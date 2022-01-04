@extends('layouts.app')
@section('stylesheet')
<style>
    .meter-text {
	 display: flex;
	 width: 70%;
	 justify-content: space-between;
	 margin: 1rem 0 0.1rem 0;
	 color: rgba(17, 17, 17, .6);
	 text-transform: capitalize;
}
.meter-text .meter-status {
	 text-transform: capitalize;
}
 .meter {
	 display: block;
	 width: 70%;
	 height: 10px;
	 border-radius: 3px;
	 background: rgba(17, 17, 17, .1);
	 overflow: hidden;
}
.meter .meter-bar {
	 display: block;
	 width: 0;
	 height: 100%;
	 transition: width 0.4s ease-in-out, transform 0.4s ease-in-out;
}
/* .input-password {
	 border-radius: 3px;
	 border: 1px solid rgba(17, 17, 17, .2);
	 height: 20px;
	 font-size: 1.1rem;
	 padding: 0.7rem 1rem;
	 outline: none;
	 transition: border 0.4s ease-in-out;
} */
.form-inline{
    display: flex;
    flex-direction:column;
    width:100%;
    overflow: hidden;
}
</style>
@endsection
@section('javascript')
<script>

$( document ).ready(function() {
    console.log( "ready!" );

    $(function() {
  $.fn.bootstrapPasswordMeter = function(options) {
    var settings = $.extend({
      minPasswordLength: 6,
      level0ClassName: 'progress-bar-danger',
      level0Description: 'Weak',
      level1ClassName: 'progress-bar-danger',
      level1Description: 'Not great',
      level2ClassName: 'progress-bar-warning',
      level2Description: 'Better',
      level3ClassName: 'progress-bar-success',
      level3Description: 'Strong',
      level4ClassName: 'progress-bar-success',
      level4Description: 'Very strong',
      parentContainerClass: '.form-group'
    }, options || {});

    $(this).on("keyup", function() {
      var progressBar = $(this).closest(settings.parentContainerClass).find('.progress-bar');
      var progressBarWidth = 0;
      var progressBarDescription = '';
      if ($(this).val().length >= settings.minPasswordLength) {
        var zxcvbnObj = zxcvbn($(this).val());
        progressBar.removeClass(settings.level0ClassName)
          .removeClass(settings.level1ClassName)
          .removeClass(settings.level2ClassName)
          .removeClass(settings.level3ClassName)
          .removeClass(settings.level4ClassName);
        switch (zxcvbnObj.score) {
          case 0:
            progressBarWidth = 25;
            progressBar.addClass(settings.level0ClassName);
            progressBarDescription = settings.level0Description;
            break;
          case 1:
            progressBarWidth = 25;
            progressBar.addClass(settings.level1ClassName);
            progressBarDescription = settings.level1Description;
            break;
          case 2:
            progressBarWidth = 50;
            progressBar.addClass(settings.level2ClassName);
            progressBarDescription = settings.level2Description;
            break;
          case 3:
            progressBarWidth = 75;
            progressBar.addClass(settings.level3ClassName);
            progressBarDescription = settings.level3Description;
            break;
          case 4:
            progressBarWidth = 100;
            progressBar.addClass(settings.level4ClassName);
            progressBarDescription = settings.level4Description;
            break;
        }
      } else {
        progressBarWidth = 0;
        progressBarDescription = '';
      }
      progressBar.css('width', progressBarWidth + '%');
      progressBar.text(progressBarDescription);
    });
  };
  $('#exampleInputPassword1').bootstrapPasswordMeter({minPasswordLength:3});
});


});

</script>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Driver') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('update-driver') }}">
                        @csrf
                        <input type="hidden" name="user_type" value="driver">
                        <input type="hidden" name="user_id" value="{{$data->id}}">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Driver Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $data->name  }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $data->email ?? ''}}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $data->phone ?? ''}}" required autocomplete="phone">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        
                        <div class="form-group row">
                          <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                          <div class="col-md-6">
                              <input id="exampleInputPassword1" type="password" class="input-password form-control @error('password') is-invalid @enderror" name="password">

                              @error('password')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                            
                          </div>
                      </div>
                        
                        <div class="form-group row">
                           
                            <label for="exampleFormControlSelect1" class="col-md-4 col-form-label text-md-right">Account Status</label>
                            <div class="col-md-6">
                            <select class="form-control" name="acc_status" id="exampleFormControlSelect1">
                              <option value="">Select Status</option>
                              @foreach(['active', 'disable'] as $item)
                              <option value="{{$item}}"
                           @if($data->acc_status == $item) selected @endif>
                            {{ucFirst($item)}}
                          </option>
                          @endforeach
                              <!-- <option value="active">Active</option>
                              <option value="disable">Disable</option> -->

                            </select>
                            </div>
                          </div>
                     
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update Driver') }}
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
