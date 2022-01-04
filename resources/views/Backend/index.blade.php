@extends('layouts.app')

@section('style')
<style>
 .table td{
   padding:0.30rem;
   vertical-align: middle;
 }
 
  .custom-link:hover{
    cursor: pointer;
  }
  .custom-link-tracking a{
    text-decoration: none;
  }
  .custom-link-customer a{
    color: #858796 !important;
    text-decoration: none;
  }
  .custom-link-customer a:hover{
    cursor: pointer;
  }
  .custom-checkbox{
  font-size:1px;
  }
  .custom-checkbox:hover{
   border:none; 
  }
  .custom-checkbox:active{
   border:none; 
  }
  .custom-btn{
    background: #02C851;
    color:white;
  }
  .btn-status{
    background:#AA66CB;
    color:white;
  }
  .bulk-btn{
    background:#33B5E5 ;
    color: white;
  }
</style>
@endsection
@section('javascript')

<script src="{{asset('assets/js/custom.js')}}"></script>

<script>
$(document).ready(function() {
$('#all').click(function () {
  
  $('.form-control').prop('checked', !$('.form-control').prop('checked'));
 
});

});
</script>
<script>

$(document).ready(function() {
    $('#datatable').DataTable({
      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
    });
});
</script>


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
    <div class="modal-body text-center">
      <i class="fa fa-exclamation-triangle fa-2x"></i>
      <h4 class="text-danger"><b>Please Select Shipment</b></h4>
      <br>

    </div>

  </div>
</div>
</div>
@endif
@endsection
@section('content')

<div class="container-fluid">


  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Shipment List</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        
        <form action="{{route('bulk-data')}}" method="post">
              @csrf
              <button class="btn btn-primary btn-md float-right" type="submit" value="bulk_status_update" name="bulk_status_update">Bulk Update</button>
              <div class="form-group col-md-2 float-right">
         
                <select class="form-control" name="update_status">
                 <option>-- Select -- </option>
                  <option value="Entered-Into-System">Entered Into System</option>
                  <option value="Scanned-At-Depot">Scanned At Depot</option>
                  <option value="Out-For-Delivery">Out For Delivery</option>
                  <option value="Delivered">Delivered</option>
                  <option value="Failed">Failed</option>
                  <option value="Returned">Returned</option>
                </select>
              </div>
          <a href="#" class="btn btn-primary btn-sm float-left mb-2 mr-2" id="all" >Bulk Select</a>
          <button class="btn btn-primary btn-sm float-left mb-2 mr-2" type="submit" value="bulk_select" name="bulk_print">Bulk Print</button>
          <a href="#" class="btn btn-status btn-sm ml-2" data-toggle="modal" data-target="#driverModal">Bulk Driver</a>
          <a href="{{url('export-csv')}}" class="btn custom-btn btn-sm float-left mb-2" id="all" >Export CSV</a>
          
        <button class="btn btn-danger btn-sm float-left mb-2 ml-2" type="submit" value="bulk_delete" name="bulk_delete">Bulk Delete</button>
       
     
        <table id="datatable" class="table table-bordered" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th></th>
              <th>Tracking Number</th>
              <th>Shipper Name</th>
              <th>Customer Name</th>
              <th>Postcode</th>
              <th>Status</th>
              <th>Order Number</th>
              <th>Driver</th>
              <th>Delivery Note</th>
              <th>Created By</th>
              <th>Upload Date</th>
              <th>Action</th>
            </tr>
          </thead>
        
          <tbody class="list">
            <?php  $i = 1; ?>
            @foreach($response as $data)
          
            <tr>
              <td> <input class="form-control custom-checkbox" type="checkbox" name="slug_selector[]" value="{{$data->slug}}" id="check"></td>
              <td class="text-primary custom-link-tracking"><a href="{{url('view-shipment/' . $data->slug)}}">{{$data->tracking_number ?? ''}}</a></td>
              <td>{{$data->shipper->shipper_name ?? ''}}</td>
              <td class="custom-link-tracking"><a href="{{url('view-shipment/' . $data->slug)}}">{{$data->customer_name ?? ''}}</a></td>
              <td>{{$data->post_code}}</td>
              <td class="custom-link text-primary" data-toggle="modal" data-target="#exampleModal">{{str_replace('-', ' ', $data->status) ?? ''}}</td>
              <td>{{$data->order_number ?? ''}}</td>
              <td class="custom-link text-primary" data-toggle="modal" data-target="#driverM">{{$data->driver->user->name ?? ''}}</td>
              <td>
                <a href="{{url('delivery-note/' . $data->slug)}}" class="btn btn-primary btn-sm"> <i class="fa fa-download" aria-hidden="true"></i> Download</a>
              </td>
              <td>{{$data->user->name ?? ''}}</td>
              <td>{{$data->upload_date ??''}}</td>
              <td>
                <a href="{{url('view-shipment/'. $data->slug)}}" class="btn btn-primary btn-sm mb-sm-1 mb-md-0"><i class="fa fa-eye fa-sm" aria-hidden="true"></i></a>
                <a href="{{url('edit-shipment/' . $data->slug)}}" class="btn btn-primary btn-sm mb-sm-1 mb-md-0"><i class="fa fa-pencil-square-o fa-sm" aria-hidden="true"></i></a>
                <a href="{{url('delete-shipment/' . $data->slug)}}" class="btn btn-danger btn-sm"><i class="fa fa-trash-o fa-sm" aria-hidden="true"></i></a>
           
              </td>
            </tr>
           @endforeach
          </tbody>
        </table>
      <!-- Bulk Driver update Form-->

      <div class="modal fade" id="driverModal" tabindex="-1" role="dialog" aria-labelledby="driverModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="driverModalLabel">Select Driver Status</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
               
                <select class="form-control" name="assign_driver">
                 <option>--Select Driver--</option>
                 @foreach($drivers as $driver)
                  <option value="{{$driver->id}}">{{ucFirst($driver->name) ?? ''}}</option>
                  @endforeach
            
                
                </select>
              </div>
            </div>
            <div class="modal-footer">
            
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" name="bulk_driver_update" value="bulk_driver_update" class="btn btn-primary">Update Status</button>
            </div>
          </div>
        </div>
      </div>

      <!-- bulk Driver update form end -->
          </form>
      
       
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<form action="{{route('status-update')}}" method="post">
  @csrf
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Shipment Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
         
          <select class="form-control" name="update_status">
           <option  id="statusSelect"></option>
            <option value="Entered-Into-System">Entered Into System</option>
            <option value="Scanned-At-Depot">Scanned At Depot</option>
            <option value="Out-For-Delivery">Out For Delivery</option>
            <option value="Delivered">Delivered</option>
            <option value="Failed">Failed</option>
            <option value="Returned">Returned</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" id="trackingNumber" name="tracking_number" value="">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-primary">Update Status</button>
      </div>
    </div>
  </div>
</div>
</form>

<!-- Driver Modal -->

<!-- Modal -->
<form action="{{route('update-assign-driver')}}" method="post">
  @csrf
<div class="modal fade" id="driverM" tabindex="-1" role="dialog" aria-labelledby="driverMLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="driverMLabel">Select Driver</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
         
          <select class="form-control" name="driver_id">
           <option  id="driverSelect"></option>
           @foreach($drivers as $driver)
           <option value="{{$driver->id}}">{{ucFirst($driver->name) ?? ''}}</option>
           @endforeach       
    
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" id="shipment_id" name="shipment_id" value="">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="driver_update" value="driver-update" class="btn btn-primary">Update Status</button>
      </div>
    </div>
  </div>
</div>
</form>
@endsection
