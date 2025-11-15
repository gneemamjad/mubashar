<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseCode;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\AdDetailsResource;
use App\Http\Resources\API\AdMediaResource;
use App\Http\Resources\API\AttributesResource;
use App\Http\Resources\API\AttributesWithSelectedResource;
use App\Http\Resources\API\BannerResource;
use App\Http\Resources\API\BannersResource;
use App\Http\Resources\API\DraftResource;
use App\Http\Resources\API\ListAdsResource;
use App\Http\Resources\API\PriceHistoryResource;
use App\Mail\ContactOwnerEmali;
use App\Models\Ad;
use App\Models\Area;
use App\Models\Banner;
use App\Models\Category;
use App\Models\City;
use App\Models\Currency;
use App\Models\Plan;
use App\Repository\AdRepository;
use App\Services\AdService;
use App\Services\AttributeService;
use App\Services\BannerService;
use App\Services\EpaymentService;
use App\Services\Messages\FirebaseV1Service;
use App\Services\Messages\SMSServices;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use PhpParser\Node\Stmt\Catch_;
use Illuminate\Http\Response;

use function PHPSTORM_META\type;
use function Ramsey\Uuid\v1;
use App\Services\PayPal\PayPalService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;


use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;



class AdController extends Controller
{

    protected $adRepository;
    protected $adService;
    protected $bannerService;
    protected $sMSServices;
    protected $firebaseServices;
    protected $attributeService;
    private $epaymentService;

    public function __construct(
            AdRepository $adRepository,
            AdService $adService,
            BannerService $bannerService,
            SMSServices $sMSServices,
            FirebaseV1Service $firebaseServices,
            AttributeService $attributeService,
            EpaymentService $epaymentService)
    {
        $this->adRepository = $adRepository;
        $this->adService = $adService;
        $this->bannerService = $bannerService;
        $this->sMSServices = $sMSServices;
        $this->firebaseServices = $firebaseServices;
        $this->attributeService = $attributeService;
        $this->epaymentService = $epaymentService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        try{
            $ads = $this->adService->getAds($request);
            $headerBanner = $this->bannerService->getHeaderBanner($request);
            $banners = $this->bannerService->getBanners($request);
            return $this->successWithDataPagination(
                "success",
                ListAdsResource::collection($ads),
                $ads,
                [
                    'headerBanner' => $headerBanner 
                        ? new BannerResource($headerBanner) 
                        : null,
                    'banners' => $banners && $banners->count() > 0 
                        ? BannersResource::collection($banners) 
                        : [],
                ]
            );
        }
        catch(Exception $e){
            Log::error('Error in get ads', ['error' => $e->getMessage()]);
            return $this->errorResponse("Server Error",ResponseCode::GENERAL_ERROR);
        }

    }

    public function getMyDraftAds(Request $request) {
        $ads = $this->adService->getMyDraftAds($request);
        return $this->successWithDataPagination("success",ListAdsResource::collection($ads),$ads);
    }

