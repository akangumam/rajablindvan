<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    /**
     * Switch application locale
     */
    public function switch($locale)
    {
        // Validate locale
        if (!in_array($locale, ['id', 'en'])) {
            abort(400, 'Invalid locale');
        }

        // Debug logging
        Log::info('LocaleController - Requested locale: ' . $locale);
        Log::info('LocaleController - Current app locale before: ' . App::getLocale());

        // Set locale in session
        Session::put('locale', $locale);
        
        // Force session save
        Session::save();
        
        // Set app locale immediately
        App::setLocale($locale);

        // Debug logging
        Log::info('LocaleController - Session locale set to: ' . Session::get('locale'));
        Log::info('LocaleController - Current app locale after: ' . App::getLocale());

        // Redirect back with success message
        return redirect()->back();
    }
}