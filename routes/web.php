<?php

use App\Http\Controllers\admin\ChartController;
use App\Http\Controllers\admin\InoutController;
use App\Http\Controllers\admin\StaffController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\FdfExportController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\staff\CheckinController;
use App\Models\Member;
use Illuminate\Support\Facades\Route;

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

// Route liên quan đến Auth
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/password/reset', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/password/update', [AuthController::class, 'updatePassword'])->name('password.update');


// Route liên quan đến Admin
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard')->middleware(['auth', 'role:admin']);

    //Quản lý staff
    Route::prefix('/staff')->name('staff.')->group(function () {
        Route::get('/index', [StaffController::class, 'index'])->name('index')->middleware(['auth', 'role:admin']);
        Route::get('/create', [StaffController::class, 'create'])->name('create')->middleware(['auth', 'role:admin']);
        Route::post('/store', [StaffController::class, 'store'])->name('store')->middleware('auth', 'role:admin');
        Route::delete('/{id}', [StaffController::class, 'destroy'])->name('destroy')->middleware('auth', 'role:admin');
        Route::get('/{id}/edit', [StaffController::class, 'edit'])->name('edit')->middleware('auth', 'role:admin');
        Route::put('/{id}', [StaffController::class, 'update'])->name('update')->middleware('auth', 'role:admin');
    });

    //Quản lý vào ra
    Route::prefix('/inout')->group(function(){
        Route::get('/index',[InoutController::class,'index'])->name('inout.index')->middleware(['auth', 'role:admin']);
    });
});

// Checkin
Route::get('/checkin', [CheckinController::class, 'index'])->name('checkin')->middleware(['auth']);
Route::get('/search-qrcode', [CheckinController::class, 'searchQRCode'])->middleware(['auth']);
Route::post('/checkin', [CheckinController::class, 'store'])->name('checkin.store')->middleware(['auth']);
Route::post('/ncheckin', [CheckinController::class, 'nstore'])->name('checkin.nstore')->middleware(['auth']);

//quản lý member
Route::prefix('member')->group(function () {
    route::get('/index', [MemberController::class, 'index'])->name('member.index')->middleware(['auth']);
    route::get('/create', [MemberController::class, 'create'])->name('member.create')->middleware(['auth']);
    route::post('/store', [MemberController::class, 'store'])->name('member.store')->middleware(['auth']);
    Route::delete('/delete/{id}', [MemberController::class, 'destroy'])->name('member.destroy')->middleware(['auth']);
    Route::get('/search', [MemberController::class, 'search'])->name('member.search')->middleware(['auth']);
    Route::get('/export', [MemberController::class, 'exportToCsv'])->name('members.export')->middleware(['auth']);
    Route::get('/{id}', [MemberController::class, 'show'])->name('member.show')->middleware(['auth']);
    Route::post('/extend', [MemberController::class, 'extendMembers'])->name('members.extend')->middleware(['auth']);
});

Route::get('/asset-url', function () {
    return response()->json(['asset_url' => asset('storage')]);
});

// Route hiển thị lỗi (Optional)
Route::get('/error/database', function () {
    return view('errors.database');
})->name('error.database');



//Chart
Route::prefix('admin/dashboard')->group(function(){
    Route::get('/checkin-data', [ChartController::class, 'getCheckinData'])->name('chart.data');
    Route::get('/statistical', [ChartController::class, 'getStatistical'])->name('chart.getStatistical');
})->middleware('auth', 'role:admin');
Route::get('/',[ChartController::class,'index'])->name('chart.index')->middleware('auth', 'role:admin');



//Address
Route::get('/api/provinces', [MemberController::class, 'getProvinces']);
Route::get('/api/districts/{provinceCode}', [MemberController::class, 'getDistrictsByProvinceCode']);
Route::get('/api/wards/{districtCode}', [MemberController::class, 'getWardsByDistrictCode']);

//Forget password
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.resets');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.ud');
