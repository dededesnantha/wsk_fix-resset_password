<?php
    Route::get('gambar/{size}/{image}','SupportController@ImageGetCrop');
    Route::get('galeri/{size}/{image}','SupportController@ImageGetCrop');
    Route::get('media/{size}/{image}','SupportController@ImageGetCrop');

    Route::get('gambar/{size}','SupportController@ImageGetCrop');
    Route::get('galeri/{size}','SupportController@ImageGetCrop');
    Route::get('media/{size}','SupportController@ImageGetCrop');