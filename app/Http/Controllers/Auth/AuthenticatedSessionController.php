<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;      

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    protected function redirectTo()
{
    $role = auth()->user()->role;

    switch ($role) {
        case 'admin':
            return '/admin';
        case 'hr':
            return '/hr';
        case 'accountant':
            return '/accountant/employe';
        case 'employee':
            return '/employee/dashboard';
        default:
            return '/';
    }
}


    /**
     * Handle an incoming authentication request.
     */
public function store(LoginRequest $request): RedirectResponse
{
    $request->validate([      
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Fetch user by email
    $user = \App\Models\User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => 'No account found.'])->withInput();
    }

    // 🔒 Block deleted users
    if ($user->is_deleted == 1) {
        return back()->withErrors(['email' => 'This account has been deleted.'])->withInput();
    }

    // Fetch related employee record
    $employee = $user->employee;  // assumes hasOne relation

    if (!$employee) {
        return back()->withErrors(['email' => 'Employee record not found.'])->withInput();
    }

	// 🔒 Block if release_date is today or in the past
	if ($employee->release_date && \Carbon\Carbon::parse($employee->release_date)->lte(now()->startOfDay())) {
		return back()->withErrors(['email' => 'You have been released from the organization. You can no longer log in.'])->withInput();
	}   

    // Check employee approval status
    switch ($employee->is_approved) { 
        case 0:
            return back()->withErrors(['email' => 'Your account is in Draft status.'])->withInput();
        case 1:
            return back()->withErrors(['email' => 'Your account is Pending approval.'])->withInput();
        case 3:
            return back()->withErrors(['email' => 'Your account has been Rejected.'])->withInput();
    }

    // Attempt login
		if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
			return back()->withErrors([
				'email' => __('auth.failed'),
			])->withInput(['email' => $request->email]); // ✅ retain only email input
		}  


    $request->session()->regenerate();

    // Save email in cookie for 30 days
    return redirect()->intended($this->redirectTo());  

}
  

  
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
