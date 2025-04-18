<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mbkm_data_model extends CI_Model {
    
    var $column_order = array('nama_jenis_aktivitas_mahasiswa', 'nama_prodi', 'nama_resmi', 'm.alamat', 'pm.tgl_mulai', 'pm.tgl_selesai');
    var $column_search = array('nama_jenis_aktivitas_mahasiswa', 'nama_prodi', 'nama_resmi', 'm.alamat', 'pm.keterangan', 'pm.tgl_mulai', 'pm.tgl_selesai', 'nama_program', 'jenis_program');
    var $order = array('pm.created_at' => 'desc');
	
	function __construct()
	{
		parent::__construct();
	}
	
	private function _get_datatables_query()
    {
		$this->db->select('pm.*, pg.nama_program, m.nama_merek, m.id_mitra, nama_jenis_aktivitas_mahasiswa, nama_prodi, nama_resmi, m.alamat,  nama_semester, m.tautan');

		$this->db->from($_ENV['DB_MBKM'].'program_mitra pm');
        $this->db->join($_ENV['DB_MBKM'].'program pg','pg.id_program = pm.id_program');
        $this->db->join($_ENV['DB_MBKM'].'mitra m','m.id_mitra = pm.id_mitra');
        $this->db->join($_ENV['DB_REF'].'prodi p','p.kode_prodi = pm.kode_prodi');
        $this->db->join($_ENV['DB_REF'].'semester s','s.id_semester = pm.id_smt');

        $this->db->join($_ENV['DB_REF'].'fakultas f','f.kode_fak = p.kode_fak');
		$this->db->join($_ENV['DB_REF'].'jenjang_pendidikan jp','jp.id_jenj_didik = p.id_jenjang_pendidikan');
        $this->db->join($_ENV['DB_REF'].'jenis_aktivitas_mahasiswa j','j.id_jenis_aktivitas_mahasiswa = pg.id_jenis_aktivitas_mahasiswa');

        if($this->input->get('kode_fak')!='0') $this->db->where('f.kode_fak',$this->input->get('kode_fak'));
        if($this->input->get('kode_prodi')!='0') $this->db->where('pm.kode_prodi',$this->input->get('kode_prodi'));
        if($this->input->get('id_smt')!='0') $this->db->where('pm.id_smt',$this->input->get('id_smt'));
        if($this->input->get('id_jenis_aktivitas_mahasiswa')!='0') $this->db->where('j.id_jenis_aktivitas_mahasiswa',$this->input->get('id_jenis_aktivitas_mahasiswa'));
        if($this->input->get('status')) $this->db->where('pm.status',$this->input->get('status'));
        if($this->input->get('aktif') != '') $this->db->where('pm.aktif',$this->input->get('aktif'));
        if($this->input->get('jenis_program') != '') $this->db->where('pm.jenis_program',$this->input->get('jenis_program'));
        if($this->input->get('id_program') != '0') $this->db->where('pm.id_program',$this->input->get('id_program'));
        if($this->input->get('pendaftaran') != '') $this->db->where("'".date('Y-m-d').'\' BETWEEN tgl_mulai_daftar AND tgl_selesai_daftar');

        if ($_SESSION['app_level'] == 1) { // mahasiswa
            $this->db->where('pm.aktif', '1');
            $this->db->where('pm.status', '1');
        	$this->db->select('pn.id_aktivitas, pn.id_pendaftaran, pn.status as status_pendaftaran, pn.id_mahasiswa_pt');
            
            if($this->input->get('id_mahasiswa_pt')) { // program saya
                $this->db->join($_ENV['DB_MBKM'].'pendaftaran pn', 'pn.id_program_mitra = pm.id_program_mitra');
                $this->db->where('pn.id_mahasiswa_pt', $_SESSION['id_user']);
            
            } else { // cari program
                $this->db->join($_ENV['DB_MBKM'].'pendaftaran pn', 'pn.id_program_mitra = pm.id_program_mitra AND pn.id_mahasiswa_pt = '.$_SESSION['id_user'], 'left');
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