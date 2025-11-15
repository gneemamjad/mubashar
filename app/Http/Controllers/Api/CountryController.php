<?php

namespace App\Http\Controllers\Api;

use App\Helpers\CountryCode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Get all countries
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $countries = CountryCode::all();
        return $this->successWithData('Countries retrieved successfully', $countries);
    }

    /**
     * Get country by code
     *
     * @param string $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByCode($code)
    {
        $country = CountryCode::getByCode($code);

        if (!$country) {
            return $this->errorResponse('Country not found', 404);
        }

        return $this->successWithData('Country retrieved successfully', $country);
    }

    /**
     * Get country by dial code
     *
     * @param string $dialCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByDialCode($dialCode)
    {
        $country = CountryCode::getByDialCode($dialCode);

        if (!$country) {
            return $this->errorResponse('Country not found', 404);
        }

        return $this->successWithData('Country retrieved successfully', $country);
    }
}
