@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
    <div class="max-w-4xl mx-auto py-10">
        <h1 class="text-3xl font-bold text-center mb-8">Checkout</h1>
        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h2 class="text-xl font-semibold mb-4">Alamat Pengiriman</h2>
                        <div class="mb-4">
                            <label for="address_line">Alamat Lengkap</label>
                            <input type="text" name="address_line" id="address_line"
                                class="w-full mt-1 px-4 py-2 border rounded-md" required>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div><label for="city">Kota</label><input type="text" name="city" id="city"
                                    class="w-full mt-1 px-4 py-2 border rounded-md" required></div>
                            <div><label for="province">Provinsi</label><input type="text" name="province" id="province"
                                    class="w-full mt-1 px-4 py-2 border rounded-md" required></div>
                        </div>
                        <div class="mt-4"><label for="postal_code">Kode Pos</label><input type="text"
                                name="postal_code" id="postal_code" class="w-full mt-1 px-4 py-2 border rounded-md"
                                required></div>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h2 class="text-xl font-semibold mb-4">Metode Pengiriman</h2>
                        <div class="space-y-2">
                            @foreach ($shippingMethods as $method)
                                <label class="flex items-center p-4 border rounded-lg cursor-pointer">
                                    <input type="radio" name="shipping_method_id" value="{{ $method->id }}"
                                        class="shipping-method" data-cost="{{ $method->cost }}" required>
                                    <div class="ml-4 flex justify-between w-full">
                                        <span>{{ $method->name }}</span>
                                        <span class="font-semibold">Rp
                                            {{ number_format($method->cost, 0, ',', '.') }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md mt-6">
                        <h2 class="text-xl font-semibold mb-4">Metode Pembayaran</h2>
                        <div class="space-y-3">
                            @forelse ($paymentMethods as $method)
                                <label class="flex items-start p-4 border rounded-lg cursor-pointer">
                                    <input type="radio" name="payment_method_id" value="{{ $method->id }}" required
                                        class="mt-1">
                                    <div class="ml-4">
                                        <span class="font-semibold">{{ $method->name }}</span>
                                        <p class="text-sm text-gray-500">{!! nl2br(e($method->description)) !!}</p>
                                    </div>
                                </label>
                            @empty
                                <p class="text-gray-500">Saat ini belum ada metode pembayaran yang tersedia.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="md:col-span-1 bg-white p-6 rounded-lg shadow-md h-fit">
                    <h2 class="text-xl font-semibold mb-4">Ringkasan Pesanan</h2>
                    <div class="border-t mt-4 pt-4">
                        <div class="flex justify-between py-2"><span>Subtotal</span><span>Rp
                                {{ number_format($subtotal, 0, ',', '.') }}</span></div>
                        @if (session('coupon'))
                            <div class="flex justify-between py-2 text-green-600"><span>Diskon
                                    ({{ session('coupon')['code'] }})</span><span>- Rp
                                    {{ number_format($discount, 0, ',', '.') }}</span></div>
                        @endif
                        <div class="flex justify-between py-2"><span>Ongkir</span><span id="shipping-cost-display">Pilih
                                metode</span></div>
                        <div class="flex justify-between py-4 font-bold text-lg border-t mt-2"><span>Total</span><span
                                id="total-display">Rp {{ number_format($totalAfterDiscount, 0, ',', '.') }}</span></div>
                    </div>
                    <button type="submit"
                        class="w-full mt-4 bg-blue-500 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-600">Buat
                        Pesanan</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const shippingRadios = document.querySelectorAll('.shipping-method');
            const subtotal = {{ $subtotal }};
            const discount = {{ $discount }};
            const shippingCostDisplay = document.getElementById('shipping-cost-display');
            const totalDisplay = document.getElementById('total-display');

            shippingRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    const shippingCost = parseFloat(this.dataset.cost);
                    const newTotal = subtotal - discount + shippingCost;

                    shippingCostDisplay.textContent = 'Rp ' + shippingCost.toLocaleString('id-ID');
                    totalDisplay.textContent = 'Rp ' + newTotal.toLocaleString('id-ID');
                });
            });
        });
    </script>
@endsection
