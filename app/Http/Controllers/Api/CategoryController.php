<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseCode;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\ListCategoryResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{


    public function getMainCategories(){
        $categories = Category::roots()->get();
        return $this->successWithData("success",ListCategoryResource::collection($categories));
    }

    public function getSubCategories( $categoryId){
        $category = Category::find($categoryId);
        if(!$category){
            return $this->errorResponse("Category not found",ResponseCode::NOT_FOUND);
        }
        $categories = $category->children()->get();

        // return $this->successWithData("success",ListCategoryResource::collection($categories));

        // اعمل resource collection
        $resources = ListCategoryResource::collection($categories);

        // سورت حسب ad_count
        $sorted = $resources->sortByDesc(function ($item) {
            return $item->ad_count;
        })->values(); // values() حتى يرجع اندكس مرتب

        return $this->successWithData("success", $sorted);
    }
    // public function getSubCategories($categoryId) {
    //     $category = Category::find($categoryId);

    //     if (!$category) {
    //         return $this->errorResponse("Category not found", ResponseCode::NOT_FOUND);
    //     }

    //     $categories = $category->children()->get();

    //     if ($category->id == 16) {
    //         $categories->map(function ($child) {
    //             $child->view_layout = 'grid';
    //             return $child;
    //         });
    //     } else {
    //         $categories->map(function ($child) {
    //             $child->view_layout = 'list';
    //             return $child;
    //         });
    //     }

    //     return $this->successWithData("success", ListCategoryResource::collection($categories));
    // }



}
