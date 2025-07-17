@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="h2 mb-3">Add New Employee</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some problems:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Step Progress Bar -->
<div class="position-relative mb-6" style="padding: 30px 40px;">
    
        <div class="d-flex justify-content-between align-items-center position-relative stepsCircls" style="z-index: 1;">
            @foreach ([
                ['icon' => 'bi-person', 'label' => 'Personal'],
                ['icon' => 'bi-geo-alt', 'label' => 'Address'],
                ['icon' => 'bi-bank', 'label' => 'Bank'],
                ['icon' => 'bi-tools', 'label' => 'Skills'],
                ['icon' => 'bi-upload', 'label' => 'Documents'],
                ['icon' => 'bi-briefcase', 'label' => 'Experience'],
            ] as $index => $step)
            <div class="text-center flex-fill position-relative stepIcon">
                <div class="step-tab step-circle" data-step="{{ $index + 1 }}" onclick="prevStep({{ $index + 1 }})">
                    <i class="bi {{ $step['icon'] }}"></i>
                </div>
                <p class="mt-2 text-sm">{{ $step['label'] }}</p>
            </div>
            @if (!$loop->last)
                <div class="flex-fill mx-1 progress-line bg-gray-400 w-100" data-line="{{ $index + 1 }}"></div>
            @endif
            @endforeach
        </div>
