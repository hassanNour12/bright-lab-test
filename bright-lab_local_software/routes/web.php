<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\SyncDataController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\ToppingsController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;

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

Auth::routes(['verify' => true]);


// Authentication  Route
Route::get('/', [LoginController::class, 'showLoginForm'])->name('auth-login');
Route::get('add_new/register', [RegisterController::class, 'showRegistrationForm'])->name('auth-register');

Route::group(['middleware' => ['auth']], function() {
    // customers routes
    Route::get('/customers', [CustomersController::class, 'index'])->name('all-customers');
    Route::get('/customer-add', [CustomersController::class, 'add_new_customer_view'])->name('add-customer-view');
    Route::post('/add-new-customer', [CustomersController::class, 'add_new_customer_data'])->name('add-new-customer');
    Route::get('/view-customer/{customer_id}', [CustomersController::class, 'get_customer_data']);
    Route::get('/edit-customer/{customer_id}', [CustomersController::class, 'edit_customer_view']);
    Route::post('/edit-customer-data', [CustomersController::class, 'edit_customer_data'])->name('edit-customer-data');
    Route::get('/get-all-customers', [CustomersController::class, 'get_all_customers'])->name('get-customers');
    Route::get('/delete-customer/{customer_id}', [CustomersController::class, 'disable_customer']);
    Route::get('/enable-customer/{customer_id}', [CustomersController::class, 'enable_customer']);
    // toppings routes
    Route::get('/toppings', [ToppingsController::class, 'index'])->name('all-toppings');
    Route::post('/add-new-topping', [ToppingsController::class, 'add_new_topping'])->name('add-new-topping');
    Route::post('/edit-topping', [ToppingsController::class, 'edit_topping']);
    Route::get('/delete-topping/{topping_id}', [ToppingsController::class, 'delete_topping']);
    Route::get('/enable-topping/{topping_id}', [ToppingsController::class, 'enable_topping']);
    //orders routes
    Route::get('/orders', [OrdersController::class, 'index'])->name('all-orders');
    Route::get('/add-new-order-view', [OrdersController::class, 'add_new_order_view'])->name('add-order-view');
    Route::post('/add-order', [OrdersController::class, 'add_new_order']);
    Route::get('/view-order/{order_id}', [OrdersController::class, 'view_order']);
    Route::get('/edit-order/{order_id}', [OrdersController::class, 'edit_order_view']);
    Route::post('/update-order', [OrdersController::class, 'update_order']);
    Route::get('/delete-order/{order_id}', [OrdersController::class, 'delete_order']);
    Route::get('/enable-order/{order_id}', [OrdersController::class, 'enable_order']);
    // sync data 
    Route::get('/sync', [SyncDataController::class, 'index'])->name('sync');
    Route::post('/update-online-data', [SyncDataController::class, 'sync'])->name('sync-data');

    Route::get('/send_email/{rows}/{date}',[MailController::class, 'send_email']);
    //Logout Route
    Route::get('/logout', [LogoutController::class, 'performLogout'])->name('logout.perform');
 });

