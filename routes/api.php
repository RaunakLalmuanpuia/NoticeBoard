<?php

use App\Http\Controllers\TaxiController;
use App\Http\Controllers\TourGuideController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PlaceOfInterestController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\NoticeBoardController;
use App\Http\Controllers\PaytmController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\ReservedDateController;
use App\Http\Controllers\SettingController;


Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
});

Route::middleware(['auth:api'])->group(function () {
  // get auth user
  Route::get('/auth/user', [AdminController::class, 'getAuthUserDetail']);
  Route::post('/update/profile', [AdminController::class, 'updateProfile']);
  // end auth user

  Route::post('/add-item', [AdminController::class, 'addItem']);
  Route::get('/get-items', [AdminController::class, 'getItems']);
  Route::get('/get-all-items', [AdminController::class, 'getAllItems']);
  Route::post('/delete-item/{id}', [AdminController::class, 'deleteItem']);

  // guide
  Route::get('/get-guide-categories', [GuideController::class, 'getGuideCategories']);
  Route::post('/add-guide', [GuideController::class, 'addGuide']);
  Route::get('/get-guide', [GuideController::class, 'getGuide']);
  Route::post('/delete-guide/{id}', [GuideController::class, 'deleteGuide']);
  Route::get('/get-guide/{id}', [GuideController::class, 'getGuideSingle']);
  Route::post('/update-guide/{id}', [GuideController::class, 'updateGuide']);

  // NoticeBoard
    Route::get('/admin-notice', [NoticeBoardController::class, 'adminNotice']);
    Route::get('/noticeboard', [NoticeBoardController::class, 'createNotice']);
    Route::get('/customer-get-noticeboard', [NoticeBoardController::class, 'customerGetNotice']);
    Route::post('/delete-notice/{id}', [NoticeBoardController::class, 'deleteNotice']);
    Route::post('/update-notice/{id}', [NoticeBoardController::class, 'updateNotice']);
    Route::post('/add-notice', [NoticeBoardController::class, 'addNotice']);

  // place of interest
  Route::post('/add-place-of-interest', [PlaceOfInterestController::class, 'addPlaceOfInterest']);
  Route::get('/get-place-of-interest', [PlaceOfInterestController::class, 'getPlaceOfInterest']);
  Route::get('/get-place-of-interest/{id}', [PlaceOfInterestController::class, 'getPlaceOfInterestSingle']);
  Route::post('/delete-place-of-interest/{id}', [PlaceOfInterestController::class, 'deletePlaceOfInterest']);
  Route::post('/update-place-of-interest/{id}', [PlaceOfInterestController::class, 'updatePlaceOfInterest']);

  // news and events
  Route::post('/add-news-event', [NewsController::class, 'addNewsEvent']);
  Route::get('/get-news', [NewsController::class, 'getNews']);
  Route::get('/get-news/{id}', [NewsController::class, 'getNewsSingle']);
  Route::post('/delete-news/{id}', [NewsController::class, 'deleteNews']);
  Route::post('/update-news/{id}', [NewsController::class, 'updateNews']);

  Route::post('/add-video', [MediaController::class, 'addvideo']);
  Route::post('/delete-video/{id}', [MediaController::class, 'deleteVideo']);

  Route::post('/add-gallery', [MediaController::class, 'addGallery']);
  Route::post('/delete-image/{id}', [MediaController::class, 'deleteImage']);

  Route::get('/get-visitor-data', [AdminController::class, 'getVisitorData']);
  Route::get('/booked', [AdminController::class, 'getBooked']);
  Route::get('/history', [AdminController::class, 'gethistory']);
  Route::get('/refunds', [AdminController::class, 'getRefunds']);
  Route::get('/failed-payments', [AdminController::class, 'getFailedPayments']);
  Route::post('/delete-applicant/{id}', [MembershipController::class, 'deleteApplicant']);

  Route::post('/add-facility', [FacilityController::class, 'addFacility']);
  Route::post('/delete-facility/{id}', [FacilityController::class, 'deleteFacility']);
  Route::get('/get-facility/{id}', [FacilityController::class, 'getFacilitySingle']);
  Route::post('/update-facility/{id}', [FacilityController::class, 'updateFacility']);

  Route::get('/get-membership-applicants', [MembershipController::class, 'membershipApplicants']);

  Route::get('/notice-and-orders', [NoticeController::class, 'getNotice']);
  Route::post('/add-document', [NoticeController::class, 'addDocument']);
  Route::post('/update-document/{id}', [NoticeController::class, 'updateDocument']);
  Route::post('/delete-document/{id}', [NoticeController::class, 'deleteDocument']);

  Route::post('/update-application-status/{id}', [MembershipController::class, 'updateApplicationStatus']);
  Route::get('/item/{id}', [ItemController::class, 'getSingleItem']);
  Route::post('/update-item/{id}', [ItemController::class, 'updateItem']);

  Route::post('/update-booking/{id}', [BookingController::class, 'updateBooking']);
  Route::post('/delete-booking/{id}', [BookingController::class, 'deleteBooking']);
  Route::post('/refund', [PaytmController::class, 'refund']);
  Route::post('/resend-qr', [BookingController::class, 'resendQr']);

  Route::get('/get-settings', [SettingController::class, 'getSettings']);
  Route::post('/update-setting', [SettingController::class, 'updateSetting']);

  Route::post('/add-reserve-date', [ReservedDateController::class, 'addDate']);
  Route::post('/update-reserve-date/{id}', [ReservedDateController::class, 'updateDate']);
  Route::post('/delete-reserve-date/{id}', [ReservedDateController::class, 'deleteDate']);
  Route::get('/get-all-items', [ReservedDateController::class, 'getAllItems']);

  // make reservation
  Route::post('/make-reservation', [BookingController::class, 'createReservation']);
  Route::get('/get-reservations', [BookingController::class, 'getReservations']);
  Route::post('/delete-reservation', [BookingController::class, 'deleteReservation']);
});
Route::get('/get-reserved-dates', [ReservedDateController::class, 'getDates']);
Route::get('/get-reserved-date/{id}', [ReservedDateController::class, 'getDateById']);

