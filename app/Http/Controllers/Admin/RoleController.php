<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    const MAIN_PAGE = 'Access Management';
    const TITLE = 'Roles';

    public function __construct()
    {
        $this->middleware('custom.permission:view_roles,admin')->only(['index', 'show']);
        $this->middleware('custom.permission:create_roles,admin')->only(['create', 'store']);
        $this->middleware('custom.permission:edit_roles,admin')->only(['edit', 'update']);
        $this->middleware('custom.permission:delete_roles,admin')->only('destroy');
    }

    public function index()
    {
        $roles = Role::with('permissions')->get();
        $title = __('admin.sidebar.roles');
        $page = __('admin.sidebar.access_management');
        return view('admin.roles.index', compact('roles', 'title', 'page'));
    }

    public function create()
    {
        $permissions = Permission::where('guard_name', 'admin')->get();
        $title = __('admin.sidebar.roles');
        $page = __('admin.sidebar.access_management');
        return view('admin.roles.create', compact('permissions', 'title', 'page'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array'
        ]);


        $role = Role::create(['name' => $request->name, 'guard_name' => 'admin']);

        $permissions = Permission::whereIn('id', $request->permissions)
            ->where('guard_name', 'admin')
            ->get();

        $role->syncPermissions($permissions);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully');
    }


    public function edit($id)
    {
        $title = __('admin.sidebar.roles');
        $page = __('admin.sidebar.access_management');
        $role = Role::findOrFail($id);
        $permissions = Permission::all();

        if (request()->ajax()) {
            return response()->json([
                'role' => $role,
                'permissions' => $permissions,
                'rolePermissions' => $role->permissions->pluck('id')->toArray()
            ]);
        }

        return view('admin.roles.edit', compact('role', 'permissions', 'title', 'page'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $validated = $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $validated = $request->all();

        $role->update(['name' => $validated['name']]);
        $permissions = Permission::whereIn('id', $validated['permissions'])
            ->where('guard_name', 'admin')
            ->get();

        $role->syncPermissions($permissions);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully');
    }

    public function destroy( $role)
    {
        try {
            $role = Role::findOrFail($role);
            $role->delete();

            return response()->json([
                'success' => true,
                'message' => 'Role deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete role'
            ], 500);
        }
    }
}
