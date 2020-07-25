<?php

namespace App\Http\Controllers;

class SiteController extends Controller
{
    public function index()
    {
        return view('site.index');
    }

    public function contacts()
    {
        return view('site.contacts');
    }
}
