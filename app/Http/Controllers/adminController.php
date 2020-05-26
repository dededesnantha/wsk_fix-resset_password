<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\administrator;
use App\Models\kategori_tahun;
use App\Models\mahasiswa;
use App\Models\tag;
use App\Models\all_tag;
use App\Models\profile_website;
use App\Models\sosial_media;
use App\Models\blog_kategori;
use App\Models\blog;
use App\Models\galeri_kategori;
use App\Models\galeri;
use App\Models\kategori;
use App\Models\product;
use App\Models\page;
use App\Models\menu;
use App\Models\kontak;
use App\Models\menu_footer;
use App\Models\footer;
use App\Models\slider;
use DB;
use Session;
use ZipArchive;
use Config;
use Storage;
use Mail;

use App\Models\shortcut_blog_category;
use App\Models\shortcut_blog_keyword;
use App\Models\shortcut_blog_tag;
use App\Models\widget;
use App\Models\widget_data;
use App\Models\product_widget;
use App\Models\list_page_on_product;

use App\Models\media;
use App\Models\review;
use App\Models\record_wa;

use Excel;

class adminController extends Controller
{    

    public function ajaran_baru(Request $request)
    {           
        $post = $request->input();
        $count = DB::table('kategori_tahun')
                ->where('status',1)
                ->count();
        if ($post['status'] == false) {
        kategori_tahun::create($post);
        }else{
             if ($count == 1) {
                return response()->json(['error'=>true],400);
            }else{
                 kategori_tahun::create($post);
                return response()->json(['success'=>true],200);
            }
        }
    }

    public function get_all_ajaran()
    {
        return kategori_tahun::all();
    }

    public function get_rubah_ajaran($id)
    {                               
         return kategori_tahun::find($id);
    }

    public function get_update_ajaran(Request $request, $id)
    {
         $post = $request->input();
         $count = DB::table('kategori_tahun')
                ->where('status',1)
                ->count();
        if ($post['status'] == false) {
            kategori_tahun::find($id)->update($post);
        }else{
            if ($count == 1) {
                return response()->json(['error'=>true],400);
            }else{
                kategori_tahun::find($id)->update($post);
                return response()->json(['success'=>true],200);
            }
        }
    } 

    public function get_all_mahasiswa($id)
    {
        return mahasiswa::where('id_kategori_tahun',$id)->get();
    }
    public function all_mahasiswa(Request $request)
    {             
        $post = $request->input();

        if ($post['field'] == 'all') {
        $data = DB::table('mahasiswa')
                ->select('id','no_registrasi','kode','nama_lengkap','nama_panggilan','jk','status_pembayaran','registrasi_ulang','id_kategori_tahun','created_at', 'updated_at')                
                ->orderBy('id', $post['order'])
                ->where('id_kategori_tahun', $post['id'])
                ->paginate($post['much']);
        }else{

            if ($post['field'] == 'no_registrasi') {
                if ($post['cari'] == '') {
                    $post['field'] = 'id';
                }
            }
        $data = DB::table('mahasiswa')          
               ->select('id','no_registrasi','kode','nama_lengkap','nama_panggilan','jk','status_pembayaran','registrasi_ulang','id_kategori_tahun','created_at', 'updated_at')                
                ->orderBy($post['field'], $post['order'])
                ->where($post['field'],'like','%'.$post['cari'].'%')
                ->where('id_kategori_tahun', $post['id'])
                ->paginate($post['much']);

        }

        return $data;
    }

    
    public function get_ajaran($id)
    {
        $data['tahun'] = DB::table('kategori_tahun')
                        ->where('id', $id)
                        ->select('id')
                        ->first();
        return $data;
    }
    public function get_view_mahasiswa($id='')
    {
       $data = mahasiswa::find($id);
       return response()->json( $data,200);
    }
    public function edit_mahasiswa($id='')
    {
        $data = mahasiswa::find($id);
       return $data;
    }
    public function update_mahasiswa(Request $request, $id)
    {
        $post = $request->input();
        if ($post['status_pembayaran'] == 'lunas') {
            $post['site'] = 'SMK Werdhi Sila Kumara';
            // ke pengirim
             Mail::send('front.email_mahasiswa.email_lunas',$post, function($message) use ($post)
             {            
                $message->from(env('MAIL_USERNAME'),$post['site']);
                $message->to($post['email'],$post['nama_lengkap'])->subject('Status Pembayaran Siswa Baru SMK Werdhi Sila Kumara');                
            });

            mahasiswa::find($id)->update($post);
            return response()->json(['status'=>'ok'],200);
        }
        mahasiswa::find($id)->update($post);
        return response()->json(['status'=>'ok'],200);
    }
    public function hapus_mahasiswa($id)
    {
        mahasiswa::find($id)->delete();
    }
    
    public function date_convert($date)
    {        
        $date = strtotime($date);
        $now_date = time();
        $range = (int) round(($now_date - $date) / (60 * 60 * 24));

        $month = ['Januari','February','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];         
        $sort_month = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];         
        $convert = array(            
            'long_month' => $month[(int) date("m",$date) - 1],
            'sort_month' => $sort_month[(int) date("m",$date) - 1],
            'day' => date("l",$date),
            'sort_day' => date("D",$date),            
            'second' => date("s",$date),
            'month' => date("m",$date),
            'menit' => date("M",$date),            
            'year' => date("Y",$date),
            'date' => date("d",$date),
            'minute' => date("i",$date),
            'hour' => date("H",$date),
            'distance' => $range
        );        
        return $convert;
    }
    public function get_review(Request $request)
    {
        $post = $request->input();
        if ($post['field'] == 'all') {
        $data = review::select('id','name','subject','created_at','approve')->orderBy('id', $post['order'])
                ->paginate($post['much']);
        }else{
            if ($post['field'] == 'name') {
                if ($post['cari'] == '') {
                    $post['field'] = 'id';
                }
            }
        $data = review::select('id','name','subject','created_at','approve')->orderBy($post['field'], $post['order'])
                ->where($post['field'],'like','%'.$post['cari'].'%')                
                ->paginate($post['much']);
        }
        if(count($data) != 0){
            foreach ($data as $row) {   
                $temp_date = $this->date_convert($row->created_at);
                $row->filter_created_at =  $temp_date['date'].' '.$temp_date['long_month'].' '.$temp_date['year'];
            }
        }
        return $data;
    }

    public function get_review_single($id)
    {
        $data =  review::find($id);
        if(empty($data)){
            return response()->json( ['error' => 'no found data'],400);
        }else{
            $temp_date = $this->date_convert($data->created_at);
            $data->filter_created_at =  $temp_date['date'].' '.$temp_date['long_month'].' '.$temp_date['year'];
        }
        return response()->json( $data,200);
        
    }
    public function review_approve($id)
    {
        $data = review::find($id);
        if ($data->approve) {
            $approve = 0;
        }else{
            $approve = 1;            
        }
        review::find($id)->update(['approve'=>$approve]);     
        return response()->json(['success'=>true],200);
        
    }
    public function delete_review($id)
    {
        
        review::find($id)->delete();         
    }
    public function get_media(Request $request){
        switch ($request->input('location')) {
            case 'Media':
                $data = media::select('id','gambar')->where('gambar','!=','')->orderBy($request->input('field'),$request->input('order'))->paginate($request->input('much'));
                break;
            case 'Tour':
                $data = galeri::select('id','gambar')->where('gambar','!=','')->where('id_product','!=',0)->orderBy($request->input('field'),$request->input('order'))->paginate($request->input('much'));
                break;            
            case 'Page':
                $data = page::select('id','gambar')->where('gambar','!=','')->orderBy($request->input('field'),$request->input('order'))->paginate($request->input('much'));
                break;
            case 'Blog':
                $data = blog::select('id','gambar')->where('gambar','!=','')->orderBy($request->input('field'),$request->input('order'))->paginate($request->input('much'));                
                break;
            case 'Gallery':
                $data = galeri::select('id','gambar')->where('gambar','!=','')->where('id_galeri_kategori','!=',0)->orderBy($request->input('field'),$request->input('order'))->paginate($request->input('much'));                
                break;
            default:
                return response()->json(['error'=>'no data selected'],400);            
                break;
        }
        return response()->json($data, 200);    
    }
    public function hapus_media_multi(Request $request){
        $data = array(); 
        if(count($request->all()) == 0) {
            return response()->json(['error' => true],400);
        };
        foreach ($request->all() as $key => $value) {
            if($value){
                array_push($data,$key);
            }
        }
        
        
        $gambar_check = media::select('gambar')->whereIn('id',$data)->get();        
        foreach ($gambar_check as $row) {            
            if (file_exists(public_path('media/'.$row['gambar']))) {
                @unlink(public_path('media/'.$row['gambar']));                
            }
        }
        
        media::whereIn('id',$data)->delete();        
        return response()->json(['success' => true],200);
    }

    public function blog_shortcut_get_keyword_tag($id){        
        $data['keyword'] = DB::table('shortcut_blog_keyword')->select('name')->where('id_shortcut_blog_category',$id)->orderBy('name','ASC')->get();
        $data['tag'] = implode(',', array_map(function($n){return $n->name;},DB::table('shortcut_blog_tag')->select('name')->where('id_shortcut_blog_category',$id)->orderByRaw('RAND()')->take(3)->get()));
        
        return $data;        
    }
    public function blog_shortcut_get_category()
    {
        $data = shortcut_blog_category::select('id','name')->orderBy('name','ASC')->get();
        return $data;
    }

    public function reload_data_shortcut_blog()
    {
        set_time_limit(600);
        shortcut_blog_category::truncate();
        shortcut_blog_keyword::truncate();
        shortcut_blog_tag::truncate();

        $ch = curl_init();            
        curl_setopt($ch, CURLOPT_URL, 'http://www.tayatha.com/get/api/faster_create_blog');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);                
        $output = curl_exec($ch);            
        curl_close($ch);
        $jsonData = json_decode($output);
        
        foreach ($jsonData->data as $row) {
            $id = shortcut_blog_category::create(['name'=>$row->name])->id;            
            $keyword = [];
            foreach (explode(',',preg_replace("/\r|\n/", "",  $row->keyword)) as $key) {
             array_push($keyword, ['name'=>$key,'id_shortcut_blog_category'=>$id]);
            }
            shortcut_blog_keyword::insert($keyword);
            $tag = [];
            foreach (explode(',', preg_replace("/\r|\n/", "", $row->tag)) as $key) {
             array_push($tag, ['name'=>$key,'id_shortcut_blog_category'=>$id]);
            }
            shortcut_blog_tag::insert($tag);            
        }

        if ($jsonData->last_page != 1) {            
            for ($i=2; $i <= $jsonData->last_page; $i++) { 
                $curlSession = curl_init();
                curl_setopt($curlSession, CURLOPT_URL, 'https://www.tayatha.com/get/api/faster_create_blog?page='.$i);
                curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
                curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
                $jsonData = json_decode(curl_exec($curlSession));
                curl_close($curlSession);

                foreach ($jsonData->data as $row) {
                    $id = shortcut_blog_category::create(['name'=>$row->name])->id;            
                    $keyword = [];
                    foreach (explode(',', preg_replace("/\r|\n/", "", $row->keyword)) as $key) {
                     array_push($keyword, ['name'=>$key,'id_shortcut_blog_category'=>$id]);
                    }
                    shortcut_blog_keyword::insert($keyword);
                    $tag = [];
                    foreach (explode(',', preg_replace("/\r|\n/", "", $row->tag)) as $key) {
                     array_push($tag, ['name'=>$key,'id_shortcut_blog_category'=>$id]);
                    }
                    shortcut_blog_tag::insert($tag);            
                }
            }
        }

