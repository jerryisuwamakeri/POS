<?php

namespace App\Http\Middleware;

use App\Models\AuditLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogAudit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only log successful requests (2xx status codes)
        if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            $this->logAction($request, $response);
        }

        return $response;
    }

    /**
     * Log the action
     */
    protected function logAction(Request $request, Response $response): void
    {
        $user = $request->user();

        // Only log authenticated requests
        if (!$user) {
            return;
        }

        // Define actions to log
        $actionsToLog = [
            'POST' => ['create', 'store', 'checkout', 'clock-in', 'clock-out'],
            'PUT' => ['update'],
            'PATCH' => ['update'],
            'DELETE' => ['delete', 'destroy'],
        ];

        $method = $request->method();
        $routeName = $request->route()?->getName() ?? '';
        $action = $request->route()?->getActionMethod() ?? '';

        // Check if this action should be logged
        $shouldLog = false;
        if (isset($actionsToLog[$method])) {
            foreach ($actionsToLog[$method] as $actionPattern) {
                if (str_contains($routeName, $actionPattern) || str_contains($action, $actionPattern)) {
                    $shouldLog = true;
                    break;
                }
            }
        }

        if (!$shouldLog) {
            return;
        }

        // Determine action type
        $actionType = match ($method) {
            'POST' => 'created',
            'PUT', 'PATCH' => 'updated',
            'DELETE' => 'deleted',
            default => 'viewed',
        };

        // Try to get the model from route parameters
        $auditableType = null;
        $auditableId = null;

        $routeParams = $request->route()?->parameters() ?? [];
        foreach ($routeParams as $key => $value) {
            if (is_object($value) && method_exists($value, 'getMorphClass')) {
                $auditableType = get_class($value);
                $auditableId = $value->id;
                break;
            } elseif (is_object($value) && isset($value->id)) {
                $auditableType = get_class($value);
                $auditableId = $value->id;
                break;
            }
        }

        AuditLog::create([
            'user_id' => $user->id,
            'action' => $actionType,
            'auditable_type' => $auditableType ?? 'system',
            'auditable_id' => $auditableId ?? 0,
            'ip_address' => $request->ip(),
            'meta' => [
                'route' => $routeName,
                'method' => $method,
                'url' => $request->fullUrl(),
            ],
        ]);
    }
}

