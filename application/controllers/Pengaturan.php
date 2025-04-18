<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){redirect(base_url('logout'));}
		if($_SESSION['logged_in']==FALSE){ redirect (base_url('logout'));}
		$this->load->helper('security');
	}
	
	function index()
	{
		if($_SESSION['app_level']==3){
			$data['title'] 		= 'Pengaturan Dasar';
			$data['content'] 	= 'pengaturan/index';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function tahun()
	{
		if($_SESSION['level_name']=='Wakil Rektor'){
			$data['title'] 		= 'Pengaturan Tahun Akademik';
			$data['content'] 	= 'pengaturan/tahun_akademik';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function ubah_tahun($id_smt)
	{
		if($_SESSION['level_name']=='Wakil Rektor' && $id_smt){
		    $whythis='ubah_tahun';
			$whatdo='#ta:'.$id_smt;
			$this->Main_model->akademik_log($whythis,$whatdo);
			
			$this->Main_model->ubah_tahun($id_smt);
			redirect(base_url('logout'));
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function fakultas()
	{
		if($_SESSION['app_level']==3){
		    $data['fakultas']   = $this->Main_model->ref_fakultas();
			$data['title'] 		= 'Atur Fakultas';
			$data['content'] 	= 'pengaturan/fakultas';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function detail_fakultas($kode_fak)
	{
		if($_SESSION['app_level']==3){
		    $data['fakultas']   = $this->Main_model->ref_fakultas($kode_fak)[0];
		    $data['prodi']      = $this->Main_model->ref_prodi($kode_fak);
			$data['title'] 		= 'Fakultas';
			$data['content'] 	= 'pengaturan/detail_fakultas';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function update_fakultas()
	{
	    $kode_fak= $this->input->post('kode_fak');
	    $isi= $this->input->post('isi');
	    $komponen= $this->input->post('komponen');
	    $proses = $this->Main_model->update_fakultas($kode_fak,$isi,$komponen);
	    if($proses){
	        $whythis='update_fakultas';
			$whatdo='#kode_fak:'.$kode_fak.'#field:'.$komponen.'#value:'.$isi;
			$this->Main_model->akademik_log($whythis,$whatdo);
	        $this->session->set_flashdata('msg', 'Tersimpan!');
            $this->session->set_flashdata('msg_clr', 'success');
	        echo 1;
	    }else{
	        $this->session->set_flashdata('msg', 'Gagal Tersimpan!');
            $this->session->set_flashdata('msg_clr', 'danger');
	        echo 0;
	    } 
	}
	
	function detail_prodi($kode_prodi)
	{
		if($_SESSION['app_level']==3){
		    $data['prodi']      = $this->Main_model->ref_prodi(null,$kode_prodi)[0];
			$data['title'] 		= 'Program Studi ';
			$data['content'] 	= 'pengaturan/detail_prodi';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function update_prodi()
	{
	    $kode_prodi= $this->input->post('kode_prodi');
	    $isi= $this->input->post('isi');
	    $komponen= $this->input->post('komponen');
	    $proses = $this->Main_model->update_prodi($kode_prodi,$isi,$komponen);
	    if($proses){
	        $whythis='update_prodi';
			$whatdo='#kode_prodi:'.$kode_prodi.'#field:'.$komponen.'#value:'.$isi;
			$this->Main_model->akademik_log($whythis,$whatdo);
	        $this->session->set_flashdata('msg', 'Tersimpan!');
            $this->session->set_flashdata('msg_clr', 'success');
	        echo 1;
	    }else{
	        $this->session->set_flashdata('msg', 'Gagal Tersimpan!');
            $this->session->set_flashdata('msg_clr', 'danger');
	        echo 0;
	    } 
	}
	
	function persepsi()
	{
		if($_SESSION['app_level']==3){
		    $this->load->model('Persepsi_model');
			$data['title'] 		= 'Instrumen Evaluasi Kelas';
			$data['content'] 	= 'pengaturan/persepsi';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function detail_persepsi($id_instrumen=null)
	{
		if($_SESSION['app_level']==3){
		if($id_instrumen){
		$this->load->model('Persepsi_model');
		$persepsi=$this->Persepsi_model->get($id_instrumen)->row();
		if($persepsi){
		    $data['persepsi']   = $persepsi;
		    $data['title'] 		= 'Instrumen '.$persepsi->nama_instrumen;
			$data['content'] 	= 'pengaturan/detail_persepsi';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Detail tidak Ditemukan!';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function log_akademik()
	{
		if($_SESSION['app_level']!=1){
			$data['title'] 		= 'Log Akademik';
			$data['content'] 	= 'pengaturan/log_akademik';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function json_log()
	{
		$this->load->model('Log_data_model');
	    
		$list = $this->Log_data_model->get_datatables();
        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            
            $row[] = $field->whenat;
            $row[] = $field->whois;
            $row[] = $field->whythis;
            $row[] = $field->whatdo;
            $row[] = $field->wherefrom;
            $row[] = $field->whenat;
            
            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Log_data_model->count_all(),
            "recordsFiltered" => $this->Log_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
}