<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Matkul_data_model extends CI_Model {
    
    var $column_order = array('a.id_matkul','a.kode_mk', 'a.nm_mk',null);
    var $column_search = array('a.kode_mk', 'a.nm_mk','a.id_matkul');
    var $order = array('a.nm_mk' => 'asc');
	
	function __construct()
	{
		parent::__construct();
	}
	
	 private function _get_datatables_query()
    {
        if($this->input->get('kode_fak')!='0') $this->db->where('f.kode_fak',$this->input->get('kode_fak'));
		if($this->input->get('kode_prodi')!='0') $this->db->where('a.kode_prodi',$this->input->get('kode_prodi'));
		$this->db->select('a.id_matkul,a.nm_mk,a.kode_prodi,f.inisial_fak,p.nama_prodi,a.kode_mk');
		$this->db->join($_ENV['DB_REF'].'prodi p','a.kode_prodi=p.kode_prodi');
		$this->db->join($_ENV['DB_REF'].'fakultas f','p.kode_fak=f.kode_fak');
		$this->db->from($_ENV['DB_GREAT'].'mata_kuliah a');
 
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
        //$this->db->from($this->table);
        //return $this->db->count_all_results();
    }
}