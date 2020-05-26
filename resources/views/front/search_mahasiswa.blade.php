@extends('front.layout')


@section('content')
	<div class="container">
		<div style="text-align: center;">
			<h3>list Pribadi Siswa :</h3>
		</div>
		<div class="c-12">
			@include('front.component.alert')
		</div>
		<table>
			<tr>
				<td>Tahun Ajaran</td>
				<td>{{$list->tahun}}</td>
			</tr>
			<tr>
				<td>Nomor Registrasi</td>
				<td>WSKPD-{{$list->no_registrasi}}</td>
			</tr>
			@if($list->status_pembayaran == 'lunas')
			<tr style="background-color: #067834;color: #fff">
				<td>Status Pembayaran</td>
				<td>{{$list->status_pembayaran}}</td>
			</tr>
			@else
			<tr style="background-color: #780606;color: #fff">
				<td>Status Pembayaran</td>
				<td>{{$list->status_pembayaran}}</td>
			</tr>
			@endif
			<tr>
				<td>Nama Lengkap</td>
				<td>{{$list->nama_lengkap}}</td>
			</tr>
			<tr>
				<td>Nama Panggilan</td>
				<td>{{$list->nama_panggilan}}</td>
			</tr>
			<tr>
				<td>Jenis Kelamin</td>
				<td>{{$list->jk}}</td>
			</tr>
			<tr>
				<td>NISN</td>
				<td>{{$list->nisn}}</td>
			</tr>
			<tr>
				<td>NIK</td>
				<td>{{$list->NIK}}</td>
			</tr>
			<tr>
				<td>No.KK</td>
				<td>{{$list->no_kk}}</td>
			</tr>
			<tr>
				<td>Hobby</td>
				<td>{{$list->hobby}}</td>
			</tr>
			<tr>
				<td>Tempat Lahir</td>
				<td>{{$list->tempat_lahir}}</td>
			</tr>
			<tr>
				<td>Tanggal Lahir</td>
				<td>{{ date('d-m-Y', strtotime($list->tanggal_lahir)) }}</td>
			</tr>
			<tr>
				<td>Asal Sekolah</td>
				<td>{{$list->asal_sekolah}}</td>
			</tr>
			<tr>
				<td>Alamat Sekolah</td>
				<td>{{$list->alamat_sekolah}}</td>
			</tr>
			<tr>
				<td>Berkebutuhan Khusus</td>
				<td>{{$list->berkebutuhan_khusus}}</td>
			</tr>
			<tr>
				<td>Agama</td>
				<td>{{$list->agama}}</td>
			</tr>
			<tr>
				<td>RT</td>
				<td>{{$list->RT}}</td>
			</tr>
			<tr>
				<td>RW</td>
				<td>{{$list->RW}}</td>
			</tr>
			<tr>
				<td>Tempat Tinggal</td>
				<td>{{$list->tempat_tinggal}}</td>
			</tr>
			<tr>
				<td>Mode Transportasi</td>
				<td>{{$list->transportasi}}</td>
			</tr>
			<tr>
				<td>Kewarganegaraan</td>
				<td>{{$list->kewarganegaraan}}</td>
			</tr>
			<tr>
				<td>Suku Bangsa</td>
				<td>{{$list->suku_bangsa}}</td>
			</tr>
			<tr>
				<td>Anak Ke-</td>
				<td>{{$list->anak_ke}}</td>
			</tr>
			<tr>
				<td>Status Siswa</td>
				<td>{{$list->status_siswa}}</td>
			</tr>
			<tr>
				<td>Beasiswa Yang Pernah Didapat</td>
				<td>{{$list->beasiswa}}</td>
			</tr>
			<tr>
				<td>Jumlah Saudara</td>
				<td>{{$list->saudara}}</td>
			</tr>
			<tr>
				<td>Alamat Rumah</td>
				<td>{{$list->alamat_rumah}}</td>
			</tr>
			<tr>
				<td>Provinsi</td>
				<td>{{$list->provinsi}}</td>
			</tr>
			<tr>
				<td>Kabupaten</td>
				<td>{{$list->kabupaten}}</td>
			</tr>
			<tr>
				<td>Kecamatan</td>
				<td>{{$list->kecamatan}}</td>
			</tr>
			<tr>
				<td>Kode Pos</td>
				<td>{{$list->kode_pos}}</td>
			</tr>
			<tr>
				<td>Lintang</td>
				<td>{{$list->lintang}}</td>
			</tr>
			<tr>
				<td>Bujur</td>
				<td>{{$list->bujur}}</td>
			</tr>
			<tr>
				<td>No Hp Siswa</td>
				<td>{{$list->hpsiswa}}</td>
			</tr>
			<tr>
				<td>No Tlp.Rumah</td>
				<td>{{$list->tlp_rumah}}</td>
			</tr>
			<tr>
				<td>Email</td>
				<td>{{$list->email}}</td>
			</tr>
			<tr>
				<td>Golongan Darah</td>
				<td>{{$list->golongan_darah}}</td>
			</tr>
			<tr>
				<td>Tinggi Badan</td>
				<td>{{$list->tinggi_badan}}</td>
			</tr>
			<tr>
				<td>Berat Badan</td>
				<td>{{$list->berat_badan}}</td>
			</tr>
			<tr>
				<td>Lingkaran Kepala</td>
				<td>{{$list->lingkaran_kepala}}</td>
			</tr>
			<tr>
				<td>Riwayat Penyakit</td>
				<td>{{$list->riwayat_penyakit}}</td>
			</tr>
			<tr>
				<td>Keterangan Lain</td>
				<td>{{$list->keterangan}}</td>
			</tr>
			<tr>
				<td>Ukuran Baju</td>
				<td>{{$list->ukuran_baju}}</td>
			</tr>
			<tr>
				<td>Ukuran Celana</td>
				<td>{{$list->ukuran_celana}}</td>
			</tr>
		</table>
		<div style="text-align: center;margin-top: 30px">
			<h3>Data Nilai Ujian Nasional :</h3>
		</div>
		<table>
			<tr>
				<td>Bahasa Indonesia</td>
				<td>{{$list->bahasa_indonesia}}</td>
			</tr>
			<tr>
				<td>Matematika</td>
				<td>{{$list->matematika}}</td>
			</tr>
			<tr>
				<td>Bahasa Inggris</td>
				<td>{{$list->bahasa_inggris}}</td>
			</tr>
			<tr>
				<td>Ilmu Pengetahuan Alam</td>
				<td>{{$list->ipa}}</td>
			</tr>
		</table>
		<div style="text-align: center;margin-top: 30px">
			<h3>Data Prestasi Siswa :</h3>
		</div>
		<table>
			<tr>
				<td>Nilai Prestasi</td>
				<td>{{$list->nilai_prestasi}}</td>
			</tr>
		</table>
		<div style="text-align: center;margin-top: 30px">
			<h3>Data Program Keahlian Yang Dipilih :</h3>
		</div>
		<table>
			<tr>
				<td>Pilih Jurusan</td>
				<td>{{$list->jurusan}}</td>
			</tr>
		</table>
		<div style="text-align: center;margin-top: 30px">
			<h3>Data Orang Tua/Wali Siswa :</h3>
		</div>
		<table>
			<tr>
				<td>Nama Ayah</td>
				<td>{{$list->nama_ayah}}</td>
			</tr>
			<tr>
				<td>NIK Ayah</td>
				<td>{{$list->nik_ayah}}</td>
			</tr>
			<tr>
				<td>Pendidikan Ayah</td>
				<td>{{$list->pendidikan_ayah}}</td>
			</tr>
			<tr>
				<td>Tanggal Lahir Ayah</td>
				<td>{{ date('d-m-Y', strtotime($list->lahir_ayah)) }}</td>
			</tr>
			<tr>
				<td>Pekerjaan Ayah</td>
				<td>{{$list->pekerjaan_ayah}}</td>
			</tr>
			<tr>
				<td>Penghasilan Ayah</td>
				<td>{{$list->penghasilan_ayah}}</td>
			</tr>
			<tr>
				<td>No Hp.Ayah</td>
				<td>{{$list->hpayah}}</td>
			</tr>
			<tr>
				<td>Tanggal Lahir Ayah</td>
				<td>{{ date('d-m-Y', strtotime($list->lahir_ayah)) }}</td>
			</tr>
			<tr>
				<td>Berkebutuhan Khusus</td>
				<td>{{$list->penyakit_ayah}}</td>
			</tr>
			<tr>
				<td>Nama Ibu</td>
				<td>{{$list->nama_ibu}}</td>
			</tr>
			<tr>
				<td>NIK Ibu</td>
				<td>{{$list->nik_ibu}}</td>
			</tr>
			<tr>
				<td>Pendidikan Ibu</td>
				<td>{{$list->pendidikan_ibu}}</td>
			</tr>
			<tr>
				<td>Pekerjaan Ibu</td>
				<td>{{$list->pekerjaan_ibu}}</td>
			</tr>
			<tr>
				<td>Penghasilan Ibu</td>
				<td>{{$list->penghasilan_ibu}}</td>
			</tr>
			<tr>
				<td>No Hp.Ibu</td>
				<td>{{$list->hpibu}}</td>
			</tr>
			<tr>
				<td>Tanggal Lahir Ibu</td>
				<td>{{ date('d-m-Y', strtotime($list->lahir_ibu)) }}</td>
			</tr>
			<tr>
				<td>Berkebutuhan Khusus</td>
				<td>{{ $list->penyakit_ibu }}</td>
			</tr>
			<tr>
				<td>Alamat Orang Tua</td>
				<td>{{$list->alamat_orangtua}}</td>
			</tr>
			<tr>
				<td>Nama Wali</td>
				<td>{{$list->nama_wali}}</td>
			</tr>
			<tr>
				<td>Pendidkan Wali</td>
				<td>{{$list->pendidkan_wali}}</td>
			</tr>
			<tr>
				<td>Pekerjaan Wali</td>
				<td>{{$list->pekerjaan_wali}}</td>
			</tr>
			<tr>
				<td>Penghasilan Wali</td>
				<td>{{$list->penghasilan_wali}}</td>
			</tr>
			<tr>
				<td>No Hp.Wali</td>
				<td>{{$list->hpwali}}</td>
			</tr>
			<tr>
				<td>Alamat Wali</td>
				<td>{{$list->alamat_wali}}</td>
			</tr>
			<tr>
				<td>Status Asuh</td>
				<td>{{$list->status_asuh}}</td>
			</tr>
		</table>
	</div>
@endsection