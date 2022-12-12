<?php

use Illuminate\Http\Request;
use App\Http\Controllers\V1\Auth\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\V1\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;
//use App\Http\Controllers\V1\Admin\PostController;
use App\Http\Controllers\V1\Admin\AdminContactController;
use App\Http\Controllers\V1\Admin\AdminCommentController;
use App\Http\Controllers\V1\Frontend\GetPostController;
use App\Http\Controllers\V1\Frontend\GetCategoryController;
use App\Http\Controllers\V1\Frontend\GetTagController;
use App\Http\Controllers\V1\Frontend\CommentController;
//use App\Http\Controllers\Admin\CategoryController;
//use App\Http\Controllers\V1\Admin\TagController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\V1\Frontend\ContactController;
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

  //.....Admin.....//


 

   Route::post('register', [AuthController::class, 'register']);
   Route::post('login', [AuthController::class, 'login']);

   Route::post('reset-password', [ResetPasswordController::class, 'resetPassword']); 

   Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword']);

   Route::post('/email/verification-notification', [VerifYEmailController::class, 'resendNotification'])->name('verification.send');

   Route::prefix('v1')->group(function() {

  Route::group(['middleware' => 'auth:sanctum'], function () {
        
    Route::group(['middleware' => ['role:admin'], 'prefix' => 'admin'], function () {

      
        Route::post('logout', [AuthController::class, 'logout']);
        
        Route::post('/profiles', [ProfileController::class, 'updateProfile']);
       
        Route::post('/change-password', [ProfileController::class, 'changePassword'])->middleware('auth:sanctum');
  
    }); 


           // iterate through the v1 folder //

      $dirIterator = new RecursiveDirectoryIterator( __DIR__ .'/api/v1');

      //.. @var RecursiveDirectoryIterator |  \ RecursiveIteratorIterator $it ..//

      $it = new RecursiveIteratorIterator($dirIterator);

      //.. require the file in each iterator..//

      while($it->valid()) {
        if(! $it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === 'php')
         {
            require $it->key();
          }

        $it->next();
       }

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

 });
