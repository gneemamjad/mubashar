<div class="dropdown" style="text-align: center; display: flex; justify-content: center;">

            <a class="dropdown-item delete-attribute m-1" href="javascript:;" data-id="{{ $attribute->id }}">
                <i class="ki-filled ki-trash text-lg"></i>

            </a>
            <a class="dropdown-item ml-5" href="{{ route('admin.attributes.edit', $attribute->id) }}">
                <i class="ki-filled ki-pencil text-lg"></i>
            </a>
</div>
