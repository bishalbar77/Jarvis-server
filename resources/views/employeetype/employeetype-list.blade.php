@extends('layouts/contentLayoutMaster')

@section('title', 'Employee Type List')

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
<!-- employeetype list start -->
<section class="employeetype-list-wrapper">
  <!-- employeetype filter start -->
  <div class="card">
    <div class="card-header">
      <h4 class="card-title">Filters</h4>
      <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
      <div class="heading-elements">
        <ul class="list-inline mb-0">
          <li><a data-action="collapse"><i class="feather icon-chevron-down"></i></a></li>
          <li><a href="{{ url('/employeetype') }}"><i class="feather icon-rotate-cw employeetype-data-filter"></i></a></li>
          <li><a data-action="close"><i class="feather icon-x"></i></a></li>
        </ul>
      </div>
    </div>
    <div class="card-content collapse show">
      <div class="card-body">
        <div class="employeetype-list-filter">
          <form id="frm-filter" action="{{ url('/employeetype') }}" method="get">
            <div class="row">
              <div class="col-12 col-sm-6 col-lg-3">
                <label for="employeetype-list-status">Status</label>
                <fieldset class="form-group">
                  <select name="status" class="form-control" id="employeetype-list-status" onchange="filterFrm()">
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
  <!-- employeetype filter end -->
  <!-- Ag Grid employeetype list section start -->
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
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Desc</th>
                                        <th>Status</th>
                                        <th>Source</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @if($employeetype)                                  
                                  <tbody>
                                    @foreach($employeetype as $emp)
                                      <tr>
                                        <th scope="row">{{ $emp->id }}</th>
                                        <td>{{ $emp->type }}</td>
                                        <td>{{ $emp->description }}</td>
                                        <td>{{ $emp->status == 'A' ? 'Active' : 'Deactive' }}</td>
                                        <td>{{ $emp->source }}</td>
                                        <td>
                                          <span>
                                            <a href="employeetype/edit/{{ $emp->id }}"><i class="employeetype-edit-icon feather icon-edit-1 mr-50"></i></a>
                                            <a href="employeetype/status/{{ $emp->id }}/status/{{ $emp->status == 'A' ? 'I' : 'A' }}"><i class="feather {{ $emp->status == 'A' ? 'icon-eye' : 'icon-eye-off' }} mr-50"></i></a>
                                            <!-- <a href="employeetype/delete/{{ $emp->id }}"><i class="employeetype-delete-icon feather icon-trash-2"></i></a> -->
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
  <!-- Ag Grid employeetype list section end -->
</section>
<!-- employeetype list ends -->
<script type="text/javascript">
  function filterFrm(){
    $('#frm-filter').submit();
  }
</script>
@endsection