@php
    app()->setLocale('ar');
@endphp

@extends('front.layouts.master')

@section('title', 'Mubashar')

@section('content')
    @include('front.partials.ads-styles')

    <div class="ads-page" dir="rtl">
        @forelse($returnData as $categoryData)
            @php
                $category = $categoryData['category'];
                $ads = $categoryData['ads'];
            @endphp

            @continue($ads->isEmpty())

            <section class="ads-section">
                <div class="ads-section__header">
                    <h2 class="ads-section__title">{{ $category->name }}</h2>
                    <a class="ads-section__link" href="{{ route('landing', ['category' => $category->id]) }}">
                        عرض الكل
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m13 5 7 7-7 7M5 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <div class="ads-grid">
                    @foreach($ads as $ad)
                        @include('components.ad-card', ['ad' => $ad])
                    @endforeach
                </div>
            </section>
        @empty
            <p class="ads-empty-state">لا يوجد إعلانات لعرضها حالياً.</p>
        @endforelse
    </div>
@endsection
