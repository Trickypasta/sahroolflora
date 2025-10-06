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
}