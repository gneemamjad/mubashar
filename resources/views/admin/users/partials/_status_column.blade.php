<div class="form-check form-switch d-flex align-items-center">
    <span class="badge {{ $user->is_active ? 'badge-light-success' : 'badge-light-danger' }}">
        {{ $user->is_active ? 'Active' : 'Blocked' }}
    </span>
</div> 