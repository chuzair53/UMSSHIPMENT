<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>UMS Shipment</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{asset('assets/images/sc.jpeg')}}" />
     <!-- Custom fonts-->
    
    <link href="https://fonts.googleapis.com/css2?family=Nanum+Gothic&display=swap" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <!-- Styles -->
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg==" crossorigin="anonymous" />
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    @yield('style')


    <style>
      .navbar-brand{
            font-weight: 800 !important;
            font-family: Arial, Helvetica, sans-serif;
            
        }
        .brand-style{
            color:#ED1C24;
        }
        
        .navbar-brand{
            font-weight: 800 !important;
            /* font-family: Arial, Helvetica, sans-serif; */
            font-family: 'Nanum Gothic', sans-serif;
            
        }
      
    
        .bg-footer-custom{
          background: #4345E7;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                  
                    UMS<span class="brand-style"> Shipment</span>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @if(Auth::user() && Auth::user()->is_type() == 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('manage-shipment') }}">{{ __('Manage Shipment') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('create-shipment') }}">{{ __('Create Shipment') }}</a>
                        </li>
                     
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('manage-admin') }}">{{ __('Manage Admin') }}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('manage-shipper') }}">{{ __('Manage Shipper') }}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('manage-driver') }}">{{ __('Manage Driver') }}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('import-csv') }}">{{ __('Import CSV') }}</a>
                        </li>
                      @elseif(Auth::user() && Auth::user()->is_type() == 'driver')
                      <li class="nav-item">
                        <a class="nav-link" href="{{ url('driver/manage-shipment') }}">{{ __('Manage Shipment') }}</a>
                    </li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                          
                           
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

   <!-- Footer-->
   <footer class="bg-footer-custom py-2">
    <div class="container">
        <div class="small text-center text-white">© Copyright <strong>UMS Shipment.</strong> All Rights Reserved</div>
        
    </div>
</footer>
     <!-- Scripts -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    

     <script src="{{ asset('assets/js/script.js') }}" ></script>
     <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

     @yield('javascript')
</body>
</html>
