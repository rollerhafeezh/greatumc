<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Reader;

class Tracer extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){redirect(base_url('logout'));}
		if($_SESSION['logged_in']==FALSE){ redirect (base_url('logout'));}
		$this->load->helper('security');
		$this->load->model('Tracer_model');
	}
	
	function index()
	{
	    if($_SESSION['app_level']==3){
			$data['title'] 		= 'Tracer Studi';
			$data['content'] 	= 'tracer/tabel';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function unggah()
	{
	    if($_SESSION['app_level']==3){
			$data['title'] 		= 'Unggah Data Baru';
			$data['content'] 	= 'tracer/unggah';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	
	
}