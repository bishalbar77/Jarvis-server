@extends('layouts/contentLayoutMaster')
@section('title', 'User Activity Log Details')
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
<!-- users list start -->
<section class="users-list-wrapper">
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
                          {{-- @dd($log) --}}
                          <table class="table table-hover mb-0">  
                            <tr>
                              <td>User</td>
                              <td>{{ $log->logger_name }}</td>
                            </tr>  
                            <tr>
                              <td>Method</td>
                              <td>{{ $log->method }}</td>
                            </tr>
                            <tr>
                              <td>URL</td>
                              <td>{{ $log->url }}</td>
                            </tr>
                            <tr>
                              <td>IP</td>
                              <td>{{ $log->ip }}</td>
                            </tr>
                            <tr>
                              <td>Location</td>
                              <td>{{ $log->current_location }}</td>
                            </tr>
                            <tr>
                              <td>User Agent</td>
                              <td>{{ $log->agent }}</td>
                            </tr>
                            <tr>
                              <td>Post Data</td>
                              <td>{{ $log->post_data }}</td>
                            </tr>
                            <tr>
                              <td>Response/Error Data</td>
                              <td>{{ $log->api_response }}</td>
                            </tr>
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