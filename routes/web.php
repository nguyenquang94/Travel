<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	// return view('welcome');
	return redirect("http://blog.bwhere.vn");
});

Route::get('/facebook', "HomeController@facebook");
Route::get('/facebook/login/{user_id}', "HomeController@login_facebook");
Route::get('/facebook/callback/{user_id}', "HomeController@login_facebook_callback");

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/home', 'HomeController@index');
Route::get('/plist', 'HomeController@show');

Route::group(["prefix" => "lbfbc", "namespace" => "LBFBC"], function() {
	Route::resource("webhook", "WebhookController");
	Route::resource("conversation", "ConversationController");
});

Route::group(["middleware" => ["auth"], "namespace" => "Backend"], function() {
	Route::resource("user", "UserController");
	Route::resource("user.transaction", "UserTransactionController");

	Route::resource("hotel", "HotelController");
	Route::resource("hotel.location", "HotelLocationController");
	Route::resource("hotel.image", "HotelImageController");
	Route::resource("hotel.area", "HotelAreaController");
	Route::resource("hotel.roomtype", "HotelRoomTypeController");
	Route::resource("hotel.room", "HotelRoomController");
	Route::resource("hotel.priceset", "HotelPricesetController");
	Route::resource("hotel.priceset_weekday", "HotelPricesetWeekdayController");
	Route::resource("hotel.priceset_day", "HotelPricesetDayController");
	Route::resource("hotel.manager", "HotelManagerController");

	Route::resource("bus", "BusProviderController");
	Route::resource("bus.type", "BusTypeController");
	Route::resource("bus.priceset", "BusPricesetController");
	Route::resource("bus.trip", "BusTripController");
	Route::resource("bus.ticket", "BusTicketController");
	Route::resource("bus.manager", "BusManagerController");


	Route::get("order/{id}/send_order/mail", "OrderController@getSendOrderMail");
	Route::get("order/{id}/send_order/contact_mail", "OrderController@getSendOrderContactMail");
	Route::get("order/{id}/send_order/lbfbc", "OrderController@getSendOrderLBFBC");
	Route::get("order/{id}/send_payment_method", "OrderController@getSendPaymentMethod");
	Route::get("order/{id}/update_transaction", "OrderController@getUpdateTransaction");

	Route::resource("order", "OrderController");
	Route::resource("order.item", "OrderItemController");
	Route::resource("order.item_bus", "OrderItemBusController");
	Route::resource("order.history", "OrderHistoryController");

	Route::resource("transaction", "TransactionController");

	Route::resource("place/category", "MstPlaceCategoryController");
	Route::resource("place", "PlaceController");
	Route::resource("place.location", "PlaceLocationController");
	Route::resource("place.image", "PlaceImageController");

	Route::resource("schedule", "ScheduleController");
	Route::resource("schedule.point", "SchedulePointController");

	Route::group(["prefix" => "master", "namespace" => "Master"], function() {
		Route::resource("bank", "BankController");
		Route::resource("transaction_category", "TransactionCategoryController");
	});

	Route::group(["prefix" => "system", "namespace" => "System"], function() {
		Route::resource("balance", "BalanceController");
		Route::resource("balance.transaction", "BalanceTransactionController");
		Route::resource("local_transaction", "LocalTransactionController");
	});
});

// Ajax

Route::group(["middleware" => ["auth"], "namespace" => "Ajax", "prefix" => "ajax"], function() {
	Route::resource("user", "UserController");
	Route::resource("user.transaction", "UserTransactionController");
	
	Route::resource("hotel", "HotelController");
	Route::resource("hotel.area", "HotelAreaController");
	Route::resource("hotel.roomtype", "HotelRoomTypeController");
	Route::resource("hotel.room", "HotelRoomController");
	Route::resource("hotel.priceset", "HotelPricesetController");
	Route::resource("hotel.priceset_weekday", "HotelPricesetWeekdayController");
	Route::resource("hotel.priceset_day", "HotelPricesetDayController");
	Route::resource("hotel.manager", "HotelManagerController");
	
	Route::resource("bus", "BusProviderController");
	Route::resource("bus.type", "BusTypeController");
	Route::resource("bus.priceset", "BusPricesetController");
	Route::resource("bus.trip", "BusTripController");
	Route::resource("bus.ticket", "BusTicketController");
	Route::resource("bus.manager", "BusManagerController");
	
	Route::resource("order", "OrderController");
	Route::resource("order.item", "OrderItemController");
	Route::resource("order.item_bus", "OrderItemBusController");
	Route::resource("order.history", "OrderHistoryController");
	Route::resource("order.transaction", "OrderTransactionController");

	Route::resource("transaction", "TransactionController");

	Route::resource("category", "CategoryController");
	Route::resource("place", "PlaceController");
	
	Route::resource("schedule", "ScheduleController");
	Route::resource("schedule.point", "SchedulePointController");
	
	Route::group(["prefix" => "system", "namespace" => "System"], function() {
		Route::resource("balance", "BalanceController");
		Route::resource("balance.transaction", "BalanceTransactionController");
	});
	Route::resource("lbfbc/conversation", "ConversationController");
});

// Payment

Route::group(["middleware" => ["web"], "namespace" => "Payment", "prefix" => "payment"], function() {
	Route::resource("order.vnpay", "OrderPaymentController");
});