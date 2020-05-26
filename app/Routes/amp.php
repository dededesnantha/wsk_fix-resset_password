<?php    
    Route::group(['middleware' => ['injection','front_handling']], function () {
        Route::get('/', 'AMPController@index');
        Route::get('booking.html', 'AMPController@booking');
        Route::get('review.html', 'AMPController@review');
        Route::get('contact.html', 'AMPController@contact');
        Route::get('blog', 'AMPController@list_blog');
        Route::get('blog/category/{slug}', 'AMPController@list_blog');
        Route::get('gallery.html', 'AMPController@list_gallery');
        Route::get('gallery/{slug}', 'AMPController@list_gallery');
        Route::get('category/all', 'AMPController@list_product');
        Route::get('category', 'AMPController@list_product');
        Route::get('category/{slug}', 'AMPController@list_product');
        Route::get('tag/{slug}', 'AMPController@list_tag');
        Route::get('blog/{slug}', 'AMPController@single_blog');
        Route::get('link/{slug}', 'AMPController@single_product');
        Route::get('{slug}', 'AMPController@single_page');
    });