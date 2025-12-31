@extends('layouts.admin')
@section('title', 'Manajemen Pengguna')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Manajemen Pengguna</h1>
        <a href="{{ route('admin.users.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            Tambah User Baru
        </a>
    </div>

    @include('partials.notification')

    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Role</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="bg-white border-b hover:bg-slate-50">
                            <td class="px-6 py-4 font-medium text-slate-900">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="hover:underline">{{ $user->name }}</a>
                            </td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                @forelse ($user->roles as $role)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $role->name == 'admin' ? 'bg-purple-200 text-purple-800' : 'bg-blue-200 text-blue-800' }}">
                                        {{ $role->name }}
                                    </span>
                                @empty
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-200 text-gray-800">
                                        N/A
                                    </span>
                                @endforelse
                            </td>
                            <td class="px-6 py-4 flex items-center space-x-3">
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                   class="font-medium text-blue-600 hover:underline">Edit</a>
                                
                                @if(auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" @submit.prevent="openModal($event.target)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-medium text-red-600 hover:underline">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection