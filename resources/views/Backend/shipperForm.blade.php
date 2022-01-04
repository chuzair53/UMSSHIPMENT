@extends('layouts.app')

@section('style')

@endsection
@section('javascript')

@endsection
@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">   
          
          @if(Session::has('info'))
<div class="alert alert-success mt-2 mb-2" role="alert">
  {{Session::get('info')}}
</div>
@endif
                    <form method="POST" action="{{ route('store-shipper') }}">
                        @csrf

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                              <h6 class="m-0 font-weight-bold text-primary">Shipper Information</h6>
                            </div>
                            <div class="card-body">
                              <div class="form-row">
                                  <div class="form-group col-md-12">
                                    <label for="Shipper Name">Shipper Name</label>
                                    <input type="text" name="shipper_name" class="form-control" placeholder="Shipper Name" required>
                                  </div>
                                    <div class="form-group col-md-12">
                                      <label for="Address">First Line Address</label>
                                      <input type="text" name="first_shipper_address" class="form-control" placeholder="First Address" required>
                                    </div>
                                    <div class="form-group col-md-12">
                                      <label for="Address">Second Line Address</label>
                                      <input type="text" name="second_shipper_address" class="form-control" placeholder="Second Address">
                                    </div>
                                    <div class="form-group col-md-12">
                                      <label for="Address">Third Line Address</label>
                                      <input type="text" name="third_shipper_address" class="form-control" placeholder="Third Address">
                                    </div>
                                    <div class="form-group col-md-12">
                                      <label for="City">Town City</label>
                                      <input type="text" class="form-control" placeholder="Town City">
                                    </div>
                                    <div class="form-group col-md-12">
                                      <label for="Post Code">Post Code</label>
                                      <input type="text" name="shipper_post_code" class="form-control"placeholder="Postcode" required>
                                    </div>
                                    <div class="form-group col-md-12">
                                      <label for="Phone Number">Phone Number</label>
                                      <input type="text" name="shipper_phone" class="form-control" placeholder="Phone Number" required>
                                    </div>
                                  
                                    <div class="form-group col-md-12">
                                      <label for="email">Email</label>
                                      <input type="email" name="shipper_email" class="form-control" placeholder="Email">
                                    </div>
                              </div>
                              
                            </div>
                          </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                            
                                <button type="submit" name="submit" class="btn btn-primary">
                                    {{ __('Create Shipper') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
           
        </div>
    </div>
</div>
@endsection