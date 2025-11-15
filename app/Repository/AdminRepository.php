<?php

namespace App\Repository;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminRepository
{
    protected $model;

    public function __construct(Admin $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->with('roles')->get();
    }

    public function find($id)
    {
        return $this->model->with('roles')->findOrFail($id);
    }

    public function create(array $data)
    {
        $admin = $this->model->create($data);
        if (isset($data['role'])) {
            $admin->roles()->sync([$data['role']]);
        }
        return $admin;
    }

    public function update($id, array $data)
    {
        $admin = $this->model->findOrFail($id);
        
        if(isset($data['name']))
            $admin->name = $data['name'];
       
        if(isset($data['email']))
            $admin->email = $data['email'];
        
        if (!empty($data['password'])) {
            $admin->password = Hash::make($data['password']);
        }

        if(isset($data['is_active']))
            $admin->is_active = $data['is_active'];
        
        $admin->save();
        
        if (isset($data['role'])) {
            $admin->roles()->sync([$data['role']]);
        }
        
        return $admin;
    }

    public function delete($id)
    {
        return $this->find($id)->delete();
    }

    public function toggleStatus($id)
    {
        $admin = $this->find($id);
        $admin->is_active = !$admin->is_active;
        $admin->save();
        
        return $admin;
    }

    public function isActive($id)
    {
        return $this->find($id)->is_active;
    }

    public function findWithRoles($id)
    {
        return $this->model->with('roles')->findOrFail($id);
    }
} 