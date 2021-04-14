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
              	@if($employer->photo->photo_url)
              		<img src="{{ $employer->photo->photo_url }}" alt="users avatar" class="users-avatar-shadow rounded" height="64" width="64">
              	@else
                	<img src="{{ asset('images/portrait/small/avatar-s-12.jpg') }}" alt="users avatar" class="users-avatar-shadow rounded" height="64" width="64">
                @endif
              </a>
              <div class="media-body mt-50">
                <h4 class="media-heading">{{ $employer->b2b_company_name }}</h4>
              </div>
            </div>
            <!-- users edit media object ends -->
            <!-- employers edit account form start -->
            <form novalidate action="{{ url('/employers/update/'.$employer->id) }}" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-12 col-sm-6">
                                    
                  <input type="hidden" name="userpic_id" value="{{ $employer->photo->id ?? '' }}">
                  <input type="hidden" name="employer_id" value="{{ $employer->id }}">
                  
                  @if($employer->source_type == 'B2C')
                    <div class="row">
                      <div class="col-4">
                        <div class="form-group">
                          <label>First Name</label>
                          <input type="hidden" name="user_id" value="{{ $users->id }}">
                          <input type="text" name="first_name" class="form-control" placeholder="First Name" value="{{ $users->first_name }}">
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="form-group">
                          <label>Middle Name</label>
                          <input type="text" name="b2b_company_name" class="form-control" placeholder="Middle Name" value="{{ $users->middle_name }}">
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="last_name" class="form-control" placeholder="Last Name" value="{{ $users->last_name }}">
                        </div>
                      </div>
                    </div>
                  @else
                    <div class="form-group">
                      <div class="controls">
                        <label>Company Name</label>
                        <input type="text" name="b2b_company_name" class="form-control" placeholder="Company Name" value="{{ $employer->b2b_company_name }}">
                        @if($errors->has('b2b_company_name'))
                          <p class="text-danger">{{ $errors->first('b2b_company_name') }}</p>
                        @endif
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="controls">
                        <label>Brand Name</label>
                        <input type="text" name="b2b_brand_name" class="form-control" placeholder="Brand Name" value="{{ $employer->b2b_brand_name }}">
                        @if($errors->has('b2b_brand_name'))
                          <p class="text-danger">{{ $errors->first('b2b_brand_name') }}</p>
                        @endif
                      </div>
                    </div>
                  @endif

                  <div class="row">
                    <div class="col-4">
                      <div class="form-group">
                        <label>Country Code</label>
                        <select name="country_code" id="country_code" class="form-control">
                          <option {{ $employer->country_code == '91' ? 'selected' : '' }} value="91" Selected>India (+91)</option>
                          <option {{ $employer->country_code == '44' ? 'selected' : '' }} value="44">UK (+44)</option>
                          <option {{ $employer->country_code == '1' ? 'selected' : '' }} value="1">USA (+1)</option>
                        </select>
                        @if($errors->has('country_code'))
                          <p class="text-danger">{{ $errors->first('country_code') }}</p>
                        @endif
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <div class="controls">
                          <label for="mobile">Mobile Number</label>
                          <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile Number" value="{{ $employer->mobile ?? '' }}">
                        </div>
                      </div> 
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <div class="controls">
                          <label for="phone">Phone Number</label>
                          <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone Number" value="{{ $employer->phone ?? '' }}">
                        </div>
                      </div> 
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <div class="controls">
                      <label>GST No.</label>
                      <input type="text" name="b2b_gst_no" class="form-control" placeholder="GST No." value="{{ $employer->b2b_gst_no }}">
                      @if($errors->has('b2b_gst_no'))
                        <p class="text-danger">{{ $errors->first('b2b_gst_no') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>PAN No.</label>
                      <input type="text" name="b2b_pan_no" class="form-control" placeholder="PAN No." value="{{ $employer->b2b_pan_no }}">
                      @if($errors->has('b2b_pan_no'))
                        <p class="text-danger">{{ $errors->first('b2b_pan_no') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>Email</label>
                      <input type="text" name="email" class="form-control" placeholder="Email" value="{{ $employer->email }}">
                      @if($errors->has('email'))
                        <p class="text-danger">{{ $errors->first('email') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>Website</label>
                      <input type="text" name="b2b_website" class="form-control" placeholder="Website" value="{{ $employer->b2b_website }}">
                      @if($errors->has('b2b_website'))
                        <p class="text-danger">{{ $errors->first('b2b_website') }}</p>
                      @endif
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-4">
                      <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                          <option {{ $employer->b2b_website == 'A' ? 'selected' : '' }} value="A">Active</option>
                          <option {{ $employer->b2b_website == 'I' ? 'selected' : '' }} value="I">In-Active</option>
                        </select>
                      </div>
                    </div>
                    <input type="hidden" name="source_type" value="{{ $employer->source_type }}">
                    <!-- <div class="col-4">
                      <div class="form-group">
                        <label>Source</label>
                        <select name="source_type" class="form-control">
                          <option {{ $employer->source_type == 'B2B' ? 'selected' : '' }} value="B2B">B2B</option>
                          <option {{ $employer->source_type == 'B2C' ? 'selected' : '' }} value="B2C">B2C</option>
                        </select>
                      </div>
                    </div> -->
                    <div class="col-4">
                      <div class="form-group">
                        <label>Language</label>
                        <input type="hidden" name="userprefs_id"value="{{ $userprefs->id ?? '' }}">
                        <select name="lang" class="form-control">
                          <option>Select Language</option>
                          @if($languages)
                            @foreach($languages as $language)
                              <option {{ isset($userprefs->lang) && $userprefs->lang == $language->id ? 'selected' : '' }} value="{{ $language->id }}">{{ $language->code }}</option>
                            @endforeach
                          @endif
                        </select>
                      </div>
                    </div>
                  <!-- </div>

                  <div class="row"> -->
                    <div class="col-4">
                      <div class="form-group">
                        <label>Locale</label>
                        <select name="locale" id="locale" class="form-control">
                          <option {{ isset($userprefs->locale) && $userprefs->locale == 'en_US' ? 'selected' : '' }} value="en_US">en_US</option>
                          <option {{ isset($userprefs->locale) && $userprefs->locale == 'en_GB' ? 'selected' : '' }} value="en_GB">en_GB</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <label>Date Pattern</label>
                        <input type="text" name="date_pattern" id="date_pattern" class="form-control" placeholder="YYYY-MM-DD" value="{{ $userprefs->date_pattern ?? '' }}">
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <label>Time Format</label>
                        <input type="text" name="time_format" id="time_format" class="form-control" placeholder="HH:MM:SS" value="{{ $userprefs->time_format ?? '' }}">
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <label>Time Zone</label>
                        <select name="time_zone" id="time_zone" class="form-control">
                          <option {{ isset($userprefs->time_zone) && $userprefs->time_zone == 'Asia/Kolkata' ? 'selected' : '' }} value="Asia/Kolkata">Asia/Kolkata</option>
                          <option {{ isset($userprefs->time_zone) && $userprefs->time_zone == 'America/New_York' ? 'selected' : '' }} value="America/New_York">America/New_York</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-4">
                      <div class="form-group">
                        <ul class="list-unstyled mb-0">
                          <li class="d-inline-block mr-2">
                            <fieldset>
                              <div class="vs-checkbox-con vs-checkbox-primary">
                                <input type="checkbox" {{ isset($userprefs->notify_by_sms) && $userprefs->notify_by_sms == 'Y' ? 'checked' : '' }} name="notify_by_sms" value="Y">
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
                    <div class="col-4">
                      <div class="form-group">
                        <ul class="list-unstyled mb-0">
                          <li class="d-inline-block mr-2">
                            <fieldset>
                              <div class="vs-checkbox-con vs-checkbox-primary">
                                <input type="checkbox" {{ isset($userprefs->notify_by_email) && $userprefs->notify_by_email == 'Y' ? 'checked' : '' }} name="notify_by_email" value="Y">
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
                    <div class="col-4">
                      <div class="form-group">
                        <ul class="list-unstyled mb-0">
                          <li class="d-inline-block mr-2">
                            <fieldset>
                              <div class="vs-checkbox-con vs-checkbox-primary">
                                <input type="checkbox" {{ isset($userprefs->notify_by_wa) && $userprefs->notify_by_wa == 'Y' ? 'checked' : '' }} name="notify_by_wa" value="Y">
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
                <div class="col-12 col-sm-4">
                  <div class="form-group">
                    <div class="controls">
                      <label>Address Line 1</label>
                      <input type="hidden" name="useraddress_id" value="{{ $useraddress->id ?? '' }}">
                      <input type="hidden" name="addr_type" id="addr_type" value="PERMANENT">
                      <input type="text" name="street_addr1" id="street_addr1" class="form-control" placeholder="Address Line 1" value="{{ $useraddress->street_addr1 ?? '' }}">
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="controls">
                      <label for="police_station">Police Station</label>
                      <input type="text" name="police_station" id="police_station" class="form-control" placeholder="Police Station" value="{{ $useraddress->police_station ?? '' }}">
                    </div>
                  </div>         
                  <div class="form-group">
                    <div class="controls">
                      <label for="city">City</label>
                      <input type="text" name="city" id="city" class="form-control" placeholder="City" value="{{ $useraddress->city ?? '' }}">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label for="state">State</label>
                      <input type="text" name="state" id="state" class="form-control" placeholder="State" value="{{ $useraddress->state ?? '' }}">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label for="country">Country</label>
                      <input type="text" name="country" id="country" class="form-control" placeholder="Country" value="{{ $useraddress->country ?? '' }}">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label for="pincode">Pin Code</label>
                      <input type="text" name="pincode" id="pincode" class="form-control" placeholder="Pin Code" value="{{ $useraddress->pincode ?? '' }}">
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Employer Type</label>
                    <select name="employer_type" id="employer_type" class="form-control">
                      <option value="">Select Option</option>
                      <option {{ $employer->employer_type == 'SCHOOL' ? 'selected' : '' }} value="SCHOOL">SCHOOL</option>
                      <option {{ $employer->employer_type == 'SME' ? 'selected' : '' }} value="SME">SME</option>
                      <option {{ $employer->employer_type == 'FMCG' ? 'selected' : '' }} value="FMCG">FMCG</option>
                      <option {{ $employer->employer_type == 'RETAIL' ? 'selected' : '' }} value="RETAIL">RETAIL</option>
                      <option {{ $employer->employer_type == 'GOVERNMENT' ? 'selected' : '' }} value="GOVERNMENT">GOVERNMENT</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Billing Plan</label>
                    <select name="billing_plan_id" id="billing_plan_id" class="form-control">
                      <option value="">Select Plan</option>
                      @if($plans)
                        @foreach($plans as $plan)
                          <option {{ $employer->billing_plan_id == $plan->id ? 'selected' : '' }} value="{{ $plan->id }}">{{ $plan->name }}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>

              </div>
              </div>
                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                  <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save Changes</button>
                  <button type="reset" class="btn btn-outline-warning">Reset</button>
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

