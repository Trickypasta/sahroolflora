@extends('layouts.app')
@section('title', 'SahroolFlora - Hubungi Kami')

@section('content')
    <main class="py-10">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-center mb-8">Kontak Kami</h1>
            <div class="bg-white p-8 rounded-lg shadow-md grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h2 class="text-2xl font-semibold mb-4">Kirim Pesan</h2>
                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 mb-2">Nama Anda</label>
                            <input type="text" name="name" id="name" class="w-full px-4 py-2 border rounded-md" required>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 mb-2">Email Anda</label>
                            <input type="email" name="email" id="email" class="w-full px-4 py-2 border rounded-md" required>
                        </div>
                        <div class="mb-4">
                            <label for="message" class="block text-gray-700 mb-2">Pesan Anda</label>
                            <textarea name="message" id="message" rows="5" class="w-full px-4 py-2 border rounded-md" required></textarea>
                        </div>
                        <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-6 rounded-lg hover:bg-blue-600">Kirim Pesan</button>
                    </form>
                </div>
                <div>
                    <h2 class="text-2xl font-semibold mb-4">Info Kontak</h2>
                    <div class="space-y-4 text-gray-700">
                        <p><strong>Alamat:</strong> Jl. Raya Bojong Gede, Kab. Bogor, Jawa Barat</p>
                        <p><strong>Telepon:</strong> +62 812 3456 7890</p>
                        <p><strong>Email:</strong> info@sahroolflora.test</p>
                    </div>
                    <div class="mt-6">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63430.4379927696!2d106.7579178125633!3d-6.46114422967272!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c2079ec059a3%3A0x401576d14fed960!2sBojonggede%2C%20Bogor%20Regency%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1696095681958!5m2!1sen!2sid" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection