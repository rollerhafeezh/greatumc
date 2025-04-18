<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Matkul_model extends CI_Model {
    
    function __construct()
	{
		parent::__construct();
	}
	
	function simpan_matkul($data)
	{
		$this->db->insert('mata_kuliah',$data);
		return $this->db->insert_id();
	}
	
	function get_matkul($id_matkul=null)
	{
		if($id_matkul)
		{
			$this->db->where('a.id_matkul',$id_matkul);
		}
		$this->db->join($_ENV['DB_REF'].'jenis_mata_kuliah d','d.inisial_jenis_mk=a.jns_mk','left');
		$this->db->join($_ENV['DB_REF'].'prodi b','a.kode_prodi=b.kode_prodi');
		$this->db->join($_ENV['DB_REF'].'fakultas c','c.kode_fak=b.kode_fak');
		$this->db->join($_ENV['DB_REF'].'kategori_mata_kuliah e','e.id_kat_mk=a.id_kat_mk');
		return $this->db->get($_ENV['DB_GREAT'].'mata_kuliah a');
	}
	
	function check_nilai($id_matkul)
	{
		$this->db->where('id_matkul',$id_matkul);
		return $this->db->get($_ENV['DB_GREAT'].'nilai')->row();
	}
	
	function check_kelas($id_matkul)
	{
		$this->db->where('id_matkul',$id_matkul);
		return $this->db->get($_ENV['DB_GREAT'].'kelas_kuliah')->row();
	}
	
	function hapus_matkul($id_matkul)
	{
		$this->db->where('id_matkul',$id_matkul);
		return $this->db->delete($_ENV['DB_GREAT'].'mata_kuliah');
	}
	
	function update_matkul($data)
	{
	    $this->db->set('sks_mk',$data['sks_mk']);
		$this->db->set('sks_tm',$data['sks_tm']);
		$this->db->set('sks_prak',$data['sks_prak']);
		$this->db->set('sks_prak_lap',$data['sks_prak_lap']);
		$this->db->set('sks_sim',$data['sks_sim']);
		$this->db->where('id_matkul',$data['id_matkul']);
		$this->db->update($_ENV['DB_GREAT'].'mata_kuliah_kurikulum');
		
		$this->db->where('id_matkul',$data['id_matkul']);
		$this->db->set('kode_mk',$data['kode_mk']);
		$this->db->set('nm_mk',$data['nm_mk']);
		$this->db->set('nm_mk_en',$data['nm_mk_en']);
		$this->db->set('jns_mk',$data['jns_mk']);
		$this->db->set('id_kat_mk',$data['id_kat_mk']);
		$this->db->set('sks_mk',$data['sks_mk']);
		$this->db->set('sks_tm',$data['sks_tm']);
		$this->db->set('sks_prak',$data['sks_prak']);
		$this->db->set('sks_prak_lap',$data['sks_prak_lap']);
		$this->db->set('sks_sim',$data['sks_sim']);
		return $this->db->update($_ENV['DB_GREAT'].'mata_kuliah');
	}
}