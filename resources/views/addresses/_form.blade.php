{{-- Menampilkan error validasi jika ada --}}
@if ($errors->any())
    <div class="mb-4 bg-red-50 border-l-4 border-red-400 text-red-700 p-4" role="alert">
        <p class="font-bold">Oops! Terjadi kesalahan:</p>
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="space-y-4">
    <div>
        <label for="address_line" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
        <input type="text" name="address_line" id="address_line" value="{{ old('address_line', $address->address_line ?? '') }}" required
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="city" class="block text-sm font-medium text-gray-700">Kota/Kabupaten</label>
            <input type="text" name="city" id="city" value="{{ old('city', $address->city ?? '') }}" required
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
        </div>
        <div>
            <label for="province" class="block text-sm font-medium text-gray-700">Provinsi</label>
            <input type="text" name="province" id="province" value="{{ old('province', $address->province ?? '') }}" required
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
        </div>
    </div>
     <div>
        <label for="postal_code" class="block text-sm font-medium text-gray-700">Kode Pos</label>
        <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $address->postal_code ?? '') }}" required
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
    </div>
</div>

<div class="text-right mt-6">
    <a href="{{ route('addresses.index') }}" class="text-sm text-gray-600 hover:underline mr-4">Batal</a>
    <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-full text-white bg-green-700 hover:bg-green-800">
        Simpan Alamat
    </button>
</div>