</div>

    <form id="multiStepForm" data-step="1" class="step-content step_content_1" method="POST" enctype="multipart/form-data">
	 	<div id="formSteps">
	      	@csrf
			<!-- <input type="hidden" name="step" value="1">  -->

	        {{-- STEP 1 --}}
			<div class="step card p-4">
			    <h5 class="card-title h5">Personal Information</h5>
			    <div class="row g-3">

			        <div class="col-md-4">
			            <label class="form-label">First Name *</label>
			            <input type="text" name="first_name" class="form-control" placeholder="First Name" required>
			        </div>

			        <div class="col-md-4">
			            <label class="form-label">Last Name *</label>
			            <input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
			        </div>


			        <div class="col-md-4">
			            <label class="form-label">Email *</label>
			            <input type="email" name="email" class="form-control" placeholder="Email" required>
			        </div>

			        <div class="col-md-4">
			            <label class="form-label">Official Email *</label>
			            <input type="email" name="official_email" class="form-control" required placeholder="Official Email">
			        </div>

			        <div class="col-md-4">
			            <label class="form-label">Employee ID *</label>
			            <input type="text" name="employeeID" id="employeeID" class="form-control" required placeholder="DS01">
			        </div>

			        <div class="col-md-4">
			            <label class="form-label">Date of Birth *</label>
			            <input type="date" name="dob" id="dob" class="form-control" placeholder="YYYY-MM-DD" required>
			        </div>

			        <div class="col-md-4">
			            <label class="form-label">Celebration DOB *</label>
			            <input type="date" name="celb_dob" id="celb_dob" class="form-control" placeholder="YYYY-MM-DD" required>
			        </div>

			        <div class="col-md-4">
			            <label class="form-label">Phone Number *</label>
			            <input type="tel" name="phone" id="phone" class="form-control" required>
			        </div>

			        <div class="col-md-4">
			            <label class="form-label">Profile Image</label>
			            <input type="file" name="profile_image" class="form-control" accept="image/*">
			        </div>

					<fieldset id="emergency-container" class="row g-3 mb-5">
					    <div class="h5">Emergency Contact</div>
					        <!-- Error placeholder -->
    						<div id="emergency-error" class="text-danger"></div>
					    <div class="emergency-group row g-3 mb-3">
					        <div class="col-md-3">
					            <label class="form-label">Name *</label>
					            <input type="text" name="emergency_contacts[0][name]" class="form-control" required>
					        </div>
					        <div class="col-md-3">
					            <label class="form-label">Relation *</label>
					            <input type="text" name="emergency_contacts[0][relation]" class="form-control" required>
					        </div>
					        <div class="col-md-3">
					            <label class="form-label">Emergency Number *</label>
					            <input type="tel" name="emergency_contacts[0][phone]" class="form-control" required>
					        </div>
					        <div class="col-md-3 mt-5">
					            <button type="button" class="addMore btn btn-primary me-2">+</button>
					            
					        </div>
					    </div>
					</fieldset>


				    <div class="h5">Other Information</div>
				    <div class="col-md-4">
                        <label class="form-label">LinkedIn URL</label>
                        <input type="url" name="linkedin_url" class="form-control">
                    </div>
				    <div class="col-md-4">
			            <label class="form-label">Gender *</label>
			            <select name="gender" class="form-control" required>
			                <option value="">Select Gender</option>
			                <option value="Male">Male</option>
			                <option value="Female">Female</option>
			                <option value="Other">Other</option>
			            </select>
			        </div>

			        <div class="col-md-4">
		        	    <label for="blood_group" class="form-label">Blood Group</label>
					    <select name="blood_group" id="blood_group" class="form-select">
					        <option value="" selected>Select Blood Group</option>
					        <option value="A+">A+</option>
					        <option value="A−">A−</option>
					        <option value="B+">B+</option>
					        <option value="B−">B−</option>
					        <option value="AB+">AB+</option>
					        <option value="AB−">AB−</option>
					        <option value="O+">O+</option>
					        <option value="O−">O−</option>
					    </select>
			        </div>


			        <div class="col-md-4">
			            <label class="form-label">Voter ID</label>
			            <input type="text" name="voter_id" id="voterid" class="form-control" placeholder="ABC1234567">
			        </div>

			        <div class="col-md-4">
			            <label class="form-label">PAN Card *</label>
			            <input type="text" name="pan" id="pancard" class="form-control" placeholder="ABCDE1234F" required>
			        </div>

			        <div class="col-md-4">
			            <label class="form-label">Aadhar Card *</label>
			            <input type="text" name="aadhar" id="aadhar" class="form-control" placeholder="999999999999" required>
			        </div>
			        <div class="col-md-4">
			        	<label for="designation" class="form-label">Designation *</label>
					    <select name="designation" id="designation" class="form-select" required>
					        <option value="" disabled selected>Select Designation</option>
					        <option value="Team Lead">Team Lead</option>
					        <option value="Software Engineer">Software Engineer</option>
					        <option value="Senior Developer">Senior Developer</option>
					        <option value="Junior Developer">Junior Developer</option>
					        <option value="Project Manager">Project Manager</option>
					        <option value="UI/UX Designer">UI/UX Designer</option>
					        <option value="QA Engineer">QA Engineer</option>
					        <option value="HR Executive">HR Executive</option> 
							<option value="BDE">BDE</option>
							<option value="Business Analyst">Business Analyst</option>
					        <option value="Intern">Intern</option>
					    </select>
			        </div>

			        <div class="col-md-4">
			            <label class="form-label">Role *</label>
			            <select name="role" class="form-control" required>
			                <option value="">Select Role</option>
			                <option value="admin">Admin</option>
			                <option value="hr">HR</option>
			                <option value="accountant">Accountant</option>
			                <option value="employee">Employee</option>
			            </select>
			        </div>

			        <div class="col-md-4">
			            <label class="form-label">Team Lead *</label>
			            <select name="team_lead" class="form-control" required>
			            	<option value="" disabled selected>Select Team Leader</option>
				            @foreach($combinedLeads as $lead)
						        <option value="{{ $lead['user_id'] }}">{{ $lead['name'] }}</option>
						    @endforeach
						</select>			            
			        </div>

			        <div class="col-md-4">
			            <label class="form-label">Joining Date *</label>
			            <input type="date" name="joining_date" id="joiningdate" required placeholder="YYYY-MM-DD" class="form-control">
			        </div>

			        <div class="col-md-4">
			            <label class="form-label">Experience Years</label>
			            <input type="number" name="exp_years" min="0" class="form-control" maxlength="2" 
                               oninput="limitInput(this)" 
                               onkeydown="blockInvalidKeys(event)" onpaste="return false;">
			        </div>

			        <div class="col-md-4">
			            <label class="form-label">Experience Months</label>
			            <input type="number" name="exp_months" class="form-control" min="0" max="11"
                               oninput="validateMonthInput(this)" 
                               onkeydown="blockInvalidKeys(event)" onpaste="return false;">
			        </div>

			        <div class="col-md-4">
			            <label class="form-label">Monthly Salary *</label>
			            <input type="number" name="salary" min="0" class="form-control" onkeydown="blockInvalidKeys(event)" onpaste="return false;" required>
			        </div>

			        <div class="col-md-4">
			            <label class="form-label">Increment After Years *</label>
			            <input type="number" name="inc_years" min="0" class="form-control" maxlength="2" 
                               oninput="limitInput(this)" 
                               onkeydown="blockInvalidKeys(event)" onpaste="return false;" required>
			        </div>

			        <div class="col-md-4">
			            <label class="form-label">Increment After Months *</label>
			            <input type="number" name="inc_months" class="form-control" min="0" max="11"
                               oninput="validateMonthInput(this)" 
                               onkeydown="blockInvalidKeys(event)" onpaste="return false;" required>
			        </div>

			        <div class="col-md-4">
			            <label class="form-label">Probation Period End</label>
			            <input type="date" name="probation_end" id="probationend" placeholder="YYYY-MM-DD" class="form-control">
			        </div>

			        <div class="col-md-4">
			            <label class="form-label">Release Date</label>
			            <input type="date" name="release_date" id="releasedate" placeholder="YYYY-MM-DD" class="form-control">
			        </div>

			        <div class="relative col-md-4">
			            <label class="form-label">Password *</label>
			            <input type="password" name="password" id="password" class="form-control" autocomplete="new-password"  required>
			            <span toggle="#password" class="field-icon toggle-password"><i class="bi bi-eye"></i></span>
			        </div>

			        <div class="relative col-md-4">
			            <label class="form-label">Confirm Password *</label>
			            <input type="password" name="password_confirmation" id="password_confirm" class="form-control" autocomplete="new-password"  required>
			            <span toggle="#password_confirm" class="field-icon toggle-password"><i class="bi bi-eye"></i></span>
			        </div>

			    </div>
			</div>

		    <div class="d-flex justify-content-between mt-4">
			    <button type="button"  class="btn btn-primary btn-lg px-4 nextBtn" onclick="nextStep(1)">
			        Next <i class="bi bi-arrow-right-circle"></i>
			    </button>
			</div>
		</div>
    </form>
    <form data-step="2" class="step-content step_content_2"  method="POST" enctype="multipart/form-data"> 
    	@csrf
        {{-- STEP 2 --}}
        <div class="step card p-4">
            <h5 class="card-title">Permanent Address</h5>
	        <div class="row g-3">
	        	 <div class="col-md-4">
		            <label class="form-label">Address *</label>
		            <input type="text" name="address_perm" placeholder="Address *" class="form-control mb-2" required>
		        </div>
		        <div class="col-md-4">
		            <label class="form-label">State *</label>
		            <select name="state_perm" id="state_perm" class="form-control mb-2" required>
					    <option value="">Select State *</option>
					</select>
		        </div>
		        <div class="col-md-4">
		            <label class="form-label">City *</label>
		            <input type="text" name="city_perm" placeholder="City *" class="form-control mb-2" required>
		        </div>
	            
	            <div class="col-md-4">
		           <label class="form-label">Zip *</label>
		           <input type="text" name="zip_perm" placeholder="Zip *" class="form-control mb-2" maxlength="6" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
		        </div>
	            
	            <div class="col-md-4">
		            <label class="form-label">Country *</label>
		            <select name="country_perm" class="form-control mb-2" required readonly disabled>
						<option value="India" selected>India</option>
					</select>
					<input type="hidden" name="country_perm" value="India">
				</div>

				<div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="sameAsPermanent">
                    <label class="form-check-label" for="sameAsPermanent">Same as Permanent Address</label>
                </div>
			</div>
			<h5 class="card-title mt-5">Local Address</h5>
			<div class="row g-3">
				<div class="col-md-4">
			        <label class="form-label">Address *</label>
		            <input type="text" name="address_local" placeholder="Address *" class="form-control mb-2" required>
	        	</div>
	        	<div class="col-md-4">
	        		<label class="form-label">State *</label>
	            	<select name="state_local" id="state_local" class="form-control mb-2" required>
					    <option value="">Select State *</option>
					</select>
	        	</div>
				<div class="col-md-4">
					<label class="form-label">City *</label>
	            	<input type="text" name="city_local" placeholder="City *" class="form-control mb-2" required>
	            </div>
	            <div class="col-md-4">
	            	<label class="form-label">Zip *</label>
	            	<input type="text" name="zip_local" placeholder="Zip *" class="form-control mb-2" maxlength="6" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
	            </div>
	            <div class="col-md-4">
	            	<label class="form-label">Country *</label>
					<select name="country_local" class="form-control mb-2" required readonly disabled>
						<option value="India" selected>India</option>
					</select>
					<input type="hidden" name="country_local" value="India">
				</div>
			</div>
        </div>
        <div class="d-flex justify-content-between mt-4">
		    <button type="button" class="btn btn-outline-primary btn-lg px-4 prevBtn" onclick="prevStep(1)">
		        <i class="bi bi-arrow-left-circle"></i> Previous
		    </button>
		    <button type="button" class="btn btn-primary btn-lg px-4 nextBtn" onclick="nextStep(2)">
		        Next <i class="bi bi-arrow-right-circle"></i>
		    </button>
		</div>
    </form>
    <form data-step="3" class="step-content step_content_3"  method="POST" enctype="multipart/form-data" >
    	@csrf
        {{-- STEP 3 --}}
        <div class="step card p-4 ">
            <h5 class="card-title">Bank Information</h5>
            <div class="row g-3">	
	            <div class="col-md-4">
		            <label class="form-label">Account Holder Name *</label>
		             <input type="text" name="acc_name" placeholder="Account Holder Name *" class="form-control mb-2" required>
		        </div>
		        <div class="col-md-4">
		            <label class="form-label">Account Number *</label>
		            <input type="text" name="acc_no" id="account_number" placeholder="Account Number *" class="form-control mb-2" required>
		        </div>
		        <div class="col-md-4">
		            <label class="form-label">Confirm Account Number *</label>
		            <input type="text" name="confirm_acc_no" id="confirm_account_number" placeholder="Confirm Account Number *" class="form-control mb-2" required>
		        </div>
		        <div class="col-md-4">
		            <label class="form-label">Bank Name *</label>
		            <input type="text" name="bank_name" placeholder="Bank Name *" class="form-control mb-2" required>
		        </div>
		        <div class="col-md-4">
		            <label class="form-label">IFSC Code *</label>
		            <input type="text" name="ifsc" id="ifsc_code" placeholder="IFSC Code *" class="form-control mb-2" required>
		        </div>
		        <div class="col-md-4">
		            <label class="form-label">Branch Address</label>
		            <input type="text" name="branch_address" placeholder="Branch Address" class="form-control mb-2">
		        </div>		
            </div>
        </div>
        <div class="d-flex justify-content-between mt-4">
		    <button type="button" class="btn btn-outline-primary btn-lg px-4 prevBtn" onclick="prevStep(2)">
		        <i class="bi bi-arrow-left-circle"></i> Previous
		    </button>
		    <button type="button" class="btn btn-primary btn-lg px-4 nextBtn" onclick="nextStep(3)">
		        Next <i class="bi bi-arrow-right-circle"></i>
		    </button>
		</div>
    </form>
    <form data-step="4" class="step-content step_content_4"  method="POST" enctype="multipart/form-data"> 
    	@csrf

    	<!-- STEP 4 - Skills -->
		    <div class="step card p-4">
		        <h5 class="card-title d-none" id="skill-title">Skills</h5>
		        <div id="skills-container">
		            <!-- <div class="skill-group">
			            <div class="row g-3">
				            <div class="col-md-3">
				           		<label class="form-label">Skills</label>
				                <select name="skills[]" class="form-control skill-select" required>
				                    <option value="">Please Select Skill</option>
				                    <?php
				                    

				                    //foreach ($all_skills as $key => $label) {
				                        //echo "<option value=\"$key\">$label</option>";
				                   // }
				                    ?>
				                </select>
				            </div>
					        <div class="col-md-3">
					           	<label class="form-label">Years</label>
				                <input type="number" name="skill_exp_years[]" placeholder="Years" class="form-control" min="0" required maxlength="2" 
                                           oninput="limitInput(this)" 
                                           onkeydown="blockInvalidKeys(event)" onpaste="return false;">
				            </div>
				            <div class="col-md-3">
					           	<label class="form-label">Months</label>
				                <input type="number" name="skill_exp_months[]" placeholder="Months" class="form-control" min="0" max="11" required oninput="validateMonthInput(this)" onkeydown="blockInvalidKeys(event)" onpaste="return false;">
				            </div>
			            	<div class="col-md-3">
		                		<button type="button" onclick="removeSkillField(this)">–</button>
		                	</div>
		                 </div>
		            </div> -->
		        </div>
		        <div class="text-center" id="add-skill-btn-wrapper">
		        	<button type="button" class="btn btn-primary mb-3" onclick="addSkillField()">+ Add Skills</button>
		    	</div>
		    </div>

		    <div class="d-flex justify-content-between mt-4">
			    <button type="button" class="btn btn-outline-primary btn-lg px-4 prevBtn" onclick="prevStep(3)">
			        <i class="bi bi-arrow-left-circle"></i> Previous
			    </button>
			    <button type="button" class="btn btn-primary btn-lg px-4 nextBtn" onclick="nextStep(4)">
			        Next <i class="bi bi-arrow-right-circle"></i>
			    </button>
			</div>
    </form>
    <form data-step="5" class="step-content step_content_5"  method="POST" enctype="multipart/form-data">
    	@csrf
    	<!-- <input type="hidden" name="step"  value="5"> -->
    	 <input type="hidden" name="employee_id" class="employee_id" value="">
    			    <!-- STEP 5 - Document Type -->
		    <div class="step card p-4">
		        <h5 class="card-title d-none" id="document-title">Document Type</h5>
		        <div class="form-columns" id="document-container">
		            <!-- <div class="document-group mb-3" style="border:1px solid #ccc; padding:10px; position:relative;">
		            	<div class="removeDocument" onclick="removeDocument(this)" style="position:absolute; top:0px; right:5px; cursor:pointer;">&times;</div>
			            <div class="row g-3">
			            	<div class="col-md-6">
					           	<label class="form-label">Document Type</label>
				                <select name="documents[0][type]" class="form-control mb-2 doc-select">
				                    <option value="">Please Select Document</option>
				                    <?php
				                    //$doc_types = ["Resume", "VoterID", "Adhaar", "PAN", "ProfileImage", "Passport", "DrivingLicence", "Other"];
				                   // foreach ($doc_types as $doc_type) {
				                       // echo "<option value=\"$doc_type\">$doc_type</option>";
				                    //}
				                    ?>
				                </select>
			            	</div>
			            	<div class="col-md-6">
						        <label class="form-label">Upload Document</label>
				                <input type="file" name="documents[0][file]" class="form-control mb-2" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
			            	</div>
			            </div>
		            </div> -->
		        </div>
		        <div id="add-doc-btn-wrapper" class="text-center">
		        	<button type="button" id="add-document" class="btn btn-primary mb-3">+ Add Document</button> 
		    	</div>
		    </div>

		    <div class="d-flex justify-content-between mt-4">
			    <button type="button" class="btn btn-outline-primary btn-lg px-4 prevBtn" onclick="prevStep(4)">
			        <i class="bi bi-arrow-left-circle"></i> Previous
			    </button>
			    <button type="button" class="btn btn-primary btn-lg px-4 nextBtn" onclick="nextStep(5)">
			        Next <i class="bi bi-arrow-right-circle"></i>
			    </button>
			</div>
    </form>
    <form data-step="6" class="step-content step_content_6"  method="POST" enctype="multipart/form-data">
    	@csrf
    	<!-- <input type="hidden" name="step" value="6"> -->
    	 <input type="hidden" name="employee_id" class="employee_id" value="">
    			    <!-- STEP 6 - Previous Company -->
		    <div class="step card p-4">
		        <h5 class="card-title d-none" id="company-title">Previous Company Details</h5>
		        <div id="previous-companies-wrapper">
		           <!--  <div class="previous-company-group mb-3" data-index="0">
                        <div class="row g-3">
                            <div class="col-md-5">
                                <label class="form-label">Company Name </label>
                                <input type="text" name="previous_companies[0][company]" placeholder="Company Name" class="form-control mb-2">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Salary </label>
                                <input type="number" name="previous_companies[0][salary]" placeholder="Salary" class="form-control mb-2" min="0">
                            </div>
                            <div class="col-md-2 mt-5">
                                <button type="button" class="btn btn-danger remove-company">-</button>
                            </div>
                        </div>
		            </div> -->
		        </div>
		        <div class="text-center" id="add-comapny-btn-wrapper">
		        	<button type="button" id="add-previous-company" class="btn btn-primary mb-3">+ Add Previous Company</button>
		    	</div>
		        <br>
		    </div>

		    <div class="d-flex justify-content-between mt-4">
			    <button type="button" class="btn btn-outline-primary btn-lg px-4 prevBtn" onclick="prevStep(5)">
			        <i class="bi bi-arrow-left-circle"></i> Previous
			    </button>
			    <button type="button" class="btn btn-primary btn-lg px-4 nextBtn" onclick="nextStep(6)">
			        Save <i class="bi bi-arrow-right-circle"></i>
			    </button>
			</div>
    </form>
