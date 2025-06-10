<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthenticationController extends Controller
{
    public function forgotPassword()
    {
        return view('admin.authentication.forgotPassword');
    }

    public function signIn()
    {
        return view('admin.authentication.signin');
    }

    public function signUp()
    {
        return view('admin.authentication.signup');
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // récupère true/false
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Check if user is admin

            if (Auth::user()->role == 'admin') {
                return redirect()->intended(route('admin.dashboard'))->with('success', 'Vous êtes connecté avec succès');
            } else {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Vous n\'avez pas les privilèges d\'administrateur.',
                ]);
            }

            // return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Identifiants incorrectes',
        ])->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.signin');
    }
}
