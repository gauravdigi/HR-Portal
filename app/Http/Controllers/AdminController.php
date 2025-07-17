<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Holiday;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class AdminController extends Controller
{
        public function dashboard(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $status = $request->input('status');
        $isStatusFilled = $status !== null && trim($status) !== '';

        $employees = DB::table('employees')
            ->join('users', 'users.employee_id', '=', 'employees.id')
            ->select(
                'employees.*',
                'users.name as user_name',
                'users.email as user_email',
                'users.role as user_role',
                'users.is_deleted as user_is_deleted'
            )

                // 🔒 Filter by approval status
                ->when($isStatusFilled, function ($query) use ($status) {
                    $query->where('employees.is_approved', (int) $status)
                          ->where('users.is_deleted', 0); // ✅ Only if status is filled, filter out deleted users
                })

            // 📅 Only filter out past employees if ?past is NOT set
            ->when(!$request->filled('past'), function ($query) use ($today) {
                $query->where(function ($q) use ($today) {
                    $q->whereNull('employees.release_date')
                      ->orWhereDate('employees.release_date', '>=', $today);
                });
            })

            // // ❗ Deleted users
            // ->when($request->has('deleted') && $isStatusFilled, function ($query) {
            //     $query->where('users.is_deleted', 1);
            // }, function ($query) {
            //     $query->where('users.is_deleted', 0);
            // })

            ->get();

            // If the request is AJAX, return only HTML fragment
            if ($request->ajax()) {
                return view('admin.dashboard', compact('employees'))->render();
            }

        //dd($employees);
        //$employees = Employee::all(); // Fetch all employees
        return view('admin.dashboard', compact('employees'));   
    }                        
        
    public function changePassword(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:users,employee_id',
            'password'    => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('employee_id', $request->employee_id)->firstOrFail();
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['success' => true, 'message' => 'Password updated successfully.']);
    }

