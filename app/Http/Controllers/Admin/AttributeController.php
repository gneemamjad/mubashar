<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeViewListType;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AttributeController extends Controller
{
    public function index()
    {
        $title = __('admin.sidebar.attributes');
        $page = __('admin.sidebar.categories_management');

        return view('admin.attributes.index', compact(['title', 'page']));
    }

    public function create()
    {
        $title = __('admin.sidebar.attributes');
        $page = __('admin.sidebar.categories_management');
        $types = AttributeViewListType::all();
        return view('admin.attributes.create', compact('types','title', 'page'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'key.en' => 'required|string|max:255',
            'key.ar' => 'required|string|max:255',
            'list_type_id' => 'required|exists:attribute_view_list_type,id',
            'type' => 'required|in:text,numeric,boolean,date,radio,multiselect,dropdown',
            'options' => 'required_if:type,radio,multiselect,dropdown'
        ]);

        $attribute = new Attribute();

        $attribute = new Attribute();
        $attribute->setTranslation('key', 'en', $validated['key']['en']);
        $attribute->setTranslation('key', 'ar', $validated['key']['ar']);
        $attribute->list_type_id = $validated['list_type_id'];
        $attribute->type = $validated['type'];
        $attribute->save();
        // $attribute->setTranslation('key', 'en', $validated['key']['en']);
        // $attribute->setTranslation('key', 'ar', $validated['key']['ar']);
        // $attribute->list_type_id = $validated['list_type_id'];
        // $attribute->type = $validated['type'];
        // $attribute->currencies =null;
        // $attribute->save();

        if (in_array($attribute->type, ['dropdown', 'multiselect','radio']) && !empty($validated['options'])) {
            $options = json_decode($validated['options'], true);
            foreach ($options as $option) {
                $attributeOption = $attribute->attributeOptions()->create();
                $attributeOption->setTranslation('value', 'en', $option['en']);
                $attributeOption->setTranslation('value', 'ar', $option['ar']);
                $attributeOption->save();
            }
        }

        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        $attribute = Attribute::findOrFail($id);
        $types = AttributeViewListType::all();
        $attribute->load('attributeOptions');
        $title = __('admin.sidebar.attributes');
        $page = __('admin.sidebar.categories_management');
        return view('admin.attributes.edit', compact('attribute', 'types','title','page'));
    }

    // public function update(Request $request, $id)
    // {
    //     $attribute = Attribute::findOrFail($id);

    //     $validated = $request->validate([
    //         'key.en' => 'required|string|max:255',
    //         'key.ar' => 'required|string|max:255',
    //         'list_type_id' => 'required|exists:attribute_view_list_type,id',
    //         'type' => 'required|in:text,numeric,boolean,date,radio,multiselect,dropdown',
    //         'options' => 'required_if:type,radio,multiselect,dropdown'
    //     ]);

    //     $attribute->setTranslation('key', 'en', $validated['key']['en']);
    //     $attribute->setTranslation('key', 'ar', $validated['key']['ar']);
    //     $attribute->list_type_id = $validated['list_type_id'];
    //     $attribute->type = $validated['type'];
    //     $attribute->save();

    //     if (in_array($attribute->type, ['radio', 'multiselect', 'dropdown']) && !empty($validated['options'])) {
    //         // Delete existing options
    //         $attribute->attributeOptions()->delete();

    //         // Add new options
    //         $options = json_decode($validated['options'], true);
    //         foreach ($options as $option) {
    //             $attributeOption = $attribute->attributeOptions()->create();
    //             $attributeOption->setTranslation('key', 'en', $option['en']);
    //             $attributeOption->setTranslation('key', 'ar', $option['ar']);
    //             $attributeOption->save();
    //         }
    //     }

    //     return response()->json(['success' => true]);
    // }
    public function update(Request $request, $id)
    {
        $attribute = Attribute::findOrFail($id);

        $validated = $request->validate([
            'key.en' => 'required|string|max:255',
            'key.ar' => 'required|string|max:255',
            'list_type_id' => 'required|exists:attribute_view_list_type,id',
            'type' => 'required|in:text,numeric,boolean,date,radio,multiselect,dropdown',
            'options' => 'nullable|required_if:type,radio,multiselect,dropdown'
        ]);

        // ✅ تحديث الحقول الرئيسية
        $attribute->setTranslation('key', 'en', $validated['key']['en']);
        $attribute->setTranslation('key', 'ar', $validated['key']['ar']);
        $attribute->list_type_id = $validated['list_type_id'];
        $attribute->type = $validated['type'];
        $attribute->save();

        // ✅ التعامل مع الخيارات فقط إذا كانت من النوع المناسب
        if (in_array($attribute->type, ['radio', 'multiselect', 'dropdown'])) {

            $options = json_decode($validated['options'] ?? '[]', true);

            // 🔹 IDs المرسلة من الواجهة (الخيارات الموجودة فقط)
            $incomingIds = collect($options)
                ->pluck('id')
                ->filter(fn($id) => !empty($id))
                ->toArray();

            // 🔹 حذف الخيارات التي لم تعد موجودة بالواجهة
            if (!empty($incomingIds)) {
                $attribute->attributeOptions()
                    ->whereNotIn('id', $incomingIds)
                    ->delete();
            } else {
                // لا نحذف شيء إن لم يُرسل أي id (لمنع حذف الكل بالغلط)
            }

            // 🔹 تحديث أو إنشاء الخيارات
            foreach ($options as $option) {
                $en = trim($option['en'] ?? '');
                $ar = trim($option['ar'] ?? '');

                // نتجاهل أي خيار فارغ تماماً
                if ($en === '' && $ar === '') {
                    continue;
                }

                if (!empty($option['id'])) {
                    // 🟢 تحديث الموجود
                    $attributeOption = $attribute->attributeOptions()->find($option['id']);
                    if ($attributeOption) {
                        $attributeOption->setTranslation('key', 'en', $en);
                        $attributeOption->setTranslation('key', 'ar', $ar);
                        $attributeOption->save();
                    }
                } else {
                    // 🟢 إنشاء جديد بشكل صريح (بدون تكرار)
                    $attribute->attributeOptions()->create([
                        'key' => [
                            'en' => $en,
                            'ar' => $ar,
                        ]
                    ]);
                }
            }
        }

        return response()->json(['success' => true]);
    }




    public function destroy( $attribute)
    {
        $attribute = Attribute::findOrFail($attribute);
        $attribute->delete();
        return response()->json(['success' => true]);
    }

    public function data()
    {



        $attributes = Attribute::with('typeList');
        // return DataTables::eloquent($attributes)->toJson();
        return datatables()
            ->eloquent($attributes)
            ->addIndexColumn()
            ->addColumn('type_name', function ($attribute) {
                return $attribute->typeList ? $attribute->typeList->name : '';
            })
            ->addColumn('actions', function ($attribute) {
                return view('admin.attributes.actions', compact('attribute'))->render();
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function available( $category)
    {
        $category = Category::find($category);
        $existingAttributeIds = $category->attributes()->pluck('attributes.id');

        // dd($category->attributes);
        return response()->json(
            Attribute::with('typeList')
                ->whereNotIn('attributes.id', $existingAttributeIds)
                ->get()
                ->map(function($attribute) {
                    return [
                        'id' => $attribute->id,
                        'key' => $attribute->key,
                        'list_type_id' => $attribute->list_type_id,
                        'list_type_name' => $attribute->typeList->name
                    ];
                })
        );
    }

}
