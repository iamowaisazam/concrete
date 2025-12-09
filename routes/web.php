<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ProfileSettingController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\PaymentController; // Import the controller
use App\Http\Controllers\TestPaymentController;
use App\Http\Controllers\UiSettingController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\AuctionFinderController;
use App\Http\Controllers\AuctionFinderDataController;
use App\Http\Controllers\ReauctionController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\UserAlertController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\InvoiceController;
use App\Http\Middleware\CheckUserStatus;
use App\Models\BodyType;
use App\Models\Color;
use App\Models\Make;
use App\Models\ModelVariant;
use App\Models\Vehicle;
use App\Models\VehicleModel;
use App\Models\VehicleType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\NotifyIntrestController;

use App\Http\Controllers\Auth\GoogleController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Broadcast::routes(['middleware' => ['auth:sanctum']]);
// ya agar session auth use kar rahe ho to
Broadcast::routes(['middleware' => ['auth']]);




// Route::get('/features', [WebController::class, 'features']);
// Route::get('/disclaimer', [WebController::class, 'disclaimer']);
// Route::get('/faq', [WebController::class, 'faq']);
// Route::get('/terms', [WebController::class, 'terms']);
// Route::get('/cookiepolicy', [WebController::class, 'cookiepolicy']);
// Route::get('/about', [WebController::class, 'about']);

// Route::get('/privacy', [WebController::class, 'privacy']);

// Route::get('/pricing', [WebController::class, 'pricing']);

// Route::get('/autionshadule', [WebController::class, 'AutionShadule']);

// Route::get('/exploreevery', [WebController::class, 'ExploreEvery']);
// Route::get('/compair', [WebController::class, 'compairaution']);
// Route::get('/privecy', [WebController::class, 'privecy']);
// Route::get('/faqs', [WebController::class, 'faqs']);
// Route::get('/explore/newss', [WebController::class, 'newss']);






// Logout (shared)
Route::post('/logout', fn() => Auth::logout() ?: redirect('/login'))->name('logout');

Route::middleware(['auth'])->prefix('user/settings')->group(function () {
    Route::get('/ui', [UiSettingController::class, 'edit'])->name('user.settings.ui');
    Route::post('/ui', [UiSettingController::class, 'update'])->name('user.settings.ui.update');
});




// Dashboard data (AJAX)
Route::get('dashboard/data', [VehicleController::class, 'getVehicles']);
Route::get('/dashboard/filters', [VehicleController::class, 'getFilterOptions']);

Route::get('/test-payment', [TestPaymentController::class, 'showPaymentForm'])->name('test.payment.form');
Route::post('/processpayment', [TestPaymentController::class, 'processPayment'])->name('payment.process');
Route::get('/payment/success', [TestPaymentController::class, 'paymentSuccess'])->name('payment.successs');
Route::get('/payment/cancel', [TestPaymentController::class, 'paymentCancel'])->name('payment.cancels');
Route::get('/payment/successful', [TestPaymentController::class, 'paymentSuccessful'])->name('payment.successful');
Route::get('/payment/failed', [TestPaymentController::class, 'paymentFailed'])->name('payment.failed');


Route::get('/pay-12-pounds', [PaymentController::class, 'showPaymentForm'])->name('pay.twelve');
Route::post('/process-payment', [PaymentController::class, 'processPayment'])->name('process.payment');
Route::get('/payment-success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment-cancel', [PaymentController::class, 'paymentCancel'])->name('payment.cancel');


Route::post('/stripe/create-checkout-session', [PaymentController::class, 'createStripeCheckoutSession'])->name('stripe.checkout');
Route::get('/stripe/success', [PaymentController::class, 'stripeSuccess'])->name('stripe.success');
Route::get('/stripe/cancel', [PaymentController::class, 'stripeCancel'])->name('stripe.cancel');
Route::post('/stripe/webhook', [WebhookController::class, 'handleStripeWebhook']); // Add this route for webhooks


Route::get('/{any?}', function () {
    return view('user.test');
})->where('any', '.*');


// // User Authenticated Routes
// Route::middleware(['auth'])->group(function () {

