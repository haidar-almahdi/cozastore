<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function index()
    {
        return view('shop.contact');
    }
} 