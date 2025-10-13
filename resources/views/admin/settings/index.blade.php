@extends('layouts.admin')

@section('title', 'Pengaturan Website')

@section('content')
    <h1 class="text-3xl font-bold mb-4">Pengaturan Website</h1>
    <p class="text-slate-600 mb-8">Kelola informasi umum dan konten halaman statis website Anda dari sini.</p>

    <div x-data="{ tab: 'umum' }">
        <div class="border-b border-slate-200 mb-8">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button @click="tab = 'umum'"
                    :class="{ 'border-blue-500 text-blue-600': tab === 'umum', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': tab !== 'umum' }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Pengaturan Umum
                </button>
                <button @click="tab = 'tentang'"
                    :class="{ 'border-blue-500 text-blue-600': tab === 'tentang', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': tab !== 'tentang' }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Halaman "Tentang Kami"
                </button>
                <button @click="tab = 'faq'"
                    :class="{ 'border-blue-500 text-blue-600': tab === 'faq', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': tab !== 'faq' }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Halaman FAQ
                </button>
                <button @click="tab = 'legal'"
                    :class="{ 'border-blue-500 text-blue-600': tab === 'legal', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': tab !== 'legal' }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Halaman Legal
                </button>
                <button @click="tab = 'medsos'"
                    :class="{ 'border-blue-500 text-blue-600': tab === 'medsos', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': tab !== 'medsos' }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Media Sosial
                </button>
            </nav>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-8">
                <div x-show="tab === 'umum'" x-cloak class="bg-white p-6 rounded-lg shadow-md">
                    <div class="space-y-4">
                        <div>
                            <label for="general_sitename" class="block font-semibold mb-1">Nama Website</label>
                            <input type="text" id="general_sitename" name="general_sitename"
                                value="{{ $settings['general_sitename'] ?? 'SahroolFlora' }}"
                                class="w-full border-slate-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label for="contact_phone" class="block font-semibold mb-1">Nomor Telepon</label>
                            <input type="text" id="contact_phone" name="contact_phone"
                                value="{{ $settings['contact_phone'] ?? '' }}"
                                class="w-full border-slate-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label for="contact_email" class="block font-semibold mb-1">Email Kontak</label>
                            <input type="email" id="contact_email" name="contact_email"
                                value="{{ $settings['contact_email'] ?? '' }}"
                                class="w-full border-slate-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label for="contact_address" class="block font-semibold mb-1">Alamat</label>
                            <textarea id="contact_address" name="contact_address" rows="3"
                                class="w-full border-slate-300 rounded-md shadow-sm">{{ $settings['contact_address'] ?? '' }}</textarea>
                        </div>
                        <div>
                            <label for="general_logo" class="block font-semibold mb-1">Logo Website</label>
                            @if (isset($settings['general_logo']))
                                <img src="{{ asset('storage/' . $settings['general_logo']) }}" alt="Logo"
                                    class="h-12 mb-2">
                            @endif
                            <input type="file" id="general_logo" name="general_logo" class="w-full">
                        </div>
                        <div>
                            <label for="general_favicon" class="block font-semibold mb-1">Favicon</label>
                            @if (isset($settings['general_favicon']))
                                <img src="{{ asset('storage/' . $settings['general_favicon']) }}" alt="Favicon"
                                    class="h-8 mb-2">
                            @endif
                            <input type="file" id="general_favicon" name="general_favicon" class="w-full">
                        </div>
                    </div>
                </div>

                <div x-show="tab === 'tentang'" x-cloak class="bg-white p-6 rounded-lg shadow-md">
                    <div class="space-y-4">
                        <div>
                            <label for="about_story" class="block font-semibold mb-1">Paragraf Cerita</label>
                            <textarea id="about_story" name="about_story" rows="5" class="w-full border-slate-300 rounded-md shadow-sm">{{ $settings['about_story'] ?? '' }}</textarea>
                        </div>
                        <div>
                            <label for="about_vision" class="block font-semibold mb-1">Teks Visi</label>
                            <textarea id="about_vision" name="about_vision" rows="3" class="w-full border-slate-300 rounded-md shadow-sm">{{ $settings['about_vision'] ?? '' }}</textarea>
                        </div>

                        <hr class="my-6">
                        <h3 class="text-lg font-bold">Poin-Poin Misi</h3>

                        {{-- Misi 1 --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t pt-4">
                            <div>
                                <label for="about_mission_1_title" class="block font-semibold mb-1">Judul Misi 1</label>
                                <input type="text" id="about_mission_1_title" name="about_mission_1_title"
                                    value="{{ $settings['about_mission_1_title'] ?? 'Kualitas Terbaik' }}"
                                    class="w-full border-slate-300 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label for="about_mission_1_desc" class="block font-semibold mb-1">Deskripsi Misi
                                    1</label>
                                <textarea id="about_mission_1_desc" name="about_mission_1_desc" rows="2"
                                    class="w-full border-slate-300 rounded-md shadow-sm">{{ $settings['about_mission_1_desc'] ?? '' }}</textarea>
                            </div>
                        </div>
                        {{-- Misi 2 --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t pt-4">
                            <div>
                                <label for="about_mission_2_title" class="block font-semibold mb-1">Judul Misi 2</label>
                                <input type="text" id="about_mission_2_title" name="about_mission_2_title"
                                    value="{{ $settings['about_mission_2_title'] ?? 'Akses Mudah' }}"
                                    class="w-full border-slate-300 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label for="about_mission_2_desc" class="block font-semibold mb-1">Deskripsi Misi
                                    2</label>
                                <textarea id="about_mission_2_desc" name="about_mission_2_desc" rows="2"
                                    class="w-full border-slate-300 rounded-md shadow-sm">{{ $settings['about_mission_2_desc'] ?? '' }}</textarea>
                            </div>
                        </div>
                        {{-- Misi 3 --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t pt-4">
                            <div>
                                <label for="about_mission_3_title" class="block font-semibold mb-1">Judul Misi 3</label>
                                <input type="text" id="about_mission_3_title" name="about_mission_3_title"
                                    value="{{ $settings['about_mission_3_title'] ?? 'Dukung Petani Lokal' }}"
                                    class="w-full border-slate-300 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label for="about_mission_3_desc" class="block font-semibold mb-1">Deskripsi Misi
                                    3</label>
                                <textarea id="about_mission_3_desc" name="about_mission_3_desc" rows="2"
                                    class="w-full border-slate-300 rounded-md shadow-sm">{{ $settings['about_mission_3_desc'] ?? '' }}</textarea>
                            </div>
                        </div>
                        {{-- Misi 4 --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t pt-4">
                            <div>
                                <label for="about_mission_4_title" class="block font-semibold mb-1">Judul Misi 4</label>
                                <input type="text" id="about_mission_4_title" name="about_mission_4_title"
                                    value="{{ $settings['about_mission_4_title'] ?? 'Edukasi & Komunitas' }}"
                                    class="w-full border-slate-300 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label for="about_mission_4_desc" class="block font-semibold mb-1">Deskripsi Misi
                                    4</label>
                                <textarea id="about_mission_4_desc" name="about_mission_4_desc" rows="2"
                                    class="w-full border-slate-300 rounded-md shadow-sm">{{ $settings['about_mission_4_desc'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div x-show="tab === 'faq'" x-cloak class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold mb-4 border-b pb-3">Halaman: FAQ</h2>
                    <p class="text-sm text-slate-500 mb-4">Isi pertanyaan dan jawaban. Kosongkan jika tidak ingin
                        ditampilkan. Maksimal 5 untuk contoh ini.</p>
                    <div class="space-y-6">
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="border-t pt-4">
                                <label for="faq_q{{ $i }}" class="block font-semibold mb-1">Pertanyaan
                                    {{ $i }}</label>
                                <input type="text" id="faq_q{{ $i }}" name="faq_q{{ $i }}"
                                    value="{{ $settings['faq_q' . $i] ?? '' }}"
                                    class="w-full border-slate-300 rounded-md shadow-sm">

                                <label for="faq_a{{ $i }}" class="block font-semibold mb-1 mt-2">Jawaban
                                    {{ $i }}</label>
                                <textarea id="faq_a{{ $i }}" name="faq_a{{ $i }}" rows="3"
                                    class="w-full border-slate-300 rounded-md shadow-sm">{{ $settings['faq_a' . $i] ?? '' }}</textarea>
                            </div>
                        @endfor
                    </div>
                </div>

                <div x-show="tab === 'legal'" x-cloak class="bg-white p-6 rounded-lg shadow-md">
                    <div class="space-y-4">
                        <div>
                            <label for="legal_terms" class="block font-semibold mb-1">Isi Halaman "Syarat dan
                                Ketentuan"</label>
                            <textarea id="legal_terms" name="legal_terms" rows="10" class="w-full border-slate-300 rounded-md shadow-sm">{{ $settings['legal_terms'] ?? '' }}</textarea>
                        </div>
                        <div>
                            <label for="legal_privacy" class="block font-semibold mb-1">Isi Halaman "Kebijakan
                                Privasi"</label>
                            <textarea id="legal_privacy" name="legal_privacy" rows="10"
                                class="w-full border-slate-300 rounded-md shadow-sm">{{ $settings['legal_privacy'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <div x-show="tab === 'medsos'" x-cloak class="bg-white p-6 rounded-lg shadow-md">
                    <div class="space-y-4">
                        <div>
                            <label for="social_instagram" class="block font-semibold mb-1">URL Instagram</label>
                            <input type="url" id="social_instagram" name="social_instagram"
                                value="{{ $settings['social_instagram'] ?? '' }}"
                                class="w-full border-slate-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label for="social_facebook" class="block font-semibold mb-1">URL Facebook</label>
                            <input type="url" id="social_facebook" name="social_facebook"
                                value="{{ $settings['social_facebook'] ?? '' }}"
                                class="w-full border-slate-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label for="social_shopee" class="block font-semibold mb-1">URL Shopee</label>
                            <input type="url" id="social_shopee" name="social_shopee"
                                value="{{ $settings['social_shopee'] ?? '' }}"
                                class="w-full border-slate-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label for="social_tiktok" class="block font-semibold mb-1">URL TikTok</label>
                            <input type="url" id="social_tiktok" name="social_tiktok"
                                value="{{ $settings['social_tiktok'] ?? '' }}"
                                class="w-full border-slate-300 rounded-md shadow-sm">
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-right mt-8">
                <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-6 rounded-lg hover:bg-blue-700">
                    Simpan Semua Pengaturan
                </button>
            </div>
        </form>
    </div>
@endsection
