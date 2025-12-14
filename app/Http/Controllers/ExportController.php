<?php

namespace App\Http\Controllers;

use App\Models\Export;
use App\Services\ExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExportController extends Controller
{
    protected $exportService;

    public function __construct(ExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    /**
     * List user's exports
     */
    public function index()
    {
        $user = Auth::user();
        $exports = Export::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('exports.index', compact('exports'));
    }

    /**
     * Download export file
     */
    public function download(Export $export)
    {
        if ($export->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$export->path || !Storage::disk('local')->exists($export->path)) {
            abort(404, 'Export file not found');
        }

        return Storage::disk('local')->download($export->path);
    }
}

