<?php

namespace App\Services;

use App\Repository\AdminRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Admin;

class AdminService
{
    protected $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function getAllAdmins()
    {
        return $this->adminRepository->all();
    }

    public function getAdmin($id)
    {
        return $this->adminRepository->find($id);
    }

    public function createAdmin(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return $this->adminRepository->create($data);
    }

    public function getAdminForEdit($id)
    {
        return $this->adminRepository->findWithRoles($id);
    }

    public function updateAdmin($id, array $data)
    {
        try {
            DB::beginTransaction();

            $admin = $this->adminRepository->update($id, $data);

            DB::commit();

            return $admin;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateProfile($admin, array $data)
    {
        return $this->adminRepository->update($admin, $data);
    }

    public function validateUpdateData($data, $id)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
            'role' => 'required|exists:roles,id',
            'is_active' => 'numeric|in:0,1'
        ];

        $validator = validator($data, $rules);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        return $validator->validated();
    }

    public function deleteAdmin($id)
    {
        return $this->adminRepository->delete($id);
    }

    public function toggleAdminStatus($id)
    {
        try {
            DB::beginTransaction();
            $admin = $this->adminRepository->toggleStatus($id);
            DB::commit();
            
            return $admin;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function validateLogin($credentials)
    {
        $admin = Admin::where('email', $credentials['email'])->first();

        if (!$admin) {
            throw ValidationException::withMessages([
                'email' => ['These credentials do not match our records.'],
            ]);
        }

        if (!$admin->is_active) {
            throw ValidationException::withMessages([
                'email' => ['Your account is inactive. Please contact administrator.'],
            ]);
        }

        if (!Hash::check($credentials['password'], $admin->password)) {
            throw ValidationException::withMessages([
                'email' => ['These credentials do not match our records.'],
            ]);
        }

        return $admin;
    }
} 