@extends('layouts.app')

@section('content')

    @php
        
    $all_skills = config('hrp.skills_list');
        $candidateSkills = old('skills', $candiadte->skills ?? []);
    @endphp 

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h2 mb-0">Candidates</h2>
        <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#candidateModal">
        + Add Candidate
        </button>
    </div>

     @if(session('success') && session('title'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: @json(session('title')) + '!',
                text: @json(session('success')),
                timer: 3000,
                showConfirmButton: false
            });
        });
    </script>
    @endif

    <!-- Filter Of Candidates -->
    <form id="filterForm" class="mb-4 p-4 bg-white rounded shadow-sm">
        <div class="row align-items-end">
            <div class="col-md-3">
                <label for="skills" class="form-label fw-semibold">Skills:</label>
                <select name="skills[]" id="skills" class="form-select" multiple>
                    @foreach ($all_skills as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="stream" class="form-label fw-semibold">Profile:</label>
                <select name="stream" id="stream" class="form-select">
                    <option value="">Please Select</option>
                    <option value=".NET">.NET</option>
                    <option value="PHP">PHP</option>
                    <option value="WordPress">WordPress</option>
                    <option value="Sales">Sales</option>
                    <option value="HR">HR</option>
                    <option value="Designer">Designer</option>
                    <option value="Flutter">Flutter</option>
                    <option value="Others">Others</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="lead_source" class="form-label fw-semibold">Candidate Source:</label>
                <select name="lead_source" id="lead_source" class="form-select">
                    <option value="">Please Select</option>
                    <option value="LinkedIn">LinkedIn</option>
                    <option value="Facebook">Facebook</option>
                    <option value="Naukri">Naukri</option>
                    <option value="Reference">Reference</option>
                    <option value="Walk-In">Walk-In</option>
                </select>
            </div>
            <div class="form-group col-md-3 gap-3 d-flex justify-content-end align-items-center custom-margin">
                <div class="col-md-6">
                    <button type="submit" class="w-100 btn btn-primary button-equal-width" id="filterSub">Filter</button>
                </div>
                <div class="col-md-6">
                    <button type="button" class="w-100 btn btn-secondary button-equal-width" id="clearform">Clear</button>
                </div>
            </div>
        </div>
    </form>

    <!-- delete candidate show -->

    <form id="deleteCandidateform">
        <div class="row g-2 justify-content-end align-items-center">
            <div class="col-auto">
                <label>
                    <input type="checkbox"
                           name="isdeleted"
                           value="1"
                           id="isdeleted"
                           {{ request('isdeleted') ? 'checked' : '' }}>
                    Show Deleted Candidate
                </label>
            </div>
        </div>
    </form>
    {{-- Candidate Table --}}
    <div id="candidateList">
        <table class="table table-bordered mb-0" id="usersTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Experience</th>
                    <th>Profile</th>
                    <th class="skillsTh" width="195px">Skills</th>
                    <th>Candidate Source</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($candidates->count())
                    @forelse($candidates as $candidate)
                        <tr>
                            <td>{{ $candidate->first_name }} {{ $candidate->last_name }}</td>
                            <td>@php
                                    $years = $candidate->total_experience_years ?? 0;
                                    $months = $candidate->total_experience_months ?? 0;
                                @endphp
                                {{ ($years > 0 ? $years . ' Year' . ($years > 1 ? 's' : '') : '') }}
                                {{ ($months > 0 ? $months . ' Month' . ($months > 1 ? 's' : '') : '') }}
                                @if($years == 0 && $months == 0)
                                    -
                                @endif</td>
                            <td>{{ $candidate->stream ?? '-' }}</td>
                            <td>
                                @php
                                    $skillNames = [];
                                    $skillsRaw = $candidate->skills ?? [];
                                    $skillsArray = is_string($skillsRaw) ? json_decode($skillsRaw, true) : $skillsRaw;

                                    if (is_array($skillsArray)) {
                                        foreach ($skillsArray as $skill) {
                                            $id = $skill['name'] ?? null;
                                            if ($id && isset($all_skills[$id])) {
                                                $skillNames[] = $all_skills[$id];
                                            }
                                        }
                                    }
                                @endphp
                                {{ $skillNames ? implode(', ', $skillNames) : '-' }}
                            </td>
                            <td>{{ $candidate->candidate_source ?? '-' }}</td>
                            <td>{{ $candidate->phone_number ?? '-' }}</td>
                            <td class="flexTd">
                                @if($candidate->is_deleted != 1)
                                    <a href="javascript:void(0);"
                                       class="btn btn-sm btn-warning text-white editCandidateBtn"
                                       data-id="{{ $candidate->id }}">
                                        <i class="bi bi-pencil" title="Edit"></i>
                                    </a>
                                @endif

                                <button type="button"
                                    class="btn btn-info btn-sm view-candidate-btn"
                                    data-id="{{ $candidate->id }}">
                                    <i class="bi bi-eye"></i>
                                </button>

                                @if($candidate->is_deleted == 1)
                                    <button type="button" class="btn btn-sm btn-danger disabled" disabled>
                                        <i class="bi bi-trash" title="Deleted"></i>
                                    </button>
                                @else
                                    <form action="{{ route('candidates.destroy', $candidate->id) }}" id="deleteForm-{{ $candidate->id }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $candidate->id }})">
                                            <i class="bi bi-trash" title="Delete"></i>
                                        </button>
                                    </form>
                                @endif

                                @if($candidate->resume_path)
                                    <a href="{{ asset('storage/' . $candidate->resume_path) }}"
                                       download
                                       class="btn btn-sm btn-warning text-white text-decoration-none"
                                       title="Download Resume">
                                        <i class="bi bi-download"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-center">No candidates found.</td>
                            <td></td>
                            <td></td>
                            <td></td>

                        </tr>
                    @endforelse
                @else
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-center">No candidates found.</td>
                        <td></td>
                        <td></td>
                        <td></td>

                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>


<!-- Add Candidate Modal -->
<div class="modal fade" id="candidateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable p-5">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h5">Add Candidate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="candidateForm" method="POST" action="{{ route('candidates.store') }}" enctype="multipart/form-data" novalidate>
                 

                        <div class="row g-3">
                            <!-- Basic Fields -->
                            <div class="col-md-6">
                                <label class="form-label">First Name *</label>
                                <input type="text" name="first_name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name *</label>
                                <input type="text" name="last_name" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Email *</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Phone Number *</label>
                                <input type="text" name="phone_number" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Alternate Phone Number</label>
                                <input type="text" name="alternate_phone_number" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Current Company</label>
                                <input type="text" name="current_company" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Total Experience (Years)</label>
                                <input type="number" name="total_experience_years" class="form-control" min="0" 
                               maxlength="2" 
                               oninput="limitInput(this)" 
                               onkeydown="blockInvalidKeys(event)" onpaste="return false;">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Total Experience (Months)</label>
                                <input type="number" name="total_experience_months" class="form-control" min="0" max="11"
                               oninput="validateMonthInput(this)" 
                               onkeydown="blockInvalidKeys(event)" onpaste="return false;">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">CTC (Per month)</label>
                                <input type="number" min="0" step="0.01" name="ctc_per_month" class="form-control" onkeydown="blockInvalidKeys(event)" onpaste="return false;">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">ECTC (Per month) *</label>
                                <input type="number" min="0" step="0.01" name="ectc_per_month" class="form-control" onkeydown="blockInvalidKeys(event)" onpaste="return false;">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Reason</label>
                                <input type="text" name="reason" id="reason" class="form-control">
                            </div>
                        </div>

                        <div class="row g-3 mt-3">
                            <!-- Salary Negotiable -->
                            <div class="col-md-4">
                                <div class="form-check mt-4">
                                    <input type="checkbox" name="is_salary_negotiable" id="salaryNegotiableCheck" class="form-check-input">
                                    <label class="form-check-label" for="salaryNegotiableCheck">Salary Negotiable?</label>
                                </div>
                            </div>
                            <div class="col-md-4 salary-negotiable-field d-none">
                                <label class="form-label">Salary Negotiable Note</label>
                                <input type="text" name="salary_negotiable" class="form-control">
                            </div>

                            <!-- Notice Period -->
                            <div class="col-md-4">
                                <label class="form-label">Notice Period (Days)</label>
                                <input type="number" name="notice_period_days" class="form-control" min="0">
                            </div>
                        </div>
                        <div class="row g-3 mt-3">
                            <div class="col-md-4">
                                <div class="form-check mt-4">
                                    <input type="checkbox" name="is_notice_negotiable" id="noticeNegotiableCheck" class="form-check-input">
                                    <label class="form-check-label" for="noticeNegotiableCheck">Notice Negotiable?</label>
                                </div>
                            </div>
                            <div class="col-md-4 notice-negotiable-field d-none">
                                <label class="form-label">Notice Negotiable (Days)</label>
                                <input type="number" name="notice_negotiable_days" class="form-control" min="0">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">LinkedIn URL</label>
                                <input type="url" name="linkedin_url" class="form-control">
                            </div>
                        </div>
                        <div class="row g-3 mt-3">
                            <div class="col-md-4">
                                <label class="form-label">Candidate Source *</label>
                                <select class="select form-control form-select txt-required  custom-border" data-val="true" data-val-required="candidate source  is required." id="candidate_source" name="candidate_source">
                                    <option value="">Please Select</option>
                                    <option value="LinkedIn">LinkedIn</option>
                                    <option value="Facebook">Facebook</option>
                                    <option value="Naukri">Naukri</option>
                                    <option value="Reference">Reference</option>
                                    <option value="Walk-In">Walk-In</option>
                                </select>
                            </div>
                              <div class="col-md-4">
                                <label class="form-label">Current Designation</label>
                                <select class="select form-control form-select custom-border" id="current_designation" name="current_designation">
                                    <option value="">Please Select</option>
                                    <option value="Team Leader">Team Leader</option>
                                    <option value="Software Engineer">Software Engineer</option>
                                    <option value="Senior">Senior</option>
                                    <option value="Junior">Junior</option>
                                    <option value="Mid-Level">Mid-Level</option>
                                    <option value="Project Manager">Project Manager</option>
                                    <option value="UI/UX Designer">UI/UX Designer</option>
                                    <option value="QA Engineer">QA Engineer</option>
                                    <option value="HR Executive">HR Executive</option> 
                                    <option value="BDE">BDE</option>
                                    <option value="Business Analyst">Business Analyst</option>
                                    <option value="Intern">Intern</option>
                                    <option value="Trainee">Trainee</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Applied Designation *</label>
                                <select class="select form-control form-select custom-border txt-required" data-val="true" data-val-required="Applied designation is required." id="applied_designation" name="applied_designation">
                                    <option value="">Please Select</option>
                                    <option value="Team Leader">Team Leader</option>
                                    <option value="Software Engineer">Software Engineer</option>
                                    <option value="Senior">Senior</option>
                                    <option value="Junior">Junior</option>
                                    <option value="Mid-Level">Mid-Level</option>
                                    <option value="Project Manager">Project Manager</option>
                                    <option value="UI/UX Designer">UI/UX Designer</option>
                                    <option value="QA Engineer">QA Engineer</option>
                                    <option value="HR Executive">HR Executive</option> 
                                    <option value="BDE">BDE</option>
                                    <option value="Business Analyst">Business Analyst</option>
                                    <option value="Intern">Intern</option>
                                    <option value="Trainee">Trainee</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Profile *</label>
                                <select class="select form-control form-select custom-border txt-required" data-val="true" data-val-required="Stream  is required." id="stream" name="stream">
                                    <option value="">Please Select</option>
                                    <option value=".NET">.NET</option>
                                    <option value="PHP">PHP</option>
                                    <option value="WordPress">WordPress</option>
                                    <option value="Sales">Sales</option>
                                    <option value="HR">HR</option>
                                    <option value="Designer">Designer</option>
                                    <option value="Flutter">Flutter</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Remark</label>
                                <input type="text" name="remark" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Upload Resume</label>
                                <input type="file" name="resume" class="form-control" accept=".pdf,.doc,.docx">
                            </div>

                            <!-- Skills -->
                            <div class="col-12 mt-4">
                                <div id="skillsContainer"></div>
                                <button type="button" class="btn btn-sm btn-outline-danger mt-2" id="addSkillBtn">+ Add Skill</button>
                            </div>
                        </div>
                    

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Save Candidate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Edit Candidate -->
<div class="modal fade" id="EditcandidateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable p-5">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h5">Add Candidate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="EditcandidateForm" method="POST" action="" enctype="multipart/form-data" novalidate>

                     <input type="hidden" name="id" id="candidateId">
                  

                        <div class="row g-3">
                            <!-- Basic Fields -->
                            <div class="col-md-6">
                                <label class="form-label">First Name *</label>
                                <input type="text" name="first_name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name *</label>
                                <input type="text" name="last_name" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Email *</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Phone Number *</label>
                                <input type="text" name="phone_number" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Alternate Phone Number</label>
                                <input type="text" name="alternate_phone_number" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Current Company</label>
                                <input type="text" name="current_company" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Total Experience (Years)</label>
                                <input type="number" name="total_experience_years" class="form-control" min="0" 
                               maxlength="2" 
                               oninput="limitInput(this)" 
                               onkeydown="blockInvalidKeys(event)" onpaste="return false;">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Total Experience (Months)</label>
                                <input type="number" name="total_experience_months" class="form-control" min="0" max="11"
                               oninput="validateMonthInput(this)" 
                               onkeydown="blockInvalidKeys(event)" onpaste="return false;">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">CTC (Per month)</label>
                                <input type="number" min="0" step="0.01" name="ctc_per_month" class="form-control" onkeydown="blockInvalidKeys(event)" onpaste="return false;">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">ECTC (Per month) *</label>
                                <input type="number" min="0" step="0.01" name="ectc_per_month" class="form-control" onkeydown="blockInvalidKeys(event)" onpaste="return false;">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Reason</label>
                                <input type="text" name="reason" id="reason" class="form-control">
                            </div>

                        </div>

                        <div class="row g-3 mt-3">
                            <!-- Salary Negotiable -->
                            <div class="col-md-4">
                                <div class="form-check mt-4">
                                    <input type="checkbox" name="is_salary_negotiable" id="Edit_salaryNegotiableCheck" class="form-check-input">
                                    <label class="form-check-label" for="Edit_salaryNegotiableCheck">Salary Negotiable?</label>
                                </div>
                            </div>
                            <div class="col-md-4 salary-negotiable-field d-none">
                                <label class="form-label">Salary Negotiable Note</label>
                                <input type="text" name="salary_negotiable" class="form-control">
                            </div>

                            <!-- Notice Period -->
                            <div class="col-md-4">
                                <label class="form-label">Notice Period (Days)</label>
                                <input type="number" name="notice_period_days" class="form-control" min="0">
                            </div>
                        </div>
                        <div class="row g-3 mt-3">
                            <div class="col-md-4">
                                <div class="form-check mt-4">
                                    <input type="checkbox" name="is_notice_negotiable" id="Edit_noticeNegotiableCheck" class="form-check-input">
                                    <label class="form-check-label" for="Edit_noticeNegotiableCheck">Notice Negotiable?</label>
                                </div>
                            </div>
                            <div class="col-md-4 notice-negotiable-field d-none">
                                <label class="form-label">Notice Negotiable (Days)</label>
                                <input type="number" name="notice_negotiable_days" class="form-control" min="0">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">LinkedIn URL</label>
                                <input type="url" name="linkedin_url" class="form-control">
                            </div>
                        </div>
                        <div class="row g-3 mt-3">
                            <div class="col-md-4">
                                <label class="form-label">Candidate Source *</label>
                                <select class="select form-control form-select txt-required  custom-border" id="candidate_source" name="candidate_source" required>
                                    <option value="">Please Select</option>
                                    <option value="LinkedIn">LinkedIn</option>
                                    <option value="Facebook">Facebook</option>
                                    <option value="Naukri">Naukri</option>
                                    <option value="Reference">Reference</option>
                                    <option value="Walk-In">Walk-In</option>
                                </select>
                            </div>
                              <div class="col-md-4">
                                <label class="form-label">Current Designation</label>
                                <select class="select form-control form-select custom-border" id="current_designation" name="current_designation">
                                    <option value="">Please Select</option>
                                    <option value="Team Leader">Team Leader</option>
                                    <option value="Software Engineer">Software Engineer</option>
                                    <option value="Senior">Senior</option>
                                    <option value="Junior">Junior</option>
                                    <option value="Mid-Level">Mid-Level</option>
                                    <option value="Project Manager">Project Manager</option>
                                    <option value="UI/UX Designer">UI/UX Designer</option>
                                    <option value="QA Engineer">QA Engineer</option>
                                    <option value="HR Executive">HR Executive</option> 
                                    <option value="BDE">BDE</option>
                                    <option value="Business Analyst">Business Analyst</option>
                                    <option value="Intern">Intern</option>
                                    <option value="Trainee">Trainee</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Applied Designation *</label>
                                <select class="select form-control form-select custom-border txt-required" data-val="true" data-val-required="Applied designation is required." id="applied_designation" name="applied_designation">
                                    <option value="">Please Select</option>
                                    <option value="Team Leader">Team Leader</option>
                                    <option value="Software Engineer">Software Engineer</option>
                                    <option value="Senior">Senior</option>
                                    <option value="Junior">Junior</option>
                                    <option value="Mid-Level">Mid-Level</option>
                                    <option value="Project Manager">Project Manager</option>
                                    <option value="UI/UX Designer">UI/UX Designer</option>
                                    <option value="QA Engineer">QA Engineer</option>
                                    <option value="HR Executive">HR Executive</option> 
                                    <option value="BDE">BDE</option>
                                    <option value="Business Analyst">Business Analyst</option>
                                    <option value="Intern">Intern</option>
                                    <option value="Trainee">Trainee</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Profile *</label>
                                <select class="select form-control form-select custom-border txt-required" data-val="true" data-val-required="Stream  is required." id="stream" name="stream">
                                    <option value="">Please Select</option>
                                    <option value=".NET">.NET</option>
                                    <option value="PHP">PHP</option>
                                    <option value="WordPress">WordPress</option>
                                    <option value="Sales">Sales</option>
                                    <option value="HR">HR</option>
                                    <option value="Designer">Designer</option>
                                    <option value="Flutter">Flutter</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Remark</label>
                                <input type="text" name="remark" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Upload Resume</label>
                                <input type="file" name="resume" class="form-control" accept=".pdf,.doc,.docx">

                                 <div id="existingResumeContainer" class="mt-2"></div>
                            </div>

                            <!-- Skills -->
                            <div class="col-12 mt-4">
                                <div id="Edit_skillsContainer"></div>
                                <button type="button" class="btn btn-sm btn-outline-danger mt-2" id="Edit_addSkillBtn">+ Add Skill</button>
                            </div>
                        </div>
                    

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Save Candidate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- View Candidate Modal -->
<div class="modal fade" id="viewCandidateModal" tabindex="-1" aria-labelledby="viewCandidateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-3 shadow">
            <div class="modal-header">
                <h5 class="modal-title h5" id="viewCandidateModalLabel">Candidate Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Content populated dynamically -->
                <div id="candidateDetails"></div>
            </div>
        </div>
    </div>
</div>


<style>
        /* Hide number input arrows cross-browser */
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }


    .select2-container--default .select2-selection--multiple {
        border: 1px solid #dfe5ef !important;
        padding-bottom: 15px;
    }

    #deleteCandidateform {
        position: absolute;
        left: 0;
        right: 310px;
        margin-top: 10px;
    }    
    .dataTables_wrapper .row:first-child div{
        z-index: 1;
        width: auto;
    }
    .dataTables_wrapper .row:first-child{
       justify-content: space-between;
    }
    .select2-container--default .select2-selection--multiple {
        position: relative;
    }
    /* Default arrow for Select2 multiselect */
    .select2-container--default .select2-selection--multiple::after {
        content: '';
        position: absolute;
        top: 50%;
        right: 8px;
        width: 16px;
        height: 16px;
        background: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2311142d' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") no-repeat center center;
        background-size: 12px;
        transform: translateY(-50%);
        pointer-events: none;
    }

    /* When .has-clear is present, shift arrow left to avoid overlap */
    .select2-container--default .select2-selection--multiple.has-clear::after {
        background:transparent;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice:nth-child(5n+2) {
        background: #1bcfb4;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice:nth-child(5n+3) {
        background: #198ae3;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice:nth-child(5n+4) {
        background: #fe7c96;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice:nth-child(5n+5) {
        background: #fed713;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice:nth-child(5n+1) {
        background: #b66dff;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        color: #ffffff;
        border: 0;
        border-radius: 3px;
        padding: 6px;
        font-size: 0.625rem;
        font-family: inherit;
        line-height: 1;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice .select2-selection__choice__remove {
        font-size: 1.2em;
        line-height: 1;
        margin-right: 5px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice .select2-selection__choice__remove {
        color: #ffffff;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__display {
        padding-left: 9px;
        padding-right: 5px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        left: 0px;
        top: 6px;
    }
</style>

<script>
    const allSkills = @json($all_skills);

$(document).ready(function () {
    // ✅ Initial DataTable setup

    $('#usersTable').DataTable();

    $('#clearform').on('click', function() {

        // If #isdeleted is checked, skip clearing
        if ($('#isdeleted').is(':checked')) {
            return;
        }

        // Only clear #filterForm, not #deleteCandidateForm
        $('#skills').val(null).trigger('change'); // clear Select2
        $('#filterForm')[0].reset();


        // Check if form had any filters before reloading
        let hasFilters = false;
        $('#filterForm').find('input, select, textarea').each(function() {
            if ($(this).val()) {
                hasFilters = true;
                return false; // exit .each early
            }
        });

        if (hasFilters) {
            $('.ApWait').show();

            $.ajax({
                url: "{{ route('candidates.index') }}",
                type: "GET",
                success: function(response) {
                    $('.ApWait').hide();
                    console.log('Reset to default:', response);

                    const newHtml = $('<div>').html(response).find('#candidateList').html();
                    $('#candidateList').html(newHtml);

                    // Reinitialize DataTable
                    if ($.fn.DataTable.isDataTable('#usersTable')) {
                        $('#usersTable').DataTable().destroy();
                    }
                    $('#usersTable').DataTable({
                        paging: true,
                        searching: true,
                        ordering: true,
                        info: true,
                        columnDefs: [
                            { orderable: true, targets: 0 },
                            { orderable: false, targets: '_all' }
                        ]
                    });
                },
                error: function(xhr, status, error) {
                    $('.ApWait').hide();
                    console.error("AJAX error on reset:", error);
                    Swal.fire('Error', 'Unable to reset candidates list.', 'error');
                }
            });
        } else {
            
        }
    });


    function filterCandidate(e) {
        e.preventDefault(); // prevent form from reloading page
        $('#deleteCandidateform')[0].reset();
        let formData = $('#filterForm').serialize();
        $('.ApWait').show();

        $.ajax({
            url: "{{ route('candidates.index') }}",
            type: "GET", // using GET so filters appear in URL
            data: formData,
            success: function (response) {
                $('.ApWait').hide();
                console.log(response);
                // Replace the table body cleanly
                const newHtml = $('<div>').html(response).find('#candidateList').html();
                $('#candidateList').html(newHtml);

                // Reinitialize DataTable
                if ($.fn.DataTable.isDataTable('#usersTable')) {
                    $('#usersTable').DataTable().destroy();
                }
                $('#usersTable').DataTable({
                    paging: true,       // Enable pagination
                    searching: true,    // Enable search box
                    ordering: true,     // Enable column sorting
                    info: true,         // Show info text ("Showing 1 to 5 of 10 entries")
                    columnDefs: [
                        { orderable: true, targets: 0 },              // Enable ordering on first column
                        { orderable: false, targets: '_all' }         // Disable ordering on all other columns
                    ]          
                  });
            },
            error: function (xhr, status, error) {
                $('.ApWait').hide();
                console.error("AJAX error:", error);
                Swal.fire('Error', 'Unable to load filtered candidates.', 'error');
            }
        });
    }

     function filterisdeleted(e) {
        e.preventDefault(); // prevent form from reloading page
         $('#skills').val(null).trigger('change'); // clear Select2
        $('#filterForm')[0].reset();
        let formData = $('#deleteCandidateform').serialize();
        $('.ApWait').show();

        $.ajax({
            url: "{{ route('candidates.index') }}",
            type: "GET", // using GET so filters appear in URL
            data: formData,
            success: function (response) {
                $('.ApWait').hide();
                console.log(response);
                // Replace the table body cleanly
                const newHtml = $('<div>').html(response).find('#candidateList').html();
                $('#candidateList').html(newHtml);

                // Reinitialize DataTable
                if ($.fn.DataTable.isDataTable('#usersTable')) {
                    $('#usersTable').DataTable().destroy();
                }
                $('#usersTable').DataTable({
                    paging: true,       // Enable pagination
                    searching: true,    // Enable search box
                    ordering: true,     // Enable column sorting
                    info: true,         // Show info text ("Showing 1 to 5 of 10 entries")
                    columnDefs: [
                        { orderable: true, targets: 0 },              // Enable ordering on first column
                        { orderable: false, targets: '_all' }         // Disable ordering on all other columns
                    ]          
                  });
            },
            error: function (xhr, status, error) {
                $('.ApWait').hide();
                console.error("AJAX error:", error);
                Swal.fire('Error', 'Unable to load filtered candidates.', 'error');
            }
        });
    }

    // ✅ Bind filter on submit only, not on change
    $('#filterForm').on('submit', filterCandidate);

    $('#isdeleted').on('change', filterisdeleted);
});


</script>

<script>
$(document).ready(function(){
    function toggleArrowPadding() {
        $('.select2-selection--multiple').each(function(){
            if ($(this).find('.select2-selection__clear').length) {
                $(this).addClass('has-clear');
            } else {
                $(this).removeClass('has-clear');
            }
        });
    }

    toggleArrowPadding();

    // Trigger on clear click or selection changes
    $(document).on('click', '.select2-selection__clear', function(){
        setTimeout(toggleArrowPadding, 50);
    });
    $('#skills').on('change', function(){
        setTimeout(toggleArrowPadding, 50);
    });
});
</script>

<script>


document.addEventListener('DOMContentLoaded', function () {
    const viewModal = new bootstrap.Modal(document.getElementById('viewCandidateModal'));
    const candidateDetails = document.getElementById('candidateDetails');

            
                    document.addEventListener('click', function (e) {
                const target = e.target.closest('.view-candidate-btn');
                if (!target) return; 
                    const candidateId = target.dataset.id;

                    fetch(`${HRP_URL}candidates/${candidateId}`)
                        .then(response => response.json())
                        .then(data => {
                            const c = data.candidate;

                            let skillsArray = [];
                            if (c.skills) {
                                if (Array.isArray(c.skills)) {
                                    skillsArray = c.skills;
                                } else if (typeof c.skills === 'string' && c.skills.trim() !== '') {
                                    try {
                                        const parsed = JSON.parse(c.skills);
                                        if (Array.isArray(parsed)) skillsArray = parsed;
                                    } catch (e) {
                                        console.error("Skills JSON parse error", e);
                                    }
                                }
                                skillsArray = skillsArray.filter(skill =>
                                    (skill.name && skill.name !== '0' && skill.name !== '') ||
                                    (skill.exp_years && skill.exp_years !== '0') ||
                                    (skill.exp_months && skill.exp_months !== '0')
                                );
                            }

                            let skillsHtml = skillsArray.length ? skillsArray.map(skill => {
                                let skillName = allSkills[skill.name] ?? skill.name ?? '';
                                let years = skill.exp_years ?? 0;
                                let months = skill.exp_months ?? 0;

                                let skillexpParts = [];
                                if (years > 0) skillexpParts.push(`${years}y`);
                                if (months > 0) skillexpParts.push(`${months}m`);
                                let expDisplay = skillexpParts.length ? ` (${skillexpParts.join(' ')})` : '';

                                return `<span class="badge bg-primary me-1 mb-1">${skillName}${expDisplay}</span>`;
                            }).join('') : '';

                            let expYears = c.total_experience_years ?? 0;
                            let expMonths = c.total_experience_months ?? 0;
                            let expParts = [];
                            if (expYears > 0) expParts.push(`${expYears} Year${expYears > 1 ? 's' : ''}`);
                            if (expMonths > 0) expParts.push(`${expMonths} Month${expMonths > 1 ? 's' : ''}`);
                            let totalExpHtml = expParts.length ? `
                                <div class="col-md-6">
                                    <p class="text-dark fw-bold">Total Experience</p>
                                    <div>${expParts.join(' ')}</div>
                                </div>
                            ` : '';

                            const fields = [
                                { label: 'Email', value: c.email },
                                { label: 'Phone', value: c.phone_number },
                                { label: 'Alternate Phone', value: c.alternate_phone_number },
                                { label: 'Current Company', value: c.current_company },
                                { label: 'Designation', value: c.current_designation },
                                { label: 'Applied Designation', value: c.applied_designation },
                                { label: 'CTC', value: c.ctc_per_month ? `₹${c.ctc_per_month}/month` : '' },
                                { label: 'ECTC', value: c.ectc_per_month ? `₹${c.ectc_per_month}/month` : '' },
                                { label: 'Notice Period', value: c.notice_period_days ? `${c.notice_period_days} days` : '' },
                                { label: 'Notice Negotiable Days', value: c.notice_negotiable_days },
                                { label: 'Salary Negotiable Note', value: c.salary_negotiable },
                                { label: 'Remark', value: c.remark },
                                { label: 'Reason Job Change', value: c.reason },
                            ];

                            let fieldsHtml = fields.map(f => {
                                if (f.value && f.value !== '0') {
                                    return `
                                        <div class="col-md-6">
                                            <p class="text-dark fw-bold">${f.label}</p>
                                            <div>${f.value}</div>
                                        </div>
                                    `;
                                }
                                return '';
                            }).join('');

                            let linkedinHtml = '';
                            if (c.linkedin_url && c.linkedin_url.trim() !== '') {
                                linkedinHtml = `
                                    <div class="col-md-6">
                                        <p class="text-dark fw-bold">LinkedIn</p>
                                        <div>
                                            <a href="${c.linkedin_url}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill">
                                                <i class="bi bi-linkedin me-1"></i> View LinkedIn Profile
                                            </a>
                                        </div>
                                    </div>
                                `;
                            }

                            let resumeHtml = '';
                            if (c.resume_path) {
                                resumeHtml = `
                                    <div class="col-md-6">
                                        <p class="text-dark fw-bold">Resume</p>
                                        <div>
                                            <a href="${HRP_URL}storage/${c.resume_path}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill">
                                                <i class="bi bi-download me-1"></i> Download Resume
                                            </a>
                                        </div>
                                    </div>
                                `;
                            }

                            let skillsBlock = skillsHtml ? `
                                <div class="col-md-12">
                                    <p class="text-dark fw-bold">Skills</p>
                                    <div>${skillsHtml}</div>
                                </div>
                            ` : '';

                            candidateDetails.innerHTML = `
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="card-title mb-3">
                                    <i class="bi bi-person-circle me-1"></i> ${c.first_name} ${c.last_name}
                                </h5>
                                <div class="row g-3">
                                    ${fieldsHtml}
                                    ${totalExpHtml}
                                    ${skillsBlock}
                                    ${linkedinHtml}
                                    ${resumeHtml}
                                </div>
                            </div>
                        </div> `;

                    viewModal.show();
                })
            .catch(error => {
                console.error(error);
                Swal.fire('Error', 'Unable to fetch candidate details.', 'error');
            });
        });
    });


</script>
<script>
    document.getElementById('salaryNegotiableCheck').addEventListener('change', function() {
        document.querySelector('.salary-negotiable-field').classList.toggle('d-none', !this.checked);
    });

    document.getElementById('noticeNegotiableCheck').addEventListener('change', function() {
        document.querySelector('.notice-negotiable-field').classList.toggle('d-none', !this.checked);
    });

    document.getElementById('addSkillBtn').addEventListener('click', function() {
        const container = document.getElementById('skillsContainer');
        const index = container.children.length;
        const skillGroup = document.createElement('div');
        skillGroup.classList.add('row', 'g-2', 'mb-2', 'skill-item');


        const skillOptions = Object.entries(allSkills).map(([id, name]) => {
            return `<option value="${id}">${name}</option>`;
        }).join('');

        skillGroup.innerHTML = `
            <div class="col-md-4">
            <label class="form-label">Skill *</label>
                <select name="skills[${index}][name]" class="form-select skill-select" placeholder="Skill Name" required>
                    <option value="">Select Skill</option>
                    ${skillOptions}
                </select>
            </div>
            <div class="col-md-3">
            <label class="form-label">Experience Years *</label>
                <input type="number" name="skills[${index}][exp_years]" class="form-control" placeholder="Exp Years" min="0" 
                                   maxlength="2" 
                                   oninput="limitInput(this)" 
                                   onkeydown="blockInvalidKeys(event)" onpaste="return false;">
            </div>
            <div class="col-md-3">
            <label class="form-label">Experience Months *</label>
                <input type="number" name="skills[${index}][exp_months]" class="form-control" placeholder="Exp Months" min="0" max="11"
                                   oninput="validateMonthInput(this)" 
                                   onkeydown="blockInvalidKeys(event)" onpaste="return false;">
            </div>
            <div class="col-md-2 mt-5">
                <button type="button" class="btn btn-danger btn-sm remove-skill-btn">Remove</button>
            </div>
        `;
        container.appendChild(skillGroup);

        skillGroup.querySelector('.remove-skill-btn').addEventListener('click', function() {
            skillGroup.remove();
        });
    });

    // delete
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                let form = document.getElementById('deleteForm-' + id);
                if (form) {
                    form.submit();
                } else {
                    console.error('Form not found for ID: ' + id);
                }
            }
        });
    }
