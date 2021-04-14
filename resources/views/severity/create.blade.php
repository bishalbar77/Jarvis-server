@extends('layouts/contentLayoutMaster')
@section('title', 'Create Severity')
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
<!-- severity edit start -->
<div class="row">
  <div class="col-12 col-sm-5">
    <section class="users-edit">
      <div class="card">
        <div class="card-content">
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                <!-- severity edit account form start -->
                <form novalidate action="{{ url('severity/store') }}" method="post" enctype="multipart/form-data" onsubmit="return validation()">
                  {{ csrf_field() }}
                  
                  <div class="form-group">
                    <label>Task Type</label>
                    <select name="task_type_id" id="task_type_id" class="select2 form-control">
                      <option value="">Select</option>
                      @if($tasktypes)
                        @foreach($tasktypes as $tasktype)
                          <option value="{{ $tasktype->id }}">{{ $tasktype->task_type }}</option>
                        @endforeach
                      @endif
                    </select>                      
                    @if($errors->has('name'))
                      <p class="text-danger" id="task_type_id_error">{{ $errors->first('task_type_id') }}</p>
                    @else
                      <p class="text-danger" id="task_type_id_error"></p>
                    @endif
                  </div>

                  <div class="form-group">
                    <label>Severity</label>
                    <select name="task_severity" id="task_severity" class="select2 form-control">
                      <option value="">Select</option>
                      <option value="GREEN">GREEN</option>
                      <option value="YELLOW">YELLOW</option>
                      <option value="RED">RED</option>
                    </select>
                    @if($errors->has('task_severity'))
                      <p class="text-danger">{{ $errors->first('task_severity') }}</p>
                    @else
                      <p class="text-danger" id="task_severity_error"></p>
                    @endif
                  </div>

                  <div class="form-group">
                    <label>Conclusion List</label>
                    <select name="severity_message_id" id="severity_message_id" class="select2 form-control">
                      <option value="">Select</option>
                      <option value="new">Add New</option>
                      @if($messeges)
                        @foreach($messeges as $messege)
                          <option value="{{ $messege->id }}">{{ $messege->id }} -- {{ $messege->severity_message }}</option>
                        @endforeach
                      @endif
                    </select>
                    @if($errors->has('severity_message_id'))
                      <p class="text-danger">{{ $errors->first('severity_message_id') }}</p>
                    @else
                      <p class="text-danger" id="severity_message_id_error"></p>
                    @endif
                  </div>

                  <div class="form-group" id="task_severity_message_div">
                    <div class="controls">
                      <label>Conclusion List</label>
                      <textarea name="task_severity_message" id="task_severity_message" class="form-control" placeholder="Severity Message"></textarea>
                      @if($errors->has('task_severity_message'))
                        <p class="text-danger">{{ $errors->first('task_severity_message') }}</p>
                      @else
                      <p class="text-danger" id="task_severity_message_error"></p>
                      @endif
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                      <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Submit</button>
                      <button type="reset" class="btn btn-outline-warning">Reset</button>
                    </div>
                  </div> 
                </form>
                <!-- severity edit account form ends -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- severity edit ends -->
  </div>
</div>
@endsection

@section('vendor-script')
  {{-- Vendor js files --}}
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/validation/jqBootstrapValidation.js')) }}"></script>
@endsection

@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset(mix('js/scripts/forms/select/form-select2.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/pages/app-user.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/navs/navs.js')) }}"></script>
  <script type="text/javascript">
    $(function() {
      $('#task_severity_message_div').hide(); 
      $('#severity_message_id').change(function(){
        if($('#severity_message_id').val() == 'new') {
          $('#task_severity_message_div').show();
          $('#task_severity_message').attr('required', 'required');
        } else {
          $('#task_severity_message_div').hide();
          $('#task_severity_message').removeAttr('required'); 
        } 
      });
    });

    function validation(){

      var flag = 0;

      if($('#task_type_id').val() == ''){
        $('#task_type_id_error').html('Please Select Task Type');
        flag = 1;
      } else {
        $('#task_type_id_error').html('');
        flag = 0;
      }

      if($('#task_severity').val() == ''){
        $('#task_severity_error').html('Please Severity');
        flag = 1;
      } else {
        $('#task_severity_error').html('');
        flag = 0;
      }
      
      if($('#severity_message_id').val() == ''){
        $('#severity_message_id_error').html('Please Select Conclusion List');
        flag = 1;
      } else {
        $('#severity_message_id_error').html('');
        flag = 0;
      }

      if($('#severity_message_id').val() == 'new'){
        if($('#task_severity_message').val() == ''){
          $('#task_severity_message_error').html('Please Select Task Type');
          flag = 1;
        } else {
          $('#task_severity_message_error').html('');
          flag = 0;
        }     
      }

      if(flag == 1){
        return false;
      }
      return true;
    }
  </script>
@endsection

