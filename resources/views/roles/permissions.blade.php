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
  <style type="text/css">
    .main-permission {
      margin-left: 0px;
      padding-left: 0px;
      padding-top: 0px;
    }
    ul.mail-permission li {
      padding-bottom: 10px;
    }
    .main-permission li {
      list-style: none;
    }
    ul.sub-permission {
      background: #d4d4d491;
      padding-top: 10px;
      padding-bottom: 10px;
      margin-top: 10px;
    }
    ul.sub-permission li {
      display: inline;
      padding: 2%;
    }
    ul.sub-permission li:first-child {
      margin-left: -40px;
    }
  </style>
@endsection

@section('content')
<!-- roles edit start -->
<section class="roles-edit">
  <div class="card">
    <div class="card-content">
      <div class="card-body">
        <div class="tab-content">
          <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
            <!-- roles edit account form start -->
            <form novalidate action="{{ url('/roles/update/'.$roles->id) }}" method="post">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-12 col-sm-5">
                  <div class="form-group">
                    <div class="controls">
                      <label>Name</label>
                      <input type="text" name="name" class="form-control" placeholder="First Name" value="{{ $roles->name }}" required data-validation-required-message="This name field is required">
                      @if($errors->has('name'))
                        <p class="text-danger">{{ $errors->first('name') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Status</label>
                    <select name="guard_name" class="form-control">
                      <option {{ $roles->guard_name == 'web' ? 'selected' : '' }} value="web">WEB</option>
                      <option {{ $roles->guard_name == 'api' ? 'selected' : '' }} value="api">API</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <ul class="main-permission">
                      <li>
                         <input type="checkbox" name="permissions" id="permissions-0" value="1"> <strong>Users</strong>
                        <ul class="sub-permission">
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Create</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Update</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Delete</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Status</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> View</li>
                        </ul>
                      </li>
                    </ul>
                  </div>
                  <div class="form-group">
                    <ul class="main-permission">
                      <li>
                         <input type="checkbox" name="permissions" id="permissions-0" value="1"> <strong>Roles</strong>
                        <ul class="sub-permission">
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Create</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Update</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Delete</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Status</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> View</li>
                        </ul>
                      </li>
                    </ul>
                  </div>
                  <div class="form-group">
                    <ul class="main-permission">
                      <li>
                         <input type="checkbox" name="permissions" id="permissions-0" value="1"> <strong>Employers</strong>
                        <ul class="sub-permission">
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Create</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Update</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Delete</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Status</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> View</li>
                        </ul>
                      </li>
                    </ul>
                  </div>
                  <div class="form-group">
                    <ul class="main-permission">
                      <li>
                         <input type="checkbox" name="permissions" id="permissions-0" value="1"> <strong>Employees</strong>
                        <ul class="sub-permission">
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Create</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Update</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Delete</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Status</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> View</li>
                        </ul>
                      </li>
                    </ul>
                  </div>
                  <div class="form-group">
                    <ul class="main-permission">
                      <li>
                         <input type="checkbox" name="permissions" id="permissions-0" value="1"> <strong>Billing Plans</strong>
                        <ul class="sub-permission">
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Create</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Update</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Delete</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Status</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> View</li>
                        </ul>
                      </li>
                    </ul>
                  </div>
                  <div class="form-group">
                    <ul class="main-permission">
                      <li>
                         <input type="checkbox" name="permissions" id="permissions-0" value="1"> <strong>Documents Type</strong>
                        <ul class="sub-permission">
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Create</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Update</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Delete</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Status</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> View</li>
                        </ul>
                      </li>
                    </ul>
                  </div>
                  <div class="form-group">
                    <ul class="main-permission">
                      <li>
                         <input type="checkbox" name="permissions" id="permissions-0" value="1"> <strong>Employee Type</strong>
                        <ul class="sub-permission">
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Create</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Update</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Delete</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Status</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> View</li>
                        </ul>
                      </li>
                    </ul>
                  </div>
                  <div class="form-group">
                    <ul class="main-permission">
                      <li>
                         <input type="checkbox" name="permissions" id="permissions-0" value="1"> <strong>Verification Type</strong>
                        <ul class="sub-permission">
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Create</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Update</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Delete</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Status</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> View</li>
                        </ul>
                      </li>
                    </ul>
                  </div>
                  <div class="form-group">
                    <ul class="main-permission">
                      <li>
                         <input type="checkbox" name="permissions" id="permissions-0" value="1"> <strong>Task Severity</strong>
                        <ul class="sub-permission">
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Create</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Update</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Delete</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> Status</li>
                          <li><input type="checkbox" name="permissions" id="permissions-0" value="1"> View</li>
                        </ul>
                      </li>
                    </ul>
                  </div>
                  <div class="row">
                    <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                      <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save</button>
                      <button type="reset" class="btn btn-outline-warning">Reset</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
            <!-- roles edit account form ends -->
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- roles edit ends -->
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