</script>
<script>
    $(document).ready(function () {

        // Salary negotiable toggle
        document.getElementById('Edit_salaryNegotiableCheck').addEventListener('change', function () {
            document.querySelector('#EditcandidateModal .salary-negotiable-field').classList.toggle('d-none', !this.checked);
        });

        // Notice negotiable toggle
        document.getElementById('Edit_noticeNegotiableCheck').addEventListener('change', function () {
            document.querySelector('#EditcandidateModal .notice-negotiable-field').classList.toggle('d-none', !this.checked);
        });

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
        // Add skill dynamically
        document.getElementById('Edit_addSkillBtn').addEventListener('click', function () {
            const container = document.getElementById('Edit_skillsContainer');
            const index = container.children.length;
            const skillGroup = document.createElement('div');
            skillGroup.classList.add('row', 'g-2', 'mb-2', 'skill-item');

            const skillOptions = Object.entries(allSkills).map(([id, name]) => {
                return `<option value="${id}">${name}</option>`;
            }).join('');

            skillGroup.innerHTML = `
                <div class="col-md-4">
                <label class="form-label">Skill *</label>
                <select name="skills[${index}][name]" class="form-select skill-select" placeholder="Skill Name" required>
                    <option value="">Select Skill</option>
                    ${skillOptions}
                </select>
                </div>
                <div class="col-md-3">
                <label class="form-label">Experience Years *</label>
                <input type="number" name="skills[${index}][exp_years]" class="form-control" placeholder="Exp Years" min="0" 
                                   maxlength="2" 
                                   oninput="limitInput(this)" 
                                   onkeydown="blockInvalidKeys(event)" onpaste="return false;">
            </div>
            <div class="col-md-3">
                <label class="form-label">Experience Months *</label>
                <input type="number" name="skills[${index}][exp_months]" class="form-control" placeholder="Exp Months" min="0" max="11"
                                   oninput="validateMonthInput(this)" 
                                   onkeydown="blockInvalidKeys(event)" onpaste="return false;">
            </div>
                <div class="col-md-2 mt-5">
                    <button type="button" class="btn btn-danger btn-sm remove-skill-btn">Remove</button>
                </div>
            `;
            container.appendChild(skillGroup);

            skillGroup.querySelector('.remove-skill-btn').addEventListener('click', function () {
                skillGroup.remove();
            });
        });

        // Open Edit Modal with data
        $(document).on('click', '.editCandidateBtn', function () {
            let candidateId = $(this).data('id');

            $('#candidateId').val(candidateId);

            $('#EditcandidateForm')[0].reset();
            $('#Edit_skillsContainer').empty();
            $('#EditcandidateForm').find('input[name="_method"]').remove();

            let updateUrl = HRP_URL+'candidates/update/' + candidateId;
            $('#EditcandidateForm').attr('action', updateUrl);
            // $('#EditcandidateForm').append('<input type="hidden" name="_method" value="PUT">');

            $('#EditcandidateModal .modal-title').text('Edit Candidate');
            $('#EditcandidateModal').modal('show');
            jQuery('.ApWait').show(); 
            $.ajax({
                url: HRP_URL +'candidates/edit/' + candidateId,
                type: 'GET',
                success: function (data) {
                    jQuery('.ApWait').hide(); 
                    let modal = $('#EditcandidateModal');
                    console.log(data);
                    // Basic fields
                    modal.find('input[name="first_name"]').val(data.first_name);
                    modal.find('input[name="last_name"]').val(data.last_name);
                    modal.find('input[name="email"]').val(data.email);
                    modal.find('input[name="phone_number"]').val(data.phone_number);
                    modal.find('input[name="alternate_phone_number"]').val(data.alternate_phone_number);
                    modal.find('input[name="total_experience_years"]').val(data.total_experience_years);
                    modal.find('input[name="total_experience_months"]').val(data.total_experience_months);
                    modal.find('input[name="current_company"]').val(data.current_company);
                    modal.find('input[name="ctc_per_month"]').val(data.ctc_per_month);
                    modal.find('input[name="ectc_per_month"]').val(data.ectc_per_month);
                    modal.find('input[name="notice_period_days"]').val(data.notice_period_days);
                    modal.find('input[name="linkedin_url"]').val(data.linkedin_url);
                    modal.find('input[name="remark"]').val(data.remark);
                    modal.find('input[name="reason"]').val(data.reason);
                    modal.find('input[name="salary_negotiable"]').val(data.salary_negotiable);
                    modal.find('input[name="notice_negotiable_days"]').val(data.notice_negotiable_days);

                    modal.find('select[name="candidate_source"]').val(data.candidate_source);
                    modal.find('select[name="current_designation"]').val(data.current_designation);
                    modal.find('select[name="applied_designation"]').val(data.applied_designation);
                    modal.find('select[name="stream"]').val(data.stream);
                // Set checkboxes based on loaded data
                $('#Edit_salaryNegotiableCheck').prop('checked', data.is_salary_negotiable == 1);
                $('#Edit_noticeNegotiableCheck').prop('checked', data.is_notice_negotiable == 1);

                // Toggle Salary Negotiable Field
                $('#Edit_salaryNegotiableCheck').on('change', function () {
                    if ($(this).is(':checked')) {
                        $('.salary-negotiable-field').removeClass('d-none');
                    } else {
                        $('.salary-negotiable-field').addClass('d-none');
                    }
                });

                // Toggle Notice Negotiable Field
                $('#Edit_noticeNegotiableCheck').on('change', function () {
                    if ($(this).is(':checked')) {
                        $('.notice-negotiable-field').removeClass('d-none');
                    } else {
                        $('.notice-negotiable-field').addClass('d-none');
                    }
                });

                // Ensure fields reflect initial state on load
                $('#Edit_salaryNegotiableCheck').trigger('change');
                $('#Edit_noticeNegotiableCheck').trigger('change');

                // Show existing resume if available
                if (data.resume_path) {
                    let resumeUrl = `${HRP_URL}storage/${data.resume_path}`;
                    $('#existingResumeContainer').html(`
                        <a href="${resumeUrl}" target="_blank" class="btn btn-sm btn-primary">
                            <i class="bi bi-file-earmark-arrow-down"></i> View Current Resume
                        </a>
                    `);
                } else {
                    $('#existingResumeContainer').html(`<span class="text-muted">No resume uploaded.</span>`);
                }

                    // Skills rendering (name, exp_years, exp_months)
                    if (data.skills && data.skills.length > 0) {
                        data.skills.forEach(function (skill, index) {
                            const container = document.getElementById('Edit_skillsContainer');
                            const skillGroup = document.createElement('div');
                            skillGroup.classList.add('row', 'g-2','mb-2', 'skill-item');

                        const skillOptions = Object.entries(allSkills).map(([id, nameText]) => {
                            const selected = (skill.name == id) ? 'selected' : '';
                            return `<option value="${id}" ${selected}>${nameText}</option>`;
                        }).join('');

                            skillGroup.innerHTML = `
                                <div class="col-md-4">
                                <label class="form-label">Skill *</label>
                                    <select name="skills[${index}][name]" class="form-select skill-select" placeholder="Skill Name" required>
                                        <option value="">Select Skill</option>
                                        ${skillOptions}
                                    </select>
                                </div>
                                <div class="col-md-3">
                                <label class="form-label">Experience Years *</label>
                                    <input type="number" name="skills[${index}][exp_years]" value="${skill.exp_years}" class="form-control" placeholder="Exp Years" min="0" 
                                                       maxlength="2" 
                                                       oninput="limitInput(this)" 
                                                       onkeydown="blockInvalidKeys(event)" onpaste="return false;">
                                </div>
                                <div class="col-md-3">
                                <label class="form-label">Experience Months *</label>
                                    <input type="number" name="skills[${index}][exp_months]" class="form-control" placeholder="Exp Months" value="${skill.exp_months}" min="0" max="11"
                                                       oninput="validateMonthInput(this)" 
                                                       onkeydown="blockInvalidKeys(event)" onpaste="return false;">
                                </div>
                                <div class="col-md-2 mt-5">
                                    <button type="button" class="btn btn-danger btn-sm remove-skill-btn">Remove</button>
                                </div>
                            `;
                            container.appendChild(skillGroup);

                            skillGroup.querySelector('.remove-skill-btn').addEventListener('click', function () {
                                skillGroup.remove();
                            });
                        });
                    }

                },
                error: function () {
                    jQuery('.ApWait').hide(); 
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to load candidate data.',
                    });
                    $('#EditcandidateModal').modal('hide');
                }
            });
        });

        // Submit Edit Form via AJAX
        $('#EditcandidateForm').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            let url = form.attr('action');
            let formData = new FormData(this);

              // Clear previous errors
            form.find('.error-message').remove();

            let hasErrors = false;

            // ✅ Validate required fields
            let requiredFields = [
                { name: 'first_name', message: 'First name is required.' },
                { name: 'last_name', message: 'Last name is required.' },
                { name: 'email', message: 'Email is required.' },
                { name: 'phone_number', message: 'Phone number is required.' },
                { name: 'ectc_per_month', message: 'Expected CTC per month is required.' },
                { name: 'candidate_source', message: 'Candidate source is required.' },
                { name: 'applied_designation', message: 'Applied designation is required.' },
                { name: 'stream', message: 'Stream is required.' }
                
            ];

            requiredFields.forEach(field => {
                let input = form.find('[name="' + field.name + '"]');
                if (input.length && !input.val().trim()) {
                    $('<div class="text-danger small error-message">' + field.message + '</div>').insertAfter(input);
                    hasErrors = true;
                }
            });

            // ✅ LinkedIn URL validation
            let linkedinInput = form.find('[name="linkedin_url"]');
            let linkedinVal = linkedinInput.val().trim();

            // Simple URL regex
            const urlRegex = /^(https?:\/\/)([\w-]+\.)+[\w-]+(\/[\w\-._~:/?#[\]@!$&'()*+,;=]*)?$/;

            if (linkedinVal && !urlRegex.test(linkedinVal)) {
                $('<div class="text-danger small error-message">The linkedin url field must be a valid URL eg. https://www.linkedin.com/</div>').insertAfter(linkedinInput);
                hasErrors = true;
            }

            // ✅ Validate email format
            let emailInput = form.find('[name="email"]');
            let emailVal = emailInput.val().trim();
            if (emailVal && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailVal)) {
                $('<div class="text-danger small error-message">Please enter a valid email address.</div>').insertAfter(emailInput);
                hasErrors = true;
            }
            // ✅ Phone number validation
            let phoneInput = form.find('[name="phone_number"]');
            let phoneVal = phoneInput.val().trim();

            const phoneRegex = /^[0-9]\d{9}$/;

            if (!phoneRegex.test(phoneVal)) {
                $('<div class="text-danger small error-message">Enter a valid 10-digit phone number starting with 0, to 9.</div>').insertAfter(phoneInput);
                hasErrors = true;
            }

            // ✅ Alternate phone validation (if filled)
            let alternateInput = form.find('[name="alternate_phone_number"]');
            let alternateVal = alternateInput.val().trim();

            if (alternateVal) {
                if (!phoneRegex.test(alternateVal)) {
                    $('<div class="text-danger small error-message">Enter a valid 10-digit phone number starting with 0, to 9.</div>').insertAfter(alternateInput);
                    hasErrors = true;
                } else if (alternateVal === phoneVal) {
                    $('<div class="text-danger small error-message">Alternate phone number must be different from phone number.</div>').insertAfter(alternateInput);
                    hasErrors = true;
                }
            }

            // ✅ Resume file size validation
            let resumeInput = form.find('[name="resume"]');
            let resumeFile = resumeInput[0].files[0]; // Get the file object

            if (resumeFile) {
                let maxSizeMB = 2; // e.g., 2 MB limit
                let maxSizeBytes = maxSizeMB * 1024 * 1024;

                if (resumeFile.size > maxSizeBytes) {
                    $('<div class="text-danger small error-message">File size should not exceed ' + maxSizeMB + ' MB.</div>')
                        .insertAfter(resumeInput);
                    hasErrors = true;
                }
            }
            // ✅ Validate ECTC is at least 1 more than CTC
            // let ctcInput = form.find('[name="ctc_per_month"]');
            // let ectcInput = form.find('[name="ectc_per_month"]');

            // let ctcVal = parseFloat(ctcInput.val().trim()) || 0;
            // let ectcVal = parseFloat(ectcInput.val().trim()) || 0;

            // if (ectcInput.length && ectcVal < ctcVal + 1) {
            //     $('<div class="text-danger small error-message">Expected CTC must be more than CTC.</div>').insertAfter(ectcInput);
            //     hasErrors = true;
            // }

        // ✅ Total Experience Validation
        let expYearsInput = form.find('[name="total_experience_years"]');
        let expMonthsInput = form.find('[name="total_experience_months"]');

        let expYearsRaw = expYearsInput.val().trim();
        let expMonthsRaw = expMonthsInput.val().trim();

        let expYearsVal = expYearsRaw !== "" ? parseInt(expYearsRaw) : null;
        let expMonthsVal = expMonthsRaw !== "" ? parseInt(expMonthsRaw) : null;

        // If both are entered and both are zero, show error
        if (expYearsVal !== null && expMonthsVal !== null && expYearsVal === 0 && expMonthsVal === 0) {
            $('<div class="text-danger small error-message">Enter at least 1 year or 1 month of total experience.</div>').insertAfter(expYearsInput);
            hasErrors = true;
        }

        // Validate months if entered
        if (expMonthsVal !== null && (expMonthsVal < 0 || expMonthsVal > 11)) {
            $('<div class="text-danger small error-message">Total experience months must be between 0 and 11.</div>').insertAfter(expMonthsInput);
            hasErrors = true;
        }


            // ✅ Skill validation
            let hasSkillErrors = false;
            $('.skill-item').each(function () {
                const skillSelect = $(this).find('select');
                const expYears = $(this).find('input[name*="[exp_years]"]');
                const expMonths = $(this).find('input[name*="[exp_months]"]');

                const skillVal = skillSelect.val();
                const yearsVal = expYears.val();
                const monthsVal = expMonths.val();

                if (!skillVal && (!yearsVal || yearsVal == 0) && (!monthsVal || monthsVal == 0)) {
                    $('<div class="text-danger small error-message">Please fill this skill row or remove it.</div>').insertAfter(skillSelect);
                    hasSkillErrors = true;
                    return; // continue to next
                }

                if (skillVal) {
                    if ((parseInt(yearsVal) === 0 || !yearsVal) && (parseInt(monthsVal) === 0 || !monthsVal)) {
                        $('<div class="text-danger small error-message">Enter at least 1 year or 1 month of experience for this skill.</div>').insertAfter(expYears);
                        hasSkillErrors = true;
                    }
                } else {
                    if ((yearsVal && yearsVal > 0) || (monthsVal && monthsVal > 0)) {
                        $('<div class="text-danger small error-message">Please select a skill name for these experience values.</div>').insertAfter(skillSelect);
                        hasSkillErrors = true;
                    }
                }

                if (monthsVal !== "" && (parseInt(monthsVal) < 0 || parseInt(monthsVal) > 11)) {
                    $('<div class="text-danger small error-message">Months must be between 0 and 11.</div>').insertAfter(expMonths);
                    hasSkillErrors = true;
                }
            });

            if (hasErrors || hasSkillErrors) {
                // Scroll to first error
                let firstError = form.find('.error-message').first();
                if (firstError.length) {
                    let modalBody = form.closest('.modal-body');
                    modalBody.animate({
                        scrollTop: firstError.offset().top - modalBody.offset().top + modalBody.scrollTop() - 40
                    }, 300);
                }
                return false;
            }


           // Email uniqueness check using unified endpoint
            $.post(HRP_URL+'candidates/check-email-exists', {
                email: emailVal,
                id: form.find('[name="id"]').val(), // Pass candidate ID for edit (or empty for add)
                _token: $('meta[name="csrf-token"]').attr('content')
            }, function(response) {

                if (response.exists) {
                    $('<div class="text-danger small error-message">The email has already been taken.</div>').insertAfter(emailInput);

                    let modalBody = form.closest('.modal-body');
                    modalBody.animate({
                        scrollTop: emailInput.offset().top - modalBody.offset().top + modalBody.scrollTop() - 40
                    }, 300);
                    return false;
                } else {
                    jQuery('.ApWait').show();

                        // ✅ Stuck upload detection and friendly error
                        let uploadTimeout;
                        let uploadRequest = $.ajax({
                            type: 'POST',
                            url: url,
                            data: formData,
                            processData: false,
                            contentType: false,
                            timeout: 30000, // 30 seconds

                            xhr: function () {
                                let xhr = new window.XMLHttpRequest();
                                xhr.upload.addEventListener("progress", function (evt) {
                                    if (evt.lengthComputable) {
                                        let percentComplete = Math.round((evt.loaded / evt.total) * 100);
                                        console.log(percentComplete + '% uploaded');
                                    }
                                }, false);
                                return xhr;
                            },
                            success: function () {
                                clearTimeout(uploadTimeout);
                                jQuery('.ApWait').hide();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Candidate added successfully.',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                $('#candidateModal').modal('hide');
                                form[0].reset();
                                location.reload();
                            },
                            error: function (xhr, textStatus) {
                                clearTimeout(uploadTimeout);
                                jQuery('.ApWait').hide();

                                // Clear previous stuck upload error
                                form.find('.resume-upload-error').remove();

                                if (textStatus === 'timeout') {
                                    $('<div class="text-danger small error-message resume-upload-error">Upload is taking too long. Please try again.</div>').insertAfter(resumeInput);
                                } else {
                                    handleAjaxValidationErrors(xhr, form);
                                }
                            }
                        });

                        // Failsafe manual abort after 35 sec
                        uploadTimeout = setTimeout(() => {
                            uploadRequest.abort(); // triggers timeout error
                        }, 35000);
                }
            });
        });

        // Reset modal on close
        $('#EditcandidateModal').on('hidden.bs.modal', function () {
            $('#EditcandidateModal .modal-title').text('Add Candidate');
            $('#EditcandidateForm')[0].reset();
            $('#EditcandidateForm').find('input[name="_method"]').remove();
            $('#Edit_skillsContainer').empty();
            document.querySelector('#EditcandidateModal .salary-negotiable-field').classList.add('d-none');
            document.querySelector('#EditcandidateModal .notice-negotiable-field').classList.add('d-none');
        });

    });


    $(document).ready(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Phone number: digits only, max 10
            $('[name="phone_number"], [name="alternate_phone_number"]').on('input', function () {
                this.value = this.value.replace(/\D/g, '').slice(0, 10);
            });


            $('#candidateForm').on('submit', function (e) {
                e.preventDefault();
                let form = $(this);
                let url = form.attr('action');
                let formData = new FormData(this);

                // Clear previous errors
                form.find('.error-message').remove();

                let hasErrors = false;

                // ✅ Required fields validation
                let requiredFields = [
                    { name: 'first_name', message: 'First name is required.' },
                    { name: 'last_name', message: 'Last name is required.' },
                    { name: 'email', message: 'Email is required.' },
                    { name: 'phone_number', message: 'Phone number is required.' },
                    { name: 'ectc_per_month', message: 'Expected CTC per month is required.' },
                    { name: 'candidate_source', message: 'Candidate source is required.' },
                    { name: 'applied_designation', message: 'Applied designation is required.' },
                    { name: 'stream', message: 'Stream is required.' }
                ];

                requiredFields.forEach(field => {
                    let input = form.find('[name="' + field.name + '"]');
                    if (input.length && !input.val().trim()) {
                        $('<div class="text-danger small error-message">' + field.message + '</div>').insertAfter(input);
                        hasErrors = true;
                    }
                });

                // ✅ Email validation
                let emailInput = form.find('[name="email"]');
                let emailVal = emailInput.val().trim();
                if (emailVal && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailVal)) {
                    $('<div class="text-danger small error-message">Please enter a valid email address.</div>').insertAfter(emailInput);
                    hasErrors = true;
                }

                // ✅ Phone validation
                let phoneInput = form.find('[name="phone_number"]');
                let phoneVal = phoneInput.val().trim();
                const phoneRegex = /^[0-9]{10}$/;
                if (!phoneRegex.test(phoneVal)) {
                    $('<div class="text-danger small error-message">Enter a valid 10-digit phone number.</div>').insertAfter(phoneInput);
                    hasErrors = true;
                }

                // ✅ Alternate phone validation
                let alternateInput = form.find('[name="alternate_phone_number"]');
                let alternateVal = alternateInput.val().trim();
                if (alternateVal) {
                    if (!phoneRegex.test(alternateVal)) {
                        $('<div class="text-danger small error-message">Enter a valid 10-digit alternate phone number.</div>').insertAfter(alternateInput);
                        hasErrors = true;
                    } else if (alternateVal === phoneVal) {
                        $('<div class="text-danger small error-message">Alternate phone number must be different from phone number.</div>').insertAfter(alternateInput);
                        hasErrors = true;
                    }
                }

                // ✅ LinkedIn validation
                let linkedinInput = form.find('[name="linkedin_url"]');
                let linkedinVal = linkedinInput.val().trim();
                const urlRegex = /^(https?:\/\/)([\w-]+\.)+[\w-]+(\/[\w\-._~:/?#[\]@!$&'()*+,;=]*)?$/;
                if (linkedinVal && !urlRegex.test(linkedinVal)) {
                    $('<div class="text-danger small error-message">The linkedin url field must be a valid URL e.g. https://www.linkedin.com/</div>').insertAfter(linkedinInput);
                    hasErrors = true;
                }

                // ✅ Total experience validation
                let expYearsInput = form.find('[name="total_experience_years"]');
                let expMonthsInput = form.find('[name="total_experience_months"]');
                let expYearsRaw = expYearsInput.val().trim();
                let expMonthsRaw = expMonthsInput.val().trim();
                let expYearsVal = expYearsRaw !== "" ? parseInt(expYearsRaw) : null;
                let expMonthsVal = expMonthsRaw !== "" ? parseInt(expMonthsRaw) : null;
                if (expYearsVal !== null && expMonthsVal !== null && expYearsVal === 0 && expMonthsVal === 0) {
                    $('<div class="text-danger small error-message">Enter at least 1 year or 1 month of total experience.</div>').insertAfter(expYearsInput);
                    hasErrors = true;
                }
                if (expMonthsVal !== null && (expMonthsVal < 0 || expMonthsVal > 11)) {
                    $('<div class="text-danger small error-message">Total experience months must be between 0 and 11.</div>').insertAfter(expMonthsInput);
                    hasErrors = true;
                }

                // ✅ Resume file validation
                let resumeInput = form.find('[name="resume"]');
                let resumeFile = resumeInput[0].files[0];
                if (resumeFile) {
                    let maxSizeMB = 2;
                    let maxSizeBytes = maxSizeMB * 1024 * 1024;
                    if (resumeFile.size > maxSizeBytes) {
                        $('<div class="text-danger small error-message">File size should not exceed ' + maxSizeMB + ' MB.</div>').insertAfter(resumeInput);
                        hasErrors = true;
                    }
                }

                // ✅ Skill validation
                let hasSkillErrors = false;
                $('.skill-item').each(function () {
                    const skillSelect = $(this).find('select');
                    const expYears = $(this).find('input[name*="[exp_years]"]');
                    const expMonths = $(this).find('input[name*="[exp_months]"]');
                    const skillVal = skillSelect.val();
                    const yearsVal = expYears.val();
                    const monthsVal = expMonths.val();

                    if (!skillVal && (!yearsVal || yearsVal == 0) && (!monthsVal || monthsVal == 0)) {
                        $('<div class="text-danger small error-message">Please fill this skill row or remove it.</div>').insertAfter(skillSelect);
                        hasSkillErrors = true;
                        return;
                    }
                    if (skillVal) {
                        if ((parseInt(yearsVal) === 0 || !yearsVal) && (parseInt(monthsVal) === 0 || !monthsVal)) {
                            $('<div class="text-danger small error-message">Enter at least 1 year or 1 month of experience for this skill.</div>').insertAfter(expYears);
                            hasSkillErrors = true;
                        }
                    } else {
                        if ((yearsVal && yearsVal > 0) || (monthsVal && monthsVal > 0)) {
                            $('<div class="text-danger small error-message">Please select a skill name for these experience values.</div>').insertAfter(skillSelect);
                            hasSkillErrors = true;
                        }
                    }
                    if (monthsVal !== "" && (parseInt(monthsVal) < 0 || parseInt(monthsVal) > 11)) {
                        $('<div class="text-danger small error-message">Months must be between 0 and 11.</div>').insertAfter(expMonths);
                        hasSkillErrors = true;
                    }
                });

                // ✅ Scroll to first error
                if (hasErrors || hasSkillErrors) {
                    let firstError = form.find('.error-message').first();
                    if (firstError.length) {
                        let modalBody = form.closest('.modal-body');
                        modalBody.animate({
                            scrollTop: firstError.offset().top - modalBody.offset().top + modalBody.scrollTop() - 40
                        }, 300);
                    }
                    return false;
                }

                // ✅ Check email uniqueness before upload
                $.post(HRP_URL + 'candidates/check-email-exists', {
                    email: emailVal,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }, function (response) {
                    if (response.exists) {
                        $('<div class="text-danger small error-message">The email has already been taken.</div>').insertAfter(emailInput);
                        let modalBody = form.closest('.modal-body');
                        modalBody.animate({
                            scrollTop: emailInput.offset().top - modalBody.offset().top + modalBody.scrollTop() - 40
                        }, 300);
                        return false;
                    } else {
                        jQuery('.ApWait').show();

                        // ✅ Stuck upload detection and friendly error
                        let uploadTimeout;
                        let uploadRequest = $.ajax({
                            type: 'POST',
                            url: url,
                            data: formData,
                            processData: false,
                            contentType: false,
                            timeout: 30000, // 30 seconds

                            xhr: function () {
                                let xhr = new window.XMLHttpRequest();
                                xhr.upload.addEventListener("progress", function (evt) {
                                    if (evt.lengthComputable) {
                                        let percentComplete = Math.round((evt.loaded / evt.total) * 100);
                                        console.log(percentComplete + '% uploaded');
                                    }
                                }, false);
                                return xhr;
                            },
                            success: function () {
                                clearTimeout(uploadTimeout);
                                jQuery('.ApWait').hide();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Candidate added successfully.',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                $('#candidateModal').modal('hide');
                                form[0].reset();
                                location.reload();
                            },
                            error: function (xhr, textStatus) {
                                clearTimeout(uploadTimeout);
                                jQuery('.ApWait').hide();

                                // Clear previous stuck upload error
                                form.find('.resume-upload-error').remove();

                                if (textStatus === 'timeout') {
                                    $('<div class="text-danger small error-message resume-upload-error">Upload is taking too long. Please try again.</div>').insertAfter(resumeInput);
                                } else {
                                    handleAjaxValidationErrors(xhr, form);
                                }
                            }
                        });

                        // Failsafe manual abort after 35 sec
                        uploadTimeout = setTimeout(() => {
                            uploadRequest.abort(); // triggers timeout error
                        }, 35000);
                    }
                });
            });


    });

    function handleAjaxValidationErrors(xhr, form) {
        jQuery('.ApWait').hide(); 
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong. Please try again.',
        });
    }
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
        const invalidChars = ['-', '+', 'e', 'E'];
        if (invalidChars.includes(e.key)) {
            e.preventDefault();
        }

        if (e.key === "ArrowDown") {
            const input = e.target;
            const currentValue = parseFloat(input.value) || 0;
            const step = parseFloat(input.step) || 1;
            if (currentValue - step < 0) {
                e.preventDefault();
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('input[type="number"]').forEach(function(input) {
            input.addEventListener('wheel', function(e) {
                e.preventDefault();
            });

            input.addEventListener('paste', function(e) {
                const pasteData = e.clipboardData.getData('text');
                if (!/^\d*\.?\d*$/.test(pasteData)) {
                    e.preventDefault();
                }
            });
        });
    });

    function validateDocumentFileSize(input) {
        const maxSizeKB = 4048; // 4 MB
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
<script>
    $(document).ready(function() {
        $('#skills').select2({
            placeholder: "Please Select Skill",
            allowClear: true,
            width: '100%'
        });
    });
</script>


@endsection
