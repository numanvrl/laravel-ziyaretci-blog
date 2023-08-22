@extends('backend.layout')
@section('content')
<section class="content-header">
  <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Edit User</h3>
      </div>
      <div class="box-body">
        <form action="{{route('user.update',$users->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
          <label>Select Image</label>
          <div class="row">
            <div class="col-xs-12">
              <input class="form-control" name="user_file" required readonly type="file">
            </div>
          </div>
        </div>
        
        <div>
          @isset($users->user_file)
          <div class="form-group">
            <label>Loaded Image</label>
            <div class="row">
              <div class="col-xs-12">
                <img width="100" src="/images/users/{{$users->user_file}}">
              </div>
            </div>
          </div>
          @endisset
          
        </div>

        <div class="form-group">
        <label>Name Surname</label>
        <div class="row">
          <div class="col-xs-12">
            <input class="form-control" type="text" name="name" value="{{$users->name}}">
          </div>
        </div>
      </div>

      <div class="form-group">
        <label>Email</label>
        <div class="row">
          <div class="col-xs-12">
            <input class="form-control" type="email" name="email" value="{{$users->email}}">
          </div>
        </div>
      </div>

      <div class="form-group">
        <label>Password</label>
        <div class="row">
          <div class="col-xs-12">
            <input class="form-control" type="password" name="password">
          </div>
        </div>
      </div>


        <div class="form-group">
          <label>Status</label>
          <div class="row">
            <div class="col-xs-12">
              <select name="user_status" class="form-control" {{Auth::user()->role=="0" ? "" : "disabled"}}>
                <option {{$users->user_status=="1" ? "selected=''" : ""}} value="1">Active</option>
                <option {{$users->user_status=="0" ? "selected=''" : ""}} value="0">Passive</option>
              </select>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label>Role</label>
          <div class="row">
            <div class="col-xs-12">
              <select name="role" class="form-control" {{Auth::user()->role=="0" ? "" : "disabled"}}>
                <option {{$users->role=="0" ? "selected=''" : ""}} value="0">Admin</option>
                <option {{$users->role=="1" ? "selected=''" : ""}} value="1">Editor</option>
                <option {{$users->role=="2" ? "selected=''" : ""}} value="2">User</option>
              </select>
            </div>
          </div>
        </div>

          <input type="hidden" name="old_file" value="{{$users->user_file}}">

        <div align="right" class="box-footer">
          <button type="submit" class="btn btn-primary">Edit</button>
        </div>
      

        </form>

      </div>
  </div>
  </section>

  @endsection

  @section('css')@endsection
  @section('js')@endsection
