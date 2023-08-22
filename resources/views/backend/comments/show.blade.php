@extends('backend.layout')
@section('content')

<section class="content-header">
  <div class="box box-primary">
      <div class="box-header with-border">
        <h2>Comment Details</h2>
      </div>
      <div class="box-body">
        @csrf


        @if ($comments->user_id != '0')
        <section class="content-header">
          <div class="box box-primary">
              <div class="box-header with-border">       
      <h4>User Information</h4>
      <hr>
        <div>
          @isset($comments->user_file)
          <div class="form-group">
            <label>User Profile Image</label>
            <div class="row">
              <div class="col-xs-12">
                <img width="100" src="/images/users/{{$comments->user_file}}">
              </div>
            </div>
          </div>
          @endisset
        </div>
      <hr>
        <div class="form-group">
          <label>Name Surname</label>
          <div class="row">
            <div class="col-xs-12">
              <p>{{$comments->name}}</p>
            </div>
          </div>
        </div>
        <hr>
        <div class="form-group">
          <label>Email</label>
          <div class="row">
            <div class="col-xs-12">
             <p>{{$comments->email}}</p>
            </div>
          </div>
        </div>
        <hr>
        <div class="form-group">
          <label>User Status</label>
          <div class="row">
            <div class="col-xs-12">
                <p>{{$comments->user_status==1 ? "Active" : "Passive"}}</p>
            </div>
          </div>
        </div>

              </div>
          </div>
        </section>

        @else
        <section class="content-header">
          <div class="box box-primary">
              <div class="box-header with-border">       
          <h4>User Information (GUEST)</h4>
          <hr>
        <div class="form-group">
          <label>Name Surname</label>
          <div class="row">
            <div class="col-xs-12">
              <p>{{$comments->guest_name}}</p>
            </div>
          </div>
        </div>
          </div>
          </div>
        </section>    
        @endif
        
        <section class="content-header">
          <div class="box box-primary">
              <div class="box-header with-border">
        <h4>Blog Information</h4>
        <hr>
        <div>
          @isset($comments->blog_file)
          <div class="form-group">
            <label>Blog Loaded Image</label>
            <div class="row">
              <div class="col-xs-12">
                <img width="100" src="/images/blogs/{{$comments->blog_file}}">
              </div>
            </div>
          </div>
          @endisset
        </div>
        <hr>
        <div class="form-group">
        <label>Blog Title</label>
        <div class="row">
          <div class="col-xs-12">
            <p>{{$comments->blog_title}}</p>
          </div>
        </div>
      </div>
      <hr>
      <div class="form-group">
        <label>Blog Slug</label>
        <div class="row">
          <div class="col-xs-12">
           <p>{{$comments->blog_slug}}</p>
          </div>
        </div>
      </div>
      <hr>
      <div class="form-group">
        <label>Blog Status</label>
        <div class="row">
          <div class="col-xs-12">
              <p>{{$comments->blog_status==1 ? "Active" : "Passive"}}</p>
          </div>
        </div>
      </div>
              </div>
          </div>
        </section>
        <section class="content-header">
          <div class="box box-primary">
              <div class="box-header with-border">
      <h4>Comment Information</h4>
      <hr>
      <div class="form-group">
        <label>Comment Date/Time</label>
        <div class="row">
          <div class="col-xs-12">
            <p>{{$comments->created_at}}</p>
          </div>
        </div>
      </div>
      <hr>
      <div class="form-group">
        <label>Comment Content</label>
        <div class="row">
          <div class="col-xs-12">
           <p>{!!$comments->comment_content!!}</p>
          </div>
        </div>
      </div>
      <hr>
       <form action="{{route('comment.updateStatus',['id'=>$comments->id])}}" method="post">
        @csrf

        <div class="form-group">
          <label>Comment Status</label>
          <div class="row">
            <div class="col-xs-12">
              <select name="comment_status" class="form-control">
                <option {{$comments->comment_status=="1" ? "selected=''" : ""}} value="1">Active</option>
                <option {{$comments->comment_status=="0" ? "selected=''" : ""}} value="0">Passive</option>
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
      </div>
  </div>
  </section>

  @endsection

  @section('css')@endsection
  @section('js')@endsection