//     // account-setting
//     Route::match(['get', 'post'], '/checkout', [AuthController::class, 'checkout']);
//     Route::match(['get', 'post'], '/account-setting/profile', [ProfileSettingController::class, 'profile']);
//     Route::match(['get', 'post'], '/account-setting/changePassword', [ProfileSettingController::class, 'changePassword']);
//     Route::match(['get', 'post'], '/account-setting/billing', [ProfileSettingController::class, 'billing']);
//     Route::get('/userprofile', [ProfileSettingController::class, 'userprofile']);
//     Route::get('/account-setting/notifications', [ProfileSettingController::class, 'Notifications']);
//     Route::post('/notifications', [ProfileSettingController::class, 'storenotification'])->name('user.notifications.store');

//     // News (public)
//     Route::get('/news', [NewsController::class, 'index'])->name('news.index');
//     Route::get('/blogs', [NewsController::class, 'blogs'])->name('blog.index');
//     Route::post('/news/{id}/toggle-pin', [NewsController::class, 'togglePin'])->name('news.togglePin');




//     Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
//         Route::resource('payment-methods', ProfileSettingController::class);
//     });
// });



//Membership Routes
// Route::middleware(['auth', CheckUserStatus::class])->group(function () {

//     Route::resource('associate-users', \App\Http\Controllers\AssociateUserController::class);

//     // User Dashboard & Pages
//     Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dasahbord');
//     Route::get('/dashboard/online', [DashboardController::class, 'onlineAuctions']);
//     Route::get('/dashboard/time', [DashboardController::class, 'timeAuctions']);
//     Route::get('/dashboard/favourite', [DashboardController::class, 'favouriteAuctions']);
//     Route::get('/dashboard/stats', [DashboardController::class, 'statsAuctions']);

//     Route::get('/dashboard/getTotalAuctions', [DashboardController::class, 'getTotalAuctions']);
//     Route::get('/dashboard/getOnlineAuctions', [DashboardController::class, 'getOnlineAuctions']);
//     Route::get('/dashboard/getTimeAuctions', [DashboardController::class, 'getTimeAuctions']);
//     Route::get('/dashboard/vehicleStates', [DashboardController::class, 'vehicleStates']);

//     Route::get('/dashboard/bestAuctions', [DashboardController::class, 'bestAuctions']);
//     Route::get('/dashboard/previousLots', [DashboardController::class, 'previousLots']);
//     Route::get('/dashboard/lookbestauction', [DashboardController::class, 'lookbestauction']);

//     Route::get('/dashboard/upComingVehicles', [DashboardController::class, 'upComingVehicles']);
//     Route::get('/dashboard/getValuation', [DashboardController::class, 'getValuation']);
//     Route::get('/dashboard/setIntrest', [DashboardController::class, 'getInterestSummary']);
//     Route::get('/dashboard/setIntrest', [DashboardController::class, 'getInterestSummary']);
//     Route::get('/dashboard/stockAuctionHouse', [DashboardController::class, 'stockAuctionHouse']);
//     Route::get('/dashboard/gettopheaderintrest', [DashboardController::class, 'getInterestDashboard']);
//     Route::get('/user/has-interest', [DashboardController::class, 'hasInterest']);




//     Route::get('/auction-finder/vehicle/{id}', [AuctionFinderController::class, 'vehicle']);
//     Route::get('/auction-finder', [AuctionFinderController::class, 'index'])->name('auctionfinder');
//     Route::get('/auctionscheduler', [AuctionFinderController::class, 'auctionScheduler']);
//     Route::post('/alert-platefrom/store', [AuctionFinderController::class, 'storeAlert']);
//     Route::post('/auction/intrest', [AuctionFinderController::class, 'getIntrest']);
//     Route::post('/auction-finder/vehicle/get-vehicle-details', [AuctionFinderDataController::class, 'getVehicleDetails']);

//     //Data
//     Route::get('/auction-finder/data/getRelatedVehicle/{id}', [AuctionFinderDataController::class, 'getRelatedVehicle']);
//     Route::get('/auction-finder/data/auctionList', [AuctionFinderDataController::class, 'auctionList']);
//     Route::get('/auction-finder/data/getPlatformVehicle', [AuctionFinderDataController::class, 'getPlatformVehicle']);

