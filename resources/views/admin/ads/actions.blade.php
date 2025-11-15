{{-- <div class="btn-group">
    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
        Status
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item change-status" href="#" data-status="pending" data-id="{{ $ad->id }}">Pending</a>
        <a class="dropdown-item change-status" href="#" data-status="approved" data-id="{{ $ad->id }}">Approve</a>
        <a class="dropdown-item change-status" href="#" data-status="not_approved" data-id="{{ $ad->id }}">Reject</a>
    </div>
</div> --}}
{{-- <button class="btn btn-sm btn-{{ $ad->is_active ? 'success' : 'danger' }} toggle-active" data-id="{{ $ad->id }}">
    {{ $ad->is_active ? 'Active' : 'Inactive' }}
</button> --}}
<a href="{{ route('admin.ads.show', $ad) }}" class="btn">
    <i class="ki-filled ki-search-list">
    </i>
   </a>
<a href="{{ route('admin.ads.editAd', $ad->id) }}" class="btn">
    <i class="ki-filled ki-pencil"></i>
    </i>
   </a>
{{-- <button class="btn btn-sm btn-danger delete-ad" data-id="{{ $ad->id }}">Delete</button>  --}}