<?php

use App\Http\Controllers\Dashboard;
use App\Http\Controllers\OutgoingController;
use App\Http\Controllers\IncomingController;

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->role == 'admin') {
            return view('adminDashboard');
        } elseif ($user->role == 'superadmin') {
            return view('superAdminDashboard');
        } elseif ($user->role == 'customercare') {
            return view('customerCareDashboard');
        } else {
            // Handle other roles or default case
            return view('dashboard');
        }
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/allusers', [ProfileController::class, 'index'])->name('profile.index');
    

    Route::resource('incomingcalls', IncomingController::class);
    Route::resource('outgoingcalls', OutgoingController::class);
    
    
    Route::get('/alloutgoing', [OutgoingController::class, 'index'])->name('alloutgoing');
    Route::get('/allincoming', [IncomingController::class, 'index'])->name('allincoming');
    Route::get('/addincoming', [IncomingController::class, 'create'])->name('addincoming');
    Route::get('/create', [OutgoingController::class, 'create'])->name('create');
    
    

    Route::get('/search', [OutgoingController::class, 'search'])->name('search');
    Route::get('/searchin', [IncomingController::class, 'search'])->name('searchin');
Route::get('/export', [OutgoingController::class, 'export'])->name('outgoingcalls.export');
Route::get('/incomingcalls/export', 'IncomingController@export')->name('incomingcalls.export');





});

Route::middleware(['auth'])->group(function () {
    // Routes for admin dashboard
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Routes for super admin dashboard
    Route::get('/superadmin/dashboard', [SuperAdminDashboardController::class, 'index'])->name('superadmin.dashboard');

    // Routes for customer care dashboard
    Route::get('/customercare/dashboard', [CustomerCareDashboardController::class, 'index'])->name('customercare.dashboard');

    // Routes for outgoing calls
    Route::get('/outgoing/create', [OutgoingController::class, 'create'])->name('outgoing.create');
    Route::post('/outgoing/store', [OutgoingController::class, 'store'])->name('outgoing.store');
    Route::get('/outgoing/all', [OutgoingController::class, 'index'])->name('outgoing.index');

    // Routes for incoming calls
    Route::get('/incoming/add', [IncomingController::class, 'create'])->name('incoming.create');
    Route::post('/incoming/store', [IncomingController::class, 'store'])->name('incoming.store');
    Route::get('/incoming/all', [IncomingController::class, 'index'])->name('incoming.index');

    // Routes for user profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
});



require __DIR__.'/auth.php';
