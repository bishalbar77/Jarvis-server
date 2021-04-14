@extends('layouts/contentLayoutMaster')
@section('title', 'Edit User')
@section('vendor-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
@endsection
@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/plugins/forms/validation/form-validation.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/pages/app-user.css')) }}">
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
            <form novalidate action="{{ url('/users/update/'.$users->id) }}" method="post">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-12 col-sm-5">
                  <div class="form-group">
                    <div class="controls">
                      <label>First Name</label>
                      <input type="text" name="first_name" class="form-control" placeholder="First Name" value="{{ $users->first_name }}" required data-validation-required-message="This first_name field is required">
                      @if($errors->has('first_name'))
                        <p class="text-danger">{{ $errors->first('first_name') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>Middle Name</label>
                      <input type="text" name="middle_name" class="form-control" placeholder="Middle Name" value="{{ $users->middle_name }}" />
                      @if($errors->has('middle_name')) 
                        <p class="text-danger">{{ $errors->first('middle_name') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>Last Name</label>
                      <input type="text" name="last_name" class="form-control" placeholder="Last Name" value="{{ $users->last_name }}" required data-validation-required-message="This last_name field is required">
                      @if($errors->has('last_name'))
                        <p class="text-danger">{{ $errors->first('last_name') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>E-mail</label>
                      <input type="email" name="email" class="form-control" placeholder="Email" value="{{ $users->email }}" required data-validation-required-message="This email field is required">
                      @if($errors->has('email'))
                        <p class="text-danger">{{ $errors->first('email') }}</p>
                      @endif
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label>Country Code</label>
                    <select name="country_code" id="country_code" class="form-control">
                      <option {{ $users->country_code == '91' ? 'selected' : '' }} value="91" Selected>India (+91)</option>
                      <option {{ $users->country_code == '44' ? 'selected' : '' }} value="44">UK (+44)</option>
                      <option {{ $users->country_code == '1' ? 'selected' : '' }} value="1">USA (+1)</option>
                    </select>
                    @if($errors->has('country_code'))
                      <p class="text-danger">{{ $errors->first('country_code') }}</p>
                    @endif
                  </div>

                  <div class="form-group">
                    <div class="controls">
                      <label>Mobile</label>
                      <input type="text" name="mobile" class="form-control" placeholder="Mobile" value="{{ $users->mobile }}" required data-validation-required-message="This mobile field is required">
                      @if($errors->has('mobile'))
                        <p class="text-danger">{{ $errors->first('mobile') }}</p>
                      @endif
                    </div>
                  </div>
                  <!-- Email input-->
                  <div class="form-group">
                    <div class="controls">
                      <label>Password</label>
                      <input name="password" type="password" placeholder="Passowrd" class="form-control" value="{{ old('password') }}">
                      @if($errors->has('password'))
                        <p class="text-danger">{{ $errors->first('password') }}</p>
                      @endif
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                      <option {{ $users->status == 'A' ? 'selected' : '' }} value="A">Active</option>
                      <option {{ $users->status == 'I' ? 'selected' : '' }} value="I">Deactive</option>
                    </select>
                  </div>
                  
                  <div class="form-group">
                    <label>Role</label>
                    <select name="roles" class="form-control">
                      @if($roles)
                        @foreach($roles as $role)
                          <option {{ $users->roles()->pluck('name')->implode(' ') == $role->name ? 'selected' : '' }} value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                      @endif
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
  <script src="{{ asset(mix('vendors/js/forms/validation/jqBootstrapValidation.js')) }}"></script>
@endsection

@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset(mix('js/scripts/pages/app-user.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/navs/navs.js')) }}"></script>
@endsection

