@extends('layouts.app')
@section('title', 'Promo & Diskon')

@section('content')
    <div class="max-w-4xl mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold text-center mb-8">Promo & Diskon Spesial</h1>
        <div class="space-y-4">
            @forelse ($coupons as $coupon)
                <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-blue-600">{{ $coupon->code }}</h2>
                        <p class="text-gray-600 mt-1">
                            @if ($coupon->type == 'fixed')
                                Dapatkan potongan harga sebesar Rp {{ number_format($coupon->value, 0, ',', '.') }}.
                            @else
                                Dapatkan diskon sebesar {{ $coupon->percent_off }}%.
                            @endif
                        </p>
                    </div>
                    <button onclick="copyToClipboard('{{ $coupon->code }}')"
                        class="bg-gray-200 text-gray-800 font-semibold px-4 py-2 rounded-md hover:bg-gray-300">
                        Salin Kode
                    </button>
                </div>
            @empty
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <p class="text-gray-500">Saat ini belum ada promo yang tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Kode "' + text + '" berhasil disalin!');
            }, function(err) {
                alert('Gagal menyalin kode.');
            });
        }
    </script>
@endsection
