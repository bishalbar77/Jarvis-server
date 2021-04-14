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
<!-- apikeys list start -->
<section class="apikeys-list-wrapper">
  <!-- apikeys filter end -->
  @if($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success : </strong> {{ $message }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif
  <!-- Ag Grid apikeys list section start -->
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
                                        <th>API Key</th>
                                        <th>System</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                @if($apikeys)                                  
                                  <tbody>
                                    @foreach($apikeys as $sever)
                                      <tr>
                                        <td>{{ $sever->api_key }}</td>
                                        <td>{{ $sever->api_system_name }}</td>
                                        <td>{{ $sever->status }}</td>
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
  <!-- Ag Grid apikeys list section end -->
</section>
<!-- apikeys list ends -->
<script type="text/javascript">
  function filterFrm(){
    $('#frm-filter').submit();
  }
</script>
@endsection