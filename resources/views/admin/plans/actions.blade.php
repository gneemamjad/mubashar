<div class="d-flex justify-content-start gap-2">
    @if(auth()->guard('admin')->user()->hasAnyPermission(['edit plans'], 'admin'))
    <button
        class="btn btn-sm btn-icon btn-light-primary edit-plan"
        data-plan-id="{{ $plan->id }}"
        title="Edit">
        <i class="ki-duotone ki-pencil fs-2">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
    </button>
    @endif

    @if(auth()->guard('admin')->user()->hasAnyPermission(['delete plans'], 'admin'))
    <button
        class="btn btn-sm btn-icon btn-light-danger delete-plan"
        data-plan-id="{{ $plan->id }}"
        title="Delete">
        <i class="ki-filled ki-trash fs-2">
            <span class="path1"></span>
            <span class="path2"></span>
            <span class="path3"></span>
            <span class="path4"></span>
            <span class="path5"></span>
        </i>
    </button>
    @endif
</div>
