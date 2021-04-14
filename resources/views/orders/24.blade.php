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

	if(isset($antecedants_data->all_civil_courts->value)){
		$all_civil_courts = $antecedants_data->all_civil_courts->value;
	} else {
		$all_civil_courts = '';
	}

	if(isset($antecedants_data->session_courts->value)){
		$session_courts = $antecedants_data->session_courts->value;
	} else {
		$session_courts = '';
	}

	if(isset($antecedants_data->high_court->value)){
		$high_court = $antecedants_data->high_court->value;
	} else {
		$high_court = '';
	}

	if(isset($antecedants_data->supreme_court->value)){
		$supreme_court = $antecedants_data->supreme_court->value;
	} else {
		$supreme_court = '';
	}

	if(isset($antecedants_data->address->value)){
		$address = $antecedants_data->address->value;
	} else {
		$address = '';
	}

	if(isset($antecedants_data->address->match_status)){
		$address_match_status = $antecedants_data->address->match_status;
	} else {
		$address_match_status = 'MATCHED';
	}

	if(isset($antecedants_data->period_of_stay->value)){
		$period_of_stay = $antecedants_data->period_of_stay->value;
	} else {
		$period_of_stay = '';
	}

	if(isset($antecedants_data->verifiers_comments->value)){
		$verifiers_comments = $antecedants_data->verifiers_comments->value;
	} else {
		$verifiers_comments = '';
	}

	if(isset($antecedants_data->severity_messages_id)){
		$severity_messages_id = $antecedants_data->severity_messages_id;
	} else {
		$severity_messages_id = '';
	}

	if(isset($antecedants_data->report_data)){
		$report_data = $antecedants_data->report_data;
	} else {
		$report_data = '';
	}

		//echo '<pre>';
		//print_r($report_data);
		//exit;

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
	<th scope="row">All District & Civil Court <span class="required-f">*</span></th>
	<td></td>
	<td>
		<input type="hidden" name="antecedants_data[all_civil_courts][name]" value="All District & Civil Court" />
		<select name="antecedants_data[all_civil_courts][value]" id="all_civil_courts" class="form-control">
	    	<option {{ $all_civil_courts == 'Match Found' ? 'selected' : '' }} value="Match Found">Match Found</option>
	    	<option {{ $all_civil_courts == 'No Match Found' ? 'selected' : '' }} value="No Match Found">No Match Found</option>
	    </select>
		<span id="all_civil_courts_err" class="frm_error"></span>
	</td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
	<th scope="row">All Magistrate and Session Court <span class="required-f">*</span></th>
	<td></td>
	<td>
		<input type="hidden" name="antecedants_data[session_courts][name]" value="All Magistrate and Session Courts" />
		<select name="antecedants_data[session_courts][value]" id="session_courts" class="form-control">
	    	<option {{ $session_courts == 'Match Found' ? 'selected' : '' }} value="Match Found">Match Found</option>
	    	<option {{ $session_courts == 'No Match Found' ? 'selected' : '' }} value="No Match Found">No Match Found</option>
	    </select>
		<span id="session_courts_err" class="frm_error"></span>
	</td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
	<th scope="row">High Court <span class="required-f">*</span></th>
	<td></td>
	<td>
		<input type="hidden" name="antecedants_data[high_court][name]" value="High Court" />
		<select name="antecedants_data[high_court][value]" id="high_court" class="form-control">
	    	<option {{ $high_court == 'Match Found' ? 'selected' : '' }} value="Match Found">Match Found</option>
	    	<option {{ $high_court == 'No Match Found' ? 'selected' : '' }} value="No Match Found">No Match Found</option>
	    </select>
		<span id="high_court_err" class="frm_error"></span>
	</td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
	<th scope="row">Supreme Court <span class="required-f">*</span></th>
	<td></td>
	<td>
		<input type="hidden" name="antecedants_data[supreme_court][name]" value="Supreme Court" />
		<select name="antecedants_data[supreme_court][value]" id="supreme_court" class="form-control">
	    	<option {{ $supreme_court == 'Match Found' ? 'selected' : '' }} value="Match Found">Match Found</option>
	    	<option {{ $supreme_court == 'No Match Found' ? 'selected' : '' }} value="No Match Found">No Match Found</option>
	    </select>
		<span id="supreme_court_err" class="frm_error"></span>
	</td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
	<th scope="row">Address <span class="required-f">*</span></th>
	<td>
		@if(isset($addresses))
			{{ $addresses->street_addr1 }} 
			{{ $addresses->street_addr2 }} 
			{{ $addresses->village }}
			{{ $addresses->post_office }}
			{{ $addresses->police_station }}
			{{ $addresses->district }}
			{{ $addresses->near_by }}
			{{ $addresses->city }}
			{{ $addresses->state }}
			{{ $addresses->pincode }}
		@endif
	</td>
	<td>
		<input type="hidden" name="antecedants_data[address][name]" value="Address" />
		<textarea name="antecedants_data[address][value]" id="address" class="form-control" required />{{ $address }}</textarea>
		<span id="address_err" class="frm_error"></span>
	</td>
	<td>
		<div class="form-group">
	        <ul class="list-unstyled mb-0">
	          	<li class="d-inline-block mr-2">
	            	<fieldset>
						<div class="vs-checkbox-con vs-checkbox-primary">
							<input type="checkbox" 
							{{ $address_match_status == 'MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[address][match_status]" value="MATCHED">
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
							{{ $address_match_status == 'PARTIAL_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[address][match_status]" value="PARTIAL_MATCHED">
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
							{{ $address_match_status == 'NO_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[address][match_status]" value="NO_MATCHED">
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
	<th scope="row">Period of Stay <span class="required-f">*</span></th>
	<td></td>
	<td>
		<input type="hidden" name="antecedants_data[period_of_stay][name]" value="Period of Stay" />
		<input type="text" name="antecedants_data[period_of_stay][value]" id="period_of_stay" class="form-control" value="{{ $period_of_stay }}" required />
		<span id="period_of_stay_err" class="frm_error"></span>
	</td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
	<th scope="row">Verifier's Comments <span class="required-f">*</span></th>
	<td></td>
	<td>
		<input type="hidden" name="antecedants_data[verifiers_comments][name]" value="Verifier's Comments" />
		<input type="text" name="antecedants_data[verifiers_comments][value]" id="address" class="form-control" value="{{ $verifiers_comments }}" required />
		<span id="verifiers_comments_err" class="frm_error"></span>
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
		@if(isset($report_data) && !empty($report_data))
			@foreach($report_data->reports as $rept)
				<input type="hidden" name="antecedants_data[report_data][reports][]" id="report_data" value="{{ $rept ?? '' }}">
			@endforeach
			<input type="hidden" name="antecedants_data[report_data][report_details][case_id]" id="case_id" value="{{ $report_data->report_details->case_id ?? '' }}">
			<input type="hidden" name="antecedants_data[report_data][report_details][name_found]" id="name_found" value="{{ $report_data->report_details->name_found ?? '' }}">
			<input type="hidden" name="antecedants_data[report_data][report_details][address_found]" id="address_found" value="{{ $report_data->report_details->address_found ?? '' }}">
			<input type="hidden" name="antecedants_data[report_data][report_details][reg_no]" id="reg_no" value="{{ $report_data->report_details->reg_no ?? '' }}">
			<input type="hidden" name="antecedants_data[report_data][report_details][court_name]" id="court_name" value="{{ $report_data->report_details->court_name ?? '' }}">
			<input type="hidden" name="antecedants_data[report_data][report_details][stage_of_case]" id="stage_of_case" value="{{ $report_data->report_details->stage_of_case ?? '' }}">
			<input type="hidden" name="antecedants_data[report_data][report_details][fir_no_year]" id="fir_no_year" value="{{ $report_data->report_details->fir_no_year ?? '' }}">
			<input type="hidden" name="antecedants_data[report_data][report_details][police_station]" id="police_station" value="{{ $report_data->report_details->police_station ?? '' }}">
			@foreach($report_data->report_details->act_name as $keyy => $act_name)
				@if(!empty($act_name))
				<input type="hidden" name="antecedants_data[report_data][report_details][act_name][]" value="{{ $act_name  ?? ''}}">
				<input type="hidden" name="antecedants_data[report_data][report_details][section_details][]" value="{{ $report_data->report_details->section_details[$keyy] ?? '' }}">
				@endif
			@endforeach
		@endif
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