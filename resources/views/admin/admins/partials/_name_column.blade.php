<div class="flex items-center gap-2.5">
    <div class="flex flex-col gap-0.5">
        <a href="{{ route('admins.edit', $admin->id) }}" class="leading-none font-medium text-sm text-gray-900 hover:text-primary">
            {{ $admin->name }}
        </a>
        <span class="text-2sm text-gray-700 font-normal">{{ $admin->email }}</span>
    </div>
</div> 