@extends('layouts.admin')

@section('title', 'Manajemen Ulasan')

@section('content')
    <h1 class="text-3xl font-bold mb-4">Manajemen Ulasan</h1>
    <p class="text-slate-600 mb-8">Setujui atau hapus ulasan yang dikirim oleh pelanggan dari halaman ini.</p>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">Pelanggan</th>
                        <th scope="col" class="px-6 py-3">Produk</th>
                        <th scope="col" class="px-6 py-3">Rating</th>
                        <th scope="col" class="px-6 py-3">Komentar</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($testimonials as $testimonial)
                        <tr class="bg-white border-b hover:bg-slate-50">
                            <td class="px-6 py-4 font-medium text-slate-900">{{ $testimonial->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $testimonial->product->name ?? 'Produk Dihapus' }}</td>
                            <td class="px-6 py-4 text-yellow-500 font-bold">{{ $testimonial->rating }} ★</td>
                            <td class="px-6 py-4 max-w-sm truncate" title="{{ $testimonial->comment }}">
                                {{ $testimonial->comment ?: '-' }}</td>
                            <td class="px-6 py-4">
                                @if ($testimonial->is_approved)
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                @else
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu
                                        Persetujuan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 flex items-center space-x-2">
                                @unless ($testimonial->is_approved)
                                    <form action="{{ route('admin.testimonials.approve', $testimonial->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="font-medium text-blue-600 hover:underline">Setujui</button>
                                    </form>
                                @endunless
                                <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST"
                                    @submit.prevent="openModal($event.target)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-slate-500">Belum ada ulasan yang masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $testimonials->links() }}
        </div>
    </div>
@endsection
