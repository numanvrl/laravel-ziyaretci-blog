<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Modern Business - Start Bootstrap Template</title>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.css" rel="stylesheet">

  <link rel="stylesheet" href="/frontend/bower_components/font-awesome/css/font-awesome.min.css">
  
  <!-- Bootstrap core CSS -->
  <link href="/frontend/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="/frontend/css/modern-business.css" rel="stylesheet">
  <link href="/frontend/css/custom/css/custom.css" rel="stylesheet">

  <!-- JavaScript -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
<!-- Semantic UI theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
<!-- Bootstrap theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>



  <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>





</head>

<body class="d-flex flex-column min-vh-100">


<nav class="navbar navbar-expand-sm fixed-top navbar-light bg-light">
  <div class="container">
  <a class="navbar-brand" href="{{route('default.index')}}">BLOGS</a>
  <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
      aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavId">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item active">
        <div class="btn-group btn-sm btn-outline-secondary">
        <a class="nav-link" href="{{route('blogf.create')}}"><i class="fa fa-plus-square-o"></i> Create New Blog <span class="sr-only">(current)</span></a>
        </div>
      </li>
    </ul>
    @if (Auth::user())
    <div class="btn-group">
    <a class="nav-link dropdown-toggle my-2 my-lg-0" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <img width="40" height="40" style="border-radius: 50%" src="/images/users/{{Auth::user()->user_file}}" alt=""> {{Auth::user()->name}}</a>
    <div class="dropdown-menu">
      <a class="dropdown-item" href="#">My Blogs</a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="{{route('default.Logout')}}">Log Out</a>
    </div>
  </div>
    @else
    <div class="btn-group">
    <a class="nav-link dropdown-toggle my-2 my-lg-0" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Login <small>or</small> Register</a>
    <div class="dropdown-menu">
      <a class="dropdown-item" href="{{route('default.Login')}}">Login</a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="{{route('default.Register')}}">Register</a>
    </div>
  </div>
    @endif

  </div>
</div>
</nav>

  <!-- Page Content -->
  @yield('content')

  <!-- Footer -->
  <footer class="mt-auto py-4 bg-dark">
    <div>
      <p class="m-0 text-center text-white">Copyright &copy; Your Website 2019</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="/frontend/vendor/jquery/jquery.min.js"></script>
  <script src="/frontend/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="
  https://cdn.jsdelivr.net/npm/dayjs@1.11.9/dayjs.min.js
  "></script>
  
  <script>

    function toggle(){
     
     let toggle = document.querySelector('.popup-container')
    
     toggle.classList.toggle('toggle');
    
    }
    
    </script>
  <script>
    dayjs().format()
  </script>

@if(session()->has('success'))
<script>alertify.success('{{session('success')}}')</script>
@endif

@if(session()->has('error'))
<script>alertify.error('{{session('error')}}')</script>
@endif

@foreach($errors->all() as $error)
<script>
 alertify.error('{{$error}}');
</script>
@endforeach

</body>

</html>
