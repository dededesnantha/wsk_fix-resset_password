<html>
	<head>
		<title>Pendaftaran Ulang SMK Werdhi Sila Kumara</title>
	<style type="text/css" media="screen">
			html{ 
			background: #efefef }
		</style>
	</head>
	
	<body style=" color: #000;background: #fff;margin: 1rem auto;max-width:700px;overflow-x: hidden;font-family: sans-serif;">
		<div style="width: 100%;padding: 30px;display: table-cell;margin-top: 40px">

			<h1 style="color:#696969;text-align: center;padding-bottom: 25px;border-bottom: 3px solid;border-bottom-color: #27c24c;padding-top: 20px;">{{$site}}</h1>
			
			<h3>Hello {{$request['nama_lengkap']}},</h3>
			<span>silahkan melakukan pendaftaran ulang dengan mengirim photo bukti pembayaran di link berikut :</span> <a href="https://www.ppdb.wsk.sch.id/daftar/ulang" title="">https://www.ppdb.wsk.sch.id/daftar/ulang</a>
			<br>
			<br>
			<div style="text-align: center; background-color: #f2f2f2">
				<h3>Nomor Register :</h3>
				<h1>WSKPD - {{$request['no_registrasi']}}</h1>
				<h3>Kode :</h3>
				<h1>{{$request['kode']}}</h1>
			</div>
			<br>
			<br>

			<table>					
				<tbody>
					<tr>
						<td>Nama Lengkap</td>
						<td>:</td>
						<td>{{$request['nama_lengkap']}}</td>
					</tr> 					
					<tr>
						<td>Nama Panggilan</td>
						<td>:</td>
						<td>{{$request['nama_panggilan']}}</td>
					</tr>
					<tr>
						<td>Jenis Kelamin</td>
						<td>:</td>
						<td>{{$request['jk']}}</td>
					</tr>
					<tr>
						<td>NISN</td>
						<td>:</td>
						<td>{{$request['nisn']}}</td>
					</tr>
					<tr>
						<td>NIK</td>
						<td>:</td>
						<td>{{$request['NIK']}}</td>
					</tr>
					<tr>
						<td>No.KK</td>
						<td>:</td>
						<td>{{$request['no_kk']}}</td>
					</tr>
					<tr>
						<td>No.Akta</td>
						<td>:</td>
						<td>{{$request['no_akta']}}</td>
					</tr>
					<tr>
						<td>Hobby</td>
						<td>:</td>
						<td>{{$request['hobby']}}</td>
					</tr>
					<tr>
						<td>Tempat Lahir</td>
						<td>:</td>
						<td>{{$request['tempat_lahir']}}</td>
					</tr>
					<tr>
						<td>Tanggal Lahir</td>
						<td>:</td>
						<td>{{date('d-m-Y', strtotime($request['tanggal_lahir']))}}</td>
					</tr>
					<tr>
						<td>Asal Sekolah</td>
						<td>:</td>
						<td>{{$request['asal_sekolah']}}</td>
					</tr>
					<tr>
						<td>Alamat Sekolah</td>
						<td>:</td>
						<td>{{$request['alamat_sekolah']}}</td>
					</tr>
					<tr>
						<td>Berkebutuhan Khusus</td>
						<td>:</td>
						<td>{{$request['berkebutuhan_khusus']}}</td>
					</tr>
					<tr>
						<td>Agama</td>
						<td>:</td>
						<td>{{$request['agama']}}</td>
					</tr>
					<tr>
						<td>RT</td>
						<td>:</td>
						<td>{{$request['RT']}}</td>
					</tr>
					<tr>
						<td>Lintang</td>
						<td>:</td>
						<td>{{$request['lintang']}}</td>
					</tr>
					<tr>
						<td>Bujur</td>
						<td>:</td>
						<td>{{$request['bujur']}}</td>
					</tr>
					<tr>
						<td>RW</td>
						<td>:</td>
						<td>{{$request['RW']}}</td>
					</tr>
					<tr>
						<td>Tempat Tinggal</td>
						<td>:</td>
						<td>{{$request['tempat_tinggal']}}</td>
					</tr>
					<tr>
						<td>Transportasi</td>
						<td>:</td>
						<td>{{$request['transportasi']}}</td>
					</tr>
					<tr>
						<td>Kewarganegaraan</td>
						<td>:</td>
						<td>{{$request['kewarganegaraan']}}</td>
					</tr>
					<tr>
						<td>Suku Bangsa</td>
						<td>:</td>
						<td>{{$request['suku_bangsa']}}</td>
					</tr>
					<tr>
						<td>Anak Ke- </td>
						<td>:</td>
						<td>{{$request['anak_ke']}}</td>
					</tr>
					<tr>
						<td>Status Siswa</td>
						<td>:</td>
						<td>{{$request['status_siswa']}}</td>
					</tr>
					<tr>
						<td>Jumlah Saudara</td>
						<td>:</td>
						<td>{{$request['saudara']}}</td>
					</tr>
					<tr>
						<td>Alamat Rumah</td>
						<td>:</td>
						<td>{{$request['alamat_rumah']}}</td>
					</tr>
					<tr>
						<td>Kabupaten</td>
						<td>:</td>
						<td>{{$request['kabupaten']}}</td>
					</tr>
					<tr>
						<td>Kecamatan</td>
						<td>:</td>
						<td>{{$request['kecamatan']}}</td>
					</tr>
					<tr>
						<td>Kode Pos</td>
						<td>:</td>
						<td>{{$request['kode_pos']}}</td>
					</tr>
					<tr>
						<td>Alamat Pos</td>
						<td>:</td>
						<td>{{$request['alamat_pos']}}</td>
					</tr>
					<tr>
						<td>No Hp Siswa</td>
						<td>:</td>
						<td>{{$request['hpsiswa']}}</td>
					</tr>
					<tr>
						<td>No Tlp.Rumah</td>
						<td>:</td>
						<td>{{$request['tlp_rumah']}}</td>
					</tr>
					<tr>
						<td>Email</td>
						<td>:</td>
						<td><a href="mailto:{{$request['email']}}">{{$request['email']}}</a></td>
					</tr>
					<tr>
						<td>Golongan Darah</td>
						<td>:</td>
						<td>{{$request['golongan_darah']}}</td>
					</tr>
					<tr>
						<td>Tinggi Badan</td>
						<td>:</td>
						<td>{{$request['tinggi_badan']}}</td>
					</tr>
					<tr>
						<td>Berat Badan</td>
						<td>:</td>
						<td>{{$request['berat_badan']}}</td>
					</tr>
					<tr>
						<td>Lingkaran Kepala</td>
						<td>:</td>
						<td>{{$request['lingkaran_kepala']}}</td>
					</tr>
					<tr>
						<td>Riwayat Penyakit</td>
						<td>:</td>
						<td>{{$request['riwayat_penyakit']}}</td>
					</tr>
					<tr>
						<td>Keterangan</td>
						<td>:</td>
						<td>{{$request['keterangan']}}</td>
					</tr>
					<tr>
						<td>Status Pembayaran</td>
						<td>:</td>
						<td>{{$request['status_pembayaran']}}</td>
					</tr>
				</tbody>
			</table>
			<h3>Data nilai Ujian Nasional</h3>
			<table>					
				<tbody>
					<tr>
						<td>Bahasa Indonesia</td>
						<td>:</td>
						<td>{{$request['bahasa_indonesia']}}</td>
					</tr> 					
					<tr>
						<td>Bahasa Inggris</td>
						<td>:</td>
						<td>{{$request['bahasa_inggris']}}</td>
					</tr>
					<tr>
						<td>Matematika</td>
						<td>:</td>
						<td>{{$request['matematika']}}</td>
					</tr>
					<tr>
						<td>Ilmu Pengetahuan Alam</td>
						<td>:</td>
						<td>{{$request['ipa']}}</td>
					</tr>
				</tbody>
			</table>
			<h3>Data Prestasi Siswa</h3>
			<table>					
				<tbody>
					<tr>
						<td>Nilai Prestasi</td>
						<td>:</td>
						<td>{{$request['nilai_prestasi']}}</td>
					</tr>
				</tbody>
			</table>
			<h3>Data Program Keahlian Yang Dipilih</h3>
			<table>					
				<tbody>
					<tr>
						<td>Jurusan</td>
						<td>:</td>
						<td>{{$request['jurusan']}}</td>
					</tr>
				</tbody>
			</table>
			<h3>Data Orang Tua/Wali Siswa</h3>
			<table>					
				<tbody>
					<tr>
						<td>Nama Ayah</td>
						<td>:</td>
						<td>{{$request['nama_ayah']}}</td>
					</tr>
					<tr>
						<td>Nik Ayah</td>
						<td>:</td>
						<td>{{$request['nik_ayah']}}</td>
					</tr>
					<tr>
						<td>Pendidikan Ayah</td>
						<td>:</td>
						<td>{{$request['pendidikan_ayah']}}</td>
					</tr>
					<tr>
						<td>Pekerjaan Ayah</td>
						<td>:</td>
						<td>{{$request['pekerjaan_ayah']}}</td>
					</tr>
					<tr>
						<td>Penghasil Ayah</td>
						<td>:</td>
						<td>{{$request['penghasilan_ayah']}}</td>
					</tr>
					<tr>
						<td>No Hp Ayah</td>
						<td>:</td>
						<td>{{$request['hpayah']}}</td>
					</tr>
					<tr>
						<td>Tanggal Lahir Ayah</td>
						<td>:</td>
						<td>{{date('d-m-Y', strtotime($request['lahir_ayah']))}}</td>
					</tr>
					<tr>
						<td>Berkebutuhan Khusus</td>
						<td>:</td>
						<td>{{$request['penyakit_ayah']}}</td>
					</tr>
					<tr>
						<td>Nama Ibu</td>
						<td>:</td>
						<td>{{$request['nama_ibu']}}</td>
					</tr>
					<tr>
						<td>Nik Ibu</td>
						<td>:</td>
						<td>{{$request['nik_ibu']}}</td>
					</tr>
					<tr>
						<td>Tanggal Lahir Ibu</td>
						<td>:</td>
						<td>{{date('d-m-Y', strtotime($request['lahir_ibu']))}}</td>
					</tr>
					<tr>
						<td>Pendidikan Ibu</td>
						<td>:</td>
						<td>{{$request['pendidikan_ibu']}}</td>
					</tr>
					<tr>
						<td>Pekerjaan Ibu</td>
						<td>:</td>
						<td>{{$request['pekerjaan_ibu']}}</td>
					</tr>
					<tr>
						<td>Penghasil Ibu</td>
						<td>:</td>
						<td>{{$request['penghasilan_ibu']}}</td>
					</tr>
					<tr>
						<td>No Hp Ibuk</td>
						<td>:</td>
						<td>{{$request['hpibu']}}</td>
					</tr>
					<tr>
						<td>Berkebutuhan Khusus</td>
						<td>:</td>
						<td>{{$request['penyakit_ibu']}}</td>
					</tr>
					<tr>
						<td>Alamat Orangtua</td>
						<td>:</td>
						<td>{{$request['alamat_orangtua']}}</td>
					</tr>
					<tr>
						<td>Nama Wali</td>
						<td>:</td>
						<td>{{$request['nama_wali']}}</td>
					</tr>
					<tr>
						<td>Pendidikan Wali</td>
						<td>:</td>
						<td>{{$request['pendidikan_wali']}}</td>
					</tr>
					<tr>
						<td>Pekerjaan Wali</td>
						<td>:</td>
						<td>{{$request['pekerjaan_wali']}}</td>
					</tr>
					<tr>
						<td>Penghasil Wali</td>
						<td>:</td>
						<td>{{$request['penghasilan_wali']}}</td>
					</tr>
					<tr>
						<td>No Hp Wali</td>
						<td>:</td>
						<td>{{$request['hpwali']}}</td>
					</tr>
					<tr>
						<td>Alamat Wali</td>
						<td>:</td>
						<td>{{$request['alamat_wali']}}</td>
					</tr>
					<tr>
						<td>Status Asuh</td>
						<td>:</td>
						<td>{{$request['status_asuh']}}</td>
					</tr>
				</tbody>
			</table>
			<br>
			<br>
			<div style="color:grey;text-align: center;padding: 10px;background-color: #EDECEC">
				<strong style="color:#696969;">{{$site}}</strong><br>
				<small><a href="{{url('')}}" title="{{$site}}">{{url('')}}</a></small><br>
				<small>Powered by <a href="https://www.tayatha.com/" title="tayatha" target="_blank" class="w3-hover-opacity">tayatha</a></small>
			</div>
		</div>
	</body>
</html>