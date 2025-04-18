<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Matkul extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){redirect(base_url('logout'));}
		if($_SESSION['logged_in']==FALSE){ redirect (base_url('logout'));}
		
		$this->load->model('Matkul_model');
	}
	
	function index()
	{
		if($_SESSION['app_level']!=1){
			$data['title'] 		= 'Daftar Mata Kuliah';
			$data['content'] 	= 'matkul/tabel';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function add()
	{
		$check = $this->Main_model->get_konfigurasi('buat_matkul')->row();
		if($check->value_konfigurasi=='on'){
		if($_SESSION['app_level']==3 or $_SESSION['app_level']==4){
			$data['title'] 		= 'Buat Mata Kuliah';
			$data['ref_kategori_mk'] 	= $this->Main_model->ref_kategori_mk();
			$data['ref_jenis_mk'] 	= $this->Main_model->ref_jenis_mk();
			$data['content'] 	= 'matkul/add';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Tutup';	$data['content'] = 'lyt/pesan'; $data['pesan'] = '<span class="text-danger h3">Pembuatan mata Kuliah di tutup. Hubungi Akademik Universitas.</span>';	$this->load->view('lyt/index',$data); }
	}
	
	function detail($id_matkul=null)
	{
		if($_SESSION['app_level']!=1){
		if($id_matkul){
		$matkul = $this->Matkul_model->get_matkul($id_matkul)->row();
		$check_nilai = $this->Matkul_model->check_nilai($id_matkul);
		if($matkul){
			$data['check_nilai']= $check_nilai;
			$data['matkul'] 	= $matkul;
			$data['ref_jenis_mk'] 	= $this->Main_model->ref_jenis_mk();
			$data['ref_kategori_mk'] 	= $this->Main_model->ref_kategori_mk();
			$data['title'] 		= 'Detail mata Kuliah '.$matkul->nm_mk;
			$data['content'] 	= 'matkul/detail';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function hapus_matkul($id_matkul=null)
	{
		if($_SESSION['app_level']==3 or $_SESSION['app_level']==4){
		if($id_matkul){
		
		$check_nilai = $this->Matkul_model->check_nilai($id_matkul);
		$check_kelas = $this->Matkul_model->check_kelas($id_matkul);
		if(!$check_nilai && !$check_kelas){
			//$proses=true;
			$proses = $this->Matkul_model->hapus_matkul($id_matkul);
			if($proses)
			{
				$whythis='hapus_matkul';
				$whatdo='#id_matkul:'.$id_matkul;
				$this->Main_model->akademik_log($whythis,$whatdo);
				
				$this->session->set_flashdata('msg', 'Data Berhasil dihapus!');
				$this->session->set_flashdata('msg_clr', 'success');
				redirect('matkul/');
			}else{
				$this->session->set_flashdata('msg', 'Gagal Diproses!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('matkul/detail/'.$id_matkul);
			}
		}else{ 
			$this->session->set_flashdata('msg', 'Mata Kuliah ini sudah terdapat Nilai atau Kelas!');
			$this->session->set_flashdata('msg_clr', 'danger');
			redirect('matkul/detail/'.$id_matkul);
		}
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function update_matkul($id_matkul)
	{
		if($_SESSION['app_level']==3 or $_SESSION['app_level']==4){
		if($id_matkul){
		$matkul_ = $this->Matkul_model->get_matkul($id_matkul)->row();
		if($matkul_){
			$matkul = array(
				'kode_mk'		=>htmlentities($this->input->post('kode_mk')),
				'nm_mk'			=>htmlentities($this->input->post('nm_mk')),
				'nm_mk_en'		=>htmlentities($this->input->post('nm_mk_en')),
				'jns_mk'		=>htmlentities($this->input->post('jns_mk')),
				'id_kat_mk'		=>htmlentities($this->input->post('id_kat_mk')),
				'id_matkul'		=>$id_matkul,
				'sks_mk'		=>$this->input->post('sks_mk'),
				'sks_tm'		=>$this->input->post('sks_tm'),
				'sks_prak'		=>$this->input->post('sks_prak'),
				'sks_prak_lap'	=>$this->input->post('sks_prak_lap'),
				'sks_sim'		=>$this->input->post('sks_sim')
			);
			$proses = $this->Matkul_model->update_matkul($matkul);
			if($proses)
			{
				$whythis='update_matkul';
				$whatdo='#id_matkul:'.$id_matkul;
				$this->Main_model->akademik_log($whythis,$whatdo);
				
				$this->session->set_flashdata('msg', 'Data Tersimpan!');
				$this->session->set_flashdata('msg_clr', 'success');
				redirect('matkul/detail/'.$id_matkul);
			}else{
				$this->session->set_flashdata('msg', 'Gagal Tersimpan!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('matkul/detail/'.$id_matkul);
			}
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function simpan_matkul()
	{
		if($_SESSION['app_level']==3 or $_SESSION['app_level']==4){
			$matkul = array(
				'kode_mk'		=>htmlentities($this->input->post('kode_mk')),
				'nm_mk'			=>htmlentities($this->input->post('nm_mk')),
				'nm_mk_en'		=>htmlentities($this->input->post('nm_mk_en')),
				'jns_mk'		=>htmlentities($this->input->post('jns_mk')),
				'id_kat_mk'		=>htmlentities($this->input->post('id_kat_mk')),
				'kode_prodi'	=>$this->input->post('kode_prodi'),
				'sks_mk'		=>$this->input->post('sks_mk'),
				'sks_tm'		=>$this->input->post('sks_tm'),
				'sks_prak'		=>$this->input->post('sks_prak'),
				'sks_prak_lap'	=>$this->input->post('sks_prak_lap'),
				'sks_sim'		=>$this->input->post('sks_sim')
			);
			$proses = $this->Matkul_model->simpan_matkul($matkul);
			if($proses)
			{
				$whythis='simpan_matkul';
				$whatdo='#id_matkul:'.$proses;
				$this->Main_model->akademik_log($whythis,$whatdo);
				
				$this->session->set_flashdata('msg', 'Data Tersimpan!');
				$this->session->set_flashdata('msg_clr', 'success');
				redirect('matkul/detail/'.$proses);
			}else{
				$this->session->set_flashdata('msg', 'Gagal Tersimpan!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('matkul/add/');
			}
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function json()
	{
		$this->load->model('Matkul_data_model');
	    
		$list = $this->Matkul_data_model->get_datatables();
        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            
            $row[] = $field->id_matkul;
            $row[] = $field->kode_mk;
            $row[] = '<a href="'.base_url('matkul/detail/'.$field->id_matkul).'">'.$field->nm_mk.'</a>';
            $row[] = $field->inisial_fak.' '.$field->nama_prodi;

            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Matkul_data_model->count_all(),
            "recordsFiltered" => $this->Matkul_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}

}
