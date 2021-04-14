@extends('layouts/contentLayoutMaster')
@section('title', 'Edit Employer')
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
<!-- employers edit start -->
<section class="employers-edit">
  <div class="card">
    <div class="card-content">
      <div class="card-body">
        <div class="tab-content">
          <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
          	<!-- users edit media object start -->
            <div class="media mb-2">
              <a class="mr-2 my-25" href="#">
              	@if($employers->photo)
              		<img src="{{ $employers->photo }}" alt="users avatar" class="users-avatar-shadow rounded" height="64" width="64">
              	@else
                	<img src="{{ asset('images/portrait/small/avatar-s-12.jpg') }}" alt="users avatar" class="users-avatar-shadow rounded" height="64" width="64">
                @endif
              </a>
              <div class="media-body mt-50">
                <h4 class="media-heading">{{ $employers->rep_full_name }}</h4>
                <h5 class="media-heading" style="color: #7367f0;">{{ $employers->company_name }}</h5>
              </div>
            </div>
            <!-- users edit media object ends -->
            <!-- employers edit account form start -->
            <form novalidate action="{{ url('/employers/update/'.$employers->id) }}" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-12 col-sm-5">
                  <div class="form-group">
                    <div class="controls">
                      <label>Name</label>
                      <input type="text" name="rep_full_name" class="form-control" placeholder="Full Name" value="{{ $employers->rep_full_name }}" required data-validation-required-message="This full name field is required">
                      @if($errors->has('rep_full_name'))
                        <p class="text-danger">{{ $errors->first('rep_full_name') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>E-mail</label>
                      <input type="email" name="email" class="form-control" placeholder="Email" value="{{ $employers->email }}" required data-validation-required-message="This email field is required">
                      @if($errors->has('email'))
                        <p class="text-danger">{{ $errors->first('email') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>Address</label>
                      <textarea name="address" class="form-control" placeholder="Address" required data-validation-required-message="This email field is required">{{ $employers->address }}</textarea>
                      @if($errors->has('address'))
                        <p class="text-danger">{{ $errors->first('address') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>Company Name</label>
                      <input type="text" name="company_name" class="form-control" placeholder="Company Name" value="{{ $employers->company_name }}" required data-validation-required-message="This company name field is required">
                      @if($errors->has('company_name'))
                        <p class="text-danger">{{ $errors->first('company_name') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>Company Logo</label>
                      <input type="file" name="photo" class="form-control" value="{{ old('photo') }}">
                      @if($errors->has('photo'))
                        <p class="text-danger">{{ $errors->first('photo') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>Phone</label>
                      <input type="text" name="phone" class="form-control" placeholder="Phone" value="{{ $employers->phone }}" required data-validation-required-message="This phone field is required">
                      @if($errors->has('phone'))
                        <p class="text-danger">{{ $errors->first('phone') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                      <option {{ $employers->status === '1' ? 'selected' : '' }} value="1">Active</option>
                      <option {{ $employers->status === '0' ? 'selected' : '' }} value="0">Deactive</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Source</label>
                    <select name="source" class="form-control">
                      <option {{ $employers->source == 'B' ? 'selected' : '' }} value="B">B2B</option>
                      <option {{ $employers->source == 'C' ? 'selected' : '' }} value="C">B2C</option>
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
            <!-- employers edit account form ends -->
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- employers edit ends -->
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

