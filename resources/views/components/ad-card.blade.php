@php
    $currencyLabel = \App\Models\Currency::getCurrency($ad->currency_id);
    $createdAt = optional($ad->created_at)->format('Y-m-d');
    $mediaUrl = getMediaUrl($ad->image, MEDIA_TYPES['image']);
    $extension = strtolower(pathinfo($ad->image, PATHINFO_EXTENSION));
    $priceValue = is_numeric($ad->price) ? number_format((float) $ad->price, 2) : $ad->price;
@endphp

<article class="ad-card" dir="rtl">
    <a href="{{ route('showAd', $ad->id) }}" class="ad-card__link" aria-label="{{ $ad->title }}">
        <div class="ad-card__image-wrapper">
            @if(in_array($extension, ['jpg','jpeg','png','gif','webp']))
            <img src="{{ $mediaUrl }}" alt="{{ $ad->title }}" loading="lazy">
            @else
            <img
                alt="{{ $ad->title }}" loading="lazy"
                src="https://placeholders.io/400/300">
            @endif
        </div>
        <div class="ad-card__body">
            <h3 class="ad-card__title">{{ $ad->title }}</h3>
            @if($createdAt)
                <div class="ad-card__meta">
                    <span>{{ $createdAt }}</span>
                    @if(!empty($ad->city))
                        <span>•</span>
                        <span>{{ $ad->city->name }}</span>
                    @endif
                </div>
            @endif
            <div class="ad-card__price">
                <strong>{{ $priceValue }}</strong>
                <span>{{ $currencyLabel }}</span>
            </div>
        </div>
    </a>
</article>
