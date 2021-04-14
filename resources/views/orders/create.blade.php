@extends('layouts/contentLayoutMaster')
@section('title', 'Create Orders')
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
    div#check_aadhar_div {
      margin-left: 13px;
    }
    #check_aadhar_div p {
      margin-bottom: 5px;
      font-size: 13px;
      font-weight: 600;
      border-bottom: 1px solid #ccc;
      padding-bottom: 9px;
    }
    div#CRC_address {
      margin-left: 13px;
    }
    #CRC_address p, #employment_check_div p {
      margin-bottom: 5px;
      font-size: 13px;
      font-weight: 600;
      border-bottom: 1px solid #ccc;
      padding-bottom: 9px;
    }
    div#AV_PHYSICAL_address {
      margin-left: 13px;
    }
    #AV_PHYSICAL_address p, #employment_check_div p {
      margin-bottom: 5px;
      font-size: 13px;
      font-weight: 600;
      border-bottom: 1px solid #ccc;
      padding-bottom: 9px;
    }
    div#AV_POSTAL_address {
      margin-left: 13px;
    }
    #AV_POSTAL_address p, #employment_check_div p {
      margin-bottom: 5px;
      font-size: 13px;
      font-weight: 600;
      border-bottom: 1px solid #ccc;
      padding-bottom: 9px;
    }
    div#AV_DIGITAL_address {
      margin-left: 13px;
    }
    #AV_DIGITAL_address p, #employment_check_div p {
      margin-bottom: 5px;
      font-size: 13px;
      font-weight: 600;
      border-bottom: 1px solid #ccc;
      padding-bottom: 9px;
    }
    div#employment_check_div, div#NID_PAN_VERIFICATION, div#education_check_div {
      margin-left: 28px;
    }
    .form-group.main-frm {
      width: 25%;
    }
    span#close {
      position: absolute;
      right: 14px;
      top: -19px;
      height: 25px;
      width: 25px;
      background: red;
      padding: 3px 8px;
      color: #fff;
      font-weight: 600;
      border-radius: 50%;
      cursor: pointer;
    }
  </style>
@endsection

