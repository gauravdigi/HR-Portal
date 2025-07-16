@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <h2 class="h2">Employee Details</h2>
    
<ul class="nav nav-pills mb-3 mt-4" id="employeeTabs" role="tablist" style="gap: 8px;">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal"
            type="button" role="tab">
            <i class="bi bi-person-circle me-1"></i> Personal Info
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address"
            type="button" role="tab">
            <i class="bi bi-geo-alt-fill me-1"></i> Address Info
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="bank-tab" data-bs-toggle="tab" data-bs-target="#bank"
            type="button" role="tab">
            <i class="bi bi-bank me-1"></i> Bank Info
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="skill-tab" data-bs-toggle="tab" data-bs-target="#skill"
            type="button" role="tab">
            <i class="bi bi-tools me-1"></i> Skills
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="document-tab" data-bs-toggle="tab" data-bs-target="#document"
            type="button" role="tab">
            <i class="bi bi-file-earmark-text me-1"></i> Documents
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="prev-tab" data-bs-toggle="tab" data-bs-target="#previous"
            type="button" role="tab">
            <i class="bi bi-building me-1"></i> Previous Company
        </button>
    </li>
</ul>


    <!-- Tab panes -->
    <div class="tab-content mt-3" id="employeeTabContent">
        <div class="tab-pane fade show active" id="personal" role="tabpanel">
            <h4 class="section-title mt-4 mb-3 h4">
                <!-- <i class="bi bi-info-circle-fill text-primary me-2"></i>Personal Information -->
            </h4>
            @php
                $statusLabels = [
                    0 => ['label' => 'Draft',  'class' => 'dark'],
                    1 => ['label' => 'Pending', 'class' => 'warning'],
                    2 => ['label' => 'Approved',  'class' => 'success'],
                    3 => ['label' => 'Rejected', 'class' => 'danger'],
                ];
            @endphp
            <div class="container my-4">
                <div class="card shadow rounded-4 p-5 border-0 bg-white">
                    <div class="row g-4 align-items-center">
                        <!-- Profile Image + Info Left -->
                        <div class="col-md-3 text-center">
                            @if($employee->profile_image)
                            <img src="{{ asset('storage/' . $employee->profile_image) }}" 
                                 alt="Profile Image" 
                                 class="rounded-circle shadow" 
                                 style="width: 150px; height: 150px; object-fit: cover;margin:0 auto">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="150" height="150" viewBox="0 0 256 256" xml:space="preserve" style="margin:0 auto;">
                                <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                    <path d="M 45 0 C 20.147 0 0 20.147 0 45 c 0 24.853 20.147 45 45 45 s 45 -20.147 45 -45 C 90 20.147 69.853 0 45 0 z M 45 22.007 c 8.899 0 16.14 7.241 16.14 16.14 c 0 8.9 -7.241 16.14 -16.14 16.14 c -8.9 0 -16.14 -7.24 -16.14 -16.14 C 28.86 29.248 36.1 22.007 45 22.007 z M 45 83.843 c -11.135 0 -21.123 -4.885 -27.957 -12.623 c 3.177 -5.75 8.144 -10.476 14.05 -13.341 c 2.009 -0.974 4.354 -0.958 6.435 0.041 c 2.343 1.126 4.857 1.696 7.473 1.696 c 2.615 0 5.13 -0.571 7.473 -1.696 c 2.083 -1 4.428 -1.015 6.435 -0.041 c 5.906 2.864 10.872 7.591 14.049 13.341 C 66.123 78.957 56.135 83.843 45 83.843 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                </g>
                                </svg>
                            @endif
                            <div class="mt-3">
                                <h5 class="h5 fw-semibold mb-0">{{ $employee->user_name }}</h5>
                                @if($employee->designation == 'Team Lead')
                                    <h6 class="h6 text-muted">(Team Lead)</h6>
                                @endif
                                 @if($employee->digi_id)<small><strong>ID No.</strong>{{ $employee->digi_id }}</small>@endif
                                <div class="mt-2">
                                    <span class="badge bg-{{ $statusLabels[$employee->is_approved]['class'] }}">
                                        {{ $statusLabels[$employee->is_approved]['label'] }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Info Right -->
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-sm-6">
                                    <p class="mb-2"><strong>Email:</strong>@if($employee->email) {{ $employee->email }}@endif</p>
                                    <p class="mb-2"><strong>Phone:</strong>@if($employee->phone) {{ $employee->phone }}@endif</p>
                                    <p class="mb-2"><strong>Designation:</strong>@if($employee->designation) {{ $employee->designation }}@endif</p>
                                    <p class="mb-2"><strong>DOB:</strong>  @if($employee->dob) {{ \Carbon\Carbon::parse($employee->dob)->format('F j, Y') }}@endif</p>
                                    <p class="mb-2"><strong>Celebration DOB:</strong> @if($employee->celb_dob) {{ old('celb_dob', ($employee->celb_dob == '0000-00-00' ? \Carbon\Carbon::parse($employee->dob)->format('F j, Y') : \Carbon\Carbon::parse($employee->celb_dob)->format('F j, Y'))) }} @endif</p>
                                    <p class="mb-2"><strong>Gender:</strong>@if($employee->gender) {{ $employee->gender }}@endif</p>
                                    <p class="mb-2"><strong>Blood Group:</strong>@if($employee->blood_group) {{ $employee->blood_group }}@endif</p>
                                    <p class="mb-2"><strong>PAN Card:</strong>@if($employee->pan) {{ $employee->pan }}@endif</p>
                                    <p class="mb-2"><strong>Aadhar Card:</strong>@if($employee->aadhar) {{ $employee->aadhar }}@endif</p>     
                                </div>
                                <div class="col-sm-6">
                                    <p class="mb-2"><strong>Official Email:</strong>@if($employee->user_email) {{ $employee->user_email }}@endif</p> 
                                    <p class="mb-2"><strong>Role:</strong>@if($employee->user_role)
                                            @if(strtolower($employee->user_role) === 'hr')
                                                HR
                                            @else
                                                {{ ucfirst(strtolower($employee->user_role)) }}
                                            @endif
                                        @endif</p>
                                    <p class="mb-2"><strong>Team Lead:</strong>@if($employee->team_lead) {{ $team_lead }} @endif</p>  
                                    <p class="mb-2"><strong>Joining Date:</strong> @if($employee->joining_date)  {{ \Carbon\Carbon::parse($employee->joining_date)->format('F j, Y') }}@endif</p>
                                    <p class="mb-2"><strong>Experience:</strong>
                                        @if($employee->exp_years || $employee->exp_months)
                                            @if($employee->exp_years)
                                                {{ $employee->exp_years }} year{{ $employee->exp_years > 1 ? 's' : '' }}
                                                {{ $employee->exp_months ?? 0 }} month{{ ($employee->exp_months ?? 0) > 1 ? 's' : '' }}
                                            @else
                                                {{ $employee->exp_months }} month{{ $employee->exp_months > 1 ? 's' : '' }}
                                            @endif
                                        @else
                                            
                                        @endif
                                    </p>
                                    <p class="mb-2">
                                        <strong>Increment:</strong>
                                        @if($employee->inc_years || $employee->inc_months)
                                            @if($employee->inc_years)
                                                {{ $employee->inc_years }} year{{ $employee->inc_years > 1 ? 's' : '' }}
                                                {{ $employee->inc_months ?? 0 }} month{{ ($employee->inc_months ?? 0) > 1 ? 's' : '' }}
                                            @else
                                                {{ $employee->inc_months }} month{{ $employee->inc_months > 1 ? 's' : '' }}
                                            @endif
                                        @else
                                            
                                        @endif
                                    </p>
                                    <p class="mb-2"><strong>Monthly Salary:</strong>
                                        @if(!is_null($salary))
                                            ₹{{ number_format($salary, 2) }}
                                        @endif
                                    </p>
                                    <p class="mb-2"><strong>Probation Period End:</strong> 
                                       @if($employee->probation_end) {{ \Carbon\Carbon::parse($employee->probation_end)->format('F j, Y') }}@endif</p>
                                    <p class="mb-2"><strong>Release Date:</strong> @if($employee->release_date)  {{ \Carbon\Carbon::parse($employee->release_date)->format('F j, Y') }}@endif</p>
                                    
                                </div>
                                   @php
                                        $emergencyContacts = is_string($employee->emergency_contacts)
                                            ? json_decode($employee->emergency_contacts, true)
                                            : $employee->emergency_contacts;
                                    @endphp

                                    @if($emergencyContacts && is_array($emergencyContacts))
                                    <p class="h4 text-muted mt-2">Emergency contacts</p>
                                    
                                        @foreach ($emergencyContacts as $emergencyContact)
                                            
                                                <div class="col-md-6">
                                                    <p class="mb-2"><strong>Name:</strong>
                                                        {{ $emergencyContact['name'] ?? '' }}</p>
                                                    <p class="mb-2"><strong>Relation:</strong>
                                                        {{ $emergencyContact['relation'] ?? '' }}</p>
                                                    <p class="mb-2"><strong>Number:</strong>
                                                        {{ $emergencyContact['phone'] ?? '' }}</p>
                                                </div>
                                         
                                        @endforeach
                                    
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <div class="tab-pane fade" id="address" role="tabpanel">
            <div class="container my-4">
                <div class="card shadow rounded-4 p-5 border-0 bg-white">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="section-title mt-0 mb-4 h4">
                                <i class="bi bi-info-circle-fill text-primary me-2"></i>Permanent Address
                            </h4>

                            @if($employee->address_perm || $employee->state_perm || $employee->city_perm || $employee->zip_perm || $employee->country_perm)
                            <p class="mb-2"><strong>Address:</strong> {{ $employee->address_perm ?? '' }}</p>
                            <p class="mb-2"><strong>State:</strong> {{ $employee->state_perm ?? '' }}</p>
                            <p class="mb-2"><strong>City:</strong> {{ $employee->city_perm ?? '' }}</p>
                            <p class="mb-2"><strong>Zip:</strong> {{ $employee->zip_perm ?? '' }}</p>
                            <p class="mb-2"><strong>Country:</strong> {{ $employee->country_perm ?? '' }}</p>
                            @else
                            <p>Permanent Address not found</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h4 class="section-title mt-0 mb-4 h4">
                                <i class="bi bi-info-circle-fill text-primary me-2"></i>Local Address
                            </h4>
                            @if($employee->address_local || $employee->state_local || $employee->city_local || $employee->zip_local || $employee->country_local)
                            <p class="mb-2"><strong>Address:</strong> {{ $employee->address_local ?? '' }}</p>
                            <p class="mb-2"><strong>State:</strong> {{ $employee->state_local ?? '' }}</p>
                            <p class="mb-2"><strong>City:</strong> {{ $employee->city_local ?? '' }}</p>
                            <p class="mb-2"><strong>Zip:</strong> {{ $employee->zip_local ?? '' }}</p>
                            <p class="mb-2"><strong>Country:</strong> {{ $employee->country_local ?? '' }}</p>
                            @else
                            <p>Local Address not found</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="bank" role="tabpanel">
            
             <div class="container my-4">
                <div class="card shadow rounded-4 p-5 border-0 bg-white">
                    <h4 class="section-title mt-0 mb-4 h4">
                        <i class="bi bi-info-circle-fill text-primary me-2"></i>Bank Information
                    </h4>
                    <div class="row">

                        @if($employee->acc_name || $employee->acc_no || $employee->confirm_acc_no || $employee->zip_local || $employee->ifsc || $employee->bank_name || $employee->branch_address)
                        <div class="col-md-6">


                            <p class="mb-2"><strong>Account Holder Name:</strong> {{ $employee->acc_name ?? '' }}</p>
                            <p class="mb-2"><strong>Account Number:</strong> {{ $employee->acc_no ?? '' }}</p>
                            <p class="mb-2"><strong>IFSC Code:</strong> {{ $employee->ifsc ?? '' }}</p>
                        </div>
                        <div class="col-md-6">
                            
                            <p class="mb-2"><strong>Bank Name:</strong> {{ $employee->bank_name ?? '' }}</p>
                            <p class="mb-2"><strong>Branch Address:</strong> {{ $employee->branch_address ?? '' }}</p>
                        </div>
                        @else
                        <p>Bank Information Not Found</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="skill" role="tabpanel">
             <div class="container my-4">
                <div class="card shadow rounded-4 p-5 border-0 bg-white">
                    <h4 class="section-title mt-0 mb-4 h4">
                        <i class="bi bi-info-circle-fill text-primary me-2"></i>Skills
                    </h4>
                    <div class="row">
                        
                        <div class="col-md-6">
                            @php
                                $skills = is_string($employee->skills)
                                    ? json_decode($employee->skills, true)
                                    : $employee->skills;

                                $validSkills = collect($skills)->filter(function ($s) {
                                    return is_array($s) &&
                                        (
                                            !empty($s['name']) || 
                                            (!empty($s['years']) && $s['years'] !== '0') || 
                                            (!empty($s['months']) && $s['months'] !== '0')
                                        );
                                });
                            @endphp

                            @if ($validSkills->count() > 0)
                           
                             <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Level</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employee->skills as $skill)
                                        <tr>
                                            @php
                                                if (is_array($skill['name']) && isset($skill['name'][0])) {
                                                    $skillId = $skill['name'][0];
                                                } elseif (!is_array($skill['name'])) {
                                                    $skillId = $skill['name'];
                                                } else {
                                                    $skillId = null;
                                                }
                                                $skillName = $skillId && isset($all_skills[$skillId]) ? $all_skills[$skillId] : 'Unknown Skill';
                                            @endphp
                                           <td>{{ $skillName }}</td>
                                            <td>@if($skill['years'] || $skill['months']) {{ $skill['years'] }} year {{ $skill['months'] }} month @else No Level Define @endif</td>
                                           
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                                <p>No skills found.</p>
                            @endif
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="document" role="tabpanel">
            <div class="container my-4">
                <div class="card shadow rounded-4 p-5 border-0 bg-white">
                     <h4 class="section-title mt-0 mb-4 h4">
                        <i class="bi bi-info-circle-fill text-primary me-2"></i>Documents
                    </h4>
                    <div class="row">
                        <div class="col-md-6">
                            @php
                                $documents = is_string($employee->documents)
                                    ? json_decode($employee->documents, true)
                                    : $employee->documents;

                                // Filter out fully-null documents
                                $validDocuments = collect($documents)->filter(function ($doc) {
                                    return is_array($doc) && collect($doc)->filter(fn($v) => !is_null($v) && $v !== '')->isNotEmpty();
                                });
                            @endphp

                            @if ($validDocuments->count() > 0)
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Document Type</th>
                                        <th>File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employee->documents as $doc)
                                        <tr>
                                            <td>{{ $doc['type'] ?? '' }}</td>
                                            <td>
                                                @php
                                                    $filePath = $doc['file_path'] ?? '';
                                                    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                                    $url = asset('storage/' . $filePath);
                                                @endphp

                                                @if (in_array($extension, ['jpg', 'jpeg', 'png']))
                                                    <a href="{{ $url }}" target="_blank" download>
                                                        <img src="{{ $url }}" alt="document" width="100" height="100" class="rounded shadow-sm" />
                                                    </a>
                                                @elseif ($extension === 'pdf')
                                                    <a href="{{ $url }}" target="_blank" download>
                                                        <i class="bi bi-file-earmark-pdf text-danger" style="font-size: 4rem;"></i>
                                                    </a>
                                                @elseif (in_array($extension, ['doc', 'docx']))
                                                    <a href="{{ $url }}" target="_blank" download>
                                                        <i class="bi bi-file-earmark-word text-primary" style="font-size: 4rem;"></i>
                                                    </a>
                                                @else
                                                    No file
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>  
                            @else
                                <p>No documents found.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="previous" role="tabpanel">
            <div class="container my-4">
                <div class="card shadow rounded-4 p-5 border-0 bg-white">
                     <h4 class="section-title mt-0 mb-4 h4">
                        <i class="bi bi-info-circle-fill text-primary me-2"></i>Previous Companies
                    </h4>
                    <div class="row">
                        <div class="col-md-6">
                            @php
                                $previousCompanies = is_string($employee->previous_companies)
                                    ? json_decode($employee->previous_companies, true)
                                    : $employee->previous_companies;

                                $validCompanies = collect($previousCompanies)->filter(function ($company) {
                                    return is_array($company) &&
                                        (
                                            !empty($company['company']) ||
                                            (!empty($company['salary']) && $company['salary'] !== '0')
                                        );
                                });
                            @endphp

                            @if ($validCompanies->count() > 0)
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Company Name</th>
                                            <th>Salary</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employee->previous_companies as $company)
                                            <tr>
                                                <td>@if($company['company']) {{ $company['company'] }}@endif</td>
                                                <td>@if($company['salary']) ₹{{ $company['salary'] }} @else No Salary @endif</td>
                                            </tr> 
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>No previous companies found.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .nav-pills .nav-link {
        border-radius: 50px;
        padding: 8px 20px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .nav-pills .nav-link.active {
        background-color: #0d6efd;
        color: #fff;
    }

    .nav-pills .nav-link:hover {
        background-color: #0b5ed7;
        color: #fff;
    }

    .card {
        background: #fff;
        transition: all 0.3s ease-in-out;
    }

    .card:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    p {
        font-size: 18px;
        line-height: 28px;
        color: #000;
    }
    strong {
        margin-right: 10px;
    }
    .table th , .table td {
    color: #000;
    font-size: 18px;
    }
    </style>
@endsection