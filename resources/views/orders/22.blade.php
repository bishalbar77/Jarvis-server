@php
	$lasthistory = json_decode($lasthistories);
	
	$antecedants_data = json_decode($lasthistory->antecedants_data);
	
	$candidate_data = json_decode($lasthistory->candidate_data);

	if(isset($candidate_data->pan_dob)){
		$pan_dob = $candidate_data->pan_dob;
	} else {
		$pan_dob = '';
	}

	if(isset($candidate_data->pan_no)){
		$pan_no = $candidate_data->pan_no;
	} else {
		$pan_no = '';
	}

	if(isset($candidate_data->name_as_per_pan)){
		$name_as_per_pan = $candidate_data->name_as_per_pan;
	} else {
		$name_as_per_pan = '';
	}

	if(isset($candidate_data->pan_file)){
		$pan_file = $candidate_data->pan_file;
	} else {
		$pan_file = '';
	}
	
	if(isset($antecedants_data->verification_date)){
		$verification_date = $antecedants_data->verification_date;
	} else {
		$verification_date = '';
	}

	if(isset($antecedants_data->verification_time)){
		$verification_time = $antecedants_data->verification_time;
	} else {
		$verification_time = '';
	}

	if(isset($antecedants_data->severity)){
		$severity = $antecedants_data->severity;
	} else {
		$severity = '';
	}

	if(isset($antecedants_data->conclusion)){
		$conclusion = $antecedants_data->conclusion;
	} else {
		$conclusion = '';
	}

	if(isset($antecedants_data->candidate_name->value)){
		$candidate_name = $antecedants_data->candidate_name->value;
	} else {
		$candidate_name = '';
	}

	if(isset($antecedants_data->candidate_name->match_status)){
		$candidate_match_status = $antecedants_data->candidate_name->match_status;
	} else {
		$candidate_match_status = 'MATCHED';
	}

	if(isset($antecedants_data->date_of_birth->value)){
		$date_of_birth = $antecedants_data->date_of_birth->value;
	} else {
		$date_of_birth = '';
	}

	if(isset($antecedants_data->date_of_birth->match_status)){
		$dob_match_status = $antecedants_data->date_of_birth->match_status;
	} else {
		$dob_match_status = 'MATCHED';
	}

	if(isset($antecedants_data->pan_number->value)){
		$pan_number = $antecedants_data->pan_number->value;
	} else {
		$pan_number = '';
	}

	if(isset($antecedants_data->pan_number->match_status)){
		$pan_match_status = $antecedants_data->pan_number->match_status;
	} else {
		$pan_match_status = 'MATCHED';
	}

	if(isset($antecedants_data->pan_status)){
		$pan_status = $antecedants_data->pan_status;
	} else {
		$pan_status = '';
	}

	if(isset($antecedants_data->severity_messages_id)){
		$severity_messages_id = $antecedants_data->severity_messages_id;
	} else {
		$severity_messages_id = '';
	}
