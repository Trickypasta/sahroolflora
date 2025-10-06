@extends('layouts.admin')
@section('title', "Detail Pesanan #" . $order->id)

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Detail Pesanan #{{ $order->id }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="text-blue-500 hover:underline">&larr; Kembali ke Daftar Pesanan</a>
    </div>

    @include('partials.notification')

    <div class="space-y-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="font-semibold border-b pb-2 mb-4 text-xl">Detail Pengiriman</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="font-semibold">Info Customer</h4>
                    <p>{{ $order->user->name }}</p>
                    <p>{{ $order->user->email }}</p>
                </div>
                <div>
                    <h4 class="font-semibold">Alamat Pengiriman</h4>
                    <p>{{ $order->address->address_line }}</p>
                    <p>{{ $order->address->city }}, {{ $order->address->province }}, {{ $order->address->postal_code }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="font-semibold border-b pb-2 mb-4 text-xl">Item Dipesan</h3>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border px-4 py-2 text-left">Produk</th>
                            <th class="border px-4 py-2 text-center">Kuantitas</th>
                            <th class="border px-4 py-2 text-right">Harga Satuan</th>
                            <th class="border px-4 py-2 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td class="border px-4 py-2">{{ $item->product->name ?? 'Produk Dihapus' }}</td>
                            <td class="border px-4 py-2 text-center">{{ $item->quantity }}</td>
                            <td class="border px-4 py-2 text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="border px-4 py-2 text-right">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="font-bold">
                        <tr class="bg-gray-50">
                            <td colspan="3" class="border px-4 py-2 text-right">Subtotal Produk</td>
                            <td class="border px-4 py-2 text-right">Rp {{ number_format($order->total_amount - $order->shipping_cost, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td colspan="3" class="border px-4 py-2 text-right">Ongkos Kirim ({{ $order->shipping_method }})</td>
                            <td class="border px-4 py-2 text-right">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="bg-gray-100 text-lg">
                            <td colspan="3" class="border px-4 py-2 text-right">Total Pesanan</td>
                            <td class="border px-4 py-2 text-right">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="font-semibold mb-4 text-xl">Update Status Pesanan</h3>
                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                    @csrf
                    <div class="flex items-center">
                        <select name="status" class="w-full px-4 py-2 border rounded-l-md">
                            <option value="pending" @if($order->status == 'pending') selected @endif>Pending</option>
                            <option value="processing" @if($order->status == 'processing') selected @endif>Diproses</option>
                            <option value="shipped" @if($order->status == 'shipped') selected @endif>Dikirim</option>
                            <option value="completed" @if($order->status == 'completed') selected @endif>Selesai</option>
                            <option value="cancelled" @if($order->status == 'cancelled') selected @endif>Dibatalkan</option>
                        </select>
                        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-r-md hover:bg-blue-600">Update</button>
                    </div>
                </form>
            </div>
            
            @if ($order->status == 'processing' || $order->status == 'shipped' || $order->status == 'completed')
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="font-semibold mb-4 text-xl">Update Pengiriman</h3>
                <form action="{{ route('admin.orders.addTracking', $order->id) }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label for="tracking_number" class="block font-semibold">Nomor Resi</label>
                        <input type="text" name="tracking_number" id="tracking_number" class="w-full border rounded-md px-3 py-2 mt-1" value="{{ $order->tracking_number }}" placeholder="Masukkan Nomor Resi">
                    </div>
                    <button type="submit" class="bg-indigo-500 text-white px-6 py-2 rounded-md hover:bg-indigo-600 w-full">
                        @if($order->tracking_number) Update Resi @else Simpan & Ubah ke 'Dikirim' @endif
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
@endsection