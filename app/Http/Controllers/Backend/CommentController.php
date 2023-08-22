<?php

namespace App\Http\Controllers\Backend;

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

        $usersInfo = DB::table('users')
                        ->select('id as user_id','name');
        
        $blogsInfo = DB::table('blogs')
                        ->select('id as blog_id','blog_title');

        $data['comment']=DB::table('comments')
        ->joinSub($usersInfo,'users_info',function(JoinClause $join1){
            $join1->on('comments.user_id', '=', 'users_info.user_id');
        })
        ->joinSub($blogsInfo,'blogs_info',function(JoinClause $join2){
            $join2->on('comments.blog_id', '=', 'blogs_info.blog_id');
        })

        ->get()->sortBy('comment_must');
         return view('backend.comments.index',compact('data'));
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
        ->where('comments.id',$id)
        ->get()->first();
        return view('backend.comments.show')->with('comments',$comments);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $comments=Comments::where('id',$id)->first();
        return view('backend.comments.edit')->with('comments',$comments);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

            $request->validate([
                'comment_content'=>'required'
            ]);

        $comment=Comments::Where('id',$id)->update(
            [
                "comment_content" => $request->comment_content,
                "comment_status" => $request->comment_status
            ]
        );
        
        if($comment)
        {
            return back()->with('success','İşlem Başarılı');
        }
        return back()->with('error','İşlem Başarısız');
    }
    public function updateStatus(Request $request, $id)
    {

        $comment=Comments::Where('id',$id)->update(
            [
                "comment_status" => $request->comment_status
            ]);
        if($comment)
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
        $comment=Comments::find(intval($id));
        if($comment->delete())
        {
            echo 1;
        }
        echo 0;
    }
    public function sortable(){

        foreach($_POST['item'] as $key => $value)
        {
            $comments=Comments::find(intval($value));
            $comments->blog_must=intval($key);
            $comments->save();
        }
        echo true;
    }
}
