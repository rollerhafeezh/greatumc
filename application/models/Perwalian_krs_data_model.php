<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perwalian_krs_data_model extends CI_Model {
    
    var $column_order = array(null,'a.id_mahasiswa_pt', 'c.nm_pd','d.nm_sdm','a.validasi','a.validasi_aka','a.validasi_keu','a.validasi_prodi','k.sks_smt');
    var $column_search = array('a.id_mahasiswa_pt', 'c.nm_pd','d.nm_sdm');
    var $order = array('a.id_mahasiswa_pt' => 'asc');
	
	function __construct()
	{
		parent::__construct();
	}
	
	private function _get_datatables_query()
    {
        if($this->input->get('kode_fak')!=0) $this->db->where('p.kode_fak',$this->input->get('kode_fak'));
		if($this->input->get('mulai_smt')!=0) $this->db->where('b.mulai_smt',$this->input->get('mulai_smt'));
		if($this->input->get('id_smt')!=0) $this->db->where('a.id_smt',$this->input->get('id_smt'));
		if($this->input->get('kode_prodi')!=0) $this->db->where('b.kode_prodi',$this->input->get('kode_prodi'));
		if($_SESSION['app_level']==2) $this->db->where('d.id_dosen',$_SESSION['id_user']);
		if($this->input->get('validasi')!=0)
		{
			if($this->input->get('validasi')=='1') $this->db->where('a.validasi is not null'); 
			if($this->input->get('validasi')=='2') $this->db->where('a.validasi is null'); 
		}
		
		if($this->input->get('validasi_aka')!=0)
		{
			if($this->input->get('validasi_aka')=='1') $this->db->where('a.validasi_aka is not null'); 
			if($this->input->get('validasi_aka')=='2') $this->db->where('a.validasi_aka is null'); 
		}
		
		if($this->input->get('validasi_keu')!=0)
		{
			if($this->input->get('validasi_keu')=='1') $this->db->where('a.validasi_keu is not null'); 
			if($this->input->get('validasi_keu')=='2') $this->db->where('a.validasi_keu is null'); 
		}
		
		if($this->input->get('validasi_prodi')!=0)
		{
			if($this->input->get('validasi_prodi')=='1') $this->db->where('a.validasi_prodi is not null'); 
			if($this->input->get('validasi_prodi')=='2') $this->db->where('a.validasi_prodi is null'); 
		}
		
		$this->db->from($_ENV['DB_GREAT'].'krs_note a');
        $this->db->join($_ENV['DB_GREAT'].'mahasiswa_pt b', 'a.id_mahasiswa_pt=b.id_mahasiswa_pt');
		$this->db->join($_ENV['DB_GREAT'].'kuliah_mahasiswa k', 'a.id_mahasiswa_pt=k.id_mahasiswa_pt and k.id_smt='.$this->input->get('id_smt'),'left');
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