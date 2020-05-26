<?php
Route::group(['middleware' => ['jwt.auth']], function () {
    // dashboard count
    Route::get('dashboard','adminController@dashboard');

    
    // tahun ajaran
    Route::post('ajaran_baru','adminController@ajaran_baru');
    Route::get('all_ajaran','adminController@get_all_ajaran');
    Route::get('ajaran_rubah/{id}','adminController@get_rubah_ajaran');
    Route::put('ajaran_update/{id}','adminController@get_update_ajaran');

    // mahasiswa
    Route::get('all_mahasiswa/{id}','adminController@get_all_mahasiswa');
    Route::post('all_mahasiswa','adminController@all_mahasiswa');
    Route::get('view_mahasiswa/{id}','adminController@get_view_mahasiswa');

    Route::get('edit_mahasiswa/{id}','adminController@edit_mahasiswa');
    Route::put('mahasiswa/update/{id}','adminController@update_mahasiswa');
    Route::delete('mahasiswa/{id}','adminController@hapus_mahasiswa');
    Route::get('tahun/{id}','adminController@get_ajaran');
    



    //profile website
    Route::get('profile_website', 'adminController@profile_website');
    Route::put('profile_website', 'adminController@profile_website_update');
    Route::put('profile_website_logo', 'adminController@profile_website_logo');
    Route::put('profile_website_gambar', 'adminController@profile_website_gambar');


    // administrator
    Route::get('administrator', 'adminController@administrator');
    Route::post('administrator', 'adminController@add_administrator');
    Route::get('administrator/{id}', 'adminController@administrator_edit');
    Route::put('administrator/{id}', 'adminController@administrator_update');
    Route::delete('administrator/{id}', 'adminController@delete_administrator');





    //home setting
    Route::get('home_setting','adminController@home_setting');
    Route::put('home_setting/{id}','adminController@home_setting_update');
    Route::put('kategori_setting/{id}','adminController@kategori_setting');
    Route::post('select_product','adminController@select_product');
    Route::post('spesial_produk','adminController@spesial_produk');
    Route::post('spesial_produk_page','adminController@spesial_produk_page');
    Route::delete('special_hapus/{id}','adminController@special_hapus');
    
    Route::post('special_hapus/multi', 'adminController@special_hapus_multi');

    Route::put('setting_active/{id}','adminController@setting_active');
    Route::get('setting_special','adminController@get_special');
    //special
    Route::get('special_offer/up/{id}','adminController@up_special_offer');
    Route::get('special_offer/down/{id}','adminController@down_special_offer');	
    // move
    Route::get('setting_up/{id}','adminController@setting_up');
    Route::get('setting_down/{id}','adminController@setting_down');
    //special oggert
    Route::get('get_kategori_produk','adminController@get_special_kategori');	
    // home setting add custom page
    // Route::get('all_page_custom','adminController@get_page_custom');	
    // Route::post('add_page_custom','adminController@home_setting_add_page');	
    // Route::delete('home_setting/delete/page/{id}','adminController@home_setting_delete');	


    //end widget

    //home setting tag
    Route::post('all_tag', 'adminController@tag');
    Route::get('tag/{id}','adminController@tag_rubah');
    Route::put('tag_update/{id}','adminController@tag_update');
    Route::delete('tag/{id}', 'adminController@hapus_tag');

    //menu
    Route::post('menu','adminController@menu_baru');
    Route::put('menu/{id}','adminController@menu_update');
    Route::get('menu','adminController@get_menu');	
    Route::delete('menu/{id}','adminController@menu_hapus');
    // move
    Route::get('menu_up/{id}','adminController@menu_up');
    Route::get('menu_down/{id}','adminController@menu_down');
    // home setting footer


    // Route::post('set_template','adminController@set_template');	
    Route::post('do/upload/gambar','adminController@upload_to_gambar');
    Route::post('do/upload/galery','adminController@upload_to_galery');
    Route::post('do/upload/media','adminController@upload_to_media');
    
    
});
    Route::get('upgrade_tag_blog', 'SupportController@reload_data_shortcut_blog'); 
    Route::post('upgrade_template','TemplateController@upgrade_template');	
    Route::get('upgrade_admin','TemplateController@upgrade_admin');
    Route::get('informasi_template','TemplateController@informasi_template');
    
    