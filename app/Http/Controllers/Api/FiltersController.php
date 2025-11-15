<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseCode;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\AttributeListsResource;
use App\Http\Resources\API\FiltersResource;
use App\Models\Category;
use App\Services\FilterService;
use Illuminate\Http\Request;

class FiltersController extends Controller
{

    protected $filterService;

    public function __construct(FilterService $filterService)
    {
        $this->filterService = $filterService;
    }

    function getFilterByCategory(Request $request){

        $request->validate([
            'category_id' => 'required|numeric'
        ]);

        $category = Category::find($request->category_id);

        if(!$category)
            return $this->errorResponse("Category not found",ResponseCode::NOT_FOUND);

        $filters = $this->filterService->getFilterByCategory($category, $request);

        return $this->successWithData("success",$filters);
    }
}
