@extends('layouts/contentLayoutMaster')

@section('title', 'Order History')

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
      cursor: pointer !important;
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
          <li><a href="{{ url('/orders') }}"><i class="feather icon-rotate-cw users-data-filter"></i></a></li>
          <li><a data-action="close"><i class="feather icon-x"></i></a></li>
        </ul>
      </div>
    </div>
    <div class="card-content collapse show">
      <div class="card-body">
        <div class="users-list-filter">
          <form id="frm-filter" action="{{ url('/orders') }}" method="get">
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
                <label for="users-list-status">Status</label>
                <fieldset class="form-group">
                  <select name="status" class="form-control" id="users-list-status" onchange="filterFrm()">
                    <option value="">All</option>
                    <option value="">Un-Assign</option>
                    <option value="">Work in Progress</option>
                    <option value="">Work in Progress</option>
                    <option value="">Awaiting Response</option>
                    <option value="">Awaiting Response</option>
                    <option value="">Completed</option>
                    <option <?php echo (isset($filter['additional_amount_status']) && $filter['additional_amount_status'] == '1') ? 'selected' : ''; ?> value="active">Active</option>
                    <option <?php echo (isset($filter['additional_amount_status']) && $filter['additional_amount_status'] === '0') ? 'selected' : ''; ?> value="deactive">Deactivated</option>
                  </select>
                </fieldset>
              </div>
              <div class="col-12 col-sm-6 col-lg-2">
                <label for="source-filter">Source</label>
                <fieldset class="form-group">
                  <select name="source" class="form-control" id="source-filter" onchange="filterFrm()">
                    <option value="">Select Source</option>
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
                                      <th>Case Number</th>
                                      <th>Order Type</th>
                                      <th>Employer</th>
                                      <th>Employee</th>
                                      <th>Status</th>
                                      <th>Priority</th>
                                      <th>Expacted Delivery</th>
                                      <th>TAT Status</th>
                                      <th>Last Update</th>
                                    </tr>
                                </thead>
                                @if($orders)                                  
                                  <tbody>
                                    @foreach($orders as $order)
                                      <tr>
                                        <td>
                                          <a href="{{ url('/orders/view/'.$order->id) }}">
                                            {{ $order->order_number }}
                                          </a>
                                        </td>
                                        <td>
                                          <a href="{{ url('/orders/view/'.$order->id) }}">
                                            {{ $order->order_dispaly_desc }}
                                          </a>
                                        </td>
                                        <td>
                                          <a href="{{ url('/orders/view/'.$order->id) }}">
                                            @if(!empty($order->b2b_company_name))
                                              {{ $order->b2b_company_name }} 
                                              @if(!empty($order->b2b_brand_name))
                                                -- {{ $order->b2b_brand_name }}
                                              @endif
                                            @else
                                              {{ $order->employer_first_name }} {{ $order->employer_middle_name }} {{ $order->employer_last_name }}
                                            @endif
                                          </a>
                                        </td>
                                        <td>
                                          <a href="{{ url('/orders/view/'.$order->id) }}">
                                            {{ $order->employees_first_name }} {{ $order->employees_middle_name }} {{ $order->employees_last_name }}
                                          </a>
                                        </td>
                                        <td>
                                          <a href="{{ url('/orders/view/'.$order->id) }}">
                                            {{ $order->status }}
                                          </a>
                                        </td>
                                        <td>
                                          <a href="{{ url('/orders/view/'.$order->id) }}">
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
                                          </a>
                                        </td>
                                        <td>
                                          <a href="{{ url('/orders/view/'.$order->id) }}">
                                            {{ date('d M Y', strtotime($order->tat)) }}
                                          </a>
                                        </td>
                                        <td>
                                          <a href="{{ url('/orders/view/'.$order->id) }}">
                                            <span class="badge badge-{{ $order->tat_color }}">
                                              @if($order->tat_days > 0)
                                                IN TAT
                                              @else
                                                OUT OF TAT
                                              @endif
                                            </span>
                                          </a>
                                        </td>
                                        <td>
                                          <a href="{{ url('/orders/view/'.$order->id) }}">
                                            {{ \Carbon\Carbon::parse($order->updated_at)->diffForHumans() }}
                                          </a>
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