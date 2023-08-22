<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Rates;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
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

        $data['rate']=DB::table('rates')
        ->joinSub($usersInfo,'users_info',function(JoinClause $join1){
        $join1->on('rates.user_id', '=', 'users_info.user_id');
        })
        ->joinSub($blogsInfo,'blogs_info',function(JoinClause $join2){
        $join2->on('rates.blog_id', '=', 'blogs_info.blog_id');
        })

        ->get()->sortBy('comment_must');
        return view('backend.rates.index',compact('data'));
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
        //
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

        $rates=DB::table('rates')
        ->joinSub($usersInfo,'users_info',function(JoinClause $join1){
        $join1->on('rates.user_id', '=', 'users_info.user_id');
        })
        ->joinSub($blogsInfo,'blogs_info',function(JoinClause $join2){
        $join2->on('rates.blog_id', '=', 'blogs_info.blog_id');
        })
        ->where('rates.id',$id)
        ->get()->first();
        return view('backend.rates.show')->with('rates',$rates);
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

    public function updateStatus(Request $request, $id)
    {

        $rate=Rates::Where('id',$id)->update(
            [
                "rate_status" => $request->rate_status
            ]);
        if($rate)
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
        $rate=Rates::find(intval($id));
        if($rate->delete())
        {
            echo 1;
        }
        echo 0;
    }
}
