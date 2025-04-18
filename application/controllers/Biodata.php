<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Biodata extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){redirect(base_url('logout'));}
		if($_SESSION['logged_in']==FALSE){ redirect (base_url('logout'));}

		$this->load->model('Mbkm_model');
	}
	
	function index()
	{
		if($_SESSION['app_level']==1){ redirect ('biodata/mahasiswa/');
		}else if($_SESSION['app_level']==2){ redirect ('biodata/dosen/');
		}else if($_SESSION['app_level']==10){ redirect ('biodata/mahasiswa_v2/');
		}else{ redirect('dashboard'); }
		
	}

	function mahasiswa_v2($id_mahasiswa_pt=null)
	{
		$id_mahasiswa_pt = xss_clean($id_mahasiswa_pt);
		if($_SESSION['app_level']==10) $id_mahasiswa_pt =  $_SESSION['username'];
		
		/*---if id mahasiswa ada----*/
		if($id_mahasiswa_pt){
			$where = ['id_mahasiswa_pt' => $id_mahasiswa_pt];
			$mahasiswa_pt = $this->Mbkm_model->get_mahasiswa($where);

		/*---if mahasiswa ada----*/
		if($mahasiswa_pt->num_rows()){
			$mahasiswa_pt = $mahasiswa_pt->row();
			// print_r($mahasiswa_pt); exit;

			$data['mahasiswa_pt']= $mahasiswa_pt;
			$data['agama'] = $this->Main_model->ref_agama();
	        $data['kecamatan'] = $this->Main_model->ref_kecamatan();
			$data['title'] 		= 'Biodata';
			$data['lead'] 		= 'Pastikan bahwa kamu melengkapi biodata.';
			$data['content'] 	= 'biodata/edit_v2';
			
			$this->load->view('lyt/index',$data);
		
		}else{ $data['title']	 = 'Data tidak Ditemukan';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function update_v2()
    {
        $data = $this->input->post(null, true);
        // print_r($data); exit;

        $update = $this->Mbkm_model->update($_ENV['DB_MBKM'].'mahasiswa', ['id_mhs' => $_SESSION['id_user']], $data);
        // print_r($update); exit;

        if ($update) {
            // $data['id_mhs'] = $_SESSION['username'];
            // $this->Aktivitas_model->add_log($_SESSION['id_user'], $data, null, 'update_biodata');

            $this->session->set_flashdata('msg', '<i class="pli-yes me-1" style="margin-top: -3px;"></i> Biodata berhasil diperbaharui.');
            $this->session->set_flashdata('msg_clr', 'success');
        }

        redirect('biodata/mahasiswa_v2');
    }

	function edit($id_mahasiswa_pt=null)
	{
		$id_mahasiswa_pt = xss_clean($id_mahasiswa_pt);
		if($_SESSION['app_level']==1) $id_mahasiswa_pt =  $_SESSION['id_user'];
		
		/*---if id mahasiswa ada----*/
		if($id_mahasiswa_pt){
			$bearer = ['id_mahasiswa_pt'=>$id_mahasiswa_pt];
			$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
			
		/*---if mahasiswa ada----*/
		if($mahasiswa_pt){
		$this->load->model('Mahasiswa_model');
		$data['mahasiswa_pt']= $mahasiswa_pt[0];
		$data['agama'] = $this->Main_model->ref_agama();
        $data['kecamatan'] = $this->Main_model->ref_kecamatan();
		$data['title'] 		= 'Edit Biodata '.$mahasiswa_pt[0]->nm_pd;
		$data['content'] 	= 'biodata/edit';
		$this->load->view('lyt/index',$data);
		
		}else{ $data['title']	 = 'Data tidak Ditemukan';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function update()
    {
        $data = $this->input->post(null, true);
        // print_r($data); exit;

        $update = $this->Main_model->update_biodata($data, ['id_mhs' => $_SESSION['username'] ]);
        if ($update) {
            $data['id_mhs'] = $_SESSION['username'];
            // $this->Aktivitas_model->add_log($_SESSION['id_user'], $data, null, 'update_biodata');

            $this->session->set_flashdata('msg', 'Biodata berhasil diperbaharui.');
            $this->session->set_flashdata('msg_clr', 'success');
        }
        redirect('biodata/mahasiswa');
    }

	function mahasiswa($id_mahasiswa_pt=null)
	{
		$id_mahasiswa_pt = xss_clean($id_mahasiswa_pt);
		if($_SESSION['app_level']==1) $id_mahasiswa_pt =  $_SESSION['id_user'];
		
		/*---if id mahasiswa ada----*/
		if($id_mahasiswa_pt){
			$bearer = ['id_mahasiswa_pt'=>$id_mahasiswa_pt];
			$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
			//print_r($mahasiswa_pt);
		/*---if mahasiswa ada----*/
		if($mahasiswa_pt){
		$this->load->model('Mahasiswa_model');
		$data['mahasiswa_pt']= $mahasiswa_pt[0];
		$data['title'] 		= 'Biodata '.$mahasiswa_pt[0]->nm_pd;
		$data['content'] 	= 'biodata/mahasiswa';
		$this->load->view('lyt/index',$data);
		
		}else{ $data['title']	 = 'Data tidak Ditemukan';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function dosen($id_dosen=null)
	{
	    if($_SESSION['app_level']!=1){
	        
	    if($_SESSION['app_level']==2) $id_dosen = $_SESSION['username'];
	    
	    if($id_dosen){
	    $bearer = ['nidn'=>$id_dosen];
		$dosen = $this->Main_model->post_api('dosen/dosen',$bearer);
		if($dosen){
		$data['dosen']      = $dosen[0];
	    $data['title'] 		= 'Biodata '.$dosen[0]->nm_sdm;
		$data['content'] 	= 'biodata/dosen';
		$this->load->view('lyt/index',$data);
		
	    }else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	    }else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

}
