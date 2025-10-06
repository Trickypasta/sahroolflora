<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Ganti dengan logika otorisasi admin jika perlu
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|unique:posts,title',
            'body' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];
    }
}