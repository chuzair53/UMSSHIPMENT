@extends('layouts.app')

@section('javascript')
<script>

$(document).ready(function() {
  $('#dataTable').DataTable();
});
</script>
@endsection
@section('content')
<div class="container-fluid">

  <!-- <form action="{{url('search-shipper')}}" method="Post">
    @csrf
  <div class="row">
  
      <div class="form-group col-md-2">
      <select name="find_by" class="form-control">
        <option value="">-- Find By --</option>
        <option value="shipper_name">Shipper Name</option>
        <option value="email">Email</option>
        <option value="phone">Phone</option>
    
      </select>
    </div>

    <div class="form-group col-md-3">
      <input type="text" name="find_value" class="form-control" placeholder="Search">
    </div>

    <div class="form-group col-md-3">
      <button type="submit" name="submit" class="btn btn-dark">Search</button>
    </div>
    </div>
  </form>
   -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">View Shipper <a href="{{url('create-shipper')}}" class="btn btn-dark btn-sm float-right"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp Create Shipper</a></h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Shipper Name</th>
              <th>Email</th>
              <th>Phone Number</th>
              <th>Created At</th>
              <th>Action</th>
             
            </tr>
          </thead>
        <?php $i=1; ?>
          <tbody>
            @if($data->count() != '0')
            @foreach($data as $rec)
            <tr>
              <td>{{$i++}}</td>
              <td>{{$rec->shipper_name ?? ''}}</td>
              <td>{{$rec->email ?? ''}}</td>
              <td>{{$rec->phone ?? ''}}</td>
              <td>{{$rec->created_at->format('d/m/Y')}}</td>
              <td>
                <a href="{{url('edit-shipper/' . $rec->slug)}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o fa-sm" aria-hidden="true"></i></a>
                <a href="{{url('delete-shipper/' . $rec->slug)}}" class="btn btn-danger btn-sm"><i class="fa fa-trash-o fa-sm" aria-hidden="true"></i></a>
              </td>
             
            </tr>   
            @endforeach
            @else
            <tr>
              <td>No Record Exist.</td>
            </tr>
            @endif
          </tbody>
        </table>
         @if($data->count() != '0')
               {{ $data->links() }}
            @endif
      </div>
    </div>
  </div>
</div>
@endsection
