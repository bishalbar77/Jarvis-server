<tr>
	<th scope="row">Verification Date <span class="required-f">*</span></th>
	<td></td>
	<td>
		<input type="date" name="verification_date" id="verification_date" class="form-control" value="" required />
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
		<input type="text" name="verification_time" id="verification_time" class="form-control" value="" />
		<span id="verification_time_err" class="frm_error"></span>
	</td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
	<th scope="row">Police Record Status <span class="required-f">*</span></th>
	<td></td>
	<td>
		<select name="record_status" id="record_status" class="form-control">
	    	<option>Select Record Status</option>
	    	<option value="Record Found">Record Found,</option>
	    	<option value="No Record Found">No Record Found</option>
	    </select>
		<span id="aadhar_number_err" class="frm_error"></span>
	</td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
  	<th scope="row">Police Station Details <span class="required-f">*</span></th>
  	<td></td>
  	<td>
  		<input type="text" name="state" id="state" class="form-control" placeholder="Enter State" value="" required />
	    <span id="age_band_err" class="frm_error"></span>
  	</td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
  	<th scope="row">Address <span class="required-f">*</span></th>
  	<td></td>
  	<td>
	    <input type="text" name="state" id="state" class="form-control" placeholder="Enter State" value="" required />
	    <span id="gender_err" class="frm_error"></span>
  	</td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
  	<th scope="row">Period of Stay <span class="required-f">*</span></th>
  	<td></td>
  	<td>
	    <input type="text" name="state" id="state" class="form-control" placeholder="Enter State" value="" required />
	    <span id="state_err" class="frm_error"></span>
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
    <select name="record_status" id="record_status" class="form-control">
    	<option>Select Option</option>
    	<option value="Green">Green</option>
    	<option value="Discrepant">Discrepant</option>
    	<option value="Inconclusive">Inconclusive</option>
    </select>
    <span id="record_status_err" class="frm_error"></span>
  </td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
  <th scope="row">Conclusion <span class="required-f">*</span></th>
  <td></td>
  <td>
    <textarea class="form-control"></textarea>
    <span id="record_status_err" class="frm_error"></span>
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