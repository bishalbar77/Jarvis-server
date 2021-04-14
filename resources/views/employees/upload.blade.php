@extends('layouts/contentLayoutMaster')

@section('title', 'Upload Employee')

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
    .picker {
      margin-top: -159px;
    }
  </style>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
@endsection

@section('content')
<!-- users edit start -->
<section class="users-edit">
  <div class="card">
    <div class="card-content">
      <div class="card-body">
        <form novalidate action="{{ url('employees/upload/'.$employer_id.'/'.$source) }}" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="row">
            <div class="col-sm-4">
              
              <div class="form-group">
                <label>Source</label>
                <select name="source_name" id="source_name" class="form-control">
                  <option {{ $source == 'B2B' ? 'selected' : '' }} value="B2B">B2B</option>
                  <option {{ $source == 'B2C' ? 'selected' : '' }} value="B2C">B2C</option>
                </select>
              </div>

              <div class="form-group">
                  <label>Company</label>
                  <select name="employer_id" id="employer_id" class="form-control" required data-validation-required-message="Company required">
                    <option value="">Select Company</option>
                    @if($employers)
                      @foreach($employers as $employer)
                        <option {{ $employer_id == $employer->id ? 'selected' : '' }} value="{{ $employer->id }}">
                          @if(!empty($employer->b2b_company_name))
                            {{ $employer->b2b_company_name }} {{ $employer->b2b_brand_name ? '('.$employer->b2b_brand_name.')' : '' }}
                          @else
                            {{ $employer->first_name }} {{ $employer->middle_name ?? '' }} {{ $employer->last_name ?? '' }}
                          @endif
                        </option>
                      @endforeach
                    @endif
                  </select>
              </div>

              <fieldset class="form-group">
                <label for="xlxs_file">Select Xlxs file</label>
                <div class="custom-file">
                  <input type="file" name="xlxs_file" class="custom-file-input" id="xlxs_file">
                  <label class="custom-file-label" for="doc_url">Choose file</label>
                </div>
              </fieldset>

              <fieldset class="form-group">
                <a href="{{ url('samples/employee-add-format.xlsx') }}" target="_blank">Download Sample file</a>
              </fieldset>

              <div class="d-flex flex-sm-row flex-column justify-content-end mt-1">
                <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save Changes</button>
              </div>

            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<!-- users edit ends -->
@endsection

@section('vendor-script')
  {{-- Vendor js files --}}
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/validation/jqBootstrapValidation.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
  <script src="{{ url('js/scripts/state.js') }}"></script>
@endsection

@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset(mix('js/scripts/pages/app-user.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/navs/navs.js')) }}"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>
  <script type="text/javascript">
    $('#source_name').on('change', function(){
      var source = $('#source_name').val();
      var employer_id = $('#employer_id').val();
      location.href = '/employees/upload?source='+source+'&employer_id='+employer_id;
    });
    $('#employer_id').on('change', function(){
      var source = $('#source_name').val();
      var employer_id = $('#employer_id').val();
      location.href = '/employees/upload?source='+source+'&employer_id='+employer_id;
    });
  </script>
@endsection