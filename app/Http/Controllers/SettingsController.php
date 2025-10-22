<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display settings main page
     */
    public function index()
    {
        return view('settings.index');
    }

    /**
     * Satuan Settings (Unit Settings)
     */
    public function units()
    {
        return view('settings.units');
    }

    /**
     * Pengingat Settings (Reminders)
     */
    public function reminders()
    {
        return view('settings.reminders');
    }

    /**
     * Format Settings (Date, Currency, etc)
     */
    public function format()
    {
        return view('settings.format');
    }

    /**
     * Account Settings
     */
    public function account()
    {
        return view('settings.account');
    }

    /**
     * Bahan Bakar Settings
     */
    public function fuelTypes()
    {
        return view('settings.fuel-types');
    }

    /**
     * Jenis BBM Settings
     */
    public function fuelGrades()
    {
        return view('settings.fuel-grades');
    }

    /**
     * SPBU Settings
     */
    public function fuelStations()
    {
        return view('settings.fuel-stations');
    }

    /**
     * Lokasi Settings
     */
    public function locations()
    {
        return view('settings.locations');
    }

    /**
     * Jenis Layanan Settings
     */
    public function serviceTypes()
    {
        return view('settings.service-types');
    }

    /**
     * Jenis Biaya Settings
     */
    public function expenseTypes()
    {
        return view('settings.expense-types');
    }

    /**
     * Jenis Pendapatan Settings
     */
    public function incomeTypes()
    {
        return view('settings.income-types');
    }

    /**
     * Alasan Settings
     */
    public function reasons()
    {
        return view('settings.reasons');
    }

    /**
     * Cara Pembayaran Settings
     */
    public function paymentMethods()
    {
        return view('settings.payment-methods');
    }

    /**
     * Formulir Settings
     */
    public function forms()
    {
        return view('settings.forms');
    }

    /**
     * Menghubungi Settings
     */
    public function contacts()
    {
        return view('settings.contacts');
    }

    /**
     * Terjemahan Settings
     */
    public function translations()
    {
        return view('settings.translations');
    }
}