</div>

<style>
	.error {
        font-size: 0.85rem;
        color: red;
        display: block;
        margin-top: 2px;
    }
    .skill-group {
        /*display: flex;
        flex-wrap: wrap;
        gap: 10px;*/
        margin-bottom: 10px;
    }
    .skill-group select,
    .skill-group input {
        flex: 1;
        min-width: 150px;
    }
    .skill-group button {
        padding: 6px 10px;
        background-color: #dc3545;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-top:24px;
    }
    .skill-group button:hover {
        background-color: #c82333;
    }


	.step-tab.disabled {
	    pointer-events: none;
	    opacity: 0.5;
	}
	.step-content { display: none; }
	.step-content.active { display: block; }
	.step-circle {
	    width: 40px;
	    height: 40px;
	    border-radius: 9999px;
	    background-color: #e5e7eb;
	    display: flex;
	    align-items: center;
	    justify-content: center;
	    margin: auto;
	    color: #6b7280;
	    transition: background-color 0.3s;
	}
	.step-circle.active, .step-circle.completed {
	    background-color: #10b981;
	    color: white;
	}
	.step-progress-container {
	    position: relative;
	}
	.step-line.completed {
	    background-color: #10b981; /* green */
	}
	.progress-line {
	    height: 4px;
	    background-color: #d1d5db; /* gray-300 */
	    margin-top: -24px;
	    transition: background-color 0.3s ease;
	}
	.progress-line.active {
	    background-color: #10b981; /* green-500 */
	}
	.removeDocument {
    color: red;
    font-size: 32px;
    line-height: 32px;
}
.stepIcon:not(:has(.disabled)) {
    cursor: pointer;
}
option:disabled {
    background: #80808063;
    color: #fff;
}
.field-icon {
    position: absolute;
    right: 20px;
    top: 55px;
    transform: translateY(-50%);
    cursor: pointer;
    color: #6c757d;
}
</style>
<script>
	// Password show hide eye
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggle-password').forEach(function(toggle) {
        toggle.addEventListener('click', function () {
            const input = document.querySelector(this.getAttribute('toggle'));
            const icon = this.querySelector('i');

            if (input.getAttribute('type') === 'password') {
                input.setAttribute('type', 'text');
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.setAttribute('type', 'password');
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    });
});
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.stepIcon').forEach(el => {
        el.style.cursor = el.querySelector('.disabled') ? 'default' : 'pointer';
    });
});
</script>

