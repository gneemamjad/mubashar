<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class AdController extends Controller
{
    public function home(Request $request, ?string $category = null)
    {
        $ads = $this->fakeAds();

        if ($category) {
            $ads = $ads->where('slug', $category);
        }

        if ($keyword = $request->get('keyword')) {
            $ads = $ads->filter(fn ($ad) => str_contains($ad['title'], $keyword));
        }

        $paginated = $this->paginate($ads->values(), 9, $request->get('page', 1));

        return view('landing', [
            'categories' => $this->fakeCategories(),
            'selectedCategory' => $category,
            'selectedCategoryLabel' => $this->fakeCategories()->firstWhere('slug', $category)['name'] ?? null,
            'ads' => $paginated,
            'stats' => [
                'total' => $ads->count(),
                'featured' => $ads->where('is_featured', true)->count(),
                'new' => $ads->where('is_new', true)->count(),
            ],
        ]);
    }

    private function fakeAds(): Collection
    {
        return collect([
            [
                'title' => 'شقة واسعة للبيع في دمشق',
                'slug' => 'apartment-damascus',
                'summary' => 'ثلاث غرف وصالون مع شرفة مطلة على المدينة، تشطيب ممتاز.',
                'price' => '450,000,000 ل.س',
                'city' => 'دمشق',
                'status_label' => 'متاح',
                'is_featured' => true,
                'is_new' => true,
                'cover_url' => 'https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=800&q=80',
                'created_at_human' => 'منذ 3 ساعات',
            ],
            [
                'title' => 'سيارة تويوتا كورولا 2020',
                'slug' => 'toyota-corolla-2020',
                'summary' => 'بحالة ممتازة مع سجل صيانة موثق وكيل حصري.',
                'price' => '210,000,000 ل.س',
                'city' => 'حلب',
                'status_label' => 'متاح',
                'is_featured' => false,
                'is_new' => false,
                'cover_url' => 'https://images.unsplash.com/photo-1549921296-3ec93abae044?auto=format&fit=crop&w=800&q=80',
                'created_at_human' => 'منذ يوم',
            ],
            [
                'title' => 'حاسوب محمول للألعاب',
                'slug' => 'gaming-laptop',
                'summary' => 'معالج i7، بطاقة RTX 4060، تخزين SSD بسعة 1 تيرابايت.',
                'price' => '18,000,000 ل.س',
                'city' => 'اللاذقية',
                'status_label' => 'متاح',
                'is_featured' => true,
                'is_new' => true,
                'cover_url' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=800&q=80',
                'created_at_human' => 'منذ 5 ساعات',
            ],
        ]);
    }

    private function fakeCategories(): Collection
    {
        return collect([
            ['name' => 'عقارات', 'slug' => 'real-estate'],
            ['name' => 'سيارات', 'slug' => 'cars'],
            ['name' => 'إلكترونيات', 'slug' => 'electronics'],
            ['name' => 'وظائف', 'slug' => 'jobs'],
        ]);
    }

    private function paginate(Collection $items, int $perPage, int $page): LengthAwarePaginator
    {
        $offset = ($page - 1) * $perPage;
        return new Paginator(
            $items->slice($offset, $perPage)->values(),
            $items->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }
}
