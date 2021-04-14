@extends('layouts/contentLayoutMaster')
@section('title', 'Create Surveys')
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
<!-- surveys edit start -->
<div class="row">
  <div class="col-12 col-sm-5">
    <section class="users-edit">
      <div class="card">
        <div class="card-content">
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                <!-- surveys edit account form start -->
                <form novalidate action="{{ url('surveys/store') }}" method="post" enctype="multipart/form-data">
                  {{ csrf_field() }}
                  
                  <div class="form-group">
                    <label>Select Employers</label>
                    <select name="employer_id" id="employer_id" class="form-control">
                      <option value="">Select Employers</option>
                      @if($employers)
                        @foreach($employers as $employer)
                          <option value="{{ $employer->id }}">{{ $employer->b2b_company_name.' -- '.$employer->b2b_brand_name }}</option>
                        @endforeach
                      @endif
                    </select>
                    @if($errors->has('employer_id'))
                      <p class="text-danger">{{ $errors->first('employer_id') }}</p>
                    @endif
                  </div>

                  <div class="form-group">
                    <label>Employee</label>
                    <select name="employee_id" id="employee_id" class="form-control">
                      <option value="">Select Employee</option>
                      @if($employees)
                        @foreach($employees as $employee)
                          <option value="{{ $employee->id }}">{{ $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name }}</option>
                        @endforeach
                      @endif
                    </select>
                    @if($errors->has('employee_id'))
                      <p class="text-danger">{{ $errors->first('employee_id') }}</p>
                    @endif
                  </div>
                  
                  <div class="row">
                    <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                      <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save Changes</button>
                      <button type="reset" class="btn btn-outline-warning">Reset</button>
                    </div>
                  </div> 
                </form>
                <!-- surveys edit account form ends -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- surveys edit ends -->
  </div>
</div>
@endsection

@section('vendor-script')
  {{-- Vendor js files --}}
  <script src="{{ asset(mix('vendors/js/forms/validation/jqBootstrapValidation.js')) }}"></script>
@endsection

@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset(mix('js/scripts/pages/app-user.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/navs/navs.js')) }}"></script>
  <script type="text/javascript">
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $("#employer_id").on('change', function(e){
      e.preventDefault();
      var employer_id = $("#employer_id").val();
      $.ajax({
        type :'POST',
        url  :'/orders/getallemployee',
        data: {
          employer_id : employer_id,
          source : 'B2B'
        },
        success:function(data){
          $('#employee_id').html(data);
        }
      });
    });
  </script>
@endsection

