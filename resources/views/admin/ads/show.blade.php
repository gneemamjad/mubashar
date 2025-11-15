@extends('layouts.main')

@section('styles')
<style>
    /* Main container styles */
    .ad-details-container {
        padding: 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    /* Media slider styles */
    .slideshow-container {
        max-width: 100%;
        position: relative;
        margin: 20px 0;
        background: #f8f9fa;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .mySlides {
        display: none;
        padding: 20px;
    }

    .mySlides img {
        width: 100%;
        height: 400px;
        object-fit: contain;
        border-radius: 4px;
    }

    .mySlides video {
        width: 100%;
        height: 400px;
        object-fit: contain;
        background: #000;
        border-radius: 4px;
    }

    /* Navigation buttons */
    .prev, .next {
        cursor: pointer;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        padding: 15px;
        color: #fff;
        font-weight: bold;
        font-size: 20px;
        transition: 0.3s ease;
        border-radius: 50%;
        user-select: none;
        background: rgba(0,0,0,0.6);
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .next {
        right: 20px;
    }

    .prev {
        left: 20px;
    }

    .prev:hover, .next:hover {
        background: rgba(0,0,0,0.9);
    }

    /* Dots/bullets/indicators */
    .dots-container {
        text-align: center;
        padding: 10px 0;
        background: rgba(255,255,255,0.9);
        position: absolute;
        bottom: 0;
        width: 100%;
    }

    .dot {
        cursor: pointer;
        height: 12px;
        width: 12px;
        margin: 0 4px;
        background-color: #bbb;
        border-radius: 50%;
        display: inline-block;
        transition: background-color 0.3s ease;
    }

    .active, .dot:hover {
        background-color: #717171;
    }

    /* Slide number */
    .numbertext {
        color: #fff;
        font-size: 14px;
        padding: 8px 12px;
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(0,0,0,0.6);
        border-radius: 4px;
    }

    /* Modal centering styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        z-index: 1050;
    }

    .modal.fade .modal-dialog {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%) !important;
        margin: 0;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body px-10 py-7.5 lg:pe-12.5">
            <div class="flex flex-wrap md:flex-nowrap  gap-6 md:gap-10">
                <div class="flex flex-col gap-3" style="width: 60%">
                    <h2 class="text-1.5xl font-semibold text-gray-900">
                        {{ $ad->title }}
                    </h2>
                    <p class="text-sm text-gray-700 leading-5.5">
                        {!! $ad->description !!}
                    </p>
                    <a href="{{ route('admin.ads.nearby', $ad->id) }}" style="width: 25%;" class="btn btn-sm btn-primary">
                        <i class="fas fa-map-marker-alt"></i> {{ __('admin.view_nearby_ads') }}
                    </a>
                </div>
                
                <div class="slideshow-container w-full" style="width: 40%;">
                    @foreach($ad->media as $index => $media)                            
                        <div class="mySlides fade">
                            <div class="numbertext">{{ $index + 1 }} / {{ count($ad->media) }}</div>
                            @if($media->type == 1)
                                <h1>Image</h1>
                                <img src="{{ getMediaUrl($media->name,$media->type) }}" alt="Ad Image">
                            @elseif($media->type == 2)
                                <h1>Video</h1>
                                <video controls>
                                    <source src="{{ getMediaUrl($media->name,$media->type) }}" type="video/mp4">
                                </video>
                            @else
                                <h1>360 Image</h1>
                                <img src="{{ getMediaUrl($media->name,$media->type) }}" alt="Ad Image">
                            @endif                                    
                        </div>
                    @endforeach
                    @if (count($ad->media) > 1)
                    <div style="text-align: center; spaceBetween:0.9rem">
                    <a class="prev" onclick="plusSlides(-1)">❮</a>
                    <a class="next" onclick="plusSlides(1)">❯</a>
                    </div>
                    <div class="dots-container">
                        @for($i = 0; $i < count($ad->media); $i++)
                            <span class="dot" onclick="currentSlide({{ $i + 1 }})"></span>
                        @endfor
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <hr class="my-5">
    <br>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-5 lg:gap-7.5 mt-5">
        @foreach($ad->attributes as $index => $attribute)
            <div class="col-span-1" style="overflow: overlay;">
                <div class="card h-100">
                    <div class="card-header">
                        <h3 class="card-title">{{ $attribute['name'] }} Attributes</h3>
                    </div>
                    <div class="card-body">
                        <table class="table-auto">
                            <tbody>
                                @foreach ($attribute['attributes'] as $attr)
                                <tr>
                                    <td class="text-sm text-gray-600 pb-3.5 pe-3">{{ $attr['key'] }}</td>
                                    <td class="text-sm text-gray-900 pb-3.5">{{ isset($attr['value']) ? $attr['value'] : $attr['attribute_options'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="col-span-1" style="overflow: overlay;">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title">{{ __('admin.pricing_information') }}</h3>
                </div>
                <div class="card-body">
                    <table class="table-auto">
                        <tbody>
                            <tr>
                                <td class="text-sm text-gray-600 pb-3.5 pe-3">{{ __('admin.price') }}</td>
                                <td class="text-sm text-gray-900 pb-3.5">{{ $ad->price }}</td>
                            </tr>
                            <tr>
                                <td class="text-sm text-gray-600 pb-3.5 pe-3">{{ __('admin.paid_status') }}</td>
                                <td class="text-sm text-gray-900 pb-3.5">
                                    <span class="status-badge badge bg-{{ $ad->paid == 1 ? 'success' : 'danger' }}" style="color: #f8f9fa">
                                        {{ $ad->paid == 1 ? __('admin.paid') : __('admin.unpaid') }}
                                    </span>
                                </td>
                            </tr>
                            @if($ad->plans->count() > 0)
                            <tr>
                                <td class="text-sm text-gray-600 pb-3.5 pe-3">Plan</td>
                                @foreach ($ad->plans as $plan)
                           
                                    <td class="text-sm text-gray-900 pb-3.5">{{ $plan->title }}</td>
                                @endforeach
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-span-1" style="overflow: overlay;">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title">{{ __('admin.owner_information') }}</h3>
                </div>
                <div class="card-body">
                    <table class="table-auto">
                        <tbody>
                            <tr>
                                <td class="text-sm text-gray-600 pb-3.5 pe-3">{{ __('admin.name') }}</td>
                                <td class="text-sm text-gray-900 pb-3.5">{{ $ad->owner->name }}</td>
                            </tr>
                            <tr>
                                <td class="text-sm text-gray-600 pb-3.5 pe-3">{{ __('admin.mobile') }}</td>
                                <td class="text-sm text-gray-900 pb-3.5">{{ $ad->owner->mobile }}</td>
                            </tr>
                            <tr>
                                <td class="text-sm text-gray-600 pb-3.5 pe-3">{{ __('admin.email') }}</td>
                                <td class="text-sm text-gray-900 pb-3.5">{{ $ad->owner->email }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-span-1" style="overflow: overlay;">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('admin.status_information') }}</h3>
                </div>
                <div class="card-body pt-4 pb-3">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="text-sm text-gray-600 pb-3.5 pe-3">{{ __('admin.current_status') }}</td>
                                <td class="text-sm text-gray-900 pb-3.5">
                                    <span style="color: #f8f9fa" class="status-badge badge bg-{{ $ad->approved == 1 ? 'success' : ($ad->approved == 0 ? 'warning' : 'danger') }}">
                                        {{ $ad->approved == 1 ? __('admin.approved') : ($ad->approved == 0 ? __('admin.pending') : __('admin.rejected')) }}
                                    </span>
                                </td>
                                <td class="text-sm text-gray-900 pb-3.5">
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#statusModal">
                                        <i class="ki-filled ki-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-sm text-gray-600 pb-3.5 pe-3">{{ __('admin.active_status') }}</td>
                                <td class="text-sm text-gray-900 pb-3.5">
                                    <span style="color: #f8f9fa" class="status-badge badge bg-{{ $ad->active ? 'success' : 'danger' }}">
                                        {{ $ad->active ? __('admin.yes') : __('admin.no') }}
                                    </span>
                                </td>
                                <td class="text-sm text-gray-900 pb-3.5">
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#activeModal">
                                        <i class="ki-filled ki-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-sm text-gray-600 pb-3.5 pe-3">{{ __('admin.premium') }}</td>
                                <td class="text-sm text-gray-900 pb-3.5">
                                    <span style="color: #f8f9fa" class="status-badge badge bg-{{ $ad->paid ? 'success' : 'danger' }}">
                                        {{ $ad->paid ? __('admin.yes') : __('admin.no') }}
                                    </span>
                                </td>
                                <td class="text-sm text-gray-900 pb-3.5">
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#premiumModal">
                                        <i class="ki-filled ki-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-sm text-gray-600 pb-3.5 pe-3">{{ __('admin.sold') }}</td>
                                <td class="text-sm text-gray-900 pb-3.5">
                                    <span style="color: #f8f9fa" class="status-badge badge bg-{{ $ad->sold ? 'success' : 'danger' }}">
                                        {{ $ad->sold ? __('admin.yes') : __('admin.no') }}
                                    </span>
                                </td>
                                <td class="text-sm text-gray-900 pb-3.5">
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#soldModal">
                                        <i class="ki-filled ki-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-sm text-gray-600 pb-3.5 pe-3">{{ __('admin.rented') }}</td>
                                <td class="text-sm text-gray-900 pb-3.5">
                                    <span style="color: #f8f9fa" class="status-badge badge bg-{{ $ad->rented ? 'success' : 'danger' }}">
                                        {{ $ad->rented ? __('admin.yes') : __('admin.no') }}
                                    </span>
                                </td>
                                <td class="text-sm text-gray-900 pb-3.5">
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#rentedModal">
                                        <i class="ki-filled ki-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-sm text-gray-600 pb-3.5 pe-3">{{ __('admin.highlighter') }}</td>
                                <td class="text-sm text-gray-900 pb-3.5">
                                    <span style="color: #f8f9fa" class="status-badge badge bg-{{ $ad->highlighter ? 'success' : 'danger' }}">
                                        {{ $ad->highlighter ? __('admin.yes') : __('admin.no') }}
                                    </span>
                                </td>
                                <td class="text-sm text-gray-900 pb-3.5">
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#highlighterModal">
                                        <i class="ki-filled ki-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-span-1" style="overflow: overlay;">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('admin.reels') }}</h3>
                </div>
                <div class="card-body pt-4 pb-3">
                    <div class="slideshow-container w-full" style="width: 40%;">
                    @foreach($ad->reels as $index => $reel)                            
                        <div class="mySlides2 fade">
                            <div class="numbertext">{{ $index + 1 }} / {{ count($ad->reels) }}</div>
                            <video controls>
                                <source src="{{ $reel->reel }}" type="video/mp4">
                            </video>                                 
                        </div>
                    @endforeach
                    @if (count($ad->reels) > 1)
                    <div style="text-align: center; spaceBetween:0.9rem">
                        <a class="prev" onclick="plusSlides2(-1)">❮</a>
                        <a class="next" onclick="plusSlides2(1)">❯</a>
                    </div>
                    <div class="dots-container">
                        @for($i = 0; $i < count($ad->reels); $i++)
                            <span class="dot2" onclick="currentSlide2({{ $i + 1 }})"></span>
                        @endfor
                    </div>
                    @endif
                </div>
                </div>
            </div>
        </div>
    </div>



</div>

<!-- Add this modal for status change -->

<div class="modal fade" id="statusModal" style="width: 50%;" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-white rounded-lg shadow-xl" style="width:50%;position:fixed; top:50%; left:50%; transform:translate(-50%, -50%);">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">{{ __('admin.change_ad_status') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="margin: 2%; text-align: center;">
                <select class="select" id="statusSelect">
                    <option></option>
                    <option value="0" {{ $ad->status == 'pending' ? 'selected' : '' }}>{{ __('admin.pending') }}</option>
                    <option value="1" {{ $ad->status == 'approved' ? 'selected' : '' }}>{{ __('admin.approved') }}</option>
                    <option value="2" {{ $ad->status == 'rejected' ? 'selected' : '' }}>{{ __('admin.rejected') }}</option>
                </select>
            </div>
            <div class="modal-footer" style="margin: 2%; text-align: center;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal-close">{{ __('admin.discard') }}</button>
                <button type="button" class="btn btn-primary" onclick="updateStatus({{ $ad->id }})">{{ __('admin.submit') }}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="activeModal" style="width: 50%;" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-white rounded-lg shadow-xl" style="width:50%;position:fixed; top:50%; left:50%; transform:translate(-50%, -50%);">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">{{ __('admin.change_active_status') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="margin: 2%; text-align: center;">
                <select class="select" id="activeSelect">
                    <option></option>
                    <option value="0" {{ $ad->active == '0' ? 'selected' : '' }}>{{ __('admin.inactive') }}</option>
                    <option value="1" {{ $ad->status == '1' ? 'selected' : '' }}>{{ __('admin.active') }}</option>
                </select>
            </div>
            <div class="modal-footer" style="margin: 2%; text-align: center;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal-active-close">{{ __('admin.cancel') }}</button>
                <button type="button" class="btn btn-primary" onclick="toggleActive({{ $ad->id }})">{{ __('admin.save_changes') }}</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="premiumModal" style="width: 50%;" tabindex="-1" aria-labelledby="premiumModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-white rounded-lg shadow-xl" style="width:50%;position:fixed; top:50%; left:50%; transform:translate(-50%, -50%);">
            <div class="modal-header">
                <h5 class="modal-title" id="premiumModalLabel">{{ __('admin.change_premium_status') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="margin: 2%; text-align: center;">
                <select class="select" id="premiumSelect">
                    <option></option>
                    <option value="0" {{ $ad->premium == '0' ? 'selected' : '' }}>{{ __('admin.yes') }}</option>
                    <option value="1" {{ $ad->premium == '1' ? 'selected' : '' }}>{{ __('admin.no') }}</option>
                </select>
            </div>
            <div class="modal-footer" style="margin: 2%; text-align: center;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal-active-close">{{ __('admin.cancel') }}</button>
                <button type="button" class="btn btn-primary" onclick="togglepremium({{ $ad->id }})">{{ __('admin.save_changes') }}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="soldModal" style="width: 50%;" tabindex="-1" aria-labelledby="soldModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-white rounded-lg shadow-xl" style="width:50%;position:fixed; top:50%; left:50%; transform:translate(-50%, -50%);">
            <div class="modal-header">
                <h5 class="modal-title" id="soldModalLabel">{{ __('admin.change_sold_status') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="margin: 2%; text-align: center;">
                <select class="select" id="soldSelect">
                    <option></option>
                    <option value="0" {{ $ad->sold == '0' ? 'selected' : '' }}>{{ __('admin.yes') }}</option>
                    <option value="1" {{ $ad->sold == '1' ? 'selected' : '' }}>{{ __('admin.no') }}</option>
                </select>
            </div>
            <div class="modal-footer" style="margin: 2%; text-align: center;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal-active-close">{{ __('admin.cancel') }}</button>
                <button type="button" class="btn btn-primary" onclick="togglesold({{ $ad->id }})">{{ __('admin.save_changes') }}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="rentedModal" style="width: 50%;" tabindex="-1" aria-labelledby="rentedModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-white rounded-lg shadow-xl" style="width:50%;position:fixed; top:50%; left:50%; transform:translate(-50%, -50%);">
            <div class="modal-header">
                <h5 class="modal-title" id="rentedModalLabel">{{ __('admin.change_rented_status') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="margin: 2%; text-align: center;">
                <select class="select" id="rentedSelect">
                    <option></option>
                    <option value="0" {{ $ad->rented == '0' ? 'selected' : '' }}>{{ __('admin.yes') }}</option>
                    <option value="1" {{ $ad->rented == '1' ? 'selected' : '' }}>{{ __('admin.no') }}</option>
                </select>
            </div>
            <div class="modal-footer" style="margin: 2%; text-align: center;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal-active-close">{{ __('admin.cancel') }}</button>
                <button type="button" class="btn btn-primary" onclick="togglerented({{ $ad->id }})">{{ __('admin.save_changes') }}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="highlighterModal" style="width: 50%;" tabindex="-1" aria-labelledby="highlighterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-white rounded-lg shadow-xl" style="width:50%;position:fixed; top:50%; left:50%; transform:translate(-50%, -50%);">
            <div class="modal-header">
                <h5 class="modal-title" id="highlighterModalLabel">{{ __('admin.change_highlighter_status') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="margin: 2%; text-align: center;">
                <select class="select" id="highlighterSelect">
                    <option></option>
                    <option value="0" {{ $ad->highlighter == '0' ? 'selected' : '' }}>{{ __('admin.yes') }}</option>
                    <option value="1" {{ $ad->highlighter == '1' ? 'selected' : '' }}>{{ __('admin.no') }}</option>
                </select>
            </div>
            <div class="modal-footer" style="margin: 2%; text-align: center;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal-active-close">{{ __('admin.cancel') }}</button>
                <button type="button" class="btn btn-primary" onclick="togglehighlighter({{ $ad->id }})">{{ __('admin.save_changes') }}</button>
            </div>
        </div>
    </div>
</div>


@endsection 

@section('scripts')
<script>

// Modal toggle element
const modalEl = document.querySelector('#statusModal');
const modalActiveEl = document.querySelector('#activeModal');
const modalpremiumEl = document.querySelector('#premiumModal');
const modalsoldEl = document.querySelector('#soldModal');
const modalrentedEl = document.querySelector('#rentedModal');
const modalhighlighterEl = document.querySelector('#highlighterModal');

// Configuration options(optional)
const options = {
    backdropClass: 'transition-all duration-300 fixed inset-0 bg-gray-900 opacity-25',
    backdrop: true,
    disableScroll: true,
    persistent: true,
    modalClass: 'transition-all duration-300 fixed z-50' // Add z-index and transition
};

// Initialize object

const modal = new KTModal(modalEl, options);
const modalActive = new KTModal(modalActiveEl, options);
const modalpremium = new KTModal(modalpremiumEl, options);
const modalsold = new KTModal(modalsoldEl, options);
const modalrented = new KTModal(modalrentedEl, options);
const modalhighlighter = new KTModal(modalhighlighterEl, options);
// Show modal when button clicked
document.querySelector('[data-bs-target="#statusModal"]').addEventListener('click', function() {
    modal.show();
});


// Show modal when button clicked
document.querySelector('[data-bs-target="#activeModal"]').addEventListener('click', function() {
    modalActive.show();
});

// Show modal when button clicked
document.querySelector('[data-bs-target="#premiumModal"]').addEventListener('click', function() {
    modalpremium.show();
});

// Show modal when button clicked
document.querySelector('[data-bs-target="#soldModal"]').addEventListener('click', function() {
    modalsold.show();
});
// Show modal when button clicked
document.querySelector('[data-bs-target="#rentedModal"]').addEventListener('click', function() {
    modalrented.show();
});
// Show modal when button clicked
document.querySelector('[data-bs-target="#highlighterModal"]').addEventListener('click', function() {
    modalhighlighter.show();
});




// Hide modal when button clicked
document.querySelector('[data-bs-dismiss="modal-close"]').addEventListener('click', function() {
    modal.hide();

    // Remove backdrop/gray screen after modal is hidden
    const backdrop = document.querySelector('.modal-backdrop');
    if (backdrop) {
        backdrop.remove();
    }
    document.body.classList.remove('modal-open');
});

// Hide modal when button clicked
document.querySelector('[data-bs-dismiss="modal-active-close"]').addEventListener('click', function() {
    modalActive.hide();

    // Remove backdrop/gray screen after modal is hidden
    const backdrop = document.querySelector('.modal-backdrop');
    if (backdrop) {
        backdrop.remove();
    }
    document.body.classList.remove('modal-open');
});



    let slideIndex = 1;
    showSlides(slideIndex);
    
    function plusSlides(n) {
        showSlides(slideIndex += n);
    }
    
    function currentSlide(n) {
        showSlides(slideIndex = n);
    }
    
    function showSlides(n) {
        let slides = document.getElementsByClassName("mySlides");
        let dots = document.getElementsByClassName("dot");
        
        if (n > slides.length) {slideIndex = 1}    
        if (n < 1) {slideIndex = slides.length}
        
        // Hide all slides
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
        }
        
        // Remove active class from all dots
        for (let i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        
        // Show current slide and activate corresponding dot
        slides[slideIndex-1].style.display = "block";  
        dots[slideIndex-1].className += " active";

        // Pause all videos when switching slides
        const videos = document.querySelectorAll('video');
        videos.forEach(video => video.pause());
    }

    /* */

    let slide2Index = 1;
    showSlides2(slide2Index);
    
    function plusSlides2(n) {
        showSlides2(slide2Index += n);
    }
    
    function currentSlide(n) {
        showSlides2(slide2Index = n);
    }
    
    function showSlides2(n) {
        let slides = document.getElementsByClassName("mySlides2");
        let dots = document.getElementsByClassName("dot2");
        
        if (n > slides.length) {slideIndex = 1}    
        if (n < 1) {slideIndex = slides.length}
        
        // Hide all slides
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
        }
        
        // Remove active class from all dots
        for (let i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        
        // Show current slide and activate corresponding dot
        slides[slideIndex-1].style.display = "block";  
        dots[slideIndex-1].className += " active";

        // Pause all videos when switching slides
        const videos = document.querySelectorAll('video');
        videos.forEach(video => video.pause());
    }


    function updateStatus(adId) {
        const status = document.getElementById('statusSelect').value;
        
        $.ajax({
            url: `/admin/ads/${adId}/update-status`,
            type: 'POST',
            data: { 
                status: status,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    window.location.reload();
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error updating status'
                });            }
        });
    }

    function toggleActive(adId) {
        const status = document.getElementById('activeSelect').value;
        
        $.ajax({
            url: `/admin/ads/${adId}/toggle-active`,
            type: 'POST',
            data: { 
                status: status,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    window.location.reload();
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error updating status'
                });
            }
        });
    }

    
    function togglepremium(adId) {
        const status = document.getElementById('premiumSelect').value;
        
        $.ajax({
            url: `/admin/ads/${adId}/toggle-premium`,
            type: 'POST',
            data: { 
                status: status,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    window.location.reload();
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error updating status'
                });
            }
        });
    }

    function togglesold(adId) {
        const status = document.getElementById('soldSelect').value;
        
        $.ajax({
            url: `/admin/ads/${adId}/toggle-sold`,
            type: 'POST',
            data: { 
                status: status,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    window.location.reload();
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error updating status'
                });
            }
        });
    }

    function togglerented(adId) {
        const status = document.getElementById('rentedSelect').value;
        
        $.ajax({
            url: `/admin/ads/${adId}/toggle-rented`,
            type: 'POST',
            data: { 
                status: status,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    window.location.reload();
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error updating status'
                });
            }
        });
    }

    function togglehighlighter(adId) {
        const status = document.getElementById('highlighterSelect').value;
        
        $.ajax({
            url: `/admin/ads/${adId}/toggle-highlighter`,
            type: 'POST',
            data: { 
                status: status,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    window.location.reload();
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error updating status'
                });
            }
        });
    }


    function deleteAd(adId) {
        if (!confirm('Are you sure you want to delete this ad? This action cannot be undone.')) return;
        
        $.ajax({
            url: `/admin/ads/${adId}`,
            type: 'DELETE',
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    setTimeout(() => window.location.href = '/admin/ads', 1000);
                }
            },
            error: function() {
                toastr.error('Error deleting ad');
            }
        });
    }
</script>
@endsection