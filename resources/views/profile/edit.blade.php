@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10">
    <h1 class="text-3xl font-bold text-center mb-8">Pengaturan Akun</h1>

    @include('partials.notification')

    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-2xl font-bold mb-4">Update Profil</h2>
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label for="name" class="block font-semibold">Nama</label>
                <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" class="w-full border rounded-md px-3 py-2 mt-1">
            </div>
            <div class="mb-4">
                <label for="email" class="block font-semibold">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" class="w-full border rounded-md px-3 py-2 mt-1">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md">Simpan Profil</button>
        </form>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Ubah Password</h2>
        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="current_password" class="block font-semibold">Password Saat Ini</label>
                <input type="password" name="current_password" id="current_password" class="w-full border rounded-md px-3 py-2 mt-1" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block font-semibold">Password Baru</label>
                <input type="password" name="password" id="password" class="w-full border rounded-md px-3 py-2 mt-1" required>
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block font-semibold">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border rounded-md px-3 py-2 mt-1" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md">Ubah Password</button>
        </form>
    </div>
</div>
@endsection