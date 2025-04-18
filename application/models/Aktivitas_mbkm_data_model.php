<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aktivitas_mbkm_data_model extends CI_Model {
    
    var $column_order = array('a.id_aktivitas', 'aa.id_mahasiswa_pt','ma.nm_pd','p.nama_prodi','s.nama_semester','j.nama_jenis_aktivitas_mahasiswa','a.judul','d.nm_sdm');
    var $column_search = array('aa.id_mahasiswa_pt','ma.nm_pd','s.nama_semester','j.nama_jenis_aktivitas_mahasiswa','a.judul','d.nm_sdm','a.id_aktivitas','p.nama_prodi');
    var $order = array('ma.nm_pd' => 'asc');
	
	function __construct()
	{
		parent::__construct();
	}
	
	 private function _get_datatables_query()
    {
		$this->db->select('aa.id_mahasiswa_pt, ma.nm_pd, s.nama_semester, j.nama_jenis_aktivitas_mahasiswa, a.judul, d.nm_sdm, a.id_aktivitas, p.nama_prodi, jp.nm_jenj_didik, a.id_program_mitra, nama_program, jenis_program, a.lokasi, pm.id_mitra, a.nilai_cpl');
		$this->db->from($_ENV['DB_MBKM'].'aktivitas a');
        $this->db->join($_ENV['DB_MBKM'].'anggota aa','aa.id_aktivitas = a.id_aktivitas');
        $this->db->join($_ENV['DB_MBKM'].'pembimbing pg','pg.id_aktivitas = a.id_aktivitas'.(!isset($_GET['nidn']) ? ' AND pg.pembimbing_ke = 1' : ''), 'left');
        $this->db->join($_ENV['DB_MBKM'].'program_mitra pm','pm.id_program_mitra = a.id_program_mitra');
        $this->db->join($_ENV['DB_MBKM'].'program prog','prog.id_program = pm.id_program');
        $this->db->join($_ENV['DB_GREAT'].'dosen d','d.nidn = pg.nidn', 'left');
        $this->db->join($_ENV['DB_GREAT'].'mahasiswa_pt m','m.id_mahasiswa_pt = aa.id_mahasiswa_pt');
        $this->db->join($_ENV['DB_GREAT'].'mahasiswa ma','ma.id_mhs = m.id_mhs');
		$this->db->join($_ENV['DB_REF'].'prodi p','p.kode_prodi = a.kode_prodi');
        $this->db->join($_ENV['DB_REF'].'fakultas f','p.kode_fak = f.kode_fak');
        $this->db->join($_ENV['DB_REF'].'semester s','s.id_semester = a.id_smt');
        $this->db->join($_ENV['DB_REF'].'jenis_aktivitas_mahasiswa j','j.id_jenis_aktivitas_mahasiswa = a.id_jenis_aktivitas_mahasiswa');
		$this->db->join($_ENV['DB_REF'].'jenjang_pendidikan jp','jp.id_jenj_didik = p.id_jenjang_pendidikan');
    
        if($this->input->get('kode_fak')!='0') $this->db->where('f.kode_fak',$this->input->get('kode_fak'));
        if($this->input->get('kode_prodi')!='0') $this->db->where('a.kode_prodi',$this->input->get('kode_prodi'));
        if($this->input->get('id_smt')!='0') $this->db->where('a.id_smt',$this->input->get('id_smt'));
        if($this->input->get('id_jenis_aktivitas_mahasiswa')!='0') $this->db->where('a.id_jenis_aktivitas_mahasiswa',$this->input->get('id_jenis_aktivitas_mahasiswa'));
        if($this->input->get('status')!='') $this->db->where('a.status',$this->input->get('status'));
        if($this->input->get('status_kegiatan')!='') $this->db->where('pn.status',$this->input->get('status_kegiatan'));
        if($this->input->get('status_nilai_cpl') != '') $this->db->where('a.status_nilai_cpl', ($this->input->get('status_nilai_cpl') == 'null' ? null :  $this->input->get('status_nilai_cpl')));
        if($this->input->get('id_program')) $this->db->where('pm.id_program',$this->input->get('id_program'));

        if ($_SESSION['app_level'] == 2) {
            if ($this->input->get('koordinator')) {
                $this->db->join($_ENV['DB_MBKM'].'koordinator_program kp','kp.id_program = prog.id_program');
                $this->db->where('kp.id_smt', $_SESSION['active_smt']);
                $this->db->where('kp.nidn', $_SESSION['username']);

            } else {
                $this->db->where('pg.nidn', $_SESSION['username']);
            }
        }
        

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