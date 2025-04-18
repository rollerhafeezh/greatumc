<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pkm_data_model extends CI_Model {
    
    var $column_order = array('a.id_smt','a.judul', 'a.id_jenis_pkm','a.status');
    var $column_search = array('a.judul');
    var $order = array('a.id_aktivitas' => 'asc');
	
	function __construct()
	{
		parent::__construct();
	}
	
	 private function _get_datatables_query()
    {
		if($this->input->get('kode_fak')!='0') $this->db->where('f.kode_fak',$this->input->get('kode_fak'));
		if($this->input->get('kode_prodi')!='0') $this->db->where('a.kode_prodi',$this->input->get('kode_prodi'));
		if($this->input->get('id_smt')!='0') $this->db->where('a.id_smt',$this->input->get('id_smt'));
		if($this->input->get('id_jenis_pkm')!='0') $this->db->where('a.id_jenis_pkm',$this->input->get('id_jenis_pkm'));
		if($this->input->get('status_aktivitas')!='9') $this->db->where('a.status_aktivitas',$this->input->get('status_aktivitas'));
		if($_SESSION['app_level']==1)  $this->db->where('ang.id_mahasiswa_pt',$_SESSION['id_user']);
		//$this->db->select('a.id_smt,a.id_kur,a.nm_kurikulum_sp,a.kur_aktif,p.nama_prodi,f.inisial_fak');
		$this->db->join($_ENV['DB_PKM'].'anggota ang','a.id_aktivitas=ang.id_aktivitas');
		$this->db->join($_ENV['DB_REF'].'jenis_pkm j','a.id_jenis_pkm=j.id_jenis_pkm');
		$this->db->join($_ENV['DB_REF'].'prodi p','a.kode_prodi=p.kode_prodi');
		$this->db->join($_ENV['DB_REF'].'fakultas f','f.kode_fak=p.kode_fak');
        $this->db->from($_ENV['DB_PKM'].'aktivitas a');
		
        $i = 0;
     
        foreach ($this->column_search as $item) 
        {
            if($_GET['search']['value']) 
            {
                 
                if($i===0) 
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_GET['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_GET['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_GET['order'])) 
        {
            $this->db->order_by($this->column_order[$_GET['order']['0']['column']], $_GET['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_GET['length'] != -1)
        $this->db->limit($_GET['length'], $_GET['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
}