<script>

    let currentStep = 1;
    const totalSteps = 6;
    showStep(currentStep);

	$(document).ready(function () {

	    // Allow only digits (max 12) in Aadhar
	    $('#aadhar').on('input', function () {
	        this.value = this.value.replace(/\D/g, '').slice(0, 12);
	    });

	    // Auto-uppercase and format PAN
	    $('#pancard').on('input', function () {
	        this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '').slice(0, 10);
	    });

	    // Auto-uppercase and format Voter ID (3 letters + 7 digits)
	    $('#voterid').on('input', function () {
	        this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '').slice(0, 10);
	    });
	    
	    $('#employeeID').on('input', function () {
		    this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '').slice(0, 10);
		});

	    // Phone number: digits only, max 10
	    $('#phone').on('input', function () {
	        this.value = this.value.replace(/\D/g, '').slice(0, 10);
	    });

	    // Account number: digits only, max 18
	    $('#account_number, #confirm_account_number').on('input', function () {
	        this.value = this.value.replace(/\D/g, '').slice(0, 18);
	    });

	    // IFSC: uppercase, format as 4 letters + 0 + 6 alphanum
	    $('#ifsc_code').on('input', function () {
	        this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '').slice(0, 11);
	    });

	});


	function validateCustomFields(step) {
	    let isValid = true;
	   // $('.error').remove(); // clear old error messages

	    // Step 1 — Personal info validation (Aadhar, PAN, Voter, Phone)
	    if (step === 1) {
	        const aadhar = $('#aadhar').val()?.trim();
	        const pan = $('#pancard').val()?.trim();
	        const voter = $('#voterid').val()?.trim();
	        const phone = $('#phone').val()?.trim();
	        //const emergency = $('#emergency').val()?.trim();
	        const employeeID = $('#employeeID').val()?.trim();
	        
	        //const emergency = $('#emergency').val()?.trim();

	        if (!employeeID) {
			    $('#employeeID').after('<span class="error text-danger">Employee ID is required.</span>');
			    isValid = false;
			} else if (!/^DS[0-9]+$/.test(employeeID)) {
			    $('#employeeID').after('<span class="error text-danger">Employee ID must start with "DS" followed by numbers only, e.g., DS01.</span>');
			    isValid = false;
			}

            if (!aadhar) {
	           $('#aadhar').after('<span class="error text-danger">Aadhar Card is required.</span>');
	            isValid = false;
	        } else if (!/^\d{12}$/.test(aadhar)) {
	            $('#aadhar').after('<span class="error text-danger">Aadhar must be 12 digits.</span>');
	            isValid = false;
	        }

	        if (!pan) {
	           $('#pancard').after('<span class="error text-danger">PAN Card is required.</span>');
	            isValid = false;
	        } else if (!/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/.test(pan)) {
	            $('#pancard').after('<span class="error text-danger">Invalid PAN format (ABCDE1234F).</span>');
	            isValid = false;
	        }

	        if (!voter) {
	            
	        } else if (!/^[A-Z]{3}[0-9]{7}$/.test(voter)) {
	            $('#voterid').after('<span class="error text-danger">Invalid Voter ID format (ABC1234567).</span>');
	            isValid = false;
	        }

	        if (!phone) {
	            $('#phone').after('<span class="error text-danger">Phone Number is required.</span>');
	            isValid = false;
	        } else if (!/^[0-9]\d{9}$/.test(phone)) {
	            $('#phone').after('<span class="error text-danger">Invalid Phone number Starts with 6 to 9.</span>');
	            isValid = false;
	        }

	        // if (!emergency) {
	        //     $('#emergency').after('<span class="error text-danger">Emergency Phone is required.</span>');
	        //     isValid = false;
	        // } else if (!/^[0-9]\d{9}$/.test(emergency)) {
	        //     $('#emergency').after('<span class="error text-danger">Invalid Emergency Phone number.</span>');
	        //     isValid = false;
	        // }
	    }

	    // Step 3 — Bank details (account + IFSC)
	    if (step === 3) {
	        const account = $('#account_number, #confirm_account_number').val()?.trim();
	        const ifsc = $('#ifsc_code').val()?.trim();

			if (!account) {
	            $('#account_number, #confirm_account_number').after('<span class="error text-danger">Account Number is required.</span>');
	            isValid = false;
	        } else if (!/^\d{9,18}$/.test(account)) {
	            $('#account_number, #confirm_account_number').after('<span class="error text-danger">Invalid Account Number (9–18 digits).</span>');
	            isValid = false;
	        }

	        if (!ifsc) {
	            $('#ifsc_code').after('<span class="error text-danger">IFSC Code is required.</span>');
	            isValid = false;
	        } else if (!/^[A-Z]{4}0[A-Z0-9]{6}$/.test(ifsc)) {
	            $('#ifsc_code').after('<span class="error text-danger">Invalid IFSC (e.g. SBIN0001234).</span>');
	            isValid = false;
	        }
	    }

	    return isValid;
	}


    function showStep(step) {
            document.querySelectorAll('.step-content').forEach(e => e.classList.remove('active'));
            document.querySelector(`.step-content[data-step="${step}"]`).classList.add('active');

            document.querySelectorAll('.step-tab').forEach(tab => {
                tab.classList.remove('active');
                tab.classList.add('disabled');
                tab.disabled = true;
            });
            for (let i = 1; i <= step; i++) {
                let tab = document.querySelector(`.step-tab[data-step="${i}"]`);
                tab.classList.remove('disabled');
                tab.disabled = false;
            }
            document.querySelector(`.step-tab[data-step="${step}"]`).classList.add('active');

            // Update circle styles
            document.querySelectorAll('.step-circle').forEach(circle => {
                circle.classList.remove('active', 'completed');
            });
            for (let i = 1; i <= totalSteps; i++) {
                const circle = document.querySelector(`.step-circle[data-step="${i}"]`);
                if (i < step) circle.classList.add('completed');
                if (i === step) circle.classList.add('active');
            }

            document.querySelectorAll('.step-line').forEach(line => line.classList.remove('completed'));
            for (let i = 1; i < step; i++) {
                const line = document.querySelector(`.step-line[data-line="${i}"]`);
                if (line) line.classList.add('completed');
            }

            document.querySelectorAll('.progress-line').forEach((line, index) => {
                if (index < step - 1) {
                    line.classList.add('active');
                } else {
                    line.classList.remove('active');
                }
            });

        document.querySelector('.prevBtn').style.display = step === 1 ? 'none' : 'inline-block';
        document.querySelector('.nextBtn').style.display = step === totalSteps ? 'none' : 'inline-block';
    }

	function nextStep(step) {

		if (step == 1) {

			let isValid = true;
		    $('.error').remove(); // clear old messages

			    $('.step_content_1').find('input[required]:not([type="hidden"]), select[required], textarea[required]').each(function () {
				    const name = $(this).attr('name');
				    
				    // Skip fields that have custom validation
				    if (['phone', 'aadhar', 'pan', 'voterid', 'employeeID'].includes(name)) return;

				    const value = $(this).val()?.trim();
				    const label = $(this).closest('div').find('label').text().replace('*', '').trim();

				    if (!value) {
				        $(this).after(`<span class="error text-danger">${label} is required.</span>`);
				        isValid = false;
				    }
				});

				const email = $('[name="email"]').val()?.trim();
				const officialEmail = $('[name="official_email"]').val()?.trim();

				if (email && officialEmail && email === officialEmail) {
				    const $officialEmailInput = $('[name="official_email"]');
				    $officialEmailInput.after('<span class="error text-danger">Official Email should not be the same as Email.</span>');
				    isValid = false;
				}

			    // 2. Password confirmation match check
			    const password = $('#password').val()?.trim();
			    const confirmPassword = $('#password_confirm').val()?.trim();

			    if (password || confirmPassword) {
			        if (password !== confirmPassword) {
			            $('#password_confirm').after(`<span class="error text-danger">Passwords do not match.</span>`);
			            isValid = false;
			        }
			    }

				const phone = $('[name="phone"]').val()?.trim();
				let emergencyPhones = [];
				let emergencyPhoneErrorShown = false;

				$('.emergency-group').each(function (index) {
				    const $input = $(this).find('input[name^="emergency_contacts"]').filter('[name$="[phone]"]');
				    const emergencyPhone = $input.val()?.trim();
				    $input.on('input', function () {
				        this.value = this.value.replace(/\D/g, '').slice(0, 10);
				    });

				    if (emergencyPhone) {
				        // Check if matches main phone
				        if (emergencyPhone === phone && !emergencyPhoneErrorShown) {
				            $input.after('<span class="error text-danger">Emergency phone should not match with main phone number.</span>');
				            emergencyPhoneErrorShown = true;
				            isValid = false;
				        }

				        // Check if duplicate with any previous emergency phone
				        if (emergencyPhones.includes(emergencyPhone)) {
				            $input.after('<span class="error text-danger">Emergency contacts must have different with Emergency and phone numbers.</span>');
				            isValid = false;
				        }

				         if (!emergencyPhones) {
				            $('#phone').after('<span class="error text-danger">Emergency contacts Number is required.</span>');
				            isValid = false;
				        } else if (!/^[0-9]\d{9}$/.test(phone)) {
				            $('#phone').after('<span class="error text-danger">Invalid Emergency contacts number Starts with 0 to 9.</span>');
				            isValid = false;
				        }

				        emergencyPhones.push(emergencyPhone);
				    }
				});


				 const expYearsInput = document.querySelector('[name="exp_years"]');
            const expMonthsInput = document.querySelector('[name="exp_months"]');
            const incYearsInput = document.querySelector('[name="inc_years"]');
            const incMonthsInput = document.querySelector('[name="inc_months"]');

            // // Safely parse values or fallback to 0
            // const expYears = expYearsInput.value.trim() !== '' ? parseInt(expYearsInput.value) : 0;
            // const expMonths = expMonthsInput.value.trim() !== '' ? parseInt(expMonthsInput.value) : 0;
            // const incYears = incYearsInput.value.trim() !== '' ? parseInt(incYearsInput.value) : 0;
            // const incMonths = incMonthsInput.value.trim() !== '' ? parseInt(incMonthsInput.value) : 0;

            // Remove old error messages
            $(expYearsInput).next('.error').remove();
            $(expMonthsInput).next('.error').remove();
            $(incYearsInput).next('.error').remove();
            $(incMonthsInput).next('.error').remove();

            // // Validate Experience section (only if any field is filled)
            // const isExpFilled = expYearsInput.value.trim() !== '' || expMonthsInput.value.trim() !== '';
            // if (isExpFilled && (expYears === 0 && expMonths === 0)) {
            //     isValid = false;
            //     $(expYearsInput).after('<span class="error text-danger">At least one of Experience Years or Months must be greater than 0.</span>');
            // }

            // // Validate Increment section (only if any field is filled)
            // const isIncFilled = incYearsInput.value.trim() !== '' || incMonthsInput.value.trim() !== '';
            // if (isIncFilled && (incYears === 0 && incMonths === 0)) {
            //     isValid = false;
            //     $(incYearsInput).after('<span class="error text-danger">At least one of Increment Years or Months must be greater than 0.</span>');
            // }else if(isIncFilled == ''){
            //     $(incYearsInput).after('<span class="error text-danger">Increments years is required.</span>');
            //     $(incMonthsInput).after('<span class="error text-danger">Increments Months is required.</span>');
            // }



            const expYears = parseInt(expYearsInput.value.trim() || '0', 10);
            const expMonths = parseInt(expMonthsInput.value.trim() || '0', 10);
            const expYearsFilled = expYearsInput.value.trim() !== '';
            const expMonthsFilled = expMonthsInput.value.trim() !== '';

            if (expYearsFilled || expMonthsFilled) {
                if (expYears === 0 && expMonths === 0) {
                    isValid = false;
                    $(expYearsInput).after('<span class="error text-danger">At least one of Experience Years or Months must be greater than 0.</span>');
                }
                if (!expYearsFilled && expMonthsFilled) {
                    isValid = false;
                    $(expYearsInput).after('<span class="error text-danger">Please enter at least 0 Years.</span>');
                }
                if (expYearsFilled && !expMonthsFilled) {
                    isValid = false;
                    $(expMonthsInput).after('<span class="error text-danger">Please enter at least 0 Months.</span>');
                }
            }

            // ✅ Validate Increment section
            const incYears = parseInt(incYearsInput.value.trim() || '0', 10);
            const incMonths = parseInt(incMonthsInput.value.trim() || '0', 10);
            const incYearsFilled = incYearsInput.value.trim() !== '';
            const incMonthsFilled = incMonthsInput.value.trim() !== '';

            if (incYearsFilled || incMonthsFilled) {
                if (incYears === 0 && incMonths === 0) {
                    isValid = false;
                    $(incYearsInput).after('<span class="error text-danger">At least one of Increment Years or Months must be greater than 0.</span>');
                }
                if (!incYearsFilled && incMonthsFilled) {
                    isValid = false;
                    $(incYearsInput).after('<span class="error text-danger">Please enter at least 0 Years.</span>');
                }
                if (incYearsFilled && !incMonthsFilled) {
                    isValid = false;
                    $(incMonthsInput).after('<span class="error text-danger">Please enter at least 0 Months.</span>');
                }
            }

            let linkedinInput = $('[name="linkedin_url"]'); // jQuery object
            let linkedinVal = linkedinInput.val().trim();   // .val() now works

            const urlRegex = /^(https?:\/\/)([\w-]+\.)+[\w-]+(\/[\w\-._~:/?#[\]@!$&'()*+,;=]*)?$/;

            if (linkedinVal && !urlRegex.test(linkedinVal)) {
                $(linkedinInput).after('<span class="error text-danger">The linkedin url field must be a valid URL e.g. https://www.linkedin.com/</span>');
                isValid = false;
            }

				// Custom fields (PAN, Aadhar, etc.)
				if (!validateCustomFields(step)) {
				    isValid = false;
				}

				// Scroll to first error
				if (!isValid) {
				    const firstError = $('.error').first();
				    if (firstError.length) {
				        $('html, body').animate({
				            scrollTop: firstError.offset().top - 120
				        }, 100);
				    }
				    return;
				}


			
		    const currentForm = $('.step_content_1')[0]; // Get the raw DOM element
		    const formData = new FormData(currentForm); // ✅ Collects text + files

		    jQuery('.ApWait').show();
		    $.ajax({
		        url: '/hrportalv2/admin/employe/store-step1',
		        type: 'POST',
		        data: formData,
		        contentType: false,      // ✅ Do not set content type manually
		        processData: false,      // ✅ Prevent jQuery from converting the FormData
		        headers: {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF for Laravel
		        },
		        success: function (response) {
		           	jQuery('.ApWait').hide(); 
		            showStep(2); // Move to step 2
		        },
		        error: function (xhr) {
		        	jQuery('.ApWait').hide(); 
		            if (xhr.status === 422) {
				            let errors = xhr.responseJSON.errors;
						$('.error').remove();

						// List of fields you want to display inline errors for
						
								// List of fields you want to display inline errors for
	                        const targetFields = ['employeeID'];

	                        let firstErrorField = null;

	                        $.each(errors, function (field, messages) {
	                            let inputField = $('[name="' + field + '"]');

	                            if (inputField.length) {
	                                // If the field is employeeID, show custom message
	                                if (targetFields.includes(field)) {
	                                    inputField.after('<span class="error text-danger">This Employee ID is already taken. Please enter a different ID.</span>');
	                                } else {
	                                    // Otherwise, show the actual validator message
	                                    inputField.after('<span class="error text-danger">' + messages[0] + '</span>');
	                                }

	                                // Capture the first field with error to scroll to
	                                if (!firstErrorField) {
	                                    firstErrorField = inputField;
	                                }
	                            }
	                        });
						// Scroll to the first errored field if present
						if (firstErrorField && firstErrorField.length) {
						    $('html, body').animate({
						        scrollTop: firstErrorField.offset().top - 120 // adjust offset as needed
						    }, 300);
						}
				        } else {
				            console.error('Raw error response:', xhr.responseText);
				            Swal.fire({
				                icon: 'error',
				                title: 'Oops!',
				                text: 'Something went wrong. Please try again.'
				            });
				        }
		        }
		    });

		    
		}

		if(step==2){
			let isValid = true;
		    $('.error').remove(); // clear old messages

			$('.step_content_2').find('input[required]:not([type="hidden"]), select[required], textarea[required]').each(function () {
			    
			    const value = $(this).val()?.trim();
			    const label = $(this).closest('div').find('label').text().replace('*', '').trim();

			    if (!value) {
			        $(this).after(`<span class="error text-danger">${label} is required.</span>`);
			        isValid = false;
			    }
			});

			// Scroll to first error if invalid
		    if (!isValid) {
		        const firstError = $('.error').first();
		        if (firstError.length) {
		            $('html, body').animate({
		                scrollTop: firstError.offset().top - 120 // adjust offset as needed
		            }, 100);
		        }
		        return;
		    }

		    const currentForm = $('.step_content_2')[0];
		    const formData = new FormData(currentForm);
			jQuery('.ApWait').show(); 
		    $.ajax({
		        url: '/hrportalv2/admin/employe/store-step2',
		        type: 'POST',
		        data: formData,
		        contentType: false,      // ✅ Do not set content type manually
		        processData: false,      // ✅ Prevent jQuery from converting the FormData
		        headers: {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF for Laravel
		        },
		        success: function (response) {
		        	jQuery('.ApWait').hide(); 
		             showStep(3); // show the next step form
		           
		        },
		        error: function (xhr) {
		        	jQuery('.ApWait').hide(); 
		            if (xhr.status === 422) {
				            let errors = xhr.responseJSON.errors;
				            let firstError = Object.values(errors)[0][0];
				            Swal.fire({
				                icon: 'error',
				                title: 'Validation Error',
				                text: firstError
				            });
				        } else {
				            console.error('Raw error response:', xhr.responseText);
				            Swal.fire({
				                icon: 'error',
				                title: 'Oops!',
				                text: 'Something went wrong. Please try again.'
				            });
				        }
		        }
		    });
		}

		if(step==3){


		    let isValid = true;
		    $('.error').remove(); // clear old messages

			$('.step_content_3').find('input[required]:not([type="hidden"]), select[required], textarea[required]').each(function () {
			    const name = $(this).attr('name');
			    
			    // Skip fields that have custom validation
			    if (['acc_no', 'confirm_acc_no', 'ifsc'].includes(name)) return;

			    const value = $(this).val()?.trim();
			    const label = $(this).closest('div').find('label').text().replace('*', '').trim();

			    if (!value) {
			        $(this).after(`<span class="error text-danger">${label} is required.</span>`);
			        isValid = false;
			    }
			});

			// 2. Custom field validations (PAN, Aadhar, Phone etc.)
		    if (!validateCustomFields(step)) {
		        isValid = false;
		    }

		    if (!isValid) {
		        const firstError = $('.error').first();
		        if (firstError.length) {
		            $('html, body').animate({
		                scrollTop: firstError.offset().top - 120 // adjust offset as needed
		            }, 100);
		        }
		        return;
		    }

		    const currentForm = $('.step_content_3')[0];
		    const formData = new FormData(currentForm);
jQuery('.ApWait').show(); 
		    $.ajax({
		        url: '/hrportalv2/admin/employe/store-step3',
		        type: 'POST',
		        data: formData,
		        contentType: false,      // ✅ Do not set content type manually
		        processData: false,      // ✅ Prevent jQuery from converting the FormData
		        headers: {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF for Laravel
		        },
		        success: function (response) {
		        
		            jQuery('.ApWait').hide(); 
		             showStep(4); // show the next step form
		           
		        },
		        error: function (xhr) {
		        	jQuery('.ApWait').hide(); 
		            if (xhr.status === 422) {
				            let errors = xhr.responseJSON.errors;
				            let firstError = Object.values(errors)[0][0];
				            Swal.fire({
				                icon: 'error',
				                title: 'Validation Error',
				                text: firstError
				            });
				        } else {
				            console.error('Raw error response:', xhr.responseText);
				            Swal.fire({
				                icon: 'error',
				                title: 'Oops!',
				                text: 'Something went wrong. Please try again.'
				            });
				        }
		        }
		    });
		}


		if(step==4){

			 let isValid = true;
            $('.error').remove(); // clear previous errors

            $('.skill-group').each(function (index) {
                const skillSelect = $(this).find('select[name$="[name]"]');
                const skillYearsInput = $(this).find('input[name$="[years]"]');
                const skillMonthsInput = $(this).find('input[name$="[months]"]');

                const selectedSkill = skillSelect.val()?.trim();
                const years = parseInt(skillYearsInput.val()) || 0;
                const months = parseInt(skillMonthsInput.val()) || 0;

                // clear previous errors
                skillSelect.next('.error').remove();
                skillYearsInput.next('.error').remove();
                skillMonthsInput.next('.error').remove();
                //console.log(`Skill group ${index}:`, { selectedSkill, years, months });
                // ✅ 🚩 CASE: Entirely empty row
                if ((!selectedSkill || selectedSkill === '') && years === 0 && months === 0) {
                    skillSelect.after('<span class="error text-danger">Please enter the data or remove this entry.</span>');
                    isValid = false;
                }
                // 🚩 CASE: Skill not selected but years/months are entered
                else if ((!selectedSkill || selectedSkill === '') && (years > 0 || months > 0)) {
                    skillSelect.after('<span class="error text-danger">Please select a skill for this entry or remove it.</span>');
                    isValid = false;
                }
                // ✅ CASE: Skill is selected, validate years/months
                else if (selectedSkill && selectedSkill !== '') {
                    if (years === 0 && months === 0) {
                        skillYearsInput.after('<span class="error text-danger">Enter at least 1 year or month for selected skill.</span>');
                        isValid = false;
                    }
                    if (months < 0 || months > 11) {
                        skillMonthsInput.after('<span class="error text-danger">Months must be between 0 and 11.</span>');
                        isValid = false;
                    }
                }
            });
			            if (!isValid) {
                const firstError = $('.error').first();
                if (firstError.length) {
                    $('html, body').animate({
                        scrollTop: firstError.offset().top - 120
                    }, 100);
                }
                return; // prevent AJAX call
            }
			jQuery('.ApWait').show(); 
		    const currentForm = $('.step_content_4')[0];
		    const formData = new FormData(currentForm);

		    $.ajax({
		        url: '/hrportalv2/admin/employe/store-step4',
		        type: 'POST',
		        data: formData,
		        contentType: false,      // ✅ Do not set content type manually
		        processData: false,      // ✅ Prevent jQuery from converting the FormData
		        headers: {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF for Laravel
		        },
		        success: function (response) {
		        	jQuery('.ApWait').hide(); 
		             showStep(5); // show the next step form
		           
		        },
		        error: function (xhr) {
		        	jQuery('.ApWait').hide(); 
		           if (xhr.status === 422) {
				            let errors = xhr.responseJSON.errors;
				            let firstError = Object.values(errors)[0][0];
				            Swal.fire({
				                icon: 'error',
				                title: 'Validation Error',
				                text: firstError
				            });
				        } else {
				            console.error('Raw error response:', xhr.responseText);
				            Swal.fire({
				                icon: 'error',
				                title: 'Oops!',
				                text: 'Something went wrong. Please try again.'
				            });
				        }
		        }
		    });
		}

		if(step==5){

			let isValid = true;
			$('.error').remove(); // Clear previous errors

			let documentGroups = $('.document-group');
        documentGroups.each(function () {
			    const docTypeField = $(this).find('.doc-select');
			    const docFileField = $(this).find('input[type="file"]');
			    const hasExistingFile = $(this).find('.viewfileCurrent').length > 0;

			    const docType = docTypeField.val()?.trim();
			    const docFile = docFileField.val()?.trim();

			    // If a document type is selected, file must be provided
			    if (docType !== "") {
			        if (!docFile && !hasExistingFile) {
			            isValid = false;
			            docFileField.after('<div class="error text-danger">Document file is required.</div>');
			        }
			    }

			    // If file is provided but no doc type selected
			    if (docFile && docType === "") {
			        isValid = false;
			        docTypeField.after('<div class="error text-danger">Document type is required.</div>');
			    }
			});

			if (!isValid) {
			    const firstError = $('.error').first();
			    if (firstError.length) {
			        $('html, body').animate({
			            scrollTop: firstError.offset().top - 120
			        }, 100);
			    }
			    return;
			}

		    const currentForm = $('.step_content_5')[0];
		    const formData = new FormData(currentForm);
jQuery('.ApWait').show(); 
		    $.ajax({
		        url: '/hrportalv2/admin/employe/store-step5',
		        type: 'POST',
		        data: formData,
		        contentType: false,      // ✅ Do not set content type manually
		        processData: false,      // ✅ Prevent jQuery from converting the FormData
		        headers: {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF for Laravel
		        },
		        success: function (response) {
		        	jQuery('.ApWait').hide(); 
		             showStep(6); // show the next step form
		           
		        },
		        error: function (xhr) {
		        	jQuery('.ApWait').hide(); 
		            if (xhr.status === 422) {
				            let errors = xhr.responseJSON.errors;
				            let firstError = Object.values(errors)[0][0];
				            Swal.fire({
				                icon: 'error',
				                title: 'Validation Error',
				                text: firstError
				            });
				        } else {
				            console.error('Raw error response:', xhr.responseText);
				            Swal.fire({
				                icon: 'error',
				                title: 'Oops!',
				                text: 'Something went wrong. Please try again.'
				            });
				        }
		        }
		    });
		}
		if(step==6){

			  let isValid = true;
    $('.error').remove(); // clear previous errors

    $('.previous-company-group').each(function () {
        const companyInput = $(this).find('input[name$="[company]"]');
        const salaryInput = $(this).find('input[name$="[salary]"]');

        const company = companyInput.val()?.trim();
        const salary = parseFloat(salaryInput.val()) || 0;

        // clear previous error next to fields
        companyInput.next('.error').remove();
        salaryInput.next('.error').remove();

        if ((!company || company === '') && salary === 0) {
            // Entirely empty row: show error to either fill or remove
            companyInput.after('<span class="error text-danger">Please enter company name and salary or remove this entry.</span>');
            isValid = false;
        } else if ((!company || company === '') && salary > 0) {
            companyInput.after('<span class="error text-danger">Please enter the company name for this entry.</span>');
            isValid = false;
        } else if (company && salary === 0) {
            salaryInput.after('<span class="error text-danger">Please enter the salary for this company.</span>');
            isValid = false;
        }
    });

    if (!isValid) {
        const firstError = $('.error').first();
        if (firstError.length) {
            $('html, body').animate({
                scrollTop: firstError.offset().top - 120
            }, 100);
        }
        return; // ❌ Prevent AJAX call if validation fails
    }


		    const currentForm = $('.step_content_6')[0];
		    const formData = new FormData(currentForm);
jQuery('.ApWait').show(); 
		    $.ajax({
		        url: '/hrportalv2/admin/employe/store-step6',
		        type: 'POST',
		        data: formData,
		        contentType: false,      // ✅ Do not set content type manually
		        processData: false,      // ✅ Prevent jQuery from converting the FormData
		        headers: {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF for Laravel
		        },
		        success: function (response) {
		        	jQuery('.ApWait').hide(); 
		                   Swal.fire({
					            icon: 'success',
					            title: 'Success!',
					            text: 'Employee added successfully!',
					            showConfirmButton: false,
					            timer: 2000
					        }).then(() => {
					            window.location.href = "/hrportalv2/admin/dashboard";
					        });
		        },
		        error: function (xhr) {
		        	jQuery('.ApWait').hide(); 
		            if (xhr.status === 422) {
				            let errors = xhr.responseJSON.errors;
				            let firstError = Object.values(errors)[0][0];
				            Swal.fire({
				                icon: 'error',
				                title: 'Validation Error',
				                text: firstError
				            });
				        } else {
				            console.error('Raw error response:', xhr.responseText);
				            Swal.fire({
				                icon: 'error',
				                title: 'Oops!',
				                text: 'Something went wrong. Please try again.'
				            });
				        }
		        }
		    });
		}

	}

    function prevStep(currentStep) {
        if (currentStep >= 1)
        showStep(currentStep);
    }

    document.querySelector('.nextBtn').addEventListener('click', nextStep);
    document.querySelector('.prevBtn').addEventListener('click', prevStep);

	document.querySelectorAll('.step-tab').forEach(tab => {
	    tab.addEventListener('click', () => {
	        const targetStep = parseInt(tab.getAttribute('data-step'));

	        if (!isNaN(targetStep) && targetStep < currentStep) {
	            currentStep = targetStep;
	            showStep(currentStep); // function to toggle visible step
	        }
	    });
	});



	
    document.addEventListener("DOMContentLoaded", function () {
    // Function to update all skill dropdowns and disable already selected ones
        function updateSkillDropdowns() {
            let selectedSkills = [];

            // Get all selected skill values
            document.querySelectorAll('.skill-select').forEach(select => {
                if (select.value) selectedSkills.push(select.value);
            });

            // Disable selected options in all dropdowns except the current one
            document.querySelectorAll('.skill-select').forEach(select => {
                const currentValue = select.value;

                select.querySelectorAll('option').forEach(option => {
                    if (selectedSkills.includes(option.value) && option.value !== currentValue) {
                        option.disabled = true;
                    } else {
                        option.disabled = false;
                    }
                });
            });
        }


        // Clone skill field
        window.addSkillField = function () {
            var container = document.getElementById("skills-container");
            var group = container.querySelector(".skill-group");
            var clone = group.cloneNode(true);
            // Clear input values in the cloned node
            var inputs = clone.querySelectorAll("input, select, textarea");
            for (var i = 0; i < inputs.length; i++) {
              inputs[i].value = "";
            }
            container.appendChild(clone);
            updateSkillDropdowns(); // 👈 update after adding
        };


let skillIndex = {{ isset($employeeSkills) ? count($employeeSkills) : 1 }};

window.addSkillField = function () {
    const container = document.getElementById("skills-container");
    const title = document.getElementById('skill-title');
    const wrapper = document.getElementById('add-skill-btn-wrapper');

    // Show title and container
    // if (container.classList.contains('d-none')) {
    //     container.classList.remove('d-none');
        title.classList.remove('d-none');

        wrapper.classList.remove('text-center');
        wrapper.classList.add('text-end');
    //}

    const newGroup = document.createElement("div");
    newGroup.classList.add("skill-group", "mb-3");
    newGroup.dataset.index = skillIndex;

    newGroup.innerHTML = `
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Skills</label>
                <select name="skills[${skillIndex}][name]" class="form-control skill-select">
                    <option value="">Please Select Skill</option>
                    @foreach ($all_skills as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Years</label>
                <input type="number" name="skills[${skillIndex}][years]" placeholder="Years" class="form-control"
                       min="0" maxlength="2" oninput="limitInput(this)" onkeydown="blockInvalidKeys(event)" onpaste="return false;">
            </div>
            <div class="col-md-3">
                <label class="form-label">Months</label>
                <input type="number" name="skills[${skillIndex}][months]" placeholder="Months" class="form-control"
                       min="0" max="11" oninput="validateMonthInput(this)" onkeydown="blockInvalidKeys(event)" onpaste="return false;">
            </div>
            <div class="col-md-3 mt-4">
                <button type="button" class="btn btn-danger remove-skill" onclick="removeSkillField(this)">–</button>
            </div>
        </div>
    `;

    container.appendChild(newGroup);
    skillIndex++;

    updateSkillDropdowns(); // if needed
}

        window.removeSkillField = function (el) {
        const container = document.getElementById("skills-container");
        const skillGroups = container.querySelectorAll(".skill-group");
         el.closest('.skill-group').remove();


	    if (container.children.length === 0) {
	        // Hide again
	        document.getElementById('skill-title').classList.add('d-none');
	        container.classList.add('d-none');

	        const wrapper = document.getElementById('add-skill-btn-wrapper');
	        wrapper.classList.remove('text-end');
	        wrapper.classList.add('text-center');
	    }

        updateSkillDropdowns(); // 👈 update after removing
        }

        // Update dropdowns when a skill changes
        document.addEventListener('change', function (e) {
        if (e.target.classList.contains('skill-select')) {
            updateSkillDropdowns();
        }
        });

        updateSkillDropdowns(); // Run once on page load
    });
        document.addEventListener("DOMContentLoaded", function () {
            let documentIndex = {{ isset($employeeDocuments) ? count($employeeDocuments) : 1 }};

            // Function to disable already-selected doc types in all dropdowns
            function updateDocumentDropdowns() {
                const selectedDocs = [];

                // Collect selected values
                document.querySelectorAll('.doc-select').forEach(select => {
                    if (select.value) {
                        selectedDocs.push(select.value);
                    }
                });

                // Disable selected values in all doc dropdowns
                document.querySelectorAll('.doc-select').forEach(select => {
                    const currentValue = select.value;

                    select.querySelectorAll('option').forEach(option => {
                        if (selectedDocs.includes(option.value) && option.value !== currentValue) {
                            option.disabled = true;
                        } else {
                            option.disabled = false;
                        }
                    });
                });
            }

  
            document.getElementById('add-document').addEventListener('click', function () {
                const container = document.getElementById('document-container');
                
			    const title = document.getElementById('document-title');
			    const wrapper = document.getElementById('add-doc-btn-wrapper');

			        // Show title and container on first add
				    // if (container.classList.contains('d-none')) {
				    //     container.classList.remove('d-none');
				        title.classList.remove('d-none');

				        // Align button right
				        wrapper.classList.remove('text-center');
				        wrapper.classList.add('text-end');
				    //}

                const newGroup = document.createElement('div');
                newGroup.classList.add('document-group', 'mb-3');
                newGroup.style.border = '1px solid #ccc';
                newGroup.style.padding = '10px';
                newGroup.style.position = 'relative';

                // ✅ Set HTML first
                newGroup.innerHTML = `
                    <div class="removeDocument" onclick="removeDocument(this)" style="position:absolute; top:0px; right:5px; cursor:pointer;">×</div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Document Type</label>
                            <select name="documents[${documentIndex}][type]" class="form-control mb-2 doc-select" required>
                                <option value="">Please Select Document</option>
                                <option value="Resume">Resume</option>
                                <option value="VoterID">VoterID</option>
                                <option value="Adhaar">Adhaar</option>
                                <option value="PAN">PAN</option>
                                <option value="ProfileImage">ProfileImage</option>
                                <option value="Passport">Passport</option>
                                <option value="DrivingLicence">DrivingLicence</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Upload Document</label>
                            <input type="file" name="documents[${documentIndex}][file]" class="form-control document-file mb-2" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" onchange="validateDocumentFileSize(this)">
                        </div>
                    </div>
                `;

                // ✅ Now safe to query elements inside
                newGroup.querySelectorAll('.error').forEach(e => e.remove());
                newGroup.querySelectorAll('select, input[type="file"]').forEach((input) => {
                    input.value = '';
                    if (input.name.includes('[0]')) {
                        input.name = input.name.replace('[0]', `[${documentIndex}]`);
                    } else {
                        input.name = input.name.replace(/\[\d+\]/, `[${documentIndex}]`);
                    }
                });

                newGroup.querySelectorAll('.viewfileCurrent').forEach(view => view.remove());

                container.appendChild(newGroup);
                documentIndex++;

                updateDocumentDropdowns(); // if needed
            });

            // Remove document field
            window.removeDocument = function (element) {
                const group = element.closest('.document-group');
                const allGroups = document.querySelectorAll('.document-group');
                group.remove();

                const container = document.getElementById('document-container');
                if (container.children.length === 0) {
			        // Hide again when no documents left
			        document.getElementById('document-title').classList.add('d-none');
			        container.classList.add('d-none');

			        // Center the button again
			        document.getElementById('add-doc-btn-wrapper').classList.remove('text-end');
			        document.getElementById('add-doc-btn-wrapper').classList.add('text-center');
			    }


                updateDocumentDropdowns(); // 👈 Run after removing
            };

            // Update doc dropdowns when changed
            document.addEventListener('change', function (e) {
                if (e.target.classList.contains('doc-select')) {
                    updateDocumentDropdowns();
                }
            });

            updateDocumentDropdowns(); // Run on initial load
        });

    document.addEventListener("DOMContentLoaded", function () {
    let companyIndex = {{ isset($previousCompanies) ? count($previousCompanies) : 0 }};

    const wrapper = document.getElementById("previous-companies-wrapper");
    const title = document.getElementById("company-title");
    const buttonWrapper = document.getElementById("add-comapny-btn-wrapper");
    const addButton = document.getElementById("add-previous-company");

    if (addButton && wrapper && title && buttonWrapper) {
        addButton.addEventListener("click", function () {
            // Show on first click
            // if (wrapper.classList.contains('d-none')) {
            //     wrapper.classList.remove('d-none');
                title.classList.remove('d-none');
                buttonWrapper.classList.remove('text-center');
                buttonWrapper.classList.add('text-end');
            //}

            // Create group
            const group = document.createElement("div");
            group.classList.add("previous-company-group", "mb-3");
            group.dataset.index = companyIndex;

            group.innerHTML = `
                <div class="row g-3" style="border: 1px solid #ccc; padding: 10px; position: relative;">
                    <div class="remove-company" onclick="removeCompany(this)" style="position:absolute; top:0px; right:5px; cursor:pointer;">&times;</div>
                    <div class="col-md-5">
                        <label class="form-label">Company Name *</label>
                        <input type="text" name="previous_companies[${companyIndex}][company]" placeholder="Company Name" class="form-control mb-2">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Salary *</label>
                        <input type="number" name="previous_companies[${companyIndex}][salary]" placeholder="Salary" class="form-control mb-2" min="0">
                    </div>
                </div>`;
            
            wrapper.appendChild(group);
            companyIndex++;
        });

        // Remove handler
        wrapper.addEventListener("click", function (e) {
            if (e.target.classList.contains("remove-company")) {
                const group = e.target.closest(".previous-company-group");
                if (group) group.remove();

                // Reset layout if no groups
                if (wrapper.children.length === 0) {
                    wrapper.classList.add('d-none');
                    title.classList.add('d-none');
                    buttonWrapper.classList.remove('text-end');
                    buttonWrapper.classList.add('text-center');
                }
            }
        });
    }

    // Fallback remove function (for inline onclick)
	    window.removeCompany = function (btn) {
	        const group = btn.closest('.previous-company-group');
	        if (group) group.remove();

	        if (wrapper.children.length === 0) {
	            wrapper.classList.add('d-none');
	            title.classList.add('d-none');
	            buttonWrapper.classList.remove('text-end');
	            buttonWrapper.classList.add('text-center');
	        }
	    };
	});
		document.addEventListener('DOMContentLoaded', function () {
		flatpickr("#dob, #celb_dob", {
		dateFormat: "Y-m-d",    // e.g., 2025-06-16
		maxDate: "today",       // 👈 disables future dates
		altInput: true,
		altFormat: "Y-m-d",    // e.g., June 16, 2025
		allowInput: true,
		});

		flatpickr("input[type='date']", {
		dateFormat: "Y-m-d",
		altInput: true,
		altFormat: "Y-m-d",    // e.g., June 16, 2025
		allowInput: true,
		});
		});

</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const checkbox = document.getElementById("sameAsPermanent");

    if (!checkbox) {
        console.error("Checkbox with ID 'sameAsPermanent' not found.");
        return;
    }

    //console.log("Checkbox found. Setting up listener...");

    checkbox.addEventListener("change", function () {
        //console.log("Checkbox changed. Checked?", this.checked);
        
        const fields = ["address", "state", "city", "zip"];

        fields.forEach(function (field) {
            const perm = document.querySelector('[name="' + field + '_perm"]');
            const local = document.querySelector('[name="' + field + '_local"]');

            if (perm && local) {
                if (checkbox.checked) {
                    local.value = perm.value;
                    local.setAttribute("readonly", true);
                } else {
                    local.value = "";
                    local.removeAttribute("readonly");
                }
            } else {
                console.warn("Missing field:", field);
            }
        });
    });

});

    document.addEventListener('DOMContentLoaded', function () {
        const indianStates = [
            "Andhra Pradesh", "Arunachal Pradesh", "Assam", "Bihar", "Chhattisgarh",
            "Goa", "Gujarat", "Haryana", "Himachal Pradesh", "Jharkhand",
            "Karnataka", "Kerala", "Madhya Pradesh", "Maharashtra", "Manipur",
            "Meghalaya", "Mizoram", "Nagaland", "Odisha", "Punjab",
            "Rajasthan", "Sikkim", "Tamil Nadu", "Telangana", "Tripura",
            "Uttar Pradesh", "Uttarakhand", "West Bengal", "Andaman and Nicobar Islands",
            "Chandigarh", "Dadra and Nagar Haveli and Daman and Diu", "Delhi", "Jammu and Kashmir",
            "Ladakh", "Lakshadweep", "Puducherry"
        ];

        const populateStates = (selectId) => {
            const select = document.getElementById(selectId);
            if (!select) return;

            // Clear existing options (if any)
            select.innerHTML = '';

            // Add default option
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Select State *';
            select.appendChild(defaultOption);

            // Add state options
            indianStates.forEach(state => {
                const option = document.createElement('option');
                option.value = state;
                option.textContent = state;
                select.appendChild(option);
            });
        };

        // Call for both dropdowns
        populateStates('state_local');
        populateStates('state_perm');

        // EMERGENCY CONTACT LIST
         const errorDiv = document.getElementById('emergency-error');
		    if (errorDiv) errorDiv.textContent = ''; // Clear previous error

			document.addEventListener('click', function (e) {
		   
		    // ADD contact
		    if (e.target.classList.contains('addMore')) {
		        const container = document.getElementById('emergency-container');
		        const groups = container.querySelectorAll('.emergency-group');

		        if (groups.length >= 2) {
		            if (errorDiv) errorDiv.textContent = 'Only 2 emergency contacts are allowed.';
		            return;
		        }

		        const original = container.querySelector('.emergency-group');
		        const newGroup = original.cloneNode(true);

		        newGroup.querySelectorAll('input').forEach(input => input.value = '');

		        newGroup.querySelector('input[name*="[name]"]').name = `emergency_contacts[${groups.length}][name]`;
		        newGroup.querySelector('input[name*="[relation]"]').name = `emergency_contacts[${groups.length}][relation]`;
		        newGroup.querySelector('input[name*="[phone]"]').name = `emergency_contacts[${groups.length}][phone]`;

		        const addBtn = newGroup.querySelector('.addMore');
		        if (addBtn) addBtn.remove();

		        const buttonCol = newGroup.querySelector('.col-md-3.mt-5');
		        if (buttonCol) {
		            const removeBtn = document.createElement('button');
		            removeBtn.type = 'button';
		            removeBtn.className = 'btn btn-danger removeContact';
		            removeBtn.textContent = '-';
		            buttonCol.appendChild(removeBtn);
		        }

		        container.appendChild(newGroup);
		    }

		    // REMOVE contact
		    if (e.target.classList.contains('removeContact')) {
		        const groups = document.querySelectorAll('.emergency-group');
		        if (groups.length > 1) {
		            e.target.closest('.emergency-group').remove();
		        } else {
		            if (errorDiv) errorDiv.textContent = 'At least one emergency contact is required.';
		        }
		    }
		});


    });
