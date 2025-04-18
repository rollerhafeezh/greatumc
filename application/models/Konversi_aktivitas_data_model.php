<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konversi_aktivitas_data_model extends CI_Model {
    
    var $column_order = array(null, 'cpl', 'sks_cpl', 'nm_mk', 'sks_mk', 'nilai_angka', 'nilai_huruf', 'nilai_indeks', 'id_konversi_aktivitas');
    var $column_search = array(null, 'cpl', 'sks_cpl', 'nm_mk', 'sks_mk', 'nilai_angka', 'nilai_huruf', 'nilai_indeks', 'id_konversi_aktivitas');
    var $order = array('created_at' => 'desc');
	
	function __construct()
	{
		parent::__construct();
	}
	
	 private function _get_datatables_query()
    {
		$this->db->select('ka.*, mk.kode_mk, mk.nm_mk, mk.sks_mk, mkk.smt, jc.nama_jenis_cpl');

        $this->db->from($_ENV['DB_MBKM'].'konversi_aktivitas ka');
        $this->db->join($_ENV['DB_MBKM'].'aktivitas a','a.id_aktivitas = ka.id_aktivitas');
        $this->db->join($_ENV['DB_MBKM'].'anggota aa','aa.id_anggota = ka.id_anggota');
        $this->db->join($_ENV['DB_GREAT'].'mata_kuliah_kurikulum mkk','mkk.id_matkul = ka.id_matkul');
        $this->db->join($_ENV['DB_GREAT'].'mata_kuliah mk','mk.id_matkul = mkk.id_matkul');
        $this->db->join($_ENV['DB_REF'].'jenis_cpl jc','jc.id_jenis_cpl = ka.id_jenis_cpl', 'left');

        $this->db->where('sha1(ka.id_aktivitas)', $this->input->get('id_aktivitas'));
        $this->db->where('sha1(ka.id_anggota)', $this->input->get('id_anggota'));
        $this->db->where('ka.id_smt', $this->input->get('id_smt'));

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