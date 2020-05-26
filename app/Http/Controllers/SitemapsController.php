<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class SitemapsController extends Controller
{
    public function layout($value='')
    {    
        return response()->view('sitemap.layout')->header('Content-Type', 'text/xsl');     
    }
    public function home($value='')
    {        
        
        $data['load'] =  array(array('loc'=> url('tour-sitemap.xml'),
                                     'lastmod'=> @DB::table('product')->orderBy('updated_at','DESC')->take(1)->get()[0]->updated_at
                                    ),
                                array('loc'=> url('page-sitemap.xml'),
                                     'lastmod'=> @DB::table('page')->orderBy('updated_at','DESC')->take(1)->get()[0]->updated_at
                                    ),                                
                                array('loc'=> url('category-sitemap.xml'),
                                     'lastmod'=> @DB::table('kategori')->orderBy('updated_at','DESC')->take(1)->get()[0]->updated_at
                                    ),
                                array('loc'=> url('blog-sitemap.xml'),
                                     'lastmod'=>  @DB::table('blog')->orderBy('updated_at','DESC')->take(1)->get()[0]->updated_at
                                    ),
                                array('loc'=> url('tag-sitemap.xml'),
                                     'lastmod'=>  @DB::table('tag')->orderBy('updated_at','DESC')->take(1)->get()[0]->updated_at
                                    ),
                                array('loc'=> url('blog-category-sitemap.xml'),
                                     'lastmod'=> @DB::table('blog_kategori')->orderBy('updated_at','DESC')->take(1)->get()[0]->updated_at
                                    ),
                                array('loc'=> url('amp_tour-sitemap.xml'),
                                     'lastmod'=> @DB::table('product')->orderBy('updated_at','DESC')->take(1)->get()[0]->updated_at
                                    ),
                                array('loc'=> url('amp_page-sitemap.xml'),
                                     'lastmod'=> @DB::table('page')->orderBy('updated_at','DESC')->take(1)->get()[0]->updated_at
                                    ),                                
                                array('loc'=> url('amp_category-sitemap.xml'),
                                     'lastmod'=> @DB::table('kategori')->orderBy('updated_at','DESC')->take(1)->get()[0]->updated_at
                                    ),
                                array('loc'=> url('amp_blog-sitemap.xml'),
                                     'lastmod'=>  @DB::table('blog')->orderBy('updated_at','DESC')->take(1)->get()[0]->updated_at
                                    ),
                                array('loc'=> url('amp_tag-sitemap.xml'),
                                     'lastmod'=>  @DB::table('tag')->orderBy('updated_at','DESC')->take(1)->get()[0]->updated_at
                                    ),
                                array('loc'=> url('amp_blog-category-sitemap.xml'),
                                     'lastmod'=> @DB::table('blog_kategori')->orderBy('updated_at','DESC')->take(1)->get()[0]->updated_at
                                    )
                        );
        return response()->view('sitemap.home',$data)->header('Content-Type', 'text/xml');
    }
    public function page($value='')
    {        
        $data['image'] = true;
        $data['status'] = 'page';
        $data['image_url'] = asset('image').'/';
        $data['site_url'] = url('').'/';
        $data['load'] = DB::table('page')->where('status','=',1)->get();
        return response()->view('sitemap.content',$data)->header('Content-Type', 'text/xml');
    }
    public function product($value='')
    {        
        $data['image'] = true;
        $data['image_url'] = asset('image').'/';
        $data['site_url'] = url('link').'/';
        $data['load'] = DB::table('product')
                    ->where('status','=',1)->get();
        return response()->view('sitemap.content',$data)->header('Content-Type', 'text/xml');
    }
    public function category($value='')
    {        
        $data['image'] = true;
        $data['image_url'] = asset('image').'/';
        $data['site_url'] = url('category').'/';
        $data['load'] = DB::table('kategori')->get();
        return response()->view('sitemap.content',$data)->header('Content-Type', 'text/xml');
    }
    public function blog($value='')
    {        
        $data['image'] = true;
        $data['image_url'] = asset('image').'/';
        $data['site_url'] = url('blog').'/';
        $data['load'] = DB::table('blog')->where('status','=',1)->get();
        return response()->view('sitemap.content',$data)->header('Content-Type', 'text/xml');
    }
    public function tag($value='')
    {        
        $data['image'] = false;
        $data['image_url'] = '';
        $data['site_url'] = url('tag').'/';
        $data['load'] = DB::table('tag')->get();
        return response()->view('sitemap.content',$data)->header('Content-Type', 'text/xml');
    }
    public function blog_category($value='')
    {        
        $data['image'] = false;
        $data['image_url'] = '';
        $data['site_url'] = url('blog/category').'/';
        $data['load'] = DB::table('blog_kategori')->get();
        return response()->view('sitemap.content',$data)->header('Content-Type', 'text/xml');
    }  
    public function amp_page($value='')
    {        
        $data['image'] = true;
        $data['status'] = 'page';
        $data['image_url'] = asset('image').'/';
        $data['site_url'] = url('amp/').'/';
        $data['load'] = DB::table('page')->where('status','=',1)->get();
        return response()->view('sitemap.amp_content',$data)->header('Content-Type', 'text/xml');
    }
    public function amp_product($value='')
    {        
        $data['image'] = true;
        $data['image_url'] = asset('image').'/';
        $data['site_url'] = url('amp/link').'/';
        $data['load'] = DB::table('product')
                    ->where('status','=',1)->get();
        return response()->view('sitemap.amp_content',$data)->header('Content-Type', 'text/xml');
    }
    public function amp_category($value='')
    {        
        $data['image'] = true;
        $data['image_url'] = asset('image').'/';
        $data['site_url'] = url('amp/category').'/';
        $data['load'] = DB::table('kategori')->get();
        return response()->view('sitemap.amp_content',$data)->header('Content-Type', 'text/xml');
    }
    public function amp_blog($value='')
    {        
        $data['image'] = true;
        $data['image_url'] = asset('image').'/';
        $data['site_url'] = url('amp/blog').'/';
        $data['load'] = DB::table('blog')->where('status','=',1)->get();
        return response()->view('sitemap.amp_content',$data)->header('Content-Type', 'text/xml');
    }
    public function amp_tag($value='')
    {        
        $data['image'] = false;
        $data['image_url'] = '';
        $data['site_url'] = url('amp/tag').'/';
        $data['load'] = DB::table('tag')->get();
        return response()->view('sitemap.amp_content',$data)->header('Content-Type', 'text/xml');
    }
    public function amp_blog_category($value='')
    {        
        $data['image'] = false;
        $data['image_url'] = '';
        $data['site_url'] = url('amp/blog/category').'/';
        $data['load'] = DB::table('blog_kategori')->get();
        return response()->view('sitemap.amp_content',$data)->header('Content-Type', 'text/xml');
    }   
    
}
