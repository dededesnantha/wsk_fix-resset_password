@extends('front.layout')


@section('content')
	<div class="container">
		
		<div class="c-12">
			@include('front.component.alert')
		</div>
		<div style="text-align: center; background-color: #b8b8b8; width: 80%; margin: 0 auto;">
			<h3>Nomor Register :</h3>
			<h1 style="margin: 0;">WSKPD - {{$data->no_registrasi}}</h1>
			<h3>Kode :</h3>
			<h1 style="margin: 0;">{{$data->kode}}</h1>
		</div>
		<table>
			<tr>
				<td>Tahun Ajaran</td>
				<td>{{$data->tahun}}</td>
			</tr>
			@if($data->status_pembayaran == 'lunas')
			<tr style="background-color: #067834;color: #fff">
				<td>Status Pembayaran</td>
				<td>{{$data->status_pembayaran}}</td>
			</tr>
			@else
			<tr style="background-color: #780606;color: #fff">
				<td>Status Pembayaran</td>
				<td>{{$data->status_pembayaran}}</td>
			</tr>
			@endif
			<tr>
				<td>Nama Lengkap</td>
				<td>{{$data->nama_lengkap}}</td>
			</tr>
			<tr>
				<td>Nama Panggilan</td>
				<td>{{$data->nama_panggilan}}</td>
			</tr>
			<tr>
				<td>Jenis Kelamin</td>
				<td>{{$data->jk}}</td>
			</tr>
			<tr>
				<td>NISN</td>
				<td>{{$data->nisn}}</td>
			</tr>
			<tr>
				<td>NIK</td>
				<td>{{$data->NIK}}</td>
			</tr>
			<tr>
				<td>No.KK</td>
				<td>{{$data->no_kk}}</td>
			</tr>
			<tr>
				<td>Hobby</td>
				<td>{{$data->hobby}}</td>
			</tr>
			<tr>
				<td>Tempat Lahir</td>
				<td>{{$data->tempat_lahir}}</td>
			</tr>
			<tr>
				<td>Tanggal Lahir</td>
				<td>{{ date('d-m-Y', strtotime($data->tanggal_lahir)) }}</td>
			</tr>
			<tr>
				<td>Asal Sekolah</td>
				<td>{{$data->asal_sekolah}}</td>
			</tr>
			<tr>
				<td>Alamat Sekolah</td>
				<td>{{$data->alamat_sekolah}}</td>
			</tr>
			<tr>
				<td>Berkebutuhan Khusus</td>
				<td>{{$data->berkebutuhan_khusus}}</td>
			</tr>
			<tr>
				<td>Agama</td>
				<td>{{$data->agama}}</td>
			</tr>
			<tr>
				<td>RT</td>
				<td>{{$data->RT}}</td>
			</tr>
			<tr>
				<td>RW</td>
				<td>{{$data->RW}}</td>
			</tr>
			<tr>
				<td>Tempat Tinggal</td>
				<td>{{$data->tempat_tinggal}}</td>
			</tr>
			<tr>
				<td>Mode Transportasi</td>
				<td>{{$data->transportasi}}</td>
			</tr>
			<tr>
				<td>Kewarganegaraan</td>
				<td>{{$data->kewarganegaraan}}</td>
			</tr>
			<tr>
				<td>Suku Bangsa</td>
				<td>{{$data->suku_bangsa}}</td>
			</tr>
			<tr>
				<td>Anak Ke-</td>
				<td>{{$data->anak_ke}}</td>
			</tr>
			<tr>
				<td>Status Siswa</td>
				<td>{{$data->status_siswa}}</td>
			</tr>
			<tr>
				<td>Beasiswa Yang Pernah Didapat</td>
				<td>{{$data->beasiswa}}</td>
			</tr>
			<tr>
				<td>Jumlah Saudara</td>
				<td>{{$data->saudara}}</td>
			</tr>
			<tr>
				<td>Alamat Rumah</td>
				<td>{{$data->alamat_rumah}}</td>
			</tr>
			<tr>
				<td>Provinsi</td>
				<td>{{$data->provinsi}}</td>
			</tr>
			<tr>
				<td>Kabupaten</td>
				<td>{{$data->kabupaten}}</td>
			</tr>
			<tr>
				<td>Kecamatan</td>
				<td>{{$data->kecamatan}}</td>
			</tr>
			<tr>
				<td>Kode Pos</td>
				<td>{{$data->kode_pos}}</td>
			</tr>
			<tr>
				<td>Lintang</td>
				<td>{{$data->lintang}}</td>
			</tr>
			<tr>
				<td>Bujur</td>
				<td>{{$data->bujur}}</td>
			</tr>
			<tr>
				<td>No Hp Siswa</td>
				<td>{{$data->hpsiswa}}</td>
			</tr>
			<tr>
				<td>No Tlp.Rumah</td>
				<td>{{$data->tlp_rumah}}</td>
			</tr>
			<tr>
				<td>Email</td>
				<td>{{$data->email}}</td>
			</tr>
			<tr>
				<td>Golongan Darah</td>
				<td>{{$data->golongan_darah}}</td>
			</tr>
			<tr>
				<td>Tinggi Badan</td>
				<td>{{$data->tinggi_badan}}</td>
			</tr>
			<tr>
				<td>Berat Badan</td>
				<td>{{$data->berat_badan}}</td>
			</tr>
			<tr>
				<td>Lingkaran Kepala</td>
				<td>{{$data->lingkaran_kepala}}</td>
			</tr>
			<tr>
				<td>Riwayat Penyakit</td>
				<td>{{$data->riwayat_penyakit}}</td>
			</tr>
			<tr>
				<td>Keterangan Lain</td>
				<td>{{$data->keterangan}}</td>
			</tr>
			<tr>
				<td>Ukuran Baju</td>
				<td>{{$data->ukuran_baju}}</td>
			</tr>
			<tr>
				<td>Ukuran Celana</td>
				<td>{{$data->ukuran_celana}}</td>
			</tr>
		</table>
		<div style="text-align: center;margin-top: 30px">
			<h3>Data Nilai Ujian Nasional :</h3>
		</div>
		<table>
			<tr>
				<td>Bahasa Indonesia</td>
				<td>{{$data->bahasa_indonesia}}</td>
			</tr>
			<tr>
				<td>Matematika</td>
				<td>{{$data->matematika}}</td>
			</tr>
			<tr>
				<td>Bahasa Inggris</td>
				<td>{{$data->bahasa_inggris}}</td>
			</tr>
			<tr>
				<td>Ilmu Pengetahuan Alam</td>
				<td>{{$data->ipa}}</td>
			</tr>
		</table>
		<div style="text-align: center;margin-top: 30px">
			<h3>Data Prestasi Siswa :</h3>
		</div>
		<table>
			<tr>
				<td>Nilai Prestasi</td>
				<td>{{$data->nilai_prestasi}}</td>
			</tr>
		</table>
		<div style="text-align: center;margin-top: 30px">
			<h3>Data Program Keahlian Yang Dipilih :</h3>
		</div>
		<table>
			<tr>
				<td>Pilih Jurusan</td>
				<td>{{$data->jurusan}}</td>
			</tr>
		</table>
		<div style="text-align: center;margin-top: 30px">
			<h3>Data Orang Tua/Wali Siswa :</h3>
		</div>
		<table>
			<tr>
				<td>Nama Ayah</td>
				<td>{{$data->nama_ayah}}</td>
			</tr>
			<tr>
				<td>NIK Ayah</td>
				<td>{{$data->nik_ayah}}</td>
			</tr>
			<tr>
				<td>Pendidikan Ayah</td>
				<td>{{$data->pendidikan_ayah}}</td>
			</tr>
			<tr>
				<td>Tanggal Lahir Ayah</td>
				<td>{{ date('d-m-Y', strtotime($data->lahir_ayah)) }}</td>
			</tr>
			<tr>
				<td>Pekerjaan Ayah</td>
				<td>{{$data->pekerjaan_ayah}}</td>
			</tr>
			<tr>
				<td>Penghasilan Ayah</td>
				<td>{{$data->penghasilan_ayah}}</td>
			</tr>
			<tr>
				<td>No Hp.Ayah</td>
				<td>{{$data->hpayah}}</td>
			</tr>
			<tr>
				<td>Berkebutuhan Khusus</td>
				<td>{{$data->penyakit_ayah}}</td>
			</tr>
			<tr>
				<td>Nama Ibu</td>
				<td>{{$data->nama_ibu}}</td>
			</tr>
			<tr>
				<td>NIK Ibu</td>
				<td>{{$data->nik_ibu}}</td>
			</tr>
			<tr>
				<td>Pendidikan Ibu</td>
				<td>{{$data->pendidikan_ibu}}</td>
			</tr>
			<tr>
				<td>Pekerjaan Ibu</td>
				<td>{{$data->pekerjaan_ibu}}</td>
			</tr>
			<tr>
				<td>Penghasilan Ibu</td>
				<td>{{$data->penghasilan_ibu}}</td>
			</tr>
			<tr>
				<td>No Hp.Ibu</td>
				<td>{{$data->hpibu}}</td>
			</tr>
			<tr>
				<td>Tanggal Lahir Ibu</td>
				<td>{{ date('d-m-Y', strtotime($data->lahir_ibu)) }}</td>
			</tr>
			<tr>
				<td>Berkebutuhan Khusus</td>
				<td>{{ $data->penyakit_ibu }}</td>
			</tr>
			<tr>
				<td>Alamat Orang Tua</td>
				<td>{{$data->alamat_orangtua}}</td>
			</tr>
			<tr>
				<td>Nama Wali</td>
				<td>{{$data->nama_wali}}</td>
			</tr>
			<tr>
				<td>Pendidkan Wali</td>
				<td>{{$data->pendidkan_wali}}</td>
			</tr>
			<tr>
				<td>Pekerjaan Wali</td>
				<td>{{$data->pekerjaan_wali}}</td>
			</tr>
			<tr>
				<td>Penghasilan Wali</td>
				<td>{{$data->penghasilan_wali}}</td>
			</tr>
			<tr>
				<td>No Hp.Wali</td>
				<td>{{$data->hpwali}}</td>
			</tr>
			<tr>
				<td>Alamat Wali</td>
				<td>{{$data->alamat_wali}}</td>
			</tr>
			<tr>
				<td>Status Asuh</td>
				<td>{{$data->status_asuh}}</td>
			</tr>
		</table>
	</div>
	

@endsection