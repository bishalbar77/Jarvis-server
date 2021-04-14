@extends('layouts/contentLayoutMaster')
@section('title', 'Create User')
@section('vendor-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
@endsection
@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/plugins/forms/validation/form-validation.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/pages/app-user.css')) }}">
  <style type="text/css">
    .hide {
      display: none;
    }
    .show {
      display: initial;
    }
  </style>
@endsection

@section('content')
<!-- users edit start -->
<section class="users-edit">
  <div class="card">
    <div class="card-content">
      <div class="card-body">
        <div class="tab-content">
          <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
            <!-- users edit account form start -->
            <form novalidate action="{{ url('b2b/store') }}" method="post">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-12 col-sm-5">
                  
                  <div class="form-group">
                    <label>Employer</label>
                    <select name="employer_id" class="form-control" required="">
                      <option value="">Select Employer</option>
                      @foreach($employers as $employer)
                        <option value="{{ $employer->id }}">{{ $employer->b2b_company_name }}</option>
                       @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Existing Employee</label>
                    <select name="employee_id" id="employee_id" class="select2 form-control">
                      <option value="">Select User</option>
                      @if($users)
                        @foreach($users as $user)
                          <option data-email="{{ $user->email }}" value="{{ $user->id }}">{{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }}</option>
                        @endforeach
                      @endif
                      <option value="new">New</option>
                    </select>
                  </div>

                  <div class="form-group show_hide hide">
                    <label>Employee Types</label>
                    <select name="employee_type_id" id="employee_type_id" class="form-control">
                      <option>Select Employee Type</option>
                      @if($employeetypes)
                        @foreach($employeetypes as $employeetype)
                          <option value="{{ $employeetype->id }}">{{ $employeetype->type }}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>

                  <div class="form-group show_hide hide">
                    <div class="controls">
                      <label>First Name</label>
                      <input type="text" name="first_name" class="form-control" placeholder="First Name" value="{{ old('first_name') }}">
                      @if($errors->has('first_name'))
                        <p class="text-danger">{{ $errors->first('first_name') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-group show_hide hide">
                    <div class="controls">
                      <label>Middle Name</label>
                      <input type="text" name="middle_name" class="form-control" placeholder="Middle Name" value="{{ old('middle_name') }}">
                      @if($errors->has('middle_name'))
                        <p class="text-danger">{{ $errors->first('middle_name') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-group show_hide hide">
                    <div class="controls">
                      <label>Last Name</label>
                      <input type="text" name="last_name" class="form-control" placeholder="Last Name" value="{{ old('last_name') }}">
                      @if($errors->has('last_name'))
                        <p class="text-danger">{{ $errors->first('last_name') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>E-mail</label>
                      <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required data-validation-required-message="This email field is required">
                      @if($errors->has('email'))
                        <p class="text-danger">{{ $errors->first('email') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-group show_hide hide">
                    <label>Country Code</label>
                    <select name="country_code" id="country_code" class="form-control">
                      <option value="91" Selected>India (+91)</option>
                      <option value="44">UK (+44)</option>
                      <option value="1">USA (+1)</option>
                    </select>
                    @if($errors->has('country_code'))
                      <p class="text-danger">{{ $errors->first('country_code') }}</p>
                    @endif
                  </div>
                  <div class="form-group show_hide hide">
                    <div class="controls">
                      <label>Mobile</label>
                      <input type="text" name="mobile" class="form-control" placeholder="Mobile" value="{{ old('mobile') }}">
                      @if($errors->has('mobile'))
                        <p class="text-danger">{{ $errors->first('mobile') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-group show_hide hide">
                    <label>Gender</label>
                    <select name="gender" class="form-control">
                      <option value="M">Male</option>
                      <option value="F">Female</option>
                    </select>
                  </div>
                  <!-- Email input-->
                  <div class="form-group">
                    <div class="controls">
                      <label>Password</label>
                      <input name="password" type="password" placeholder="Passowrd" class="form-control" value="{{ old('password') }}" required>
                      @if($errors->has('password'))
                        <p class="text-danger">{{ $errors->first('password') }}</p>
                      @endif
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                      <option value="A">Active</option>
                      <option value="I">Deactive</option>
                    </select>
                  </div>

                  <div class="row">
                    <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                      <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save Changes</button>
                      <button type="reset" class="btn btn-outline-warning">Reset</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
            <!-- users edit account form ends -->
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- users edit ends -->
@endsection

@section('vendor-script')
  {{-- Vendor js files --}}
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/validation/jqBootstrapValidation.js')) }}"></script>
@endsection

@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset(mix('js/scripts/pages/app-user.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/navs/navs.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/forms/select/form-select2.js')) }}"></script>
  <script type="text/javascript">

    var first_name = $('#first_name').val();
    if(first_name != '' && name === 'undefined'){
     $('.show_hide').removeClass('hide'); 
    }

    $('#employee_id').on('change', function(){
      if($(this).val() == 'new'){
        $('.show_hide').removeClass('hide');
        $('#email').val('');
        $('.show_hide input').attr('required', 'required');
      } else {
        $('#email').val($(this).find(':selected').data('email'));
        $('.show_hide').addClass('hide');
      }
    })
  </script>
@endsection

