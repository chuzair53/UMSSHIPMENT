@extends('layouts.app')

@section('style')


<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css"
  rel="stylesheet" type="text/css">

<style>
  #p_scents {
    border-bottom: 1px solid #F2F2F3;

  }

  #addScnt,
  #remScnt {
    text-decoration: none;
    padding: 5px 25px;
  }

  #remScnt {
    color: #c23f44;
  }

  #addScnt,
  #remScnt:hover {
    cursor: pointer;
  }
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
<!-- <div class="col-md-12">
  @if(Session::has('info'))
  <div class="alert alert-success mt-2 mb-2" role="alert">
    {{Session::get('info')}}
  </div>
  @endif
</div> -->

<!-- modal popup -->
@if(Session::has('info'))


 <script type="text/javascript">
    $(document).ready(function(){
        $("#myModal").modal('show');
    });
</script>




        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" name="submit" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <input type="hidden" name="_token" value="2f7YITknYeqtRAMgr5OnwuMII4QmUeBWo7XZl8wV">

      </div>
      <div class="modal-body text-center mb-2">
     
        <h2 class="text-success"><b>Shipment Created</b></h2>
        <br>
        <p>Tracking Number: &nbsp {{Session::get('info')}}</p>
      
      </div>

    </div>
  </div>
</div>
@endif

