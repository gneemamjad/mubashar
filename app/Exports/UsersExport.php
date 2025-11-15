<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function collection()
    {
        return $this->users;
    }

    public function headings(): array
    {
        return [
            'ID',
            'First Name',
            'Last Name',
            'Username',
            'Email',
            'Phone',
            'Version',
            'Status',
            'Blocked',
            'Created At'
        ];
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->first_name,
            $user->last_name,
            $user->user_name,
            $user->email,
            $user->phone,
            $user->version,
            $user->active ? 'Active' : 'Inactive',
            $user->blocked ? 'Blocked' : 'Not Blocked',
            $user->created_at->format('Y-m-d H:i:s')
        ];
    }
} 