Route::get('/get-facilities', [FacilityController::class, 'getFacilities']);
Route::post('/login', [AdminController::class, 'login']);
Route::get('/place-of-interest', [CustomerController::class, 'placeOfInterest']);
Route::get('/guide/{category}', [CustomerController::class, 'getGuideList']);
Route::get('/offers', [CustomerController::class, 'getOffers']);
Route::get('/single-offer/{id}', [CustomerController::class, 'singleOffer']);
Route::post('/apply-membership', [MembershipController::class, 'apply']);

// Paytm
Route::post('/pay', [PaytmController::class, 'payment']);
Route::post('/initiate-payment', [PaytmController::class, 'initiateTransaction']);
Route::post('/response-handler', [PaytmController::class, 'responseHandler']);

Route::get('/get-order-detail/{id}', [CustomerController::class, 'getOrderDetail']);
Route::get('/generate-barcode', [CustomerController::class, 'getBarcode']);
Route::get('/customer-get-news', [CustomerController::class, 'getNews']);
Route::get('/scan-qr-code', [CustomerController::class, 'scanQrCode']);
Route::post('/api-test', [PaytmController::class, 'statusApi']);
Route::post('/refund-status-api', [PaytmController::class, 'refundStatusApi']);
Route::get('/customer-place-of-interest', [CustomerController::class, 'getPlaceOfInterest']);
Route::get('/video', [MediaController::class, 'getVideo']);
Route::get('/gallery', [MediaController::class, 'getGallery']);

Route::get('/send-whatsapp', [MembershipController::class, 'sendWhatsapp']);

Route::post('/message-reply', [CustomerController::class, 'messageReply']);

Route::get('/get-my-booking/{id}', [BookingController::class, 'getMyBooking']);

Route::post('/give-rating', [RatingController::class, 'giveRating']);

Route::get('/get-rating', [RatingController::class, 'averageRating']);

Route::get('/customer-get-downloads', [NoticeController::class, 'customerNotice']);

Route::get('/customer-get-news-page', [NewsController::class, 'customerGetNews']);

Route::get('/check-date', [CustomerController::class, 'checkDate']);

Route::get('/get-notifications', [NewsController::class, 'getNotificationsCount']);

Route::get('/get-crypt', [CustomerController::class, 'getCrypt']);

Route::get('/send-email/{name}/{barcode}/{email}', [CustomerController::class, 'sendEmail']);

Route::get('/user-get-settings', [SettingController::class, 'getUserSettings']);

Route::group(['prefix' => 'v2'], function () {
    Route::get('taxi', [TaxiController::class, 'index']);
    Route::get('tour-guide', [TourGuideController::class, 'index']);
});
