@extends('layouts.app')

@section('title', 'Keranjang Belanja - SahroolFlora')

@section('content')
<div class="bg-gray-50">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="font-lora text-4xl font-extrabold tracking-tight text-gray-900 text-center">Keranjang Belanja Anda</h1>

        @if ($cart && $cart->items->isNotEmpty())
            <div class="mt-12 grid grid-cols-1 lg:grid-cols-12 lg:gap-x-12 items-start">
                
                <section class="lg:col-span-8 bg-white p-6 rounded-lg shadow-sm">
                    <h2 class="sr-only">Daftar Produk di Keranjang</h2>
                    <ul role="list" class="divide-y divide-gray-200">
                        @foreach ($cart->items as $item)
                            <li class="flex py-6">
                                <div class="flex-shrink-0 w-24 h-24 border border-gray-200 rounded-md overflow-hidden">
                                    <img src="{{ $item->product->images->isNotEmpty() ? asset('storage/' . $item->product->images->first()->path) : 'https://via.placeholder.com/150' }}"
                                         alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                </div>

                                <div class="ml-4 flex-1 flex flex-col">
                                    <div>
                                        <div class="flex justify-between text-base font-medium text-gray-900">
                                            <h3>
                                                <a href="{{ route('products.show', $item->product->slug) }}">{{ $item->product->name }}</a>
                                            </h3>
                                            <p class="ml-4">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</p>
                                        </div>
                                        <p class="mt-1 text-sm text-gray-500">Harga Satuan: Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="flex-1 flex items-end justify-between text-sm">
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center">
                                            @csrf
                                            <label for="quantity-{{ $item->id }}" class="mr-2 text-gray-600">Qty:</label>
                                            <input type="number" id="quantity-{{ $item->id }}" name="quantity" value="{{ $item->quantity }}" min="1"
                                                   class="w-16 text-center border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                                            <button type="submit" class="ml-2 font-medium text-green-600 hover:text-green-800">Update</button>
                                        </form>
                                        <div class="flex">
                                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="font-medium text-red-600 hover:text-red-800">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </section>

                <section class="lg:col-span-4 mt-10 lg:mt-0">
                    <div class="bg-white p-6 rounded-lg shadow-sm lg:sticky lg:top-24">
                        <h2 class="text-lg font-medium text-gray-900">Ringkasan Pesanan</h2>

                        {{-- Kalkulasi Total --}}
                        @php
                            $subtotal = $cart->items->reduce(function ($carry, $item) {
                                return $carry + ($item->product->price * $item->quantity);
                            }, 0);
                            $discount = 0;
                            $coupon = session('coupon');
                            if ($coupon) {
                                if ($coupon['type'] == 'fixed') {
                                    $discount = $coupon['value'];
                                } elseif ($coupon['type'] == 'percent') {
                                    $discount = ($subtotal * $coupon['percent_off']) / 100;
                                }
                            }
                            $total = $subtotal - $discount;
                        @endphp
                        
                        <dl class="mt-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-gray-600">Subtotal</dt>
                                <dd class="text-sm font-medium text-gray-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</dd>
                            </div>
                            
                            @if($coupon)
                                <div class="flex items-center justify-between text-green-600">
                                    <dt class="text-sm flex items-center">
                                        <span>Diskon ({{ $coupon['code'] }})</span>
                                        <form action="{{ route('coupon.remove') }}" method="POST" class="inline ml-2">
                                            @csrf
                                            <button type="submit" class="text-red-500 text-xs">[Hapus]</button>
                                        </form>
                                    </dt>
                                    <dd class="text-sm font-medium">- Rp {{ number_format($discount, 0, ',', '.') }}</dd>
                                </div>
                            @endif

                            <div class="border-t border-gray-200 pt-4 flex items-center justify-between">
                                <dt class="text-base font-medium text-gray-900">Total Pesanan</dt>
                                <dd class="text-base font-medium text-gray-900">Rp {{ number_format($total, 0, ',', '.') }}</dd>
                            </div>
                        </dl>

                        @if(!$coupon)
                            <div class="mt-6">
                                <form action="{{ route('coupon.apply') }}" method="POST" class="flex">
                                    @csrf
                                    <input type="text" name="code" placeholder="Kode Kupon"
                                           class="w-full border-gray-300 rounded-l-md focus:ring-green-500 focus:border-green-500">
                                    <button type="submit"
                                            class="bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700 rounded-r-md hover:bg-gray-300">
                                        Gunakan
                                    </button>
                                </form>
                            </div>
                        @endif

                        <div class="mt-6">
                            <a href="{{ route('checkout.index') }}"
                               class="w-full flex items-center justify-center rounded-full border border-transparent bg-green-700 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-green-800">
                                Lanjut ke Pembayaran
                            </a>
                        </div>
                        <div class="mt-4 text-center">
                            <a href="{{ route('products.index') }}" class="text-sm font-medium text-green-700 hover:text-green-800">
                                atau Lanjut Belanja <span aria-hidden="true">&rarr;</span>
                            </a>
                        </div>
                    </div>
                </section>
            </div>
        @else
            <div class="mt-12 bg-white p-12 rounded-lg shadow-sm text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                <h2 class="mt-4 text-xl font-semibold text-gray-800">Keranjang belanja Anda kosong</h2>
                <p class="mt-2 text-gray-600">Sepertinya Anda belum menambahkan produk apa pun.</p>
                <a href="{{ route('products.index') }}"
                   class="mt-6 inline-block bg-green-700 text-white font-bold py-3 px-8 rounded-full hover:bg-green-800">
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>
</div>
@endsection