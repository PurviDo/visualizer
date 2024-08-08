<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;

class CategoryController extends Controller
{
    use ApiResponseTrait;

    public function getCategories() {
        $categories = Category::where('is_deleted', 0)->get();
        if ($categories) {
            return $this->sendResponse('Category data get successfully.', 1, array($categories), $this->successStatus);
        }
    }

    public function getSubCategories() {
        $subCategories = Category::where('is_deleted', 0)->where('parent_id', null)->get();;
        if ($subCategories) {
            return $this->sendResponse('Sub Category data get successfully.', 1, array($subCategories), $this->successStatus);
        }
    }

}