        return response()->json(['success' => true],200);
        
    }
    public function index()
    {        
        return view('admin.index');
    }
    public function angular()
    {
        return view('dashboard.index');
    }    
    public function blog_kategori()
    {        
        $data = blog_kategori::all();
        if(count($data) == 0){
            blog_kategori::create([
                'judul'=>'Thing To Do',
                'slug'=>'thing-to-do.html'  
            ]);
            $data = blog_kategori::all();
        }
        return $data;
    }
    public function blog_kategori_baru(Request $request)
    {           
        $post = $request->input();                
        $title_slug = strip_tags($post['judul']);        
        $string_replace = array('\'', ';', '[', ']', '{', '}', '|', '^', '~','?','/','.');
        $slug = str_replace(' ','-',str_replace($string_replace, '', $title_slug)); 
        $tc = DB::table('blog_kategori')->where('judul', $post['judul'])->get();                                    
        if (count($tc) > 0 ) {                 
            $slugs = $slug.'-'.count($tc);            
            $sc = DB::table('blog_kategori')->where('slug', $tc[0]->slug)->count();                
            if ($sc > 0) {
                $finisslug = $slugs.'-'.$sc;
            }else{
                $finisslug = $slug.'-'.count($tc);
            }            
        }else{
          $finisslug = $slug;  
        }
        if (trim(@$post['seo_judul']) == '' || @$post['seo_judul'] == null) {
            $post['seo_judul'] = strip_tags($post['judul']);
        }
        if (trim(@$post['seo_kata_kunci']) == '' || @$post['seo_kata_kunci'] == null) {
            $post['seo_kata_kunci'] = strip_tags($post['judul']);
        }
        blog_kategori::create(array_merge($post, ['slug' => strtolower($finisslug).'.html']));
    }
    public function blog_baru(Request $request)
    {           
        $post = $request->input();                        
        $title_slug = strip_tags($post['judul']);        
        $string_replace = array('\'', ';', '[', ']', '{', '}', '|', '^', '~','?','/','.');
        $slug = str_replace(' ','-',str_replace($string_replace, '', $title_slug)); 
        $tc = DB::table('blog')->where('judul', $post['judul'])->get();                                    
        if (count($tc) > 0 ) {                 
            $slugs = $slug.'-'.count($tc);            
            $sc = DB::table('blog')->where('slug', $tc[0]->slug)->count();                
            if ($sc > 0) {
                $finisslug = $slugs.'-'.$sc;
            }else{
                $finisslug = $slug.'-'.count($tc);
            }                    
        }else{
          $finisslug = $slug;
        }
        //new category if not selected
        if (empty($post['id_blog_kategori'])) {
            $get_category_shortcut = shortcut_blog_category::find($post['second_category']);        
            $get_category_blog = blog_kategori::where('judul',$get_category_shortcut->name)->get();
            if (count($get_category_blog) == 0) {
                $string_replace = array('\'', ';', '[', ']', '{', '}', '|', '^', '~','?','/','.');
                $new_category = blog_kategori::create(['judul'=>$get_category_shortcut->name,'slug'=>strtolower(str_replace(' ','-',
                    str_replace($string_replace, '', strip_tags($get_category_shortcut->name)))).'.html']);
                $post['id_blog_kategori'] = $new_category->id;
            }else{
                $post['id_blog_kategori'] = $get_category_blog[0]->id;
            }
        }

        if (trim(@$post['seo_judul']) == '' || @$post['seo_judul'] == null) {
            $post['seo_judul'] = strip_tags($post['judul']);
        }
        if (trim(@$post['seo_kata_kunci']) == '' || @$post['seo_kata_kunci'] == null) {
            $post['seo_kata_kunci'] = strip_tags($post['judul']);
        }
        if (trim(@$post['seo_deskripsi']) == '' || @$post['seo_deskripsi'] == null) {
            $post['seo_deskripsi'] = substr(strip_tags(@$post['deskripsi']),0,500);
        }
        $id = blog::create(array_merge($post, ['slug' => strtolower($finisslug).'.html']))->id;        
        // -----------------------------             
        if (empty($post['tag'])) {              
        }else{            
            $t = explode(',', $post['tag']);                
            foreach ($t as $key) {
                $tag_baru = str_replace('-',' ',trim($key));                
                $tag_find = DB::table('tag')->where('judul', $tag_baru)->get();
                if (count($tag_find) == 0) {                                            
                    $string_replace = array('\'', ';', '[', ']', '{', '}', '|', '^', '~','?','/','.');
                    $slug = str_replace(' ','-',trim(str_replace($string_replace, '', $key)));                 
                    $get_count = DB::table('tag')->where('judul', $tag_baru)->get();   
                    $tc = count($get_count);
                    if ($tc > 0 ) {     
                        $slugs = $slug.'-'.$tc;
                        $slug_count = DB::table('tag')->where('judul', $tag_baru)->get();                          
                        $sc = count($slug_count);
                        if ($sc > 0) {
                            $tag_slug = $slugs.'-'.$sc;
                        }else{
                            $tag_slug = $slug.'-'.$tc;
                        }
                    }
                    else{$tag_slug = $slug;}
                    $data_tag = array('judul' => $tag_baru,
                                        'slug' => strtolower($tag_slug).'.html');
                    $tags = tag::create($data_tag);                  
                    $data_tag = array('id_tag' =>$tags->id,
                                        'id_blog' => $id);
                    if ($tag_baru != '') {
                        if (all_tag::where('id_tag','=',$tags->id)->where('id_blog' ,'=', $id)->get()->count() == 0) { 
                            all_tag::create($data_tag);                 
                        }
                    }
                }else{
                    $id_tag = $tag_find[0]->id;
                    $data_tag = array('id_tag' => $id_tag,
                                        'id_blog' => $id);
                    if ($tag_baru != '') {
                        if (all_tag::where('id_tag','=',$id_tag)->where('id_blog' ,'=', $id)->get()->count() == 0) {
                            all_tag::create($data_tag);         
                        }        
                    }
                } 
            }            
        }   
    }
    public function blog_rubah($id='')
    {                               
         return blog::find($id);
    }  
    public function blog_update(Request $request,$id)
    {
        $post = $request->input();
        if (!empty($post['slug'])) {    
            $title_slug = strip_tags($post['slug']);        
        }else{
            $title_slug = strip_tags($post['judul']);
        }     
        $string_replace = array('\'', ';', '[', ']', '{', '}', '|', '^', '~','?','/','.');
        $slug = str_replace(' ','-',str_replace($string_replace, '', $title_slug)); 
        $tc = DB::table('blog')->where('slug', $slug)->get();                                    
        if (count($tc) > 0 ) {     
            if ($tc[0]->id == $id and $tc[0]->slug == $post['slug']) {                    
                $finisslug = $slug;
            }else{
                $slugs = $slug.'-'.count($tc);            
                $sc = DB::table('blog')->where('slug', $tc[0]->slug)->count();                
                if ($sc > 0) {
                    $finisslug = $slugs.'-'.$sc;
                }else{
                    $finisslug = $slug.'-'.count($tc);
                }
            }                                
        }else{
          $finisslug = $slug;  
        } 
        if (trim(@$post['seo_judul']) == '' || @$post['seo_judul'] == null) {
            $post['seo_judul'] = strip_tags($post['judul']);
        }
        if (trim(@$post['seo_kata_kunci']) == '' || @$post['seo_kata_kunci'] == null) {
            $post['seo_kata_kunci'] = strip_tags($post['judul']);
        }
        if (trim(@$post['seo_deskripsi']) == '' || @$post['seo_deskripsi'] == null) {
            if (substr(strip_tags(@$post['deskripsi']),0,500) == '') {     
                $post['seo_deskripsi'] = '';
            }else{
                $post['seo_deskripsi'] = substr(strip_tags(@$post['deskripsi']),0,500);                
            }
        }
        // ----------        
        if (@$post['gambar'] == '') {
            unset($request['gambar']);
            unset($post['gambar']);
        }else{            
            $gambar_check = blog::select('gambar')->where('id',$id)->get();               
            if ($post['gambar'] != $gambar_check[0]['gambar']) {                
                if (file_exists(public_path('image/'.$gambar_check[0]['gambar']))) {
                    @unlink(public_path('image/'.$gambar_check[0]['gambar']));
                    @unlink(public_path('image/thumb/'.$gambar_check[0]['gambar']));
                }
            }
        }
        
        blog::find($id)->update(array_merge($post, ['slug' => strtolower(str_replace('html','',$finisslug)).'.html']));
        all_tag::where('id_blog', $id)->delete();
        // -----------------------------                
        if (empty($post['tag'])) {              
        }else{
            
                $t = explode(',', $post['tag']);                
                foreach ($t as $key) {
                    $tag_baru = str_replace('-',' ',trim($key));
                    $tag_find = DB::table('tag')->where('judul', $tag_baru)->get();
                    if (count($tag_find) == 0) {                                            
                        $string_replace = array('\'', ';', '[', ']', '{', '}', '|', '^', '~','?','/','.');
                        $slug = str_replace(' ','-',trim(str_replace($string_replace, '', $key)));                 
                        $get_count = DB::table('tag')->where('judul', $tag_baru)->get();   
                        $tc = count($get_count);    
                        if ($tc > 0 ) {     
                            $slugs = $slug.'-'.$tc;
                            $slug_count = DB::table('tag')->where('judul', $tag_baru)->get();                          
                            $sc = count($slug_count);
                            if ($sc > 0) {
                                $tag_slug = $slugs.'-'.$sc;
                            }else{
                                $tag_slug = $slug.'-'.$tc;
                            }
                        }
                        else{$tag_slug = $slug;}
                        $data_tag = array('judul' => $tag_baru,
                                            'slug' => strtolower($tag_slug).'.html');
                        $tags = tag::create($data_tag);                  
                        $data_tag = array('id_tag' =>$tags->id,
                                            'id_blog' => $id);
                        if ($tag_baru != '') {
                            if (all_tag::where('id_tag','=',$tags->id)->where('id_blog' ,'=', $id)->get()->count() == 0 ) { 
                                all_tag::create($data_tag);      
                            }
                        }
                    }else{
                        $id_tag = $tag_find[0]->id;
                        $data_tag = array('id_tag' => $id_tag,
                                            'id_blog' => $id);
                        if ($tag_baru != '') {
                            if (all_tag::where('id_tag','=',$id_tag)->where('id_blog' ,'=', $id)->get()->count() == 0) {
                                all_tag::create($data_tag); 
                            }
                        }
                        
                    } 
                }
            
        }

    }
    public function blog_kategori_rubah($id='')
    {                               
         return blog_kategori::find($id);
    }
    public function get_tag_blog($id)
    {
        $data = DB::table('all_tag')            
            ->join('tag', 'tag.id', '=', 'all_tag.id_tag')
            ->select('tag.judul as text')
            ->where('all_tag.id_blog', '=', $id)
            ->lists('text');                        
            return implode(',',$data);
    }
    public function blog_kategori_update(Request $request,$id)
    {
        $post = $request->input();
        if (!empty($post['slug'])) {    
            $title_slug = strip_tags($post['slug']);        
        }else{
            $title_slug = strip_tags($post['judul']);
        }    
        $string_replace = array('\'', ';', '[', ']', '{', '}', '|', '^', '~','?','/','.');
        $slug = str_replace(' ','-',str_replace($string_replace, '', $title_slug)); 
        $tc = DB::table('blog_kategori')->where('slug', $slug)->get();                                    
        if (count($tc) > 0 ) {     
            if ($tc[0]->id == $id and $tc[0]->slug == $post['slug']) {                    
                $finisslug = $slug;
            }else{
                $slugs = $slug.'-'.count($tc);            
                $sc = DB::table('blog_kategori')->where('slug', $tc[0]->slug)->count();                
                if ($sc > 0) {
                    $finisslug = $slugs.'-'.$sc;
                }else{                    
                    $finisslug = $slug.'-'.count($tc);
                }
            }                                
        }else{
          $finisslug = $slug;  
        }
        if (trim(@$post['seo_judul']) == '' || @$post['seo_judul'] == null) {
            $post['seo_judul'] = strip_tags($post['judul']);
        }        
        return DB::table('blog_kategori')->where('id', $id)->update(array_merge($post, ['slug' => strtolower(str_replace('html','',$finisslug)).'.html']));
    }
    public function get_all_blog(Request $request)
    {
        $post = $request->input();
        if ($post['field'] == 'all') {
         $data = DB::table('blog')                
                ->leftjoin('blog_kategori', 'blog.id_blog_kategori', '=', 'blog_kategori.id')                
                ->select('blog.id','blog.slug','blog.judul','blog.view','blog.status','blog.gambar','blog_kategori.judul as kategori')
                ->orderBy('blog.id', $post['order'])
                ->paginate($post['much']);
        }else{            
            if ($post['field'] == 'blog.status') {                
                if ($post['cari'] == 'Draf' || $post['cari'] == 'draf') {
                    $post['cari'] = 0;
                }else{
                    $post['cari'] = 1;
                }
            }
            if ($post['field'] == 'blog.judul') {
                if ($post['cari'] == '') {
                    $post['field'] = 'blog.id';
                }
            }
         $data = DB::table('blog')
                ->leftjoin('blog_kategori', 'blog.id_blog_kategori', '=', 'blog_kategori.id')
                ->select('blog.id','blog.slug','blog.judul','blog.view','blog.status','blog.gambar','blog_kategori.judul as kategori')    
                ->orderBy($post['field'], $post['order'])
                ->where($post['field'],'like','%'.$post['cari'].'%')
                ->paginate($post['much']);
        }
        return $data;
    }
    public function hapus_kategori_blog($id)
    {
        blog_kategori::find($id)->delete();
    }
    public function hapus_blog($id)
    {
        $gambar_check = blog::select('gambar')->where('id',$id)->get();        
        if (file_exists(public_path('image/'.$gambar_check[0]['gambar']))) {
            @unlink(public_path('image/'.$gambar_check[0]['gambar']));
            @unlink(public_path('image/thumb/'.$gambar_check[0]['gambar']));
        }        
        blog::find($id)->delete();
        all_tag::where('id_blog', $id)->delete();
    }
    public function hapus_blog_multi(Request $request){
        $data = array(); 
        if(count($request->all()) == 0) {
            return response()->json(['error' => true],400);
        };
        foreach ($request->all() as $key => $value) {
            if($value){
                array_push($data,$key);
            }
        }
        
        
        $gambar_check = blog::select('gambar')->whereIn('id',$data)->get();        
        foreach ($gambar_check as $row) {            
            if (file_exists(public_path('image/'.$row['gambar']))) {
                @unlink(public_path('image/'.$row['gambar']));
                @unlink(public_path('image/thumb/'.$row['gambar']));
            }
        }
        
        blog::whereIn('id',$data)->delete();
        all_tag::whereIn('id_blog', $data)->delete();

        return response()->json(['success' => true],200);
    }
    // ------------
    public function kategori()
    {
        $data = kategori::all();
        if(count($data) == 0){
            kategori::create([
                'judul'=>'Tour Package',
                'slug'=>'tour-package.html',
                'status'=>1,
                'position'=>1
            ]);
            $data = kategori::all();
        }
        return $data;
    }
    public function kategori_position()
    {
        return kategori::orderBy('position','ASC')->get();
    }    
    
    public function up_kategori($id)
    {
        $positionup = kategori::find($id);   
        $positiondown = kategori::where('position',$positionup['position']-1)->first();
        kategori::find($positiondown['id'])->update(array('position' => $positiondown['position']+1 ));
        kategori::find($positionup['id'])->update(array('position' => $positionup['position']-1 ));
    }
    public function down_kategori($id)
    {
        $positiondown = kategori::find($id);   
        $positionup = kategori::where('position',$positiondown['position']+1)->first();        
        kategori::find($positionup['id'])->update(array('position' => $positionup['position']-1 ));
        kategori::find($positiondown['id'])->update(array('position' => $positiondown['position']+1 ));
    }
    public function kategori_baru(Request $request)
    {           
        $post = $request->input();                
        $title_slug = strip_tags($post['judul']);        
        $string_replace = array('\'', ';', '[', ']', '{', '}', '|', '^', '~','?','/','.');
        $slug = str_replace(' ','-',str_replace($string_replace, '', $title_slug)); 
        $tc = DB::table('kategori')->where('judul', $post['judul'])->get();                                    
        if (count($tc) > 0 ) {                 
            $slugs = $slug.'-'.count($tc);            
            $sc = DB::table('kategori')->where('slug', $tc[0]->slug)->count();                
            if ($sc > 0) {
                $finisslug = $slugs.'-'.$sc;
            }else{
                $finisslug = $slug.'-'.count($tc);
            }
        }else{
          $finisslug = $slug;  
        }
        //check seo kosong
        if (trim(@$post['seo_judul']) == '' || @$post['seo_judul'] == null) {
            $post['seo_judul'] = strip_tags($post['judul']);
        }
        if (trim(@$post['seo_kata_kunci']) == '' || @$post['seo_kata_kunci'] == null) {
            $post['seo_kata_kunci'] = strip_tags($post['judul']);
        }        
        //end check seo kosong
        $post['position']=DB::table('kategori')->count()+1;
        return kategori::create(array_merge($post, ['slug' => strtolower($finisslug).'.html']));
    }
    public function product_baru(Request $request)
    {           
        $post = $request->input();                        
        if (empty($post['id'])) {
            $id = product::create($request->all())->id;
            return $id;
        }else{
            $title_slug = strip_tags($post['judul']);        
            $string_replace = array('\'', ';', '[', ']', '{', '}', '|', '^', '~','?','/','.');
            $slug = str_replace(' ','-',str_replace($string_replace, '', $title_slug)); 
            $tc = DB::table('product')->where('id','!=',$post['id'])->where('judul', $post['judul'])->get();
            if (count($tc) > 0 ) {     
                $slugs = $slug.'-'.count($tc);            
                $sc = DB::table('product')->where('id','!=',$post['id'])->where('slug', $tc[0]->slug)->count();
                if ($sc > 0) {
                    $finisslug = $slugs.'-'.$sc;
                }else{
                    $finisslug = $slug.'-'.count($tc);
                }
            }else{
              $finisslug = $slug;
            }
            $galeri = galeri::where('id_product','=',$post['id'])->get();
            //check seo kosong
            if (trim(@$post['seo_judul']) == '' || @$post['seo_judul'] == null) {
                $post['seo_judul'] = strip_tags($post['judul']);
            }
            if (trim(@$post['seo_kata_kunci']) == '' || @$post['seo_kata_kunci'] == null) {
                $post['seo_kata_kunci'] = strip_tags($post['judul']);
            }
            if (trim(@$post['seo_deskripsi']) == '' || @$post['seo_deskripsi'] == null) {
                if (substr(strip_tags(@$post['deskripsi']),0,500) == '') {
                    $post['seo_deskripsi'] = '';
                }else{
                    $post['seo_deskripsi'] = substr(strip_tags(@$post['deskripsi']),0,500);                
                }
            }
            //end check seo kosong
            if (empty($post['gambar']) ) {
                if (count($galeri) != 0) {
                    $post['gambar'] = $galeri[0]->gambar;
                }
                product::find($post['id'])->update(array_merge($post, ['slug' => strtolower($finisslug).'.html']));        
            }else{
                $galeri_found = galeri::where('gambar','=',$post['gambar'])->where('id_product','=',$post['id'])->get();
                if (count($galeri_found) == 0) {                    
                    if (count($galeri) != 0) {    
                        $post['gambar'] = $galeri[0]->gambar;
                    }
                }
                product::find($post['id'])->update(array_merge($post, ['slug' => strtolower($finisslug).'.html']));        
            }
            // -----------------------------                
            if (empty($post['tag'])) {              
            }else{
                            
                $t = explode(',', $post['tag']);                
                foreach ($t as $key) {
                    $tag_baru = str_replace('-',' ',trim($key));
                    $tag_find = DB::table('tag')->where('judul', $tag_baru)->get();
                    if (count($tag_find) == 0) {                                            
                        $string_replace = array('\'', ';', '[', ']', '{', '}', '|', '^', '~','?','/','.');
                        $slug = str_replace(' ','-',trim(str_replace($string_replace, '', $key)));                 
                        $get_count = DB::table('tag')->where('judul', $tag_baru)->get();   
                        $tc = count($get_count);    
                        if ($tc > 0 ) {     
                            $slugs = $slug.'-'.$tc;
                            $slug_count = DB::table('tag')->where('judul', $tag_baru)->get();                          
                            $sc = count($slug_count);
                            if ($sc > 0) {
                                $tag_slug = $slugs.'-'.$sc;
                            }else{
                                $tag_slug = $slug.'-'.$tc;
                            }
                        }
                        else{$tag_slug = $slug;}
                        $data_tag = array('judul' => $tag_baru,
                                            'slug' => strtolower($tag_slug).'.html');
                        $tags = tag::create($data_tag);                  
                        $data_tag = array('id_tag' =>$tags->id,
                                            'id_product' => $post['id']);
                        if ($tag_baru != '') {
                            if (all_tag::where('id_tag','=',$tags->id)->where('id_product' ,'=', $post['id'])->get()->count() == 0) { 
                                all_tag::create($data_tag);       
                            }
                        }
                    }else{
                        $id_tag = $tag_find[0]->id;
                        $data_tag = array('id_tag' => $id_tag,
                                            'id_product' => $post['id']);
                        if ($tag_baru != '') {
                            if (all_tag::where('id_tag','=',$id_tag)->where('id_product' ,'=', $post['id'])->get()->count() == 0) {
                                all_tag::create($data_tag);                 
                            }
                        }
                    } 
                }
            
            }
        }
    }
    public function product_key_up_update(Request $request)
    {
        product::find($request->input('id'))->update($request->all());
    }
    public function product_gambar(Request $request)
    {                                               
            $galeri = array('gambar' => $request->input('text'),                            
                            'id_product' => $request->input('data'));
            galeri::create($galeri);        
    }  
    public function get_product_gambar($id)
    {
        return galeri::where('id_product','=',$id)->get();
    }
    public function hapus_product_gambar($id)
    {        
        $gambar_check = galeri::select('gambar')->where('id',$id)->get();                   
        if (file_exists(public_path('image/'.$gambar_check[0]['gambar']))) {
            @unlink(public_path('image/'.$gambar_check[0]['gambar']));
            @unlink(public_path('image/thumb/'.$gambar_check[0]['gambar']));
        }        
        galeri::find($id)->delete();
    }
    public function product_rubah($id='')
    {                               
         return product::find($id);
    }  
    public function product_update(Request $request,$id)
    {
        $post = $request->input();
        if (!empty($post['slug'])) {    
            $title_slug = strip_tags($post['slug']);        
        }else{
            $title_slug = strip_tags($post['judul']);
        }
        $string_replace = array('\'', ';', '[', ']', '{', '}', '|', '^', '~','?','/','.');
        $slug = str_replace(' ','-',str_replace($string_replace, '', $title_slug)); 
        $tc = DB::table('product')->where('slug', $slug)->get();                                    
        if (count($tc) > 0 ) {     
            if ($tc[0]->id == $id and $tc[0]->slug == $post['slug']) {                    
                $finisslug = $slug;
            }else{
                $slugs = $slug.'-'.count($tc);            
                $sc = DB::table('product')->where('slug', $tc[0]->slug)->count();                
                if ($sc > 0) {
                    $finisslug = $slugs.'-'.$sc;
                }else{
                    $finisslug = $slug.'-'.count($tc);
                }
            }                                
        }else{
          $finisslug = $slug;  
        } 
        // ----------
        if ($post['gambar'] == '') {                           
            unset($request['gambar']);
            unset($post['gambar']);
        }else{
            $gambar_check = product::select('gambar')->where('id',$post['id'])->get();           
            if ($post['gambar'] != $gambar_check[0]['gambar']) {
                if (file_exists(public_path('image/'.$gambar_check[0]['gambar']))) {
                    @unlink(public_path('image/'.$gambar_check[0]['gambar']));
                    @unlink(public_path('image/thumb/'.$gambar_check[0]['gambar']));
                }
            }
        }

        $galeri = galeri::where('id_product','=',$post['id'])->get();
        //check seo kosong
        if (trim(@$post['seo_judul']) == '' || @$post['seo_judul'] == null) {
            $post['seo_judul'] = strip_tags($post['judul']);
        }
        if (trim(@$post['seo_kata_kunci']) == '' || @$post['seo_kata_kunci'] == null) {
            $post['seo_kata_kunci'] = strip_tags($post['judul']);
        }
        if (trim(@$post['seo_deskripsi']) == '' || @$post['seo_deskripsi'] == null) {
            if (substr(strip_tags(@$post['deskripsi']),0,500) == '') {
                $post['seo_deskripsi'] = '';
            }else{
                $post['seo_deskripsi'] = substr(strip_tags(@$post['deskripsi']),0,500);                
            }
        }
        //end check seo kosong
        if (empty($post['gambar']) ) {
            if (count($galeri) != 0) {
                $post['gambar'] = $galeri[0]->gambar;
            }
            product::find($post['id'])->update(array_merge($post, ['slug' => strtolower(str_replace('html','',$finisslug)).'.html']));        
        }else{
            $galeri_found = galeri::where('gambar','=',$post['gambar'])->where('id_product','=',$post['id'])->get();
            if (count($galeri_found) == 0) {
                if (count($galeri) != 0) {    
                    $post['gambar'] = $galeri[0]->gambar;
                }
            }
            product::find($post['id'])->update(array_merge($post, ['slug' => strtolower(str_replace('html','',$finisslug)).'.html']));        
        }        
        all_tag::where('id_product', $id)->delete();
        // -----------------------------                
        if (empty($post['tag'])) {              
        }else{
             
            $t = explode(',', $post['tag']);                
            foreach ($t as $key){
                $tag_baru = str_replace('-',' ',trim($key));
                $tag_find = DB::table('tag')->where('judul', $tag_baru)->get();
                if (count($tag_find) == 0) {                                            
                    $string_replace = array('\'', ';', '[', ']', '{', '}', '|', '^', '~','?','/','.');
                    $slug = str_replace(' ','-',trim(str_replace($string_replace, '', $key)));                 
                    $get_count = DB::table('tag')->where('judul', $tag_baru)->get();   
                    $tc = count($get_count);    
                    if ($tc > 0 ) {     
                        $slugs = $slug.'-'.$tc;
                        $slug_count = DB::table('tag')->where('judul', $tag_baru)->get();                          
                        $sc = count($slug_count);
                        if ($sc > 0) {
                            $tag_slug = $slugs.'-'.$sc;
                        }else{
                            $tag_slug = $slug.'-'.$tc;
                        }
                    }
                    else{$tag_slug = $slug;}
                    $data_tag = array('judul' => $tag_baru,
                                        'slug' => strtolower($tag_slug).'.html');
                    $tags = tag::create($data_tag);              
                    $data_tag = array('id_tag' =>$tags->id,
                                        'id_product' => $id);                        
                    if ($tag_baru != '') {
                        if (all_tag::where('id_tag','=',$tags->id)->where('id_product' ,'=', $id)->get()->count() == 0) { 
                            all_tag::create($data_tag);                 
                        }
                    }
                }else{
                    $id_tag = $tag_find[0]->id;
                    $data_tag = array('id_tag' => $id_tag,
                                        'id_product' => $id);
                    if ($tag_baru != '') {
                        if (all_tag::where('id_tag','=',$id_tag)->where('id_product' ,'=', $id)->get()->count() == 0) {
                            all_tag::create($data_tag); 
                        }
                    }
                }
            } 
            
        }

    }
    public function kategori_rubah($id='')
    {                               
         return kategori::find($id);
    }
    public function get_tag_product($id)
    {
        $data = DB::table('all_tag')            
            ->join('tag', 'tag.id', '=', 'all_tag.id_tag')
            ->select('tag.judul as text')
            ->where('all_tag.id_product', '=', $id)
            ->lists('text');                        
            return implode(',',$data);
    }
    public function kategori_update(Request $request,$id)
    {
        $post = $request->input();
        if (!empty($post['slug'])) {    
            $title_slug = strip_tags($post['slug']);        
        }else{
            $title_slug = strip_tags($post['judul']);
        }      
        $string_replace = array('\'', ';', '[', ']', '{', '}', '|', '^', '~','?','/','.');
        $slug = str_replace(' ','-',str_replace($string_replace, '', $title_slug)); 
        $tc = DB::table('kategori')->where('slug', $slug)->get();                                    
        if (count($tc) > 0 ) {     
            if ($tc[0]->id == $id and $tc[0]->slug == $post['slug']) {                    
                $finisslug = $slug;
            }else{
                $slugs = $slug.'-'.count($tc);            
                $sc = DB::table('kategori')->where('slug', $tc[0]->slug)->count();                
                if ($sc > 0) {
                    $finisslug = $slugs.'-'.$sc;
                }else{
                    $finisslug = $slug.'-'.count($tc);
                }
            }                                
        }else{
          $finisslug = $slug;  
        }
        //check seo kosong
        if (trim(@$post['seo_judul']) == '' || @$post['seo_judul'] == null) {
            $post['seo_judul'] = strip_tags($post['judul']);
        }
        if (trim(@$post['seo_kata_kunci']) == '' || @$post['seo_kata_kunci'] == null) {
            $post['seo_kata_kunci'] = strip_tags($post['judul']);
        }        
        //end check seo kosong
        if ($post['gambar'] == '' ) {
            unset($request['gambar']);
            unset($post['gambar']);
        }else{
            $gambar_check = kategori::select('gambar')->where('id',$id)->get();           
            if ($post['gambar'] != $gambar_check[0]['gambar']) {
                if (file_exists(public_path('image/'.$gambar_check[0]['gambar']))) {
                    @unlink(public_path('image/'.$gambar_check[0]['gambar']));
                    @unlink(public_path('image/thumb/'.$gambar_check[0]['gambar']));
                }
            }
        }

        kategori::find($id)->update(array_merge($post, ['slug' => strtolower(str_replace('html','',$finisslug)).'.html']));
    }
    public function get_all_product(Request $request)
    {                                
        $post = $request->input();
        if ($post['field'] == 'all') {
        $data = DB::table('product')                
                ->leftjoin('kategori', 'product.id_kategori', '=', 'kategori.id')
                ->select('product.id','product.slug','product.judul','product.view','product.status','product.gambar','kategori.judul as kategori')                
                ->orderBy('product.id', $post['order'])                
                ->paginate($post['much']);        
        }else{            
            if ($post['field'] == 'product.status') {                
                if ($post['cari'] == 'Draf' || $post['cari'] == 'draf') {
                    $post['cari'] = 0;
                }else{
                    $post['cari'] = 1;
                }
            }
            if ($post['field'] == 'product.judul') {
                if ($post['cari'] == '') {
                    $post['field'] = 'product.id';
                }
            }
        $data = DB::table('product')
                ->leftjoin('kategori', 'product.id_kategori', '=', 'kategori.id')            
                ->select('product.id','product.slug','product.judul','product.view','product.status','product.gambar','kategori.judul as kategori')                
                ->orderBy($post['field'], $post['order'])
                ->where($post['field'],'like','%'.$post['cari'].'%')
                ->paginate($post['much']);
        }
        return $data;
    }
    public function hapus_kategori($id)
    {
        $gambar_check = kategori::select('gambar')->where('id',$id)->get();           
        
        if (file_exists(public_path('image/'.$gambar_check[0]['gambar']))) {
            @unlink(public_path('image/'.$gambar_check[0]['gambar']));
            @unlink(public_path('image/thumb/'.$gambar_check[0]['gambar']));
        }        
        $parent = kategori::find($id);
        $position = kategori::where('position','>',$parent['position'])->get();
        foreach ($position as $row) {          
            kategori::find($row->id)->update(array('position' => $row->position-1 ));
        }        
        kategori::find($id)->delete();        
    }
    public function hapus_product($id)
    {
        $gambar_check = product::select('gambar')->where('id',$id)->get();    
        if (file_exists(public_path('image/'.$gambar_check[0]['gambar']))) {
            @unlink(public_path('image/'.$gambar_check[0]['gambar']));
            @unlink(public_path('image/thumb/'.$gambar_check[0]['gambar']));
        }
    
        $delete_galeri = galeri::select('gambar')->where('id_product',$id)->get();
        foreach ($delete_galeri as $row) {
            if (file_exists(public_path('image/'.$row['gambar']))) {
                @unlink(public_path('image/'.$row['gambar']));
                @unlink(public_path('image/thumb/'.$row['gambar']));
            }   
        }
        product::find($id)->delete();
        galeri::where('id_product',$id)->delete();
        all_tag::where('id_product', $id)->delete();
        list_page_on_product::where('product_id',$id)->delete();
        product_widget::where('product_id',$id)->delete();
    }
    public function hapus_product_multi(Request $request){
        $data = array(); 
        if(count($request->all()) == 0) {
            return response()->json(['error' => true],400);
        };
        foreach ($request->all() as $key => $value) {
            if($value){
                array_push($data,$key);
            }
        }
        
        
        $gambar_check = product::select('gambar')->whereIn('id',$data)->get();        
        foreach ($gambar_check as $row) {            
            if (file_exists(public_path('image/'.$row['gambar']))) {
                @unlink(public_path('image/'.$row['gambar']));
                @unlink(public_path('image/thumb/'.$row['gambar']));
            }
        }
        
        product::whereIn('id',$data)->delete();
        all_tag::whereIn('id_product', $data)->delete();
        list_page_on_product::whereIn('product_id',$data)->delete();
        product_widget::whereIn('product_id',$data)->delete();

        return response()->json(['success' => true],200);
    }
    // -----------------------page
    public function page_rubah($id='')
    {                               
         return page::find($id);
    }  
    public function page_baru(Request $request)
    {           
        $post = $request->input();                        
        
        $title_slug = strip_tags($post['judul']);        
        $string_replace = array('\'', ';', '[', ']', '{', '}', '|', '^', '~','?','/','.');
        $slug = str_replace(' ','-',str_replace($string_replace, '', $title_slug)); 
        $tc = DB::table('page')->where('judul', $post['judul'])->get();                                    
        if (count($tc) > 0 ) {                 
            $slugs = $slug.'-'.count($tc);            
            $sc = DB::table('page')->where('slug', $tc[0]->slug)->count();                
            if ($sc > 0) {
                $finisslug = $slugs.'-'.$sc;
            }else{
                $finisslug = $slug.'-'.count($tc);
            }                                    
        }else{
          $finisslug = $slug;
        }
        if (@$post['status'] == true ||  @$post['status'] == 1 ||  @$post['status'] == "1") {
            $post['status'] = 1;
        }else{
            $post['status'] = 0;
        }
        //check seo kosong
        if (trim(@$post['seo_judul']) == '' || @$post['seo_judul'] == null) {
            $post['seo_judul'] = strip_tags($post['judul']);
        }
        if (trim(@$post['seo_kata_kunci']) == '' || @$post['seo_kata_kunci'] == null) {
            $post['seo_kata_kunci'] = strip_tags($post['judul']);
        }
        if (trim(@$post['seo_deskripsi']) == '' || @$post['seo_deskripsi'] == null) {
            if (substr(strip_tags(@$post['deskripsi']),0,500) == '') {
                $post['seo_deskripsi'] = '';
            }else{
                $post['seo_deskripsi'] = substr(strip_tags(@$post['deskripsi']),0,500);                
            }
        }
        //end check seo kosong
        page::create(array_merge($post, ['slug' => strtolower($finisslug).'.html']));
    
    }
    
    public function page_update(Request $request,$id)
    {
        $post = $request->input();
        if (!empty($post['slug'])) {
            $title_slug = strip_tags($post['slug']);        
        }else{
            $title_slug = strip_tags($post['judul']);
        }
        $string_replace = array('\'', ';', '[', ']', '{', '}', '|', '^', '~','?','/','.');
        $slug = str_replace(' ','-',str_replace($string_replace, '', $title_slug)); 
        $tc = DB::table('page')->where('slug', $slug)->get();                                    
        if (count($tc) > 0 ) {     
            if ($tc[0]->id == $id and $tc[0]->slug == $post['slug']) {                    
                $finisslug = $slug;
            }else{
                $slugs = $slug.'-'.count($tc);            
                $sc = DB::table('page')->where('slug', $tc[0]->slug)->count();                
                if ($sc > 0) {
                    $finisslug = $slugs.'-'.$sc;
                }else{
                    $finisslug = $slug.'-'.count($tc);
                }
            }                                
        }else{
          $finisslug = $slug;  
        } 
        // ----------
        if ($post['gambar'] == '') {                           
            unset($request['gambar']);
            unset($post['gambar']);
        }else{
            $gambar_check = page::select('gambar')->where('id',$id)->get();
            if ($post['gambar'] != $gambar_check[0]['gambar']) {
                if (file_exists(public_path('image/'.$gambar_check[0]['gambar']))) {
                    @unlink(public_path('image/'.$gambar_check[0]['gambar']));
                    @unlink(public_path('image/thumb/'.$gambar_check[0]['gambar']));
                }
            }
        }
        
        if (@$post['status'] == 'true') {
            $post['status'] = 1;
        }else{
            $post['status'] = 0;
        }        
        //check seo kosong
        if (trim(@$post['seo_judul']) == '' || @$post['seo_judul'] == null) {
            $post['seo_judul'] = strip_tags($post['judul']);
        }
        if (trim(@$post['seo_kata_kunci']) == '' || @$post['seo_kata_kunci'] == null) {
            $post['seo_kata_kunci'] = strip_tags($post['judul']);
        }
        if (trim(@$post['seo_deskripsi']) == '' || @$post['seo_deskripsi'] == null) {
            if (substr(strip_tags(@$post['deskripsi']),0,500) == '') {
                $post['seo_deskripsi'] = '';
            }else{
                $post['seo_deskripsi'] = substr(strip_tags(@$post['deskripsi']),0,500);                
            }
        }
        //end check seo kosong
        page::find($id)->update(array_merge($post, ['slug' => strtolower(str_replace('html','',$finisslug)).'.html']));
    }
    public function car_charter_baru(Request $request)
    {           
        $post = $request->input();
        if (@$post['status'] == true ||  @$post['status'] == 1 ||  @$post['status'] == "1") {
            $post['status'] = 1;
        }else{
            $post['status'] = 0;
        }
        page::create($post);                
    }  
    public function car_charter_update(Request $request,$id)
    {
        $post = $request->input();        
        if (@$post['gambar'] == '') {
            unset($request['gambar']);
            unset($post['gambar']);
        }else{            
            $gambar_check = page::select('gambar')->where('id',$id)->get();               
            if ($post['gambar'] != $gambar_check[0]['gambar']) {                
                if (file_exists(public_path('image/'.$gambar_check[0]['gambar']))) {
                    @unlink(public_path('image/'.$gambar_check[0]['gambar']));
                    @unlink(public_path('image/thumb/'.$gambar_check[0]['gambar']));
                }
            }
        }
        
        if (@$post['status'] == 'true') {
            $post['status'] = 1;
        }else{
            $post['status'] = 0;
        }
        page::find($id)->update($post);        
    }

    public function get_all_page(Request $request)
    {
        $post = $request->input();
        if ($post['field'] == 'all') {
         $data = DB::table('page') 
                ->orderBy('id', $post['order'])                  
                ->paginate($post['much']);
        }else{
            if ($post['field'] == 'page.judul') {
                if ($post['cari'] == '') {
                    $post['field'] = 'page.id';
                }
            }
         $data = DB::table('page')
                ->orderBy($post['field'], $post['order'])
                ->where($post['field'],'like','%'.$post['cari'].'%')                
                ->paginate($post['much']);
        }
        return $data;
    }
    public function all_page(Request $request)
    {
        $data = page::where('display','page')->orderby('judul','slug','asc')->get();
        return $data;
    }
    public function hapus_page($id)
    {
        $gambar_check = page::select('gambar')->where('id',$id)->get();        
        if (file_exists(public_path('image/'.$gambar_check[0]['gambar']))) {
            @unlink(public_path('image/'.$gambar_check[0]['gambar']));
            @unlink(public_path('image/thumb/'.$gambar_check[0]['gambar']));
        }        
        page::find($id)->delete();
    }

    public function hapus_page_multi(Request $request){
        $data = array(); 
        if(count($request->all()) == 0) {
            return response()->json(['error' => true],400);
        };
        foreach ($request->all() as $key => $value) {
            if($value){
                array_push($data,$key);
            }
        }        
        
        $gambar_check = page::select('gambar')->whereIn('id',$data)->get();        
        foreach ($gambar_check as $row) {            
            if (file_exists(public_path('image/'.$row['gambar']))) {
                @unlink(public_path('image/'.$row['gambar']));
                @unlink(public_path('image/thumb/'.$row['gambar']));
            }
        }
                
        page::whereIn('id',$data)->delete();

        return response()->json(['success' => true],200);
    }
    // -----------------setting
    // -----------------sosial media
    public function sosial_media()
    {
        return sosial_media::all();
    }
    public function sosial_media_baru(Request $request)
    {   
        $gambar='';
        $post = $request->input();
        if ($post['ikon'] == 'upload') {
            $gambar = $post['gambar'];
        }else{
            $gambar = $post['ikon'];
        }
        $data = array('judul' => $post['judul'],
                        'link' => $post['link'],
                        'gambar' => $gambar);        
        sosial_media::create($data);     
    }
    public function sosial_media_rubah($id='')
    {                               
         return sosial_media::find($id);
    }  
    public function sosial_media_update(Request $request,$id)
    {
        $post = $request->input();                    
        sosial_media::find($id)->update($request->all());
    }
    public function sosial_media_ikon(Request $request,$id)
    {
        $gambar = '';
        $post = $request->input();
        if ($post['ikon'] == 'upload') {
            $post['gambar'] = $post['gambar'];
        }else{
            $post['gambar'] = $post['ikon'];        
        }        
        sosial_media::find($id)->update($post);
    }
    public function hapus_sosial_media($id)
    {
        sosial_media::find($id)->delete();
    }
    // -----------------Kontak
    public function kontak()
    {
        return kontak::all();
    }
    public function kontak_baru(Request $request)
    {                           
        $post = $request->input();
        if (empty($post['gambar'])) {
            $request->request->add(['role' => 0]);
        }elseif ($post['gambar'] == 'sm/email.png') {
            $request->request->add(['role' => 1]);            
        }elseif($post['gambar'] == 'sm/phone.png'){
            $request->request->add(['role' => 2]);
        }elseif($post['gambar'] == 'sm/wa.png'){
            $request->request->add(['role' => 3]);
        }elseif($post['gambar'] == 'sm/wechat.png'){
            $request->request->add(['role' => 4]);
        }elseif($post['gambar'] == 'sm/kakaotalk.png'){
            $request->request->add(['role' => 5]);
        }elseif($post['gambar'] == 'sm/viber.png'){
            $request->request->add(['role' => 6]);
        }elseif($post['gambar'] == 'sm/line.png'){
            $request->request->add(['role' => 0]);
        }else{
            $request->request->add(['role' => 0]);
        }
         kontak::create($request->all());    
    }
    public function kontak_rubah($id='')
    {                               
         return kontak::find($id);
    }  
    public function kontak_update(Request $request,$id)
    {        
        $post = $request->input();        
        if (empty($post['gambar'])) {            
            $request->request->add(['role' => 0]); 
        }elseif ($post['gambar'] == 'sm/email.png') {
            $request->request->add(['role' => 1]);            
        }elseif($post['gambar'] == 'sm/phone.png'){
            $request->request->add(['role' => 2]);
        }elseif($post['gambar'] == 'sm/wa.png'){
            $request->request->add(['role' => 3]);
        }elseif($post['gambar'] == 'sm/wechat.png'){
            $request->request->add(['role' => 4]);
        }elseif($post['gambar'] == 'sm/kakaotalk.png'){
            $request->request->add(['role' => 5]);
        }elseif($post['gambar'] == 'sm/viber.png'){
            $request->request->add(['role' => 6]);
        }elseif($post['gambar'] == 'sm/line.png'){
            $request->request->add(['role' => 0]);
        }else{
            $request->request->add(['role' => 0]);
        }
        kontak::find($id)->update($request->all());        
    }    
    public function hapus_kontak($id)
    {
        kontak::find($id)->delete();
    }

    // ------------------ profile website
    public function profile_website()
    {
        $count = profile_website::all()->count();        
        if ($count == 0) {
            DB::table('profile_website')->insert(array('judul' => '' ));
        }
        return profile_website::all()->first();
    }
    public function profile_website_update(Request $request)
    {
        $post = $request->input();        
        return DB::table('profile_website')->where('id', $post['id'])->update($request->all());    
    }
    public function profile_website_logo(Request $request)
    {        
        $post = $request->input();
        $data = array('logo' => $post['gambar']);
        $gambar_check = profile_website::select('logo')->where('id',$post['id'])->get();        
        if (file_exists(public_path('image/'.$gambar_check[0]['logo']))) {
            @unlink(public_path('image/'.$gambar_check[0]['logo']));
            @unlink(public_path('image/thumb/'.$gambar_check[0]['logo']));
        }        
        DB::table('profile_website')->where('id', $post['id'])->update($data);        
    }
    public function profile_website_gambar(Request $request)
    {        
        $post = $request->input();
        $data = array('gambar' => $post['gambar']);
        $gambar_check = profile_website::select('gambar')->where('id',$post['id'])->get();        
        if (file_exists(public_path('image/'.$gambar_check[0]['gambar']))) {
            @unlink(public_path('image/'.$gambar_check[0]['gambar']));
            @unlink(public_path('image/thumb/'.$gambar_check[0]['gambar']));
        }
        DB::table('profile_website')->where('id', $post['id'])->update($data);        
    }
    


    // --------- administrator
    public function administrator()
    {               
        $data = administrator::all()->sortByDesc('id');            
        return $data;
    }
    public function administrator_edit($id='')
    {        
        $data = administrator::find($id);
        return $data;                
    }
    public function administrator_update(Request $request,$id)
    {                                       
        if ($request->input('newpassword') == '') {
            $data = array(  'name' => $request->input('name'),
                        'username' => $request->input('username'));
            administrator::find($id)->update($data);
            return response()->json(['success' => true]);
        }
        else {
            $data = array(  'name' => $request->input('name'),
                        'username' => $request->input('username'),
                        'password' => bcrypt($request->input('newpassword')));
            administrator::find($id)->update($data);
            return response()->json(['success' => true]);                 
        }
    }
    public function add_administrator(Request $request)
    {                 
        
        $data = array('name' => $request->input('name'),
                    'username' => $request->input('username'),
                    'password' => bcrypt($request->input('password')));          
        administrator::create($data);        
    }
    public function delete_administrator($id)
    {        
        administrator::find($id)->delete();                
    }
    //home setting
    public function home_setting()
    {
        $hs = DB::table('home_setting')->count();
        if ($hs == 0) {
            $data = [
                ['name' => 'Slider','status'=> 0,'judul' => 'Slider','posisi'=>1],
                ['name' => 'Profile','status'=> 0,'judul' => 'Profile','posisi'=>2],
                ['name' => 'Product','status'=> 0,'judul' => 'Product','posisi'=>3],
                ['name' => 'Special','status'=> 0,'judul' => 'Special','posisi'=>4],
                ['name' => 'Transport','status'=> 0,'judul' => 'Transport','posisi'=>5],
                ['name' => 'Booking','status'=> 0,'judul' => 'Booking','posisi'=>6]
            ];
            DB::table('home_setting')->insert($data);            
        }
        return DB::table('home_setting')->orderBy('posisi','ASC')->get();
    }
    public function home_setting_update(Request $request,$id)
    {
        unset($request['accordion']);
        return DB::table('home_setting')->where('id','=',$id)->update($request->all());   
    }
    public function setting_up($id)
    {
        $posisiup = DB::table('home_setting')->find($id);   
        $posisidown = DB::table('home_setting')->where('posisi',$posisiup->posisi-1)->first();
        DB::table('home_setting')->where('id','=',$posisidown->id)->update(array('posisi' => $posisidown->posisi+1 ));
        DB::table('home_setting')->where('id','=',$posisiup->id)->update(array('posisi' => $posisiup->posisi-1 ));
    }
    public function setting_down($id)
    {
        $posisidown = DB::table('home_setting')->find($id);
        $posisiup = DB::table('home_setting')->where('posisi',$posisidown->posisi+1)->first();
        DB::table('home_setting')->where('id','=',$posisiup->id)->update(array('posisi' => $posisiup->posisi-1 ));
        DB::table('home_setting')->where('id','=',$posisidown->id)->update(array('posisi' => $posisidown->posisi+1 ));
    }
    public function get_special()
    {
        $data = DB::table('special_offer')
                ->leftjoin('product','product.id','=','special_offer.id_product')
                ->leftjoin('page','page.id','=','special_offer.id_page')
                ->select('product.judul as product_jud','special_offer.id','page.judul as page_jud')
                ->orderBy('special_offer.position','ASC')
                ->get();
        return $data;
    }
    public function get_special_kategori($value='')
    {
        $category = DB::table('kategori')->select('id','judul','slug')->orderBy('judul','ASC')->get();
        foreach ($category as $row) {            
            $data['product'][$row->slug]['name'] = $row->judul;
            $data['product'][$row->slug]['id'] = $row->id;            
            $data['product'][$row->slug]['data'] = DB::table('product')->select('id','judul','slug','gambar')->where('id_kategori','=',$row->id)->where('status','=',1)->get();
        }
        return $data;
    }
    public function special_hapus($id)
    {       
        $parent = DB::table('special_offer')->where('id',$id)->first();        
        $position = DB::table('special_offer')->where('position','>',$parent->position)->get();    
        foreach ($position as $row) {          
            DB::table('special_offer')->where('id',$row->id)->update(array('position' => $row->position-1 ));
        }        
        DB::table('special_offer')->where('id',$id)->delete();
    } 
    public function special_hapus_multi(Request $request)
    {
        $data = array(); 
        if(count($request->all()) == 0) {
            return response()->json(['error' => true],400);
        };
        foreach ($request->all() as $key => $value) {
            if($value){
                array_push($data,$key);
            }
        }                    
        
        DB::table('special_offer')->whereIn('id',$data)->delete();        

        return response()->json(['success' => true],200);
    }
    public function kategori_setting(Request $request,$id)
    {
        $post = $request->input();
        $data = array('status' => $post['text'] );
        kategori::find($id)->update($data);
    }
    public function setting_active(Request $request,$id)
    {
        $post = $request->input();
        $data = array('status' => $post['text'] );
        DB::table('home_setting')->where('id','=',$id)->update($data);
    }    
    public function select_product(Request $request)
    {                 
        $post = $request->input();
        return product::where('id_kategori', $post['search'])->get();
    }
    public function spesial_produk_page(Request $request)
    {               
        $status = true;
        $warning = false;
        $post = $request->input();
        $ceck = DB::table('special_offer')->where('id_page','=',$post['text'])->count();
        $position = DB::table('special_offer')->count()+1;
        if ($ceck == 0) {                    
            $data = array('id_page' => $post['text'],'position'=>$position);
            DB::table('special_offer')->insert($data);
        }else{
            $status = false;
            $warning = true;

        }
        
        return response()->json(['success' => $status,'warning' => $warning]);
    }
    public function spesial_produk(Request $request)
    {                              
        $status = true;
        $warning = false;
        $post = $request->input();
        foreach ($post['text'] as $key) {
            $ceck = DB::table('special_offer')->where('id_product','=',$key)->count();
            $position = DB::table('special_offer')->count()+1;            
            if ($ceck == 0) {                    
                $data = array('id_product' => $key,'position'=>$position);
                DB::table('special_offer')->insert($data);
            }else{
                $status = false;
                $warning = true;

            }
        } 
        return response()->json(['success' => $status,'warning' => $warning]);
    }

    public function up_special_offer($id)
    {
        $positionup = DB::table('special_offer')->where('id',$id)->first();
        $positiondown = DB::table('special_offer')->where('position',$positionup->position-1)->first();
        DB::table('special_offer')->where('id',$positiondown->id)->update(array('position' => $positiondown->position+1 ));
        DB::table('special_offer')->where('id',$positionup->id)->update(array('position' => $positionup->position-1 ));
    }
    public function down_special_offer($id)
    {
        $positiondown = DB::table('special_offer')->where('id',$id)->first();
        $positionup = DB::table('special_offer')->where('position',$positiondown->position+1)->first();
        DB::table('special_offer')->where('id',$positionup->id)->update(array('position' => $positionup->position-1 ));
        DB::table('special_offer')->where('id',$positiondown->id)->update(array('position' => $positiondown->position+1 ));
    }

    //tag
    public function tag(Request $request)
    {
        $post = $request->input();
        if ($post['field'] == 'all') {
         $data = DB::table('tag')                                
                ->select('*')
                ->orderBy('id', $post['order'])                
                ->paginate($post['much']);        
        }else{
            if ($post['field'] == 'judul') {
                if ($post['cari'] == '') {
                    $post['field'] = 'id';
                }
            }
         $data = DB::table('tag')
                ->select('*')                
                ->orderBy($post['field'], $post['order'])
                ->where($post['field'],'like','%'.$post['cari'].'%')
                ->paginate($post['much']);
        }
        return $data;
        // return tag::all();
    } 
    public function tag_rubah($id='')
    {                               
         return tag::find($id);
    }
    public function tag_update(Request $request,$id)
    {
        $post = $request->input();
        if (!empty($post['slug'])) {    
            $title_slug = strip_tags($post['slug']);        
        }else{
            $title_slug = strip_tags($post['judul']);
        }       
        $string_replace = array('\'', ';', '[', ']', '{', '}', '|', '^', '~','?','/','.');
        $slug = str_replace(' ','-',str_replace($string_replace, '', $title_slug)); 
        $tc = DB::table('tag')->where('slug', $slug)->get();                                    
        if (count($tc) > 0 ) {     
            if ($tc[0]->id == $id and $tc[0]->slug == $post['slug']) {                    
                $finisslug = $slug;
            }else{
                $slugs = $slug.'-'.count($tc);            
                $sc = DB::table('tag')->where('slug', $tc[0]->slug)->count();                
                if ($sc > 0) {
                    $finisslug = $slugs.'-'.$sc;
                }else{
                    $finisslug = $slug.'-'.count($tc);
                }
            }                                
        }else{
          $finisslug = $slug;  
        } 
        
        return DB::table('tag')->where('id', $id)->update(array_merge($request->all(), ['slug' => strtolower(str_replace('html','',$finisslug)).'.html']));        
    }
    public function hapus_tag($id)
    {
        tag::find($id)->delete();
        DB::table('all_tag')->where('id_tag',$id)->delete();
    }

    //galeri
    public function galeri_kategori()
    {        
        $data = galeri_kategori::all();
        if(count($data) == 0){
            galeri_kategori::create([
                'judul'=>'Gallery',
                'slug'=>'gallery.html'            
            ]);
            $data = galeri_kategori::all();
        }
        return $data;
    } 
    public function galeri_kategori_baru(Request $request)
    {           
        $post = $request->input();                
        $title_slug = strip_tags($post['judul']);        
        $string_replace = array('\'', ';', '[', ']', '{', '}', '|', '^', '~','?','/','.');
        $slug = str_replace(' ','-',str_replace($string_replace, '', $title_slug)); 
        $tc = DB::table('galeri_kategori')->where('judul', $post['judul'])->get();                                    
        if (count($tc) > 0 ) {                 
            $slugs = $slug.'-'.count($tc);            
            $sc = DB::table('galeri_kategori')->where('slug', $tc[0]->slug)->count();                
            if ($sc > 0) {
                $finisslug = $slugs.'-'.$sc;
            }else{
                $finisslug = $slug.'-'.count($tc);
            }            
        }else{
          $finisslug = $slug;  
        }             
        return galeri_kategori::create(array_merge($request->all(), ['slug' => strtolower($finisslug).'.html']));


    }
    public function galeri_kategori_rubah($id='')
    {                               
         return galeri_kategori::find($id);
    }
    public function galeri_kategori_update(Request $request,$id)
    {
        $post = $request->input();
        if (!empty($post['slug'])) {    
            $title_slug = strip_tags($post['slug']);        
        }else{
            $title_slug = strip_tags($post['judul']);
        }      
        $string_replace = array('\'', ';', '[', ']', '{', '}', '|', '^', '~','?','/','.');
        $slug = str_replace(' ','-',str_replace($string_replace, '', $title_slug)); 
        $tc = DB::table('galeri_kategori')->where('slug', $slug)->get();                                    
        if (count($tc) > 0 ) {     
            if ($tc[0]->id == $id and $tc[0]->slug == $post['slug']) {                    
                $finisslug = $slug;
            }else{
                $slugs = $slug.'-'.count($tc);            
                $sc = DB::table('galeri_kategori')->where('slug', $tc[0]->slug)->count();                
                if ($sc > 0) {
                    $finisslug = $slugs.'-'.$sc;
                }else{
                    $finisslug = $slug.'-'.count($tc);
                }
            }                                
        }else{
          $finisslug = $slug;  
        }
        if ($post['gambar'] == '' ) {
            unset($request['gambar']);
            unset($post['gambar']);
        }else{            
            $gambar_check = galeri_kategori::select('gambar')->where('id',$id)->get();
            if ($post['gambar'] != $gambar_check[0]['gambar']) {
                if (file_exists(public_path('image/'.$gambar_check[0]['gambar']))) {
                    @unlink(public_path('image/'.$gambar_check[0]['gambar']));
                    @unlink(public_path('image/thumb/'.$gambar_check[0]['gambar']));
                }
            }
        }
        galeri_kategori::find($id)->update(array_merge($post, ['slug' => strtolower(str_replace('html','',$finisslug)).'.html']));

    }   

    public function hapus_kategori_galeri($id)
    {        
        galeri_kategori::find($id)->delete();
    }
    public function galeri_baru(Request $request)
    {          
        $post = $request->input();                        
        $data = array(  'gambar' => $post['text'],                        
                        'id_galeri_kategori' => $post['kategori']);        
        return galeri::create($data);
    }
    public function galeri(Request $request)
    {         
        $post = $request->input();
        if ($post['field'] == 'all') {
         $data = DB::table('galeri') 
                ->join('galeri_kategori', 'galeri.id_galeri_kategori', '=', 'galeri_kategori.id')
                ->select('galeri.id','galeri.judul','galeri.gambar','galeri_kategori.judul as kategori')
                ->orderBy('id', $post['order'])                                  
                ->where('id_product','=',0)
                ->paginate($post['much']);
        }else{
            if ($post['field'] == 'galeri.judul') {
                if ($post['cari'] == '') {
                    $post['field'] = 'galeri.id';
                }
            }
            $data = DB::table('galeri')
                ->join('galeri_kategori', 'galeri.id_galeri_kategori', '=', 'galeri_kategori.id')
                ->select('galeri.id','galeri.judul','galeri.gambar','galeri_kategori.judul as kategori')
                ->orderBy($post['field'], $post['order'])
                ->where($post['field'],'like','%'.$post['cari'].'%')                
                ->where('id_product','=',0)
                ->paginate($post['much']);
        }
        return $data;
    } 
    public function galeri_hapus($id)
    {
        $gambar_check = galeri::select('gambar')->where('id',$id)->get();        
        if (file_exists(public_path('gallery/'.$gambar_check[0]['gambar']))) {
            @unlink(public_path('gallery/'.$gambar_check[0]['gambar']));                
        }    
        galeri::find($id)->delete();
    }
    public function hapus_galeri_multi(Request $request){
        $data = array(); 
        if(count($request->all()) == 0) {
            return response()->json(['error' => true],400);
        };
        foreach ($request->all() as $key => $value) {
            if($value){
                array_push($data,$key);
            }
        }        
        
        $gambar_check = galeri::select('gambar')->whereIn('id',$data)->get();        
        foreach ($gambar_check as $row) {            
            if (file_exists(public_path('gallery/'.$row['gambar']))) {
                @unlink(public_path('gallery/'.$row['gambar']));                
            }
        }
        
        galeri::whereIn('id',$data)->delete();        

        return response()->json(['success' => true],200);
    }
    public function galeri_rubah($id)
    {                               
        return galeri::find($id);
    }
    public function galeri_update(Request $request,$id)
    {
        $post = $request->input();       
        $data = array(  'judul' => $post['judul'],                        
                        'id_galeri_kategori' => $post['id_galeri_kategori']);
        return DB::table('galeri')->where('id', $id)->update($data);
    }
    
    //slider
    public function up_slider($id)
    {
        $positionup = slider::find($id);
        $positiondown = slider::where('position',$positionup['position']-1)->first();
        slider::find($positiondown['id'])->update(array('position' => $positiondown['position']+1 ));
        slider::find($positionup['id'])->update(array('position' => $positionup['position']-1 ));        
    }
    public function down_slider($id)
    {
        $positiondown = slider::find($id);   
        $positionup = slider::where('position',$positiondown['position']+1)->first();        
        slider::find($positionup['id'])->update(array('position' => $positionup['position']-1 ));
        slider::find($positiondown['id'])->update(array('position' => $positiondown['position']+1 ));
    }
    public function slider_baru(Request $request)
    {
        $post = $request->input();
        $count = DB::table('slider')->count()+1;
        $data = array('gambar' => $post['text'],'position'=>$count);
        return slider::create($data);
    }
    public function slider()
    {              
        return slider::orderBy('position','ASC')->get();
    } 
    public function slider_hapus($id)
    {
        $gambar_check = slider::select('gambar')->where('id',$id)->get();        
            if (file_exists(public_path('gallery/'.$gambar_check[0]['gambar']))) {
                @unlink(public_path('gallery/'.$gambar_check[0]['gambar']));                
            }
        $parent = slider::find($id);
        $position = slider::where('position','>',$parent['position'])->get();
        foreach ($position as $row) {          
            slider::find($row->id)->update(array('position' => $row->position-1 ));
        }
        slider::find($id)->delete();
    }

    public function hapus_slider_multi(Request $request){
        $data = array(); 
        if(count($request->all()) == 0) {
            return response()->json(['error' => true],400);
        };
        foreach ($request->all() as $key => $value) {
            if($value){
                array_push($data,$key);
            }
        }        
        
        $gambar_check = slider::select('gambar')->whereIn('id',$data)->get();        
        foreach ($gambar_check as $row) {
            if (file_exists(public_path('gallery/'.$row['gambar']))) {
                @unlink(public_path('gallery/'.$row['gambar']));                
            }
        }
                
        slider::whereIn('id',$data)->delete();

        return response()->json(['success' => true],200);
    }


    public function slider_rubah($id)
    {                               
        return slider::find($id);
    }
    public function slider_update(Request $request,$id)
    {
        $post = $request->input();       
        $data = array(  'judul' => $post['judul']);
        return DB::table('slider')->where('id', $id)->update($data);        
    }
    //menu
    public function menu_baru(Request $request)
    {      
        $judul = '';
        $link =   '';
        $post = $request->input();                                
        $count = DB::table('menu')->count();
        if ($post['judul'] =='page') {
            $page = page::find($post['link']);
            $judul = $page['judul'];
            $link = $page['slug'];
            $data = array(  'judul' => $judul,  
                        'link' => $link,
                        'posisi' => $count+1,
                        'local_link' => 1);
        }elseif($post['judul'] =='kategori'){           
            $page = kategori::find($post['link']);
            $judul = $page['judul'];
            $link = $page['slug'];
            $data = array(  'judul' => $judul,
                        'link' => 'kategori',
                        'id_parent' => $post['link'],
                        'posisi' => $count+1,
                        'local_link' => 1);
        }elseif($post['judul'] =='blog'){
            $judul = 'Blog';
            $link =  $post['link'];
            $data = array(  'judul' => $judul,  
                        'link' => $link,
                        'posisi' => $count+1,
                        'local_link' => 1
                    );
        }elseif($post['judul'] =='contact'){
            $judul = 'Contact';
            $link =  $post['link'];
            $data = array(  'judul' => $judul,  
                        'link' => $link,
                        'posisi' => $count+1,
                        'local_link' => 1);
        }elseif($post['judul'] =='booking'){
            $judul = 'Booking';
            $link =  $post['link'];
            $data = array(  'judul' => $judul,  
                        'link' => $link,
                        'posisi' => $count+1,
                        'local_link' => 1);
        }elseif($post['judul'] =='gallery'){
            $judul = 'Gallery';
            $link =  $post['link'];
            $data = array(  'judul' => $judul,  
                        'link' => $link,
                        'posisi' => $count+1,
                        'local_link' => 1);
        }elseif($post['judul'] =='review'){
            $judul = 'Review';
            $link =  $post['link'];
            $data = array(  'judul' => $judul,  
                        'link' => $link,
                        'posisi' => $count+1,
                        'local_link' => 1);
        }elseif($post['judul'] =='home'){
            $judul = 'Home';
            $link =  $post['link'];
            $data = array(  'judul' => $judul,  
                        'link' => $link,
                        'posisi' => $count+1,
                        'local_link' => 1);
        }elseif($post['judul'] =='produk'){
            $page = product::find($post['link']);
            $judul = $page['judul'];
            $link = 'link/'.$page['slug'];
            $data = array(  'judul' => $judul,
                        'link' => $link,
                        'id_parent' => 0,
                        'posisi' => $count+1,
                        'local_link' => 1);
        }else{
            $judul = $post['judul'];
            $link =  $post['link'];
            $data = array(  'judul' => $judul,  
                        'link' => $link,
                        'posisi' => $count+1,
                        'local_link' => 0);
        }              
        menu::create($data);        
    }
    public function get_menu()
    {        
        $temp = DB::table('menu')->select('id','judul','posisi','link','local_link')->orderBy('posisi', 'asc')->get();
        $data = array();
        foreach($temp as $row){
            if ($row->local_link == 1 && $row->link != 'kategori') {
                $row->link = url($row->link);
                array_push($data,$row);
            }else{
                array_push($data,$row);
            }
        }
        return $data;

    }
    public function menu_update(Request $request,$id)
    {
        unset($request['accordion']);
        return DB::table('menu')->where('id','=',$id)->update($request->all());
    }
    public function menu_hapus($id)
    {
        $parent = menu::find($id);
        $posisi = DB::table('menu')->where('posisi','>',$parent['posisi'])->get();
        foreach ($posisi as $row) {          
            menu::find($row->id)->update(array('posisi' => $row->posisi-1 ));
        }        
        menu::find($id)->delete();
    }    
    public function menu_up($id)
    {
        $posisiup = menu::find($id);   
        $posisidown = DB::table('menu')->where('posisi',$posisiup->posisi-1)->first();
        menu::find($posisidown->id)->update(array('posisi' => $posisidown->posisi+1 ));
        menu::find($posisiup->id)->update(array('posisi' => $posisiup->posisi-1 ));
    }
    public function menu_down($id)
    {
        $posisidown = menu::find($id);   
        $posisiup = DB::table('menu')->where('posisi',$posisidown->posisi+1)->first();        
        menu::find($posisiup->id)->update(array('posisi' => $posisiup->posisi-1 ));
        menu::find($posisidown->id)->update(array('posisi' => $posisidown->posisi+1 ));
    }
    public function dashboard()
    {
       $data['ajaran'] = kategori_tahun::count();
       return $data;
    }
    // booking
    public function booking_list(Request $request)
    {        
        $post = $request->input();
        if ($post['field'] == 'all') {
         $data = DB::table('booking')
                ->select('id','nama','email','tanggal','hapus')
                ->orderBy('id', $post['order'])
                ->where('hapus','=',0)
                ->paginate($post['much']);
        }else{
            if ($post['field'] == 'booking.nama') {
                if ($post['cari'] == '') {
                    $post['field'] = 'booking.id';
                }
            }
         $data = DB::table('booking')
                ->select('id','nama','email','tanggal','hapus')
                ->orderBy($post['field'], $post['order'])
                ->where($post['field'],'like','%'.$post['cari'].'%')
                ->where('hapus','=',0)
                ->paginate($post['much']);
        }
        return $data;
    } 
    public function booking_single($id)
    {   
        $data['single'] = DB::table('booking')->where('id','=',$id)->first();
        return $data;
    } 
    public function booking_hapus($id)
    {   
        $data = array('hapus' => 1 );
        DB::table('booking')->where('id','=',$id)->update($data);
    }
    //footer
    public function get_footer($posisi)
    {
        if ($posisi == 1) {
            return DB::table('footer')->where('posisi','=',$posisi)->orderBy('id','ASC')->get();
        }elseif ($posisi == 2) {
            return DB::table('footer')->where('posisi','=',$posisi)->orderBy('id','ASC')->get();
        }elseif ($posisi == 3) {
            return DB::table('footer')->where('posisi','=',$posisi)->orderBy('id','ASC')->get();
        }        
    }
    public function add_footer(Request $request)
    {                             
        $judul = '';        
        switch ($request->input('role')) {
            case 1:
                $judul = 'Find Us';
                break;
            case 2:
                $judul = 'Contact';
                break;
            case 3:
                $judul = 'Logo';
                break;
            case 4:
                $judul = 'Deskripsi';
                break;
            case 5:
                $judul = 'Categorys';
                break;
            case 6:
                $judul = 'Profile Website';
                break;
            case 7:
                $judul = 'Special Offer';
                break;
            case 8:
                $judul = 'Menu';
                break;
            case 9:
                $judul = 'Gallery';
                break;
            case 10:
                $categori = kategori::where('id','=',$request->input('id_galeri_kategori'))->select('judul')->first();
                $judul = $categori->judul;
                break;
            case 11:
                $judul = 'Map';
                break;
            case 12:
                $judul = 'Blog';
                break;
            default:
                $judul = '';
                break;
        }
        footer::create(array_merge($request->all(), ['judul' => $judul]));        
    }
    public function edit_footer($id)
    {
        return footer::find($id);        
    }
    public function update_footer(Request $request,$id)
    {        
        footer::find($id)->update($request->all());
    }
    public function footer_hapus($id)
    {        
        footer::find($id)->delete();
    }
    //menu footer
    public function menu_footer(Request $request)
    {      
        $judul = '';
        $link =   '';

        $post = $request->input();                                        
        if($post['judul'] =='blog'){            
            $judul = 'Blog';
            $link =  $post['link'];
        }elseif($post['judul'] =='sitemap'){            
            $judul = 'Sitemap';
            $link =  $post['link'];
        }elseif($post['judul'] =='galeri'){            
            $judul = 'Gallery';
            $link =  $post['link'];
        }else{
            $judul = $post['judul'];
            $link =  $post['link'];
        }
        $data = array(  'judul' => $judul,  
                        'link' => $link);
        menu_footer::create($data);        
    }
    public function get_menu_footer()
    {
        return DB::table('menu_footer')->orderBy('id','ASC')->get();        
    }
    public function edit_menu_footer($id)
    {
        return menu_footer::find($id);        
    }
    public function update_menu_footer(Request $request,$id)
    {        
        menu_footer::find($id)->update($request->all());
    }    
    public function menu_footer_hapus($id)
    {        
        menu_footer::find($id)->delete();
    }
    //widget
    public function widget_add(Request $request){
        widget::create($request->all());
    }
    public function widget_edit($id){
        $data = widget::find($id);
        return $data;
    }
    public function widget_update(Request $request,$id){
        widget::find($id)->update($request->all());    
    }
    public function widget_get_all(Request $request)
    {
        $post = $request->input();
        if ($post['field'] == 'all') {
         $data = DB::table('widget') 
                ->orderBy('id', $post['order'])                  
                ->where('name','!=','Widget Label')
                ->paginate($post['much']);
        }else{
            if ($post['field'] == 'widget.name') {
                if ($post['cari'] == '') {
                    $post['field'] = 'widget.id';
                }
            }
         $data = DB::table('widget')
                ->orderBy($post['field'], $post['order'])
                ->where($post['field'],'like','%'.$post['cari'].'%')                
                ->where('name','!=','Widget Label')
                ->paginate($post['much']);
        }
        return $data;
    }
    public function widget_delete($id)
    {
        widget::find($id)->delete();        
    }

    public function widget_data_add(Request $request){        
        widget_data::create($request->all());
    }    
    public function widget_data_edit($id){
        $data = widget_data::find($id);
        return $data;
    }
    public function widget_data_update(Request $request,$id){
        widget_data::find($id)->update($request->all());    
    }
    public function widget_data_get_all(Request $request)
    {
        $post = $request->input();
        if ($post['field'] == 'all') {
         $data = DB::table('widget_data')
                ->leftjoin('widget','widget.id','=','widget_data.widget_id')
                ->select('widget.name as widget','widget_data.name','widget_data.id')
                ->orderBy('id', $post['order'])
                ->where('widget.name','!=','Widget Label')
                ->paginate($post['much']);
        }else{
            if ($post['field'] == 'widget_data.name') {
                if ($post['cari'] == '') {
                    $post['field'] = 'widget_data.id';
                }
            }
         $data = DB::table('widget_data')
                ->leftjoin('widget','widget.id','=','widget_data.widget_id')
                ->select('widget.name as widget','widget_data.name','widget_data.id')
                ->orderBy($post['field'], $post['order'])
                ->where($post['field'],'like','%'.$post['cari'].'%')
                ->where('widget.name','!=','Widget Label')
                ->paginate($post['much']);
        }
        return $data;
    }
    public function widget_data_delete($id)
    {
        widget_data::find($id)->delete();
        product_widget::where('widget_data_id',$id)->delete();
    }

    //widget for product
    public function widget_to_product_get_all()
    {
        $data = DB::table('widget_data')
            ->leftjoin('widget','widget.id','=','widget_data.widget_id')
            ->select('widget.name as widget','widget_data.name','widget_data.id')
            ->orderBy('widget.name','asc')
            ->orderBy('widget_data.name','asc')
            ->where('widget.name','!=','Widget Label')
            ->get();
            return $data;
    }

    public function add_widget_to_product(Request $request,$id)
    {
        $post = $request->input();
        $count_data_on_product = count(product_widget::where('product_id',$id)->get())+1;        
        foreach ($post['data'] as $key => $value) {
            if ($value == true || $value == 'true') {                
                $data =  array('product_id' => $id,
                                'position'=> $count_data_on_product,
                                'widget_data_id' => $key
                            );
                $count_data_on_product++;
                product_widget::create($data);
            }
        }
    }
    public function delete_widget_to_product($id)
    {    
        $parent = product_widget::find($id);
        $position = product_widget::where('position','>',$parent['position'])->where('product_id',$parent['product_id'])->get();
        foreach ($position as $row) {          
            product_widget::find($row->id)->update(array('position' => $row->position-1 ));
        }        
        product_widget::find($id)->delete();
    }    
    public function up_widget_to_product($id)
    {
        $positionup = product_widget::find($id);   
        $positiondown = product_widget::where('position',$positionup->position-1)->where('product_id',$positionup->product_id)->first();
        product_widget::find($positiondown->id)->update(array('position' => $positiondown->position+1 ));
        product_widget::find($positionup->id)->update(array('position' => $positionup->position-1 ));
    }
    public function down_widget_to_product($id)
    {
        $positiondown = product_widget::find($id);   
        $positionup = product_widget::where('position',$positiondown->position+1)->where('product_id',$positiondown->product_id)->first();        
        product_widget::find($positionup->id)->update(array('position' => $positionup->position-1 ));
        product_widget::find($positiondown->id)->update(array('position' => $positiondown->position+1 ));
    }
    public function get_widget_to_product($id){
        $data = DB::table('product_widget')
            ->leftjoin('widget_data','widget_data.id','=','product_widget.widget_data_id')
            ->leftjoin('widget','widget.id','=','widget_data.widget_id')
            ->select('widget_data.name','widget.name as widget','product_widget.id')
            ->orderBy('product_widget.position','ASC')
            ->where('product_widget.product_id',$id)
            ->where('widget.name','!=','Widget Label')
            ->get();
        return $data;
    }


    public function widget_for_select()
    {
        $data = widget::select('id','name')->orderBy('name','ASC')->where('name','!=','Widget Label')->get();
        return $data;
    }
    public function widget_for_label()
    {
        $data = DB::table('widget_data')
                ->select('widget_data.id','widget_data.name','widget_data.description')
                ->join('widget','widget.id','=','widget_data.widget_id')
                ->where('widget.name','Widget Label')
                ->orderby('widget_data.id','ASC')
                ->get();
        return $data;
    }
    public function update_widget_label(Request $request)
    {
        $post = $request->input();
        foreach ($post as $key => $value) {
            widget_data::find($key)->update(['description' => $value]);
        }
    }



    // list_page_on_product
    public function get_all_pages(Request $request)
    {
        $post = $request->input();
        if ($post['field'] == 'all') {
         $data = DB::table('page')                
                ->orderBy('id', $post['order'])  
                ->where('display','page')
                ->paginate($post['much']);                        
        }else{
            if ($post['field'] == 'page.judul') {
                if ($post['cari'] == '') {
                    $post['field'] = 'page.id';
                }
            }
         $data = DB::table('page')
                ->orderBy($post['field'], $post['order'])
                ->where($post['field'],'like','%'.$post['cari'].'%')
                ->where('display','page')
                ->paginate($post['much']);
        }
        return $data;
    }
    public function get_list_page_on_prouct($id)
    {
        $data = DB::table('list_page_on_product')->rightjoin('page','page.id','=','list_page_on_product.page_id')->where('product_id',$id)->orderBy('position','ASC')->select('list_page_on_product.id','page.judul','page.gambar')->get();
        return $data;
    }
    public function save_list_page_on_product(Request $request,$id)
    {
        $post = $request->input();
        $jumlah = count(list_page_on_product::where('product_id',$id)->get())+1;

        foreach ($post as $key) {
            list_page_on_product::create(['product_id'=>$id,'position'=>$jumlah,'page_id'=>$key['id']]);
            $jumlah++;
        }
    }
    public function delete_list_page_on_product($id='')
    {    
        $parent = list_page_on_product::find($id);
        $position = list_page_on_product::where('position','>',$parent['position'])->where('product_id',$parent['product_id'])->get();
        foreach ($position as $row) {          
            list_page_on_product::find($row->id)->update(array('position' => $row->position-1 ));
        }        
        list_page_on_product::find($id)->delete();
    }    
    public function up_list_page_on_product($id)
    {
        $positionup = list_page_on_product::find($id);   
        $positiondown = list_page_on_product::where('position',$positionup->position-1)->where('product_id',$positionup->product_id)->first();
        list_page_on_product::find($positiondown->id)->update(array('position' => $positiondown->position+1 ));
        list_page_on_product::find($positionup->id)->update(array('position' => $positionup->position-1 ));
    }
    public function down_list_page_on_product($id)
    {
        $positiondown = list_page_on_product::find($id);   
        $positionup = list_page_on_product::where('position',$positiondown->position+1)->where('product_id',$positiondown->product_id)->first();        
        list_page_on_product::find($positionup->id)->update(array('position' => $positionup->position-1 ));
        list_page_on_product::find($positiondown->id)->update(array('position' => $positiondown->position+1 ));
    }
    //logout 
    public function logout()
    {                
        session()->flush();
        session()->forget('status');
        session()->forget('name');        
        return response()->json(['success' => 'true']);
    }

    function calculateDimensions($width,$height,$maxwidth,$maxheight)
    {
        if($width != $height)
        {
            if($width > $height)
            {
                $t_width = $maxwidth;
                $t_height = (($t_width * $height)/$width);
                //fix height
                if($t_height > $maxheight)
                {
                    $t_height = $maxheight;
                    $t_width = (($width * $t_height)/$height);
                }
            }
            else
            {
                $t_height = $maxheight;
                $t_width = (($width * $t_height)/$height);
                //fix width
                if($t_width > $maxwidth)
                {
                    $t_width = $maxwidth;
                    $t_height = (($t_width * $height)/$width);
                }
            }
        }
        else
            $t_width = $t_height = min($maxheight,$maxwidth);

        return array('height'=>(int)$t_height,'width'=>(int)$t_width);
    }
    
    public function upload_to_galery(Request $request)
    {
        $post = $request->input();
        
        if($request->file('file') != null){

            $file = $request->file('file');
            list($width, $height) = getimagesize($file->getPathName());
            $calculate = $this->calculateDimensions($width,$height,1400,1400);

            $file = $request->file('file');
            $while = 0;
            $string_replace = array('\'', ';', '[', ']', '{', '}', '|', '^', '~','?','/');
            $file_name = str_replace(' ','-',str_replace($string_replace, '',$file->getClientOriginalName()));
            do {
                if (file_exists(public_path('gallery/'.$file_name))) {
                    $file_name = str_replace('.','-1.',$file_name);
                }else{
                    $file_name = $file_name;
                    $while = 1;
                }
            } while ($while <= 0);
            // $file->move('gallery/', $file_name);         
            
            if($width > 1400 || $height > 1400){
                $newfile = imagecreatefromjpeg($file->getPathName());
                $path =  public_path() . DIRECTORY_SEPARATOR . 'gallery' .DIRECTORY_SEPARATOR . $file_name;
                $canvas = imagecreatetruecolor($calculate['width'],$calculate['height']);
                imagecopyresampled($canvas,$newfile,0,0,0,0,$calculate['width'],$calculate['height'],$width,$height);                
                imagejpeg($canvas,$path,90);
            }else{
                $file->move('gallery/', $file_name);
            }

            return response()->json(['data'=>$file_name,'status' => 200]);
        }else{
            return response()->json(['data'=>'','status' => 400]);
        }        
    }
    public function upload_to_media(Request $request)
    {
        $post = $request->input();
        
        if($request->file('file') != null){

            $file = $request->file('file');
            list($width, $height) = getimagesize($file->getPathName());
            $calculate = $this->calculateDimensions($width,$height,1000,1000);

            $file = $request->file('file');
            $while = 0;
            $string_replace = array('\'', ';', '[', ']', '{', '}', '|', '^', '~','?','/');
            $file_name = str_replace(' ','-',str_replace($string_replace, '',$file->getClientOriginalName()));
            do {
                if (file_exists(public_path('media/'.$file_name))) {
                    $file_name = str_replace('.','-1.',$file_name);
                }else{
                    $file_name = $file_name;
                    $while = 1;
                }
            } while ($while <= 0);
            // $file->move('media/', $file_name);         
            
            if($width > 1000 || $height > 1000){
                $newfile = imagecreatefromjpeg($file->getPathName());
                $path =  public_path() . DIRECTORY_SEPARATOR . 'media' .DIRECTORY_SEPARATOR . $file_name;
                $canvas = imagecreatetruecolor($calculate['width'],$calculate['height']);
                imagecopyresampled($canvas,$newfile,0,0,0,0,$calculate['width'],$calculate['height'],$width,$height);                
                imagejpeg($canvas,$path,90);
            }else{
                $file->move('media/', $file_name);
            }

            media::create(['gambar'=>$file_name]);
            return response()->json(['data'=>$file_name,'status' => 200]);
        }else{
            return response()->json(['data'=>'','status' => 400]);
        }        
    }
    public function upload_to_gambar(Request $request)
    {
        $post = $request->input();
        if($request->file('file') != null){
            
            $file = $request->file('file');
            list($width, $height) = getimagesize($file->getPathName());
            $calculate = $this->calculateDimensions($width,$height,1000,1000);

            $while = 0;
            $string_replace = array('\'', ';', '[', ']', '{', '}', '|', '^', '~','?','/');            
            $file_name = str_replace(' ','-',str_replace($string_replace, '',$file->getClientOriginalName()));
            do {
                if (file_exists(public_path('image/'.$file_name))) {
                    $file_name = str_replace('.','-1.',$file_name);
                }else{
                    $file_name = $file_name;
                    $while = 1;
                }
            } while ($while <= 0);

            if($width > 1000 || $height > 1000){
                $newfile = imagecreatefromjpeg($file->getPathName());
                $path =  public_path() . DIRECTORY_SEPARATOR . 'image' .DIRECTORY_SEPARATOR . $file_name;
                $canvas = imagecreatetruecolor($calculate['width'],$calculate['height']);
                imagecopyresampled($canvas,$newfile,0,0,0,0,$calculate['width'],$calculate['height'],$width,$height);                
                imagejpeg($canvas,$path,90);
            }else{
                $file->move('image/', $file_name);
            }

            return response()->json(['data'=>$file_name,'status' => 200]);
        }else{
            return response()->json(['data'=>'','status' => 400]);
        }
    }

    public function clean_content(Request $request)
    {
        $post = $request->input();
        $cons = explode("\n",@$post['content']);
        $content = '';
        foreach($cons as $value){
            if($value != ''){
                $content = $content.'<p>'.strip_tags($value).'</p>';
            }
        }
        return response()->json(['data'=>$content,'status' => 200]);

    }
}
