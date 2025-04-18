<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aktivitas_model extends CI_Model {

	function __construct()
	{
		parent::__construct();

		$CI = &get_instance();
		$this->db_aktivitas = $CI->load->database('aktivitas', TRUE);
		$this->db_sso 		= $CI->load->database('sso', TRUE);
	}

	function insert($table, $data)
	{
	    return $this->db->insert($table, $data);
	}

	function get($table, $where = null, $order_by = null, $limit = null)
	{
	    if ($where) $this->db->where($where);
	    if ($order_by) $this->db->order_by($order_by);
	    if ($limit) $this->db->limit($limit);
	    
	    $this->db->from($table);
	    return $this->db->get();
	}

	function mahasiswa_studi_akhir($id_kat_mk) {
		$this->db->select('id_mahasiswa_pt, id_smt');
		$this->db->where('id_kat_mk', $id_kat_mk);
		$this->db->join($_ENV['DB_GREAT'].'mata_kuliah mk', 'mk.id_matkul = krs.id_matkul');
		return $this->db->get($_ENV['DB_GREAT'].'krs');
	}

	function wisudawan($where, $order_by = null)
	{
		if ($order_by) $this->db->order_by($order_by);

		$this->db->select('MAX(p.id_penjadwalan) as id_penjadwalan, a.id_mahasiswa_pt, mp.id_mhs, m.id_wil, p.id_kegiatan, nik, nm_pd, tmp_lahir, mulai_smt, jalan, blok, rt, rw, tgl_lahir, judul, m.email, m.no_hp, ipk, sks_diakui, nm_wil, nama_jalur_masuk, MAX(p.tanggal) as tanggal, p.nama_prodi');
		$this->db->where('p.id_kegiatan', '5');
		$this->db->join($_ENV['DB_AKT'].'aktivitas as', 'as.id_aktivitas = p.id_aktivitas');
		$this->db->join($_ENV['DB_AKT'].'anggota a', 'a.id_aktivitas = p.id_aktivitas');
		$this->db->join($_ENV['DB_GREAT'].'mahasiswa_pt mp', 'mp.id_mahasiswa_pt = a.id_mahasiswa_pt AND mp.npm_aktif = 1');
		$this->db->join($_ENV['DB_GREAT'].'mahasiswa m', 'm.id_mhs = mp.id_mhs');
		$this->db->join($_ENV['DB_REF'].'jalur_masuk jm', 'jm.id_jalur_masuk = mp.id_jalur_masuk', 'left');
		$this->db->join($_ENV['DB_REF'].'wilayah w', 'w.id_wil = m.id_wil', 'left');
		$this->db->join($_ENV['DB_REF'].'prodi p', 'p.kode_prodi = as.kode_prodi');

		if ($where['kode_prodi'] != '0') $this->db->where('as.kode_prodi', $where['kode_prodi']);
		if ($where['kode_fak'] != '0') $this->db->where('p.kode_fak', $where['kode_fak']);

		return $this->db->get($_ENV['DB_AKT'].'penjadwalan p');
	}

	function tutup_seminar_sidang($data, $where)
	{
		$this->db_aktivitas->where($where);
		return $this->db_aktivitas->update('penjadwalan', $data);
	}

	function nilai_huruf($nilai_angka, $id_kegiatan)
	{
		return $this->db_aktivitas->query('SELECT * FROM `pengaturan_nilai` WHERE (? BETWEEN nilai_angka_min AND nilai_angka_maks) AND id_kegiatan = ? AND aktif = 1', [ $nilai_angka, $id_kegiatan ])->row();
	}

	function nilai_akhir($where = null, $order_by = null, $select = null)
	{
		if ($select) $this->db_aktivitas->select($select);
		if ($where) $this->db_aktivitas->where($where);
		if ($order_by) $this->db_aktivitas->order_by($order_by);

		return $this->db_aktivitas->get('nilai_akhir');
	}

	function pengaturan_nilai($nilai_angka)
	{
		return $this->db_aktivitas->query('SELECT * FROM `pengaturan_nilai` WHERE (? BETWEEN nilai_angka_min AND nilai_angka_maks) AND aktif = 1', [ $nilai_angka ])->row();
	}

	function proses_nilai($data)
	{
		$penilaian = $this->pengaturan_nilai($data['nilai_angka']);

		$this->db_aktivitas->where([ 'id_aktivitas' => $data['id_aktivitas'], 'id_anggota' => $data['id_anggota'] ]);
		return $this->db_aktivitas->update('anggota', [ 'nilai_angka' => $data['nilai_angka'], 'nilai_huruf' => $penilaian->nilai_huruf, 'bobot' => $penilaian->bobot ]);
	}

	function rata_rata_nilai($id_penjadwalan)
	{
		$query = 'SELECT SUM(rata_rata) / COUNT(*) as nilai FROM (SELECT AVG(nilai) as rata_rata FROM nilai WHERE id_penjadwalan = ? GROUP BY jenis_nilai) N';
		return $this->db_aktivitas->query($query, [ $id_penjadwalan ]);
	}

	function nilai_tambahan($where)
	{
		if ($where) $this->db_aktivitas->where($where);
		return $this->db_aktivitas->get('nilai');
	}

	function nilai($where, $order_by=null, $arr_where = null)
	{
		if ($arr_where) $this->db_aktivitas->where($arr_where);
		if ($order_by) $this->db_aktivitas->order_by($order_by);
	
		$this->db_aktivitas->select('kn.id_komponen_nilai, kn.nama_komponen, n.nilai, kn.id_parent, kn.bobot, kn.id_kegiatan');
		$this->db_aktivitas->join('nilai n', 'n.id_komponen_nilai = kn.id_komponen_nilai AND n.id_anggota = '.$where['id_anggota'].' AND n.jenis_nilai = '.$where['jenis_nilai'].' AND n.id_penjadwalan = '.$where['id_penjadwalan'].' AND n.nidn = '.$where['nidn'], 'left');
		$this->db_aktivitas->where('kn.id_kegiatan', $where['id_kegiatan']);
		// $this->db_aktivitas->join('penjadwalan p', 'p.id_penjadwalan = n.id_penjadwalan'), 'left');

		// $this->db_aktivitas->join('nilai n', 'n.id_komponen_nilai = kn.id_komponen_nilai AND n.id_anggota = '.$this->security->xss_clean($where['id_anggota']).' AND n.id_aktivitas = '.$this->security->xss_clean($where['id_aktivitas']). ' AND n.jenis_nilai = '.$this->security->xss_clean($where['jenis_nilai']). ' AND n.id_kegiatan = '.$this->security->xss_clean($where['id_kegiatan']), 'left');
		return $this->db_aktivitas->get('komponen_nilai kn');
	}

	function simpan_nilai($data, $table = 'nilai')
	{
		return $this->db_aktivitas->replace($table, $data);
	}

	function hapus_nilai($where, $table = 'nilai')
	{
		$this->db_aktivitas->where($where);
		return $this->db_aktivitas->delete($table);
	}

	function aktivitas($where, $order_by=null, $jenis_bimbingan=null, $db=null)
	{
		if ($order_by) $this->db->order_by($order_by);
		if ($db == null) {
			$db = $_ENV['DB_AKT'];
		}


		$this->db->select('a.*, jam.nama_jenis_aktivitas_mahasiswa, s.nama_semester, p.kode_fak');
		$this->db->where($where);
		$this->db->join($_ENV['DB_REF'].'jenis_aktivitas_mahasiswa jam', 'jam.id_jenis_aktivitas_mahasiswa = a.id_jenis_aktivitas_mahasiswa');
		$this->db->join($_ENV['DB_REF'].'semester s', 's.id_semester=a.id_smt');
		$this->db->join($_ENV['DB_REF'].'prodi p', 'p.kode_prodi = a.kode_prodi');
		
		if ($db == $_ENV['DB_MBKM']) {
			$this->db->select('m.nama_resmi, m.nama_merek, pro.nama_program, pro.id_jenis_aktivitas_mahasiswa, jenis_program, p.nama_prodi, pm.tgl_mulai, pm.tgl_selesai, m.tautan, m.alamat, pro.id_program');
			$this->db->join($_ENV['DB_MBKM'].'program_mitra pm', 'pm.id_program_mitra = a.id_program_mitra');
	        $this->db->join($_ENV['DB_MBKM'].'program pro','pro.id_program = pm.id_program');
	        $this->db->join($_ENV['DB_MBKM'].'mitra m','m.id_mitra = pm.id_mitra');
		}

		if ($jenis_bimbingan == '1') {
			$this->db->join($db.'pembimbing p', 'p.id_aktivitas=a.id_aktivitas');
		}

		if ($jenis_bimbingan == '2') {
			$this->db->join($db.'penguji p', 'p.id_aktivitas=a.id_aktivitas');
		}

		if ($jenis_bimbingan == '3') {
			$this->db->join($db.'penjadwalan p', 'p.id_aktivitas=a.id_aktivitas');
		}
		
		return $this->db->get($db.'aktivitas a');
	}

	function mahasiswa_pt($where) {
		$this->db->where($where);
		$this->db->join($_ENV['DB_GREAT'].'mahasiswa m', 'm.id_mhs=mp.id_mhs');
		return $this->db->get($_ENV['DB_GREAT'].'mahasiswa_pt mp');
	}

	function anggota($where, $order_by = null, $db = null)
	{
		if ($order_by) $this->db->order_by($order_by);
		if ($db == null) {
			$db = $_ENV['DB_AKT'];
		}

		$this->db->select('a.*, as.id_smt, mp.kode_prodi, m.nm_pd, m.id_mhs, p.nama_prodi, p.kode_fak, f.nama_fak, jp.nm_jenj_didik, m.no_hp, m.email');
		$this->db->where($where);
		$this->db->join($db.'aktivitas as', 'as.id_aktivitas=a.id_aktivitas');
		$this->db->join($_ENV['DB_GREAT'].'mahasiswa_pt mp', 'mp.id_mahasiswa_pt=a.id_mahasiswa_pt');
		$this->db->join($_ENV['DB_GREAT'].'mahasiswa m', 'm.id_mhs=mp.id_mhs');
		$this->db->join($_ENV['DB_REF'].'prodi p', 'p.kode_prodi=mp.kode_prodi');
		$this->db->join($_ENV['DB_REF'].'fakultas f', 'f.kode_fak=p.kode_fak');
		$this->db->join($_ENV['DB_REF'].'jenjang_pendidikan jp', 'jp.id_jenj_didik=p.id_jenjang_pendidikan');


		return $this->db->get($db.'anggota a');
	}

	function kategori_kegiatan($where_in = null, $penguji=null) {
		if ($penguji) $this->db->where_in('kk.id_kategori_kegiatan', [ 110500, 110501, 110502 ]);
		if ($where_in) $this->db->where_in('kk.id_kategori_kegiatan', $where_in);

		$this->db->order_by('kk.id_kategori_kegiatan ASC');
		return $this->db->get($_ENV['DB_REF'].'kategori_kegiatan kk');
	}

	function kegiatan($where)
	{
		$this->db_aktivitas->where($where);
		return $this->db_aktivitas->get('kegiatan');
	}

	function berkas_kegiatan($where, $order_by=null, $id_anggota=null)
	{
		if ($order_by) $this->db_aktivitas->order_by($order_by);
		$id_anggota = !$id_anggota ? null : ' AND ba.id_anggota = '.$this->db->escape(xss_clean($id_anggota));

		$this->db_aktivitas->select('bk.*, kb.nama_kategori, kb.deskripsi, ba.*');
		$this->db_aktivitas->where($where);
		$this->db_aktivitas->join('kategori_berkas kb', 'kb.id_kat_berkas=bk.id_kat_berkas');
		$this->db_aktivitas->join('berkas_anggota ba', 'ba.id_berkas_kegiatan=bk.id_berkas_kegiatan'.$id_anggota, 'left');
		return $this->db_aktivitas->get('berkas_kegiatan bk');
	}

	function berkas_anggota($where, $order_by=null, $id_anggota=null)
	{
		if ($order_by) $this->db_aktivitas->order_by($order_by);
		$id_anggota = !$id_anggota ? null : ' AND ba.id_anggota = '.$this->db->escape(xss_clean($id_anggota));
	
		$this->db_aktivitas->select('bk.*, kb.nama_kategori, kb.deskripsi, ba.*, k.deskripsi, kb.slug as slug_kategori_berkas, k.slug as slug_kegiatan');
		$this->db_aktivitas->where($where);
		$this->db_aktivitas->join('kegiatan k', 'k.id_kegiatan = bk.id_kegiatan');
		$this->db_aktivitas->join('kategori_berkas kb', 'kb.id_kat_berkas=bk.id_kat_berkas');
		$this->db_aktivitas->join('berkas_anggota ba', 'ba.id_berkas_kegiatan=bk.id_berkas_kegiatan'.$id_anggota, 'left');
		return $this->db_aktivitas->get('berkas_kegiatan bk');
	}

	function hapus_berkas_anggota($where)
	{
		$this->db_aktivitas->where($where);
		return $this->db_aktivitas->delete('berkas_anggota');
	}

	function kegiatan_anggota($where, $id_anggota)
	{
		$this->db_aktivitas->select('k.*, ka.id_anggota, ka.created_at, ka.status');
		$this->db_aktivitas->where($where);
		$this->db_aktivitas->join('kegiatan_anggota ka', 'ka.id_kegiatan = k.id_kegiatan AND ka.id_anggota = '.$this->security->xss_clean($id_anggota), 'left');
		return $this->db_aktivitas->get('kegiatan k');
	}

	function pembimbing($where, $order_by=null, $db=null)
	{
		if ($order_by) $this->db->order_by($order_by);
		if ($db == null) {
			$db = $_ENV['DB_AKT'];
		}

		$this->db->select('p.*, kk.*, nm_sdm, no_hp, email');
		$this->db->where($where);
		$this->db->order_by('kk.id_kategori_kegiatan ASC');
		$this->db->join($_ENV['DB_REF'].'kategori_kegiatan kk', 'kk.id_kategori_kegiatan = p.id_kategori_kegiatan');
		$this->db->join($_ENV['DB_GREAT'].'dosen d', 'd.nidn = p.nidn');
		return $this->db->get($db.'pembimbing p');
	}

	function penguji($where, $order_by=null)
	{
		if ($order_by) $this->db->order_by($order_by);
		
		$this->db->select('p.*, kk.*, nm_sdm, deskripsi, no_hp, email');
		$this->db->where($where);
		$this->db->order_by('k.id_kegiatan ASC, kk.id_kategori_kegiatan ASC');
		$this->db->join($_ENV['DB_REF'].'kategori_kegiatan kk', 'kk.id_kategori_kegiatan = p.id_kategori_kegiatan');
		$this->db->join($_ENV['DB_GREAT'].'dosen d', 'd.nidn = p.nidn');
		$this->db->join($_ENV['DB_AKT'].'kegiatan k', 'k.id_kegiatan = p.id_kegiatan');
		return $this->db->get($_ENV['DB_AKT'].'penguji p');
	}

	function penjadwalan($where, $order_by = null, $anggota = null)
	{
		if ($order_by) $this->db->order_by($order_by);
		if ($anggota) {
			// $this->db->join($_ENV['DB_AKT'].'anggota aa', 'aa.id_aktivitas = p.id_aktivitas');
			$this->db->join($_ENV['DB_AKT'].'aktivitas a', 'a.id_aktivitas = p.id_aktivitas');
			$this->db->join($_ENV['DB_REF'].'jenis_aktivitas_mahasiswa j', 'j.id_jenis_aktivitas_mahasiswa = a.id_jenis_aktivitas_mahasiswa');
			// $this->db->where(['p.id_kegiatan' => 5]);
			$this->db->select('a.id_jenis_aktivitas_mahasiswa, j.id_kat_mk');
		}

		$this->db->select('p.*, d.nm_sdm, k.deskripsi, d.no_hp');
		$this->db->where($where);
		// $this->db->join($_ENV['DB_REF'].'kategori_kegiatan kk', 'kk.id_kategori_kegiatan = p.id_kategori_kegiatan');
		$this->db->join($_ENV['DB_GREAT'].'dosen d', 'd.nidn = p.nidn');
		$this->db->join($_ENV['DB_AKT'].'kegiatan k', 'k.id_kegiatan = p.id_kegiatan');
		return $this->db->get($_ENV['DB_AKT'].'penjadwalan p');
	}

	function tambah_dosen($table, $data, $db = null)
	{
		if ($db == null) {
			$db = $_ENV['DB_AKT'];
		}

		$insert_query = $this->db->insert_string($db.$table, $data);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO', $insert_query);
		return $this->db->query($insert_query);

		// return $this->db_aktivitas->replace($table, $data);
	}

	function tambah_penjadwalan($data)
	{
		$insert_query = $this->db_aktivitas->insert_string('penjadwalan', $data);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO', $insert_query);
		return $this->db_aktivitas->query($insert_query);

		// return $this->db_aktivitas->insert('penjadwalan', $data);
	}

	function delete($table, $where, $db = null)
	{
		if ($db == null) {
			$db = $_ENV['DB_AKT'];
		}

		$this->db->where($where);
		return $this->db->delete($db.$table);
	}

	function hapus_dosen($table, $where, $db = null)
	{
		if ($db == null) {
			$db = $_ENV['DB_AKT'];
		}

		$this->db->where($where);
		return $this->db->delete($db.$table);
	}

	function hapus_penjadwalan($where)
	{
		$this->db_aktivitas->where($where);
		return $this->db_aktivitas->delete('penjadwalan');
	}

	function status_kegiatan_anggota($data)
	{
		return $this->db_aktivitas->replace('kegiatan_anggota', $data);
	}

	function tambah_aktivitas($data, $db = null)
	{
		if ($db == null) {
			$db = $_ENV['DB_AKT'];
		}

		$insert_query = $this->db->insert_string($db.'aktivitas', $data);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO', $insert_query);
		$this->db->query($insert_query);
		return $this->db->insert_id();
	}

	function tambah_anggota($data, $db = null)
	{
		if ($db == null) {
			$db = $_ENV['DB_AKT'];
		}

		$insert_query = $this->db->insert_string($db.'anggota', $data);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO', $insert_query);
		return $this->db->query($insert_query);
	}

	function tambah_user_level($data)
	{
		$insert_query = $this->db_sso->insert_string('user_level', $data);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO', $insert_query);
		return $this->db_sso->query($insert_query);
	}

	function update($data, $where, $table = null, $db = null)
	{
		if ($db == null) {
			$db = $_ENV['DB_AKT'];
		}

		$this->db->where($where);
		return $this->db->update((!$table ? $db.'aktivitas' : $db.$table), $data);
	}


	function aktivitas_log($where, $order_by=null)
	{
		if ($order_by) $this->db_aktivitas->order_by($order_by);

		$this->db_aktivitas->where($where);
		return $this->db_aktivitas->get('aktivitas_log');
	}

	function getUserIpAddr()
	{			
		if(!empty($_SERVER['HTTP_CLIENT_IP'])){	        
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){	        
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{	     
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		
		return $ip;	
	}

	function add_log($whois, $data=null, $ref=null, $whatdo=null)
	{
		$this->load->library('BrowserDetection');
		$browser = new BrowserDetection();
		
		// if (isset($data['id_aktivitas']))
		// 	$data['id_aktivitas'] = $data['id_aktivitas']
		
		$data=array(
			'whois'		=> $whois,
			'id_aktivitas' => (isset($data['id_aktivitas']) ? $data['id_aktivitas'] : '0' ),
			'ref'		=> $ref ?: base_url(uri_string()),
			'data'		=> json_encode($data),
			'whatdo'	=> $whatdo ?: $this->router->method,
			'browser'	=> $browser->getName(),
			'platform'	=> $browser->getPlatformVersion(),
			'ip_address'	=> $this->getUserIpAddr(),
		);


		return $this->db_aktivitas->insert('aktivitas_log',$data);
	}

	function bimbingan($where, $order_by=null)
	{
		if ($order_by) $this->db_aktivitas->order_by($order_by);

		$this->db_aktivitas->select('b.*, k.nama_kegiatan, k.deskripsi');
		$this->db_aktivitas->where($where);
		$this->db_aktivitas->join('kegiatan k', 'k.id_kegiatan = b.id_kegiatan', 'left');

		return $this->db_aktivitas->get('bimbingan b');
	}

	function simpan_bimbingan($data)
	{
		return $this->db_aktivitas->insert('bimbingan', $data);
	}

	function hapus_bimbingan($where)
	{
		$this->db_aktivitas->where($where);
		return $this->db_aktivitas->delete('bimbingan');
	}
}

/* End of file Aktivitas_model.php */
/* Location: ./application/models/Aktivitas_model.php */