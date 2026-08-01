<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a list of active documents grouped by category.
     * Supports search by title (?q=).
     */
    public function index(Request $request)
    {
        $query = Document::where('is_active', true)
            ->orderBy('category')
            ->orderBy('title');

        // Search by title
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where('title', 'like', "%{$search}%");
        }

        $documents = $query->get();

        // Group by category for display
        $groupedDocuments = $documents->groupBy('category');

        return view('documents.index', compact('groupedDocuments', 'documents'));
    }

    /**
     * Increment download count and return the document as a download response.
     *
     * @param Document $document
     */
    public function download(Document $document)
    {
        // Ensure the document is active
        abort_if(!$document->is_active, 404);

        // Increment download counter
        $document->increment('downloads');

        // Determine the file path and return as a download
        $filePath = $document->file_path;

        if (!Storage::exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        $fileName = $document->file_name ?? basename($filePath);

        return Storage::download($filePath, $fileName);
    }
}
