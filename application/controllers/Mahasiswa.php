<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){redirect(base_url('logout'));}
		if($_SESSION['logged_in']==FALSE){ redirect (base_url('logout'));}
		
		$this->load->model('Mahasiswa_model');
	}
	
	function index()
	{
		if($_SESSION['app_level']!=1){
			$data['title'] 		= 'Daftar Mahasiswa';
			$data['content'] 	= 'mahasiswa/tabel';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function mutasi()
	{
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==5){
			$data['title'] 		= 'Mutasi Internal Mahasiswa';
			$data['content'] 	= 'mahasiswa/mutasi_internal';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Tidak ada Hak Akses!';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function simpan_dokumen_pindah()
	{
	    if ($this->input->is_ajax_request()) {
	        $id_mutasi = $this->input->post('id_mutasi');
	        $nama_dokumen   = $id_mutasi;
			$url_dokumen    = $this->Main_model->unggah_dokumen($nama_dokumen,'./dokumen/mutasi_mahasiswa/','pdf','dokumen_pindah');
			if($url_dokumen){
			    $nama_dokumen=base_url('dokumen/mutasi_mahasiswa/'.$url_dokumen['upload_data']['file_name']);
			    $unggah = $this->Mahasiswa_model->update_mutasi($id_mutasi,$nama_dokumen,'dokumen_pindah');
			    if($unggah)
			        echo 1;
			    else
			        echo 0;
		    }else{
		        echo 0;
		    }
	    }
	}
	
	function mutasi_detail($id_mutasi=null)
	{
		$id_mutasi = xss_clean($id_mutasi);
		
		if($id_mutasi){
			$mahasiswa_mutasi = $this->Mahasiswa_model->mutasi_detail($id_mutasi)->row();
		if($mahasiswa_mutasi){
		
		$data['status_ajuan'] = ['n/a','Draft','Request NIM','Siap Mutasi','Selesai Mutasi'];
		$data['warna_status_ajuan'] = ['danger','danger','warning','info','success'];
		$data['mahasiswa_mutasi']= $mahasiswa_mutasi;
		$data['title'] 		= 'Detail Mutasi '.$mahasiswa_mutasi->nm_pd;
		$data['content'] 	= 'mahasiswa/mutasi_detail';
		$this->load->view('lyt/index',$data);
		
		}else{ $data['title']	 = 'Data tidak Ditemukan';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function update_mutasi()
	{
	    if($_SESSION['app_level']==3 || $_SESSION['app_level']==5){
    	    $id_mutasi= $this->input->post('id_mutasi');
    	    $isi= $this->input->post('isi');
    	    $komponen= $this->input->post('komponen');
    	    $proses = $this->Mahasiswa_model->update_mutasi($id_mutasi,$isi,$komponen);
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
	}
	
	function mutasi_cari()
	{
		if($_SESSION['app_level']==3){
			$data['title'] 		= 'Cari Mahasiswa';
			$data['content'] 	= 'mahasiswa/mutasi_cari';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Tidak ada Hak Akses!';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function mutasi_proses($id_mahasiswa_pt=null)
	{
		if($_SESSION['app_level']==3){
		if($id_mahasiswa_pt){
		    $bearer = ['id_mahasiswa_pt'=>$id_mahasiswa_pt];
			$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
		
		if($mahasiswa_pt){
		    
			$id_mutasi = $this->Mahasiswa_model->mutasi_proses($mahasiswa_pt[0]);
			if($id_mutasi)
    		{
    			$whythis='mutasi_proses';
    			$whatdo='#id_mahasiswa_pt:'.$id_mahasiswa_pt;
    			$this->Main_model->akademik_log($whythis,$whatdo);
    			
    			$this->session->set_flashdata('msg', 'Data Tersimpan!');
    			$this->session->set_flashdata('msg_clr', 'success');
    			redirect(base_url('mahasiswa/mutasi_detail/'.$id_mutasi));
    		}else{
    			$this->session->set_flashdata('msg', 'Gagal Tersimpan!');
    			$this->session->set_flashdata('msg_clr', 'danger');
    			redirect(base_url('mahasiswa/mutasi/'));
    		}
			
			    redirect(base_url('mahasiswa/mutasi/'));
		}else{ $data['title']	 = '404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = '404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Tidak ada Hak Akses!';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function proses_mutasi($id_mutasi=null)
	{
		if($_SESSION['app_level']==3){
		
		if($id_mutasi){
		$id_mutasi = xss_clean($id_mutasi);
			$mahasiswa_mutasi = $this->Mahasiswa_model->mutasi_detail($id_mutasi)->row();
		if($mahasiswa_mutasi){
		    
			$mutasi = $this->Mahasiswa_model->proses_mutasi($mahasiswa_mutasi);
			if($mutasi)
    		{
    			$whythis='proses_mutasi';
    			$whatdo='#id_mutasi:'.$id_mutasi;
    			$this->Main_model->akademik_log($whythis,$whatdo);
    			
    			$this->session->set_flashdata('msg', 'Data Tersimpan!');
    			$this->session->set_flashdata('msg_clr', 'success');
    		}else{
    			$this->session->set_flashdata('msg', 'Gagal Tersimpan!');
    			$this->session->set_flashdata('msg_clr', 'danger');
    			
    		}
			redirect(base_url('mahasiswa/mutasi/'));
		}else{ $data['title']	 = '404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = '404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Tidak ada Hak Akses!';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function kuliah_mahasiswa()
	{
		if($_SESSION['app_level']!=1){
			$data['title'] 		= 'Aktifitas Kuliah Mahasiswa';
			$data['content'] 	= 'mahasiswa/tabel_kuliah_mahasiswa';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function kartu_ujian()
	{
		if($_SESSION['app_level']!=1){
			$data['title'] 		= 'Cetak Kartu Ujian';
			$data['content'] 	= 'mahasiswa/kartu_ujian';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function validasi_krs()
	{
		$this->load->model('Krs_model');
		$this->load->model('Aktivitas_model');
		$_POST = json_decode($this->input->raw_input_stream, true);
		$id_smt = $this->input->post('id_smt');
		$id_mahasiswa_pt = $this->input->post('id_mahasiswa_pt');
		if($_SESSION['app_level']==4 || $_SESSION['app_level']==3) $validasi='aka';
		if($_SESSION['app_level']==7) $validasi='prodi';
		
		if($_SESSION['app_level']==6 || $_SESSION['app_level']==5) {
			$id_mhs = $this->input->post('id_mhs');
			$validasi='keu';

			$detail_krs = $this->Krs_model->list_kelas_krs($id_mahasiswa_pt, $id_smt)->result();
			foreach ($detail_krs as $mk) {
				if ($mk->id_kat_mk == 3 OR $mk->id_kat_mk == 5) { // KERJA PRAKTEK & TUGAS AKHIR
					$id_jenis_aktivitas_mahasiswa = ($mk->id_kat_mk == 3 ? 6 : 2);
					
					$jml_aktivitas = $this->Aktivitas_model->aktivitas([ 'id_mahasiswa_pt' => $id_mahasiswa_pt, 'id_jenis_aktivitas_mahasiswa' => $id_jenis_aktivitas_mahasiswa ])->num_rows();
					if ($jml_aktivitas < 1) {
						$data_aktivitas = [
							'jenis_anggota' => '0', // Personal
							'id_jenis_aktivitas_mahasiswa' => $id_jenis_aktivitas_mahasiswa, // 6: KERJA PRAKTEK; 2: SKRIPSI
							'kode_prodi' => $mk->kode_prodi,
							'id_smt' => $mk->id_smt
						];
						$id_aktivitas = $this->Aktivitas_model->tambah_aktivitas($data_aktivitas);

						$data_anggota = [
							'id_aktivitas' => $id_aktivitas,
							'id_mahasiswa_pt' => $id_mahasiswa_pt,
							'jenis_peran' => '3',
							'status' => '0'
						];
						$anggota = $this->Aktivitas_model->tambah_anggota($data_anggota);

						$data_sso = [
							'username' => $id_mhs,
							'id_level' => ($mk->id_kat_mk == 3 ? 16 : 7)
						];
						$user_level = $this->Aktivitas_model->tambah_user_level($data_sso);
					}
				}
			}
		}

		$proses = $this->Krs_model->validasi_krs($id_mahasiswa_pt,$id_smt,$validasi);
		if($proses)
		{
			if($_SESSION['app_level']==6 || $_SESSION['app_level']==5)
			{
				//$this->Krs_model->simpan_kelas_kuliah($id_mahasiswa_pt,$id_smt);
			}
			
			$whythis='validasi_krs_'.$validasi;
			$whatdo='#id_mahasiswa_pt:'.$id_mahasiswa_pt.'#id_smt:'.$id_smt;
			$this->Main_model->akademik_log($whythis,$whatdo);
			
			echo $_SESSION['nama_pengguna'];
		}else{
			echo 0;
		}
	}
	
	function validasi()
	{
		if($_SESSION['app_level']!=1){
			$data['title'] 		= 'Validasi KRS Mahasiswa';
			$data['content'] 	= 'mahasiswa/tabel_validasi';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function dosen_wali($id_mahasiswa_pt=null)
	{
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		if($id_mahasiswa_pt){
			$bearer = ['id_mahasiswa_pt'=>$id_mahasiswa_pt];
			$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
		
		if($mahasiswa_pt){
			
		$data['mahasiswa_pt']= $mahasiswa_pt[0];
		$data['title'] 		= 'Dosen Wali '.$mahasiswa_pt[0]->nm_pd;
		$data['content'] 	= 'mahasiswa/dosen_wali';
		$this->load->view('lyt/index',$data);
			
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function cuti($id_smt=null,$id_mahasiswa_pt=null)
	{
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		if($id_smt && $id_mahasiswa_pt){
			$bearer = ['id_mahasiswa_pt'=>$id_mahasiswa_pt];
			$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
		
		if($mahasiswa_pt){
			
		$data['id_smt']= $id_smt;
		$data['mahasiswa_pt']= $mahasiswa_pt[0];
		$data['title'] 		= 'Cuti Mahasiswa '.$mahasiswa_pt[0]->nm_pd;
		$data['content'] 	= 'mahasiswa/cuti';
		$this->load->view('lyt/index',$data);
			
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function keluar($id_mahasiswa_pt=null)
	{
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		if($id_mahasiswa_pt){
			$bearer = ['id_mahasiswa_pt'=>$id_mahasiswa_pt];
			$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
		
		if($mahasiswa_pt){
			
		$data['mahasiswa_pt']= $mahasiswa_pt[0];
		$data['title'] 		= 'Keluarkan Mahasiswa '.$mahasiswa_pt[0]->nm_pd;
		$data['content'] 	= 'mahasiswa/keluar';
		$this->load->view('lyt/index',$data);
			
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function aktif($id_mahasiswa_pt=null)
	{
		if($_SESSION['app_level']==3){
		if($id_mahasiswa_pt){
			$bearer = ['id_mahasiswa_pt'=>$id_mahasiswa_pt];
			$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
		
		if($mahasiswa_pt){
			
		$proses = $this->Main_model->proses_aktif($id_mahasiswa_pt);
		
		if($proses)
		{
			$whythis='proses_aktif';
			$whatdo='#id_mahasiswa_pt:'.$id_mahasiswa_pt;
			$this->Main_model->akademik_log($whythis,$whatdo);
			
			$this->session->set_flashdata('msg', 'Data Tersimpan!');
			$this->session->set_flashdata('msg_clr', 'success');
		}else{
			$this->session->set_flashdata('msg', 'Gagal Tersimpan! atau Sudah Status Aktif');
			$this->session->set_flashdata('msg_clr', 'danger');
		}
		redirect('biodata/mahasiswa/'.$id_mahasiswa_pt);
			
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function proses_dosen_wali($id_mahasiswa_pt=null)
	{
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		if($id_mahasiswa_pt){
			$id_mahasiswa_pt = $this->input->post('id_mahasiswa_pt');
			$id_dosen = $this->input->post('id_dosen');
			$id_dosen_old = $this->input->post('id_dosen_old');
			
			$proses = $this->Mahasiswa_model->proses_dosen_wali($id_mahasiswa_pt,$id_dosen);
			if($proses)
			{
				$whythis='dosen_wali';
				$whatdo='#id_mahasiswa_pt:'.$id_mahasiswa_pt.'#id_dosen:'.$id_dosen.'#id_dosen_old:'.$id_dosen_old;
				$this->Main_model->akademik_log($whythis,$whatdo);
				
				$this->session->set_flashdata('msg', 'Data Tersimpan!');
				$this->session->set_flashdata('msg_clr', 'success');
				redirect('biodata/mahasiswa/'.$id_mahasiswa_pt);
			}else{
				$this->session->set_flashdata('msg', 'Gagal Tersimpan!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('biodata/mahasiswa/'.$id_mahasiswa_pt);
			}
			
		
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function json()
	{
		$this->load->model('Mahasiswa_data_model');
	    
		$list = $this->Mahasiswa_data_model->get_datatables();
        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            
           $row[] = $field->id_mahasiswa_pt;
            $row[] = '<a href="'.base_url('biodata/mahasiswa/'.$field->id_mahasiswa_pt).'">'.$field->nm_pd.'</a>';
            $row[] = $field->inisial_fak.' '.$field->nama_prodi;
            $row[] = $field->email;
			$row[] = $field->nm_sdm;
			$row[] = $field->ket_keluar;
           
            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Mahasiswa_data_model->count_all(),
            "recordsFiltered" => $this->Mahasiswa_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	function json_mutasi()
	{
		$this->load->model('Mutasi_data_model');
	    $status_ajuan = ['n/a','Draft','Request NIM','Siap Mutasi','Selesai Mutasi'];
		$list = $this->Mutasi_data_model->get_datatables();
        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            
            $row[] = $field->mulai_smt;
            $row[] = '<a href="'.base_url('mahasiswa/mutasi_detail/'.$field->id_mutasi).'">'.$field->id_mahasiswa_pt_lama.'</a>';
            $row[] = $field->id_mahasiswa_pt_baru;
            $row[] = $field->inisial_fak.' '.$field->nama_prodi;
            $row[] = $field->nm_pd;
            $row[] = $status_ajuan[$field->status_mutasi];
            
            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Mutasi_data_model->count_all(),
            "recordsFiltered" => $this->Mutasi_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	function json_mutasi_cari()
	{
		$this->load->model('Mahasiswa_data_model');
	    
		$list = $this->Mahasiswa_data_model->get_datatables();
        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            
            $row[] = $field->id_mahasiswa_pt;
            $row[] = $field->nm_pd;
            $row[] = $field->inisial_fak.' '.$field->nama_prodi;
            $row[] = '<a href="'.base_url('mahasiswa/mutasi_proses/'.$field->id_mahasiswa_pt).'" class="btn btn-sm btn-danger" onclick="return confirm(`Yakin akan Mutasi? tidak dapat dihapus!`)">Pilih</a>';
           
            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Mahasiswa_data_model->count_all(),
            "recordsFiltered" => $this->Mahasiswa_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}

	function json_validasi()
	{
		$this->load->model('Perwalian_krs_data_model');
	    
		$list = $this->Perwalian_krs_data_model->get_datatables();
        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            
			$row[] = nama_smt($field->id_smt);
			$row[] = $field->id_mahasiswa_pt;
            $row[] = '<a href="'.base_url('perwalian/validasi/'.$field->id_smt.'/'.$field->id_mahasiswa_pt).'">'.$field->nm_pd .'</a>';
            $row[] = $field->nm_sdm;
            $row[] = $field->validasi;
			if($_SESSION['app_level']==4 || $_SESSION['app_level']==3){
				if($field->validasi_aka)
				{
					$row[] = $field->validasi_aka;
				}else{
					$row[] = '<div id="'.$field->id_mahasiswa_pt.'" class="badge bg-danger" style="cursor: pointer;" onclick="validasi(`'.$field->id_smt.'`,`'.$field->id_mahasiswa_pt.'`)">validasi</div>';
				}
			}else{
				$row[] = $field->validasi_aka;
			}
			if($_SESSION['app_level']==5 || $_SESSION['app_level']==6){
				if($field->validasi_keu)
				{
					$row[] = '<div id="'.$field->id_mahasiswa_pt.'" class="badge bg-info" style="cursor: pointer;" onclick="validasi(`'.$field->id_smt.'`,`'.$field->id_mahasiswa_pt.'`,`'.$field->id_mhs.'`)">'.$field->validasi_keu.'</div>';
				}else{
					$row[] = '<div id="'.$field->id_mahasiswa_pt.'" class="badge bg-danger" style="cursor: pointer;" onclick="validasi(`'.$field->id_smt.'`,`'.$field->id_mahasiswa_pt.'`,`'.$field->id_mhs.'`)">validasi</div>';
				}
			}else{
				$row[] = $field->validasi_keu;
			}
			if($_SESSION['app_level']==7){
				if($field->validasi_prodi)
				{
					$row[] = $field->validasi_prodi;
				}else{
					$row[] = '<div id="'.$field->id_mahasiswa_pt.'" class="badge bg-danger" style="cursor: pointer;" onclick="validasi(`'.$field->id_smt.'`,`'.$field->id_mahasiswa_pt.'`)">validasi</div>';
				}
			}else{
				$row[] = $field->validasi_prodi;
			}
            $row[] = $field->sks_smt;
            
           
            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Perwalian_krs_data_model->count_all(),
            "recordsFiltered" => $this->Perwalian_krs_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	function json_kuliah_mahasiswa()
	{
		$this->load->model('Kuliah_mahasiswa_data_model');
	    
		$list = $this->Kuliah_mahasiswa_data_model->get_datatables();
        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
			$stat_mhs='';
			if($field->id_stat_mhs=='N')
			{
				$stat_mhs='<a href="'.base_url('mahasiswa/cuti/'.$field->id_smt.'/'.$field->id_mahasiswa_pt).'" class="text-decoration-none">Non Aktif</a>';
			}
			if($field->id_stat_mhs=='A')
			{
				$stat_mhs='<a href="'.base_url('mahasiswa/cuti/'.$field->id_smt.'/'.$field->id_mahasiswa_pt).'" class="text-decoration-none">Aktif</a>';
			}
			if($field->id_stat_mhs=='C')
			{
				$stat_mhs='Cuti';
			}
			if($field->id_stat_mhs=='M')
			{
				$stat_mhs='Kampus Merdeka';
			}
			
            $no++;
            $row = array();
            
            $row[] = $field->id_mahasiswa_pt;
            $row[] = '<a href="'.base_url('biodata/mahasiswa/'.$field->id_mahasiswa_pt).'">'.$field->nm_pd.'</a>';
            $row[] = $field->inisial_fak.' '.$field->nama_prodi;
            $row[] = nama_smt($field->id_smt);
            $row[] = $stat_mhs;
            $row[] = $field->smt_mhs;
            $row[] = $field->biaya_kuliah;
            $row[] = $field->ips;
			$row[] = $field->ipk;
			$row[] = $field->sks_smt;
            $row[] = $field->sks_total;

			$data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Kuliah_mahasiswa_data_model->count_all(),
            "recordsFiltered" => $this->Kuliah_mahasiswa_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	function json_kartu_ujian()
	{
		$this->load->model('Kartu_ujian_data_model');
	    
		$list = $this->Kartu_ujian_data_model->get_datatables();
        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
            $kartu_uts = ($field->kartu_uts==1)?'<a href="'.base_url('cetak/kartu/uts/'.$field->id_smt.'/'.$field->id_mahasiswa_pt).'" class="text-decoration-none btn btn-light" target="_blank"><i class="psi-printer"></i> UTS</a>':'<a href="'.base_url('cetak/kartu/uts/'.$field->id_smt.'/'.$field->id_mahasiswa_pt).'" class="text-decoration-none btn btn-success" target="_blank"><i class="psi-printer"></i> UTS</a>';
            $kartu_uas = ($field->kartu_uas==1)?'<a href="'.base_url('cetak/kartu/uas/'.$field->id_smt.'/'.$field->id_mahasiswa_pt).'" class="text-decoration-none btn btn-light" target="_blank"><i class="psi-printer"></i> UAS</a>':'<a href="'.base_url('cetak/kartu/uas/'.$field->id_smt.'/'.$field->id_mahasiswa_pt).'" class="text-decoration-none btn btn-success" target="_blank"><i class="psi-printer"></i> UAS</a>';
            $no++;
            $row = array();
            
            $row[] = nama_smt($field->id_smt);
            $row[] = $field->id_mahasiswa_pt;
            $row[] = '<a href="'.base_url('biodata/mahasiswa/'.$field->id_mahasiswa_pt).'">'.$field->nm_pd.'</a>';
            $row[] = $field->inisial_fak.' '.$field->nama_prodi;
            $row[] = $kartu_uts;
            $row[] = $kartu_uas;
            
            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Kartu_ujian_data_model->count_all(),
            "recordsFiltered" => $this->Kartu_ujian_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	function json_arsip_kelas_kuliah()
	{
		$this->load->model('Arsip_kelas_kuliah_mahasiswa_data_model');
	    
		$list = $this->Arsip_kelas_kuliah_mahasiswa_data_model->get_datatables();
        $data = array();
        $no = $_GET['start'];
		
        foreach ($list as $field) {
			
			$no++;
            $row = array();
            
            $row[] = nama_smt($field->id_smt);
            $row[] = $field->nm_mk.' '.$field->nm_kls;
            $row[] = '<a class="text-decoration-none" href="'.base_url('dhmd/daftar_pertemuan/'.$field->id_kelas_kuliah).'">Lihat</a>';
            
			$data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Arsip_kelas_kuliah_mahasiswa_data_model->count_all(),
            "recordsFiltered" => $this->Arsip_kelas_kuliah_mahasiswa_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	function proses_cuti()
	{
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		$id_smt = $this->input->post('id_smt');
		$id_mahasiswa_pt = $this->input->post('id_mahasiswa_pt');
		$proses = $this->Main_model->proses_cuti($id_smt,$id_mahasiswa_pt);
		
		if(isset($_FILES['surat']['name']))
		{
			$nama_dokumen = 'cuti-'.$id_smt.'-'.$id_mahasiswa_pt;
			$simpan_file = $this->Main_model->unggah_dokumen_re($nama_dokumen,'./dokumen/etc/','pdf','surat');
		}
		
		if($proses)
		{
			$whythis='proses_cuti';
			$whatdo='#id_mahasiswa_pt:'.$id_mahasiswa_pt.'#id_smt:'.$id_smt;
			$this->Main_model->akademik_log($whythis,$whatdo);
			
			$this->session->set_flashdata('msg', 'Data Tersimpan!');
			$this->session->set_flashdata('msg_clr', 'success');
		}else{
			$this->session->set_flashdata('msg', 'Gagal Tersimpan! atau Sudah Status Cuti');
			$this->session->set_flashdata('msg_clr', 'danger');
		}
		redirect('mahasiswa/cuti/'.$id_smt.'/'.$id_mahasiswa_pt);
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	}
	
	function proses_keluar()
	{
		if($_SESSION['app_level']==3){
		$tgl_keluar = $this->input->post('tgl_keluar');
		$ket = $this->input->post('ket',true);
		$id_jns_keluar = $this->input->post('id_jns_keluar');
		$id_mahasiswa_pt = $this->input->post('id_mahasiswa_pt');
		$proses = $this->Main_model->proses_keluar($id_jns_keluar,$id_mahasiswa_pt,$tgl_keluar,$ket);
		
		if(isset($_FILES['surat']['name']))
		{
			$nama_dokumen = 'keluar-'.$id_mahasiswa_pt;
			$simpan_file = $this->Main_model->unggah_dokumen_re($nama_dokumen,'./dokumen/etc/','pdf','surat');
		}
		
		if($proses)
		{
			$whythis='proses_keluar';
			$whatdo='#id_mahasiswa_pt:'.$id_mahasiswa_pt.'#id_jns_keluar:'.$id_jns_keluar;
			$this->Main_model->akademik_log($whythis,$whatdo);
			
			$this->session->set_flashdata('msg', 'Data Tersimpan!');
			$this->session->set_flashdata('msg_clr', 'success');
		}else{
			$this->session->set_flashdata('msg', 'Gagal Tersimpan! atau Sudah Status Keluar');
			$this->session->set_flashdata('msg_clr', 'danger');
		}
		redirect('mahasiswa/keluar/'.$id_mahasiswa_pt);
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	}
	
	function unggah_dokumen()
	{
		$id_mhs = $this->input->post('id_mhs',true);
		$jenis_dokumen = $this->input->post('jenis_dokumen');
		
		if(isset($_FILES['dokumen']['name']))
		{
			$nama_dokumen = md5($jenis_dokumen.'-'.$id_mhs.'-'.date("YmdHis"));
			$simpan_file = $this->Main_model->unggah_dokumen_re($nama_dokumen,'./dokumen/mahasiswa/','jpeg|jpg|png','dokumen');
			if($simpan_file)
			{
				$nama_dokumen=base_url('dokumen/mahasiswa/'.$simpan_file['upload_data']['file_name']);
				$this->Mahasiswa_model->unggah_dokumen($id_mhs,$jenis_dokumen,$nama_dokumen);
			    echo $nama_dokumen.'?'.date("YmdHis");
			}else{
				echo 0;
			}
		}else{
			echo 0;
		}
		
		
	}
}
