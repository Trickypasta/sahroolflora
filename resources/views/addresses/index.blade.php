@extends('layouts.app')
@section('title', 'Alamat Pengiriman - SahroolFlora')
@section('content')
    <div class="bg-gray-50 border-b">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <h1 class="font-lora text-3xl font-extrabold tracking-tight text-gray-900">Akun Saya</h1>
        </div>
    </div>
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <aside class="md:col-span-1">
                @include('partials.account-sidebar')
            </aside>

            <div class="md:col-span-3">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Alamat Pengiriman</h2>
                        <p class="mt-1 text-sm text-gray-500">Kelola alamat pengiriman Anda untuk checkout yang lebih cepat.
                        </p>
                    </div>
                    @if (count($addresses) < 5)
                        <a href="{{ route('addresses.create') }}" class="inline-flex ...">
                            Tambah Alamat
                        </a>
                    @endif
                </div>

                <div class="space-y-4">
                    @forelse ($addresses as $address)
                        <div class="bg-white p-4 rounded-lg shadow-sm border flex justify-between items-start">
                            <div class="text-sm text-gray-700">
                                <p class="font-semibold text-gray-900">{{ $address->address_line }}</p>
                                <p>{{ $address->city }}, {{ $address->province }}</p>
                                <p>{{ $address->postal_code }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('addresses.edit', $address->id) }}"
                                    class="text-sm font-medium text-green-600 hover:text-green-800">Edit</a>
                                <form action="{{ route('addresses.destroy', $address->id) }}" method="POST"
                                    onsubmit="return confirm('Anda yakin ingin menghapus alamat ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-sm font-medium text-red-600 hover:text-red-800">Hapus</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 bg-gray-50 rounded-lg">
                            <p class="text-gray-500">Anda belum menyimpan alamat.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
