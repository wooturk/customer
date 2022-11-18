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
		Route::get('/customer', [UserController::class, 'index']);
		Route::post('/customer', [UserController::class, 'post']);
		Route::group(['middleware' => ['auth:sanctum']], function(){
			Route::get('/customers', [UserController::class, 'list']);
			Route::get('/customer/{id}', [UserController::class, 'get']);
			Route::put('/customer/{id}', [UserController::class, 'put']);
			Route::delete('/customer/{id}', [UserController::class, 'delete']);
		});
	}
}
