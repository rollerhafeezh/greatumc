<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Inbound extends CI_Controller {

	protected $app_level;

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){redirect(base_url('logout'));}
		if($_SESSION['logged_in']==FALSE){ redirect (base_url('logout'));}

		$this->app_level = [3, 7, 4, 8, 10]; # 10: mahasiswa inbound
		$this->app_level_dosen = [2];

		$this->load->model('Aktivitas_model');
		$this->load->model('Mbkm_model');
	}
	
	function kuliah()
	{
		if(in_array($_SESSION['app_level'], $this->app_level)){
			$where = ['id_mahasiswa_pt' => $_SESSION['username']];
			$data['mahasiswa_pt'] = $this->Mbkm_model->get_mahasiswa($where)->row();

			$data['prodi'] = $this->Mbkm_model->get($_ENV['DB_REF'].'prodi', ['id_jenjang_pendidikan' => 30], 'nama_prodi asc')->result();

			$data['title'] 		= 'Perkuliahan';
			$data['lead'] 		= 'Silahkan isi kartu rencana studi untuk mengikuti perkuliahan.';
			$data['content'] 	= 'inbound/kuliah';

			$this->load->view('lyt/index',$data);
			
		} else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function get_mata_kuliah($kode_prodi)
	{
		$where = [ 'k.kur_aktif' => '1', 'mk.kode_prodi' => $kode_prodi, 'mk.pmm' => '1' ];
		$mata_kuliah = $this->Mbkm_model->get_mata_kuliah($where)->result();
		
		$option = '<option value="" hidden>Pilih Mata Kuliah</option>';
		foreach ($mata_kuliah as $mk) {
			$option .= '<option value="'.$mk->id_matkul.'">'.$mk->nm_mk.'</option>';
		}

		echo $option;
	}
}
