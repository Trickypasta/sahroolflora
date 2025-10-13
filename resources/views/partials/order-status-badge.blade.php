{{-- resources/views/partials/order-status-badge.blade.php --}}

@switch($status)
    @case('pending')
        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu Pembayaran</span>
        @break
    @case('processing')
        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Diproses</span>
        @break
    @case('shipped')
        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">Dikirim</span>
        @break
    @case('completed')
        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
        @break
    @case('cancelled')
        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Dibatalkan</span>
        @break
    @default
        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">{{ ucfirst($status) }}</span>
@endswitch