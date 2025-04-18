<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utama extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        //$this->load->model('Main_model');
    }
    
    function debut()
    {
        if($_SESSION['app_level']=='7'){
	        $result=$this->Main_model->ref_prodi($_SESSION['kode_fak'],$_SESSION['kode_prodi']);    
	    }else{
	        $result=$this->Main_model->ref_prodi($_SESSION['kode_fak']);
	    }
	    
	    var_dump($result);
    }
	
	function index()
	{
		echo 'oke'; exit();
	}
	
	function simpan_email_mhs()
	{
	    if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		
		$id_mhs 	= $this->input->post('id_mhs');
		$email 	= $this->input->post('email');
		
		$proses = $this->Main_model->simpan_email_mhs($id_mhs,$email);
		if($proses){
			$whythis='simpan_email_mhs';
			$whatdo='#$id_mhs:'.$id_mhs.'#email:'.$email;
			$this->Main_model->akademik_log($whythis,$whatdo);
			echo 1;
		}else{
			echo 0;
		}
		}else{ echo 0; }
	}
	
	function simpan_email_dosen()
	{
	    if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		
		$nidn 	= $this->input->post('nidn');
		$email 	= $this->input->post('email');
		
		$proses = $this->Main_model->simpan_email_dosen($nidn,$email);
		if($proses){
			$whythis='simpan_email_dosen';
			$whatdo='#nidn:'.$nidn.'#email:'.$email;
			$this->Main_model->akademik_log($whythis,$whatdo);
			echo 1;
		}else{
			echo 0;
		}
		}else{ echo 0; }
	}
	
	function simpan_no_hp_mhs()
	{
	    if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		
		$id_mhs 	= $this->input->post('id_mhs');
		$no_hp 	= $this->input->post('no_hp');
		
		$proses = $this->Main_model->simpan_no_hp_mhs($id_mhs,$no_hp);
		if($proses){
			$whythis='simpan_no_hp_mhs';
			$whatdo='#$id_mhs:'.$id_mhs.'#no_hp:'.$no_hp;
			$this->Main_model->akademik_log($whythis,$whatdo);
			echo 1;
		}else{
			echo 0;
		}
		}else{ echo 0; }
	}
	
	function simpan_no_hp_dosen()
	{
	    if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		
		$nidn 	= $this->input->post('nidn');
		$no_hp 	= $this->input->post('no_hp');
		
		$proses = $this->Main_model->simpan_no_hp_dosen($nidn,$no_hp);
		if($proses){
			$whythis='simpan_no_hp_dosen';
			$whatdo='#nidn:'.$nidn.'#no_hp:'.$no_hp;
			$this->Main_model->akademik_log($whythis,$whatdo);
			echo 1;
		}else{
			echo 0;
		}
		}else{ echo 0; }
	}
	
	function simpan_konfigurasi()
	{
		if($_SESSION['app_level']==3){
		$_POST = json_decode($this->input->raw_input_stream, true);
		$nama_konfigurasi 	= $this->input->post('nama_konfigurasi');
		$value_konfigurasi 	= $this->input->post('value_konfigurasi');
		
		$proses = $this->Main_model->simpan_konfigurasi($nama_konfigurasi,$value_konfigurasi);
		if($proses){
			$whythis='simpan_konfigurasi';
			$whatdo='#nama_konfigurasi:'.$nama_konfigurasi.'#value_konfigurasi:'.$value_konfigurasi;
			$this->Main_model->akademik_log($whythis,$whatdo);
			echo 1;
		}else{
			echo 0;
		}
		}else{ echo 0; }
	}
	
	function ref_prodi($kode_fak)
	{
	    if($_SESSION['app_level']==7){
	        $result=$this->Main_model->ref_prodi($_SESSION['kode_fak'],$_SESSION['kode_prodi']);    
	    }else{
	        $result=$this->Main_model->ref_prodi($kode_fak);
	    }
		
		$option="<option value='0'>Semua Program Studi</option>";
		foreach ($result as $key=>$value ){
			$id_jenjang_pendidikan=($value->id_jenjang_pendidikan==30)?'S1':(($value->id_jenjang_pendidikan==22)?'D3':'Profesi');
			$option.= '<option value='.$value->kode_prodi.'>'.$value->nama_prodi.' ('.$id_jenjang_pendidikan.')</option>';
		}
		echo $option;
	}
	
	function ref_gedung($id_gedung)
	{
		$result=$this->Main_model->ref_ruangan($id_gedung)->result();
		$option="<option value='0'>Pilih Ruangan</option>";
		foreach ($result as $key=>$value ){
			$option.= '<option value='.$value->id_ruangan.'>'.$value->nama_ruangan.'</option>';
		}
		echo $option;
	}
	
	function ref_matkul_kur_kelas($id_kur,$id_smt)
	{
		$this->load->model('Kurikulum_model');
		$result=$this->Kurikulum_model->ref_matkul_kur_kelas($id_kur,$id_smt)->result();
		$option="<option>Pilih Mata Kuliah</option>";
		foreach ($result as $key=>$value ){
			$option.= '<option value='.$value->id_matkul.'>[smt: '.$value->smt.'] '.$value->nm_mk.' ('.$value->sks_mk.') SKS</option>';
		} 
		echo $option;
	}
	
	function ref_kurikulum_aktif($kode_prodi)
	{
		$this->load->model('Kurikulum_model');
		$result=$this->Kurikulum_model->ref_kurikulum_aktif($kode_prodi)->result();
		$option="<option>Pilih Kurikulum</option>";
		foreach ($result as $key=>$value ){
			$option.= '<option value='.$value->id_kur.'>'.$value->nm_kurikulum_sp.'</option>';
		} 
		echo $option;
	}
	
	function ref_pengampu($id_kelas_kuliah)
	{
		$option='';
		$pengampu=$this->Main_model->pengampu_kelas($id_kelas_kuliah)->result();
		if($pengampu)
		{
			foreach($pengampu as $keys=>$values)
			{
				$option.='<strong>'.$values->nidn.'</strong> '.$values->nm_sdm.' ('.$values->sks_subst_tot.' SKS)<br>';
			}
		}
		echo $option;
	}
	
	function ref_ruangan_kuliah()
	{
		$_POST = json_decode($this->input->raw_input_stream, true);
		$team_teach	=$this->input->post('team_teach');
		$id_gedung	=$this->input->post('id_gedung');
		$id_smt		=$this->input->post('id_smt');
		$hari_kuliah=$this->input->post('hari_kuliah');
		$jam_mulai	=(strlen($this->input->post('jam_mulai'))!=5)?$this->input->post('jam_mulai').':00':$this->input->post('jam_mulai');
		$jam_selesai=(strlen($this->input->post('jam_selesai'))!=5)?$this->input->post('jam_selesai').':00':$this->input->post('jam_selesai');
		
		$data=array(
			'team_teach'=>$team_teach,
			'id_smt'=>$id_smt,
			'id_gedung'	=>$id_gedung,
			'hari_kuliah'=>$hari_kuliah,
			'jam_mulai'	=>$jam_mulai,
			'jam_selesai'=>$jam_selesai,
		);
		
		$result=$this->Main_model->ref_ruangan_kuliah($data)->result();
		if($result){
			$option="<option>Pilih Ruangan</option>";
			foreach ($result as $key=>$value ){
				$option.= '<option value='.$value->id_ruangan.'>'.$value->nama_ruangan.'</option>';
			}
		}else{
			$option="<option>Ruangan Penuh!</option>";
		}
		echo $option;
	}
	
	function get_dosen_pt()
	{
		$output = $this->Main_model->get_dosen_pt();
		echo json_encode($output);
	}
	
	function get_dosen()
	{
		$output = $this->Main_model->get_dosen();
		echo json_encode($output);
	}

}