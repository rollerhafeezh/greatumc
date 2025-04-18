<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Nilai_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function simpan_nilai_konversi($data)
	{
	    return $this->db->insert('nilai_transfer',$data);
	}
	
	function get_kur_aktif($kode_prodi)
	{
	    $this->db->where('a.kode_prodi',$kode_prodi);
		$this->db->where('a.kur_aktif','1');
		$this->db->join($_ENV['DB_REF'].'prodi b','a.kode_prodi=b.kode_prodi');
		$this->db->join($_ENV['DB_REF'].'fakultas c','c.kode_fak=b.kode_fak');
		$this->db->order_by('nm_kurikulum_sp','asc');
		return $this->db->get($_ENV['DB_GREAT'].'kurikulum a');
	}
	
	function get_mk($id_matkul)
	{
	    $this->db->where('a.id_matkul',$id_matkul);
	    return $this->db->get($_ENV['DB_GREAT'].'mata_kuliah a');
	}
	
	function get_nilai($id_matkul,$id_mahasiswa_pt)
    {
        $sql = "
        SELECT 
			a.id_mahasiswa_pt, 
			MAX(a.nilai_mk) as nilai_indeks
		FROM
		(
			SELECT id_matkul, id_mahasiswa_pt, nilai_indeks as nilai_mk FROM ".$_ENV['DB_GREAT']."nilai
			UNION ALL
			SELECT id_matkul, id_mahasiswa_pt, nilai_angka_diakui as nilai_mk FROM ".$_ENV['DB_GREAT']."nilai_transfer
		) a
		RIGHT JOIN mata_kuliah b on a.id_matkul=b.id_matkul
		
		WHERE a.id_mahasiswa_pt = ?
		AND a.id_matkul=?
		";
        
        return $this->db->query($sql,array($id_mahasiswa_pt,$id_matkul));
    }
	
}