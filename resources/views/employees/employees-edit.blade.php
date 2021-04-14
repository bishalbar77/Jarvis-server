@extends('layouts/contentLayoutMaster')

@section('title', 'Employee Edit')

@section('vendor-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
@endsection

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/plugins/forms/validation/form-validation.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/pages/app-user.css')) }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/duDialog.css') }}">
  <style type="text/css">
    .picker {
      margin-top: -159px;
    }
  </style>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
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
        
        <div class="tab-content">
          <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
            <form novalidate action="{{ url('employees/update/'.$employee->id) }}" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
              <!-- users edit account form start -->
              <div class="row">
                <div class="col-12 col-sm-6">                  
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="controls">
                          <label>Source</label>
                          <select name="source_name" id="source_name" class="form-control">
                            <option {{ $employerdetails->source_type == 'B2B' ? 'selected' : '' }} value="B2B">B2B</option>
                            <option {{ $employerdetails->source_type == 'B2C' ? 'selected' : '' }} value="B2C">B2C</option>
                            <option {{ $employerdetails->source_type == 'BOT' ? 'selected' : '' }} value="BOT">BOT</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="controls">
                          <label>Company</label>
                          <input type="hidden" name="employmenthistory_id" value="{{ $employmenthistory->id }}">
                          <select name="employer_id" id="employer_id" class="form-control">
                            <option>Select Company</option>
                            @if($employers)
                              @foreach($employers as $employer)
                                <option {{ $employmenthistory->employed_by == $employer->id ? 'selected' : '' }} value="{{ $employer->id }}">

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
                      <div class="col-sm-4">
                        <div class="controls">
                          <label>Employee Types</label>
                          <input type="hidden" name="employee_id" id="employee_id" value="{{ $employee->id }}">
                          <select name="employee_type_id" id="employee_type_id" class="form-control">
                            <option>Select Employee Type</option>
                            @if($employeetypes)
                              @foreach($employeetypes as $employeetype)
                                <option {{ $employee->employee_type_id == $employeetype->id ? 'selected' : '' }} value="{{ $employeetype->id }}">{{ $employeetype->type }}</option>
                              @endforeach
                            @endif
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="controls">
                          <label>Employee Code</label>
                          <input type="text" name="employee_code" id="employee_code" value="{{ $employee->employee_code }}" class="form-control" placeholder="Employee Code">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="controls">
                          <label>Document Types</label>
                          <select name="docTypeId" id="docTypeId" class="form-control">
                            <option>Select Document Type</option>
                            @if($documenttypes)
                              @foreach($documenttypes as $documenttype)
                                <option {{ isset($userdocs[0]->doc_type_id) && $userdocs[0]->doc_type_id == $documenttype->id ? 'selected' : '' }} value="{{ $documenttype->id }}">{{ $documenttype->name }}</option>
                              @endforeach
                            @endif
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="controls">
                          <label>Document Number</label>
                          <input type="text" name="document_no" id="document_no" value="{{ $userdocs[0]->doc_number ?? '' }}" class="form-control" placeholder="Document Number" required>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="controls">
                          <label>First Name</label>
                          <input type="hidden" name="user_id" value="{{ $user->id }}">
                          <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" required data-validation-required-message="This first name field is required" value="{{ $user->first_name }}">
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
                          <input type="text" name="middle_name" id="middle_name" class="form-control" placeholder="Middle Name" value="{{ $user->middle_name }}">
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
                          <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" value="{{ $user->last_name }}">
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
                          <input type="text" name="alias_name" id="alias_name" class="form-control" placeholder="Alias Name" value="{{ $user->alias_name }}">
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Relation</label>
                        <select name="co_relation" id="co_relation" class="form-control">
                          <option {{ $user->co_relation == 'FATHER' ? 'selected' : '' }} value="FATHER">FATHER</option>
                          <option {{ $user->co_relation == 'MOTHER' ? 'selected' : '' }} value="MOTHER">MOTHER</option>
                          <option {{ $user->co_relation == 'GUARDIAN' ? 'selected' : '' }} value="GUARDIAN">GUARDIAN</option>
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
                          <input type="text" name="father_name" id="father_name" class="form-control" placeholder="Care of" value="{{ $user->co_name }}">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="controls">
                          <label>E-mail</label>
                          <input type="email" name="email" class="form-control" placeholder="Email" value="{{ $employee->email }}" />
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
                          <option {{ $user->country_code == '91' ? 'selected' : '' }} value="91" Selected>India (+91)</option>
                          <option {{ $user->country_code == '44' ? 'selected' : '' }} value="44">UK (+44)</option>
                          <option {{ $user->country_code == '1' ? 'selected' : '' }} value="1">USA (+1)</option>
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
                          <input type="text" name="mobile" class="form-control" placeholder="Mobile" value="{{ $user->mobile }}" required data-validation-required-message="This mobile field is required">
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
                          <input type="text" value="{{ $user->dob }}" name="dob" id="dob" class="form-control birthdate-picker" required placeholder="Birth date" data-validation-required-message="This birthdate field is required">
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
                                <input {{ $user->gender == 'M' ? 'checked' : '' }} type="radio" name="gender" value="M">
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
                                <input {{ $user->gender == 'F' ? 'checked' : '' }} type="radio" name="gender" value="F">
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
                                <input {{ $user->gender == 'O' ? 'checked' : '' }} type="radio" name="gender" value="O">
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
                        <option {{ $employee->status == 'A' ? 'selected' : '' }} value="A">Active</option>
                        <option {{ $employee->status == 'I' ? 'selected' : '' }} value="I">In-Active</option>
                      </select>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-12">
                      <div class="form-group">
                        <ul class="list-unstyled mb-0">
                          <li class="d-inline-block mr-2">
                            <input type="hidden" name="userpref_id" value="{{ $userpref->id ?? '' }}">
                            <fieldset>
                              <div class="vs-checkbox-con vs-checkbox-primary">
                                <input type="checkbox" {{ isset($userpref->notify_by_sms) && $userpref->notify_by_sms == 'Y' ? 'checked' : '' }} name="notify_by_sms" value="Y">
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
                                <input type="checkbox" {{ isset($userpref->notify_by_email) && $userpref->notify_by_email == 'Y' ? 'checked' : '' }} name="notify_by_email" value="Y">
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
                                <input type="checkbox" {{ isset($userpref->notify_by_wa) && $userpref->notify_by_wa == 'Y' ? 'checked' : '' }} name="notify_by_wa" value="Y">
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

                <div class="col-12 d-flex flex-sm-row mt-1">
                  <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save</button>
                </div>
              </div>
              </form>
              <!-- users edit account form ends -->
            </div>
            <div class="tab-pane" id="files" aria-labelledby="files-tab" role="tabpanel">
              <!-- users edit socail form start -->
              <div class="row">
                @if($userpics)
                <div class="col-12">
                  <label><strong>Profile Pictures</strong></label>
                  <ul style="list-style: none; padding: 0px;">
                    @foreach($userpics as $userpic)
                    <li style="width: 80px; margin-right: 10px; float: left;">
                      <img src="{{ $userpic->photo_url }}" class="img-fluid">
                    </li>
                    @endforeach
                  </ul>
                </div>
                @endif
              </div>
              
              <div class="row">
                <div class="col-md-6 text-center">
                  <div id="upload-demo"></div>
                </div>
                <div class="col-md-6">
                  <div id="preview-crop-image"></div>
                </div>
                <div class="col-12 col-sm-6">
                  <fieldset class="form-group">
                    <div class="custom-file col-12">
                      <div class="row">
                        <div class="col-12 col-sm-8">
                          <div class="form-group">
                            <strong>Select image to crop:</strong>
                            <input type="file" name="profile_image" class="custom-file-input" id="image">
                            <label class="custom-file-label" for="image">Choose file</label>
                          </div>
                        </div>
                        <div class="col-12 col-sm-4">
                          <button type="button" class="btn btn-primary btn-block upload-image">Upload Image</button>
                          <input type="hidden" name="photo_url" id="photo_url" value="">
                        </div>
                      </div>
                    </div>
                  </fieldset>
                </div>
              </div>
              
              <div class="">
                <form id="frm_upload_docs" class="row" novalidate action="{{ url('employees/upload-docs/'.$employee->user_id) }}" method="post" enctype="multipart/form-data">
                  {{ csrf_field() }}
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
                  <div class="col-sm-3">
                    <fieldset class="form-group">
                      <button type="button" id="upload_docs" class="btn btn-primary" style="padding: 10px 15px;">Upload</button>
                    </fieldset>
                  </div>
                </form>
              </div>
              
              <span id="addFields">
                @if($userdocs)
                  @foreach($userdocs as $key => $docs)  
                    <div class="row" id="docs-row-{{ $docs->id }}">
                      <div class="col-2">
                        <label>{{ $docs->doc_name }}</label>
                      </div>
                      <div class="col-2">
                        <label>{{ $docs->doc_number }}</label>
                      </div>
                      <div class="col-2">
                        <img src="{{ $docs->doc_url }}" class="img-fluid" width="40px">
                      </div>
                      <div class="col-sm-3">
                        <fieldset class="form-group">
                          <button type="button" onclick="delete_doc({{ $docs->id }})" class="btn btn-primary" style="padding: 10px 15px;">Delete</button>
                        </fieldset>
                      </div>
                    </div>
                    @endforeach
                  @endif
                <!-- users edit socail form ends -->
                </span>
            </div>
            <div class="tab-pane" id="information" aria-labelledby="information-tab" role="tabpanel">
            <!-- Expand And Remove Actions Starts -->
            <div class="row">
              @if($address)
              {{-- @dd($address) --}}
                @foreach($address as $k => $addr)
                  <div class="col-md-6 col-sm-12">
                    <div class="card" style="background: #ccc;">
                      <div class="card-header">
                        <h4 class="card-title">{{ $addr->type }}</h4>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                          <ul class="list-inline mb-0">
                            <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                          </ul>
                        </div>
                      </div>
                      <div class="card-content collapse show">
                        <div class="card-body">
                          <p>
                            {{ $addr->street_addr1 }}
                            {{ $addr->street_addr2 }}
                            {{ $addr->village }}
                            {{ $addr->post_office }}
                            {{ $addr->police_station }}
                            {{ $addr->district }}
                            {{ $addr->near_by }}
                            {{ $addr->city }}
                            {{ $addr->state }}
                            {{ $addr->pincode }}
                            {{ $addr->country }}
                            {{ $addr->stayed_from }}
                            {{ $addr->stayed_to }}
                            {{ $addr->verified_by }}
                            {{ $addr->is_verified }}
                            {{ $addr->status }}
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              @endif
            </div>
            <!-- Expand And Remove Actions Ends -->
              <input type="hidden" name="user_addresses" value="">
              <!-- users edit Info form start -->
              <div class="row mt-1">
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label>Address Type</label>
                    <input type="hidden" name="address_id" value="">
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
                      <label for="post_office">Post Office</label>
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
                      <input type="text" name="country" id="country" class="form-control" placeholder="Country">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>Stayed From</label>
                      <input type="text" name="stayed_from" id="stayed_from" class="form-control">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>Stayed To</label>
                      <input type="text" name="stayed_to" id="stayed_to" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="col-12 d-flex flex-sm-row mt-1">
                  <button type="button" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save</button>
                </div>
              </div>
              <!-- users edit Info form ends -->
            </div>
            <div class="tab-pane" id="social" aria-labelledby="social-tab" role="tabpanel">
              <form novalidate id="frm_social_update" action="{{ url('employees/update-social/'.$employee->user_id) }}" method="post" enctype="multipart/form-data">
                <!-- users edit socail form start -->
                <div class="row">
                  <div class="col-12 col-sm-6">
                    <label>Facebook</label>
                    <div class="input-group mb-75">
                      <div class="input-group-prepend">
                        <span class="input-group-text feather icon-facebook" id="basic-addon4"></span>
                      </div>
                      <input type="hidden" name="user_web_profile_id" id="user_web_profile_id" value="{{ $userwebprofile->id ?? '' }}">
                      <input value="{{ $userwebprofile->fb_connection_id ?? '' }}" type="text" name="fb_connection_id" id="fb_connection_id" class="form-control" placeholder="https://www.facebook.com/" aria-describedby="basic-addon4">
                    </div>
                    <label>Twitter</label>
                    <div class="input-group mb-75">
                      <div class="input-group-prepend">
                        <span class="input-group-text feather icon-twitter" id="basic-addon3"></span>
                      </div>
                      <input value="{{ $userwebprofile->twtr_connection_id ?? '' }}" type="text" name="twtr_connection_id" id="twtr_connection_id" class="form-control" placeholder="https://www.twitter.com/" aria-describedby="basic-addon3">
                    </div>
                    <label>Linkedin</label>
                    <div class="input-group mb-75">
                      <div class="input-group-prepend">
                        <span class="input-group-text feather icon-linkedin" id="basic-addon9"></span>
                      </div>
                      <input value="{{ $userwebprofile->li_connection_id ?? '' }}" type="text" name="li_connection_id" id="li_connection_id" class="form-control" placeholder="https://www.linkedin.com/" aria-describedby="basic-addon9">
                    </div>
                  </div>
                  <div class="col-12 d-flex flex-sm-row mt-1">
                    <button type="button" id="update_social" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save</button>
                  </div>
                </div>
              </form>
              <!-- users edit socail form ends -->
            </div>

              <div class="tab-pane" id="employment" aria-labelledby="employment-tab" role="tabpanel">
                <form novalidate id="frm_employement_update" action="{{ url('employees/update-employement/'.$employee->user_id) }}" method="post" enctype="multipart/form-data">
                  <div class="row">
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                        <div class="controls">
                          <label for="salary">Salary</label>
                          <input type="text" name="salary" id="salary" value="{{ $employmenthistory->salary }}" class="form-control" placeholder="Salary" aria-describedby="basic-addon4">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="controls">
                          <label for="doj">Joining Date</label>
                          <input type="text" name="doj" id="doj" value="{{ $employee->doj }}" class="form-control birthdate-picker">
                        </div>
                      </div>
                    </div>

                    <div class="col-12 d-flex flex-sm-row flex-column mt-1">
                      <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Update</button>
                    </div>
                  </div>
                  
                </form>
              </div>

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
  <script src="{{ asset('js/scripts/duDialog.js') }}"></script>

  <script>
    $('#upload_docs').on('click', function(){
      var formElement = document.getElementById("frm_upload_docs");
      var formData = new FormData(formElement);
      var files = $('input[type=file]')[0].files;

      for (var i = files.length - 1; i >= 0; i--) {
        formData.append('files[]', files[i]);
      }

      $.ajax({
        url: $('#frm_upload_docs').attr('action'),
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_field() }}',
        },
        success: function(data){
          $('#addFields').html(data);
          console.log(data);
        },
        error: function (jqXHR, textStatus) {
          console.log('error :', jqXHR);
          console.log('error :', textStatus);
        }
      });
    })
  </script>

