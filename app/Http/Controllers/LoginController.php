<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function index(){
        return view('auth/login');
    }

    public function login(Request $request){
        $credentials = $request->validate([
                            'email'     => 'required|email:dns',
                            'password'  => 'required',
                        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('home');
        }
        $request->session()->flash('notif','Login Failed!!');
        return back(); 
    }

    public function logout(){
        Auth::logout();

        Request()->session()->invalidate();

        Request()->session()->regenerateToken();

        Request()->session()->flash('success','Logged Out!!');
        return redirect('/');
    }
}
