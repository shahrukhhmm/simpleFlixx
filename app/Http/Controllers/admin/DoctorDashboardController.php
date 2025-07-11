<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DoctorDashboardController extends Controller
{
    public function index()
    {
        $totalCustomers = User::where('role','customer')->count();
        $pendingOrders = \App\Models\Order::where('status', 'Pending')->count();
        return view('admin.pages.doctor.dashboard', compact('totalCustomers', 'pendingOrders'));
    }
}
