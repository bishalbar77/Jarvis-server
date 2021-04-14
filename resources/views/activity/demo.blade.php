@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="sidenav">
            <a class="p-5"></a>
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
        <div class="card-body">
                    <form method="POST" action="/demostore">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
    </div>
@endsection