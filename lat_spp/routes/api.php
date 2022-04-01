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
// Route::post('register_siswa', 'UserController@regsis');
// Route::post('register', 'UserController@register');
// Route::get('/login/check', 'UserController@getAuthenticatedUser')->middleware('jwt.verify');

// Route::get('kelas', 'KelasController@kelas');
// Route::get('/kelas/{id}', 'KelasController@cari_data');
// Route::post("/insert_kelas", "KelasController@store");
// Route::put("/update_kelas/{id}", "KelasController@update");
// Route::delete("/delete_kelas/{id}", "KelasController@destroy");
// Route::get('/getkelas/{id}', 'KelasController@getdetail');

// Route::get('/pembayaranss/{id}', 'PembayaranController@getnisn');

// ALL
Route::group(['middleware'=>['jwt.verify:admin,petugas,siswa']], function() {
    Route::get('/login/check', 'UserController@getAuthenticatedUser');
    Route::get('user', 'UserController@user');
    Route::get('siswa', 'SiswaController@siswa');
});

// ADMIN & PETUGAS
Route::group(['middleware'=>['jwt.verify:admin,petugas']], function() {
    // REPORT
    Route::post('report', 'TransaksiController@report');

    // BAYAR
    Route::post('bayar', 'PembayaranController@store');

    // SPP
    Route::get('spp', 'SppController@spp');
});

// ADMIN
Route::group(['middleware'=>['jwt.verify:admin']], function() {

    // JWT
    Route::post('register', 'UserController@register');
    Route::post('register_siswa', 'UserController@regsis');
    
    // KELAS
    Route::get('kelas', 'KelasController@kelas');
    Route::post("/insert_kelas", "KelasController@store");
    Route::put("/update_kelas/{id}", "KelasController@update");
    Route::delete("/delete_kelas/{id}", "KelasController@destroy");
    Route::get('/kelas/{id}', 'KelasController@cari_data');
    Route::get('/getkelas/{id}', 'KelasController@getdetail');
    Route::get('/totalkelas', 'KelasController@total');

    // SISWA
    Route::post("/insert_siswa", "SiswaController@store");
    Route::put("/update_siswa/{id}", "SiswaController@update");
    Route::delete("/delete_siswa/{id}", "SiswaController@destroy");
    Route::get('/siswa/{id}', 'SiswaController@cari_data');
    Route::get('/getsiswa/{id}', 'SiswaController@getdetail');
    Route::get('/totalsiswa', 'SiswaController@total');

    // SPP
    // Route::get('spp', 'SppController@spp');
    Route::post("/insert_spp", "SppController@store");
    Route::put("/update_spp/{id}", "SppController@update");
    Route::delete("/delete_spp/{id}", "SppController@destroy");
    Route::get('/spp/{id}', 'SppController@cari_data');
    Route::get('/getspp/{id}', 'SppController@getdetail');

    // PETUGAS
    Route::get('petugas', 'PetugasController@petugas');
    Route::post("/insert_petugas", "PetugasController@store");
    Route::put("/update_petugas/{id}", "PetugasController@update");
    Route::delete("/delete_petugas/{id}", "PetugasController@destroy");
    Route::get('/petugas/{id}', 'PetugasController@cari_data');
    Route::get('/getpetugas/{id}', 'PetugasController@getdetail');
    Route::get('/totalpetugas', 'PetugasController@total');

    // PEMBAYARAN
    Route::get('pembayaran', 'PembayaranController@pembayaran');
    Route::post("/insert_pembayaran", "PembayaranController@store");
    Route::put("/update_pembayaran/{id}", "PembayaranController@update");
    Route::delete("/delete_pembayaran/{id}", "PembayaranController@destroy");
    Route::get('/pembayaran/{id}', 'PembayaranController@cari_data');
    Route::get('/getpembayaran/{id}', 'PembayaranController@getdetail');
    Route::get('/latest', 'PembayaranController@last');

    // Tranksasi
    // Route::post('bayar', 'TransaksiController@bayar');
    Route::get('/kurang/{id}', 'TransaksiController@kurang');

    // USER
    Route::put("/update_user/{id}", "UserController@update");
    Route::delete('/delpet/{id}', 'UserController@delpet');
    Route::delete('/delsis/{id}', 'UserController@delsis');
    Route::get('/user/{id}', 'UserController@cari_data');
    Route::get('/getuser/{id}', 'UserController@getdetail');
    Route::get('/getusersis/{id}', 'UserController@getdetailsis');
});

// PETUGAS
Route::group(['middleware'=>['jwt.verify:petugas']], function() {
    Route::get('pembayarans', 'PembayaranController@pembayaran');

    // Route::post('bayars', 'TransaksiController@bayar');
});

// SISWA
Route::group(['middleware'=>['jwt.verify:siswa']], function() {
    Route::get('/kurang/{id}', 'TransaksiController@kurang');
    Route::get('/pembayaranss/{id}', 'PembayaranController@getnisn');
});