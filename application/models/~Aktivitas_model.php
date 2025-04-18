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

	function aktivitas($where, $order_by=null)
	{
		if ($order_by) {
			$this->db_aktivitas->order_by($order_by);
		}

		// $this->db->select('a.*');
		$this->db_aktivitas->where($where);
		// $this->db_aktivitas->join('anggota b', 'a.id_aktivitas=b.id_aktivitas');
		return $this->db_aktivitas->get('aktivitas a');
	}

	function anggota($where, $order_by=null)
	{
		if ($order_by) $this->db->order_by($order_by);

		$this->db->select('a.*, m.*');
		$this->db->where($where);
		// $this->db->join($_ENV['DB_AKT'].'aktivitas b', 'b.id_aktivitas=a.id_aktivitas');
		$this->db->join($_ENV['DB_GREAT'].'mahasiswa_pt mp', 'mp.id_mahasiswa_pt=a.id_mahasiswa_pt');
		$this->db->join($_ENV['DB_GREAT'].'mahasiswa m', 'm.id_mhs=mp.id_mhs');
		return $this->db->get($_ENV['DB_AKT'].'anggota a');
	}

	function kegiatan($where)
	{
		$this->db_aktivitas->where($where);
		return $this->db_aktivitas->get('kegiatan');
	}

	function berkas_kegiatan($where, $order_by=null)
	{
		if ($order_by) $this->db_aktivitas->order_by($order_by);
	
		$this->db_aktivitas->select('bk.*, kb.nama_kategori, kb.deskripsi, ba.*');
		$this->db_aktivitas->where($where);
		$this->db_aktivitas->join('kategori_berkas kb', 'kb.id_kat_berkas=bk.id_kat_berkas');
		$this->db_aktivitas->join('berkas_anggota ba', 'ba.id_berkas_kegiatan=bk.id_berkas_kegiatan', 'left');
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

	function pembimbing($where)
	{
		$this->db->select('p.*, kk.*, nm_sdm');
		$this->db->where($where);
		$this->db->order_by('kk.id_kategori_kegiatan ASC');
		$this->db->join($_ENV['DB_REF'].'kategori_kegiatan kk', 'kk.id_kategori_kegiatan = p.id_kategori_kegiatan');
		$this->db->join($_ENV['DB_GREAT'].'dosen d', 'd.nidn = p.nidn');
		return $this->db->get($_ENV['DB_AKT'].'pembimbing p');
	}

	function penguji($where)
	{
		$this->db->select('p.*, kk.*, nm_sdm, deskripsi');
		$this->db->where($where);
		$this->db->order_by('k.id_kegiatan ASC, kk.id_kategori_kegiatan ASC');
		$this->db->join($_ENV['DB_REF'].'kategori_kegiatan kk', 'kk.id_kategori_kegiatan = p.id_kategori_kegiatan');
		$this->db->join($_ENV['DB_GREAT'].'dosen d', 'd.nidn = p.nidn');
		$this->db->join($_ENV['DB_AKT'].'kegiatan k', 'k.id_kegiatan = p.id_kegiatan');
		return $this->db->get($_ENV['DB_AKT'].'penguji p');
	}

	function penjadwalan($where)
	{
		$this->db->select('p.*, nm_sdm, deskripsi');
		$this->db->where($where);
		// $this->db->join($_ENV['DB_REF'].'kategori_kegiatan kk', 'kk.id_kategori_kegiatan = p.id_kategori_kegiatan');
		$this->db->join($_ENV['DB_GREAT'].'dosen d', 'd.nidn = p.nidn');
		$this->db->join($_ENV['DB_AKT'].'kegiatan k', 'k.id_kegiatan = p.id_kegiatan');
		return $this->db->get($_ENV['DB_AKT'].'penjadwalan p');
	}

	function tambah_dosen($table, $data)
	{
		$insert_query = $this->db_aktivitas->insert_string($table, $data);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO', $insert_query);
		return $this->db_aktivitas->query($insert_query);

		// return $this->db_aktivitas->replace($table, $data);
	}

	function tambah_penjadwalan($data)
	{
		$insert_query = $this->db_aktivitas->insert_string('penjadwalan', $data);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO', $insert_query);
		return $this->db_aktivitas->query($insert_query);

		// return $this->db_aktivitas->insert('penjadwalan', $data);
	}

	function hapus_dosen($table, $where)
	{
		$this->db_aktivitas->where($where);
		return $this->db_aktivitas->delete($table);
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

	function tambah_aktivitas($data)
	{
		$insert_query = $this->db_aktivitas->insert_string('aktivitas', $data);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO', $insert_query);
		$this->db_aktivitas->query($insert_query);
		return $this->db_aktivitas->insert_id();
	}

	function tambah_anggota($data)
	{
		$insert_query = $this->db_aktivitas->insert_string('anggota', $data);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO', $insert_query);
		return $this->db_aktivitas->query($insert_query);
	}

	function tambah_user_level($data)
	{
		$insert_query = $this->db_sso->insert_string('user_level', $data);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO', $insert_query);
		return $this->db_sso->query($insert_query);
	}

	function update($data, $where)
	{
		$this->db_aktivitas->where($where);
		return $this->db_aktivitas->update('aktivitas', $data);
	}
}

/* End of file Aktivitas_model.php */
/* Location: ./application/models/Aktivitas_model.php */