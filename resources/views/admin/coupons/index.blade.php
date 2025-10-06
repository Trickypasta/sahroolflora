@extends('layouts.admin')
@section('title', 'Manajemen Kupon Diskon')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Manajemen Kupon Diskon</h1>

    @include('partials.notification')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-4">Buat Kupon Baru</h2>
                <form action="{{ route('admin.coupons.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="code" class="block font-semibold">Kode Kupon</label>
                        <input type="text" name="code" id="code" class="w-full border rounded-md px-3 py-2 mt-1 uppercase" required>
                    </div>
                    <div class="mb-4">
                        <label for="type" class="block font-semibold">Tipe Diskon</label>
                        <select name="type" id="type" class="w-full border rounded-md px-3 py-2 mt-1">
                            <option value="fixed">Potongan Tetap (Rp)</option>
                            <option value="percent">Persentase (%)</option>
                        </select>
                    </div>
                    <div class="mb-4" id="value_field">
                        <label for="value" class="block font-semibold">Jumlah Potongan (Rp)</label>
                        <input type="number" name="value" id="value" class="w-full border rounded-md px-3 py-2 mt-1">
                    </div>
                    <div class="mb-4 hidden" id="percent_off_field">
                        <label for="percent_off" class="block font-semibold">Persentase Potongan (%)</label>
                        <input type="number" name="percent_off" id="percent_off" class="w-full border rounded-md px-3 py-2 mt-1">
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md w-full hover:bg-blue-600">Simpan Kupon</button>
                </form>
            </div>
        </div>

        {{-- Kolom Kanan: Daftar Kupon --}}
        <div class="lg:col-span-2">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-4">Daftar Kupon Aktif</h2>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border px-4 py-2 text-left">Kode</th>
                                <th class="border px-4 py-2 text-left">Tipe</th>
                                <th class="border px-4 py-2 text-left">Nilai</th>
                                <th class="border px-4 py-2 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($coupons as $coupon)
                                <tr class="hover:bg-gray-50">
                                    <td class="border px-4 py-2 font-mono font-bold">{{ $coupon->code }}</td>
                                    <td class="border px-4 py-2">{{ $coupon->type == 'fixed' ? 'Potongan Tetap' : 'Persentase' }}</td>
                                    <td class="border px-4 py-2">
                                        @if($coupon->type == 'fixed')
                                            Rp {{ number_format($coupon->value, 0, ',', '.') }}
                                        @else
                                            {{ $coupon->percent_off }}%
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2">
                                        <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kupon ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline text-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="border px-4 py-2 text-center text-gray-500">Belum ada kupon diskon.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('type').addEventListener('change', function () {
        if (this.value === 'percent') {
            document.getElementById('percent_off_field').classList.remove('hidden');
            document.getElementById('value_field').classList.add('hidden');
        } else {
            document.getElementById('percent_off_field').classList.add('hidden');
            document.getElementById('value_field').classList.remove('hidden');
        }
    });
</script>
@endpush