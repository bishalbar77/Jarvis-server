@php
	$lasthistory = json_decode($lasthistories);
	$antecedants_data = json_decode($lasthistory->antecedants_data);
	$candidate_data = json_decode($lasthistory->candidate_data);
	
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

	if(isset($antecedants_data->cource_name->value)){
		$cource_name = $antecedants_data->cource_name->value;
	} else {
		$cource_name = '';
	}

	if(isset($candidate_data->edu_course_name)){
		$edu_course_name = $candidate_data->edu_course_name;
	} else {
		$edu_course_name = '';
	}

	if(isset($antecedants_data->cource_name->match_status)){
		$cource_name_match_status = $antecedants_data->cource_name->match_status;
	} else {
		$cource_name_match_status = '';
	}

	if(isset($antecedants_data->edu_passing_year->value)){
		$edu_passing_year = $antecedants_data->edu_passing_year->value;
	} else {
		$edu_passing_year = '';
	}

	if(isset($candidate_data->edu_passing_year)){
		$cedu_passing_year = $candidate_data->edu_passing_year;
	} else {
		$cedu_passing_year = '';
	}

	if(isset($antecedants_data->edu_passing_year->match_status)){
		$edu_passing_year_match_status = $antecedants_data->edu_passing_year->match_status;
	} else {
		$edu_passing_year_match_status = '';
	}

	if(isset($antecedants_data->edu_roll_no->value)){
		$edu_roll_no = $antecedants_data->edu_roll_no->value;
	} else {
		$edu_roll_no = '';
	}

	if(isset($candidate_data->edu_roll_no)){
		$cedu_roll_no = $candidate_data->edu_roll_no;
	} else {
		$cedu_roll_no = '';
	}

	if(isset($antecedants_data->edu_roll_no->match_status)){
		$edu_roll_no_match_status = $antecedants_data->edu_roll_no->match_status;
	} else {
		$edu_roll_no_match_status = '';
	}

	if(isset($antecedants_data->edu_school_name->value)){
		$edu_school_name = $antecedants_data->edu_school_name->value;
	} else {
		$edu_school_name = '';
	}

	if(isset($candidate_data->edu_school_name)){
		$cedu_school_name = $candidate_data->edu_school_name;
	} else {
		$cedu_school_name = '';
	}

	if(isset($antecedants_data->edu_school_name->match_status)){
		$edu_school_name_match_status = $antecedants_data->edu_school_name->match_status;
	} else {
		$edu_school_name_match_status = '';
	}

	if(isset($antecedants_data->severity_messages_id)){
		$severity_messages_id = $antecedants_data->severity_messages_id;
	} else {
		$severity_messages_id = '';
	}

	if(isset($antecedants_data->verifier_contact_details->value)){
		$verifier_contact_details = $antecedants_data->verifier_contact_details->value;
	} else {
		$verifier_contact_details = '';
	}

	if(isset($antecedants_data->remarks->value)){
		$remarks = $antecedants_data->remarks->value;
	} else {
		$remarks = '';
	}

	if(isset($antecedants_data->verified_on)){
		$verified_on = $antecedants_data->verified_on->value;
	} else {
		$verified_on = '';
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
	<th scope="row">Cource Name <span class="required-f">*</span></th>
	<td>
		{{ $edu_course_name }}
		<input type="hidden" name="candidate_data[edu_course_name]" id="edu_course_name" class="form-control" value="{{ $edu_course_name }}" />
	</td>
	<td>
		<input type="hidden" name="antecedants_data[cource_name][name]" value="Cource Name" />
		<input type="text" name="antecedants_data[cource_name][value]" id="cource_name" class="form-control" value="{{ $cource_name }}" required placeholder="Cource Name" />
		<span id="cource_name_err" class="frm_error"></span>
	</td>
	<td>
		<div class="form-group">
	        <ul class="list-unstyled mb-0">
	          	<li class="d-inline-block mr-2">
	            	<fieldset>
						<div class="vs-checkbox-con vs-checkbox-primary">
							<input type="checkbox" 
							{{ $cource_name_match_status == 'MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[cource_name][match_status]" value="MATCHED">
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
							{{ $cource_name_match_status == 'PARTIAL_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[cource_name][match_status]" value="PARTIAL_MATCHED">
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
							{{ $cource_name_match_status == 'MIS_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[cource_name][match_status]" value="MIS_MATCHED">
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
	<th scope="row">Year of Passing <span class="required-f">*</span></th>
	<td>
		{{ $cedu_passing_year }}
		<input type="hidden" name="candidate_data[edu_passing_year]" id="edu_passing_year" class="form-control" value="{{ $cedu_passing_year }}" />
	</td>
	<td>
		<input type="hidden" name="antecedants_data[edu_passing_year][name]" value="Year of Passing" />
		<input type="text" name="antecedants_data[edu_passing_year][value]" id="edu_passing_year" class="form-control" value="{{ $edu_passing_year }}" required placeholder="Year of Passing" />
		<span id="edu_passing_year_err" class="frm_error"></span>
	</td>
	<td>
		<div class="form-group">
	        <ul class="list-unstyled mb-0">
	          	<li class="d-inline-block mr-2">
	            	<fieldset>
						<div class="vs-checkbox-con vs-checkbox-primary">
							<input type="checkbox" 
							{{ $edu_passing_year_match_status == 'MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[edu_passing_year][match_status]" value="MATCHED">
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
							{{ $edu_passing_year_match_status == 'PARTIAL_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[edu_passing_year][match_status]" value="PARTIAL_MATCHED">
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
							{{ $edu_passing_year_match_status == 'MIS_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[edu_passing_year][match_status]" value="MIS_MATCHED">
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
	<th scope="row">Enrolment/Roll Number <span class="required-f">*</span></th>
	<td>
		{{ $cedu_roll_no }}
		<input type="hidden" name="candidate_data[edu_roll_no]" id="edu_roll_no" class="form-control" value="{{ $cedu_roll_no }}" />
	</td>
	<td>
		<input type="hidden" name="antecedants_data[edu_roll_no][name]" value="Enrolment/Roll Number" />
		<input type="text" name="antecedants_data[edu_roll_no][value]" id="edu_roll_no" class="form-control" value="{{ $edu_roll_no }}" required placeholder="Enrolment/Roll Number" />
		<span id="edu_roll_no_err" class="frm_error"></span>
	</td>
	<td>
		<div class="form-group">
	        <ul class="list-unstyled mb-0">
	          	<li class="d-inline-block mr-2">
	            	<fieldset>
						<div class="vs-checkbox-con vs-checkbox-primary">
							<input type="checkbox" 
							{{ $edu_roll_no_match_status == 'MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[edu_roll_no][match_status]" value="MATCHED">
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
							{{ $edu_roll_no_match_status == 'PARTIAL_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[edu_roll_no][match_status]" value="PARTIAL_MATCHED">
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
							{{ $edu_roll_no_match_status == 'MIS_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[edu_roll_no][match_status]" value="MIS_MATCHED">
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
	<th scope="row">University/College/School Name <span class="required-f">*</span></th>
	<td>
		{{ $cedu_school_name }}
		<input type="hidden" name="candidate_data[edu_school_name]" id="edu_school_name" class="form-control" value="{{ $cedu_school_name }}" />
	</td>
	<td>
		<input type="hidden" name="antecedants_data[edu_school_name][name]" value="University/College/School Name" />
		<input type="text" name="antecedants_data[edu_school_name][value]" id="edu_school_name" class="form-control" value="{{ $edu_school_name }}" required placeholder="University/College/School Name" />
		<span id="edu_school_name_err" class="frm_error"></span>
	</td>
	<td>
		<div class="form-group">
	        <ul class="list-unstyled mb-0">
	          	<li class="d-inline-block mr-2">
	            	<fieldset>
						<div class="vs-checkbox-con vs-checkbox-primary">
							<input type="checkbox" 
							{{ $edu_school_name_match_status == 'MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[edu_school_name][match_status]" value="MATCHED">
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
							{{ $edu_school_name_match_status == 'PARTIAL_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[edu_school_name][match_status]" value="PARTIAL_MATCHED">
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
							{{ $edu_school_name_match_status == 'MIS_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[edu_school_name][match_status]" value="MIS_MATCHED">
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
	<th scope="row">Any Additional Remarks <span class="required-f">*</span></th>
	<td></td>
	<td>
		<input type="hidden" name="antecedants_data[remarks][name]" value="Any Additional Remarks" />
		<textarea name="antecedants_data[remarks][value]" id="remarks" class="form-control">{{ $remarks }}</textarea>
		<span id="remarks_err" class="frm_error"></span>
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

@if($taskhistorydocs)
	@foreach($taskhistorydocs as $key => $files)
		<tr>
			<th scope="row">Attachnment {{ $key + 1 }}</th>
			<td></td>
			<td>
				<input type="hidden" name="document_name[]" value="{{ $files->document_name }}">
				<input type="hidden" name="document_url[]" value="{{ $files->document_url }}">
				<a href="{{ $files->document_url }}" target="_blank">{{ $files->document_name }}</a>
			</td>
			<td></td>
			<td></td>
			<td>
				<a href="{{ url('orders/delete-doc/'.$files->id.'/'.$orders->id.'/'.$tasks->id) }}">Delete</a>
			</td>
		</tr>
	@endforeach
@endif

<tr>
	<th scope="row">Attachnment </th>
	<td></td>
	<td>
		<input type="file" name="attachment[]" class="form-control" multiple />
		<span id="attachment_err" class="frm_error"></span>
	</td>
	<td></td>
	<td></td>
	<td></td>
</tr>