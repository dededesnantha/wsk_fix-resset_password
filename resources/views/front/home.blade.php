@extends('front.layout')
@section('script')
<script src='https://www.google.com/recaptcha/api.js'></script>  
<script src="{{asset('front')}}/jquery-3.1.1.min.js" type="text/javascript"></script>
@endsection
@section('content')
<div class="container">
  <div style="text-align: center;">
    <h4>Pendaftaran Awal Siswa Baru :</h4>
  </div>
  <div class="c-12">
  @include('front.component.alert')
    <form action="{{ url('form/pendaftaransiswa') }}" method="POST" enctype="multipart/form-data" id="my-form">
      {{ csrf_field() }}
    <div class="row">
      <div class="col-25">
        <label>Nama Lengkap</label>
      </div>
      <div class="col-75">
        <input class="form-control" type="text" value="{{ old('nama_lengkap') }}" required="" placeholder="Nama Lengkap" name="nama_lengkap"
        oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
        <span class="alert-warning"><i>Nama Sesuai Ijazah. Huruf Kapital Semua</i></span>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Nama Panggilan</label>
      </div>
      <div class="col-75">
        <input class="form-control" type="text"  required="" placeholder="Nama Panggilan" value="{{ old('nama_panggilan') }}" name="nama_panggilan"
        oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Jenis Kelamin</label>
      </div>
      <div class="col-75">
        @if(old('jk') == 'pria')
          <span>
            <input class="w3-check" type="radio" value="pria"  required="" name="jk" checked="checked"
          oninvalid="this.setCustomValidity('Wajib Diisi')"
          oninput="setCustomValidity('')">pria
          </span>
          <span class="w3-padding">
            <input class="w3-check" type="radio" value="wanita"  required="" value="{{ old('jk') }}"  name="jk"
          oninvalid="this.setCustomValidity('Wajib Diisi')"
          oninput="setCustomValidity('')">wanita
          </span>
          @elseif(old('jk') == 'wanita')
          <span>
            <input class="w3-check" type="radio" value="pria"  required="" name="jk" 
          oninvalid="this.setCustomValidity('Wajib Diisi')"
          oninput="setCustomValidity('')">pria
          </span>
          <span class="w3-padding">
            <input class="w3-check" type="radio" value="wanita"  required="" checked="checked" name="jk"
          oninvalid="this.setCustomValidity('Wajib Diisi')"
          oninput="setCustomValidity('')">wanita
          </span>
          @else
           <span>
            <input class="w3-check" type="radio" value="pria"  required="" name="jk" checked="checked"
          oninvalid="this.setCustomValidity('Wajib Diisi')"
          oninput="setCustomValidity('')">pria
          </span>
          <span class="w3-padding">
            <input class="w3-check" type="radio" value="wanita"  required="" name="jk"
          oninvalid="this.setCustomValidity('Wajib Diisi')"
          oninput="setCustomValidity('')">wanita
          </span>
        @endif
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>NISN <span style="font-size: 12px;font-weight: 900"><i>(Optional)</i></span></label>
      </div>
      <div class="col-75">
        <input type="number" name="nisn" placeholder="NISN" value="{{ old('nisn') }}">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>NIK</label>
      </div>
      <div class="col-75">
        <input type="number" name="NIK" placeholder="NIK" value="{{ old('NIK') }}">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>No.KK</label>
      </div>
      <div class="col-75">
        <input type="number"  required="" placeholder="No.kk" name="no_kk" value="{{ old('no_kk') }}"
        oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>No.Akta</label>
      </div>
      <div class="col-75">
        <input type="number"  required="" placeholder="No.Akta" name="no_akta" value="{{ old('no_akta') }}"
        oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
      </div>
    </div>
   <div class="row">
      <div class="col-25">
        <label >Hobby</label>
      </div>
      <div class="col-75">
        <input type="text"  required="" placeholder="Hobby" name="hobby" value="{{ old('hobby') }}"
        oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Tempat Lahir</label>
      </div>
      <div class="col-35">
        <input type="text" required="" placeholder="Tempat Lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
        oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
      </div>
      <div class="col-15">
        <label>Tanggal Lahir</label>
      </div>
      <div class="col-25">
        <div class="sd-container">
          <p><input class="w3-input w3-padding-16 w3-border" type="date" placeholder="Date" required="" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')"></p>
          <span class="open-button">
            <i class="fa fa-calendar" aria-hidden="true" style="font-size: 20px"></i>
          </span>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Asal Sekolah</label>
      </div>
      <div class="col-75">
        <input type="text" required="" placeholder="Asal Sekolah" name="asal_sekolah" value="{{ old('asal_sekolah') }}"
        oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Alamat Sekolah</label>
      </div>
      <div class="col-75">
        <textarea required="" name="alamat_sekolah"
        oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')" style="height:200px">{{ old('alamat_sekolah') }}</textarea>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="penyakit" style="line-height: 21px;">Berkebutuhan Khusus <span style="font-size: 12px;font-weight: 900"><i>(Optional)</i></span></label>
      </div>
      <div class="col-75">
        <select id="penyakit" name="berkebutuhan_khusus">
           @if(old('berkebutuhan_khusus'))
            <option value="{{ old('berkebutuhan_khusus') }}">{{ old('berkebutuhan_khusus') }}</option>
          @endif
          <option value="">-- Pilih --</option>
          <option value="netral">Netral</option>
          <option value="Rungu">Rungu</option>
          <option value="Grahita Ringan">Grahita Ringan</option>
          <option value="Grahita Sedang">Grahita Sedang</option>
          <option value="Daksa Ringan">Daksa Ringan</option>
          <option value="Daksa Sedang">Daksa Sedang</option>
          <option value="Laras">Laras</option>
          <option value="Wicara">Wicara</option>
          <option value="Hyperaktif">Hyperaktif</option>
          <option value="Cerdas Istimewa">Cerdas Istimewa</option>
          <option value="Bakat Istimewa">Bakat Istimewa</option>
          <option value="Kesulitan Belajar">Kesulitan Belajar</option>
          <option value="Narkoba">Narkoba</option>
          <option value="Indigo">Indigo</option>
          <option value="Down Syndrome">Down Syndrome</option>
          <option value="Autis">Autis</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="agama">Agama</label>
      </div>
      <div class="col-75">
        <select id="agama" name="agama" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
         @if(old('agama'))
            <option value="{{ old('agama') }}">{{ old('agama') }}</option>
          @endif
          <option value="">-- Pilih --</option>
          <option value="Hindu">Hindu</option>
          <option value="Islam">Islam</option>
          <option value="Kristen">Kristen</option>
          <option value="Katolik">Katolik</option>
          <option value="Buddha">Buddha</option>
          <option value="Konghucu">Kong Hu Cu</option>
          <option value="Kepercayaan kpd Tuhan YME">Kepercayaan kpd Tuhan YME</option>
          <option value="Lainnya">Lainnya</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>RT <span style="font-size: 12px;font-weight: 900"><i>(Optional)</i></span></label>
      </div>
      <div class="col-75">
        <input type="text" name="RT" placeholder="RT" value="{{ old('RT') }}">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label >RW <span style="font-size: 12px;font-weight: 900"><i>(Optional)</i></span></label>
      </div>
      <div class="col-75">
        <input type="text" name="RW" placeholder="RW" value="{{ old('RW') }}">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="tempat">Tempat Tinggal</label>
      </div>
      <div class="col-75">
        <select id="tempat" name="tempat_tinggal" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
          @if(old('tempat_tinggal'))
            <option value="{{ old('tempat_tinggal') }}">{{ old('tempat_tinggal') }}</option>
          @endif
          <option value="Bersama Orang Tua">Bersama Orang Tua</option>
          <option value="Wali">Wali</option>
          <option value="Kost">Kost</option>
          <option value="Asrama">Asrama</option>
          <option value="Panti Asuhan">Panti Asuhan</option>
          <option value="Pesantren">Pesantren</option>
          <option value="Lainnya">Lainnya</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="tempat">Mode Transportasi</label>
      </div>
      <div class="col-75">
        <select id="tempat" name="transportasi" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
          @if(old('transportasi'))
            <option value="{{ old('transportasi') }}">{{ old('transportasi') }}</option>
          @endif
          <option value="Sepeda Motor">Sepeda Motor</option>
          <option value="Sepeda">Sepeda</option>
          <option value="Kuda">Kuda</option>
          <option value="Perahu Penyebrangan">Perahu Penyebrangan</option>
          <option value="Andong">Andong</option>
          <option value="Ojek">Ojek</option>
          <option value="Kereta Api">Kereta Api</option>
          <option value="Mobil/Bus">Mobil/Bus</option>
          <option value="Angkutan Umum">Angkutan Umum</option>
          <option value="Jalan Kaki">Jalan Kaki</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Kewarganegaraan</label>
      </div>
      <div class="col-75">
        <input type="text" name="kewarganegaraan" value="indonesia" readonly="readonly" style="background-color: #f2f2f2" />
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="fname">Suku Bangsa</label>
      </div>
      <div class="col-75">
        <input type="text" name="suku_bangsa" value="{{ old('suku_bangsa') }}" placeholder="Suku Bangsa" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
        <span class="alert-warning"><i>Contoh : jawa, bali, aceh, dll</i></span>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="anak">Anak Ke-</label>
      </div>
      <div class="col-75">
        <select id="anak" name="anak_ke" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
          @if(old('anak_ke'))
            <option value="{{ old('anak_ke') }}">{{ old('anak_ke') }}</option>
          @endif
          <option value="0">-- Pilih --</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="status">Status Siswa</label>
      </div>
      <div class="col-75">
        <select id="status" name="status_siswa">
          @if(old('status_siswa'))
            <option value="{{ old('status_siswa') }}">{{ old('status_siswa') }}</option>
          @endif
          <option value="">-- Pilih --</option>
          <option value="Anak Yatim">Anak Yatim</option>
          <option value="Piatu">Piatu</option>
          <option value="Yatim Piatu">Yatim Piatu</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="Beasiswa">Pernah Mendapatkan Beasiswa</label>
      </div>
      <div class="col-75">
        <select id="Beasiswa" name="beasiswa">
          @if(old('beasiswa'))
            <option value="{{ old('beasiswa') }}">{{ old('beasiswa') }}</option>
          @endif
          <option value="">-- Pilih --</option>
          <option value="KIP">KIP</option>
          <option value="KPS">KPS</option>
          <option value="KKS">KKS</option>
          <option value="PKH">PKH</option>
          <option value="YAITM PIATU">YAITM PIATU</option>
          <option value="YATIM">YATIM</option>
          <option value="PIATU">PIATU</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="jumlah">Jumlah Saudara</label>
      </div>
      <div class="col-75">
        <select id="jumlah" name="saudara" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
          @if(old('saudara'))
            <option value="{{ old('saudara') }}">{{ old('saudara') }}</option>
          @endif
          <option value="0">-- Pilih --</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Alamat Rumah</label>
      </div>
      <div class="col-75">
        <textarea name="alamat_rumah" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')" style="height:200px">{{ old('alamat_rumah') }}</textarea>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Provinsi</label>
      </div>
      <div class="col-75">
        <input type="text" name="provinsi" value="{{ old('provinsi') }}" placeholder="provinsi" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Kabupaten</label>
      </div>
      <div class="col-75">
        <input type="text" name="kabupaten" value="{{ old('kabupaten') }}" placeholder="kabupaten" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
      </div>
    </div>
     <div class="row">
      <div class="col-25">
        <label>Kecamatan</label>
      </div>
      <div class="col-75">
        <input type="text" name="kecamatan" value="{{ old('kecamatan') }}" placeholder="Kecamatan" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Kode Pos</label>
      </div>
      <div class="col-75">
        <input type="number" name="kode_pos" value="{{ old('kode_pos') }}" placeholder="Kode Pos" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label >Alamat Pos</label>
      </div>
      <div class="col-75">
        <textarea name="alamat_pos" style="height:200px">{{ old('alamat_pos') }}</textarea>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Lintang <span style="font-size: 12px;font-weight: 900"><i>(Optional)</i></span></label>
      </div>
      <div class="col-75">
        <input type="number" name="lintang" placeholder="Lintang" value="{{ old('lintang') }}">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Bujur <span style="font-size: 12px;font-weight: 900"><i>(Optional)</i></span></label>
      </div>
      <div class="col-75">
        <input type="number" name="bujur" value="{{ old('bujur') }}" placeholder="Bujur">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Nomor Hp</label>
      </div>
      <div class="col-75">
        <input type="number" name="hpsiswa" value="{{ old('hpsiswa') }}" placeholder="Nomor Hp" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
        <span class="alert-warning"><i>Contoh: 085*****</i></span>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Nomor Tel.Rumah <span style="font-size: 12px;font-weight: 900"><i>(Optional)</i></span></label>
      </div>
      <div class="col-75">
        <input type="number" name="tlp_rumah" value="{{ old('tlp_rumah') }}" placeholder="Nomor Tel.Rumah">
        <span class="alert-warning"><i>Contoh: 027*****</i></span>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Email</label>
      </div>
      <div class="col-75">
        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Golongan Darah</label>
      </div>
      <div class="col-75">
        <div class="c-12">
          <div class="row">
            <div class="c-2">  
            <span>
              @if(old('golongan_darah') == 'A')
              <input type="radio" name="golongan_darah" value="A" class="w3-check" checked=""> A
              @else
              <input type="radio" name="golongan_darah" value="A" class="w3-check"> A
              @endif
            </span>
            </div>
            <div class="c-2">
              <span>
                @if(old('golongan_darah') == 'B')
                <input type="radio" name="golongan_darah" value="B" class="w3-check" checked=""> B
                @else
                <input type="radio" name="golongan_darah" value="B" class="w3-check"> B
                @endif
              </span>
            </div>
            <div class="c-2">
              <span>
                @if(old('golongan_darah') == 'AB')
                <input type="radio" name="golongan_darah" value="AB" class="w3-check" checked=""> AB
                @else
                <input type="radio" name="golongan_darah" value="AB" class="w3-check"> AB
                @endif
              </span>
            </div>
            <div class="c-2">
              <span>
                @if(old('golongan_darah') == 'O')
                <input type="radio" name="golongan_darah" value="O" class="w3-check" checked=""> O
                @else
                <input type="radio" name="golongan_darah" value="O" class="w3-check"> O
                @endif
              </span>
            </div>
            <div class="c-4">
              <span>
                @if(old('golongan_darah') == 'Tidak Ada')
                <input type="radio" name="golongan_darah" value="Tidak Ada" class="w3-check" checked=""> Tidak Ada
                @else
                <input type="radio" name="golongan_darah" value="Tidak Ada" class="w3-check"> Tidak Ada
                @endif
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
     <div class="row">
      <div class="col-25">
        <label>Tinggi Badan <span style="font-size: 12px;font-weight: 900"><i>(Cm)</i></span></label>
      </div>
      <div class="col-75">
        <input type="number" name="tinggi_badan" value="{{ old('tinggi_badan') }}" placeholder="Tinggi badan" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
        <span class="alert-warning"><i>Contoh: 160, 150, dll</i></span>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Berat Badan <span style="font-size: 12px;font-weight: 900"><i>(Kg)</i></span></label>
      </div>
      <div class="col-75">
        <input type="number" name="berat_badan" value="{{ old('berat_badan') }}" placeholder="Berat Badan" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
        <span class="alert-warning"><i>Contoh: 70, 40, dll</i></span>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Lingkaran Kepala <span style="font-size: 12px;font-weight: 900"><i>(Cm)</i></span></label>
      </div>
      <div class="col-75">
        <input type="number" name="lingkaran_kepala" value="{{ old('lingkaran_kepala') }}" placeholder="Lingkar Kepala">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="riwayat">Riwayat Penyakit</label>
      </div>
      <div class="col-75">
        <textarea id="riwayat" name="riwayat_penyakit"  placeholder="Riwayat Penyakit" style="height:200px">{{ old('riwayat_penyakit') }}</textarea>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="keterangan">Keterangan Lain</label>
      </div>
      <div class="col-75">
        <textarea id="keterangan" name="keterangan" placeholder="Keterangan Lain" style="height:200px">{{ old('riwayat_penyakit') }}</textarea>
      </div>
    </div>

    <div style="text-align: center; margin-top: 50px">
      <h3 style="padding-bottom: 0; margin-bottom: 0;">Data Nilai Ujian Nasional : </h3>
      <span class="alert-warning" style="padding: 0; margin: 0;"><i>(Optional)</i></span>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Bahasa Indonesia </label>
      </div>
      <div class="col-75">
        @if(old('bahasa_indonesia'))
        <input type="number" name="bahasa_indonesia" value="{{ old('bahasa_indonesia') }}" placeholder="Nilai Bahasa Indonesia" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
        @else
        <input type="number" name="bahasa_indonesia" value="0" placeholder="Nilai Bahasa Indonesia" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
        @endif
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Bahasa Inggris </label>
      </div>
      <div class="col-75">
        @if(old('bahasa_inggris'))
        <input type="number" name="bahasa_inggris" value="{{ old('bahasa_inggris') }}" placeholder="Nilai Bahasa Inggris" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
        @else
        <input type="number" name="bahasa_inggris" value="0" placeholder="Nilai Bahasa Inggris" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
        @endif
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Matematika</label>
      </div>
      <div class="col-75">
        @if(old('matematika'))
        <input type="number" name="matematika" value="{{ old('matematika') }}" placeholder="Nilai Matematika" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
        @else
        <input type="number" name="matematika" value="0" placeholder="Nilai Matematika" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
        @endif
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Ilmu Pengetahuan Alam</label>
      </div>
      <div class="col-75">
        @if(old('ipa'))
        <input type="number" name="ipa" value="{{ old('ipa') }}" placeholder="Nilai Ilmu Pengetahuan Alam" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
        @else
        <input type="number" name="ipa" value="0" placeholder="Nilai Ilmu Pengetahuan Alam" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
        @endif
      </div>
    </div>
    <span class="alert-warning" style="padding: 0; margin: 0;"><i>* Nilai Ujian Nasional, Sementara Diisi Anggka 0 Semuanya (Keempat Kolom Studi Diataas)*</i></span>

    <div style="text-align: center; margin-top: 50px">
      <h3 style="padding-bottom: 0; margin-bottom: 0;">Data Prestasi Siswa : </h3>
      <span class="alert-warning" style="padding: 0; margin: 0;"><i>(Optional)</i></span>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Nilai Prestasi</label>
      </div>
      <div class="col-75">
        @if(old('nilai_prestasi'))
        <input type="number" name="nilai_prestasi" value="{{ old('nilai_prestasi') }}" placeholder="Nilai Prestasi" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
        @else
        <input type="number" name="nilai_prestasi" value="0" placeholder="Nilai Prestasi" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
        @endif
         <span class="alert-warning" style="padding: 0; margin: 0;"><i>* Nilai Prestasi Diisi 0 Jika Tidak Punya Prestasi Akademis/Non.Akademis. Jika Mempunyai Prestasi 
    Akademis / Non Akademis Saat di SMP Isikan Nilai 5 = Tingkat Sekolah, 6 = Kecamatan, 7 = Kabupaten, 8 = Provinsi, 9 = Nasional, 10 = Internasional*</i></span>
      </div>
    </div>

     <div style="text-align: center; margin-top: 50px">
      <h3 style="padding-bottom: 0; margin-bottom: 0;">Data Program Keahlian Yang Ada : </h3>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Program Keahlian</label>
      </div>
      <div class="col-75">
        <span>
          @if(old('jurusan') == 'perhotelan')
          <input type="radio" name="jurusan" value="perhotelan" class="w3-check" required="" checked="checked" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')"> Perhotelan
          @else
          <input type="radio" name="jurusan" value="perhotelan" class="w3-check" required="" checked="checked" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')"> Perhotelan
          @endif
        </span>
        @if(old('jurusan') == 'tata boga')
        <span class="w3-padding">
          <input type="radio" name="jurusan" value="tata boga" class="w3-check" required="" checked="checked" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')"> Tata Boga
        </span>
        @else
        <span class="w3-padding">
          <input type="radio" name="jurusan" value="tata boga" class="w3-check" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')"> Tata Boga
        </span>
        @endif
      </div>
    </div>

    <div style="text-align: center; margin-top: 50px">
      <h3 style="padding-bottom: 0; margin-bottom: 0;">Data Orang Tua/Wali Siswa : </h3>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Nama Ayah</label>
      </div>
      <div class="col-75">
        <input type="text" name="nama_ayah" value="{{ old('nama_ayah') }}" placeholder="Nama Ayah" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>NIK Ayah</label>
      </div>
      <div class="col-25">
        <input type="text" required="" placeholder="NIK Ayah" name="nik_ayah" value="{{ old('nik_ayah') }}"
        oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
      </div>
      <div class="col-25">
        <label>Tanggal Lahir Ayah</label>
      </div>
      <div class="col-25">
        <div class="sd-container">
          <p><input class="w3-input w3-padding-16 w3-border" type="date" value="{{ old('lahir_ayah') }}" placeholder="Date" required="" name="lahir_ayah" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')"></p>
          <span class="open-button">
            <i class="fa fa-calendar" aria-hidden="true" style="font-size: 20px"></i>
          </span>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="pendidikan">Pendidikan Ayah</label>
      </div>
      <div class="col-75">
        <select id="pendidikan" name="pendidikan_ayah" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
           @if(old('pendidikan_ayah'))
            <option value="{{ old('pendidikan_ayah') }}">{{ old('pendidikan_ayah') }}</option>
          @endif
          <option value="">-- Pilih --</option>
          <option value="Tidak Sekolah">Tidak Sekolah</option>
          <option value="Putus SD">Putus SD</option>
          <option value="TK">TK</option>
          <option value="SD">SD</option>
          <option value="SMP">SMP</option>
          <option value="SMA">SMA</option>
          <option value="D1">D1</option>
          <option value="D2">D2</option>
          <option value="D3">D3</option>
          <option value="S1">S1</option>
          <option value="S2">S2</option>
          <option value="S3">S3</option>
          <option value="Paket A">Paket A</option>
          <option value="Paket B">Paket B</option>
          <option value="Paket C">Paket C</option>
          <option value="Lainnya">Lainnya</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="pekerjaan">Pekerjaan Ayah</label>
      </div>
      <div class="col-75">
        <select id="pekerjaan" name="pekerjaan_ayah" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
         @if(old('pendidikan_ayah'))
            <option value="{{ old('pekerjaan_ayah') }}">{{ old('pekerjaan_ayah') }}</option>
          @endif
          <option value="">-- Pilih --</option>
          <option value="Buruh">Buruh</option>
          <option value="PNS">PNS</option>
          <option value="TNI">TNI</option>
          <option value="Polri">Polri</option>
          <option value="Karyawan Swasta">Karyawan Swasta</option>
          <option value="Petani">Petani</option>
          <option value="Nelayan">Nelayan</option>
          <option value="Pedagang Besar">Pedagang Besar</option>
          <option value="Pedagang Kecil">Pedagang Kecil</option>
          <option value="Pensiunan">Pensiunan</option>
          <option value="Peternak">Peternak</option>
          <option value="Wiraswasta">Wiraswasta</option>
          <option value="Tenaga Kerja Indonesia">Tenaga Kerja Indonesia</option>
          <option value="Wiraswasta">Wiraswasta</option>
          <option value="Wirausaha">Wirausaha</option>
          <option value="Sudah Meninggal">Sudah Meninggal</option>
         <option value="Dan Lain-Lain">Dan Lain - Lain</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="penghasil_ayah">Penghasilan Ayah</label>
      </div>
      <div class="col-75">
        <select id="penghasil_ayah" name="penghasilan_ayah">
          @if(old('penghasilan_ayah'))
            <option value="{{ old('penghasilan_ayah') }}">{{ old('penghasilan_ayah') }}</option>
          @endif
          <option value="Kurang Dari Rp.500.000">Kurang Dari Rp.500.000</option>
          <option value="Rp.500.000 - Rp.1.000.000">Rp.500.000 - Rp.1.000.000</option>
          <option value="Rp.1.000.000 - Rp.2.000.000">Rp.1.000.000 - Rp.2.000.000</option>
          <option value="Rp.2.000.000 - Rp.5.000.000">Rp.2.000.000 - Rp.5.000.000</option>
          <option value="Rp.5.000.000 - Rp.20.000.000">Rp.5.000.000 - Rp.20.000.000</option>
          <option value="Lebih dari Rp.20.000.000">Lebih dari Rp.20.000.000</option>
          <option value="Tidak berpenghasilan">Tidak Berpenghasilan</option>
        </select>
      </div>
  </div>
    <div class="row">
      <div class="col-25">
        <label>Nomor Hp Ayah</label>
      </div>
      <div class="col-75">
        <input type="number" name="hpayah" value="{{ old('hpayah') }}" placeholder="Nomor Hp Ayah">
        <span class="alert-warning"><i>Contoh: 085*****</i></span>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="penyakit_ayah" style="line-height: 21px;">Berkebutuhan Khusus <span style="font-size: 12px;font-weight: 900"><i>(Optional)</i></span></label>
      </div>
      <div class="col-75">
        <select id="penyakit_ayah" name="penyakit_ayah">
          @if(old('penyakit_ayah'))
            <option value="{{ old('penyakit_ayah') }}">{{ old('penyakit_ayah') }}</option>
          @endif
          <option value="">-- Pilih --</option>
          <option value="netral">Netral</option>
          <option value="Rungu">Rungu</option>
          <option value="Grahita Ringan">Grahita Ringan</option>
          <option value="Grahita Sedang">Grahita Sedang</option>
          <option value="Daksa Ringan">Daksa Ringan</option>
          <option value="Daksa Sedang">Daksa Sedang</option>
          <option value="Laras">Laras</option>
          <option value="Wicara">Wicara</option>
          <option value="Hyperaktif">Hyperaktif</option>
          <option value="Cerdas Istimewa">Cerdas Istimewa</option>
          <option value="Bakat Istimewa">Bakat Istimewa</option>
          <option value="Kesulitan Belajar">Kesulitan Belajar</option>
          <option value="Narkoba">Narkoba</option>
          <option value="Indigo">Indigo</option>
          <option value="Down Syndrome">Down Syndrome</option>
          <option value="Autis">Autis</option>
        </select>
      </div>
    </div>
     <div class="row">
      <div class="col-25">
        <label>Nama Ibu</label>
      </div>
      <div class="col-75">
        <input type="text" name="nama_ibu" value="{{ old('nama_ibu') }}" placeholder="Nama Ibu" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>NIK Ibu</label>
      </div>
      <div class="col-25">
        <input type="text" required="" placeholder="NIK Ibu" name="nik_ibu" value="{{ old('nik_ibu') }}"
        oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
      </div>
      <div class="col-25">
        <label>Tanggal Lahir Ibu</label>
      </div>
      <div class="col-25">
        <div class="sd-container">
          <p><input class="w3-input w3-padding-16 w3-border" type="date" value="{{ old('lahir_ibu') }}" placeholder="Date" required="" name="lahir_ibu" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')"></p>
          <span class="open-button">
            <i class="fa fa-calendar" aria-hidden="true" style="font-size: 20px"></i>
          </span>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="pendidikan_ibu">Pendidikan Ibu</label>
      </div>
      <div class="col-75">
        <select id="pendidikan_ibu" name="pendidikan_ibu" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
        @if(old('pendidikan_ibu'))
            <option value="{{ old('pendidikan_ibu') }}">{{ old('pendidikan_ibu') }}</option>
          @endif
          <option value="">-- Pilih --</option>
          <option value="Tidak Sekolah">Tidak Sekolah</option>
          <option value="Putus SD">Putus SD</option>
          <option value="TK">TK</option>
          <option value="SD">SD</option>
          <option value="SMP">SMP</option>
          <option value="SMA">SMA</option>
          <option value="D1">D1</option>
          <option value="D2">D2</option>
          <option value="D3">D3</option>
          <option value="S1">S1</option>
          <option value="S2">S2</option>
          <option value="S3">S3</option>
          <option value="Paket A">Paket A</option>
          <option value="Paket B">Paket B</option>
          <option value="Paket C">Paket C</option>
          <option value="Lainnya">Lainnya</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="pekerjaan_ibu">Pekerjaan Ibu</label>
      </div>
      <div class="col-75">
        <select id="pekerjaan_ibu" name="pekerjaan_ibu" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">
        @if(old('pekerjaan_ibu'))
            <option value="{{ old('pekerjaan_ibu') }}">{{ old('pekerjaan_ibu') }}</option>
          @endif
          <option value="">-- Pilih --</option>
          <option value="Buruh">Buruh</option>
          <option value="PNS">PNS</option>
          <option value="TNI">TNI</option>
          <option value="Polri">Polri</option>
          <option value="Karyawan Swasta">Karyawan Swasta</option>
          <option value="Petani">Petani</option>
          <option value="Nelayan">Nelayan</option>
          <option value="Pedagang Besar">Pedagang Besar</option>
          <option value="Pedagang Kecil">Pedagang Kecil</option>
          <option value="Pensiunan">Pensiunan</option>
          <option value="Peternak">Peternak</option>
          <option value="Wiraswasta">Wiraswasta</option>
          <option value="Tenaga Kerja Indonesia">Tenaga Kerja Indonesia</option>
          <option value="Wiraswasta">Wiraswasta</option>
          <option value="Wirausaha">Wirausaha</option>
          <option value="Sudah Meninggal">Sudah Meninggal</option>
         <option value="Dan Lain-Lain">Dan Lain - Lain</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="penghasil_ibu">Penghasilan Ibu</label>
      </div>
      <div class="col-75">
        <select id="penghasil_ibu" name="penghasilan_ibu">
          @if(old('penghasilan_ibu'))
            <option value="{{ old('penghasilan_ibu') }}">{{ old('penghasilan_ibu') }}</option>
          @endif
          <option value="Kurang Dari Rp.500.000">Kurang Dari Rp.500.000</option>
          <option value="Rp.500.000 - Rp.1.000.000">Rp.500.000 - Rp.1.000.000</option>
          <option value="Rp.1.000.000 - Rp.2.000.000">Rp.1.000.000 - Rp.2.000.000</option>
          <option value="Rp.2.000.000 - Rp.5.000.000">Rp.2.000.000 - Rp.5.000.000</option>
          <option value="Rp.5.000.000 - Rp.20.000.000">Rp.5.000.000 - Rp.20.000.000</option>
          <option value="Lebih dari Rp.20.000.000">Lebih dari Rp.20.000.000</option>
          <option value="Tidak berpenghasilan">Tidak Berpenghasilan</option>
        </select>
      </div>
  </div>
    <div class="row">
      <div class="col-25">
        <label>Nomor Hp Ibu</label>
      </div>
      <div class="col-75">
        <input type="number" name="hpibu" value="{{ old('hpibu') }}" placeholder="Nomor Hp Ibu">
        <span class="alert-warning"><i>Contoh: 085*****</i></span>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="penyakit_ibu" style="line-height: 21px;">Berkebutuhan Khusus <span style="font-size: 12px;font-weight: 900"><i>(Optional)</i></span></label>
      </div>
      <div class="col-75">
        <select id="penyakit_ibu" name="penyakit_ibu">
          @if(old('penyakit_ibu'))
            <option value="{{ old('penyakit_ibu') }}">{{ old('penyakit_ibu') }}</option>
          @endif
          <option value="">-- Pilih --</option>
          <option value="netral">Netral</option>
          <option value="Rungu">Rungu</option>
          <option value="Grahita Ringan">Grahita Ringan</option>
          <option value="Grahita Sedang">Grahita Sedang</option>
          <option value="Daksa Ringan">Daksa Ringan</option>
          <option value="Daksa Sedang">Daksa Sedang</option>
          <option value="Laras">Laras</option>
          <option value="Wicara">Wicara</option>
          <option value="Hyperaktif">Hyperaktif</option>
          <option value="Cerdas Istimewa">Cerdas Istimewa</option>
          <option value="Bakat Istimewa">Bakat Istimewa</option>
          <option value="Kesulitan Belajar">Kesulitan Belajar</option>
          <option value="Narkoba">Narkoba</option>
          <option value="Indigo">Indigo</option>
          <option value="Down Syndrome">Down Syndrome</option>
          <option value="Autis">Autis</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="alamat">Alamat Orang Tua</label>
      </div>
      <div class="col-75">
        <textarea id="alamat" name="alamat_orangtua" placeholder="Alamat Orang Tua" style="height:200px" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')">{{ old('alamat_orangtua') }}</textarea>
      </div>
    </div>
     <div class="row">
      <div class="col-25">
        <label>Nama Wali</label>
      </div>
      <div class="col-75">
        <input type="text" name="nama_wali" value="{{ old('nama_wali') }}" placeholder="Nama Wali">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="pendidikan_wali">Pendidikan Wali</label>
      </div>
      <div class="col-75">
        <select id="pendidikan_wali" name="pendidikan_wali">
          @if(old('pendidikan_wali'))
            <option value="{{ old('pendidikan_wali') }}">{{ old('pendidikan_wali') }}</option>
          @endif
          <option value="">-- Pilih --</option>
          <option value="Tidak Sekolah">Tidak Sekolah</option>
          <option value="Putus SD">Putus SD</option>
          <option value="TK">TK</option>
          <option value="SD">SD</option>
          <option value="SMP">SMP</option>
          <option value="SMA">SMA</option>
          <option value="D1">D1</option>
          <option value="D2">D2</option>
          <option value="D3">D3</option>
          <option value="S1">S1</option>
          <option value="S2">S2</option>
          <option value="S3">S3</option>
          <option value="Paket A">Paket A</option>
          <option value="Paket B">Paket B</option>
          <option value="Paket C">Paket C</option>
          <option value="Lainnya">Lainnya</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="pekerjaan_wali">Pekerjaan Wali</label>
      </div>
      <div class="col-75">
        <select id="pekerjaan_wali" name="pekerjaan_wali">
          @if(old('pekerjaan_wali'))
            <option value="{{ old('pekerjaan_wali') }}">{{ old('pekerjaan_wali') }}</option>
          @endif
          <option value="">-- Pilih --</option>
          <option value="Buruh">Buruh</option>
          <option value="PNS">PNS</option>
          <option value="TNI">TNI</option>
          <option value="Polri">Polri</option>
          <option value="Karyawan Swasta">Karyawan Swasta</option>
          <option value="Petani">Petani</option>
          <option value="Nelayan">Nelayan</option>
          <option value="Pedagang Besar">Pedagang Besar</option>
          <option value="Pedagang Kecil">Pedagang Kecil</option>
          <option value="Pensiunan">Pensiunan</option>
          <option value="Peternak">Peternak</option>
          <option value="Wiraswasta">Wiraswasta</option>
          <option value="Tenaga Kerja Indonesia">Tenaga Kerja Indonesia</option>
          <option value="Wiraswasta">Wiraswasta</option>
          <option value="Wirausaha">Wirausaha</option>
          <option value="Sudah Meninggal">Sudah Meninggal</option>
         <option value="Dan Lain-Lain">Dan Lain - Lain</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="penghasil_Wali">Penghasilan Wali</label>
      </div>
      <div class="col-75">
        <select id="penghasil_Wali" name="penghasilan_wali">
          @if(old('penghasilan_wali'))
            <option value="{{ old('penghasilan_wali') }}">{{ old('penghasilan_wali') }}</option>
          @endif
          <option value="">-- Pilih --</option>
          <option value="Kurang Dari Rp.500.000">Kurang Dari Rp.500.000</option>
          <option value="Rp.500.000 - Rp.1.000.000">Rp.500.000 - Rp.1.000.000</option>
          <option value="Rp.1.000.000 - Rp.2.000.000">Rp.1.000.000 - Rp.2.000.000</option>
          <option value="Rp.2.000.000 - Rp.5.000.000">Rp.2.000.000 - Rp.5.000.000</option>
          <option value="Rp.5.000.000 - Rp.20.000.000">Rp.5.000.000 - Rp.20.000.000</option>
          <option value="Lebih dari Rp.2.000.000">Lebih dari Rp.2.000.000</option>
          <option value="Tidak berpenghasilan">Tidak Berpenghasilan</option>
        </select>
      </div>
  </div>
    <div class="row">
      <div class="col-25">
        <label>Nomor Hp wali</label>
      </div>
      <div class="col-75">
        <input type="number" name="hpwali" value="{{ old('hpwali') }}" placeholder="Nomor Hp Wali">
        <span class="alert-warning"><i>Contoh: 085*****</i></span>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="alamat_wali">Alamat Wali</label>
      </div>
      <div class="col-75">
        <textarea id="alamat_wali" name="alamat_wali" placeholder="Alamat Wali" style="height:200px">{{ old('alamat_wali') }}</textarea>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Status Asuh</label>
      </div>
      <div class="col-75">
        <span>
          @if(old('status_asuh') == 'Orang Tua')
          <input type="radio" name="status_asuh" value="Orang Tua" class="w3-check" checked="checked" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')"> Orang Tua
          @else
          <input type="radio" name="status_asuh" value="Orang Tua" class="w3-check" checked="checked" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')"> Orang Tua
          @endif
        </span>
        <span class="w3-padding">
          @if(old('status_asuh') == 'Wali')
          <input type="radio" name="status_asuh" value="Wali" class="w3-check" required="" checked="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')"> Wali
          @else
          <input type="radio" name="status_asuh" value="Wali" class="w3-check" required="" oninvalid="this.setCustomValidity('Wajib Diisi')"
        oninput="setCustomValidity('')"> Wali
          @endif
        </span>
      </div>
    </div>
    <div class="row">
      <div class="c-12" style="margin-bottom: 10px">
        <div style="float: right;">
            <!-- <label for="mathgroup">{{ app('mathcaptcha')->label() }}</label>
            <div style="display: block;">
             {!! app('mathcaptcha')->input(['class' => 'form-control', 'id' => 'mathgroup']) !!}
             @if ($errors->has('mathcaptcha'))
             <span class="help-block">
              <span class="alert-error">{{ $errors->first('mathcaptcha') }}</span>
            </span>
            @endif
          </div> -->
          <div class="g-recaptcha" data-sitekey="{{env('CAPCHA_KEY')}}"></div>
        </div>
      </div>
      <div class="c-12">
      <input type="submit" value="Kirim Data">
      </div>
      </div>
    </div>
    </form>
  </div>
</div>

@endsection