<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blogs;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usersInfo = DB::table('users')
                        ->select('id as user_id','name','user_file');

        $data['blog']=DB::table('blogs')
        ->joinSub($usersInfo,'users_info',function(JoinClause $join){
            $join->on('blogs.user_id', '=', 'users_info.user_id');
        })
        ->get()->sortBy('blog_must');
        return view('frontend.blog.create',compact('data'));
    }

    public function detail($slug)
    {

        //BLOG AND THE WRITER INFO
        $blogList=Blogs::all()->sortBy('blog_must');

        $usersInfo1 = DB::table('users')
        ->select('id as user_id','name','user_file');

        $blog=DB::table('blogs')
        ->joinSub($usersInfo1,'users_info',function(JoinClause $join){
        $join->on('blogs.user_id', '=', 'users_info.user_id');
        })
        ->where('blog_slug',$slug)
        ->first();


        //COMMENTS INFO
        $usersInfo2 = DB::table('users')
                ->select('id as user_id','name','user_file','user_status');

        $blogsInfo = DB::table('blogs')
                ->select('id as blog_id','blog_slug');

        $comments=DB::table('comments')
        ->joinSub($usersInfo2,'users_info',function(JoinClause $join1){
        $join1->on('comments.user_id', '=', 'users_info.user_id');
        })
        ->joinSub($blogsInfo,'blogs_info',function(JoinClause $join2){
        $join2->on('comments.blog_id', '=', 'blogs_info.blog_id');
        })
        ->where('blog_slug',$slug)
        ->get();


        //RATING INFO
        $blogsInfo2 = DB::table('blogs')
                ->select('id as blog_id','blog_slug');

        $rates=DB::table('rates')
        ->joinSub($blogsInfo2,'blogs_info',function(JoinClause $join3){
        $join3->on('rates.blog_id', '=', 'blogs_info.blog_id');
        })
        ->where('blog_slug',$slug)
        ->get();


        return view('frontend.blog.detail',compact('blog','blogList','comments','rates'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('frontend.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $slug=Str::slug($request->blog_title);
        if($request->hasFile('blog_file'))
        {
            $request->validate([
                'blog_title'=>'required',
                'blog_content'=>'required',
                'blog_file'=>'image|mimes:jpg,jpeg,png|max:2048'
            ]);
            
        $file_name=uniqid().'.'.$request->blog_file->getClientOriginalExtension();
        $request->blog_file->move(public_path('images/blogs'),$file_name);
        }
        else{
            $request->validate([
                'blog_title'=>'required',
                'blog_content'=>'required'
            ]);
            $file_name=null;
        }

        $blog=Blogs::create(
            [
                "blog_title" => $request->blog_title,
                "blog_slug" => $slug,
                "blog_file" => $file_name,
                "blog_content" => $request->blog_content,
                "blog_status" => '0',
                "user_id" => Auth::user()->id
                
            ]
        );
        if($blog)
        {
            return redirect(route('default.index'))->with('success','İşlem Başarılı');
        }
        return back()->with('error','İşlem Başarısız');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
