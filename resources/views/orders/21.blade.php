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

	if(isset($antecedants_data->aadhar_number->value)){
		$aadhar_number = $antecedants_data->aadhar_number->value;
	} else {
		$aadhar_number = '';
	}

	if(isset($antecedants_data->aadhar_number->match_status)){
		$aadhar_match_status = $antecedants_data->aadhar_number->match_status;
	} else {
		$aadhar_match_status = 'MATCHED';
	}

	if(isset($antecedants_data->age_band->value)){
		$age_band = $antecedants_data->age_band->value;
	} else {
		$age_band = '';
	}

	if(isset($antecedants_data->age_band->match_status)){
		$age_match_status = $antecedants_data->age_band->match_status;
	} else {
		$age_match_status = 'MATCHED';
	}

	if(isset($antecedants_data->gender->value)){
		$gender = $antecedants_data->gender->value;
	} else {
		$gender = '';
	}

	if(isset($antecedants_data->gender->match_status)){
		$gender_match_status = $antecedants_data->gender->match_status;
	} else {
		$gender_match_status = 'MATCHED';
	}

	if(isset($antecedants_data->state->value)){
		$state = $antecedants_data->state->value;
	} else {
		$state = '';
	}

	if(isset($antecedants_data->state->match_status)){
		$state_match_status = $antecedants_data->state->match_status;
	} else {
		$state_match_status = 'MATCHED';
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
	<th scope="row">Aadhar Number <span class="required-f">*</span></th>
	<td>{{ isset($userdocs->doc_number) ? $userdocs->doc_number : 'N/A'  }}</td>
	<td>
		<input type="hidden" name="antecedants_data[aadhar_number][name]" value="Aadhar Number" />
		<input type="text" name="antecedants_data[aadhar_number][value]" id="aadhar_number" class="form-control" value="{{ $aadhar_number }}" required />
		<span id="aadhar_number_err" class="frm_error"></span>
	</td>
	<td>
		<div class="form-group">
	        <ul class="list-unstyled mb-0">
	          	<li class="d-inline-block mr-2">
	            	<fieldset>
						<div class="vs-checkbox-con vs-checkbox-primary">
							<input type="checkbox" 
							{{ $aadhar_match_status == 'MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[aadhar_number][match_status]" value="MATCHED">
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
							{{ $aadhar_match_status == 'PARTIAL_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[aadhar_number][match_status]" value="PARTIAL_MATCHED">
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
							{{ $aadhar_match_status == 'MIS_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[aadhar_number][match_status]" value="MIS_MATCHED">
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
  	<th scope="row">Age Band <span class="required-f">*</span></th>
  	<td></td>
  	<td>
  		<input type="hidden" name="antecedants_data[age_band][name]" value="Age Band" />
	    <select name="antecedants_data[age_band][value]" id="age_band" class="form-control">
	    	<option>Select Age Band</option>
	    	<option {{ $age_band  ==  '10-20' ? 'selected' : '' }} value="10-20">10-20</option>
	    	<option {{ $age_band  ==  '20-30' ? 'selected' : '' }} value="20-30">20-30</option>
	    	<option {{ $age_band  ==  '30-40' ? 'selected' : '' }} value="30-40">30-40</option>
	    	<option {{ $age_band  ==  '40-50' ? 'selected' : '' }} value="40-50">40-50</option>
	    	<option {{ $age_band  ==  '50-60' ? 'selected' : '' }} value="50-60">50-60</option>
	    	<option {{ $age_band  ==  '60-70' ? 'selected' : '' }} value="60-70">60-70</option>
	    	<option {{ $age_band  ==  '70-80' ? 'selected' : '' }} value="70-80">70-80</option>
	    	<option {{ $age_band  ==  '80-90' ? 'selected' : '' }} value="80-90">80-90</option>
	    	<option {{ $age_band  ==  '90-100' ? 'selected' : '' }} value="90-100">90-100</option>
	    </select>
	    <span id="age_band_err" class="frm_error"></span>
  	</td>
	<td>
		<div class="form-group">
	        <ul class="list-unstyled mb-0">
	          	<li class="d-inline-block mr-2">
	            	<fieldset>
						<div class="vs-checkbox-con vs-checkbox-primary">
							<input type="checkbox" 
							{{ $age_match_status == 'MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[age_band][match_status]" value="MATCHED">
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
							{{ $age_match_status == 'PARTIAL_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[age_band][match_status]" value="PARTIAL_MATCHED">
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
							{{ $age_match_status == 'MIS_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[age_band][match_status]" value="MIS_MATCHED">
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
  	<th scope="row">Gender <span class="required-f">*</span></th>
  	<td></td>
  	<td>
  		<input type="hidden" name="antecedants_data[gender][name]" value="Gender" />
	    <select name="antecedants_data[gender][value]" id="gender" class="form-control">
	    	<option>Select Gender</option>
	    	<option {{ $gender  ==  'Male' ? 'selected' : '' }} value="Male">Male</option>
	    	<option {{ $gender  ==  'Female' ? 'selected' : '' }} value="Female">Female</option>
	    </select>
	    <span id="gender_err" class="frm_error"></span>
  	</td>
	<td>
		<div class="form-group">
	        <ul class="list-unstyled mb-0">
	          	<li class="d-inline-block mr-2">
	            	<fieldset>
						<div class="vs-checkbox-con vs-checkbox-primary">
							<input type="checkbox" 
							{{ $gender_match_status == 'MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[gender][match_status]" value="MATCHED">
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
							{{ $gender_match_status == 'PARTIAL_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[gender][match_status]" value="PARTIAL_MATCHED">
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
							{{ $gender_match_status == 'MIS_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[gender][match_status]" value="MIS_MATCHED">
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
  	<th scope="row">State <span class="required-f">*</span></th>
  	<td></td>
  	<td>
  		<input type="hidden" name="antecedants_data[state][name]" value="State" />
	    <input type="text" name="antecedants_data[state][value]" id="state" class="form-control" value="{{ $state }}" required />
	    <span id="state_err" class="frm_error"></span>
  	</td>
	<td>
		<div class="form-group">
	        <ul class="list-unstyled mb-0">
	          	<li class="d-inline-block mr-2">
	            	<fieldset>
						<div class="vs-checkbox-con vs-checkbox-primary">
							<input type="checkbox" 
							{{ $state_match_status == 'MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[state][match_status]" value="MATCHED">
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
							{{ $state_match_status == 'PARTIAL_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[state][match_status]" value="PARTIAL_MATCHED">
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
							{{ $state_match_status == 'MIS_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[state][match_status]" value="MIS_MATCHED">
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
  	@if($severity_messages_id != '')
		<label for="" id="severity_messages_id_old">
			<input type="radio" checked="" name="severity_msg">
			 {{ $severity_messages_id }} -- {{ $conclusion }}
		</label>
	@endif
  </td>
  <td>
    <select name="antecedants_data[severity]" id="severity" class="form-control">
    	<option>Select Option</option>
    	<option {{ $severity == 'GREEN' ? 'selected' : '' }} value="GREEN">GREEN</option>
    	<option {{ $severity == 'YELLOW' ? 'selected' : '' }} value="YELLOW">YELLOW</option>
    	<option {{ $severity == 'RED' ? 'selected' : '' }} value="RED">RED</option>
    	<!-- <option {{ $severity == 'INCONCLUSIVE' ? 'selected' : '' }} value="INCONCLUSIVE">INCONCLUSIVE</option> -->
    </select>
    <span id="severity_err" class="frm_error"></span>
  </td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
  <th scope="row">Conclusion <span class="required-f">*</span></th>
  <td>
  	<input type="hidden" name="antecedants_data[severity_messages_id]" id="severity_messages_id" value="{{ $severity_messages_id }}">
  </td>
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