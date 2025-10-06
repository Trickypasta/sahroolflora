@extends('layouts.admin')
@section('title', 'Manajemen Stok')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Manajemen Stok</h1>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2 text-left">Nama Produk</th>
                    <th class="border px-4 py-2 text-left">Stok Saat Ini</th>
                    <th class="border px-4 py-2 text-left" style="width: 200px;">Update Stok</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stocks as $stock)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2 font-semibold">{{ $stock->product->name ?? 'Produk Dihapus' }}</td>
                        <td class="border px-4 py-2 @if($stock->quantity <= 5) text-red-600 font-bold @endif">
                            {{ $stock->quantity }} unit
                        </td>
                        <td class="border px-4 py-2">
                            <form action="{{ route('admin.stocks.update', $stock->id) }}" method="POST">
                                @csrf
                                <div class="flex items-center">
                                    <input type="number" name="quantity" value="{{ $stock->quantity }}" class="w-20 text-center border rounded-l-md px-2 py-1">
                                    <button type="submit" class="bg-blue-500 text-white p-2 rounded-r-md hover:bg-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    </button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="border px-4 py-2 text-center text-gray-500">Belum ada data stok.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection