<?php
    use Illuminate\Http\Request;
    use App\Http\Requests;
        
    Route::post('login', 'protectController@login');
       
    Route::group(['middleware' => ['jwt.auth']], function () {        
        Route::get('refresh', 'protectController@refresh');
        Route::get('session', function(){            
            return response()->json(['success'=>true], 200);            
        });
        //blog shortcut get on tayatha
        // Route::post('admin/set_admin','adminController@set_admin');	
        // Route::get('controller/reload_data/shortcut/blog', 'adminController@reload_data_shortcut_blog'); 
    });