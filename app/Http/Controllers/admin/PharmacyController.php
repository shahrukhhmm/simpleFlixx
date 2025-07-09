<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PharmacyDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class PharmacyController extends Controller
{
    public function index()
    {
        return view('admin.pages.pharmacies.index');
    }

    public function getPharmacies(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select(['users.id', 'users.name', 'users.email', 'users.phone', 'users.state', 'users.status', 'pharmacy_details.tel_no', 'pharmacy_details.second_address', 'pharmacy_details.fax_no'])
                ->leftJoin('pharmacy_details', 'users.id', '=', 'pharmacy_details.user_id')
                ->where('users.role', 'pharmacy');
            return DataTables::of($data)
                ->addColumn('action', function ($user) {
                    return '
                        <button class="btn btn-sm btn-primary edit-pharmacy" data-id="' . $user->id . '">Edit</button>
                        <button class="btn btn-sm btn-danger delete-pharmacy" data-id="' . $user->id . '"' . (Auth::id() == $user->id ? ' disabled' : '') . '>Delete</button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'state' => 'nullable|string|max:100',
            'status' => 'required|in:active,blocked,pending',
            'tel_no' => 'nullable|string|max:20',
            'second_address' => 'nullable|string|max:255',
            'fax_no' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // Mutator will hash it
            'phone' => $request->phone,
            'state' => $request->state,
            'role' => 'pharmacy',
            'status' => $request->status,
        ]);

        PharmacyDetail::create([
            'user_id' => $user->id,
            'tel_no' => $request->tel_no,
            'second_address' => $request->second_address,
            'fax_no' => $request->fax_no,
        ]);

        return response()->json(['success' => 'Pharmacy added successfully.']);
    }

    public function edit($id)
    {

        // dd($id);
        $user = User::where('role', 'pharmacy')->findOrFail($id);
        $pharmacyDetails = PharmacyDetail::where('user_id', $id)->first();
        $data = $user->toArray();
        $data['tel_no'] = $pharmacyDetails ? $pharmacyDetails->tel_no : null;
        $data['second_address'] = $pharmacyDetails ? $pharmacyDetails->second_address : null;
        $data['fax_no'] = $pharmacyDetails ? $pharmacyDetails->fax_no : null;
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'phone' => 'nullable|string|max:20',
            'state' => 'nullable|string|max:100',
            'status' => 'required|in:active,blocked,pending',
            'tel_no' => 'nullable|string|max:20',
            'second_address' => 'nullable|string|max:255',
            'fax_no' => 'nullable|string|max:20',
        ]);

        $user = User::where('role', 'pharmacy')->findOrFail($id);
        $data = $request->only(['name', 'email', 'phone', 'state', 'status']);
        if ($request->filled('password')) {
            $data['password'] = $request->password; // Mutator will hash it
        }
        $data['role'] = 'pharmacy';
        $user->update($data);

        $pharmacyDetails = PharmacyDetail::where('user_id', $id)->first();
        if ($pharmacyDetails) {
            $pharmacyDetails->update([
                'tel_no' => $request->tel_no,
                'second_address' => $request->second_address,
                'fax_no' => $request->fax_no,
            ]);
        } else {
            PharmacyDetail::create([
                'user_id' => $id,
                'tel_no' => $request->tel_no,
                'second_address' => $request->second_address,
                'fax_no' => $request->fax_no,
            ]);
        }

        return response()->json(['success' => 'Pharmacy updated successfully.']);
    }

    public function destroy($id)
    {
        if (Auth::id() == $id) {
            return response()->json(['error' => 'Cannot delete your own account.'], 403);
        }

        $user = User::where('role', 'pharmacy')->findOrFail($id);
        $user->delete(); // Cascades to delete pharmacy_details due to onDelete('cascade')

        return response()->json(['success' => 'Pharmacy deleted successfully.']);
    }
}
