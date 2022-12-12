<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public $category;

    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->category->allCategorys();

        return CategoryResource::collection($categories);
    }

    public function getTotalCategory()
    {
        $categories = $this->category->allCategorys();

        return response()->json($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request)
    {
      
            $data = $request->all();

            $this->category->storeCategory($data);
    
             return response()->json([
                'message' => 'Category Saved Successfully !'
             ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
      return $this->category->getSingleCategory($category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        
      $data = $request->all();

     $category = $this->category->updateCategory($category, $data);

     return response()->json([
        'message' => 'Category Updated Successfully'
     ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category = $this->category->deleteCategory($category);

       // return new CategoryResource($category);

       return response()->json([
        "message" => 'Catgeory deleted successfully !',

    ]);
    
    }

    public function search($search)
    {
        $categories = Category::where('name', 'LIKE', '%' . $search . '%')->orderBy('id', 'desc')->get();
        if($categories) {
            return response()->json([
                'success' => true,
                'categories' => $categories
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Categories not found'
            ]);
        }
    }
}
