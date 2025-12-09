<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\admin\AdminAuthController;
use App\Http\Controllers\admin\AdminNewscrudController;
use App\Http\Controllers\admin\AdminNewsCategoryController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\AdminUserController;
use App\Http\Controllers\admin\AlertController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\ActivityController;
use App\Http\Controllers\admin\PlanController;
use App\Http\Controllers\admin\MembershipController;
use App\Http\Controllers\admin\TicketsController;
use App\Http\Controllers\admin\AuctionController;
use App\Http\Controllers\admin\VehicleController;
use App\Http\Controllers\admin\BodyTypeController;
use App\Http\Controllers\admin\CenterController;
use App\Http\Controllers\admin\ColorController;
use App\Http\Controllers\admin\MakeController;
use App\Http\Controllers\admin\ModelController;
use App\Http\Controllers\admin\PlatformController;
use App\Http\Controllers\admin\VariantController;
use App\Http\Controllers\admin\VehicleTypeController;
use App\Http\Controllers\admin\BlogController as AdminBlogController;
use App\Http\Middleware\IsAdmin;

Route::get('/admin', [AdminAuthController::class, 'showLoginForm']);
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm']);
Route::post('/admin/login', [AdminAuthController::class, 'login']);


Route::prefix('admin')->middleware(['auth',IsAdmin::class])->group(function () {

    
        Route::post('/logout', [AdminAuthController::class, 'logout']);

        //Profile
        Route::view('/importcsv', 'admin/datamanagement/importcsv');
        Route::view('/scrappinglogs', 'admin/datamanagement/scrappinglogs');
        Route::view('/datascrapereview', 'admin/datamanagement/datascrapereview');
        Route::view('/rolepermission', 'admin/securitysetting/rolepermission');
        Route::view('/backuprestore', 'admin/securitysetting/backuprestore');
        Route::view('/activitylog', 'admin/securitysetting/activitylog');
        Route::view('/mostsearch', 'admin/reportsanalytics/mostsearch');
        Route::view('/auctionperformancereport', 'admin/reportsanalytics/auctionperformancereport');
        Route::view('/realtimeuseractivity', 'admin/reportsanalytics/realtimeuseractivity');
        Route::view('/customemailtemplate', 'admin/alerts/customemailtemplate');


        //Masters
        Route::get('/masters/platforms/getPlatforms', [PlatformController::class,'getPlatforms']);
        Route::get('/masters/platforms/getPlatformshouse', [PlatformController::class,'getPlatformshouse']);
        Route::resource('masters/platforms',PlatformController::class);
        
        Route::get('/masters/centers/getCenters', [CenterController::class,'getCenters']);
        Route::resource('masters/centers',CenterController::class);
        
        Route::get('/masters/colours/getColours', [ColorController::class,'getColours']);
        Route::resource('masters/colours',ColorController::class);
        
        Route::get('/masters/bodytypes/getBodyTypes', [BodyTypeController::class,'getBodyTypes']);
        Route::resource('masters/bodytypes',BodyTypeController::class);
        
        Route::get('/masters/vehicletypes/getVehicleTypes', [VehicleTypeController::class, 'getVehicleTypes']);
        Route::resource('masters/vehicletypes',VehicleTypeController::class);
        
        Route::get('/masters/makes/getMakes', [MakeController::class, 'getMakes']);
        Route::resource('masters/makes',MakeController::class);
        
        Route::get('/masters/models/getModels', [ModelController::class, 'getModels']);
        Route::resource('/masters/models',ModelController::class);
        
        Route::get('/masters/variants/getVariants', [VariantController::class, 'getVariants']);
        Route::resource('/masters/variants',VariantController::class);
        
        Route::get('/masters/newcat/getnewscategory', [AdminNewscrudController::class, 'getCategory']);
        Route::get('/masters/memberships/getmemberships', [AdminNewscrudController::class, 'getmemberships']);
        
        //Auctions
        Route::prefix('auctions')->group(function () {

            Route::get('/getAuction', [AuctionController::class, 'getAuctions']);
            Route::get('/', [AuctionController::class, 'index']);
            Route::get('/viewCsv/{id}', [AuctionController::class,'viewCsv']);
            Route::get('/create', [AuctionController::class, 'create']);
            
            Route::post('/', [AuctionController::class, 'store']);
            Route::get('/{auction}/edit', [AuctionController::class, 'edit']);
            Route::put('/{auction}', [AuctionController::class, 'update']);
            Route::delete('/{auction}', [AuctionController::class, 'destroy']);
        
            Route::get('/ajax/get', [AuctionController::class, 'getAjaxData']);
            Route::get('/ajax/platform/{id}/centers', [AuctionController::class,'getCentersByPlatform']);
        });
        

        //Plans
        Route::prefix('plans')->group(function () {
            Route::get('/', [PlanController::class, 'index']);
            Route::get('/create', [PlanController::class, 'create']);
            Route::post('/store', [PlanController::class, 'store']);
            Route::put('/update/{plan}', [PlanController::class, 'update']);
            Route::get('/sort', [PlanController::class, 'sort']);
            Route::post('/sort', [PlanController::class, 'updateOrder'])->name('admin.plans.updateOrder');
            
            Route::get('/{plan}/edit', [PlanController::class, 'edit']);
            
            Route::delete('/{plan}', [PlanController::class, 'destroy']);
            Route::get('/ajax/get', [PlanController::class, 'getAjaxData']);
        });
        

        //Tickets
        Route::prefix('tickets')->group(function () {
            Route::get('/', [TicketsController::class, 'index']);
            Route::get('/{id}', [TicketsController::class, 'show']);
            Route::post('/{id}/reply', [TicketsController::class, 'reply']);
            Route::post('/{id}/update', [TicketsController::class, 'updateStatus']);
        });


        //Membership
        Route::prefix('memberShips')->group(function () {
            Route::get('/', [MembershipController::class, 'index']);
            Route::get('/create', [MembershipController::class, 'create']);
            Route::post('/store', [MembershipController::class, 'store']);
            Route::post('/fetch-user', [MembershipController::class, 'fetchUser']);
            Route::get('/{id}/edit', [MembershipController::class, 'edit']);
            Route::post('/{id}/update', [MembershipController::class, 'update']);
            Route::post('/{id}/destroy', [MembershipController::class, 'destroy']);
        });

        
        // Blog Categories (CRUD)
        Route::prefix('blogcategories')->group(function () {
            Route::get('/', [BlogCategoryController::class, 'index']);
            Route::get('/create', [BlogCategoryController::class, 'create']);
            Route::post('/', [BlogCategoryController::class, 'store']);
            Route::get('/{blogcategory}/edit', [BlogCategoryController::class, 'edit']);
            Route::put('/{blogcategory}', [BlogCategoryController::class, 'update']);
            Route::delete('/{blogcategory}', [BlogCategoryController::class, 'destroy']);
        });

        
        // Blogs (CRUD with AJAX)
        Route::middleware('auth')->prefix('blogs')->name('blogs.')->group(function () {
            Route::get('/', [AdminBlogController::class, 'index']);
            Route::get('/create', [AdminBlogController::class, 'create']);
            Route::post('/store', [AdminBlogController::class, 'store']);
            Route::get('/{slug}', [AdminBlogController::class, 'show']);
            Route::get('/{blog}/edit', [AdminBlogController::class, 'edit']);
            Route::put('/{blog}', [AdminBlogController::class, 'update']);
            Route::delete('/{blog}', [AdminBlogController::class, 'destroy']);
            Route::post('/upload-image', [AdminBlogController::class, 'uploadImage']);
        });
        

        //Vehicles
        Route::get('/vehicles', [VehicleController::class,'index']);
        Route::get('/vehicles/create', [VehicleController::class,'create']);
        Route::post('/vehicles/store', [VehicleController::class, 'store']);
        Route::get('/vehicles/edit/{id}', [VehicleController::class,'edit']);
        Route::put('/vehicles/update/{id}', [VehicleController::class,'update']);
        Route::delete('/vehicles/destroy/{id}', [VehicleController::class,'destroy']);
        Route::get('/vehicles/show/{id}', [VehicleController::class, 'show']);
        // Route::get('/admin/vehicles/show/{id}/vehicle_details', [AVehicleController::class, 'vehicleDetails']);
        // Route::get('/admin/vehicles/show/{id}/vehicle_valuation', [AVehicleController::class, 'vehicleValuation']);
        
        
        
        //News
        Route::prefix('news')->name('admin.news.')->group(function () {
            Route::get('/', [AdminNewscrudController::class, 'index']);
            Route::post('/', [AdminNewscrudController::class, 'store']);
            Route::get('/create', [AdminNewscrudController::class, 'create']);
            
            Route::get('/{news}/edit', [AdminNewscrudController::class, 'edit']);
            Route::put('/{news}', [AdminNewscrudController::class, 'update']);
            Route::delete('/{news}', [AdminNewscrudController::class, 'destroy']);
        });
        
        //News categories
        
        Route::prefix('ncategories')->group(function () {
            Route::get('/', [AdminNewsCategoryController::class, 'index']);
            Route::get('/create', [AdminNewsCategoryController::class, 'create']);
            Route::post('/', [AdminNewsCategoryController::class, 'store']);
           Route::get('/{newsCategory}/edit', [AdminNewsCategoryController::class, 'edit']);
            Route::put('/{newsCategory}', [AdminNewsCategoryController::class, 'update']);
            Route::delete('/{newsCategory}', [AdminNewsCategoryController::class, 'destroy']);
        });
        
        
        
        //Alerts
        Route::prefix('alerts')->middleware('auth')->name('alerts.')->group(function () {
            Route::get('/', [AlertController::class, 'index'])->name('index');
            Route::get('/create', [AlertController::class, 'create'])->name('create');
            Route::post('/store', [AlertController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AlertController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AlertController::class, 'update'])->name('update');
            Route::delete('/{id}', [AlertController::class, 'destroy'])->name('destroy');
            Route::get('/ajax/data', [AlertController::class, 'ajaxData'])->name('ajax');
        });

        
        Route::prefix('role')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('role.index');
            Route::get('/create', [RoleController::class, 'create'])->name('create');
            Route::post('/store', [RoleController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [RoleController::class, 'edit'])->name('edit');
            Route::put('/{id}', [RoleController::class, 'update'])->name('update');
            Route::delete('/{id}', [RoleController::class, 'destroy'])->name('role.destroy');
            Route::get('/getRole', [RoleController::class, 'getRole']);
            Route::get('/access/{id}', [RoleController::class, 'access']);
            Route::post('/access/store', [RoleController::class, 'accessStore']);
        });
        Route::prefix('activity')->group(function () {
            Route::get('/', [ActivityController::class, 'index'])->name('role.index');
        });
        

        //Members
        Route::get('members', [UserController::class, 'index']);
        Route::get('members-data', [UserController::class, 'getData']);
        Route::get('members/create', [UserController::class, 'create']);
        Route::post('members/store', [UserController::class, 'store']);
        Route::get('members/{id}/edit', [UserController::class, 'edit']);
        Route::post('members/{id}/update', [UserController::class, 'update']);
        Route::get('members/{id}/delete', [UserController::class, 'destroy']);
        Route::get('members/{id}/status/{status}', [UserController::class, 'updateStatus'])->name('admin.members.status');
        Route::get('members/getmembers', [UserController::class,'getmembers']);
        
        
        //Users
        Route::get('users', [AdminUserController::class, 'index'])->name('admin.users.index');
        Route::get('users-data', [AdminUserController::class, 'getData']);
        Route::get('users/create', [AdminUserController::class, 'create']);
        Route::post('users/store', [AdminUserController::class, 'store']);
        Route::get('users/{id}/edit', [AdminUserController::class, 'edit']);
        Route::post('users/{id}/update', [AdminUserController::class, 'update']);
        Route::get('users/{id}/delete', [AdminUserController::class, 'destroy']);
        Route::get('users/{id}/status/{status}', [AdminUserController::class, 'updateStatus'])->name('admin.users.status');

        // Admin Authentication
        Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/profile', [AdminAuthController::class, 'profile']);



    

});




?>