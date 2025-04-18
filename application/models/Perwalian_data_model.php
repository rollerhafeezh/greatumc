<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perwalian_data_model extends CI_Model {
    
    var $column_order = array(null,'b.id_mahasiswa_pt', 'c.nm_pd',null,'b.mulai_smt','b.id_jns_keluar');
    var $column_search = array('b.id_mahasiswa_pt', 'c.nm_pd');
    var $order = array('b.id_mahasiswa_pt' => 'asc');
	
	function __construct()
	{
		parent::__construct();
	}
	
	private function _get_datatables_query()
    {
		$this->db->select('b.id_jns_keluar,b.id_mahasiswa_pt,c.nm_pd,b.mulai_smt,f.inisial_fak,p.nama_prodi');
        if($this->input->get('kode_fak')!=0) $this->db->where('p.kode_fak',$this->input->get('kode_fak'));
		if($this->input->get('id_jns_keluar')!=99) $this->db->where('b.id_jns_keluar',$this->input->get('id_jns_keluar'));
		if($this->input->get('mulai_smt')!=0) $this->db->where('b.mulai_smt',$this->input->get('mulai_smt'));
		if($this->input->get('kode_prodi')!=0) $this->db->where('b.kode_prodi',$this->input->get('kode_prodi'));
		if($this->input->get('id_dosen')!=0) $this->db->where('b.id_dosen',$this->input->get('id_dosen'));
		
		$this->db->from($_ENV['DB_GREAT'].'mahasiswa_pt b');
        $this->db->join($_ENV['DB_GREAT'].'mahasiswa c', 'c.id_mhs=b.id_mhs');
		$this->db->join($_ENV['DB_REF'].'prodi p','b.kode_prodi=p.kode_prodi');
		$this->db->join($_ENV['DB_REF'].'fakultas f','p.kode_fak=f.kode_fak');
        $this->db->join($_ENV['DB_GREAT'].'dosen d', 'd.id_dosen=b.id_dosen');
 
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