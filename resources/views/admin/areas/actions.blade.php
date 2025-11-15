<div class="dropdown" style="text-align: center; display: flex; justify-content: center;">
    @if(auth()->guard('admin')->user()->hasAnyPermission(['edit areas'], 'admin'))

    <a class="dropdown-item edit-area " href="javascript:;" data-city="{{ $area->city_id }}" data-ar-name="{{ $area->getTranslation('name', 'ar') }}" data-id="{{ $area->id }}" data-en-name="{{ $area->getTranslation('name', 'en') }}" data-active="{{ $area->active }}" >
        <i class="ki-filled ki-pencil text-lg"></i>

    </a>
    @endif

    {{-- <a class="dropdown-item ml-5 delete-area" data-id="{{ $area->id }}" >
        <i class="ki-filled ki-trash fs-2 text-lg"></i>
    </a> --}}
</div>
