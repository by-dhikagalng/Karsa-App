<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin() // Form login
    {
        return view('events.login');
    }

    public function login() // Proses login
    {
        return 'TODO Login Process Bekti';
    }

    public function logout() // Logout
    {
        return 'TODO Logout Bekti';
    }
}
