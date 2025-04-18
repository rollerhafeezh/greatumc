<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Arsip_kelas_kuliah_dosen_data_model extends CI_Model {
    
    var $column_order = array('a.id_smt', 'c.nm_mk',null);
    var $column_search = array('c.b.nm_mk', 'b.nm_kls');
    var $order = array('a.id_smt' => 'asc','c.nm_mk'=>'asc');
	
	function __construct()
	{
		parent::__construct();
	}
	
	 private function _get_datatables_query()
    {
        $this->db->select('b.nm_sdm,b.nidn,b.id_dosen,p.nama_prodi,f.inisial_fak,f.nama_fak,a.sks_subst_tot,d.nm_kls,c.nm_mk,c.id_matkul,d.id_kelas_kuliah,a.id_smt,d.hari_kuliah,d.jam_mulai,d.jam_selesai');
        
        //if($this->input->get('kode_fak')!='0') $this->db->where('f.kode_fak',$this->input->get('kode_fak'));
		if($this->input->get('id_smt')!='0') $this->db->where('a.id_smt',$this->input->get('id_smt'));
		//if($this->input->get('kode_prodi')!='0') $this->db->where('p.kode_prodi',$this->input->get('kode_prodi'));
		if($this->input->get('id_dosen')) $this->db->where('b.id_dosen',$this->input->get('id_dosen'));
		
		$this->db->join($_ENV['DB_GREAT'].'dosen b','a.id_dosen=b.id_dosen');
		$this->db->join($_ENV['DB_GREAT'].'kelas_kuliah d','a.id_kelas_kuliah=d.id_kelas_kuliah');
		$this->db->join($_ENV['DB_GREAT'].'mata_kuliah c','d.id_matkul=c.id_matkul');
		$this->db->join($_ENV['DB_REF'].'prodi p','d.kode_prodi=p.kode_prodi', 'left');
		$this->db->join($_ENV['DB_REF'].'fakultas f','f.kode_fak=p.kode_fak', 'left');
		$this->db->from($_ENV['DB_GREAT'].'ajar_dosen a');
		
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