<script>
    $('#update_social').on('click', function(){
      $.ajax({
        url: $('#frm_social_update').attr('action'),
        type: 'POST',
        data : $('#frm_social_update').serialize(),
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(data){
          console.log(data);
        },
        error: function (jqXHR, textStatus) {
          console.log(jqXHR);
        }
      });
    })
  </script>

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
        data: { 
          "image" : img,
          "employee_id" : $('#employee_id').val(),
        },
        success: function (data) {
          html = '<img src="' + img + '" class="img-fluid" />';
          $("#preview-crop-image").html(html);
          $('#photo_url').val(data);
        }
      });
    });
  });

  function addFields(){
    $.ajax({
      url: "{{ url('/employees/add-file-fields') }}",
      type: "POST",
      success: function (data) {
        $('#addFields').append(data);
      }
    });
  }

  function removeField(fld){
    $(fld).parent().parent().parent('.row').remove();
  }

  function delete_doc(id){
    new duDialog('Are You Sure', 'You want to Delete Doc? This action cannot be undone.', duDialog.OK_CANCEL, { 
      okText: 'Confirm',
      callbacks: {
        okClick: function(){
          this.hide();
          $.ajax({
            url: "{{ url('/employees/delete-doc') }}/" + id,
            type: "POST",
            success: function (data) {
              $("#docs-row-" + id).remove();
            }
          });
        },
        cancelClick: function(){
          this.hide();
        }
      }
    });
  }
</script>

@endsection