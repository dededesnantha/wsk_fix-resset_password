<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;

use App\Models\product;
use App\Models\tag;
use App\Models\all_tag;

use App\Models\shortcut_blog_category;
use App\Models\shortcut_blog_keyword;
use App\Models\shortcut_blog_tag;

class SupportController extends Controller
{
    public function ImageGetCrop(Request $request,$size,$name_image = ' ')
    {               
        $folder = '';        
        switch (explode('/',$request->path())[0]) {
            case 'gambar':
                $folder = 'image';
                break;
            case 'galeri':
                $folder = 'gallery';
                break;
            case 'media':
                $folder = 'media';                
                break;
            default:
                $folder = 'image';
                break;
        }
        $resize = explode('x', $size);        
        $imagess = public_path().DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.str_replace('%20', ' ', $name_image);            
        
        $mobile = preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $request->header()['user-agent'][0]);
        
        if($mobile){
            if ((int) $resize[0] > 400) {                
                $resize[1] =  225;
                $resize[0] = 400;
            }
        }

        if(file_exists($imagess)){            
            switch (getimagesize($imagess)['mime']) {
                case 'image/jpeg':
                $image = imagecreatefromjpeg($imagess);
                break;
                case 'image/png':
                $image = imagecreatefrompng($imagess);
                break;
                case 'image/gif':
                    $image = imagecreatefromgif($imagess);
                    break;                
                default:
                    $imagess = public_path().DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'noimg.jpg';
                    $image = imagecreatefromjpeg($imagess);
                    break;
                }
            }else{
                $imagess = public_path().DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'noimg.jpg';
                $image = imagecreatefromjpeg($imagess);
            }        
            
        $thumb_width = (int)$resize[0];
        $thumb_height = (int)$resize[1];
        $width = imagesx($image);
        $height = imagesy($image);
        $original_aspect = $width / $height;
        $thumb_aspect = $thumb_width / $thumb_height;
        if ( $original_aspect >= $thumb_aspect )
        {       
            $new_height = $thumb_height;
            $new_width = $width / ($height / $thumb_height);
        }
        else
        {       
            $new_width = $thumb_width;
            $new_height = $height / ($width / $thumb_width);
        }        
        $thumb = imagecreatetruecolor( $thumb_width, $thumb_height );   
        imagecopyresampled($thumb,$image,0 - ($new_width - $thumb_width) / 2,0 - ($new_height - $thumb_height) / 2,0, 0,$new_width, $new_height,$width, $height);
        header("Content-Disposition: inline; filename=\"" . str_replace('%20', ' ', $name_image) . "\"");        
        switch (getimagesize($imagess)['mime']) {
            case 'image/jpeg':
                header("Content-type: image/jpeg");   
                imagejpeg($thumb, null, 75);                
                break;
            case 'image/png':
                header("Content-type: image/png");
                $transparant = imagecolorallocate($thumb, 255, 255, 255);
                imagefill($thumb,0,0,$transparant);
                imagecolortransparent($thumb, $transparant);
                imagepng($thumb);
                break;
            case 'image/gif':
                header("Content-type: image/gif");   
                imagejpeg($thumb, null, 75);
                break;                
            default:                
                header("Content-type: image/jpeg");   
                imagejpeg($thumb, null, 75);
                break;
        }
        imageDestroy($thumb); 

    }
    public function adding_tag(Request $request)
    {
        $post = $request->input();
        set_time_limit(6000);
        $count = product::where('id_kategori',$post['kategori'])->count();
        for ($i=0; $i < $count; $i++) {
            $each_product = product::where('id_kategori',$post['kategori'])->skip($i)->first();
            if ($each_product) {
                $count_product_tag = all_tag::where('id_product',$each_product->id)->count();
                if ($count_product_tag < 3) {
                    $tag = shortcut_blog_keyword::select('name')->where('shortcut_blog_keyword',$post['keyword'])->orderByRaw('RAND()')->take(3-$count_product_tag)->get();
                    if (count($tag) == 0) {
                        return response()->json(['message'=>'Tidak Ada Tag Tersedia , Hubungi Admin Untuk Penambahan Tag','status' => 400]);
                    }else{
                        foreach ($tag as $value) {

                            $count_tag = tag::where('judul',$value->name)->get();
                            if (count($count_tag) == 0) {
                                
                                //new tag
                                $block_caracter = array('\'', ';', '[', ']', '{', '}', '|', '^', '~','?','/','.');
                                $create_tag = array(
                                    'judul' => $value->name,
                                    'slug' => str_replace(' ','-',trim(str_replace($block_caracter, '', $value->name))).'.html',
                                );
                                $insert_tag = tag::create($create_tag);

                                // insert tag each product
                                all_tag::create(array(
                                    'id_product'=> $each_product->id,
                                    'id_tag'  => $insert_tag->id
                                ));

                            }else{
                                all_tag::create(array(
                                    'id_product'=> $each_product->id,
                                    'id_tag'  => $count_tag[0]->id
                                ));
                            }
                        }
                    }
                }
            }
        }
        return response()->json(['message'=> 'Berhasil Menyisipkan Tag Di Produk','status' => 200]);
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
}
