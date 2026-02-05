<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = \App\Models\User::paginate(10);
        return view('admin.dashboard', compact('users'));
    }
}
