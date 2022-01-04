<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>UMS Shipment</title>

    <!-- Favicon-->
  
    <link rel="icon" type="image/x-icon" href="{{asset('assets/images/sc.jpg')}}" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v5.13.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Nanum+Gothic&display=swap" rel="stylesheet">
    <!-- Third party plugin CSS-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{asset('assets/css/theme.css')}}" rel="stylesheet" />
    @yield('style')
    <style>
         .navbar-brand{
            font-weight: 800 !important;
            font-size:28px;
            /* font-family: Arial, Helvetica, sans-serif !important; */
            font-family: 'Nanum Gothic', sans-serif !important;
            color:#4143E5 !important;
        }
     
        .brand-style{
            color:#ED1C24;
        }
        .bg-footer-custom{
          background: #4345E7;
        }
        .nav-link{
         color:#4345E7 !important;
        }
    </style>
</head>
<body id="page-top">
 

      <!-- Navigation-->
      <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                  
                UMS<span class="brand-style"> Shipment</span>
            </a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto my-2 my-lg-0">
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#home">HOME</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#track-parcel">TRACK PARCEL</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#about-us">ABOUT US</a></li>
                 
                </ul>
            </div>
        </div>
    </nav>
    @yield('content')


    <!-- Footer-->
    <footer class="bg-footer-custom py-5">
        <div class="container">
            <div class="small text-center text-white">© Copyright <strong>UMS Shipment.</strong> All Rights Reserved</div>
            
        </div>
    </footer>

     <!-- Bootstrap core JS-->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
     <!-- Third party plugin JS-->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
     <!-- Core theme JS-->

      <!-- Core theme JS-->
      <script src="{{asset('assets/js/theme.js')}}"></script>
      @yield('javascript')
</body>
</html>