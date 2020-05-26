<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Validator;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function validatePasswordRequest(Request $request)
    {
        
        $user = DB::table('siswa')->where('nis','=', $request->nis)
        ->first();
        
            //Check nis 
            if (empty($user)) {
                return redirect()->back()->withInput(Input::all())->with(['alert-error' => 'Nis Tidak Ditemukan']);
            }

        //create password resset
        DB::table('password_reset')->insert([
            'nis' => $request->nis,
            'token' => str_random(60)
        ]);

        //Get token yang sudah dibuat
        $tokenData = DB::table('password_reset')
            ->where('nis','=', $request->nis)->first();

        if (!empty($tokenData)) {
            return redirect('password_reset/token/'. $tokenData->token);
        }else{
            return redirect('password/reset')->withInput(Input::all())->with(['alert-error' => 'Nis Tidak Ditemukan']);
        }
    }   

    public function resetPassword($token)
    {
        $data['getToken'] = DB::table('password_reset')
            ->join('siswa','siswa.nis', '=', 'password_reset.nis' )
            ->where('password_reset.token','=', $token)
            ->first();

        if (!empty($data['getToken'])) {
             return view('front.password.resetpassword')->with($data);
        }else{
             return redirect('password/reset')->withInput(Input::all())->with(['alert-error' => 'Nis Tidak Ditemukan']);
        }
    }

    public function update_password(Request $request, $token)
    {
        //Validate input
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'konfirpasswrod' => 'required' 
        ]);

        //check jika validate salah
        if ($validator->fails()) {
             return redirect()->back()->with(['alert-error' => 'Silahkan Isi Dengan Lengkap']);
        }
            
         $password = $request->password;
         $konfirpasswrod = $request->konfirpasswrod;

        // Validate token
        $tokenData = DB::table('password_reset')
        ->where('token','=', $token)->first();

        if (!$tokenData) {  return redirect('password/reset')->withInput(Input::all())->with(['alert-error' => 'Nis Tidak Ditemukan']); }

        if ($password == $konfirpasswrod) {
            $siswa = DB::table('siswa')
            ->where('nis','=', $tokenData->nis)
            ->limit(1)
            ->update(array('password' => bcrypt($password)));

            if ($siswa) {
                DB::table('password_reset')->where('nis', $tokenData->nis)
                ->delete();
                 return redirect('password/reset')->withInput(Input::all())->with(['alert-success' => 'Password Update Berhasil']);
            }
            
        }else{
            return redirect()->back()->withInput(Input::all())->with(['alert-error' => 'Password Harus Sama']);
        }
    }
    
}
