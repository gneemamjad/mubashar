{{-- <div class="dropdown">
    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
        Status
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item change-status" href="#" data-status="pending" data-id="{{ $reel->id }}">Pending</a></li>
        <li><a class="dropdown-item change-status" href="#" data-status="approved" data-id="{{ $reel->id }}">Approve</a></li>
        <li><a class="dropdown-item change-status" href="#" data-status="not_approved" data-id="{{ $reel->id }}">Reject</a></li>
    </ul>
</div> --}}

{{-- <button class="btn btn-sm btn-{{ $reel->is_active ? 'success' : 'danger' }} toggle-active" data-id="{{ $reel->id }}">
    {{ $reel->is_active ? 'Active' : 'Inactive' }}
</button> --}}

{{-- <button class="btn btn-sm btn-danger delete-ad" data-id="{{ $reel->id }}">Delete</button>  --}}

<div class="d-flex align-items-center gap-2">
    <!-- <a style="margin: 5px; {{ $reel->status == '1' ? 'background-color: var(--tw-dark);' : '' }}" href="/admin/reels/{{$reel->id}}/change-status"
            class="btn btn-sm {{ $reel->status == '1' ? 'btn-danger' : 'btn-success' }} text-center" 
            data-id="{{ $reel->id }}"
            ><i class="ki-filled {{ $reel->status == '1' ? 'ki-pill' : 'ki-check' }}"></i>{{ $reel->status == '1' ? 'Reject' : 'Approve' }}</a>
    <a style="margin:5px" href="/admin/reels/{{$reel->id}}/delete"
            class="btn btn-sm btn-danger" 
            data-id="{{ $reel->id }}"><i class="ki-filled ki-trash"></i>{{ __('admin.delete') }}</a> -->
    <a style="margin: 5px; {{ $reel->status == '1' ? 'background-color: var(--tw-dark);' : '' }}" 
            href="/admin/reels/{{$reel->id}}/change-status"
            class="btn btn-sm {{ $reel->status == '1' ? 'btn-danger' : 'btn-success' }} text-center action-confirm"
            data-id="{{ $reel->id }}"
            data-message="{{ $reel->status == '1' ? 'Are you sure you want to reject this reel?' : 'Are you sure you want to approve this reel?' }}"
            ><i class="ki-filled {{ $reel->status == '1' ? 'ki-pill' : 'ki-check' }}"></i>{{ $reel->status == '1' ? 'Reject' : 'Approve' }}</a>

    <a style="margin:5px" 
            href="/admin/reels/{{$reel->id}}/delete"
            class="btn btn-sm btn-danger action-confirm"
            data-id="{{ $reel->id }}"
            data-message="Are you sure you want to delete this reel?"
            ><i class="ki-filled ki-trash"></i>{{ __('admin.delete') }}</a>
</div>


