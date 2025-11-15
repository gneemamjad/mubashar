<?php

namespace App\Repository;

use App\Models\Currency;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class UserRepository
{
    public function __construct(protected User $model)
    {
    }

    public function updateProfile(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }

    public function getDataTable()
    {
        $query = $this->model->query()->select(['id', 'first_name','last_name', 'user_name','app_version','otp','mobile', 'active','blocked', 'created_at','email','currency_id']);

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('actions', function ($user) {
                return view('admin.users.partials._actions_column', compact('user'))->render();
            })
            ->addColumn('created_at_formatted', function ($user) {
              
                return $user->created_at != null ? $user->created_at->format('Y-m-d') : "";
            })
            ->addColumn('currency', function ($user) {
              
                return Currency::CURRENCY[$user->currency_id];
            })
            ->rawColumns(['actions','currency','created_at_formatted'])
            ->setRowId('id')
            ->make(true);
    }

    public function toggleBlock($id)
    {
        $user = $this->model->findOrFail($id);
        $user->update(['blocked' => !$user->blocked]);
        return $user;
    }

    public function toggleActive($id)
    {
        $user = $this->model->findOrFail($id);
        $user->update(['active' => !$user->active]);
        return $user;
    }
} 