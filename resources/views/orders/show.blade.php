@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
    <div class="bg-gray-50">
        <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">

            @if ($order->status == 'pending')
                {{-- Tampilan Khusus untuk Pesanan Pending --}}
                <div class="bg-white p-8 rounded-lg shadow-sm text-center">
                    <h1 class="text-2xl font-bold mb-2">Menunggu Pembayaran</h1>
                    <p class="text-gray-600 mb-6">Selesaikan pembayaran untuk pesanan #{{ $order->id }} agar dapat kami
                        proses.</p>
                    <div class="border-t border-b py-4 my-4">
                        <p class="text-lg text-gray-600">Total Pembayaran:</p>
                        <p class="font-lora text-4xl font-bold text-green-700">Rp
                            {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                    </div>
                    <div class="text-left my-6 bg-gray-50 p-6 rounded-lg">
                        <p class="font-semibold mb-2">Silakan transfer ke rekening berikut:</p>
                        @php
                            $paymentMethod = \App\Models\PaymentMethod::where('name', $order->payment_method)->first();
                            $paymentInstruction =
                                $paymentMethod->description ?? 'Hubungi admin untuk instruksi pembayaran.';
                        @endphp
                        <p class="font-semibold">{{ $order->payment_method }}</p>
                        <div class="prose prose-sm text-gray-600">{!! nl2br(e($paymentInstruction)) !!}</div>
                    </div>
                    <p class="text-sm text-gray-500">Pesanan akan diproses oleh admin setelah pembayaran diverifikasi.</p>
                </div>
            @else
                {{-- Tampilan Umum untuk Status Lainnya --}}
                <div class="bg-white p-6 sm:p-8 rounded-lg shadow-sm">
                    <div class="text-center border-b border-gray-200 pb-6 mb-6">
                        <h1 class="text-2xl sm:text-3xl font-bold">Detail Pesanan #{{ $order->id }}</h1>
                        <p class="text-gray-600 mt-2">Status: @include('partials.order-status-badge', ['status' => $order->status])</p>
                    </div>

                    <div class="space-y-8">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pengiriman</h2>
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2 text-sm text-gray-600">
                                <div>
                                    <dt class="font-medium text-gray-900">Dikirim kepada</dt>
                                    <dd>{{ $order->user->name }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-900">Metode Pengiriman</dt>
                                    <dd>{{ $order->shipping_method }}</dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="font-medium text-gray-900">Alamat</dt>
                                    <dd>{{ $order->address->address_line }}, {{ $order->address->city }}</dd>
                                </div>
                                @if ($order->tracking_number)
                                    <div>
                                        <dt class="font-medium text-gray-900">Nomor Resi</dt>
                                        <dd class="font-bold text-green-700">{{ $order->tracking_number }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Rincian Item</h2>
                            <ul class="divide-y divide-gray-200">
                                @foreach ($order->items as $item)
                                    <li class="py-4 flex items-center justify-between">
                                        <div class="flex items-center">
                                            <img src="{{ $item->product->images->isNotEmpty() ? asset('storage/' . $item->product->images->first()->path) : 'https://via.placeholder.com/100' }}"
                                                alt="{{ $item->product->name }}"
                                                class="h-16 w-16 object-cover rounded-md mr-4">
                                            <div>
                                                <p class="font-semibold text-gray-900">
                                                    {{ $item->product->name ?? 'Produk Dihapus' }}</p>
                                                <p class="text-sm text-gray-500">{{ $item->quantity }} x Rp
                                                    {{ number_format($item->price, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                        <p class="font-semibold text-gray-800">Rp
                                            {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="border-t border-gray-200 pt-6">
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Pembayaran</h2>
                            <dl class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <dt class="text-gray-600">Subtotal</dt>
                                    <dd class="text-gray-800">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-gray-600">Ongkos Kirim</dt>
                                    <dd class="text-gray-800">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                                    </dd>
                                </div>
                                @if ($order->discount > 0)
                                    <div class="flex justify-between text-green-600">
                                        <dt>Diskon</dt>
                                        <dd>- Rp {{ number_format($order->discount, 0, ',', '.') }}</dd>
                                    </div>
                                @endif
                                <div class="flex justify-between text-base font-bold pt-2 border-t mt-2">
                                    <dt class="text-gray-900">Total</dt>
                                    <dd class="text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            @endif
            @if ($order->status == 'completed')
                <div class="mt-8 space-y-8">

                    {{-- BAGIAN TULIS TESTIMONI --}}
                    <div class="bg-white p-6 sm:p-8 rounded-lg shadow-sm">
                        @if ($order->status == 'completed')
                            <div class="mt-8 bg-white p-6 sm:p-8 rounded-lg shadow-sm">
                                <h2 class="text-xl font-bold text-gray-900 mb-4">Ulas Produk Anda</h2>
                                <div class="space-y-6 divide-y divide-gray-200">
                                    @foreach ($order->items as $item)
                                        @if ($product = $item->product)
                                            <div class="pt-6 flex items-start space-x-4">
                                                <img src="{{ $product->images->isNotEmpty() ? asset('storage/' . $product->images->first()->path) : 'https://via.placeholder.com/100' }}"
                                                    alt="{{ $product->name }}" class="h-20 w-20 object-cover rounded-md">
                                                <div class="flex-1">
                                                    <p class="font-semibold text-gray-900">{{ $product->name }}</p>

                                                    @php $existingReview = $order->testimonials->where('product_id', $product->id)->first(); @endphp

                                                    @if ($existingReview)
                                                        <div class="mt-2 text-sm text-gray-500">
                                                            <p>Anda sudah memberi ulasan untuk produk ini. Terima kasih!</p>
                                                            <div class="flex items-center mt-1">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <svg class="h-4 w-4 {{ $i <= $existingReview->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                                        fill="currentColor" viewBox="0 0 20 20">
                                                                        <path
                                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                    </svg>
                                                                @endfor
                                                            </div>
                                                        </div>
                                                    @else
                                                        <form action="{{ route('testimonials.store') }}" method="POST"
                                                            class="mt-4" x-data="{ rating: 0, hoverRating: 0 }">
                                                            @csrf
                                                            <input type="hidden" name="order_id"
                                                                value="{{ $order->id }}">
                                                            <input type="hidden" name="product_id"
                                                                value="{{ $product->id }}">
                                                            <input type="hidden" name="rating" x-model="rating">

                                                            <div class="flex items-center space-x-1 mb-2">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <button type="button"
                                                                        @click="rating = {{ $i }}"
                                                                        @mouseenter="hoverRating = {{ $i }}"
                                                                        @mouseleave="hoverRating = 0"
                                                                        class="text-gray-300 focus:outline-none">
                                                                        <svg class="h-6 w-6"
                                                                            :class="{ 'text-yellow-400': hoverRating >=
                                                                                    {{ $i }} || rating >=
                                                                                    {{ $i }} }"
                                                                            fill="currentColor" viewBox="0 0 20 20">
                                                                            <path
                                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                        </svg>
                                                                    </button>
                                                                @endfor
                                                            </div>

                                                            <textarea name="comment" rows="2" placeholder="Tulis komentar Anda (opsional)..."
                                                                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"></textarea>

                                                            <div class="text-right mt-2">
                                                                <button type="submit"
                                                                    class="inline-flex py-1 px-4 text-sm font-medium rounded-full text-white bg-green-700 hover:bg-green-800">Kirim</button>
                                                            </div>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="text-center">
                        @if (!$order->returnRequest)
                            <a href="{{ route('returns.create', $order->id) }}"
                                class="text-sm font-medium text-gray-600 hover:text-gray-900 hover:underline">
                                Ada masalah dengan pesanan? Ajukan Pengembalian
                            </a>
                        @else
                            <p class="text-sm font-semibold text-gray-800">Status Pengembalian:
                                {{ ucfirst($order->returnRequest->status) }} <br> Mohon Maaf Sebener Benarnya, Info
                                Selanjutnya Akan Disampaikan Oleh Admin</p>
                        @endif
                    </div>

                </div>
            @endif
        </div>

    </div>

@endsection
