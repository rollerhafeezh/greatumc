<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mitra_data_model extends CI_Model {
    
    var $column_order = array(null, 'nama_merek', 'alamat', 'telepon', 'aktif', null, null);
    var $column_search = array('m.nama_resmi', 'm.nama_merek', 'm.alamat', 'm.telepon');
    var $order = array('mpm.created_at' => 'desc');
	
	function __construct()
	{
		parent::__construct();
	}
	
	 private function _get_datatables_query()
    {
		$this->db->select('*');
        $this->db->from($_ENV['DB_MBKM'].'mitra m');

        if($this->input->get('aktif') != '') $this->db->where('m.aktif',$this->input->get('aktif'));
        if($this->input->get('id_jenis_instansi') != '') $this->db->where('m.id_jenis_instansi',$this->input->get('id_jenis_instansi'));
        // $this->db->where('sha1(mpm.id_program_mitra)', $this->input->get('ipm'));

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