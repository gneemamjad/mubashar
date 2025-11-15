@extends('layouts.main')

@section('content')
<main class="grow content pt-5" id="content" role="content">
    <div class="container-fluid">
     <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
      <div class="flex flex-col justify-center gap-2">
       <h1 class="text-xl font-medium leading-none text-gray-900">
        {{ __('admin.ads_nearby.title') }}
       </h1>
       <div class="flex items-center gap-2 text-sm font-normal text-gray-700">
        {{ __('admin.ads_nearby.overview') }}
       </div>
      </div>
      <div class="flex items-center gap-2.5">
       {{-- <a class="btn btn-sm btn-light" href="{{ route('admin.roles.create') }}">
        New Role
       </a> --}}
      </div>
     </div>
    </div>
    <!-- End of Container -->
<div class="container-fluid">
    <div class="card" style="margin:0 5% 5% 5%;">
                <div class="card-header">
                    <h3 class="card-title">{{ __('admin.ads_nearby.nearby.title', ['title' => $ad->title]) }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse($nearbyAds as $nearAd)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="grid grid-cols-3 gap-4">
                                            <div class="col-span-1">
                                                <h5 class="card-title">{{ $nearAd->title }}</h5>
                                                <p class="card-text">{{ Str::limit($nearAd->description, 100) }}</p>
                                                <p class="card-text mt-3">
                                                    <strong>{{ __('admin.ads_nearby.nearby.price') }}:</strong> {{ number_format($nearAd->price, 2) }}
                                                </p>
                                                <p class="card-text">
                                                    <small class="text-muted">
                                                        {{ __('admin.ads_nearby.nearby.distance', ['distance' => round($nearAd->distance)]) }}
                                                    </small>
                                                </p>
                                                <a href="{{ route('admin.ads.show', $nearAd->id) }}" 
                                                    class="btn btn-primary btn-sm mt-5">
                                                    {{ __('admin.ads_nearby.nearby.view_details') }}
                                                </a>
                                            </div>
                                            <div class="col-span-1">

                                            </div>
                                            <div class="col-span-1">
                                                @if($nearAd->media->count() > 0)
                                                <img src="{{ getMediaUrl($nearAd->media[0]->name, 'images') }}" 
                                                     class="img-fluid rounded" 
                                                     alt="{{ $nearAd->title }}"
                                                     style="height: 100px; object-fit: cover;">
                                                @endif
                                            </div>
                                         
                                        </div>
                                      
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-info">
                                    {{ __('admin.ads_nearby.nearby.no_ads') }}
                                </div>
                            </div>
                        @endforelse 
                    </div>
                </div>
            </div>
      
</div>
</main>
@endsection