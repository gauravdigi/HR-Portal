<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;


class CandidateController extends Controller
{
       public function index(Request $request)
        {
            $all_skills = config('hrp.skills_list');

            $candidates = DB::table('candidates')
            ->when($request->filled('isdeleted') && $request->isdeleted == 1, function ($query) {
                // ✅ Show only deleted candidates, ignore other filters
                return $query->where('is_deleted', 1);
            }, function ($query) use ($request, $all_skills) {
                // ✅ Show active candidates with filters
                $query->where('is_deleted', 0);

                // Skills Filter
                if ($request->filled('skills')) {
                    $skills_raw = $request->skills; // ['3,10'] or ['3', '10']
                    $skills_ids = [];

                    foreach ($skills_raw as $item) {
                        $split_items = array_map('trim', explode(',', $item));
                        foreach ($split_items as $skill_id) {
                            if ($skill_id !== '') {
                                $skills_ids[] = $skill_id;
                            }
                        }
                    }

                    if (!empty($skills_ids)) {
                        $query->where(function ($q) use ($skills_ids) {
                            foreach ($skills_ids as $skill_id) {
                                $q->orWhere('skills', 'LIKE', '%"name":"' . $skill_id . '"%');
                            }
                        });
                    }
                }

                // Stream Filter
                if ($request->filled('stream')) {
                    $query->where('stream', $request->stream);
                }

                // Lead Source Filter
                if ($request->filled('lead_source')) {
                    $query->where('candidate_source', $request->lead_source);
                }
            })
            ->get();



            if ($request->ajax()) {
                //$html = view('candidates.index', compact('candidates'))->render();
                return view('candidates.index', compact('candidates'))->render();
            }

            return view('candidates.index', compact('candidates', 'all_skills'));
        }


    public function checkEmailExists(Request $request)
    {
        $email = $request->input('email');
        $ignoreId = $request->input('id'); // null for add, candidate id for edit

        $query = Candidate::where('email', $email);
        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        $exists = $query->exists();

        return response()->json(['exists' => $exists]);
    }


public function store(Request $request)
{
    // Force clean boolean values for validation
    $request->merge([
        'is_salary_negotiable' => $request->has('is_salary_negotiable') ? 1 : 0,
        'is_notice_negotiable' => $request->has('is_notice_negotiable') ? 1 : 0,
    ]);

    $validated = $request->validate([
        'first_name' => 'required|string|max:100',
        'last_name' => 'required|string|max:100',
        'email' => 'required|email|max:255|unique:candidates,email',
        'phone_number' => 'required|string|max:20',
        'alternate_phone_number' => 'nullable|string|max:20|different:phone_number',
        'total_experience_years' => 'nullable|integer|min:0',
        'total_experience_months' => 'nullable|integer|min:0|max:11',
        'current_company' => 'nullable|string|max:255',
        'ctc_per_month' => 'nullable|numeric|min:0',
        'ectc_per_month' => 'required|numeric|min:0',
        'is_salary_negotiable' => 'required|boolean',
        'salary_negotiable' => 'nullable|string|max:255',
        'notice_period_days' => 'nullable|integer|min:0',
        'is_notice_negotiable' => 'required|boolean',
        'notice_negotiable_days' => 'nullable|integer|min:0',
        'linkedin_url' => 'nullable|url|max:255',
        'candidate_source' => 'required|string|max:100',
        'current_designation' => 'nullable|string|max:100',
        'applied_designation' => 'required|string|max:100',
        'stream' => 'required|string|max:100',
        'remark' => 'nullable|string|max:255',
        'reason' => 'nullable|string|max:255',
        'resume' => 'nullable|mimes:pdf,doc,docx|max:2048',
        'skills' => 'nullable|array',
        'skills.*.name' => 'nullable|string|max:255',
        'skills.*.exp_years' => 'nullable|numeric|min:0',
        'skills.*.exp_months' => 'nullable|numeric|min:0|max:11',
    ]);

       // Handle resume storage with custom name
    if ($request->hasFile('resume')) {
        $file = $request->file('resume');
        $extension = $file->getClientOriginalExtension();
        $firstName = preg_replace('/\s+/', '_', strtolower($validated['first_name']));
        $lastName = preg_replace('/\s+/', '_', strtolower($validated['last_name']));
        $baseFileName = "{$firstName}_{$lastName}_resume";
        $fileName = "{$baseFileName}.{$extension}";
        $path = "resumes/{$fileName}";

        $counter = 1;
        while (\Storage::disk('public')->exists($path)) {
            $fileName = "{$baseFileName}_{$counter}.{$extension}";
            $path = "resumes/{$fileName}";
            $counter++;
        }

        // Save under resumes/ folder in public disk
        $storedPath = $file->storeAs('resumes', $fileName, 'public');
        $validated['resume_path'] = $storedPath;
    }

    // Serialize skills if using JSON column
    $validated['skills'] = json_encode($validated['skills'] ?? []);

    Candidate::create($validated);

    return redirect()->route('candidates.index')->with(['success' => 'Candidate added successfully.', 'title' => 'Added']);
}



