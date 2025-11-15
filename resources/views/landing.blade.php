<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إعلانات التصنيفات</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/landing.css">
</head>
<body class="page">
    <header class="page__header">
        <div class="page__brand">
            <div class="page__badge">إعلان</div>
            <div>
                <p class="page__eyebrow">استكشف أفضل العروض</p>
                <h1 class="page__title">البحث في الإعلانات</h1>
            </div>
        </div>
        <p class="page__lead">
            اختر التصنيف الذي تريده أو استخدم شريط البحث للعثور على الإعلان المناسب بسرعة.
        </p>
    </header>

    <section class="filters">
        <form action="{{ route('landing') }}" method="GET" class="filters__form">
            <div class="filters__group">
                <label for="category" class="filters__label">التصنيف</label>
                <select name="category" id="category" class="filters__control" onchange="this.form.submit()">
                    <option value="">عرض الكل</option>
                    @foreach (($categories ?? []) as $category)
                        <option value="{{ $category['slug'] ?? $category->slug }}" @selected(($selectedCategory ?? '') === ($category['slug'] ?? $category->slug))>
                            {{ $category['name'] ?? $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="filters__group filters__group--search">
                <label for="keyword" class="filters__label">بحث</label>
                <input type="search" id="keyword" name="keyword" value="{{ request('keyword') }}" placeholder="ابحث عن إعلان" class="filters__control">
            </div>
            <button type="submit" class="filters__submit">بحث متقدم</button>
        </form>
    </section>

    <section class="stats" aria-label="ملخص الإعلانات">
        <div class="stats__item">
            <span class="stats__value">{{ number_format($stats['total'] ?? ($ads->count() ?? 0)) }}</span>
            <span class="stats__label">إعلان متاح</span>
        </div>
        <div class="stats__item">
            <span class="stats__value">{{ number_format($stats['featured'] ?? 0) }}</span>
            <span class="stats__label">مميز</span>
        </div>
        <div class="stats__item">
            <span class="stats__value">{{ number_format($stats['new'] ?? 0) }}</span>
            <span class="stats__label">أضيف اليوم</span>
        </div>
    </section>

    <section class="ads" aria-label="قائمة الإعلانات">
        <header class="ads__header">
            <div>
                <p class="ads__eyebrow">النتائج الحالية</p>
                <h2 class="ads__title">
                    @if(!empty($selectedCategory))
                        {{ $selectedCategoryLabel ?? 'إعلانات مختارة' }}
                    @else
                        كل الإعلانات
                    @endif
                </h2>
            </div>
            <span class="ads__count">{{ $ads->total() ?? $ads->count() ?? 0 }} نتيجة</span>
        </header>
        <div class="ads__grid">
            @forelse (($ads ?? []) as $ad)
                <article class="ad-card">
                    <div class="ad-card__image">
                        <img src="{{ $ad->cover_url ?? $ad['cover_url'] ?? 'https://placehold.co/600x400?text=Ad' }}" alt="{{ $ad->title ?? $ad['title'] }}">
                        @if(($ad->is_featured ?? $ad['is_featured'] ?? false))
                            <span class="ad-card__badge">مميز</span>
                        @endif
                    </div>
                    <div class="ad-card__body">
                        <h3 class="ad-card__title">{{ $ad->title ?? $ad['title'] }}</h3>
                        <p class="ad-card__description">{{ $ad->summary ?? $ad['summary'] ?? 'وصف مختصر للإعلان يظهر هنا.' }}</p>
                        <dl class="ad-card__meta">
                            <div>
                                <dt>السعر</dt>
                                <dd>{{ $ad->price ?? $ad['price'] ?? 'حسب الطلب' }}</dd>
                            </div>
                            <div>
                                <dt>الموقع</dt>
                                <dd>{{ $ad->city ?? $ad['city'] ?? 'غير محدد' }}</dd>
                            </div>
                            <div>
                                <dt>الحالة</dt>
                                <dd>{{ $ad->status_label ?? $ad['status_label'] ?? 'متاح' }}</dd>
                            </div>
                        </dl>
                        <div class="ad-card__footer">
                            <span class="ad-card__date">{{ optional($ad->created_at ?? null)->diffForHumans() ?? ($ad['created_at_human'] ?? 'منذ لحظات') }}</span>
                            <a href="{{ route('ads.show', $ad->slug ?? $ad['slug'] ?? '#') }}" class="ad-card__action">عرض التفاصيل</a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="ads__empty">
                    <p>لا توجد إعلانات مطابقة لبحثك حالياً.</p>
                    <a href="{{ route('landing') }}" class="ads__reset">إعادة تعيين البحث</a>
                </div>
            @endforelse
        </div>

        @if(method_exists($ads ?? null, 'links'))
            <div class="ads__pagination">
                {{ $ads->withQueryString()->links() }}
            </div>
        @endif
    </section>

    <footer class="page__footer">
        <p>آخر تحديث للبيانات {{ now()->format('Y/m/d') }}</p>
        <div class="page__footer-links">
            <a href="/privacy">سياسة الخصوصية</a>
            <a href="/contact">تواصل معنا</a>
        </div>
    </footer>
</body>
</html>
