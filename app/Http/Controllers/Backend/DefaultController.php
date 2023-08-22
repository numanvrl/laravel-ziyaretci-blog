<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DefaultController extends Controller
{
    public function index()
    {

        return view('backend.default.index');
        
    }

    public function login()
    {
        return view('backend.default.login');
    }


    
    public function authenticate(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|Min:8'
        ]);

        $request->flash();

        $credentials=$request->only('email','password');
        $remember_me=$request->has('remember_me') ? true : false;

        if(Auth::attempt($credentials,$remember_me))
        {
            return redirect()->intended(route('nedmin.index'))->with('success','Login Successful');
        }
        else
        {
            return back()->with('error', 'User Not Found');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('nedmin.Login'))->with('success','Logout Successful');
    }
}
