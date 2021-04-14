@extends('layouts/contentLayoutMaster')

@section('title', 'Role List')

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
<!-- roles list start -->
<section class="roles-list-wrapper">
   @if($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success : </strong> {{ $message }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif
  <!-- Ag Grid roles list section start -->
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
                                    <th>Guard Name</th>
                                    <th>Action</th>
                                  </tr>
                                </thead>
                                @if($roles)                                  
                                  <tbody>
                                    @foreach($roles as $role)
                                      <tr>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->guard_name }}</td>
                                        <td>
                                          <span>
                                            <a href="roles/edit/{{ $role->id }}"><i class="roles-edit-icon feather icon-edit-1 mr-50"></i></a>
                                            <a href="roles/permissions/{{ $role->id }}">Add Permission</a>
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
  <!-- Ag Grid roles list section end -->
</section>
<!-- roles list ends -->
@endsection