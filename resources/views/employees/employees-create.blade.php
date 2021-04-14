@extends('layouts/contentLayoutMaster')

@section('title', 'Employee Create')

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
    .picker {
      margin-top: -159px;
    }
  </style>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
@endsection

@section('content')
<!-- users edit start -->
<section class="users-edit">
  <div class="card">
    <div class="card-content">
      <div class="card-body">
        <ul class="nav nav-tabs mb-3" role="tablist">
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center active" id="account-tab" data-toggle="tab" href="#account" aria-controls="account" role="tab" aria-selected="true">
              <i class="feather icon-user mr-25"></i><span class="d-none d-sm-block">Account</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center" id="files-tab" data-toggle="tab" href="#files" aria-controls="files" role="tab" aria-selected="false">
              <i class="feather icon-file mr-25"></i><span class="d-none d-sm-block">Files & Documents</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center" id="information-tab" data-toggle="tab" href="#information"
              aria-controls="information" role="tab" aria-selected="false">
              <i class="feather icon-map-pin mr-25"></i><span class="d-none d-sm-block">Address</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center" id="social-tab" data-toggle="tab" href="#social" aria-controls="social" role="tab" aria-selected="false">
              <i class="feather icon-share-2 mr-25"></i><span class="d-none d-sm-block">Social</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center" id="employment-tab" data-toggle="tab" href="#employment" aria-controls="employment" role="tab" aria-selected="false">
              <i class="feather icon-share-2 mr-25"></i><span class="d-none d-sm-block">Employement Details</span>
            </a>
          </li>
        </ul>
        <form novalidate action="{{ url('employees/store') }}" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
        <div class="tab-content">
          <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
            <!-- users edit account form start -->
              <div class="row">
                <div class="col-12 col-sm-6">                  
                  
                  <div class="row">

                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="controls">
                          <label>Source</label>
                          <select name="source_name" id="source_name" class="form-control">
                            <option {{ $source == 'B2B' ? 'selected' : '' }} value="B2B">B2B</option>
                            <option {{ $source == 'B2C' ? 'selected' : '' }} value="B2C">B2C</option>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="controls">
                          <label>Company</label>
                          <select name="employer_id" id="employer_id" class="form-control" required data-validation-required-message="Company required">
                            <option value="">Select Company</option>
                            @if($employers)
                              @foreach($employers as $employer)
                                <option value="{{ $employer->id }}">

                                  @if(!empty($employer->b2b_company_name))
                                    {{ $employer->b2b_company_name }} -- {{ $employer->b2b_brand_name }}
                                  @else
                                    {{ $employer->first_name }} {{ $employer->middle_name }} {{ $employer->last_name }}
                                  @endif

                                </option>
                              @endforeach
                            @endif
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="controls">
                          <label>Employee Types</label>
                          <select name="employee_type_id" id="employee_type_id" class="form-control" required data-validation-required-message="Employee Type required">
                            <option value="">Select Employee Type</option>
                            @if($employeetypes)
                              @foreach($employeetypes as $employeetype)
                                <option value="{{ $employeetype->id }}">{{ $employeetype->type }}</option>
                              @endforeach
                            @endif
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="controls">
                          <label>Employee Code</label>
                          <input type="text" name="employee_code" id="employee_code" class="form-control" placeholder="Employee Code">
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="controls">
                          <label>Document Types</label>
                          <select name="docTypeId" id="docTypeId" class="form-control" required data-validation-required-message="Document Type required">
                            <option>Select Document Type</option>
                            @if($documenttypes)
                              @foreach($documenttypes as $documenttype)
                                <option value="{{ $documenttype->id }}">{{ $documenttype->name }}</option>
                              @endforeach
                            @endif
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="controls">
                          <label>Document Number</label>
                          <input type="text" name="document_no" id="document_no" class="form-control" placeholder="Document Number" required data-validation-required-message="This Document Number field is required">
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="controls">
                          <label>First Name</label>
                          <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" required data-validation-required-message="This first name field is required">
                          @if($errors->has('first_name'))
                            <p class="text-danger">{{ $errors->first('first_name') }}</p>
                          @endif
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="controls">
                          <label>Middle Name</label>
                          <input type="text" name="middle_name" id="middle_name" class="form-control" placeholder="Middle Name">
                          @if($errors->has('middle_name'))
                            <p class="text-danger">{{ $errors->first('middle_name') }}</p>
                          @endif
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="controls">
                          <label>Last Name</label>
                          <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name">
                          @if($errors->has('last_name'))
                            <p class="text-danger">{{ $errors->first('last_name') }}</p>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="controls">
                          <label>Alias Name</label>
                          <input type="text" name="alias_name" id="alias_name" class="form-control" placeholder="Alias Name">
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Relation</label>
                        <select name="co_relation" id="co_relation" class="form-control">
                          <option value="FATHER" Selected>FATHER</option>
                          <option value="MOTHER">MOTHER</option>
                          <option value="GUARDIAN">GUARDIAN</option>
                        </select>
                        @if($errors->has('co_relation'))
                          <p class="text-danger">{{ $errors->first('co_relation') }}</p>
                        @endif
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="controls">
                          <label for="father_name">C/O</label>
                          <input type="text" name="father_name" id="father_name" class="form-control" placeholder="Care of">
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="controls">
                          <label>E-mail</label>
                          <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" />
                          @if($errors->has('email'))
                            <p class="text-danger">{{ $errors->first('email') }}</p>
                          @endif
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
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
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="controls">
                          <label>Mobile</label>
                          <input type="text" name="mobile" class="form-control" placeholder="Mobile" value="{{ old('mobile') }}" required data-validation-required-message="This mobile field is required">
                          @if($errors->has('mobile'))
                            <p class="text-danger">{{ $errors->first('mobile') }}</p>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-12 col-sm-6">
                  
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <div class="controls" style="width: 40%;">
                          <label>Birth date</label>
                          <input type="text" name="dob" id="dob" class="form-control birthdate-picker" required placeholder="Birth date" data-validation-required-message="This birthdate field is required">
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="controls">
                        <label>Gender</label>
                        <ul class="list-unstyled mb-0">
                          <li class="d-inline-block mr-2">
                            <fieldset>
                              <div class="vs-radio-con">
                                <input type="radio" name="gender" checked value="M">
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
                                <input type="radio" name="gender" value="F">
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
                                <input type="radio" name="gender" value="O">
                                <span class="vs-radio">
                                  <span class="vs-radio--border"></span>
                                  <span class="vs-radio--circle"></span>
                                </span>
                                Other
                              </div>
                            </fieldset>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Status</label>
                    <div class="controls" style="width: 40%;">
                      <select name="status" id="status" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Deactive</option>
                      </select>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-12">
                      <div class="form-group">
                        <ul class="list-unstyled mb-0">
                          <li class="d-inline-block mr-2">
                            <fieldset>
                              <div class="vs-checkbox-con vs-checkbox-primary">
                                <input type="checkbox" checked name="notify_by_sms" value="Y">
                                <span class="vs-checkbox">
                                  <span class="vs-checkbox--check">
                                    <i class="vs-icon feather icon-check"></i>
                                  </span>
                                </span>
                                <span class="" style="font-size: 0.85rem;">Notify by SMS</span>
                              </div>
                            </fieldset>
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="form-group">
                        <ul class="list-unstyled mb-0">
                          <li class="d-inline-block mr-2">
                            <fieldset>
                              <div class="vs-checkbox-con vs-checkbox-primary">
                                <input type="checkbox" checked name="notify_by_email" value="Y">
                                <span class="vs-checkbox">
                                  <span class="vs-checkbox--check">
                                    <i class="vs-icon feather icon-check"></i>
                                  </span>
                                </span>
                                <span class="" style="font-size: 0.85rem;">Notify by Email</span>
                              </div>
                            </fieldset>
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="form-group">
                        <ul class="list-unstyled mb-0">
                          <li class="d-inline-block mr-2">
                            <fieldset>
                              <div class="vs-checkbox-con vs-checkbox-primary">
                                <input type="checkbox" checked name="notify_by_wa" value="Y">
                                <span class="vs-checkbox">
                                  <span class="vs-checkbox--check">
                                    <i class="vs-icon feather icon-check"></i>
                                  </span>
                                </span>
                                <span class="" style="font-size: 0.85rem;">Notify by Whatsapp</span>
                              </div>
                            </fieldset>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  
                </div>

                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                  <button type="button" onclick="activeClass('files-tab','account-tab')" data-toggle="tab" href="#files" aria-controls="files" role="tab" aria-selected="false" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save</button>
                  <!-- <button type="reset" class="btn btn-outline-warning">Back</button> -->
                </div>
              </div>
              <!-- users edit account form ends -->
            </div>
            <div class="tab-pane" id="files" aria-labelledby="files-tab" role="tabpanel">
              <!-- users edit socail form start -->

              <div class="row">
                <div class="col-md-6 text-center">
                  <div id="upload-demo"></div>
                </div>
                <div class="col-md-6">
                  <div id="preview-crop-image"></div>
                </div>
                <div class="col-12 col-sm-6">
                  <fieldset class="form-group">
                    <strong>Select image to crop:</strong>
                    <div class="custom-file">
                      <input type="file" name="profile_image" class="custom-file-input" id="image">
                      <label class="custom-file-label" for="image">Choose file</label>
                      <button type="button" class="btn btn-primary btn-block upload-image" style="margin-top:2%">Upload Image</button>
                      <input type="hidden" name="photo_url" id="photo_url" value="">
                    </div>
                  </fieldset>
                </div>
              </div>
              
              <!-- <div class="row">
                <div class="col-12 col-sm-6">
                  <fieldset class="form-group">
                    <label for="doc_url_front">Documents front Image</label>
                    <div class="custom-file">
                      <input type="file" name="doc_url_front" class="custom-file-input" id="doc_url_front">
                      <label class="custom-file-label" for="doc_url">Choose file</label>
                    </div>
                  </fieldset>
                </div>
              </div>

              <div class="row">
                <div class="col-12 col-sm-6">
                  <fieldset class="form-group">
                    <label for="doc_url_back">Documents Back Image</label>
                    <div class="custom-file">
                      <input type="file" name="doc_url_back" class="custom-file-input" id="doc_url_back">
                      <label class="custom-file-label" for="doc_url">Choose file</label>
                    </div>
                  </fieldset>
                </div>
              </div> -->

              <div class="row">
                  <div class="col-sm-2">
                    <div class="form-group">
                      <select name="doc_type" id="doc_type" class="form-control">
                        <option value="">Select Document Type</option>
                        @if($documenttypes)
                          @foreach($documenttypes as $doctype)
                            <option value="{{ $doctype->id }}">{{ $doctype->name }}</option>
                          @endforeach
                        @endif
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <fieldset class="form-group">
                      <div class="custom-file">
                        <input type="text" name="doc_number" class="form-control" placeholder="Number" />
                      </div>
                    </fieldset>
                  </div>
                  <div class="col-sm-3">
                    <fieldset class="form-group">
                      <div class="custom-file">
                        <input type="file" name="doc_url_front[]" class="custom-file-input" multiple />
                        <label class="custom-file-label" for="doc_url">Choose files</label>
                      </div>
                    </fieldset>
                  </div>
              </div>
              
              <div class="row">
                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                  <button type="button" onclick="activeClass('information-tab','files-tab')" data-toggle="tab" href="#information" aria-controls="information" role="tab" aria-selected="false" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Next</button>
                  <button type="reset" class="btn btn-outline-warning">Back</button>
                </div>
              </div>
              <!-- users edit socail form ends -->
            </div>
            <div class="tab-pane" id="information" aria-labelledby="information-tab" role="tabpanel">
              <!-- users edit Info form start -->
              <div class="row mt-1">
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label>Address Type</label>
                    <select name="addr_type" id="addr_type" class="form-control">
                      <option>Select Address Type</option>
                      <option value="PERMANENT">PERMANENT</option>
                      <option value="CURRENT">CURRENT</option>
                      <option value="OLD">OLD</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>Address Line 1</label>
                      <input type="text" name="street_addr1" id="street_addr1" class="form-control" placeholder="Address Line 1">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>Address Line 2</label>
                      <input type="text" name="street_addr2" id="street_addr2" class="form-control" placeholder="Address Line 2">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label for="village">Village</label>
                      <input type="text" name="village" id="village" class="form-control" placeholder="Village">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label for="police_station">Police Station</label>
                      <input type="text" name="police_station" id="police_station" class="form-control" placeholder="Police Station">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label for="districtpost_office">Post Office</label>
                      <input type="text" name="post_office" class="form-control" placeholder="Post Office">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label for="near_by">Landmark</label>
                      <input type="text" name="near_by" id="near_by" class="form-control" placeholder="Landmark">
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <div class="controls">
                      <label for="pincode">Pin Code</label>
                      <input type="text" name="pincode" id="pincode" class="form-control" placeholder="Pin Code">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label for="state">State</label>
                      <select class="form-control" name="state" id="choosestate" onchange="selct_district(this.value)">
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label for="district">District</label>
                      <select class="form-control" name="district" id="district">
                        <option>Select State First</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label for="country">Country</label>
                      <input type="text" name="country" id="country" class="form-control" value="India" placeholder="Country">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>Stayed From</label>
                      <input type="text" name="stayed_from" id="stayed_from" class="form-control" placeholder="Stayed From" />
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>Stayed To</label>
                      <input type="text" name="stayed_to" id="stayed_to" class="form-control" placeholder="Stayed To" />
                    </div>
                  </div>
                </div>
                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                  <button type="button" onclick="activeClass('social-tab','information-tab')" data-toggle="tab" href="#social" aria-controls="social" role="tab" aria-selected="false" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Next</button>
                  <button type="reset" class="btn btn-outline-warning">Back</button>
                </div>
              </div>
              <!-- users edit Info form ends -->
            </div>
            <div class="tab-pane" id="social" aria-labelledby="social-tab" role="tabpanel">
              <!-- users edit socail form start -->
              <div class="row">
                <div class="col-12 col-sm-6">
                  <label>Facebook</label>
                  <div class="input-group mb-75">
                    <div class="input-group-prepend">
                      <span class="input-group-text feather icon-facebook" id="basic-addon4"></span>
                    </div>
                    <input type="text" name="fb_connection_id" id="fb_connection_id" class="form-control" placeholder="https://www.facebook.com/" aria-describedby="basic-addon4">
                  </div>
                  <label>Twitter</label>
                  <div class="input-group mb-75">
                    <div class="input-group-prepend">
                      <span class="input-group-text feather icon-twitter" id="basic-addon3"></span>
                    </div>
                    <input type="text" name="twtr_connection_id" id="twtr_connection_id" class="form-control" placeholder="https://www.twitter.com/" aria-describedby="basic-addon3">
                  </div>
                  <label>Linkedin</label>
                  <div class="input-group mb-75">
                    <div class="input-group-prepend">
                      <span class="input-group-text feather icon-linkedin" id="basic-addon9"></span>
                    </div>
                    <input type="text" name="li_connection_id" id="li_connection_id" class="form-control" placeholder="https://www.linkedin.com/" aria-describedby="basic-addon9">
                  </div>
                </div>
                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                  <button type="button" onclick="activeClass('employment-tab','social-tab')" data-toggle="tab" href="#employment" aria-controls="employment" role="tab" aria-selected="false" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Next</button>
                  <button type="reset" class="btn btn-outline-warning">Back</button>
                </div>
              </div>
              <!-- users edit socail form ends -->
            </div>
            <div class="tab-pane" id="employment" aria-labelledby="employment-tab" role="tabpanel">
              <!-- users edit socail form start -->
              <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                      <div class="controls">
                        <label for="salary">Salary</label>
                        <input type="text" name="salary" id="salary" class="form-control" placeholder="Salary" aria-describedby="basic-addon4">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="controls">
                        <label for="doj">Joining Date</label>
                        <input type="text" name="doj" id="doj" class="form-control birthdate-picker">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                  <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save Changes</button>
                  <button type="reset" class="btn btn-outline-warning">Back</button>
                </div>
              </div>
              <!-- users edit socail form ends -->
            </div>
          </div>
        </form>
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
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
  <script src="{{ url('js/scripts/state.js') }}"></script>
