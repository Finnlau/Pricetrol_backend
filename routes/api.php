<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('getAllStation', [ApiController::class, 'getAllStation']);
Route::get('getNearByStations', [ApiController::class, 'getNearByStations'])->name('getNearByStations');
Route::post('import', [ApiController::class, 'import'])->name('import');
Route::post('update_station_price', [ApiController::class, 'update_station_price'])->name('update_station_price');
Route::get('getStationById', [ApiController::class, 'getStationById'])->name('getStationById');
Route::get('getPriceById', [ApiController::class, 'getPriceById'])->name('getPriceById');
Route::post('addRemoveFavoriteStation', [ApiController::class, 'addRemoveFavoriteStation']);
Route::get('getMyFavoriteStation', [ApiController::class, 'getMyFavoriteStation']);