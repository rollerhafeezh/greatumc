<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aktivitas_data_model extends CI_Model {
    
    var $column_order = array('a.id_aktivitas', 'aa.id_mahasiswa_pt','ma.nm_pd','p.nama_prodi','s.nama_semester','j.nama_jenis_aktivitas_mahasiswa','a.judul','d.nm_sdm','a.status');
    var $column_search = array('aa.id_mahasiswa_pt','ma.nm_pd','s.nama_semester','j.nama_jenis_aktivitas_mahasiswa','a.judul','d.nm_sdm','a.status','a.id_aktivitas','p.nama_prodi');
    var $order = array('ma.nm_pd' => 'asc');
	
	function __construct()
	{
		parent::__construct();
	}
	
	 private function _get_datatables_query()
    {
		$this->db->select('aa.id_mahasiswa_pt, ma.nm_pd, s.nama_semester, j.id_jenis_aktivitas_mahasiswa, j.nama_jenis_aktivitas_mahasiswa, a.judul, a.status, a.id_aktivitas, p.nama_prodi, jp.nm_jenj_didik');
		$this->db->from($_ENV['DB_AKT'].'aktivitas a');
        $this->db->join($_ENV['DB_AKT'].'anggota aa','aa.id_aktivitas = a.id_aktivitas');
        $this->db->join($_ENV['DB_GREAT'].'mahasiswa_pt m','m.id_mahasiswa_pt = aa.id_mahasiswa_pt');
        $this->db->join($_ENV['DB_GREAT'].'mahasiswa ma','ma.id_mhs = m.id_mhs');

    	$this->db->join($_ENV['DB_AKT'].'pembimbing pg','pg.id_aktivitas = a.id_aktivitas'.(!isset($_GET['nidn']) ? ' AND pg.pembimbing_ke = 1' : ''), 'left');
    	$this->db->join($_ENV['DB_GREAT'].'dosen d','d.nidn = pg.nidn', 'left');

		$this->db->join($_ENV['DB_REF'].'prodi p','p.kode_prodi = a.kode_prodi');
        $this->db->join($_ENV['DB_REF'].'fakultas f','p.kode_fak = f.kode_fak');
        $this->db->join($_ENV['DB_REF'].'semester s','s.id_semester = a.id_smt');
        $this->db->join($_ENV['DB_REF'].'jenis_aktivitas_mahasiswa j','j.id_jenis_aktivitas_mahasiswa = a.id_jenis_aktivitas_mahasiswa');
		$this->db->join($_ENV['DB_REF'].'jenjang_pendidikan jp','jp.id_jenj_didik = p.id_jenjang_pendidikan');
    
        if (isset($_GET['nidn']) AND $_GET['jenis_bimbingan']) {
            if ($_GET['jenis_bimbingan'] == 1) { // dosen pembimbing
            	// $this->db->select('d.nm_sdm');
                $this->db->where('pg.nidn', $this->input->get('nidn'));
            }

            if ($_GET['jenis_bimbingan'] == 2) {
                $this->db->select('pn.tanggal, pn.id_kegiatan, k.nama_kegiatan, k.deskripsi, pn.status as status_kegiatan');
                $this->db->join($_ENV['DB_AKT'].'penguji pi','pi.id_aktivitas = a.id_aktivitas');
                $this->db->join($_ENV['DB_AKT'].'penjadwalan pn','pn.id_aktivitas = pi.id_aktivitas AND pn.id_kegiatan = pi.id_kegiatan');
                $this->db->join($_ENV['DB_AKT'].'kegiatan k','k.id_kegiatan = pn.id_kegiatan');
                // $this->db->join($_ENV['DB_AKT'].'kegiatan_anggota ka','ka.id_kegiatan = pi.id_kegiatan AND ka.id_anggota = aa.id_anggota', 'left');
                $this->db->where('pi.nidn', $this->input->get('nidn'));
                $this->db->group_by('pi.id_aktivitas, pi.id_kegiatan');
            }

            if ($_GET['jenis_bimbingan'] == 3) {
                $this->db->select('pn.tanggal, pn.id_kegiatan, k.nama_kegiatan, k.deskripsi, pn.status as status_kegiatan');
                // $this->db->join($_ENV['DB_AKT'].'penguji pi','pi.id_aktivitas = a.id_aktivitas');
                $this->db->join($_ENV['DB_AKT'].'penjadwalan pn','pn.id_aktivitas = a.id_aktivitas');
                $this->db->join($_ENV['DB_AKT'].'kegiatan k','k.id_kegiatan = pn.id_kegiatan');
                // $this->db->join($_ENV['DB_AKT'].'kegiatan_anggota ka','ka.id_kegiatan = pn.id_kegiatan AND ka.id_anggota = aa.id_anggota', 'left');
                $this->db->where('pn.nidn', $this->input->get('nidn'));
                $this->db->group_by('pn.id_aktivitas, pn.id_kegiatan');
            }
            // $this->db->join($_ENV['DB_AKT'].'penjadwalan pn','pn.id_aktivitas = a.id_aktivitas', 'left');
            // $this->db->join($_ENV['DB_AKT'].'kegiatan k','k.id_kegiatan = pn.id_kegiatan', 'left');
        
        } else {
	        // $this->db->join($_ENV['DB_AKT'].'pembimbing pg','pg.id_aktivitas = a.id_aktivitas'.(!isset($_GET['nidn']) ? ' AND pg.pembimbing_ke = 1' : ''), 'left');
	        // $this->db->join($_ENV['DB_GREAT'].'dosen d','d.nidn = pg.nidn', 'left');

        	$this->db->select('d.nm_sdm, d2.nm_sdm as nm_sdm_2');
	        $this->db->join($_ENV['DB_AKT'].'pembimbing pg2','pg2.id_aktivitas = a.id_aktivitas'.(!isset($_GET['nidn']) ? ' AND pg.pembimbing_ke = 2' : ''), 'left');
	        $this->db->join($_ENV['DB_GREAT'].'dosen d2','d2.nidn = pg2.nidn', 'left');
        }

        if($this->input->get('kode_fak')!='0') $this->db->where('f.kode_fak',$this->input->get('kode_fak'));
        if($this->input->get('kode_prodi')!='0') $this->db->where('a.kode_prodi',$this->input->get('kode_prodi'));
        if($this->input->get('id_smt')!='0') $this->db->where('a.id_smt',$this->input->get('id_smt'));
        if($this->input->get('id_jenis_aktivitas_mahasiswa')!='0') $this->db->where('a.id_jenis_aktivitas_mahasiswa',$this->input->get('id_jenis_aktivitas_mahasiswa'));
        if($this->input->get('status')!='') $this->db->where('a.status',$this->input->get('status'));
        if($this->input->get('status_kegiatan')!='') $this->db->where('pn.status',$this->input->get('status_kegiatan'));
        

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