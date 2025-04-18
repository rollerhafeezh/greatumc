<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Persepsi extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){redirect(base_url('logout'));}
		if($_SESSION['logged_in']==FALSE){ redirect (base_url('logout'));}
		$this->load->model(['Dhmd_model','Krs_model','Persepsi_model']);
		$this->load->helper('security');
	}

    function index($id_kelas_kuliah=null,$id_mahasiswa_pt=null)
	{
		if($id_kelas_kuliah && $id_mahasiswa_pt){
		
		$id_kelas_kuliah = xss_clean($id_kelas_kuliah);
		
		/*-----------BATASAN MAHASISWA----------------*/
		$id_mahasiswa_pt = ($_SESSION['app_level']==1)?$_SESSION['id_user']:$id_mahasiswa_pt;
		$id_mahasiswa_pt = xss_clean($id_mahasiswa_pt);
		
		if($_SESSION['app_level']==1){ 
			$check = $this->Dhmd_model->check_hak_mahasiswa($id_mahasiswa_pt,$id_kelas_kuliah)->row();
			if(!$check)
			{
				$this->session->set_flashdata('msg', 'Its Not Your Cup of Coffee!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('dashboard/');
			}
		}
		/*-----------BATASAN MAHASISWA----------------*/
		
		/*---CEK ID INSTRUMEN KELAS
		JADI SETIAP KELAS AKAN DIBERIKAN ID INSTRUMEN DARI yang pertama kali membuka, dan ini berlaku surut!
		----*/
		$id_instrumen = $this->Persepsi_model->get_id_instrumen_kelas($id_kelas_kuliah);
		$id_responden = $this->Persepsi_model->get_id_responden($id_kelas_kuliah,$id_mahasiswa_pt,$id_instrumen);
		
		redirect('persepsi/isi/'.$id_responden);
		
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function tambah_pertanyaan()
	{
	    if($_SESSION['app_level']!=1){
		$variabel = $this->input->post('variabel',true);
		$text_pertanyaan = $this->input->post('text_pertanyaan',true);
		$skala_min = $this->input->post('skala_min',true);
		$skala_maks = $this->input->post('skala_maks',true);
		$id_instrumen = $this->input->post('id_instrumen',true);
		
		$data = [	'variabel'=>$variabel,
					'text_pertanyaan'=>$text_pertanyaan,
					'skala_min'=>$skala_min,
					'skala_maks'=>$skala_maks,
					'id_instrumen'=>$id_instrumen,
				];
		$proses = $this->Persepsi_model->tambah_pertanyaan($data);
		
		$whythis='tambah_pertanyaan';
    	$whatdo='#id_instrumen:'.$id_instrumen;
    	$this->Main_model->akademik_log($whythis,$whatdo);
		
		//$proses = $this->Persepsi_model->update_detail_persepsi($id_pertanyaan,$kolom,$isi);
		if($proses) echo 1; else echo 0; 
		}else{
		    echo 0;
		}
	}
	
	function update_detail_persepsi()
	{
		if($_SESSION['app_level']!=1){
		$isi = $this->input->post('isi',true);
		$kolom = $this->input->post('kolom',true);
		$id_pertanyaan = $this->input->post('id_pertanyaan',true);
		
		$whythis='update_detail_persepsi';
    	$whatdo='#id_pertanyaan:'.$id_pertanyaan.'#kolom:'.$kolom.'#isi:'.$isi;
    	$this->Main_model->akademik_log($whythis,$whatdo);
		
		$proses = $this->Persepsi_model->update_detail_persepsi($id_pertanyaan,$kolom,$isi);
		if($proses) echo 1; else echo 0; 
		}else{
		    echo 0;
		}
	}
	
	function hasil($id_kelas_kuliah=null)
	{
		if($_SESSION['app_level']!=1){ 
		if($id_kelas_kuliah){
		
		$id_kelas_kuliah = xss_clean($id_kelas_kuliah);
		$this->Persepsi_model->hitung_skor_persepsi($id_kelas_kuliah);
		$kelas = $this->Krs_model->kelas_kuliah_mahasiswa_krs(null,null,$id_kelas_kuliah)->row();
		if($kelas){
		    $data['distinct_pertanyaan'] = $this->Persepsi_model->distinct_pertanyaan($kelas->id_instrumen)->result();
		    $data['responden'] = $this->Persepsi_model->get_responden(null,$id_kelas_kuliah)->result(); 
			$data['kelas'] 		= $kelas;
			$data['title'] 		= 'Persepsi Mahasiswa Terhadap '.$kelas->nm_mk.' '.$kelas->nm_kls.' '.nama_smt($kelas->id_smt);
			$data['content'] 	= 'persepsi/hasil';
			$this->load->view('lyt/index_2',$data);
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function isi($id_responden=null)
	{
		if($id_responden){
		
		$id_responden = xss_clean($id_responden);
		
		$detail = $this->Persepsi_model->get_responden($id_responden)->row();
		if($detail){
		
		/*-----------BATASAN MAHASISWA----------------*/
		$id_mahasiswa_pt = ($_SESSION['app_level']==1)?$_SESSION['id_user']:$detail->id_mahasiswa_pt;
		$id_kelas_kuliah = $detail->id_kelas_kuliah;
		
		if($_SESSION['app_level']==1){ 
			$check = $this->Dhmd_model->check_hak_mahasiswa($id_mahasiswa_pt,$id_kelas_kuliah)->row();
			if(!$check)
			{
				$this->session->set_flashdata('msg', 'Its Not Your Cup of Coffee!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('dashboard/');
			}
		}
		/*-----------BATASAN MAHASISWA----------------*/    
		    
		$bearer = ['id_mahasiswa_pt'=>$id_mahasiswa_pt];
		$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
		
		$kelas = $this->Krs_model->kelas_kuliah_mahasiswa_krs(null,null,$id_kelas_kuliah)->row();
		if($kelas && $mahasiswa_pt){
			$data['mahasiswa_pt'] = $mahasiswa_pt[0];
			$data['kelas'] 		= $kelas;
			$data['detail'] 		= $detail;
			$data['title'] 		= 'Persepsi Mahasiswa Terhadap '.$kelas->nm_mk.' '.$kelas->nm_kls.' '.nama_smt($kelas->id_smt);
			$data['content'] 	= 'persepsi/isi';
			$this->load->view('lyt/index_2',$data);
		
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function simpan($id_responden=null)
	{
		if($id_responden){
		
		$id_responden = xss_clean($id_responden);
		
		$detail = $this->Persepsi_model->get_responden($id_responden)->row();
		if($detail){
		
		/*-----------BATASAN MAHASISWA----------------*/
		$id_mahasiswa_pt = ($_SESSION['app_level']==1)?$_SESSION['id_user']:$detail->id_mahasiswa_pt;
		$id_kelas_kuliah = $detail->id_kelas_kuliah;
		
		if($_SESSION['app_level']==1){ 
			$check = $this->Dhmd_model->check_hak_mahasiswa($id_mahasiswa_pt,$id_kelas_kuliah)->row();
			if(!$check)
			{
				$this->session->set_flashdata('msg', 'Its Not Your Cup of Coffee!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('dashboard/');
			}
		}
		/*-----------BATASAN MAHASISWA----------------*/  
		
		$pertanyaan = $this->Persepsi_model->get_pertanyaan($detail->id_instrumen)->result();
		$data_respon = [];

        foreach ($pertanyaan as $value) {

			$id = $value->id_pertanyaan;
			array_push(
				$data_respon,
				[
					'id_responden'          => $id_responden,
					'id_kelas_kuliah'       => $id_kelas_kuliah,
					'id_pertanyaan'         => $id,
					'nilai'                 => $this->input->post($id),

				]
			);
		}

		$respon=$this->Persepsi_model->save_respon($data_respon);
		if($this->input->post('pesan_moral')){
			$data_respon_teks =
				[
					'id_responden'          => $id_responden,
					'id_kelas_kuliah'       => $id_kelas_kuliah,
					'pesan_moral'           => $this->input->post('pesan_moral',true)
				];

			$this->Persepsi_model->save_respon_text($data_respon_teks);
		}
		
		if($respon)
		{
		    $this->Persepsi_model->hitung_skor_persepsi($id_kelas_kuliah);
		    $this->Persepsi_model->update_isi_persepsi($id_mahasiswa_pt,$id_kelas_kuliah);
		    
			$this->session->set_flashdata('msg', 'Terima Kasih!');
			$this->session->set_flashdata('msg_clr', 'success');
			$whythis='simpan_persepsi';
			$whatdo='#id_responden:'.$id_responden.'#id_kelas_kuliah:'.$id_kelas_kuliah;
			$this->Main_model->akademik_log($whythis,$whatdo);
		}else{
			$this->session->set_flashdata('msg', 'Gagal!');
			$this->session->set_flashdata('msg_clr', 'danger');
		}
			redirect('dhmd/daftar_pertemuan/'.$id_kelas_kuliah);
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function hitung_skor_persepsi($id_kelas_kuliah)
	{
	    $this->Persepsi_model->hitung_skor_persepsi($id_kelas_kuliah);
	}
	
	function ulangi($id_responden=null)
	{
		if($id_responden){
		
		$id_responden = xss_clean($id_responden);
		
		$detail = $this->Persepsi_model->get_responden($id_responden)->row();
		if($detail){
		
		/*-----------BATASAN MAHASISWA----------------*/
		$id_mahasiswa_pt = ($_SESSION['app_level']==1)?$_SESSION['id_user']:$detail->id_mahasiswa_pt;
		$id_kelas_kuliah = $detail->id_kelas_kuliah;
		
		if($_SESSION['app_level']==1){ 
			$check = $this->Dhmd_model->check_hak_mahasiswa($id_mahasiswa_pt,$id_kelas_kuliah)->row();
			if(!$check)
			{
				$this->session->set_flashdata('msg', 'Its Not Your Cup of Coffee!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('dashboard/');
			}
		}
		/*-----------BATASAN MAHASISWA----------------*/    
		$respon=$this->Persepsi_model->delete_respon($id_responden);
		$respon_text=$this->Persepsi_model->delete_respon_text($id_responden);
		
		if($respon)
		{
		    $this->Persepsi_model->hitung_skor_persepsi($id_kelas_kuliah);
		    
			$this->session->set_flashdata('msg', 'Berhasil!');
			$this->session->set_flashdata('msg_clr', 'success');
			$whythis='hapus_persepsi';
			$whatdo='#id_responden:'.$id_responden.'#id_kelas_kuliah:'.$id_kelas_kuliah;
			$this->Main_model->akademik_log($whythis,$whatdo);
		}else{
			$this->session->set_flashdata('msg', 'Gagal!');
			$this->session->set_flashdata('msg_clr', 'danger');
		}
		redirect('persepsi/isi/'.$id_responden);
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
}