@extends('layouts.admin')
@section('title', 'Tambah User Baru')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Tambah User Baru</h1>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold mb-2">Nama</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="w-full px-4 py-2 border rounded-md @error('name') border-red-500 @enderror" required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="w-full px-4 py-2 border rounded-md @error('email') border-red-500 @enderror" required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
                <input type="password" name="password" id="password"
                    class="w-full px-4 py-2 border rounded-md @error('password') border-red-500 @enderror" required>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Role</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                    @foreach ($roles as $role)
                        <label class="flex items-center">
                            <input type="checkbox" name="roles[]" value="{{ $role->id }}" class="mr-2">
                            {{ $role->name }}
                        </label>
                    @endforeach
                </div>
                @error('roles')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">Simpan
                    User</button>
                <a href="{{ route('admin.users.index') }}" class="text-gray-600 ml-4">Batal</a>
            </div>
        </form>
    </div>
@endsection
