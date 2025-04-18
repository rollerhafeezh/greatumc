<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas_data_model extends CI_Model {
    
    var $table = 'kelas_kuliah a';
    var $column_order = array(null,'b.nm_mk', null,'a.count_peserta','a.count_pertemuan',null,null,null,null,'a.skor_persepsi');
    var $column_search = array('b.nm_mk','a.nm_kls');
    var $order = array('b.nm_mk' => 'asc','a.nm_kls'=>'asc');
	
	function __construct()
	{
		parent::__construct();
	}
	
	 private function _get_datatables_query()
    {
        if($this->input->get('kode_fak')!='0') $this->db->where('f.kode_fak',$this->input->get('kode_fak'));
		if($this->input->get('id_smt')!='0') $this->db->where('a.id_smt',$this->input->get('id_smt'));
		if($this->input->get('kode_prodi')!='0') $this->db->where('a.kode_prodi',$this->input->get('kode_prodi'));
		
		$this->db->select('	a.kuota_kelas,a.count_krs,a.id_kelas_kuliah,a.id_smt,a.nm_kls,b.nm_mk,f.inisial_fak,p.nama_prodi,a.sks_mk,a.kode_prodi,a.count_pertemuan,a.count_peserta,a.skor_persepsi,
							r.nama_ruangan as nama_ruangan,g.nama_gedung as nama_gedung,a.hari_kuliah,a.jam_mulai,a.jam_selesai,
							ruas.nama_ruangan as nama_ruangan_uas,guas.nama_gedung as nama_gedung_uas,a.tgl_uas,a.jam_mulai_uas,a.jam_selesai_uas,
							ruts.nama_ruangan as nama_ruangan_uts,g.nama_gedung as nama_gedung_uts,a.tgl_uts,a.jam_mulai_uts,a.jam_selesai_uts
		');
		$this->db->join($_ENV['DB_GREAT'].'mata_kuliah b','a.id_matkul=b.id_matkul','left');
		$this->db->join($_ENV['DB_REF'].'ruangan r','r.id_ruangan=a.id_ruangan');
		$this->db->join($_ENV['DB_REF'].'ruangan ruas','ruas.id_ruangan=a.id_ruangan_uas','left');
		$this->db->join($_ENV['DB_REF'].'ruangan ruts','ruts.id_ruangan=a.id_ruangan_uts','left');
		$this->db->join($_ENV['DB_REF'].'gedung guas','ruas.id_gedung=guas.id_gedung','left');
		$this->db->join($_ENV['DB_REF'].'gedung guts','ruts.id_gedung=guts.id_gedung','left');
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