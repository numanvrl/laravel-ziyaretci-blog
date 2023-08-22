@extends('frontend.layout')
@section('title',"Anasayfa Başlığı")
@section('content')
  <!-- Page Content -->
  <div class="container">

    <!-- Page Heading/Breadcrumbs -->
    
    <h1 class="mt-4 mb-3">{{$blog->blog_title}}</h1>

      <p>
        <img width="40" height="40" style="border-radius: 50%" src="/images/users/{{$blog->user_file}}" alt=""> Posted By {{$blog->name}}
    </p>

    <div class="row ">
      <!-- Post Content Column -->
      <div class="col-lg-8">

        <!-- Preview Image -->
        @if ($blog->blog_file)
        <img class="img-fluid rounded" src="/images/blogs/{{$blog->blog_file}}" alt="">     
        @endif
        <hr>

        <!-- Date/Time -->
        
        <p><i>Posted on {{ Carbon\Carbon::parse($blog->created_at)->format('d-m-Y h:i')}}</i></p>
        <hr>

        <!-- Post Content -->
        
        <p>{!!$blog->blog_content!!}</p>

        <hr>
    
      </div>

      <!-- Sidebar Widgets Column -->
      <div class="col-md-4">


        <!-- Side Widget -->
        <div class="card my-4">
          <h5 class="card-header">Latest Blogs</h5>
          <div class="card-body">
            <ul class="list-group">
                @foreach ($blogList as $list)
                @if($list->blog_status == 1)
                <a href="{{route('blog.Detail',$list->blog_slug)}}"><li class="list-group-item">{{$list->blog_title}}</li></a>
                @endif
                @endforeach
              </ul>
          </div>
        </div>

      </div>
    </div>
    <div class="container">
    <div class="row align-items-center">
<div class="col-md-auto">
  @if(Auth::guest())
  <div class="myDIV">
  <button disabled onclick="toggle()" id="button" class="btn btn-warning">Rate This Blog</button>
</div>
<div class="hide">Please Log In To Rate</div>
@else
<button onclick="toggle()" id="button" class="btn btn-warning">Rate This Blog</button>
@endif
</div>

@php
$finalRate = 0;
$numberOfRate = 0;
    foreach ($rates as $val) {
      if($val->rate_status == 1){
      $finalRate += $val->rate; 
      $numberOfRate++;
      }
    }
    if($numberOfRate == 0){
      $finalRate = 0;
    }
    else{
    $finalRate /= $numberOfRate;
  }
@endphp


<div class="col-md-auto">
  <div class="rateshow">
    <label class="{{$finalRate>=0.01 ? 'checked2' : 'checked'}}" for="star5" title="Awesome"></label>
    <label class="{{$finalRate>=2 ? 'checked2' : 'checked'}}" for="star4" title="Good"></label>
    <label class="{{$finalRate>=3 ? 'checked2' : 'checked'}}" for="star3" title="Okey"></label>
    <label class="{{$finalRate>=4 ? 'checked2' : 'checked'}}" for="star2" title="Bad"></label>
    <label class="{{$finalRate==5 ? 'checked2' : 'checked'}}" for="star1" title="Terrible"></label>
    <span>({{$numberOfRate}})</span>
  </div>
</div>
<div class="col-6 text-start">

</div>
    </div>
</div>
    <form action="{{route('commentf.store')}}" method="post">
      @csrf
    <div class="container my-3 text-dark">
      <div class="row d-flex justify-content-left">
        <div class="col-md-10">
          <div class="card">
            <div class="card-body p-4">
              <div class="d-flex flex-start w-100">
              @if (Auth::user())
                  <img class="rounded-circle shadow-1-strong me-3"
                  src="/images/users/{{Auth::user()->user_file}}" width="65"
                  height="65">
                <div class="w-100">
                  <div class="form-group">
                    <textarea class="form-control" rows="3" name="comment_content" placeholder="Add a comment"></textarea>
                  </div>

                  <div class="d-flex justify-content-between mt-3">
                    <button type="submit" class="btn btn-success">Send</button>
                  </div>
                </div>
                @else
                <div class="w-100">
                  <h5>Add a comment</h5>
                  <div class="form-group">
                    <label>Name Surname</label>
                    <input type="text" class="form-control" name="guest_name" value="{{old('guest_name')}}" placeholder="Enter ...">
                  </div>
                  <div class="form-group">
                    <label>Comment</label>
                    <textarea class="form-control" rows="3" name="comment_content" value="{{old('comment_content')}}" placeholder="Enter ..."></textarea>
                  </div>
                  <div class="d-flex justify-content-between mt-3">
                    <button type="submit" class="btn btn-success">Send</button>
                  </div>
                </div>
                @endif
                <input type="hidden" name="blog_id" value="{{$blog->id}}">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</form>

    <div class="col-md-10">
          <h4 class="text-left mb-4 pb-2">Comments ({{$comments->where('comment_status','1')->count()}})</h4>
          @empty($comments[0])
          <div class="card">
            <div class="card-body mb-1 pb-4">
            <div class="row">
                <div class="d-flex flex-start mt-4">
                  <div class="flex-grow-1 flex-shrink-1">
                    <div>
                      <p class="mb-0">
                        There is no comment
                      </p>
                    </div>
              </div>
            </div>
          </div>
      </div>
  </div>
  <br>
         @endempty 
         @foreach ($comments as $comment)
         @if ($comment->comment_status==1)
          <div class="card">
          <div class="card-body mb-1 pb-4">
          <div class="row">
              <div class="d-flex flex-start mt-4">
                <img class="rounded-circle shadow-1-strong me-3"
                  src="/images/users/{{($comment->user_id == 0) ? 'guest-image.png' : $comment->user_file}}" alt="avatar" width="65"
                  height="65" />
                <div class="flex-grow-1 flex-shrink-1">
                  <div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="mb-1">
                        {{($comment->user_id == 0) ? $comment->guest_name : $comment->name}} <span class="small">- {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</span>
                      </p>
                    </div>
                    <p class="small mb-0">
                      {{$comment->comment_content}}
                    </p>
                  </div>
            </div>
          </div>
        </div>
    </div>
</div>
<br>
@endif
@endforeach

      </div>
    </div>
<form action=" {{route('ratef.store')}}" method="post">
  @csrf
    <div class="popup-container">

      <div class="popup">
  
          <h3>DID YOU LIKE THIS BLOG</h3>

            <div class="rate">
          <input type="radio" id="star5" name="rate" value="5" />
          <label for="star5" title="Awesome">5 stars</label>
          <input type="radio" id="star4" name="rate" value="4" />
          <label for="star4" title="Good">4 stars</label>
          <input type="radio" id="star3" name="rate" value="3" />
          <label for="star3" title="Okey">3 stars</label>
          <input type="radio" id="star2" name="rate" value="2" />
          <label for="star2" title="Bad">2 stars</label>
          <input type="radio" id="star1" name="rate" value="1" />
          <label for="star1" title="Terrible">1 star</label>
        </div>
  
          <input type="submit" value="submit" class="btn">
  
          <div onclick="toggle()" id="close">✖</div>
  
      </div>
      <input type="hidden" name="blog_id" value="{{$blog->id}}">
  </div>
</form>
    <br>

@endsection
@section('css') @endsection
@section('js') @endsection