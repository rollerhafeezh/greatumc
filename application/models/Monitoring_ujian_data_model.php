<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring_ujian_data_model extends CI_Model {
    
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
		
		if($this->input->get('jenis')=='uts'){
		    if($this->input->get('id_gedung')!='0') $this->db->where('g.id_gedung',$this->input->get('id_gedung'));
		    if($this->input->get('id_ruangan')!='0') $this->db->where('a.id_ruangan_uts',$this->input->get('id_ruangan'));
			$this->db->where('a.tgl_uts',$this->input->get('tanggal'));
			$this->db->select('a.jam_mulai_uts as jam_mulai,a.jam_selesai_uts as jam_selesai, a.tgl_uts as tgl_ujian,r.nama_ruangan,g.nama_gedung,u.dokumen_soal');
			$this->db->join($_ENV['DB_REF'].'ruangan r','r.id_ruangan=a.id_ruangan_uts');
			$this->db->join($_ENV['DB_REF'].'gedung g','r.id_gedung=g.id_gedung');
			$this->db->join('ujian_soal u','a.id_kelas_kuliah=u.id_kelas_kuliah and u.jenis_ujian="UTS" and u.status_soal=1','left');
		}
		if($this->input->get('jenis')=='uas'){
		    if($this->input->get('id_gedung')!='0') $this->db->where('g.id_gedung',$this->input->get('id_gedung'));
			if($this->input->get('id_ruangan')!='0') $this->db->where('a.id_ruangan_uas',$this->input->get('id_ruangan'));
			$this->db->where('a.tgl_uas',$this->input->get('tanggal'));
			$this->db->select('a.jam_mulai_uas as jam_mulai,a.jam_selesai_uas as jam_selesai, a.tgl_uas as tgl_ujian,r.nama_ruangan,g.nama_gedung,u.dokumen_soal');
			$this->db->join($_ENV['DB_REF'].'ruangan r','r.id_ruangan=a.id_ruangan_uas');
			$this->db->join($_ENV['DB_REF'].'gedung g','r.id_gedung=g.id_gedung');
			$this->db->join('ujian_soal u','a.id_kelas_kuliah=u.id_kelas_kuliah and u.jenis_ujian="UAS" and u.status_soal=1','left');
		}
		$this->db->select('a.id_kelas_kuliah,a.nm_kls,b.nm_mk,f.inisial_fak,p.nama_prodi,a.hari_kuliah,if(c.tanggal is null,0, if(c.jam_selesai is null,1,2)) as status_kuliah, concat("'.$this->input->get('jenis').'") as jenis');
		$this->db->join($_ENV['DB_GREAT'].'bap_kuliah c','a.id_kelas_kuliah=c.id_kelas_kuliah and c.tanggal="'.$this->input->get('tanggal').'" and c.tipe_kuliah="'.$this->input->get('jenis').'"','left');
		$this->db->join($_ENV['DB_GREAT'].'mata_kuliah b','a.id_matkul=b.id_matkul');
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