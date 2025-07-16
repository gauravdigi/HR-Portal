<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AccountantController;
use App\Http\Controllers\HrController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\HiringController;
use App\Http\Controllers\CandidateController;

// Route::get('/', function () {
//     return redirect()->route('login');
// });

Route::get('/', function () {
    if (!Auth::check()) {
        return redirect('/login');
    }

    $user = Auth::user();

    switch ($user->role) {
        case 'admin':
            return redirect('/admin');
        case 'hr':
            return redirect('/hr');
        case 'accountant':
            return redirect('/accountant/employe');
        default:
            Auth::logout(); // Optional: log out unknown roles
            return redirect('/login')->withErrors(['role' => 'Unknown user role.']);
    }
});


Route::get('/dashboard', function () {
    $user = Auth::user();

    switch ($user->role) {
        case 'admin':
            return redirect('/admin');
        case 'hr':
            return redirect('/hr');
        case 'accountant':
            return redirect('/accountant/employe');
        default:
            Auth::logout();
            return redirect('/login')->withErrors(['role' => 'Unknown user role.']);
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile', [ProfileController::class, 'viewProfile'])->name('profile.viewprofile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




// Admin routes - full access
// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get('/admin/dashboard', function () {
//         return 'Admin Dashboard';
//     });
//     Route::resource('admin/employees', EmployeeController::class);
// });

        // HR routes - manage employees (except admin routes)
        Route::middleware(['auth', 'hr'])->prefix('hr')->group(function () {                      
            // HR Dashboard Route
            Route::get('/dashboard', [HrController::class, 'dashboard'])->name('hr.dashboard');
             Route::get('/', [HrController::class, 'index'])->name('hr.index');
            Route::get('/employe/create', [HrController::class, 'create'])->name('hr.employe.create');
            //Route::post('hr/employe/store', [HrController::class, 'storeStep1'])->name('hr.employe.store');  
            Route::get('/employe/edit/{id}', [HrController::class, 'edit'])->name('hr.employe.edit');
            Route::get('/employe/view/{id}', [HrController::class, 'view'])->name('hr.employe.view');
            Route::post('/employe/update/{id}', [HrController::class, 'update'])->name('hr.employe.update');  
            Route::DELETE('/employe/destroy/{id}', [HrController::class, 'destroyEmployee'])->name('hr.employe.destroy');

            Route::post('/employe/store-step1', [HrController::class, 'storeStep1'])->name('employee.store.step1');
            Route::post('/employe/store-step2', [HrController::class, 'storeStep2'])->name('employee.store.step2');
            Route::post('/employe/store-step3', [HrController::class, 'storeStep3'])->name('employee.store.step3');
            Route::post('/employe/store-step4', [HrController::class, 'storeStep4'])->name('employee.store.step4');
            Route::post('/employe/store-step5', [HrController::class, 'storeStep5'])->name('employee.store.step5');
            Route::post('/employe/store-step6', [HrController::class, 'storeStep6'])->name('employee.store.step6');

            // edit step routes

            Route::post('/employe/edit-step1', [HrController::class, 'editStep1'])->name('employee.store.editstep1');
            Route::post('/employe/edit-step2', [HrController::class, 'editStep2'])->name('employee.store.editstep2');
            Route::post('/employe/edit-step3', [HrController::class, 'editStep3'])->name('employee.store.editstep3');
            Route::post('/employe/edit-step4', [HrController::class, 'editStep4'])->name('employee.store.editstep4');
            Route::post('/employe/edit-step5', [HrController::class, 'editStep5'])->name('employee.store.editstep5');
            Route::post('/employe/edit-step6', [HrController::class, 'editStep6'])->name('employee.store.editstep6');
             
            Route::resource('employees', HrController::class);          
             
        }); 


// Accountant routes - view-only access to employees (GET only)
Route::middleware(['auth', 'accountant'])->prefix('accountant')->group(function () {
 
    // Accountant Dashboard Route
    Route::get('/dashboard', [AccountantController::class, 'dashboard'])
        ->name('accountant.dashboard');
 
    // List all employees
    Route::get('/employe', [AccountantController::class, 'index'])
        ->name('accountant.employe.index');
 
    // Optional: Show individual employee details
    Route::get('/employe/{id}', [AccountantController::class, 'show'])
        ->name('accountant.employe.show');  
});

    //Admin routes - full access
    Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () { 

        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/employe/create', [AdminController::class, 'create'])->name('admin.employe.create');
        // Route::post('admin/employe/store', [AdminController::class, 'store'])->name('admin.employe.store');  
        Route::get('/employe/edit/{id}', [AdminController::class, 'edit'])->name('admin.employe.edit');
        Route::get('/employe/view/{id}', [AdminController::class, 'view'])->name('admin.employe.view');
        Route::post('/employe/update/{id}', [AdminController::class, 'update'])->name('admin.employe.update');  

            // Update password (POST)
            Route::post('/employe/change-password', [AdminController::class, 'changePassword'])->name('admin.employe.change-password');

            Route::post('/employe/update-status/', [AdminController::class, 'updateStatus'])->name('admin.employe.update-status');
            
        Route::DELETE('/employe/destroy/{id}', [AdminController::class, 'destroy'])->name('admin.employe.destroy');
        Route::post('/employe/{id}/approve', [AdminController::class, 'approve'])->name('admin.employe.approve');
        Route::post('/employe/store-step1', [AdminController::class, 'storeStep1'])->name('employee.store.step1');
        Route::post('/employe/store-step2', [AdminController::class, 'storeStep2'])->name('employee.store.step2');
        Route::post('/employe/store-step3', [AdminController::class, 'storeStep3'])->name('employee.store.step3');
        Route::post('/employe/store-step4', [AdminController::class, 'storeStep4'])->name('employee.store.step4');
        Route::post('/employe/store-step5', [AdminController::class, 'storeStep5'])->name('employee.store.step5');
        Route::post('/employe/store-step6', [AdminController::class, 'storeStep6'])->name('employee.store.step6');

        // edit step routes

        Route::post('/employe/edit-step1', [AdminController::class, 'editStep1'])->name('employee.store.editstep1');
        Route::post('/employe/edit-step2', [AdminController::class, 'editStep2'])->name('employee.store.editstep2');
        Route::post('/employe/edit-step3', [AdminController::class, 'editStep3'])->name('employee.store.editstep3');
        Route::post('/employe/edit-step4', [AdminController::class, 'editStep4'])->name('employee.store.editstep4');
        Route::post('/employe/edit-step5', [AdminController::class, 'editStep5'])->name('employee.store.editstep5');
        Route::post('/employe/edit-step6', [AdminController::class, 'editStep6'])->name('employee.store.editstep6');

        Route::resource('employees', AdminController::class);   
    });  


        Route::middleware(['auth', 'role:admin,hr'])->group(function () {
            Route::get('/holiday', [HolidayController::class, 'index'])->name('holiday.index');
            Route::post('/holiday', [HolidayController::class, 'store'])->name('holiday.store');
            Route::get('/holiday/edit/{id}', [HolidayController::class, 'edit'])->name('holiday.edit');
            Route::post('/holiday/update/{id}', [HolidayController::class, 'update'])->name('holiday.update');
            Route::DELETE('/holiday/{id}', [HolidayController::class, 'destroy'])->name('holiday.destroy');
        });


         Route::middleware(['auth', 'role:admin,hr'])->group(function () {    
             Route::post('/hiringportal', [HiringController::class, 'store'])->name('hiringportal.store');
             Route::get('/hiringportal', [HiringController::class, 'index'])->name('hiringportal.index');
             Route::post('/hiringportal/{id}', [HiringController::class, 'update'])->name('hiringportal.update');
             Route::delete('/hiringportal/{id}', [HiringController::class, 'destroy'])->name('hiringportal.destroy');

         });
           

        // //Admin routes - full access
    Route::middleware(['auth', 'role:admin,hr'])->prefix('candidates')->group(function () {
        Route::post('/', [CandidateController::class, 'store'])->name('candidates.store');
        Route::get('/', [CandidateController::class, 'index'])->name('candidates.index');
        Route::get('/edit/{candidate}', [CandidateController::class, 'edit'])->name('candidates.edit');
        Route::post('/update/{candidate}', [CandidateController::class, 'update'])->name('candidates.update');
        Route::DELETE('/{candidate}', [CandidateController::class, 'destroy'])->name('candidates.destroy');
        Route::post('/check-email-exists', [CandidateController::class, 'checkEmailExists']);
        Route::get('/{candidate}', [CandidateController::class, 'show'])->name('candidates.show');


    });
  
require __DIR__.'/sunny.php';
require __DIR__.'/auth.php';