    // 🖊️ Edit candidate
    public function edit($id) {
        $candidate = Candidate::findOrFail($id);

        return response()->json($candidate);
    }

    // public function editeee(Request $request)
    // {
    //     $candidate = Candidate::findOrFail($request->id);

    //     $validator = \Validator::make($request->all(), [
    //         'id' => 'required|exists:candidates,id',
    //         'first_name' => 'required|string|max:100',
    //         'last_name' => 'required|string|max:100',
    //         'email' => [
    //             'required',
    //             'email',
    //             'max:255',
    //             Rule::unique('candidates', 'email')->ignore($candidate->id),
    //         ],
    //         'phone_number' => 'required|string|max:20',
    //         'alternate_phone_number' => 'nullable|string|max:20',
    //         'total_experience_years' => 'nullable|integer|min:0',
    //         'total_experience_months' => 'nullable|integer|min:0|max:11',
    //         'current_company' => 'nullable|string|max:255',
    //         'ctc_per_month' => 'nullable|numeric|min:0',
    //         'ectc_per_month' => 'required|numeric|min:0',
    //         'is_salary_negotiable' => 'nullable|boolean',
    //         'salary_negotiable' => 'nullable|string|max:255',
    //         'notice_period_days' => 'nullable|integer|min:0',
    //         'is_notice_negotiable' => 'nullable|boolean',
    //         'notice_negotiable_days' => 'nullable|integer|min:0',
    //         'linkedin_url' => 'nullable|url|max:255',
    //         'candidate_source' => 'required|string|max:100',
    //         'current_designation' => 'nullable|string|max:100',
    //         'applied_designation' => 'required|string|max:100',
    //         'stream' => 'required|string|max:100',
    //         'remark' => 'nullable|string|max:255',
    //         'resume' => 'nullable|mimes:pdf,doc,docx|max:2048',
    //         'skills' => 'nullable|array',
    //         'skills.*.name' => 'nullable|string|max:255',
    //         'skills.*.exp_years' => 'nullable|numeric|min:0',
    //         'skills.*.exp_months' => 'nullable|numeric|min:0|max:11',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }

    //     $updateData = $validator->validated();

    //     if ($request->hasFile('resume')) {
    //         $path = $request->file('resume')->store('candidate_resumes', 'public');
    //         $updateData['resume'] = $path;
    //     }

    //     $candidate->update($updateData);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Candidate updated successfully.'
    //     ]);
    // }

