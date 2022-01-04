@extends('layouts.app')
@section('javascript')
<script>
    $('.custom-file-input').on('change',function(){
  var fileName = document.getElementById("customFile").files[0].name;
  $(this).next('.form-control-file').addClass("selected").html(fileName);
})
</script>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Import') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('shipment-import') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="Excel File"
                                class="col-md-4 col-form-label text-md-right">{{ __('Excel File') }}</label>

                            <div class="col-md-6">
                       
                                    <input type="file" name="file" class="custom-file-input" id="customFile" required>
                                    <label class="custom-file-label custom-file-control form-control-file" for="customFile">Choose file</label>
                              
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Import Shipment') }}
                                </button>
                                <a class="btn btn-primary" href="{{url('/import-csv-update')}}">Import Update</a>
                            </div>
                        </div>

                         <div class="instruction mt-5">
                             <h3>Instructions on how to Import Shipment</h3>
                             <ol>
                                 <li><a href="{{url('download-file')}}"> Download CSV template</a> as template for Importing data.</li>
                                 <li>Delete Column(s) that are not needed, make sure no empty header column this cause data maaping error.</li>
                                 <li>Add Data to each Cell.</li>
                                 <li>Import CSV template.</li>
                             </ol>
                         </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection