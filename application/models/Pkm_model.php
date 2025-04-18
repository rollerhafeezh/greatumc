<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pkm_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function buat_sesi()
	{
	    $this->db->set('tgl_mulai',date("Y-m-d"));
	    $this->db->set('tgl_selesai',date("Y-m-d"));
	    $this->db->insert($_ENV['DB_PKM'].'sesi');
	    return $this->db->insert_id();
	}
	
	function buat_bidang()
	{
	    $this->db->set('jenis_pkm',"-");
	    $this->db->insert($_ENV['DB_REF'].'jenis_pkm');
	    return $this->db->insert_id();
	}
	
	function get_sesi($id_sesi=null)
	{
	    if($id_sesi)
	    {
	        $this->db->where('id_sesi',$id_sesi);
	    }
	    $this->db->order_by('id_sesi','asc');
	    return $this->db->get($_ENV['DB_PKM'].'sesi');
	}
	
	function get_bidang($id_jenis_pkm=null)
	{
	    if($id_jenis_pkm)
	    {
	        $this->db->where('id_jenis_pkm',$id_jenis_pkm);
	    }
	    $this->db->order_by('id_jenis_pkm','asc');
	    return $this->db->get($_ENV['DB_REF'].'jenis_pkm');
	}
	
	function check_validasi($sebagai,$id_aktivitas)
	{
	     $this->db->where('id_aktivitas',$id_aktivitas);
	     $this->db->where('sebagai',$sebagai);
	     return $this->db->get($_ENV['DB_PKM'].'validasi');
	}
	
	function validasi_ajuan($sebagai,$id_aktivitas)
	{
	    $this->db->set('id_aktivitas',$id_aktivitas);
	    $this->db->set('sebagai',$sebagai);
	    $this->db->set('oleh',$_SESSION['nama_pengguna']);
	    $this->db->insert($_ENV['DB_PKM'].'validasi');
	}
	
	function update_aktivitas($id_aktivitas,$isi,$komponen)
	{
	    $this->db->where('id_aktivitas',$id_aktivitas);
		$this->db->set($komponen,$isi);
		return $this->db->update($_ENV['DB_PKM'].'aktivitas');
	}
	
	function update_sesi($id_sesi,$isi,$komponen)
	{
	    $this->db->where('id_sesi',$id_sesi);
		$this->db->set($komponen,$isi);
		return $this->db->update($_ENV['DB_PKM'].'sesi');
	}
	
	function update_bidang($id_jenis_pkm,$isi,$komponen)
	{
	    $this->db->where('id_jenis_pkm',$id_jenis_pkm);
		$this->db->set($komponen,$isi);
		return $this->db->update($_ENV['DB_REF'].'jenis_pkm');
	}
	
	function hapus_percakapan($id_bimbingan)
	{
		$this->db->where('id_bimbingan',$id_bimbingan);
		$this->db->set('status','0');
		return $this->db->update($_ENV['DB_PKM'].'bimbingan');
	}
	
	function add_percakapan($data)
	{
	    return $this->db->insert($_ENV['DB_PKM'].'bimbingan',$data);
	}
	
	function get_dokumen($id_aktivitas)
	{
	    $this->db->order_by('nama_dokumen','asc');
	    return $this->db->get_where($_ENV['DB_PKM'].'dokumen',array('status_dokumen'=>1,'id_aktivitas'=>$id_aktivitas));
	}
	
	function add_dokumen($data)
	{
	    return $this->db->insert($_ENV['DB_PKM'].'dokumen',$data);
	}
	
	function percakapan($id_aktivitas)
	{
	    $this->db->order_by('created_at','desc');
	    return $this->db->get_where($_ENV['DB_PKM'].'bimbingan',array('status'=>1,'id_aktivitas'=>$id_aktivitas));
	}
	
	function riwayat($id_aktivitas)
	{
	    $this->db->order_by('created_at','desc');
	    return $this->db->get_where($_ENV['DB_PKM'].'riwayat',array('id_aktivitas'=>$id_aktivitas));
	}
	
	function add_riwayat($data)
	{
	    return $this->db->insert($_ENV['DB_PKM'].'riwayat',$data);
	}
	
	function get_aktivitas($id_aktivitas)
	{
	    if($_SESSION['app_level']==1)  $this->db->where('ang.id_mahasiswa_pt',$_SESSION['id_user']);
	    $this->db->where('a.id_aktivitas',$id_aktivitas);
	    $this->db->join($_ENV['DB_PKM'].'anggota ang','a.id_aktivitas=ang.id_aktivitas','left');
	    $this->db->join($_ENV['DB_REF'].'jenis_pkm ref','ref.id_jenis_pkm=a.id_jenis_pkm');
	    return $this->db->get($_ENV['DB_PKM'].'aktivitas a');
	}
	
	function cek_sesi()
	{
		$this->db->where('aktif',1);
		return $this->db->get($_ENV['DB_PKM'].'sesi');
	}
	
	function ref_jenis()
	{
		$this->db->where('aktif',1);
		return $this->db->get($_ENV['DB_REF'].'jenis_pkm');
	}
	
	function add_pkm($data)
	{
	    $this->db->insert($_ENV['DB_PKM'].'aktivitas',$data);
	    return $this->db->insert_id();
	}
	
	function add_anggota($data)
	{
	    return $this->db->insert($_ENV['DB_PKM'].'anggota',$data);
	}
}