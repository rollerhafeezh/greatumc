<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Eclass extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){redirect(base_url('logout'));}
		if($_SESSION['logged_in']==FALSE){ redirect (base_url('logout'));}
    }
    
    public function index()
    {
        /*
        1: Mahasiswa        99
        2: Dosen            100
        3: Kaprodi PGPAUD   101
        4: Dekan FKIP       102
        5: Univ             103
        */
    }
}