<?php

use Illuminate\Http\Request;

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

Route::get('/facebook', "HomeController@facebook");
Route::post('/facebook', "HomeController@postFacebook");

Route::resource("order/status", "Service\MstOrderStatusController");

Route::resource("hotel.roomtype", "Service\HotelRoomTypeController");
Route::resource("place.hotel", "Service\PlaceHotelController");
Route::resource("place", "Service\PlaceController");
Route::resource("vnpay_bank", "Service\VNPayBankController");

Route::resource("promotion", "Service\PromotionController");

Route::group(["middleware" => ["auth:api"]], function() {
	Route::resource("user", "Service\UserController");
	Route::resource('partner/order', "Service\Partner\OrderController");
	Route::resource('partner/order.item', "Service\Partner\OrderItemController");
	Route::resource('partner/order.item_bus', "Service\Partner\OrderItemBusController");
	Route::resource("order.history", "Service\OrderHistoryController");

	Route::resource("hotel", "Service\HotelController");
	Route::resource("bus_provider", "Service\BusProviderController");

	Route::resource("order", "Service\OrderController");
	Route::resource("user.device", "Service\UserDeviceController");
});