@section('content')
<!-- orders edit start -->
<section class="orders-edit">
  <div class="card">
    <div class="card-content">
      <div class="card-body">
        <div class="tab-content">
          <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
            <!-- orders edit account form start -->
            <form novalidate action="{{ url('orders/store') }}" id="frm_create_order" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-12 col-sm-12">
                  <div class="form-group main-frm">
                    <label>Source</label>
                    <select name="source" id="source" class="form-control">
                      <option {{ $source == 'B2B' ? 'selected' : '' }} value="B2B">B2B</option>
                      <option {{ $source == 'B2C' ? 'selected' : '' }} value="B2C">B2C</option>
                    </select>
                  </div>

                  <div class="form-group main-frm">
                    <label>Order Recieve Date</label>
                    <input type="date" name="received_date" id="received_date" value="{{ date('Y-m-d') }}" class="form-control" />
                  </div>

                  <div class="form-group main-frm">
                    <label>Company</label>
                    <select name="employer_id" id="employer_id" class="form-control">
                      <option value="">Select Company</option>
                      @if($employers)
                        @foreach($employers as $employer)
                          <option {{ (!empty($_GET['eid']) && $_GET['eid'] == $employer->id) ? 'selected' : '' }} value="{{ $employer->id }}">
                            @if(!empty($employer->b2b_company_name))
                              {{ $employer->b2b_company_name }} 
                              @if(!empty($employer->b2b_brand_name))
                                -({{ $employer->b2b_brand_name }})
                              @endif
                            @else
                              {{ $employer->first_name }} {{ $employer->middle_name }} {{ $employer->last_name }}
                            @endif
                          </option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                  <div class="form-group main-frm">
                    <label>Employee</label>
                    <select name="employee_id" id="employee_id" class="form-control">
                      <option value="">Select Employee</option>
                      @if($employees)
                        @foreach($employees as $employee)
                          <option {{ (!empty($_GET['uid']) && $_GET['uid'] == $employee->employee_id) ? 'selected' : '' }} value="{{ $employee->employee_id }}">{{ $employee->first_name }} {{ $employee->middle_name }} {{ $employee->last_name }}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                  <div class="form-group main-frm">
                    <label>Verifications</label>
                  </div>
                  @if($verificationtypes)
                    <ul class="list-unstyled mb-0 row">
                      @foreach($verificationtypes as $verification)
                        <li class="d-inline-block mr-2 col-12">
                          <fieldset>
                            <div class="vs-checkbox-con vs-checkbox-primary">
                              <input 
                                @if($verification->name == 'CRC' || $verification->name == 'AV_PHYSICAL' || $verification->name == 'AV_DIGITAL' || $verification->name == 'AV_POSTAL')
                                  onclick="showAddress(this)"
                                @endif
                                @if($verification->name == 'EDUCATION_VERIFICATION')
                                  onclick="showEducation(this)"
                                @endif
                                @if($verification->name == 'EMPLOYMENT_CHECK')
                                  onclick="showEmployement(this)"
                                @endif
                                @if($verification->name == 'NID_AADHAAR')
                                  onclick="check_aadhar(this)"
                                @endif
                                @if($verification->name == 'NID_PAN')
                                  onclick="add_pan_fields(this)"
                                @endif
                                type="checkbox" 
                                id="verifications_{{ $verification->id }}" 
                                name="varifications[]" 
                                value="{{ $verification->id }}"
                                data-id="{{ $verification->name }}" />
                              <span class="vs-checkbox">
                                <span class="vs-checkbox--check">
                                  <i class="vs-icon feather icon-check"></i>
                                </span>
                              </span>
                              <span class="" style="font-size: 0.85rem;">{{ $verification->name }}</span>
                            </div>

                            @if($verification->name == 'CRC' || $verification->name == 'AV_PHYSICAL' || $verification->name == 'AV_DIGITAL' || $verification->name == 'AV_POSTAL')
                              <div class="row" id="{{ $verification->name }}_address" style="display: none;">
                                
                              </div>
                            @endif

                            @if($verification->name == 'NID_PAN')
                              <div class="row" id="NID_PAN_VERIFICATION" style="display: none;">
                                
                              </div>
                            @endif

                            @if($verification->name == 'EDUCATION_VERIFICATION')
                            <div class="emp_dtls" id="education_check_div" style="display: none;">
                              <p>Add Education Details <button class="btn btn-sm btn-success" type="button" onclick="add_education_fields()" style="float: right;">Add Education Details</button></p>                           
                            </div>
                            @endif

                            @if($verification->name == 'EMPLOYMENT_CHECK')
                            <div class="emp_dtls" id="employment_check_div" style="display: none;">
                              <p>Add Employment Details <button class="btn btn-sm btn-success" type="button" onclick="add_employment_fields()" style="float: right;">Add Employment Details</button></p>                           
                            </div>
                            @endif

                            @if($verification->name == 'NID_AADHAAR')
                            <div class="aadhaar_dtls" id="check_aadhar_div" style="display: none;">
                              <p>
                                <style type="text/css">
                                  .aadhaar_dtls label {
                                    cursor: pointer;
                                    padding: 1px 10px;
                                    background: #7367f0;
                                    color: #fff;
                                    font-weight: 600;
                                    border-radius: 10px;
                                  }

                                  #NID_AADHAAR_FRONT_br, #NID_AADHAAR_BACK_br {
                                    opacity: 0;
                                    position: absolute;
                                    z-index: -1;
                                  }
                                </style>
                                Aadhaar Details 
                                <span style="float: right;">
                                  <input type="text" name="document_number" id="document_number" value="" placeholder="Aadhaar Number" />
                                  <label for="NID_AADHAAR_FRONT_br">Upload Front</label>
                                  <input type="file" name="NID_AADHAAR_FRONT_br" id="NID_AADHAAR_FRONT_br" style="float: right;" /> 
                                  <label for="NID_AADHAAR_FRONT_br">Upload Back</label>
                                  <input type="file" name="NID_AADHAAR_BACK_br" id="NID_AADHAAR_BACK_br" onchange="upload_aadhaar('back')" style="float: right;" />
                                  <input type="hidden" name="NID_AADHAAR_FRONT" id="NID_AADHAAR_FRONT" value="">
                                  <input type="hidden" name="NID_AADHAAR_BACK" id="NID_AADHAAR_BACK" value="">
                                </span>
                              </p>                           
                            </div>
                            @endif
                          </fieldset>
                        </li>                        
                      @endforeach
                    </ul>
                  @endif
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

<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Address</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" id="frm_add_address" name="" method="POST">
          <div class="row mt-1">
            <div class="col-12">
              <span id="msgds"></span>
            </div>
          </div>
          <div class="row mt-1">
            <div class="col-12 col-sm-6">
              <div class="form-group">
                <label>Address Type</label>
                <input type="hidden" name="verfy_type" id="verfy_type" value="">
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
                  <input type="text" name="post_office" id="post_office" class="form-control" placeholder="Post Office">
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
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" onclick="add_address()" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


@endsection

@section('vendor-script')
  {{-- Vendor js files --}}
  <script src="{{ asset(mix('vendors/js/forms/validation/jqBootstrapValidation.js')) }}"></script>
@endsection

