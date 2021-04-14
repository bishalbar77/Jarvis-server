@extends('layouts/contentLayoutMaster')

@section('title', 'Documents Type List')

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
<!-- documents list start -->
<section class="documents-list-wrapper">
  <!-- documents filter start -->
  <div class="card">
    <div class="card-header">
      <h4 class="card-title">Filters</h4>
      <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
      <div class="heading-elements">
        <ul class="list-inline mb-0">
          <li><a data-action="collapse"><i class="feather icon-chevron-down"></i></a></li>
          <li><a href="{{ url('/documents') }}"><i class="feather icon-rotate-cw documents-data-filter"></i></a></li>
          <li><a data-action="close"><i class="feather icon-x"></i></a></li>
        </ul>
      </div>
    </div>
    <div class="card-content collapse show">
      <div class="card-body">
        <div class="documents-list-filter">
          <form id="frm-filter" action="{{ url('/documents') }}" method="get">
            <div class="row">
              <div class="col-12 col-sm-6 col-lg-3">
                <label for="documents-list-status">Status</label>
                <fieldset class="form-group">
                  <select name="status" class="form-control" id="documents-list-status" onchange="filterFrm()">
                    <option value="">All</option>
                    <option <?php echo (isset($filter['status']) && $filter['status'] == '1') ? 'selected' : ''; ?> value="active">Active</option>
                    <option <?php echo (isset($filter['status']) && $filter['status'] === '0') ? 'selected' : ''; ?> value="deactive">Deactivated</option>
                  </select>
                </fieldset>
              </div>
              <div class="col-12 col-sm-6 col-lg-3">
                <label for="source-filter">Source</label>
                <fieldset class="form-group">
                  <select name="source" class="form-control" id="source-filter" onchange="filterFrm()">
                    <option value="">Select Source</option>
                    <option <?php echo (isset($filter['source']) && $filter['source'] == 'B') ? 'selected' : ''; ?> value="B">B2B</option>
                    <option <?php echo (isset($filter['source']) && $filter['source'] === 'C') ? 'selected' : ''; ?> value="C">B2C</option>
                  </select>
                </fieldset>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- documents filter end -->
  <!-- Ag Grid documents list section start -->
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
                                        <th>Status</th>
                                        <th>Source</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @if($documents)                                  
                                  <tbody>
                                    @foreach($documents as $document)
                                      <tr>
                                        <th scope="row">{{ $document->id }}</th>
                                        <td>{{ $document->name }}</td>
                                        <td>{{ $document->status == 'A' ? 'Active' : 'Deactive' }}</td>
                                        <td>{{ $document->source }}</td>
                                        <td>
                                          <span>
                                            <a href="documents/edit/{{ $document->id }}"><i class="documents-edit-icon feather icon-edit-1 mr-50"></i></a>
                                            <a href="documents/status/{{ $document->id }}/status/{{ $document->status == 'A' ? 'A' : 'I' }}"><i class="feather {{ $document->status == 'A' ? 'icon-eye' : 'icon-eye-off' }} mr-50"></i></a>
                                            <!-- <a href="documents/delete/{{ $document->id }}"><i class="documents-delete-icon feather icon-trash-2"></i></a> -->
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
  <!-- Ag Grid documents list section end -->
</section>
<!-- documents list ends -->
<script type="text/javascript">
  function filterFrm(){
    $('#frm-filter').submit();
  }
</script>
@endsection