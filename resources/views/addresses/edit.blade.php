@extends('layouts.app')
@section('title', 'Edit Alamat - SahroolFlora')

@section('content')
    <div class="bg-gray-50 border-b">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <h1 class="font-lora text-3xl font-extrabold tracking-tight text-gray-900">Edit Alamat</h1>
        </div>
    </div>
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <form action="{{ route('addresses.update', $address->id) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- atau 'PATCH' --}}
                    
                    {{-- Panggil form partial yang sama, tapi kirim data $address --}}
                    @include('addresses._form', ['address' => $address])
                </form>
            </div>
        </div>
    </div>
@endsection