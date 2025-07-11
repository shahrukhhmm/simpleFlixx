<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PharmacyDashboardController extends Controller
{
    public function index()
    {
        $totalCustomers = User::where('role','customer')->count();
        $approvedOrders = Order::where('status', 'Approved')->count();
        return view('admin.pages.pharmacy.dashboard', compact('totalCustomers', 'approvedOrders'));
    }
}
