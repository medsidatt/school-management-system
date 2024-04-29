<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use function Laravel\Prompts\password;

class AdminController extends Controller
{
    public function loginForm() : View
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $messages = [
            'required' => 'Le champ :attribute est obligatoire'
        ];

        $attributes = [
            'username' => 'nom d\'utilisateur',
            'password' => 'mot de passe'
        ];

        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ], $messages, $attributes);

        $username = $request['username'];
        $password = $request['password'];
        if (Auth::attempt(['username' => $username, 'password' => $password]))
        {
            $request->session()->put('username', $username);
            return redirect()->intended(route('home'));
        }
        return redirect()->back()->with('fail', 'Le nom d\'utilisateur ou mot de pass incorrect');
    }


    public function registerForm() : View
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $messages = [
            'required' => 'Le champ :attribute est obligatoire',
            'unique' => 'Le champ :attribute est déjà utilisé'
        ];

        $attributes = [
            'username' => 'nom d\'utilisateur',
            'password' => 'mot de passe',
            'first_name' => 'prénom',
            'last_name' => 'nom'
        ];

        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required',
            'email' => 'required|email|unique:users',
            'first_name' => 'required',
            'last_name' => 'required'
        ], $messages, $attributes);


        $data = [
            'username' => $request['username'],
            'password' => Hash::make($request['password']),
            'first_name' => $request['first_name'], // Changed to snake_case
            'last_name' => $request['last_name'], // Changed to snake_case
            'email' => $request['email']
        ];

        $user = User::create($data);

        $request->session()->put('username', $request['username']);
        return redirect()->route('home');
    }


    public function logout() {
        if (Session::has('username')) {
            Session::pull('username');
            return redirect()->route('login');
        }
    }

}
