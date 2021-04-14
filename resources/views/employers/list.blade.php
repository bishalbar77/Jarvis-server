@extends('layouts/contentLayoutMaster')

@section('title', 'Employers List')

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
          <li><a href="{{ url('/employers') }}"><i class="feather icon-rotate-cw users-data-filter"></i></a></li>
          <li><a data-action="close"><i class="feather icon-x"></i></a></li>
        </ul>
      </div>
    </div>
    <div class="card-content collapse show">
      <div class="card-body">
        <div class="users-list-filter">
          <form id="frm-filter" action="{{ url('/employers') }}" method="get">
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
              <div class="col-6 col-sm-4 col-lg-2">
                <label for="users-list-status">Status</label>
                <fieldset class="form-group">
                  <select name="status" class="form-control" id="users-list-status" onchange="filterFrm()">
                    <option value="">All</option>
                    <option <?php echo (isset($filter['employers.status']) && $filter['employers.status'] == 'A') ? 'selected' : ''; ?> value="A">Active</option>
                    <option <?php echo (isset($filter['employers.status']) && $filter['employers.status'] === 'I') ? 'selected' : ''; ?> value="I">Deactivated</option>
                  </select>
                </fieldset>
              </div>
              <div class="col-6 col-sm-4 col-lg-2">
                <label for="users-list-status">Source</label>
                <fieldset class="form-group">
                  <select name="source" class="form-control" id="users-list-status" onchange="filterFrm()">
                    <option value="">All</option>
                    <option <?php echo (isset($filter['employers.source_type']) && $filter['employers.source_type'] == 'B2B') ? 'selected' : ''; ?> value="B2B">B2B</option>
                    <option <?php echo (isset($filter['employers.source_type']) && $filter['employers.source_type'] === 'B2C') ? 'selected' : ''; ?> value="B2C">B2C</option>
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
                                        <th>Logo</th>
                                        <th>Code</th>
                                        <th>Company Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Phone</th>
                                        <th>Source</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @if($employers)                                  
                                  <tbody>
                                    @foreach($employers as $employer)
                                      <tr>
                                        <td>
                                          @if(empty($employer->photo->photo_url))
                                            <img src="images/profile/user-uploads/user-default.jpg" width="40" height="40" />
                                          @else
                                            <img src="{{ $employer->photo->photo_url }}" width="40" height="40" />
                                          @endif
                                        </td>
                                        <td>{{ $employer->employer_custom_id }}</td>
                                        
                                        @if($employer->source_type == 'B2C')
                                          <td>{{ $employer->first_name }} {{ $employer->middle_name }} {{ $employer->last_name }}</td>
                                        @else
                                          <td>{{ $employer->b2b_company_name }}</td>
                                        @endif
                                        
                                        <td>{{ $employer->email }}</td>
                                        <td>+{{ $employer->country_code }}-{{ $employer->mobile }}</td>
                                        <td>{{ $employer->phone }}</td>
                                        <td>{{ $employer->source_type }}</td>
                                        <td>{{ $employer->employer_type }}</td>
                                        <td>{{ $employer->status == 'A' ? 'Active' : 'In-Active' }}</td>
                                        <td>
                                          <span>
                                            <a href="/employers/edit/{{ $employer->id }}"><i class="users-edit-icon feather icon-edit-1 mr-50"></i></a>
                                            <a href="/employers/status/{{ $employer->id }}/status/{{ $employer->status == 1 ? 0 : 1 }}"><i class="feather {{ $employer->status == 1 ? 'icon-eye' : 'icon-eye-off' }} mr-50"></i></a>
                                            <!-- <a href="/employers/delete/{{ $employer->id }}"><i class="users-delete-icon feather icon-trash-2"></i></a> -->
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
  {{ $employers->links() }}
</section>
<!-- users list ends -->
<script type="text/javascript">
  function filterFrm(){
    $('#frm-filter').submit();
  }
</script>
@endsection