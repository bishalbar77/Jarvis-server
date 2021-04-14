@extends('layouts/contentLayoutMaster')

@section('title', 'Employee List')

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
          <li><a href="{{ url('/employees') }}"><i class="feather icon-rotate-cw users-data-filter"></i></a></li>
          <li><a data-action="close"><i class="feather icon-x"></i></a></li>
        </ul>
      </div>
    </div>
    <div class="card-content collapse show">
      <div class="card-body">
        <div class="users-list-filter">
          <form id="frm-filter" action="{{ url('/employees') }}" method="get">
            <div class="row">
              <div class="col-3 col-sm-1 col-lg-1">
                <label for="users-list-status">Per Page</label>
                <fieldset class="form-group">
                  <select name="perpage" class="form-control" onchange="filterFrm()">
                    <option <?php echo $perpage == '10' ? 'selected' : ''; ?> value="10">10</option>
                    <option <?php echo $perpage == '20' ? 'selected' : ''; ?> value="20">20</option>
                    <option <?php echo $perpage == '50' ? 'selected' : ''; ?> value="50">50</option>
                    <option <?php echo $perpage == '100' ? 'selected' : ''; ?> value="100">100</option>
                    <option <?php echo $perpage == '500' ? 'selected' : ''; ?> value="500">500</option>
                  </select>
                </fieldset>
              </div>

              <div class="col-12 col-sm-6 col-lg-3">
                <label for="surveys-list-status">Employers</label>
                <fieldset class="form-group">
                  <select name="employer_id" class="form-control" id="surveys-list-status" onchange="filterFrm()">
                    <option value="">All</option>
                    @if($employers)
                      @foreach($employers as $employer)
                        <option {{ isset($_GET['employer_id']) && $_GET['employer_id'] == $employer->id ? 'selected' : '' }} value="{{ $employer->id }}">
                          @if($employer->b2b_company_name == '')
                            {{ $employer->first_name }} {{ $employer->middle_name }} {{ $employer->last_name }} 
                          @else
                            {{ $employer->b2b_company_name }}
                            @if($employer->b2b_brand_name != '')
                              ({{ $employer->b2b_brand_name }})
                            @endif
                          @endif
                        </option>
                      @endforeach
                    @endif
                  </select>
                </fieldset>
              </div>

              <div class="col-6 col-sm-4 col-lg-2">
                <label for="users-list-status">Status</label>
                <fieldset class="form-group">
                  <select name="status" class="form-control" id="users-list-status" onchange="filterFrm()">
                    <option value="">All</option>
                    <option <?php echo (isset($filter['status']) && $filter['status'] == '1') ? 'selected' : ''; ?> value="active">Active</option>
                    <option <?php echo (isset($filter['status']) && $filter['status'] === '0') ? 'selected' : ''; ?> value="deactive">Deactivated</option>
                  </select>
                </fieldset>
              </div>

              <div class="col-12 col-sm-6 col-lg-3">
                <label for="surveys-list-status">Name</label>
                <fieldset class="form-group">
                  <input class="form-control" type="text" name="s" id="s" value="{{ $s }}" placeholder="Name" onchange="filterFrm()">
                </fieldset>
              </div>

            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- users filter end -->
  @if($message = Session::get('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success : </strong> {{ $message }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
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
                                        <th>Photo</th>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Employer</th>
                                        <th>Mobile</th>
                                        <th>Source</th>
                                        <th>Status</th>
                                        <th>Share Url</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @if($employees)                                  
                                  <tbody>
                                    @foreach($employees as $employee)
                                      <tr>
                                        <th scope="row">
                                          @if(empty($employee->photo_url))
                                            <img src="images/profile/user-uploads/user-default.jpg" width="40" height="40" />
                                          @else
                                            <img src="{{ $employee->photo_url }}" width="40" height="40" />
                                          @endif
                                        </th>
                                        <td>{{ $employee->employee_custom_id }}</td>
                                        <td>{{ $employee->empl_first_name }} {{ $employee->empl_middle_name }} {{ $employee->empl_last_name }}</td>
                                        <td>
                                          @if(!empty($employee->b2b_company_name))
                                            {{ $employee->b2b_company_name }} 
                                            @if(!empty($employee->b2b_brand_name))
                                              -- {{ $employee->b2b_brand_name }}
                                            @endif
                                          @else
                                            {{ $employee->emplo_first_name }} {{ $employee->emplo_middle_name }} {{ $employee->emplo_last_name }}
                                          @endif
                                        </td>
                                        <td>{{ $employee->mobile }}</td>
                                        <td>{{ $employee->source_type }}</td>
                                        <td>{{ $employee->status == 'A' ? 'Active' : 'In-Active' }}</td>
                                        <td><a href="http://truehelp.io/profile/?id={{ md5($employee->user_id) }}" target="_blank">Share</a></td>
                                        <td>
                                          <span>
                                            <a href="/employees/edit/{{ $employee->employee_id }}?source={{ $employee->source_type }}"><i class="users-edit-icon feather icon-edit-1 mr-50"></i></a>
                                            <!-- <a href="/employees/status/{{ $employee->id }}/status/{{ $employee->status == 1 ? 0 : 1 }}"><i class="feather {{ $employee->status == 1 ? 'icon-eye' : 'icon-eye-off' }} mr-50"></i></a> -->
                                            <!-- <a href="employees/delete-emp/{{ $employee->employee_id }}"><i class="users-delete-icon feather icon-trash-2"></i></a> -->
                                            <!-- <a href="{{ url('/orders/create?eid='.$employee->company_id.'&uid='.$employee->id) }}">Order </a> -->
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
  <!-- Ag Grid users list section end -->
  {{ $employees->links() }}
</section>
<!-- users list ends -->
<script type="text/javascript">
  function filterFrm(){
    $('#frm-filter').submit();
  }
</script>
@endsection