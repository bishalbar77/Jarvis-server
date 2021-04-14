@extends('layouts/contentLayoutMaster')

@section('title', 'Verification Type List')

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
<!-- verificationtype list start -->
<section class="verificationtype-list-wrapper">
  <!-- verificationtype filter start -->
  <div class="card">
    <div class="card-header">
      <h4 class="card-title">Filters</h4>
      <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
      <div class="heading-elements">
        <ul class="list-inline mb-0">
          <li><a data-action="collapse"><i class="feather icon-chevron-down"></i></a></li>
          <li><a href="{{ url('/verificationtype') }}"><i class="feather icon-rotate-cw verificationtype-data-filter"></i></a></li>
          <li><a data-action="close"><i class="feather icon-x"></i></a></li>
        </ul>
      </div>
    </div>
    <div class="card-content collapse show">
      <div class="card-body">
        <div class="verificationtype-list-filter">
          <form id="frm-filter" action="{{ url('/verificationtype') }}" method="get">
            <div class="row">
              <div class="col-12 col-sm-6 col-lg-3">
                <label for="verificationtype-list-status">Status</label>
                <fieldset class="form-group">
                  <select name="status" class="form-control" id="verificationtype-list-status" onchange="filterFrm()">
                    <option value="">All</option>
                    <option <?php echo (isset($filter['status']) && $filter['status'] == 'A') ? 'selected' : ''; ?> value="active">Active</option>
                    <option <?php echo (isset($filter['status']) && $filter['status'] === 'I') ? 'selected' : ''; ?> value="deactive">Deactivated</option>
                  </select>
                </fieldset>
              </div>
              <div class="col-12 col-sm-6 col-lg-3">
                <label for="source-filter">Source</label>
                <fieldset class="form-group">
                  <select name="source" class="form-control" id="source-filter" onchange="filterFrm()">
                    <option value="">Select Source</option>
                    <option <?php echo (isset($filter['source']) && $filter['source'] == 'B2B') ? 'selected' : ''; ?> value="B2B">B2B</option>
                    <option <?php echo (isset($filter['source']) && $filter['source'] === 'B2C') ? 'selected' : ''; ?> value="B2C">B2C</option>
                  </select>
                </fieldset>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- verificationtype filter end -->
  @if($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success : </strong> {{ $message }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif
  <!-- Ag Grid verificationtype list section start -->
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
                                        <th>Icon</th>
                                        <th>Name</th>
                                        <th>Internal Name</th>
                                        <th style="text-align: right;">Amount</th>
                                        <th style="text-align: right;">Status</th>
                                        <th style="text-align: right;">Source</th>
                                        <th style="text-align: right;">TAT</th>
                                        <th style="text-align: right;">Action</th>
                                    </tr>
                                </thead>
                                @if($verificationtype)                                  
                                  <tbody>
                                    @foreach($verificationtype as $verification)
                                      <tr>
                                        <td>
                                          @if($verification->icon_url)
                                            <img src="{{ $verification->icon_url }}" alt="users avatar" class="users-avatar-shadow rounded" height="64" width="64">
                                          @else
                                            <img src="{{ asset('images/portrait/small/avatar-s-12.jpg') }}" alt="users avatar" class="users-avatar-shadow rounded" height="64" width="64">
                                          @endif
                                        </td>
                                        <td>{{ $verification->name }}</td>
                                        <td>{{ $verification->internal_name }}</td>
                                        <td align="right">
                                          <strong>₹</strong> {{ number_format($verification->amount, 2, '.', ',') }}
                                        </td>
                                        <td align="right">{{ $verification->status == 'A' ? 'Active' : 'In-Active' }}</td>
                                        <td align="right">{{ $verification->source }}</td>
                                        <td align="right">{{ $verification->tat }} Working Day's</td>
                                        <td align="right">
                                          <span>
                                            <a href="verificationtype/edit/{{ $verification->id }}"><i class="verificationtype-edit-icon feather icon-edit-1 mr-50"></i></a>
                                            <a href="verificationtype/status/{{ $verification->id }}/status/{{ $verification->status == 'A' ? 'I' : 'A' }}"><i class="feather {{ $verification->status == 1 ? 'icon-eye' : 'icon-eye-off' }} mr-50"></i></a>
                                            <!-- <a href="verificationtype/delete/{{ $verification->id }}"><i class="verificationtype-delete-icon feather icon-trash-2"></i></a> -->
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
  <!-- Ag Grid verificationtype list section end -->
</section>
<!-- verificationtype list ends -->
<script type="text/javascript">
  function filterFrm(){
    $('#frm-filter').submit();
  }
</script>
@endsection