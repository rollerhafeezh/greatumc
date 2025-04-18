<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_data_model extends CI_Model {
    
    var $column_order = array('whenat');
    var $column_search = array('whois','whythis','wherefrom');
    var $order = array('whenat' => 'desc');
	
	function __construct()
	{
		parent::__construct();
	}
	
	 private function _get_datatables_query()
    {
        //if($this->input->get('whois')!='') $this->db->where('whois',$this->input->get('whois'));
        if($this->input->get('whois')!='') $this->db->like('whois',$this->input->get('whois'));
        if($this->input->get('whythis')!='0') $this->db->like('whythis',$this->input->get('whythis'));
        if($this->input->get('wherefrom')) $this->db->like('wherefrom',$this->input->get('wherefrom'));
        $this->db->where('whenat BETWEEN "'.$this->input->get('awal').' 00:00:00" and "'.$this->input->get('akhir').' 23:59:59"');
		$this->db->from($_ENV['DB_GREAT'].'akademik_log');
 
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