public function updateStatus(Request $request)
{
    $request->validate([
        'employee_id' => 'required|exists:employees,id',
        'status' => 'required|in:1,2,3',
    ]);

    $employee = Employee::findOrFail($request->employee_id);
    $employee->is_approved = (int) $request->status;
    $employee->save();

    $statusMap = [
        1 => ['label' => 'Pending',  'class' => 'warning'],
        2 => ['label' => 'Approved', 'class' => 'success'],
        3 => ['label' => 'Rejected', 'class' => 'danger'],
    ];

    $statusCode = (int) $employee->is_approved;

    return response()->json([
        'success' => true,
        'message' => 'Status updated successfully',
        'statusText' => $statusMap[$statusCode]['label'] ?? 'Unknown',
        'statusClass' => $statusMap[$statusCode]['class'] ?? 'secondary',
    ]);
}


    // Display a list of employees
 public function index()
    {
        $todayCarbon = Carbon::today();
        $todayMonthDay = $todayCarbon->format('m-d');

        // 🎂 Dynamic celebration field
        $dateField = "IF(employees.celb_dob = '0000-00-00' OR employees.celb_dob IS NULL, employees.dob, employees.celb_dob)";

        // 🎂 Today's Birthdays
        $todayBirthdays = DB::table('employees')
            ->join('users', 'users.employee_id', '=', 'employees.id')
            ->whereRaw("DATE_FORMAT($dateField, '%m-%d') = ?", [$todayMonthDay])
            ->where('users.is_deleted', 0)
            ->where(function($query) use ($todayCarbon) {
                $query->whereNull('employees.release_date')
                      ->orWhereDate('employees.release_date', '>=', $todayCarbon);
            })
            ->select(
                'users.name',
                'users.email',
                'employees.designation',
                'employees.profile_image',
                'employees.celb_dob',
                DB::raw("$dateField as celb_dob")
            )
            ->get();

 $upcomingBirthdays = DB::table('employees')
    ->join('users', 'users.employee_id', '=', 'employees.id')
    ->where('users.is_deleted', 0)
    ->where(function($query) use ($todayCarbon) {
        $query->whereNull('employees.release_date')
              ->orWhereDate('employees.release_date', '>=', $todayCarbon);
    })
    ->whereRaw("
        (
            STR_TO_DATE(
                CONCAT(
                    IF(DATE_FORMAT($dateField, '%m-%d') >= DATE_FORMAT(CURDATE(), '%m-%d'),
                        YEAR(CURDATE()),
                        YEAR(CURDATE()) + 1
                    ),
                    '-', DATE_FORMAT($dateField, '%m-%d')
                ),
                '%Y-%m-%d'
            )
            BETWEEN DATE_ADD(CURDATE(), INTERVAL 1 DAY)
            AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)
        )
    ")
    // ✅ Exclude today's birthdays explicitly:
    ->whereRaw("DATE_FORMAT($dateField, '%m-%d') != ?", [$todayMonthDay])
    ->orderByRaw("DATE_FORMAT($dateField, '%m-%d')")
    ->select(
        'users.name',
        'users.email',
        'employees.designation',
        'employees.profile_image',
        'employees.celb_dob',
        DB::raw("$dateField as celb_dob")
    )
    ->get();



            // 📅 Upcoming Holidays in Next 30 Days
        $upcomingHolidays = Holiday::whereBetween('holiday_date', [Carbon::today(), Carbon::today()->addDays(30)])
            ->orderBy('holiday_date', 'asc')
            ->get();

        //$employees = Employee::all(); // Fetch all employees
        return view('admin.index', compact('todayBirthdays', 'upcomingBirthdays', 'upcomingHolidays'));
    }


     public function create()       
    {

        session()->forget('employee_id');
        $admins = User::where('role', 'admin')->get();

        $teamLeads = Employee::where('designation', 'Team Lead')
        ->where('is_approved', 2)
        ->get();

        $combinedLeads = collect();

        // Add admins (already have user_id)
        foreach ($admins as $admin) {
            $combinedLeads->push([
                'user_id' => $admin->id,
                'name' => $admin->name,
            ]);
        }

        foreach ($teamLeads as $team) {
            // Get corresponding user using employee_id
            $user = User::where('employee_id', $team->id)->first();

            // Skip if user not found or already added
            if ($user && !$combinedLeads->contains('user_id', $user->id)) {
                $combinedLeads->push([
                    'user_id' => $user->id,
                    'name' => $user->name, // ← using name from users table
                ]);
            }
        }


         $all_skills = config('hrp.skills_list');
        return view('admin.employe.create', compact('combinedLeads', 'all_skills'));
    }

   public function storeStep1(Request $request)
    {
        $employeeId = session('employee_id');
        $employee = $employeeId ? Employee::find($employeeId) : null;

        // Get existing user (if employee already exists)
        $user = $employee ? User::where('employee_id', $employee->id)->first() : null;
        $userId = $user ? $user->id : null;
        //dd($request->all());
        // Validation with conditional unique email
        $validator = \Validator::make($request->all(), [
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'employeeID'     => 'required|string|max:255|unique:employees,digi_id',
            'gender'         => 'required|string',
            'official_email' => ['required', 'email', Rule::unique('users', 'email')->ignore($userId)],  
            'email' => ['required', 'email'],   
            'dob'            => 'required|date',
            'celb_dob'       => 'required|date',   
            'blood_group'    => 'nullable|string|max:10',
            'phone'          => 'required|string|max:20',
            'linkedin_url' => 'nullable|url|max:255',
            'emergency_contacts' => 'nullable|array|min:1|max:2',
            'emergency_contacts.*.name' => 'required|string|max:255',
            'emergency_contacts.*.relation' => 'required|string|max:100',
            'emergency_contacts.*.phone' => 'required|string|max:20|different:phone',
            'profile_image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'voter_id'       => 'nullable|string|max:50',
            'pan'            => 'required|string|max:50',
            'aadhar'         => 'required|string|max:16',
            'designation'    => 'nullable|string|max:255',
            'role'           => 'required|string',
            'team_lead'      => 'required|string|max:255',
            'joining_date'   => 'required|date',
            'exp_years'      => 'nullable|integer|min:0',
            'exp_months'     => 'nullable|integer|min:0|max:11',
            'salary'         => 'nullable|numeric|min:0',
            'inc_years'      => 'nullable|integer|min:0',
            'inc_months'     => 'nullable|integer|min:0|max:11',
            'probation_end'  => 'nullable|date',
            'release_date'   => 'nullable|date',
            'password'       => $user ? 'nullable|confirmed' : 'required|confirmed',
        ]);

        // ✅ Add custom validation: emergency contacts must not have same phone
        $validator->after(function ($validator) use ($request) {
            $contacts = $request->input('emergency_contacts', []);
            $phones = array_column($contacts, 'phone');
            $duplicates = array_filter(array_count_values($phones), fn($count) => $count > 1);

            if (!empty($duplicates)) {
                $validator->errors()->add('emergency_contacts', 'Emergency contacts must have different phone numbers.');
            }
        });

        $validated = $validator->validate();

        $validated['digi_id'] = $validated['employeeID'];
        unset($validated['employeeID']);
        // Handle profile image upload
     if ($request->hasFile('profile_image')) {
                $file = $request->file('profile_image');

                // Safely get full name
                $fullName = $request->first_name . ' ' . $request->last_name;
                $fullnameSlug = Str::slug($fullName, '_');
                
                $extension = $file->getClientOriginalExtension();

                // Base filename without extension
                $baseFilename = "{$fullnameSlug}_profile";

                $filename = "{$baseFilename}.{$extension}";
                $path = "profile_images/{$filename}";

                $counter = 1;
                while (Storage::disk('public')->exists($path)) {
                    // Generate new filename with increment if exists
                    $filename = "{$baseFilename}_{$counter}.{$extension}";
                    $path = "profile_images/{$filename}";
                    $counter++;
                }

                // Store the file with the unique filename
                $storedPath = $file->storeAs('profile_images', $filename, 'public');

                $validated['profile_image'] = $storedPath;
            }
        if ($request->filled('emergency_contacts')) {
            $validated['emergency_contacts'] = $request->input('emergency_contacts') ?? [];
        }


        $salt = config('app.salary_salt');
        $salaryWithSalt = $salt . $validated['salary'];

        $encryptedSalary = Crypt::encryptString($salaryWithSalt);
        $validated['salary'] =  $encryptedSalary;

        // Create or update Employee
        if ($employee) {
            $employee->update($validated);
        } else {
            $employee = new Employee($validated);
            $employee->save();
            session(['employee_id' => $employee->id]);
        }

        // Create or update User
        if ($employee->id) {
            $user = User::where('employee_id', $employee->id)->first();

            if (!$user && !empty($request->password)) {
                $user = new User();
                $user->employee_id = $employee->id;
            }

            if ($user) {
                $user->name  = $request->first_name . ' ' . $request->last_name;
                $user->email = $request->official_email;
                $user->role  = $request->role;

                if (!empty($request->password)) {
                    $user->password = Hash::make($request->password);
                }

                $user->save();
            }
        }

        return response()->json([
            'employee_id' => $employee->id,
            'success' => true
        ]);
    }


    public function storeStep2(Request $request)
    {

        $employeeId = session('employee_id');
        $employee = Employee::find($employeeId);
        if (!$employee) return response()->json(['error' => 'Employee not found'], 404);

        $validated = $request->validate($this->addressValidationRules());
        $employee->update($validated);

        return response()->json(['employee_id' => $employeeId, 'success' => true]);
    }

    public function storeStep3(Request $request)
    {

        $employeeId = session('employee_id');
        $employee = Employee::find($employeeId);
        if (!$employee) return response()->json(['error' => 'Employee not found'], 404);

        $validated = $request->validate($this->bankValidationRules());
        $employee->update($validated);

        return response()->json(['employee_id' => $employee->id, 'success' => true]);
    }

    public function storeStep4(Request $request)
    {
        $employeeId = session('employee_id');
        $employee = Employee::find($employeeId);
        if (!$employee) return response()->json(['error' => 'Employee not found'], 404);

        $employee->skills = $this->parseSkills($request);
        $employee->save();

        return response()->json(['employee_id' => $employee->id, 'success' => true]);
    }

    public function storeStep5(Request $request)
    {
        $employeeId = session('employee_id');
        $employee = Employee::find($employeeId);
        if (!$employee) return response()->json(['error' => 'Employee not found'], 404);

        $employee->documents = $this->parseDocuments($request);
        $employee->save();

        return response()->json(['employee_id' => $employee->id, 'success' => true]);
    }

    public function storeStep6(Request $request)
    {
       $employeeId = session('employee_id');
        $employee = Employee::find($employeeId);
        if (!$employee) return response()->json(['error' => 'Employee not found'], 404);

        $employee->previous_companies = $this->parsePreviousCompanies($request);
        // Mark employee as approved
        $employee->is_approved = 1;
        $employee->save();

        session()->forget('employee_id');
        

        return response()->json(['employee_id' => $employee->id, 'success' => true, 'message' => 'Employee added successfully!']);
    }


    // edit functions for update

 public function editStep1(Request $request)
{
    $employeeId = $request->id;
        $user = User::where('employee_id', $employeeId)->first();
        $userId = $user ? $user->id : null;

        $validator = \Validator::make($request->all(), [
                'id'             => 'required|exists:employees,id',
                'first_name'     => 'required|string|max:255',
                'last_name'      => 'required|string|max:255',
                'employeeID' => [
                        'required',
                        'string',
                        'max:255',
                        Rule::unique('employees', 'digi_id')->ignore($employeeId),
                    ],
                'gender'         => 'required|string',
                'official_email' => [
                    'required',
                    'email',
                    Rule::unique('users', 'email')->ignore($userId), // ✅ CORRECT
                ],
                'email' => [
                    'required',
                    'email',
                    Rule::unique('employees', 'email')->ignore($employeeId), // ✅ CORRECT
                ],
        'dob'            => 'required|date',
        'celb_dob'       => 'required|date',
        'phone'          => 'required|string|max:20',
        'role'           => 'required|string',
        'profile_image'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'emergency_contacts' => 'nullable|array|min:1|max:2',
        'emergency_contacts.*.name' => 'required|string|max:255',
        'emergency_contacts.*.relation' => 'required|string|max:100',
        'emergency_contacts.*.phone' => 'required|string|max:20|different:phone',
        'pan'            => 'required|string|max:50',
        'aadhar'         => 'required|string|max:16',
        'team_lead'      => 'required|string|max:255',
        'joining_date'   => 'required|date',
    ]);

    // 🔁 Custom validation for duplicate emergency phones
    $validator->after(function ($validator) use ($request) {
        $contacts = $request->input('emergency_contacts', []);
        $phones = array_column($contacts, 'phone');
        $duplicates = array_filter(array_count_values($phones), fn($count) => $count > 1);

        if (!empty($duplicates)) {
            $validator->errors()->add('emergency_contacts', 'Emergency contact phone numbers must be different from each other.');
        }
    });

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422);
    }


    // ✅ Update Employee fields
    $employee = Employee::find($request->id);
    $userName = $request->first_name . ' ' . $request->last_name;

    $updateData = [
        'user_name'      => $userName,
        'digi_id'        => $request->employeeID,
        'gender'         => $request->gender,
        'user_email'     => $request->official_email,
        'dob'            => $request->dob,
        'celb_dob'       => $request->celb_dob,
        'blood_group'    => $request->blood_group,
        'phone'          => $request->phone,
        'linkedin_url'   => $request->linkedin_url,
        'emergency'      => $request->emergency,
        'official_email' => $request->official_email,
        'email'          => $request->email,
        'voter_id'       => $request->voter_id,
        'pan'            => $request->pan,
        'aadhar'         => $request->aadhar,
        'designation'    => $request->designation,
        'user_role'      => $request->role,
        'team_lead'      => $request->team_lead,
        'joining_date'   => $request->joining_date,
        'exp_years'      => $request->exp_years,
        'exp_months'     => $request->exp_months,
        'salary'         => $request->salary,
        'inc_years'      => $request->inc_years,
        'inc_months'     => $request->inc_months,
        'probation_end'  => $request->probation_end,
        'release_date'   => $request->release_date,
    ];
