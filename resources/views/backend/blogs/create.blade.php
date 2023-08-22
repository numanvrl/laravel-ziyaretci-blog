@extends('backend.layout')
@section('content')
<section class="content-header">
  <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Create New Blog</h3>
      </div>
      <div class="box-body">
        <form action="{{route('blog.store')}}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
          <label>Select Image</label>
          <div class="row">
            <div class="col-xs-12">
              <input class="form-control" name="blog_file" required readonly type="file">
            </div>
          </div>
        </div>

        <div class="form-group">
        <label>Title</label>
        <div class="row">
          <div class="col-xs-12">
            <input class="form-control" type="text" name="blog_title" >
          </div>
        </div>
      </div>

      <div class="form-group">
        <label>Slug</label>
        <div class="row">
          <div class="col-xs-12">
            <input class="form-control" type="text" name="blog_slug" >
          </div>
        </div>
      </div>

      <div class="form-group">
        <label>Content</label>
        <div class="row">
          <div class="col-xs-12">
            <textarea class="form-control" id="editor" name="blog_content"></textarea>
            <script>
                ClassicEditor
                        .create( document.querySelector( '#editor' ) )
                        .then( editor => {
                                console.log( editor );
                        } )
                        .catch( error => {
                                console.error( error );
                        } );
                </script>

          </div>
        </div>

        <div class="form-group">
          <label>Status</label>
          <div class="row">
            <div class="col-xs-12">
              <select name="blog_status" class="form-control">
                <option value="1">Active</option>
                <option value="0">Passive</option>
              </select>
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