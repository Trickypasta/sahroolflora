<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk - SahroolFlora</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">

    @include('admin.partials.navbar')

    <main class="py-10">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h1 class="text-2xl font-bold mb-6">Edit Produk: {{ $product->name }}</h1>

                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') 
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-semibold mb-2">Nama Produk</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="w-full px-4 py-2 border rounded-md @error('name') border-red-500 @enderror" required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
                        <textarea name="description" id="description" rows="5" class="w-full px-4 py-2 border rounded-md">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="price" class="block text-gray-700 font-semibold mb-2">Harga (Rp)</label>
                            <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" class="w-full px-4 py-2 border rounded-md" required>
                        </div>
                        <div>
                            <label for="stock" class="block text-gray-700 font-semibold mb-2">Stok</label>
                            <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock->quantity ?? 0) }}" class="w-full px-4 py-2 border rounded-md" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Kategori</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                            @foreach ($categories as $category)
                                <label class="flex items-center">
                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="mr-2"
                                        @if(in_array($category->id, $product->categories->pluck('id')->toArray())) checked @endif
                                    > {{ $category->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">Update Produk</button>
                        <a href="{{ route('admin.products.index') }}" class="text-gray-600 ml-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>