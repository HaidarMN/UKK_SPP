<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//JWT
Route::post('login', 'UserController@login');
Route::post('login_siswa', 'LogSisController@login');
Route::post('register_siswa', 'LogSisController@register');
// Route::post('register', 'UserController@register');
Route::get('user', 'UserController@getAuthenticatedUser')->middleware('jwt.verify');

Route::get('kelas', 'KelasController@kelas');
Route::get('/kelas/{id}', 'KelasController@cari_data');

//ADMIN
Route::group(['middleware'=>['jwt.verify:admin']], function() {

    //JWT
    Route::post('register', 'UserController@register');

    //KELAS
    // Route::get('kelas', 'KelasController@kelas');
    Route::post("/insert_kelas", "KelasController@store");
    Route::put("/update_kelas/{id}", "KelasController@update");
    Route::delete("/delete_kelas/{id}", "KelasController@destroy");
    // Route::get('/kelas/{id}', 'KelasController@cari_data');

    //SISWA
    Route::get('siswa', 'SiswaController@siswa');
    Route::post("/insert_siswa", "SiswaController@store");
    Route::put("/update_siswa/{id}", "SiswaController@update");
    Route::delete("/delete_siswa/{id}", "SiswaController@destroy");
    Route::get('/siswa/{id}', 'SiswaController@cari_data');

    //SPP
    Route::get('spp', 'SppController@spp');
    Route::post("/insert_spp", "SppController@store");
    Route::put("/update_spp/{id}", "SppController@update");
    Route::delete("/delete_spp/{id}", "SppController@destroy");
    Route::get('/spp/{id}', 'SppController@cari_data');

    //PETUGAS
    Route::get('petugas', 'PetugasController@petugas');
    Route::post("/insert_petugas", "PetugasController@store");
    Route::put("/update_petugas/{id}", "PetugasController@update");
    Route::delete("/delete_petugas/{id}", "PetugasController@destroy");

    //PEMBAYARAN
    Route::get('pembayaran', 'PembayaranController@pembayaran');
    Route::post("/insert_pembayaran", "PembayaranController@store");
    Route::put("/update_pembayaran/{id}", "PembayaranController@update");
    Route::delete("/delete_pembayaran/{id}", "PembayaranController@destroy");
    Route::get('/pembayaran/{id}', 'PembayaranController@cari_data');

    //Tranksasi
    Route::post('bayar', 'TransaksiController@bayar');

    //USER
    Route::get('user', 'UserController@user');
    Route::delete('/delete_user/{id}', 'UserController@destroy');
    Route::get('/user/{id}', 'UserController@cari_data');
});

//PETUGAS
Route::group(['middleware'=>['jwt.verify:petugas']], function() {
    Route::get('pembayarans', 'PembayaranController@pembayaran');

    Route::post('bayars', 'TransaksiController@bayar');
});

//SISWA
Route::group(['middleware'=>['jwt.verify:siswa']], function() {
    Route::get('/kurang/{id}', 'TransaksiController@kurang');
});