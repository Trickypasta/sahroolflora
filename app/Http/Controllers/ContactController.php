<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage; // Jangan lupa import model

class ContactController extends Controller
{
    // Menampilkan halaman kontak
    public function show()
    {
        return view('contact');
    }

    // Memproses dan menyimpan pesan dari form
    public function send(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // Simpan ke database
        ContactMessage::create($validatedData);

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Pesan Anda telah berhasil terkirim! Kami akan segera merespon.');
    }
}