<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\MahasiswaController;
use App\Http\Controllers\API\DosenController;
use App\Http\Controllers\API\MataKuliahController;

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



// Route::post('login', 'AuthController@login');
// Route::group(['prefix' => 'auth', 'middleware' => 'auth:sanctum'], function() {
    
//     // manggil controller sesuai bawaan laravel 8
//     Route::post('logout', [AuthController::class, 'logout']);
//     // manggil controller dengan mengubah namespace di RouteServiceProvider.php biar bisa kayak versi2 sebelumnya
//     Route::post('logoutall', 'AuthController@logoutall');
    
// });

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::resource('mahasiswas', MahasiswaController::class);
    Route::resource('dosens', DosenController::class);
    Route::resource('matakuliahs', MataKuliahController::class);

    // API route for logout user
    Route::post('/logout', [AuthController::class, 'logout']);
});

