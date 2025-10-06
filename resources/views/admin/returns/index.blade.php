@extends('layouts.admin')
@section('title', 'Manajemen Pengembalian')
@section('content')
    <h1 class="text-3xl font-bold mb-6">Manajemen Pengembalian</h1>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <table class="w-full border-collapse">
            <thead><tr class="bg-gray-200">
                <th class="border px-4 py-2 text-left">Order ID</th><th class="border px-4 py-2 text-left">Customer</th>
                <th class="border px-4 py-2 text-left">Alasan</th><th class="border px-4 py-2 text-left">Status</th>
                <th class="border px-4 py-2 text-left">Aksi</th>
            </tr></thead>
            <tbody>
                @forelse ($requests as $returnRequest)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">#{{ $returnRequest->order_id }}</td>
                        <td class="border px-4 py-2">{{ $returnRequest->user->name }}</td>
                        <td class="border px-4 py-2 text-sm">{{ $returnRequest->reason }}</td>
                        <td class="border px-4 py-2">
                            @switch($returnRequest->status)
                                @case('pending') <span class="px-2 py-1 text-xs rounded-full bg-yellow-200 text-yellow-800">Pending</span> @break
                                @case('approved') <span class="px-2 py-1 text-xs rounded-full bg-green-200 text-green-800">Disetujui</span> @break
                                @case('rejected') <span class="px-2 py-1 text-xs rounded-full bg-red-200 text-red-800">Ditolak</span> @break
                            @endswitch
                        </td>
                        <td class="border px-4 py-2">
                            <form action="{{ route('admin.returns.update', $returnRequest->id) }}" method="POST">
                                @csrf
                                <div class="flex items-center"><select name="status" class="text-sm border rounded-l-md p-1">
                                    <option value="pending" @if($returnRequest->status == 'pending') selected @endif>Pending</option>
                                    <option value="approved" @if($returnRequest->status == 'approved') selected @endif>Setujui</option>
                                    <option value="rejected" @if($returnRequest->status == 'rejected') selected @endif>Tolak</option>
                                </select><button type="submit" class="bg-blue-500 text-white p-1.5 rounded-r-md text-sm">Update</button></div>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="border px-4 py-2 text-center text-gray-500">Belum ada permintaan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection