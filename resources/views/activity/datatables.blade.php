@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
@endsection

@section('content')
<div class="sidenav">
    <a class="p-2"></a>
    <li class="menu-item" aria-haspopup="true">
        <a href="/home" class="menu-link">
            <span class="svg-icon menu-icon">
                <i class="fa fa-tasks text-info"></i>
            </span>
            <span class="menu-text">Dashboard</span>
        </a>
    </li>
    <li class="menu-item" aria-haspopup="true">
        <a href="/users" class="menu-link">
            <span class="svg-icon menu-icon">
                <i class="fa fa-history text-danger"></i>
            </span>
            <span class="menu-text">Log Activity</span>
        </a>
    </li>
    <li class="menu-item" aria-haspopup="true">
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
        <a href="{{ route('logout') }}" class="menu-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <span class="svg-icon menu-icon">
                <i class="fa fa-sign-out text-primary"></i>
            </span>

            <span class="menu-text">Logout</span>
        </a>
    </li>
</div>
<div class="container">
    <div class="col-md-12 col-md-offset-1">
        <button type="button" class="btn btn-primary mb-0" data-toggle="modal" data-target="#myModal">
            Session
        </button>
        <form action="{{ route('session.store') }}" method="post">
        @csrf
            <div class="modal" id="myModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h5 class="modal-title">Session Expire Time</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-md-8">
                                    <input id="session_expire" type="text" class="form-control @error('session_expire') is-invalid @enderror" name="session_expire" value="{{ old('session_expire') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-success">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div> 
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<a class="p-4"></a>
    <div class="container">
        <div class="col-md-12 col-md-offset-1">
            <form id="clear">
                <div class="row">               
					<div class="col-lg-3 mb-lg-0 mb-6">
                        <div class="form-group" id="filter_col1" data-column="1">
                            <label>First Name</label>
                            <input class="form-control column_filter" id="col1_filter" placeholder="First Name">
                        </div>
                    </div>
                    <div class="col-lg-3 mb-lg-0 mb-6">
                        <div class="form-group" id="filter_col2" data-column="2">
                            <label>Last Name</label>
                            <input type="text" name="Last Name" class="form-control column_filter" id="col2_filter" placeholder="Last Name">
                        </div>
                    </div>
				 <!--Email-->
					<div class="col-lg-3 mb-lg-0 mb-6">
                        <div class="form-group" id="filter_col3" data-column="3">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control column_filter" id="col3_filter" placeholder="Email">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-12 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Users</div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered" id="datatable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Last Seen</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascripts')
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready( function () {
            $('#datatable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('api.users.index') }}",
                "columns": 
                [
                    { data: 'id', name: 'id' },
                    { data: 'first_name', name: 'first_name' },
                    { data: 'last_name', name: 'last_name' },
                    { data: 'email', name: 'email' },
                    { data: 'status', name: 'status'},
                    { data: 'actions', name: 'actions'},
                    { data: 'action', name: 'action'}
                ]
            });
        });
    </script>
@endsection