@endphp
<tr>
	<th scope="row">Verification Date <span class="required-f">*</span></th>
	<td></td>
	<td>
		<input type="hidden" name="taskhistories_id" value="{{ isset($lasthistories->id) ? $lasthistories->id : '' }}">
		<input type="date" name="antecedants_data[verification_date]" id="verification_date" class="form-control" value="{{ $verification_date }}" required />
		<span id="verification_date_err" class="frm_error"></span>
	</td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
	<th scope="row">Verification Time <span class="required-f">*</span></th>
	<td></td>
	<td>
		<input type="text" name="antecedants_data[verification_time]" id="verification_time" class="form-control" value="{{ $verification_time }}" required />
		<span id="verification_time_err" class="frm_error"></span>
	</td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
	<th scope="row">Candidate Name <span class="required-f">*</span></th>
	<td>
		{{ $name_as_per_pan }}
		<input type="hidden" name="candidate_data[name_as_per_pan]" id="name_as_per_pan" class="form-control" value="{{ $name_as_per_pan }}" />
	</td>
	<td>
		<input type="hidden" name="antecedants_data[candidate_name][name]" value="Candidate Name" />
		<input type="text" name="antecedants_data[candidate_name][value]" id="candidate_name" class="form-control" value="{{ $candidate_name }}" required />
		<span id="candidate_name_err" class="frm_error"></span>
	</td>
	<td>
		<div class="form-group">
	        <ul class="list-unstyled mb-0">
	          	<li class="d-inline-block mr-2">
	            	<fieldset>
						<div class="vs-checkbox-con vs-checkbox-primary">
							<input type="checkbox" 
							{{ $candidate_match_status == 'MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[candidate_name][match_status]" value="MATCHED">
							<span class="vs-checkbox">
							<span class="vs-checkbox--check">
							<i class="vs-icon feather icon-check"></i>
							</span>
							</span>
							<span class="" style="font-size: 0.85rem;"></span>
						</div>
					</fieldset>
	          	</li>
	        </ul>
	    </div>
	</td>
	<td>
		<div class="form-group">
	        <ul class="list-unstyled mb-0">
	          	<li class="d-inline-block mr-2">
	            	<fieldset>
						<div class="vs-checkbox-con vs-checkbox-primary">
							<input type="checkbox" 
							{{ $candidate_match_status == 'PARTIAL_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[candidate_name][match_status]" value="PARTIAL_MATCHED">
							<span class="vs-checkbox">
							<span class="vs-checkbox--check">
							<i class="vs-icon feather icon-check"></i>
							</span>
							</span>
							<span class="" style="font-size: 0.85rem;"></span>
						</div>
					</fieldset>
	          	</li>
	        </ul>
	    </div>
	</td>
	<td>
		<div class="form-group">
	        <ul class="list-unstyled mb-0">
	          	<li class="d-inline-block mr-2">
	            	<fieldset>
						<div class="vs-checkbox-con vs-checkbox-primary">
							<input type="checkbox" 
							{{ $candidate_match_status == 'MIS_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[candidate_name][match_status]" value="MIS_MATCHED">
							<span class="vs-checkbox">
							<span class="vs-checkbox--check">
							<i class="vs-icon feather icon-check"></i>
							</span>
							</span>
							<span class="" style="font-size: 0.85rem;"></span>
						</div>
					</fieldset>
	          	</li>
	        </ul>
	    </div>
	</td>
</tr>

<tr>
	<th scope="row">Date of Birth <span class="required-f">*</span></th>
	<td>
		{{ $pan_dob ? date('d-m-Y', strtotime($pan_dob)) : '' }}
		<input type="hidden" name="candidate_data[pan_dob]" id="pan_dob" class="form-control" value="{{ $pan_dob }}" />
	</td>
	<td>
		<input type="hidden" name="antecedants_data[date_of_birth][name]" value="Date of Birth" />
		<input type="text" name="antecedants_data[date_of_birth][value]" id="date_of_birth" class="form-control" value="{{ $date_of_birth }}" required />
		<span id="date_of_birth_err" class="frm_error"></span>
	</td>
	<td>
		<div class="form-group">
	        <ul class="list-unstyled mb-0">
	          	<li class="d-inline-block mr-2">
	            	<fieldset>
						<div class="vs-checkbox-con vs-checkbox-primary">
							<input type="checkbox" 
							{{ $dob_match_status == 'MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[date_of_birth][match_status]" value="MATCHED">
							<span class="vs-checkbox">
							<span class="vs-checkbox--check">
							<i class="vs-icon feather icon-check"></i>
							</span>
							</span>
							<span class="" style="font-size: 0.85rem;"></span>
						</div>
					</fieldset>
	          	</li>
	        </ul>
	    </div>
	</td>
	<td>
		<div class="form-group">
	        <ul class="list-unstyled mb-0">
	          	<li class="d-inline-block mr-2">
	            	<fieldset>
						<div class="vs-checkbox-con vs-checkbox-primary">
							<input type="checkbox" 
							{{ $dob_match_status == 'PARTIAL_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[date_of_birth][match_status]" value="PARTIAL_MATCHED">
							<span class="vs-checkbox">
							<span class="vs-checkbox--check">
							<i class="vs-icon feather icon-check"></i>
							</span>
							</span>
							<span class="" style="font-size: 0.85rem;"></span>
						</div>
					</fieldset>
	          	</li>
	        </ul>
	    </div>
	</td>
	<td>
		<div class="form-group">
	        <ul class="list-unstyled mb-0">
	          	<li class="d-inline-block mr-2">
	            	<fieldset>
						<div class="vs-checkbox-con vs-checkbox-primary">
							<input type="checkbox" 
							{{ $dob_match_status == 'MIS_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[date_of_birth][match_status]" value="MIS_MATCHED">
							<span class="vs-checkbox">
							<span class="vs-checkbox--check">
							<i class="vs-icon feather icon-check"></i>
							</span>
							</span>
							<span class="" style="font-size: 0.85rem;"></span>
						</div>
					</fieldset>
	          	</li>
	        </ul>
	    </div>
	</td>
</tr>

<tr>
	<th scope="row">PAN Number <span class="required-f">*</span></th>
	<td>
		{{ $pan_no }}
		<input type="hidden" name="candidate_data[pan_no]" id="pan_no" class="form-control" value="{{ $pan_no }}" />
	</td>
	<td>
		<input type="hidden" name="antecedants_data[pan_number][name]" value="PAN Number" />
		<input type="text" name="antecedants_data[pan_number][value]" id="pan_number" class="form-control" value="{{ $pan_number }}" required />
		<span id="pan_number_err" class="frm_error"></span>
	</td>
	<td>
		<div class="form-group">
	        <ul class="list-unstyled mb-0">
	          	<li class="d-inline-block mr-2">
	            	<fieldset>
						<div class="vs-checkbox-con vs-checkbox-primary">
							<input type="checkbox" 
							{{ $pan_match_status == 'MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[pan_number][match_status]" value="MATCHED">
							<span class="vs-checkbox">
							<span class="vs-checkbox--check">
							<i class="vs-icon feather icon-check"></i>
							</span>
							</span>
							<span class="" style="font-size: 0.85rem;"></span>
						</div>
					</fieldset>
	          	</li>
	        </ul>
	    </div>
	</td>
	<td>
		<div class="form-group">
	        <ul class="list-unstyled mb-0">
	          	<li class="d-inline-block mr-2">
	            	<fieldset>
						<div class="vs-checkbox-con vs-checkbox-primary">
							<input type="checkbox" 
							{{ $pan_match_status == 'PARTIAL_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[pan_number][match_status]" value="PARTIAL_MATCHED">
							<span class="vs-checkbox">
							<span class="vs-checkbox--check">
							<i class="vs-icon feather icon-check"></i>
							</span>
							</span>
							<span class="" style="font-size: 0.85rem;"></span>
						</div>
					</fieldset>
	          	</li>
	        </ul>
	    </div>
	</td>
	<td>
		<div class="form-group">
	        <ul class="list-unstyled mb-0">
	          	<li class="d-inline-block mr-2">
	            	<fieldset>
						<div class="vs-checkbox-con vs-checkbox-primary">
							<input type="checkbox" 
							{{ $pan_match_status == 'MIS_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[pan_number][match_status]" value="MIS_MATCHED">
							<span class="vs-checkbox">
							<span class="vs-checkbox--check">
							<i class="vs-icon feather icon-check"></i>
							</span>
							</span>
							<span class="" style="font-size: 0.85rem;"></span>
						</div>
					</fieldset>
	          	</li>
	        </ul>
	    </div>
	</td>
</tr>

<tr>
  	<th scope="row">PAN Status <span class="required-f">*</span></th>
  	<td>
  		<span id="pan_status"></span>
  	</td>
  	<td>
	    <select name="antecedants_data[pan_status]" id="pan_status" class="form-control">
	    	<option>Select Option</option>
	    	<option {{ $pan_status == 'ACTIVE' ? 'selected' : '' }} value="ACTIVE">ACTIVE</option>
	    	<option {{ $pan_status == 'IN_ACTIVE' ? 'selected' : '' }} value="IN_ACTIVE">IN ACTIVE</option>
	    </select>
	    <span id="pan_status_err" class="frm_error"></span>
  	</td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
  	<th scope="row">Severity <span class="required-f">*</span></th>
	<td>
		<span id="severity_msg"></span>
		<input type="hidden" name="antecedants_data[severity_messages_id]" id="severity_messages_id" value="{{ $severity_messages_id }}" />
		@if($severity_messages_id != '')
			<label for="" id="severity_messages_id_old">
				<input type="radio" checked="" name="severity_msg">
				{{ $severity_messages_id }} -- {{ $conclusion }}
			</label>
		@endif
	</td>
  	<td>
	  	<select name="antecedants_data[severity]" id="severity" class="form-control">
	    	<option value="">Select Option</option>
	    	<option {{ $severity == 'GREEN' ? 'selected' : '' }} value="GREEN">GREEN</option>
	    	<option {{ $severity == 'YELLOW' ? 'selected' : '' }} value="YELLOW">YELLOW</option>
	    	<option {{ $severity == 'RED' ? 'selected' : '' }} value="RED">RED</option>
	    </select>
	    <span id="severity_err" class="frm_error"></span>
  	</td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
	<th scope="row">Conclusion <span class="required-f">*</span></th>
	<td></td>
	<td>
		<textarea name="antecedants_data[conclusion]" id="conclusion" class="form-control">{{ $conclusion }}</textarea>
		<span id="conclusion_err" class="frm_error"></span>
	</td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
	<th scope="row">Attachnment </th>
	<td></td>
	<td>
		<input type="file" name="attachnment[]" class="form-control" multiple />
		<span id="record_status_err" class="frm_error"></span>
	</td>
	<td></td>
	<td></td>
	<td></td>
</tr>