<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);

        // Handle image uploads for logo and favicon
        $imageKeys = ['logo', 'favicon', 'og_image'];

        foreach ($imageKeys as $key) {
            if ($request->hasFile($key)) {
                $oldSetting = Setting::where('key', $key)->first();
                if ($oldSetting && $oldSetting->value) {
                    Storage::disk('public')->delete($oldSetting->value);
                }
                $path        = $request->file($key)->store('settings', 'public');
                $data[$key]  = $path;
            } else {
                // Remove from data if no new file uploaded so we don't null the old value
                unset($data[$key]);
            }
        }

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->route('admin.settings.index')
                         ->with('success', 'Settings updated successfully.');
    }
}
