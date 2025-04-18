<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Berita extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){redirect(base_url('logout'));}
		if($_SESSION['logged_in']==FALSE){ redirect (base_url('logout'));}
    }
	
	function baca($id_berita=null)
	{
		if($id_berita){
	        $lempar = base64_decode($id_berita);
	        $berita = $this->Main_model->get_berita($lempar,'1',1)->row();
	        if($berita){
    	        $data['title'] 	= $berita->judul_berita;
    	        $data['berita'] 	= $berita;
    		    $data['content'] 	= 'berita/baca';
    		    $this->load->view('lyt/index',$data);
	        }
		}
	}
	
	function buat_v3()
	{
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		    $data['title'] 		= 'Buat Berita';
			$data['content'] 	= 'berita/buat';
			$this->load->view('lyt/index',$data);
		}
	}
	
	function buat()
	{
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
			$data['head']	= array(
							'<link href="'.base_url('assets/plugins/summernote-0.8.20/dist/summernote-lite.min.css').'" rel="stylesheet">',
							'',
							''
							);
			$data['footer']	= array(
		                    '<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>',
							'<script src="'.base_url('assets/plugins/summernote-0.8.20/dist/summernote-lite.min.js').'"></script>',
							'<script src="'.base_url('assets/js/berita.js').'"></script>',
							);
		    $data['title'] 		= 'Buat Berita';
			$data['content'] 	= 'berita/buat_v2';
			$this->load->view('lyt/index',$data);
		}
	}
	
	function simpan()
	{
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		    $data=array(
    		    'isi_berita' => $this->input->post('isi_berita',true),
    		    'judul_berita' => $this->input->post('judul_berita',true),
    		    'expired_at' => $this->input->post('expired_at'),
    		    'pembuat_berita' => $this->input->post('pembuat_berita',true)
		    );
		    $proses = $this->Main_model->simpan_berita($data);
			if($proses)
			{
			    $lempar = str_replace('=','',base64_encode($proses));
			
				$whythis='simpan_berita';
				$whatdo='#id_berita:'.$proses;
				$this->Main_model->akademik_log($whythis,$whatdo);
				
				$this->session->set_flashdata('msg', 'Data Tersimpan!');
				$this->session->set_flashdata('msg_clr', 'success');
				redirect('berita/baca/'.$lempar);
			}else{
				$this->session->set_flashdata('msg', 'Gagal Tersimpan!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('berita/buat');
			}
		}
	}
	
	function hapus($id_berita)
	{
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		    $proses = $this->Main_model->hapus_berita($id_berita);
			if($proses)
			{
			    $whythis='hapus_berita';
				$whatdo='#id_berita:'.$id_berita;
				$this->Main_model->akademik_log($whythis,$whatdo);
				
				$this->session->set_flashdata('msg', 'Data Terhapus!');
				$this->session->set_flashdata('msg_clr', 'success');
				redirect('berita/');
			}else{
				$this->session->set_flashdata('msg', 'Gagal Terhapus!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('berita/');
			}
		}
	}
	
	
	function index()
	{
		$data['title'] 		= 'Daftar Berita';
		$data['content'] 	= 'berita/index';
		$this->load->view('lyt/index',$data);
	}
	
	function unggah_gambar()
	{
		if(isset($_FILES['file']['name']))
		{
			$nama_dokumen = $_SESSION['username'];
			$simpan_file = $this->Main_model->unggah_dokumen($nama_dokumen,'./dokumen/berita/','*','file');
			if($simpan_file)
			{
				$nama_dokumen=base_url('dokumen/berita/'.$simpan_file['upload_data']['file_name']);
				$data=array('location' =>$nama_dokumen ,'status'=> 'success');
				
			}else{ 
				$data=array('message' =>'upload failed' ,'status'=> 'error');
			}
		}else{
			$data=array('message' =>'no image' ,'status'=> 'error');
		}
		
		echo json_encode($data, JSON_HEX_APOS | JSON_HEX_QUOT);
	}
	
	function unggah_gambar_v2()
	{
		if(isset($_FILES['file']['name']))
		{
			$nama_dokumen = $_SESSION['username'];
			$simpan_file = $this->Main_model->unggah_dokumen($nama_dokumen,'./dokumen/berita/','*','file');
			if($simpan_file)
			{
				echo base_url('dokumen/berita/'.$simpan_file['upload_data']['file_name']);
			}else{ 
				echo 'https://cdn.presslabs.com/wp-content/uploads/2018/10/upload-error.png';
			}
		}else{
			echo 'https://cdn.presslabs.com/wp-content/uploads/2018/10/upload-error.png';
		}
		
	}
}