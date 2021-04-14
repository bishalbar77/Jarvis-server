@php
	$lasthistory = json_decode($lasthistories);
	$antecedants_data = isset($lasthistory->antecedants_data) ? json_decode($lasthistory->antecedants_data) : '';
	
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

	if(isset($antecedants_data->internet_searches->value)){
		$internet_searches = $antecedants_data->internet_searches->value;
	} else {
		$internet_searches = '';
	}

	if(isset($antecedants_data->media_searches->value)){
		$media_searches = $antecedants_data->media_searches->value;
	} else {
		$media_searches = '';
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
	<th scope="row">Internet Searches <span class="required-f">*</span></th>
	<td></td>
	<td>
		<input type="hidden" name="antecedants_data[internet_searches][name]" value="Internet Searches" />
		<select name="antecedants_data[internet_searches][value]" id="internet_searches" class="form-control">
	    	<option>Select Internet Searches</option>
	    	<option {{ $internet_searches == 'Match Found' ? 'selected' : '' }} value="Match Found">Match Found</option>
	    	<option {{ $internet_searches == 'No Match Found' ? 'selected' : '' }} value="No Match Found">No Match Found</option>
	    	<option {{ $internet_searches == 'Partial Match Found' ? 'selected' : '' }} value="Partial Match Found">Partial Match Found</option>
	    </select>
		<span id="internet_searches_err" class="frm_error"></span>
	</td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
	<th scope="row">Media Searches <span class="required-f">*</span></th>
	<td></td>
	<td>
		<input type="hidden" name="antecedants_data[media_searches][name]" value="Media Searches" />
		<select name="antecedants_data[media_searches][value]" id="media_searches" class="form-control">
	    	<option>Select Internet Searches</option>
	    	<option {{ $media_searches == 'Match Found' ? 'selected' : '' }} value="Match Found">Match Found</option>
	    	<option {{ $media_searches == 'No Match Found' ? 'selected' : '' }} value="No Match Found">No Match Found</option>
	    	<option {{ $media_searches == 'Partial Match Found' ? 'selected' : '' }} value="Partial Match Found">Partial Match Found</option>
	    </select>
		<span id="internet_searches_err" class="frm_error"></span>
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