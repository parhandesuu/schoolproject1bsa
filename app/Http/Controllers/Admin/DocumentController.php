<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('dokumen.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat dokumen.');
        }

        $documents = Document::latest()->paginate(15);
        return view('admin.documents.index', compact('documents'));
    }

    public function create()
    {
        if (!auth()->user()->can('dokumen.create')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah dokumen.');
        }

        return view('admin.documents.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('dokumen.create')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah dokumen.');
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'file'        => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip|max:10240',
            'category'    => 'nullable|string|max:100',
        ]);

        $uploadedFile = $request->file('file');
        $path         = $uploadedFile->store('documents', 'public');

        $validated['file']      = $path;
        $validated['file_type'] = $uploadedFile->getClientOriginalExtension();
        $validated['file_size'] = $uploadedFile->getSize();

        Document::create($validated);

        return redirect()->route('admin.documents.index')
                         ->with('success', 'Dokumen berhasil diunggah.');
    }

    public function show(Document $document)
    {
        if (!auth()->user()->can('dokumen.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat dokumen.');
        }

        return view('admin.documents.show', compact('document'));
    }

    public function edit(Document $document)
    {
        if (!auth()->user()->can('dokumen.update')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah dokumen.');
        }

        return view('admin.documents.edit', compact('document'));
    }

    public function update(Request $request, Document $document)
    {
        if (!auth()->user()->can('dokumen.update')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah dokumen.');
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'file'        => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip|max:10240',
            'category'    => 'nullable|string|max:100',
        ]);

        if ($request->hasFile('file')) {
            if ($document->file) {
                Storage::disk('public')->delete($document->file);
            }
            $uploadedFile = $request->file('file');
            $path         = $uploadedFile->store('documents', 'public');

            $validated['file']      = $path;
            $validated['file_type'] = $uploadedFile->getClientOriginalExtension();
            $validated['file_size'] = $uploadedFile->getSize();
        }

        $document->update($validated);

        return redirect()->route('admin.documents.index')
                         ->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(Document $document)
    {
        if (!auth()->user()->can('dokumen.delete')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus dokumen.');
        }

        if ($document->file) {
            Storage::disk('public')->delete($document->file);
        }
        $document->delete();

        return redirect()->route('admin.documents.index')
                         ->with('success', 'Dokumen berhasil dihapus.');
    }
}
