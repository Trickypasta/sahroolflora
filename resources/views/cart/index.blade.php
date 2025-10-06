<!DOCTYPE html>
<html lang="en">

<head>
    <title>Keranjang Belanja - SahroolFlora</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

    @include('partials.navbar')
    @include('partials.notification')

    <main class="py-10">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-center mb-8">Keranjang Belanja Anda</h1>

            @if ($cart && $cart->items->isNotEmpty())
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left p-4">Produk</th>
                                <th class="text-left p-4">Harga</th>
                                <th class="text-left p-4">Kuantitas</th>
                                <th class="text-left p-4">Subtotal</th>
                                <th class="text-left p-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0 @endphp
                            @foreach ($cart->items as $item)
                                @php $total += $item->product->price * $item->quantity @endphp
                                <tr class="border-b">
                                    <td class="p-4 flex items-center">
                                        <img src="{{ $item->product->images->isNotEmpty() ? asset('storage/' . $item->product->images->first()->path) : 'https://via.placeholder.com/100' }}"
                                            alt="{{ $item->product->name }}"
                                            class="h-16 w-16 object-cover mr-4 rounded">
                                        <span class="font-semibold">{{ $item->product->name }}</span>
                                    </td>
                                    <td class="p-4">Rp {{ number_format($item->product->price, 0, ',', '.') }}</td>
                                    <td class="p-4">
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST"
                                            class="flex items-center">
                                            @csrf
                                            <input type="number" name="quantity" value="{{ $item->quantity }}"
                                                class="w-16 text-center border rounded-l-md px-2 py-1">
                                            <button type="submit"
                                                class="bg-blue-500 text-white p-2 rounded-r-md hover:bg-blue-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="p-4">Rp
                                        {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</td>
                                    <td class="p-4">
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-red-500 hover:text-red-700 p-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-6">
                        <form action="{{ route('coupon.apply') }}" method="POST">
                            @csrf
                            <div class="flex">
                                <input type="text" name="code" placeholder="Masukkan Kode Kupon"
                                    class="w-full border rounded-l-md px-4 py-2">
                                <button type="submit"
                                    class="bg-gray-800 text-white px-6 py-2 rounded-r-md hover:bg-gray-900">Gunakan</button>
                            </div>
                        </form>
                    </div>

                    <div class="text-right mt-6">
                        <p class="text-xl">Subtotal: Rp {{ number_format($total, 0, ',', '.') }}</p>
                        @if (session('coupon'))
                            @php
                                $coupon = session('coupon');
                                $discount = 0;
                                if ($coupon['type'] == 'fixed') {
                                    $discount = $coupon['value'];
                                } elseif ($coupon['type'] == 'percent') {
                                    $discount = ($total * $coupon['percent_off']) / 100;
                                }
                                $newTotal = $total - $discount;
                            @endphp
                            <p class="text-lg text-green-600">Diskon ({{ $coupon['code'] }}): - Rp
                                {{ number_format($discount, 0, ',', '.') }}
                                <a href="{{ route('coupon.remove') }}" class="text-red-500 text-sm ml-2">[Hapus]</a>
                            </p>
                            <p class="text-2xl font-bold">Total: Rp {{ number_format($newTotal, 0, ',', '.') }}</p>
                        @else
                            <p class="text-2xl font-bold">Total: Rp {{ number_format($total, 0, ',', '.') }}</p>
                        @endif
                        <div class="text-right mt-6">
                            <a href="{{ route('checkout.index') }}"
                                class="mt-4 inline-block bg-green-500 text-white font-bold py-3 px-6 rounded-lg hover:bg-green-600">Lanjut
                                ke Pembayaran</a>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <p class="text-xl text-gray-600">Keranjang belanja Anda masih kosong.</p>
                    <a href="{{ route('products.index') }}"
                        class="mt-4 inline-block bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600">Mulai
                        Belanja</a>
                </div>
            @endif
        </div>
    </main>
</body>

</html>
