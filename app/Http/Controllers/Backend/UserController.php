<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;
use Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('role')
            ->where('role_id', 1)
            ->where('name', '!=', 'Super Admin') // ← this line excludes the name
            ->whereHas('role')
            ->get();

        $roles = Role::all();
        $permissions = Permission::all();

        return view('backend.user.index', compact('users', 'roles', 'permissions'));
    }


    public function list()
    {
        $lists = User::with('role')->where('role_id', 5)->whereHas('role')->latest()->get();
        return view('backend.user.list', compact('lists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch all employees
        $employees = User::all();
        $roles = Role::all();
        $permissions = Permission::all();
        return view('backend.user.create', compact('employees', 'roles', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validate the incoming request
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'gender'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email',
            'password'       => 'required|string|min:6',
            'mobile'         => 'required|string',
            'join_date'         => 'required|date',
            'role_id'        => 'required|exists:roles,id', // Ensures role_id is present and valid.
            'photo'          => 'required|image|max:2048',
        ]);

        // Generate a unique user code (for example: USR-7LETTERCODE)
        // $pcode = 'USR-' . Str::upper(Str::random(7));

        // Generate an 8-digit random employee code (e.g., EMP-12345678)
        $pcode = 'USR-' . str_pad(random_int(0, 99999999), 8, '0', STR_PAD_LEFT);

        // Handle photo upload
        $photo = $request->file('photo');
        $name_gen = hexdec(uniqid()) . '.' . $photo->getClientOriginalExtension();
        $photo->move(public_path('upload/user'), $name_gen);
        $save_url = 'upload/user/' . $name_gen;

        // Create the user record in the database
        $user = User::create([
            'name'           => $request->name,
            'gender'           => $request->gender,
            'role_id'        => $request->role_id,        // Save role_id in the user's record
            'join_date'       => $request->join_date,
            'mobile'         => $request->mobile,
            'email'          => $request->email,
            'code'           => $pcode,
            'photo'          => $save_url,
            'password'       => Hash::make($request->password),
            'created_at'     => Carbon::now(),
        ]);

        // Retrieve and assign the role for Spatie's permission management.
        $role = Role::find($request->role_id);
        if ($role) {
            $user->assignRole($role);
        } else {
            // Although validation ensures role_id exists, add error handling if needed.
            return redirect()->back()->withErrors(['role_id' => 'Role not found']);
        }

        $notification = [
            'message'    => 'User Created Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('user.index')->with($notification);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('backend.user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'gender'           => $request->gender,
            'gender'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email,' . $user->id,
            'password'       => 'nullable|string|min:6',
            'mobile'         => 'required|string',
            'join_date'         => 'required|date',
            'role_id'        => 'required|exists:roles,id',
            'photo'          => 'nullable|image|max:2048',
        ]);

        // Handle photo upload
        if ($request->file('photo')) {
            $photo = $request->file('photo');
            $name_gen = hexdec(uniqid()) . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('upload/user'), $name_gen);
            $user->photo = 'upload/user/' . $name_gen;
        }

        // Update user fields
        $user->name = $request->name;
        $user->gender = $request->gender;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->join_date = $request->join_date;
        $user->role_id = $request->role_id;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Assign role if changed
        $role = Role::find($request->role_id);
        if ($role) {
            $user->syncRoles([$role->name]);
        }

        $notification = [
            'message'    => 'User Created Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('user.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if ($id == 1) {
            return redirect()->back()->with('error', 'You cannot delete the super admin.');
        }

        User::destroy($id);

        $notification = [
            'message' => 'User deleted successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('user.index')->with($notification);
    }


    /**
     * Get Designation by Department ID (AJAX).
     */
    // Controller Method Example
}
