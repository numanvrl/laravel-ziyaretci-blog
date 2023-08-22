<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['user']=User::all()->sortBy('user_must');
        return view('backend.users.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if($request->hasFile('user_file'))
        {
            $request->validate([
                'name'=>'required',
                'email'=>'required|email',
                'password'=>'required|Min:6',
                'user_file'=>'image|mimes:jpg,jpeg,png|max:2048'
            ]);
            
        $file_name=uniqid().'.'.$request->user_file->getClientOriginalExtension();
        $request->user_file->move(public_path('images/users'),$file_name);
        }
        else{
            $request->validate([
                'name'=>'required',
                'email'=>'required',
                'password'=>'required|Min:6'
            ]);
            $file_name=null;
        }

        $user=User::create(
            [
                "name" => $request->name,
                "user_file" => $file_name,
                "email" => $request->email,
                "password" => Hash::make($request->password),
                "role" => $request->role,
                "user_status" => $request->user_status
            ]
        );
        if($user)
        {
            return redirect(route('user.index'))->with('success','İşlem Başarılı');
        }
        return back()->with('error','İşlem Başarısız');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $users=User::where('id',$id)->first();
        return view('backend.users.show')->with('users',$users);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $users=User::where('id',$id)->first();
        return view('backend.users.edit')->with('users',$users);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'name'=>'required',
            'email'=>'required|email'
        ]);

        if($request->hasFile('user_file'))
        {
            $request->validate([
                'user_file'=>'image|mimes:jpg,jpeg,png|max:2048'
            ]);     
        $file_name=uniqid().'.'.$request->user_file->getClientOriginalExtension();
        $request->user_file->move(public_path('images/users'),$file_name);

        if(strlen($request->password)>0)
        {
            $request->validate([
                'password'=>'Min:6'
            ]);  
        
        $user=User::Where('id',$id)->update(
            [
                "name" => $request->name,
                "user_file" => $file_name,
                "email" => $request->email,
                "user_status" => $request->user_status,
                "password" => Hash::make($request->password),
                "role" => $request->role
            ]
        );
        }
        else{
            $user=User::Where('id',$id)->update(
                [
                    "name" => $request->name,
                    "user_file" => $file_name,
                    "email" => $request->email,
                    "user_status" => $request->user_status,
                    "role" => $request->role
                ]
            );
        }
        $path='images/users/'.$request->old_file;
        if(file_exists($path))
        {
            @unlink(public_path($path));
        }
    
    }
        else{
            if(strlen($request->password)>0)
            {
                $request->validate([
                    'password'=>'Min:6'
                ]);  
            
            $user=User::Where('id',$id)->update(
                [
                    "name" => $request->name,
                    "email" => $request->email,
                    "user_status" => $request->user_status,
                    "password" => Hash::make($request->password),
                    "role" => $request->role
                ]
            );
            }
            else{
                $user=User::Where('id',$id)->update(
                    [
                        "name" => $request->name,
                        "email" => $request->email,
                        "user_status" => $request->user_status,
                        "role" => $request->role
                    ]
                );
            }
        }

        if($user)
        {
            return back()->with('success','İşlem Başarılı');
        }
        return back()->with('error','İşlem Başarısız');
    }

    public function updateStatus(Request $request,$id)
    {
    if(Auth::user()->role == '0'){
        $user=DB::table('users')
        ->where('id',$id)
        ->update(
            [
                "user_status" => $request->user_status,
                "role" => $request->role
            ]);
    }
    else{
        $user=DB::table('users')
        ->where('id',$id)
        ->update(
            [
                "user_status" => $request->user_status,
            ]);
    }
    if ($request->user_status == '0') {
        DB::table('blogs')
         ->where('user_id',$id)
         ->update(
             [
                 "blog_status" => '0',
             ]);   

        DB::table('comments')
        ->where('user_id',$id)
        ->update(
            [
                "comment_status" => '0',
            ]);  
            
        DB::table('rates')
        ->where('user_id',$id)
        ->update(
            [
                "rate_status" => '0',
            ]);
    }            
        if($user)
        {
            return back()->with('success','İşlem Başarılı');
        }

        return back()->with('error','İşlem Başarısız');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user=User::find(intval($id));
        if($user->delete())
        {
            echo 1;
        }
        echo 0;
    }


}
