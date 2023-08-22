@extends('frontend.layout')
@section('content')
<div class="container">

<br>

    <!-- Portfolio Section -->
    <h2>Latest Posts</h2>

    <div class="row">
        @foreach ($data['blog'] as $blog)
        @if ($blog->blog_status == 1 )

        @php
        $finalRate = 0;
        $numberOfRate = 0;
            foreach ($data['rate'] as $val) {
              if($blog->id == $val->blog_id && $val->rate_status==1){
              $finalRate += $val->rate; 
              $numberOfRate++;
            }
            }
            if($numberOfRate == 0){
            $finalRate=0;
          }
          else{
            $finalRate /= $numberOfRate;
          }
        @endphp


      <div class="col-lg-4 col-sm-6 portfolio-item">
        <div class="card h-100">
          <div class="card-body">
            <h4 class="card-title">
              <a href="{{route('blog.Detail',$blog->blog_slug)}}">{{$blog->blog_title}}</a>
            </h4>
            <div class='indexrate'><label class="{{$finalRate>=0.01 ? 'checked2' : 'checked'}}" for="star5" title="Awesome"></label></div>
            {{-- <div class="rateshowi">
              <label class="{{$finalRate>=0.01 ? 'checked2' : 'checked'}}" for="star5" title="Awesome"></label>
              <label class="{{$finalRate>=2 ? 'checked2' : 'checked'}}" for="star4" title="Good"></label>
              <label class="{{$finalRate>=3 ? 'checked2' : 'checked'}}" for="star3" title="Okey"></label>
              <label class="{{$finalRate>=4 ? 'checked2' : 'checked'}}" for="star2" title="Bad"></label>
              <label class="{{$finalRate==5 ? 'checked2' : 'checked'}}" for="star1" title="Terrible"></label>
            </div> --}}
            <div class="row">
            <h5><small>
              <img width="40" height="40" style="border-radius: 50%" src="/images/users/{{$blog->user_file}}" alt=""> Posted By {{$blog->name}} 
              <sup>• {{ \Carbon\Carbon::parse($blog->created_at)->diffForHumans() }}</sup>
            </small></h5>
            </div>
            <p class="card-text">{!!substr($blog->blog_content,0,250)!!}...</p>
          </div>
        </div>
      </div>
      @endif
      @endforeach
    </div>


  </div>
  <!-- /.container -->
  @endsection
  @section('css') @endsection
  @section('js') @endsection