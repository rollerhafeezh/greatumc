<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Auth_model');
    }
    
    function index($encoded=null)
    {
        redirect(base_url('logout'));
    }
    
    function logon($encoded=null)
    {
        
        if($encoded)
        {
            $decoded=base64_decode($encoded);
            $dekripsi = $this->Auth_model->dekripsi($decoded);
            $data = explode('#', $dekripsi);
            
            if(count($data)==3)
            {
                $waktu = date('Y-m-d H:i:s');
                if($waktu < $data[2])
                {
                    $cek_login = $this->Auth_model->cek_login($data[0],$data[1]);
                    if($cek_login)
                    {
                        $this->proses($data[0],$data[1]);
                    }else{
                        redirect(base_url('logout'));
                    }
                }else{
                    echo 'Your link has expired. Please go back and <a href="'.base_url('logout').'">create new one</a>';
                }
            }else{
                redirect(base_url('logout'));
            }
        }else{
            redirect(base_url('logout'));
        }
    }
    
    private function proses($username,$id_level)
    {
        $pengguna = $this->Auth_model->get_username($username);
        //var_dump($username); exit();
        $level = $this->Auth_model->get_level($id_level);
        
        if($pengguna && $level)
        {
            $id_user = $this->Auth_model->get_id_user($pengguna->username,$level->app_level);
            if($id_user){
                
            
			/*-------USER DETAIL---------*/
            $_SESSION['picture']	    =($pengguna->picture)?:$_ENV['LOGO_100'];
    		$_SESSION['username']	    =$pengguna->username;
    		$_SESSION['email']	        =$pengguna->email;
    		$_SESSION['nama_pengguna']  =$pengguna->nama_pengguna;
    		$_SESSION['email']	        =$pengguna->email;
    		$_SESSION['api_token']	    =$pengguna->api_token;
    		$_SESSION['id_user']	    = $id_user;
			/*-------USER DETAIL---------*/
    		
    		/*---CAN BE IGNORED ----*/
    		$_SESSION['id_level']	=$level->id_level;
    		$_SESSION['id_app']	    =$level->id_app;
    		$_SESSION['nama_app']	=$level->nama_app;
    		/*---CAN BE IGNORED ----*/
    		
    		/*--------FOR APPLEVEL PURPOSE-----*/
    		$_SESSION['app_level']	=$level->app_level;
    		$_SESSION['level_name']	=$level->level_name;
    		$_SESSION['kode_fak']	=$level->kode_fak;
    		$_SESSION['nama_fak']	=json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/fakultas?kode_fak='.$level->kode_fak))[0]->nama_fak;
    		$_SESSION['kode_prodi']	=$level->kode_prodi;
    		$_SESSION['nama_prodi']	=json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/prodi?kode_prodi='.$level->kode_prodi))[0]->nama_prodi;
    		/*--------FOR APPLEVEL PURPOSE-----*/
			
			/*-----KETERANGAN TAMBAHAN HERE----*/
			$active_smt = json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/smt?id_smt=aktif'))[0];
			$_SESSION['active_smt']=$active_smt->id_semester;
			$_SESSION['nama_smt']=$active_smt->nama_semester;
			
			$thn_aka=substr($_SESSION['active_smt'],0,4);
			$_SESSION['thn_aka']=$thn_aka;
			$_SESSION['thn_akademik']=$thn_aka.'/'.($thn_aka+1);
    		
    		$_SESSION['logged_in']	=TRUE;
			
			if($_SESSION['app_level']==1)
			{
			    $count_nim = $this->Main_model->get_count_nim($_SESSION['username'])->num_rows();
			    if($count_nim > 1)
			    {
			        redirect('dashboard/pilih_nim');
			    }else{
			        $kuliah_mahasiswa = $this->Main_model->check_kuliah_mahasiswa($_SESSION['id_user'],$_SESSION['active_smt']);    
                    //print_r($kuliah_mahasiswa); exit;
                    $_SESSION['smt_mhs'] = $kuliah_mahasiswa->smt_mhs;
			        redirect('dashboard');
			    }
			}else{
    		    redirect('dashboard');
            }
            }else{
                echo 'tidak ada nim aktif.';
            }
        }else{
            redirect(base_url('logout'));   
        }
    }
    
    
}