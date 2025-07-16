<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index()
    {
       // die('ddsd');
        // $employees = Employee::all();
        // return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }
 

public function store(Request $request)
{
    $validated = $request->validate([
        'first_name'       => 'required|string|max:255',
        'middle_name'      => 'nullable|string|max:255',
        'last_name'        => 'required|string|max:255',
        'gender'           => 'required|string',
        'email'            => 'required|email|unique:employees',
        'dob'              => 'required|date',
        'blood_group'      => 'nullable|string|max:10',
        'phone'            => 'required|string|max:15',
        'emergency'        => 'nullable|string|max:15',
        'official_email'   => 'nullable|email',
        'voter_id'         => 'nullable|string|max:50',
        'pan'              => 'nullable|string|max:50',
        'aadhar'           => 'nullable|string|max:50',
        'designation'      => 'nullable|string|max:255',
        'role'             => 'required|string',
        'team_lead'        => 'nullable|string|max:255',
        'joining_date'     => 'nullable|date',
        'exp_years'        => 'nullable|integer|min:0',
        'exp_months'       => 'nullable|integer|min:0|max:11',
        'salary'           => 'nullable|numeric|min:0',
        'inc_years'        => 'nullable|integer|min:0',
        'inc_months'       => 'nullable|integer|min:0|max:11',
        'probation_end'    => 'nullable|date',
        'release_date'     => 'nullable|date',
        'address_perm'     => 'required|string',
        'state_perm'       => 'required|string',
        'city_perm'        => 'required|string',
        'zip_perm'         => 'required|string',
        'country_perm'     => 'required|string',
        'address_local'    => 'required|string',
        'state_local'      => 'required|string',
        'city_local'       => 'required|string',
        'zip_local'        => 'required|string',
        'country_local'    => 'required|string',
        'acc_name'         => 'required|string',
        'acc_no'           => 'required|string',
        'confirm_acc_no'   => 'required|string|same:acc_no',
        'bank_name'        => 'required|string',
        'ifsc'             => 'required|string',
        'branch_address'   => 'nullable|string',
    ]);

    // SKILLS
    $skills = [];
    if ($request->filled('skills')) {
        foreach ($request->skills as $i => $skill) {
            $skills[] = [
                'name'   => $skill,
                'years'  => $request->skill_exp_years[$i] ?? 0,
                'months' => $request->skill_exp_months[$i] ?? 0,
            ];
        }
    }

    // DOCUMENTS
    $documents = [];
    if ($request->has('documents')) {
        foreach ($request->documents as $i => $doc) {
            $filePath = null;
            if (isset($doc['file'])) {
                $filePath = $doc['file']->store('documents');
            }
            $documents[] = [
                'type' => $doc['type'],
                'file_path' => $filePath,
            ];
        }
    }

    // PREVIOUS COMPANIES
    $previousCompanies = [];
    if ($request->filled('previous_companies')) {
        foreach ($request->previous_companies as $prev) {
            $previousCompanies[] = [
                'company' => $prev['company'],
                'salary' => $prev['salary'],
            ];
        }
    }

    // Merge & save
    $employee = new Employee($validated);
    $employee->skills = $skills;
    $employee->documents = $documents;
    $employee->previous_companies = $previousCompanies;
    $employee->save();

    return redirect()->route('employees.index')->with('success', 'Employee added successfully.');
}  

public function edit($id)
{
    $employee = Employee::findOrFail($id);

    $countries = [
        "Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antigua and Barbuda", 
        "Argentina", "Armenia", "Australia", "Austria", "Azerbaijan", "Bahamas",
        "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin",
        "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei",
        "Bulgaria", "Burkina Faso", "Burundi", "Cabo Verde", "Cambodia", "Cameroon",
        "Canada", "Central African Republic", "Chad", "Chile", "China", "Colombia",
        "Comoros", "Congo (Congo-Brazzaville)", "Costa Rica", "Croatia", "Cuba", "Cyprus",
        "Czechia (Czech Republic)", "Democratic Republic of the Congo", "Denmark", "Djibouti",
        "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea",
        "Eritrea", "Estonia", "Eswatini (fmr. Swaziland)", "Ethiopia", "Fiji", "Finland",
        "France", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Grenada",
        "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Holy See", "Honduras",
        "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Israel",
        "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Kuwait",
        "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya",
        "Liechtenstein", "Lithuania", "Luxembourg", "Madagascar", "Malawi", "Malaysia",
        "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius",
        "Mexico", "Micronesia", "Moldova", "Monaco", "Mongolia", "Montenegro", "Morocco",
        "Mozambique", "Myanmar (formerly Burma)", "Namibia", "Nauru", "Nepal",
        "Netherlands", "New Zealand", "Nicaragua", "Niger", "Nigeria", "North Korea",
        "North Macedonia", "Norway", "Oman", "Pakistan", "Palau", "Palestine State",
        "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland",
        "Portugal", "Qatar", "Romania", "Russia", "Rwanda", "Saint Kitts and Nevis",
        "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino",
        "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Serbia", "Seychelles",
        "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia",
        "South Africa", "South Korea", "South Sudan", "Spain", "Sri Lanka", "Sudan",
        "Suriname", "Sweden", "Switzerland", "Syria", "Tajikistan", "Tanzania", "Thailand",
        "Timor-Leste", "Togo", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey",
        "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom",
        "United States of America", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela",
        "Vietnam", "Yemen", "Zambia", "Zimbabwe"
    ];

    return view('employees.edit', compact('employee', 'countries'));
}
  

public function update(Request $request, Employee $employee)
{
    $validated = $request->validate([
        'first_name'       => 'required|string|max:255',
        'middle_name'      => 'nullable|string|max:255',
        'last_name'        => 'required|string|max:255',
        'gender'           => 'required|string',
        'email'            => 'required|email|unique:employees,email,' . $employee->id,
        'dob'              => 'required|date',
        'blood_group'      => 'nullable|string|max:10',
        'phone'            => 'required|string|max:15',
        'emergency'        => 'nullable|string|max:15',
        'official_email'   => 'nullable|email',
        'voter_id'         => 'nullable|string|max:50',
        'pan'              => 'nullable|string|max:50',
        'aadhar'           => 'nullable|string|max:50',
        'designation'      => 'nullable|string|max:255',
        'role'             => 'required|string',
        'team_lead'        => 'nullable|string|max:255',
        'joining_date'     => 'nullable|date',
        'exp_years'        => 'nullable|integer|min:0',
        'exp_months'       => 'nullable|integer|min:0|max:11',
        'salary'           => 'nullable|numeric|min:0',
        'inc_years'        => 'nullable|integer|min:0',
        'inc_months'       => 'nullable|integer|min:0|max:11',
        'probation_end'    => 'nullable|date',
        'release_date'     => 'nullable|date',
        'address_perm'     => 'required|string',
        'state_perm'       => 'required|string',
        'city_perm'        => 'required|string',
        'zip_perm'         => 'required|string',
        'country_perm'     => 'required|string',
        'address_local'    => 'required|string',
        'state_local'      => 'required|string',
        'city_local'       => 'required|string',
        'zip_local'        => 'required|string',
        'country_local'    => 'required|string',
        'acc_name'         => 'required|string',
        'acc_no'           => 'required|string',
        'confirm_acc_no'   => 'required|string|same:acc_no',
        'bank_name'        => 'required|string',
        'ifsc'             => 'required|string',
        'branch_address'   => 'nullable|string',
    ]);

    // Prepare skills array
    $skills = [];
    if ($request->filled('skills')) {
        foreach ($request->skills as $i => $skill) {
            $skills[] = [
                'name' => $skill,
                'years' => $request->skill_exp_years[$i] ?? 0,
                'months' => $request->skill_exp_months[$i] ?? 0,
            ];
        }
    }

    // Prepare documents array
    $documents = [];
    if ($request->has('documents')) {
        foreach ($request->documents as $i => $doc) {
            $filePath = $employee->documents[$i]['file_path'] ?? null; // Keep old if no new file uploaded
            if (isset($doc['file']) && $doc['file'] instanceof \Illuminate\Http\UploadedFile) {
                $filePath = $doc['file']->store('documents');
            }
            $documents[] = [
                'type' => $doc['type'],
                'file_path' => $filePath,
            ];
        }
    }

    // Prepare previous companies array
    $previousCompanies = [];
    if ($request->filled('previous_companies')) {
        foreach ($request->previous_companies as $prev) {
            $previousCompanies[] = [
                'company' => $prev['company'],
                'salary' => $prev['salary'],
            ];
        }
    }

    // Update employee data
    $employee->fill($validated);
    $employee->skills = $skills;
    $employee->documents = $documents;
    $employee->previous_companies = $previousCompanies;
    $employee->save();

    return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
}


    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
  