//     Route::get('/auction-finder/data/getVehicleTypes', [AuctionFinderDataController::class, 'getVehicleTypes']);
//     Route::get('/auction-finder/data/getMakes', [AuctionFinderDataController::class, 'getMakes']);
//     Route::get('/auction-finder/data/getModels', [AuctionFinderDataController::class, 'getModels']);
//     Route::get('/auction-finder/data/getVariants', [AuctionFinderDataController::class, 'getVariants']);
//     Route::get('/auction-finder/data/getYears', [AuctionFinderDataController::class, 'getYears']);
//     Route::get('/auction-finder/data/getTransmissions', [AuctionFinderDataController::class, 'getTransmissions']);
//     Route::get('/auction-finder/data/getFuelType', [AuctionFinderDataController::class, 'getFuelType']);
//     Route::get('/auction-finder/data/getBodyType', [AuctionFinderDataController::class, 'getBodyType']);
//     Route::get('/auction-finder/data/getColors', [AuctionFinderDataController::class, 'getColors']);
//     Route::get('/auction-finder/data/getdoors', [AuctionFinderDataController::class, 'getDoors']);
//     Route::get('/auction-finder/data/getSeats', [AuctionFinderDataController::class, 'getSeats']);
//     Route::get('/auction-finder/data/getGrade', [AuctionFinderDataController::class, 'getGrade']);
//     Route::get('/auction-finder/data/getV5', [AuctionFinderDataController::class, 'getV5']);
//     Route::get('/auction-finder/data/getEngineSize', [AuctionFinderDataController::class, 'getEngineSize']);
//     Route::get('/auction-finder/data/getFormerKeepers', [AuctionFinderDataController::class, 'getFormerKeepers']);
//     Route::get('/auction-finder/data/getNoOfservices', [AuctionFinderDataController::class, 'getNoOfservices']);
//     Route::get('/auction-finder/data/getAuctionHouse', [AuctionFinderDataController::class, 'getAuctionHouse']);
//     Route::get('/auction-finder/data/getAuctionCenter', [AuctionFinderDataController::class, 'getAuctionCenter']);
//     Route::get('/auction-finder/data/getDates', [AuctionFinderDataController::class, 'getDates']);



//     Route::view('/upcoming', 'user/upcoming')->name('upcoming');
//     Route::view('/auctioncalender', 'user/auctioncalender')->name('auctioncalender');
//     Route::view('/auctiondetail', 'user/auctiondetail')->name('auctiondetail');
//     Route::view('/futureauction', 'user/futureauction')->name('futureauction');
//     Route::view('/timeauction', 'user/timeauction')->name('timeauction');

//     // Reauction
//     Route::get('/reauction', [ReauctionController::class, 'index'])->name('reauction');
//     Route::get('/get-reauction-stats', [ReauctionController::class, 'getReauctionStats']);

//     Route::get('/reauction/interest', [ReauctionController::class, 'interest'])->name('reauction-interest');
//     Route::post('/reauction/info', [ReauctionController::class, 'information'])->name('reauctioninfo');
//     Route::get('/autionshadule', [WebController::class, 'AutionShadule'])->name('autionshadule');
//     Route::post('/notificationsstore', [ReauctionController::class, 'notification'])->name('notifications.store');

//     // compare
//     Route::get('/compare', [CompareController::class, 'index'])->name('compare');
//     Route::get('/compare/head', [CompareController::class, 'fetchHead'])->name('compare.head');
//     Route::post('/compare/body', [CompareController::class, 'fetchBody']);
//     Route::get('/get-models-variants/{make_id}', [CompareController::class, 'getModelsAndVariants']);


//     Route::view('/vinsearch', 'user/vinsearch')->name('vinsearch');
//     // Route::view('/interest', 'user/interest')->name('interest');

//     Route::get('/interest/myintrest', [InterestController::class, 'myintrest']);
//     Route::get('/interest/setintrest/{id}', [InterestController::class, 'setintrest']);
//     Route::resource('/interest', InterestController::class);

//     Route::view('/gellery', 'user/gellery')->name('gellery');
//     Route::view('/comparevehicles', 'user/comparevehicles')->name('comparevehicles');
//     Route::view('/reauctiontracker', 'user/reauctiontracker')->name('reauctiontracker');
//     // Route::view('/pricing', 'user/pricing')->name('pricing');
//     Route::view('/platformwise', 'user/platformwise')->name('platformwise');
//     Route::view('/search', 'user/search')->name('search');

