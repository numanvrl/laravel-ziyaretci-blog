@extends('backend.layout')
@section('content')
<section class="content-header">
  <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Create New User</h3>
      </div>
      <div class="box-body">
        <form action="{{route('user.store')}}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
          <label>Select Image</label>
          <div class="row">
            <div class="col-xs-12">
              <input class="form-control" name="user_file" required readonly type="file">
            </div>
          </div>
        </div>

        <div class="form-group">
        <label>Name Surname</label>
        <div class="row">
          <div class="col-xs-12">
            <input class="form-control" type="text" name="name" >
          </div>
        </div>
      </div>

      <div class="form-group">
        <label>Email</label>
        <div class="row">
          <div class="col-xs-12">
            <input class="form-control" type="email" name="email" >
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
              <select name="user_status" class="form-control">
                <option value="1">Active</option>
                <option value="0">Passive</option>
              </select>
            </div>
          </div>
        </div>

          <div class="form-group">
            <label>Role</label>
            <div class="row">
              <div class="col-xs-12">
                <select name="role" class="form-control">
                  <option value="0">Admin</option>
                  <option value="1">Editor</option>
                  <option value="2" selected>User</option>
                </select>
              </div>
            </div>
          </div>

        <div align="right" class="box-footer">
          <button type="submit" class="btn btn-primary">Add</button>
        </div>
      </div>

        </form>
      </div>
  </div>
  </section>

  @endsection

  @section('css')@endsection
  @section('js')@endsection