<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {

        $settings = Setting::pluck('value', 'key')->all();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {

        // Validasi dasar
        $request->validate([
            'general_logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:1024',
            'general_favicon' => 'nullable|mimes:ico,png,jpg,jpeg|max:256',
        ]);

        $data = $request->except('_token');

        // Loop untuk semua input teks
        foreach ($data as $key => $value) {
            // Lewati file, karena akan dihandle terpisah
            if ($request->hasFile($key)) {
                continue;
            }
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // Handle upload logo
        if ($request->hasFile('general_logo')) {
            $this->handleFileUpload($request, 'general_logo', 'logos');
        }

        // Handle upload favicon
        if ($request->hasFile('general_favicon')) {
            $this->handleFileUpload($request, 'general_favicon', 'logos');
        }

        return back()->with('success', 'Pengaturan berhasil disimpan!');
    }

    // Helper function untuk upload file
    private function handleFileUpload(Request $request, string $key, string $directory)
    {
        // Hapus file lama jika ada
        $oldPath = Setting::where('key', $key)->value('value');
        if ($oldPath) {
            Storage::disk('public')->delete($oldPath);
        }

        // Simpan file baru dan update path di database
        $path = $request->file($key)->store($directory, 'public');
        Setting::updateOrCreate(['key' => $key], ['value' => $path]);
    }
}
