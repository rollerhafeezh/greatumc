<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Gedung extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){redirect(base_url('logout'));}
		if($_SESSION['logged_in']==FALSE){ redirect (base_url('logout'));}
		
		$this->load->model('Gedung_model');
		$this->load->helper('security');
	}
	
	function index()
	{
		if($_SESSION['app_level']!=1){
			$data['gedung']		= $this->Gedung_model->get_gedung()->result();
			$data['title'] 		= 'Data Gedung';
			$data['content'] 	= 'gedung/tabel';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function detail($id_gedung=null)
	{
		if($_SESSION['app_level']!=1){
		if($id_gedung){
		$gedung = $this->Gedung_model->get_gedung($id_gedung)->row();
		if($gedung){
			$data['gedung']		= $gedung;
			$data['ruangan']	= $this->Gedung_model->get_ruangan(null,$id_gedung)->result();
			$data['title'] 		= 'Detail Gedung '.$gedung->nama_gedung;
			$data['content'] 	= 'gedung/detail';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function ganti_status_gedung($id_gedung,$statuss)
    {
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		
		$status     =($statuss==1)?'0':'1';
		
		$data = array('id_gedung'=>$id_gedung,'status_gedung'=>$status);
		
		$simpan = $this->Gedung_model->ganti_status_gedung($data);
		
		if($simpan)
		{
		    $whythis='ganti_status_gedung';
		    $whatdo='#id_gedung:'.$id_gedung.'#status_gedung:'.$status;
		    $this->Main_model->akademik_log($whythis,$whatdo);
		    
			$this->session->set_flashdata('msg', 'Berhasil!');
			$this->session->set_flashdata('msg_clr', 'success');
		    redirect('gedung/');
		}else{
		    $this->session->set_flashdata('msg', 'Gagal');
			$this->session->set_flashdata('msg_clr', 'success');
		    redirect('gedung/');
		}
		
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
    }
	
	function ganti_nama_gedung($id_gedung,$nama_gedung)
    {
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		$nama_gedung = xss_clean($nama_gedung);
		
		$data = array('id_gedung'=>$id_gedung,'nama_gedung'=>$nama_gedung);
		
		$simpan = $this->Gedung_model->ganti_nama_gedung($data);
		
		if($simpan)
		{
		    $whythis='ganti_nama_gedung';
		    $whatdo='#id_gedung:'.$id_gedung.'#nama_gedung:'.$nama_gedung;
		    $this->Main_model->akademik_log($whythis,$whatdo);
		    
			echo 1;
		}else{
		    echo 0;
		}
		
		}else { echo 0; }
    }
	
	function ganti_nama_ruangan($id_ruangan,$nama_ruangan)
    {
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		$nama_ruangan = xss_clean($nama_ruangan);
		
		$data = array('id_ruangan'=>$id_ruangan,'nama_ruangan'=>$nama_ruangan);
		
		$simpan = $this->Gedung_model->ganti_nama_ruangan($data);
		
		if($simpan)
		{
		    $whythis='ganti_nama_ruangan';
		    $whatdo='#id_ruangan:'.$id_ruangan.'#nama_ruangan:'.$nama_ruangan;
		    $this->Main_model->akademik_log($whythis,$whatdo);
		    
			echo 1;
		}else{
		    echo 0;
		}
		
		}else { echo 0; }
    }
	
	function ganti_status_ruangan($id_gedung,$id_ruangan,$statuss)
    {
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		
		$status     =($statuss==1)?'0':'1';
		
		$data = array('id_ruangan'=>$id_ruangan,'status_ruangan'=>$status);
		
		$simpan = $this->Gedung_model->ganti_status_ruangan($data);
		
		if($simpan)
		{
		    $whythis='ganti_status_ruangan';
		    $whatdo='#id_ruangan:'.$id_ruangan.'#status_ruangan:'.$status;
		    $this->Main_model->akademik_log($whythis,$whatdo);
		    
			$this->session->set_flashdata('msg', 'Berhasil!');
			$this->session->set_flashdata('msg_clr', 'success');
		    redirect('gedung/detail/'.$id_gedung);
		}else{
		    $this->session->set_flashdata('msg', 'Gagal');
			$this->session->set_flashdata('msg_clr', 'success');
		    redirect('gedung/detail/'.$id_gedung);
		}
		
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
    }
	
	function simpan_gedung()
	{
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
			$data=[
				'nama_gedung'=>$this->input->post('nama_gedung'),
				'lokasi_gedung'=>($this->input->post('lokasi_gedung'))?:NULL,
				'ket_gedung'=>($this->input->post('ket_gedung'))?:NULL,
			];
			$id_kur = $this->Gedung_model->simpan_gedung($data);
			if($id_kur)
			{
				$whythis='simpan_gedung';
				$whatdo='#id_gedung:'.$id_kur.'#nama_gedung:'.$this->input->post('nama_gedung');
				$this->Main_model->akademik_log($whythis,$whatdo);
				
				$this->session->set_flashdata('msg', 'Data Tersimpan!');
				$this->session->set_flashdata('msg_clr', 'success');
				redirect('gedung/detail/'.$id_kur);
			}else{
				$this->session->set_flashdata('msg', 'Gagal Tersimpan!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('gedung/index');
			}
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function simpan_ruangan()
	{
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
			$data=[
				'id_gedung'=>$this->input->post('id_gedung'),
				'nama_ruangan'=>$this->input->post('nama_ruangan'),
				'daya_kuliah'=>($this->input->post('daya_kuliah'))?:NULL,
				'daya_ujian'=>($this->input->post('daya_ujian'))?:NULL,
				'ket_ruangan'=>($this->input->post('ket_ruangan'))?:NULL,
				'tingkat_ruangan'=>($this->input->post('tingkat_ruangan'))?:NULL,
			];
			$id_kur = $this->Gedung_model->simpan_ruangan($data);
			if($id_kur)
			{
				$whythis='simpan_ruangan';
				$whatdo='#id_ruangan:'.$id_kur.'#id_gedung:'.$this->input->post('id_gedung').'#nama_ruangan:'.$this->input->post('nama_ruangan');
				$this->Main_model->akademik_log($whythis,$whatdo);
				
				$this->session->set_flashdata('msg', 'Data Tersimpan!');
				$this->session->set_flashdata('msg_clr', 'success');
				redirect('gedung/detail/'.$this->input->post('id_gedung'));
			}else{
				$this->session->set_flashdata('msg', 'Gagal Tersimpan!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('gedung/detail/'.$this->input->post('id_gedung'));
			}
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
}