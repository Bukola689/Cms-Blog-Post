<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Http\Resources\CategoryResource;

class CategoryRepository implements ICategoryRepository
{
    public function allCategorys()
    {
        $categories = Category::orderBy('id', 'desc')->get();

        return CategoryResource::collection($categories);
    }

    public function storeCategory(array $data)
    {
        Category::insert([
            'name' => $data['name'],
        ]);

    }

    public function getSingleCategory(Category $category)
    {
        return $category;
    }

    public function updateCategory(Category $category, array $data)
    {
        $category->update([
            'name' => $data['name'],
        ]);
    }

    public function deleteCategory(Category $category)
    {
        $category = $category->delete();

        return response()->json([
            'message' => 'Category deleted Successfully !'
        ]);
    }
}