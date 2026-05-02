<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class AuthController extends Controller
{
    //

    public function showRegister()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $request->validate([
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|confirmed|min:6',
        ]);

        $role = Role::where('name', 'user')->first();

        User::create([
            'name'          =>$request->name,
            'email'         =>$request->email,
            'password'      =>$request->password,
            'role_id'       =>$role->id,
        ]);

        return redirect('/login')->with('success','Registrasi Berhasil! Silahkan login.');

    }
    public function showLogin()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
       if( Auth::attempt([
        'email' => $request->email,
        'password' => $request->password,
    ])){
        
        return redirect('/')->with('success','Login Berhasil! Akses Di Terima.');
    }else{
        return back()->withErrors([
            'email' => 'Email atau password salah!'
        ]);
    }

    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }  
}
