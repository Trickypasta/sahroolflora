<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index()
    {
        // Ambil semua pesan, urutkan dari yang paling baru
        $messages = ContactMessage::latest()->get();

        // Tampilkan view dan kirim data pesannya
        return view('admin.messages.index', compact('messages'));
    }

    /**
     * TAMBAHKAN METHOD BARU INI
     * Menghapus pesan kontak dari database.
     */
    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return back()->with('success', 'Pesan berhasil dihapus.');
    }
}
