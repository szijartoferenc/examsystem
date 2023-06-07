<!doctype html>
<html lang="en">
  <head>
  	<title>Admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="{{ asset('css/style.css')}}">
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
        <script src="{{asset('js/multiselect-dropdown.js')}}"></script>

        <style>
            .multiselect-dropdown{
                width: 100% !important;
            }
        </style>

  </head>
  <body>

		<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar">
				<div class="custom-menu">
					<button type="button" id="sidebarCollapse" class="btn btn-primary">
	          <i class="fa fa-bars"></i>
	          <span class="sr-only">Toggle Menu</span>
	        </button>
        </div>
	  		<h1><a href="/admin/dashboard" class="logo">Admin kezelőfelület</a></h1>
        <ul class="list-unstyled components mb-5">
          <li class="active">
            <a href="/admin/dashboard"><span class="fa fa-book mr-3"></span>Tantárgyak</a>
          </li>
          <li class="active">
            <a href="/admin/exam"><span class="fa fa-tasks mr-3"></span>Vizsgák</a>
          </li>
          <li class="active">
            <a href="/admin/marks"><span class="fa fa-check mr-3"></span>Értékelés</a>
          </li>
          <li class="active">
            <a href="/admin/questions-answers"><span class="fa fa-question-circle mr-3"></span>Kérdések&Válaszok</a>
          </li>
          <li class="active">
            <a href="/admin/students"><span class="fa fa-graduation-cap mr-3"></span>Hallgatók</a>
          </li>
          <li class="active">
            <a href="/admin/review-exams"><span class="fa fa-file-o mr-3"></span>Vizsga felülvizsgálat</a>
          </li>
          <li>
              <a href="/logout"><span class="fa fa-user mr-3"></span> Kijelentkezés</a>
          </li>

        </ul>

    	</nav>

        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5 pt-5">
            @yield('space-work')
      </div>
		</div>

    {{-- <script src="{{asset('js/jquery-3.7.0.js')}}"></script>
    <script src="{{asset('js/popper.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script> --}}
    <script src="{{asset('js/main.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.7/umd/popper.min.js" integrity="sha512-uaZ0UXmB7NHxAxQawA8Ow2wWjdsedpRu7nJRSoI2mjnwtY8V5YiCWavoIpo1AhWPMLiW5iEeavmA3JJ2+1idUg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.min.js" integrity="sha512-1/RvZTcCDEUjY/CypiMz+iqqtaoQfAITmNSJY17Myp4Ms5mdxPS5UV7iOfdZoxcGhzFbOm6sntTKJppjvuhg4g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  </body>
</html>
