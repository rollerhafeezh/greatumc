<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Dosen extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){redirect(base_url('logout'));}
		if($_SESSION['logged_in']==FALSE){ redirect (base_url('logout'));}
		//$this->load->model('Main_model');
	}
	
	function index()
	{
		if($_SESSION['app_level']!=1){
			$data['title'] 		= 'Daftar Dosen';
			$data['content'] 	= 'dosen/tabel';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function riwayat_pengawasan($id_dosen=null)
	{
		if($_SESSION['app_level']!=1){
	        
	    if($_SESSION['app_level']==2) $id_dosen = $_SESSION['username'];
	    
	    if($id_dosen){
	    $bearer = ['nidn'=>$id_dosen];
		$dosen = $this->Main_model->post_api('dosen/dosen',$bearer);
		if($dosen){
		    
		    $data['dosen']      = $dosen[0];
	        $data['title'] 		= 'Riwayat Pengawasan Ujian '.$dosen[0]->nm_sdm;
			$data['content'] 	= 'dosen/riwayat_pengawasan';
			$this->load->view('lyt/index',$data);
			
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	    }else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function json()
	{
		$this->load->model('Dosen_data_model');
	    $maks_sks = $this->Main_model->conf_maks_sks_dosen();
		$list = $this->Dosen_data_model->get_datatables();
        $data = array();
        $no = $_GET['start'];
		$total_ganjil = 0;
		$total_genap = 0;
        foreach ($list as $field) {
			$tahun = ($field->id_tahun_ajaran)?$field->id_tahun_ajaran.'/'.($field->id_tahun_ajaran+1):'';
            $total_ganjil = ($this->Main_model->count_sks_dosen($field->id_dosen,$field->id_tahun_ajaran.'1'))?:0;
            $total_genap = ($this->Main_model->count_sks_dosen($field->id_dosen,$field->id_tahun_ajaran.'2'))?:0;
            
			$no++;
            $row = array();
            
            $row[] = $field->nidn;
            $row[] = '<a href="'.base_url('biodata/dosen/'.$field->nidn).'">'.$field->nm_sdm.'</a>';
            $row[] = $tahun;
            $row[] = $field->inisial_fak.' '.$field->nama_prodi;
            $row[] = $total_ganjil;
            $row[] = $total_genap;
            
			$data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Dosen_data_model->count_all(),
            "recordsFiltered" => $this->Dosen_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	function json_arsip_kelas()
	{
	    $this->load->model('Arsip_kelas_kuliah_dosen_data_model');
	    
		$list = $this->Arsip_kelas_kuliah_dosen_data_model->get_datatables();
		var_dump($list);
	}
	
	function json_arsip_kelas_kuliah()
	{
		$this->load->model('Arsip_kelas_kuliah_dosen_data_model');
	    
		$list = $this->Arsip_kelas_kuliah_dosen_data_model->get_datatables();
        $data = array();
        $no = $_GET['start'];
		
        foreach ($list as $field) {
			
			$no++;
            $row = array();
            
            $row[] = nama_smt($field->id_smt);
            $row[] = $field->nm_mk.' '.$field->nm_kls;
            $row[] = $field->inisial_fak.' '.$field->nama_prodi;
            $row[] = nama_hari($field->hari_kuliah).' '.$field->jam_mulai.' s/d '.$field->jam_selesai;
            $row[] = $field->sks_subst_tot;
            $row[] = '<a class="text-decoration-none" href="'.base_url('dhmd/daftar_pertemuan/'.$field->id_kelas_kuliah).'">Lihat</a>';
            
			$data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Arsip_kelas_kuliah_dosen_data_model->count_all(),
            "recordsFiltered" => $this->Arsip_kelas_kuliah_dosen_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	function json_riwayat_pengawasan()
	{
		$this->load->model('Arsip_riwayat_pengawasan_dosen_data_model');
	    
		$list = $this->Arsip_riwayat_pengawasan_dosen_data_model->get_datatables();
        $data = array();
        $no = $_GET['start'];
		
        foreach ($list as $field) {
			
			$no++;
            $row = array();
            
            $row[] = nama_smt($field->id_smt);
            $row[] = $field->nm_mk.' '.$field->nm_kls;
            $row[] = $field->inisial_fak.' '.$field->nama_prodi;
            $row[] = format_indo($field->tanggal).' '.$field->jam_mulai.' s/d '.$field->jam_selesai;
            
			$data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Arsip_riwayat_pengawasan_dosen_data_model->count_all(),
            "recordsFiltered" => $this->Arsip_riwayat_pengawasan_dosen_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
}