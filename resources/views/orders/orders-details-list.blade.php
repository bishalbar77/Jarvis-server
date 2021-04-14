@extends('layouts/contentLayoutMaster')

@section('title', 'Order Details')

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
    .clickable-row {
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
      <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
      <div class="heading-elements">
        <ul class="list-inline mb-0">
          <li><a data-action="collapse"><i class="feather icon-chevron-down"></i></a></li>
          <li><a href="javascript:void(0)"><i class="feather icon-rotate-cw users-data-filter"></i></a></li>
          <li><a data-action="close"><i class="feather icon-x"></i></a></li>
        </ul>
      </div>
    </div>
    <div class="card-content collapse show">
      <div class="card-body">
        <div class="users-list-filter">
            <!-- users edit media object start -->
            <div class="row">
              <div class="col-6">
                <h4></h4>
                <div class="media mb-2">
                  <a class="mr-2 my-25" href="javascript:void(0)">
                  <!-- <a class="mr-2 my-25" href="{{ url('employees/edit/'.$employees->employee_id) }}" target="_blank"> -->
                    <img src="
                    @if($employees->photo_url)
                      {{ $employees->photo_url }}
                    @else
                      /images/portrait/small/avatar-s-11.jpg
                    @endif
                    " alt="users avatar" class="users-avatar-shadow rounded" height="64" width="64">
                  </a>
                  <div class="media-body mt-50">
                    <h4 class="media-heading">
                      <a class="mr-2 my-25" href="javascript:void(0)">
                      <!-- <a class="mr-2 my-25" href="{{ url('employees/edit/'.$employees->employee_id) }}" target="_blank"> -->
                        {{ $employees->first_name }} {{ $employees->middle_name }} {{ $employees->last_name }} 
                        @if($employees->employee_code)
                          ({{ $employees->employee_code }})
                        @else
                          ({{ $employees->employee_custom_id }})
                        @endif
                      </a>
                    </h4>
                    <p>
                      Father Name:  {{ $employees->co_name }}<br />
                      Mobile:  {{ $employees->mobile }}<br />
                      Alise Name:  {{ $employees->alias }}<br />
                      DOB:  {{ date('d M Y', strtotime($employees->dob)) }}<br />
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="media mb-2">
                  <a class="mr-2 my-25" href="javascript:void(0)">
                  <!-- <a class="mr-2 my-25" href="{{ url('employers/edit/'.$employers->employer_id) }}" target="_blank"> -->
                      <img src="
                      @if($employers->photo_url)
                        {{ $employers->photo_url }}
                      @else
                        /images/portrait/small/avatar-s-11.jpg
                      @endif
                      " alt="users avatar" class="users-avatar-shadow rounded" height="64" width="64">
                  </a>
                  <div class="media-body mt-50">
                    <h4 class="media-heading">
                      <a class="mr-2 my-25" href="javascript:void(0)">
                      <!-- <a href="{{ url('employers/edit/'.$employers->employer_id) }}" target="_blank"> -->
                        @if(!empty($employers->b2b_company_name))
                          {{ $employers->b2b_company_name }} 
                          @if(!empty($employers->b2b_brand_name))
                            -- {{ $employers->b2b_brand_name }}
                          @endif
                        @else
                          {{ $employers->first_name }} {{ $employers->middle_name }} {{ $employers->last_name }}
                        @endif
                      </a>
                    </h4>
                    <p>
                      Employer Code : {{ $employers->employer_custom_id }}<br />
                      Case Number: {{ $orders->order_number }}<br />
                      Current Status: {{ $orders->status }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <!-- users edit media object ends -->
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
                                        <th>Check No.</th>
                                        <th>Check</th>
                                        <th>Current Status</th>
                                        <th>Priority</th>
                                        <th>TAT</th>
                                        <th>Last Update</th>
                                    </tr>
                                </thead>
                                @if($tasks)                                  
                                  <tbody>
                                    @foreach($tasks as $task)
                                      <tr>
                                        <th scope="row">
                                          <a href="{{ url('/orders/task/'.$orders->id.'/'.$task->id) }}">
                                            {{ $task->task_number }}
                                          </a>
                                        </td>
                                        <td><a href="{{ url('/orders/task/'.$orders->id.'/'.$task->id) }}">{{ $task->task_display_id }}</a></td>
                                        <td><a href="{{ url('/orders/task/'.$orders->id.'/'.$task->id) }}">{{ $task->status }}</a></td>
                                        <td>
                                          <a href="{{ url('/orders/task/'.$orders->id.'/'.$task->id) }}">
                                            @switch($task->priority)
                                              @case('NORMAL')
                                                <span class="badge badge-success">
                                                @break
                                              @case('MEDIUM')
                                                <span class="badge badge-warning">
                                                @break
                                              @default
                                                <span class="badge badge-danger">
                                            @endswitch                                          
                                              {{ $task->priority }}
                                            </span>
                                          </span>
                                        </td>
                                        <td>
                                          <a href="{{ url('/orders/task/'.$orders->id.'/'.$task->id) }}">
                                            {{ date('d M Y', strtotime($task->tat)) }}
                                          </a>
                                        </td>
                                        <td>
                                          <a href="{{ url('/orders/task/'.$orders->id.'/'.$task->id) }}">
                                            {{ \Carbon\Carbon::parse($task->updated_at)->diffForHumans() }}
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

    jQuery(document).ready(function($) {
      $(".clickable-row").click(function() {
        window.location = $(this).data("href");
      });
    });
  </script>
@endsection