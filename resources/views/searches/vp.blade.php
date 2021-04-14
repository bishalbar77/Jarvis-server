@extends('layouts/contentLayoutMaster')

@section('title', 'Search VP')

@section('vendor-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/ag-grid/ag-grid.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/ag-grid/ag-theme-material.css')) }}">
@endsection

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/pages/app-user.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/pages/aggrid.css')) }}">
  <style type="text/css">
    tr {
      /*cursor: pointer !important;*/
    }
    a {
      display: block;
    }
  </style>
@endsection

@section('content')
<!-- users list start -->
<section class="users-list-wrapper">
  <!-- users filter start -->
  <div class="card">
    <div class="card-header">
      <h4 class="card-title">Search</h4>
      <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
      <div class="heading-elements">
        <ul class="list-inline mb-0">
          <li><a data-action="collapse"><i class="feather icon-chevron-down"></i></a></li>
          <li><a href="{{ url('/orders/tasks') }}"><i class="feather icon-rotate-cw users-data-filter"></i></a></li>
          <li><a data-action="close"><i class="feather icon-x"></i></a></li>
        </ul>
      </div>
    </div>
    <div class="card-content collapse show">
      <div class="card-body">
        <div class="users-list-filter">
          <form id="frm-filter" action="{{ url('/searches/vp') }}" method="get">
            <div class="row">

              <div class="col-6 col-sm-4 col-lg-2">
                <div class="form-group">
                  <label for="users-list-status">Search Task ID</label>
                  <select name="task_id" id="task_id" class="select2 form-control">
                    <option value="">Select</option>
                    @if($tasks)
                      @foreach($tasks as $task)
                        <option value="{{ $task->task_number }}">{{ $task->task_number }}</option>
                      @endforeach
                    @endif
                  </select>
                </div>
              </div>
              
              <div class="col-6 col-sm-4 col-lg-2">
                <label for="name">Candidate Name</label>
                <fieldset class="form-group">
                  <input type="text" class="form-control" name="name" id="name" placeholder="Search by Candidate Name" value="{{ $request['name'] ?? '' }}" required="">
                </fieldset>
              </div>

              <div class="col-6 col-sm-4 col-lg-2">
                <label for="address">Address</label>
                <fieldset class="form-group">
                  <textarea class="form-control" name="address" id="address" placeholder="Address" required="">{{ $request['address'] ?? '' }}</textarea>
                </fieldset>
              </div>

              <div class="col-6 col-sm-4 col-lg-2">
                <label for="father_name">Father Name</label>
                <fieldset class="form-group">
                  <input type="text" class="form-control" name="father_name" id="father_name" placeholder="Search by Candidate Name" value="{{ $request['father_name'] ?? '' }}">
                </fieldset>
              </div>

              <div class="col-6 col-sm-4 col-lg-2">
                <label for="state_name">Select State</label>
                <fieldset class="form-group">
                  <select name="state_name" id="state_name" class="select2 form-control">
                    <option value="">All</option>
                    <option value="MAHARASHTRA">MAHARASHTRA</option>
                    <option value="ANDHRA PRADESH">ANDHRA PRADESH</option>
                    <option value="KARNATAKA">KARNATAKA</option>
                    <option value="KERALA">KERALA</option>
                    <option value="HIMACHAL PRADESH">HIMACHAL PRADESH</option>
                    <option value="ASSAM">ASSAM</option>
                    <option value="JHARKHAND">JHARKHAND</option>
                    <option value="BIHAR">BIHAR</option>
                    <option value="RAJASTHAN">RAJASTHAN</option>
                    <option value="TAMIL NADU">TAMIL NADU</option>
                    <option value="ORISSA">ORISSA</option>
                    <option value="JAMMU AND KASHMIR">JAMMU AND KASHMIR</option>
                    <option value="UTTAR PRADESH">UTTAR PRADESH</option>
                    <option value="HARYANA">HARYANA</option>
                    <option value="UTTARAKHAND">UTTARAKHAND</option>
                    <option value="WEST BENGAL">WEST BENGAL</option>
                    <option value="GUJARAT">GUJARAT</option>
                    <option value="CHHATTISGARH">CHHATTISGARH</option>
                    <option value="MIZORAM">MIZORAM</option>
                    <option value="TRIPURA">TRIPURA</option>
                    <option value="MEGHALAYA">MEGHALAYA</option>
                    <option value="PUNJAB">PUNJAB</option>
                    <option value="MADHYA PRADESH">MADHYA PRADESH</option>
                    <option value="SIKKIM">SIKKIM</option>
                    <option value="MANIPUR">MANIPUR</option>
                    <option value="DELHI">DELHI</option>
                    <option value="CHANDIGARH">CHANDIGARH</option>
                    <option value="ANDAMAN AND NICOBAR">ANDAMAN AND NICOBAR</option>
                    <option value="TELANGANA">TELANGANA</option>
                    <option value="GOA">GOA</option>
                    <option value="DIU AND DAMAN">DIU AND DAMAN</option>
                    <option value="DNH AT SILVASA">DNH AT SILVASA</option>
                  </select>
                </fieldset>
              </div>

              <div class="col-6 col-sm-4 col-lg-2">
                <fieldset class="form-group">
                  <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1" style="margin-top: 20px;">Search</button>
                </fieldset>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- users filter end -->
  @if(isset($cases) && !empty($cases[0]))
  <!-- Ag Grid users list section start -->
  <div id="basic-examples">
    <div class="card">
      <div class="card-content">
        <div class="card-body">
          <!-- Hoverable rows start -->
          <div class="row" id="table-hover-row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Matched Name</th>
                                  <th>Matched Address</th>
                                  <th>Dist. Name</th>
                                  <th>State Name</th>
                                  <th>Case Category</th>
                                  <th>Petitoner/Respondant</th>
                                  <th>Court Name</th>
                                  <th>Ecourt Link</th>
                                  <th>Case Type</th>
                                  <th>FIR No.</th>
                                  <th>PS Name</th>
                                  <th>Act Name</th>
                                  <th>Under Section</th>
                                  <th>Score %</th>
                                </tr>
                              </thead>
                                                                
                              <tbody>
                                @foreach($cases as $key => $case)
                                  <tr>
                                    <th>{{ $key + 1 }}</th>
                                    <th>{{ $case->name ?? '' }}</th>
                                    <th>{{ $case->address ?? '' }}</th>
                                    <th>{{ $case->address_district ?? '' }}</th>
                                    <th>{{ $case->state_name ?? '' }}</th>
                                    <th>{{ $case->case_category ?? '' }}</th>
                                    <th>{{ $case->type == 0 ? 'Petitioner' : 'Respondent' }}</th>
                                    <th>{{ $case->court_name ?? '' }}</th>
                                    <th><a href="{{ $case->link ?? '' }}" target="_blank"> View </a></th>
                                    <th>{{ $case->case_type ?? '' }}</th>
                                    <th>{{ $case->fir_no ?? '' }}</th>
                                    <th>{{ $case->police_station ?? '' }}</th>
                                    <th>{{ $case->under_acts ?? '' }}</th>
                                    <th>{{ $case->under_sections ?? '' }}</th>
                                    <th>{{ $case->score ?? '' }}</th>
                                  </tr>
                                @endforeach
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
          </div>
          <!-- Hoverable rows end -->
        </div>
      </div>
    </div>
  </div>
  <!-- Ag Grid users list section end -->
  @endif
</section>
<!-- users list ends -->
@endsection

@section('vendor-script')
  {{-- Vendor js files --}}
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/validation/jqBootstrapValidation.js')) }}"></script>
@endsection

@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset(mix('js/scripts/forms/select/form-select2.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/pages/app-user.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/navs/navs.js')) }}"></script>
  <script type="text/javascript">
    function filterFrm(){
      $('#frm-filter').submit();
    }
  </script>
  <script type="text/javascript">
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $("#task_id").on('change', function(e){
      e.preventDefault();
      $.ajax({
        url  :'/searches/get-info',
        method : 'GET',
        dataType: 'json',
        data : {
          'task_id' : $(this).val()
        },
        success:function(data){
          $('#name').val(data[0].name);
          $('#address').val(data[0].address);
          $('#father_name').val(data[0].father_name);
        }
      });
    });
  </script>
@endsection