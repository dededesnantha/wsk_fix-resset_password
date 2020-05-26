<?php	
	
	

	Route::group(['middleware' => ['injection','front_handling']], function () {
		// get
		Route::get('/', 'FrontController@index'); 
		
		Route::post('form/pendaftaransiswa', 'FrontController@mahasiswa_send');
		Route::get('pendaftaransiswa/{key}', 'FrontController@get_mahasiswa');
		Route::get('search', 'FrontController@search');
		Route::get('daftar/ulang', 'FrontController@get_daftar');
		Route::post('daftar/ulang', 'FrontController@login_daftar');
		Route::get('login/mahasiswa/{id}', 'FrontController@get_login');
		Route::get('logout', 'FrontController@logout');
		Route::post('form/mahasiswa/update/{id}', 'FrontController@update_daftar');
		Route::get('pendaftaran/update/berhasil', 'FrontController@success_update');
		Route::get('Rincian/Pembayaran', 'FrontController@view_Pembayaran');

		// Export Excel
		Route::get('mahasiswa/sudah/daftar_ulang/export/{type}/{id}','FrontController@export_mahasiswa');
		Route::get('mahasiswa/belum/daftar_ulang/export/{type}/{id}','FrontController@exports_mahasiswa');

		// resset password
		Route::get('password/reset','FrontController@resetPassword');		
		Route::post('reset_password_without_token', 'AccountsController@validatePasswordRequest');
		Route::get('password_reset/token/{token}', 'AccountsController@resetPassword');
		Route::post('update_password/{token}', 'AccountsController@update_password');
		
    

    });