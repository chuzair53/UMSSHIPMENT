<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Delivery Note</title>

   <style>
      table{
        height:auto;
        width: 680px; 
    }
      th, td{
       text-align: left !important;
       border: 1px solid #000 !important; 
       border-collapse:collapse !important; 
       padding: 5px; 
}


.logo {
    height: auto;
    width: auto;
    float: right;
}
.navbar-brand {
    font-weight: 800 !important;
    font-family: Arial, Helvetica, sans-serif;
    display: inline-block;
    padding-top: 0.3125rem;
    padding-bottom: 0.3125rem;
    margin-right: 1rem;
    font-size: 2.25rem;
    line-height: inherit;
    white-space: nowrap;
    text-decoration: none;
    color: #000;
}

.custom-detail li {
    list-style: none;
}
.list-type {
    display: inline-block;
}
.custom-border hr{
width:100%;
  
     }
.custom-address h4, li{
  font-size:14px;
     }
     .custom-font-size{
       font-size:14px;
     }
     
     .navbar-brand{
            font-weight: 800 !important;
            font-family: Arial, Helvetica, sans-serif;
            
        }
        .brand-style{
            color:#ED1C24 !important;
        }
     
</style>
</head>
<body>
  <div class="logo">
     <a class="navbar-brand" href="{{ url('/') }}">
                  
                    UMS<span class="brand-style"> Shipment</span>
                </a>
   </div>
  <ul class="custom-detail">
    <h3>DELIVERY NOTE</h3>
    <li>Date: {{$data->upload_date ?? ''}}</li>
    <li>Order Number: {{$data->order_number ?? ''}}</li>
    <li>Tracking Number: {{$data->tracking_number ?? ''}}</li> 
    <li>Shipper Name: {{$data->shipper->shipper_name ?? ''}}</li> 
    <li>Service: {{$data->service ?? ''}}</li>
  
  </ul>

  <center>
  <ul class="custom-detail custom-address">
    <h4>Delivery Address</h4>
    <li>{{$data->customer_name ?? ''}}</li>
    <li>{{$data->first_receiver_address ?? ''}}</li>
    <li>{{$data->second_receiver_address ?? ''}}</li>
    <li>{{$data->third_receiver_address ?? ''}}</li>
    <li>{{$data->town_city ?? ''}}</li> 
    <li>{{$data->post_code ?? ''}}</li> 
    <li>{{$data->phone ?? ''}}</li>
    <li>{{$data->email ?? ''}}</li>
  
  </ul>
  </center>
  <br>
<table class="custom-table custom-font-size" > 
        <tr> 
            <th colspan="1" style="width: 2%;">Qty</th>
            <th colspan="3" style="width: 80%;">Description</th>
            <th colspan="1" style="width: 10%;">Loaded</th>
            <th colspan="1" style="width: 10%;">Delivered</th>
          
        </tr> 

        <tr> 
           <td>{{$package->qty ?? ''}}</td>
                   @php

$array =  explode('+', $data->package->description);
echo "<td colspan='3'>";
foreach ($array as $item) {

    if ($item != '') {
     
    echo "$item";
    echo "<span class='custom-border'>
          <br>
          <hr>
        
          </span>";

    }else{
        echo " No Package Exist";
    }

}
echo "</td>";
@endphp
           <td></td>
           <td></td>
        </tr> 
     

           <tr> 
           
          <td></td>
          <td colspan="3"></td>
           <th colspan="6" style="width: 5%;">Payment: {{$data->payment ?? ''}}</th>
         
        </tr>
         <tr style="text-align:left;"> 
           <th colspan="6">SKU: {{$data->sku ?? ''}}</th>

        </tr>

        <tr style="text-align:left;"> 
          <th colspan="2">Pieces: {{$data->package->piece_type ?? ''}}</th>
           
           
          <th colspan="2">Weight(kg): {{$data->package->weight ?? ''}}</th>
          <th colspan="2">Type: {{$data->package->package_type ?? ''}} </th>
        </tr>
      
      <tr style="text-align:left;"> 
           <th colspan="6" rowspan="5">Notes: {{$data->notes ?? ''}}</th>
        </tr>
    </table> 
  <br>
  <div class="custom-font-size">
  <strong>I have checked and inspected all items delivered & confirm that I have received all items in perfect
    condition. No items are damaged nor visible marks of damage. I agree that once signed I have no
    rights to make any claims</strong>
    <br>
    <br>
    <br>
   <strong>Customer Signature ________________________</strong>
   <br>
   <br>
   <br>
   <strong>Delivery Date & Time _______________________</strong>
   <br>
   <br>
   <br>
   <strong>Instructions:</strong> Call Customer 30 minutes before making delivery
   <br>
   <br>
   <center>
   <strong class="text-bold">Thank you for your custom </strong>
  </center>
  </div>
</body>
</html>
