@extends('layouts.app')

@section('style')
<style>
   .shipment-header{
       background:#4143E5;
       color:#fff;
       padding-top: 7px;
       padding-bottom:1px; 
       margin-bottom: 20px;   
   }
   .shipment-header span{
       text-transform: uppercase;
   }
   .text-custom-title{
       color:#4143E5;
     font-weight:bold;
     font-size:25px;
   }
   .custom-style h5{
       color:#000;
       font-weight: bold;
       /* border-bottom:2px solid #ABABAB; */
       margin-top: 20px;
   }
  .custom-detail h5{
     color:#000;
       /* font-weight: bold; */
       font-size:18px;
     
  }
   .thead-custom{
       color:#fff;
       background-color: #4143E5;
    border-color: #0239DD;
   }
   .custom-detail li{
     list-style: none;
     /* font-size:20px; */
   }
   .custom-bold{
    color:#000;
       font-weight: bold;
       font-size:20px;
   }
   .custom-tracking-color{
       color:#000 !important;
   }
   .custom-color{
       color:#000 !important;
   }
   .custom-bold{
     font-weight:bold;
   }
   .custom-icon img{
     height:120px;
   }

   .button-view{
  /* z-index: 5; */
  position: relative;
  /* top: 20px;
  right: 30px; */
  cursor: pointer;
 border-radius: 10px;
 padding:10px;
}

.menu-container {
  /* z-index:1;
  position:fixed; */
  height: 100%;
  width: 100%;
  background: #E94444;
 }
</style>
@endsection
@section('javascript')

<script src="{{asset('assets/js/custom.js')}}"></script>
<script>
  $(document).ready(function() {
  $('#show-hidden-menu').click(function() {
    $('.hidden-menu').slideToggle("slow");
    // Alternative animation for example
    // slideToggle("fast");
  });
});
</script>
@endsection
@section('content')
<div class="container">
 
    <center>
      <div class="shipment-header">
        <h2>Shipment Details</h2>
      </div>
        <div class="text-custom-title">
          <span class="custom-tracking-color">TRACKING NUMBER:</span>
          {{$data->order_number ?? ''}}
      
        </div>
  
    <div class="row mt-2">
      
        <div class="col-md-12 col-lg-12 custom-color custom-icon">  
          
            <div class="">Status<br> <span class="custom-bold">{{ str_replace('-', ' ', $data->status) ?? ''}}</span>
              <!-- <h5>Image Icon</h5> -->
              <br>
            <img src="{{asset('assets/images/Icons/' . $data->status . '.png')}}" alt="">
            </div>
          </div>
        
    </div>
    <hr>
    
  </center>

<div class="row mt-5">
<div class="col-md-6">

  <ul class="custom-detail custom-bold">
    <h5>Shipper Details</h5>
    <li> {{$data->shipper->shipper_name ?? ''}}</li>
    <li> {{$data->shipper->first_shipper_address ?? ''}}</li>
    <li> {{$data->shipper->second_shipper_address ?? ''}}</li>
    <li> {{$data->shipper->third_shipper_address ?? ''}}</li>
    <li> {{$data->shipper->town_city ?? ''}}</li>
    <li> {{$data->shipper->post_code ?? ''}}</li>
    <li> {{$data->shipper->phone ?? ''}}</li>
    <li> {{$data->shipper->email ?? ''}}</li>
  </ul>
</div>
<div class="col-md-6">

  <ul class="custom-detail custom-bold">
    <h5>Customer Details</h5>
    <li> {{$data->customer_name ?? ''}}</li>
    <li> {{$data->first_receiver_address ?? ''}}</li>
    <li> {{$data->second_receiver_address ?? ''}}</li>
    <li> {{$data->third_receiver_address ?? ''}}</li>
    <li> {{$data->town_city ?? ''}}</li>
    <li> {{$data->post_code ?? ''}}</li>
    <li> {{$data->phone ?? ''}}</li>
    <li> {{$data->email ?? ''}}</li>
  </ul>
</div>
  
<!-- <div class="col-md-6">
  <ul class="custom-detail">
    <li>Order Number: {{$data->order_number ?? ''}}</li>
    <li>Service: {{$data->service ?? ''}}</li>
    <li>SKU: {{$data->sku ?? ''}}</li>
    <li>Booking Date: {{$data->upload_date  ?? ''}}</li>
    <li>Payment: {{$data->payment ?? ''}}</li>
  </ul>
