<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Hashids\Hashids;

class Persepsi_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function tambah_pertanyaan($data)
	{
	    return $this->db->insert($_ENV['DB_PER'].'pertanyaan',$data);
	}
	
	function update_detail_persepsi($id_pertanyaan,$kolom,$isi)
	{
	    $this->db->set($kolom,$isi);
	    $this->db->where('id_pertanyaan',$id_pertanyaan);
	    return $this->db->update($_ENV['DB_PER'].'pertanyaan');
	}
	
	function get_id_instrumen_kelas($id_kelas_kuliah)
	{
	    $kelas = $this->db->select('id_instrumen')->get_where('kelas_kuliah',array('id_kelas_kuliah'=>$id_kelas_kuliah))->row();
	    if($kelas->id_instrumen)
	    {
	        return $kelas->id_instrumen;
	    }else{
	        $id_instrumen = $this->get_instrumen_aktif();
	        $this->db->where('id_kelas_kuliah',$id_kelas_kuliah);
	        $this->db->set('id_instrumen',$id_instrumen);
	        $this->db->update('kelas_kuliah');
	        return $id_instrumen;
	    }
	}
	
	function get_id_responden($id_kelas_kuliah,$id_mahasiswa_pt,$id_instrumen)
	{
	    $mhs = $this->db->select('id_responden')->get_where($_ENV['DB_PER'].'responden',array('id_kelas_kuliah'=>$id_kelas_kuliah,'id_mahasiswa_pt'=>$id_mahasiswa_pt))->row();
	    if($mhs)
	    {
	        return $mhs->id_responden;
	    }else{
	        $hashids = new Hashids($id_kelas_kuliah.'-'.$id_mahasiswa_pt,11);
            $id_responden = $hashids->encode(time());
	        
	        $this->db->set('id_responden',$id_responden);
	        $this->db->set('id_kelas_kuliah',$id_kelas_kuliah);
	        $this->db->set('id_mahasiswa_pt',$id_mahasiswa_pt);
	        $this->db->set('id_instrumen',$id_instrumen);
	        $this->db->insert($_ENV['DB_PER'].'responden');
	        return $id_responden;
	    }
	}
	
	function update_isi_persepsi($id_mahasiswa_pt,$id_kelas_kuliah)
	{
		$this->db->where('id_kelas_kuliah',$id_kelas_kuliah);
		$this->db->where('id_mahasiswa_pt',$id_mahasiswa_pt);
		$this->db->set('isi_persepsi','1');
		return $this->db->update('nilai');
	}
	
	function hitung_skor_persepsi($id_kelas_kuliah)
	{
		$this->load->database();
		$skor=$this->db->query('select ROUND(avg(`nilai`),2)*25 as akhir FROM '.$_ENV['DB_PER'].'respon WHERE id_kelas_kuliah='.$id_kelas_kuliah)->row();
		/*return $skor->akhir;*/
		$this->db->where('id_kelas_kuliah',$id_kelas_kuliah);
		$this->db->set('skor_persepsi',$skor->akhir);
		return $this->db->update('kelas_kuliah');
	}
	
    function distinct_pertanyaan($id_instrumen = null)
    {
        $this->db->select('distinct(id_pertanyaan) as id_pertanyaan');

        if ($id_instrumen) {
            $this->db->where('id_instrumen', $id_instrumen);
        }

        return $this->db->get($_ENV['DB_PER'].'pertanyaan');
    }
	
	function delete_respon($id_responden=null)
	{
	    $this->db->where('id_responden',$id_responden);
	    return $this->db->delete($_ENV['DB_PER'].'respon');
	}
	
	function delete_respon_text($id_responden=null)
	{
	    $this->db->where('id_responden',$id_responden);
	    return $this->db->delete($_ENV['DB_PER'].'respon_text');
	}
	
	function get_respon($id_responden=null,$id_kelas_kuliah=null)
	{
	    if($id_responden){
	        $this->db->where('id_responden',$id_responden);
	    }
	    if($id_kelas_kuliah){
	        $this->db->where('id_kelas_kuliah',$id_kelas_kuliah);
	    }
	    return $this->db->get($_ENV['DB_PER'].'respon');
	}
	
	function get_respon_text($id_responden=null,$id_kelas_kuliah=null)
	{
	    if($id_responden){
	        $this->db->where('id_responden',$id_responden);
	    }
	    if($id_kelas_kuliah){
	        $this->db->where('id_kelas_kuliah',$id_kelas_kuliah);
	    }
	    return $this->db->get($_ENV['DB_PER'].'respon_text');
	}
	
	function save_respon($data = null)
	{
		return $this->db->insert_batch($_ENV['DB_PER'] . 'respon', $data);
	}

	function save_respon_text($data = null)
	{
		return $this->db->insert($_ENV['DB_PER'] . 'respon_text', $data);
	}
	
	function get_instrumen_aktif()
	{
	    return $this->db->select('id_instrumen')->get_where($_ENV['DB_PER'].'instrumen',array('aktif'=>'1'))->row()->id_instrumen;
	}
	
	function get_survey($id_kelas_kuliah = null, $id_pertanyaan = null, $id_responden = null)
    {
        $this->db->select('*');
        if ($id_kelas_kuliah) {
            $this->db->where('id_kelas_kuliah', $id_kelas_kuliah);
        }
        if ($id_pertanyaan) {
            $this->db->where('id_pertanyaan', $id_pertanyaan);
        }
        if ($id_responden) {
            $this->db->where('id_responden', $id_responden);
        }
        return $this->db->get($_ENV['DB_PER'] .'respon')->result();
    }
	
	function get_responden($id_responden=null,$id_kelas_kuliah = null)
	{
	   if($id_responden){
	        $this->db->where('id_responden',$id_responden);
	    }
	    if($id_kelas_kuliah){
	        $this->db->where('id_kelas_kuliah',$id_kelas_kuliah);
	    }
	    return $this->db->get($_ENV['DB_PER'].'responden');
	}
	
	function get($id_instrumen=null)
	{
	   if($id_instrumen){
	        $this->db->where('id_instrumen',$id_instrumen);
	    }
	    return $this->db->get($_ENV['DB_PER'].'instrumen');
	}
	
	function get_pertanyaan($id_instrumen=null,$id_pertanyaan=null,$aktif=null)
	{
	    if($id_instrumen){
	        $this->db->where('id_instrumen',$id_instrumen);
	    }
	    if($id_pertanyaan){
	        $this->db->where('id_pertanyaan',$id_pertanyaan);
	    }
	    if($aktif)
	    {
	        $this->db->where('aktif',$aktif);
	    }
	    return $this->db->get($_ENV['DB_PER'].'pertanyaan');
	}
	
}