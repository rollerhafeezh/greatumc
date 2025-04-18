<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {
	
	function index(){
		$this->session->sess_destroy();
		redirect($_ENV['SSO_URL'].'/logout');
	}
}