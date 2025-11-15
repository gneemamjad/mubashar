@extends('layouts.main')

@section('content')
<main class="grow content pt-5" id="content" role="content">
    <div class="container-fluid">
     <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
      <div class="flex flex-col justify-center gap-2">
       <h1 class="text-xl font-medium leading-none text-gray-900">
        {{ __('ads.ads') }}
       </h1>
       <div class="flex items-center gap-2 text-sm font-normal text-gray-700">
        {{ __('ads.overview') }}
       </div>
      </div>
     </div>
    </div>
    <div class="container-fluid">
        <div class="card" style="margin:0 5% 5% 5%;">
            <div class="card-body">
                <div class="row">
                    @forelse($ads as $ad)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="grid grid-cols-3 gap-4">
                                        <div class="col-span-1">
                                            <h5 class="card-title">{{ $ad->title }}</h5>
                                            <p class="card-text">{{ Str::limit($ad->description, 100) }}</p>
                                            <p class="card-text mt-3">
                                                <strong>{{ __('ads.price') }}:</strong> {{ number_format($ad->price, 2) }}
                                            </p>
                                        
                                            <a href="{{ route('admin.ads.show', $ad->id) }}" 
                                               class="btn btn-primary btn-sm mt-5">
                                                {{ __('ads.view_details') }}
                                            </a>
                                        </div>
                                        <div class="col-span-1">
                                        </div>
                                        <div class="col-span-1">
                                            @if($ad->media->count() > 0)
                                            <img src="{{ getMediaUrl($ad->media[0]->name, 'images') }}" 
                                                 class="img-fluid rounded" 
                                                 alt="{{ $ad->title }}"
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
                                {{ __('ads.no_ads') }}
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</main>
@endsection