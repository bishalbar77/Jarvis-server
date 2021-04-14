@php
  $ancData = '';

  $aData = $lastTaskHistory->antecedants_data ?? '';

  $ancData = json_decode($aData);
  
  $ancData = $ancData->report_data ?? '';

  if(isset($ancData->reports) && !empty($ancData->reports)):
    foreach($ancData->reports as $reps):

      $str = explode("%URL%",$reps);
      $caseIds[] = $str[0];
    endforeach;
  else:
    $caseIds = array();
  endif;

  //echo '<pre>';
  //print_r($caseIds);
  //exit;

  $report_case_id = $ancData->report_details->case_id ?? '';
  $name_found = $ancData->report_details->name_found ?? '';
  $address_found = $ancData->report_details->address_found ?? '';
  $reg_no = $ancData->report_details->reg_no ?? '';
  $court_name = $ancData->report_details->court_name ?? '';
  $stage_of_case = $ancData->report_details->stage_of_case ?? '';
  $fir_no_year = $ancData->report_details->fir_no_year ?? '';
  $police_station = $ancData->report_details->police_station ?? '';
  $act_name = $ancData->report_details->act_name ?? '';
  $section_details = $ancData->report_details->section_details ?? '';

  $task_id = $_GET['task_id'] ?? '';
@endphp
@extends('layouts/contentLayoutMaster')

@section('title', 'Search CRC')

@section('vendor-style')
  {{-- Page Css files --}}
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
    /*a {
      display: block;
    }*/
    tr.selected {
      background: #ccc;
    }
    .top-buttons {
      list-style: none;
      margin-left: -41px;
    }
    #top-buttons li {
      display: inline;
      margin-right: 10px;
    }
    .collapse-bordered .card .card-body {
      padding: 0px 0px;
      line-height: 1;
    }
    label {
      margin-bottom: 7px;
    }
    .addDelBtn {
      text-align: right;
    }
  </style>
@endsection

