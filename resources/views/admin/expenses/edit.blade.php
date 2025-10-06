@extends('layouts.admin')
@section('title', 'Edit Pengeluaran')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Edit Pengeluaran</h1>
    <div class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
        <form action="{{ route('admin.expenses.update', $expense->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="description" class="block font-semibold">Deskripsi</label>
                <input type="text" name="description" id="description" class="w-full border rounded-md px-3 py-2 mt-1" value="{{ old('description', $expense->description) }}" required>
            </div>
            <div class="mb-4">
                <label for="amount" class="block font-semibold">Jumlah (Rp)</label>
                <input type="number" step="0.01" name="amount" id="amount" class="w-full border rounded-md px-3 py-2 mt-1" value="{{ old('amount', $expense->amount) }}" required>
            </div>
            <div class="mb-4">
                <label for="expense_date" class="block font-semibold">Tanggal</label>
                <input type="date" name="expense_date" id="expense_date" class="w-full border rounded-md px-3 py-2 mt-1" value="{{ old('expense_date', $expense->expense_date->format('Y-m-d')) }}" required>
            </div>
            <div class="flex items-center">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">Update Pengeluaran</button>
                <a href="{{ route('admin.expenses.index') }}" class="text-gray-600 ml-4">Batal</a>
            </div>
        </form>
    </div>
@endsection