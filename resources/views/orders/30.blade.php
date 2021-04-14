@php
	$lasthistory = json_decode($lasthistories);

	$candidate_data = json_decode($lasthistory->candidate_data);
	
	$antecedants_data = json_decode($lasthistory->antecedants_data);

	if(isset($candidate_data->current_temprature)){
		$ccurrent_temprature = $candidate_data->current_temprature;
	} else {
		$ccurrent_temprature = '';
	}

	if(isset($candidate_data->had_symptoms)){
		$chad_symptoms = $candidate_data->had_symptoms;
	} else {
		$chad_symptoms = '';
	}

	if(isset($candidate_data->tested_positive)){
		$ctested_positive = $candidate_data->tested_positive;
	} else {
		$ctested_positive = '';
	}

	if(isset($candidate_data->proximate_contact)){
		$cproximate_contact = $candidate_data->proximate_contact;
	} else {
		$cproximate_contact = '';
	}

	if(isset($candidate_data->confirm_answer)){
		$cconfirm_answer = $candidate_data->confirm_answer;
	} else {
		$cconfirm_answer = '';
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

	if(isset($antecedants_data->current_temprature->value)){
		$current_temprature = $antecedants_data->current_temprature->value;
	} else {
		$current_temprature = $ccurrent_temprature;
	}

	if(isset($antecedants_data->had_symptoms)){
		$had_symptoms = $antecedants_data->had_symptoms;
	} else {
		$had_symptoms = $chad_symptoms;
	}

	if(isset($antecedants_data->tested_positive)){
		$tested_positive = $antecedants_data->tested_positive;
	} else {
		$tested_positive = $ctested_positive;
	}

	if(isset($antecedants_data->proximate_contact)){
		$proximate_contact = $antecedants_data->proximate_contact;
	} else {
		$proximate_contact = $cproximate_contact;
	}

	if(isset($antecedants_data->confirm_answer)){
		$confirm_answer = $antecedants_data->confirm_answer;
	} else {
		$confirm_answer = $cconfirm_answer;
	}

	if(isset($antecedants_data->conclusion)){
		$conclusion = $antecedants_data->conclusion;
	} else {
		$conclusion = '';
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
  	<th scope="row">Current Temprature <span class="required-f">*</span></th>
	<td></td>
	<td>
		<input type="hidden" name="antecedants_data[current_temprature][name]" value="Current Temprature" />
		<input type="text" name="antecedants_data[current_temprature][value]" id="current_temprature" class="form-control" value="{{ $current_temprature }}" required readonly />
		<span id="current_temprature_err" class="frm_error"></span>
	</td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
  	<th scope="row" style="max-width: 300px;">Have you been diagnosed with or had symptoms of COVID-19 in the past 14 days? COVID-19 symptoms include: cough, difficulty breathing or shortness of breath, fever or chills, new loss of taste or smell, muscle or body aches, fatigue, headache, sore throat, congestion or runny nose, nausea, vomiting, or diarrhea. <span class="required-f">*</span></th>
  	<td>
  		<span id="had_symptoms"></span>
  	</td>
  	<td>
	    <select name="antecedants_data[had_symptoms]" id="had_symptoms" class="form-control" readonly >
	    	<option value="">Select Option</option>
	    	<option {{ $had_symptoms == 'YES' ? 'selected' : '' }} value="YES">YES</option>
	    	<option {{ $had_symptoms == 'NO' ? 'selected' : '' }} value="NO">NO</option>
	    </select>
	    <span id="had_symptoms_err" class="frm_error"></span>
  	</td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
  	<th scope="row">Have you tested positive for COVID-19 within the past 14 days?<span class="required-f">*</span></th>
  	<td>
  		<span id="tested_positive_msg"></span>
  	</td>
  	<td>
	    <select name="antecedants_data[tested_positive]" id="tested_positive" class="form-control" readonly >
	    	<option value="">Select Option</option>
	    	<option {{ $tested_positive == 'YES' ? 'selected' : '' }} value="YES">YES</option>
	    	<option {{ $tested_positive == 'NO' ? 'selected' : '' }} value="NO">NO</option>
	    </select>
	    <span id="tested_positive_err" class="frm_error"></span>
  	</td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
  	<th scope="row">Have you tested positive for COVID-19 within the past 14 days?<span class="required-f">*</span></th>
  	<td>
  		<span id="proximate_contact_msg"></span>
  	</td>
  	<td>
	    <select name="antecedants_data[proximate_contact]" id="proximate_contact" class="form-control" readonly >
	    	<option value="">Select Option</option>
	    	<option {{ $proximate_contact == 'YES' ? 'selected' : '' }} value="YES">YES</option>
	    	<option {{ $proximate_contact == 'NO' ? 'selected' : '' }} value="NO">NO</option>
	    </select>
	    <span id="proximate_contact_err" class="frm_error"></span>
  	</td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
  	<th scope="row">I confirm the answer to all the above questions is “YES/NO” for me on this date. <span class="required-f">*</span></th>
	<td></td>
	<td>
		<input type="checkbox" name="antecedants_data[confirm_answer]" id="confirm_answer" class="form-control" value="YES" {{ $confirm_answer == 'YES' ? 'checked' : '' }} />
		<span id="current_temprature_err" class="frm_error"></span>
	</td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
  	<th scope="row">Severity <span class="required-f">*</span></th>
  	<td>
  		<span id="severity_msg"></span>
  	</td>
  	<td>
	    <select name="antecedants_data[severity]" id="severity" class="form-control">
	    	<option value="">Select Option</option>
	    	<option {{ $severity == 'GREEN' ? 'selected' : '' }} value="GREEN">GREEN</option>
	    	<option {{ $severity == 'YELLOW' ? 'selected' : '' }} value="YELLOW">YELLOW</option>
	    	<option {{ $severity == 'RED' ? 'selected' : '' }} value="RED">RED</option>
	    	<option {{ $severity == 'INCONCLUSIVE' ? 'selected' : '' }} value="INCONCLUSIVE">INCONCLUSIVE</option>
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