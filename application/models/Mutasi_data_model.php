<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mutasi_data_model extends CI_Model {
    
	var $column_order = array(null,'a.id_mahasiswa_pt_lama','a.id_mahasiswa_pt_baru','p.nama_prodi', 'b.nm_pd','a.status_mutasi');
    var $column_search = array('a.id_mahasiswa_pt_lama','b.nm_pd');
    var $order = array('id_mahasiswa_pt' => 'asc');
	
	function __construct()
	{
		parent::__construct();
	}
	
	 private function _get_datatables_query()
    {
		$this->db->select('a.id_mutasi,b.nm_pd,a.id_mahasiswa_pt_lama,a.id_mahasiswa_pt_baru,a.mulai_smt,f.inisial_fak,p.nama_prodi,f.kode_fak,a.kode_prodi,b.email,a.status_mutasi');
        if($this->input->get('kode_fak')!=0) $this->db->where('f.kode_fak',$this->input->get('kode_fak'));
		if($this->input->get('mulai_smt')!=0) $this->db->where('a.mulai_smt',$this->input->get('mulai_smt'));
		if($this->input->get('kode_prodi')!=0) $this->db->where('a.kode_prodi',$this->input->get('kode_prodi'));
		if($this->input->get('status_mutasi')!=0) $this->db->where('a.status_mutasi',$this->input->get('status_mutasi'));
		
        $this->db->from($_ENV['DB_GREAT'].'mahasiswa_mutasi a');
        $this->db->join($_ENV['DB_GREAT'].'mahasiswa b', 'b.id_mhs=a.id_mhs');
        $this->db->join($_ENV['DB_REF'].'prodi p','a.kode_prodi=p.kode_prodi','left');
		$this->db->join($_ENV['DB_REF'].'fakultas f','p.kode_fak=f.kode_fak','left');
 
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