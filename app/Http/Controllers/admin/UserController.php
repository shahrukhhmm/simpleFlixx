<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.pages.users.index');
    }

    public function getUsers(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select(['id', 'name', 'email', 'phone', 'date_of_birth', 'sex', 'state', 'status']);
            return DataTables::of($data)
                ->addColumn('action', function ($user) {
                    return '
                        <button class="btn btn-sm btn-primary edit-user" data-id="' . $user->id . '">Edit</button>
                        <button class="btn btn-sm btn-danger delete-user" data-id="' . $user->id . '"' . (Auth::id() == $user->id ? ' disabled' : '') . '>Delete</button>
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
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // Mutator will hash it
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'sex' => $request->sex,
            'state' => $request->state,
            'role' => 'customer',
            'status' => $request->status,
        ]);

        return response()->json(['success' => 'Customer added successfully.']);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
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
        ]);

        $user = User::findOrFail($id);
        $data = $request->only(['name', 'email', 'phone', 'date_of_birth', 'sex', 'state', 'status']);
        if ($request->filled('password')) {
            $data['password'] = $request->password; // Mutator will hash it
        }
        $data['role'] = 'customer';
        $user->update($data);

        return response()->json(['success' => 'Customer updated successfully.']);
    }

    public function destroy($id)
    {
        if (Auth::id() == $id) {
            return response()->json(['error' => 'Cannot delete your own account.'], 403);
        }

        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['success' => 'Customer deleted successfully.']);
    }

    public function showRegistrationForm()
    {
        return view('admin.pages.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'sex' => 'nullable|in:male,female,other',
            'state' => 'nullable|string|max:100',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'sex' => $request->sex,
            'state' => $request->state,
            'role' => 'customer',
            'status' => 'pending',
        ]);

        return redirect()->route('login')->with('success', 'Registration successful. Please wait for admin approval.');
    }
}
