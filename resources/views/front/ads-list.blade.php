@php
    app()->setLocale('ar');
@endphp

@extends('front.layouts.master')

@section('title', 'Mubashar')

@section('content')
    @include('front.partials.ads-styles')

    @php
        $categoryModel = $category ?? ($returnData[0]['category'] ?? null);
        $adsCollection = $ads ?? ($returnData[0]['ads'] ?? collect());
    @endphp

    <div class="ads-page" dir="rtl">
        <section class="ads-section">
            <div class="ads-section__header">
                <h2 class="ads-section__title">{{ $categoryModel?->name ?? 'الإعلانات' }}</h2>
                @if($categoryModel)
                    <a class="ads-section__link" href="{{ route('landing', ['category' => $categoryModel->id]) }}">
                        الرجوع للقسم
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                @endif
            </div>

            <div id="ads-container" class="ads-grid">
                @foreach($adsCollection as $ad)
                    @include('components.ad-card', ['ad' => $ad])
                @endforeach
            </div>

            @if($adsCollection->isEmpty())
                <p class="ads-empty-state">لا يوجد إعلانات لعرضها حالياً.</p>
            @endif
        </section>
    </div>

    @if(isset($returnData))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const adsContainer = document.getElementById('ads-container');
                if (!adsContainer) {
                    return;
                }

                let page = 1;
                let loading = false;
                let hasMore = true;
                const categoryId = '{{ $categoryModel?->id }}';

                const loadMoreAds = async () => {
                    if (loading || !hasMore || !categoryId) {
                        return;
                    }

                    loading = true;
                    page += 1;

                    try {
                        const response = await fetch(`/load-ads?page=${page}&category_id=${categoryId}`);
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }

                        const data = await response.json();
                        adsContainer.insertAdjacentHTML('beforeend', data.html);
                        hasMore = Boolean(data.hasMore);
                    } catch (error) {
                        console.error('Unable to load additional ads', error);
                        hasMore = false;
                    } finally {
                        loading = false;
                    }
                };

                window.addEventListener('scroll', () => {
                    const scrollTriggerPoint = document.body.offsetHeight - 300;
                    if (window.innerHeight + window.scrollY >= scrollTriggerPoint) {
                        loadMoreAds();
                    }
                });
            });
        </script>
    @endif
@endsection
