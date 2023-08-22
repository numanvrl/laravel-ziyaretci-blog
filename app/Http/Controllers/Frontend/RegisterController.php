<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('frontend.default.register');
    }

    public function register(Request $request)
    {
        
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
            
        $user=User::create(
            [
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password),
                "role" => '2',
                "user_status" => '0',
                "user_file" => 'guest-image.png'
            ]
        );
        if($user)
        {
            return redirect(route('default.index'))->with('success','Registeration Successful');
        }
        return back()->with('error','Registeration Unsuccessful');
    }
}
