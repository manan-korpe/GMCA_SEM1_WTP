<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'firstname' => 'required|string|min:3',
            'lastname' => 'required|string|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registeration Successful');
    }

    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = User::where('email', $request->username)->first();
        // dd(Hash::check($request->password, $user->password));

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return redirect()->route('login') // explicitly redirect
                 ->with('toastMessage', 'Invalid Username and Password!')
                 ->with('toastType', 'error');
        }

        session([
            'user_id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
        ]);

        return redirect()->route('home')->with('success', 'Login Successful!');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully');
    }
}
