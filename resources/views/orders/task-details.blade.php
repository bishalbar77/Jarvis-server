@extends('layouts/contentLayoutMaster')

@section('title', 'Task Details')

@section('vendor-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/ag-grid/ag-grid.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/ag-grid/ag-theme-material.css')) }}">
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/duDialog.css') }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
@endsection

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/pages/app-user.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/pages/aggrid.css')) }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
  <style type="text/css">
    .card .card-header .heading-elements, .card .card-header .heading-elements-toggle {top: 0px;}
    #card-body-msg {overflow-y: scroll;max-height: 300px;}
    .required-f {color: red !important;}
    .frm_error {
      color: red !important;
      padding-top: 4px;
      width: 100%;
      float: left;
      font-size: 12px;
      font-weight: 600;
    }
    .form-group.sevrt-div {
      margin-bottom: 3px;
    }
  </style>
@endsection

@section('content')
<!-- users list start -->
<section class="users-list-wrapper">
  <!-- users filter start -->
  <div class="card">
    <div class="card-header row">
      <div class="col-4">
        <h4 class="card-title">Task Details</h4>
      </div>
      <div class="col-4">
        <h4 class="card-title">Employee Details</h4>
      </div>
      <div class="col-4">
        <div class="row">
          <div class="col-6">
            <h4 class="card-title">Employer Details</h4>
          </div>
          <div class="col-6">
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
              <ul class="list-inline mb-0">
                <li><a data-action="collapse"><i class="feather icon-chevron-down"></i></a></li>
                <li><a href="javascript:void(0)"><i class="feather icon-rotate-cw users-data-filter"></i></a></li>
                <li><a data-action="close"><i class="feather icon-x"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card-content collapse show">
      <div class="card-body">
        <div class="users-list-filter">
            <!-- users edit media object start -->
            <div class="row">
              <div class="col-4">
                <h4></h4>
                <div class="media mb-2">
                  <div class="media-body mt-50">
                    <p>
                      Task Name: {{ $tasks->task_display_id }}
                      <br />
                      Task Status: <span class="">{{ $tasks->status }}</span>
                      <br />
                      Priority: {{ $tasks->priority }}
                      <br />
                      TAT: {{ date('d M Y', strtotime($tasks->tat)) }}
                      <br />
                      Order Recieved Date: {{ date('d M Y', strtotime($tasks->created_at)) }}
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-4">
                <h4></h4>
                <style type="text/css">
                  #upload_avtar {
                    display: none;
                    position: relative;
                  }
                  #pro_pic:hover + #upload_avtar {
                    display: block;
                    color: red;
                    position: absolute;
                    bottom: 108px;
                  }
                </style>
                <div class="media mb-2">
                  <a class="mr-2 my-25" href="javascript:void(0)" id="pro_pic">
                  <!-- <a class="mr-2 my-25" href="{{ url('employees/edit/'.$employees->employee_id) }}" target="_blank"> -->
                    <img src="
                    @if($employees->photo_url)
                      {{ $employees->photo_url }}
                    @else
                      /images/portrait/small/avatar-s-11.jpg
                    @endif
                    " alt="users avatar" class="users-avatar-shadow rounded" height="64" width="64">
                  </a>
                  <span id="upload_avtar">
                    <button id="upload_profile_pic" class="btn btn-xs btn-info" data-toggle="modal" data-target="#UploadAvtar">Upload Avtar</button>
                  </span>
                  <div class="media-body mt-50">
                    <h4 class="media-heading">
                      <!-- <a class="mr-2 my-25" href="{{ url('employees/edit/'.$employees->employee_id) }}" target="_blank"> -->
                      <a class="mr-2 my-25" href="javascript:void(0)">
                        {{ $employees->first_name }} {{ $employees->middle_name }} {{ $employees->last_name }} 
                        @if($employees->employee_code)
                          ({{ $employees->employee_code }})
                        @else
                          ({{ $employees->employee_custom_id }})
                        @endif
                      </a>
                    </h4>
                    <p>
                      Father's Name:  {{ $employees->co_name }}<br />
                      Mobile:  {{ $employees->mobile }}<br />
                      Alise Name:  {{ $employees->alias }}<br />
                      Gender:  {{ $employees->gender == 'M' ? 'Male' : 'Female' }}<br />
                      DOB:  {{ date('d M Y', strtotime($employees->dob)) }}<br />
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-4">
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
                      Case Status: {{ $orders->status }}<br />
                      Task Number: {{ $tasks->task_number }}
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
  @if($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> {{ $message }}.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif 

  @php
  if(isset($addresses)):
      $aadr = $addresses->street_addr1.' '. 
      $addresses->street_addr2.' '. 
      $addresses->village.' '.
      $addresses->post_office.' '.
      $addresses->police_station.' '.
      $addresses->district.' '.
      $addresses->near_by.' '.
      $addresses->city.' '.
      $addresses->state.' '.
      $addresses->pincode;
    endif;
  @endphp

  @if($vpdata && $tasks->task_display_id == 'CRC')
  <div id="basic-examples">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <!-- Hoverable rows start -->
              <div class="row" id="table-hover-row">
                <div class="col-12">
                  <a href="{{ url('orders/vp/'.$tasks->task_number) }}" target="_blank">View Verified Data</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif

  @if($tasks->task_display_id == 'CRC')
    <div id="basic-examples">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-content">
              <div class="card-body">
                <!-- Hoverable rows start -->
                <div class="row" id="table-hover-row">
                  <div class="col-12">
                    <a href="{{ url('searches/cosmos?task_id='.$tasks->id.'&name='.$employees->first_name.' '.$employees->middle_name.' '.$employees->last_name.'&address='.$aadr) }}" target="_blank">Search in Court Records</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif

  <!-- Ag Grid users list section start -->
  <div id="basic-examples">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <!-- Hoverable rows start -->
              <div class="row" id="table-hover-row">
                <div class="col-12">
                  <h4 class="media-heading">Antecedents/Reply Fields</h4>
                  <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                          <th>Fields</th>
                          <th>Candidate Data</th>
                          <th>Verified</th>
                          <th>Matched</th>
                          @if($tasks->task_display_id == 'AV_POSTAL' || $tasks->task_display_id == 'EDUCATION_VERIFICATION')
                            <th>Unable to Verify</th>
                          @else
                            <th>Partial Match</th>
                          @endif
                          <th>Mis Match</th>
                        </thead>
                        <tbody>
                          <form id="frm_add_update_anc" action="{{ url('orders/antecedents-store/') }}/{{ $orders->id }}/{{ $tasks->id }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            @include('orders.'.$tasks->task_type)
                            <input type="hidden" name="report_print" id="report_print" value="Y">
                          </form>
                        </tbody>                       
                        <tfoot>
                          <th>
                            <select onchange="select_action(this.value)" class="form-control">
                              <option>Select Action</option>
                              <option value="close">Close</option>
                              <option value="reopen">Reopen</option>
                              <option value="add-comments">Add Comments</option>
                              <option value="raise-insuff">Raise Insuff</option>
                              <option value="escalate">Escalate</option>
                            </select>
                          </th>
                          <th colspan="6">
                            <!-- <button type="button" onclick="report_view()" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1 waves-effect waves-light">View Report</button> -->
                            
                            <a style="color: #fff;" onclick="submit_frm('frm_add_update_anc', 'N')" href="javascript:void(0)" id="" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1 waves-effect waves-light">Save</a>

                            <a style="color: #fff;" onclick="submit_frm('frm_add_update_anc', 'Y')" href="javascript:void(0)" id="GenerateReport" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1 waves-effect waves-light">Finalize Report</a>

                            @if(!empty($lasthistories->report_url))
                            <a style="color: #fff;" href="{{ url('/orders/report/'.$tasks->id) }}" target="_blank" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1 waves-effect waves-light">Download Report</a>
                            @endif

                            @if($tasks->task_display_id == 'AV_POSTAL')
                              <a onclick="print_postal_page(this)" style="color: #fff;" href="javascript:void(0)" data-url="{{ url('/orders/generate-postal-otp/'.$tasks->id) }}" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1 waves-effect waves-light">Print Postal</a>
                            @endif

                            @if($tasks->task_display_id == 'AV_DIGITAL')
                              <a style="color: #fff;" href="javascript:void(0)" id="send-msgg" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1 waves-effect waves-light">Send Messege</a>
                            @endif
                          </th>
                        </tfoot>
                    </table>
                  </div>
                </div>
              </div>
              <!-- Hoverable rows end -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Ag Grid users list section end -->
</section>
<!-- users list ends -->
{{-- Add Comment Modal --}}
<div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel33">Add Comments</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ url('/orders/add-comments/'.$tasks->order_id.'/'.$tasks->id) }}" method="post">
        {{ csrf_field() }}
        <div class="modal-body">
          <div class="form-group">
            <textarea placeholder="Comments" name="message" id="message-comment" class="form-control"></textarea>
          </div>
          <div style="text-align: right;">
            <button type="submit" class="btn btn-primary">Save</button>  
          </div>          
        </div>
      </form>
    </div>
  </div>
</div>
{{-- Raise Insuff Modal --}}
<div class="modal fade text-left" id="raiseInsuff" tabindex="-1" role="dialog" aria-labelledby="RaiseInsuffModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="RaiseInsuffModal">Raise Insuff</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ url('/orders/raise-insuff/'.$tasks->order_id.'/'.$tasks->id) }}" method="post">
        {{ csrf_field() }}
        <div class="modal-body">
          <div class="form-group">
            <textarea placeholder="Comments" name="message" id="message-insuff" class="form-control"></textarea>
          </div>
          <div style="text-align: right;">
            <button type="submit" class="btn btn-primary">Save</button>  
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Upload Avtar Modal --}}
<div class="modal fade text-left" id="UploadAvtar" tabindex="-1" role="dialog" aria-labelledby="UploadAvtarfModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="UploadAvtarfModal">Upload Avtar</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="javascript:void(0)" method="post">
        {{ csrf_field() }}
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 text-center">
              <div id="upload-demo"></div>
            </div>
            <div class="col-md-12">
              <div id="preview-crop-image"></div>
            </div>
            <div class="col-12 col-sm-12">
              <fieldset class="form-group">
                <strong>Select image to crop:</strong>
                <div class="custom-file">
                  <input type="file" name="profile_image" class="custom-file-input" id="image">
                  <label class="custom-file-label" for="image">Choose file</label>
                  <button type="button" class="btn btn-primary btn-block upload-image" style="margin-top:2%">Upload Image</button>
                  <input type="hidden" name="photo_url" id="photo_url" value="">
                </div>
              </fieldset>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/extensions/polyfill.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
