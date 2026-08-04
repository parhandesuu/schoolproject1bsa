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

        $filePath = $document->file;

        if (!$filePath) {
            abort(404, 'File tidak ditemukan.');
        }

        // Check in public disk first, fallback to default disk
        $disk = 'public';
        if (!Storage::disk('public')->exists($filePath)) {
            if (Storage::exists($filePath)) {
                $disk = null;
            } else {
                abort(404, 'File tidak ditemukan di server.');
            }
        }

        // Increment download counter
        $document->increment('downloads');

        $ext = $document->file_type ?: pathinfo($filePath, PATHINFO_EXTENSION);
        $cleanTitle = \Illuminate\Support\Str::slug($document->title);
        $fileName = $cleanTitle ? ($cleanTitle . ($ext ? '.' . $ext : '')) : basename($filePath);

        return $disk
            ? Storage::disk($disk)->download($filePath, $fileName)
            : Storage::download($filePath, $fileName);
    }
}
