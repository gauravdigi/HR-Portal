<?php
namespace App\Http\Controllers;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class AccountantController extends Controller
{
    public function dashboard()
    {  
	//die('here');
        return view('accountant.dashboard');
    }

		public function index(Request $request)
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
                return view('accountant.employe.index', compact('employees'))->render();
            }

			return view('accountant.employe.index', compact('employees'));
		}
   


			public function show($id)
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
	            $all_skills = ["1" => ". ASP NET (Web forms)",
                        "2" => "SQL",
                        "3" => "JAVASCRIPT &amp; JQuery",
                        "4" => "EntityFramework",
                        "5" => "WPF",
                        "6" => "WCF",
                        "7" => "Web API",
                        "8" => "MVC",
                        "9" => ".NET Core",
                        "10" => "My SQL",
                        "11" => "Window Forms",
                        "12" => "VB.NET",
                        "13" => "Sales Force",
                        "14" => "Visual Basic",
                        "15" => "C#",
                        "16" => "PostgreSQL",
                        "17" => "MongoDB",
                        "18" => "MS Access",
                        "19" => "Bootstrap",
                        "20" => "Ajax",
                        "21" => "DataTable.Js",
                        "22" => "C++",
                        "23" => "Swagger",
                        "24" => "SOAP",
                        "25" => "AWS",
                        "26" => "AWS lambda",
                        "27" => "Azure",
                        "28" => "SSRS",
                        "29" => "Crystal Reports",
                        "30" => "RDLC Reporting",
                        "31" => "Telerik Kendo UI",
                        "32" => "DevExpress",
                        "33" => "ADO.NET",
                        "34" => "LINQ",
                        "35" => "LeaveTypeID",
                        "36" => "Dapper",
                        "37" => "Stripe",
                        "38" => "Paypal",
                        "39" => "Authorize.NET",
                        "40" => "PhotoShop",
                        "41" => "HTML5",
                        "42" => "CSS3",
                        "44" => "ADOBE XD",
                        "45" => "FIGMA",
                        "46" => "Joomla",
                        "47" => "Core Php",
                        "48" => "Open Cart",
                        "49" => "Drupal",
                        "50" => "Codeigniter",
                        "51" => "Magento",
                        "53" => "Wordpress",
                        "54" => "Python",
                        "55" => "HRD",
                        "56" => "Recruitment",
                        "57" => "Talent Management",
                        "58" => "HRM",
                        "59" => "Industrial Relations",
                        "61" => "Training and development",
                        "62" => "Leadership",
                        "63" => "Adaptability",
                        "64" => "Conflict resolution",
                        "65" => "Decision-making",
                        "66" => "Organizational skills",
                        "68" => "Management",
                        "70" => "Interpersonal communication",
                        "71" => "Organization",
                        "72" => "Strategic thinking",
                        "74" => "Command of technology",
                        "75" => "Coaching",
                        "77" => "Performance management",
                        "78" => "Compensation",
                        "81" => "Managing priorities",
                        "83" => "Onboarding",
                        "120" => "Writing skills",
                        "122" => "Team player",
                        "123" => "Leadership skills",
                        "124" => "Legal Knowledge",
                        "125" => "Recruitment and Onboarding skills",
                        "126" => "Budget skills",
                        "127" => "Integrity &amp; Equity",
                        "129" => "Record management",
                        "130" => "Scheduling skills",
                        "131" => "Utilising Data",
                        "132" => "Career and Personal Development",
                        "133" => "Strategy &amp; Structure",
                        "134" => "Adaptability and Flexibility",
                        "135" => "Proactivity",
                        "137" => "Active Hearing",
                        "138" => "Cultural Sensitivity",
                        "139" => "Ethics at Work",
                        "140" => "Problem-Solving",
                        "141" => "Good understanding of technology",
                        "142" => "Inspiration &amp; Power",
                        "143" => "Administrative Expertise",
                        "144" => "Commercial Awareness",
                        "145" => "Wellbeing Evangelism",
                        "146" => "Advising",
                        "147" => "Data Analytics",
                        "148" => "HR Information Systems (HRIS)",
                        "149" => "Talent Acquisition Technology",
                        "150" => "Employee Engagement Platforms",
                        "151" => "Compliance and HR Regulations",
                        "152" => "Social Media Proficiency",
                        "153" => "HR Chatbots &amp; AI Automation",
                        "156" => "Automation Testing",
                        "157" => "Analytical skills",
                        "158" => "Time management",
                        "159" => "Problem solving",
                        "160" => "Agile testing",
                        "161" => "Coding",
                        "162" => "Systems development life cycle",
                        "165" => "Project management",
                        "166" => "Test management tools",
                        "167" => "Testing types knowledge",
                        "168" => "Communication",
                        "170" => "Manual testing",
                        "171" => "Technical proficiency",
                        "173" => "Performance testing",
                        "174" => "Test Case Design",
                        "175" => "Bug Tracking and Reporting",
                        "176" => "Regression Testing",
                        "177" => "Root Cause Analysis",
                        "178" => "Version Control Systems",
                        "179" => "Automation Framework Design",
                        "180" => "Test Script Development",
                        "181" => "Unit Testing",
                        "182" => "Integration Testing",
                        "183" => "API Testing",
                        "184" => "Security Testing",
                        "185" => "User  Acceptance Testing (UAT)",
                        "186" => "Cross-browser Testing",
                        "187" => "Load and Stress Testing",
                        "188" => "Performance Optimization",
                        "189" => "Database Testing",
                        "190" => "Test Data Management",
                        "191" => "Test Planning",
                        "192" => "Release Management",
                        "193" => "Risk Management",
                        "194" => "CI/CD",
                        "195" => "DevOps Knowledge",
                        "196" => "Cloud Testing",
                        "197" => "Test Environment Setup",
                        "198" => "Mobile Testing",
                        "199" => "Data Integrity Testing",
                        "200" => "Test Reporting and Metrics",
                        "201" => "Version Compatibility Testing",
                        "202" => "Test Execution and Result Analysis",
                        "203" => "End-to-End Testing",
                        "205" => "Client relationships",
                        "206" => "Business intelligence",
                        "209" => "Customer service",
                        "210" => "Developing sales strategies",
                        "211" => "Extensive presentation skills",
                        "212" => "Marketing",
                        "217" => "Ability to convince potential clients",
                        "218" => "Actively conducting market research",
                        "220" => "Creative and strategic thinking",
                        "221" => "Customer relationship management",
                        "223" => "Lead generation",
                        "225" => "Sales Forecasting",
                        "228" => "Negotiation Tactics",
                        "231" => "Strategic Partnerships",
                        "232" => "Networking",
                        "234" => "Budgeting and Financial Planning",
                        "236" => "Deal Closing",
                        "237" => "CRM Software Proficiency",
                        "238" => "Product Knowledge",
                        "239" => "Consultative Selling",
                        "240" => "Proposal Writing",
                        "241" => "Customer Needs Assessment",
                        "242" => "Account Management",
                        "243" => "Event Planning and Management",
                        "245" => "Digital Marketing",
                        "246" => "Sales Presentation Skills",
                        "247" => "Cross-functional Team Collaboration",
                        "249" => "Sales Reporting and Analytics",
                        "250" => "Key Account Management",
                        "251" => "B2B Sales Strategy",
                        "254" => "Customer Feedback Analysis",
                        "255" => "Prospecting",
                        "257" => "Objection handling",
                        "258" => "Relationship building",
                        "261" => "Presentation skills",
                        "262" => "Business acumen",
                        "263" => "Ask questions",
                        "270" => "Closing",
                        "272" => "Lead Qualification",
                        "273" => "Sales Target Achievement",
                        "274" => "Customer Needs Analysis",
                        "275" => "Sales Metrics and KPIs",
                        "276" => "Cross-selling and Upselling",
                        "277" => "Pipeline Management",
                        "278" => "Cold Calling",
                        "280" => "Sales Enablement",
                        "281" => "Sales Process Optimization",
                        "282" => "Deal Closing Strategies",
                        "283" => "Market Research",
                        "285" => "Product Launch Support",
                        "287" => "B2B Sales Expertise",
                        "288" => "B2C Sales Expertise",
                        "289" => "Negotiation and Persuasion Skills",
                        "291" => "Sales Presentations and Demos",
                        "292" => "Sales Proposal Writing",
                        "293" => "Team Selling ",
                        "294" => "Customer Service Excellence",
                        "295" => "Client Onboarding",
                        "296" => "Value-Based Selling",
                        "297" => "Customer Feedback Integration",
                        "299" => "Sales Training",
                        "300" => "Digital Sales Tools"];


				return view('accountant.employe.show', compact('employee', 'all_skills','team_lead', 'salary'));
			}
			
}    
