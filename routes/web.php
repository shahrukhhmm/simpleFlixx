<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\ChatController;
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\DoctorController;
use App\Http\Controllers\admin\PharmacyController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\DoctorDashboardController;
use App\Http\Controllers\admin\PharmacyDashboardController;

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

Route::get('login', [AuthController::class, 'loginPage'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');

// New registration routes
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [UserController::class, 'register'])->name('register.post');

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    // User Routes (Restricted to Admins)
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/get', [UserController::class, 'getUsers'])->name('admin.users.get');
    Route::post('/users/store', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{id}/update', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{id}/delete', [UserController::class, 'destroy'])->name('admin.users.destroy');

    // Admin routes for doctors
    Route::get('/doctors', [DoctorController::class, 'index'])->name('admin.doctors.index');
    Route::get('/doctors/get', [DoctorController::class, 'getDoctors'])->name('admin.doctors.get');
    Route::post('/doctors', [DoctorController::class, 'store'])->name('admin.doctors.store');
    Route::get('/doctors/{id}/edit', [DoctorController::class, 'edit'])->name('admin.doctors.edit');
    Route::put('/doctors/{id}', [DoctorController::class, 'update'])->name('admin.doctors.update');
    Route::delete('/doctors/{id}', [DoctorController::class, 'destroy'])->name('admin.doctors.destroy');
    Route::get('/doctor/dashboard', [DoctorDashboardController::class, 'index'])->name('admin.doctors.dashboard');

    // Admin routes for pharmacies
    Route::get('/pharmacies', [PharmacyController::class, 'index'])->name('admin.pharmacies.index');
    Route::get('/pharmacies/get', [PharmacyController::class, 'getPharmacies'])->name('admin.pharmacies.get');
    Route::post('/pharmacies', [PharmacyController::class, 'store'])->name('admin.pharmacies.store');
    Route::get('/pharmacies/{id}/edit', [PharmacyController::class, 'edit'])->name('admin.pharmacies.edit');
    Route::put('/pharmacies/{id}', [PharmacyController::class, 'update'])->name('admin.pharmacies.update');
    Route::delete('/pharmacies/{id}', [PharmacyController::class, 'destroy'])->name('admin.pharmacies.destroy');
    Route::get('/pharmacy/dashboard', [PharmacyDashboardController::class, 'index'])->name('admin.pharmacies.dashboard');


    Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
    Route::get('/orders/doctor', [OrderController::class, 'doctorIndex'])->name('order.doctor.index');
    Route::get('/orders/pharmacy', [OrderController::class, 'pharmacyIndex'])->name('order.pharmacy.index');
    Route::get('/orders/add', [OrderController::class, 'add'])->name('order.add');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/details/{id}', [OrderController::class, 'getOrderDetails'])->name('admin.orders.details');
    Route::get('/orders/edit/{id}', [OrderController::class, 'edit'])->name('order.edit');
    Route::put('/orders/update/{id}', [OrderController::class, 'update'])->name('order.update');
    Route::delete('/orders/destroy/{id}', [OrderController::class, 'destroy'])->name('order.destroy');
    Route::get('/orders/success', [OrderController::class, 'success'])->name('order.success');
    Route::get('/orders/show/{id}', [OrderController::class, 'show'])->name('order.show');
    Route::post('/orders/update-status/{id}', [OrderController::class, 'updateStatus'])->name('order.updateStatus');
    Route::get('/orders/show/pharmacy/{id}', [OrderController::class, 'showPharmacy'])->name('order.show.pharmacy');

    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/messages/{receiverId}', [ChatController::class, 'getMessages'])->name('chat.messages');
});
