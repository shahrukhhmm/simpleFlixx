<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $totalCustomers = User::where('role','customer')->count();
        $totalDoctors = User::where('role','doctor')->count();
        $totalPharmacies = User::where('role','pharmacy')->count();


        if($user->role == 'admin') {

            return view('admin.pages.dashboard', compact('totalCustomers', 'totalDoctors', 'totalPharmacies'));
        }
        else if($user->role == 'customer') {
            return view('admin.pages.dashboard', compact('totalCustomers', 'totalDoctors', 'totalPharmacies'))->with([
                'message' => 'Welcome to the Customer Dashboard',
                'alert-type' => 'success'
            ]);
        }
        else if($user->role == 'doctor') {
            return redirect()->route('admin.doctors.dashboard',compact('totalCustomers', 'totalDoctors', 'totalPharmacies'))->with([
                'message' => 'Welcome to the Doctor Dashboard',
                'alert-type' => 'success'
            ]);
        } elseif($user->role == 'pharmacy') {
            return redirect()->route('admin.pharmacies.dashboard',compact('totalCustomers', 'totalDoctors', 'totalPharmacies'))->with([
                'message' => 'Welcome to the Pharmacy Dashboard',
                'alert-type' => 'success'
            ]);
        }

    }


}
