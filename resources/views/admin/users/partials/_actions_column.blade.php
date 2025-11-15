<div class="d-flex align-items-center gap-2">
    <button type="button" 
            class="btn btn-sm {{ $user->blocked ? 'btn-light-success' : 'btn-light-danger' }} toggle-block" 
            data-id="{{ $user->id }}">
        <i class="ki-filled {{ $user->blocked ? 'ki-check' : 'ki-pill' }}"></i>
        {{ $user->blocked ? 'Unblock' : 'Block' }}
    </button>
</div>

