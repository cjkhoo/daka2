<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\CustomAdminLoginController;
use App\Http\Controllers\AdminLocationController;
use App\Http\Controllers\CheckInController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Frontend
// Route::get('/', function () {
//     return view('home');
// })->name('home');
 Route::get('/', [UserController::class, 'showLoginForm']);
Route::post('logout', [UserController::class, 'logout'])->name('logout');
Route::get('logout', [UserController::class, 'logout'])->name('link.logout');

Route::middleware('user.login')->group(function () {
    Route::get('/', [UserController::class, 'showLoginForm']);
    Route::get('login', [UserController::class, 'showLoginForm'])->name('login');
    Route::post('login', [UserController::class, 'login']);

    Route::get('register', [UserController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [UserController::class, 'register']);


});
Route::middleware('user')->group(function () {
    Route::get('checkin', [UserController::class, 'showCheckin'])->name('checkin');
    Route::post('checkin', [UserController::class, 'checkin']);
        Route::get('password/change', [UserController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('password/change', [UserController::class, 'changePassword'])->name('password.change.post');
     Route::get('location/change', [UserController::class, 'showChangelocationForm'])->name('location.change');
    Route::post('location/change', [UserController::class, 'changelocation'])->name('location.change.post');
    Route::post('validatelocation', [UserController::class, 'validatelocation'])->name('validatelocation');  
    Route::post('checkout', [UserController::class, 'checkout'])->name('checkout');;
    Route::get('checkinlist', [CheckInController::class, 'showCheckinList'])->name('checkin.list');

});

//Backend


Route::middleware('admin.login')->group(function () {
    Route::get('admin/login', [CustomAdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('admin/login', [CustomAdminLoginController::class, 'login']);
});

Route::post('admin/logout', [CustomAdminLoginController::class, 'logout'])->name('admin.logout');

Route::middleware('admin')->group(function () {
    Route::get('admin/', [CustomAdminLoginController::class, 'index']);
    Route::get('admin/home', [CustomAdminLoginController::class, 'index'])->name('admin.home');

    // Admin routes
    Route::resource('admin/users', AdminUserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);

    Route::resource('admin/locations', AdminLocationController::class)->names([
        'index' => 'admin.locations.index',
        'create' => 'admin.locations.create',
        'store' => 'admin.locations.store',
        'edit' => 'admin.locations.edit',
        'update' => 'admin.locations.update',
        'destroy' => 'admin.locations.destroy',
    ]);

    Route::get('admin/report/checkin', [CheckInController::class, 'index'])->name('admin.report.checkin');
    // Route::post('admin/report/checkin', [ReportController::class, 'filter'])->name('admin.report.checkin.filter');
    Route::delete('admin/report/checkin/destroy', [CheckInController::class, 'destroy'])->name('admin.report.checkin.destroy');

    Route::get('/admin/checkins/export', [CheckInController::class, 'export'])->name('admin.checkins.export');
     Route::get('/admin/checkins/export/all', [CheckInController::class, 'exportAll'])->name('admin.checkins.export.all');



});


