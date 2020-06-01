<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\administrator;
use App\Models\kategori_tahun;
use App\Models\mahasiswa;
use App\Models\kelas;
use App\Models\siswa;
use App\Models\pengumuman;
use DB;
use Session;
use ZipArchive;
use Config;
use Storage;
use Mail;

use Excel;

// library untuk FCM
use App\Helpers\Notification;

class adminController extends Controller
{    
    // ajaran
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

    // pengumuman
    //============
    // kelas 
public function kelas_baru(Request $request)
{
    $post = $request->input();
    kelas::create($post);
    return response()->json(['success'=>true],200);
}
public function get_all_kelas()
{
    return kelas::all();
}
public function get_rubah_kelas($id)
{                               
   return kelas::find($id);
}
public function get_update_kelas(Request $request, $id)
{
    $post = $request->input();
    kelas::find($id)->update($post);
    return response()->json(['success'=>true],200);
}
public function hapus_kelas($id)
{
    kelas::find($id)->delete();
}

    // siswa
public function all_kelas()
{
    return kelas::all();
}
public function siswa_baru(Request $request)
{
    $post = $request->input();
    if (empty($post['password'])) {
        $post['password'] = password_hash($post['nis'], PASSWORD_DEFAULT);
    }else{
        $post['password'] = password_hash($post['password'], PASSWORD_DEFAULT);
    }
    siswa::create($post);
    return response()->json(['success'=>true],200);
}
public function get_all_siswa(Request $request)
{                                
    $post = $request->input();

    if ($post['field'] == 'all') {
        $data = DB::table('siswa')                
        ->leftjoin('kelas', 'siswa.kelas_id', '=', 'kelas.id')
        ->select('siswa.id','siswa.nis','siswa.name','kelas.name as name_kelas')                
        ->orderBy('kelas.id', $post['order'])                
        ->paginate($post['much']);        
    }else{
        if ($post['field'] == 'siswa.nis') {
            if ($post['cari'] == '') {
                $post['field'] = 'siswa.id';
            }
        }
        $data = DB::table('siswa')
        ->leftjoin('kelas', 'siswa.kelas_id', '=', 'kelas.id')
        ->select('siswa.id','siswa.nis','siswa.name','kelas.name as name_kelas')                
        ->orderBy($post['field'], $post['order'])
        ->where($post['field'],'like','%'.$post['cari'].'%')
        ->paginate($post['much']);
    }
    return $data;
}
public function get_rubah_siswa($id)
{                               
   return siswa::find($id);
}
public function update_siswa(Request $request, $id)
{
    $post = $request->input();
    if ($request->input('newpassword') == '') {
        $data = array( 'nis' => $request->input('nis'),
            'name' => $request->input('name'),
            'kelas_id' => $request->input('kelas_id')
        );
        siswa::find($id)->update($data);
        return response()->json(['success'=>true],200);
    }
    else {
        $data = array( 'nis' => $request->input('nis'),
            'name' => $request->input('name'),
            'kelas_id' => $request->input('kelas_id'),
            'password' => bcrypt($request->input('newpassword'))
        );
        siswa::find($id)->update($data);
        return response()->json(['success'=>true],200);                
    }
}
public function hapus_siswa($id)
{
    siswa::find($id)->delete();
}

// pengumuman sekolah
public function pengumuman_sekolah(Request $request)
{
    $post = $request->input();
    $post['target_type'] = 'public';
    $post['publish_id'] = date('YmdHi');

    pengumuman::create($post);

    $data['siswa'] = DB::table('siswa')->select('device_id')->get();

    foreach ($array_siswa as $api_token) {
        $response = Notification::send([
            'to' => $api_token->device_id,
            'title' => $post['title'],
            'body' => substr(strip_tags($post['content']), 0,100),
            'data' => [
                    'dimulai' => $post['publish'],
                    'berakhir' => $post['end']
            ]
        ]);
        return response()->json($response);
    }
    
}

// pengumuman Kelas
public function pengumuman_kelas(Request $request)
{
    $post = $request->input();
    $post['target_type'] = 'class';
    $post['target_id'] = $post['kelas_id'];
    $post['publish_id'] = date('YmdHi');
    
    pengumuman::create($post);

    $data['siswa'] = DB::table('siswa')->select('device_id')->where('kelas_id','=',$post['target_id'])->get();

    foreach ($array_siswa as $api_token) {
        $response = Notification::send([
            'to' => $api_token->device_id,
            'title' => $post['title'],
            'body' => substr(strip_tags($post['content']), 0,100),
            'data' => [
                    'dimulai' => $post['publish'],
                    'berakhir' => $post['end']
            ]
        ]);

        return response()->json($response);
    }

}

// pengumuman siswa
public function pengumuman_siswa(Request $request)
{
    $post = $request->input();
    if (empty($post['siswa'])) {
        pengumuman::insert($post);
    }else{

        $siswa = explode(',', $post['siswa']);
        $date = date('YmdHi');
        $siswa_input = [];    
        foreach ($siswa as $Siswa) {
            $siswa_baru = str_replace('-',' ',trim($Siswa));
            $siswa_input = [
                'title' => $post['title'],
                'content' => $post['content'],
                'target_type' => 'personal',
                'target_id' => $siswa_baru,
                'publish' => $post['publish'],
                'end' => $post['end'],
                'publish_id' => date('YmdHi')
            ];
            pengumuman::insert($siswa_input);
        }

        $data_siswa = DB::table('siswa')->select('device_id')->whereIn('nis',$siswa)->get();
        foreach ($data_siswa as $siswa_value) {
            $response = Notification::send([
                'to' => $siswa_value->device_id,
                'title' => $post['title'],
                'body' => substr(strip_tags($post['content']), 0,100),
                'data' => [
                    'dimulai' => $post['publish'],
                    'berakhir' => $post['end']
                ]
            ]);
            return response()->json($response);
        }
    }

}
public function all_pengumuman(Request $request)
{                                
    $post = $request->input();

    if ($post['field'] == 'all') {
        $data = DB::table('pengumuman')
        ->select('id','title','content','target_type', DB::raw("COUNT(publish_id) as jumlah_title"))                
        ->groupBy('publish_id')                
        ->paginate($post['much']);

    }else{
        if ($post['field'] == 'title') {
            if ($post['cari'] == '') {
                $post['field'] = 'id';
            }
        }
        $data = DB::table('pengumuman')
        ->select('id','title','content','target_type', DB::raw("COUNT(publish_id) as jumlah_title"))                
        ->groupBy('publish_id')
        ->where($post['field'],'like','%'.$post['cari'].'%')
        ->paginate($post['much']);

    }
    return $data;
}

public function get_rubah_pengumuman($id)
{               
    $pengumuman = pengumuman::select('id','target_type','publish_id')->where('id',$id)->get();
    $array_data = [];
    foreach ($pengumuman as $key) {
        $array_data =[
            'id' => $key['id'],
            'target_type' => $key['target_type'],
            'publish_id' => $key['publish_id']
        ];
    }
    if ($array_data['target_type'] == 'personal') {

        $data = DB::table('pengumuman')
        ->select('title','content','target_type','publish','end','publish_id')
        ->where('id',$id)
        ->get();

        $target_id = DB::table('pengumuman')
        ->select('target_id')
        ->where('publish_id',$array_data['publish_id'])
        ->lists('target_id'); 

        $data['target_id'] = implode(',',$target_id);
        return $data;

    }elseif ($array_data['target_type'] == 'public') {
        $data = DB::table('pengumuman')
        ->select('title','content','target_type','publish','end','publish_id','target_id')
        ->where('id',$id)
        ->get();
        return $data;
    }elseif ($array_data['target_type'] == 'class') {
        $data = DB::table('pengumuman')
        ->select('title','content','target_type','publish','end','publish_id','target_id')
        ->where('id',$id)
        ->get();
        return $data;
    }
}
public function update_pengumuman(Request $request, $id)
{   

    $pengumuman = pengumuman::select('id','target_type','publish_id')->where('id',$id)->get();
    $array_data = [];
    foreach ($pengumuman as $key) {
        $array_data =[
            'id' => $key['id'],
            'target_type' => $key['target_type'],
            'publish_id' => $key['publish_id']
        ];
    }

    // update pengumuman siswa
    if ($array_data['target_type'] == 'personal') {
        $post = $request->input();
        pengumuman::where('publish_id', $post['publish_id'])->delete();
        $t = explode(',', $post['target_id']); 

            foreach ($t as $key) {
                $siswa_baru = str_replace('-',' ',trim($key));
                $view_siswa = pengumuman::select('target_id')->where('target_id',$siswa_baru)->get();

                $siswa_input = [];
                $siswa_input = [
                    'title' => $post['title'],
                    'content' => $post['content'],
                    'target_type' => 'personal',
                    'target_id' => $siswa_baru,
                    'publish' => $post['publish'],
                    'end' => $post['end'],
                    'publish_id' => $post['publish_id']
                ];
                pengumuman::where('publish_id', $post['publish_id'])->insert($siswa_input);
                }
               
                $siswa = DB::table('siswa')->select('device_id')->whereIn('nis',$t)->get();
                foreach ($siswa as $siswa_value) {
                        $response = Notification::send([
                            'to' => $siswa_value->device_id,
                            'title' => $post['title'],
                            'body' => substr(strip_tags($post['content']), 0,100),
                            'data' => [
                                'dimulai' => $post['publish'],
                                'berakhir' => $post['end']
                            ]
                        ]);
                    return response()->json($response);
                    }
                
    }

    //update pengumuman sekolah
    elseif($array_data['target_type'] == 'public') {
        $post = $request->input();
        pengumuman::find($id)->update($post);

        $data['siswa'] = DB::table('siswa')->select('device_id')->get();
        
        foreach ($data['siswa'] as $device_id) {
            $response = Notification::send([
                'to' => $device_id->device_id,
                'title' => $post['title'],
                'body' => substr(strip_tags($post['content']), 0,100),
                'data' => [
                    'dimulai' => $post['publish'],
                    'berakhir' => $post['end']
                ]
            ]);
            return response()->json($response);
        }
    
    }

    // update pengumuman kelas
    elseif($array_data['target_type'] == 'class') {
        $post = $request->input();
        pengumuman::find($id)->update($post);

        $data['siswa'] = DB::table('siswa')->select('device_id')->where('kelas_id','=',$post['target_id'])->get();

            foreach ($data['siswa'] as $api_token) {
                $response = Notification::send([
                    'to' => $api_token->device_id,
                    'title' => $post['title'],
                    'body' => substr(strip_tags($post['content']), 0,100),
                    'data' => [
                        'dimulai' => $post['publish'],
                        'berakhir' => $post['end']
                    ]
                ]);
            return response()->json($response);
            }

        
    }

}
public function hapus_pengumuman($id)
{
    $pengumuman = pengumuman::select('id','target_type','publish_id')->where('id',$id)->get();
    $array_data = [];
    foreach ($pengumuman as $key) {
        $array_data =[
            'id' => $key['id'],
            'target_type' => $key['target_type'],
            'publish_id' => $key['publish_id']
        ];
    }
    if ($array_data['target_type'] == 'personal') {
        pengumuman::find($id)->where('target_type','personal')->where('publish_id',$array_data['publish_id'])->delete();
    }elseif($array_data['target_type'] == 'public') {
        pengumuman::find($id)->where('target_type','public')->where('publish_id',$array_data['publish_id'])->delete();
    }elseif($array_data['target_type'] == 'class') {
        pengumuman::find($id)->where('target_type','class')->where('publish_id',$array_data['publish_id'])->delete();
    }

}

public function index()
{        
    return view('admin.index');
}
public function angular()
{
    return view('dashboard.index');
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
