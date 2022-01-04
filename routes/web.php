<?php

use App\Mail\OrderShippedMail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return view('newhome');
});
Auth::routes();


Route::get('/admin-login', 'Auth\LoginController@showLoginForm');



Route::get('/home', 'HomeController@index')->name('home');
Route::any('/view-shipment/{slug?}', 'AdminController@fullShipment')->name('find-shipment');
Route::any('/set-limit', 'AdminController@getQty');
// Backend
Route::group(['middleware' => ['auth', 'admin']], function () {
Route::get('/manage-shipment', 'AdminController@dashboard');

Route::post('/status-update', 'AdminController@updateStatus')->name('status-update');
Route::get('/view-shipment/{slug}', 'AdminController@viewShipment');
Route::any('/search-shipment', 'AdminController@findShipment');
Route::get('/create-shipment', 'AdminController@createShipment');
Route::post('/store-shipment', 'AdminController@storeShipment')->name('store-shipment');
Route::get('/edit-shipment/{slug}', 'AdminController@editShipment');
Route::post('/update-shipment', 'AdminController@updateShipment')->name('update-shipment');
Route::get('/delete-shipment/{slug}', 'AdminController@deleteShipment');


// Shipper Start
Route::get('/manage-shipper', 'AdminController@viewShipper');
Route::post('/search-shipper', 'AdminController@findShipper');

Route::get('/create-shipper', 'AdminController@createShipper');

Route::post('/store-shipper', 'AdminController@storeShipper')->name('store-shipper');
Route::get('/edit-shipper/{slug}', 'AdminController@editShipper');
Route::post('/update-shipper', 'AdminController@updateShipper')->name('update-shipper');
Route::get('/delete-shipper/{slug}', 'AdminController@deleteShipper');

// Shipper end
Route::get('/manage-admin', 'AdminController@viewAdmin');
Route::get('/delete-admin/{slug}', 'AdminController@deleteAdmin');
Route::get('/edit-admin/{slug}', 'AdminController@editAdmin');
Route::post('/update-admin', 'AdminController@updateAdmin')->name('update-admin');


// Import File
Route::get('/import-csv', 'ShipmentController@index');
Route::post('/shipment-import', 'ShipmentController@store')->name('shipment-import');

// Import CSV Update
Route::get('/import-csv-update', 'ShipmentController@importUpdatePage');
Route::post('/import-csv-update', 'ShipmentController@importUpdate')->name('shipment-import-update');


// new route

Route::get('/delivery-note/{slug}', 'AdminController@deliveryNote');

Route::get('/download-file', 'ShipmentController@downloadSample');
Route::post('/bulk-data', 'AdminController@bulkData')->name('bulk-data');

// Bulk Status Update
// Route::post('/bulk-status-update', 'AdminController@bulkStatusUpdate');

// Admin Driver Manage
Route::get('/manage-driver', 'AdminController@viewDriver');
Route::get('/create-driver', 'AdminController@createDriver');
Route::post('/store-driver', 'AdminController@storeDriver')->name('store-driver');
Route::get('/edit-driver/{id}', 'AdminController@editDriver');
Route::post('/update-driver', 'AdminController@updateDriver')->name('update-driver');
Route::post('/update-assign-driver', 'AdminController@updateAssignDriver')->name('update-assign-driver');

});

// Export File
Route::get('/export-csv', 'ShipmentController@export');

// For Driver
Route::group(['middleware' => ['auth', 'driver']], function () {

Route::get('/driver/manage-shipment', 'DriverController@index')->name('manage.shipment');
// Route::get('/driver/update-shipment', 'DriverController@updateShipment');
Route::get('/driver/edit-shipment-status/{uid}', 'DriverController@editShipment');
Route::post('/driver/update-shipment', 'DriverController@updateShipment')->name('driver-update-shipment');
Route::get('/driver/attachment-download/{slug}', 'DriverController@downloadAttachment');
});

Route::get('/delivery-note/{slug}', 'AdminController@deliveryNote');


Route::get('/command', function () {
	
	/* php artisan migrate */
    \Artisan::call('config:clear');
    dd("Done");
});

// Route::get('/driver-logout', function () {
//     Auth::logout();

// });


Route::get('/email', function(){

return new OrderShippedMail();
});