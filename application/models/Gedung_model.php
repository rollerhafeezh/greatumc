<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Gedung_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_gedung($id_gedung=null,$status=null)
	{
		if($id_gedung)
		{
			$this->db->where('id_gedung',$id_gedung);
		}
		if($status)
		{
			$this->db->where('status_gedung',$status);
		}
		$this->db->where('id_gedung !=',0);
		return $this->db->get($_ENV['DB_REF'].'gedung');
	}
	
	function get_ruangan($id_ruangan=null,$id_gedung=null,$status=null)
	{
		if($id_ruangan)
		{
			$this->db->where('a.id_ruangan',$id_ruangan);
		}
		
		if($id_gedung)
		{
			$this->db->where('a.id_gedung',$id_gedung);
		}
		if($status)
		{
			$this->db->where('a.status_ruangan',$status);
		}
		
		$this->db->where('a.id_ruangan !=',0);
		$this->db->join($_ENV['DB_REF'].'gedung b','a.id_gedung=b.id_gedung');
		return $this->db->get($_ENV['DB_REF'].'ruangan a');
	}
	
	function ganti_status_gedung($data)
	{
		$this->db->where('id_gedung',$data['id_gedung']);
		$this->db->set('status_gedung',$data['status_gedung']);
		return $this->db->update($_ENV['DB_REF'].'gedung');
	}
	
	function ganti_nama_gedung($data)
	{
		$this->db->where('id_gedung',$data['id_gedung']);
		$this->db->set('nama_gedung',$data['nama_gedung']);
		return $this->db->update($_ENV['DB_REF'].'gedung');
	}
	
	function ganti_status_ruangan($data)
	{
		$this->db->where('id_ruangan',$data['id_ruangan']);
		$this->db->set('status_ruangan',$data['status_ruangan']);
		return $this->db->update($_ENV['DB_REF'].'ruangan');
	}
	
	function ganti_nama_ruangan($data)
	{
		$this->db->where('id_ruangan',$data['id_ruangan']);
		$this->db->set('nama_ruangan',$data['nama_ruangan']);
		return $this->db->update($_ENV['DB_REF'].'ruangan');
	}
	
	function simpan_gedung($data)
	{
		$this->db->insert($_ENV['DB_REF'].'gedung',$data);
		return $this->db->insert_id();
	}
	
	function simpan_ruangan($data)
	{
		$this->db->insert($_ENV['DB_REF'].'ruangan',$data);
		return $this->db->insert_id();
	}
}