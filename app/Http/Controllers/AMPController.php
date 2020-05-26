<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;

class AMPController extends Controller
{
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
        $data['menu'] = DB::table('menu')->select('id_parent','judul','link','posisi')->orderBy('posisi','ASC')->get();        
        foreach ($data['menu'] as $row) {
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
                'img' => asset('image').'/'.$row->gambar,
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
            'img' => asset('image').'/'.$row->gambar,
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
                    $footer_data[$i]->template = 'front.amp.footer.sosial_media';
                    break;
                case 2:
                    $footer_data[$i]->template = 'front.amp.footer.kontak';
                    break;
                case 3:
                    $footer_data[$i]->template = 'front.amp.footer.logo';
                    break;
                case 4:
                    $footer_data[$i]->template = 'front.amp.footer.deskripsi';
                    break;
                case 5:
                    $footer_data[$i]->template = 'front.amp.footer.semua_kategori';
                    break;
                case 6:
                    $footer_data[$i]->template = 'front.amp.footer.profile_website';
                    break;
                case 7:
                    $footer_data[$i]->template = 'front.amp.footer.special_offer';
                    break;
                case 8:
                    $footer_data[$i]->template = 'front.amp.footer.menu';
                    break;
                case 9:
                    $footer_data[$i]->template = null;
                    break;
                case 10:
                    $footer_data[$i]->template = 'front.amp.footer.list_category';
                    break;
                case 11:
                    $footer_data[$i]->template = 'front.amp.footer.map';
                    break;
                case 12:
                    $footer_data[$i]->template = 'front.amp.footer.list_blog';
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

    public function single_product($param='')
    {
        if ($param == '') {
            return redirect('/');
        }else{
            $data['main'] = $this->main();
            $data['single'] = DB::table('product')
                            ->join('kategori','product.id_kategori','=','kategori.id')
                            ->select('kategori.id as id_cat','product.id','product.view','product.judul','product.gambar','product.deskripsi','kategori.judul as judul_cat','product.seo_judul','product.seo_kata_kunci','product.seo_deskripsi','product.slug','kategori.slug as slug_cat','product.updated_at','product.created_at','product.price')
                            ->where('product.slug','=',$param)
                            ->where('product.status','=',1)
                            ->first();            
            if (!empty($data['single'])) {
                $data['single']->price = number_format($data['single']->price,2,",",".");
                $data['single']->detail_updated_at = str_replace(' ', 'T', date("Y-m-d h:m:sP", strtotime($data['single']->updated_at)));
                $data['single']->detail_created_at = str_replace(' ', 'T', date("Y-m-d h:m:sP", strtotime($data['single']->created_at)));
                $data['tag'] = DB::table('all_tag')
                                ->join('tag','all_tag.id_tag','=','tag.id')
                                ->select('tag.judul','tag.slug')
                                ->where('all_tag.id_product','=',$data['single']->id)
                                ->orderBy('tag.judul','ASC')
                                ->get();
            
                $data['related']= DB::table('product')->select('judul','gambar','slug')->where('id_kategori','=',$data['single']->id_cat)->where('id','!=',$data['single']->id)->where('status','=',1)->take(3)->orderBy('id','DESC')->get();
                $data['review'] = DB::table('product_review')
                                ->join('product','product.id','=','product_review.id_product')
                                ->select(DB::raw('SUM(product_review.count) as review_total'),DB::raw('count(*) as review_count'))
                                ->where('product.slug',$param)
                                ->get();

                if (!$data['review'][0]->review_total) {
                    $data['review'] = $this->null_review('tour',$param);
                }                    

                $data['list_page'] = DB::table('list_page_on_product')
                                    ->join('page','list_page_on_product.page_id','=','page.id')
                                    ->where('list_page_on_product.product_id',$data['single']->id)
                                    ->where('page.status',1)
                                    ->select('page.judul','page.slug','page.gambar',DB::raw('LEFT(page.deskripsi,200) as deskripsi'))
                                    ->get();
                $data['widget'] = DB::table('product_widget')
                                    ->select('widget.name','widget_data.description')
                                    ->join('widget_data','product_widget.widget_data_id','=','widget_data.id')
                                    ->join('widget','widget_data.widget_id','=','widget.id')
                                    ->where('product_widget.product_id',$data['single']->id)
                                    ->get();
            }else{
                return abort(404);
            }

            $optiomation = array();
            $optiomation['main_title'] = null;
            $optiomation['title'] = null;
            $optiomation['keyword'] = null;
            $optiomation['description'] = null;
            $optiomation['image'] = null;  
            $optiomation['author'] = ucwords(str_replace('https://www.','', url('')));
            $optiomation['sitename'] = strtoupper(explode('.',str_replace('https://www.','', url('')))[0]);            
            $optiomation['single_optiomation'] = array(
                'tag' => $data['tag'],
                'judul_cat' => $data['single']->judul_cat,
                'created_at' => $data['single']->created_at,
                'updated_at' => $data['single']->updated_at
            );              

            if (!empty($data['single'])){

                $optiomation['main_title'] = $data['single']->judul;
                // title
                if(trim($data['single']->seo_judul) != ''){
                    $optiomation['title'] = $data['single']->seo_judul;
                }else{
                    $optiomation['title'] = $data['single']->judul;
                }          
                //description
                if(trim($data['single']->seo_deskripsi) != ''){
                    $optiomation['description'] = substr(strip_tags($data['single']->seo_deskripsi), 0,320) ;
                }else{
                    $optiomation['description'] = substr(strip_tags($data['single']->deskripsi), 0,320) ;
                }
                //keyword           
                if(trim($data['single']->seo_kata_kunci) != ''){
                    $optiomation['keyword'] = $data['single']->seo_kata_kunci;
                }else{
                    $optiomation['keyword'] = $data['single']->judul;
                }       
                //image logo            
                if(trim($data['single']->gambar) != ''){
                    $optiomation['image'] = asset('image').'/'.$data['single']->gambar;
                }else{
                    $optiomation['image'] = asset('image').'/'.@$data['main']['profile_website']->logo;
                }
            }else{
                return abort(404);
            }
            $data['optiomation'] = $optiomation;        

            DB::table('product')->where('slug',$param)->Increment('view');
            return view('front..amp.single_product')->with($data);
            
        }
    }
    public function single_page($param='')
    {
        if ($param == '') {
            return redirect('/');
        }else{
            $data['main'] = $this->main();             
            $data['single'] = DB::table('page')
                            ->select('page.id','page.judul','page.view','page.gambar','page.deskripsi','page.seo_judul','page.seo_kata_kunci','page.seo_deskripsi','page.slug','page.created_at','page.updated_at')
                            ->where('page.slug','=',$param)
                            ->where('page.status','=',1)
                            ->first();
            $optiomation = array();
            $optiomation['main_title'] = null;
            $optiomation['title'] = null;
            $optiomation['keyword'] = null;
            $optiomation['description'] = null;
            $optiomation['image'] = null;  
            $optiomation['author'] = ucwords(str_replace('https://www.','', url('')));
            $optiomation['sitename'] = strtoupper(explode('.',str_replace('https://www.','', url('')))[0]);            

            if (!empty($data['single'])){
                $data['single']->detail_updated_at = str_replace(' ', 'T', date("Y-m-d h:m:sP", strtotime($data['single']->updated_at)));
                $data['single']->detail_created_at = str_replace(' ', 'T', date("Y-m-d h:m:sP", strtotime($data['single']->created_at)));

                $optiomation['main_title'] = $data['single']->judul;
                // title
                if(trim($data['single']->seo_judul) != ''){
                    $optiomation['title'] = $data['single']->seo_judul;
                }else{
                    $optiomation['title'] = $data['single']->judul;
                }
                //description
                if(trim($data['single']->seo_deskripsi) != ''){
                    $optiomation['description'] = substr(strip_tags($data['single']->seo_deskripsi), 0,320) ;
                }else{
                    $optiomation['description'] = substr(strip_tags($data['single']->deskripsi), 0,320) ;
                }
                //keyword           
                if(trim($data['single']->seo_kata_kunci) != ''){
                    $optiomation['keyword'] = $data['single']->seo_kata_kunci;
                }else{
                    $optiomation['keyword'] = $data['single']->judul;
                }       
                //image logo            
                if(trim($data['single']->gambar) != ''){
                    $optiomation['image'] = asset('image').'/'.$data['single']->gambar;
                }else{
                    $optiomation['image'] = asset('image').'/'.$data['main']['profile_website']->logo;
                }
            }else{
                return abort(404);
            }
            
            $data['optiomation'] = $optiomation;                       

            DB::table('page')->where('slug',$param)->Increment('view');
            return view('front.amp.single_page')->with($data);
        }
    }
    public function single_blog($param='')
    {
        if ($param == '') {
            return redirect('/');
        }else{
            $data['main'] = $this->main(); 
            
            $data['single'] = DB::table('blog')
                            ->join('blog_kategori','blog.id_blog_kategori','=','blog_kategori.id')
                            ->select('blog_kategori.id as id_cat','blog.id','blog.view','blog.judul','blog.gambar','blog.deskripsi','blog_kategori.judul as judul_cat','blog.seo_judul','blog.seo_kata_kunci','blog.seo_deskripsi','blog.slug','blog_kategori.slug as slug_cat','blog.created_at','blog.updated_at')
                            ->where('blog.slug','=',$param)
                            ->where('blog.status','=',1)
                            ->first();                            
            if (!empty($data['single'])) {
                $data['single']->detail_updated_at = str_replace(' ', 'T', date("Y-m-d h:m:sP", strtotime($data['single']->updated_at)));
                $data['single']->detail_created_at = str_replace(' ', 'T', date("Y-m-d h:m:sP", strtotime($data['single']->created_at)));
                $data['tag'] = DB::table('all_tag')
                            ->join('tag','all_tag.id_tag','=','tag.id')
                            ->select('tag.judul','tag.slug')
                            ->where('all_tag.id_blog','=',$data['single']->id)
                            ->orderBy('tag.judul','ASC')
                            ->get();
                $data['related'] = DB::table('blog')->select('judul','gambar','slug')->where('id_blog_kategori','=',$data['single']->id_cat)->where('id','!=',$data['single']->id)->where('status','=',1)->take(3)->orderBy('id','DESC')->get();
            }else{
                return abort(404);
            }
            
            $optiomation = array();
            $optiomation['main_title'] = null;
            $optiomation['title'] = null;
            $optiomation['keyword'] = null;
            $optiomation['description'] = null;
            $optiomation['image'] = null;  
            $optiomation['author'] = ucwords(str_replace('https://www.','', url('')));
            $optiomation['sitename'] = strtoupper(explode('.',str_replace('https://www.','', url('')))[0]);                          
            $optiomation['single_optiomation'] = array(
                'tag' => $data['tag'],
                'judul_cat' => $data['single']->judul_cat,
                'created_at' => $data['single']->created_at,
                'updated_at' => $data['single']->updated_at
            );              
            
            if (!empty($data['single'])){
                $optiomation['main_title'] = $data['single']->judul;
                // title
                if(trim($data['single']->seo_judul) != ''){
                    $optiomation['title'] = $data['single']->seo_judul;
                }else{
                    $optiomation['title'] = $data['single']->judul;
                }          
                //description
                if(trim($data['single']->seo_deskripsi) != ''){
                    $optiomation['description'] = substr(strip_tags($data['single']->seo_deskripsi), 0,320) ;
                }else{
                    $optiomation['description'] = substr(strip_tags($data['single']->deskripsi), 0,320) ;
                }
                //keyword           
                if(trim($data['single']->seo_kata_kunci) != ''){
                    $optiomation['keyword'] = $data['single']->seo_kata_kunci;
                }else{
                    $optiomation['keyword'] = $data['single']->judul;
                }       
                //image logo            
                if(trim($data['single']->gambar) != ''){
                    $optiomation['image'] = asset('image').'/'.$data['single']->gambar;
                }else{
                    $optiomation['image'] = asset('image').'/'.@$data['main']['profile_website']->logo;
                }
            }else{
                return abort(404);
            }
            $data['optiomation'] = $optiomation;
              
            DB::table('blog')->where('slug',$param)->Increment('view');
            return view('front.amp.single_blog')->with($data);
        }
    }
    public function list_tag($param='')
    {
        
        if ($param == '') {
            return redirect('/');
        }else{
            $data['main'] = $this->main();             
            
            $data['list'] = DB::table('all_tag')
                            ->leftjoin('product','all_tag.id_product','=','product.id')
                            ->leftjoin('blog','all_tag.id_blog','=','blog.id')
                            ->join('tag','tag.id','=','all_tag.id_tag')
                            ->where('tag.slug','=',$param)
                            // ->where('product.status','=',1)
                            // ->where('blog.status','=',1)
                            ->orderBy('all_tag.id','DESC')
                            ->select('product.judul as judul_product','product.gambar as gambar_product','product.slug as slug_product','product.deskripsi as deskripsi_product','blog.judul as judul_blog','blog.gambar as gambar_blog','blog.slug as slug_blog','blog.deskripsi as deskripsi_blog')
                            ->paginate(8);
        
            if (count($data['list']) == 0) {                
                return abort(404);                
            }

            $data_seo = DB::table('tag')->where('slug','=',$param)->first();            
            
            $optiomation = array();
            $optiomation['main_title'] = null;
            $optiomation['title'] = null;
            $optiomation['keyword'] = null;
            $optiomation['description'] = null;
            $optiomation['image'] = null;  
            $optiomation['author'] = ucwords(str_replace('https://www.','', url('')));
            $optiomation['sitename'] = strtoupper(explode('.',str_replace('https://www.','', url('')))[0]);                          
            if (!empty($data_seo)){
                $optiomation['main_title'] = $data_seo->judul;
                // title
                if(trim($data_seo->seo_judul) != ''){
                    if ($data['list']->currentPage() == 1) {
                        $optiomation['title'] = '✅ '.$data_seo->seo_judul;
                    }else{
                        $optiomation['title'] = '✅ '.$data_seo->seo_judul .' - Page '.$data['list']->currentPage();
                    }
                }else{
                    if ($data['list']->currentPage() == 1) {
                        $optiomation['title'] = '✅ '.$data_seo->judul;        
                    }else{
                        $optiomation['title'] = '✅ '.$data_seo->judul .' - Page '.$data['list']->currentPage();      
                    }
                }            
                //description
                if (trim($data_seo->seo_deskripsi) != '') {
                 $optiomation['description'] = $optiomation['main_title'].' - '.substr(strip_tags($data_seo->seo_deskripsi), 0,320);
                }else{
                   $optiomation['description'] = $optiomation['main_title'].' - '.substr(strip_tags($data['main']['profile_website']->deskripsi), 0,320);
                }
                //keyword
                if (trim($data_seo->seo_kata_kunci) != '') {
                  $optiomation['keyword'] = $data_seo->seo_kata_kunci;
                }else{
                  $optiomation['keyword'] = $data['main']['profile_website']->judul;      
                }            
                //image logo
                if (trim($data['main']['profile_website']->logo) != '') {
                   $optiomation['image'] = asset('image').'/'.$data['main']['profile_website']->logo;
                }else{
                  $optiomation['image'] = asset('image').'/'.$data['main']['profile_website']->gambar;
                }            
            }else{
                return abort(404);
            }
            $data['optiomation'] = $optiomation;                    
    
            return view('front.amp.list_tag')->with($data);
        }
    }
    public function list_product($param='')
    {
        $data['main'] = $this->main(); 
    
        if ($param == '') {
            $data_seo = DB::table('profile_website')->first();        
            $data['list'] = DB::table('product')
                    ->join('kategori','product.id_kategori','=','kategori.id')
                    ->where('product.status','=',1)
                    ->select('product.judul',DB::raw('LEFT(product.deskripsi,200) as deskripsi'),'product.gambar','product.slug')
                    ->orderBy('product.id','DESC')
                    ->paginate(14);
        }else{
            $data_seo = DB::table('kategori')->select('judul','seo_judul','seo_kata_kunci','seo_deskripsi','gambar')->where('slug','=',$param)->first();
            $data['list'] = DB::table('product')
                        ->join('kategori','product.id_kategori','=','kategori.id')
                        ->where('kategori.slug','=',$param)
                        ->where('product.status','=',1)
                        ->select('product.judul',DB::raw('LEFT(product.deskripsi,200) as deskripsi'),'product.gambar','product.slug')
                        ->orderBy('product.id','DESC')
                        ->paginate(14);            
        }

        $optiomation = array();
        $optiomation['main_title'] = null;
        $optiomation['title'] = null;
        $optiomation['keyword'] = null;
        $optiomation['description'] = null;
        $optiomation['image'] = null;  
        $optiomation['author'] = ucwords(str_replace('https://www.','', url('')));
        $optiomation['sitename'] = strtoupper(explode('.',str_replace('https://www.','', url('')))[0]);                          
        if (!empty($data_seo)){
            $optiomation['main_title'] = $data_seo->judul;
            // title                            
            if(trim($data_seo->seo_judul) != ''){
                if ($data['list']->currentPage() == 1) {
                    $optiomation['title'] = $data_seo->seo_judul;
                }else{
                    $optiomation['title'] = $data_seo->seo_judul .' - Page '.$data['list']->currentPage();
                }
            }else{
                if ($data['list']->currentPage() == 1) {
                    $optiomation['title'] = $data_seo->judul;        
                }else{
                    $optiomation['title'] = $data_seo->judul .' - Page '.$data['list']->currentPage();      
                }
            }            
            //description
            if (trim($data_seo->seo_deskripsi) != '') {
                $optiomation['description'] = substr(strip_tags($data_seo->seo_deskripsi), 0,320);
            }else{
                $optiomation['description'] = substr(strip_tags($data['main']['profile_website']->deskripsi), 0,320);
            }
            //keyword
            if (trim($data_seo->seo_kata_kunci) != '') {
                $optiomation['keyword'] = $data_seo->seo_kata_kunci;
            }else{
                $optiomation['keyword'] = $data_seo->judul;
            }            
            //image logo
            if (trim($data_seo->gambar) != '') {
                $optiomation['image'] = asset('image').'/'.$data_seo->gambar;
            }else{
                $optiomation['image'] = asset('image').'/'.$data['main']['profile_website']->logo;
            }
        }else{
            return abort(404);
        }
        $data['optiomation'] = $optiomation;    
        
        return view('front.amp.list_product')->with($data);
    }    
    public function list_gallery($param='')
    {
        $data['main'] = $this->main();         
        if ($param == '') {
            $data_seo = DB::table('profile_website')->first();
            $data['list'] = DB::table('galeri')
                    ->join('galeri_kategori','galeri.id_galeri_kategori','=','galeri_kategori.id')
                    ->where('id_product','=',0)
                    ->where('galeri_kategori.status','=',1)
                    ->select('galeri.judul','galeri.gambar','galeri_kategori.slug')
                    ->orderBy('galeri.id','DESC')
                    ->paginate(14);
        }else{
            $data_seo = DB::table('galeri_kategori')->select('judul','seo_judul','seo_kata_kunci','seo_deskripsi')->where('slug','=',$param)->first();
            $data['list'] = DB::table('galeri')
                    ->join('galeri_kategori','galeri.id_galeri_kategori','=','galeri_kategori.id')
                    ->where('galeri.id_product','=',0)
                    ->where('galeri_kategori.slug','=',$param)
                    ->select('galeri.judul','galeri.gambar','galeri_kategori.slug','galeri.updated_at','galeri.created_at')
                    ->orderBy('galeri.id','DESC')
                    ->paginate(14);            
        }
        foreach ($data['list'] as $key => $value) {
            $data['list'][$key]->detail_updated_at = str_replace(' ', 'T', date("Y-m-d h:m:sP", strtotime($value->updated_at)));
            $data['list'][$key]->detail_created_at = str_replace(' ', 'T', date("Y-m-d h:m:sP", strtotime($value->created_at)));
        }
        $optiomation = array();
        $optiomation['main_title'] = null;
        $optiomation['title'] = null;
        $optiomation['keyword'] = null;
        $optiomation['description'] = null;
        $optiomation['image'] = null;  
        $optiomation['author'] = ucwords(str_replace('https://www.','', url('')));
        $optiomation['sitename'] = strtoupper(explode('.',str_replace('https://www.','', url('')))[0]);                          
        if (!empty($data_seo)){
            $optiomation['main_title'] = $data_seo->judul;
            // title                            
            if(trim($data_seo->seo_judul) != ''){
                if ($data['list']->currentPage() == 1) {
                    $optiomation['title'] = 'Gallery - '.$data_seo->seo_judul;
                }else{
                    $optiomation['title'] = 'Gallery - '.$data_seo->seo_judul .' - Page '.$data['list']->currentPage();
                }
            }else{
                if ($data['list']->currentPage() == 1) {
                    $optiomation['title'] = 'Gallery - '.$data_seo->judul;        
                }else{
                    $optiomation['title'] = 'Gallery - '.$data_seo->judul .' - Page '.$data['list']->currentPage();      
                }
            }            
            //description
            if (trim($data_seo->seo_deskripsi) != '') {
                $optiomation['description'] = substr(strip_tags($data_seo->seo_deskripsi), 0,320);
            }else{
                $optiomation['description'] = substr(strip_tags($data['main']['profile_website']->deskripsi), 0,320);
            }
            //keyword
            if (trim($data_seo->seo_kata_kunci) != '') {
                $optiomation['keyword'] = $data_seo->seo_kata_kunci;
            }else{
                $optiomation['keyword'] = $data_seo->judul;
            }            
            //image logo
            if (trim($data_seo->gambar) != '') {
                $optiomation['image'] = asset('image').'/'.$data_seo->gambar;
            }else{
                $optiomation['image'] = asset('image').'/'.$data['main']['profile_website']->logo;
            }            
        }else{
            return abort(404);
        }
        $data['optiomation'] = $optiomation;
    
        return view('front.amp.list_gallery')->with($data); 
    }
    public function list_blog($param='')
    {
        $data['main'] = $this->main();
        if ($param == '') {
            $data_seo = DB::table('profile_website')->first();
            $data['list'] = DB::table('blog')
                    ->join('blog_kategori','blog.id_blog_kategori','=','blog_kategori.id')
                    ->where('blog.status','=',1)
                    ->select('blog.judul','blog.gambar',DB::raw('LEFT(blog.deskripsi,200) as deskripsi'),'blog.slug')
                    ->orderBy('blog.id','DESC')
                    ->paginate(14);
        }else{
            $data_seo = DB::table('blog_kategori')->select('judul','seo_judul','seo_kata_kunci','seo_deskripsi')->where('slug','=',$param)->first();
            $data['list'] = DB::table('blog')
                        ->join('blog_kategori','blog.id_blog_kategori','=','blog_kategori.id')
                        ->where('blog_kategori.slug','=',$param)
                        ->where('blog.status','=',1)
                        ->select('blog.judul','blog.gambar',DB::raw('LEFT(blog.deskripsi,200) as deskripsi'),'blog.slug')
                        ->orderBy('blog.id','DESC')
                        ->paginate(14);            
        }
        $optiomation = array();
        $optiomation['main_title'] = null;
        $optiomation['title'] = null;
        $optiomation['keyword'] = null;
        $optiomation['description'] = null;
        $optiomation['image'] = null;  
        $optiomation['author'] = ucwords(str_replace('https://www.','', url('')));
        $optiomation['sitename'] = strtoupper(explode('.',str_replace('https://www.','', url('')))[0]);                          
        if (!empty($data_seo)){
            $optiomation['main_title'] = $data_seo->judul;
            // title                            
            if(trim($data_seo->seo_judul) != ''){
                if ($data['list']->currentPage() == 1) {
                    $optiomation['title'] = 'Blog - '.$data_seo->seo_judul;
                }else{
                    $optiomation['title'] = 'Blog - '.$data_seo->seo_judul .' - Page '.$data['list']->currentPage();
                }
            }else{
                if ($data['list']->currentPage() == 1) {
                    $optiomation['title'] = 'Blog - '.$data_seo->judul;        
                }else{
                    $optiomation['title'] = 'Blog - '.$data_seo->judul .' - Page '.$data['list']->currentPage();      
                }
            }            
            //description
            if (trim($data_seo->seo_deskripsi) != '') {
                $optiomation['description'] = substr(strip_tags($data_seo->seo_deskripsi), 0,320);
            }else{
                $optiomation['description'] = substr(strip_tags($data['main']['profile_website']->deskripsi), 0,320);
            }
            //keyword
            if (trim($data_seo->seo_kata_kunci) != '') {
                $optiomation['keyword'] = $data_seo->seo_kata_kunci;
            }else{
                $optiomation['keyword'] = $data_seo->judul;
            }            
            //image logo
            if (trim($data['main']['profile_website']->logo) != '') {
                $optiomation['image'] = asset('image').'/'.$data['main']['profile_website']->logo;
            }else{
                $optiomation['image'] = asset('image').'/'.$data['main']['profile_website']->gambar;
            }            
        }else{
            return abort(404);
        }
        $data['optiomation'] = $optiomation;            
        
        return view('front.amp.list_blog')->with($data);
    }
    public function contact()
    {
        $data['main'] = $this->main();

        $optiomation = array();
        $optiomation['main_title'] = null;
        $optiomation['title'] = null;
        $optiomation['keyword'] = null;
        $optiomation['description'] = null;
        $optiomation['image'] = null;  
        $optiomation['author'] = ucwords(str_replace('https://www.','', url('')));
        $optiomation['sitename'] = strtoupper(explode('.',str_replace('https://www.','', url('')))[0]);                          
        
        if (!empty($data['main']['profile_website'])){
            $optiomation['main_title'] = $data['main']['profile_website']->judul;
            // title            
            if(trim($data['main']['profile_website']->seo_judul) != ''){                
                $optiomation['title'] = $data['main']['label']['Contact'] .' - '. $data['main']['profile_website']->seo_judul;
            }else{
                $optiomation['title'] = $data['main']['label']['Contact'] .' - '. $data['main']['profile_website']->judul;
            }            
            //description    
            if (trim($data['main']['profile_website']->seo_deskripsi) != '') {
                $optiomation['description'] = substr(strip_tags($data['main']['profile_website']->seo_deskripsi), 0,300);
            }else{
                $optiomation['description'] = substr(strip_tags($data['main']['profile_website']->deskripsi), 0,300);
            }            

            //keyword
            if (trim($data['main']['profile_website']->seo_kata_kunci) != '') {
                $optiomation['keyword'] = $data['main']['profile_website']->seo_kata_kunci;
            }else{
                $optiomation['keyword'] = $data['main']['profile_website']->judul; 
            }
            
            //image logo
            if (trim($data['main']['profile_website']->logo) != '') {
                $optiomation['image'] = asset('image').'/'.$data['main']['profile_website']->logo;
            }else{
                $optiomation['image'] = asset('image').'/'.$data['main']['profile_website']->gambar;
            }            
        }else{
            return abort(404);
        }

        $data['optiomation'] = $optiomation;
        
        
        return view('front.amp.contact')->with($data); 
    }
    public function booking()
    {        
        $data['main'] = $this->main();
        
        $optiomation = array();
        $optiomation['main_title'] = null;
        $optiomation['title'] = null;
        $optiomation['keyword'] = null;
        $optiomation['description'] = null;
        $optiomation['image'] = null;  
        $optiomation['author'] = ucwords(str_replace('https://www.','', url('')));
        $optiomation['sitename'] = strtoupper(explode('.',str_replace('https://www.','', url('')))[0]);                          
        
        if (!empty($data['main']['profile_website'])){
            $optiomation['main_title'] = $data['main']['profile_website']->judul;
            // title            
            if(trim($data['main']['profile_website']->seo_judul) != ''){                
                $optiomation['title'] = $data['main']['label']['Booking'] .' - '. $data['main']['profile_website']->seo_judul;
            }else{
                $optiomation['title'] = $data['main']['label']['Booking'] .' - '. $data['main']['profile_website']->judul;
            }            
            //description    
            if (trim($data['main']['profile_website']->seo_deskripsi) != '') {
                $optiomation['description'] = substr(strip_tags($data['main']['profile_website']->seo_deskripsi), 0,300);
            }else{
                $optiomation['description'] = substr(strip_tags($data['main']['profile_website']->deskripsi), 0,300);
            }            

            //keyword
            if (trim($data['main']['profile_website']->seo_kata_kunci) != '') {
                $optiomation['keyword'] = $data['main']['profile_website']->seo_kata_kunci;
            }else{
                $optiomation['keyword'] = $data['main']['profile_website']->judul; 
            }
            
            //image logo
            if (trim($data['main']['profile_website']->logo) != '') {
                $optiomation['image'] = asset('image').'/'.$data['main']['profile_website']->logo;
            }else{
                $optiomation['image'] = asset('image').'/'.$data['main']['profile_website']->gambar;
            }            
        }else{
            return abort(404);
        }
        $data['optiomation'] = $optiomation;

        return view('front.amp.booking')->with($data); 
    }
    public function review()
    {        
        $data['main'] = $this->main();
        
        $optiomation = array();
        $optiomation['main_title'] = null;
        $optiomation['title'] = null;
        $optiomation['keyword'] = null;
        $optiomation['description'] = null;
        $optiomation['image'] = null;  
        $optiomation['author'] = ucwords(str_replace('https://www.','', url('')));
        $optiomation['sitename'] = strtoupper(explode('.',str_replace('https://www.','', url('')))[0]);                          
        
        if (!empty($data['main']['profile_website'])){
            $optiomation['main_title'] = $data['main']['profile_website']->judul;
            // title            
            if(trim($data['main']['profile_website']->seo_judul) != ''){                
                $optiomation['title'] = 'Review'.' - '. $data['main']['profile_website']->seo_judul;
            }else{
                $optiomation['title'] = 'Review'.' - '. $data['main']['profile_website']->judul;
            }            
            //description    
            if (trim($data['main']['profile_website']->seo_deskripsi) != '') {
                $optiomation['description'] = substr(strip_tags($data['main']['profile_website']->seo_deskripsi), 0,300);
            }else{
                $optiomation['description'] = substr(strip_tags($data['main']['profile_website']->deskripsi), 0,300);
            }            

            //keyword
            if (trim($data['main']['profile_website']->seo_kata_kunci) != '') {
                $optiomation['keyword'] = $data['main']['profile_website']->seo_kata_kunci;
            }else{
                $optiomation['keyword'] = $data['main']['profile_website']->judul; 
            }
            
            //image logo
            if (trim($data['main']['profile_website']->logo) != '') {
                $optiomation['image'] = asset('image').'/'.$data['main']['profile_website']->logo;
            }else{
                $optiomation['image'] = asset('image').'/'.$data['main']['profile_website']->gambar;
            }            
        }else{
            return abort(404);
        }
        $data['optiomation'] = $optiomation;

        return view('front.amp.review')->with($data); 
    }
    public function index()
    {
        $data['main'] = $this->main();        
        $data['home'] = DB::table('home_setting')->orderBy('posisi','ASC')->where('status','=',1)->get();

        $optiomation = array();
        $optiomation['main_title'] = null;
        $optiomation['title'] = null;
        $optiomation['keyword'] = null;
        $optiomation['description'] = null;
        $optiomation['image'] = null;  
        $optiomation['author'] = ucwords(str_replace('https://www.','', url('')));
        $optiomation['sitename'] = strtoupper(explode('.',str_replace('https://www.','', url('')))[0]);                          
        
        if (!empty($data['main']['profile_website'])){
            $optiomation['main_title'] = $data['main']['profile_website']->judul;
            
            // title
            if(trim($data['main']['profile_website']->seo_judul) != ''){                
                $optiomation['title'] = $data['main']['profile_website']->seo_judul;
            }else{
                $optiomation['title'] = $data['main']['profile_website']->judul;
            }            
            //description    
            if (trim($data['main']['profile_website']->seo_deskripsi) != '') {
                $optiomation['description'] = substr(strip_tags($data['main']['profile_website']->seo_deskripsi), 0,300);
            }else{
                $optiomation['description'] = substr(strip_tags($data['main']['profile_website']->deskripsi), 0,300);
            }            

            //keyword
            if (trim($data['main']['profile_website']->seo_kata_kunci) != '') {
                $optiomation['keyword'] = $data['main']['profile_website']->seo_kata_kunci;
            }else{
                $optiomation['keyword'] = $data['main']['profile_website']->judul; 
            }
            
            //image logo
            if (trim($data['main']['profile_website']->logo) != '') {
                $optiomation['image'] = asset('image').'/'.$data['main']['profile_website']->logo;
            }else{
                $optiomation['image'] = asset('image').'/'.$data['main']['profile_website']->gambar;
            }            
        }else{
            return abort(404);
        }
        $data['optiomation'] = $optiomation;

        foreach ($data['home'] as $row) {
            if ($row->status == 1) {
                if ($row->name == 'Slider') {
                    $data[$row->name] = DB::table('slider')->orderBy('position','ASC')->get();
                    $slider = $data[$row->name];
                    while(count($data[$row->name]) <= 5){
                        foreach ($slider as $key) {                            
                            array_push($data[$row->name],$key);
                        }
                    }                    
                }elseif($row->name == 'Profile') {
                    $data[$row->name] = true;
                }elseif($row->name == 'Special'){
                    $special = DB::table('special_offer')                                        
                                        ->leftjoin('product','product.id','=','special_offer.id_product')
                                        ->leftjoin('page','page.id','=','special_offer.id_page')
                                        ->select('product.judul as product_judul','product.deskripsi as product_deskripsi','product.slug as product_slug','product.gambar as product_gambar',
                                            'page.judul as page_judul','page.deskripsi as page_deskripsi','page.slug as page_slug','page.gambar as page_gambar'
                                                )
                                        ->orderBy('special_offer.position','ASC')
                                        ->get();
                    $data[$row->name] = array();
                    foreach ($special as $spesial) {                        
                        $item_row = array();
                        if($spesial->page_judul == null) {
                            $item_row = array(
                                'link' => url('amp/link').'/'.$spesial->product_slug,
                                'title' => $spesial->product_judul,
                                'id' => str_replace(' ','_',$spesial->product_judul),
                                'img_path' => asset('image').'/',
                                'img' => '/'.$spesial->product_gambar,
                                'description' => substr(strip_tags($spesial->product_deskripsi), 0,100).'...'
                            );
                        }else{
                            $item_row = array(
                                'link' => url('amp').'/'.$spesial->page_slug,
                                'title' => $spesial->page_judul,
                                'id' => str_replace(' ','_',$spesial->page_judul),
                                'img_path' => asset('image').'/',
                                'img' => '/'.$spesial->page_gambar,
                                'description' => substr(strip_tags($spesial->page_deskripsi), 0,100).'...'
                            );                        
                        }
                        array_push($data[$row->name],$item_row);
                    }
                }elseif ($row->name == 'Product') {
                    $data[$row->name] = DB::table('kategori')
                                        ->select('judul','seo_deskripsi','gambar','slug')
                                        ->where('status','=',1)
                                        ->orderBy('position','ASC')
                                        ->get();
                
                }elseif ($row->name == 'Transport') {
                    $data[$row->name] = DB::table('page')->select('judul','gambar','deskripsi')->where('status',1)->where('display','transport')->get();
                    if ($row->custom  == 1) {                       
                        $data['transport_button'] = true;
                    }else{
                        $data['transport_button'] = false;                        
                    }
                }
            }else{
                $data[$row->name] == '';
            }
        } 
        
        return view('front.amp.home')->with($data);
    }    
}
