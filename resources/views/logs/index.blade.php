@extends('layouts/contentLayoutMaster')
@section('title', 'User Activity Log List')
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
    .clickable-row {
      cursor: pointer !important;
    }
  </style>
@endsection

@section('content')
<!-- users list start -->
<section class="users-list-wrapper">
  <!-- users filter start -->
  <div class="card">
    <div class="card-header">
      <h4 class="card-title">Filters</h4>
      <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
      <div class="heading-elements">
        <ul class="list-inline mb-0">
          <li><a data-action="collapse"><i class="feather icon-chevron-down"></i></a></li>
          <li><a href="{{ url('/users') }}"><i class="feather icon-rotate-cw users-data-filter"></i></a></li>
          <li><a data-action="close"><i class="feather icon-x"></i></a></li>
        </ul>
      </div>
    </div>
    <div class="card-content collapse show">
      <div class="card-body">
        <div class="users-list-filter">
          <form id="frm-filter" action="{{ url('/users') }}" method="get">
            <div class="row">
              <div class="col-12 col-sm-6 col-lg-3">
                <label for="users-list-status">Status</label>
                <fieldset class="form-group">
                  <select name="status" class="form-control" id="users-list-status" onchange="filterFrm()">
                    <option value="">All</option>
                    <option <?php echo (isset($filter['status']) && $filter['status'] == '1') ? 'selected' : ''; ?> value="active">Active</option>
                    <option <?php echo (isset($filter['status']) && $filter['status'] === '0') ? 'selected' : ''; ?> value="deactive">Deactivated</option>
                  </select>
                </fieldset>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- users filter end -->
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
                                        <th>Method</th>
                                        <th>IP address</th>
                                        <th>Time</th>
                                        <th>Date</th>
                                        <th width="200px">Current Location</th>
                                        <th width="300px">Device Address</th>
                                        <th>I/O Data</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs as $key => $log)
                                    @if($log->user_id==$users->id)
                                    <tr class="clickable-row" data-href="{{ route('logs.show', $log->id) }}">
                                        <td><label class="badge badge-success">{{ $log->method }}</label></td>
                                        <td>{{ $log->ip }}</td>
                                        <td><button class="btn btn-primary btn-sm">{{ $log->updated_at->format('H:i:s') }}</button></td>
                                        <td>{{ $log->updated_at->format('m/d/Y') }}</td>
                                        <td>{{ $log->current_location }}</td>
                                        <td>{{ $log->agent }}</td>
                                        <td class="pl-3"><a href="{{ route('logs.show', $log->id) }}" 
                                                class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2" title="View">
                                                <i class="fa fa-info-circle text-info"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endif
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
</section>
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
    jQuery(document).ready(function($) {
      $(".clickable-row").click(function() {
        window.location = $(this).data("href");
      });
    });
  </script>
@endsection