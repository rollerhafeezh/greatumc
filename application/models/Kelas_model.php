<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function hapus_kelas($id_kelas_kuliah)
	{
		$this->db->where('id_kelas_kuliah',$id_kelas_kuliah);
		return $this->db->delete('kelas_kuliah');
	}
	
	function check_count($id_kelas_kuliah,$tabel)
	{
		$this->db->select('id_kelas_kuliah');
		$this->db->where('id_kelas_kuliah',$id_kelas_kuliah);
		return $this->db->get($tabel)->num_rows();
	}
	
	function update_kelas_kuliah($id_kelas_kuliah,$field,$value)
	{
		$this->db->where('id_kelas_kuliah',$id_kelas_kuliah);
		$this->db->set($field,$value);
		return $this->db->update('kelas_kuliah');
	}
	
	function proses_ganti_jadwal_ujian($jenis,$data)
	{
		if($jenis=='uts')
		{
			$this->db->set('tgl_uts',$data['tgl_uts']);
			$this->db->set('id_ruangan_uts',$data['id_ruangan_uts']);
			$this->db->set('jam_mulai_uts',$data['jam_mulai_uts']);
			$this->db->set('jam_selesai_uts',$data['jam_selesai_uts']);
		}
		
		if($jenis=='uas')
		{
			$this->db->set('tgl_uas',$data['tgl_uas']);
			$this->db->set('id_ruangan_uas',$data['id_ruangan_uas']);
			$this->db->set('jam_mulai_uas',$data['jam_mulai_uas']);
			$this->db->set('jam_selesai_uas',$data['jam_selesai_uas']);
		}
		
		$this->db->where('id_kelas_kuliah',$data['id_kelas_kuliah']);
		return $this->db->update('kelas_kuliah');
	}
	function proses_ganti_jadwal($data)
	{
		$this->db->where('id_kelas_kuliah',$data['id_kelas_kuliah']);
		$this->db->set('hari_kuliah',$data['hari_kuliah']);
		$this->db->set('id_ruangan',$data['id_ruangan']);
		$this->db->set('jam_mulai',$data['jam_mulai']);
		$this->db->set('jam_selesai',$data['jam_selesai']);
		return $this->db->update('kelas_kuliah');
	}
	
	function ganti_kuota($id_kelas_kuliah,$kuota_kelas)
	{
		$this->db->where('id_kelas_kuliah',$id_kelas_kuliah);
		$this->db->set('kuota_kelas',$kuota_kelas);
		return $this->db->update('kelas_kuliah');
	}
	
	function ganti_nm_kls($id_kelas_kuliah,$nm_kls)
	{
		$this->db->where('id_kelas_kuliah',$id_kelas_kuliah);
		$this->db->set('nm_kls',$nm_kls);
		return $this->db->update('kelas_kuliah');
	}
	
	function proses_ganti_pengampu($id_ajar_dosen,$id_dosen)
	{
		$this->db->where('id_ajar_dosen',$id_ajar_dosen);
		$this->db->set('id_dosen',$id_dosen);
		$this->db->set('sync_to_feeder','N');
		return $this->db->update('ajar_dosen');
	}
	
	function simpan_kelas_kuliah($data)
	{
		$this->db->insert('kelas_kuliah',$data);
		return $this->db->insert_id();
	}
	
	function simpan_ajar_dosen($data)
	{
		return $this->db->insert('ajar_dosen',$data);
	}

    function ref_ruangan_ujian($jenis,$data)
	{
		if($jenis=='uts')
		{
			$query = 'select id_ruangan_uts as id_ruangan from '.$_ENV['DB_GREAT'].'kelas_kuliah where (? BETWEEN `jam_mulai_uts` AND `jam_selesai_uts` OR ? = `jam_mulai_uts`) and tgl_uts = ? and id_smt = ?';
			$id_ruangan = $this->db->query($query, array($data['jam_mulai_uts'],$data['jam_mulai_uts'],$data['tgl_uts'],$data['id_smt']));
		}
		
		if($jenis=='uas')
		{
			$query = 'select id_ruangan_uas as id_ruangan from '.$_ENV['DB_GREAT'].'kelas_kuliah where (? BETWEEN `jam_mulai_uas` AND `jam_selesai_uas` OR ? = `jam_mulai_uas`) and tgl_uas = ? and id_smt = ?';
			$id_ruangan = $this->db->query($query, array($data['jam_mulai_uas'],$data['jam_mulai_uas'],$data['tgl_uas'],$data['id_smt']));
		}
		
		$id_ruangans = array();
		if( $id_ruangan->num_rows() > 0 )
		{
			foreach( $id_ruangan->result() as $row )
			{
				$id_ruangans[] = $row->id_ruangan;
			}
			if($data['id_gedung'])
			{
				if($data['id_gedung']!=1)
				{
					$this->db->where_not_in('id_ruangan', $id_ruangans);
				}
			}else{
				$this->db->where_not_in('id_ruangan', $id_ruangans);
			}
		} 
		
		if($data['id_gedung'])
		{
			$this->db->where('id_gedung',$data['id_gedung']);
		}
		return $this->db->get($_ENV['DB_REF'].'ruangan');
	}
	
	function get_id_kelas_aktif($data)
	{
		$query = 'select id_kelas_kuliah from '.$_ENV['DB_GREAT'].'kelas_kuliah where (? BETWEEN `jam_mulai` AND `jam_selesai` OR ? = `jam_mulai`) and hari_kuliah = ? and id_smt = ?';
		$id_kelas_kuliah = $this->db->query($query, array($data['jam_mulai'],$data['jam_mulai'],$data['hari_kuliah'],$data['id_smt']));
		$id_kelas_kuliahs = array();
		if( $id_kelas_kuliah->num_rows() > 0 )
		{
			foreach( $id_kelas_kuliah->result() as $row )
			{
				$id_kelas_kuliahs[] = $row->id_kelas_kuliah;
			}
			
			$this->db->select('id_dosen');
			$this->db->where_in('id_kelas_kuliah', $id_kelas_kuliahs);
			$sql = $this->db->get('ajar_dosen');
			$id_dosens=array();
			if( $sql->num_rows() > 0 )
			{
				foreach( $sql->result() as $row )
				{
					$id_dosens[] = $row->id_dosen;
				}
				return $id_dosens;
			}else{
				return false;
			}
		} 
		return false;
	}
	
}