  public function update(Request $request, Candidate $candidate)
{
    // ✅ Normalize checkbox values before validation
    $request->merge([
        'is_salary_negotiable' => $request->has('is_salary_negotiable') ? 1 : 0,
        'is_notice_negotiable' => $request->has('is_notice_negotiable') ? 1 : 0,
    ]);

    $rules = [
        'first_name' => 'required|string|max:100',
        'last_name' => 'required|string|max:100',
        'phone_number' => 'required|string|max:20',
        'alternate_phone_number' => 'nullable|string|max:20|different:phone_number',
        'total_experience_years' => 'nullable|integer|min:0',
        'total_experience_months' => 'nullable|integer|min:0|max:11',
        'current_company' => 'nullable|string|max:255',
        'ctc_per_month' => 'nullable|numeric|min:0',
        'ectc_per_month' => 'required|numeric|min:0',
        'is_salary_negotiable' => 'nullable|boolean',
        'salary_negotiable' => 'nullable|string|max:255',
        'notice_period_days' => 'nullable|integer|min:0',
        'is_notice_negotiable' => 'nullable|boolean',
        'notice_negotiable_days' => 'nullable|integer|min:0',
        'linkedin_url' => 'nullable|url|max:255',
        'candidate_source' => 'required|string|max:100',
        'current_designation' => 'nullable|string|max:100',
        'applied_designation' => 'required|string|max:100',
        'stream' => 'required|string|max:100',
        'remark' => 'nullable|string|max:255',
        'reason' => 'nullable|string|max:255',
        'resume' => 'nullable|mimes:pdf,doc,docx|max:2048',
        'skills' => 'nullable|array',
        'skills.*.name' => 'nullable|string|max:255',
        'skills.*.exp_years' => 'nullable|numeric|min:0',
        'skills.*.exp_months' => 'nullable|numeric|min:0|max:11',
    ];

    if ($request->email === $candidate->email) {
        $rules['email'] = ['required', 'email', 'max:255'];
    } else {
        $rules['email'] = [
            'required',
            'email',
            'max:255',
            Rule::unique('candidates', 'email')->ignore($candidate->id),
        ];
    }

    $validated = $request->validate($rules);

    // Handle resume upload
if ($request->hasFile('resume')) {
    $file = $request->file('resume');
    $extension = $file->getClientOriginalExtension();
    $firstName = preg_replace('/\s+/', '_', strtolower($validated['first_name']));
    $lastName = preg_replace('/\s+/', '_', strtolower($validated['last_name']));
    $baseFileName = "{$firstName}_{$lastName}_resume";
    $fileName = "{$baseFileName}.{$extension}";
    $path = "resumes/{$fileName}";

    $counter = 1;
    while (\Storage::disk('public')->exists($path)) {
        $fileName = "{$baseFileName}_{$counter}.{$extension}";
        $path = "resumes/{$fileName}";
        $counter++;
    }

    // Save under resumes/ folder in public disk
    $storedPath = $file->storeAs('resumes', $fileName, 'public');
    $validated['resume_path'] = $storedPath;
}

    // Ensure skills stored correctly
    $validated['skills'] = !empty($validated['skills']) ? $validated['skills'] : NULL;

    $candidate->update($validated);

    return redirect()->route('candidates.index')->with(['success' => 'Candidate updated successfully.', 'title' => 'Updated']);
}


    public function destroy(Candidate $candidate)
    {
        // Optionally delete resume file if you want to clear storage on soft delete
        if ($candidate->resume_path && Storage::disk('public')->exists($candidate->resume_path)) {
            Storage::disk('public')->delete($candidate->resume_path);
            $candidate->resume_path = null;
        }

        $candidate->is_deleted = 1;
        $candidate->save();

        return redirect()->route('candidates.index')->with(['success' => 'Candidate deleted successfully.', 'title' => 'Deleted']);
    }
    public function restore($id)
    {
        $candidate = Candidate::findOrFail($id);
        $candidate->is_deleted = 0;
        $candidate->save();

        return redirect()->route('candidates.index')->with(['success' => 'Candidate restored successfully.', 'title' => 'Restored']);
    }

    public function show(Candidate $candidate)
    {
        return response()->json([
            'candidate' => $candidate,
        ]);
    }


}
