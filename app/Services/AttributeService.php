<?php


namespace App\Services;

use App\Models\AdsReviewOption;
use App\Models\Attribute as ModelsAttribute;
use App\Models\Category;
use App\Repository\ReviewRepository;
use App\Traits\Response;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Models\Currency;
use Attribute;

class AttributeService
{

    protected $reviewRepository;

    public function __construct(ReviewRepository $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    public function getStaticAttributes(Category $category , $withMainAttributes = true, $forUpdate = false){
        $attributes = $category->attributes()->where('list_type_id', 1)->distinct()->get();
        if($withMainAttributes){
            
            $virtualAttributes = [
                [
                    'id' => '-1',
                    'key' => ['en' => 'Title', 'ar' => 'عنوان الإعلان'],
                    'type' => 'text',
                    'list_type_id' => 1,
                    'required' => "1",
                ],
                [
                    'id' => '-2',
                    'key' => ['en' => 'Description', 'ar' => 'الوصف'],
                    'type' => 'textarea',
                    'list_type_id' => 1,
                    'required' => "1",
                ],
                [
                    'id'=>'-3',
                    'key'=> ['en' => 'Price', 'ar' => 'السعر'],
                    'type' =>'currency',
                    'list_type_id' => 1,
                    'required' => "1",
                    'currencies' => $this->getAvailableCurrencies(),
                ],
                [
                    'id'=>'-6',
                    'key'=> ['en' => 'City', 'ar' => 'المدينة'],
                    'type' =>'addressDropdown',
                    'list_type_id' => 1,
                    'required' => "0"
                ]
            ];

            if($forUpdate) {
                $forUpdateAttributes = [
                    [
                        'id'=>'-4',
                        'key' => ['en' => 'تم بيعه', 'ar' => 'Sold'],
                        'type' => 'boolean',
                        'list_type_id' => 1,
                        'required' => "0",
                    ],
                    [
                        'id'=>'-5',
                        'key' => ['en' => 'تم تأجيره', 'ar' => 'Rented'],
                        'type' => 'boolean',
                        'list_type_id' => 1,
                        'required' => "0",
                    ],
                    [
                        'id'=>'-9',
                        'key' => ['en' => 'العملة', 'ar' => 'Currency'],
                        'type' => 'boolean',
                        'list_type_id' => 1,
                        'required' => "1",
                    ]
                ];
                $virtualAttributes = array_merge($virtualAttributes, $forUpdateAttributes);
            }

            $virtualAttributeModels = collect($virtualAttributes)->map(function ($attr) {
                $attribute = new \App\Models\Attribute($attr);
                if (isset($attr['currencies'])) {
                    $attribute->currencies = $attr['currencies'];
                }
                return $attribute;
            });

            $attributes = $virtualAttributeModels->concat($attributes);
        }
        return $attributes;
    }

    public function getByIds($ids) {
        return ModelsAttribute::whereIn('id', $ids)->get();
    }

    /**
     * Get list of available currencies
     * @return array
     */
    private function getAvailableCurrencies()
    {
        return Currency::where('active', true)
            ->get()
            ->map(function ($currency) {
                return [
                    'id' => $currency->id,
                    'name' => $currency->name
                ];
            })
            ->toArray();
    }

    public function getFeaturedAttributes(Category $category){
        $attributes = $category->attributes()->where('list_type_id',2)->distinct()->get();
        return $attributes;
    }

    function saveReview($data)
    {

        $review = $this->reviewRepository->create([
            "ad_id" => $data['ad_id'],
            "user_id" => Auth::user()->id
        ]);

        if(isset($data['options']) && count($data['options']) > 0){
            $options = [];
            foreach ($data['options'] as $option) {
                $reviewOption = new AdsReviewOption();
                $reviewOption->review_id = $review->id;
                $reviewOption->option_id = $option;
                array_push($options, $reviewOption);
            }
            $review->options()->saveMany($options);
        }

        return ;
    }

}