@section('content')
<!-- users list start -->
<section class="users-list-wrapper">
  <!-- users filter start -->
  <div class="card" style="margin-bottom: 1.2rem;">
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
          <form id="frm-filter" action="{{ url('/searches/cosmos') }}" method="get">
            {{ csrf_field() }}
            <div class="row">
              
              <div class="col-6 col-sm-4 col-lg-2">
                <label for="name">Candidate Name</label>
                <fieldset class="form-group">
                  <input type="text" class="form-control" name="name" id="name" placeholder="Search by Candidate Name" value="{{ $request['name'] ?? '' }}">
                </fieldset>
              </div>

              <div class="col-6 col-sm-4 col-lg-2">
                <label for="address">Address</label>
                <fieldset class="form-group">
                  <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="{{ $request['address'] ?? '' }}">
                </fieldset>
              </div>

              <!-- <div class="col-6 col-sm-4 col-lg-2">
                <label for="users-list-status">Select State</label>
                <fieldset class="form-group">
                  <select name="state_code" class="form-control" onchange="filterFrm()">
                    <option value="">All</option>
                  </select>
                </fieldset>
              </div>
              
              <div class="col-6 col-sm-4 col-lg-2">
                <label for="users-list-status">Select District</label>
                <fieldset class="form-group">
                  <select name="dist_code" class="form-control" onchange="filterFrm()">
                    <option value="">All</option>
                  </select>
                </fieldset>
              </div> -->

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

  @if($caseIds)
    <div class="row">
      <div class="col-12">
        <button id="final-submit" class="btn btn-primary"type="button" style="margin-bottom: 15px;">Save</button>
        <ul class="top-buttons" id="top-buttons" style="display: none;">
          <li>
          </li>
          @foreach($caseIds as $key => $caseId)
            <li>
              <button id="pop-btn-{{ $key + 1 }}" onclick="open_popup(this)" class="btn btn-sm btn-primary" data-order="{{ $key + 1 }}" data-id="{{ $caseId }}" type="button">Case {{ $key + 1 }}</button>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  @endif

  <div class="row" style="margin-bottom: 15px;">
    <div class="col-12">
      <button type="button" onclick="document.getElementById('frm_reports').submit()" class="btn btn-primary">Save</button>
      <br>
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
              <form id="frm_reports" action="{{ url('orders/crc-ancedents-update/'.$task_id) }}" method="POST">
                {{ csrf_field() }}
              <div class="default-collapse collapse-bordered">
                <div class="card collapse-header">
                  <div id="headingCollapse1" class="card-header" data-toggle="collapse" role="button" data-target="#collapse1"
                      aria-expanded="false" aria-controls="collapse1">
                    <span class="lead collapse-title">
                      COSMOS ({{ count($cases) }})
                    </span>
                  </div>
                  <div id="collapse1" role="tabpanel" aria-labelledby="headingCollapse1" class="collapse">
                    <div class="card-content">
                      <div class="card-body">
                        <div class="table-responsive">
                          <table class="table table-hover mb-0">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th style="min-width: 200px !important;">Matched Name</th>
                                <th style="min-width: 200px !important;">Matched Address</th>
                                <th style="min-width: 200px !important;">Dist. Name</th>
                                <th style="min-width: 100px !important;">State Name</th>
                                <th style="min-width: 200px !important;">Case Category</th>
                                <th style="min-width: 200px !important;">Petitoner/Respondant</th>
                                <th style="min-width: 200px !important;">Court Name</th>
                                <th style="min-width: 100px !important;">Ecourt Link</th>
                                <th style="min-width: 200px !important;">Case Type</th>
                                <th style="min-width: 200px !important;">FIR No.</th>
                                <th style="min-width: 200px !important;">PS Name</th>
                                <th style="min-width: 200px !important;">Act Name</th>
                                <th style="min-width: 200px !important;">Under Section</th>
                                <th style="min-width: 80px !important;">Score %</th>
                              </tr>
                            </thead>                                                             
                            <tbody>
                              @if(isset($cases) && !empty($cases))
                              @foreach($cases as $count => $case)
                                <tr class="{{ $case->id == $report_case_id ? 'selected' : '' }}" style="cursor: pointer;">
                                  <th>
                                    <input onchange="showButtons(this, '{{ $count + 1 }}')" {{ in_array($case->id, $caseIds) ? 'checked' : '' }} type="checkbox" name="reports[]" id="reports-{{ $case->id }}" value="{{ $case->id }}">
                                  </th>
                                  <th onclick="open_popup(this, '{{ $case->id }}')" >{{ $case->name }}</th>
                                  <th onclick="open_popup(this, '{{ $case->id }}')" >{{ $case->address }}</th>
                                  <th onclick="open_popup(this, '{{ $case->id }}')" >{{ $case->dist_name }}</th>
                                  <th onclick="open_popup(this, '{{ $case->id }}')" >{{ $case->state_name }}</th>
                                  <th onclick="open_popup(this, '{{ $case->id }}')" >{{ '' }}</th>
                                  <th onclick="open_popup(this, '{{ $case->id }}')" >{{ '' }}</th>
                                  <th onclick="open_popup(this, '{{ $case->id }}')" >{{ $case->court_no_name }}</th>
                                  <th><a href="{{ $case->link }}" target="_blank"> View </a></th>
                                  <th onclick="open_popup(this, '{{ $case->id }}')" >{{ $case->case_type }}</th>
                                  <th onclick="open_popup(this, '{{ $case->id }}')" >{{ $case->fir_no }}</th>
                                  <th onclick="open_popup(this, '{{ $case->id }}')" >{{ $case->police_station }}</th>
                                  <th onclick="open_popup(this, '{{ $case->id }}')" >{{ $case->under_acts }}</th>
                                  <th onclick="open_popup(this, '{{ $case->id }}')" >{{ $case->under_sections }}</th>
                                  <th onclick="open_popup(this, '{{ $case->id }}')" >{{ '' }}
                          
                                    {{-- Add Comment Modal --}}
                                    <div class="modal fade text-left" id="inlineForm_{{ $case->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel{{ $case->id }}" aria-hidden="true">
                                      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document" style="max-width: 800px; cursor: auto;">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel{{ $case->id }}">Add Comments</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                            
                                            <div class="modal-body">
                                              
                                              <div class="row">
                                                <div class="col-6">
                                                  <div class="form-group">
                                                    <label for="name_found_{{ $case->id }}">Name found in court</label>
                                                    <input type="text" value="{{ $case->name }}" name="case[{{ $case->id }}][name_found]" id="name_found_{{ $case->id }}" class="form-control" placeholder="Name found in court" />
                                                  </div>
                                                </div>
                                                <div class="col-6">
                                                  <div class="form-group">
                                                    <label for="address_found_{{ $case->id }}">Address found in court</label>
                                                    <input type="text" value="{{ $case->address }}" name="case[{{ $case->id }}][address_found]" id="address_found_{{ $case->id }}" class="form-control" placeholder="Address Found in court" />
                                                  </div>
                                                </div>
                                              </div>

                                              <div class="row">
                                                <div class="col-6">
                                                  <div class="form-group">
                                                    <label for="reg_no_{{ $case->id }}">Registration Number & Year</label>
                                                    <input type="text" value="{{ $case->registration_no }}" name="case[{{ $case->id }}][reg_no]" id="reg_no_{{ $case->id }}" class="form-control" placeholder="Registration Number & Year" />
                                                  </div>
                                                </div>
                                                <div class="col-6">
                                                  <div class="form-group">
                                                    <label for="court_name_{{ $case->id }}">Court name</label>
                                                    <input type="text" value="{{ $case->court_no_name }}" name="case[{{ $case->id }}][court_name]" id="court_name_{{ $case->id }}" class="form-control" placeholder="Court name" />
                                                  </div>
                                                </div>
                                              </div>

                                              <div class="row">
                                                <div class="col-6">
                                                  <div class="form-group">
                                                    <label for="stage_of_case_{{ $case->id }}">Stage of Case</label>
                                                    <input type="text" value="{{ $case->case_status  ?? '' }}" name="case[{{ $case->id }}][stage_of_case]" id="stage_of_case_{{ $case->id }}" class="form-control" placeholder="Stage of Case" />
                                                  </div>
                                                </div>
                                                <div class="col-6">
                                                  <div class="form-group">
                                                    <label for="fir_no_year_{{ $case->id }}">FIR No. & Year</label>
                                                    <input type="text" value="{{ $case->fir_no }}" name="case[{{ $case->id }}][fir_no_year]" id="fir_no_year_{{ $case->id }}" class="form-control" placeholder="FIR No. & Year" />
                                                  </div>
                                                </div>
                                              </div>

                                              <div class="row">
                                                <div class="col-6">
                                                  <div class="form-group">
                                                    <label for="police_station_{{ $case->id }}">Police Station</label>
                                                    <input type="text" name="case[{{ $case->id }}][police_station]" id="police_station_{{ $case->id }}" class="form-control" placeholder="Police Station" />
                                                  </div>
                                                </div>
                                              </div>

                                              <div class="addRow">
                                                <div class="row">
                                                  <div class="col-5">
                                                    <div class="form-group">
                                                      <label for="act_name_{{ $case->id }}">Act Name</label>
                                                      <select name="case[{{ $case->id }}][act_name][]" id="act_name_{{ $case->id }}" class="form-control" onchange="get_sections(this)">
                                                        <option value="">Select Option</option>
                                                        @if($acts)
                                                          @foreach($acts as $key => $act)
                                                            <option value="{{ $act->act_no }}">{{ $act->act_name }}</option>
                                                          @endforeach
                                                        @endif
                                                        <option value="other">Other</option>
                                                      </select>
                                                    </div>
                                                  </div>
                                                  <div class="col-5">
                                                    <div class="form-group section_dtls">
                                                      <label for="section_details_{{ $case->id }}">Section Details</label>
                                                      <select name="case[{{ $case->id }}][section_details][]" id="section_details_{{ $case->id }}" class="form-control">
                                                        <option value="">Select Option</option>
                                                      </select>
                                                    </div>
                                                  </div>
                                                  <div class="col-2">
                                                    <div class="form-group addDelBtn">
                                                      <button class="btn btn-primary btn-xs add-row addRowbtn" type="button" style="padding: 12px 12px; margin-top: 19px;"><i class="fa fa-plus"></i></button>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </th>
                                  </tr>
                                @endforeach
                                @endif
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
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