@section('page-script')
  {{-- Page js files --}}
  <script src="{{ url('js/scripts/state.js') }}"></script>
  <script src="{{ asset(mix('js/scripts/pages/app-user.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/navs/navs.js')) }}"></script>
    <script type="text/javascript">
    $('#source').on('change', function(){
      var source = $('#source').val();
      location.href = '/orders/create?source='+source;
    });

    function set_dd_val(var_val){
      $('#verfy_type').val(var_val);
    }
  </script>
  <script type="text/javascript">
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $("#employer_id").on('change', function(e){
      e.preventDefault();
      var employer_id = $("#employer_id").val();
      var source = $("#source").val();
      $.ajax({
        type :'POST',
        url  :'/orders/getemployee',
        data: {
          employer_id : employer_id,
          source : source
        },
        success:function(data){
          $('#employee_id').html(data);
        }
      });
    });

    function showAddress(check){
      var employee_id = $('#employee_id').val();
      var verifications_type = $(check).data('id');

      if(employee_id == ''){
        $(check).prop("checked", false);
        alert('Please Select Employee First');
        return false;
      }

      if ($(check).prop("checked") == true) {
        $.ajax({
          type :'POST',
          url  :'/orders/get-address',
          data: {
            employee_id : employee_id,
            verifications_type : verifications_type,
          },
          success:function(data){
            $('#'+ verifications_type +'_address').removeAttr('style');
            $('#'+ verifications_type +'_address').html(data);
          }
        });
      } else {
        $('#'+ verifications_type +'_address').css('display', 'none !important');
        $('#'+ verifications_type +'_address').empty();
      }
    }

    function showEmployement(check){
      if ($(check).prop("checked") == true) {
        $('#employment_check_div').removeAttr('style');
      } else {
        $('#employment_check_div').css('display', 'none');
      }
    }

    function showEducation(check){
      if ($(check).prop("checked") == true) {
        $('#education_check_div').removeAttr('style');
      } else {
        $('#education_check_div').css('display', 'none');
      }
    }

    function add_address() {
      $.ajax({
        type :'POST',
        url  :'/orders/add-address',
        data: {
          employee_id : $('#employee_id').val(),
          type : $('#addr_type').val(),
          street_addr1 : $('#street_addr1').val(),
          street_addr2 : $('#street_addr2').val(),
          village : $('#village').val(),
          post_office : $('#post_office').val(),
          police_station : $('#police_station').val(),
          district : $('#district').val(),
          near_by : $('#near_by').val(),
          city : $('#city').val(),
          state : $('#choosestate').val(),
          pincode : $('#pincode').val(),
          country : $('#country').val(),
          verifications_type : $('#verfy_type').val(),
        },
        success:function(data){
          if(data != 'FAILED'){
            $('#frm_add_address').find("input[type=text], select, textarea").val("");
            $('#msgds').html('Added Successfully!!');
            $('#crc_address').append(data);
          } else {
            $('#msgds').html('Not Added!! Somthing Wrong');
          }
        }
      });
    }

    function add_education_fields() {
      $.ajax({
        type :'POST',
        url  :'/orders/add-education-fields',
        success:function(data){
          $('#education_check_div').append(data);
        }
      });
    }

    function add_employment_fields() {
      $.ajax({
        type :'POST',
        url  :'/orders/add-employment-fields',
        success:function(data){
          $('#employment_check_div').append(data);
        }
      });
    }

    function add_pan_fields(check) {
      if ($(check).prop("checked") == true) {      
        $('#NID_PAN_VERIFICATION').removeAttr('style');
        $.ajax({
          type :'POST',
          url  :'/orders/add-pan-fields',
          success:function(data){
            $('#NID_PAN_VERIFICATION').append(data);
          }
        });
      } else {
        $('#NID_PAN_VERIFICATION').html('');
        $('#NID_PAN_VERIFICATION').css('display', 'none');
      }
    }

    function check_aadhar(check) {
      var employee_id = $('#employee_id').val();
      var verifications_type = $(check).data('id');

      if(employee_id == ''){
        $(check).prop("checked", false);
        alert('Please Select Employee First');
        return false;
      }

      $.ajax({
        type :'POST',
        url  :'/orders/check-aadhar',
        data: {
          employee_id : $('#employee_id').val(),
          employer_id : $('#employer_id').val(),
        },
        success:function(data){
          if(data == 'NOT_EXIST'){
            $('#check_aadhar_div').removeAttr('style');
          } else {
            $('#check_aadhar_div').css('display', 'none');
          }
        }
      });
    }
    
    $('#NID_AADHAAR_FRONT_br').on('change', function(evt){
      evt.preventDefault();
      var formData = new FormData($("#frm_create_order")[0]);
      $.ajax({
        url: "{{ url('upload-document') }}",
        type: "POST",
        data: formData,
        success: function (data) {
          console.log('uploaded');
        }
      });
    })

    function remove_div(del){
      $(del).parent().remove();
    }
  </script>
@endsection