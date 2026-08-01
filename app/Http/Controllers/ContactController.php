<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Setting;
use App\Models\SocialMedia;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display the contact page with school contact information and social media links.
     */
    public function index()
    {
        // Load all settings for contact info display
        $settings = Setting::pluck('value', 'key');

        // Load active social media links
        $social_media = SocialMedia::where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('contact.index', compact('settings', 'social_media'));
    }

    /**
     * Store a new contact message from the contact form.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:100'],
            'email'   => ['required', 'email', 'max:150'],
            'phone'   => ['nullable', 'string', 'max:20'],
            'subject' => ['required', 'string', 'max:200'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ]);

        Contact::create([
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'phone'      => $validated['phone'] ?? null,
            'subject'    => $validated['subject'],
            'message'    => $validated['message'],
            'ip_address' => $request->ip(),
            'is_read'    => false,
        ]);

        return redirect()
            ->route('contact.index')
            ->with('success', 'Pesan Anda berhasil dikirim. Kami akan menghubungi Anda segera.');
    }
}
