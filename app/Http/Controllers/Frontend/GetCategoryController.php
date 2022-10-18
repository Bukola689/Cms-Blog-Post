<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;

class GetCategoryController extends Controller
{
    public function allCategory()
    {
        $allCategories = Category::orderBy('id', 'desc')->paginate(5);

        return CategoryResource::collection($allCategories);
    }

    public function getTotalCategory()
    {
        $categories = Category::count();

        return response()->json($categories);
    }

    public function categoryById(Category $category)
    {
        return new CategoryResource($category);
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
