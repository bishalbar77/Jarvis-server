@extends('layouts/contentLayoutMaster')
@section('title', 'User Activity Log')
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
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Last Seen</th>
                                        <th>Timestamp</th>
                                        <th>Check Logs</th>
                                    </tr>
                                </thead>
                                @if($users)                                  
                                  <tbody>
                                    @foreach($users as $user)
                                      <tr class="clickable-row" data-href="{{ route('logActivity.logs', $user->id) }}">
                                        <td>{{$user->first_name}} {{$user->middle_name}} {{$user->last_name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>
                                          @if(Cache::has('user-is-online-' . $user->id))
                                              <label class="badge badge-success">Online</label>
                                          @else
                                              <label class="badge badge-danger">Offline</label>
                                          @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}</td>
                                        <td>{{ $user->last_seen }}</td>
                                        <td align="center">
                                          <a href="{{ route('logActivity.logs', $user->id) }}" 
                                          class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2" title="View">
                                          <i class="fa fa-info-circle text-info"></i>
                                          </a>
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
  <!-- Ag Grid users list section end -->
  {{ $users->links() }}
</section>
<!-- users list ends -->
<script type="text/javascript">
  function filterFrm(){
    $('#frm-filter').submit();
  }
</script>
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