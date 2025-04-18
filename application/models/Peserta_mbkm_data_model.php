<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peserta_mbkm_data_model extends CI_Model {
    
    var $column_order = array(null, 'pn.id_mahasiswa_pt', 'nm_pd', 'inisial_fak', 'smt_mhs', 'pn.status');
    var $column_search = array('pn.id_mahasiswa_pt', 'nm_pd', 'inisial_fak', 'nama_prodi', 'nm_jenj_didik', 'smt_mhs', 'pn.status');
    var $order = array('smt_mhs' => 'asc');
	
	function __construct()
	{
		parent::__construct();
	}
	
	 private function _get_datatables_query()
    {
		$this->db->select('pn.*, m.nm_pd, inisial_fak, nama_prodi, nm_jenj_didik, smt_mhs');
		$this->db->from($_ENV['DB_MBKM'].'pendaftaran pn');
        $this->db->join($_ENV['DB_MBKM'].'program_mitra pm','pm.id_program_mitra = pn.id_program_mitra');

        $this->db->join($_ENV['DB_GREAT'].'mahasiswa_pt mp','mp.id_mahasiswa_pt = pn.id_mahasiswa_pt');
        $this->db->join($_ENV['DB_GREAT'].'mahasiswa m','m.id_mhs = mp.id_mhs');

		$this->db->join($_ENV['DB_REF'].'prodi p','p.kode_prodi = pm.kode_prodi');
        $this->db->join($_ENV['DB_REF'].'fakultas f','p.kode_fak = f.kode_fak');
		$this->db->join($_ENV['DB_REF'].'jenjang_pendidikan jp','jp.id_jenj_didik = p.id_jenjang_pendidikan');
    
        if($this->input->get('id_program_mitra')!='0') $this->db->where('sha1(pn.id_program_mitra)', $this->input->get('id_program_mitra'));

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
        // print_r($this->db->last_query());    
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