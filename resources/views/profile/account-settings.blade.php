@extends('layouts/contentLayoutMaster')

@section('title', 'Account Settings')

@section('vendor-style')
        <!-- vendor css files -->
        <link rel='stylesheet' href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
        <link rel='stylesheet' href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
@endsection
@section('page-style')
        <!-- Page css files -->
        <link rel="stylesheet" href="{{ asset(mix('css/plugins/extensions/noui-slider.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('css/core/colors/palette-noui.css')) }}">
@endsection

@section('content')
@if($message = Session::get('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success : </strong> {{ $message }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif
<!-- account setting page start -->
<section id="page-account-settings">
    <div class="row">
      <!-- left menu section -->
      <div class="col-md-2 mb-2 mb-md-0">
        <ul class="nav nav-pills flex-column mt-md-0 mt-1">
          <li class="nav-item">
            <a class="nav-link d-flex py-75 active" id="account-pill-general" data-toggle="pill"
              href="#account-vertical-general" aria-expanded="true">
              <i class="feather icon-globe mr-50 font-medium-3"></i>
              General
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link d-flex py-75" id="account-pill-password" data-toggle="pill"
              href="#account-vertical-password" aria-expanded="false">
              <i class="feather icon-lock mr-50 font-medium-3"></i>
              Change Password
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link d-flex py-75" id="account-pill-info" data-toggle="pill" href="#account-vertical-info"
              aria-expanded="false">
              <i class="feather icon-info mr-50 font-medium-3"></i>
              Info
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link d-flex py-75" id="account-pill-social" data-toggle="pill" href="#account-vertical-social"
              aria-expanded="false">
              <i class="feather icon-camera mr-50 font-medium-3"></i>
              Social links
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link d-flex py-75" id="account-pill-notifications" data-toggle="pill"
              href="#account-vertical-notifications" aria-expanded="false">
              <i class="feather icon-message-circle mr-50 font-medium-3"></i>
              Notifications
            </a>
          </li>
        </ul>
      </div>
      <!-- right content section -->
      <div class="col-md-6">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="account-vertical-general"
                  aria-labelledby="account-pill-general" aria-expanded="true">
                  <div class="media">
                    <a href="javascript: void(0);">
                      <img src="{{ asset('images/portrait/small/avatar-s-12.jpg') }}" class="rounded mr-75"
                        alt="profile image" height="64" width="64">
                    </a>
                    <div class="media-body mt-75">
                      <div class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
                        <label class="btn btn-sm btn-primary ml-50 mb-50 mb-sm-0 cursor-pointer"
                          for="account-upload">Upload new photo</label>
                        <input type="file" id="account-upload" hidden>
                        <button class="btn btn-sm btn-outline-warning ml-50">Reset</button>
                      </div>
                      <p class="text-muted ml-75 mt-50"><small>Allowed JPG, GIF or PNG. Max size of 800kB</small></p>
                    </div>
                  </div>
                  <hr>
                  <form novalidate action="{{ url('/users/update-profile') }}">
                    <div class="row">
                      <div class="col-4">
                        <div class="form-group">
                          <div class="controls">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" value="{{ $user->first_name }}">
                          </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="form-group">
                          <div class="controls">
                            <label for="middle_name">Middle Name</label>
                            <input type="text" class="form-control" name="middle_name" id="middle_name" placeholder="Middle Name" value="{{ $user->middle_name }}">
                          </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="form-group">
                          <div class="controls">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" value="{{ $user->last_name }}">
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <div class="controls">
                            <label for="mobile">Mobile</label>
                            <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile" value="{{ $user->mobile }}">
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <div class="controls">
                            <label for="email">E-mail</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{ $user->email }}">
                          </div>
                        </div>
                      </div>
                      <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                        <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save changes</button>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="tab-pane fade " id="account-vertical-password" role="tabpanel"
                  aria-labelledby="account-pill-password" aria-expanded="false">
                  <form novalidate action="{{ url('/users/update-password') }}">
                    <div class="row">
                      <div class="col-12">
                        <div class="form-group">
                          <div class="controls">
                            <label for="password">New Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="New Password">
                            @if($errors->has('password'))
                              <p class="text-danger">{{ $errors->first('password') }}</p>
                            @endif
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <div class="controls">
                            <label for="npassword">Retype New Password</label>
                            <input type="password" name="npassword" class="form-control" id="npassword" placeholder="New Password">
                            @if($errors->has('npassword'))
                              <p class="text-danger">{{ $errors->first('npassword') }}</p>
                            @endif
                          </div>
                        </div>
                      </div>
                      <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                        <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save changes</button>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="tab-pane fade" id="account-vertical-info" role="tabpanel" aria-labelledby="account-pill-info"
                  aria-expanded="false">
                  <form novalidate action="{{ url('/users/update-info') }}">
                    <div class="row">
                      <div class="col-12">
                        <div class="form-group">
                          <div class="controls">
                            <label for="dob">Birth date</label>
                            <input type="text" class="form-control birthdate-picker" placeholder="Birth date" name="dob" id="dob" value="{{ $user->dob }}">
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <div class="controls">
                          <label>Gender</label>
                          <ul class="list-unstyled mb-0">
                            <li class="d-inline-block mr-2">
                              <fieldset>
                                <div class="vs-radio-con">
                                  <input type="radio" name="gender" {{ $user->gender == 'M' ? 'checked' : '' }} value="M">
                                  <span class="vs-radio">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                  </span>
                                  Male
                                </div>
                              </fieldset>
                            </li>
                            <li class="d-inline-block mr-2">
                              <fieldset>
                                <div class="vs-radio-con">
                                  <input type="radio" name="gender" {{ $user->gender == 'F' ? 'checked' : '' }} value="F">
                                  <span class="vs-radio">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                  </span>
                                  Female
                                </div>
                              </fieldset>
                            </li>
                            <li class="d-inline-block mr-2">
                              <fieldset>
                                <div class="vs-radio-con">
                                  <input type="radio" name="gender" {{ $user->gender == 'O' ? 'checked' : '' }} value="O">
                                  <span class="vs-radio">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                  </span>
                                  Other
                                </div>
                              </fieldset>
                            </li>
                          </ul>
                          @if($errors->has('dob'))
                            <p class="text-danger">{{ $errors->first('dob') }}</p>
                          @endif
                        </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <div class="controls">
                            <label for="phone">Phone Number</label>
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone number" value="{{ $user->phone }}">
                            @if($errors->has('phone'))
                              <p class="text-danger">{{ $errors->first('phone') }}</p>
                            @endif
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <label for="co_name">Father's Name</label>
                          <input type="text" class="form-control" name="co_name" id="co_name" placeholder="Website address" value="{{ $user->co_name }}">
                          @if($errors->has('co_name'))
                            <p class="text-danger">{{ $errors->first('co_name') }}</p>
                          @endif
                        </div>
                      </div>
                      <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                        <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save changes</button>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="tab-pane fade " id="account-vertical-social" role="tabpanel"
                  aria-labelledby="account-pill-social" aria-expanded="false">
                  <form novalidate action="{{ url('/users/web-profiles') }}">
                    <div class="row">
                      <div class="col-12">
                        <div class="form-group">
                          <label for="fb_connection_id">Facebook</label>
                          <input type="hidden" name="user_web_profile_id" id="user_web_profile_id" class="form-control" value="{{ $user->user_web_profile_id }}">
                          <input type="text" name="fb_connection_id" id="fb_connection_id" class="form-control" placeholder="Add link" value="{{ $userweb->fb_connection_id ?? '' }}">
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <label for="li_connection_id">LinkedIn</label>
                          <input type="text" name="li_connection_id" id="li_connection_id" class="form-control" placeholder="Add link" value="{{ $userweb->li_connection_id  ?? '' }}">
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <label for="twtr_connection_id">Twitter</label>
                          <input type="text" name="twtr_connection_id" id="twtr_connection_id" class="form-control" placeholder="Add link" value="{{ $userweb->twtr_connection_id ?? '' }}">
                        </div>
                      </div>
                      <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                        <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save changes</button>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="tab-pane fade" id="account-vertical-notifications" role="tabpanel"
                  aria-labelledby="account-pill-notifications" aria-expanded="false">
                  <div class="row">
                    <h6 class="m-1">Activity</h6>
                    <div class="col-12 mb-1">
                      <div class="form-group">
                        <label for="languageselect2">Languages</label>
                        <select class="form-control" id="languageselect2">
                          <option value="en" selected>English</option>
                          <option value="hn">Hindi</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-12 mb-1">
                      <div class="custom-control custom-switch custom-control-inline">
                        <input type="checkbox" class="custom-control-input" checked id="accountSwitch1">
                        <label class="custom-control-label mr-1" for="accountSwitch1"></label>
                        <span class="switch-label w-100">Notify by SMS</span>
                      </div>
                    </div>
                    <div class="col-12 mb-1">
                      <div class="custom-control custom-switch custom-control-inline">
                        <input type="checkbox" class="custom-control-input" checked id="accountSwitch2">
                        <label class="custom-control-label mr-1" for="accountSwitch2"></label>
                        <span class="switch-label w-100">Notify by Email</span>
                      </div>
                    </div>
                    <div class="col-12 mb-1">
                      <div class="custom-control custom-switch custom-control-inline">
                        <input type="checkbox" class="custom-control-input" id="accountSwitch3">
                        <label class="custom-control-label mr-1" for="accountSwitch3"></label>
                        <span class="switch-label w-100">Notify by Whatsapp</span>
                      </div>
                    </div>
                    <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                      <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save changes</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
<!-- account setting page end -->
@endsection

@section('vendor-script')
        <!-- vendor files -->
        <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/forms/validation/jqBootstrapValidation.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/extensions/dropzone.min.js')) }}"></script>
@endsection
@section('page-script')
        <!-- Page js files -->
        <script src="{{ asset(mix('js/scripts/pages/account-setting.js')) }}"></script>
@endsection