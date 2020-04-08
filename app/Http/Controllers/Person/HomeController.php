<?php

namespace App\Http\Controllers\Person;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return redirect(route('login'));
    }
}
