<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){redirect(base_url('logout'));}
		if($_SESSION['logged_in']==FALSE){ redirect (base_url('logout'));}
	}
	
	function index()
	{
	    //if($_SESSION['app_level']==3){
	    $this->load->model('Dhmd_model');
		$data['title']	 = 'Dashboard';
		$data['content'] = 'dashboard/index';
		$this->load->view('lyt/index',$data);
	    //}else{ echo 'mohon maaf'; }
		//if($_SESSION['app_level']==3){echo "aaaaaaa"}
	}
	
	function pilih_nim()
    {
        if($_SESSION['app_level']==1)
		{
		    $count_nim = $this->Main_model->get_count_nim($_SESSION['username']);
		    if($count_nim->num_rows() > 1)
		    {
        		
        		$data['mahasiswa_pt']= $count_nim;
        		$data['title'] 		= 'Pilih Nomor Induk Mahasiswa';
        		$data['content'] = 'dashboard/pilih_nim';
        		$this->load->view('lyt/index_2',$data);
		    }else{
		        redirect('dashboard');
		    }
		}else{
		    redirect('dashboard');
		}
    }
    
    function logon_dd($id_mahasiswa_pt=null)
    {
        if($_SESSION['app_level']==1)
		{
            if($id_mahasiswa_pt){
                $cek_milik = $this->Main_model->cek_milik($_SESSION['username'],$id_mahasiswa_pt)->row();
                if($cek_milik){
                    $_SESSION['id_user'] =$id_mahasiswa_pt;
                    $this->Main_model->check_kuliah_mahasiswa($_SESSION['id_user'],$_SESSION['active_smt']); 
                    redirect('dashboard');
                }else{
                    redirect('logout');    
                }
            }else{
                redirect('logout');
            }
		}else{
            redirect('logout');
        }
    }
    
    function debug_sks($id_smt)
    {
        $sql = $this->Main_model->update_sks_smt($_SESSION['id_user'],$id_smt)->row();
        $sks = ($sql->sks)?:0;
        echo $sks;
    }
    
    private function change_smt($id_smt)
	{
		$_SESSION['active_smt'] = $id_smt;
		$_SESSION['nama_smt'] = nama_smt($id_smt);
	}
	
	function index3($id_mahasiswa_pt,$id_smt)
	{
        $this->Main_model->tagihan_total($id_mahasiswa_pt,$id_smt);
    }

    private function index2()
    {
        /*
        $kuliah_mahasiswa=array(
			'id_smt'			=> $_SESSION['active_smt'],
			'id_mahasiswa_pt' 	=> $id_mhs_pt,
			'stat_mhs' 			=> 'A'
		);*/
		$url=$_ENV['API_LINK'].'sso/get_app/';
		echo $url;
		$this->curl->http_header('token',$_SESSION['api_token']);
		$this->curl->http_header('bearer','SIMAK');
		
		//jika Membawa Inputan
		//$app_list =  $this->curl->simple_post($url,$kuliah_mahasiswa);
		
		//jika tanpa inputan
		$app_list =  json_decode($this->curl->simple_post($url));
		
echo'<pre>';
var_dump($_SESSION);
echo'</pre>
Contoh hasil Get Data API :';
echo'<pre>';
var_dump($app_list);
echo'</pre>';
        echo '<br><a href="'.base_url('logout').'">keluar</a>';
    }
}