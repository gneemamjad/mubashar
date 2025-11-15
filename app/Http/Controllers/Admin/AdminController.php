<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;

        // Use custom permission middleware
        $this->middleware(['auth:admin', 'custom.permission:view_admins,admin'])->only(['index', 'show', 'data']);
        $this->middleware(['auth:admin', 'custom.permission:create_admins,admin'])->only(['create', 'store']);
        $this->middleware(['auth:admin', 'custom.permission:edit_admins,admin'])->only(['edit', 'update', 'toggleStatus']);
        $this->middleware(['auth:admin', 'custom.permission:delete_admins,admin'])->only('destroy');
    }

    public function index()
    {
        $roles = Role::all();
        $title = __('admin.adminsT');
        $page = __('admin.sidebar.access_management');

        return view('admin.admins.index', compact('roles','title','page'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.admins.create', compact('roles'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:admins,email',
                'password' => 'required|min:8|confirmed',
                'role' => 'required|exists:roles,id'
            ]);

            DB::beginTransaction();

            $admin = $this->adminService->createAdmin($validated);

            DB::commit();

            return redirect()->route('admins.index')
                ->with('success', __('admin.messages.admin_created'));

        } catch (ValidationException $e) {
            return redirect()->route('admins.index')
                ->with('error', $e->getMessage());
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', __('admin.messages.admin_create_error', ['error' => $e->getMessage()]))
                ->withInput();
        }
    }

    public function show($id)
    {
        $admin = $this->adminService->getAdmin($id);
        return view('admin.admins.show', compact('admin'));
    }

    public function edit($id)
    {
        try {
            $admin = $this->adminService->getAdminForEdit($id);
            return response()->json(['admin' => $admin]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to load admin data'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $this->adminService->validateUpdateData($request->all(), $id);

            $admin = $this->adminService->updateAdmin($id, $validated);

            return redirect()->route('admins.index')
                ->with('success', __('admin.messages.admin_updated'));

        } catch (ValidationException $e) {
            return redirect()->route('admins.index')
                ->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', __('admin.messages.admin_update_error', ['error' => $e->getMessage()]))
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $this->adminService->deleteAdmin($id);
        return redirect()->route('admins.index')
            ->with('success', __('admin.messages.admin_deleted'));
    }

    public function toggleStatus($id)
    {
        $this->adminService->toggleAdminStatus($id);
        return redirect()->route('admins.index')
            ->with('success', __('admin.messages.admin_status_updated'));
    }

    public function data(Request $request)
    {
        $query = Admin::select(['admins.*'])->with('roles');

        if ($request->active_only) {
            $query->where('is_active', true);
        }

        $datatable = datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('checkbox', function($admin) {
                return '<input type="checkbox" class="checkbox checkbox-sm" value="'.$admin->id.'">';
            })
            ->addColumn('admin_info', function($admin) {
                return view('admin.admins.partials._name_column', compact('admin'))->render();
            })
            ->addColumn('role_name', function($admin) {
                return $admin->roles->first()?->name ?? 'No Role';
            })
            ->addColumn('status', function($admin) {
                return view('admin.admins.partials._status_column', compact('admin'))->render();
            })
            ->addColumn('actions', function($admin) {
                return view('admin.admins.partials._actions_column', compact('admin'))->render();
            })
            ->rawColumns(['checkbox', 'admin_info', 'status', 'actions']);

        return $datatable->toJson();
    }
}