$(document).on('change', '.doc-select', function () {
    const selectedValue = $(this).val()?.trim();
    const container = $(this).closest('.document-group');

    if (selectedValue === '') {
        // Remove the current file preview
        container.find('.viewfileCurrent').remove();
        // Optionally also remove hidden existing_file input
        container.find('input[name*="[existing_file]"]').remove();
    }
});
</script>

<script>
function limitInput(input) {
    // Allow only max 2 digits
    if (input.value.length > 2) {
        input.value = input.value.slice(0, 2);
    }
}

function validateMonthInput(input) {
    let value = input.value;

    // Remove non-digit characters (just in case)
    value = value.replace(/\D/g, '');

    // Limit to 2 digits
    if (value.length > 2) {
        value = value.slice(0, 2);
    }

    // Limit to max 11
    const numericValue = parseInt(value, 10);
    if (numericValue > 11) {
        value = '11';
    }

    input.value = value;
}

function blockInvalidKeys(e) {
    const invalidChars = ['-', '+', 'e', 'E', '.'];
    if (invalidChars.includes(e.key)) {
        e.preventDefault();
    }
}
</script>
<script>
function validateDocumentFileSize(input) {
    const maxSizeKB = 2048; // 2 MB
    const errorClass = 'file-size-error';

    // Remove existing error message if present
    $(input).next(`.${errorClass}`).remove();

    if (input.files && input.files.length > 0) {
        const file = input.files[0];
        const fileSizeKB = file.size / 1024;

        if (fileSizeKB > maxSizeKB) {
            $(input).after(`<span class="${errorClass} text-danger">File size must be 2MB or less.</span>`);
            input.value = ''; // clear the invalid file
        }
    }
}
</script>


@endsection
