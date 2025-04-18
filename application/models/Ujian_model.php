<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ujian_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function check_jawaban($id_kelas_kuliah,$jenis_ujian,$id_mahasiswa_pt)
	{
		$get_jawaban = $this->get_jawaban($id_kelas_kuliah,$jenis_ujian,$id_mahasiswa_pt)->row();
		if($get_jawaban){
			return $get_jawaban;
		}else{
			$this->simpan_jawaban($id_kelas_kuliah,$jenis_ujian,$id_mahasiswa_pt);
			return $this->get_jawaban($id_kelas_kuliah,$jenis_ujian,$id_mahasiswa_pt)->row();
		}
	}
	
	function get_jawaban($id_kelas_kuliah,$jenis_ujian,$id_mahasiswa_pt)
	{
		$this->db->where('id_kelas_kuliah',$id_kelas_kuliah);
		$this->db->where('jenis_ujian',$jenis_ujian);
		$this->db->where('id_mahasiswa_pt',$id_mahasiswa_pt);
		return $this->db->get('ujian_jawaban');
	}
	
	function simpan_jawaban($id_kelas_kuliah,$jenis_ujian,$id_mahasiswa_pt)
	{
		$this->db->set('id_kelas_kuliah',$id_kelas_kuliah);
		$this->db->set('jenis_ujian',$jenis_ujian);
		$this->db->set('id_mahasiswa_pt',$id_mahasiswa_pt);
		return $this->db->insert('ujian_jawaban');
	}
	
	function get_log($id_kelas_kuliah,$jenis_ujian,$id_mahasiswa_pt)
	{
		$this->db->where('id_kelas_kuliah',$id_kelas_kuliah);
		$this->db->where('jenis_ujian',$jenis_ujian);
		$this->db->where('id_mahasiswa_pt',$id_mahasiswa_pt);
		$this->db->order_by('update_time','desc');
		return $this->db->get('ujian_log');
	}
	
	function simpan_log($id_kelas_kuliah,$jenis_ujian,$id_mahasiswa_pt,$jenis_log)
	{
		$this->db->set('id_kelas_kuliah',$id_kelas_kuliah);
		$this->db->set('jenis_ujian',$jenis_ujian);
		$this->db->set('id_mahasiswa_pt',$id_mahasiswa_pt);
		$this->db->set('jenis_log',$jenis_log);
		return $this->db->insert('ujian_log');
	}
	
	function update_jawaban($id_kelas_kuliah,$jenis_ujian,$id_mahasiswa_pt,$field,$value)
	{
		$this->db->where('id_kelas_kuliah',$id_kelas_kuliah);
		$this->db->where('jenis_ujian',$jenis_ujian);
		$this->db->where('id_mahasiswa_pt',$id_mahasiswa_pt);
		$this->db->set($field,$value);
		return $this->db->update('ujian_jawaban');
	}
	
	function simpan_soal($id_kelas_kuliah,$jenis_ujian,$dokumen_soal)
	{
		$this->db->where('id_kelas_kuliah',$id_kelas_kuliah);
		$this->db->where('jenis_ujian',$jenis_ujian);
		$this->db->set('status_soal','0');
		$this->db->update('ujian_soal');
		
		$this->db->set('id_kelas_kuliah',$id_kelas_kuliah);
		$this->db->set('jenis_ujian',$jenis_ujian);
		$this->db->set('dokumen_soal',$dokumen_soal);
		return $this->db->insert('ujian_soal');
	}
	
	function get_soal_ujian($id_kelas_kuliah,$jenis_ujian,$status_soal=null)
	{
		if($status_soal) $this->db->where('status_soal',$status_soal);
		
		$this->db->where('id_kelas_kuliah',$id_kelas_kuliah);
		$this->db->where('jenis_ujian',$jenis_ujian);
		return $this->db->get('ujian_soal');
	}
	
	function get_status_cetak($id_smt,$jenis_ujian,$id_mahasiswa_pt)
	{
	    $this->db->where('id_smt',$id_smt);
	    $this->db->where('jenis_kartu',$jenis_ujian);
	    $this->db->where('id_mahasiswa_pt',$id_mahasiswa_pt);
	    return $this->db->get($_ENV['DB_GREAT'].'cetak_kartu');
	}
	
	function update_nilai($id_nilai,$jenis_ujian,$nilai)
	{
		if($jenis_ujian =='UTS') $this->db->set('nilai_uts',$nilai);
		if($jenis_ujian =='UAS') $this->db->set('nilai_uas',$nilai);
		$this->db->where('id_nilai',$id_nilai);
		return $this->db->update('nilai');
	}
	
	function get_nilai_ujian($id_kelas_kuliah,$jenis_ujian,$id_mahasiswa_pt)
	{
		if($jenis_ujian =='UTS') $this->db 	->select('if(a.nilai_uts is null,0,a.nilai_uts) as nilai_ujian');
		if($jenis_ujian =='UAS') $this->db 	->select('if(a.nilai_uas is null,0,a.nilai_uas) as nilai_ujian');
		$this->db 	->select('a.id_nilai')
					->from('nilai a')
					->where('a.id_mahasiswa_pt',$id_mahasiswa_pt)
					->where('a.id_kelas_kuliah',$id_kelas_kuliah);
		return $this->db->get();
	}
	
	function peserta_ujian_absen($id_kelas_kuliah,$jenis_ujian,$id_bap_kuliah)
	{
		if($jenis_ujian =='UTS') $this->db 	->select('if(a.nilai_uts is null,0,a.nilai_uts) as nilai_ujian');
		if($jenis_ujian =='UAS') $this->db 	->select('if(a.nilai_uas is null,0,a.nilai_uas) as nilai_ujian');
		$this->db 	->select('a.id_nilai,a.id_kelas_kuliah,a.id_mahasiswa_pt, if(b.id_jawaban_ujian is null,0,1) as status_ujian,if(p.id_bap_peserta_kuliah is null,0,1) as status_hadir,e.nm_pd')
					->from('nilai a')
					->join('ujian_jawaban b','a.id_mahasiswa_pt=b.id_mahasiswa_pt and b.jenis_ujian="'.$jenis_ujian.'" and a.id_kelas_kuliah=b.id_kelas_kuliah','left')
					->join('bap_peserta_kuliah p','a.id_mahasiswa_pt=p.id_mahasiswa_pt and p.id_bap_kuliah="'.$id_bap_kuliah.'"','left')
					->join('mahasiswa_pt d','a.id_mahasiswa_pt=d.id_mahasiswa_pt')
					->join('mahasiswa e','d.id_mhs=e.id_mhs')
					->where('a.id_kelas_kuliah',$id_kelas_kuliah)
					->order_by('a.id_mahasiswa_pt ASC');
		return $this->db->get();
	}
	
	function peserta_ujian($id_kelas_kuliah,$jenis_ujian)
	{
		if($jenis_ujian =='UTS') $this->db 	->select('if(a.nilai_uts is null,0,a.nilai_uts) as nilai_ujian');
		if($jenis_ujian =='UAS') $this->db 	->select('if(a.nilai_uas is null,0,a.nilai_uas) as nilai_ujian');
		$this->db 	->select('a.id_nilai,a.id_kelas_kuliah,a.id_mahasiswa_pt, if(b.id_jawaban_ujian is null,0,1) as status_ujian,e.nm_pd,km.id_stat_mhs')
					->from('nilai a')
					->join('ujian_jawaban b','a.id_mahasiswa_pt=b.id_mahasiswa_pt and b.jenis_ujian="'.$jenis_ujian.'" and a.id_kelas_kuliah=b.id_kelas_kuliah','left')
					->join('mahasiswa_pt d','a.id_mahasiswa_pt=d.id_mahasiswa_pt')
					->join('mahasiswa e','d.id_mhs=e.id_mhs')
					->join($_ENV['DB_GREAT'].'kuliah_mahasiswa km','km.id_mahasiswa_pt = a.id_mahasiswa_pt AND km.id_smt = a.id_smt')
					->where('a.id_kelas_kuliah',$id_kelas_kuliah)
					->order_by('a.id_mahasiswa_pt ASC');
		return $this->db->get();
	}
}