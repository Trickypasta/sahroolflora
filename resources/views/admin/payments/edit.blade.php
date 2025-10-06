@extends('layouts.admin')
@section('title', 'Edit Metode Pembayaran')
@section('content')
    <h1 class="text-3xl font-bold mb-6">Edit Metode Pembayaran</h1>
    <div class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
        <form action="{{ route('admin.payment-methods.update', $paymentMethod->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block font-semibold">Nama Metode</label>
                <input type="text" name="name" id="name" class="w-full border rounded-md px-3 py-2 mt-1" value="{{ old('name', $paymentMethod->name) }}" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block font-semibold">Deskripsi / Instruksi</label>
                <textarea name="description" id="description" rows="3" class="w-full border rounded-md px-3 py-2 mt-1">{{ old('description', $paymentMethod->description) }}</textarea>
            </div>
            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" class="mr-2" @if(old('is_active', $paymentMethod->is_active)) checked @endif>
                    Aktifkan metode ini
                </label>
            </div>
            <div class="flex items-center">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">Update</button>
                <a href="{{ route('admin.payment-methods.index') }}" class="text-gray-600 ml-4">Batal</a>
            </div>
        </form>
    </div>
@endsection