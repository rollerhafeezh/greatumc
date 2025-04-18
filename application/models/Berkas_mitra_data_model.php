<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berkas_mitra_data_model extends CI_Model {
    
    var $column_order = array(null, 'nama_berkas', 'bm.created_at', 'bm.berkas', null);
    var $column_search = array(null, 'nama_berkas', 'bm.created_at', 'bm.berkas', null);
    var $order = array('bm.created_at' => 'desc');
    
    function __construct()
    {
        parent::__construct();
    }
    
     private function _get_datatables_query()
    {
        $this->db->select('bm.*, b.slug, b.nama_berkas, b.deskripsi');

        $this->db->from($_ENV['DB_MBKM'].'berkas_mitra bm');
        $this->db->join($_ENV['DB_MBKM'].'mitra m','m.id_mitra = bm.id_mitra');
        $this->db->join($_ENV['DB_MBKM'].'berkas b','b.id_berkas = bm.id_berkas');

        $this->db->where('sha1(bm.id_mitra)', $this->input->get('id_mitra'));

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