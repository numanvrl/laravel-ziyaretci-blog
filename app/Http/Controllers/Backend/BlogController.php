<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['blog']=Blogs::all()->sortBy('blog_must');
        return view('backend.blogs.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.blogs.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(strlen($request->blog_slug)>3)
        {
            $slug=Str::slug($request->blog_slug);
        }
        else{
            $slug=Str::slug($request->blog_title);
        }
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
                "blog_status" => $request->blog_status,
                "user_id" => Auth::user()->id
            ]
        );
        if($blog)
        {
            return redirect(route('blog.index'))->with('success','İşlem Başarılı');
        }
        return back()->with('error','İşlem Başarısız');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $blogs=Blogs::where('id',$id)->first();
        return view('backend.blogs.show')->with('blogs',$blogs);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blogs=Blogs::where('id',$id)->first();
        return view('backend.blogs.edit')->with('blogs',$blogs);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(strlen($request->blog_slug)>3)
        {
            $slug=Str::slug($request->blog_slug);
        }
        else{
            $slug=Str::slug($request->blog_title);
        }
        if($request->hasFile('blog_file'))
        {
            $request->validate([
                'blog_title'=>'required',
                'blog_content'=>'required',
                'blog_file'=>'required|image|mimes:jpg,jpeg,png|max:2048'
            ]);
            
        $file_name=uniqid().'.'.$request->blog_file->getClientOriginalExtension();
        $request->blog_file->move(public_path('images/blogs'),$file_name);

        $blog=Blogs::Where('id',$id)->update(
            [
                "blog_title" => $request->blog_title,
                "blog_slug" => $slug,
                "blog_file" => $file_name,
                "blog_content" => $request->blog_content,
                "blog_status" => $request->blog_status
            ]
        );
        
        $path='images/blogs/'.$request->old_file;
        if(file_exists($path))
        {
            @unlink(public_path($path));
        }
    
    }
        else{
        $blog=Blogs::Where('id',$id)->update(
            [
                "blog_title" => $request->blog_title,
                "blog_slug" => $slug,
                "blog_content" => $request->blog_content,
                "blog_status" => $request->blog_status
            ]
        );
        }


        if($blog)
        {
            return back()->with('success','İşlem Başarılı');
        }
        return back()->with('error','İşlem Başarısız');
    }

    public function updateStatus(Request $request, $id)
    {

        $blog=Blogs::Where('id',$id)->update(
            [
                "blog_status" => $request->blog_status
            ]);
        if($blog)
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
        $blog=Blogs::find(intval($id));
        if($blog->delete())
        {
            echo 1;
        }
        echo 0;
    }

    public function sortable(){

        foreach($_POST['item'] as $key => $value)
        {
            $blogs=Blogs::find(intval($value));
            $blogs->blog_must=intval($key);
            $blogs->save();
        }
        echo true;
    }
}
