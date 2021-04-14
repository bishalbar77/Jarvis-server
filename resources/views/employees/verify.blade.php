@extends('layouts/contentLayoutMaster')

@section('title', 'Upload Employee')

@section('vendor-style')
  {{-- Page Css files --}}
@endsection

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/plugins/forms/validation/form-validation.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/pages/app-user.css')) }}">
  <style type="text/css">
    .picker {
      margin-top: -159px;
    }
    .table th {
    	line-height: 0px;
	}
  </style>
@endsection

@section('content')
<div id="basic-examples">
	<div class="card">
		<div class="card-content">
			<div class="card-body">
				<form action="{{ url('employees/bulk-upload') }}" method="post" id="validate_form">
              		@csrf
					<div class="row" id="table-hover-row">
						<div class="col-12">
							<div class="card">
								<div class="card-content">
									<div class="table-responsive">
										<input type="hidden" id="employer_id" name="employer_id" value="{{ $employer_id }}">
										<input type="hidden" id="source" name="source" value="{{ $source }}">
										<table class="table table-hover mb-0">
											<thead>
												<tr>
													<th>#</th>
													<th>Employee Types</th>
													<th>Employee Code</th>
													<th>Document Types</th>
													<th>Document Number</th>
													<th>First Name</th>
													<th>Middle Name</th>
													<th>Last Name</th>
													<th>Alias Name</th>
													<th>Relation</th>
													<th>C/O</th>
													<th>E-mail</th>
													<th>Mobile Number</th>
													<th>Birth date</th>
													<th>Gender</th>
													<th>Salary</th>
													<th>Joining Date</th>
												</tr>
											</thead>
											<tbody class="t-body">
												@foreach($data as $employee)
													@foreach($employee as $count => $key )
														@if(!empty($key['Employee Types']))
														<tr>
															<td>{{ $count + 1 }}</td>
															<td>
																<input class="form-control" name="employee_types[]" value="{{ $key['Employee Types']}}" style="width:170px;" required="">
															</td>
															<td>
																<input class="form-control" name="employee_code[]" value="{{ $key['Employee Code']}}" style="width:170px;" required="">
															</td>
															<td>
																<input class="form-control" name="document_types[]" value="{{ $key['Document Types']}}" style="width:170px;">
															</td>
															<td>
																<input class="form-control" name="document_number[]" value="{{ $key['Document Number']}}" style="width:170px;">
															</td>
															<td>
																<input class="form-control" name="first_name[]" value="{{ $key['First Name']}}" style="width:170px;" required="">
															</td>
															<td>
																<input class="form-control" name="middle_name[]" value="{{ $key['Middle Name']}}" style="width:170px;">
															</td>
															<td>
																<input class="form-control" name="last_name[]" value="{{ $key['Last Name']}}" style="width:170px;">
															</td>
															<td>
																<input class="form-control" name="alias_name[]" value="{{ $key['Alias Name']}}" style="width:170px;">
															</td>
															<td>
																<input class="form-control" name="relation[]" value="{{ $key['Relation']}}" style="width:170px;">
															</td>
															<td>
																<input class="form-control" name="c_o[]" value="{{ $key['C/O']}}" style="width:170px;">
															</td>
															<td>
																<input class="form-control" name="email[]" value="{{ $key['E-mail']}}" style="width:170px;">
															</td>
															<td>
																<div class="row" style="min-width: 170px;">
																	<div class="col-3">
																		<input class="form-control" name="country_code[]" value="{{ $key['Country Code']}}" style="width: 35px;">
																	</div>
																	<div class="col-9">
																		<input class="form-control" name="mobile_number[]" value="{{ $key['Mobile Number']}}" required="">
																	</div>
																</div>															
															</td>
															<td>
																<input class="form-control" name="birth_date[]" value="{{ $key['Birth date']}}" style="width:170px;" required="">
															</td>
															<td>
																<input class="form-control" name="gender[]" value="{{ $key['Gender']}}" style="width:170px;" required="">
															</td>
															<td>
																<input class="form-control" name="salary[]" value="{{ $key['Salary']}}" style="width:170px;">
															</td>
															<td>
																<input class="form-control" name="joining_date[]" value="{{ $key['Joining Date']}}" style="width:170px;">
															</td>
														</tr>
														@endif
													@endforeach
												@endforeach
											</tbody>
											<tfoot>
												<tr>
													<td colspan="17">
														<button class="btn btn-info btn-sm">Save</button>
													</td>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
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
      location.href = '/employees/upload?source='+source;
    });
  </script>
@endsection