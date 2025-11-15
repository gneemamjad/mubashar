@extends('layouts.main')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Admin Details</h3>
        <div class="card-toolbar">
            <a href="{{ route('admins.edit', $admin->id) }}" class="btn btn-primary">Edit Admin</a>
        </div>
    </div>
    <div class="card-body">
        <div class="mb-4">
            <strong>Name:</strong>
            <p>{{ $admin->name }}</p>
        </div>

        <div class="mb-4">
            <strong>Email:</strong>
            <p>{{ $admin->email }}</p>
        </div>

        <div class="mb-4">
            <strong>Role:</strong>
            <p>{{ $admin->roles->first()?->name ?? 'No Role Assigned' }}</p>
        </div>

        <div class="mb-4">
            <strong>Status:</strong>
            <span class="badge badge-{{ $admin->is_active ? 'success' : 'danger' }}">
                {{ $admin->is_active ? 'Active' : 'Inactive' }}
            </span>
        </div>

        <div class="mb-4">
            <strong>Created At:</strong>
            <p>{{ $admin->created_at->format('Y-m-d H:i:s') }}</p>
        </div>
    </div>
</div>
@endsection 