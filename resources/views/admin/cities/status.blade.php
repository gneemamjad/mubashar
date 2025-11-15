<div class="form-check form-switch">
    <input type="checkbox" class="form-check-input toggle-status" 
           data-id="{{ $id }}" 
           {{ $is_active ? 'checked' : '' }}>
    <label class="form-check-label">
        {{ $is_active ? __('admin.active') : __('admin.inactive') }}
    </label>
</div> 