<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Beranda extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		/*$data['title']	 = 'Beranda';
		$data['content'] = 'beranda/index';
		$this->load->view('lyt/index_2',$data);*/
		redirect('beranda/kurikulum');
	}
	
	function rps($id_matkul=null)
	{
		if($id_matkul)
		{
		
		$id_matkul = xss_clean($id_matkul);
		
		$lempar = base64_decode($id_matkul);
		$rps = $this->Main_model->get_rps($lempar,null,1)->row();
		if($rps){
		$this->load->model('Matkul_model');
		$matkul = $this->Matkul_model->get_matkul($rps->id_matkul)->row();
		$data['rps'] 		= $rps;
		$data['matkul'] 	= $matkul;
		$data['title'] 		= 'Rancangan Pembelajaran Semester '.$matkul->nm_mk.' '.$matkul->nama_prodi;
		$data['content'] = 'beranda/rps';
		$this->load->view('lyt/index_2',$data);
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index_2',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index_2',$data); }
	}
	
	function kurikulum_detail($id_kur=null)
	{
		if($id_kur)
		{
		    $id_kur = xss_clean($id_kur);
		$lempar = base64_decode($id_kur);
		$kurikulum = $this->Main_model->get_kurikulum($lempar,1)->row();
		$this->load->model('Kurikulum_model');
		$mk = $this->Kurikulum_model->get_mata_kuliah_kurikulum($lempar)->result();
		if($kurikulum && $mk){
		$data['mk'] 		= $mk;
		$data['kurikulum'] 	= $kurikulum;
		$data['title'] 		= 'Detail Kurikulum '.$kurikulum->nm_kurikulum_sp;
		$data['content'] = 'beranda/kurikulum_detail';
		$this->load->view('lyt/index_2',$data);
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index_2',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index_2',$data); }
	}
	
	function kurikulum()
	{
		$kurikulum = $this->Main_model->get_kurikulum(null,1)->result();
		if($kurikulum){
		$data['kurikulum'] 	= $kurikulum;
		$data['title'] 		= 'Daftar Kurikulum Aktif ';
		$data['content'] = 'beranda/kurikulum';
		$this->load->view('lyt/index_2',$data);
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index_2',$data); }
	}
	
}