@endsection
@section('page-script')
  <script src="{{ asset(mix('js/scripts/pickers/dateTime/pick-a-datetime.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/modal/components-modal.js')) }}"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script src="{{ asset('js/scripts/duDialog.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>
  <script type="text/javascript">
    function disable(){
      $('input, select, textarea, checkbox, radio, date').attr("disabled", "disabled");
    }
  </script>
  @if($tasks->status == '1')
    <script type="text/javascript">disable();</script>
  @endif
  <script type="text/javascript">    
    function report_view(){
      if(frm_validator() == 1){
        $('#frm_add_update_anc').attr("action", "{{ url('orders/view-report/'.$tasks->id) }}");
        $('#frm_add_update_anc').attr("target", "_blank");
        $('#frm_add_update_anc').submit();
      }
    }

    function frm_validator(){
      var flag = 1;

      if($('#Aadhaar_Status').val() == ''){
        $('#Aadhaar_Status_err').html('Please Select Aadhar Status');
        flag = 0;
      } else {
        $('#Aadhaar_Status_err').html('');
      }

      if($('#Aadhaar_Number').val() == ''){
        $('#Aadhaar_Number_err').html('Please fill Aadhar Number');
        flag = 0;
      } else {
        $('#Aadhaar_Number_err').html('');
      }

      if($('#Age_Band').val() == ''){
        $('#Age_Band_err').html('Please fill Age Band');
        flag = 0;
      } else {
        $('#Age_Band_err').html('');
      }

      if($('#Gender').val() == ''){
        $('#Gender_err').html('Please Select Gender');
        flag = 0;
      } else {
        $('#Gender_err').html('');
      }

      if($('#State').val() == ''){
        $('#State_err').html('Please fill State');
        flag = 0;
      } else {
        $('#State_err').html('');
      }

      if($('#Mobile_Number').val() == ''){
        $('#Mobile_Number_err').html('Please fill Mobile Number');
        flag = 0;
      } else {
        $('#Mobile_Number_err').html('');
      }

      if($('#Severity').val() == ''){
        $('#Severity_err').html('Please Select Severity');
        flag = 0;
      } else {
        $('#Severity_err').html('');
      }

      if($('#Conclusion').val() == ''){
        $('#Conclusion_err').html('Please fill Conclusion');
        flag = 0;
      } else {
        $('#Conclusion_err').html('');
      }

      if(flag == 1){
        return true;
      } else {
        return false;
      }
    }
  </script>
  <script type="text/javascript">
    function submit_frm(frmId,report_print){

      if(report_print == 'Y'){
        var finalize = 'finalize the report';
      } else {
        finalize = 'save the records';
      }   
      if(frm_validator() == 1){
        new duDialog('Are You Sure', 'You want to ' + finalize + '? This action cannot be undone.', duDialog.OK_CANCEL, { 
          okText: 'Confirm',
          callbacks: {
            okClick: function(){
              this.hide();
              $('#report_print').val(report_print);
              $('#frm_add_update_anc').attr("action", "{{ url('orders/antecedents-store/') }}/{{ $orders->id }}/{{ $tasks->id }}");
              $('#frm_add_update_anc').removeAttr("target");
              $('#' + frmId).submit();
            },
            cancelClick: function(){
              this.hide();
            }
          }
        });
      }      
    }

    $('#send-msgg').on('click', function(e){
        axios({
          method: 'post',
          url: '{{ url("/orders/generate-digital-messege/".$tasks->id) }}',
          data: {}
        }).then((response) => {
          console.log(response);
          new duDialog('Success', 'Messege Successfully Sent.', duDialog.OK_CANCEL, { 
          okText: 'OK',
          callbacks: {
            okClick: function(){
              this.hide();
              $('#report_print').val(report_print);
              $('#frm_add_update_anc').attr("action", "{{ url('orders/antecedents-store/') }}/{{ $orders->id }}/{{ $tasks->id }}");
              $('#frm_add_update_anc').removeAttr("target");
              $('#' + frmId).submit();
            },
            cancelClick: function(){
              this.hide();
            }
          }
        }, (error) => {
          console.log(error);
        });
      });
    });

    $('#company-message').on('keypress', function(e){
      var key = e.which;
      if(key == 13){
        axios({
          method: 'post',
          url: '/orders/sendmessage',
          data: {
            orderId: '{{ $tasks->id }}',
            message_title: 'Task #{{ $tasks->id }} {{ $tasks->task_display_id }} regarding',
            message_body: $(this).val(),
            verification_type: '0',
          }
        }).then((response) => {
          console.log(response);
          $(this).val('');
          $('#success-msg').html('Messege Sent.');
        }, (error) => {
          console.log(error);
        });
      }
    });

    $('#severity').on('change', function(e){
      axios({
        method: 'post',
        url: '/orders/get-severty',
        data: {
          task_type_id: '{{ $tasks->task_type }}',
          task_severity: $(this).val(),
        }
      }).then((response) => {
        $('#severity_messages_id_old').hide();
        $('#severity_msg').html(response.data);
        console.log(response.data);
      }, (error) => {
        console.log(error);
      });
    });

    function get_severty_msg(msgid) {
      $('#conclusion').val($(msgid).val());
      $('#severity_messages_id').val($(msgid).data('id'));
    }


    /*Generate Report*/
    // $('#GenerateReport').on('click', function(e){
    //   $(this).attr('disabled', true);
    //   axios({
    //     method: 'get',
    //     url: '/orders/generate/{{ $tasks->id }}',
    //     data: {
    //       task_id: '{{ $tasks->id }}',
    //     }
    //   }).then((response) => {
    //     console.log(response);
    //     $('#ReportMsg').html('Report Generated');
    //     $(this).removeAttr('id');
    //     $(this).removeAttr('disabled');
    //     $(this).text('View Report');
    //     $(this).attr('href', '{{ url("/orders/report/".$tasks->id) }}');
    //     $(this).attr('target', '_blank');
    //     // alert(response.data.response.data.report_file);
    //   }, (error) => {
    //     $('#ReportMsg').html('Somthing Wrong! Try Again');
    //   });
    // });
    
    function filterFrm(){
      $('#frm-filter').submit();
    }

    function select_action(action){
      if(action == 'add-comments'){
        $('#inlineForm').modal('show');
      }
      if(action == 'raise-insuff'){
        $('#raiseInsuff').modal('show');
      }
      if(action == 'escalate'){
        $('#escalate').modal('show');
      }
      if(action == 'sms-history'){
        $('#smshistory').modal('show');
      }
      // if(action == 'add-comments'){
      //   $('#inlineForm').modal('show');
      // }
    }


    $(document).ready(function () {
      $('#escalate_to').on('change', function(){
        $('#escalate_name').val($(this).find("option:selected").text());
      })

      $('#confirm-color1').on('click', function () {
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!',
          confirmButtonClass: 'btn btn-primary',
          cancelButtonClass: 'btn btn-danger ml-1',
          buttonsStyling: false,
        }).then(function (result) {
          if (result.value) {
            Swal.fire({
              type: "success",
              title: 'Deleted!',
              text: 'Your file has been deleted.',
              confirmButtonClass: 'btn btn-success',
            })
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire({
              title: 'Cancelled',
              text: 'Your imaginary file is safe :)',
              type: 'error',
              confirmButtonClass: 'btn btn-success',
            })
          }
        })
      });
    });

    function setStatusVal(value, field_id){
      $('#' + field_id).val(value);
    }

    $('#Severity').on('change', function(){
      var val = $(this).children("option:selected").val();

      if(val == 'Green'){
        $('#Conclusion').val('Record Found in Aadhar Database');
      } else if(val == 'Discrepant'){
        $('#Conclusion').val('Discrepant');
      } else if(val == 'Inconclusive'){
        $('#Conclusion').val('Inconclusive');
      } else {
        $('#Conclusion').val('');
      }
    });
  </script>

  <script type="text/javascript">
    $("input:checkbox").on('click', function() {
  var $box = $(this);
  if ($box.is(":checked")) {
    var group = "input:checkbox[name='" + $box.attr("name") + "']";
    $(group).prop("checked", false);
    $box.prop("checked", true);
  } else {
    $box.prop("checked", false);
  }
});
  </script>

    <script type="text/javascript">

