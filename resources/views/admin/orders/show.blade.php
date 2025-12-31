@extends('layouts.admin')
@section('title', "Detail Pesanan #" . $order->id)

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Detail Pesanan #{{ $order->id }}</h1>
        <a href="{{ route('admin.orders.index', ['status' => $order->status]) }}" class="text-blue-500 hover:underline">&larr; Kembali ke Daftar Pesanan</a>
    </div>

    <div class="mb-6">
        @if ($order->status == 'pending')
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-md">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h3 class="font-bold text-yellow-800">Menunggu Pembayaran</h3>
                        <p class="text-yellow-700">Cek konfirmasi pembayaran. Jika sudah lunas, klik tombol di samping.</p>
                    </div>
                    <form action="{{ route('admin.orders.confirmPayment', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-700">
                            (✓) Konfirmasi Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        @elseif ($order->status == 'processing')
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-md" x-data="{ showTrackingForm: false }">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h3 class="font-bold text-blue-800">Siap Dikirim</h3>
                        <p class="text-blue-700">Pesanan sudah dibayar dan siap untuk dikemas/dikirim.</p>
                    </div>
                    <button @click="showTrackingForm = !showTrackingForm" class="bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700">
                        (🚚) Kirim & Masukkan Resi
                    </button>
                </div>
                
                <form x-show="showTrackingForm" x-transition class="mt-4 border-t border-blue-200 pt-4" action="{{ route('admin.orders.shipOrder', $order->id) }}" method="POST">
                    @csrf
                    <label for="tracking_number" class="block font-semibold text-slate-700">Nomor Resi</label>
                    <input type="text" name="tracking_number" id="tracking_number" class="w-full md:w-1/2 border-slate-300 rounded-md px-3 py-2 mt-1" required placeholder="Masukkan Nomor Resi">
                    <button type="submit" class="mt-2 bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">Simpan & Kirim</button>
                </form>
            </div>
        @elseif ($order->status == 'shipped')
            <div class="bg-purple-50 border-l-4 border-purple-400 p-4 rounded-md">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h3 class="font-bold text-purple-800">Dalam Pengiriman</h3>
                        <p class="text-purple-700">Pesanan sedang dalam perjalanan. No. Resi: <strong>{{ $order->tracking_number }}</strong></p>
                    </div>
                    <form action="{{ route('admin.orders.completeOrder', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-700">
                            (🏁) Tandai Selesai
                        </button>
                    </form>
                </div>
            </div>
        @elseif ($order->status == 'completed')
             <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-md">
                <h3 class="font-bold text-green-800">Pesanan Selesai</h3>
                <p class="text-green-700">Pesanan ini telah selesai pada {{ $order->updated_at->format('d M Y') }}.</p>
            </div>
        @elseif ($order->status == 'cancelled')
             <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-md">
                <h3 class="font-bold text-red-800">Pesanan Dibatalkan</h3>
                <p class="text-red-700">Pesanan ini telah dibatalkan.</p>
            </div>
        @endif
    </div>

    <div class="space-y-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="font-semibold border-b border-slate-200 pb-2 mb-4 text-xl">Detail Pengiriman</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-slate-700">
                <div>
                    <h4 class="font-semibold text-slate-900">Info Customer</h4>
                    <p>{{ $order->user->name }}</p>
                    <p>{{ $order->user->email }}</p>
                </div>
                <div>
                    <h4 class="font-semibold text-slate-900">Alamat Pengiriman</h4>
                    <p>{{ $order->address->address_line }}</p>
                    <p>{{ $order->address->city }}, {{ $order->address->province }}, {{ $order->address->postal_code }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
             <h3 class="font-semibold border-b border-slate-200 pb-2 mb-4 text-xl">Item Dipesan</h3>
             <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                        <tr>
                            <th class="px-4 py-3">Produk</th>
                            <th class="px-4 py-3 text-center">Kuantitas</th>
                            <th class="px-4 py-3 text-right">Harga Satuan</th>
                            <th class="px-4 py-3 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-700">
                        @foreach($order->items as $item)
                        <tr class="border-b">
                            <td class="px-4 py-3">{{ $item->product->name ?? 'Produk Dihapus' }}</td>
                            <td class="px-4 py-3 text-center">{{ $item->quantity }}</td>
                            <td class="px-4 py-3 text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="font-semibold text-slate-800">
                        <tr class="bg-slate-50">
                            <td colspan="3" class="px-4 py-2 text-right">Subtotal Produk</td>
                            <td class="px-4 py-2 text-right">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="bg-slate-50">
                            <td colspan="3" class="px-4 py-2 text-right">Ongkos Kirim ({{ $order->shipping_method }})</td>
                            <td class="px-4 py-2 text-right">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                        </tr>
                        @if($order->discount > 0)
                        <tr class="bg-slate-50 text-green-600">
                            <td colspan="3" class="px-4 py-2 text-right">Diskon ({{ $order->coupon_code }})</td>
                            <td class="px-4 py-2 text-right">- Rp {{ number_format($order->discount, 0, ',', '.') }}</td>
                        </tr>
                        @endif
                        <tr class="bg-slate-100 text-lg">
                            <td colspan="3" class="px-4 py-3 text-right font-bold">Total Pesanan</td>
                            <td class="px-4 py-3 text-right font-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
             </div>
        </div>
        
        @if(!in_array($order->status, ['completed', 'cancelled']))
        <div class="bg-white p-6 rounded-lg shadow-md">
             <h3 class="font-semibold mb-4 text-xl">Aksi Lainnya</h3>
             <form action="{{ route('admin.orders.cancelOrder', $order->id) }}" method="POST" @submit.prevent="openModal($event.target)">
                @csrf
                <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700">Batalkan Pesanan</button>
             </form>
        </div>
        @endif
    </div>
@endsection