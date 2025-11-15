<div class="form-check form-switch d-flex align-items-center">
    <span class="badge {{ $admin->is_active ? 'badge-light-success' : 'badge-light-danger' }}">
        {{ $admin->is_active ? 'Active' : 'Inactive' }}
    </span>
</div> 