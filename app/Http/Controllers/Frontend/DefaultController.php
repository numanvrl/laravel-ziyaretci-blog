<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blogs;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DefaultController extends Controller
{
    public function index()
    {
        $usersInfo = DB::table('users')
                        ->select('id as user_id','name','user_file');

        $blogsInfo = DB::table('blogs')
                        -> select('id as blog_id','blog_status');                

        $data['blog']=DB::table('blogs')
        ->joinSub($usersInfo,'users_info',function(JoinClause $join){
            $join->on('blogs.user_id', '=', 'users_info.user_id');  
        })
        ->get()->sortBy('blog_must');


        $data['rate']=DB::table('rates')
        ->joinSub($blogsInfo,'blogs_info',function(JoinClause $join){
            $join->on('rates.blog_id', '=', 'blogs_info.blog_id');
        })
        ->get();
        return view('frontend.default.index',compact('data'));
        
    }


    public function login()
    {
        return view('frontend.default.login');
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
            return redirect()->intended(route('default.index'))->with('success','Login Successful');
        }
        else
        {
            return back()->with('error', 'User Not Found');
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect(route('default.index'))->with('success','Logout Successful');
    }


}
