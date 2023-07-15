<?php

use App\Http\Controllers\orangtuacontroller;
use App\Http\Controllers\Siswacontroller;
use App\Http\Controllers\pelanggarancontroller;
use App\Http\Controllers\getPelanggaranSiswa;
use App\Models\pelanggaran;
use App\Http\Controllers\pelanggaransiswa;
use App\Http\Controllers\userController;
use App\Models\Orangtua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\GetSiswaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\GetOrangtuaController;
use App\Http\Controllers\tampildatapelsiswa;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/userlogin', function (Request $request) {
    return $request->user();
});
Route::resource('/siswa', Siswacontroller::class);
Route::resource('/pelanggaran', pelanggarancontroller::class);
Route::resource('/psiswa', pelanggaransiswa::class);
Route::get('/byorangtua/{id}', [pelanggaransiswa::class, 'getPelSiswaOrtu']);
Route::resource('/orangtua', orangtuacontroller::class);
Route::post('/sendwhatsapp', [App\Http\Controllers\API\ApiController::class, 'postapi']);
Route::get('/logout', [LoginController::class, 'logout']);
Route::post('/login', [LoginController::class, 'index']);
Route::post('/loginadmin', [LoginController::class, 'loginadmin']);
Route::get('get-master-product-paging',  [ProductController::class, 'get_product_paging']);
Route::get('/getDataSiswa', [GetSiswaController::class, 'getSiswaPage']);
Route::get('getDataOrangtua', [GetOrangtuaController::class, 'getOrtu']);
Route::get('getDataPelanggaranSiswa', [getPelanggaranSiswa::class, 'getPelSiswaPage']);
Route::get('GetDataPelanggaransiswa/{id}', [tampildatapelsiswa::class, 'getData']);
Route::get('getSiswaid/{id}', [tampildatapelsiswa::class, 'getsiswapage']);
Route::resource('/user', userController::class);

//Route::get('/pelanggaransiswa', [pelanggaransiswa::class, 'index']);