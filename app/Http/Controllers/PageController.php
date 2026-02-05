<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function initiative()
    {
        return view('initiative');
    }

    public function products()
    {
        return view('products');
    }

    public function investors()
    {
        return view('investors');
    }

    // REMOVED: public function dashboard() 
    // We removed it because DashboardController handles this now.
}

