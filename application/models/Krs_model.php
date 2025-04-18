<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Krs_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_riwayat_ajar($id_mahasiswa_pt=null,$id_smt=null)
	{
		if($id_mahasiswa_pt)
		{
			$this->db->where('a.id_mahasiswa_pt',$id_mahasiswa_pt);
		}
		if($id_smt)
		{
			$this->db->where('a.id_smt',$id_smt);
		}
		$this->db->select('d.nama_status_mahasiswa,a.id_smt,a.id_mahasiswa_pt,a.id_stat_mhs');
		//$this->db->join('krs_note b','a.id_mahasiswa_pt=b.id_mahasiswa_pt','left');
		$this->db->join($_ENV['DB_REF'].'status_mahasiswa d','a.id_stat_mhs=d.id_status_mahasiswa');
		$this->db->order_by('a.id_smt','asc');
		return $this->db->get('kuliah_mahasiswa a');
	}
	
	function update_kuliah_mahasiswa_value($id_mahasiswa_pt,$id_smt,$field,$value)
	{
		$this->db->set($field,$value);
		$this->db->where('id_mahasiswa_pt',$id_mahasiswa_pt);
		$this->db->where('id_smt',$id_smt);
		$this->db->update('kuliah_mahasiswa');
	}
	
	function update_kuliah_mahasiswa($id_mahasiswa_pt,$id_smt,$id_stat_mhs=null)
	{
		$this->db->select('id_stat_mhs');
		$this->db->where('id_mahasiswa_pt',$id_mahasiswa_pt);
		$this->db->where('id_smt',$id_smt);
		$query = $this->db->get('kuliah_mahasiswa')->row();
		
		if($query->id_stat_mhs=='N')
		{
			$this->db->set('id_stat_mhs', ($id_stat_mhs ?: 'A'));
			$this->db->where('id_mahasiswa_pt',$id_mahasiswa_pt);
			$this->db->where('id_smt',$id_smt);
			$this->db->update('kuliah_mahasiswa');
		}
	}
	
	function simpan_kelas_kuliah($id_mahasiswa_pt,$id_smt)
	{
		$this->db->where('id_mahasiswa_pt',$id_mahasiswa_pt);
		$this->db->where('id_smt',$id_smt);
		$query = $this->db->get('krs')->result();
		
		foreach($query as $key=>$value)
		{
			if($value->status_krs==1)
			{
				$this->simpan_kelas($id_smt,$value->id_krs,$value->id_kelas_kuliah,$value->id_matkul,$id_mahasiswa_pt);
				$this->update_krs($value->id_krs,2);
			}
		}
		return $query;
	}
	
	function simpan_kelas($id_smt,$id_krs,$id_kelas_kuliah,$id_matkul,$id_mahasiswa_pt)
	{
		$sql = "INSERT IGNORE INTO `nilai`(`id_smt`,`id_krs`,`id_kelas_kuliah`,`id_matkul`,`id_mahasiswa_pt`) VALUES(?,?,?,?,?)";
		$this->db->query($sql,array($id_smt,$id_krs,$id_kelas_kuliah,$id_matkul,$id_mahasiswa_pt));
	}
	
	function simpan_perwalian($id_mahasiswa_pt,$id_smt)
	{
		$this->db->where('id_mahasiswa_pt',$id_mahasiswa_pt);
		$this->db->where('id_smt',$id_smt);
		$this->db->set('validasi',$_SESSION['nama_pengguna']);
		$this->db->set('tgl_validasi',date("Y-m-d H:i:s"));
		return $this->db->update('krs_note');
	}
	
	function validasi_krs($id_mahasiswa_pt,$id_smt,$siapa)
	{
		$this->db->where('id_mahasiswa_pt',$id_mahasiswa_pt);
		$this->db->where('id_smt',$id_smt);
		$this->db->set('validasi_'.$siapa,$_SESSION['nama_pengguna']);
		$this->db->set('tgl_validasi_'.$siapa,date("Y-m-d H:i:s"));
		return $this->db->update('krs_note');
	}
	
	function validasi_krs_keuangan($id_mahasiswa_pt,$id_smt)
	{
		$this->db->where('id_mahasiswa_pt',$id_mahasiswa_pt);
		$this->db->where('id_smt',$id_smt);
		$this->db->set('validasi_keu','CICIH NURASIH');
		$this->db->set('tgl_validasi_keu',date("Y-m-d H:i:s"));
		return $this->db->update('krs_note');
	}
	
	function isi_catatan($data)
	{
		$this->db->where('id_mahasiswa_pt',$data['id_mahasiswa_pt']);
		$this->db->where('id_smt',$data['id_smt']);
		$this->db->set('isi_catatan',$data['isi_catatan']);
		return $this->db->update('krs_note');
	}
	
	function update_krs($id_krs,$status_krs)
	{
		$this->db->where('id_krs',$id_krs);
		$this->db->set('status_krs',$status_krs);
		return $this->db->update('krs');
	}
	
	function list_kelas_krs($id_mahasiswa_pt, $id_smt=null, $id_program_mitra=null)
	{
		$this->db->select('a.*,b.nm_mk,b.kode_mk,b.id_kat_mk,b.kode_prodi,c.nm_kls,c.hari_kuliah,c.jam_mulai,c.jam_selesai,b.sks_mk,r.nama_ruangan,g.nama_gedung');
		if($id_smt)
		{
			$this->db->where('a.id_smt',$id_smt);
		}
		$this->db->where('a.id_mahasiswa_pt',$id_mahasiswa_pt);
		$this->db->join('mata_kuliah b', 'a.id_matkul=b.id_matkul');
		$this->db->join('kelas_kuliah c', 'c.id_kelas_kuliah=a.id_kelas_kuliah');
		$this->db->join($_ENV['DB_REF'].'ruangan r','r.id_ruangan=c.id_ruangan');
		$this->db->join($_ENV['DB_REF'].'gedung g','r.id_gedung=g.id_gedung');
		
		if ($id_program_mitra) {
			$this->db->select('mpm.id_program_mitra');
			$this->db->join($_ENV['DB_MBKM'].'matkul_program_mitra mpm','mpm.id_matkul = a.id_matkul AND mpm.id_program_mitra = '.xss_clean($id_program_mitra), 'left');
			// $this->db->where('mpm.id_program_mitra', $id_program_mitra);
		}
		
		$this->db->order_by('c.hari_kuliah asc');
		$this->db->order_by('c.jam_mulai asc');
		return $this->db->get('krs a');
	}
	
	function list_kelas_ujian($id_mahasiswa_pt,$id_smt=null, $jenis=null)
	{
		if($id_smt)
		{
			$this->db->where('a.id_smt',$id_smt);
		}
		if($jenis=='uts'){
		    $this->db->select('a.*,b.nm_mk,b.id_kat_mk,b.kode_mk,b.kode_prodi,c.nm_kls,c.tgl_uts as tgl,c.jam_mulai_uts as jam_mulai,c.jam_selesai_uts as jam_selesai,b.sks_mk,r.nama_ruangan,g.nama_gedung');
		}
		if($jenis=='uas'){
		    $this->db->select('a.*,b.nm_mk,b.kode_mk,b.id_kat_mk,b.kode_prodi,c.nm_kls,c.tgl_uas as tgl,c.jam_mulai_uas as jam_mulai,c.jam_selesai_uas as jam_selesai,b.sks_mk,r.nama_ruangan,g.nama_gedung');
		}
		$this->db->where('a.id_mahasiswa_pt',$id_mahasiswa_pt);
		$this->db->join('mata_kuliah b', 'a.id_matkul=b.id_matkul');
		$this->db->join('kelas_kuliah c', 'c.id_kelas_kuliah=a.id_kelas_kuliah');
		if($jenis=='uts'){
		    $this->db->join($_ENV['DB_REF'].'ruangan r','r.id_ruangan=c.id_ruangan_uts','left');
		}
		if($jenis=='uas'){
		    $this->db->join($_ENV['DB_REF'].'ruangan r','r.id_ruangan=c.id_ruangan_uas','left');
		}
		$this->db->join($_ENV['DB_REF'].'gedung g','r.id_gedung=g.id_gedung','left');
		$this->db->order_by('c.hari_kuliah asc');
		$this->db->order_by('c.jam_mulai asc');
		return $this->db->get('nilai a');
	}
	
	function list_kelas_kuliah($id_mahasiswa_pt,$id_smt=null, $id_kat_mk=null)
	{
		$this->db->select('a.*,b.nm_mk,b.kode_mk,b.id_kat_mk,b.kode_prodi,c.nm_kls,c.hari_kuliah,c.jam_mulai,c.jam_selesai,b.sks_mk,r.nama_ruangan,g.nama_gedung');
		if ($id_kat_mk) $this->db->where('b.id_kat_mk', $id_kat_mk);
		if($id_smt)
		{
			$this->db->where('a.id_smt',$id_smt);
		}
		$this->db->where('a.id_mahasiswa_pt',$id_mahasiswa_pt);
		$this->db->join('mata_kuliah b', 'a.id_matkul=b.id_matkul');
		$this->db->join('kelas_kuliah c', 'c.id_kelas_kuliah=a.id_kelas_kuliah');
		$this->db->join($_ENV['DB_REF'].'ruangan r','r.id_ruangan=c.id_ruangan');
		$this->db->join($_ENV['DB_REF'].'gedung g','r.id_gedung=g.id_gedung');
		$this->db->order_by('c.hari_kuliah asc');
		$this->db->order_by('c.jam_mulai asc');
		return $this->db->get('nilai a');
	}
	
	function hapus_krs($id_krs)
	{
		$this->db->where('id_krs',$id_krs);
		return $this->db->delete('krs');
	}
	
	function get_krs_note($id_mahasiswa_pt,$id_smt)
	{
		$this->db->where('id_mahasiswa_pt',$id_mahasiswa_pt);
		$this->db->where('id_smt',$id_smt);
		return $this->db->get('krs_note');
	}
	
	function cek_krs($id_krs)
	{
		$this->db->where('id_krs',$id_krs);
		return $this->db->get('krs');
	}
	
	function simpan_krs($data)
	{
		return $this->db->insert('krs',$data);
	}
	
	function tarik_ajuan_krs($data)
	{
		$this->db->where('id_mahasiswa_pt',$data['id_mahasiswa_pt']);
		$this->db->where('id_smt',$data['id_smt']);
		$this->db->delete('krs_note');
		
		$this->db->where('id_mahasiswa_pt',$data['id_mahasiswa_pt']);
		$this->db->where('id_smt',$data['id_smt']);
		$this->db->delete('nilai');
		
		$this->db->where('id_mahasiswa_pt',$data['id_mahasiswa_pt']);
		$this->db->where('id_smt',$data['id_smt']);
		$this->db->set('status_krs',0);
		return $this->db->update('krs');
	}
	
	function ajukan_krs($data)
	{
		return $this->db->insert('krs_note',$data);
	}
	
	function sudah_kontrak($id_matkul,$id_mahasiswa_pt,$id_smt)
	{
		$this->db->where('id_mahasiswa_pt',$id_mahasiswa_pt);
		$this->db->where('id_matkul',$id_matkul);
		$this->db->where('id_smt',$id_smt);
		$query=$this->db->get('krs');
		if($query->num_rows()==0) return true; else return false;
	}
	
	function kelas_prodi($id_kelas_kuliah,$kode_prodi,$id_smt)
	{
		$this->db->where('kode_prodi',$kode_prodi);
		$this->db->where('id_kelas_kuliah',$id_kelas_kuliah);
		$this->db->where('id_smt',$id_smt);
		return $this->db->get('kelas_kuliah');
	}
	
	function matkul_prodi($id_matkul,$kode_prodi,$id_smt)
	{
		$smt=str_split($id_smt);
		if($smt[4]==1){
			$this->db->where('mod (a.smt , 2 ) != 0');
		}else if($smt[4]==2){
			$this->db->where('mod (a.smt , 2 ) == 0');
		}
		$this->db->where('b.kode_prodi',$kode_prodi);
		$this->db->where('b.id_matkul',$id_matkul);
		$this->db->join('mata_kuliah b','a.id_matkul=b.id_matkul');
		return $this->db->get('mata_kuliah_kurikulum a');
	}
	
	function matkul_krs_add_two($id_matkul,$kode_prodi,$id_smt)
	{
		$this->db->where('b.kode_prodi',$kode_prodi);
		$this->db->where('b.id_matkul',$id_matkul);
		$this->db->join('mata_kuliah b','a.id_matkul=b.id_matkul');
		return $this->db->get('mata_kuliah_kurikulum a');
	}
	
	function kelas_kuliah_simple($id_matkul=null,$id_smt=null,$id_kelas_kuliah=null)
	{
		if($id_matkul){
			$this->db->where('b.id_matkul',$id_matkul);
		}
		
		if($id_kelas_kuliah){
			$this->db->where('a.id_kelas_kuliah',$id_kelas_kuliah);
		}
		
		if($id_smt)
		{
			$this->db->where('a.id_smt',$id_smt);	
		}
		
 		$this->db->select('	a.id_matkul,a.kuota_kelas,a.count_krs,a.id_kelas_kuliah,a.id_smt,a.nm_kls,b.nm_mk,f.nama_fak,p.nama_prodi,a.sks_mk,a.kode_prodi,a.count_pertemuan,a.count_peserta,a.skor_persepsi,
							a.id_ruangan,r.nama_ruangan as nama_ruangan,g.nama_gedung as nama_gedung,a.hari_kuliah,a.jam_mulai,a.jam_selesai,
		');
        $this->db->join($_ENV['DB_GREAT'].'mata_kuliah b','a.id_matkul=b.id_matkul');
		$this->db->join($_ENV['DB_REF'].'ruangan r','r.id_ruangan=a.id_ruangan');
		$this->db->join($_ENV['DB_REF'].'gedung g','r.id_gedung=g.id_gedung');
        $this->db->join($_ENV['DB_REF'].'prodi p','p.kode_prodi=a.kode_prodi');
        $this->db->join($_ENV['DB_REF'].'fakultas f','f.kode_fak=p.kode_fak');
		$this->db->order_by('b.nm_mk ASC');
		$this->db->order_by('a.nm_kls ASC');
        return $this->db->get($_ENV['DB_GREAT'].'kelas_kuliah a');
	}
	
	function kelas_kuliah_mahasiswa_krs($id_matkul=null,$id_smt=null,$id_kelas_kuliah=null)
 	{
		if($id_matkul){
			$this->db->where('b.id_matkul',$id_matkul);
		}
		
		if($id_kelas_kuliah){
			$this->db->where('a.id_kelas_kuliah',$id_kelas_kuliah);
		}
		
		if($id_smt)
		{
			$this->db->where('a.id_smt',$id_smt);	
		}
		
 		$this->db->select('	c.*,a.id_matkul,a.kuota_kelas,a.count_krs,a.id_kelas_kuliah,a.id_smt,a.nm_kls,b.nm_mk,b.id_kat_mk,f.nama_fak,p.nama_prodi,a.sks_mk,a.kode_prodi,a.count_pertemuan,a.count_peserta,a.skor_persepsi,a.id_instrumen,
							r.id_ruangan as id_ruangan,r.nama_ruangan as nama_ruangan,g.nama_gedung as nama_gedung,a.hari_kuliah,a.jam_mulai,a.jam_selesai,
							ruas.id_ruangan as id_ruangan_uas,ruas.nama_ruangan as nama_ruangan_uas,guas.nama_gedung as nama_gedung_uas,a.tgl_uas,a.jam_mulai_uas,a.jam_selesai_uas,
							ruts.id_ruangan as id_ruangan_uts,ruts.nama_ruangan as nama_ruangan_uts,guts.nama_gedung as nama_gedung_uts,a.tgl_uts,a.jam_mulai_uts,a.jam_selesai_uts
		');
        $this->db->join($_ENV['DB_GREAT'].'mata_kuliah b','a.id_matkul=b.id_matkul','left');
		$this->db->join($_ENV['DB_REF'].'ruangan r','r.id_ruangan=a.id_ruangan','left');
		$this->db->join($_ENV['DB_REF'].'ruangan ruas','ruas.id_ruangan=a.id_ruangan_uas','left');
		$this->db->join($_ENV['DB_REF'].'ruangan ruts','ruts.id_ruangan=a.id_ruangan_uts','left');
		$this->db->join($_ENV['DB_REF'].'gedung guas','ruas.id_gedung=guas.id_gedung','left');
		$this->db->join($_ENV['DB_REF'].'gedung guts','ruts.id_gedung=guts.id_gedung','left');
		$this->db->join($_ENV['DB_REF'].'gedung g','r.id_gedung=g.id_gedung','left');
        $this->db->join($_ENV['DB_REF'].'prodi p','p.kode_prodi=a.kode_prodi');
        $this->db->join($_ENV['DB_REF'].'fakultas f','f.kode_fak=p.kode_fak');
        $this->db->join($_ENV['DB_GREAT'].'persentase_nilai c','c.id_kelas_kuliah=a.id_kelas_kuliah');
		$this->db->order_by('b.nm_mk ASC');
		$this->db->order_by('a.nm_kls ASC');
        return $this->db->get($_ENV['DB_GREAT'].'kelas_kuliah a');
	}
}