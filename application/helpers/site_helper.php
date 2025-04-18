<?php

function batas_sks($ip=null)
{
	if($ip){
		if($ip > 3.25){
			return 24;
		}else if($ip > 2.99){
			return 22;
		}else if($ip > 2.74){
			return 20;
		}else if($ip > 2.00){
			return 18;
		}else{
			return 16;
		}
	}else{
		return 24;
	}
}

function no_romawi($no)
{
	$arr_no = ['I', 'II', 'III', 'IV'];
	return $arr_no[$no-1];
}

function format_nilai($nilai_angka, $decimal = 2)
{
	return number_format($nilai_angka, $decimal, '.', ',');
}

function domain_jitsi($data, $type = null, $protocol = 'https://')
{
	if ($type == 'pdfjs') {
		return str_replace($protocol, '', $data == 6 ? $_ENV['PDFVIEWER_PKL'] : $_ENV['PDFVIEWER_SKRIPSI']);
	} else {
		return 'meet.jit.si/'.$data;
	}
}

// function domain_jitsi($id_jenis_aktivitas_mahasiswa, $protocol = 'https://')
// {
// 	return str_replace($protocol, '', $id_jenis_aktivitas_mahasiswa == 6 ? $_ENV['PDFVIEWER_PKL'] : $_ENV['PDFVIEWER_SKRIPSI']);
// }

function format_nama($nama)
{
	return preg_replace("/[^A-Z a-z 0-9]/", '', $nama);
}

function nama_hari($id_hari=null)
{
	$arr_hari = ['Ahad', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu','Ahad'];
	if($id_hari) return $arr_hari[$id_hari];
	return $arr_hari;
}

function nama_smt($id_smt)
{
	$thn_aka=substr($id_smt,0,4);
	$thn_akademik=$thn_aka.'/'.($thn_aka+1);
	$smt=str_split($id_smt);
	if($smt[4]==1){
		$smt_akademik='Ganjil';
	}elseif($smt[4]==2){
		$smt_akademik='Genap';
	}else{
		$smt_akademik='Pendek';
	}
	return $thn_akademik.' '.$smt_akademik;
}

function status_hadir($status)
{
	switch($status){
		case 0: return "Tidak Hadir"; break;
		case 1: return "Hadir"; break;
		case 2: return "Sakit"; break;
		case 3: return "Izin"; break;
		default: return "n/a"; break;
	}
}

function smt_krs($id_smt)
{
	$thn_aka=substr($id_smt,0,4);
	$thn_smt=substr($id_smt,4,1);
	$thn_kmrn=$thn_aka-1;
	return $thn_kmrn.$thn_smt;
}

function format_indo($date){
    date_default_timezone_set('Asia/Jakarta');
    // array hari dan bulan
    $Hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
    $Bulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
    
    // pemisahan tahun, bulan, hari, dan waktu
    $tahun = substr($date,0,4);
    $bulan = substr($date,5,2);
    $tgl = substr($date,8,2);
    $waktu = substr($date,11,5);
    $hari = date("w",strtotime($date));
    $result = $Hari[$hari].", ".$tgl." ".$Bulan[(int)$bulan-1]." ".$tahun." ".$waktu;

    return $result;
}

function tanggal_indo($tgl)
{
	//$jam = explode(' ', $tgl)[1];
	$ubah = gmdate(explode(' ', $tgl)[0], time()+60*60*8);
	$pecah = explode("-",$ubah);
	$tanggal = $pecah[2];
	$bulan = bulan($pecah[1]);
	$tahun = $pecah[0];
	return $tanggal.' '.$bulan.' '.$tahun;
}

function jenis_keluar($id_jns_keluar=null)
{
	$jns_keluar = array(0=>"Aktif","Lulus","Mutasi","Dikeluarkan","Mengundurkan diri","Putus Sekolah","Wafat","Hilang","Alih Fungsi","Pensiun",'Z'=>'Lainnya');
	if($id_jns_keluar) return $jns_keluar[$id_jns_keluar];
	return $jns_keluar;
}

function bulan($bln)
{
	switch ($bln)
	{
		case 1:
			return "Januari";
			break;
		case 2:
			return "Februari";
			break;
		case 3:
			return "Maret";
			break;
		case 4:
			return "April";
			break;
		case 5:
			return "Mei";
			break;
		case 6:
			return "Juni";
			break;
		case 7:
			return "Juli";
			break;
		case 8:
			return "Agustus";
			break;
		case 9:
			return "September";
			break;
		case 10:
			return "Oktober";
			break;
		case 11:
			return "November";
			break;
		case 12:
			return "Desember";
			break;
	}
}
