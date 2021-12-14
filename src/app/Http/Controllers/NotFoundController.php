<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotFoundController extends Controller
{
    public function not_found()
    {
        return view('layouts.404');
    }
}
