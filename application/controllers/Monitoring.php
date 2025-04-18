<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){redirect(base_url('logout'));}
		if($_SESSION['logged_in']==FALSE){ redirect (base_url('logout'));}
		$this->load->model('Dhmd_model');
		$this->load->model('Krs_model');
		$this->load->model('Gedung_model');
		$this->load->helper('security');
	}
	
	function index()
	{
		if($_SESSION['app_level']!=1){
			$data['title'] 		= 'Monitoring Perkuliahan';
			$data['content'] 	= 'monitoring/index';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function ujian()
	{
		if($_SESSION['app_level']!=1){
			$data['title'] 		= 'Monitoring Ujian';
			$data['content'] 	= 'monitoring/ujian';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function rekap()
	{
		if($_SESSION['app_level']!=1){
			$data['title'] 		= 'Rekapitulasi';
			$data['content'] 	= 'monitoring/rekapitulasi';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function rekap_2()
	{
		if($_SESSION['app_level']!=1){
			$data['title'] 		= 'Rekapitulasi';
			$data['content'] 	= 'monitoring/rekapitulasi_2';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function json()
	{
		$this->load->model('Monitoring_pbm_data_model');
	    $list = $this->Monitoring_pbm_data_model->get_datatables();
        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
            $uts = '';
			$uas = '';
			$kuliah = '';
			//$status_kuliah = $field->status_kuliah;
			$status_kuliah = '<div class="badge bg-danger">belum mulai</div>';
			if($field->status_kuliah==1) $status_kuliah = '<div class="badge bg-info">belum selesai</div>';
			if($field->status_kuliah==2) $status_kuliah = '<div class="badge bg-success">selesai</div>';
			if($field->hari_kuliah) $kuliah  = '<div class="jadwal_kuliah">'.nama_hari($field->hari_kuliah).', '.$field->jam_mulai .' s/d '.$field->jam_selesai.'<br>G. '.$field->nama_gedung .' R.'.$field->nama_ruangan.'</div>';
			
			$no++;
            $row = array();
            
            $row[] = '<a href="'.base_url('kelas/detail/'.$field->id_kelas_kuliah).'">'.$field->nm_mk.' '.$field->nm_kls.'</a>';
            $row[] = $field->inisial_fak.' '.$field->nama_prodi;
            $row[] = $kuliah;
            $row[] = $this->ref_pengampu($field->id_kelas_kuliah);
            $row[] = $status_kuliah;
            
			
            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Monitoring_pbm_data_model->count_all(),
            "recordsFiltered" => $this->Monitoring_pbm_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	function json_rekap()
	{
		$this->load->model('Rekapitulasi_data_model');
	    $list = $this->Rekapitulasi_data_model->get_datatables();
        $data = array();
        $co=1;
        $no = $_GET['start'];
        foreach ($list as $field) {
            $hadir = '<ol>';
            $kehadiran = explode(',', $field->kehadiran);
            for ($i=0; $i < count($kehadiran); $i++) {
                $hadir .='<li>'. format_indo($kehadiran[$i]).'</li>';
            }
            $hadir .='</ol>';
        	$no++;
            $row = array();
            
            $row[] = $co;
            $row[] = $field->nm_sdm;
            $row[] = $field->inisial_fak.' '.$field->nama_prodi;
            $row[] = $field->nm_mk.' '.$field->nm_kls;
            $row[] = $hadir;
            $row[] = $field->sks_subst_tot;
            $row[] = $field->jml;
            $row[] = ($field->jml*$field->sks_subst_tot);
            
            $data[] = $row;
            $co++;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Rekapitulasi_data_model->count_all(),
            "recordsFiltered" => $this->Rekapitulasi_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	function json_rekap_2()
	{
		$this->load->model('Rekapitulasi_data_model_2');
	    $list = $this->Rekapitulasi_data_model_2->get_datatables();
        $data = array();
        $co=1;
        $no = $_GET['start'];
        foreach ($list as $field) {
            $durasi=0;
            if($field->jam_selesai) {
                $selesai= strtotime($field->jam_selesai);
                $mulai  = strtotime($field->jam_mulai);
                $durasi = floor(($selesai-$mulai)/60);
            }
			$no++;
            $row = array();
            
            $row[] = $co;
            $row[] = $field->nm_sdm;
            $row[] = $field->inisial_fak.' '.$field->nama_prodi;
            $row[] = $field->nm_mk.' '.$field->nm_kls;
            $row[] = format_indo($field->tanggal);
            $row[] = $field->jam_mulai;
            $row[] = $field->jam_selesai;
            $row[] = $durasi;
            
            $data[] = $row;
            $co++;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Rekapitulasi_data_model_2->count_all(),
            "recordsFiltered" => $this->Rekapitulasi_data_model_2->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	function json_ujian()
	{
		$this->load->model('Monitoring_ujian_data_model');
	    $list = $this->Monitoring_ujian_data_model->get_datatables();
	    // echo '<pre>';
	    //var_dump($list); exit;
        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
            $kuliah = '';
            $dokumen_soal = '';
			$status_kuliah = '<div class="badge bg-danger">belum mulai</div>';
			if($field->status_kuliah==1) $status_kuliah = '<div class="badge bg-info">belum selesai</div>';
			if($field->status_kuliah==2) $status_kuliah = '<div class="badge bg-success">selesai</div>';
			if($field->tgl_ujian) $kuliah  = format_indo($field->tgl_ujian).', '.$field->jam_mulai .' s/d '.$field->jam_selesai.'<br>G. '.$field->nama_gedung .' R.'.$field->nama_ruangan;
			if($field->tgl_ujian) $dokumen_soal  .= ' <a href="'.base_url('cetak/sampul/'.$field->jenis.'/'.$field->id_kelas_kuliah).'" class="text-decoration-none badge bg-info" target="_blank">Sampul</a>';
			if($field->dokumen_soal) $dokumen_soal  .= ' <a href="'.$field->dokumen_soal.'" class="text-decoration-none badge bg-info" target="_blank">Soal</a>';
			if($field->tgl_ujian) $dokumen_soal  .= ' <a href="'.base_url('cetak/dafhad/'.$field->jenis.'/'.$field->id_kelas_kuliah).'" class="text-decoration-none badge bg-success" target="_blank">Daftar Hadir</a>';
			if($field->tgl_ujian) $dokumen_soal  .= ' <a href="'.base_url('cetak/ba/'.$field->jenis.'/'.$field->id_kelas_kuliah).'" class="text-decoration-none badge bg-success" target="_blank">Berita Acara</a>';
			
			$no++;
            $row = array();
            
            $row[] = '<a href="'.base_url('kelas/detail/'.$field->id_kelas_kuliah).'">'.$field->nm_mk.' '.$field->nm_kls.'</a>';
            $row[] = $field->inisial_fak.' '.$field->nama_prodi;
            $row[] = $kuliah;
            $row[] = $status_kuliah;
            $row[] = $dokumen_soal;
            $row[] = $this->ref_pengampu($field->id_kelas_kuliah);
            
			
            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Monitoring_ujian_data_model->count_all(),
            "recordsFiltered" => $this->Monitoring_ujian_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	function ref_pengampu($id_kelas_kuliah)
	{
		$option='';
		$pengampu=$this->Main_model->pengampu_kelas($id_kelas_kuliah)->result();
		if($pengampu)
		{
			foreach($pengampu as $keys=>$values)
			{
				$option.='<strong>'.$values->nidn.'</strong> '.$values->nm_sdm.' ('.$values->sks_subst_tot.' SKS)<br>';
			}
		}
		return $option;
	}
}