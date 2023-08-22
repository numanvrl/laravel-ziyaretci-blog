@extends('frontend.layout')
@section('title',"Anasayfa Başlığı")
@section('content')
<br>
<div class="container" >
    <!-- left column -->
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Add a New Blog</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form action="{{route('blogf.store')}}" method="post" enctype="multipart/form-data">
            @csrf
          <div class="box-body">
            <div class="form-group col-md-6">
                <label>Choose Image</label>
                <div class="row">
                    <input class="form-control" name="blog_file" required readonly type="file">
                </div>
              </div>
            <div class="form-group col-md-6">
              <label>Title</label>
              <input type="text" name="blog_title" class="form-control" placeholder="Add a Title to Your Blog">
            </div>
            <div class="form-group col-md-12">
              <label>Content</label>
              <textarea class="form-control" id="editor" name="blog_content" placeholder="Write Your Content Here"></textarea>
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
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
</div>
<br>

@endsection
@section('css') @endsection
@section('js') @endsection