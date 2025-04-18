<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dhmd_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function check_rps_pertemuan($id_matkul,$id_rps,$minggu_ke)
	{
		$this->db->where('id_matkul',$id_matkul);
		$this->db->where('id_rps',$id_rps);
		$this->db->where('minggu_ke',$minggu_ke);
		$check = $this->db->get('rps_pertemuan');
		if($check->row())
		{
			return $check;
		}else{
			$this->db->set('id_matkul',$id_matkul);
			$this->db->set('id_rps',$id_rps);
			$this->db->set('minggu_ke',$minggu_ke);
			$this->db->insert('rps_pertemuan');
			
			$this->db->where('id_matkul',$id_matkul);
			$this->db->where('id_rps',$id_rps);
			$this->db->where('minggu_ke',$minggu_ke);
			return $this->db->get('rps_pertemuan');
		}
	}
	
	function buat_rps($id_matkul)
	{
		$this->db->set('id_matkul',$id_matkul);
		$this->db->insert('rps');
		return $this->db->insert_id();
	}
	
	function aktif_rps($id_matkul,$id_rps)
	{
		$this->db->where('id_matkul',$id_matkul);
		$this->db->set('status','0');
		$this->db->update('rps');
		
		$this->db->where('id_rps',$id_rps);
		$this->db->set('status','1');
		return $this->db->update('rps');
	}
	
	function update_rps($data)
	{
		$this->db->where('id_rps',$data['id_rps']);
		$this->db->set('cp_prodi',$data['cp_prodi']);
		$this->db->set('cp_mk',$data['cp_mk']);
		$this->db->set('deskripsi_singkat',$data['deskripsi_singkat']);
		$this->db->set('pokok_bahasan',$data['pokok_bahasan']);
		$this->db->set('pustaka_utama',$data['pustaka_utama']);
		$this->db->set('pustaka_pendukung',$data['pustaka_pendukung']);
		$this->db->set('media_perangkat_lunak',$data['media_perangkat_lunak']);
		$this->db->set('media_perangkat_keras',$data['media_perangkat_keras']);
		return $this->db->update('rps');
	}
	
	function update_rps_pertemuan($data)
	{
		$this->db->where('id_rps_pertemuan',$data['id_rps_pertemuan']);
		$this->db->set('sub_cp_mk',$data['sub_cp_mk']);
		$this->db->set('indikator',$data['indikator']);
		$this->db->set('kriteria_bentuk_penilaian',$data['kriteria_bentuk_penilaian']);
		$this->db->set('metode_pembelajaran',$data['metode_pembelajaran']);
		$this->db->set('metode_pembelajaran_daring',$data['metode_pembelajaran_daring']);
		$this->db->set('materi_pembelajaran',$data['materi_pembelajaran']);
		$this->db->set('bobot',$data['bobot']);
		return $this->db->update('rps_pertemuan');
	}
	
	function update_sikap($id_kelas_kuliah,$field,$value)
	{
		$this->db->where('id_kelas_kuliah',$id_kelas_kuliah);
		$this->db->set($field,$value);
		return $this->db->update('persentase_sikap');
	}
	
	function get_sikap($id_kelas_kuliah)
	{
		$this->db->where('id_kelas_kuliah',$id_kelas_kuliah);
		return $this->db->get('persentase_sikap');
	}
	
	function get_nilai_sikap($id_kelas_kuliah,$id_mahasiswa_pt)
	{
		$this->db->where('id_kelas_kuliah',$id_kelas_kuliah);
		$this->db->where('id_mahasiswa_pt',$id_mahasiswa_pt);
		return $this->db->get('nilai_sikap');
	}
	
	function get_persentase($id_kelas_kuliah)
	{
		$this->db->where('id_kelas_kuliah',$id_kelas_kuliah);
		return $this->db->get('persentase_nilai');
	}
	
	function update_persentase($id_kelas_kuliah,$field,$value)
	{
		$this->db->where('id_kelas_kuliah',$id_kelas_kuliah);
		$this->db->set($field,$value);
		return $this->db->update('persentase_nilai');
	}
	
	function update_nilai_pertemuan($id_bap_peserta_kuliah,$nilai)
	{
		$this->db->where('id_bap_peserta_kuliah',$id_bap_peserta_kuliah);
		$this->db->set('nilai',$nilai);
		return $this->db->update('bap_peserta_kuliah');
	}
	
	function update_nilai($id_nilai,$field,$value)
	{
		$this->db->where('id_nilai',$id_nilai);
		$this->db->set($field,$value);
		$this->db->set('sync_to_feeder','N');
		return $this->db->update('nilai');
	}
	
	function update_bap_peserta_kuliah($id_bap_kuliah,$id_mahasiswa_pt,$field,$value)
	{
		$this->db->where('id_bap_kuliah',$id_bap_kuliah);
		$this->db->where('id_mahasiswa_pt',$id_mahasiswa_pt);
		$this->db->set($field,$value);
		return $this->db->update('bap_peserta_kuliah');
	}
	
	function update_nilai_mahasiswa($id_mahasiswa_pt,$id_kelas_kuliah,$field,$value)
	{
		$this->db->where('id_mahasiswa_pt',$id_mahasiswa_pt);
		$this->db->where('id_kelas_kuliah',$id_kelas_kuliah);
		$this->db->set($field,$value);
		$this->db->set('sync_to_feeder','N');
		return $this->db->update('nilai');
	}
	
	function update_nilai_sikap($id_mahasiswa_pt,$id_kelas_kuliah,$field,$value)
	{
		$this->db->where('id_mahasiswa_pt',$id_mahasiswa_pt);
		$this->db->where('id_kelas_kuliah',$id_kelas_kuliah);
		$this->db->set($field,$value);
		return $this->db->update('nilai_sikap');
	}
	
	function peserta_pertemuan_bap($id_bap_kuliah)
	{
		$id_kelas_kuliah=$this->db->select('id_kelas_kuliah')->get_where('bap_kuliah', array('id_bap_kuliah'=>$id_bap_kuliah))->row()->id_kelas_kuliah;
		$this->db 	->select('a.id_nilai, a.id_mahasiswa_pt, if(b.status is null,0,b.status) as status_hadir,e.nm_pd, if(b.nilai is null,0,b.nilai) as nilai,b.id_bap_peserta_kuliah,b.created_at,b.dokumen, km.id_stat_mhs')
					->from('nilai a')
					->join('bap_peserta_kuliah b','a.id_mahasiswa_pt=b.id_mahasiswa_pt and b.id_bap_kuliah='.$id_bap_kuliah,'left')
					->join('mahasiswa_pt d','a.id_mahasiswa_pt=d.id_mahasiswa_pt')
					->join('mahasiswa e','d.id_mhs=e.id_mhs')
					->join('kuliah_mahasiswa km','km.id_mahasiswa_pt = a.id_mahasiswa_pt AND km.id_smt = a.id_smt')
					->where('a.id_kelas_kuliah',$id_kelas_kuliah)
					->order_by('b.status DESC, d.id_mahasiswa_pt ASC');
		return $this->db->get()->result();
	}
	
	function get_pertemuan_mahasiswa($id_mahasiswa_pt,$id_kelas_kuliah)
	{
		$sql = "select a.tanggal, IF(b.status is null, 0,b.status) as status_hadir, IF(b.nilai is null, 0,b.nilai) as nilai
				from bap_kuliah a
				LEFT JOIN bap_peserta_kuliah b on a.id_bap_kuliah=b.id_bap_kuliah and b.id_mahasiswa_pt = ?
				WHERE a.id_kelas_kuliah = ?
				ORDER by a.tanggal asc";
		return $this->db->query($sql, array($id_mahasiswa_pt,$id_kelas_kuliah));
	}
	
	function check_bap_mahasiswa($id_mahasiswa_pt,$id_bap_kuliah)
	{
		$this->db->where('a.id_mahasiswa_pt',$id_mahasiswa_pt);
		$this->db->where('b.id_bap_kuliah',$id_bap_kuliah);
		$this->db->join('bap_kuliah b','a.id_bap_kuliah=b.id_bap_kuliah');
		return $this->db->get('bap_peserta_kuliah a');
	}
	
	function check_hak_mahasiswa($id_mahasiswa_pt,$id_kelas_kuliah=null,$id_bap_kuliah=null)
	{
		if($id_kelas_kuliah){
			$this->db->where('a.id_kelas_kuliah',$id_kelas_kuliah);
		}
		if($id_bap_kuliah){
			$this->db->where('b.id_bap_kuliah',$id_bap_kuliah);
			$this->db->join('bap_kuliah b','a.id_kelas_kuliah=b.id_kelas_kuliah');
		}
		$this->db->where('a.id_mahasiswa_pt',$id_mahasiswa_pt);
		return $this->db->get('nilai a');
	}
	
	function get_nilai($id_kelas_kuliah=null,$id_mahasiswa_pt=null)
	{
		$this->db->select('a.*,c.nm_pd, km.id_stat_mhs,d.id_kat_mk');
		if($id_kelas_kuliah){
			$this->db->where('a.id_kelas_kuliah',$id_kelas_kuliah);
		}
		if($id_mahasiswa_pt){
			$this->db->where('a.id_mahasiswa_pt',$id_mahasiswa_pt);
		}
		$this->db->join('mahasiswa_pt b','a.id_mahasiswa_pt=b.id_mahasiswa_pt');
		$this->db->join('mahasiswa c','c.id_mhs=b.id_mhs');
		$this->db->join('mata_kuliah d','a.id_matkul=d.id_matkul');
		$this->db->join('kuliah_mahasiswa km','km.id_mahasiswa_pt = a.id_mahasiswa_pt AND km.id_smt = a.id_smt');
		//$this->db->order_by('a.id_mahasiswa_pt','asc');
		// sorting abjad nama
		$this->db->order_by('c.nm_pd','asc');
		return $this->db->get('nilai a');
	}
	
	function get_aktifitas($id_bap_kuliah=null,$id_komen=null)
	{
		if($id_bap_kuliah){
			$this->db->where('id_bap_kuliah',$id_bap_kuliah);
		}
		if($id_komen){
			$this->db->where('id_komen',$id_komen);
		}
		$this->db->where('is_deleted','0');
		$this->db->order_by('id_komen','desc');
		return $this->db->get('bap_aktifitas');
	}
		
	function check_start($id_bap_kuliah,$nidn)
	{
		$this->db->where('id_bap_kuliah',$id_bap_kuliah);
		$this->db->where('input_by',$nidn);
		return $this->db->get('bap_kuliah');
	}
	
	function update_kehadiran($data)
	{
		$this->db->where('id_kelas_kuliah',$data['id_kelas_kuliah']);
		$this->db->where('id_mahasiswa_pt',$data['id_mahasiswa_pt']);
		$this->db->where('id_bap_kuliah',$data['id_bap_kuliah']);
		$id_bap_peserta_kuliah = $this->db->get('bap_peserta_kuliah')->row();
		if($id_bap_peserta_kuliah && $data['status'] != '0'){
			$this->db->where('id_kelas_kuliah',$data['id_kelas_kuliah']);
			$this->db->where('id_mahasiswa_pt',$data['id_mahasiswa_pt']);
			$this->db->where('id_bap_kuliah',$data['id_bap_kuliah']);
			$this->db->set('status',$data['status']);
			return $this->db->update('bap_peserta_kuliah');
		}else if($id_bap_peserta_kuliah && $data['status'] == '0'){
			$this->db->where('id_kelas_kuliah',$data['id_kelas_kuliah']);
			$this->db->where('id_mahasiswa_pt',$data['id_mahasiswa_pt']);
			$this->db->where('id_bap_kuliah',$data['id_bap_kuliah']);
			return $this->db->delete('bap_peserta_kuliah');
		}else{
			return $this->hadir($data);
		}
	}
	
	function urutan_pertemuan($id_bap_kuliah,$id_kelas_kuliah)
	{
		$this->db->where('id_bap_kuliah <',$id_bap_kuliah);
		$this->db->where('id_kelas_kuliah',$id_kelas_kuliah);
		$this->db->from('bap_kuliah');
		return $this->db->get()->num_rows();
	}
	
	function update_pertemuan($id_bap_kuliah,$field,$value)
	{
		$this->db->where('id_bap_kuliah',$id_bap_kuliah);
		$this->db->set($field,$value);
		return $this->db->update('bap_kuliah');
	}
	
	function update_bap_aktifitas($id_komen,$field,$value)
	{
		$this->db->where('id_komen',$id_komen);
		$this->db->set($field,$value);
		return $this->db->update('bap_aktifitas');
	}
	
	function update_kelas($id_kelas_kuliah,$field,$value)
	{
		$this->db->where('id_kelas_kuliah',$id_kelas_kuliah);
		$this->db->set($field,$value);
		return $this->db->update('kelas_kuliah');
	}
	
	function check_pertemuan($id_kelas_kuliah=null,$tanggal=null)
	{
		if($id_kelas_kuliah){
			$this->db->where('id_kelas_kuliah',$id_kelas_kuliah);
		}
		if($tanggal){
			$this->db->where('tanggal',$tanggal);
		}
		return $this->db->get('bap_kuliah');
	}
	
	function get_pertemuan_ujian($id_kelas_kuliah=null,$jenis_ujian=null)
	{
		if($id_kelas_kuliah){
			$this->db->where('a.id_kelas_kuliah',$id_kelas_kuliah);
		}
		if($id_kelas_kuliah){
			$this->db->where('a.tipe_kuliah',$jenis_ujian);
		}
		$this->db->select('a.*,d.nm_sdm');
		$this->db->join('dosen d','a.input_by=d.nidn','left');
		return $this->db->get('bap_kuliah a');
	}
	
	function get_pertemuan($id_kelas_kuliah=null,$id_bap_kuliah=null)
	{
		if($id_kelas_kuliah){
			$this->db->where('a.id_kelas_kuliah',$id_kelas_kuliah);
		}
		
		if($id_bap_kuliah){
			$this->db->where('a.id_bap_kuliah',$id_bap_kuliah);
		}
		$this->db->select('a.*,g.nama_gedung,d.nm_sdm,f.nama_ruangan,m.nm_mk,k.nm_kls,k.id_smt')
					->join($_ENV['DB_REF'].'ruangan as f', 'a.id_ruangan=f.id_ruangan','left')
					->join($_ENV['DB_REF'].'gedung as g', 'f.id_gedung=g.id_gedung','left')
					->join('kelas_kuliah k','a.id_kelas_kuliah=k.id_kelas_kuliah')
					->join('mata_kuliah m','m.id_matkul=k.id_matkul')
					->join('dosen d','a.input_by=d.nidn','left');
		$this->db->order_by('a.id_bap_kuliah','desc');
		return $this->db->get('bap_kuliah a');
	}
	
	function hadir($data)
	{
		return $this->db->insert('bap_peserta_kuliah',$data);
	}
	
	function get_jadwal_ujian($id_kelas_kuliah,$jenis_ujian)
	{
		return $this->db->get('kelas_kuliah a');
	}
	
	function simpan_bap_aktifitas($data)
	{
		$this->db->insert('bap_aktifitas',$data);
		return $this->db->insert_id();
	}
	
	function mulai_kuliah($data)
	{
		$this->db->insert('bap_kuliah',$data);
		return $this->db->insert_id();
	}
	
	function kelas_kuliah_mahasiswa($id_mahasiswa_pt=null,$id_smt=null)
 	{
 		$this->db 	->select("	d.inisial_fak as nama_fak, 
 								b.nm_mk, b.id_matkul, 
 								c.nama_prodi, 
 								e.nama_semester, 
 								g.nama_gedung, 
 								f.nama_ruangan, 
 								a.nm_kls, 
 								a.sks_mk, 
 								a.hari_kuliah, 
 								a.jam_mulai, 
 								a.jam_selesai, 
 								a.kuota_kelas, 
 								a.tgl_uts, 
 								a.jam_mulai_uts, 
 								a.jam_selesai_uts, 
 								a.tgl_uas, 
 								a.jam_mulai_uas, 
 								a.jam_selesai_uas, 
 								a.count_pertemuan, 
 								a.count_peserta, 
 								a.id_kelas_kuliah as id_kelas_kuliah, 
 								x.smt")
					->join($_ENV['DB_GREAT'].'kelas_kuliah as a', 'a.id_kelas_kuliah=z.id_kelas_kuliah')
					->join($_ENV['DB_GREAT'].'mata_kuliah as b', 'a.id_matkul=b.id_matkul')
					->join($_ENV['DB_GREAT'].'mata_kuliah_kurikulum as x', 'a.id_matkul=x.id_matkul')
					->join($_ENV['DB_REF'].'prodi as c', 'b.kode_prodi=c.kode_prodi')
					->join($_ENV['DB_REF'].'fakultas as d', 'c.kode_fak=d.kode_fak')
					->join($_ENV['DB_REF'].'semester as e', 'a.id_smt=e.id_semester')
					->join($_ENV['DB_REF'].'ruangan as f', 'a.id_ruangan=f.id_ruangan','left')
					->join($_ENV['DB_REF'].'gedung as g', 'f.id_gedung=g.id_gedung','left');
		if($id_mahasiswa_pt){
			$this->db->where('z.id_mahasiswa_pt',$id_mahasiswa_pt);
		}
		
		if($id_smt)
		{
			$this->db->where('a.id_smt',$id_smt);	
		}
		$this->db->group_by('a.id_kelas_kuliah');
		$this->db->order_by('a.hari_kuliah ASC, a.jam_mulai ASC, b.nm_mk ASC, nama_prodi ASC');
		return $this->db->get($_ENV['DB_GREAT'].'nilai z');
	}
	
	function get_kuliah_mahasiswa()
	{
	    $this->db->join($_ENV['DB_REF'].'status_mahasiswa d','a.id_stat_mhs=d.id_status_mahasiswa');
	    $this->db->where('a.id_mahasiswa_pt',$_SESSION['id_user']);
	    $this->db->where('a.id_smt',$_SESSION['active_smt']);
	    return $this->db->get('kuliah_mahasiswa a');
	}
	
	function kelas_kuliah_dosen($nidn=null,$id_smt=null)
 	{
 		$this->db 	->select("	d.inisial_fak as nama_fak, 
 								b.nm_mk, b.id_matkul, 
 								c.nama_prodi, 
 								e.nama_semester, 
 								g.nama_gedung, 
 								f.nama_ruangan, 
 								a.nm_kls, 
 								a.sks_mk, 
 								a.hari_kuliah, 
 								a.jam_mulai, 
 								a.jam_selesai, 
 								a.kuota_kelas, 
 								a.tgl_uts, 
 								a.jam_mulai_uts, 
 								a.jam_selesai_uts, 
 								a.tgl_uas, 
 								a.jam_mulai_uas, 
 								a.jam_selesai_uas, 
 								a.count_pertemuan, 
 								a.count_peserta, 
 								a.id_kelas_kuliah as id_kelas_kuliah, 
 								h.id_dosen, 
 								j.nidn, 
 								j.nm_sdm, 
 								j.no_hp, 
 								x.smt")
					->join($_ENV['DB_GREAT'].'mata_kuliah as b', 'a.id_matkul=b.id_matkul')
					->join($_ENV['DB_GREAT'].'mata_kuliah_kurikulum as x', 'a.id_matkul=x.id_matkul')
					->join($_ENV['DB_GREAT'].'ajar_dosen as h', 'a.id_kelas_kuliah=h.id_kelas_kuliah','left')
					->join($_ENV['DB_GREAT'].'dosen as j', 'j.id_dosen=h.id_dosen','left')
					->join($_ENV['DB_REF'].'prodi as c', 'b.kode_prodi=c.kode_prodi')
					->join($_ENV['DB_REF'].'fakultas as d', 'c.kode_fak=d.kode_fak')
					->join($_ENV['DB_REF'].'semester as e', 'a.id_smt=e.id_semester')
					->join($_ENV['DB_REF'].'ruangan as f', 'a.id_ruangan=f.id_ruangan','left')
					->join($_ENV['DB_REF'].'gedung as g', 'f.id_gedung=g.id_gedung','left');
		if($nidn){
			$this->db->where('j.nidn',$nidn);
		}
		
		if($id_smt)
		{
			$this->db->where('a.id_smt',$id_smt);	
		}
		$this->db->group_by('a.id_kelas_kuliah');
		$this->db->order_by('a.hari_kuliah ASC, a.jam_mulai ASC, b.nm_mk ASC, nama_prodi ASC');
		return $this->db->get($_ENV['DB_GREAT'].'kelas_kuliah a');
	}
}