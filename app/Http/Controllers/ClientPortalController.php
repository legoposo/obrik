<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ClientPortalController extends Controller
{
    public function index(): View
    {
        return view('client-portal.index');
    }
}