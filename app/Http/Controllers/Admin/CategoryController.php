<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\AttributeViewListType;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $title = __('admin.sidebar.categories');
        $page = __('admin.sidebar.categories_management');
        return view('admin.categories.index',compact(['title','page']));
    }

    public function searchAjax(Request $request) {

        $query = $request->get('q');

        $categories = Category::with('parent')
                ->where('name', 'like', '%' . $query . '%')
                ->get()
                ->map(function ($category) {
                    return [
                        'id'   => $category->id,
                        'name' => ($category->parent ? $category->parent->name : 'No Parent') . ' - ' . $category->name,
                    ];
                });

        return response()->json($categories);
    }

    public function getTreeNodes(Request $request)
    {
        $parentId = $request->input('parent', '#');
        $locale = app()->getLocale(); // Get current locale

        if ($parentId === '#') {
            $categories = Category::whereNull('parent_id')->get();
        } else {
            $categories = Category::where('parent_id', $parentId)->get();
        }

        $nodes = [];
        foreach ($categories as $category) {
            $hasChildren = Category::where('parent_id', $category->id)->exists();

            // Get both translations for the node text
            $text = $category->getTranslation('name', $locale);
            $translations = [
                'en' => $category->getTranslation('name', 'en'),
                'ar' => $category->getTranslation('name', 'ar')
            ];

            $nodes[] = [
                'id' => $category->id,
                'text' => $text, // Show current locale's translation
                'icon' => $hasChildren ? 'fa fa-folder text-warning' : 'fa fa-list-alt text-primary',
                'children' => $hasChildren,
                'state' => [
                    'opened' => false,
                    'selected' => false
                ],
                'translations' => $translations // Store translations in node data
            ];
        }

        return response()->json($nodes);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.show', compact('category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:category,id'
        ]);

        $category = new Category();
        $category->setTranslation('name', 'en', $request->name_en);
        $category->setTranslation('name', 'ar', $request->name_ar);
        $category->parent_id = $request->parent_id;
        $category->save();

        return response()->json(['success' => true, 'category' => $category]);
    }

    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:category,id'
        ]);

        $category = Category::findOrFail($id);
        $category->setTranslation('name', 'en', $request->name_en);
        $category->setTranslation('name', 'ar', $request->name_ar);
        $category->parent_id = $request->parent_id;
        $category->save();

        return response()->json(['success' => true, 'category' => $category]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:category,id'
        ]);

        $category = Category::findOrFail($id);
        $category->setTranslation('name', 'en', $request->name_en);
        $category->setTranslation('name', 'ar', $request->name_ar);
        $category->parent_id = $request->parent_id;
        $category->save();

        return response()->json(['success' => true, 'category' => $category]);
    }

    public function moveCategory(Request $request, $id)
    {
        $request->validate([
            'parent_id' => 'required|exists:category,id'
        ]);

        $category = Category::findOrFail($id);
        $category->parent_id = $request->parent_id;
        $category->save();

        return response()->json(['success' => true, 'category' => $category]);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(['success' => true]);
    }

    public function tree(Request $request)
    {
        $parentId = $request->get('parent', '#');

        if ($parentId === '#') {
            $categories = Category::whereNull('parent_id')->get();
        } else {
            $categories = Category::where('parent_id', $parentId)->get();
        }

        $nodes = [];
        foreach ($categories as $category) {
            $node = [
                'id' => $category->id,
                'text' => $category->name,
                'translations' => [
                    'en' => $category->name_en,
                    'ar' => $category->name_ar
                ],
                'children' => true,
                'type' => 'category'
            ];



            $nodes[] = $node;
        }

        if($parentId==='#')
            return response()->json($nodes);

        $category = Category::findOrFail($parentId);

        if ($category->attributes()->exists()) {
            $attributeTypes = AttributeViewListType::all();

            foreach ($attributeTypes as $type) {
                $attributes = $category->attributes()->where('list_type_id', $type->id)->get();
                if($category->id == 4)
                {
                    // dd($attributes);
                }
                if ($attributes->isNotEmpty()) {
                    $typeNode = [
                        'id' => "type_{$category->id}_{$type->id}",
                        'text' => $type->name,
                        'type' => 'attribute_folder',
                        'children' => [],
                        'state' => ['opened' => false]
                    ];

                    foreach ($attributes as $attribute) {
                        $typeNode['children'][] = [
                            'id' => "attr_{$attribute->id}",
                            'text' => $attribute->key . ($attribute->pivot->enable_filter ? ' 🔍' : ''),
                            'type' => 'attribute',
                            'icon' => 'fa fa-tag',
                            'enable_filter' => $attribute->pivot->enable_filter
                        ];
                    }

                    $node['children'] = true;
                    $nodes[] = $typeNode;
                }
            }
        }

        return response()->json($nodes);
    }

    public function catTree(Request $request)
    {
        $parentId = $request->get('parent', '#');

        if ($parentId === '#') {
            $categories = Category::whereNull('parent_id')->get();
        } else {
            $categories = Category::where('parent_id', $parentId)->get();
        }

        $nodes = [];
        foreach ($categories as $category) {
            $node = [
                'id' => $category->id,
                'text' => $category->name,
                'translations' => [
                    'en' => $category->name_en,
                    'ar' => $category->name_ar
                ],
                'children' => true,
                'type' => 'category'
            ];



            $nodes[] = $node;
        }

        if($parentId==='#')
            return response()->json($nodes);

        $category = Category::findOrFail($parentId);

        return response()->json($nodes);
    }

    public function searchCatTree(Request $request)
    {
        $query = $request->get('q');

        // جلب جميع الفئات التي تطابق كلمة البحث في الاسم العربي أو الإنجليزي
        $categories = Category::where('name', 'like', "%{$query}%")
                        ->get();

        $results = [];

        foreach ($categories as $category) {
            // جلب كل الأبوية للعقدة
            $parents = $category->getAncestors()->pluck('id')->toArray(); 
            // getAncestors() تحتاج أن تستعمل حزمة مثل Baum أو Laravel Nested Set

            $results[] = [
                'id' => $category->id,
                'parents' => $parents,
            ];
        }

        return response()->json($results);
    }

    public function getAttributes( $category)
    {
        $category = Category::findOrFail($category);

        $attributes = $category->attributes()->with('typeList')->get();

        $response = $attributes->map(function($attribute) {
            return [
                'id' => $attribute->id,
                'key' => $attribute->key,
                'list_type_name' => $attribute->typeList->name
            ];
        });
        // dd($category->attributes);
        return response()->json($response);
    }

    public function updateAttributes(Request $request, $category)
    {
        // dd($request->all());
        $request->validate([
            'attributes' => 'required|array',
            'attributes.*' => 'exists:attributes,id',
            // 'enable_filter' => 'boolean'
        ]);

        $attributes = $request->input('attributes');
        // dd($request->input('attributes'));

        $category = Category::findOrFail($category);
        $category->attributes()->attach([
            $attributes[0] => [
                'category_id' => $category->id,
                'filter_enabled' => $request->enable_filter ?? false
            ]
        ]);

        return response()->json(['success' => true]);
    }

    public function removeAttribute($category, $attribute)
    {
        $category = Category::findOrFail($category);
        $category->attributes()->detach($attribute);
        return response()->json(['success' => true]);
    }

    public function toggleAttributeFilter( $category,  $attribute)
    {
        $category = Category::findOrFail($category);
        $currentFilter = $category->attributes()
            ->wherePivot('attribute_id', $attribute)
            ->first()
            ->pivot
            ->filter_enabled;

        $category->attributes()->updateExistingPivot($attribute, [
            'filter_enabled' => !$currentFilter
        ]);

        return response()->json(['success' => true]);
    }

    public function clone($id)
    {
        $original = Category::findOrFail($id);

        $clone = $original->replicate();
        $clone->name = $original->name . ' (Copy)';
        $clone->save();

        // Translations
        if (method_exists($original, 'getTranslations')) {
            $translations = $original->getTranslations('name');
            foreach ($translations as $locale => $value) {
                $clone->setTranslation('name', $locale, $value . ' (Copy)');
            }
            $clone->save();
        }
        $categoryId = $clone->id;
        // Clone attributes with pivot
        foreach ($original->attributes as $attribute) {
            $clone->attributes()->attach([
                $attribute->id => [
                    'category_id' => $categoryId,
                    'filter_enabled' => $attribute->filter_enabled ?? false
                ]
            ]);
        }

        return response()->json(['message' => 'Category cloned successfully']);
    }
}
