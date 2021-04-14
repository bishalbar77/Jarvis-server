@extends('layouts/contentLayoutMaster')
@section('title', 'Edit Employee Type')
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
<!-- employeetype edit start -->
<section class="users-edit">
  <div class="card">
    <div class="card-content">
      <div class="card-body">
        <ul class="nav nav-tabs mb-3" role="tablist">
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center active" id="account-tab" data-toggle="tab" href="#account"
              aria-controls="account" role="tab" aria-selected="true">
              <i class="feather icon-user mr-25"></i><span class="d-none d-sm-block">Employee type</span>
            </a>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
            <!-- employeetype edit account form start -->
            <form novalidate action="{{ url('employeetype/update/'.$employeetype->id) }}" method="post">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-12 col-sm-5">
                  <div class="form-group">
                    <div class="controls">
                      <label>Employee type Name</label>
                      <input type="text" name="type" class="form-control" placeholder="Employee type Name" value="{{ $employeetype->type }}" required data-validation-required-message="This document Name field is required">
                      @if($errors->has('type'))
                        <p class="text-danger">{{ $errors->first('type') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>Description</label>
                      <textarea name="description" class="form-control" placeholder="Description" required data-validation-required-message="This Description field is required">{{ $employeetype->type }}</textarea>
                      @if($errors->has('description'))
                        <p class="text-danger">{{ $errors->first('description') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                      <option {{ $employeetype->status == 'A' ? 'selected' : '' }} value="A">Active</option>
                      <option {{ $employeetype->status == 'I' ? 'selected' : '' }} value="I">Deactive</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Source</label>
                    <select name="source" class="form-control">
                      <option {{ $employeetype->source == 'B2B' ? 'selected' : '' }} value="B2B">B2B</option>
                      <option {{ $employeetype->source == 'B2C' ? 'selected' : '' }} value="B2C">B2C</option>
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
            <!-- employeetype edit account form ends -->
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- employeetype edit ends -->
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

