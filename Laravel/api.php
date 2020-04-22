<?php

use Illuminate\Http\Request;
use App\Constants\Feature;
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
Route::middleware('auth:api')->group(function () {
   
    //product type
    Route::prefix('product_type')->group(function () {;
        Route::get('/', 'ProductTypeController@index')->name('product_type.index');
        Route::get('/delete', 'ProductTypeController@queryDelete')->name('product_type.getDelete');
        Route::post('/', 'ProductTypeController@store')->name('product_type.store');
        Route::get('/{id}', 'ProductTypeController@edit')->name('product_type.getEdit');
        Route::delete('/{id}', 'ProductTypeController@delete')->name('product_type.delete');
    });
});


