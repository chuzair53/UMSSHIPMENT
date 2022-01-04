@extends('layouts.master')

@section('style')
<style>
    .track-form{
        background:#4547EA; padding:20px; color:#fff;
        border-radius: 10px;
    }
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
  color:#4143e5;
}
#mainNav .navbar-nav .nav-item .nav-link.active {
  color: #E66F7B !important;
}

   /* .header-heading h1{margin:30px 0 10px 0;font-size:48px!important;font-weight:700;line-height:56px;text-transform:uppercase;color:#fff!important}.header-subheading{font-size:24px!important}.about-us img{min-height:300px!important} */

/* New Style */
.custom-btn{
    font-family:Poppins,sans-serif;
    text-transform:uppercase;
    font-weight:500;
    font-size:24px;
    letter-spacing:1px;
    display:inline-block;
    padding:8px 28px;
    border-radius:50px;
    transition:.5s;
    margin:10px;
    border:3px solid #fff;
    color:#fff;
    background:#4143e5;
}

.custom-btn:hover{
    background:#E66F7B;
   
    color:#fff!important;
    transition: 0.6s;

}

.bg-cover img{
    height: auto;
    width: auto;
    background-position:center;
    background-repeat:no-repeat;
    background-attachment:scroll;
    background-size:cover;
    margin-top:40px;
}
@media only screen and (max-width: 600px) {
    .bg-cover img{
    height: auto;
    width: auto;
    background-position:center;
    background-repeat:no-repeat;
    background-attachment:scroll;
    background-size:cover;
    margin-top:40px;
}
.mb-custom{
    margin-top: 160px;
  
}
}
.header-head{
color:#4143E5;
}
.header-head h2{
    font-size:72px;
}
.header-head span{
    font-size:30px;
}
.header-head p{
    font-size:25px;
}

.slash {
    width: 50%;
    border-bottom:3px solid #4143E5;
   
    
}
.text-color {
    color:#4143E5;
}
.text-size h2{
    font-size:62px;
}
.text-size p{
    font-size:20px;
}
</style>
@endsection
@section('content')
<!-- Masthead class="masthead"-->
<header id="home" style="margin-top: 145px;">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-1"></div>
            <div class="col-md-5 mb-custom">
<div class="header-head">
               <h2>UMS Couriers</h2>
               <span>Delivery Service</span>
               <div class="slash"></div>
              <br>
              <br>
             
               <p>Delivered to your door hassle free.</p>
              
            </div>
            <a href="#track-parcel" class="btn btn-md custom-btn js-scroll-trigger">TRACK PARCEL</a>
            </div>

            <div class="col-md-6">
        
                <div class="bg-cover">
                    <img class="img-fluid" src="{{asset('assets/images/smart-cover.jpg')}}" alt="img">
                </div>
 
                 
             </div>
      
         
        </div>
    </div>
</header>


<!-- Home-->
<section class="page-section" id="track-parcel">
    <div class="container-fluid">
        <div class="row align-items-center">
<div class="col-md-1"></div>
            <div class="col-md-6 font-icon">
                <div class="bg-cover">
                    <img class="img-fluid" src="{{asset('assets/images/tracking.jpg')}}" alt="">
                </div>
                <!-- <p class="lead">To get delivery information enter Tracking Number and Postcode</p> -->

            </div>

            <div class="col-md-4">
                <div class="text-center text-color text-size">
                <h2>Track a Parcel </h2>
                <p>To get delivery information enter Tracking Number and Postcode</p>
            </div>
                <div class="track-form">
                <form action="{{route('find-shipment')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tracking Number</label>
                        <input type="text" class="form-control" name="tracking_number" aria-describedby="emailHelp"
                              required placeholder="SC-">
                        
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
    <div class="container-fluid">
        <div class="row align-items-center">
<div class="col-md-1"></div>
            <div class="col-md-5">
            <div class="text-color text-size">
                <h2>Few Words About Us</h2>
                <p class="lead">Here at UMS Couriers we take pride in our work, our hassle-free service is bespoke to every customer need. We try our hardest to make sure the customer receives 100% satisfaction. Generally, this means we contact the customer to arrange a convenient time, then deliver the product to the correct location in the house. However, the service can be tailored to the needs of you or your business. If you are looking for specialist white glove service transportation, we are the premier shipment provider.

                    <br>
                    <br>
                    * Extra charges apply for a premium service
                    <br>
                    * A fee to deliver to a specific area
                    <br>
                    <strong style="font-size: 25px;">Call Us: +9212313233</strong>
                </p>
            </div>
            </div>

            <div class="col-md-6 about-us">
                <img class="img-fluid " src="{{asset('assets/images/about-us.jpg')}}" alt="bed">
            </div>

        </div>
    </div>
</section>
@endsection