<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nilai_transfer_data_model extends CI_Model {
    
    var $column_order = array('nm_lemb', 'kode_mk_asal', 'nm_mk_asal', 'sks_asal', 'nilai_huruf_asal', 'kode_mk', 'nm_mk', 'sks_mk', 'nilai_angka_diakui', 'nilai_huruf_diakui', null);
    var $column_search = array('nm_lemb', 'kode_mk_asal', 'nm_mk_asal', 'sks_asal', 'nilai_huruf_asal', 'kode_mk', 'nm_mk', 'sks_mk', 'nilai_angka_diakui', 'nilai_huruf_diakui');
    var $order = array('nt.tgl_create' => 'desc');
	
	function __construct()
	{
		parent::__construct();
	}
	
	 private function _get_datatables_query()
    {
		$this->db->select('*');

        $this->db->from($_ENV['DB_GREAT'].'nilai_transfer nt');
        $this->db->join($_ENV['DB_MBKM'].'aktivitas a','a.id_aktivitas = nt.id_aktivitas');
        // $this->db->join($_ENV['DB_MBKM'].'anggota aa','aa.id_aktivitas = a.id_aktivitas');
        $this->db->join($_ENV['DB_GREAT'].'mata_kuliah mk','mk.id_matkul = nt.id_matkul');

        $this->db->where('sha1(nt.id_aktivitas)', $this->input->get('id_aktivitas'));
        $this->db->where('nt.id_mahasiswa_pt', $this->input->get('id_mahasiswa_pt'));

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