<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;


class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    private function findUser($credentials){

        $users = Config::get('credentials.users');
        foreach ($users as $user) {
            if ($credentials['username'] === $user['username'] && Hash::check($credentials['password'],$user['password'])){
                return true;
            }
        }

        return false;
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        $result = $this->findUser($credentials);

        if ($result) {
           session(['authenticated' => true]);
            return redirect()->intended(route('files.list'));
        }

        return back()->withErrors([
            'username' => 'Usuario o contraseña incorrectos.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Session::forget('authenticated');
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('loginForm');
    }
}