</div> -->
</div>


 
  <center>
  <div id="show-hidden-menu" class=" btn btn-primary btn-sm button-view">
    <h5>View More Details <i class="fa fa-caret-down"></i></h5>
  </div>
</center>
<div class="hidden-menu" style="display: none;">
<div class="col-md-12 custom-style">
<h5>SHIPMENT HISTORY</h5>
<hr>

<table class="table">
    <thead class="thead-custom">
      <tr>
        <th scope="col">Date</th>
        <th scope="col">Time</th>
        <th scope="col">Location</th>
        <th scope="col">Status</th>
      </tr>
    </thead>
    <tbody>
        @foreach($data->history as $record)
      
      <tr>
        <td>{{$record->history_date ?? ''}}</td>
        <td>{{$record->history_time ?? ''}}</td>
        @if($record->history_status == 'Entered-Into-System')
        <td>Dewsbury, UK</td>
        @elseif($record->history_status == 'Delivered')
        <td>{{$data->post_code ?? ''}}, UK</td>
        @elseif($record->history_status == 'Out-For-Delivery')
        <td>{{$data->town_city ?? ''}}, UK</td>
        @elseif($record->history_status == 'Scanned-At-Depot')
        <td>{{$data->shipper->town_city ?? ''}}, UK</td>
        @elseif($record->history_status == 'Failed')
        <td>{{$data->post_code ?? ''}}, UK</td>
        @elseif($record->history_status == 'Returned')
        <td>{{$data->post_code ?? ''}}, UK</td>
        @else
        <td>{{$record->history_location ?? ''}}, UK</td>
        @endif
        <td>{{str_replace('-', ' ', $record->history_status)  ?? ''}}</td>
      </tr>
      @endforeach
     
    </tbody>
  </table>


</div>

<!-- Packages -->

<div class="col-md-12 custom-style">
    <h5>PACKAGES</h5>
    <hr>
    
    <table class="table">
        <thead class="thead-custom">
          <tr>
            <th scope="col">Qty.</th>
            <th scope="col">Product Name</th>
            <th scope="col">Type</th>
            <th scope="col">Weight (kg)</th>
            <th scope="col">Pieces</th>
            
          </tr>
        </thead>
        <tbody>
           
          <tr>
            <td>{{$data->package->qty ?? ''}}</td>
           
     @if($data->package != '')
             @php

$array =  explode('+', $data->package->description);
echo "<td>";
foreach ($array as $item) {

    if ($item != '') {
     
    echo "$item<br>";

    }else{
        echo " No Package Exist";
    }
    
}
echo "</td>";
@endphp
@else
<td></td>
@endif
            <td>{{$data->package->package_type ?? ''}}</td>
            <td>{{$data->package->weight ?? ''}}</td>
            <td>{{$data->package->piece_type ?? ''}}</td>
           
          </tr>
      
        </tbody>
      </table>
      <center>
        @if($data->package != '')
    <h5>Total Actual Weight : {{$data->package->sum('weight') .'Kg.'}}</h5>
    @endif
</center>
    </div>

<!-- Driver -->
@if(Auth::user())
@if(Auth::user()->user_type == "driver" || Auth::user()->user_type == "")
<div class="col-md-12 custom-style">
  <h5>DRIVER ATTACHMENT</h5>
  <hr>


  <table class="table">
    <thead class="thead-custom">
      <tr>
        <th scope="col">No</th>
        <th scope="col">File Name</th>
        <th scope="col">Action</th>
  
        
      </tr>
    </thead>
    @if($data->driver != '')
@if($data->driver->driverInfo != '')
      <?php $i=1; ?>
      @foreach($data->driver->driverInfo->attachment as $file)
      <tbody>
      <td>{{$i++}} </td>
      <td>{{$file->file_name}}</td>
      <td> <a href="{{url('driver/attachment-download/' . $file->slug)}}" class="btn btn-primary btn-sm">Download <i class="fa fa-arrow-down" aria-hidden="true"></i></a> </td>
    </tbody>
       @endforeach
@endif
@endif
      </table>
      <hr>
      <table class="table">
        <thead class="thead-custom">
          <tr>
            <th scope="col">DRIVER NOTE</th>
        
      
            
          </tr>
        </thead>
        <tbody>
         <td>{{$data->driver->driverInfo->notes ?? ''}}</td>
          
        </tbody>
        </table>
      <!-- <h5>DRIVER NOTE</h5>
      <p></p> -->
  </div>
  @endif
<!-- Driver end -->
@endif
  </div>


</div>


@endsection
