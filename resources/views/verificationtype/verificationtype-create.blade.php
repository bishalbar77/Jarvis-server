@extends('layouts/contentLayoutMaster')
@section('title', 'Create Verification Type')
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
    #cpyfields button {
        display: none !important;
    }
  </style>
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
            <!-- verificationtype edit account form start -->
            <form novalidate action="{{ url('verificationtype/store') }}" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <div class="controls">
                      <label>Name</label>
                      <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}" required data-validation-required-message="This document Name field is required">
                      @if($errors->has('name'))
                        <p class="text-danger">{{ $errors->first('name') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>Internal Name</label>
                      <input type="text" name="internal_name" class="form-control" placeholder="Internal Name" value="{{ old('internal_name') }}" required data-validation-required-message="This document Name field is required">
                      @if($errors->has('internal_name'))
                        <p class="text-danger">{{ $errors->first('internal_name') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>Amount</label>
                      <input type="text" name="amount" class="form-control" placeholder="Amount" value="{{ old('amount') }}" required data-validation-required-message="This Amount field is required">
                      @if($errors->has('amount'))
                        <p class="text-danger">{{ $errors->first('amount') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>Description</label>
                      <textarea name="description" class="form-control" placeholder="Description"></textarea>
                      @if($errors->has('description'))
                        <p class="text-danger">{{ $errors->first('description') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>Icon</label>
                      <input type="file" name="icon_url" class="form-control" value="{{ old('icon_url') }}">
                      @if($errors->has('icon_url'))
                        <p class="text-danger">{{ $errors->first('icon_url') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>TAT (in working Days)</label>
                      <input type="text" name="tat" class="form-control" placeholder="TAT in Days" value="{{ old('tat') }}" required data-validation-required-message="This document TAT field is required">
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
                          <option value="NID">NID</option>
                          <option value="BGV">BGV</option>
                          <option value="AV">AV</option>
                          <option value="PV_WRITTEN">PV_WRITTEN</option>
                          <option value="PV_VERBAL">PV_VERBAL</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                        <label>Task Type</label>
                        <select name="task_type" class="form-control">
                          <option value="AADHAAR_VERIFICATION">AADHAAR_VERIFICATION</option>
                          <option value="WEB_CHECK">WEB_CHECK</option>
                          <option value="CRC">CRC</option>
                          <option value="AV">AV</option>
                          <option value="PV_WRITTEN">PV_WRITTEN</option>
                          <option value="PV_VERBAL">PV_VERBAL</option>
                        </select>
                      </div>
                    </div>                    
                  </div>
                  <div class="row">
                    <div class="col-12 col-sm-6">                      
                      <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                          <option value="A">Active</option>
                          <option value="I">Deactive</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                        <label>Source</label>
                        <select name="source" class="form-control">
                          <option value="B2B">B2B</option>
                          <option value="B2C">B2C</option>
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

