<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\WebController;
use App\Models\BodyType;
use App\Models\Color;
use App\Models\Make;
use App\Models\ModelVariant;
use App\Models\Vehicle;
use App\Models\VehicleModel;
use App\Models\VehicleType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [WebController::class, 'index']);
Route::get('/features', [WebController::class, 'features']);
Route::get('/disclaimer', [WebController::class, 'disclaimer']);
Route::get('/faq', [WebController::class, 'faq']);
Route::get('/terms', [WebController::class, 'terms']);
Route::get('/cookiepolicy', [WebController::class, 'cookiepolicy']);
Route::get('/about', [WebController::class, 'about']);

Route::get('/privacy', [WebController::class, 'privacy']);

Route::get('/pricing', [WebController::class, 'pricing']);

Route::get('/autionshadule', [WebController::class, 'AutionShadule']);

Route::get('/exploreevery', [WebController::class, 'ExploreEvery']);
Route::get('/compair', [WebController::class, 'compairaution']);
Route::get('/privecy', [WebController::class, 'privecy']);
Route::get('/faqs', [WebController::class, 'faqs']);
Route::get('/explore/newss', [WebController::class, 'newss']);

Route::get('/login',  [AuthController::class, 'login'])->name('login');
Route::post('/login_submit', [AuthController::class, 'login_submit']);


Route::get('/verify-email/{email}', [AuthController::class, 'show'])->name('verify.email.show');
Route::post('/verify-email-token', [AuthController::class, 'verifyToken'])->name('verify.email.submit');
Route::post('/verify-email/resend', [AuthController::class, 'resendToken'])->name('verify.email.resend');

// Google auth
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('/register', [AuthController::class, 'register']);

Route::post('/register_submit', [AuthController::class, 'register_submit']);
Route::get('/forgot-password', [AuthController::class, 'forgotpassword']);
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password-form', [AuthController::class, 'resetpasswordvalidation']);
Route::post('/reset-password-submit', [AuthController::class, 'resetpasswordsubmit'])->name('reset.password.submit');

Route::get('/support', [WebController::class, 'support']);
Route::post('/send-contact', [WebController::class, 'send']);


Route::get('/uploading1', function (Request $request) {

    Vehicle::query()->delete();
    BodyType::query()->delete();
    VehicleType::query()->delete();
    Color::query()->delete();
    ModelVariant::query()->delete();
    VehicleModel::query()->delete();
    Make::query()->delete();


    $path = public_path('color.csv');
    $csv = file($path);
    $rows = array_map('str_getcsv', $csv);
    foreach ($rows as $value) {
        if ($value[1]) {
            Color::create([
                'id' => $value[0],
                'name' => $value[1],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    $path = public_path('body.csv');
    $csv = file($path);
    $rows = array_map('str_getcsv', $csv);
    foreach ($rows as $value) {
        if ($value[1]) {
            BodyType::create([
                'id' => $value[0],
                'name' => $value[1],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }


    $path = public_path('vehicle.csv');
    $csv = file($path);
    $rows = array_map('str_getcsv', $csv);
    foreach ($rows as $value) {
        if ($value[1]) {
            VehicleType::create([
                'id' => $value[0],
                'name' => $value[1],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }


    //Path
    $path = public_path('make.csv');
    $csv = file($path);
    $rows = array_map('str_getcsv', $csv);
    foreach ($rows as $value) {
        if ($value[1]) {
            Make::create([
                'id' => $value[0],
                'name' => $value[1],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }


    //Path
    $path = public_path('model.csv');
    $csv = file($path);
    $rows = array_map('str_getcsv', $csv);
    foreach ($rows as $value) {
        if ($value[1]) {
            VehicleModel::create([
                'id' => $value[0],
                'name' => $value[1],
                'make_id' => $value[2],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
});



Route::get('/uploading2', function (Request $request) {


    $path = public_path('variant.csv');
    $csv = file($path);
    $rows = array_map('str_getcsv', $csv);
    foreach ($rows as $value) {
        if ($value[1]) {
            ModelVariant::create([
                'id' => $value[0],
                'name' => $value[1],
                'model_id' => $value[2],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
});

Route::get('/packages', [FrontendController::class, 'pricing'])->name('packages');

Route::view('/registration', 'front.register')->name('registration');