@extends('layouts/contentLayoutMaster')

@section('title', 'Task History')

@section('vendor-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/ag-grid/ag-grid.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/ag-grid/ag-theme-material.css')) }}">
@endsection

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/pages/app-user.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/pages/aggrid.css')) }}">
  <style type="text/css">
    tr {
      /*cursor: pointer !important;*/
    }
    a {
      display: block;
    }
    ul.total-count {
      margin: -9px 0px 19px 0px;
      margin-left: -37px;
      list-style: none;
    }
  </style>
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
          <li><a href="{{ url('/orders/tasks') }}"><i class="feather icon-rotate-cw users-data-filter"></i></a></li>
          <li><a data-action="close"><i class="feather icon-x"></i></a></li>
        </ul>
      </div>
    </div>
    <div class="card-content collapse show">
      <div class="card-body">
        <div class="users-list-filter">
          <form id="frm-filter" action="{{ url('/orders/tasks') }}" method="get">
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
                <label for="users-list-status">Task Type</label>
                <fieldset class="form-group">
                  <select name="type" class="form-control" onchange="filterFrm()">
                    <option value="">All</option>
                    <option <?php echo $type == 'WEB_CHECK' ? 'selected' : ''; ?> value="WEB_CHECK">WEB_CHECK</option>
                    <option <?php echo $type == 'AADHAAR_VERIFICATION' ? 'selected' : ''; ?> value="AADHAAR_VERIFICATION">AADHAAR_VERIFICATION</option>
                    <option <?php echo $type == 'PAN_VERIFICATION' ? 'selected' : ''; ?> value="PAN_VERIFICATION">PAN_VERIFICATION</option>
                    <option <?php echo $type == 'DL_VERIFICATION' ? 'selected' : ''; ?> value="DL_VERIFICATION">DL_VERIFICATION</option>
                    <option <?php echo $type == 'CRC' ? 'selected' : ''; ?> value="CRC">CRC</option>
                    <option <?php echo $type == 'AV_PHYSICAL' ? 'selected' : ''; ?> value="AV_PHYSICAL">AV_PHYSICAL</option>
                    <option <?php echo $type == 'AV_POSTAL' ? 'selected' : ''; ?> value="AV_POSTAL">AV_POSTAL</option>
                    <option <?php echo $type == 'PV_WRITTEN' ? 'selected' : ''; ?> value="PV_WRITTEN">PV_WRITTEN</option>
                    <option <?php echo $type == 'PV_VERBAL' ? 'selected' : ''; ?> value="PV_VERBAL">PV_VERBAL</option>
                    <option <?php echo $type == 'EDUCATION_VERIFICATION' ? 'selected' : ''; ?> value="EDUCATION_VERIFICATION">EDUCATION_VERIFICATION</option>
                  </select>
                </fieldset>
              </div>
              <div class="col-6 col-sm-4 col-lg-2">
                <label for="users-list-status">Employers</label>
                <fieldset class="form-group">
                  <select name="employer_id" class="form-control" onchange="filterFrm()">
                    <option value="">All</option>
                    @if($employers)
                      @foreach($employers as $employer)
                        <option {{ $employer_id == $employer->employer_id ? 'selected' : '' }} value="{{ $employer->employer_id }}">
                          @if(!empty($employer->b2b_company_name))
                            {{ $employer->b2b_company_name }} 
                              @if(!empty($employer->b2b_brand_name))
                                -- {{ $employer->b2b_brand_name }}
                              @endif
                            @else
                              {{ $employer->first_name }} {{ $employer->middle_name }} {{ $employer->last_name }}
                          @endif
                        </option>
                      @endforeach
                    @endif
                  </select>
                </fieldset>
              </div>
              <div class="col-6 col-sm-4 col-lg-2">
                <label for="users-list-status">Status</label>
                <fieldset class="form-group">
                  <select name="status" class="form-control" id="users-list-status" onchange="filterFrm()">
                    <option value="">All</option>
                    <option <?php echo $status == 'CREATED' ? 'selected' : ''; ?> value="CREATED">CREATED</option>
                    <option <?php echo $status == 'IN_PROGRESS' ? 'selected' : ''; ?> value="IN_PROGRESS">IN_PROGRESS</option>
                    <option <?php echo $status == 'WAITING_MORE_DATA' ? 'selected' : ''; ?> value="WAITING_MORE_DATA">WAITING_MORE_DATA</option>
                    <option <?php echo $status == 'SENT_TO_TP' ? 'selected' : ''; ?> value="SENT_TO_TP">SENT_TO_TP</option>
                    <option <?php echo $status == 'ERROR' ? 'selected' : ''; ?> value="ERROR">ERROR</option>
                    <option <?php echo $status == 'CANCELLED' ? 'selected' : ''; ?> value="CANCELLED">CANCELLED</option>
                    <option <?php echo $status == 'COMPLETE' ? 'selected' : ''; ?> value="COMPLETE">COMPLETED</option>
                  </select>
                </fieldset>
              </div>
              <div class="col-12 col-sm-6 col-lg-1">
                <label for="source-filter">Source</label>
                <fieldset class="form-group">
                  <select name="source" class="form-control" id="source-filter" onchange="filterFrm()">
                    <option value="">Source</option>
                    <option <?php echo (isset($source) && $source === 'B2B') ? 'selected' : ''; ?> value="B2B">B2B</option>
                    <option <?php echo (isset($source) && $source === 'B2C') ? 'selected' : ''; ?> value="B2C">B2C</option>
                  </select>
                </fieldset>
              </div>
              <div class="col-6 col-sm-4 col-lg-2">
                <label for="users-list-status">Case Number</label>
                <fieldset class="form-group">
                  <input type="text" class="form-control" name="s" id="s" value="{{ $s }}" placeholder="Search by Case Number">
                </fieldset>
              </div>
              
              <div class="col-6 col-sm-4 col-lg-2">
                <fieldset class="form-group">
                  <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1" style="margin-top: 20px;">Search</button>
                </fieldset>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- users filter end -->
  <ul class="total-count">
    <li>Shows {{ count($orders) }} of {{ $orders->total() }}</li>
  </ul>
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
                                        <th>Task Number/Employee</th>
                                        <th>Task Type</th>
                                        <th>Employer</th>
                                        <th>Status</th>
                                        <th>Priority</th>
                                        <th>Last Update</th>
                                    </tr>
                                </thead>
                                @if($orders)                                  
                                  <tbody>
                                    @foreach($orders as $order)
                                      <tr>
                                        <td>
                                            {{ $order->task_number }}
                                            {{ $order->employees_first_name }} {{ $order->employees_middle_name }} {{ $order->employees_last_name }}
                                        </td>
                                        <td>
                                            {{ $order->task_display_id }}
                                        </td>
                                        <td>
                                            @if(!empty($order->b2b_company_name))
                                              {{ $order->b2b_company_name }} 
                                              @if(!empty($order->b2b_brand_name))
                                                -- {{ $order->b2b_brand_name }}
                                              @endif
                                            @else
                                              {{ $order->employer_first_name }} {{ $order->employer_middle_name }} {{ $order->employer_last_name }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $order->status }}
                                        </td>
                                        <td>
                                            @switch($order->priority)
                                              @case('NORMAL')
                                                <span class="badge badge-success">
                                                @break
                                              @case('MEDIUM')
                                                <span class="badge badge-warning">
                                                @break
                                              @default
                                                <span class="badge badge-danger">
                                            @endswitch                                          
                                              {{ $order->priority }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($order->updated_at)->diffForHumans() }}
                                        </td>
                                        <td>
                                          <a href="{{ url('orders/tasks/edit/'.$order->id) }}" class=""><i class="fa fa-edit"></i></a>
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
  {{ $orders->links() }}
</section>
<!-- users list ends -->
@endsection

@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset(mix('js/scripts/pages/app-user.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/navs/navs.js')) }}"></script>
  <script type="text/javascript">
    function filterFrm(){
      $('#frm-filter').submit();
    }
  </script>
@endsection