<?php

use Illuminate\Http\Request;
use App\Http\Controllers\V1\Auth\AuthController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\V1\Admin\UserController;
use App\Http\Controllers\V1\Auth\ProfileController;
use App\Http\Controllers\V1\Auth\VerifyEmailController;
//use App\Http\Controllers\V1\Admin\PostController;
use App\Http\Controllers\V1\Admin\AdminContactController;
use App\Http\Controllers\V1\Admin\AdminCommentController;
use App\Http\Controllers\V1\Frontend\GetPostController;
use App\Http\Controllers\V1\Frontend\GetCategoryController;
use App\Http\Controllers\V1\Frontend\GetTagController;
use App\Http\Controllers\V1\Frontend\CommentController;
//use App\Http\Controllers\Admin\CategoryController;
//use App\Http\Controllers\V1\Admin\TagController;
use App\Http\Controllers\V1\Auth\ForgotPasswordController;
use App\Http\Controllers\V1\Frontend\ContactController;
use App\Http\Controllers\V1\Admin\SettingsController;
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

 //require __DIR__ ."/api/posts.php";

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

         //....auth....//
        Route::group(['prefix'=> 'auth'], function() {
            Route::post('register', [RegisterController::class, 'register']);
            Route::post('login', [LoginController::class, 'login']);
            Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
         Route::group(['middleware' => 'auth:sanctum'], function() {
            Route::post('logout', [LogoutController::class, 'logout']);
            Route::post('/email/verification-notification', [VerifyEmailController::class, 'resendNotification'])->name('verification.send');
            Route::post('reset-password', [ResetPasswordController::class, 'resetPassword']); 
 
         });
     });




     Route::group(['middleware' => 'me', 'middleware' => 'auth:sanctum'], function() {
 
      Route::post('/profiles', [ProfileController::class, 'updateProfile']);
      Route::post('/change-password', [ProfileController::class, 'changePassword']);
     });


     Route::group(['middleware' => ['auth:sanctum']], function() {
      Route::group(['middleware' => ['role:super-admin'], 'prefix' => 'admin'], function() {
      Route::get('users', [AdminUserController::class, 'index']);
      Route::post('users', [AdminUserController::class, 'store']);
      Route::get('users/{id}', [AdminUserController::class, 'show']);
      Route::put('users/{id}', [AdminUserController::class, 'update']);
      Route::delete('users/{id}', [AdminUserController::class, 'destroy']);
      Route::post('users/{id}/suspend', [AdminUserController::class, 'suspend']);
      Route::post('users/{id}/active', [AdminUserController::class, 'active']);
      Route::get('users/{id}/roles', [AdminRoleController::class, 'show']);
      Route::get('users/{id}/permissions', [AdminPermissionController::class, 'show']);
      Route::post('users/{id}/roles', [AdminRoleController::class, 'changeRole']);
    
      });

    });

   
    //    //...userController..//

    //    require __DIR__ ."/api/v1/admin/users.php";

    //    //...postcontroller..//

    //     require __DIR__ ."/api/v1/admin/posts.php";

    //     //..categorycontrollers..//

    //     require __DIR__ ."/api/v1/admin/categorys.php";
        
    //     //..tagscontroller..//

    //     require __DIR__ ."/api/v1/admin/tags.php";


    Route::group(['middleware' => ['role:admin'], 'prefix' => 'admin'], function () {
        
        Route::get('/comments', [AdminCommentController::class, 'index']);
        Route::DELETE('/comments/{comment}', [AdminCommentController::class, 'destroy']);
  
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

