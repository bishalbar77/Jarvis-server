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

	if(isset($antecedants_data->verification_code->match_status)){
		$code_match_status = $antecedants_data->verification_code->match_status;
	} else {
		$code_match_status = 'MATCHED';
	}

	if(isset($antecedants_data->duration_of_stay->value)){
		$duration_of_stay = $antecedants_data->duration_of_stay->value;
	} else {
		$duration_of_stay = '';
	}

	if(isset($antecedants_data->verification_code->value)){
		$verification_code = $antecedants_data->verification_code->value;
	} else {
		$verification_code = '';
	}

	if(isset($antecedants_data->verification_code->otp)){
		$otp = $antecedants_data->verification_code->otp;
	} else {
		$otp = '';
	}

	if(isset($antecedants_data->duration_of_stay->match_status)){
		$duration_match_status = $antecedants_data->duration_of_stay->match_status;
	} else {
		$duration_match_status = 'MATCHED';
	}

	if(isset($antecedants_data->accommodation_status->value)){
		$accommodation_status = $antecedants_data->accommodation_status->value;
	} else {
		$accommodation_status = '';
	}

	if(isset($antecedants_data->above_details->value)){
		$above_details = $antecedants_data->above_details->value;
	} else {
		$above_details = '';
	}

	if(isset($antecedants_data->relationship->value)){
		$relationship = $antecedants_data->relationship->value;
	} else {
		$relationship = '';
	}

	if(isset($antecedants_data->contact_number->value)){
		$contact_number = $antecedants_data->contact_number->value;
	} else {
		$contact_number = '';
	}

	if(isset($antecedants_data->remarks->value)){
		$remarks = $antecedants_data->remarks->value;
	} else {
		$remarks = '';
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
							{{ $address_match_status == 'UNABLE_TO_VERIFY' ? 'checked' : '' }} 
							name="antecedants_data[address][match_status]" value="UNABLE_TO_VERIFY">
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
	<th scope="row">Postal Verification Code <span class="required-f">*</span></th>
	<td>{{ $otp }}</td>
	<td>
		<input type="hidden" name="antecedants_data[verification_code][name]" value="Postal Verification Code" />
		<input type="hidden" name="antecedants_data[verification_code][otp]" value="{{ $otp }}" />
		<input type="text" name="antecedants_data[verification_code][value]" id="verification_code" class="form-control" value="{{ $verification_code }}" placeholder="Enter Postal Verification Code" required />
		<span id="verification_code_err" class="frm_error"></span>
	</td>
	<td>
		<div class="form-group">
	        <ul class="list-unstyled mb-0">
	          	<li class="d-inline-block mr-2">
	            	<fieldset>
						<div class="vs-checkbox-con vs-checkbox-primary">
							<input type="checkbox" 
							{{ $code_match_status == 'MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[verification_code][match_status]" value="MATCHED">
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
							{{ $code_match_status == 'UNABLE_TO_VERIFY' ? 'checked' : '' }} 
							name="antecedants_data[verification_code][match_status]" value="UNABLE_TO_VERIFY">
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
							{{ $code_match_status == 'NO_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[verification_code][match_status]" value="NO_MATCHED">
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
  	<th scope="row">Accommodation Status <span class="required-f">*</span></th>
	<td></td>
	<td>
		<input type="hidden" name="antecedants_data[accommodation_status][name]" value="Accommodation Status" />
		<input type="text" name="antecedants_data[accommodation_status][value]" id="accommodation_status" class="form-control" value="{{ $accommodation_status }}" required />
		<span id="accommodation_status_err" class="frm_error"></span>
	</td>

	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
	<th scope="row">Duration of Stay <span class="required-f">*</span></th>
	<td></td>
	<td>
		<input type="hidden" name="antecedants_data[duration_of_stay][name]" value="Duration of Stay" />
		<input type="text" name="antecedants_data[duration_of_stay][value]" id="duration_of_stay" class="form-control" value="{{ $duration_of_stay }}" required />
		<span id="duration_of_stay_err" class="frm_error"></span>
	</td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
  	<th scope="row">Above details Verified by <span class="required-f">*</span></th>
	<td></td>
	<td>
		<input type="hidden" name="antecedants_data[above_details][name]" value="Above details Verified by" />
		<input type="text" name="antecedants_data[above_details][value]" id="above_details" class="form-control" value="{{ $above_details }}" required />
		<span id="above_details_err" class="frm_error"></span>
	</td>

	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
  	<th scope="row">Relationship With Candidate <span class="required-f">*</span></th>
	<td></td>
	<td>
		<input type="hidden" name="antecedants_data[relationship][name]" value="Relationship With Candidate" />
		<input type="text" name="antecedants_data[relationship][value]" id="relationship" class="form-control" value="{{ $relationship }}" required />
		<span id="relationship_err" class="frm_error"></span>
	</td>

	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
  	<th scope="row">Contact Number of Verifier <span class="required-f">*</span></th>
	<td></td>
	<td>
		<input type="hidden" name="antecedants_data[contact_number][name]" value="Contact Number of Verifier" />
		<input type="text" name="antecedants_data[contact_number][value]" id="contact_number" class="form-control" value="{{ $contact_number }}" required />
		<span id="contact_number_err" class="frm_error"></span>
	</td>

	<td></td>
	<td></td>
	<td></td>
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