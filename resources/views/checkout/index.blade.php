@extends('layouts.app')

@section('title', 'Checkout - SahroolFlora')

@section('content')
    <div x-data="{
        shippingCost: 0,
        subtotal: {{ $subtotal }},
        discount: {{ $discount }},
        addressOption: '{{ $addresses->isNotEmpty() ? $addresses->first()->id : 'new' }}', // Opsi default
        get total() {
            let calculatedTotal = this.subtotal - this.discount + this.shippingCost;
            return calculatedTotal < 0 ? 0 : calculatedTotal;
        },
        formatCurrency(value) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
        }
    }" class="bg-gray-50">

        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="text-center pb-12">
                <h1 class="font-lora text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Checkout</h1>
            </div>

            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-12 lg:gap-x-12 items-start">

                    <div class="lg:col-span-8 space-y-8">

                        <section class="bg-white p-6 rounded-lg shadow-sm">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">1. Alamat Pengiriman</h2>

                            {{-- Opsi Pilihan Alamat --}}
                            <div class="space-y-4">
                                @if ($addresses->isNotEmpty())
                                    @foreach ($addresses as $address)
                                        <label
                                            class="flex items-start p-4 border rounded-lg cursor-pointer has-[:checked]:bg-green-50 has-[:checked]:border-green-400">
                                            <input type="radio" name="address_option" value="{{ $address->id }}"
                                                x-model="addressOption">
                                            <div class="ml-4 text-sm">
                                                <p class="font-semibold text-gray-900">{{ $address->address_line }}</p>
                                                <p class="text-gray-600">{{ $address->city }}, {{ $address->province }}
                                                    {{ $address->postal_code }}</p>
                                            </div>
                                        </label>
                                    @endforeach
                                @endif

                                <label
                                    class="flex items-start p-4 border rounded-lg cursor-pointer has-[:checked]:bg-green-50 has-[:checked]:border-green-400">
                                    <input type="radio" name="address_option" value="new" x-model="addressOption">
                                    <div class="ml-4 text-sm font-semibold text-gray-900">
                                        Kirim ke alamat baru
                                    </div>
                                </label>
                            </div>

                            {{-- Form Alamat Baru (hanya muncul jika opsi 'new' dipilih) --}}
                            <div x-show="addressOption === 'new'" x-transition class="mt-6 space-y-4 border-t pt-6">
                                <div>
                                    <label for="address_line" class="block text-sm font-medium text-gray-700">Alamat
                                        Lengkap</label>
                                    <input type="text" name="address_line" id="address_line"
                                        :disabled="addressOption !== 'new'"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label for="city"
                                            class="block text-sm font-medium text-gray-700">Kota/Kabupaten</label>
                                        <input type="text" name="city" id="city"
                                            :disabled="addressOption !== 'new'"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                                    </div>
                                    <div>
                                        <label for="province"
                                            class="block text-sm font-medium text-gray-700">Provinsi</label>
                                        <input type="text" name="province" id="province"
                                            :disabled="addressOption !== 'new'"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                                    </div>
                                </div>
                                <div>
                                    <label for="postal_code" class="block text-sm font-medium text-gray-700">Kode
                                        Pos</label>
                                    <input type="text" name="postal_code" id="postal_code"
                                        :disabled="addressOption !== 'new'"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                                </div>
                            </div>
                        </section>

                        <section class="bg-white p-6 rounded-lg shadow-sm">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">2. Metode Pengiriman</h2>
                            <div class="space-y-4">
                                @foreach ($shippingMethods as $method)
                                    <label
                                        class="flex items-center p-4 border rounded-lg cursor-pointer has-[:checked]:bg-green-50 has-[:checked]:border-green-400">
                                        <input type="radio" name="shipping_method_id" value="{{ $method->id }}"
                                            @click="shippingCost = {{ $method->cost }}"
                                            class="h-4 w-4 text-green-600 border-gray-300 focus:ring-green-500" required>
                                        <div class="ml-4 flex justify-between w-full">
                                            <span class="font-medium text-gray-800">{{ $method->name }}</span>
                                            <span class="font-semibold text-gray-900">Rp
                                                {{ number_format($method->cost, 0, ',', '.') }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </section>

                        <section class="bg-white p-6 rounded-lg shadow-sm">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">3. Metode Pembayaran</h2>
                            <div class="space-y-4">
                                @forelse ($paymentMethods as $method)
                                    <label
                                        class="flex items-start p-4 border rounded-lg cursor-pointer has-[:checked]:bg-green-50 has-[:checked]:border-green-400">
                                        <input type="radio" name="payment_method_id" value="{{ $method->id }}" required
                                            class="mt-1 h-4 w-4 text-green-600 border-gray-300 focus:ring-green-500">
                                        <div class="ml-4">
                                            <span class="font-medium text-gray-800">{{ $method->name }}</span>
                                            <p class="text-sm text-gray-500">{!! nl2br(e($method->description)) !!}</p>
                                        </div>
                                    </label>
                                @empty
                                    <p class="text-gray-500">Saat ini belum ada metode pembayaran yang tersedia.</p>
                                @endforelse
                            </div>
                        </section>
                    </div>

                    <div class="lg:col-span-4 mt-10 lg:mt-0">
                        <aside class="bg-white p-6 rounded-lg shadow-sm lg:sticky lg:top-24">
                            <h2 class="text-lg font-medium text-gray-900">Ringkasan Pesanan</h2>
                            <dl class="mt-6 space-y-4">
                                <div class="flex items-center justify-between">
                                    <dt class="text-sm text-gray-600">Subtotal</dt>
                                    <dd class="text-sm font-medium text-gray-900" x-text="formatCurrency(subtotal)"></dd>
                                </div>
                                @if (session('coupon'))
                                    <div class="flex items-center justify-between text-green-600">
                                        <dt class="text-sm">Diskon ({{ session('coupon')['code'] }})</dt>
                                        <dd class="text-sm font-medium" x-text="'- ' + formatCurrency(discount)"></dd>
                                    </div>
                                @endif
                                <div class="flex items-center justify-between">
                                    <dt class="text-sm text-gray-600">Ongkos Kirim</dt>
                                    <dd class="text-sm font-medium text-gray-900" x-text="formatCurrency(shippingCost)">
                                    </dd>
                                </div>
                                <div class="border-t border-gray-200 pt-4 flex items-center justify-between">
                                    <dt class="text-base font-medium text-gray-900">Total</dt>
                                    <dd class="text-base font-medium text-gray-900" x-text="formatCurrency(total)"></dd>
                                </div>
                            </dl>
                            <div class="mt-6">
                                <button type="submit"
                                    class="w-full flex items-center justify-center rounded-full border border-transparent bg-green-700 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-green-800">
                                    Buat Pesanan
                                </button>
                            </div>
                        </aside>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