//     // Ticket Management
//     Route::get('/createticket', [TicketController::class, 'create'])->name('ticket.create');
//     Route::post('/ticket/store', [TicketController::class, 'store'])->name('ticket.store');
//     Route::get('/tickethistory', [TicketController::class, 'history'])->name('ticket.history');
//     Route::get('/ticket/{id}', [TicketController::class, 'view'])->name('ticket.view');
//     Route::post('/ticket/{id}/reply', [TicketController::class, 'reply'])->name('ticket.reply');
//     Route::get('/ticket-history/data', [TicketController::class, 'historyData'])->name('ticket.history.data');
//     Route::post('/ticket/{id}/feedback', [TicketController::class, 'submitFeedback'])->name('ticket.feedback');


//     // myalert
//     Route::get('/viewhistory', [UserAlertController::class, 'index']);
//     Route::get('/viewhistory/get-filters', [UserAlertController::class, 'getVehicleFilters'])->name('get.filters');
//     Route::post('/viewhistory/auction-data', [UserAlertController::class, 'getAuctionData'])->name('get.auction.data');
//     Route::delete('/viewhistory/alerts/{id}', [UserAlertController::class, 'destroy']);




//     Route::get('/auction-finder/vehicle/{id}', [AuctionFinderController::class, 'vehicle']);
//     Route::get('/auction-finder', [AuctionFinderController::class, 'index'])->name('auctionfinder');
//     Route::get('/auctionscheduler', [AuctionFinderController::class, 'auctionScheduler']);
//     Route::post('/alert-platefrom/store', [AuctionFinderController::class, 'storeAlert']);
//     Route::post('/auction/intrest', [AuctionFinderController::class, 'getIntrest']);

//     //Data
//     Route::get('/auction-finder/data/getRelatedVehicle/{id}', [AuctionFinderDataController::class, 'getRelatedVehicle']);
//     Route::get('/auction-finder/data/auctionList', [AuctionFinderDataController::class, 'auctionList']);
//     Route::get('/auction-finder/data/getPlatformVehicle', [AuctionFinderDataController::class, 'getPlatformVehicle']);

//     Route::get('/auction-finder/data/getVehicleTypes', [AuctionFinderDataController::class, 'getVehicleTypes']);
//     Route::get('/auction-finder/data/getMakes', [AuctionFinderDataController::class, 'getMakes']);
//     Route::get('/auction-finder/data/getModels', [AuctionFinderDataController::class, 'getModels']);
//     Route::get('/auction-finder/data/getModels2', [AuctionFinderDataController::class, 'getModels2']);
//     Route::get('/auction-finder/data/getVariants', [AuctionFinderDataController::class, 'getVariants']);
//     Route::get('/auction-finder/data/getYears', [AuctionFinderDataController::class, 'getYears']);
//     Route::get('/auction-finder/data/getTransmissions', [AuctionFinderDataController::class, 'getTransmissions']);
//     Route::get('/auction-finder/data/getFuelType', [AuctionFinderDataController::class, 'getFuelType']);
//     Route::get('/auction-finder/data/getBodyType', [AuctionFinderDataController::class, 'getBodyType']);
//     Route::get('/auction-finder/data/getColors', [AuctionFinderDataController::class, 'getColors']);
//     Route::get('/auction-finder/data/getDoors', [AuctionFinderDataController::class, 'getDoors']);
//     Route::get('/auction-finder/data/getSeats', [AuctionFinderDataController::class, 'getSeats']);
//     Route::get('/auction-finder/data/getGrade', [AuctionFinderDataController::class, 'getGrade']);
//     Route::get('/auction-finder/data/getV5', [AuctionFinderDataController::class, 'getV5']);
//     Route::get('/auction-finder/data/getEngineSize', [AuctionFinderDataController::class, 'getEngineSize']);
//     Route::get('/auction-finder/data/getFormerKeepers', [AuctionFinderDataController::class, 'getFormerKeepers']);
//     Route::get('/auction-finder/data/getNoOfservices', [AuctionFinderDataController::class, 'getNoOfservices']);



