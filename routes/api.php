<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\AdminContactController;
use App\Http\Controllers\Admin\AdminCommentController;
use App\Http\Controllers\Frontend\GetPostController;
use App\Http\Controllers\Frontend\GetCategoryController;
use App\Http\Controllers\Frontend\GetTagController;
use App\Http\Controllers\Frontend\CommentController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\rontend\ContactController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

  //.....Admin.....//

   Route::post('register', [AuthController::class, 'register']);
   Route::post('login', [AuthController::class, 'login']);

   Route::post('reset-password', [ResetPasswordController::class, 'resetPassword']); 

   Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword']);

  Route::group(['middleware' => 'auth:sanctum'], function () {
        
    Route::group(['middleware' => ['role:admin'], 'prefix' => 'admin'], function () {

        Route::get('/users', [UserController::class, 'index']);
        Route::get('/count-users', [UserController::class, 'getTotalUser']);
        Route::post('/users', [UserController::class, 'store']);
        Route::post('/users/{user}', [UserController::class, 'show']);
        Route::put('/users/{user}', [UserController::class, 'update']);
        Route::delete('/users/{user}', [UserController::class, 'destroy']);

        Route::post('logout', [AuthController::class, 'logout']);
        
        Route::post('/profiles', [ProfileController::class, 'updateProfile']);
       
        Route::post('/change-password', [ProfileController::class, 'changePassword'])->middleware('auth:sanctum');
  
    }); 

    Route::group(['middleware' => ['role:admin'], 'prefix' => 'admin'], function () {

        Route::get('/categories', [CategoryController::class, 'index']);
        Route::get('/count-categories', [CategoryController::class, 'getTotalCategory']);
        Route::post('/categories', [CategoryController::class, 'store']);
        Route::get('/categories/{category}', [CategoryController::class, 'show']);
        Route::put('/categories/{category}', [CategoryController::class, 'update']);
        Route::DELETE('/categories/{category}', [CategoryController::class, 'destroy']);
        Route::get('/categories/{search}', [PostController::class, 'searchCategory']);
  
    }); 

    Route::group(['middleware' => ['role:admin'], 'prefix' => 'admin'], function () {

        Route::get('/posts', [PostController::class, 'index']);
        Route::get('/count-posts', [PostController::class, 'getTotalPost']);
        Route::post('/posts', [PostController::class, 'store']);
        Route::get('/posts/{post}', [PostController::class, 'show']);
        Route::put('/posts/{post}', [PostController::class, 'update']);
        Route::DELETE('/posts/{post}', [PostController::class, 'destroy']);
        Route::get('/posts/{search}', [PostController::class, 'searchPost']);   
  
    }); 

    Route::group(['middleware' => ['role:admin'], 'prefix' => 'admin'], function () {
        
        Route::get('/tags', [TagController::class, 'index']);
        Route::get('/count-tags', [TagController::class, 'getTotalTag']);
        Route::post('/tags', [TagController::class, 'store']);
        Route::get('/tags/{tag}', [TagController::class, 'show']);
        Route::put('/tags/{tag}', [TagController::class, 'update']);
        Route::DELETE('/tags/{tag}', [TagController::class, 'destroy']);
        Route::get('/tags/{search}', [TagController::class, 'searchTag']);
  
    }); 

    Route::group(['middleware' => ['role:admin'], 'prefix' => 'admin'], function () {
        
        Route::get('/comments', [AdminCommentController::class, 'index']);
        Route::DELETE('/comments/{comment}', [AdminCommentController::class, 'destroy']);
  
    });
    
    Route::group(['middleware' => ['role:admin'], 'prefix' => 'admin'], function () {
        
        Route::get('/contacts', [AdminContactController::class, 'index']);
        Route::get('/count-contacts', [AdminContactController::class, 'getTotalContact']);
        Route::DELETE('/contacts/{contact}', [AdminContactController::class, 'destroy']);
  
    }); 

    Route::group(['middleware' => ['role:admin'], 'prefix' => 'admin'], function () {
        
        Route::get('/settings', [SettingsController::class, 'index']);
        Route::post('/settings', [SettingsController::class, 'store']);
        Route::get('/settings/{comment}', [SettingsController::class, 'show']);
        Route::put('/settings/{setting}', [SettingsController::class, 'update']);
        Route::DELETE('/settings/{setting}', [SettingsController::class, 'destroy']);
  
    }); 



  });

  // frontend ..//

    Route::get('/allposts', [GetPostController::class, 'allPost']);
    Route::get('/count-posts', [GetPostController::class, 'getTotalPost']);
    Route::get('/single-post/{post}', [GetPostController::class, 'postById']);
    Route::get('/allposts/{search}', [GetPostController::class, 'searchPost']);

    Route::get('/allcategories', [GetCategoryController::class, 'allCategory']);
    Route::get('/count-categories', [GetCategoryController::class, 'getTotalCategory']);
    Route::get('/single-category/{category}', [GetCategoryController::class, 'categoryById']);
    Route::get('/allcategories/{search}', [GetCategoryController::class, 'searchCategory']);

    Route::get('/alltags', [GetTagController::class, 'allTag']);
    Route::get('/count-tags', [GetTagController::class, 'getTotalTag']);
    Route::get('/single-tag/{tag}', [GetTagController::class, 'tagById']);
    Route::get('/alltags/{search}', [GetTagController::class, 'searchTag']);

    Route::get('/comments', [CommentController::class, 'getComment']);
    Route::get('/count-comments', [CommentController::class, 'getTotalComment']);
    Route::post('/comments', [CommentController::class, 'store']);

    Route::post('/contacts', [ContactController::class, 'store']);
