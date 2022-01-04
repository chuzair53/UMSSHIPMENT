@extends('layouts.app')

@section('style')


<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css"
  rel="stylesheet" type="text/css">

<style>
 #p_scents{border-bottom:1px solid #f2f2f3}#edit_secnts{border-bottom:1px solid #f2f2f3}#addScnt,#remScnt{text-decoration:none;padding:5px 25px}#remScnt{color:#c23f44}#addScnt,#remScnt:hover{cursor:pointer}

  /* Toggle */
 .tgl{position:relative;outline:0;display:inline-block;cursor:pointer;user-select:none;margin:0 0 5px 0}.tgl,.tgl *,.tgl :after,.tgl :before,.tgl+.tgl-btn,.tgl:after,.tgl:before{box-sizing:border-box}.tgl ::selection,.tgl :after::selection,.tgl :before::selection,.tgl+.tgl-btn::selection,.tgl::selection,.tgl:after::selection,.tgl:before::selection{background:0 0}.tgl span{position:relative;display:block;height:1.8em;line-height:1.2em;overflow:hidden;font-weight:400;text-align:center;border-radius:2em;padding:.2em 1em;border:1px solid #fafafa;box-shadow:inset 0 2px 0 rgba(0,0,0,.2),0 2px 0 rgba(255,255,255,.7);transition:color .3s ease,padding .3s ease-in-out,background .3s ease-in-out}.tgl span:before{position:relative;display:block;line-height:1.3em;padding:0 .2em;font-size:1em}.tgl span:after{position:absolute;display:block;content:'';border-radius:2em;width:1.3em;height:1.3em;margin-left:-1.45em;top:.2em;background:#fff;transition:left .3s cubic-bezier(.175,.885,.32,.97),background .3s ease-in-out}.tgl input[type=checkbox]{display:none!important}.tgl input[type=checkbox]:not(:checked)+span{background:#de474e;color:#fff;padding-left:1.6em;padding-right:.4em}.tgl input[type=checkbox]:not(:checked)+span:before{content:attr(data-off);color:#fff}.tgl input[type=checkbox]:not(:checked)+span:after{background:#fff;left:1.6em}.tgl input[type=checkbox]:checked+span{background:#86d993;color:#fff;padding-left:.4em;padding-right:1.6em}.tgl input[type=checkbox]:checked+span:before{content:attr(data-on)}.tgl input[type=checkbox]:checked+span:after{background:#fff;left:100%}.tgl input[type=checkbox]:disabled,.tgl input[type=checkbox]:disabled+span,.tgl input[type=checkbox]:read-only,.tgl input[type=checkbox]:read-only+span{cursor:not-allowed}.tgl-gray input[type=checkbox]:not(:checked)+span{background:#e3e3e3;color:#999}.tgl-gray input[type=checkbox]:not(:checked)+span:before{color:#999}.tgl-gray input[type=checkbox]:not(:checked)+span:after{background:#fff}.tgl-inline{display:inline-block!important;vertical-align:top}.tgl-inline.tgl{font-size:16px}.tgl-inline.tgl span{min-width:50px}.tgl-inline.tgl span:before{line-height:1.4em;padding-left:.4em;padding-right:.4em}.tgl-inline-label{display:inline-block!important;vertical-align:top;line-height:26px}
</style>
@endsection
@section('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
<script src="{{asset('assets/js/apiscript.js')}}"></script>

<script>
  var scntDiv = $("#frm_scents");
  var i = $("#p_scents").length + 1;

  $(function () {
    $("#addScnt").click(function () {
      $(
        '<div class="row mt-4" id="p_scents"><div class="form-group col-md-3"><textarea name="description[]" cols="10" rows="3" class="form-control custom-width " id="Fld_Value(' +
        i +
        ')" placeholder="Product Name"></textarea></div><div class="form-group col-md-1"><input type="text" name="qty[]" class="form-control tx-sm" id="Fld_Alias(' +
        i +
        ')" placeholder="Qty." /></div><div class="form-group col-md-2"><select class="form-control" name="piece_type[]" id="Field_Type(' +
        i +
        ')"><option value="">-- Type --</option><option value="Pallet">Pallet </option><option value="Carton">Carton </option><option value="Crate">Crate </option><option value="Loose">Loose</option><option value="Others">Others</option></select></div><div class="form-group col-md-2"><input name="weight[]" type="text" class="form-control" id="Fld_Dflt_Val(' +
        i +
        ')" placeholder="Weight (Kg)" /></div><div class="form-group col-md-2"><input name="package_type[]" type="text" class="form-control" id="Fld_Pkg_Val(' +
        i +
        ')" placeholder="Pieces" /></div><div class="form-group col-md-2" id="remScnt" onclick="removeCont(this);"><div class="btn btn-danger btn-sm pl-2 pr-2"><i class="fa fa-minus-circle" aria-hidden="true"></i> Remove</div></div>'
      ).appendTo(scntDiv);
      i++;
      return false;
    });
  });

  function removeCont(_this) {
    if (i > 1) {
      $(_this).parent().remove();
      i--;
    }
  }

</script>

@endsection
@section('content')
<div class="col-md-12">
  @if(Session::has('info'))
  <div class="alert alert-success mt-2 mb-2" role="alert">
    {{Session::get('info')}}
  </div>
  @endif
</div>
<form method="post" action="{{route('update-shipment')}}">
  @csrf
 
  <input type="hidden" name="slug" value="{{$response->slug}}">
  <div class="container-fluid">
    <div class="col-md-8 col-lg-8">

      <!-- Shipment number -->


      <div class="input-group mb-2">
        <div class="input-group-prepend">
          <div class="input-group-text">Tracking Number <small>*</small></div>
        </div>
        <input type="text" name="tracking_number" value="{{$response->tracking_number}}" class="form-control" placeholder="" disabled>
      </div>

    </div>
    <div class="row">
      <!-- start card -->
      <div class="col-md-4 col-lg-4">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Shipper Information</h6>
          </div>
          <div class="card-body">
            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="exampleFormControlSelect1">Shipper Name</label>

                <select class="form-control" name="shipper" id="shipper-select" onchange="shipperFun()">
                  <option value="{{$response->shipper->slug ?? ''}}">{{$response->shipper->shipper_name ?? ''}}</option>
                  @foreach($shippers as $shipper)
                  <option value="{{$shipper->slug}}">{{$shipper->shipper_name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group col-md-12">
                <label for="Address">First Line Address</label>
                <input type="text" id="shipper_first_address" value="{{$response->shipper->first_shipper_address ?? ''}}" class="form-control" placeholder="First Address" readonly>
              </div>
              <div class="form-group col-md-12">
                <label for="Address">Second Line Address</label>
                <input type="text" id="shipper_second_address" value="{{$response->shipper->second_shipper_address ?? ''}}" class="form-control" placeholder="Second Address" readonly>
              </div>
              <div class="form-group col-md-12">
                <label for="Address">Third Line Address</label>
                <input type="text" id="shipper_third_address" value="{{$response->shipper->third_shipper_address ?? ''}}" class="form-control" placeholder="Third Address" readonly>
              </div>
              <div class="form-group col-md-12">
                <label for="City">Town City</label>
                <input type="text" id="shipper_town_city" value="{{$response->shipper->town_city ?? ''}}" class="form-control" placeholder="Town City" readonly>
              </div>
              <div class="form-group col-md-12">
                <label for="Post Code">Postcode</label>
                <input type="text" id="shipper_post_code" value="{{$response->shipper->post_code ?? ''}}"  class="form-control" placeholder="Post Code" readonly>
              </div>
              <div class="form-group col-md-12">
                <label for="Phone Number">Phone Number</label>
                <input type="text" id="shipper_phone" value="{{$response->shipper->phone ?? ''}}" class="form-control" placeholder="Phone Number" readonly>
              </div>
              <div class="form-group col-md-12">
                <label for="email">Email</label>
                <input type="email" id="shipper_email" value="{{$response->shipper->email ?? ''}}" class="form-control" placeholder="Email" readonly>
              </div>
            </div>

          </div>
        </div>
      </div>
      <!-- end card -->
      <div class="col-md-4 col-lg-4">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Customer Information</h6>
          </div>
          <div class="card-body">
            <div class="form-row">

              <div class="form-group col-md-12">
                <label for="Receiver Name">Customer Name</label>
                <input type="text" name="customer_name" value="{{$response->customer_name ?? ''}}" class="form-control" placeholder="Customer Name">
              </div>

              <div class="form-group col-md-12">
                <label for="Address">First Line Address</label>
                <input type="text" name="first_receiver_address" value="{{$response->first_receiver_address ?? ''}}" class="form-control" placeholder="First Address">
              </div>
              <div class="form-group col-md-12">
                <label for="Address">Second Line Address</label>
                <input type="text"  name="second_receiver_address" value="{{$response->second_receiver_address ?? ''}}" class="form-control" placeholder="Second Address">
              </div>
              <div class="form-group col-md-12">
                <label for="Address">Third Line Address</label>
                <input type="text" name="third_receiver_address" value="{{$response->third_receiver_address ?? ''}}" class="form-control" placeholder="Third Address">
              </div>
              <div class="form-group col-md-12">
                <label for="City">Town City</label>
                <input type="text" class="form-control" name="town_city" value="{{$response->town_city ?? ''}}" placeholder="Town City">
              </div>
              <div class="form-group col-md-12">
                <label for="Post Code">Postcode</label>
                <input type="text" name="post_code" value="{{$response->post_code ?? ''}}" class="form-control" placeholder="Post Code">
              </div>
              <div class="form-group col-md-12">
                <label for="Phone Number">Phone Number</label>
                <input type="text" name="phone" value="{{$response->phone ?? ''}}" class="form-control" placeholder="Phone Number">
              </div>


              <div class="form-group col-md-12">
                <label for="email">Email</label>
                <input type="email" name="email" value="{{$response->email ?? ''}}" class="form-control" placeholder="Email">
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-3 offset-md-1 col-lg-3">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">History <span class="text-dark float-right" style="text-transform: uppercase; font-weight: bold !important;">{{str_replace('-', ' ', $response->status) ?? ''}}</span></h6>
          </div>
          <div class="card-body">

            <div class="form-group">
              <label for="Date">Date</label>
              <div class="input-group date">

                <input data-provide="datepicker" value="{{$response->assign_date ?? ''}}" name="assign_date" class="form-control"
                  data-date-format="dd/mm/yyyy" />
                <div class="input-group-prepend">
                  <div class="input-group-text"><i class="fa fa-calendar input-prefix" tabindex=0></i></div>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="Time">Time</label>
              <input type="time" name="assign_time" value="{{$response->assign_time ?? ''}}" class="form-control" />
            </div>

            <div class="form-group">
              <label for="Location">Location</label>
              <input type="text" name="location" value="{{$response->location ?? ''}}" class="form-control">
            </div>

            <div class="form-group">
              <label for="Status">Status</label>
              <select class="form-control" name="status" id="exampleFormControlSelect1">

                @foreach(['Entered-Into-System', 'Scanned-At-Depot', 'Out-For-Delivery', 'Delivered', 'Failed', 'Returned'] as $item)
                <option value="{{$item}}"
             @if($response->status == $item) selected @endif>
            {{str_replace('-', ' ', $item)}}
            </option>
               @endforeach
            
              </select>
            </div>

          </div>
        </div>
   <!-- Assign Shipment To -->
   <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Assign Shipment To</h6>
    </div>
    
    <div class="card-body">
      <div class="form-group">
        <label for="Status">Select Driver</label>
        <select class="form-control" name="assign_driver" id="exampleFormControlSelect1" required="required">
          <option value="">-- Select Driver --</option>
          @foreach($drivers as $driver)
          @if($response->driver != '' && $response->driver->driver_id == $driver->id)
           <option value="{{$driver->id}}" selected="selected">{{$driver->name ?? ''}}</option>
           @else
           <option value="{{$driver->id}}">{{$driver->name ?? ''}}</option>
           @endif
          @endforeach
        </select>
      </div>
    </div>
    </div>
        <!-- Assign Shipment End -->
      </div>
    </div>
    <!-- Shipment Information -->
    <div class="row">
      <div class="col-md-8 col-lg-8">

        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Shipment Information</h6>
          </div>
          <div class="card-body">
            <div class="form-row">

              <div class="form-group col-md-6">
                <label for="Service">Service</label>
                <input type="text" name="service" value="{{$response->service ?? ''}}" class="form-control" placeholder="Service">
              </div>
              <div class="form-group col-md-6">
                <label for="Service">Order Number</label>
                <input type="text" name="order_number" value="{{$response->order_number ?? ''}}" class="form-control" placeholder="Order Number">
              </div>
              <div class="form-group col-md-6">
                <label for="SKU">SKU</label>
                <input type="text" class="form-control" name="sku" value="{{$response->sku ?? ''}}" placeholder="SKU">
              </div>
              <div class="form-group col-md-6">

                <label for="Upload Date">Upload Date</label>
                <div class="input-group date" id='datetimepicker1'>

                  <input data-provide="datepicker" name="upload_date" value="{{$response->upload_date ?? ''}}" class="form-control"
                    data-date-format="dd/mm/yyyy" />
                  <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-calendar input-prefix" tabindex=0></i></div>
                  </div>
                </div>
              </div>

              <div class="form-group col-md-6">
                <label for="Payment">Payment</label>
                <input type="text" class="form-control" name="payment" value="{{$response->payment ?? ''}}" placeholder="Payment">
              </div>

              <div class="form-group col-md-6">
                <label for="Notes">Notes</label>
                <textarea type="text" class="form-control" name="notes" col="3" rows="3">{{$response->notes ?? ''}}</textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

 <div class="row">
      <div class="col-md-8">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Packages</h6>
          </div>
          <div class="card-body">
<!-- Previous Packages -->

<div class="form-row mt-5">

    <div class="row" id="edit_secnts">
      <div class="form-group col-md-3">
        <textarea class="form-control custom-width" name="edit_description[]" cols="10" rows="3"
          placeholder="Product Name">{{$response->package->description}}</textarea>
      </div>
      <div class="form-group col-md-1">

        <input type="text" class="form-control" name="edit_qty[]" value="{{$response->package->qty}}"  placeholder="Qty." />
      </div>
      <div class="form-group col-md-2">
        <select class="form-control" name="edit_package_type[]" >
          @foreach(['Pallet', 'Carton', 'Crate', 'Loose', 'Others'] as $item)
          <option value="{{$item}}"
           @if($response->package->package_type == $item) selected @endif>
            {{$item}}
          </option>
          @endforeach

        </select>
      </div>

      <div class="form-group col-md-2">
        <input type="text" class="form-control" value="{{$response->package->weight}}" name="edit_weight[]"  placeholder="Weight (kg)" />
      </div>
      <div class="form-group col-md-2">
        <input type="text" class="form-control" value="{{$response->package->piece_type }}" name="edit_piece_type[]"  placeholder="Pieces" />
      </div>
      <div>
        <input type="hidden" name="package_slug[]" value="{{$response->package->package_slug}}">
      </div>
      <div class="form-group col-md-2">
        <!-- <div class="btn btn-dark btn-sm ml-2"><i class="fa fa-plus" aria-hidden="true"></i> Select Delete
        </div> -->
       
      </div>

    </div>


</div>    

<!-- Previous Packages End-->
          </div>
        </div>
      </div>
    </div>


    <!-- History Records -->

    <div class="row">
      <div class="col-md-8">


        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Update History </h6>
          </div>
          <div class="card-body">
            @if($response->history != '')
            @foreach($response->history as $history)
            <div class="form-row">
            <!-- Update History -->
            <div class="form-group col-md-2">
              <label for="Date">Date</label>
              <div class="input-group date">

                <input data-provide="datepicker" value="{{$history->history_date ?? ''}}" name="history_date[]" class="form-control"
                  data-date-format="dd/mm/yyyy" />
                <div class="input-group-prepend">
                  <div class="input-group-text"><i class="fa fa-calendar input-prefix" tabindex=0></i></div>
                </div>
              </div>
            </div>

            <div class="form-group col-md-2">
              <label for="Time">Time</label>
              <input type="time" name="history_time[]" value="{{$history->history_time ?? ''}}" class="form-control" />
            </div>

            <div class="form-group col-md-2">
              <label for="Location">Location</label>
              <input type="text" name="history_location[]" value="{{$history->history_location ?? ''}}" class="form-control">
            </div>

            <div class="form-group col-md-2">
              <label for="Status">Status</label> 
              <select class="form-control" name="history_status[]"  id="exampleFormControlSelect1">
                @foreach(['Entered-Into-System', 'Scanned-At-Depot', 'Out-For-Delivery', 'Delivered', 'Failed', 'Returned'] as $item)
                <option value="{{$item}}"
             @if($history->history_status == $item) selected @endif>
            {{str_replace('-', ' ', $item)}}
            </option>
               @endforeach
               
              </select>
            </div>
            <div>
            <input type="hidden" name="history_slug[]" value="{{$history->history_slug}}">
          </div>
            <div class="form-group col-md-1" style="margin-top: 32px;">
              <label class="tgl" style="font-size:18px">  
                <input type="checkbox" name="history_delete[]" value="{{$history->history_slug}}" />
                <span data-on="Delete" data-off="Active"></span>
              </label>
            </div>
            <!-- End -->

            </div>
            @endforeach
            @endif
          </div>
        </div>
      </div>
    </div>

    <!-- History Records end -->
    <center>
      <button class="btn btn-primary btn-md" type="submit" name="submit">Update Shipment</button>
    </center>

</form>
@endsection