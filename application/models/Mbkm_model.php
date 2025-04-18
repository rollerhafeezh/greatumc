<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mbkm_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function get_mahasiswa($where = null)
	{
		if ($where) $this->db->where($where);

		$this->db->select('mp.*, m.*, nm_lemb');
		$this->db->from($_ENV['DB_MBKM'].'mahasiswa_pt mp');
        $this->db->join($_ENV['DB_MBKM'].'mahasiswa m', 'm.id_mhs = mp.id_mhs');
        $this->db->join($_ENV['DB_REF'].'satuan_pendidikan sp', 'sp.id_sp = mp.id_sp', 'left');

		return $this->db->get();
	}

	function delete($table, $where)
	{
		$this->db->where($where);
		return $this->db->delete($table);
	}

	function insert_ignore($table, $data, $insert_id = false)
	{
		if ($insert_id) {
			$this->db->insert($table, $data);
			return $this->db->insert_id();
		} else {
			$insert_query = $this->db->insert_string($table, $data);
			$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO', $insert_query);
			$this->db->query($insert_query);
			return $this->db->affected_rows();
			// return ($this->db->affected_rows() != 1) ? false : true;
		}
	}

	function insert($table, $data, $insert_id = false)
	{
		if ($insert_id) {
			$this->db->insert($table, $data);
			return $this->db->insert_id();
		} else {
			return $this->db->insert($table, $data);
		}
	}

	function update($table, $where, $data)
	{
		$this->db->where($where);
		return $this->db->update($table, $data);
	}

	function get_join($table, $where = null, $order_by = null, $join = null)
	{
		if ($order_by) $this->db->order_by($order_by);
		if ($where) $this->db->where($where);
		if ($join) {
        	$this->db->join($join['join'], $join['on']);
		}

		return $this->db->get($table);
	}

	function get($table, $where = null, $order_by = null)
	{
		if ($order_by) $this->db->order_by($order_by);
		if ($where) $this->db->where($where);

		return $this->db->get($table);
	}

	function pendaftaran_aktivitas($where = null, $order_by = null)
	{
		if ($order_by) $this->db->order_by($order_by);
		if ($where) $this->db->where($where);

		$this->db->select('p.*, a.*, pm.sks_diakui');

        $this->db->from($_ENV['DB_MBKM'].'pendaftaran p');
        $this->db->join($_ENV['DB_MBKM'].'aktivitas a', 'a.id_aktivitas = p.id_aktivitas');
        $this->db->join($_ENV['DB_MBKM'].'program_mitra pm','pm.id_program_mitra = p.id_program_mitra');
        // $this->db->join($_ENV['DB_MBKM'].'matkul_program_mitra mpm', 'mpm.id_program_mitra = p.id_program_mitra');
        // $this->db->join($_ENV['DB_GREAT'].'mata_kuliah mk','mk.id_matkul = mpm.id_matkul');
        // $this->db->join($_ENV['DB_GREAT'].'mata_kuliah_kurikulum mkk','mkk.id_matkul = mpm.id_matkul');

        return $this->db->get();
	}

	function koordinator_program($where, $order_by=null)
	{
		if ($order_by) $this->db->order_by($order_by);

		$this->db->select('kp.*, nm_sdm, no_hp, email');
		$this->db->where($where);
		$this->db->join($_ENV['DB_GREAT'].'dosen d', 'd.nidn = kp.nidn');
		return $this->db->get($_ENV['DB_MBKM'].'koordinator_program kp');
	}


	function matkul_program($id_program_mitra, $sum = null)
	{
		if ($sum == null) {
			$this->db->select('*');
		} elseif ($sum == 'jml_sks') {
			$this->db->select('pm.*, sum(mk.sks_mk) as jml_sks');
		}

        $this->db->from($_ENV['DB_MBKM'].'matkul_program_mitra mpm');
        $this->db->join($_ENV['DB_MBKM'].'program_mitra pm','pm.id_program_mitra = mpm.id_program_mitra');
        $this->db->join($_ENV['DB_GREAT'].'mata_kuliah mk','mk.id_matkul = mpm.id_matkul');
        $this->db->join($_ENV['DB_GREAT'].'mata_kuliah_kurikulum mkk','mkk.id_matkul = mpm.id_matkul');

        $this->db->where('sha1(mpm.id_program_mitra)', $id_program_mitra);

        return $this->db->get();
	}

	function program_mitra($where = null, $order_by = null)
	{
		if ($order_by) $this->db->order_by($order_by);
		if ($where) $this->db->where($where);

		$this->db->select('pm.*, m.nama_resmi, m.nama_merek, p.nama_program, p.id_jenis_aktivitas_mahasiswa, jam.nama_jenis_aktivitas_mahasiswa');
        $this->db->from($_ENV['DB_MBKM'].'program_mitra pm');
        $this->db->join($_ENV['DB_MBKM'].'program p','p.id_program = pm.id_program');
        $this->db->join($_ENV['DB_MBKM'].'mitra m','m.id_mitra = pm.id_mitra');
        $this->db->join($_ENV['DB_REF'].'jenis_aktivitas_mahasiswa jam','jam.id_jenis_aktivitas_mahasiswa = p.id_jenis_aktivitas_mahasiswa');
		return $this->db->get();
	}

	function program_mbkm($where=null, $order_by=null)
	{
		if ($order_by) $this->db->order_by($order_by);
		if ($where) $this->db->where($where);

		$this->db->select('*');
		$this->db->join($_ENV['DB_REF'].'jenis_aktivitas_mahasiswa jam', 'jam.id_jenis_aktivitas_mahasiswa = p.id_jenis_aktivitas_mahasiswa');
		return $this->db->get($_ENV['DB_MBKM'].'program p');
	}

	function mitra($where=null, $order_by=null)
	{
		if ($order_by) $this->db->order_by($order_by);
		if ($where) $this->db->where($where);

		$this->db->select('*');
		return $this->db->get($_ENV['DB_MBKM'].'mitra m');
	}

	function get_mata_kuliah_kurikulum($where)
	{
		$this->db->select('a.id_mata_kuliah_kurikulum,a.no_urut,d.kode_mk,d.nm_mk,d.sks_mk,d.jns_mk,a.smt,e.nama_jenis_mk,a.a_wajib,d.id_matkul, d.id_kat_mk,a.id_matkul_konv');
		$this->db->where($where);
		$this->db->join($_ENV['DB_GREAT'].'kurikulum k','k.id_kur=a.id_kur');
		$this->db->join($_ENV['DB_GREAT'].'mata_kuliah d','a.id_matkul=d.id_matkul');
		$this->db->join($_ENV['DB_REF'].'prodi b','d.kode_prodi=b.kode_prodi');
		$this->db->join($_ENV['DB_REF'].'fakultas c','c.kode_fak=b.kode_fak');
		$this->db->join($_ENV['DB_REF'].'jenis_mata_kuliah e','d.jns_mk=e.inisial_jenis_mk','left');
		$this->db->order_by('a.smt','asc');
		$this->db->order_by('a.no_urut','asc');
		$this->db->order_by('d.nm_mk','asc');
		return $this->db->get($_ENV['DB_GREAT'].'mata_kuliah_kurikulum a');
	}

	function mbkm_log($where, $order_by=null)
	{
		if ($order_by) $this->db->order_by($order_by);

		$this->db->where($where);
		return $this->db->get($_ENV['DB_MBKM'].'mbkm_log');
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


		return $this->db->insert($_ENV['DB_MBKM'].'mbkm_log',$data);
	}

}

/* End of file Mbkm_model.php */
/* Location: ./application/models/Mbkm_model.php */