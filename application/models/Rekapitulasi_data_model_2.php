<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekapitulasi_data_model_2 extends CI_Model {
    
    var $column_order = array(null,null,'a.jam_mulai','c.jam_mulai');
    var $column_search = array('b.nm_mk','a.nm_kls');
    var $order = array('d.nm_sdm,c.nm_mk,b.nm_kls'=>'asc');
	
	function __construct()
	{
		parent::__construct();
	}
	
	 private function _get_datatables_query()
    {
        $this->db->select('d.nm_sdm,f.inisial_fak,p.nama_prodi,c.nm_mk,b.nm_kls,e.sks_subst_tot,a.tanggal,a.jam_mulai,a.jam_selesai');
        
        if($this->input->get('id_smt')) $this->db->where('b.id_smt',$this->input->get('id_smt'));
        if($this->input->get('kode_fak')) $this->db->where('f.kode_fak',$this->input->get('kode_fak'));
		if($this->input->get('kode_prodi')) $this->db->where('b.kode_prodi',$this->input->get('kode_prodi'));
		//$tanggal = strtotime($this->input->get('tanggal'));
		//$hari = date('N', $tanggal);
		
		//$this->db->select('a.id_kelas_kuliah,a.nm_kls,b.nm_mk,f.inisial_fak,p.nama_prodi,a.hari_kuliah,r.nama_ruangan,g.nama_gedung,if(c.tanggal is null,0, if(c.jam_selesai is null,1,2)) as status_kuliah');
		
		if($this->input->get('jenis_pertemuan')==1)
		{
			$this->db->where('(a.tipe_kuliah = "kuliah" or a.tipe_kuliah="responsi")');
		}
		if($this->input->get('selesai')==1)
		{
			$this->db->where('a.jam_selesai is not null');
		}
		if($this->input->get('jenis_pertemuan')==2)
		{  
			$this->db->where('a.tipe_kuliah','uts');
		} 
		if($this->input->get('jenis_pertemuan')==3)
		{
			$this->db->where('a.tipe_kuliah','uas');
		}
		$this->db->where('a.tanggal BETWEEN "'.$this->input->get('awal').'" and "'.$this->input->get('akhir').'"');
		
		$this->db->join($_ENV['DB_GREAT'].'kelas_kuliah b','a.id_kelas_kuliah=b.id_kelas_kuliah');
		$this->db->join($_ENV['DB_GREAT'].'mata_kuliah c','c.id_matkul=b.id_matkul');
		$this->db->join($_ENV['DB_GREAT'].'dosen d','a.input_by=d.nidn');
		$this->db->join($_ENV['DB_GREAT'].'ajar_dosen e','e.id_kelas_kuliah=a.id_kelas_kuliah and e.id_dosen=d.id_dosen');
		$this->db->join($_ENV['DB_REF'].'prodi p','p.kode_prodi=b.kode_prodi');
        $this->db->join($_ENV['DB_REF'].'fakultas f','f.kode_fak=p.kode_fak');
		$this->db->group_by(['a.id_kelas_kuliah','a.input_by']);
		$this->db->from($_ENV['DB_GREAT'].'bap_kuliah a');
		
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