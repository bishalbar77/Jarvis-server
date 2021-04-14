@extends('layouts/contentLayoutMaster')
@section('title', 'Billing Plans Edit')
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
<!-- billing-plans create start -->
<div class="row">
  <div class="col-12 col-sm-5">
    <section class="users-edit">
      <div class="card">
        <div class="card-content">
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                <!-- billing-plans create account form start -->
                <form novalidate action="{{ url('billing-plans/update/'.$billingplans->id) }}" method="post" enctype="multipart/form-data">
                  {{ csrf_field() }}

                  <div class="form-group">
                    <div class="controls">
                      <label>Code</label>
                      <input type="text" name="code" class="form-control" placeholder="Code" value="{{ $billingplans->code }}" />
                      @if($errors->has('code'))
                        <p class="text-danger">{{ $errors->first('code') }}</p>
                      @endif
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="controls">
                      <label>Name</label>
                      <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $billingplans->name }}" />
                      @if($errors->has('name'))
                        <p class="text-danger">{{ $errors->first('name') }}</p>
                      @endif
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="controls">
                      <label>Amount</label>
                      <input type="text" name="amount" class="form-control" placeholder="Amount" value="{{ $billingplans->amount }}" />
                      @if($errors->has('amount'))
                        <p class="text-danger">{{ $errors->first('amount') }}</p>
                      @endif
                    </div>
                  </div>
                    
                  <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                      <option {{ $billingplans->status == 'A' ? 'selected' : '' }} value="A">Active</option>
                      <option {{ $billingplans->status == 'I' ? 'selected' : '' }} value="I">Deactive</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <div class="controls">
                      <label>Severity Message</label>
                      <textarea name="description" class="form-control" placeholder="Description">{{ $billingplans->code }}</textarea>
                      @if($errors->has('description'))
                        <p class="text-danger">{{ $errors->first('description') }}</p>
                      @endif
                    </div>
                  </div>

                  @php
                    $billing_verification_tasks = explode(',', $billingplans->billing_verification_tasks);
                  @endphp
                  
                  @if($verificationtypes)
                    <ul class="list-unstyled mb-0">
                      @foreach($verificationtypes as $verification)
                        <li class="d-inline-block mr-2">
                          <fieldset>
                            <div class="vs-checkbox-con vs-checkbox-primary">
                              <input {{ in_array( $verification->name, $billing_verification_tasks) ? 'checked' : '' }} type="checkbox" id="verifications_{{ $verification->id }}" name="billing_verification_tasks[]" value="{{ $verification->name }}">
                              <span class="vs-checkbox">
                                <span class="vs-checkbox--check">
                                  <i class="vs-icon feather icon-check"></i>
                                </span>
                              </span>
                              <span class="" style="font-size: 0.85rem;">{{ $verification->name }}</span>
                            </div>
                          </fieldset>
                        </li>                        
                      @endforeach
                    </ul>
                  @endif

                  <div class="row">
                    <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                      <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save Changes</button>
                      <button type="reset" class="btn btn-outline-warning">Reset</button>
                    </div>
                  </div> 
                </form>
                <!-- billing-plans create account form ends -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- billing-plans create ends -->
  </div>
</div>
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

