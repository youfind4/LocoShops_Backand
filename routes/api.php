<?php
/**
 * File name: api.php
 * Last modified: 2020.04.30 at 08:21:08
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

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

Route::prefix('driver')->group(function () {
    Route::post('login', 'API\Driver\UserAPIController@login');
    Route::post('register', 'API\Driver\UserAPIController@register');
    Route::post('send_reset_link_email', 'API\UserAPIController@sendResetLinkEmail');
    Route::get('user', 'API\Driver\UserAPIController@user');
    Route::get('logout', 'API\Driver\UserAPIController@logout');
    Route::get('settings', 'API\Driver\UserAPIController@settings');
});


Route::post('login', 'API\UserAPIController@login');
Route::post('register', 'API\UserAPIController@register');
Route::post('send_reset_link_email', 'API\UserAPIController@sendResetLinkEmail');
Route::get('user', 'API\UserAPIController@user');
Route::get('logout', 'API\UserAPIController@logout');
Route::get('settings', 'API\UserAPIController@settings');

Route::resource('fields', 'API\FieldAPIController');
Route::resource('categories', 'API\CategoryAPIController');
Route::resource('markets', 'API\MarketAPIController');
Route::get('paymentgateways','API\PaymentGatewaysAPIController@index');
Route::resource('faq_categories', 'API\FaqCategoryAPIController');
Route::get('products/categories', 'API\ProductAPIController@categories');
Route::resource('products', 'API\ProductAPIController');
Route::resource('galleries', 'API\GalleryAPIController');
Route::resource('product_reviews', 'API\ProductReviewAPIController');


Route::resource('faqs', 'API\FaqAPIController');
Route::resource('market_reviews', 'API\MarketReviewAPIController');
Route::resource('currencies', 'API\CurrencyAPIController');

Route::resource('option_groups', 'API\OptionGroupAPIController');

Route::resource('options', 'API\OptionAPIController');
Route::get('manager_market_driv','API\Manager\ManagerAppDriversAPIController@market_driver');
Route::get('manager_drivers_list','API\Manager\ManagerAppDriversAPIController@index');
Route::post('manager_profile_update','API\Manager\ManagerAppUserProfileAPIController@update');

Route::post('manager_notification','API\OrderAPIController@sendPushNotification');
Route::post('manager_notification_token','API\Manager\ManagerAppLoginManagerAPIController@notification_token');
Route::post('manager_login','API\Manager\ManagerAppLoginManagerAPIController@login');
Route::post('manager_signup','API\Manager\ManagerAppLoginManagerAPIController@register');
Route::get('manager_drivers','API\Manager\ManagerAppMarketPayoutsAPIController@getdrivers');
Route::get('manager_profile','API\Manager\ManagerAppUserProfileAPIController@index');
Route::get('manager_orders_pending','API\Manager\ManagerAppOrdersAPIController@total_orders_pending');
Route::get('manager_orders_recieved','API\Manager\ManagerAppOrdersAPIController@total_orders_recieved');
Route::get('manager_orders_completed','API\Manager\ManagerAppOrdersAPIController@total_orders_completed');

Route::get('manager_payments','API\Manager\ManagerAppMarketPayoutsAPIController@getPayments');
Route::get('manager_galleries','API\Manager\ManagerAppGalleriesAPIController@index');
Route::get('manager_market_reviews','API\Manager\ManagerAppMarketReviewsAPIController@index');
Route::get('manager_markets','API\Manager\ManagerAppMarketsAPIController@index');
Route::get('manager_faqs','API\Manager\ManagerAppFaqAPIController@index');
Route::get('manager_favorites','API\Manager\ManagerAppFavoritesAPIController@index');
Route::get('manager_order_status','API\Manager\ManagerAppOrdersStatusesAPIController@index');
Route::get('manager_product_reviews','API\Manager\ManagerAppProductReviewsAPIController@index');
Route::get('manager_product_options','API\Manager\ManagerAppProductOptionsAPIController@index');
Route::get('manager_products','API\Manager\ManagerAppProductsAPIController@index');
Route::post('manager_favorites_delete','API\Manager\ManagerAppFavoritesAPIController@delete');
Route::post('manager_market_create','API\Manager\ManagerAppMarketsAPIController@create_market');
Route::post('manager_market_update','API\Manager\ManagerAppMarketsAPIController@update');
Route::post('manager_market_reviews_update','API\Manager\ManagerAppMarketReviewsAPIController@update');
Route::post('manager_product_reviews_update','API\Manager\ManagerAppProductReviewsAPIController@update');
Route::get('manager_userslist','API\Manager\ManagerAppMarketReviewsAPIController@fetchuserslist');
Route::get('manager_market_list','API\Manager\ManagerAppMarketReviewsAPIController@fetchmarketslist');
Route::post('manager_product_insert','API\Manager\ManagerAppProductsAPIController@insertproduct');
Route::post('manager_option_group_insert','API\Manager\ManagerAppProductsAPIController@option_groups');
Route::get('manager_categories','API\Manager\ManagerAppProductsAPIController@list_catageries');
Route::get('manager_earnings','API\Manager\ManagerAppEarningsAPIController@index');
Route::get('manager_market_payouts','API\Manager\ManagerAppMarketPayoutsAPIController@index');
Route::post('manager_create_payout','API\Manager\ManagerAppMarketPayoutsAPIController@insert_payout');
Route::get('manager_orders','API\Manager\ManagerAppOrdersAPIController@index');
Route::post('manager_orders_delete','API\ManagerAppOrdersAPIController@delete');
Route::post('manager_options_create','API\Manager\ManagerAppProductOptionsAPIController@create_option');
Route::post('manager_options_update','API\Manager\ManagerAppProductOptionsAPIController@update');
Route::post('manager_options_delete','API\Manager\ManagerAppProductOptionsAPIController@delete');
Route::post('manager_order_status_update','API\Manager\ManagerAppOrdersAPIController@order_update');
Route::post('manager_orders_delete','API\Manager\ManagerAppOrdersAPIController@delete');
Route::post('manager_products_delete','API\Manager\ManagerAppProductsAPIController@delete');
Route::post('manager_app_product_update','API\Manager\ManagerAppProductsAPIController@update_product');
Route::post('manager_app_market_delete','API\Manager\ManagerAppMarketsAPIController@delete');

Route::middleware('auth:api')->group(function () {
    Route::group(['middleware' => ['role:driver']], function () {
        Route::prefix('driver')->group(function () {
            Route::resource('orders', 'API\OrderAPIController');
            Route::resource('notifications', 'API\NotificationAPIController');
            Route::post('users/{id}', 'API\UserAPIController@update');
            Route::resource('faq_categories', 'API\FaqCategoryAPIController');
            Route::resource('faqs', 'API\FaqAPIController');
        });
    });
    Route::group(['middleware' => ['role:manager']], function () {
        Route::prefix('manager')->group(function () {
            
            Route::resource('drivers', 'API\DriverAPIController');

            Route::resource('earnings', 'API\EarningAPIController');

            Route::resource('driversPayouts', 'API\DriversPayoutAPIController');

            Route::resource('marketsPayouts', 'API\MarketsPayoutAPIController');
        });
    });
    Route::post('users/{id}', 'API\UserAPIController@update');

    Route::resource('order_statuses', 'API\OrderStatusAPIController');

    Route::get('payments/byMonth', 'API\PaymentAPIController@byMonth')->name('payments.byMonth');
    Route::resource('payments', 'API\PaymentAPIController');

    Route::get('favorites/exist', 'API\FavoriteAPIController@exist');
    Route::resource('favorites', 'API\FavoriteAPIController');

    Route::resource('orders', 'API\OrderAPIController');

    Route::resource('product_orders', 'API\ProductOrderAPIController');

    Route::resource('notifications', 'API\NotificationAPIController');

    Route::get('carts/count', 'API\CartAPIController@count')->name('carts.count');
    Route::resource('carts', 'API\CartAPIController');

    Route::resource('delivery_addresses', 'API\DeliveryAddressAPIController');

    
});