<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use DB;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('backend.role-permission.index',compact('roles','permissions','permission_groups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('backend.role-permission.create',compact('roles','permissions','permission_groups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validate the incoming request to ensure `role_id` and `permissions` are present
    $request->validate([
        'role_id' => 'required|exists:roles,id', // Ensure role_id is required and exists in the roles table
        'permission' => 'required|array', // Ensure permission is required and is an array
    ]);

    $role_id = $request->role_id; // Get the role_id from the request
    $permissions = $request->permission; // Get the selected permissions

    // Loop through the selected permissions
    foreach ($permissions as $permission_id) {
        // Check if the combination of role_id and permission_id already exists
        $exists = DB::table('role_has_permissions')
                    ->where('role_id', $role_id)
                    ->where('permission_id', $permission_id)
                    ->exists();

        // If it doesn't exist, insert the permission
        if (!$exists) {
            DB::table('role_has_permissions')->insert([
                'role_id' => $role_id,
                'permission_id' => $permission_id,
            ]);
        }
    }

    $notification = [
        'message' => 'Role Permissions Added Successfully',
        'alert-type' => 'success'
    ];

    return redirect()->route('backend.role-permission.create')->with($notification);
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
 // Get the role
 $role = Role::findOrFail($id);

 // Get all roles (for dropdown, if needed)
 $roles = Role::all();

 // Get grouped permissions by 'group_name'
 $permission_groups = Permission::select('group_name')
     ->groupBy('group_name')
     ->get();

 return view('backend.role-permission.edit', compact('role', 'roles', 'permission_groups'));

    }// End Method 


    public function DeletePermission($id){

        Permission::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Permission Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    // Validate the input
    $validated = $request->validate([
        'name' => 'required|string|max:255', // Ensure name is required and not null
        'permission' => 'required|array', // Ensure permissions are provided
    ]);

    // Retrieve the role to update
    $role = Role::find($id); // Using find() to avoid exception, check if null
    if (!$role) {
        return redirect()->route('role-permission.index')->withErrors(['role' => 'Role not found.']);
    }

    // Update the role name (or any other properties as needed)
    $role->name = $validated['name'];

    // Validate and sync permissions
    $permissions = $validated['permission'];
    $validPermissions = \Spatie\Permission\Models\Permission::whereIn('id', $permissions)->pluck('id')->toArray();

    // Debugging line to check valid permissions
    // dd($validPermissions, $permissions);

    if (count($validPermissions) !== count($permissions)) {
        return back()->withErrors(['permissions' => 'Some of the permissions do not exist.']);
    }

    // Sync the valid permissions
    $role->syncPermissions($validPermissions);

    // Save the role
    $role->save();

    // Create a notification
    $notification = [
        'message' => 'Role updated successfully!',
        'alert-type' => 'success',
    ];

    // Redirect to the correct route with the notification
    return redirect()->route('role-permission.index')->with($notification);
}

}
 