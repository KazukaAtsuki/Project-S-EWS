<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function general()
    {
        return view('settings.general');
    }

    public function notifications()
    {
        return view('settings.notifications');
    }
}