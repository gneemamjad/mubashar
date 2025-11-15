<div class="menu" data-menu="true">
    <div class="menu-item" data-menu-item-toggle="dropdown">
        <button class="menu-toggle btn btn-sm btn-icon btn-light btn-clear">
            <i class="ki-filled ki-dots-vertical"></i>
        </button>
        <div class="menu-dropdown menu-default w-full max-w-[175px]">
            @can('edit_admins')
                <div class="menu-item">
                    <a class="menu-link" href="{{ route('admins.edit', $admin->id) }}">
                        <span class="menu-icon">
                            <i class="ki-filled ki-pencil"></i>
                        </span>
                        <span class="menu-title">Edit</span>
                    </a>
                </div>
                <div class="menu-item">
                    <button class="menu-link w-full" onclick="AdminsList.toggleStatus({{ $admin->id }})">
                        <span class="menu-icon">
                            <i class="ki-filled ki-check"></i>
                        </span>
                        <span class="menu-title">Toggle Status</span>
                    </button>
                </div>
            @endcan
            @can('delete_admins')
                <div class="menu-separator"></div>
                <div class="menu-item">
                    <button class="menu-link w-full" onclick="AdminsList.deleteAdmin({{ $admin->id }})">
                        <span class="menu-icon">
                            <i class="ki-filled ki-trash"></i>
                        </span>
                        <span class="menu-title">Remove</span>
                    </button>
                </div>
            @endcan
        </div>
    </div>
</div> 