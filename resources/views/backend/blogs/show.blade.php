@extends('backend.layout')
@section('content')
<section class="content-header">
  <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Blog Detail</h3>
      </div>
      <div class="box-body">
        @csrf
        
        <div>
          @isset($blogs->blog_file)
          <div class="form-group">
            <label>Loaded Image</label>
            <div class="row">
              <div class="col-xs-12">
                <img width="100" src="/images/blogs/{{$blogs->blog_file}}">
              </div>
            </div>
          </div>
          @endisset
          
        </div>

        <div class="form-group">
        <label>Title</label>
        <div class="row">
          <div class="col-xs-12">
            <p>{{$blogs->blog_title}}</p>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label>Slug</label>
        <div class="row">
          <div class="col-xs-12">
           <p>{{$blogs->blog_slug}}</p>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label>Post Date/Time</label>
        <div class="row">
          <div class="col-xs-12">
            <p>{{$blogs->created_at}}</p>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label>Content</label>
        <div class="row">
          <div class="col-xs-12">
           <p>{!!$blogs->blog_content!!}</p>
          </div>
        </div>
      </div>

       <form action="{{route('blog.updateStatus',['id'=>$blogs->id])}}" method="post">
        @csrf

        <div class="form-group">
          <label>Status</label>
          <div class="row">
            <div class="col-xs-12">
              <select name="blog_status" class="form-control">
                <option {{$blogs->blog_status=="1" ? "selected=''" : ""}} value="1">Active</option>
                <option {{$blogs->blog_status=="0" ? "selected=''" : ""}} value="0">Passive</option>
              </select>
            </div>
          </div>
        </div>

        <div align="right" class="box-footer">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
        </form>

      </div>
  </div>
  </section>

  @endsection

  @section('css')@endsection
  @section('js')@endsection
