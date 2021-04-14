@extends('layouts/contentLayoutMaster')
@section('title', 'Edit Survey Questions')
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
    #cpyfields button {
        display: none !important;
    }
  </style>
@endsection

@section('content')
<!-- surveyquestions edit start -->
<section class="users-edit">
  <div class="card">
    <div class="card-content">
      <div class="card-body">
        <ul class="nav nav-tabs mb-3" role="tablist">
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center active" id="account-tab" data-toggle="tab" href="#account"
              aria-controls="account" role="tab" aria-selected="true">
              <i class="feather icon-user mr-25"></i><span class="d-none d-sm-block">Survey Questions</span>
            </a>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
            <!-- surveyquestions edit account form start -->
            <form novalidate action="{{ url('surveyquestions/update/'.$surveyquestions->id) }}" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-12 col-sm-6">

                  <div class="form-group">
                    <div class="controls">
                      <label>Question</label>
                      <input type="input" name="text" class="form-control" placeholder="Question" value="{{ $surveyquestions->text }}">
                      @if($errors->has('text'))
                        <p class="text-danger">{{ $errors->first('text') }}</p>
                      @endif
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="controls">
                      <label>Possible Answer</label>
                      <textarea name="possible_answers" class="form-control" placeholder="Possible Answer">{{ $surveyquestions->possible_answers }}</textarea>
                      @if($errors->has('possible_answers'))
                        <p class="text-danger">{{ $errors->first('possible_answers') }}</p>
                      @endif
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                      <option {{ $surveyquestions->status == 'A' ? 'selected' : '' }} value="A">Active</option>
                      <option {{ $surveyquestions->status == 'I' ? 'selected' : '' }} value="I">In-Active</option>
                    </select>
                  </div>

                  <div class="row">
                    <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                      <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save Changes</button>
                      <button type="reset" class="btn btn-outline-warning">Reset</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
            <!-- surveyquestions edit account form ends -->
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- surveyquestions edit ends -->
@endsection

@section('vendor-script')
  {{-- Vendor js files --}}
  <script src="{{ asset(mix('vendors/js/forms/validation/jqBootstrapValidation.js')) }}"></script>
@endsection

@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset(mix('js/scripts/pages/app-user.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/navs/navs.js')) }}"></script>
@endsection

