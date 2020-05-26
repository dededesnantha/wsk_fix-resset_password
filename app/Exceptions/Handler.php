<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use DB;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    public function main()
    {
        $data['wa'] = '';
        $data['label'] = DB::table('widget_data')->where('widget.name','Widget Label')->join('widget','widget.id','=','widget_data.widget_id')->select('widget_data.name','widget_data.description')->get();
        foreach ($data['label'] as $key) {
            if ($key->description != '') {
                $data['label'][$key->name] = $key->description;
            }else{
                $data['label'][$key->name] = $key->name;
            }
        }
        $data['profile_website'] = DB::table('profile_website')->first();
        $data['color'] = DB::table('template_front')->first()->code_color;
        ///google webmaster        
        $gw = explode(' ',$data['profile_website']->google_webmaster);
        $gw_status = false;
        foreach($gw as $row){
            if($row == "name=google-site-verification"){
                $gw_status = true;
                break;
            }    
        }
        if (!$gw_status) {
            $data['profile_website']->google_webmaster = '';
        }
        //
        //google analistik
        $ga = explode(' ',$data['profile_website']->google_analytics);
        $ga_status = false;
        foreach($ga as $row){
            if($row == "Analytics"){
                $ga_status = true;
                break;
            }    
        }
        if (!$ga_status) {
            $data['profile_website']->google_analytics = '';
        }
        //
        //facebook pixel
        $gw = explode(' ',$data['profile_website']->facebook_pixel);
        $gw_status = false;
        foreach($gw as $row){
            if($row == "Facebook"){
                $gw_status = true;
                break;
            }    
        }
        if (!$gw_status) {
            $data['profile_website']->facebook_pixel = '';
        }        
        //
        //trip advisor
        $gw = explode(' ',$data['profile_website']->tripadvisor);
        $gw_status = false;
        foreach($gw as $row){
            if($row == 'alt="TripAdvisor"' || $row == 'TripAdvisor'){
                $gw_status = true;
                break;
            }    
        }
        if (!$gw_status) {
            $data['profile_website']->tripadvisor = '';
        }      

        
        //
        //map
        $gw = explode(' ',$data['profile_website']->map);
        $gw_status = false;
        foreach($gw as $row){
            if($row == "<iframe"){
                $gw_status = true;
                break;
            }    
        }
        if (!$gw_status) {
            $data['profile_website']->map = '';
        }      

        
        //
        // tawk
        $gw = explode(' ',$data['profile_website']->tawk);
        $gw_status = false;
        foreach($gw as $row){
            if($row == "Tawk.to"){
                $gw_status = true;
                break;
            }    
        }
        if (!$gw_status) {
            $data['profile_website']->tawk = '';
        }      

        $temp = DB::table('menu')->select('id_parent','judul','link','posisi','local_link')->orderBy('posisi','ASC')->get();                
        $data['menu'] = array();
        foreach ($temp as $row) {
            if ($row->local_link == 1 && $row->link != 'kategori') {
                $row->link = url($row->link);
                array_push($data['menu'],$row);                
            }else{
                array_push($data['menu'],$row);
            }
            $data['parent'][$row->id_parent] = DB::table('product')->where('id_kategori','=',$row->id_parent)->where('status','=',1)->get();
        }        
        
        // contact
        $data['contact'] = DB::table('kontak')->select('judul','kontak','gambar','role')->orderBy('id','ASC')->get();  
        $data_contact = array();
        foreach ($data['contact'] as $row) {
            switch ($row->role) {
                case 1:
                    $link = 'mailto:'.$row->kontak;
                    $itemprop = '';
                    break;
                case 2:
                    $link = 'tel:'.$row->kontak;
                    $itemprop = 'itemprop="telephone"';      
                    break;
                case 3:
                    $link = url('contact-wa/'.$row->kontak);
                    $itemprop = 'itemprop="telephone"';      
                    $data['wa'] = $link;
                    break;
                case 4:
                    $link = $row->kontak;
                    $itemprop = '';        
                    break;
                case 5:
                    $link = 'https://story.kakao.com/ch/'.$row->kontak;
                    $itemprop = '';
                    break;
                case 6:
                    $link = 'viber://pa?chatURI='.$row->kontak;
                    $itemprop = '';        
                    break;
                default:
                    $link = '';
                    $itemprop = '';
                    break;
            }
            
            $temp_contact = [
                'title' => $row->judul,
                'img' => asset('gambar').'/'.$row->gambar,
                'link' => $link,
                'id' => $row->kontak,
                'role' => $row->role,
                'itemprop'=> $itemprop,
                'image_null' => $row->gambar == ''
            ];
            array_push($data_contact, $temp_contact);
        }
        $data['contact'] = $data_contact;

        //sosial media  
        $data['social_media'] = DB::table('social_media')->select('judul','link','gambar')->orderBy('id','ASC')->get();
        $data_sosial_media = array();
        foreach ($data['social_media'] as $row) {
            $temp_sosial_media = [
            'title' => $row->judul,
            'img' => asset('gambar').'/'.$row->gambar,
            'link' => $row->link
            ];
            array_push($data_sosial_media, $temp_sosial_media);
        }
        $data['social_media'] = $data_sosial_media;

        // footer
        $data['menu_footer'] = DB::table('menu_footer')->select('judul','link')->orderBy('id','ASC')->get();
        $data['footer_kolom1'] = [];
        $data['footer_kolom2'] = [];
        $data['footer_kolom3'] = [];
        $footer_data = DB::table('footer')->select('posisi','role','judul','id_galeri_kategori')->orderBy('id','ASC')->get();

        for ($i=0; $i < count($footer_data); $i++) {        
            switch ($footer_data[$i]->role) {
                case 1:
                    $footer_data[$i]->template = 'front.footer.sosial_media';
                    break;
                case 2:
                    $footer_data[$i]->template = 'front.footer.kontak';
                    break;
                case 3:
                    $footer_data[$i]->template = 'front.footer.logo';
                    break;
                case 4:
                    $footer_data[$i]->template = 'front.footer.deskripsi';
                    break;
                case 5:
                    $footer_data[$i]->template = 'front.footer.semua_kategori';
                    break;
                case 6:
                    $footer_data[$i]->template = 'front.footer.profile_website';
                    break;
                case 7:
                    $footer_data[$i]->template = 'front.footer.special_offer';
                    break;
                case 8:
                    $footer_data[$i]->template = 'front.footer.menu';
                    break;
                case 9:
                    $footer_data[$i]->template = 'front.footer.gallery';
                    break;
                case 10:
                    $footer_data[$i]->template = 'front.footer.list_category';
                    break;
                case 11:
                    $footer_data[$i]->template = 'front.footer.map';
                    break;
                case 12:
                    $footer_data[$i]->template = 'front.footer.list_blog';
                    break;
                default:
                    $footer_data[$i]->template = null;
                    break;
            }
            array_push($data['footer_kolom'.$footer_data[$i]->posisi], $footer_data[$i]);
                        
            switch ($footer_data[$i]->role) {
                case 5:
                    $data['kategori'] = DB::table('kategori')->get();
                    break;
                case 7:
                    $data['spesial'] = DB::table('special_offer')
                                ->leftjoin('product','product.id','=','special_offer.id_product')
                                ->leftjoin('page','page.id','=','special_offer.id_page')
                                ->orderBy('product.id','DESC')
                                ->select('product.judul as product_judul','product.slug as product_slug',
                                    'page.judul as page_judul','page.slug as page_slug')
                                ->get();
                    break;
                case 9:                        
                        $data['footer_slider'][$footer_data[$i]->id_galeri_kategori] = DB::table('galeri')->where('id_galeri_kategori','=',$footer_data[$i]->id_galeri_kategori)->take(6)->get();
                    break;
                case 10:
                    $data['list_category'][$footer_data[$i]->id_galeri_kategori] = DB::table('product')->where('id_kategori','=',$footer_data[$i]->id_galeri_kategori)->get();
                    break;
                case 12:
                    $data['list_blog_footer'] = DB::table('blog')->select('judul','slug')->orderBy('id')->take(6)->get();
                    break;
                default:
                    
                    break;
            }          
        }
        
        
        return $data;
    }


    public function sidebar()
    {
        $data['blog'] = [];        
        $category = DB::table('kategori')->select('id','judul','slug')->orderBy('judul','ASC')->get();        
        $menu_product = DB::table('product')->select('id_kategori','judul','slug','gambar')->whereIn('id_kategori',array_map(function($n){return $n->id; }, $category))->where('status','=',1)->orderBy('judul','ASC')->get();            

        $data['product'] = [];
        for ($i=0; $i < count($menu_product); $i++) {                     
            if (!array_key_exists(array_map(function($n){return $n->slug; }, $category)[array_search($menu_product[$i]->id_kategori, array_map(function($n){return $n->id; }, $category))], $data['product'])) {
                $data['product'][array_map(function($n){return $n->slug; }, $category)[array_search($menu_product[$i]->id_kategori, array_map(
                    function($n){return $n->id; }, $category))]] = [];
                $data['product'][array_map(function($n){return $n->slug; }, $category)[array_search($menu_product[$i]->id_kategori, array_map(function($n){return $n->id; }, $category))]]['name'] = '';
                $data['product'][array_map(function($n){return $n->slug; }, $category)[array_search($menu_product[$i]->id_kategori, array_map(function($n){return $n->id; }, $category))]]['data'] = [];
            }
            $data['product'][array_map(function($n){return $n->slug; }, $category)[array_search($menu_product[$i]->id_kategori, array_map(function($n){return $n->id; }, $category))]]['name'] = array_map(function($n){return $n->judul; }, $category)[array_search($menu_product[$i]->id_kategori, array_map(function($n){return $n->id; }, $category))];            
            array_push($data['product'][array_map(function($n){return $n->slug; }, $category)[array_search($menu_product[$i]->id_kategori, array_map(function($n){return $n->id; }, $category))]]['data'], $menu_product[$i]);            
        }
        usort($data['product'],function($a,$b){ return strcmp($a['name'], $b['name']); });
        
        return $data;   
    }

    public function render($request, Exception $e)
    {
        // if ($e instanceof ModelNotFoundException) {
        //     $e = new NotFoundHttpException($e->getMessage(), $e);
        // }
        // return parent::render($request, $e);        
        if ($this->isHttpException($e)) {
            $data['main'] = $this->main(); 
            $data['sidebar'] = $this->sidebar();
            switch ($e->getStatusCode()) {
                // not authorized
                case '403':
                    return \Response::view('front.404',$data,403);
                    break;

                // not found
                case '404':
                    return \Response::view('front.404',$data,404);
                    break;

                // internal error
                case '500':
                    return \Response::view('front.404',$data,500);
                    break;

                default:
                    return $this->renderHttpException($e);
                    break;
            }
        } else {
            return parent::render($request, $e);
        }
    }
}
