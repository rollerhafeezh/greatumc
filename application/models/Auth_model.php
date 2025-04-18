<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('encryption');
		
	}
	
	function dekripsi($chiper)
	{
	    $this->encryption->initialize(array(	
										'cipher' => 'aes-256',
										'mode' => 'ctr',
										'key' => $_ENV['APP_SALT']
										));
		return $this->encryption->decrypt($chiper);
	}
	
	function cek_login($username,$id_level)
	{
	    $sso=$this->load->database('sso',true);
	    return $sso->get_where('user_level',array('username'=>$username,'id_level'=>$id_level,'status_user_level'=>1))->row();
	}
	
	function get_id_user($username,$app_level)
	{
	    if($app_level==1)
		{
			$sql = $this->db->get_where('mahasiswa_pt',array('id_mhs'=>$username,'npm_aktif'=>1))->row();
			if($sql)
			{
			    return $sql->id_mahasiswa_pt;
			}else{
			    return false;
			}
		}
		
		if($app_level==2)
		{
			$sql = $this->db->get_where('dosen',array('nidn'=>$username))->row();
			if($sql)
			{
			    return $sql->id_dosen;
			}else{
			    return false;
			}
		}
		
		return true;
	}
	
	function get_username($username)
	{
	    $sso=$this->load->database('sso',true);
	    return $sso->get_where('user_main',array('username'=>$username))->row();
	}
	
	function get_level($id_level)
	{
	    $sso=$this->load->database('sso',true);
	    $sso->where('a.id_level',$id_level);
	    $sso->join('app_level b','a.id_level=b.id_level');
	    $sso->join('app_ref c','b.id_app=c.id_app');
	    return $sso->get('user_level a')->row();
	}
}