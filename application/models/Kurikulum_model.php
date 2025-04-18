<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kurikulum_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function store_mk_konv($id_mata_kuliah_kurikulum,$id_matkul_konv)
    {
        $this->db->where('id_mata_kuliah_kurikulum',$id_mata_kuliah_kurikulum);
		$this->db->set('id_matkul_konv',$id_matkul_konv);
		$simpan = $this->db->update('mata_kuliah_kurikulum');
		if($simpan)
		{
		    return $this->db->where('id_matkul',$id_matkul_konv)->get('mata_kuliah');
		}else{ return false; }
    }
	
	function remove_mk_konv($id_mata_kuliah_kurikulum)
    {
        $this->db->where('id_mata_kuliah_kurikulum',$id_mata_kuliah_kurikulum);
		$this->db->set('id_matkul_konv',NULL);
		return $this->db->update('mata_kuliah_kurikulum');
	}
	
	function list_mk_konversi($id_kur,$kurikulum_asal)
	{
	    $lama=$this->db->select('id_matkul_konv')->where('id_kur',$id_kur)->where('id_matkul_konv is not null')->get('mata_kuliah_kurikulum');
	    $id_matkul_konv=array();
	    $hasil = false;
		if( $lama->num_rows() > 0 )
		{
		    $hasil = true;
			foreach( $lama->result() as $row )
			{
				$id_matkul_konv[] = $row->id_matkul_konv;
			}
		}
		$this->db->select('b.kode_mk as kode_mk,b.id_matkul as id_matkul, b.nm_mk as nm_mk, a.sks_mk as sks_mk');
		$this->db->where('a.id_kur',$kurikulum_asal);
		if($hasil) $this->db->where_not_in('a.id_matkul',$id_matkul_konv);
		$this->db->join('mata_kuliah b','a.id_matkul=b.id_matkul');
		$this->db->order_by('b.nm_mk');
		return $this->db->get('mata_kuliah_kurikulum a');
	}
	
	function get_kur_konversi($id_kur,$kode_prodi)
	{
	    $this->db->where('kode_prodi',$kode_prodi);
	    $this->db->where('id_kur !=',$id_kur);
	    return $this->db->get('kurikulum');
	}
	
	function ref_kelas_krs($id_matkul,$smt)
	{
		
	}
	
	function ref_maktul_krs($id_mahasiswa_pt,$id_kur,$smt)
	{
		$sql="SELECT
			c.sks_mk,
			c.kode_mk,
			a.smt,
			a.id_matkul,
			c.nm_mk,
			e.nilai_huruf,
			a.a_wajib
		FROM
			".$_ENV['DB_GREAT']."mata_kuliah_kurikulum a 
		JOIN
			".$_ENV['DB_GREAT']."mata_kuliah c
		ON
			a.id_matkul=c.id_matkul
		JOIN
			".$_ENV['DB_GREAT']."mahasiswa_pt d
		ON
			d.kode_prodi=c.kode_prodi AND d.id_mahasiswa_pt= ?
		LEFT JOIN
			(
				select id_matkul,id_mahasiswa_pt,nilai_huruf from ".$_ENV['DB_GREAT']."nilai where id_mahasiswa_pt=? group by id_matkul
			) e
		ON
			e.id_matkul=a.id_matkul
		WHERE
			a.id_kur=? and a.smt=?";
		return $this->db->query($sql,array($id_mahasiswa_pt,$id_mahasiswa_pt,$id_kur,$smt));
	}
	
	function ref_matkul_kur_kelas($id_kur,$id_smt)
	{
		$smt=str_split($id_smt);
		
		if($smt[4]==1){
		$sql = 'SELECT `d`.`id_matkul`, `d`.`kode_mk`, `d`.`nm_mk`, `d`.`sks_mk`, `d`.`jns_mk`, `a`.`smt` 
				FROM '.$_ENV['DB_GREAT'].'`mata_kuliah_kurikulum` `a` 
				JOIN '.$_ENV['DB_GREAT'].'`mata_kuliah` `d` ON `a`.`id_matkul`=`d`.`id_matkul` 
				WHERE `a`.`id_kur` = ? AND 
				(MOD(a.smt, 2) !=0 OR `a`.`smt` =0 )
				ORDER BY `a`.`smt` ASC, `a`.`no_urut` ASC, `d`.`nm_mk` ASC';
			//$this->db->where("MOD(a.smt, 2) != 0");
		}
		if($smt[4]==2){
			$sql = 'SELECT `d`.`id_matkul`, `d`.`kode_mk`, `d`.`nm_mk`, `d`.`sks_mk`, `d`.`jns_mk`, `a`.`smt` 
				FROM '.$_ENV['DB_GREAT'].'`mata_kuliah_kurikulum` `a` 
				JOIN '.$_ENV['DB_GREAT'].'`mata_kuliah` `d` ON `a`.`id_matkul`=`d`.`id_matkul` 
				WHERE `a`.`id_kur` = ? AND 
				(MOD(a.smt, 2) =0 OR `a`.`smt` =0 )
				ORDER BY `a`.`smt` ASC, `a`.`no_urut` ASC, `d`.`nm_mk` ASC';
		}
		/* $this->db->or_where('a.smt=0');
		$this->db->where('a.id_kur',$id_kur);
		$this->db->select('d.id_matkul,d.kode_mk,d.nm_mk,d.sks_mk,d.jns_mk,a.smt');
		$this->db->join($_ENV['DB_GREAT'].'mata_kuliah d','a.id_matkul=d.id_matkul');
		$this->db->order_by('a.smt','asc');
		$this->db->order_by('a.no_urut','asc');
		$this->db->order_by('d.nm_mk','asc'); */
		return $this->db->query($sql,array($id_kur));
		//return $this->db->get_compiled_select($_ENV['DB_GREAT'].'mata_kuliah_kurikulum a');
	}
	
	
	function get_mata_kuliah_kurikulum($id_kur)
	{
		$this->db->select('a.id_mata_kuliah_kurikulum,a.no_urut,d.kode_mk,d.nm_mk,d.sks_mk,d.jns_mk,a.smt,e.nama_jenis_mk,a.a_wajib,d.id_matkul, d.id_kat_mk,a.id_matkul_konv');
		$this->db->where('a.id_kur',$id_kur);
		$this->db->join($_ENV['DB_GREAT'].'mata_kuliah d','a.id_matkul=d.id_matkul');
		$this->db->join($_ENV['DB_REF'].'prodi b','d.kode_prodi=b.kode_prodi');
		$this->db->join($_ENV['DB_REF'].'fakultas c','c.kode_fak=b.kode_fak');
		$this->db->join($_ENV['DB_REF'].'jenis_mata_kuliah e','d.jns_mk=e.inisial_jenis_mk','left');
		$this->db->order_by('a.smt','asc');
		$this->db->order_by('a.no_urut','asc');
		$this->db->order_by('d.nm_mk','asc');
		return $this->db->get($_ENV['DB_GREAT'].'mata_kuliah_kurikulum a');
	}
	
	function get_mata_kuliah_kurikulum_konversi($id_kur)
	{
		$this->db->select('konv.kode_mk as k_kode_mk,konv.nm_mk as k_nm_mk,konv.sks_mk as k_sks_mk,a.id_mata_kuliah_kurikulum,a.no_urut,d.kode_mk,d.nm_mk,d.sks_mk,d.jns_mk,a.smt,e.nama_jenis_mk,a.a_wajib,d.id_matkul, d.id_kat_mk,a.id_matkul_konv');
		$this->db->where('a.id_kur',$id_kur);
		$this->db->join($_ENV['DB_GREAT'].'mata_kuliah d','a.id_matkul=d.id_matkul');
		$this->db->join($_ENV['DB_GREAT'].'mata_kuliah konv','a.id_matkul_konv=konv.id_matkul','left');
		$this->db->join($_ENV['DB_REF'].'prodi b','d.kode_prodi=b.kode_prodi');
		$this->db->join($_ENV['DB_REF'].'fakultas c','c.kode_fak=b.kode_fak');
		$this->db->join($_ENV['DB_REF'].'jenis_mata_kuliah e','d.jns_mk=e.inisial_jenis_mk','left');
		$this->db->order_by('a.smt','asc');
		$this->db->order_by('a.no_urut','asc');
		$this->db->order_by('d.nm_mk','asc');
		return $this->db->get($_ENV['DB_GREAT'].'mata_kuliah_kurikulum a');
	}
	
	function get_add_mata_kuliah_kurikulum($id_kur,$kode_prodi)
	{
		$this->db->select('a.id_matkul,a.nm_mk,a.kode_mk');
		$this->db->join('mata_kuliah_kurikulum b','a.id_matkul=b.id_matkul and b.id_kur='.$id_kur,'left');
		$this->db->where('a.kode_prodi',$kode_prodi);
		$this->db->where('b.id_matkul is null');
		$this->db->order_by('a.nm_mk','asc');
		return $this->db->get('mata_kuliah a');
	}
	
	function simpan_mata_kuliah_kurikulum($data)
	{
		return $this->db->insert('mata_kuliah_kurikulum',$data);
	}
	
	function simpan_kurikulum($data)
	{
		$this->db->insert('kurikulum',$data);
		return $this->db->insert_id();
	}
	
	function ubah_mk_kur($id_mata_kuliah_kurikulum,$smt)
	{
		$this->db->where('id_mata_kuliah_kurikulum',$id_mata_kuliah_kurikulum);
		$this->db->set('smt',$smt);
		return $this->db->update('mata_kuliah_kurikulum');
	}
	
	function hapus_mata_kuliah_kurikulum($id_mata_kuliah_kurikulum)
	{
		$this->db->where('id_mata_kuliah_kurikulum',$id_mata_kuliah_kurikulum);
		return $this->db->delete('mata_kuliah_kurikulum');
	}
	
	function hapus_kurikulum($id_kur)
	{
		$this->db->where('id_kur',$id_kur);
		return $this->db->delete('kurikulum');
	}
	
	function update_sk($id_kur,$sk_kurikulum)
	{
		$this->db->where('id_kur',$id_kur);
		$this->db->set('sk_kurikulum',$sk_kurikulum);
		return $this->db->update('kurikulum');
	}
	
	function update_kurikulum($data)
	{
		$this->db->where('id_kur',$data['id_kur']);
		$this->db->set('nm_kurikulum_sp',$data['nm_kurikulum_sp']);
		$this->db->set('jml_sem_normal',$data['jml_sem_normal']);
		$this->db->set('jml_sks_wajib',$data['jml_sks_wajib']);
		$this->db->set('jml_sks_pilihan',$data['jml_sks_pilihan']);
		return $this->db->update('kurikulum');
	}
	
	function aktif_kurikulum($id_kur)
	{
		$get_prodi=$this->db->get_where('kurikulum',array('id_kur'=>$id_kur))->row();
		if($get_prodi)
		{
			$this->db->where('kode_prodi',$get_prodi->kode_prodi);
			$this->db->set('kur_aktif',0);
			$update = $this->db->update('kurikulum');
			if($update)
			{
				$this->db->where('id_kur',$id_kur);
				$this->db->set('kur_aktif',1);
				return $this->db->update('kurikulum');
			}else { return false; }
		}else { return false; }
		
	}
	
	function ref_kurikulum_aktif($kode_prodi)
	{
		$this->db->where('a.kode_prodi',$kode_prodi);
		$this->db->where('a.kur_aktif',1);
		return $this->db->get($_ENV['DB_GREAT'].'kurikulum a');
	}
	
	function get_kurikulum($id_kur=null,$kur_aktif=null)
	{
		if($id_kur)
		{
			$this->db->where('a.id_kur',$id_kur);
		}
		if($kur_aktif)
		{
			$this->db->where('a.kur_aktif',$kur_aktif);
		}
		$this->db->join($_ENV['DB_REF'].'prodi b','a.kode_prodi=b.kode_prodi');
		$this->db->join($_ENV['DB_REF'].'fakultas c','c.kode_fak=b.kode_fak');
		$this->db->order_by('nm_kurikulum_sp','asc');
		return $this->db->get($_ENV['DB_GREAT'].'kurikulum a');
	}
}