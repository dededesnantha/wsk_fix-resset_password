<?php

namespace App\MOdels;

use Illuminate\Database\Eloquent\Model;

class mahasiswa extends Model
{
    protected $table = 'mahasiswa';
    protected $fillable = ['id_kategori_tahun',
    						'no_registrasi',
    						'kode',
    						'nama_lengkap',
    						'nama_panggilan',
    						'jk',
    						'nisn',
                            'NIK',
                            'no_kk',
    						'hobby',
    						'tempat_lahir',
    						'tanggal_lahir',
                            'no_akta',
                            'berkebutuhan_khusus',
    						'asal_sekolah',
    						'alamat_sekolah',
    						'agama',
                            'RT',
                            'RW',
    						'kewarganegaraan',
    						'suku_bangsa',
    						'anak_ke',
    						'status_siswa',
    						'beasiswa',
    						'saudara',
                            'tempat_tinggal',
                            'transportasi',
    						'alamat_rumah',
    						'provinsi',
    						'kabupaten',
    						'kecamatan',
    						'kode_pos',
    						'hpsiswa',
    						'tlp_rumah',
    						'email',
    						'golongan_darah',
    						'tinggi_badan',
    						'berat_badan',
    						'lingkaran_kepala',
    						'riwayat_penyakit',
    						'keterangan',
    						'bahasa_indonesia',
    						'matematika',
    						'bahasa_inggris',
    						'ipa',
    						'nilai_prestasi',
    						'jurusan',
    						'nama_ayah',
                            'nik_ayah',
    						'pendidikan_ayah',
    						'pekerjaan_ayah',
    						'penghasilan_ayah',
    						'hpayah',
                            'lahir_ayah',
                            'penyakit_ayah',
    						'nama_ibu',
                            'nik_ibu',
                            'lahir_ibu',
    						'pendidikan_ibu',
    						'pekerjaan_ibu',
    						'penghasilan_ibu',
    						'hpibu',
                            'penyakit_ibu',
    						'alamat_orangtua',
    						'nama_wali',
    						'pendidkan_wali',
    						'pekerjaan_wali',
    						'penghasilan_wali',
    						'hpwali',
    						'alamat_wali',
    						'status_asuh',
    						'status_pembayaran',
    						'gambar_konfirmasi',
                            'ukuran_baju',
                            'ukuran_celana',
                            'lintang',
                            'bujur',
                            'registrasi_ulang',
                            'created_at',
                            'updated_at']; 
}