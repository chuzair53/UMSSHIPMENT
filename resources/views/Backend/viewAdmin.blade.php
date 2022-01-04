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
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">View Admin
        <a href="{{url('register')}}" class="btn btn-dark btn-sm float-right"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp Create Admin</a>
      </h6>
   
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Username</th>
              <th>Email</th>
              <th>Account Status</th>
              <th>Created At</th>
              <th>Action</th>
             
            </tr>
          </thead>
    <?php $i = 1; ?>
          <tbody>
            @foreach($data as $admin)
            <tr>
              <td>{{$i++}}</td>
              <td>{{$admin->name ?? ''}}</td>
              <td>{{$admin->email ?? ''}}</td>
              <td>{{ucFirst($admin->acc_status ?? '')}}</td>
              <td>{{$admin->created_at->format('d/m/Y') ?? ''}}</td>
              <td> 
                <a href="{{url('edit-admin/' . $admin->id)}}" class="btn btn-dark btn-sm"><i class="fa fa-pencil-square-o fa-sm" aria-hidden="true"></i></a>
                @if(Auth::user()->id != $admin->id)
                <a href="{{url('delete-admin/' . $admin->id)}}" class="btn btn-danger btn-sm"><i class="fa fa-trash-o fa-sm" aria-hidden="true"></i></a>
                @endif
              </td>
             
            </tr> 
            @endforeach  
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
