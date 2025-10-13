<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->all();
        return view('about', compact('settings'));
    }

    // Nanti kita bisa tambahkan method lain di sini untuk FAQ, Terms, dll.
    public function faq()
    {
        $settings = Setting::pluck('value', 'key')->all();
        return view('faq', compact('settings'));
    }

    public function terms()
    {
        $settings = Setting::pluck('value', 'key')->all();
        return view('terms', compact('settings'));
    }

    public function privacy()
    {
        $settings = Setting::pluck('value', 'key')->all();
        return view('privacy', compact('settings'));
    }
}
