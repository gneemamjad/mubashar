<?php


namespace App\Services;

use App\Http\Resources\API\FiltersResource;
use App\Models\AdsReviewOption;
use App\Models\Voucher;
use App\Repository\AdRepository;
use App\Repository\AttributesRepository;
use App\Repository\FilterRepository;
use App\Repository\ReviewRepository;
use App\Traits\Response;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FilterService
{


    protected $filterRepository;

    public function __construct(FilterRepository $filterRepository)
    {
        $this->filterRepository = $filterRepository;
    }

    function getFilterByCategory($category, $request)
    {

        $lang = request()->header('lang', 'en');
        
        $options = $lang == 'ar' ? "خيارات البحث" : "Options";
        $info = $lang == 'ar' ? "معلومات الإعلان" : "Ad Information";
        $others = $lang == 'ar' ? "المزيد" : "Others";
        $outsideSyria = $request->get('outside_syria');
        if(!$outsideSyria) {
            $optionsFilters = [
                [
                    "key" => "nearby",
                    "title" => [
                        "ar" => "البحث بقربي",
                        "en" => "Search Near Me"
                    ],
                    "type" => "slider"
                ],
                [
                    "key" => "address",
                    "title" => [
                        "ar" => "العنوان",
                        "en" => "Address"
                    ],
                    "type" => "addressDropdown"
                ],
                [
                    "key" => "price",
                    "title" => [
                        "ar" => "السعر",
                        "en" => "Price"
                    ],
                    "type" => "range",
                    "currency" => "SYP"
                ]
            ];
        } else {
            $optionsFilters = [
                [
                    "key" => "nearby",
                    "title" => [
                        "ar" => "البحث بقربي",
                        "en" => "Search Near Me"
                    ],
                    "type" => "slider"
                ],
                [
                    "key" => "price",
                    "title" => [
                        "ar" => "السعر",
                        "en" => "Price"
                    ],
                    "type" => "range",
                    "currency" => "SYP"
                ]
            ];
        }

        $othersFilters = [
            [
                "key" => "keyword",
                "title" => [
                    "ar" => "رقم الاعلان او كلمة مفتاحية",
                    "en" => "Ad Number or Keyword"
                ],
                "type" => "text"
            ],
            [
                "key" => "ad_date",
                "title" => [
                    "ar" => "تاريخ الاعلان",
                    "en" => "Ad date"
                ],
                "type" => "radio",
                "options" => [
                    
                        [
                        "title" => [
                            "ar" => "اخر 24 ساعة",
                            "en" => "Last 24 hours"
                            ],
                        "value" => 1
                        ]
                        ,
                        [
                        "title" => [
                            "ar" => "اخر 3 ايام",
                            "en" => "Last 3 days"
                            ],
                        "value" => 3
                        ],
                        [
                        "title" => [
                            "ar" => "اخر 7 ايام",
                            "en" => "Last 7 days"
                            ],
                        "value" => 7
                        ],
                        [
                        "title" => [
                            "ar" => "اخر 15 يوم",
                            "en" => "Last 15 days"
                            ],
                        "value" => 15
                        ],
                        [
                        "title" => [
                            "ar" => "اخر 30 يوم",
                            "en" => "Last 30 days"
                            ],
                        "value" => 30
                        ]
                    
                ]
            ],
            [
                "key" => "vedio",
                "title" => [
                    "ar" => "اعلان مع فيديو",
                    "en" => "Ad with vedio"
                ],
                "type" => "checkbox"
            ],
            [
                "key" => "360image",
                "title" => [
                    "ar" => "اعلان مع صورة 360",
                    "en" => "Ad with 360 photo"
                ],
                "type" => "checkbox"
            ],
            [
                "key" => "map",
                "title" => [
                    "ar" => "اعلان مع موقع على الخريطة",
                    "en" => "Ad with map"
                ],
                "type" => "checkbox"
            ],
        ];

        $categories = $category->getAncestorsAndSelf();

        $adInfoFilters = [];

        $infoFilters = [];
        foreach($categories as $category){
            $categoryFilters = $this->filterRepository->getFilterByCategory($category);
            $adInfoFilters = array_merge($adInfoFilters, FiltersResource::collection($categoryFilters)->resolve());
        }

        if(count($adInfoFilters) > 0)
            $infoFilters = collect($adInfoFilters)->unique('key')->values();


        $formattedOptionsFilters = array_map(function($filter) use ($lang) {
            $filter['title'] = $filter['title'][$lang];
            return $filter;
        }, $optionsFilters);

        $formattedOthersFilters = array_map(function($filter) use ($lang) {
            $filter['title'] = $filter['title'][$lang];
            if(isset($filter['options'])){
                foreach($filter['options'] as &$option){
                    $option['title'] =  $option['title'][$lang];
                }
            }
          
            return $filter;
        }, $othersFilters);

        return [
           "filters" => [
            [ "title" => $options , "data" =>  $formattedOptionsFilters],
            [ "title" => $info , "data" => $infoFilters],
            [ "title" => $others , "data" =>$formattedOthersFilters]
           ],
           "sorts" => SORTS["$lang"]
        ];
    }

    /**
     * Apply filters to the query including trashed items if specified
     *
     * @param $query
     * @param array $filters
     * @param bool $withTrashed
     * @return mixed
     */
    public function apply($query, array $filters, $withTrashed = false)
    {
        if ($withTrashed) {
            $query->withTrashed();
        }

        // Apply other existing filters...
        
        return $query;
    }

    /**
     * Get only trashed ads
     *
     * @param $query
     * @return mixed
     */
    public function onlyTrashed($query)
    {
        return $query->onlyTrashed();
    }
}