    public function getLastDraftAd(Request $request) {
        $ad = $this->adService->getLastDraftAd($request);
        if(!$ad)
            return $this->successWithData("ad not found",[]);
        $ad->photos = AdMediaResource::collection($ad->media->toArray());
        $area = Area::where('id', $ad->area_id)->first();
        $city = City::where('id', $ad->city_id)->first();
        if($city) {
            $ad->addressText = $city->city_name;     
        }
        if($area) {
            $ad->addressText = ' '.$area->area_name;    
        }
        $category = Category::find($ad->category_id);
        if (!$category) {
            return $this->notFoundResponse(__('categories.notFound'));
        }

        $staticAttributes = $this->attributeService->getStaticAttributes($category, true, true);
        $featureAttributes = $this->attributeService->getFeaturedAttributes($category);
        $selectedAttributes = $ad->adAttributes;

        $sAttributesWithSelected = $staticAttributes->map(function($attribute) use ($selectedAttributes, $ad) {
            if($attribute['id'] != -1 && $attribute['id'] != -2 && $attribute['id'] != -3 && $attribute['id'] != -9) {
                if(in_array($attribute['type'] ,[
                    "boolean",
                    "text",
                    "numeric",
                    "date",
                ])){
                    $attribute->selectedValue = $selectedAttributes->where('attribute_id', $attribute->id)->first()->value??null;
                } else if(in_array($attribute['type'] ,[
                    "addressDropdown"
                ])) {
                    $city = City::find($ad->city_id);
                    $area = Area::find($ad->area_id);

                    $cityName = $city ? $city->getTranslation('name', app()->getLocale()) : '';
                    $areaName = $area ? $area->getTranslation('name', app()->getLocale()) : '';

                    $attribute->selectedValue = $cityName . ', ' . $areaName;
                } else{
                    $attribute->selectedValue = $selectedAttributes->where('attribute_id', $attribute->id)->first()?->options?->pluck('ad_attribute_option_id') ?? null;
                }
            } else {
                if($attribute['id'] == -1) {
                    $attribute->selectedValue = $ad->title;
                } else if ($attribute['id'] == -2) {
                    $attribute->selectedValue = $ad->description;
                } else if ($attribute['id'] == -3) {
                    $attribute->selectedValue = $ad->price;
                } else if ($attribute['id'] == -9) {
                    $attribute->selectedValue = $ad->currency_id;
                }
            }
            return $attribute;
        });

        $fAttributesWithSelected = $featureAttributes->map(function($attribute) use ($selectedAttributes, $ad) {
            if(in_array($attribute['type'] ,[
                "boolean",
                "text",
                "numeric",
                "date",
            ])){
                $attribute->selectedValue = $selectedAttributes->where('attribute_id', $attribute->id)->first()->value??null;
            } else if(in_array($attribute['type'] ,[
                "addressDropdown"
            ])) {
                $city = City::find($ad->city_id);
                $area = Area::find($ad->area_id);

                $cityName = $city ? $city->getTranslation('name', app()->getLocale()) : '';
                $areaName = $area ? $area->getTranslation('name', app()->getLocale()) : '';

                $attribute->selectedValue = $cityName . ', ' . $areaName;
            } else{
                $attribute->selectedValue = $selectedAttributes->where('attribute_id', $attribute->id)->first()?->options?->pluck('ad_attribute_option_id') ?? null;
            }
            return $attribute;
        });
        $staticAttributesData = AttributesWithSelectedResource::collection($sAttributesWithSelected);
        $featureAttributesData = AttributesWithSelectedResource::collection($fAttributesWithSelected);
        $dataToReturn = [
            "ad" => $ad,
            "staticAttributesData" => $staticAttributesData,
            "featureAttributesData" => $featureAttributesData
        ];
        return $this->successWithData("success", $dataToReturn);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $request->validate([
            'ad_id' => 'nullable',
            'category' => 'required|numeric',
            'attributes' => 'required|array',
        ]);

        $category = $request->input('category');
        $category = Category::find($category);
        $attributes = $this->attributeService->getStaticAttributes($category);
        $this->adService->checkAdAttributesInRequest($request->input('attributes'),$attributes);

        // $ad=DB::transaction(function () use ($request,$attributes,$category) {
        //     $ad = $this->adService->createAd($request->input('attributes') , $category , $attributes);
        //     return $ad;
        // });

        $ad = DB::transaction(function () use ($request, $attributes, $category) {
            $adId = $request->input('ad_id');
            if ($adId) {
                $ad = $this->adService->createDraftAd($adId, $request->input('attributes'), $category, $attributes);
            } else {
                $ad = $this->adService->createAd($request->input('attributes'), $category, $attributes);
            }
            return $ad;
        });

        return $this->successWithData("success",[
            'ad'=>$ad
        ]);
    }

    public function getStaticAttributesWithSelected($adId,Request $request)
    {
        $request->validate([
            'type' => 'required|in:1,2',
        ]);


        $ad = $this->adRepository->findMyAd($adId);
        if (!$ad) {
            return $this->notFoundResponse(__('ads.notFound'));
        }

        $category = Category::find($ad->category_id);
        if (!$category) {
            return $this->notFoundResponse(__('categories.notFound'));
        }

        $attributes = $request->type == 1 ?
            $this->attributeService->getStaticAttributes($category, true, true) :
            $this->attributeService->getFeaturedAttributes($category);
        $selectedAttributes = $ad->adAttributes;

        $attributesWithSelected = $attributes->map(function($attribute) use ($selectedAttributes, $ad) {
            if(in_array($attribute['type'] ,[
                "boolean",
                "text",
                "numeric",
                "date",
            ])){
                $attribute->selectedValue = $selectedAttributes->where('attribute_id', $attribute->id)->first()->value??null;
            } else if(in_array($attribute['type'] ,[
                "addressDropdown"
            ])) {
                $city = City::find($ad->city_id);
                $area = Area::find($ad->area_id);

                $cityName = $city ? $city->getTranslation('name', app()->getLocale()) : '';
                $areaName = $area ? $area->getTranslation('name', app()->getLocale()) : '';

                $attribute->selectedValue = $cityName . ', ' . $areaName;
            } else{
                $attribute->selectedValue = $selectedAttributes->where('attribute_id', $attribute->id)->first()?->options?->pluck('ad_attribute_option_id') ?? null;
            }
            return $attribute;
        });

        return $this->successWithData("Attributes",AttributesWithSelectedResource::collection($attributesWithSelected));

        return $this->successWithData("success", [
            'attributes' => $attributesWithSelected
        ]);
    }
    function addFeaturedAttributes(Request $request){
        $request->validate([
            'attributes' => 'required|array',
            'ad_id' => 'required|numeric',
        ]);


        $ad = $this->adRepository->findMyAd($request->input('ad_id'));
        if(!$ad)
            return $this->notFoundResponse(__('ads.notFound'));

        $category = $ad->category;
        $attributes = $this->attributeService->getFeaturedAttributes($category);
        $this->adService->checkAdAttributesInRequest($request->input('attributes'),$attributes);

        DB::transaction(function () use ($request,$attributes,$ad) {
            $this->adService->addFeaturedAttributes($request->input('attributes'),$ad,$attributes);
        });
        
        $ad->status = Ad::STATUS['PENDING'];
        $ad->save();

        return $this->successWithoutData("success");
    }



    public function updateAttributes(Request $request)
    {
        $request->validate([
            'attributes' => 'required|array',
            'ad_id' => 'required|numeric',
            'type' => 'required|numeric|in:1,2' // 1 for static, 2 for featured
        ]);

        $ad = $this->adRepository->findMyAd($request->input('ad_id'));
        if(!$ad) {
            return $this->notFoundResponse(__('ads.notFound'));
        }

        $category = $ad->category;
        $attributes = $request->type == 1 ?
            $this->attributeService->getByIds(array_keys($request->input('attributes'))) :
            $this->attributeService->getFeaturedAttributes($category);

        $this->adService->checkAdAttributesInRequest($request->input('attributes'), $attributes,false,true);

        $this->adService->updateAd($ad, $request->input('attributes'));
        if($request->type == 1) {
            $attributeIds = array_keys($request->input('attributes'));
            DB::transaction(function () use ($request, $attributes, $ad,$attributeIds) {
                // Delete old attributes
                $ad->adAttributes()
                    ->whereIn('attribute_id', $attributeIds)
                    ->delete();
    
                // Add new attributes
                $this->adService->addStaticAttributes($request->input('attributes'), $ad, $attributes);
            });
        }
        if($request->type == 2) {
            // Get attribute IDs from request
            $attributeIds = array_keys($request->input('attributes'));
            DB::transaction(function () use ($request, $attributes, $ad,$attributeIds) {
                // Delete old attributes
                $ad->adAttributes()
                    ->whereIn('attribute_id', $attributeIds)
                    ->delete();
    
                // Add new attributes
                $this->adService->addFeaturedAttributes($request->input('attributes'), $ad, $attributes);
            });
        }

        return $this->successWithoutData("success");
    }

    public function updateBook($adId,Request $request)
    {
        $request->validate([
            'date' => 'nullable|array', // نخليها array لأنه ممكن يجي أكثر من تاريخ
        ]);

        $ad = $this->adRepository->findMyAd($adId);
        if (!$ad) {
            return $this->notFoundResponse(__('ads.notFound'));
        }

        $dates = $request->input('date', []);

        // نحذف التواريخ القديمة دائماً
        $ad->bookedDates()->delete();

        // إذا في تواريخ جديدة من الريكوست نضيفها
        if (!empty($dates)) {
            $newDates = collect($dates)->map(function ($date) {
                return ['date' => $date];
            });

            $ad->bookedDates()->createMany($newDates);
        }

        return $this->successWithData("success",$dates);
        // return $this->successWithoutData("success");
    }


    public function addAdLocation(Request $request){
        $request->validate([
            'ad_id'=>'required|numeric',
            'lat'=>'required|numeric',
            'lng'=>'required|numeric',
        ]);

        $ad = $this->adRepository->findMyAd($request->ad_id);
        if(!$ad)
            return $this->notFoundResponse(__('ads.notFound'));

        $ad->update([
            'lat'=>$request->lat,
            'lng'=>$request->lng,
        ]);

        return $this->successWithoutData("success");
    }

    
    public function addAdImagesFromAdmin(Request $request){
        $request->validate([
            'ad_id'=>'required|numeric',
            'media'=>'array',
            'image360'=>'nullable',
        ]);
        $ad = $this->adRepository->getAdById($request->ad_id);
        if(!$ad)
            return $this->notFoundResponse(__('ads.notFound'));
        $mainImageUpdated = false;
        if($request->file){

            $manager = new ImageManager(new Driver());
            $waterMarkManager = new ImageManager(new Driver());
            foreach ($request->file as $index => $media) {
                $extension = $media->getClientOriginalExtension();
                $mediaType = MEDIA_TYPES["image"];

                if (in_array($extension, ['mp4', 'MP4', 'Mov', 'mov', 'avi', 'MOV', 'AVI'])) {
                    $mediaType = MEDIA_TYPES["vedio"];
                }

                if ($mediaType == MEDIA_TYPES["image"]) {
                    $img = $manager->read($media->getRealPath());

                    $watermark = $waterMarkManager->read(public_path('watermark.png'));
                    $watermark->resize(600, 400);
                    $watermark->save(public_path('new-watermark.png'));
                    $img->place(
                        'new-watermark.png',
                        'center', 
                        0, 
                        0,
                        25
                    );

                    $imageName = uniqid() . '.' . $extension;
                    $img->save('storage/uploads/images/' . $imageName);

                    if (!$mainImageUpdated) {
                        $ad->update(['image' => $imageName]);
                        $mainImageUpdated = true;
                    }

                    $ad->media()->create([
                        'type' => $mediaType,
                        'name' => $imageName,
                    ]);
                } else {
                    $imageName = uploadMedia($media, $mediaType);
                    
                    if (!$mainImageUpdated) {
                        $ad->update(['image' => $imageName]);
                        $mainImageUpdated = true;
                    }

                    $ad->media()->create([
                        'type' => $mediaType,
                        'name' => $imageName,
                    ]);
                }
            }
            // foreach($request->file as $index => $media){
            //     $extension = $media->getClientOriginalExtension();
            //     $mediaType = MEDIA_TYPES["image"]; // Default to image

            //     if (in_array($extension, ['mp4', 'MP4', 'Mov', 'mov', 'avi'])) {
            //         $mediaType = MEDIA_TYPES["vedio"];
            //     }

            //     $imageName = uploadMedia($media, $mediaType);
            //     if (!$mainImageUpdated && $mediaType == MEDIA_TYPES['image']) {
            //         $ad->update(['image' => $imageName]);
            //         $mainImageUpdated=true;
            //     }
            //     $ad->media()->create([
            //         'type' => $mediaType,
            //         'name' => $imageName,
            //     ]);
            // }
        }

        if($request->has('image360')){
            $imageName = uploadMedia($request->image360, MEDIA_TYPES["360image"]);
            $ad->media()->create([
                'type' => MEDIA_TYPES["360image"],  
                'name' => $imageName,
            ]);
        }


        return $this->successWithoutData("success");
    }

    public function addAdImages(Request $request){
        $request->validate([
            'ad_id'=>'required|numeric',
            'media'=>'array',
            'image360'=>'nullable',
        ]);
        $ad = $this->adRepository->findMyAd($request->ad_id);
        if(!$ad)
            return $this->notFoundResponse(__('ads.notFound'));
        $mainImageUpdated = false;
        if($request->media) {

            if(true) {
                $manager = new ImageManager(new Driver());
                $waterMarkManager = new ImageManager(new Driver());
                foreach ($request->media as $index => $media) {
                    $extension = $media->getClientOriginalExtension();
                    $mediaType = MEDIA_TYPES["image"];

                    if (in_array($extension, ['mp4', 'MP4', 'Mov', 'mov', 'avi', 'MOV', 'AVI'])) {
                        $mediaType = MEDIA_TYPES["vedio"];
                    }

                    if ($mediaType == MEDIA_TYPES["image"]) {
                        $img = $manager->read($media->getRealPath());

                        $watermark = $waterMarkManager->read(public_path('watermark.png'));
                        $watermark->resize(600, 400);
                        $watermark->save(public_path('new-watermark.png'));
                        $img->place(
                            'new-watermark.png',
                            'center', 
                            0, 
                            0,
                            25
                        );

                        $imageName = uniqid() . '.' . $extension;
                        $img->save('storage/uploads/images/' . $imageName);

                        if (!$mainImageUpdated) {
                            $ad->update(['image' => $imageName]);
                            $mainImageUpdated = true;
                        }

                        $ad->media()->create([
                            'type' => $mediaType,
                            'name' => $imageName,
                        ]);
                    } else {
                        $imageName = uploadMedia($media, $mediaType);
                        
                        if (!$mainImageUpdated) {
                            $ad->update(['image' => $imageName]);
                            $mainImageUpdated = true;
                        }
                        
                        $ad->media()->create([
                            'type' => $mediaType,
                            'name' => $imageName,
                        ]);
                    }
                }
            } else {
                foreach($request->media as $index => $media){
                    $extension = $media->getClientOriginalExtension();
                    $mediaType = MEDIA_TYPES["image"]; // Default to image
        
                    if (in_array($extension, ['mp4', 'mov', 'avi'])) {
                        $mediaType = MEDIA_TYPES["vedio"];
                    }
                    $imageName = uploadMedia($media, $mediaType);
                    if (!$mainImageUpdated && $mediaType == MEDIA_TYPES['image']) {
                        $ad->update(['image' => $imageName]);
                        $mainImageUpdated=true;
                    }
                    $ad->media()->create([
                        'type' => $mediaType,
                        'name' => $imageName,
                    ]);
                }    
            }
            
        }
        if($request->file){
            foreach($request->file as $index => $media){
                $extension = $media->getClientOriginalExtension();
                $mediaType = MEDIA_TYPES["image"]; // Default to image

                if (in_array($extension, ['mp4', 'mov', 'avi'])) {
                    $mediaType = MEDIA_TYPES["vedio"];
                }

                $imageName = uploadMedia($media, $mediaType);
                if (!$mainImageUpdated && $mediaType == MEDIA_TYPES['image']) {
                    $ad->update(['image' => $imageName]);
                    $mainImageUpdated=true;
                }
                $ad->media()->create([
                    'type' => $mediaType,
                    'name' => $imageName,
                ]);
            }
        }

        if($request->has('image360')){
            $imageName = uploadMedia($request->image360, MEDIA_TYPES["360image"]);
            $ad->media()->create([
                'type' => MEDIA_TYPES["360image"],
                'name' => $imageName,
            ]);
        }


        return $this->successWithoutData("success");
    }

    public function updateAdImages(Request $request)
    {
        $request->validate([
            'ad_id'       => 'required|numeric',
            'media'       => 'array',
            'image360'    => 'nullable',
            'exist_media' => 'array'
        ]);

        $ad = $this->adRepository->findMyAd($request->ad_id);
        if (!$ad) {
            return $this->notFoundResponse(__('ads.notFound'));
        }

        $mainImageUpdated = false;

        if ($request->has('exist_media')) {
            $existMedia = $request->exist_media;

            $oldMedia = $ad->media()->pluck('id', 'name');
            foreach ($oldMedia as $fileName => $id) {
                if (!in_array($id, $existMedia)) {
                    $ad->media()->where('id', $id)->delete();

                    $filePath = storage_path('uploads/images/' . $fileName);
                    if (file_exists($filePath)) {
                        @unlink($filePath);
                    }
                }
            }
        } else {
            $oldMedia = $ad->media()->pluck('id', 'name');
            foreach ($oldMedia as $fileName => $id) {
                $ad->media()->where('id', $id)->delete();

                $filePath = storage_path('uploads/images/' . $fileName);
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
            }
        }
        if ($request->media) {
            $manager = new ImageManager(new Driver());
            $waterMarkManager = new ImageManager(new Driver());

            foreach ($request->media as $index => $media) {
                $extension = $media->getClientOriginalExtension();
                $mediaType = MEDIA_TYPES["image"];

                if (in_array(strtolower($extension), ['mp4', 'mov', 'avi'])) {
                    $mediaType = MEDIA_TYPES["vedio"];
                }

                if ($mediaType == MEDIA_TYPES["image"]) {
                    $img = $manager->read($media->getRealPath());

                    $watermark = $waterMarkManager->read(public_path('watermark.png'));
                    $watermark->resize(600, 400);
                    $watermark->save(public_path('new-watermark.png'));
                    $img->place('new-watermark.png', 'center', 0, 0, 25);

                    $imageName = uniqid() . '.' . $extension;
                    $img->save('storage/uploads/images/' . $imageName);

                    if (!$mainImageUpdated) {
                        $ad->update(['image' => $imageName]);
                        $mainImageUpdated = true;
                    }

                    $ad->media()->create([
                        'type' => $mediaType,
                        'name' => $imageName,
                    ]);
                } else {
                    $imageName = uploadMedia($media, $mediaType);

                    if (!$mainImageUpdated) {
                        $ad->update(['image' => $imageName]);
                        $mainImageUpdated = true;
                    }

                    $ad->media()->create([
                        'type' => $mediaType,
                        'name' => $imageName,
                    ]);
                }
            }
        }

        if ($request->file) {
            foreach ($request->file as $index => $media) {
                $extension = $media->getClientOriginalExtension();
                $mediaType = MEDIA_TYPES["image"];

                if (in_array(strtolower($extension), ['mp4', 'mov', 'avi'])) {
                    $mediaType = MEDIA_TYPES["vedio"];
                }

                $imageName = uploadMedia($media, $mediaType);
                if (!$mainImageUpdated && $mediaType == MEDIA_TYPES['image']) {
                    $ad->update(['image' => $imageName]);
                    $mainImageUpdated = true;
                }
                $ad->media()->create([
                    'type' => $mediaType,
                    'name' => $imageName,
                ]);
            }
        }

        if ($request->has('image360')) {
            $imageName = uploadMedia($request->image360, MEDIA_TYPES["360image"]);
            $ad->media()->create([
                'type' => MEDIA_TYPES["360image"],
                'name' => $imageName,
            ]);
        }

        return $this->successWithoutData("success");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        // try{
            $ad = $this->adService->getAd($id);

            if(!$ad)
                return $this->notFoundResponse("ad not found",ResponseCode::NOT_FOUND);
            
            $outsideSyria = $request->get('outside_syria');
            if(!$outsideSyria) {
                if($ad->active == 0)
                return $this->notAllowedResponse(__('ads.inActive'));
            } else {
                $ad->approved = 1;
            }
            
            $ad->increment('show_count');
            // Save user view if authenticated
            if (Auth::check()) {
                $ad->views()->attach(Auth::id(), [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            return $this->successWithData("success",new AdDetailsResource($ad));
        // }
        // catch(Exception $e){
        //     return $this->errorResponse("Server Error",ResponseCode::GENERAL_ERROR);
        // }

    }

    /**
     * Display the specified resource.
     */
    public function bulkAds(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
        ]);

        try{

            foreach($request->ids as $id){
                $ad = $this->adService->getAd($id);

                if(!$ad)
                    continue;

                if($ad->active == 0 || $ad->approved == 0)
                    continue;

                $ads[] = new AdDetailsResource($ad);
            }



            return $this->successWithData("success",$ads);
        }
        catch(Exception $e){
            return $this->errorResponse("Server Error",ResponseCode::GENERAL_ERROR);
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }



    public function destroy($ad_id)
    {
        try {

            $ad = $this->adRepository->getAdById($ad_id);

            if(!$ad)
                return $this->notFoundResponse(__('ads.notFound'));

            if (Auth::user()->id != $ad->user_id)
                return $this->notAllowedResponse(__('ads.notAllowed'));

            $ad->delete();
            return $this->successWithoutData(__('ads.deleted'));
        } catch (\Exception $e) {
            return $this->errorResponse("Server Error",ResponseCode::GENERAL_ERROR);
        }
    }


    function getPricingHistory($adId)
    {
        try{
            $history = $this->adService->getPricingHistory($adId);

            if(!$history)
                return $this->notAllowedResponse(__('ads.notFaviorate'));


            $data = $history['history'];
            $dateOfFollowing = $history['dateOfFollowing'];

            if(count($data) == 0){
                $data = [];
                $ad = $this->adRepository->getAdById($adId);
                $first_price = "";
                $current_price = $ad->price;
                return $this->successWithData("success",[
                    "first_price" =>  getExchangedPrice($current_price,1 ,getCurrency()->id),
                    "current_price" => getExchangedPrice($current_price,1 ,getCurrency()->id),
                    "following_date" => $dateOfFollowing,
                    "history" => [
                        [
                            'old_price' =>  getExchangedPrice($current_price,1 ,getCurrency()->id),
                            'new_price' =>  getExchangedPrice($current_price,1 ,getCurrency()->id),
                            'status' => "no_change",
                            'discount' => 0,
                            'created_at' => $dateOfFollowing,
                        ]
                    ]
                ]);
            }


            $first_price = $data->last()->old_price;
            $current_price = $data->first()->new_price;

            $data = PriceHistoryResource::collection($data);
            $ResponseDataToSend = [
                "first_price" => $first_price,
                "following_date" => $dateOfFollowing,
                "current_price" => $current_price,
                "history" => $data
            ];

            return $this->successWithData("success",$ResponseDataToSend);
        }
        catch(Exception $e){
            return $this->errorResponse("Server Error",ResponseCode::GENERAL_ERROR);
        }

    }

    function getFavoratesList(Request $request)
    {
        try{
            $list = $this->adService->getFavoritesList();
            if (empty($list)) {
                return $this->successWithData("success", new \stdClass());
            }
            return $this->successWithData("success", $list);
        }
        catch(Exception $e){
            return $this->errorResponse("Server Error",ResponseCode::GENERAL_ERROR);
        }
    }

    function getHomeFavoratesList(Request $request)
    {
        try{
            $request->validate([
                'limit' => 'numeric'
            ]);
            $limit = $request->input('limit');
            if($limit == null){
                $list = $this->adService->getFavoritesListPaginated();
                return $this->successWithDataPagination("success",ListAdsResource::collection($list),$list);
            }
            $list = $this->adService->getFavoritesListWithLimit($limit);
            return $this->successWithData("success",ListAdsResource::collection($list));
        }
        catch(Exception $e){
            if($e instanceof \Illuminate\Validation\ValidationException)
                throw $e;
            return $this->errorResponse("Server Error",ResponseCode::GENERAL_ERROR);
        }

    }

    function getNearByAds(Request $request)
    {
        try{
            $request->validate([
                'limit' => 'numeric',
                'lat' => 'required|numeric',
                'lng' => 'required|numeric',
            ]);
            $limit = $request->input('limit');
            $lat = $request->input('lat');
            $lng = $request->input('lng');
            if($limit == null){
                $list = $this->adService->getNearByAdsWithPagination($lat,$lng);
                return $this->successWithDataPagination("success",ListAdsResource::collection($list),$list);
            }

            $list = $this->adService->getNearByAds($lat,$lng,$limit);
            return $this->successWithData("success",ListAdsResource::collection($list));
        }
        catch(Exception $e){
            if($e instanceof \Illuminate\Validation\ValidationException)
                throw $e;
            return $this->errorResponse("Server Error",ResponseCode::GENERAL_ERROR);
        }

    }

    function getLastSeenAdsByMe(Request $request){
        try {
            $request->validate([
                'limit' => 'numeric'
            ]);

            $limit = $request->input('limit');
            if($limit == null){
                $lastSeenAds = $this->adService->getLastSeenAdsByMePaginated();
                return $this->successWithDataPagination("success",ListAdsResource::collection($lastSeenAds),$lastSeenAds);
            }
            $lastSeenAds = $this->adService->getLastSeenAdsByMe($limit);

            return $this->successWithData("success", ListAdsResource::collection($lastSeenAds));
        } catch (Exception $e) {
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                throw $e;
            }
            throw $e;
            return $this->errorResponse("Server Error", ResponseCode::GENERAL_ERROR);
        }
    }

    function getMostViewedAds(Request $request){
        try{
            $request->validate([
                'limit' => 'numeric'
            ]);

            $limit = $request->input('limit');

            if($limit == null){
                $mostViewedAds = $this->adService->getMostViewedAdsPaginated($request);
                return $this->successWithDataPagination("success",ListAdsResource::collection($mostViewedAds),$mostViewedAds);
            }

            $mostViewedAds = $this->adService->getMostViewedAds($limit, $request);

            return $this->successWithData("success",ListAdsResource::collection($mostViewedAds));
        }
        catch(Exception $e){
            Log::error('Error in get ads', ['error' => $e->getMessage()]);
            return $this->errorResponse("Server Error",ResponseCode::GENERAL_ERROR);
        }
    }

    function getSuggestedAds(Request $request){
        try{
            $request->validate([
                'limit' => 'numeric'
            ]);

            $limit = $request->input('limit');

            if($limit == null){
                $suggestedAds = $this->adService->getSuggestedAdsPaginated($request);
                return $this->successWithDataPagination("success",ListAdsResource::collection($suggestedAds),$suggestedAds);
            }

            $suggestedAds = $this->adService->getSuggestedAds($limit, $request);

            return $this->successWithData("success",ListAdsResource::collection($suggestedAds));
        }
        catch(Exception $e){
            Log::error('Error in get ads', ['error' => $e->getMessage()]);
            return $this->errorResponse("Server Error",ResponseCode::GENERAL_ERROR);
        }
    }

    function getPremiumAds(Request $request){
        try{
            $request->validate([
                'limit' => 'numeric'
            ]);

            $limit = $request->input('limit');

            if($limit == null){
                $premuimAds = $this->adService->getPremiumAdsPaginated($request);
                return $this->successWithDataPagination("success",ListAdsResource::collection($premuimAds),$premuimAds);
            }

            $premuimAds = $this->adService->getPremiumAds($limit, $request);

            return $this->successWithData("success",ListAdsResource::collection($premuimAds));
        }
        catch(Exception $e){
            Log::error('Error in get ads', ['error' => $e->getMessage()]);
            return $this->errorResponse("Server Error",ResponseCode::GENERAL_ERROR);
        }
    }

    function getShowcaseAds(Request $request){
        try{
            $request->validate([
                'limit' => 'numeric'
            ]);

            $limit = $request->input('limit');

            if($limit == null){
                $premuimAds = $this->adService->getShowcaseAdsPaginated($request);
                return $this->successWithDataPagination("success",ListAdsResource::collection($premuimAds),$premuimAds);
            }

            $premuimAds = $this->adService->getShowcaseAds($limit, $request);

            return $this->successWithData("success",ListAdsResource::collection($premuimAds));
        }
        catch(Exception $e){
            Log::error('Error in get ads', ['error' => $e->getMessage()]);
            return $this->errorResponse("Server Error",ResponseCode::GENERAL_ERROR);
        }
    }

    function addToFavorites(Request $request)
    {
        $request->validate([
            'ad_id' => 'required|numeric'
        ]);
        try{
            $ad = $this->adRepository->getAdById($request->ad_id);

            if(!$ad)
                return $this->notFoundResponse(__('ads.notFound'));

            if (Auth::user()->following->contains($request->ad_id))
                return $this->successWithoutData(__('ads.addedToFavAlready'));

            $this->adService->addToFaviorate($ad);

            return $this->successWithoutData(__('ads.addedToFav'));

        }
        catch(Exception $e){
            return $this->errorResponse("Server Error",ResponseCode::GENERAL_ERROR);
        }


    }

    function removeFromFavorites(Request $request)
    {
        $request->validate([
            'ad_id' => 'required|numeric'
        ]);

        try{
            $ad = $this->adRepository->getAdById($request->ad_id);

            if(!$ad)
                return $this->notFoundResponse(__('ads.notFound'));

            if (!Auth::user()->following->contains($request->ad_id)) {
                return $this->notAllowedResponse(__('ads.notFaviorate'));
            }

            $this->adService->removeFromFaviorate($ad);

            return $this->successWithoutData(__('ads.RemoveFromFav'));

        }
        catch(Exception $e){
            return $this->errorResponse("Server Error",ResponseCode::GENERAL_ERROR);
        }


    }

    function sendSms(Request $request)
    {
        $request->validate([
            "ad_id" => 'required|numeric',
        ]);

        try{
            $ad = $this->adRepository->getAdById($request->ad_id);

            if(!$ad)
                return $this->notFoundResponse(__('ads.notFound'));

            $owner = $ad->owner;
            $user = Auth::user();
            // if($owner->call == 1)
            //     return $this->notFoundResponse(__('ads.callAllowed'));

            if(Cache::has("sms-from-".Auth::user()->id."for-ad".$ad->id)){
                return $this->notAllowedResponse(__('ads.smsSendAlready'));
            }
            if($owner->mobile != '' && $owner->mobile != null)
                // $this->sMSServices->sendContactMessage($owner->mobile,$user->mobile,$ad->ad_number);

                $this->firebaseServices->sendByType(
                    $owner->fcm_token,
                    __('ads.callRequest'),
                    __('ads.callRequestMsg', ['mobile' => "00".$user->dial_code.$user->mobile]),
                    "2",
                    [
                        "userMobile" => "00".$user->dial_code.$user->mobile,
                        "adId" => $ad->id,
                        "userId" => $owner->id
                    ]
                );

            if($owner->email != '' && $owner->email != null){
                $msg = "يرغب الزبون صاحب الرقم " . "00".$user->dial_code.$user->mobile . " بالتواصل معك من اجل الاعلان رقم  " . $ad->ad_number;
                Mail::to($owner->email)->send(new ContactOwnerEmali($msg));
            }

            Cache::put("sms-from-".Auth::user()->id."for-ad".$ad->id,true, 60 * 60 * 12);
            return $this->successWithoutData("success");
        }
        catch(Exception $e){
            return $this->errorResponse("Server Error",ResponseCode::GENERAL_ERROR);
        }

    }

    function getStaticAttributes(Category $category){
        $attributes = $this->attributeService->getStaticAttributes($category);
        return $this->successWithData("Attributes",AttributesResource::collection($attributes));
    }

    function getFeaturedAttributes(Category $category){
        $attributes = $this->attributeService->getFeaturedAttributes($category);
        return $this->successWithData("Attributes",AttributesResource::collection($attributes));
    }





    function getMyAds(Request $request)
    {

        $request->validate([
            'type' => 'required|numeric|in:0,1,2'
        ]);

        $user = Auth::user();
        $ads = $this->adService->getAdsByUser($request,$user->id);
        return $this->successWithDataPagination("success",ListAdsResource::collection($ads),$ads);
    }

    /**
     * Select a plan for an ad
     *
     * @param Request $request
     * @param Ad $ad
     * @return \Illuminate\Http\JsonResponse
     */
    public function selectPlan(Request $request)
    {
        $request->validate([
            'plan_id' => 'required',
            'ad_id' => 'required',
            'bank_id' => 'nullable|numeric|in:1,2',
            'currency_id' => 'nullable|numeric|in:1,2',
        ]);

        $ad = $this->adRepository->getAdById($request->ad_id);

        // Check if the ad belongs to the authenticated user
        if ($ad->user_id != Auth::id()) {
            return $this->notAllowedResponse(__('ads.notAllowed'));
        }
        $plan = Plan::findOrFail($request->plan_id);

       // Deactivate any existing active plans for this ad
        DB::table('ad_plan')
        ->where('ad_id', $ad->id)
        ->where('is_active', true)
        ->update(['is_active' => false]);

        DB::table('ad')
        ->where('id', $ad->id)
        ->update(['paid' => true]);

        // Attach the new plan
        $ad->plans()->attach($plan->id, [
            'featured_until' => now()->addDays($plan->duration_days),
            'is_active' => true
        ]);

        //testing
        if($request->has('bank_id') && $plan->price!=0){
            $currency = getCurrency();
            if($request->has('currency_id')){
                $currency = Currency::where("id",$request->currency_id)->first();
            }

            return $this->successWithData("success",[
                'payment_url'=> $this->epaymentService->initPaymentUrl($request->bank_id,$ad,$plan,$currency)
            ]);
        }

        return $this->successWithoutData(__('ads.planSelected'));
    }

    public function updateAdPersonalInfo(Request $request)
    {
        $validated = $request->validate([
            'show_as' => 'required|numeric|in:1,2',
            'recive_calls' => 'required|boolean',
            'ad_id' => 'required|numeric',
        ]);

        $ad = $this->adRepository->findMyAd($validated['ad_id']);
        $ad->update($validated);

        return response()->json([
            'message' => 'Personal information updated successfully',
            'data' => [
                'receive_calls' => $ad->recive_calls,
                'show_as' => $ad->show_as,
            ]
        ]);
    }

    /**
     * Test SMS sending functionality
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function testSendSms(Request $request)
    {
        // $validated = $request->validate([
        //     'phone_number' => 'required|string',
        //     'message' => 'required|string'
        // ]);

        try {
            // Assuming you have an SMS service implementation
            // You may need to inject it through constructor or use facade
            $this->sMSServices->sendOtpMessage('980166049',123456);


            $result = $this->sMSServices->sendContactMessage(
               '980166049',
                123,
                456
            );

            return $this->successWithData('SMS sent successfully', [
                'status' => $result,
                // 'to' => $validated['phone_number']
            ]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }




}
