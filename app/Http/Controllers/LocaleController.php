<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    /**
     * Switch application locale
     */
    public function switch($locale)
    {
        // Validate locale
        if (!in_array($locale, ['id', 'en'])) {
            abort(400);
        }

        // Store locale in session
        session(['locale' => $locale]);

        // Redirect back
        return redirect()->back();
    }
}
