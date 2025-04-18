<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring_pbm_data_model extends CI_Model {
    
    var $column_order = array(null,null,'a.jam_mulai','c.jam_mulai');
    var $column_search = array('b.nm_mk','a.nm_kls');
    var $order = array(null,null,'a.jam_mulai' => 'asc');
	
	function __construct()
	{
		parent::__construct();
	}
	
	 private function _get_datatables_query()
    {
        if($this->input->get('kode_fak')!='0') $this->db->where('f.kode_fak',$this->input->get('kode_fak'));
 		if($this->input->get('kode_prodi')!='0') $this->db->where('a.kode_prodi',$this->input->get('kode_prodi'));
        if($this->input->get('selesai')==1) {
            $this->db->where('c.jam_selesai is not null');
        }
        if($this->input->get('selesai')==2) {
            $this->db->where('c.tanggal is not null');
            $this->db->where('c.jam_selesai is null');
        }
        if($this->input->get('selesai')==3) {
            $this->db->where('c.tanggal is null');
        }
            
		if($this->input->get('id_gedung')!='0') $this->db->where('g.id_gedung',$this->input->get('id_gedung'));
		if($this->input->get('id_ruangan')!='0') $this->db->where('a.id_ruangan',$this->input->get('id_ruangan'));
		
		if($this->input->get('tanggal'))
		{
			$tanggal = strtotime($this->input->get('tanggal'));
			$hari = date('N', $tanggal);
			$this->db->where('a.hari_kuliah',$hari);
		}
		$this->db->select('a.id_kelas_kuliah,a.nm_kls,b.nm_mk,f.inisial_fak,p.nama_prodi,a.hari_kuliah,a.jam_mulai,.a.jam_selesai,r.nama_ruangan,g.nama_gedung,if(c.tanggal is null,0, if(c.jam_selesai is null,1,2)) as status_kuliah');
		
		$this->db->where('a.id_smt',$_SESSION['active_smt']);
		$this->db->join($_ENV['DB_GREAT'].'bap_kuliah c','a.id_kelas_kuliah=c.id_kelas_kuliah and c.tanggal="'.$this->input->get('tanggal').'" and (c.tipe_kuliah="kuliah" or c.tipe_kuliah="responsi")','left');
		$this->db->join($_ENV['DB_GREAT'].'mata_kuliah b','a.id_matkul=b.id_matkul');
		$this->db->join($_ENV['DB_REF'].'ruangan r','r.id_ruangan=a.id_ruangan');
		$this->db->join($_ENV['DB_REF'].'gedung g','r.id_gedung=g.id_gedung');
        $this->db->join($_ENV['DB_REF'].'prodi p','p.kode_prodi=a.kode_prodi');
        $this->db->join($_ENV['DB_REF'].'fakultas f','f.kode_fak=p.kode_fak');
		$this->db->group_by('a.id_kelas_kuliah');
		$this->db->from($_ENV['DB_GREAT'].'kelas_kuliah a');
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