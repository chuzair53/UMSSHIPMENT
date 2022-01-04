@extends('layouts.master')

@section('style')
<style>
    .track-form{background:#d45959; padding:20px; color:#fff;}
    .btn-custom{    
        border: 1px solid #ccc;
    margin-top: 28px;
    padding: 6px 12px;
    color: #666;
    text-shadow: 0 1px #fff;
    background:#F0F0F0 !important;
    border-radius: 3px 3px;
}
.font-icon i{
fill:#FFFFFF;
}
hr.divider{
   display:none;
}

#mainNav .navbar-nav .nav-item .nav-link:hover, #mainNav .navbar-nav .nav-item .nav-link:active {
  color:#ed1c24;
}
#mainNav .navbar-nav .nav-item .nav-link.active {
  color: #ed1c24 !important;
}

   .header-heading h1{margin:30px 0 10px 0;font-size:48px!important;font-weight:700;line-height:56px;text-transform:uppercase;color:#fff!important}.header-subheading{font-size:24px!important}.about-us img{min-height:300px!important}.custom-btn{font-family:Poppins,sans-serif;text-transform:uppercase;font-weight:500;font-size:16px;letter-spacing:1px;display:inline-block;padding:8px 28px;border-radius:50px;transition:.5s;margin:10px;border:3px solid #fff;color:#fff}.custom-btn:hover{background:#ed1c24;border:2px solid#ed1c24; color:#fff!important}
</style>
@endsection
@section('content')
<!-- Masthead-->
<header class="masthead" id="home">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-10 align-self-end header-heading mt-5">
                <h1 class="text-uppercase text-white font-weight-bold">WE DELIVER ON TIME EVERY TIME</h1>
             
            </div>
            <div class="col-lg-8 align-self-baseline mt-4">
                <p class="header-subheading text-white mb-5">We Deliver On Time, Every Time.</p>
                <a href="#track-parcel" class="btn btn-md custom-btn js-scroll-trigger">TRACK PARCEL</a>
            </div>
            <!-- <div class="col-lg-8">
                
            </div> -->
        </div>
    </div>
</header>


<!-- Home-->
<section class="page-section" id="track-parcel">
    <div class="container">
        <div class="row">

            <div class="col-md-6 font-icon">
                <h2 class="text-muted">Track a Parcel <img src="{{asset('assets/images/landmark.png')}}" alt=""></h2>
                <p class="lead">To get delivery information enter Tracking Number and Postcode</p>

            </div>

            <div class="col-md-6">
                <div class="track-form">
                <form action="{{route('find-shipment')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tracking Number</label>
                        <input type="text" class="form-control" name="tracking_number" aria-describedby="emailHelp"
                             value="BD-" required>
                        
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Postcode</label>
                        <input type="text" class="form-control" name="post_code" placeholder="Enter Postcode" required>
                    </div>
                    @if(Session::has('info'))
                  <span>{{Session::get('info')}}</span>
                  @endif
                    <button type="submit" name="submit" class="btn btn-custom btn-block">Search</button>
                </form>
            </div>
            </div>

        </div>
    </div>
</section>

<!-- About US  -->
<section class="page-section" id="about-us">
    <div class="container">
        <div class="row">

            <div class="col-md-6">
                <h2>Few Words About Us</h2>
                <p class="lead">Our unique 2 man white glove delivery service is second to none. We appreciate the value
                    you have in your customers, and have designed a service that puts your customer’s delivery
                    expectations first. The service we provide is based on the confidence we have in the training of all
                    our “point of contact” staff. Generally, this means we contact the customer to arrange a convenient
                    time, then deliver the product to the correct location in the house, unpack it, clean and install
                    the item*. We then remove the packaging and, if needed, the old product for disposal or recycling.
                    However, the service can be tailored to the needs of you or your business. If you’re looking for
                    specialist white glove service transportation, we are the premier UK provider.
                    <br>
                    <br>
                    * Extra charges apply for premium service
                    <br>
                    * There is a charge 29.99 to deliver to a specific room
                    <br>
                    <strong style="font-size: 25px;">Call Us: 0203 0111 470</strong>
                </p>

            </div>

            <div class="col-md-6 about-us">
                <img class="img-fluid " src="{{asset('assets/images/about-us.png')}}" alt="bed">
            </div>

        </div>
    </div>
</section>
@endsection