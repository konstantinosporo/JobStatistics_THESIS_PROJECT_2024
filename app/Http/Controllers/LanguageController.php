<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switchLanguage($locale)
    {
        if (in_array($locale, ['en', 'el'])) {
            App::setLocale($locale);
            session()->put('locale', $locale);
            //dd(session('locale'));
        }

        return redirect()->back();
    }

}
