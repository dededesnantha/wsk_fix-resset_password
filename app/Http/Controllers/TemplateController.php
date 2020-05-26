<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

use App\Models\template;
use App\Models\template_front;
use App\Models\template_color;
use App\Models\template_admin;
use DB;
use ZipArchive;
use Config;
use Storage;
class TemplateController extends Controller
{
    public function informasi_template(){
        $data = DB::table('template_front')->get()[0];
        return response()->json($data,200);
    }
    public function list_template()
    {
        $on_use = template_front::first();
        $template = DB::table('template')->orderBy('id','ASC')->get();
        
                
        $data = array(
            'on_use' => $on_use,
            'template' => $template     
        );
        return response()->json($data, 200);        
    }   
    
    public function move_from_temp($dir = '')
    {                        
        if (is_dir($dir)) {
            $files = glob($dir.'/*'); 
            foreach($files as $file){
                if(is_file($file)){                    
                    if (file_exists(str_replace('\temp/','/',$file))) {                        
                        unlink(str_replace('\temp/','/',$file));
                    }
                    rename($file, str_replace('\temp/','/',$file)); 
                }elseif(is_dir($file)){
                    if (!file_exists(str_replace('\temp','/',$file))) {
                        mkdir(str_replace('\temp','/',$file));
                    }
                    $this->move_from_temp($file);
                    
                }
            } 
        }        
    }
    public function upgrade_template(Request $request){
        $post = $request->input();
        $template_on_use = template_front::select('id_template')->first();
        
        if ($post['type_change'] == 'template') {
                $template = template::find($post['id']);
                
                $name =  explode('/',$template->source);
                $name = $name[count($name)-1];
                if (file_exists(public_path($name))) {
                    unlink(public_path($name));   
                }               
                $ch = curl_init($template->source);
                $fp = fopen(public_path($name), 'wb');
                curl_setopt($ch, CURLOPT_FILE, $fp);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_exec($ch);
                curl_close($ch);
                fclose($fp);
                
                if (file_exists(public_path($name))) {
                    $this->select_folder_del(public_path('/front'));
                    $zip = new ZipArchive;
                    $res = $zip->open(public_path($name));
                    
                    if ($res === TRUE) {
                        $zip->extractTo(base_path(''));
                        $zip->close();
                        unlink(public_path($name));
                    } else {
                        $zip->close();
                        return response()->json(['failed',false],404);
                    }
                    
                    $convert_style = $template->style;
                    
                    foreach($post['full_color'] as $key => $row){                
                        $convert_style = str_replace('['.$key.']',$row['color_select'],$convert_style);
                    }
        
                    file_put_contents(base_path('resources/views/front/component/template_style.blade.php'), '<style>'.$convert_style.'</style>');
                    $save_template = array(
                                        'id_template' => $post['id'],
                                        'custom_style' => $post['color'],
                                        'code_color' => $post['navigasi']
                                    );
                    DB::table('template_front')->truncate();
                    template_front::create($save_template);
                    return response()->json(['success',true],200);
                }else{
                    return response()->json(['failed',false],404);                    
                }                    
        }else{
            $template = template::find($template_on_use->id_template);
            $convert_style = $template->style;
            foreach($post['full_color'] as $key => $row){
                $convert_style = str_replace('['.$key.']',$row['color_select'],$convert_style);
            }

            file_put_contents(base_path('resources/views/front/component/template_style.blade.php'), '<style>'.$convert_style.'</style>');
            $save_template = array(
                                'id_template' => $template_on_use->id_template,
                                'custom_style' => $post['color'],
                                'code_color' => $post['navigasi']
                            );
            DB::table('template_front')->truncate();
            template_front::create($save_template);
            return response()->json(['success',true],200);
        }
    }

    public function upgrade_admin(){
        $template = template_admin::first();
        
        $name =  explode('/',$template->source);
        $name = $name[count($name)-1];
        if (file_exists(public_path($name))) {
            unlink(public_path($name));                    
        }
        $ch = curl_init($template->source);
        $fp = fopen(public_path($name), 'wb');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
        
        if (file_exists(public_path($name))) {            
            $zip = new ZipArchive;
            $res = $zip->open(public_path($name));
            
            if ($res === TRUE) {
                $zip->extractTo(base_path(''));
                $zip->close();
                unlink(public_path($name));
            } else {
                $zip->close();
                return response()->json(['failed',false],404);
            }

            return response()->json(['success',true],200);            
        } else {
            throw new ProcessFailedException($migration);
            return response()->json(['failed',false],400);
        }
    }

    public function select_folder_del($delete_dir = '')
    {        
        if (is_dir($delete_dir)) {
            $files = glob($delete_dir.'/*'); 
            foreach($files as $file){
                if(is_file($file)){                    
                    unlink($file);
                }elseif(is_dir($file)){
                    $this->select_folder_del($file);
                }
            }
        }
        if (file_exists($delete_dir)){
            rmdir($delete_dir);        
        }
    }


}