@endsection

@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset(mix('js/scripts/pages/app-user.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/navs/navs.js')) }}"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>
  <script type="text/javascript">
    $('#source_name').on('change', function(){
      var source = $('#source_name').val();
      location.href = '/employees/create?source='+source;
    });
    function activeClass(active,deactive){
      $('#' + active).addClass('active');
      $('#' + deactive).removeClass('active');
    }
    $('#dob').pickadate({
      format: 'dd mmmm yyyy',
      selectMonths: true,
      selectYears: 60,
      max: true
    });
    $('#doj').pickadate({
      format: 'dd mmmm yyyy',
      selectMonths: true,
      selectYears: 60,
      max: true
    });
  </script>
  <script type="text/javascript">

$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});


var resize = $('#upload-demo').croppie({
    enableExif: true,
    enableOrientation: true,    
    viewport: {
        width: 300,
        height: 300,
        type: 'square' //circle
    },
    boundary: {
        width: 350,
        height: 350
    }
});


$('#image').on('change', function () { 
  var reader = new FileReader();
    reader.onload = function (e) {
      resize.croppie('bind',{
        url: e.target.result
      }).then(function(){
        console.log('jQuery bind complete');
      });
    }
    reader.readAsDataURL(this.files[0]);
});


$('.upload-image').on('click', function (ev) {
  resize.croppie('result', {
    type: 'canvas',
    size: 'viewport'
  }).then(function (img) {
    $.ajax({
      url: "{{ url('upload-file') }}",
      type: "POST",
      data: { "image" : img },
      success: function (data) {
        html = '<img src="' + img + '" class="img-fluid" />';
        $("#preview-crop-image").html(html);
        $('#photo_url').val(data);
      }
    });
  });
});
  </script>
@endsection