<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function proses_mutasi($mahasiswa_pt)
	{
	    $this->db->where('id_mahasiswa_pt',$mahasiswa_pt->id_mahasiswa_pt_lama);
	    $this->db->set('npm_aktif','0');
	    $this->db->set('tgl_keluar',$mahasiswa_pt->tgl_keluar);
	    $this->db->set('ket',$mahasiswa_pt->ket_keluar);
	    $this->db->set('id_jns_keluar','2');
	    $this->db->set('sync_to_feeder','N');
	    $this->db->update('mahasiswa_pt');
	    
	    $this->db->set('id_mhs',$mahasiswa_pt->id_mhs);
	    $this->db->set('id_mahasiswa_pt',$mahasiswa_pt->id_mahasiswa_pt_baru);
	    $this->db->set('nipd',$mahasiswa_pt->id_mahasiswa_pt_baru);
	    $this->db->set('tgl_masuk_sp',$mahasiswa_pt->tgl_masuk_sp);
	    $this->db->set('id_jns_daftar','2');
	    $this->db->set('kode_prodi',$mahasiswa_pt->kode_prodi);
	    $this->db->set('npm_aktif','1');
	    $this->db->set('id_jalur_masuk','6');
	    $this->db->set('mulai_smt',$mahasiswa_pt->mulai_smt);
	    $this->db->set('kelas_mhs',$mahasiswa_pt->kelas_mhs);
	    $this->db->set('diterima_smt',$mahasiswa_pt->diterima_smt);
	    $this->db->insert('mahasiswa_pt');
	    
	    $this->db->where('id_mutasi',$mahasiswa_pt->id_mutasi);
		$this->db->set('status_mutasi','4');
		return $this->db->update('mahasiswa_mutasi');
	}
	
	function update_mutasi($id_mutasi,$isi,$komponen)
	{
	    $this->db->where('id_mutasi',$id_mutasi);
		$this->db->set($komponen,$isi);
		return $this->db->update('mahasiswa_mutasi');
	}
	
	function mutasi_detail($id_mutasi)
	{
	    $this->db->join($_ENV['DB_REF'].'prodi p','a.kode_prodi=p.kode_prodi');
	    $this->db->join($_ENV['DB_REF'].'jenjang_pendidikan jp','jp.id_jenj_didik=p.id_jenjang_pendidikan');
	    $this->db->join('mahasiswa b','a.id_mhs=b.id_mhs');
	    $this->db->where('a.id_mutasi',$id_mutasi);
	    return $this->db->get('mahasiswa_mutasi a');
	}
	
	function mutasi_proses($mahasiswa_pt)
	{
	    $this->db->set('id_mhs',$mahasiswa_pt->id_mhs);
	    $this->db->set('id_mahasiswa_pt_lama',$mahasiswa_pt->id_mahasiswa_pt);
	    $this->db->insert('mahasiswa_mutasi');
	    return $this->db->insert_id();
	}
	
	function proses_dosen_wali($id_mahasiswa_pt,$id_dosen)
	{
		$this->db->where('id_mahasiswa_pt',$id_mahasiswa_pt);
		$this->db->set('id_dosen',$id_dosen);
		return $this->db->update('mahasiswa_pt');
	}
	
	function get_kuliah_mahasiswa($id_mahasiswa_pt,$id_smt)
	{
	    return $this->db->get_where('kuliah_mahasiswa',array('id_mahasiswa_pt'=>$id_mahasiswa_pt,'id_smt'=>$id_smt))->row();
	}
	
	function get_dokumen($id_mhs,$jenis)
	{
	    return $this->db->get_where('mahasiswa_file',array('id_mhs'=>$id_mhs,'jenis'=>$jenis))->row();
	}
	
	function unggah_dokumen($id_mhs,$jenis,$file_mahasiswa)
	{
	    $sql = $this->db->get_where('mahasiswa_file',array('id_mhs'=>$id_mhs,'jenis'=>$jenis))->row();
	    if($sql)
	    {
	        $this->db->where('id_mhs',$id_mhs);
	        $this->db->where('jenis',$jenis);
		    $this->db->set('file_mahasiswa',$file_mahasiswa);
		    return $this->db->update('mahasiswa_file');
	    }else{
	        $this->db->set('id_mhs',$id_mhs);
	        $this->db->set('jenis',$jenis);
		    $this->db->set('file_mahasiswa',$file_mahasiswa);
		    return $this->db->insert('mahasiswa_file');
	    }
	}
	
    function get_dokumen_pmb($id_mhs)
	{
	    //return true;
	    return $this->db->get_where($_ENV['DB_PMB'].'file_calon_mhs',array('id_daftar'=>$id_mhs))->result();
	}
}