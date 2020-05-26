<?php
namespace App\Exports;
  
use App\mahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
  
class MahasiswaExport implements FromCollection
{
	/**
    * @return \Illuminate\Support\Collection
    */
	public function collection()
	{
		return mahasiswa::where('id_kategori_tahun',$this->id)->get();
	}
}