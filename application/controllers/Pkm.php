<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Pkm extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){redirect(base_url('logout'));}
		if($_SESSION['logged_in']==FALSE){ redirect (base_url('logout'));}
		$this->load->model('Pkm_model');
		$this->load->helper('security');
	}
	
	function pengumuman()
	{
		if	(	
			$_SESSION['app_level'] == 3 
			)
		{
		$data['title']	='Pengumuman';
		$data['content']	='pkm/pengumuman';
		$this->load->view('lyt/index',$data);
		
		}else{ $data['title']	 = 'Kenapa Seperti ini?';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	}
	
	function index()
	{
		$data['title'] 		= 'Pengumuman';
		$data['content'] 	= 'pkm/index';
		$this->load->view('lyt/index',$data);
	}
	
	function tabel()
	{
		$data['title'] 		= 'Tabel Ajuan PKM';
		$data['content'] 	= 'pkm/tabel';
		$this->load->view('lyt/index',$data);
	}
	
	function detail($id_aktivitas=null)
	{
	    if($id_aktivitas){
	    $id_aktivitas = xss_clean($id_aktivitas);
	    $cek_aktivitas = $this->Pkm_model->get_aktivitas($id_aktivitas)->row();
	    if($cek_aktivitas){
		    $bearer = ['id_mahasiswa_pt'=>$cek_aktivitas->id_mahasiswa_pt];
			$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
		if($mahasiswa_pt){
		
		$data['status_ajuan'] = ['Draft','Diajukan','Evaluasi','Diterima'];
		$data['warna_status_ajuan'] = ['danger','warning','info','success'];
		$data['mahasiswa_pt']= $mahasiswa_pt[0];
		$data['aktivitas'] 	= $cek_aktivitas;
		$data['title'] 		= 'Detail PKM';
		$data['content'] 	= 'pkm/detail';
		$this->load->view('lyt/index',$data);
		
		}else{ $data['title']	 = 'Kamu tidak Ditemukan!';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	    }else{ $data['title']	 = 'Belum ada sesi Aktif';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Kenapa Seperti ini?';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	}
	
	function add()
	{
	    if($_SESSION['app_level']==1){
	    $cek_sesi = $this->Pkm_model->cek_sesi()->row();
	    if($cek_sesi){
		    $bearer = ['id_mahasiswa_pt'=>$_SESSION['id_user']];
			$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
		if($mahasiswa_pt){
		
		$data['mahasiswa_pt']= $mahasiswa_pt[0];
		$data['sesi'] 		= $cek_sesi;
		$data['title'] 		= 'Buat Ajuan PKM';
		$data['content'] 	= 'pkm/add';
		$this->load->view('lyt/index',$data);
		
		}else{ $data['title']	 = 'Kamu tidak Ditemukan!';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	    }else{ $data['title']	 = 'Belum ada sesi Aktif';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Khusus Mahasiswa';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function bidang()
	{
	    if($_SESSION['app_level']==3){ 
	    $get_bidang = $this->Pkm_model->get_bidang()->result();
		
		$data['bidang'] 	= $get_bidang;
		$data['title'] 		= 'Pengaturan Bidang';
		$data['content'] 	= 'pkm/bidang';
		$this->load->view('lyt/index',$data);
		
		}else{ $data['title']	 = 'Khusus Akademik';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function detail_bidang($id_jenis_pkm)
	{
	    if($_SESSION['app_level']==3 && $id_jenis_pkm){ 
	    $get_bidang = $this->Pkm_model->get_bidang($id_jenis_pkm)->row();
		
		if($get_bidang){
		$data['bidang'] 		= $get_bidang;
		$data['title'] 		= 'Detail Bidang';
		$data['content'] 	= 'pkm/detail_bidang';
		$this->load->view('lyt/index',$data);
		
		    
		}else{ $data['title']	 = 'tidak Ditemukan!';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Khusus Akademik';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function update_bidang()
	{
	    $id_jenis_pkm= $this->input->post('id_jenis_pkm');
	    $isi= $this->input->post('isi');
	    $komponen= $this->input->post('komponen');
	    $proses = $this->Pkm_model->update_bidang($id_jenis_pkm,$isi,$komponen);
	    if($proses){
	        $this->session->set_flashdata('msg', 'Tersimpan!');
            $this->session->set_flashdata('msg_clr', 'success');
	        echo 1;
	    }else{
	        $this->session->set_flashdata('msg', 'Gagal Tersimpan!');
            $this->session->set_flashdata('msg_clr', 'danger');
	        echo 0;
	    } 
	}
	
	function buat_bidang()
	{
	    if($_SESSION['app_level']==3){ 
	    $proses = $this->Pkm_model->buat_bidang();
	    if($proses){
	        $this->session->set_flashdata('msg', 'Tersimpan!');
            $this->session->set_flashdata('msg_clr', 'success');
	        redirect('pkm/detail_bidang/'.$proses);
	    }else{
	        $this->session->set_flashdata('msg', 'Gagal Tersimpan!');
            $this->session->set_flashdata('msg_clr', 'danger');
	        redirect('pkm/bidang/');
	    } 
		}else{ $data['title']	 = 'Khusus Akademik';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function sesi()
	{
	    if($_SESSION['app_level']==3){ 
	    $get_sesi = $this->Pkm_model->get_sesi()->result();
		
		$data['sesi'] 		= $get_sesi;
		$data['title'] 		= 'Pengaturan Sesi';
		$data['content'] 	= 'pkm/sesi';
		$this->load->view('lyt/index',$data);
		
		}else{ $data['title']	 = 'Khusus Akademik';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function detail_sesi($id_sesi)
	{
	    if($_SESSION['app_level']==3 && $id_sesi){ 
	    $get_sesi = $this->Pkm_model->get_sesi($id_sesi)->row();
		
		if($get_sesi){
		$data['sesi'] 		= $get_sesi;
		$data['title'] 		= 'Detail Sesi';
		$data['content'] 	= 'pkm/detail_sesi';
		$this->load->view('lyt/index',$data);
		
		    
		}else{ $data['title']	 = 'tidak Ditemukan!';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Khusus Akademik';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function update_sesi()
	{
	    $id_sesi= $this->input->post('id_sesi');
	    $isi= $this->input->post('isi');
	    $komponen= $this->input->post('komponen');
	    $proses = $this->Pkm_model->update_sesi($id_sesi,$isi,$komponen);
	    if($proses){
	        $this->session->set_flashdata('msg', 'Tersimpan!');
            $this->session->set_flashdata('msg_clr', 'success');
	        echo 1;
	    }else{
	        $this->session->set_flashdata('msg', 'Gagal Tersimpan!');
            $this->session->set_flashdata('msg_clr', 'danger');
	        echo 0;
	    } 
	}
	
	function buat_sesi()
	{
	    if($_SESSION['app_level']==3){ 
	    $proses = $this->Pkm_model->buat_sesi();
	    if($proses){
	        $this->session->set_flashdata('msg', 'Tersimpan!');
            $this->session->set_flashdata('msg_clr', 'success');
	        redirect('pkm/detail_sesi/'.$proses);
	    }else{
	        $this->session->set_flashdata('msg', 'Gagal Tersimpan!');
            $this->session->set_flashdata('msg_clr', 'danger');
	        redirect('pkm/sesi/');
	    } 
		}else{ $data['title']	 = 'Khusus Akademik';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function simpan()
	{
	    if($_SESSION['app_level']==1){
	    $cek_sesi = $this->Pkm_model->cek_sesi()->row();
	    if($cek_sesi){
		    $bearer = ['id_mahasiswa_pt'=>$_SESSION['id_user']];
			$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
		if($mahasiswa_pt){
		//print_r($_POST);
		$aktivitas = [
		    'id_smt' => $this->input->post('id_smt'),
		    'id_jenis_pkm' => $this->input->post('id_jenis_pkm'),
		    'kode_prodi' => $this->input->post('kode_prodi'),
		    'judul' => $this->input->post('judul',true),
		    'keterangan' => $this->input->post('keterangan',true),
		    'lokasi' => $this->input->post('lokasi',true),
		    ];
        $proses = $this->Pkm_model->add_pkm($aktivitas);
        if($proses){
		$anggota = ['id_mahasiswa_pt'=>$this->input->post('id_mahasiswa_pt'),'id_aktivitas'=>$proses];
    		$add_anggota = $this->Pkm_model->add_anggota($anggota);
    		if($add_anggota){
    		    $riwayat = ['id_aktivitas'=>$proses,'siapa'=>$_SESSION['nama_pengguna'].' ('.$_SESSION['level_name'].')','ngapain'=>'inisiasi'];
    	        $this->Pkm_model->add_riwayat($riwayat);
    		    $this->session->set_flashdata('msg', 'Tersimpan!');
                $this->session->set_flashdata('msg_clr', 'success');
    		    redirect('pkm/detail/'.$proses);
    		}else{
                $this->session->set_flashdata('msg', 'Gagal Tersimpan!');
                $this->session->set_flashdata('msg_clr', 'danger');
                redirect('pkm/add/');    
            }    
        }else{
            $this->session->set_flashdata('msg', 'Gagal Tersimpan!');
            $this->session->set_flashdata('msg_clr', 'danger');
            redirect('pkm/add/');    
        }
		}else{ $data['title']	 = 'Kamu tidak Ditemukan!';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	    }else{ $data['title']	 = 'Belum ada sesi Aktif';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Khusus Mahasiswa';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function add_dokumen()
	{
	    $unggah = $this->upload_file();
	    if($unggah){
    	    $data = [
        	    'id_aktivitas'=> $this->input->post('id_aktivitas'),
        	    'nama_dokumen'=> $this->input->post('nama_dokumen',true),
        	    'url_dokumen'=> $unggah,
        	    ];
    	    
    	    $proses = $this->Pkm_model->add_dokumen($data);
    	    if($proses){
    	        $riwayat = ['id_aktivitas'=>$this->input->post('id_aktivitas'),'siapa'=>$_SESSION['nama_pengguna'].' ('.$_SESSION['level_name'].')','ngapain'=>'add_dokumen'];
        	    $this->Pkm_model->add_riwayat($riwayat);
        	    $this->session->set_flashdata('msg', 'Tersimpan!');
                $this->session->set_flashdata('msg_clr', 'success');
    	        echo 1;
    	    }else{
    	        $this->session->set_flashdata('msg', 'Gagal Tersimpan!');
                $this->session->set_flashdata('msg_clr', 'danger');
    	        echo 0;
    	    } 
	    }else{
	        $this->session->set_flashdata('msg', 'Gagal Tersimpan!');
            $this->session->set_flashdata('msg_clr', 'danger');
	        echo 0;
	    } 
	}
	
	function upload_file()
	{
	    if($_FILES['dokumen']['name'])
		{
			$nama_dokumen = $this->input->post('nama_dokumen');
			$simpan_file = $this->Main_model->unggah_dokumen($nama_dokumen,'./dokumen/pkm/','*','dokumen');
			if($simpan_file)
			{
				$nama_dokumen=base_url('dokumen/pkm/'.$simpan_file['upload_data']['file_name']);
				return $nama_dokumen;
			}else{
			    return false;
			}
		}else{
		    return false;
		}
	}
	
	public function riwayat($id_aktivitas=null)
	{
	    if($id_aktivitas){
    		
    		$data['riwayat']    = $this->Pkm_model->riwayat($id_aktivitas);
    		
    		$this->load->view('pkm/riwayat',$data);
    		
		}else{ echo 'na'; }	
	}
	
	function hapus_percakapan()
	{
	    $id_bimbingan= $this->input->post('id_bimbingan');
	    $proses = $this->Pkm_model->hapus_percakapan($id_bimbingan);
	    if($proses){
	        echo 1;
	    }else{
	        echo 0;
	    } 
	}
	
	function update_aktivitas()
	{
	    $id_aktivitas= $this->input->post('id_aktivitas');
	    $isi= $this->input->post('isi');
	    $komponen= $this->input->post('komponen');
	    $proses = $this->Pkm_model->update_aktivitas($id_aktivitas,$isi,$komponen);
	    if($proses){
	            $riwayat = ['id_aktivitas'=>$id_aktivitas,'siapa'=>$_SESSION['nama_pengguna'].' ('.$_SESSION['level_name'].')','ngapain'=>'update_aktivitas '.$komponen];
    	        $this->Pkm_model->add_riwayat($riwayat);
	        echo 1;
	    }else{
	        echo 0;
	    } 
	}
	
	function unggah_sesi()
	{
	    $id_sesi= $this->input->post('id_sesi');
		$jenis = $this->input->post('jenis');
	    if($_FILES['dokumen']['name'])
		{
		    $nama_dokumen = $id_sesi.'-'.$jenis;
			$simpan_file = $this->Main_model->unggah_dokumen($nama_dokumen,'./dokumen/pkm/','*','dokumen');
			if($simpan_file)
			{
				$nama_dokumen=base_url('dokumen/pkm/'.$simpan_file['upload_data']['file_name']);
				$proses = $this->Pkm_model->update_sesi($id_sesi,$nama_dokumen,$jenis);
        	    if($proses){
        	        $this->session->set_flashdata('msg', 'Tersimpan!');
                    $this->session->set_flashdata('msg_clr', 'success');
        	        echo 1;
        	    }else{
        	        $this->session->set_flashdata('msg', 'Gagal Tersimpan!');
                    $this->session->set_flashdata('msg_clr', 'danger');
        	        echo 0;
        	    } 
			}else{
			    $this->session->set_flashdata('msg', 'Gagal Tersimpan!');
                $this->session->set_flashdata('msg_clr', 'danger');
			    echo 0;
			}
		}else{
		    $this->session->set_flashdata('msg', 'Gagal Tersimpan!');
            $this->session->set_flashdata('msg_clr', 'danger');
		    echo 0;
		}
	}
	
	function proses_ajuan()
	{
	    $id_aktivitas= $this->input->post('id_aktivitas');
	    $status_ajuan= $this->input->post('status_ajuan');
	    
	    $proses = $this->Pkm_model->update_aktivitas($id_aktivitas,$status_ajuan,'status_aktivitas');
	    if($proses){
	            $this->validasi_ajuan($status_ajuan,$id_aktivitas);
	            $riwayat = ['id_aktivitas'=>$id_aktivitas,'siapa'=>$_SESSION['nama_pengguna'].' ('.$_SESSION['level_name'].')','ngapain'=>'update_status '.$status_ajuan];
    	        $this->Pkm_model->add_riwayat($riwayat);
	        echo 1;
	    }else{
	        echo 0;
	    } 
	}
	
	function validasi_ajuan($status=null,$id_aktivitas=null)
	{
	    $validasi_ajuan = ($status)?$status:$this->input->post('validasi_ajuan');
	    $id_aktivitas   = ($id_aktivitas)?$id_aktivitas:$this->input->post('id_aktivitas');
	    if($validasi_ajuan==1)
	    {
	        $this->Pkm_model->validasi_ajuan('MAHASISWA',$id_aktivitas);
	    }
	    if($validasi_ajuan==3)
	    {
	        $this->Pkm_model->validasi_ajuan('AKADEMIK',$id_aktivitas);
	    }
	    if($validasi_ajuan==7)
	    {
	        $this->Pkm_model->validasi_ajuan('KAPRODI',$id_aktivitas);
	    }
	    if($validasi_ajuan==8)
	    {
	        $this->Pkm_model->validasi_ajuan('WAKIL REKTOR',$id_aktivitas);
	    }
	}
	
	function add_percakapan()
	{
	    $data = [
    	    'id_aktivitas'=> $this->input->post('id_aktivitas'),
    	    'isi'=> $this->input->post('isi',true),
    	    'nama_user'=> $_SESSION['nama_pengguna'],
    	    'level_name'=> $_SESSION['level_name'],
    	    ];
	    
	    $proses = $this->Pkm_model->add_percakapan($data);
	    if($proses){
	        echo 1;
	    }else{
	        echo 0;
	    } 
	}
	
	public function percakapan($id_aktivitas=null)
	{
	    if($id_aktivitas){
    		
    		$data['percakapan']    = $this->Pkm_model->percakapan($id_aktivitas);
    		
    		$this->load->view('pkm/percakapan',$data);
    		
		}else{ echo 'na'; }	
	}
	
	function json()
	{
		$this->load->model('Pkm_data_model');
	    $status_ajuan = ['Draft','Diajukan','Evaluasi','Diterima'];
		$list = $this->Pkm_data_model->get_datatables();
        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            
            $row[] = nama_smt($field->id_smt);
            $row[] = $field->jenis_pkm;
            $row[] = '<a href="'.base_url('pkm/detail/'.$field->id_aktivitas).'">'.$field->judul.'</a>';
            $row[] = $status_ajuan[$field->status_aktivitas];

            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Pkm_data_model->count_all(),
            "recordsFiltered" => $this->Pkm_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
}