@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset(mix('js/scripts/pages/app-user.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/navs/navs.js')) }}"></script>
  <script type="text/javascript">
    function delRowFun(delBtn){
      $(delBtn).parent().parent().parent('.row').remove();
    }

    function filterFrm(){
      $('#frm-filter').submit();
    }
  </script>
  <script type="text/javascript">
    function update_ancedents(){
      $.ajax({
        url: "{{ url('orders/crc-ancedents-update/'.$task_id) }}",
        type: "POST",
        data: $('#frm_reports').serialize(),
        success: function (data) {
          console.log(data);
        }
      });
    }

    function get_sections(acts) {
      var act_id = acts.value;
      $.ajax({
        type :'GET',
        url  :'/searches/get-sections/' + act_id,
        success:function(data){
          $(acts).parent().parent().parent('.row').find('.section_dtls select').html(data);
        }
      });
    }
    
    function open_popup(action, id){

      $('#inlineForm_' + id).modal('show');      
      // $('#case_id').val($(action).data('id'));
      // var report_case_id = '{{ $report_case_id }}';

      // if($(action).data('id') == report_case_id){
      //   $('#name_found').val('{{ $name_found }}');
      //   $('#address_found').val('{{ $address_found }}');
      //   $('#reg_no').val('{{ $reg_no }}');
      //   $('#court_name').val('{{ $court_name }}');
      //   $('#stage_of_case').val('{{ $stage_of_case }}');
      //   $('#fir_no_year').val('{{ $fir_no_year }}');
      //   $('#police_station').val('{{ $police_station }}');
      //   $('.oldSections').removeAttr('style');
      //   $('#addRow').css('display', 'none');
      // } else {
      //   $('#name_found').val('');
      //   $('#address_found').val('');
      //   $('#reg_no').val('');
      //   $('#court_name').val('');
      //   $('#stage_of_case').val('');
      //   $('#fir_no_year').val('');
      //   $('#police_station').val('');
      //   $('.oldSections').css('display', 'none');
      //   $('#addRow').removeAttr('style');
      // }
    }

  </script>

  <script type="text/javascript">
    $(document).ready(function(){
      $(".addRowbtn").click(function(){
        var html_d = '<div class="row addedDiv">' + $(this).parent().parent().parent('.row').html() + '</div>';
        $(this).parent().parent().parent().parent('.addRow').append(html_d);
        $('.addedDiv button').removeClass('addRowbtn');
        $('.addedDiv button').addClass('delButton');
        $('.addedDiv button').html('<i class="fa fa-trash"></i>');
        $('.addedDiv button').attr('onclick', 'delRowFun(this)');
      });
      $("#customFields").on('click','.remCF',function(){
        $(this).parent().parent().remove();
      });
    });

    function add_extra(extra){
      if($(extra).val() == 'other'){
        $(extra).parent().parent().next().find('.section_dtls').html('<label for="section_details1">Section Details</label><input type="text" name="section_details[]" id="section_details1" class="form-control" placeholder="Section Details" />');
      }
    }

    function showButtons(btns, id){
      if($(btns).is(':checked')){
        var last_el = $("#top-buttons li").last().find('button').data('order');
        $("#top-buttons").append('<li><button onclick="open_popup()" class="btn btn-sm btn-primary" data-order="' + (last_el + 1) + '" type="button">Case ' + id + '</button></li>');
      }
    }
  </script>
@endsection