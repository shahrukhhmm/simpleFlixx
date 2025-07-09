<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DoctorDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    public function index()
    {
        return view('admin.pages.doctors.index');
    }

    public function getDoctors(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select(['users.id', 'users.name', 'users.email', 'users.phone', 'users.date_of_birth', 'users.sex', 'users.state', 'users.status', 'doctor_details.education', 'doctor_details.specialty', 'doctor_details.experience', 'doctor_details.hospital'])
                ->leftJoin('doctor_details', 'users.id', '=', 'doctor_details.user_id')
                ->where('users.role', 'doctor');
            return DataTables::of($data)
                ->addColumn('action', function ($user) {
                    return '
                        <button class="btn btn-sm btn-primary edit-doctor" data-id="' . $user->id . '">Edit</button>
                        <button class="btn btn-sm btn-danger delete-doctor" data-id="' . $user->id . '"' . (Auth::id() == $user->id ? ' disabled' : '') . '>Delete</button>
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
            'date_of_birth' => 'nullable|date',
            'sex' => 'nullable|in:male,female,other',
            'state' => 'nullable|string|max:100',
            'status' => 'required|in:active,blocked,pending',
            'education' => 'nullable|string|max:255',
            'specialty' => 'nullable|string|max:255',
            'experience' => 'nullable|integer|min:0',
            'hospital' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // Mutator will hash it
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'sex' => $request->sex,
            'state' => $request->state,
            'role' => 'doctor',
            'status' => $request->status,
        ]);

        DoctorDetail::create([
            'user_id' => $user->id,
            'education' => $request->education,
            'specialty' => $request->specialty,
            'experience' => $request->experience,
            'hospital' => $request->hospital,
        ]);

        return response()->json(['success' => 'Doctor added successfully.']);
    }

    public function edit($id)
    {
        $user = User::where('role', 'doctor')->findOrFail($id);
        $doctorDetails = DoctorDetail::where('user_id', $id)->first();
        $data = $user->toArray();
        $data['education'] = $doctorDetails ? $doctorDetails->education : null;
        $data['specialty'] = $doctorDetails ? $doctorDetails->specialty : null;
        $data['experience'] = $doctorDetails ? $doctorDetails->experience : null;
        $data['hospital'] = $doctorDetails ? $doctorDetails->hospital : null;
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'sex' => 'nullable|in:male,female,other',
            'state' => 'nullable|string|max:100',
            'status' => 'required|in:active,blocked,pending',
            'education' => 'nullable|string|max:255',
            'specialty' => 'nullable|string|max:255',
            'experience' => 'nullable|integer|min:0',
            'hospital' => 'nullable|string|max:255',
        ]);

        $user = User::where('role', 'doctor')->findOrFail($id);
        $data = $request->only(['name', 'email', 'phone', 'date_of_birth', 'sex', 'state', 'status']);
        if ($request->filled('password')) {
            $data['password'] = $request->password; // Mutator will hash it
        }
        $data['role'] = 'doctor';
        $user->update($data);

        $doctorDetails = DoctorDetail::where('user_id', $id)->first();
        if ($doctorDetails) {
            $doctorDetails->update([
                'education' => $request->education,
                'specialty' => $request->specialty,
                'experience' => $request->experience,
                'hospital' => $request->hospital,
            ]);
        } else {
            DoctorDetail::create([
                'user_id' => $id,
                'education' => $request->education,
                'specialty' => $request->specialty,
                'experience' => $request->experience,
                'hospital' => $request->hospital,
            ]);
        }

        return response()->json(['success' => 'Doctor updated successfully.']);
    }

    public function destroy($id)
    {
        if (Auth::id() == $id) {
            return response()->json(['error' => 'Cannot delete your own account.'], 403);
        }

        $user = User::where('role', 'doctor')->findOrFail($id);
        $user->delete(); // Cascades to delete doctor_details due to onDelete('cascade')

        return response()->json(['success' => 'Doctor deleted successfully.']);
    }
}
