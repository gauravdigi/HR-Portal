<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->is_deleted == 1) {
            Auth::logout();
            return redirect()->route('login')->withErrors(['email' => 'Your account has been deleted.']);
        }  
      
        $employee = $user?->employee;
    
        if ($employee && $employee->release_date) {
            $releaseDate = Carbon::parse($employee->release_date);
            if ($releaseDate->lte(now()->startOfDay())) {
                Auth::logout();
                return redirect()->route('login')->withErrors(['email' => 'You have been released from the organization.']);
            }
        }

        return $next($request);
    }
}    
     