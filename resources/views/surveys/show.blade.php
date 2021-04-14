@extends('layouts/contentLayoutMaster')
@section('title', 'Survey Details')
@section('vendor-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
@endsection
@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/plugins/forms/validation/form-validation.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/pages/app-user.css')) }}">
@endsection

@section('content')
<!-- orders edit start -->
<section class="orders-edit">
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
                              <tbody>
                                  <tr>
                                    <th>Employer</th>
                                    <td>{{ $surveys->b2b_company_name.' -- '.$surveys->b2b_brand_name }}</td>
                                  </tr>
                                  <tr>
                                    <th>Employee</th>
                                    <td>
                                      @if($surveys->visitor_id != '')
                                        {{ $surveys->vfname.' '.$surveys->vmname.' '.$surveys->vlname }}
                                      @else
                                        {{ $surveys->first_name.' '.$surveys->middle_name.' '.$surveys->last_name }}
                                      @endif
                                    </td>
                                  </tr>
                                  <tr>
                                    <th>Survey Type</th>
                                    <td>{{ $surveys->survey_type }}</td>
                                  </tr>
                                  <tr>
                                    <th>Start</th>
                                    <td>{{ $surveys->survey_start }}</td>
                                  </tr>
                                  <tr>
                                    <th>End</th>
                                    <td>{{ $surveys->survey_end }}</td>
                                  </tr>
                                  <tr>
                                    <th>Conclusion</th>
                                    <td>{{ $surveys->severity ?? 'NOT DONE' }}</td>
                                  </tr>
                                  <tr>
                                    <th>Created At</th>
                                    <td>{{ $surveys->created_at }}</td>
                                  </tr>
                                  <tr>
                                    <th>Status</th>
                                    <td>{{ $surveys->survey_status }}</td>
                                  </tr>
                                  @if($answers)
                                    @foreach($answers as $answer)
                                      <tr>
                                        <th>{{ $answer->question_answer }}</th>
                                        <td>{{ str_replace(array('<employer_name>', '<employer/school name>'), $surveys->b2b_company_name.' -- '.$surveys->b2b_brand_name, $answer->question) }}</td>
                                      </tr>
                                    @endforeach
                                  @endif
                              </tbody>
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
</section>
<!-- employers edit ends -->
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

