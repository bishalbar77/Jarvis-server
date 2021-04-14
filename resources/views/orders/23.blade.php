@php
	$lasthistory = json_decode($lasthistories);
	$antecedants_data = json_decode($lasthistory->antecedants_data);
	
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

	if(isset($antecedants_data->current_status->value)){
		$current_status = $antecedants_data->current_status->value;
	} else {
		$current_status = '';
	}

	if(isset($antecedants_data->current_status->match_status)){
		$current_match_status = $antecedants_data->current_status->match_status;
	} else {
		$current_match_status = 'MATCHED';
	}

	if(isset($antecedants_data->dl_number->value)){
		$dl_number = $antecedants_data->dl_number->value;
	} else {
		$dl_number = '';
	}

	if(isset($antecedants_data->dl_number->match_status)){
		$pan_match_status = $antecedants_data->dl_number->match_status;
	} else {
		$pan_match_status = 'MATCHED';
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
	<th scope="row">Driving License Number <span class="required-f">*</span></th>
	<td>{{ isset($userdocs->doc_number) ? $userdocs->doc_number : 'N/A'  }}</td>
	<td>
		<input type="hidden" name="antecedants_data[dl_number][name]" value="Driving License Number" />
		<input type="text" name="antecedants_data[dl_number][value]" id="dl_number" class="form-control" value="{{ $dl_number }}" required />
		<span id="dl_number_err" class="frm_error"></span>
	</td>
	<td>
		<div class="form-group">
	        <ul class="list-unstyled mb-0">
	          	<li class="d-inline-block mr-2">
	            	<fieldset>
						<div class="vs-checkbox-con vs-checkbox-primary">
							<input type="checkbox" 
							{{ $pan_match_status == 'MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[dl_number][match_status]" value="MATCHED">
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
							name="antecedants_data[dl_number][match_status]" value="PARTIAL_MATCHED">
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
							name="antecedants_data[dl_number][match_status]" value="MIS_MATCHED">
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
	<th scope="row">Current Status <span class="required-f">*</span></th>
	<td></td>
	<td>
		<input type="hidden" name="antecedants_data[current_status][name]" value="Current Status" />
		<input type="text" name="antecedants_data[current_status][value]" id="current_status" class="form-control" value="{{ $current_status }}" required />
		<span id="current_status_err" class="frm_error"></span>
	</td>
	<td>
		<div class="form-group">
	        <ul class="list-unstyled mb-0">
	          	<li class="d-inline-block mr-2">
	            	<fieldset>
						<div class="vs-checkbox-con vs-checkbox-primary">
							<input type="checkbox" 
							{{ $current_match_status == 'MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[current_status][match_status]" value="MATCHED">
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
							{{ $current_match_status == 'PARTIAL_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[current_status][match_status]" value="PARTIAL_MATCHED">
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
							{{ $current_match_status == 'MIS_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[current_status][match_status]" value="MIS_MATCHED">
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
	<th scope="row">Candidate Name <span class="required-f">*</span></th>
	<td>{{ $employees->first_name }} {{ $employees->middle_name }} {{ $employees->last_name }}</td>
	<td>
		<input type="hidden" name="antecedants_data[candidate_name][name]" value="Candidate Number" />
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
  	<th scope="row">Severity <span class="required-f">*</span></th>
  	<td>
  		<span id="severity_msg"></span>
  	</td>
  	<td>
	    <select name="antecedants_data[severity]" id="severity" class="form-control">
	    	<option>Select Option</option>
	    	<option {{ $severity == 'Green' ? 'selected' : '' }} value="Green">Green</option>
	    	<option {{ $severity == 'Discrepant' ? 'selected' : '' }} value="Discrepant">Discrepant</option>
	    	<option {{ $severity == 'Inconclusive' ? 'selected' : '' }} value="Inconclusive">Inconclusive</option>
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