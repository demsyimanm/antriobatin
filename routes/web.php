<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/','HomeController@login');
Route::get('login', function () {
    return redirect('/');
});


Route::post('login','HomeController@login');
Route::post('register','HomeController@register');

/*API*/
Route::post('api/login','HomeController@loginApi');
Route::post('api/register','HomeController@registerApi');

Route::group(['middleware' => 'auth'], function()
{
	Route::get('admin','HomeController@admin');
	Route::get('pasien','HomeController@pasien');
	Route::get('dokter','HomeController@dokter');
	Route::get('apotek','HomeController@apotek');

	/*DOKTER*/
		/*RESEP*/
			Route::get('dokter/resep','DokterController@home');
			Route::get('dokter/resep/create','DokterController@create');
			Route::post('dokter/resep/create','DokterController@create');
			Route::get('dokter/resep/update/{id}','DokterController@update');
			Route::post('dokter/resep/update/{id}','DokterController@update');
			Route::get('dokter/resep/delete/{id}','DokterController@destroy');
		/*RIWAYAT*/
			Route::get('dokter/riwayat','DokterController@homeRiwayat');
			Route::get('dokter/riwayat/create','DokterController@createRiwayat');
			Route::post('dokter/riwayat/create','DokterController@createRiwayat');
			Route::get('dokter/riwayat/update/{id}','DokterController@updateRiwayat');
			Route::post('dokter/riwayat/update/{id}','DokterController@updateRiwayat');
			Route::get('dokter/riwayat/delete/{id}','DokterController@destroyRiwayat');

	/*PASIEN*/
		/*RESEP*/
			Route::get('pasien/resep','PasienController@home');
			Route::get('pasien/resep/finished','PasienController@finished');
			Route::get('pasien/history','PasienController@history');

	/*APOTEK*/
		/*RESEP*/
			Route::get('apotek/resep','ApotekController@home');
			Route::get('apotek/resep/terima/{id}','ApotekController@terima');
			Route::post('apotek/resep/terima/{id}','ApotekController@terima');
			Route::get('apotek/racik','ApotekController@racik');
			Route::get('apotek/resep/selesai/{id}','ApotekController@selesai');
			Route::get('apotek/selesai','ApotekController@bisaDiambil');
			Route::get('apotek/resep/diambil/{id}','ApotekController@sudahDiambil');
			Route::get('apotek/taken','ApotekController@takenList');

	Route::get('logout','HomeController@logout');	



});

/*API*/
	/*Route::get('api/admin','HomeController@adminApi');
	Route::get('api/pasien','HomeController@pasienApi');
	Route::get('api/dokter','HomeController@dokterApi');
	Route::get('api/apotek','HomeController@apotekApi');*/
	Route::post('api/sendToken/{token}','HomeController@sendToken');
	/*DOKTER*/
		/*RESEP*/ /*SELESAI*/
			Route::get('api/dokter/resep/{token}','DokterController@homeApi');
			Route::get('api/dokter/resep/create/{token}','DokterController@createApi');
			Route::post('api/dokter/resep/create/{token}','DokterController@createApi');
			Route::get('api/dokter/resep/update/{id}/{token}','DokterController@updateApi');
			Route::post('api/dokter/resep/update/{id}/{token}','DokterController@updateApi');
			Route::get('api/dokter/resep/delete/{id}/{token}','DokterController@destroyApi');
		/*RIWAYAT*/
			//Route::get('api/dokter/riwayat','DokterController@homeRiwayatApi');
			Route::post('api/dokter/riwayat/{token}','DokterController@homeRiwayatApi');
			//Route::get('api/dokter/riwayat/create/{token}','DokterController@createRiwayatApi');
			Route::post('api/dokter/riwayat/create/{token}','DokterController@createRiwayatApi');
			Route::get('api/dokter/riwayat/update/{id}/{token}','DokterController@updateRiwayatApi');
			Route::post('api/dokter/riwayat/update/{id}/{token}','DokterController@updateRiwayatApi');
			Route::get('api/dokter/riwayat/delete/{id}/{token}','DokterController@destroyRiwayatApi');

	/*PASIEN*/ /*SELESAI*/
		/*RESEP*/
			Route::get('api/pasien/resep/{token}','PasienController@homeApi');
			Route::get('api/pasien/resep/{id}/{token}','PasienController@homeApiById');
			Route::get('api/pasien/resep/finished/{token}','PasienController@finishedApi');
			Route::get('api/pasien/history/{token}','PasienController@historyApi');
			Route::get('api/pasien/history/{id}/{token}','PasienController@historyByIdApi');

	/*APOTEK*/ /*SELESAI*/
		/*RESEP*/
			Route::get('api/apotek/resep/{token}','ApotekController@homeApi');
			Route::get('webview/apotek/resep/{token}','ApotekController@homeApiWebView');
			
			Route::get('api/apotek/resep/terima/{id}/{token}','ApotekController@terimaApi');
			Route::get('webview/apotek/resep/terima/{id}/{token}','ApotekController@terimaApiWebView');

			Route::post('api/apotek/resep/terima/{id}/{token}','ApotekController@terimaApi');
			Route::post('webview/apotek/resep/terima/{id}/{token}','ApotekController@terimaApiWebView');

			Route::get('api/apotek/racik/{token}','ApotekController@racikApi');
			Route::get('webview/apotek/racik/{token}','ApotekController@racikApiWebView');

			Route::get('api/apotek/resep/selesai/{id}/{token}','ApotekController@selesaiApi');
			Route::get('webview/apotek/resep/selesai/{id}/{token}','ApotekController@selesaiApiWebView');

			Route::get('api/apotek/selesai/{token}','ApotekController@bisaDiambilApi');
			Route::get('webview/apotek/selesai/{token}','ApotekController@bisaDiambilApiWebView');

			Route::get('api/apotek/resep/diambil/{id}/{token}','ApotekController@sudahDiambilApi');
			Route::get('webview/apotek/resep/diambil/{id}/{token}','ApotekController@sudahDiambilApiWebView');
			
			Route::get('api/apotek/taken/{token}','ApotekController@takenListApi');
			Route::get('webview/apotek/taken/{token}','ApotekController@takenListApiWebView');

	Route::get('api/logout/{token}','HomeController@logoutApi');

	Route::get('coba','DokterController@cek');	