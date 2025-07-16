<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
   public function boot()
	{
		Schema::defaultStringLength(191);
	}
	
	 
	protected function redirectTo()
{
    $role = auth()->user()->role;

    return match ($role) {
        'admin'      => '/admin/dashboard',
        'hr'         => '/hr/dashboard',
        'accountant' => '/accountant/dashboard',
        'employee'   => '/employee/dashboard',
        default      => '/',
    };
}
 
	
}
