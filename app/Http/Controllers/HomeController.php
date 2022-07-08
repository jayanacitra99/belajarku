<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        if(auth()->user()->role == 'ADMIN'){
            return redirect('admin');
        } else if (auth()->user()->role == 'TEACHER'){
            return redirect('teacher');
        } else if (auth()->user()->role == 'STUDENT'){
            return redirect('student');
        }
    }

    public function back(){
        return back();
    }
}
