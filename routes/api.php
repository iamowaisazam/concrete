<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\DeliveryNoteController;
use App\Http\Controllers\Api\ExpenseCategoryController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SaleInvoiceController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\SaleOrderController;
use App\Http\Controllers\Api\StockAdjustmentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::prefix('auth')->group(function () {

    Route::get('/profile', [AuthController::class, 'profile'])->middleware(['auth:sanctum']);
    // Route::post('/profile',[AuthController::class,'profileUpdate'])->middleware(['auth:sanctum']);

    Route::post('/login', [AuthController::class, 'login']);
    // Route::post('/register',[AuthController::class,'register']);

    Route::post('/changePassword', [AuthController::class, 'changePassword'])->middleware(['auth:sanctum']);
});


Route::apiResource('users', UserController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('category', CategoryController::class);
Route::apiResource('unit', UnitController::class);
Route::apiResource('expenseCategory', ExpenseCategoryController::class);
Route::apiResource('expenses', ExpenseController::class);

Route::apiResource('payments', PaymentController::class);
Route::apiResource('stockadjustment', StockAdjustmentController::class);

Route::apiResource('saleOrder', SaleOrderController::class);
Route::apiResource('deliveryNotes', DeliveryNoteController::class);
Route::apiResource('saleInvoice', SaleInvoiceController::class);


Route::prefix('reports')->group(function () {

    Route::get('/customerLedger', [ReportController::class, 'customerLedger']);
    Route::get('/customerLedgerDetail/{id}', [ReportController::class, 'customerLedgerDetail']);
    Route::get('/inventory', [ReportController::class, 'inventory']);
    Route::get('/inventoryDetail/{id}', [ReportController::class, 'inventoryDetail']);
});
