@extends('layouts.app')

@section('title', 'Promo & Diskon - SahroolFlora')

@section('content')

    <div class="bg-[#F8F7F3]">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8 text-center">
            <h1 class="font-lora text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Promo & Diskon Spesial</h1>
            <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">Manfaatkan penawaran spesial kami untuk mendapatkan tanaman impian Anda dengan harga terbaik.</p>
        </div>
    </div>

    <div class="bg-white">
        <div class="max-w-7xl mx-auto py-16 sm:py-24 px-4 sm:px-6 lg:px-8">
            
            @if ($coupons->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach ($coupons as $coupon)
                        {{-- Setiap div di bawah ini adalah satu kartu kupon --}}
                        <div x-data="{
                                code: '{{ $coupon->code }}',
                                feedback: 'Salin Kode',
                                copyToClipboard() {
                                    navigator.clipboard.writeText(this.code).then(() => {
                                        this.feedback = 'Berhasil Disalin!';
                                        setTimeout(() => { this.feedback = 'Salin Kode' }, 2000);
                                    }).catch(() => {
                                        this.feedback = 'Gagal Menyalin';
                                    });
                                }
                            }" 
                            class="bg-white rounded-lg border border-gray-200 p-8 flex flex-col items-center text-center transition hover:shadow-lg">
                            
                            <h2 class="font-lora text-3xl font-bold text-green-700">
                                @if ($coupon->type == 'fixed')
                                    Potongan Rp {{ number_format($coupon->value, 0, ',', '.') }}
                                @else
                                    Diskon {{ $coupon->percent_off }}%
                                @endif
                            </h2>
                            
                            <p class="mt-2 text-gray-600">Untuk semua produk tanpa minimum pembelian.</p>

                            <div class="my-6 w-full border-2 border-dashed border-gray-300 rounded-lg p-4">
                                <span class="font-mono text-xl font-bold tracking-widest text-gray-800">{{ $coupon->code }}</span>
                            </div>

                            <button @click="copyToClipboard()"
                                    :class="{ 'bg-green-600 text-white': feedback === 'Berhasil Disalin!', 'bg-gray-200 text-gray-800 hover:bg-gray-300': feedback !== 'Berhasil Disalin!' }"
                                    class="w-full font-semibold px-4 py-3 rounded-md transition-colors duration-300">
                                <span x-text="feedback">Salin Kode</span>
                            </button>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center bg-gray-50 rounded-lg py-16">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-12v.75m0 3v.75m0 3v.75m0 3V18m-9-12h18a2.25 2.25 0 012.25 2.25v10.5A2.25 2.25 0 0119.5 21H4.5A2.25 2.25 0 012.25 18.75V4.5A2.25 2.25 0 014.5 3z" /></svg>
                    <h2 class="mt-4 text-xl font-semibold text-gray-800">Belum Ada Promo</h2>
                    <p class="mt-2 text-gray-600">Cek kembali halaman ini nanti untuk penawaran spesial dari kami.</p>
                </div>
            @endif
        </div>
    </div>
@endsection