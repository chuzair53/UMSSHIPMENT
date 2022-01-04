@extends('layouts.app')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

@endsection

@section('javascript')

<script>
  $(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $("#add_field_button"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div id="ct" class="form-group" style="display:inline-flex"><input  class="form-control mt-2" type="file" name="files[]"/><a href="#" class="btn btn-danger btn-md mt-2" id="remove_field"><i class="fa fa-trash-o fa-sm" aria-hidden="true"></i></a> </div>'); // add input boxes.
        }
    });
    
    $(wrapper).on("click","#remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('#ct').remove(); x--;
    })
});
</script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Shipment Status') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('driver-update-shipment') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                         <label for="Customer Name" class="font-style">Customer Name: {{ucFirst($data->customer_name) ?? ''}}</label>
                         <br>
                         <label for="Order Number" class="font-style">Order Number: {{$data->order_number ?? ''}}</label>
                         <hr>
                        </div>
                        <div class="form-group">
                            <label for="Status">Status</label>
                            <select class="form-control" name="update_status" id="exampleFormControlSelect1" required="required">
                              <option value="">-- Select Status --</option>
                              @foreach(['Delivered', 'Failed', 'Returned'] as $item)
                              <option value="{{$item}}"
                           @if($data->status == $item) selected @endif>
                          {{str_replace('-', ' ', $item)}}
                          </option>
                          @endforeach
                             
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Status">Driver Note</label>
                       <textarea class="form-control" name="driver_note" cols="30" rows="10"></textarea>
                        </div>

                        <div class="form-group">
                            <hr>
                            <h5 class="font-style">Attachment</h5>

<!-- Attached -->

  <div class="row">
    <div class="col-md-8">
    <div class="input_fields_wrap">
      <div class="form-group" style="display:inline-flex">
 
      <input class="form-control" type="file" name="files[]">   
 
      <a href="#" class="btn btn-primary btn-md" id="add_field_button"><i class="fa fa-plus fa-sm"></i></a>
  </div>
  </div>
  </div>
  </div>



  
</div>

<!-- Attached End -->
                      
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                              <input type="hidden" name="shipment_id" value="{{$data->id}}">
                                <input type="hidden" name="tracking_number" value="{{$data->tracking_number}}">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-paper-plane"></i> {{ __('Update Shipment') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection