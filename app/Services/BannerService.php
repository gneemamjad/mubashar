<?php


namespace App\Services;

use App\Repository\BannerRepository;

class BannerService
{

    protected $bannerRepository;

    public function __construct(BannerRepository $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }

    public function getHeaderBanner($request) {
        // dd($request->category_id);
        if ($request->has('category_id')) {
            return $this->bannerRepository->getHeaderBanner($request);
        }
    }

    public function getBanners($request) {
        if ($request->has('category_id')) {
            return $this->bannerRepository->getBanners($request);
        }
    }

}
