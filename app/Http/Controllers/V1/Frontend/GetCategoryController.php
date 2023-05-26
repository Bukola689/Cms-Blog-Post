<?php

namespace App\Http\Controllers\V1\Frontend;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GetCategoryController extends Controller
{
    public function allCategory()
    {
        $allCategories = Cache::remember('categories', 60, function () {
           return Category::orderBy('id', 'desc')->paginate(5);
        });

        return CategoryResource::collection($allCategories);
    }

    public function getTotalCategory()
    {
        $categories = Category::count();

        return response()->json($categories);
    }

    public function categoryById(Category $category)
    {   
        $categoryIdShow = Cache::remember('category:'. $category->id, 60, function () use ($category) {
            return $category;
        });

        return new CategoryResource($categoryIdShow);
    }

    public function searchCategory($search)
    {
        $categorys = Category::where('name', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();

        if($categorys)
        {
            return response()->json($categorys);
        }

        else {
            return response()->json(['category not found']);
        }
    }
}
