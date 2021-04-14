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

	if(isset($antecedants_data->name_of_employer->value)){
		$name_of_employer = $antecedants_data->name_of_employer->value;
	} else {
		$name_of_employer = '';
	}

	if(isset($antecedants_data->name_of_employer->match_status)){
		$name_of_employer_match_status = $antecedants_data->name_of_employer->match_status;
	} else {
		$name_of_employer_match_status = '';
	}	

	if(isset($candidate_data->employer_name)){
		$cemployer_name = $candidate_data->employer_name;
	} else {
		$cemployer_name = '';
	}

	if(isset($antecedants_data->period_of_employement->value)){
		$period_of_employement = $antecedants_data->period_of_employement->value;
	} else {
		$period_of_employement = '';
	}

	if(isset($antecedants_data->period_of_employement->match_status)){
		$period_of_employement_match_status = $antecedants_data->period_of_employement->match_status;
	} else {
		$period_of_employement_match_status = '';
	}

	if(isset($candidate_data->employment_period)){
		$cemployment_period = $candidate_data->employment_period;
	} else {
		$cemployment_period = '';
	}

	if(isset($antecedants_data->designation->value)){
		$designation = $antecedants_data->designation->value;
	} else {
		$designation = '';
	}

	if(isset($antecedants_data->designation->match_status)){
		$designation_match_status = $antecedants_data->designation->match_status;
	} else {
		$designation_match_status = '';
	}

	if(isset($candidate_data->designation)){
		$cdesignation = $candidate_data->designation;
	} else {
		$cdesignation = '';
	}

	if(isset($antecedants_data->last_salary->value)){
		$last_salary = $antecedants_data->last_salary->value;
	} else {
		$last_salary = '';
	}

	if(isset($antecedants_data->last_salary->match_status)){
		$last_salary_match_status = $antecedants_data->last_salary->match_status;
	} else {
		$last_salary_match_status = '';
	}

	if(isset($candidate_data->salary)){
		$csalary = $candidate_data->salary;
	} else {
		$csalary = '';
	}

	if(isset($antecedants_data->employee_code->value)){
		$employee_code = $antecedants_data->employee_code->value;
	} else {
		$employee_code = '';
	}

	if(isset($antecedants_data->employee_code->match_status)){
		$employee_code_match_status = $antecedants_data->employee_code->match_status;
	} else {
		$employee_code_match_status = '';
	}

	if(isset($candidate_data->employee_code)){
		$cemployee_code = $candidate_data->employee_code;
	} else {
		$cemployee_code = '';
	}

	if(isset($antecedants_data->reporting_manager_details->value)){
		$reporting_manager_details = $antecedants_data->reporting_manager_details->value;
	} else {
		$reporting_manager_details = '';
	}

	if(isset($antecedants_data->reporting_manager_details->match_status)){
		$reporting_manager_details_match_status = $antecedants_data->reporting_manager_details->match_status;
	} else {
		$reporting_manager_details_match_status = '';
	}

	if(isset($candidate_data->reporting_manager)){
		$creporting_manager = $candidate_data->reporting_manager;
	} else {
		$creporting_manager = '';
	}

	if(isset($antecedants_data->hr_name->value)){
		$hr_name = $antecedants_data->hr_name->value;
	} else {
		$hr_name = '';
	}

	if(isset($antecedants_data->hr_name->match_status)){
		$hr_name_match_status = $antecedants_data->hr_name->match_status;
	} else {
		$hr_name_match_status = '';
	}

	if(isset($candidate_data->hr_name)){
		$chr_name = $candidate_data->hr_name;
	} else {
		$chr_name = '';
	}
	
	if(isset($antecedants_data->hr_email->value)){
		$hr_email = $antecedants_data->hr_email->value;
	} else {
		$hr_email = '';
	}

	if(isset($antecedants_data->hr_email->match_status)){
		$hr_email_match_status = $antecedants_data->hr_email->match_status;
	} else {
		$hr_email_match_status = '';
	}

	if(isset($candidate_data->hr_email)){
		$chr_email = $candidate_data->hr_email;
	} else {
		$chr_email = '';
	}

	if(isset($antecedants_data->hr_contact_details->value)){
		$hr_contact_details = $antecedants_data->hr_contact_details->value;
	} else {
		$hr_contact_details = '';
	}

	if(isset($candidate_data->hr_contact_details)){
		$chr_contact_details = $candidate_data->hr_contact_details;
	} else {
		$chr_contact_details = '';
	}

	if(isset($antecedants_data->hr_contact_details->match_status)){
		$hr_contact_details_match_status = $antecedants_data->hr_contact_details->match_status;
	} else {
		$hr_contact_details_match_status = '';
	}

	if(isset($antecedants_data->reason_for_leaving->value)){
		$reason_for_leaving = $antecedants_data->reason_for_leaving->value;
	} else {
		$reason_for_leaving = '';
	}

	if(isset($antecedants_data->eligibility_for_rehire->value)){
		$eligibility_for_rehire = $antecedants_data->eligibility_for_rehire->value;
	} else {
		$eligibility_for_rehire = '';
	}

	if(isset($antecedants_data->feedback->value)){
		$feedback = $antecedants_data->feedback->value;
	} else {
		$feedback = '';
	}

	if(isset($antecedants_data->referees_details->value)){
		$referees_details = $antecedants_data->referees_details->value;
	} else {
		$referees_details = '';
	}

	if(isset($antecedants_data->additional_comments->value)){
		$additional_comments = $antecedants_data->additional_comments->value;
	} else {
		$additional_comments = '';
	}

	if(isset($antecedants_data->exit_formalities->value)){
		$exit_formalities = $antecedants_data->exit_formalities->value;
	} else {
		$exit_formalities = '';
	}

	if(isset($antecedants_data->verification_mode->value)){
		$verification_mode = $antecedants_data->verification_mode->value;
	} else {
		$verification_mode = '';
	}

	if(isset($antecedants_data->severity_messages_id)){
		$severity_messages_id = $antecedants_data->severity_messages_id;
	} else {
		$severity_messages_id = '';
	}

	if(isset($antecedants_data->verifier_name->value)){
		$verifier_name = $antecedants_data->verifier_name->value;
	} else {
		$verifier_name = '';
	}

	if(isset($antecedants_data->verifier_position)){
		$verifier_position = $antecedants_data->verifier_position->value;
	} else {
		$verifier_position = '';
	}

	if(isset($antecedants_data->verifier_email->value)){
		$verifier_email = $antecedants_data->verifier_email->value;
	} else {
		$verifier_email = '';
	}

	if(isset($antecedants_data->verifier_contact_details->value)){
		$verifier_contact_details = $antecedants_data->verifier_contact_details->value;
	} else {
		$verifier_contact_details = '';
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
	<th scope="row">Name of Employer <span class="required-f">*</span></th>
	<td>
		{{ $cemployer_name }}
		<input type="hidden" name="candidate_data[employer_name]" id="cemployer_name" class="form-control" value="{{ $cemployer_name }}" />
	</td>
	<td>
		<input type="hidden" name="antecedants_data[name_of_employer][name]" value="Name of Employer" />
		<input type="text" name="antecedants_data[name_of_employer][value]" id="name_of_employer" class="form-control" value="{{ $name_of_employer }}" required placeholder="Period of Employement" />
		<span id="name_of_employer_err" class="frm_error"></span>
	</td>
	<td>
		<div class="form-group">
	        <ul class="list-unstyled mb-0">
	          	<li class="d-inline-block mr-2">
	            	<fieldset>
						<div class="vs-checkbox-con vs-checkbox-primary">
							<input type="checkbox" 
							{{ $name_of_employer_match_status == 'MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[name_of_employer][match_status]" value="MATCHED">
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
							{{ $name_of_employer_match_status == 'PARTIAL_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[name_of_employer][match_status]" value="PARTIAL_MATCHED">
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
							{{ $name_of_employer_match_status == 'MIS_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[name_of_employer][match_status]" value="MIS_MATCHED">
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
	<th scope="row">Period of Employement <span class="required-f">*</span></th>
	<td>
		{{ $cemployment_period }}
		<input type="hidden" name="candidate_data[employment_period]" id="cemployment_period" class="form-control" value="{{ $cemployment_period }}" />
	</td>
	<td>
		<input type="hidden" name="antecedants_data[period_of_employement][name]" value="Period of Employement" />
		<input type="text" name="antecedants_data[period_of_employement][value]" id="period_of_employement" class="form-control" value="{{ $period_of_employement }}" required placeholder="Period of Employement" />
		<span id="period_of_employement_err" class="frm_error"></span>
	</td>
	<td>
		<div class="form-group">
	        <ul class="list-unstyled mb-0">
	          	<li class="d-inline-block mr-2">
	            	<fieldset>
						<div class="vs-checkbox-con vs-checkbox-primary">
							<input type="checkbox" 
							{{ $period_of_employement_match_status == 'MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[period_of_employement][match_status]" value="MATCHED">
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
							{{ $period_of_employement_match_status == 'PARTIAL_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[period_of_employement][match_status]" value="PARTIAL_MATCHED">
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
							{{ $period_of_employement_match_status == 'MIS_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[period_of_employement][match_status]" value="MIS_MATCHED">
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
	<th scope="row">Designation <span class="required-f">*</span></th>
	<td>
		{{ $cdesignation }}
		<input type="hidden" name="candidate_data[designation]" id="cdesignation" class="form-control" value="{{ $cdesignation }}" />
	</td>
	<td>
		<input type="hidden" name="antecedants_data[designation][name]" value="Designation" />
		<input type="text" name="antecedants_data[designation][value]" id="designation" class="form-control" value="{{ $designation }}" required placeholder="Designation" />
		<span id="designation_err" class="frm_error"></span>
	</td>
	<td>
		<div class="form-group">
	        <ul class="list-unstyled mb-0">
	          	<li class="d-inline-block mr-2">
	            	<fieldset>
						<div class="vs-checkbox-con vs-checkbox-primary">
							<input type="checkbox" 
							{{ $designation_match_status == 'MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[designation][match_status]" value="MATCHED">
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
							{{ $designation_match_status == 'PARTIAL_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[designation][match_status]" value="PARTIAL_MATCHED">
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
							{{ $designation_match_status == 'MIS_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[designation][match_status]" value="MIS_MATCHED">
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
	<th scope="row">Last Drawn Salary by the applicant (Annual Gross) <span class="required-f">*</span></th>
	<td>
		{{ $csalary }}
		<input type="hidden" name="candidate_data[salary]" id="csalary" class="form-control" value="{{ $csalary }}" />
	</td>
	<td>
		<input type="hidden" name="antecedants_data[last_salary][name]" value="Last Drawn Salary by the applicant (Annual Gross)" />
		<input type="text" name="antecedants_data[last_salary][value]" id="last_salary" class="form-control" value="{{ $last_salary }}" required placeholder="Last Drawn Salary by the applicant (Annual Gross)" />
		<span id="last_salary_err" class="frm_error"></span>
	</td>
	<td>
		<div class="form-group">
	        <ul class="list-unstyled mb-0">
	          	<li class="d-inline-block mr-2">
	            	<fieldset>
						<div class="vs-checkbox-con vs-checkbox-primary">
							<input type="checkbox" 
							{{ $last_salary_match_status == 'MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[last_salary][match_status]" value="MATCHED">
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
							{{ $last_salary_match_status == 'PARTIAL_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[last_salary][match_status]" value="PARTIAL_MATCHED">
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
							{{ $last_salary_match_status == 'MIS_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[last_salary][match_status]" value="MIS_MATCHED">
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
	<th scope="row">Employee Code <span class="required-f">*</span></th>
	<td>
		{{ $cemployee_code }}
		<input type="hidden" name="candidate_data[employee_code]" id="cemployee_code" class="form-control" value="{{ $cemployee_code }}" />
	</td>
	<td>
		<input type="hidden" name="antecedants_data[employee_code][name]" value="Employee Code" />
		<input type="text" name="antecedants_data[employee_code][value]" id="employee_code" class="form-control" value="{{ $employee_code }}" required placeholder="Employee Code" />
		<span id="employee_code_err" class="frm_error"></span>
	</td>
	<td>
		<div class="form-group">
	        <ul class="list-unstyled mb-0">
	          	<li class="d-inline-block mr-2">
	            	<fieldset>
						<div class="vs-checkbox-con vs-checkbox-primary">
							<input type="checkbox" 
							{{ $employee_code_match_status == 'MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[employee_code][match_status]" value="MATCHED">
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
							{{ $employee_code_match_status == 'PARTIAL_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[employee_code][match_status]" value="PARTIAL_MATCHED">
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
							{{ $employee_code_match_status == 'MIS_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[employee_code][match_status]" value="MIS_MATCHED">
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
	<th scope="row">Reporting Manager Details <span class="required-f">*</span></th>
	<td>
		{{ $creporting_manager }}
		<input type="hidden" name="candidate_data[reporting_manager]" id="creporting_manager" class="form-control" value="{{ $creporting_manager }}" />
	</td>
	<td>
		<input type="hidden" name="antecedants_data[reporting_manager_details][name]" value="Reporting Manager Details" />
		<input type="text" name="antecedants_data[reporting_manager_details][value]" id="reporting_manager_details" class="form-control" value="{{ $reporting_manager_details }}" required placeholder="Reporting Manager Details" />
		<span id="reporting_manager_details_err" class="frm_error"></span>
	</td>
	<td>
		<div class="form-group">
	        <ul class="list-unstyled mb-0">
	          	<li class="d-inline-block mr-2">
	            	<fieldset>
						<div class="vs-checkbox-con vs-checkbox-primary">
							<input type="checkbox" 
							{{ $reporting_manager_details_match_status == 'MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[reporting_manager_details][match_status]" value="MATCHED">
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
							{{ $reporting_manager_details_match_status == 'PARTIAL_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[reporting_manager_details][match_status]" value="PARTIAL_MATCHED">
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
							{{ $reporting_manager_details_match_status == 'MIS_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[reporting_manager_details][match_status]" value="MIS_MATCHED">
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
	<th scope="row">HR Name</th>
	<td>
		{{ $chr_name }}
		<input type="hidden" name="candidate_data[hr_name]" id="chr_name" class="form-control" value="{{ $chr_name }}" />
	</td>
	<td>
		<input type="hidden" name="antecedants_data[hr_name][name]" value="HR Name" />
		<input type="text" name="antecedants_data[hr_name][value]" id="hr_name" class="form-control" value="{{ $hr_name }}" required placeholder="HR Name" />
		<span id="hr_name_err" class="frm_error"></span>
	</td>
	<td>
		<div class="form-group">
	        <ul class="list-unstyled mb-0">
	          	<li class="d-inline-block mr-2">
	            	<fieldset>
						<div class="vs-checkbox-con vs-checkbox-primary">
							<input type="checkbox" 
							{{ $hr_name_match_status == 'MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[hr_name][match_status]" value="MATCHED">
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
							{{ $hr_name_match_status == 'PARTIAL_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[hr_name][match_status]" value="PARTIAL_MATCHED">
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
							{{ $hr_name_match_status == 'MIS_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[hr_name][match_status]" value="MIS_MATCHED">
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
	<th scope="row">HR Email</th>
	<td>
		{{ $chr_email }}
		<input type="hidden" name="candidate_data[hr_email]" id="chr_email" class="form-control" value="{{ $chr_email }}" />
	</td>
	<td>
		<input type="hidden" name="antecedants_data[hr_email][name]" value="HR Email" />
		<input type="text" name="antecedants_data[hr_email][value]" id="hr_email" class="form-control" value="{{ $hr_email }}" required placeholder="HR Email" />
		<span id="hr_email_err" class="frm_error"></span>
	</td>
	<td>
		<div class="form-group">
	        <ul class="list-unstyled mb-0">
	          	<li class="d-inline-block mr-2">
	            	<fieldset>
						<div class="vs-checkbox-con vs-checkbox-primary">
							<input type="checkbox" 
							{{ $hr_name_match_status == 'MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[hr_email][match_status]" value="MATCHED">
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
							{{ $hr_email_match_status == 'PARTIAL_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[hr_email][match_status]" value="PARTIAL_MATCHED">
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
							{{ $hr_email_match_status == 'MIS_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[hr_email][match_status]" value="MIS_MATCHED">
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
	<th scope="row">HR Contact details</th>
	<td>
		{{ $chr_contact_details }}
		<input type="hidden" name="candidate_data[hr_contact_details]" id="chr_contact_details" class="form-control" value="{{ $chr_contact_details }}" />
	</td>
	<td>
		<input type="hidden" name="antecedants_data[hr_contact_details][name]" value="HR Contact details" />
		<input type="text" name="antecedants_data[hr_contact_details][value]" id="hr_contact_details" class="form-control" value="{{ $hr_contact_details }}" required placeholder="HR Contact details" />
		<span id="hr_contact_details_err" class="frm_error"></span>
	</td>
	<td>
		<div class="form-group">
	        <ul class="list-unstyled mb-0">
	          	<li class="d-inline-block mr-2">
	            	<fieldset>
						<div class="vs-checkbox-con vs-checkbox-primary">
							<input type="checkbox" 
							{{ $hr_contact_details_match_status == 'MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[hr_contact_details][match_status]" value="MATCHED">
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
							{{ $hr_contact_details_match_status == 'PARTIAL_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[hr_contact_details][match_status]" value="PARTIAL_MATCHED">
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
							{{ $hr_contact_details_match_status == 'MIS_MATCHED' ? 'checked' : '' }} 
							name="antecedants_data[hr_contact_details][match_status]" value="MIS_MATCHED">
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
	<th scope="row">Verifier's Name</th>
	<td></td>
	<td>
		<input type="hidden" name="antecedants_data[verifier_name][name]" value="Verifier's Name" />
		<input type="text" name="antecedants_data[verifier_name][value]" id="verifier_name" class="form-control" value="{{ $verifier_name }}" required placeholder="Verifier's Name" />
		<span id="verifier_name_err" class="frm_error"></span>
	</td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
	<th scope="row">Verifier's Position</th>
	<td></td>
	<td>
		<input type="hidden" name="antecedants_data[verifier_position][name]" value="Verifier's Position" />
		<input type="text" name="antecedants_data[verifier_position][value]" id="verifier_position" class="form-control" value="{{ $verifier_position }}" required placeholder="Verifier's Position" />
		<span id="verifier_position_err" class="frm_error"></span>
	</td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
	<th scope="row">Verifier's Email</th>
	<td></td>
	<td>
		<input type="hidden" name="antecedants_data[verifier_email][name]" value="Verifier's Email" />
		<input type="text" name="antecedants_data[verifier_email][value]" id="verifier_email" class="form-control" value="{{ $verifier_email }}" required placeholder="Verifier's Email" />
		<span id="verifier_email_err" class="frm_error"></span>
	</td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
	<th scope="row">Verifier's Contact details</th>
	<td></td>
	<td>
		<input type="hidden" name="antecedants_data[verifier_contact_details][name]" value="Verifier's Contact details" />
		<input type="text" name="antecedants_data[verifier_contact_details][value]" id="verifier_contact_details" class="form-control" value="{{ $verifier_contact_details }}" required placeholder="Verifier's Contact details" />
		<span id="verifier_contact_details_err" class="frm_error"></span>
	</td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
	<th scope="row">Verified On</th>
	<td></td>
	<td>
		<input type="hidden" name="antecedants_data[verified_on][name]" value="Verified On" />
		<input type="text" name="antecedants_data[verified_on][value]" id="verified_on" class="form-control" value="{{ $verified_on }}" required placeholder="Verified On" />
		<span id="verified_on_err" class="frm_error"></span>
	</td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
	<th scope="row">Reason for Leaving <span class="required-f">*</span></th>
	<td></td>
	<td>
		<input type="hidden" name="antecedants_data[reason_for_leaving][name]" value="Reason for Leaving" />
		<input type="text" name="antecedants_data[reason_for_leaving][value]" id="reason_for_leaving" class="form-control" value="{{ $reason_for_leaving }}" required placeholder="Reason for Leaving" />
		<span id="reason_for_leaving_err" class="frm_error"></span>
	</td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
	<th scope="row">Eligibility for Rehire <span class="required-f">*</span></th>
	<td></td>
	<td>
		<input type="hidden" name="antecedants_data[eligibility_for_rehire][name]" value="Eligibility for Rehire" />
		<select name="antecedants_data[eligibility_for_rehire][value]" id="eligibility_for_rehire" class="form-control">
	    	<option {{ $eligibility_for_rehire == 'YES' ? 'selected' : '' }} value="YES">YES</option>
	    	<option {{ $eligibility_for_rehire == 'NO' ? 'selected' : '' }} value="NO">NO</option>
	    </select>
		<span id="eligibility_for_rehire_err" class="frm_error"></span>
	</td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
	<th scope="row">Feedback on account of Deciplinary / Ethical / <br />
		Integrity conduct on Job <span class="required-f">*</span></th>
	<td></td>
	<td>
		<input type="hidden" name="antecedants_data[feedback][name]" value="Feedback on account of Deciplinary/Ethical/Integrity conduct on Job" />
		<textarea name="antecedants_data[feedback][value]" id="feedback" class="form-control" required />{{ $feedback }}</textarea>
		<span id="feedback_err" class="frm_error"></span>
	</td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
	<th scope="row">Exit Formalities <span class="required-f">*</span></th>
	<td></td>
	<td>
		<input type="hidden" name="antecedants_data[exit_formalities][name]" value="Exit Formalities" />
		<input type="text" name="antecedants_data[exit_formalities][value]" id="exit_formalities" class="form-control" value="{{ $exit_formalities }}" required />
		<span id="exit_formalities_err" class="frm_error"></span>
	</td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
	<th scope="row">Mode of Verification <span class="required-f">*</span></th>
	<td></td>
	<td>
		<input type="hidden" name="antecedants_data[verification_mode][name]" value="Mode of Verification" />
		<select name="antecedants_data[verification_mode][value]" id="verification_mode" class="form-control">
	    	<option {{ $verification_mode == 'VERBAL' ? 'selected' : '' }} value="VERBAL">VERBAL</option>
	    	<option {{ $verification_mode == 'WRITTEN' ? 'selected' : '' }} value="WRITTEN">WRITTEN</option>
	    </select>
		<span id="verification_mode_err" class="frm_error"></span>
	</td>
	<td></td>
	<td></td>
	<td></td>
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