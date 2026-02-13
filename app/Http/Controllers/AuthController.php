<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $username = 'aldmic';
    private $password = '123abc123';

    public function showLogin()
    {
        return view('login');
    }
        public function showRegister()
    {
        return view('register');
    }

    public function login(Request $request)
    {
        $user = $request->input('username');
        $pass = $request->input('password');

        if ($user === $this->username && $pass === $this->password) {
            $request->session()->put('user', $user);
            return redirect()->route('movies.list');
        }

        return redirect()->back()->with('error', 'Invalid username or password');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user');
        return redirect()->route('login');
    }
}