//     Route::view('/upcoming', 'user/upcoming')->name('upcoming');
//     Route::view('/auctioncalender', 'user/auctioncalender')->name('auctioncalender');
//     Route::view('/auctiondetail', 'user/auctiondetail')->name('auctiondetail');
//     Route::view('/futureauction', 'user/futureauction')->name('futureauction');
//     Route::view('/timeauction', 'user/timeauction')->name('timeauction');

//     // Reauction
//     Route::get('/reauction', [ReauctionController::class, 'index'])->name('reauction');
//     Route::get('/reauction/interest', [ReauctionController::class, 'interest'])->name('reauction-interest');
//     Route::post('/reauction/info', [ReauctionController::class, 'information'])->name('reauctioninfo');
//     Route::get('/autionshadule', [WebController::class, 'AutionShadule'])->name('autionshadule');
//     Route::post('/notificationsstore', [ReauctionController::class, 'notification'])->name('notifications.store');

//     // compare
//     Route::get('/compare', [CompareController::class, 'index'])->name('compare');
//     Route::get('/compare/head', [CompareController::class, 'fetchHead'])->name('compare.head');
//     Route::post('/compare/body', [CompareController::class, 'fetchBody']);
//     Route::get('/get-models-variants/{make_id}', [CompareController::class, 'getModelsAndVariants']);


//     Route::view('/vinsearch', 'user/vinsearch')->name('vinsearch');
//     // Route::view('/interest', 'user/interest')->name('interest');

//     Route::get('/interest/myintrest', [InterestController::class, 'myintrest']);
//     Route::get('/interest/setintrest/{id}', [InterestController::class, 'setintrest']);
//     Route::resource('/interest', InterestController::class);

//     Route::view('/gellery', 'user/gellery')->name('gellery');
//     Route::view('/comparevehicles', 'user/comparevehicles')->name('comparevehicles');
//     Route::view('/reauctiontracker', 'user/reauctiontracker')->name('reauctiontracker');
//     // Route::view('/pricing', 'user/pricing')->name('pricing');
//     Route::view('/platformwise', 'user/platformwise')->name('platformwise');
//     Route::view('/search', 'user/search')->name('search');

//     // Ticket Management
//     Route::get('/createticket', [TicketController::class, 'create'])->name('ticket.create');
//     Route::post('/ticket/store', [TicketController::class, 'store'])->name('ticket.store');
//     Route::get('/tickethistory', [TicketController::class, 'history'])->name('ticket.history');
//     Route::get('/ticket/{id}', [TicketController::class, 'view'])->name('ticket.view');
//     Route::post('/ticket/{id}/reply', [TicketController::class, 'reply'])->name('ticket.reply');
//     Route::get('/ticket-history/data', [TicketController::class, 'historyData'])->name('ticket.history.data');
//     Route::post('/ticket/{id}/feedback', [TicketController::class, 'submitFeedback'])->name('ticket.feedback');


//     // myalert
//     Route::get('/viewhistory', [UserAlertController::class, 'index']);
//     Route::get('/viewhistory/get-filters', [UserAlertController::class, 'getVehicleFilters'])->name('get.filters');
//     Route::post('viewhistory/auction-data', [UserAlertController::class, 'getAuctionData'])->name('get.auction.data');


//     Route::post('/notifications/mark-read/{id}', function ($id) {
//         $notif = \App\Models\UserNotificationAlert::findOrFail($id);
//         $notif->update(['is_read' => 1]);
//         return back();
//     });

//     Route::get('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');
//     Route::post('/notifications/delete/{id}', [NotificationController::class, 'delete']);
//     Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.all');
// });




// Admin Routes
// require __DIR__ . '/web.php';
// require __DIR__ . '/admin.php';


// cron job route
// Route::get('/send_interest_notify/{token?}', [NotifyIntrestController::class, 'sendInterestNotify']);
// Route::get('/send-daily-summary', [NotifyIntrestController::class, 'sendDailySummary']);

// Route::get('/invoice/{id}', [InvoiceController::class, 'view'])->name('invoice.view');
// Route::get('/invoice/{id}/download', [InvoiceController::class, 'downloadPDF'])->name('invoice.pdf');
