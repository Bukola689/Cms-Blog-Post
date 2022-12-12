<?php

namespace App\Repositories\Category;

use App\Models\Category;
interface ICategoryRepository
{
    public function allCategorys();

    public function storeCategory(array $data);

    public function getSingleCategory(Category $category);

    public function updateCategory(Category $category, array $data);

    public function deleteCategory(Category $category);
}