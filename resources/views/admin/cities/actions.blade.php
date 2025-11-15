<div class="dropdown" style="text-align: center; display: flex; justify-content: center">
    @if(auth()->guard('admin')->user()->hasAnyPermission(['edit cities'], 'admin'))

    <a style="text-align: center" class="dropdown-item edit-city " href="javascript:;" data-ar-name="{{ $city->getTranslation('name', 'ar') }}" data-id="{{ $city->id }}" data-en-name="{{ $city->getTranslation('name', 'en') }}" data-active="{{ $city->active }}" >
        <i class="ki-filled ki-pencil text-lg"></i>

    </a>
    @endif
    {{-- <a class="dropdown-item ml-5 delete-city" data-id="{{ $city->id }}" >
        <i class="ki-filled ki-trash fs-2 text-lg"></i>
    </a> --}}
</div>
