<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kuliah_mahasiswa_data_model extends CI_Model {
    
    var $column_order = array('a.id_mahasiswa_pt','c.nm_pd',null,'a.id_smt','a.id_stat_mhs','a.smt_mhs','a.biaya_kuliah','a.ips','a.ipk','a.sks_smt','a.sks_total');
    var $column_search = array('a.id_mahasiswa_pt');
    var $order = array('id_mahasiswa_pt' => 'asc');
	
	function __construct()
	{
		parent::__construct();
	}
	
	 private function _get_datatables_query()
    {
        if($this->input->get('kode_fak')!='0') $this->db->where('f.kode_fak',$this->input->get('kode_fak'));
		if($this->input->get('id_smt')!='0') $this->db->where('a.id_smt',$this->input->get('id_smt'));
		if($this->input->get('mulai_smt')!='0') $this->db->where('b.mulai_smt',$this->input->get('mulai_smt'));
		if($this->input->get('kode_prodi')!='0') $this->db->where('b.kode_prodi',$this->input->get('kode_prodi'));
		if($this->input->get('id_stat_mhs')!='0') $this->db->where('a.id_stat_mhs',$this->input->get('id_stat_mhs'));
		if($this->input->get('smt_mhs')!='0') {
			if($this->input->get('smt_mhs')=='15') {
				$this->db->where('a.smt_mhs > 14');
			}else{
				$this->db->where('a.smt_mhs',$this->input->get('smt_mhs'));
			}
		}
		
		$this->db->select('a.id_mahasiswa_pt,c.nm_pd,f.inisial_fak,p.nama_prodi,p.kode_fak,b.kode_prodi,a.id_smt,a.id_stat_mhs,a.smt_mhs,a.biaya_kuliah,a.ips,a.ipk,a.sks_smt,a.sks_total');
        $this->db->from($_ENV['DB_GREAT'].'kuliah_mahasiswa a');
		$this->db->join($_ENV['DB_GREAT'].'mahasiswa_pt b', 'a.id_mahasiswa_pt=b.id_mahasiswa_pt');
        $this->db->join($_ENV['DB_GREAT'].'mahasiswa c', 'c.id_mhs=b.id_mhs');
		$this->db->join($_ENV['DB_REF'].'prodi p','b.kode_prodi=p.kode_prodi');
		$this->db->join($_ENV['DB_REF'].'fakultas f','p.kode_fak=f.kode_fak');
 
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