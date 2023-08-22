<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comments;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Auth::user()){
        $request->validate([
            'comment_content'=>'required',
        ]);
        $user_id = Auth::user()->id;
    }
    else{
        $request->validate([
            'guest_name'=>'required',
            'comment_content'=>'required',
        ]);
        $user_id = '0';
    }
    if(isset(Auth::user()->rate)){
        $comment=Comments::create(
            [
                "comment_content" => $request->comment_content,
                "comment_status" => '1',
                "user_id" => $user_id,
                "blog_id" => $request->blog_id,
                "guest_name" => $request->guest_name
            ]
        );
    }
        if($comment)
        {
            return back()->with('success','Comment Send');
        }
        return back()->with('error','Comment Could not Send');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $usersInfo = DB::table('users')
        ->select('id as user_id','name','email','user_file','user_status');

        $blogsInfo = DB::table('blogs')
                ->select('id as blog_id','blog_title','blog_slug','blog_file','blog_status');

        $comments=DB::table('comments')
        ->joinSub($usersInfo,'users_info',function(JoinClause $join1){
        $join1->on('comments.user_id', '=', 'users_info.user_id');
        })
        ->joinSub($blogsInfo,'blogs_info',function(JoinClause $join2){
        $join2->on('comments.blog_id', '=', 'blogs_info.blog_id');
        })
        ->where('comments.blog_id',$id)
        ->get();
        return view('frontend.comment.show',compact('data'));
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
