<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Ujian extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){redirect(base_url('logout'));}
		if($_SESSION['logged_in']==FALSE){ redirect (base_url('logout'));}
		$this->load->model(['Ujian_model','Dhmd_model','Krs_model']);
		$this->load->helper('security');
	}
	
	function soal($id_kelas_kuliah=null)
	{
		if($_SESSION['app_level']!=1){
		if($id_kelas_kuliah){
		$this->load->model('Krs_model');
		$kelas = $this->Krs_model->kelas_kuliah_mahasiswa_krs(null,null,$id_kelas_kuliah)->row();
		if($kelas){
			$data['kelas'] 		= $kelas;
			$data['title'] 		= 'Ujian '.$kelas->nm_mk.' '.$kelas->nm_kls;
			$data['content'] 	= 'ujian/soal';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function jawab($jenis_ujian=null,$id_kelas_kuliah=null,$id_mahasiswa_pt=null)
	{
		if($_SESSION['app_level']==1) $id_mahasiswa_pt =  $_SESSION['id_user'];
		if($id_kelas_kuliah && $jenis_ujian && $id_mahasiswa_pt){
		
		$id_mahasiswa_pt = xss_clean($id_mahasiswa_pt);
		$jenis_ujian = xss_clean($jenis_ujian);
		$id_kelas_kuliah = xss_clean($id_kelas_kuliah);
		$kelas = $this->Krs_model->kelas_kuliah_mahasiswa_krs(null,null,$id_kelas_kuliah)->row();
		
		if($kelas){
			
		if($_SESSION['app_level']==1){ 
			$check = $this->Dhmd_model->check_hak_mahasiswa($id_mahasiswa_pt,$id_kelas_kuliah)->row();
			if(!$check)
			{
				$this->session->set_flashdata('msg', 'Its Not Your Cup of Coffee!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('dashboard/');
			}
		}
		$bearer = ['id_mahasiswa_pt'=>$id_mahasiswa_pt];
		$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
		
		if($mahasiswa_pt){
		if($jenis_ujian == 'uas' || $jenis_ujian == 'uts') {
			$detail_pertemuan = $this->Dhmd_model->get_pertemuan_ujian($id_kelas_kuliah,$jenis_ujian)->row();
			$data['jawaban']	= $this->Ujian_model->check_jawaban($id_kelas_kuliah,strtoupper($jenis_ujian),$id_mahasiswa_pt);
			$data['pertemuan'] = $detail_pertemuan;
			$data['status_bayar'] = $this->Main_model->keuangan($jenis_ujian,$id_mahasiswa_pt,$kelas->id_smt);
			$data['jenis_ujian'] = $jenis_ujian;
			$data['mahasiswa_pt']= $mahasiswa_pt[0];
			$data['kelas'] 		= $kelas;
			$data['title'] 		= 'Detail Jawaban '.strtoupper($jenis_ujian).' '.$kelas->nm_mk.' '.$kelas->nm_kls;
			$data['content'] 	= 'ujian/jawab';
			$this->load->view('lyt/index',$data);
			
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function simpan_jawaban()
	{
		$id_mahasiswa_pt = $_SESSION['id_user'];
		$id_kelas_kuliah = $this->input->post('id_kelas_kuliah');
		$jenis_ujian = strtoupper($this->input->post('jenis_ujian'));
		$text_jawaban = xss_clean($this->input->post('text_jawaban'));
		
		/**---------------DISINI LOG UJIAN------------*/
		$proses = $this->Ujian_model->update_jawaban($id_kelas_kuliah,$jenis_ujian,$id_mahasiswa_pt,'text_jawaban',$text_jawaban);
		if($proses){
			$this->Ujian_model->simpan_log($id_kelas_kuliah,$jenis_ujian,$id_mahasiswa_pt,2);
			echo $nama_dokumen_show; 
		}else{ echo 0; }
	}
	
	function simpan_komentar()
	{
		$id_mahasiswa_pt = $this->input->post('id_mahasiswa_pt');
		$id_kelas_kuliah = $this->input->post('id_kelas_kuliah');
		$jenis_ujian = strtoupper($this->input->post('jenis_ujian'));
		$komentar_dosen = xss_clean($this->input->post('komentar_dosen'));
		
		/**---------------DISINI LOG UJIAN------------*/
		$proses = $this->Ujian_model->update_jawaban($id_kelas_kuliah,$jenis_ujian,$id_mahasiswa_pt,'komentar_dosen',$komentar_dosen);
		if($proses){
			$this->Ujian_model->simpan_log($id_kelas_kuliah,$jenis_ujian,$id_mahasiswa_pt,5);
			echo 1; 
		}else{ echo 0; }
	}
	
	function update_nilai()
	{
		$id_mahasiswa_pt = $this->input->post('id_mahasiswa_pt');
		$id_kelas_kuliah = $this->input->post('id_kelas_kuliah');
		$id_nilai = $this->input->post('id_nilai');
		$nilai = $this->input->post('nilai');
		$jenis_ujian = strtoupper($this->input->post('jenis_ujian'));
		
		/**---------------DISINI LOG UJIAN------------*/
		$proses = $this->Ujian_model->update_nilai($id_nilai,$jenis_ujian,$nilai);
		if($proses){
			$this->Ujian_model->simpan_log($id_kelas_kuliah,$jenis_ujian,$id_mahasiswa_pt,4);
			echo 1; 
		}else{ echo 0; }
	}
	
	function unggah_gambar()
	{
		$id_mahasiswa_pt = $_SESSION['id_user'];
		$id_kelas_kuliah = $this->input->post('id_kelas_kuliah');
		$jenis_ujian = strtoupper($this->input->post('jenis_ujian'));
		
		if(isset($_FILES['file']['name']))
		{
			$nama_dokumen = $id_kelas_kuliah.'-img-'.$jenis_ujian.'-'.$_SESSION['id_user'];
			$simpan_file = $this->Main_model->unggah_dokumen($nama_dokumen,'./dokumen/ujian_img/','*','file');
			if($simpan_file)
			{
				$nama_dokumen=base_url('dokumen/ujian_img/'.$simpan_file['upload_data']['file_name']);
				$this->Ujian_model->simpan_log($id_kelas_kuliah,$jenis_ujian,$id_mahasiswa_pt,6);
				$data=array('location' =>$nama_dokumen ,'status'=> 'success');
				
			}else{ 
				$data=array('message' =>'upload failed' ,'status'=> 'error');
			}
		}else{
			$data=array('message' =>'no image' ,'status'=> 'error');
		}
		
		echo json_encode($data, JSON_HEX_APOS | JSON_HEX_QUOT);
	}
	
	function simpan_file_jawaban()
	{
		$id_mahasiswa_pt = $_SESSION['id_user'];
		$id_kelas_kuliah = $this->input->post('id_kelas_kuliah');
		$jenis_ujian = strtoupper($this->input->post('jenis_ujian'));
		
		if(isset($_FILES['file_jawaban']['name']))
		{
			$nama_dokumen = $id_kelas_kuliah.'-'.$jenis_ujian.'-'.$_SESSION['id_user'];
			$simpan_file = $this->Main_model->unggah_dokumen($nama_dokumen,'./dokumen/ujian/','*','file_jawaban');
			if($simpan_file)
			{
				$nama_dokumen_show=$simpan_file['upload_data']['file_name'];
				$nama_dokumen=base_url('dokumen/ujian/'.$simpan_file['upload_data']['file_name']);
				$proses = $this->Ujian_model->update_jawaban($id_kelas_kuliah,$jenis_ujian,$id_mahasiswa_pt,'file_jawaban',$nama_dokumen);
				if($proses){
					$this->Ujian_model->simpan_log($id_kelas_kuliah,$jenis_ujian,$id_mahasiswa_pt,3);
					echo $nama_dokumen_show; 
				}else{ echo 0; }
			}else{ echo 0; }
		}else{ echo 0; }
	}
	
	function simpan_soal()
	{
		if($_SESSION['app_level']==2){
		$id_kelas_kuliah = $this->input->post('id_kelas_kuliah');
		$jenis_ujian = strtoupper($this->input->post('jenis_ujian'));
		if(isset($_FILES['dokumen_soal']['name']))
		{
			$nama_dokumen = $id_kelas_kuliah.'-'.$jenis_ujian.'-'.md5('f276f8fc49738268dab269c0a8a7215e-20220922004025'.date("Y-m-d H:i:s"));
			$simpan_file = $this->Main_model->unggah_dokumen($nama_dokumen,'./dokumen/ujian/','pdf','dokumen_soal');
			if($simpan_file)
			{
				$nama_dokumen=base_url('dokumen/ujian/'.$simpan_file['upload_data']['file_name']);
				$proses = $this->Ujian_model->simpan_soal($id_kelas_kuliah,$jenis_ujian,$nama_dokumen);
				if($proses){ 
				$whythis='simpan_soal';
				$whatdo='#id_kelas_kuliah:'.$id_kelas_kuliah.'#jenis_ujian:'.$jenis_ujian;
				$this->Main_model->akademik_log($whythis,$whatdo);
				echo 1; 
				}else{ echo 2; }
			}else{ echo 3; }
		}else{ echo 4; }
		}else{ echo 5; }
	}

}