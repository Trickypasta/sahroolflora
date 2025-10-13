<div x-show="modalOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center" x-cloak>
    <div @click.outside="modalOpen = false" x-show="modalOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90" class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
        <h2 class="text-xl font-bold text-slate-800">Konfirmasi Penghapusan</h2>
        <p class="mt-2 text-slate-600">Anda yakin ingin menghapus item ini secara permanen? Tindakan ini tidak dapat
            dibatalkan.</p>

        <div class="mt-6 flex justify-end space-x-3">
            <button @click="modalOpen = false" type="button"
                class="px-4 py-2 text-sm font-medium text-slate-700 bg-slate-100 rounded-md hover:bg-slate-200">
                Batal
            </button>
            <button @click="submitForm()" type="button"
                class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>