$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});


var resize = $('#upload-demo').croppie({
    enableExif: true,
    enableOrientation: true,    
    viewport: {
        width: 300,
        height: 300,
        type: 'square' //circle
    },
    boundary: {
        width: 350,
        height: 350
    }
});


$('#image').on('change', function () { 
  var reader = new FileReader();
    reader.onload = function (e) {
      resize.croppie('bind',{
        url: e.target.result
      }).then(function(){
        console.log('jQuery bind complete');
      });
    }
    reader.readAsDataURL(this.files[0]);
});


$('.upload-image').on('click', function (ev) {
  resize.croppie('result', {
    type: 'canvas',
    size: 'viewport'
  }).then(function (img) {
    $.ajax({
      url: "{{ url('upload-file') }}",
      type: "POST",
      data: { "image" : img },
      success: function (data) {
        html = '<img src="' + img + '" class="img-fluid" />';
        $("#preview-crop-image").html(html);
        $('#photo_url').val(data);
      }
    });
  });
});

  function print_postal_page(frm){
    new duDialog('Are You Sure', 'You want to Print Postal Page? This action cannot be undone.', duDialog.OK_CANCEL, { 
      okText: 'Confirm',
      callbacks: {
        okClick: function(){
          this.hide();
          window.open($(frm).data('url'));
        },
        cancelClick: function(){
          this.hide();
        }
      }
    });
  }
</script>

@endsection
<?php
  function getWorkingDays($startDate,$endDate,$holidays){
    $endDate = strtotime($endDate);
    $startDate = strtotime($startDate);
    $days = ($endDate - $startDate) / 86400 + 1;

    $no_full_weeks = floor($days / 7);
    $no_remaining_days = fmod($days, 7);

    $the_first_day_of_week = date("N", $startDate);
    $the_last_day_of_week = date("N", $endDate);

    if ($the_first_day_of_week <= $the_last_day_of_week) {
      if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
      if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
    } else {
      if ($the_first_day_of_week == 7) {
        $no_remaining_days--;
        if ($the_last_day_of_week == 6) {
          $no_remaining_days--;
        }
      } else {
        $no_remaining_days -= 2;
      }
    }
    $workingDays = $no_full_weeks * 5;
    
    if ($no_remaining_days > 0 ) {
      $workingDays += $no_remaining_days;
    }
    
    foreach($holidays as $holiday){
      $time_stamp=strtotime($holiday);
      if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N",$time_stamp) != 6 && date("N",$time_stamp) != 7)
      $workingDays--;
    }
    return $workingDays;
  }
?>