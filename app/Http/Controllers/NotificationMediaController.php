<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationMediaController extends Controller
{
    public function index()
    {
        return view('master.notification-medias');
    }
}