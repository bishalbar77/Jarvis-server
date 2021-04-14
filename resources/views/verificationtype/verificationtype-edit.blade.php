@extends('layouts/contentLayoutMaster')
@section('title', 'Edit Verification Type')
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
<!-- verificationtype edit start -->
<section class="users-edit">
  <div class="card">
    <div class="card-content">
      <div class="card-body">
        <ul class="nav nav-tabs mb-3" role="tablist">
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center active" id="account-tab" data-toggle="tab" href="#account"
              aria-controls="account" role="tab" aria-selected="true">
              <i class="feather icon-user mr-25"></i><span class="d-none d-sm-block">Verification type</span>
            </a>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
            <!-- users edit media object start -->
            <div class="media mb-2">
              <a class="mr-2 my-25" href="#">
                @if($verificationtype->icon_url)
                  <img src="{{ $verificationtype->icon_url }}" alt="users avatar" class="users-avatar-shadow rounded" height="64" width="64">
                @else
                  <img src="{{ asset('images/portrait/small/avatar-s-12.jpg') }}" alt="users avatar" class="users-avatar-shadow rounded" height="64" width="64">
                @endif
              </a>
              <div class="media-body mt-50">
                <h4 class="media-heading">{{ $verificationtype->name }}</h4>
                <h5 class="media-heading" style="color: #7367f0;">₹ {{ $verificationtype->amount }}</h5>
              </div>
            </div>
            <!-- users edit media object ends -->
            <!-- verificationtype edit account form start -->
            <form novalidate action="{{ url('verificationtype/update/'.$verificationtype->id) }}" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-12 col-sm-5">
                  <div class="form-group">
                    <div class="controls">
                      <label>Verification type Name</label>
                      <input type="text" name="name" class="form-control" placeholder="Verification type Name" value="{{ $verificationtype->name }}" required data-validation-required-message="This verification type Name field is required">
                      @if($errors->has('name'))
                        <p class="text-danger">{{ $errors->first('name') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>Internal Name</label>
                      <input type="text" name="internal_name" class="form-control" placeholder="Internal Name" value="{{ $verificationtype->internal_name }}" required data-validation-required-message="This document Name field is required">
                      @if($errors->has('internal_name'))
                        <p class="text-danger">{{ $errors->first('internal_name') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>Amount</label>
                      <input type="text" name="amount" class="form-control" placeholder="Verification type Name" value="{{ $verificationtype->amount }}" required data-validation-required-message="This verification type Name field is required">
                      @if($errors->has('amount'))
                        <p class="text-danger">{{ $errors->first('amount') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>Description</label>
                      <textarea name="description" class="form-control" placeholder="Verification Description">{{ $verificationtype->description }}</textarea>
                      @if($errors->has('description'))
                        <p class="text-danger">{{ $errors->first('description') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>Icon</label>
                      <input type="file" name="icon" class="form-control" value="{{ old('icon') }}">
                      @if($errors->has('icon'))
                        <p class="text-danger">{{ $errors->first('icon') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>TAT (in working Days)</label>
                      <input type="text" name="tat" class="form-control" placeholder="TAT in Days" value="{{ $verificationtype->tat }}" required data-validation-required-message="This document TAT field is required">
                      @if($errors->has('tat'))
                        <p class="text-danger">{{ $errors->first('tat') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                        <label>Order Type</label>
                        <select name="order_type" class="form-control">
                          <option {{ $verificationtype->order_type == 'NID' ? 'selected' : '' }} value="NID">NID</option>
                          <option {{ $verificationtype->order_type == 'BGV' ? 'selected' : '' }} value="BGV">BGV</option>
                          <option {{ $verificationtype->order_type == 'AV' ? 'selected' : '' }} value="AV">AV</option>
                          <option {{ $verificationtype->order_type == 'PV_WRITTEN' ? 'selected' : '' }} value="PV_WRITTEN">PV_WRITTEN</option>
                          <option {{ $verificationtype->order_type == 'PV_VERBAL' ? 'selected' : '' }} value="PV_VERBAL">PV_VERBAL</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                        <label>Task Type</label>
                        <select name="task_type" class="form-control">
                          <option {{ $verificationtype->task_type == 'AADHAAR_VERIFICATION' ? 'selected' : '' }} value="AADHAAR_VERIFICATION">AADHAAR_VERIFICATION</option>
                          <option {{ $verificationtype->task_type == 'WEB_CHECK' ? 'selected' : '' }} value="WEB_CHECK">WEB_CHECK</option>
                          <option {{ $verificationtype->task_type == 'CRC' ? 'selected' : '' }} value="CRC">CRC</option>
                          <option {{ $verificationtype->task_type == 'AV' ? 'selected' : '' }} value="AV">AV</option>
                          <option {{ $verificationtype->task_type == 'PV_WRITTEN' ? 'selected' : '' }} value="PV_WRITTEN">PV_WRITTEN</option>
                          <option {{ $verificationtype->task_type == 'PV_VERBAL' ? 'selected' : '' }} value="PV_VERBAL">PV_VERBAL</option>
                        </select>
                      </div>
                    </div>                    
                  </div>
                  <div class="row">
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                          <option {{ $verificationtype->status == 'A' ? 'selected' : '' }} value="A">Active</option>
                          <option {{ $verificationtype->status == 'I' ? 'selected' : '' }} value="I">Deactive</option>
                        </select>
                      </div>
                      </div>
                      <div class="col-12 col-sm-6">
                      <div class="form-group">
                        <label>Source</label>
                        <select name="source" class="form-control">
                          <option {{ $verificationtype->source == 'B2B' ? 'selected' : '' }} value="B2B">B2B</option>
                          <option {{ $verificationtype->source == 'B2C' ? 'selected' : '' }} value="B2C">B2C</option>
                        </select>
                      </div>
                    </div>
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
            <!-- verificationtype edit account form ends -->
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- verificationtype edit ends -->
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

