@extends('backend.layout')
@section('content')
<section class="content-header">
  <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Edit Comment</h3>
      </div>
      <div class="box-body">
        <form action="{{route('comment.update',$comments->id)}}" method="post">
        @csrf
        @method('PUT')
        

      <div class="form-group">
        <label>Content</label>
        <div class="row">
          <div class="col-xs-12">
            <textarea style="height: 200px" class="form-control" name="comment_content">{{$comments->comment_content}}</textarea>
          </div>
        </div>
      </div>


        <div class="form-group">
          <label>Status</label>
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
          <button type="submit" class="btn btn-primary">Edit</button>
        </div>
      

        </form>

      </div>
  </div>
  </section>

  @endsection

  @section('css')@endsection
  @section('js')@endsection
