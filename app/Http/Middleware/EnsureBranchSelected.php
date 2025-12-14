<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureBranchSelected
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Super admin doesn't need branch
        if ($user && $user->hasRole('super_admin')) {
            return $next($request);
        }

        // Check if user has a branch
        if ($user && !$user->branch_id) {
            // Allow access to branch selection page
            $currentPath = $request->path();
            if ($currentPath !== 'branches/select' && !$request->is('branches/select') && !$request->isMethod('post')) {
                return redirect('/branches/select')
                    ->with('error', 'Please select a branch to continue.');
            }
        }

        return $next($request);
    }
}

