<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\administrator;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;
use Cookie;

class protectController extends Controller
{
    public function refresh()
    {    
        $token = JWTAuth::getToken();
        return response()->json(['token'=>JWTAuth::refresh($token)], 200);
    }
    
    public function login(Request $request)
    {
        if (!empty($request->input('g-recaptcha-response'))) {

            
                $validator = Validator::make($request->all(), [
                    'username' => 'required|string|max:255',
                    'password'=> 'required'            
                ]);
                if ($validator->fails()) {
                    return response()->json($validator->errors());
                }
                
                $credentials = $request->only('username', 'password');
                try {
                    if (! $token = JWTAuth::attempt($credentials)) {
                        return response()->json(['error' => 'Login Gagal'], 401);
                    }
                } catch (JWTException $e) {
                    return response()->json(['error' => 'Login Gagal'], 500);
                }
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify?secret='.env('CAPCHA_SECRET_KEY').'&response='.$request->input('g-recaptcha-response'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HEADER, 0);                
                $output = curl_exec($ch);            
                curl_close($ch);
                $responseData = json_decode($output);
                if (!$responseData) {
                    $responseData = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.env('CAPCHA_SECRET_KEY').'&response='.$request->input('g-recaptcha-response'));
                    $responseData = json_decode($responseData);                
                }                
                if($responseData->success){
                    Cookie::queue(cookie('to_admin', true, 300));
                    return response()->json(compact('token'));
                }else{
                    return response()->json(['error' => 'reCAPTCHA Time out, Please reSubmit'], 401);                    
                }
        }else{
            return response()->json(['error' => 'Please checked reCAPTCHA'], 401);
        }
    }

    public function handel()
    {
        $fix_folder = [
            ['front'=>[]],
            ['galeri'=>[
                '.htaccess',
                'index.php'
            ]],
            ['gambar' => [
                'sm',
                'thumb',
                '.htaccess',
                'index.php'
            ]],
            ['img' =>[
                'logo.png',
                'noimg.jpg'
            ]],
            ['js' =>[
                ['app' =>[
                    'calendar',
                    'contact',
                    'mail',
                    'map',
                    'music',
                    'note',
                    'weather'
                ]],
                ['controller' =>[
                    'dsh'=>[
                        'blog.js',
                        'dashboard.js',
                        'galleri.js',
                        'page.js',
                        'produk.js',
                        'setting.js',
                        'widget.js'
                    ],
                    'bootstrap.js',
                    'chart.js',
                    'editor.js',
                    'file-upload.js',
                    'form.js',
                    'grid.js',
                    'imgcrop.js',
                    'select.js',
                    'signin.js',
                    'signup.js',
                    'slider.js',
                    'tab.js',
                    'toaster.js',
                    'tree.js',
                    'vectormap.js'
                ]],
                ['directives'=>[
                    'setnganimate.js',
                    'ui-butterbar.j',
                    'ui-focus.j',
                    'ui-fullscreen.j',
                    'ui-jq.j',
                    'ui-module.j',
                    'ui-nav.j',
                    'ui-scroll.j',
                    'ui-shift.j',
                    'ui-toggleclass.j',
                    'ui-validate.js'
                ]],
                ['filters' => [
                    'fromNow.js'
                ]],
                ['services'=>[
                    'ui-load.js'
                ]],
                'app.js',
                'config.js',
                'config.lazyload.js',
                'config.router.js',
                'jquery.tablesorter.js',
                'main.js'
            ]],
            // ['l10n' =>[
            //     'de_DE.js',
            //     'en.js',
            //     'it_IT.js'
            // ]],
            ['source' =>[
                'api',
                'css',
                'fonts'
            ]] ,
            ['template' => [
                '.git',
                'template1',
                'template2',
                '.gitattributes',
                '.gitignore',
                'admindata.json',
                'sitedata.json',
                'template.json'            
            ]],
            ['tpl' => [
                ['blocks' => [
                    'aside.html',
                    'aside.music.html',
                    'header.html',                    
                    'header.music.html',                    
                    'nav.html',                    
                    'page_footer.html',                    
                    'settings.html'                    
                ]],
                ['front' => [
                    ['blog' => [
                        'baru.html',
                        'kategori.html',
                        'kategori_baru.html',
                        'kategori_rubah.html',
                        'modal_clean_content.html',
                        'modal_shortcut.html',
                        'rubah.html',
                        'semua.html'
                    ]],
                    ['galeri' => [
                        'kategori.html',
                        'kategori_baru.html',
                        'kategori_rubah.html',
                        'rubah.html',
                        'semua.html'                        
                    ]],
                    ['page' => [
                        'baru.html',
                        'car_charter_baru.html',
                        'car_charter_rubah.html',
                        'rubah.html',
                        'semua.html'
                    ]],
                    ['produk' => [
                        'baru.html',
                        'kategori.html',
                        'kategori_baru.html',
                        'kategori_rubah.html',
                        'rubah.html',
                        'semua.html'
                    ]],
                    ['setting'=> [
                        'admin.html',
                        'admin_baru.html',
                        'admin_rubah.html',
                        'footer.html',
                        'gambar.html',
                        'home_setting.html',
                        'kontak.html',
                        'kontak_baru.html',
                        'kontak_rubah.html',
                        'layout.html',
                        'logo.html',
                        'menu.html',
                        'menu_tambahan.html',
                        'profile_website.html',
                        'slider.html',
                        'slider_rubah.html',
                        'sosial_media.html',
                        'sosial_media_baru.html',
                        'sosial_media_ikon.html',
                        'sosial_media_rubah.html',
                        'special_offer.html',
                        'tag.html',
                        'tag_rubah.html',
                        'template.html',
                        'webmaster.html',
                    ]],
                    ['widget' => [
                        'all.html',
                        'data_all.html',
                        'data_edit.html',
                        'data_new.html',
                        'edit.html',
                        'label.html',
                        'new.html',
                    ]],
                    'booking_modal.html',
                    'footer.html',
                    'menu_footer.html',
                    'modal.html',
                    'modal_add_page_to_product.html',
                    'modal_add_widget_to_product.html',
                    'setting_navigasi.html',
                    'table.html'
                    
                ]],
                'app.html',
                'app_dashboard_v1.html',
                'page_logout.html',
                'page_signin.html'
            ]],
            // ['vendor' => [
            //     'angular' =>[
            //         ['angular-animate'=>[
            //             'angular-animate.js',
            //             'angular-animate.min.js'
            //         ]],
            //         ['angular-bootstrap'=>[
            //             'ui-bootstrap-tpls.js'
            //         ]],
            //         ['angular-cookies'=>[
            //             'angular-cookies.js',
            //             'angular-cookies.min.js'
            //         ]],
            //         ['angular-resource'=>[
            //             'angular-resource.js',
            //             'angular-resource.min.js'
            //         ]],
            //         ['angular-sanitize'=>[
            //             'angular-sanitize.js',
            //             'angular-sanitize.min.js'
            //         ]],
            //         ['angular-touch'=>[
            //             'angular-touch.js',
            //             'angular-touch.min.js',
            //         ]],
            //         ['angular-translate'=>[
            //             'angular-translate.js',
            //             'loader-static-files.js',
            //             'storage-cookie.js',
            //             'storage-local.js'
            //         ]],
            //         ['angular-ui-router'=>[
            //             'angular-ui-router.js'
            //         ]],
            //         ['angular-ui-utils'=>[
            //             'ui-utils.js'
            //         ]],
            //         ['ngstorage'=>[
            //             'ngStorage.js'
            //         ]],
            //         ['oclazyload'=>[
            //             'ocLazyLoad.js'
            //         ]],
            //         'angular.js',
            //         'angular.min.js'

            //     ],
            //     ['angular-loading'=>[
            //         ['build'=>[
            //             'loading-bar.css',
            //             'loading-bar.js',
            //             'loading-bar.min.css',
            //             'loading-bar.min.js'
            //         ]]
            //     ]],
            //     ['jquery'=>[
            //         ['charts' =>[
            //             ['easypiechart'=>[
            //                 'jquery.easy-pie-chart.js'
            //             ]],
            //             ['flot'=>[
            //                 'jquery.flot.min.js',
            //                 'jquery.flot.orderBars.js',
            //                 'jquery.flot.pie.min.js',
            //                 'jquery.flot.resize.js',
            //                 'jquery.flot.spline.js',
            //                 'jquery.flot.tooltip.min.js'
            //             ]],
            //             ['sparkline'=>[
            //                 'jquery.sparkline.min.js'
            //             ]]
            //         ]],
            //         ['chosen'=>[
            //             'chosen.css',
            //             'chosen.jquery.min.js',
            //             'chosen-sprite.png',
            //             'chosen-sprite@2x.png'
            //         ]],
            //         ['datatables'=>[
            //             'datatable.json',
            //             'dataTables.bootstrap.css',
            //             'dataTables.bootstrap.js',
            //             'jquery.dataTables.min.js'

            //         ]],
            //         ['file'=>[
            //             'bootstrap-filestyle.min.js'
            //         ]],
            //         ['footable'=>[
            //             'fonts'=>[
            //                 'footable.eot',
            //                 'footable.svg',
            //                 'footable.ttf',
            //                 'footable.woff'
            //             ],
            //             'footable.all.min.js',
            //             'footable.core.css'
            //         ]],
            //         ['fullcalendar'=>[
            //             'fullcalendar.css',
            //             'fullcalendar.min.js',
            //             'theme.css'
            //         ]],
            //         ['jvectormap'=>[
            //             'jquery-jvectormap.css',
            //             'jquery-jvectormap.min.js',
            //             'jquery-jvectormap-us-aea-en.js',
            //             'jquery-jvectormap-world-mill-en.js'
            //         ]],
            //         ['nestable'=>[
            //             'jquery.nestable.js',
            //             'nestable.css'
            //         ]],
            //         ['select2'=>[
            //             'select2.css',
            //             'select2.min.js',
            //             'select2.png',
            //             'select2-bootstrap.css',
            //             'select2-spinner.gif',
            //             'select2x2.png'
            //         ]],
            //         ['slider'=>[
            //             'bootstrap-slider.js',
            //             'slider.css'
            //         ]],
            //         ['slimscroll'=>[
            //             'jquery.slimscroll.min.js'
            //         ]],
            //         ['sortable'=>[
            //             'jquery.sortable.js'
            //         ]],
            //         ['spinner'=>[
            //             'jquery.bootstrap-touchspin.css',
            //             'jquery.bootstrap-touchspin.min.js'
            //         ]],
            //         ['tag'=>[
            //             'tag.css',
            //             'tag.js'
            //         ]],
            //         ['wysiwyg'=>[
            //             'bootstrap-wysiwyg.js',
            //             'jquery.hotkeys.js'
            //         ]],
            //         'bootstrap.js',
            //         'jquery.min.js',
            //         'jquery.ui.touch-punch.min.js',
            //         'jquery-ui-1.10.3.custom.min.js'
            //     ]],
            //     ['libs'=>[
            //         'moment.min.js',
            //         'screenfull.min.js'
            //     ]],
            //     ['modules'=>[
            //         ['angular-bootstrap-nav-tree'=>[
            //             'abn_tree.css',
            //             'abn_tree_directive.js'
            //         ]],
            //         ['angular-file-upload'=>[
            //             'angular-file-upload.min.js'
            //         ]],
            //         ['angularjs-toaster'=>[
            //             'toaster.css',
            //             'toaster.js'
            //         ]],
            //         ['angular-slider'=>[
            //             'angular-slider.css',
            //             'angular-slider.js'
            //         ]],
            //         ['angular-ui-calendar'=>[
            //             'calendar.js'
            //         ]],
            //         ['angular-ui-select'=>[
            //             'select.min.css',
            //             'select.min.js'
            //         ]],
            //         ['ng-grid'=>[
            //             'ng-grid.min.css',
            //             'ng-grid.min.js',
            //             'theme.css'
            //         ]],
            //         ['ngImgCrop'=>[
            //             'ng-img-crop.css',
            //             'ng-img-crop.js'
            //         ]],
            //         ['textAngular'=>[
            //             'rangy-core.min.js',
            //             'rangy-selectionsaverestore.min.js',
            //             'table.js',
            //             'textangular.css',
            //             'textAngular.min.js',
            //             'textAngular-rangy.min.js',
            //             'textAngular-sanitize.min.js'
            //         ]],
            //         ['videogular'=>[
            //             ['plugins'=>[
            //                 'buffering.min.js',
            //                 'controls.min.js',
            //                 'ima-ads.min.js',
            //                 'overlay-play.min.js',
            //                 'poster.min.js'
            //             ]],
            //             'videogular.min.js'
            //         ]]
            //     ]],
            //     ['tag'=>[
            //         'bower_components',
            //         'compiled'
            //     ]],
            //     ['tinymce'=>[
            //         ['bower_components'=>[
            //             'angular',
            //             'angular-ui-tinymce',
            //             'tinymce'
            //         ]]
            //     ]]
            // ]],
            '.htaccess',
            'favicon.ico',
            'index.php',
            'robots.txt',
            'web.config',
        ];       
        $now_folder = $this->is_folder(public_path());




        $arr1 = [
            'a',
            'b',
            ['c'=>[
               
                ]
            ]
        ];
        $arr2 = [
            'a',
            'b',
            ['c'=>[
               'e','i' ]
            ],
            'd'];
        $data = $this->comparing([$fix_folder,$now_folder]);
        // $data = $this->comparing([$arr1,$arr2]);
        var_dump(dd($data));
    }
    public function is_folder($folder){
        $scan_folder = array_diff(scandir($folder),['.','..']);
        $data = [];
        foreach($scan_folder as $row){            
            if(is_dir($folder.'/'.$row)){
                $sub_folder = $this->is_folder($folder.'/'.$row);                
                array_push($data,[$row=>$sub_folder]);
            }else{                
                array_push($data,$row);
            }
        }
        return $data;
    }
    
    public function comparing($array)
    {                    
        $data = ['message'=>[
                    'increase' =>[
                        'folder' => [],
                        'file' => []
                    ],
                    'lost' => [
                        'folder' => [],
                        'file' => []
                    ]
                ]];
        $line_array = [0=>[],1=>[]];
        
        $line_array_is_folder = [0=>[],1=>[]];
        for ($i=0; $i < 2; $i++) {
            foreach ($array[$i] as $key) {
                if(is_array($key)){
                    foreach($key as $k => $v){
                        if(is_array($v)){
                            array_push($line_array[$i],$k);
                            array_push($line_array_is_folder[$i],$k );
                        }
                    }
                }else{
                    array_push($line_array[$i],$key);
                }
            }
        }
         
        // foreach($line_array_is_folder[0] as $value){
        //     $check = array_search($value,$line_array[1]);
        //     if($check && $line_array[1][$check] == $value){
        //         $next_fix_folder = array_search($value,$line_array[0]);
        //         $next_now_folder = array_search($value,$line_array[1]);
        //         array_push($data,[$value=>$this->comparing([$array[0][$next_fix_folder],$array[1][$next_now_folder]])]);
        //     }
        // }

        // menghasilkan nilai yang tidak ada di antara 2 array
        foreach($line_array[0] as $index => $value){
            $check = array_search($value,$line_array[1]);
            if(count($line_array[1]) != 0){
            
                if(!$check && $line_array[1][$check] != $value){
                    // folder or file utama hilang
                    if(is_array($array[1][$check])){
                        //folder
                        array_push($data['message']['lost']['folder'] ,$value);
                    }else{
                        array_push($data['message']['lost']['file'] ,$value);
                    }
                }
            }else{                
                if(is_array($array[0][$index])){
                    //folder                    
                    array_push($data['message']['increase']['folder'] ,$value);
                }else{
                    array_push($data['message']['increase']['file'] ,$value);
                }
            }
            
            //
            
            if(is_array($array[0][$index]) ){
                if($line_array[0][$index] == $line_array[1][$check]){
                    
                    $next_fix_folder = [];
                    $next_now_folder = [];
                    if(count($array[0][$index]) != 0){
                        $next_fix_folder = $array[0][$index][$value];
                    }
                    if(count($array[1][$check]) != 0){
                        $next_now_folder = $array[1][$check][$value];
                    }
                    array_push($data,[$value=>$this->comparing([$next_fix_folder,$next_now_folder])]);

                    // echo 'folder selanjutnya = '.$value;
                }
            }
        }

        foreach($line_array[1] as $index => $value){
            $check = array_search($value,$line_array[0]);
            if(count($line_array[0]) != 0){
                if(!$check && $line_array[0][$check] != $value){
                    // folder or file utama bertrambah (terdapat file baru)
                    $check_position_array = array_search($value,$line_array[0]);
                    if(is_array($array[0][$check_position_array])){
                        //folder                    
                        array_push($data['message']['increase']['folder'] ,$value);
                    }else{
                        array_push($data['message']['increase']['file'] ,$value);
                    }
                }
            }else{                
                if(is_array($array[1][$index])){
                    //folder                    
                    array_push($data['message']['increase']['folder'] ,$value);
                }else{
                    array_push($data['message']['increase']['file'] ,$value);
                }
            }
           
        }

        // var_dump(dd($data));        
        return $data;
    }    
}
