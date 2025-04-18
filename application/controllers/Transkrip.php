<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Transkrip extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){redirect(base_url('logout'));}
		if(!isset($_SESSION['id_user'])){redirect(base_url('logout'));}
		if($_SESSION['logged_in']==FALSE){ redirect (base_url('logout'));}
		$this->load->model('Transkrip_model');
		$this->load->helper('security');
	}

    function index($id_mahasiswa_pt=null)
	{
		if($_SESSION['app_level']==1) $id_mahasiswa_pt =  $_SESSION['id_user'];
		if($id_mahasiswa_pt){
		$id_mahasiswa_pt = xss_clean($id_mahasiswa_pt);
		
		$bearer = ['id_mahasiswa_pt'=>$id_mahasiswa_pt];
		$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
		if($mahasiswa_pt){
		
		$data['mahasiswa_pt'] 	= $mahasiswa_pt[0];
		$data['title'] 		= 'Transkrip Mahasiswa '.$mahasiswa_pt[0]->nm_pd;
		$data['content'] 	= 'transkrip/index';
		$this->load->view('lyt/index',$data);
		
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function transkrip($id_kur=null,$id_mahasiswa_pt=null)
	{
	    if($_SESSION['app_level']==1) $id_mahasiswa_pt =  $_SESSION['id_user'];
		if($id_mahasiswa_pt && $id_kur){
		$id_mahasiswa_pt = xss_clean($id_mahasiswa_pt);
		$id_kur = xss_clean($id_kur);
		
		$bearer = ['id_mahasiswa_pt'=>$id_mahasiswa_pt];
		$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
		if($mahasiswa_pt){
		
		$data['id_kur'] 	= $id_kur;
		$data['mahasiswa_pt'] 	= $mahasiswa_pt[0];
		$this->load->view('transkrip/transkrip',$data);
		
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function khs($id_kur=null,$id_mahasiswa_pt=null)
	{
	    if($_SESSION['app_level']==1) $id_mahasiswa_pt =  $_SESSION['id_user'];
		if($id_mahasiswa_pt && $id_kur){
		$id_mahasiswa_pt = xss_clean($id_mahasiswa_pt);
		$id_kur = xss_clean($id_kur);
		
		$bearer = ['id_mahasiswa_pt'=>$id_mahasiswa_pt];
		$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
		if($mahasiswa_pt){
		
		$nilai = $this->Transkrip_model->transkrip($id_kur,$id_mahasiswa_pt)->result();
		$kurikulum = $this->Transkrip_model->khs($id_mahasiswa_pt,$id_kur);
		$_SESSION['nilai_temp']=array();
		foreach ($nilai as $key => $value) {
			$_SESSION['nilai_temp'][$value->id_matkul]=$value->nilai_indeks;
		}
		
		$data['mahasiswa_pt'] 	= $mahasiswa_pt[0];
		$data['kurikulum']	=$kurikulum;
		$this->load->view('transkrip/khs',$data);
		unset($_SESSION['nilai_temp']);
		
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function konversi($id_kur=null,$id_mahasiswa_pt=null)
	{
	    if($_SESSION['app_level']==1) $id_mahasiswa_pt =  $_SESSION['id_user'];
		if($id_mahasiswa_pt && $id_kur){
		$id_mahasiswa_pt = xss_clean($id_mahasiswa_pt);
		$id_kur = xss_clean($id_kur);
		
		$bearer = ['id_mahasiswa_pt'=>$id_mahasiswa_pt];
		$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
		if($mahasiswa_pt){
		
		$data['id_kur'] 	= $id_kur;
		$data['mahasiswa_pt'] 	= $mahasiswa_pt[0];
		$this->load->view('transkrip/konversi',$data);
		
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function transkrip_all($id_kur=null,$id_mahasiswa_pt=null)
	{
	    if($_SESSION['app_level']==1) $id_mahasiswa_pt =  $_SESSION['id_user'];
		if($id_mahasiswa_pt && $id_kur){
		$id_mahasiswa_pt = xss_clean($id_mahasiswa_pt);
		$id_kur = xss_clean($id_kur);
		
		$bearer = ['id_mahasiswa_pt'=>$id_mahasiswa_pt];
		$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
		if($mahasiswa_pt){
		
		$data['id_kur'] 	= $id_kur;
		$data['mahasiswa_pt'] 	= $mahasiswa_pt[0];
		$this->load->view('transkrip/transkrip_all',$data);
		
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

    
}