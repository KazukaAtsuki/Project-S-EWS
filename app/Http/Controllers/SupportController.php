<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function tickets()
    {
        return view('master.tickets');
    }

    public function faq()
    {
        return view('support.faq');
    }
}