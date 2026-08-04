<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('pesan.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat pesan kontak.');
        }

        $query = Contact::query();

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $contacts = $query->latest()->paginate(15)->withQueryString();

        return view('admin.contacts.index', compact('contacts'));
    }

    public function show(Contact $contact)
    {
        if (!auth()->user()->can('pesan.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat pesan kontak.');
        }

        if ($contact->status === 'unread') {
            $contact->update(['status' => 'read']);
        }

        return view('admin.contacts.show', compact('contact'));
    }

    public function markRead(Contact $contact)
    {
        if (!auth()->user()->can('pesan.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah status pesan kontak.');
        }

        $contact->update(['status' => 'read']);

        return redirect()->back()
                         ->with('success', 'Pesan ditandai sudah dibaca.');
    }

    public function destroy(Contact $contact)
    {
        if (!auth()->user()->can('pesan.delete')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus pesan kontak.');
        }

        $contact->delete();

        return redirect()->route('admin.contacts.index')
                         ->with('success', 'Pesan kontak berhasil dihapus.');
    }
}