<!-- modal popup end -->
<form method="post" action="{{route('store-shipment')}}">
  @csrf
  <input type="hidden" name="shipper_id" value="2">
  <div class="container-fluid">
    <div class="col-md-8 col-lg-8">

      <!-- Shipment number -->


      <div class="input-group mb-2">
        <div class="input-group-prepend">
          <div class="input-group-text">Tracking Number</div>
        </div>
        <input type="text" name="tracking_number" class="form-control" placeholder="" readonly>
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

                <select class="form-control" name="shipper" id="shipper-select"  onchange="shipperFun()">
                  <option value="">-- Select Shipper --</option>
                  @foreach($data as $shipper)
                  <option value="{{$shipper->slug}}">{{$shipper->shipper_name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group col-md-12">
                <label for="Address">First Line Address</label>
                <input type="text" id="shipper_first_address" value="" class="form-control" placeholder="First Address" readonly>
              </div>
              <div class="form-group col-md-12">
                <label for="Address">Second Line Address</label>
                <input type="text" id="shipper_second_address" value="" class="form-control" placeholder="Second Address" readonly>
              </div>
              <div class="form-group col-md-12">
                <label for="Address">Third Line Address</label>
                <input type="text" id="shipper_third_address"  value="" class="form-control" placeholder="Third Address" readonly>
              </div>
              <div class="form-group col-md-12">
                <label for="City">Town City</label>
                <input type="text" id="shipper_town_city" value="" class="form-control" placeholder="Town City" readonly>
              </div>
              <div class="form-group col-md-12">
                <label for="Post Code">Postcode</label>
                <input type="text" id="shipper_post_code" value="" class="form-control" placeholder="Post Code" readonly>
              </div>
              <div class="form-group col-md-12">
                <label for="Phone Number">Phone Number</label>
                <input type="text" id="shipper_phone" value="" class="form-control" placeholder="Phone Number" readonly>
              </div>
              <div class="form-group col-md-12">
                <label for="email">Email</label>
                <input type="email" id="shipper_email" value="" class="form-control" placeholder="Email" readonly>
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
                <input type="text" name="customer_name" class="form-control" placeholder="Customer Name" required="required">
              </div>

              <div class="form-group col-md-12">
                <label for="Address">First Line Address</label>
                <input type="text" name="first_receiver_address" class="form-control" placeholder="First Address">
              </div>
              <div class="form-group col-md-12">
                <label for="Address">Second Line Address</label>
                <input type="text" name="second_receiver_address" class="form-control" placeholder="Second Address">
              </div>
              <div class="form-group col-md-12">
                <label for="Address">Third Line Address</label>
                <input type="text" name="third_receiver_address" class="form-control" placeholder="Third Address">
              </div>
              <div class="form-group col-md-12">
                <label for="City">Town City</label>
                <input type="text" name="town_city" class="form-control" placeholder="Town City">
              </div>
              <div class="form-group col-md-12">
                <label for="Post Code">Postcode</label>
                <input type="text" name="receiver_post_code" class="form-control" placeholder="Post Code">
              </div>
              <div class="form-group col-md-12">
                <label for="Phone Number">Phone Number</label>
                <input type="text" name="receiver_phone" class="form-control" placeholder="Phone Number">
              </div>


              <div class="form-group col-md-12">
                <label for="email">Email</label>
                <input type="email" name="receiver_email" class="form-control" placeholder="Email">
              </div>
            </div>
          </div>
        </div>
      </div>
<div class="row"></div>
      <div class="col-md-3 offset-md-1 col-lg-3">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">History</h6>
          </div>
          <div class="card-body">

            <div class="form-group">
              <label for="Date">Date</label>
              <div class="input-group date">

                <input data-provide="datepicker" name="assign_date" class="form-control"
                  data-date-format="dd/mm/yyyy" />
                <div class="input-group-prepend">
                  <div class="input-group-text"><i class="fa fa-calendar input-prefix" tabindex=0></i></div>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="Time">Time</label>
              <input type="time" name="assign_time" class="form-control" />
            </div>

            <div class="form-group">
              <label for="Location">Location</label>
              <input type="text" name="assign_location" id="address" class="form-control">
            </div>

            <div class="form-group">
              <label for="Status">Status</label>
              <select class="form-control" name="assign_status" id="exampleFormControlSelect1" required="required">
                <option value="Entered-Into-System">-- Select Status --</option>
                <option value="Entered-Into-System">Entered Into System</option>
                <option value="Scanned-At-Depot">Scanned At Depot</option>
                <option value="Out-For-Delivery">Out For Delivery</option>
                <option value="Delivered">Delivered</option>
                <option value="Failed">Failed</option>
                <option value="Returned">Returned</option>
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
       <option value="{{$driver->id}}">{{$driver->name ?? ''}}</option>
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
                <input type="text" name="service" class="form-control" placeholder="Service">
              </div>

              <div class="form-group col-md-6">
                <label for="Service">Order Number</label>
                <input type="text" name="order_number" class="form-control" placeholder="Order Number">
              </div>
            
              <div class="form-group col-md-6">
                <label for="SKU">SKU</label>
                <input type="text" class="form-control" name="sku" placeholder="SKU">
              </div>
              <div class="form-group col-md-6">

                <label for="Upload Date">Upload Date</label>
                <div class="input-group date" id='datetimepicker1'>

                  <input data-provide="datepicker" name="upload_date" class="form-control"
                  data-date-format="dd-mm-yyyy" />
                  <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-calendar input-prefix" tabindex=0></i></div>
                  </div>
                </div>
              </div>

              <div class="form-group col-md-6">
                <label for="Payment">Payment</label>
                <input type="text" class="form-control" name="payment" placeholder="Payment">
              </div>

              <div class="form-group col-md-6">
                <label for="Notes">Notes</label>
                <textarea type="text" class="form-control" name="notes" col="3" rows="3"></textarea>
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
            <div class="form-row">
              <!-- Multiple Form Start -->
              <div id="frm_scents">
                <div class="row" id="p_scents">
                  <div class="form-group col-md-3">
                    <textarea class="form-control custom-width" name="description[]" id="Fld_Name" cols="10" rows="3"
                      placeholder="Product Name"></textarea>
                  </div>
                  <div class="form-group col-md-1">

                    <input type="text" class="form-control" name="qty[]" id="Fld_Alias" placeholder="Qty." />
                  </div>
                  <div class="form-group col-md-2">
                    <select class="form-control" name="piece_type[]" id="Field_Type">
                      <option value="">-- Type --</option>
                      <option value="Pallet">Pallet</option>
                      <option value="Carton">Carton</option>
                      <option value="Crate">Crate</option>
                      <option value="Loose">Loose</option>
                      <option value="Others">Others</option>
                    </select>
                  </div>

                  <div class="form-group col-md-2">
                    <input type="text" class="form-control" name="weight[]" id="Fld_Value" placeholder="Weight (kg)" />
                  </div>
                  <div class="form-group col-md-2">
                    <input type="text" class="form-control" name="package_type[]" id="Fld_Pkg_Val" placeholder="Pieces" />
                  </div>
                 

                </div>
              </div>
              <!-- Multiple Form End -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <center>
      <button class="btn btn-primary btn-lg" type="submit" name="submit"> Add Shipment</button>
    </center>

</form>
@endsection