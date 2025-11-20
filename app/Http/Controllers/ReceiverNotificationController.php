<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReceiverNotificationController extends Controller
{
    public function index()
    {
        return view('master.receiver-notification');
    }
}