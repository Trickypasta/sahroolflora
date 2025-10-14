@extends('layouts.auth-layout')

@section('title', 'Login')

@section('content')
    <h1 class="text-2xl font-bold text-gray-800">Selamat Datang Kembali</h1>
    <p class="mt-2 text-gray-600">Silakan masuk untuk melanjutkan.</p>

    @if ($errors->any())
        <div class="mt-6 mb-4 bg-red-50 border-l-4 border-red-400 text-red-700 p-4" role="alert">
            <p>{{ $errors->first('email') }}</p>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
        @csrf
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
        </div>
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input id="password" type="password" name="password" required
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
        </div>
        <div>
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-full shadow-sm text-sm font-medium text-white bg-green-700 hover:bg-green-800">
                Login
            </button>
        </div>
        <div class="text-center text-sm text-gray-600">
            Belum punya akun?
            <a class="font-medium text-green-600 hover:text-green-800 underline" href="{{ route('register') }}">
                Daftar di sini
            </a>
        </div>
    </form>
@endsection