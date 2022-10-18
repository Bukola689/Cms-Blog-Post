<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        return CategoryResource::collection($categories);
    }

    public function getTotalCategory()
    {
        $categories = Category::count();

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
    public function store(Request $request)
    {
        $data = Validator::make($request->all(),[
            'name' => 'required',
            'description' => 'required',
        ]);

        if($data->fails()) {
            return response()->json([
                'message'=> 'please check your credentials and try again'
            ]);
        }
    
             $categories = new Category;
             $categories->name = $request->input('name');
             $categories->save();
    
             return new CategoryResource($categories);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
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
    public function update(Request $request, Category $category)
    {

        $data = Validator::make($request->all(),[
            'name' => 'required',
            'description' => 'required',
        ]);

  
        if($data->fails()) {
            return response()->json([
                'message'=> 'please check your credentials and try again'
            ]);
        }
        
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->update();

        return new CategoryResource($category);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category = $category->delete();

       // return new CategoryResource($category);

       return response()->json([
        "message" => 'Catgeory deleted successfully !',
        'category' => $category
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
