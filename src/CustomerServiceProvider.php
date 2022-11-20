<?php

namespace Wooturk;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
class CustomerServiceProvider extends ServiceProvider
{
	/**
	 * Register services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Bootstrap services.
	 *
	 * @return void
	 */
	public function boot()
	{
		Route::get('/customer', [UserController::class, 'index'])->name('customer-index');
		Route::group(['middleware' => ['auth:sanctum','wooturk.gateway']], function(){
			Route::post('/customer', [UserController::class, 'post'])->name('customer-create');
			Route::get('/customers', [UserController::class, 'list'])->name('customer-list');
			Route::get('/customer/{id}', [UserController::class, 'get'])->name('customer-get');
			Route::put('/customer/{id}', [UserController::class, 'put'])->name('customer-update');
			Route::delete('/customer/{id}', [UserController::class, 'delete'])->name('customer-delete');
		});
	}
}
