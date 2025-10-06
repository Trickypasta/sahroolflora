@extends('layouts.admin')
@section('title', 'Manajemen Pengguna')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Manajemen Pengguna</h1>
    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('admin.users.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Tambah User Baru</a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2 text-left">Nama</th>
                    <th class="border px-4 py-2 text-left">Email</th>
                    <th class="border px-4 py-2 text-left">Role</th>
                    <th class="border px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $user->name }}</td>
                        <td class="border px-4 py-2">{{ $user->email }}</td>
                        <td class="border px-4 py-2">
                            @foreach ($user->roles as $role)
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-200 text-blue-800">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('admin.customers.show', $user->id) }}"
                                class="text-blue-600 hover:underline font-semibold">
                                {{ $user->name }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
