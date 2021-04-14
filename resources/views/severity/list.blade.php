@extends('layouts/contentLayoutMaster')

@section('title', 'Severity List')

@section('vendor-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/ag-grid/ag-grid.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/ag-grid/ag-theme-material.css')) }}">
@endsection

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/pages/app-user.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/pages/aggrid.css')) }}">
@endsection

@section('content')
<!-- severity list start -->
<section class="severity-list-wrapper">
  <!-- severity filter start -->
  <div class="card">
    <div class="card-header">
      <h4 class="card-title">Filters</h4>
      <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
      <div class="heading-elements">
        <ul class="list-inline mb-0">
          <li><a data-action="collapse"><i class="feather icon-chevron-down"></i></a></li>
          <li><a href="{{ url('/severity') }}"><i class="feather icon-rotate-cw severity-data-filter"></i></a></li>
          <li><a data-action="close"><i class="feather icon-x"></i></a></li>
        </ul>
      </div>
    </div>
    <div class="card-content collapse show">
      <div class="card-body">
        <div class="severity-list-filter">
          <form id="frm-filter" action="{{ url('/severity') }}" method="get">
            <div class="row">
              <div class="col-12 col-sm-6 col-lg-3">
                <label for="severity-list-status">Task Type</label>
                <fieldset class="form-group">
                  <select name="tasktype" class="form-control" id="severity-list-status" onchange="filterFrm()">
                    <option value="">All</option>
                    @if($tasktypes)
                      @foreach($tasktypes as $tasktype)
                        <option value="{{ $tasktype->id }}">{{ $tasktype->task_type }}</option>
                      @endforeach
                    @endif
                  </select>
                </fieldset>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- severity filter end -->
  @if($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success : </strong> {{ $message }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif
  <!-- Ag Grid severity list section start -->
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
                                        <th>Severity ID</th>
                                        <th>Task Type</th>
                                        <th>Severity</th>
                                        <th>Message</th>
                                        <th style="text-align: right;">Action</th>
                                    </tr>
                                </thead>
                                @if($severity)                                  
                                  <tbody>
                                    @foreach($severity as $sever)
                                      <tr>
                                        <td>{{ $sever->severity_id }}</td>
                                        <td>{{ $sever->task_type }}</td>
                                        <td>{{ $sever->task_severity }}</td>
                                        <td>{{ $sever->severity_message }}</td>
                                        <td align="right">
                                          <span>
                                            <a href="severity/edit/{{ $sever->id }}"><i class="severity-edit-icon feather icon-edit-1 mr-50"></i></a>
                                            <!-- <a href="severity/status/{{ $sever->id }}/status/{{ $sever->status == 'A' ? 'I' : 'A' }}"><i class="feather {{ $sever->status == 1 ? 'icon-eye' : 'icon-eye-off' }} mr-50"></i></a> -->
                                            <!-- <a href="severity/delete/{{ $sever->id }}"><i class="severity-delete-icon feather icon-trash-2"></i></a> -->
                                          </span>
                                        </td>
                                      </tr>
                                    @endforeach
                                  </tbody>                                  
                                @endif
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
  <!-- Ag Grid severity list section end -->
</section>
<!-- severity list ends -->
<script type="text/javascript">
  function filterFrm(){
    $('#frm-filter').submit();
  }
</script>
@endsection