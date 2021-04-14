@extends('layouts/contentLayoutMaster')

@section('title', 'Surveys List')

@section('vendor-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/ag-grid/ag-grid.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/ag-grid/ag-theme-material.css')) }}">
@endsection

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/pages/app-user.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/pages/aggrid.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/duDialog.css') }}">
@endsection

@section('content')
<!-- surveys list start -->
<section class="surveys-list-wrapper">
  <!-- surveys filter start -->
  <div class="card">
    <div class="card-header">
      <h4 class="card-title">Filters</h4>
      <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
      <div class="heading-elements">
        <ul class="list-inline mb-0">
          <li><a data-action="collapse"><i class="feather icon-chevron-down"></i></a></li>
          <li><a href="{{ url('/surveys') }}"><i class="feather icon-rotate-cw surveys-data-filter"></i></a></li>
          <li><a data-action="close"><i class="feather icon-x"></i></a></li>
        </ul>
      </div>
    </div>
    <div class="card-content collapse show">
      <div class="card-body">
        <div class="surveys-list-filter">
          <form id="frm-filter" action="{{ url('/surveys') }}" method="get">
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
                        <option <?php echo isset($_GET['employer_id']) && $_GET['employer_id'] == $employer->id ? 'selected' : ''; ?> value="{{ $employer->id }}">
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
              <div class="col-12 col-sm-6 col-lg-3">
                <label for="status">Status</label>
                <fieldset class="form-group">
                  <select name="status" class="form-control" id="status" onchange="filterFrm()">
                    <option value="">All</option>
                    <option <?php echo $_GET['status'] ?? '' && $_GET['status'] == 'DRAFT' ? 'selected' : ''; ?> value="DRAFT">DRAFT</option>
                    <option <?php echo $_GET['status'] ?? '' && $_GET['status'] == 'COMPLETE' ? 'selected' : ''; ?> value="COMPLETE">COMPLETE</option>
                  </select>
                </fieldset>
              </div>
              <div class="col-12 col-sm-6 col-lg-3">
                <label for="severity">Conclusion</label>
                <fieldset class="form-group">
                  <select name="severity" class="form-control" id="severity" onchange="filterFrm()">
                    <option value="">All</option>
                    <option <?php echo $_GET['severity'] ?? '' && $_GET['severity'] == 'GREEN' ? 'selected' : ''; ?> value="GREEN">GREEN</option>
                    <option <?php echo $_GET['severity'] ?? '' && $_GET['severity'] == 'RED' ? 'selected' : ''; ?> value="RED">RED</option>
                    <option <?php echo $_GET['severity'] ?? '' && $_GET['severity'] == 'NOT_DONE' ? 'selected' : ''; ?> value="NOT_DONE">NOT DONE</option>
                  </select>
                </fieldset>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- surveys filter end -->
  @if($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success : </strong> {{ $message }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif
  <!-- Ag Grid surveys list section start -->
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
                                        <th>Survey Type</th>
                                        <th>Employee</th>
                                        <th>Employer</th>
                                        <th>Status</th>
                                        <th>Conclusion</th>
                                        <th>Create At</th>
                                        <th style="text-align: right;">Action</th>
                                    </tr>
                                </thead>
                                @if($surveys)                                  
                                  <tbody>
                                    @foreach($surveys as $survey)
                                      <tr>
                                        <td>{{ $survey->survey_type }}</td>
                                        <td>
                                          @if($survey->visitor_id != '')
                                            {{ $survey->vfname.' '.$survey->vmname.' '.$survey->vlname }}
                                          @else
                                            {{ $survey->first_name.' '.$survey->middle_name.' '.$survey->last_name }}
                                          @endif
                                        </td>
                                        <td>
                                          @if(!empty($survey->b2b_company_name))
                                            {{ $survey->b2b_company_name }} 
                                            @if(!empty($survey->b2b_brand_name))
                                              ({{ $survey->b2b_brand_name }})
                                            @endif
                                          @else
                                            {{ $survey->first_name }} {{ $survey->middle_name }} {{ $survey->last_name }}
                                          @endif
                                        </td>
                                        <td>{{ $survey->survey_status }}</td>
                                        <td>{{ $survey->severity ?? 'NOT DONE' }}</td>
                                        <td>{{ $survey->created_at }}</td>
                                        <td align="right" width="300px">
                                          <span>
                                            <a onclick="resend_survey({{$survey->id}})" href="javascript:void(0)">
                                              Resend
                                            </a> | 
                                            <a href="surveys/show/{{ $survey->id }}">
                                              View Details
                                            </a> | <a href="https://www.gettruehelp.com/healthcheck/?eid={{ md5($survey->employee_id) }}" type="submit" target="-_blank">View Survey</a>
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
  <!-- Ag Grid surveys list section end -->
  {{ $surveys->appends($_GET)->links() }}
</section>
@endsection
<!-- surveys list ends -->
@section('page-script')
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
<script src="{{ asset('js/scripts/duDialog.js') }}"></script>
<script type="text/javascript">
  function filterFrm(){
    $('#frm-filter').submit();
  }

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
  });

  function resend_survey(id){
    $.ajax({
      type :'POST',
      url  :'/surveys/resend',
      data: {
        id : id,
      },
      success:function(data){
        if(data == 'SUCCESS'){
          new duDialog('Success', 'Messege Successfully Sent.', duDialog.OK_CANCEL, { 
            okText: 'OK',
            callbacks: {
              okClick: function(){
                this.hide();
              },
              cancelClick: function(){
                this.hide();
              }
            }
          }, (error) => {
            console.log(error);
          });
        }
      }
    });
  }
</script>
@endsection