if ($request->hasFile('profile_image')) {
    $file = $request->file('profile_image');

    // Safely get full name for naming
    $fullName = $userName;
    $fullnameSlug = Str::slug($fullName, '_');

    $extension = $file->getClientOriginalExtension();
    $baseFilename = "{$fullnameSlug}_profile";
    $filename = "{$baseFilename}.{$extension}";
    $path = "profile_images/{$filename}";

    $counter = 1;
    while (Storage::disk('public')->exists($path)) {
        $filename = "{$baseFilename}_{$counter}.{$extension}";
        $path = "profile_images/{$filename}";
        $counter++;
    }

    // ✅ Delete old profile image from storage if it exists
    if (!empty($employee->profile_image) && Storage::disk('public')->exists($employee->profile_image)) {
        Storage::disk('public')->delete($employee->profile_image);
    }

    // ✅ Store new image
    $storedPath = $file->storeAs('profile_images', $filename, 'public');

    // ✅ Update database
    $updateData['profile_image'] = $storedPath;
}



    if ($request->filled('emergency_contacts')) {
        $updateData['emergency_contacts'] = $request->input('emergency_contacts');
    }

        // ✅ Encrypt salary if present
        if (!empty($updateData['salary'])) {
            $salt = config('app.salary_salt');
            $salaryWithSalt = $salt . $updateData['salary'];
            $encryptedSalary = Crypt::encryptString($salaryWithSalt);
            $updateData['salary'] = $encryptedSalary;
        }

    $employee->update($updateData);

    if ($employee->id) {
            $user = User::where('employee_id', $employee->id)->first();

            if (!$user && !empty($request->password)) {
                $user = new User();
                $user->employee_id = $employee->id;
            }
                //dd($request->role);
            if ($user) {
                $user->name  = $request->first_name . ' ' . $request->last_name;
                $user->email = $request->official_email;
                $user->role  = $request->role;

                if (!empty($request->password)) {
                    $user->password = bcrypt($request->password);
                }

                $user->save();
            }
            
        }

    return response()->json(['success' => true, 'message' => 'Step 1 updated successfully.']);
}

    public function editStep2(Request $request)
    {

        $validator = \Validator::make($request->all(), [
                'id'             => 'required|exists:employees,id',
                'address_perm'   => 'required|string',
                'state_perm'     => 'required|string',
                'city_perm'      => 'required|string',
                'zip_perm'       => 'required|string',
                'country_perm'   => 'required|string',
                'address_local'  => 'required|string',
                'state_local'    => 'required|string',
                'city_local'     => 'required|string',
                'zip_local'      => 'required|string',
                'country_local'  => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

  
        $employee = Employee::find($request->id);

        $updateData = [
            'address_perm'   => $request->address_perm,
            'state_perm'     => $request->state_perm,
            'city_perm'      => $request->city_perm,
            'zip_perm'       => $request->zip_perm,
            'country_perm'   => $request->country_perm,
            'address_local'  => $request->address_local,
            'state_local'    => $request->state_local,
            'city_local'     => $request->city_local,
            'zip_local'      => $request->zip_local,
            'country_local'  => $request->country_local,
        ];
         
        // ✅ Perform update
        $employee->update($updateData);

        return response()->json(['success' => true, 'message' => 'Update setp 2']);

    }

    public function editStep3(Request $request)
    {

        $validator = \Validator::make($request->all(), [
                'id'             => 'required|exists:employees,id',
                'acc_name'       => 'required|string',
                'acc_no'         => 'required|string',
                'confirm_acc_no' => 'required|string|same:acc_no',
                'bank_name'      => 'required|string',
                'ifsc'           => 'required|string',
                'branch_address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

  
        $employee = Employee::find($request->id);

        $updateData = [
            'acc_name'       => $request->acc_name,
            'acc_no'         => $request->acc_no,
            'confirm_acc_no' => $request->confirm_acc_no,
            'bank_name'      => $request->bank_name,
            'ifsc'           => $request->ifsc,
            'branch_address' => $request->branch_address,
        ];
         
        // ✅ Perform update
        $employee->update($updateData);

        return response()->json(['success' => true, 'message' => 'Update setp 3']);

    }

    public function editStep4(Request $request)
    {   
            $validator = \Validator::make($request->all(), [
                'id'                => 'required|exists:employees,id',
                'skills' => 'nullable|array',
                'skills.*.name' => 'nullable|string|max:255',
                'skills.*.years' => 'nullable|numeric|min:0',
                'skills.*.months' => 'nullable|numeric|min:0|max:11',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            $employee = Employee::find($request->id);

            $skills = [];
            if ($request->filled('skills')) {
                foreach ($request->skills as $i => $skill) {
                    $skills[] = [
                        'name' => $skill['name'] ?? '',
                        'years' => $skill['years'] ?? 0,
                        'months' => $skill['months'] ?? 0,
                    ];
                }
            }

            $employee->skills = $skills;
            $employee->save();

            return response()->json(['success' => true, 'message' => 'Skills updated']);

    }
public function editStep5(Request $request)
{
    $validator = \Validator::make($request->all(), [
        'id' => 'required|exists:employees,id',
        'documents' => 'nullable|array',
        'documents.*.type' => 'nullable|string|max:255',
        'documents.*.file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422);
    }

    $employee = Employee::findOrFail($request->id);

    // ✅ Get full name from users table
    $user = User::where('employee_id', $employee->id)->first();
    $fullName = $user ? $user->name : 'employee';
    $cleanName = preg_replace('/\s+/', '_', strtolower($fullName));

    $newDocuments = [];

if ($request->has('documents')) {
    $newDocuments = [];

    foreach ($request->documents as $i => $doc) {
        $filePath = null;
        $uploadedFile = $request->file("documents.$i.file");

        if ($uploadedFile) {
            $extension = $uploadedFile->getClientOriginalExtension();
            $safeDocType = preg_replace('/\s+/', '_', strtolower($doc['type'] ?? 'document'));

            // Define base filename clearly
            $baseFileName = "{$cleanName}-{$safeDocType}";
            $fileName = "{$baseFileName}.{$extension}";
            $path = "documents/{$fileName}";

            if (!\Storage::disk('public')->exists('documents')) {
                \Storage::disk('public')->makeDirectory('documents');
            }

            // Check for existing and increment if needed
            $counter = 1;
            while (\Storage::disk('public')->exists($path)) {
                $fileName = "{$baseFileName}_{$counter}.{$extension}";
                $path = "documents/{$fileName}";
                $counter++;
            }

            // Store the file
            $filePath = $uploadedFile->storeAs('documents', $fileName, 'public');

        } elseif (!empty($doc['existing_file'])) {
            $filePath = $doc['existing_file'];
        }

        if (!empty($doc['type']) || $filePath) {
            $newDocuments[] = [
                'type' => $doc['type'] ?? null,
                'file_path' => $filePath,
            ];
        }
    }
}


    // ✅ If no documents remain, clear the column in DB
    $employee->documents = count($newDocuments) > 0 ? $newDocuments : null;
    $employee->save();

    return response()->json(['success' => true, 'message' => 'Documents updated']);
}


    public function editStep6(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'id' => 'required|exists:employees,id',
            'previous_companies' => 'nullable|array',
            'previous_companies.*.company' => 'nullable|string|max:255',
            'previous_companies.*.salary' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $employee = Employee::findOrFail($request->id);

        $companies = [];

        if ($request->filled('previous_companies')) {
            foreach ($request->previous_companies as $prev) {
                $companies[] = [
                    'company' => $prev['company'] ?? null,
                    'salary' => $prev['salary'] ?? null,
                ];
            }
        }
         // Mark employee as approved
        if ($employee->is_approved == 0) {
            $employee->is_approved = 1;
        }else{

        }

        $employee->previous_companies = $companies;
        $employee->save();

        return response()->json(['success' => true, 'message' => 'Employee updated successfully']);
    }

public function edit($id)
{


    // $employee = Employee::findOrFail($id);

    $employee = DB::table('employees')
        ->join('users', 'users.employee_id', '=', 'employees.id')
        ->where('employees.id', $id)
        ->select('employees.*', 'users.name as user_name', 'users.email as user_email', 'users.role as user_role')
        ->first();
            $firstName = '';
            $lastName = '';

            if ($employee && $employee->user_name) {

                $nameParts = explode(' ', trim($employee->user_name));
                $firstName = array_shift($nameParts); // Take first word
                $lastName = implode(' ', $nameParts); // Everything else as last name

            }
            // dd($employee);
                session(['employee_id' => $id]);

                  $admins = User::where('role', 'admin')->get();

                $teamLeads = Employee::where('designation', 'Team Lead')
                ->where('is_approved', 2)
                ->get();

                $combinedLeads = collect();

                // Add admins (already have user_id)
                foreach ($admins as $admin) {
                    $combinedLeads->push([
                        'user_id' => $admin->id,
                        'name' => $admin->name,
                    ]);
                }

                foreach ($teamLeads as $team) {
                    // Get corresponding user using employee_id
                    $user = User::where('employee_id', $team->id)->first();

                    // Skip if user not found or already added
                    if ($user && !$combinedLeads->contains('user_id', $user->id)) {
                        $combinedLeads->push([
                            'user_id' => $user->id,
                            'name' => $user->name, // ← using name from users table
                        ]);
                    }
                }


           // Get the currently authenticated user
        $currentUser = auth()->user();

        // Dynamically determine if role field should be disabled
        $disableRoleChange = false;

        if (
            $currentUser->role === 'admin' &&
            $employee->user_email === $currentUser->email
        ) {
            $disableRoleChange = true;
        }


    return view('admin.employe.edit', compact('employee','id', 'combinedLeads', 'firstName', 'lastName', 'disableRoleChange'));
}
  

public function update(Request $request, Employee $employee)
    {
        $validated = [];

        // ✅ Only validate and include personal data if it's not already filled
        if (!$employee->email ) {
            $validated += $request->validate($this->personalValidationRulesUpdate($employee->id));
        }

        // ✅ Always validate address and bank
        $validated += $request->validate($this->addressValidationRules());
        $validated += $request->validate($this->bankValidationRules());

        // ✅ Only update profile image if uploaded
        if ($request->hasFile('profile_image')) {
            $validated['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
        }

        $employee->fill($validated);

        // ✅ Always update JSON fields
        $employee->skills = $this->parseSkills($request);
        $employee->documents = $this->parseDocuments($request);
        $employee->previous_companies = $this->parsePreviousCompanies($request);

        $employee->save();

        return redirect()->route('admin.dashboard')->with('success', 'Employee updated successfully.');
    }

    private function personalValidationRules()
    {

        return [
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'gender'         => 'required|string',
            'email'          => 'required|email|unique:users,email',
            'dob'            => 'required|date',
            'blood_group'    => 'nullable|string|max:10',
            'phone'          => 'required|string|max:15',
            'emergency'      => 'required|string|max:15|different:phone',
            'official_email' => 'required|email',
            'profile_image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'voter_id'       => 'nullable|string|max:50',
            'pan'            => 'required|string|max:50',
            'aadhar'         => 'required|string|max:16',
            'designation'    => 'nullable|string|max:255',
            'role'           => 'required|string',
            'team_lead'      => 'required|string|max:255',
            'joining_date'   => 'required|date',
            'exp_years'      => 'nullable|integer|min:0',
            'exp_months'     => 'nullable|integer|min:0|max:11',
            'salary'         => 'nullable|numeric|min:0',
            'inc_years'      => 'nullable|integer|min:0',
            'inc_months'     => 'nullable|integer|min:0|max:11',
            'probation_end'  => 'nullable|date',
            'release_date'   => 'nullable|date',
        ];
    }

    private function personalValidationRulesUpdate($employeeId)
    {

        //$employeeId = session('employee_id');

        return [
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'gender'         => 'required|string',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($employeeId, 'employee_id'),
            ],
            'dob'            => 'required|date',
            'blood_group'    => 'nullable|string|max:10',
            'phone'          => 'required|string|max:15',
            'emergency'      => 'required|string|max:15|different:phone',
            'official_email' => 'required|email',
            'profile_image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'voter_id'       => 'nullable|string|max:50',
            'pan'            => 'required|string|max:50',
            'aadhar'         => 'required|string|max:16',
            'designation'    => 'nullable|string|max:255',
            'role'           => 'required|string',
            'team_lead'      => 'required|string|max:255',
            'joining_date'   => 'required|date',
            'exp_years'      => 'nullable|integer|min:0',
            'exp_months'     => 'nullable|integer|min:0|max:11',
            'salary'         => 'nullable|numeric|min:0',
            'inc_years'      => 'nullable|integer|min:0',
            'inc_months'     => 'nullable|integer|min:0|max:11',
            'probation_end'  => 'nullable|date',
            'release_date'   => 'nullable|date',
        ];
    }

    private function addressValidationRules()
    {
        return [
            'address_perm'   => 'required|string',
            'state_perm'     => 'required|string',
            'city_perm'      => 'required|string',
            'zip_perm'       => 'required|string',
            'country_perm'   => 'required|string',
            'address_local'  => 'required|string',
            'state_local'    => 'required|string',
            'city_local'     => 'required|string',
            'zip_local'      => 'required|string',
            'country_local'  => 'required|string',
        ];
    }

    private function bankValidationRules()
    {
        return [
            'acc_name'       => 'required|string',
            'acc_no'         => 'required|string',
            'confirm_acc_no' => 'required|string|same:acc_no',
            'bank_name'      => 'required|string',
            'ifsc'           => 'required|string',
            'branch_address' => 'nullable|string',
        ];
    }

    private function parseSkills(Request $request)
    {
        $skills = [];
       if ($request->filled('skills')) {
                foreach ($request->skills as $i => $skill) {
                    $skills[] = [
                        'name' => $skill['name'] ?? '',
                        'years' => $skill['years'] ?? 0,
                        'months' => $skill['months'] ?? 0,
                    ];
                }
            }
        return $skills;
    }

private function parseDocuments(Request $request)
{
    $documents = [];

    if ($request->has('documents')) {
        $employee = Employee::find(session('employee_id'));
        $firstName = preg_replace('/\s+/', '_', strtolower($employee->first_name ?? 'employee'));
         $user = User::where('employee_id', $employee->id)->first();
    $fullName = $user ? $user->name : 'employee';
    $cleanName = preg_replace('/\s+/', '_', strtolower($fullName));

        foreach ($request->documents as $i => $doc) {
            $filePath = null;
            $uploadedFile = $request->file("documents.$i.file");

            if ($uploadedFile) {
                $extension = $uploadedFile->getClientOriginalExtension();
                $safeDocType = preg_replace('/\s+/', '_', strtolower($doc['type'] ?? 'document'));
                 $baseFileName = "{$cleanName}-{$safeDocType}";
                $fileName = "{$firstName}-{$safeDocType}." . $extension;
                 $path = "documents/{$fileName}";
                // Ensure the documents directory exists
                if (!\Storage::disk('public')->exists('documents')) {
                    \Storage::disk('public')->makeDirectory('documents');
                }
                 // Check for existing and increment if needed
                $counter = 1;
                while (\Storage::disk('public')->exists($path)) {
                    $fileName = "{$baseFileName}_{$counter}.{$extension}";
                    $path = "documents/{$fileName}";
                    $counter++;
                }

                $filePath = $uploadedFile->storeAs('documents', $fileName, 'public');
            }

            $documents[] = [
                'type' => $doc['type'] ?? null,
                'file_path' => $filePath,
            ];
        }
    }

    return $documents;
}


    private function parsePreviousCompanies(Request $request)
    {
        $companies = [];
        if ($request->filled('previous_companies')) {
            foreach ($request->previous_companies as $prev) {
                $companies[] = [
                    'company' => $prev['company'],
                    'salary' => $prev['salary'],
                ];
            }
        }
        return $companies;
    }


public function destroy($id)
{
    // Find the employee (optional, if you still need it)
    $employee = Employee::findOrFail($id);

    // Find the related user by employee_id (assuming this relationship exists)
    $user = User::where('employee_id', $employee->id)->first();

    if ($user) {
        $user->is_deleted = 1;
        $user->save();
    }

    return redirect()->route('admin.dashboard')->with('success', 'User soft deleted successfully.');
} 

    public function approve(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $status = $request->input('is_approved');

        if (!in_array($status, [0, 1, 2, 3])) {
            return back()->with('error', 'Invalid status selected.');
        }

        $employee->is_approved = $status;
        $employee->save();

        return back()->with('approve', 'Status updated successfully.');
    }

    // view function
    public function view($id)
    {
        //$employee = Employee::findOrFail($id);
        $employee = DB::table('employees')
        ->join('users', 'users.employee_id', '=', 'employees.id')
        ->where('employees.id', $id)
        ->select('employees.*', 'users.name as user_name', 'users.email as user_email','users.role as user_role') // add more fields if needed
        ->first();

            // ✅ Manually decode JSON fields
            if ($employee) {
               $user = User::find($employee->team_lead);

                if ($user) {
                    $team_lead = $user->name;
                }
                $employee->skills = json_decode($employee->skills, true) ?? [];
                $employee->documents = json_decode($employee->documents, true) ?? [];
                $employee->previous_companies = json_decode($employee->previous_companies, true) ?? [];
            }

            $salt = config('app.salary_salt');

            try {
                $decrypted = Crypt::decryptString($employee->salary);

                if (str_starts_with($decrypted, $salt)) {
                    $salary = substr($decrypted, strlen($salt));
                    $salary = (float) $salary; // ✅ ensure numeric
                } else {
                    $salary = null; // ✅ use null for failure
                }
            } catch (\Exception $e) {
                $salary = null; // ✅ use null for failure
            }

         $all_skills = config('hrp.skills_list');

        return view('admin.employe.view', compact('employee', 'all_skills', 'team_lead', 'salary'));
    }

    	
}     
