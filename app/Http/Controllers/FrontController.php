<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\booking;
use App\Models\administrator;
use App\Exports\MahasiswaExport;
use Excel;
use DB;
use Mail;
use Session;
use Validator;
use Crypt;
use Image;
use Auth;


use App\Models\mahasiswa;
use App\Models\kategori_tahun;

use Cookie;

class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_daftar()
    {
       return view('front.daftar_mahasiswa');
    }
    public function index()
    {
        return view('front.home');
    }
    public function login_daftar(Request $request)
    {
        if (!empty($request->input('g-recaptcha-response'))) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify?secret='.env('CAPCHA_SECRET_KEY').'&response='.$request->input('g-recaptcha-response'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);                
            $output = curl_exec($ch);            
            curl_close($ch);
            $responseData = json_decode($output);
            if($responseData->success){
                $validate = Validator::make($request->all(), [
                    'no_registrasi' => 'required',
                    'kode' => 'required'
                ],[
                    'no_registrasi.required' => 'No register tidak boleh kosong',
                    'no_registrasi.number' => 'No register anda salah',
                    'kode.required' => 'Kode tidak boleh kosong',
                    'kode.number' => 'Kode anda salah',
                ]);
                   if($validate->fails()){
                    return redirect('/daftar/ulang')->with(['errors' => $validate->messages()]);
                }
                $data['request'] = $request->all();
                $data['data'] = mahasiswa::where('no_registrasi',$data['request']['no_registrasi'])->select('id','registrasi_ulang')->where('kode',$data['request']['kode'])->first();
                if ($data['data']) {
                    Session::put('no_registrasi',$data['request']['no_registrasi']);
                    Session::put('kode',$data['request']['kode']);
                    Session::put('daftar/ulang',TRUE);
                    if ($data['data']->registrasi_ulang == 'belum') {
                        $data['id_mahasiswa'] = Crypt::encrypt($data['data']->id);
                        return redirect('login/mahasiswa/'.$data['id_mahasiswa'])->with('alert-success', 'login berhasil');
                    }else{
                        return redirect('/daftar/ulang')->with(['alert-error' => 'Anda Sudah Melakukan Pendaftaran Ulang, Jika Ada Masalah Segera Hubungi Pihak Sekolah']);
                    }
                }else{
                    return redirect('/daftar/ulang')->with(['alert-error' => 'No register dan kode salah']);
                }
            }else{
                return redirect()->back()->withInput(Input::all())->with(['alert-error' => 'reCAPTCHA Waktu habis, Tolong ulangi']);
            }
        }else{
            return redirect()->back()->withInput(Input::all())->with('alert-error', 'Tolong Di Centang reCAPTCHA');  
        }
       
    }
    public function get_login($id='')
    {
       if(!Session::get('daftar/ulang')){
            return redirect('daftar/ulang')->with(['alert-error' => 'login terlebih dahulu']);
        }
        else{
            $id = Crypt::decrypt($id);
           $data['data'] = mahasiswa::where('id',$id)->first();
           return view('front.update_mahasiswa')->with($data);
        }
    }

    public function search(Request $request)
    {    
        $search = $request->get('search');
        if (!empty($search)) {
            $data['list'] = DB::table('mahasiswa')
                        ->join('kategori_tahun','kategori_tahun.id','=','mahasiswa.id_kategori_tahun')
                        ->select('mahasiswa.no_registrasi',
                            'mahasiswa.kode',
                            'mahasiswa.nama_lengkap',
                            'mahasiswa.nama_panggilan',
                            'mahasiswa.jk',
                            'mahasiswa.nisn',
                            'mahasiswa.hobby',
                            'mahasiswa.tempat_lahir',
                            'mahasiswa.tanggal_lahir',
                            'mahasiswa.asal_sekolah',
                            'mahasiswa.alamat_sekolah',
                            'mahasiswa.agama',
                            'mahasiswa.kewarganegaraan',
                            'mahasiswa.suku_bangsa',
                            'mahasiswa.anak_ke',
                            'mahasiswa.status_siswa',
                            'mahasiswa.beasiswa',
                            'mahasiswa.saudara',
                            'mahasiswa.alamat_rumah',
                            'mahasiswa.provinsi',
                            'mahasiswa.kabupaten',
                            'mahasiswa.kecamatan',
                            'mahasiswa.kode_pos',
                            'mahasiswa.hpsiswa',
                            'mahasiswa.tlp_rumah',
                            'mahasiswa.email',
                            'mahasiswa.golongan_darah',
                            'mahasiswa.tinggi_badan',
                            'mahasiswa.berat_badan',
                            'mahasiswa.lingkaran_kepala',
                            'mahasiswa.riwayat_penyakit',
                            'mahasiswa.keterangan',
                            'mahasiswa.bahasa_indonesia',
                            'mahasiswa.matematika',
                            'mahasiswa.bahasa_inggris',
                            'mahasiswa.ipa',
                            'mahasiswa.nilai_prestasi',
                            'mahasiswa.jurusan',
                            'mahasiswa.nama_ayah',
                            'mahasiswa.pendidikan_ayah',
                            'mahasiswa.pekerjaan_ayah',
                            'mahasiswa.penghasilan_ayah',
                            'mahasiswa.hpayah',
                            'mahasiswa.nama_ibu',
                            'mahasiswa.pendidikan_ibu',
                            'mahasiswa.pekerjaan_ibu',
                            'mahasiswa.penghasilan_ibu',
                            'mahasiswa.hpibu',
                            'mahasiswa.alamat_orangtua',
                            'mahasiswa.nama_wali',
                            'mahasiswa.pendidkan_wali',
                            'mahasiswa.pekerjaan_wali',
                            'mahasiswa.penghasilan_wali',
                            'mahasiswa.hpwali',
                            'mahasiswa.alamat_wali',
                            'mahasiswa.status_pembayaran',
                            'mahasiswa.status_asuh',
                            'mahasiswa.NIK',
                            'mahasiswa.no_kk',
                            'mahasiswa.no_akta',
                            'mahasiswa.berkebutuhan_khusus',
                            'mahasiswa.RT',
                            'mahasiswa.RW',
                            'mahasiswa.tempat_tinggal',
                            'mahasiswa.transportasi',
                            'mahasiswa.nik_ayah',
                            'mahasiswa.lahir_ayah',
                            'mahasiswa.penyakit_ayah',
                            'mahasiswa.nik_ibu',
                            'mahasiswa.lahir_ibu',
                            'mahasiswa.penyakit_ibu',
                            'mahasiswa.ukuran_baju',
                            'mahasiswa.ukuran_celana',
                            'mahasiswa.lintang',
                            'mahasiswa.bujur',
                            'mahasiswa.gambar_konfirmasi',
                            'kategori_tahun.tahun')
                        ->where('mahasiswa.no_registrasi','like','%'.$search.'%')->first(); 
            if (empty($data['list'])) {
                return redirect('/')->with(['alert-error' => 'No Register tidak Ditemukan']);
            }           
        }else{
            return redirect('/')->with(['alert-error' => 'No Register tidak Ditemukan']);
        }
        
        return view('front.search_mahasiswa')->with($data); 
    }

    public function mahasiswa_send(Request $request)
    {
        if (!empty($request->input('g-recaptcha-response'))) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify?secret='.env('CAPCHA_SECRET_KEY').'&response='.$request->input('g-recaptcha-response'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);                
            $output = curl_exec($ch);            
            curl_close($ch);
            $responseData = json_decode($output);
            if($responseData->success){

                $validate = Validator::make($request->all(), [
                    'nama_lengkap' => 'required|max:200',
                    'nama_panggilan' => 'required|max:200',
                    'hobby' => 'required|max:200',
                    'no_kk' => 'required',
                    'no_akta' => 'required',
                    'tempat_lahir' => 'required|max:200',
                    'asal_sekolah'=> 'required',
                    'alamat_sekolah' => 'required|max:200',
                    'agama'=> 'required',
                    'tempat_tinggal' => 'required',
                    'transportasi' => 'required',
                    'suku_bangsa' => 'required',
                    'saudara' => 'required',
                    'anak_ke' => 'required',
                    'alamat_rumah' => 'required',
                    'provinsi' => 'required',
                    'kabupaten' => 'required',
                    'kecamatan' => 'required',
                    'kode_pos' => 'required',
                    'hpsiswa' => 'required',
                    'email' => 'required|email',
                    'golongan_darah' => 'required',
                    'tinggi_badan' => 'required',
                    'berat_badan' => 'required',
                    'bahasa_indonesia' => 'required',
                    'bahasa_inggris' => 'required',
                    'matematika' => 'required',
                    'ipa' => 'required',
                    'nilai_prestasi' => 'required',
                    'jurusan' => 'required',
                    'nama_ayah' => 'required',
                    'nik_ayah' => 'required',
                    'lahir_ayah' => 'required',
                    'pendidikan_ayah' => 'required',
                    'pekerjaan_ayah' => 'required',
                    'penghasilan_ayah' => 'required',
                    'nama_ibu' => 'required',
                    'nik_ibu' => 'required',
                    'lahir_ibu' => 'required',
                    'pendidikan_ibu' => 'required',
                    'pekerjaan_ibu' => 'required',
                    'penghasilan_ibu' => 'required',
                    'alamat_orangtua' => 'required',
                    'status_asuh' => 'required'
                ],[
                    'nama_lengkap.required' => 'Nama tidak boleh kosong',
                    'nama_lengkap.max' => 'Nama Terlalu Panjang',
                    'hobby.required' => 'Hobby tidak boleh kosong',
                    'hobby.max' => 'hobby terlalu panjang',
                    'saudara.required' => 'Jumlah Saudara tidak boleh kosong',
                    'no_kk.required' => 'No KK tidak boleh kosong',
                    'no_akta.required' => 'No Akta tidak boleh kosong',
                    'tempat_tinggal.required' => 'Tempat Tinggal tidak boleh kosong',
                    'transportasi.required' => 'Transportasi tidak boleh kosong',
                    'tempat_lahir.required' => 'Tempat Lahit tidak boleh kosong',
                    'tempat_lahir.max' => 'Tempat Lahir terlalu panjang',
                    'asal_sekolah.required' => 'Asal Sekolah tidak boleh kosong',
                    'alamat_sekolah.required' => 'Alamat Sekolah tidak boleh kosong',
                    'agama.required' => 'agama tidak boleh kosong',
                    'suku_bangsa.required' => 'suku bangsa tidak boleh kosong',
                    'anak_ke.required' => 'anak tidak boleh kosong',
                    'alamat_rumah.required' => 'alamat rumah tidak boleh kosong',
                    'provinsi.required' => 'provinsi tidak boleh kosong',
                    'kabupaten.required' => 'kabupaten tidak boleh kosong',
                    'kecamatan.required' => 'kecamatan tidak boleh kosong',
                    'kode_pos.required' => 'kode_pos tidak boleh kosong',
                    'hpsiswa.required' => 'no hp siswa tidak boleh kosong',
                    'email.required' => 'Email tidak boleh kosong',
                    'email.email' => 'Email harus ada @gmail.com',
                    'golongan_darah.required' => 'golongan darah tidak boleh kosong',
                    'tinggi_badan.required' => 'tinggi badan tidak boleh kosong',  
                    'berat_badan.required' => 'berat badan tidak boleh kosong', 
                    'bahasa_indonesia.required' => 'bahasa indonesia tidak boleh kosong',
                    'bahasa_inggris.required' => 'bahasa inggris tidak boleh kosong',
                    'matematika.required' => 'matematika tidak boleh kosong',
                    'ipa.required' => 'ilmu pengetahuan alam tidak boleh kosong',
                    'nilai_prestasi.required' => 'nilai prestasi tidak boleh kosong',
                    'jurusan.required' => 'jurusan tidak boleh kosong',
                    'nama_ayah.required' => 'nama ayah tidak boleh kosong',
                    'nik_ayah.required' => 'Nik Ayah tidak boleh kosong',
                    'lahir_ayah.required' => 'Tanggal Lahir Ayah tidak boleh kosong',
                    'pendidikan_ayah.required' => 'pendidikan ayah tidak boleh kosong',
                    'pekerjaan_ayah.required' => 'pekerjaan ayah tidak boleh kosong',
                    'penghasilan_ayah.required' => 'penghasilan ayah tidak boleh kosong',
                    'nama_ibu.required' => 'nama ibu tidak boleh kosong',
                    'nik_ibu.required' => 'Nik ibu tidak boleh kosong',
                    'lahir_ibu.required' => 'Tanggal Lahir Ibu tidak boleh kosong',
                    'pendidikan_ibu.required' => 'pendidikan ibu tidak boleh kosong',
                    'pekerjaan_ibu.required' => 'pekerjaan ibu tidak boleh kosong',
                    'penghasilan_ibu.required' => 'penghasilan ibu tidak boleh kosong',
                    'alamat_orangtua.required' => 'alamat orangtua ibu tidak boleh kosong',
                    'status_asuh.required' => 'status anak asuh tidak boleh kosong',
                ]);
                if($validate->fails()){
                    return redirect()->back()->withInput(Input::all())->with(['errors' => $validate->messages()]);
                }
                $data['request'] = $request->all();
                $data['request']['kode'] = str_pad(rand(0,9200), 4, "0", STR_PAD_LEFT);

                $data['request']['created_at'] = date('Y-m-d H:i:s');
                $data['request']['updated_at'] = '';
                $data['request']['status_pembayaran'] = 'belum bayar';
                $data['request']['gambar_konfirmasi'] = '';
                $data['request']['registrasi_ulang'] = 'belum';

                $get_ajaran = DB::table('kategori_tahun')
                ->select('id','tahun')
                ->where('status',1)
                ->first();

                if (empty($get_ajaran)) {
                    return redirect('/')->with(['alert-error' => 'Tahun Ajaran Tidak Ada']);
                }
                $data['request']['id_kategori_tahun'] = $get_ajaran->id;

                $data['site'] = 'SMK Werdhi Sila Kumara';

                $get_mahasiswa = DB::table('mahasiswa')
                ->where('id_kategori_tahun', $data['request']['id_kategori_tahun'])
                ->select('no_registrasi')
                ->orderBy('created_at','DESC')
                ->first();
                if ($get_mahasiswa) {
                    $orderNr = $get_mahasiswa->no_registrasi;
                    $data['request']['no_registrasi'] = str_pad($orderNr + 1, 4,"0" , STR_PAD_LEFT);
                }else{
                    $tahun = $get_ajaran->tahun;
                    $data['request']['no_registrasi'] = $tahun.str_pad(1, 4, "0", STR_PAD_LEFT);
                }


                $id = mahasiswa::create($data['request'])->id;

                       // ke pengirim
                // Mail::send('front.email_mahasiswa.email',$data, function($message) use ($data)
                // {            
                //     $message->from(env('MAIL_USERNAME'),$data['site']);
                //     $message->to($data['request']['email'],$data['request']['nama_lengkap'])->subject('Terimakasih Sudah Melakukan Pendaftaran Awal SMK Werdhi Silakumara');                
                // });


                $data['id_mahasiswa'] = Crypt::encrypt($id);
                return redirect('pendaftaransiswa/'. $data['id_mahasiswa'])->with('alert-success', 'Selamat Anda sudah berhasil melakukan pendaftaran tahap awal. Silahkan cek inbox atau folder spam email anda. Lakukan Pembayaran dan segera melakukan pendaftaran ulang dengan mengirim foto bukti transfer pembayaran. Terimakasih');

            }else{
                return redirect()->back()->withInput(Input::all())->with(['alert-error' => 'reCAPTCHA Waktu habis, Tolong ulangi']);
            }
        }else{
            return redirect()->back()->withInput(Input::all())->with('alert-error', 'Tolong Di Centang reCAPTCHA');  
        }
        
    }

    public function get_mahasiswa($tokens)
    {
        $id = Crypt::decrypt($tokens);
        $data['data'] =DB::table('mahasiswa')
                    ->join('kategori_tahun','kategori_tahun.id','=','mahasiswa.id_kategori_tahun')
                    ->select('mahasiswa.no_registrasi',
                            'mahasiswa.kode',
                            'mahasiswa.nama_lengkap',
                            'mahasiswa.nama_panggilan',
                            'mahasiswa.jk',
                            'mahasiswa.nisn',
                            'mahasiswa.hobby',
                            'mahasiswa.tempat_lahir',
                            'mahasiswa.tanggal_lahir',
                            'mahasiswa.asal_sekolah',
                            'mahasiswa.alamat_sekolah',
                            'mahasiswa.agama',
                            'mahasiswa.kewarganegaraan',
                            'mahasiswa.suku_bangsa',
                            'mahasiswa.anak_ke',
                            'mahasiswa.status_siswa',
                            'mahasiswa.beasiswa',
                            'mahasiswa.saudara',
                            'mahasiswa.alamat_rumah',
                            'mahasiswa.provinsi',
                            'mahasiswa.kabupaten',
                            'mahasiswa.kecamatan',
                            'mahasiswa.kode_pos',
                            'mahasiswa.hpsiswa',
                            'mahasiswa.tlp_rumah',
                            'mahasiswa.email',
                            'mahasiswa.golongan_darah',
                            'mahasiswa.tinggi_badan',
                            'mahasiswa.berat_badan',
                            'mahasiswa.lingkaran_kepala',
                            'mahasiswa.riwayat_penyakit',
                            'mahasiswa.keterangan',
                            'mahasiswa.bahasa_indonesia',
                            'mahasiswa.matematika',
                            'mahasiswa.bahasa_inggris',
                            'mahasiswa.ipa',
                            'mahasiswa.nilai_prestasi',
                            'mahasiswa.jurusan',
                            'mahasiswa.nama_ayah',
                            'mahasiswa.pendidikan_ayah',
                            'mahasiswa.pekerjaan_ayah',
                            'mahasiswa.penghasilan_ayah',
                            'mahasiswa.hpayah',
                            'mahasiswa.nama_ibu',
                            'mahasiswa.pendidikan_ibu',
                            'mahasiswa.pekerjaan_ibu',
                            'mahasiswa.penghasilan_ibu',
                            'mahasiswa.hpibu',
                            'mahasiswa.alamat_orangtua',
                            'mahasiswa.nama_wali',
                            'mahasiswa.pendidkan_wali',
                            'mahasiswa.pekerjaan_wali',
                            'mahasiswa.penghasilan_wali',
                            'mahasiswa.hpwali',
                            'mahasiswa.alamat_wali',
                            'mahasiswa.status_pembayaran',
                            'mahasiswa.status_asuh',
                            'mahasiswa.NIK',
                            'mahasiswa.no_kk',
                            'mahasiswa.no_akta',
                            'mahasiswa.berkebutuhan_khusus',
                            'mahasiswa.RT',
                            'mahasiswa.RW',
                            'mahasiswa.tempat_tinggal',
                            'mahasiswa.transportasi',
                            'mahasiswa.nik_ayah',
                            'mahasiswa.lahir_ayah',
                            'mahasiswa.penyakit_ayah',
                            'mahasiswa.nik_ibu',
                            'mahasiswa.lahir_ibu',
                            'mahasiswa.penyakit_ibu',
                            'mahasiswa.ukuran_baju',
                            'mahasiswa.ukuran_celana',
                            'mahasiswa.lintang',
                            'mahasiswa.bujur',
                            'kategori_tahun.tahun')
                    ->where('mahasiswa.id',$id)
                    ->first();
        return view('front.layout_mahasiswa')->with($data);
    }

    public function update_daftar(Request $request, $id)
    {
        if (!empty($request->input('g-recaptcha-response'))) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify?secret='.env('CAPCHA_SECRET_KEY').'&response='.$request->input('g-recaptcha-response'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);                
            $output = curl_exec($ch);            
            curl_close($ch);
            $responseData = json_decode($output);
            if($responseData->success){
                $validate = Validator::make($request->all(), [
                    'gambar_konfirmasi' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1048'
                ],[
                    'gambar_konfirmasi.required' => 'Gambar Tidak Boleh Kosong',
                    'gambar_konfirmasi.mimes' => 'Bentuk Format File Salah',
                    'gambar_konfirmasi.max' => 'File Tidak boleh lebih besar 1MB'
                ]);
                if($validate->fails()){
                    return redirect()->back()->with(['errors' => $validate->messages()]);
                }
                $data['request'] = $request->all();
                if ($data['request']['ukuran_baju'] == 'S') {
                    $data['request']['ukuran_celana'] = "S";
                }
                if ($data['request']['ukuran_baju'] == 'M') {
                    $data['request']['ukuran_celana'] = "M";
                }
                if ($data['request']['ukuran_baju'] == 'L') {
                    $data['request']['ukuran_celana'] = "L";
                }
                if ($data['request']['ukuran_baju'] == 'XL') {
                    $data['request']['ukuran_celana'] = "XL";
                }
                if ($data['request']['ukuran_baju'] == 'XXL') {
                    $data['request']['ukuran_celana'] = "XXL";
                }
                if ($data['request']['ukuran_baju'] == 'XXXL') {
                    $data['request']['ukuran_celana'] = "XXXL";
                }
                if ($data['request']['ukuran_baju'] == 'XXXXL') {
                    $data['request']['ukuran_celana'] = "XXXXL";
                }
                if ($data['request']['ukuran_baju'] == 'Jumbo') {
                    $data['request']['ukuran_celana'] = "Jumbo";
                }

                $image = $request->file('gambar_konfirmasi');
                $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/images');
                $img = Image::make($image->getRealPath());
                $img->resize(300, 300, function ($constraint) {

                    $constraint->aspectRatio();

                })->save($destinationPath.'/'.$input['imagename']);

                $destinationPath = public_path('/images');
                $image->move($destinationPath, $input['imagename']);

                $data['request']['gambar_konfirmasi'] = $input['imagename'];
                $data['request']['registrasi_ulang'] = 'sudah';
                $data['request']['updated_at'] = date('Y-m-d H:i:s');

                mahasiswa::find($id)->update($data['request']);

                return redirect('pendaftaran/update/berhasil')->with('alert-success', 'Update Data Berhasil');
            }else{
                return redirect()->back()->withInput(Input::all())->with(['alert-error' => 'reCAPTCHA Waktu habis, Tolong ulangi']);
            }
        }else{
            return redirect()->back()->withInput(Input::all())->with('alert-error', 'Tolong Di Centang reCAPTCHA');  
        }
    }

    public function success_update()
    {
        return view('front.success');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Session::flush();
        return redirect('/daftar/ulang');
    }

    public function view_Pembayaran()
    {
         return view('front.pembayaran');
    }

    public function export_mahasiswa($type,$id)
    {
        $data = mahasiswa::where('id_kategori_tahun',$id)
                            ->join('kategori_tahun','kategori_tahun.id','=','mahasiswa.id_kategori_tahun')
                            ->where('registrasi_ulang','sudah')
                            ->select('mahasiswa.no_registrasi',
                            'mahasiswa.kode',
                            'mahasiswa.nama_lengkap',
                            'mahasiswa.nama_panggilan',
                            'mahasiswa.jk',
                            'mahasiswa.nisn',
                            'mahasiswa.hobby',
                            'mahasiswa.NIK',
                            'mahasiswa.no_kk',
                            'mahasiswa.no_akta',
                            'mahasiswa.tempat_lahir',
                            'mahasiswa.tanggal_lahir',
                            'mahasiswa.asal_sekolah',
                            'mahasiswa.alamat_sekolah',
                            'mahasiswa.agama',
                            'mahasiswa.RT',
                            'mahasiswa.RW',
                            'mahasiswa.tempat_tinggal',
                            'mahasiswa.transportasi',
                            'mahasiswa.kewarganegaraan',
                            'mahasiswa.suku_bangsa',
                            'mahasiswa.anak_ke',
                            'mahasiswa.status_siswa',
                            'mahasiswa.beasiswa',
                            'mahasiswa.saudara',
                            'mahasiswa.alamat_rumah',
                            'mahasiswa.provinsi',
                            'mahasiswa.kabupaten',
                            'mahasiswa.kecamatan',
                            'mahasiswa.kode_pos',
                            'mahasiswa.hpsiswa',
                            'mahasiswa.tlp_rumah',
                            'mahasiswa.email',
                            'mahasiswa.golongan_darah',
                            'mahasiswa.tinggi_badan',
                            'mahasiswa.berat_badan',
                            'mahasiswa.lingkaran_kepala',
                            'mahasiswa.riwayat_penyakit',
                            'mahasiswa.keterangan',
                            'mahasiswa.bahasa_indonesia',
                            'mahasiswa.matematika',
                            'mahasiswa.bahasa_inggris',
                            'mahasiswa.ipa',
                            'mahasiswa.nilai_prestasi',
                            'mahasiswa.jurusan',
                            'mahasiswa.nama_ayah',
                            'mahasiswa.pendidikan_ayah',
                            'mahasiswa.nik_ayah',
                            'mahasiswa.lahir_ayah',
                            'mahasiswa.penyakit_ayah',
                            'mahasiswa.pekerjaan_ayah',
                            'mahasiswa.penghasilan_ayah',
                            'mahasiswa.hpayah',
                            'mahasiswa.nama_ibu',
                            'mahasiswa.nik_ibu',
                            'mahasiswa.lahir_ibu',
                            'mahasiswa.penyakit_ibu',
                            'mahasiswa.pendidikan_ibu',
                            'mahasiswa.pekerjaan_ibu',
                            'mahasiswa.penghasilan_ibu',
                            'mahasiswa.hpibu',
                            'mahasiswa.alamat_orangtua',
                            'mahasiswa.nama_wali',
                            'mahasiswa.pendidkan_wali',
                            'mahasiswa.pekerjaan_wali',
                            'mahasiswa.penghasilan_wali',
                            'mahasiswa.hpwali',
                            'mahasiswa.alamat_wali',
                            'mahasiswa.status_pembayaran',
                            'mahasiswa.status_asuh',
                            'mahasiswa.berkebutuhan_khusus',
                            'mahasiswa.ukuran_baju',
                            'mahasiswa.ukuran_celana',
                            'mahasiswa.lintang',
                            'mahasiswa.bujur',
                            'mahasiswa.registrasi_ulang',
                            'kategori_tahun.tahun')
                            ->get();
            
        return Excel::create('Pendaftaransiswa Sudah Registrasi', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->export($type);

        return response()->json(['status'=>'ok'],200);
    }

    public function exports_mahasiswa($type,$id)
    {

        $data = mahasiswa::where('id_kategori_tahun',$id)
                            ->join('kategori_tahun','kategori_tahun.id','=','mahasiswa.id_kategori_tahun')
                            ->where('registrasi_ulang','belum')
                            ->select('mahasiswa.no_registrasi',
                            'mahasiswa.kode',
                            'mahasiswa.nama_lengkap',
                            'mahasiswa.nama_panggilan',
                            'mahasiswa.jk',
                            'mahasiswa.nisn',
                            'mahasiswa.hobby',
                            'mahasiswa.NIK',
                            'mahasiswa.no_kk',
                            'mahasiswa.no_akta',
                            'mahasiswa.tempat_lahir',
                            'mahasiswa.tanggal_lahir',
                            'mahasiswa.asal_sekolah',
                            'mahasiswa.alamat_sekolah',
                            'mahasiswa.agama',
                            'mahasiswa.RT',
                            'mahasiswa.RW',
                            'mahasiswa.tempat_tinggal',
                            'mahasiswa.transportasi',
                            'mahasiswa.kewarganegaraan',
                            'mahasiswa.suku_bangsa',
                            'mahasiswa.anak_ke',
                            'mahasiswa.status_siswa',
                            'mahasiswa.beasiswa',
                            'mahasiswa.saudara',
                            'mahasiswa.alamat_rumah',
                            'mahasiswa.provinsi',
                            'mahasiswa.kabupaten',
                            'mahasiswa.kecamatan',
                            'mahasiswa.kode_pos',
                            'mahasiswa.hpsiswa',
                            'mahasiswa.tlp_rumah',
                            'mahasiswa.email',
                            'mahasiswa.golongan_darah',
                            'mahasiswa.tinggi_badan',
                            'mahasiswa.berat_badan',
                            'mahasiswa.lingkaran_kepala',
                            'mahasiswa.riwayat_penyakit',
                            'mahasiswa.keterangan',
                            'mahasiswa.bahasa_indonesia',
                            'mahasiswa.matematika',
                            'mahasiswa.bahasa_inggris',
                            'mahasiswa.ipa',
                            'mahasiswa.nilai_prestasi',
                            'mahasiswa.jurusan',
                            'mahasiswa.nama_ayah',
                            'mahasiswa.pendidikan_ayah',
                            'mahasiswa.nik_ayah',
                            'mahasiswa.lahir_ayah',
                            'mahasiswa.penyakit_ayah',
                            'mahasiswa.pekerjaan_ayah',
                            'mahasiswa.penghasilan_ayah',
                            'mahasiswa.hpayah',
                            'mahasiswa.nama_ibu',
                            'mahasiswa.nik_ibu',
                            'mahasiswa.lahir_ibu',
                            'mahasiswa.penyakit_ibu',
                            'mahasiswa.pendidikan_ibu',
                            'mahasiswa.pekerjaan_ibu',
                            'mahasiswa.penghasilan_ibu',
                            'mahasiswa.hpibu',
                            'mahasiswa.alamat_orangtua',
                            'mahasiswa.nama_wali',
                            'mahasiswa.pendidkan_wali',
                            'mahasiswa.pekerjaan_wali',
                            'mahasiswa.penghasilan_wali',
                            'mahasiswa.hpwali',
                            'mahasiswa.alamat_wali',
                            'mahasiswa.status_pembayaran',
                            'mahasiswa.status_asuh',
                            'mahasiswa.berkebutuhan_khusus',
                            'mahasiswa.ukuran_baju',
                            'mahasiswa.ukuran_celana',
                            'mahasiswa.lintang',
                            'mahasiswa.bujur',
                            'mahasiswa.registrasi_ulang',
                            'kategori_tahun.tahun')
                            ->get();
            
        return Excel::create('Pendaftaransiswa Belum Registrasi', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->export($type);

        return response()->json(['status'=>'ok'],200);
    }

    // reset password
    public function resetPassword()
    {
        return view('front.password.lupa_password');
    }
}
