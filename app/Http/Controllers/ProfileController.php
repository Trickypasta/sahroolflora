<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// Impor Form Request yang baru
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdatePasswordRequest;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(UpdateProfileRequest $request) // <-- Ganti di sini
    {
        $request->user()->fill($request->validated());
        $request->user()->save();
        return back()->with('success', 'Profil berhasil diupdate!');
    }

    public function updatePassword(UpdatePasswordRequest $request) // <-- Ganti di sini
    {
        $request->user()->update([
            'password' => Hash::make($request->validated('password')),
        ]);
        return back()->with('success', 'Password berhasil diubah!');
    }
}