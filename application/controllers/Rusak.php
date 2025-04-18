<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Rusak extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){redirect(base_url('logout'));}
		if($_SESSION['logged_in']==FALSE){ redirect (base_url('logout'));}
	}
	
	function e404()
	{
		$data['title']	 = 'Error 404';
		$data['content'] = 'e404';
		$this->load->view('lyt/index',$data);
	}
	
	function e401()
	{
		$data['title']	 = 'Error 401';
		$data['content'] = 'e401';
		$this->load->view('lyt/index',$data);
	}
}