@extends('layouts.auth-layout')

@section('title', 'Register')

@section('content')
    <h1 class="text-center text-2xl font-bold text-gray-800 mb-6">Buat Akun Baru</h1>

    @if ($errors->any())
        <div class="mb-4 bg-red-50 border-l-4 border-red-400 text-red-700 p-4" role="alert">
            <p class="font-bold">Oops! Terjadi kesalahan:</p>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input id="password" type="password" name="password" required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
        </div>

        <div>
            <button type="submit"
                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-full shadow-sm text-sm font-medium text-white bg-green-700 hover:bg-green-800">
                Register
            </button>
        </div>

        <div class="text-center text-sm text-gray-600">
            Sudah punya akun?
            <a class="font-medium text-green-600 hover:text-green-800 underline" href="{{ route('login') }}">
                Login di sini
            </a>
        </div>
    </form>
@endsection
