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
} );
</script>
@endsection
@section('content')
<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Shipment List</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        
 
       
     
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
              <th>Delivery Note</th>
              <th>Upload Date</th>
              <th>Action</th>
            </tr>
          </thead>
        
          <tbody class="list">
            <?php  $i = 1; ?>
            @foreach($response as $shipments)
            @foreach($shipments->shipment as $data)
          
            <tr>
              <td> <input class="form-control custom-checkbox" type="checkbox" name="slug_selector[]" value="{{$data->slug}}" id="check"></td>
              <td class="text-primary custom-link-tracking"><a href="{{url('view-shipment/' . $data->slug)}}">{{$data->tracking_number ?? ''}}</a></td>
              <td>{{$data->shipper->shipper_name ?? ''}}</td>
              <td class="custom-link-tracking"><a href="{{url('view-shipment/' . $data->slug)}}">{{$data->customer_name ?? ''}}</a></td>
              <td>{{$data->post_code}}</td>
              <td class="custom-link text-primary"><a href="{{url('/driver/edit-shipment-status/' . $data->slug)}}">{{str_replace('-', ' ', $data->status) ?? ''}}</a></td>
              <td>{{$data->order_number ?? ''}}</td>
              <td>
                <a href="{{url('delivery-note/' . $data->slug)}}" class="btn btn-primary btn-sm"> <i class="fa fa-download" aria-hidden="true"></i> Download</a>
              </td>
            
              <td>{{$data->upload_date ??''}}</td>
              <td>
                <a href="{{url('view-shipment/'. $data->slug)}}" class="btn btn-primary btn-sm mb-sm-1 mb-md-0"><i class="fa fa-eye fa-sm" aria-hidden="true"></i></a>
                <a href="{{url('/driver/edit-shipment-status/' . $data->slug)}}" class="btn btn-primary btn-sm mb-sm-1 mb-md-0"><i class="fa fa-pencil-square-o fa-sm" aria-hidden="true"></i></a>
                
           
              </td>
            </tr>
           @endforeach
           @endforeach
          </tbody>
        </table>
      
       
       
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
        <h5 class="modal-title" id="exampleModalLabel">Shipment Type</h5>
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

@endsection
