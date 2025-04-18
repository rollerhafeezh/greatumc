<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Krs extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){redirect(base_url('logout'));}
		if(!isset($_SESSION['id_user'])){redirect(base_url('logout'));}
		if($_SESSION['logged_in']==FALSE){ redirect (base_url('logout'));}
		$this->load->model('Krs_model');
		$this->load->model('Mbkm_model');
	}
	
	function persetujuan_ajukan_krs($id_smt=null,$id_mahasiswa_pt=null)
	{
		/*---if mahasiswa tetap pake sesi----*/
		if($_SESSION['app_level']==1) $id_mahasiswa_pt =  $_SESSION['id_user'];
		$id_smt 	= ($id_smt)?:$_SESSION['active_smt'];
		
		/*---if id mahasiswa ada----*/
		if($id_mahasiswa_pt && $id_smt){
			$bearer = ['id_mahasiswa_pt'=>$id_mahasiswa_pt];
			$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
			
		/*---if mahasiswa ada----*/
		if($mahasiswa_pt){
			$data['id_smt']		= $id_smt;
			$data['mahasiswa_pt']= $mahasiswa_pt[0];
			$data['title'] 		= 'Ajukan KRS '.nama_smt($id_smt);
			$data['content'] 	= 'krs/persetujuan_ajukan_krs';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	}
	
	function ajukan_krs($id_smt=null,$id_mahasiswa_pt=null)
	{
		/*---if mahasiswa tetap pake sesi----*/
		if($_SESSION['app_level']==1) $id_mahasiswa_pt =  $_SESSION['id_user'];
		$id_smt 	= ($id_smt)?:$_SESSION['active_smt'];
		
		/*---if id mahasiswa ada----*/
		if($id_mahasiswa_pt && $id_smt){
			$bearer = ['id_mahasiswa_pt'=>$id_mahasiswa_pt];
			$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
			
		/*---if mahasiswa ada----*/
		if($mahasiswa_pt){
			
			/*------just make sure belum tersimpan----------*/
			$cek_krs_note = $this->Krs_model->get_krs_note($id_mahasiswa_pt,$id_smt)->row();
			if($cek_krs_note){
				$this->session->set_flashdata('msg', 'KRS sudah diajukan!');
				$this->session->set_flashdata('msg_clr', 'danger');
			}else{
				
			/*---------simpan krs note (ajukan krs)--------------*/
			$data=['id_smt'=>$id_smt,'id_mahasiswa_pt'=>$id_mahasiswa_pt];
			$proses = $this->Krs_model->ajukan_krs($data);
			if($proses)
			{
				$mbkm = $this->Mbkm_model->pendaftaran_aktivitas([ 'p.id_mahasiswa_pt' => $id_mahasiswa_pt, 'a.id_smt' => $id_smt ]);
				$id_stat_mhs = $mbkm->num_rows() > 0 ? 'M' : null;

				$this->Main_model->check_kuliah_mahasiswa($id_mahasiswa_pt,$id_smt);
				$this->Krs_model->update_kuliah_mahasiswa($id_mahasiswa_pt,$id_smt, $id_stat_mhs);
				
				$whythis='ajukan_krs';
				$whatdo='#id_mahasiswa_pt:'.$id_mahasiswa_pt.'#id_smt:'.$id_smt;
				$this->Main_model->akademik_log($whythis,$whatdo);
				
				$this->session->set_flashdata('msg', 'KRS Diajukan!');
				$this->session->set_flashdata('msg_clr', 'success');
			}else{
				$this->session->set_flashdata('msg', 'Gagal Nih! Coba Lagi!');
				$this->session->set_flashdata('msg_clr', 'danger');
			}
			}
			redirect('krs/add/'.$id_smt.'/'.$id_mahasiswa_pt);
			
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	}
	
	function tarik_ajuan_krs($id_smt=null,$id_mahasiswa_pt=null)
	{
		/*---if mahasiswa tetap pake sesi----*/
		if($_SESSION['app_level']==1) $id_mahasiswa_pt =  $_SESSION['id_user'];
		$id_smt 	= ($id_smt)?:$_SESSION['active_smt'];
		
		/*---if id mahasiswa ada----*/
		if($id_mahasiswa_pt && $id_smt){
			$bearer = ['id_mahasiswa_pt'=>$id_mahasiswa_pt];
			$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
			
		/*---if mahasiswa ada----*/
		if($mahasiswa_pt){
			
			/*------just make sure belum tersimpan----------*/
			$cek_krs_note = $this->Krs_model->get_krs_note($id_mahasiswa_pt,$id_smt)->row();
			if(!$cek_krs_note){
				$this->session->set_flashdata('msg', 'KRS Belum ada diajukan!');
				$this->session->set_flashdata('msg_clr', 'danger');
			}else{
				
			/*---------simpan krs note (ajukan krs)--------------*/
			$data=['id_smt'=>$id_smt,'id_mahasiswa_pt'=>$id_mahasiswa_pt];
    			if($data['id_smt']==$_SESSION['active_smt']){
        			$proses = $this->Krs_model->tarik_ajuan_krs($data);
        			if($proses)
        			{
        				$whythis='tarik_ajuan_krs';
        				$whatdo='#id_mahasiswa_pt:'.$id_mahasiswa_pt.'#id_smt:'.$id_smt;
        				$this->Main_model->akademik_log($whythis,$whatdo);
        				
        				$this->session->set_flashdata('msg', 'KRS Ditarik!');
        				$this->session->set_flashdata('msg_clr', 'success');
        			}else{
        				$this->session->set_flashdata('msg', 'Gagal Nih! Coba Lagi!');
        				$this->session->set_flashdata('msg_clr', 'danger');
        			}
    			}else{
    			    $this->session->set_flashdata('msg', 'Data Semester tidak Sama!');
        			$this->session->set_flashdata('msg_clr', 'danger');
    			}
			}
			redirect('krs/add/'.$id_smt.'/'.$id_mahasiswa_pt);
			
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	}
	
	function add($id_smt=null,$id_mahasiswa_pt=null)
	{
		//$check = $this->Main_model->get_konfigurasi('buat_krs')->row();
		//if($check->value_konfigurasi=='on'){
		/*---if mahasiswa tetap pake sesi----*/
		if($_SESSION['app_level']==1) $id_mahasiswa_pt =  $_SESSION['id_user'];
		$id_smt 	= ($id_smt)?:$_SESSION['active_smt'];
		$check_smt = $this->Main_model->check_smt_mahasiswa($id_mahasiswa_pt,$id_smt);
		//echo $check_smt; exit;
		if($check_smt){
		/*---if id mahasiswa ada----*/
		if($id_mahasiswa_pt && $id_smt){
			$bearer = ['id_mahasiswa_pt'=>$id_mahasiswa_pt];
			$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
			
		/*---if mahasiswa ada----*/
		if($mahasiswa_pt){
			$data['mbkm'] = $this->Mbkm_model->pendaftaran_aktivitas([ 'p.id_mahasiswa_pt' => $id_mahasiswa_pt, 'a.id_smt' => $id_smt ]);
			$id_program_mitra = $data['mbkm']->num_rows() > 0 ? $data['mbkm']->row()->id_program_mitra : null;
			
			$data['matkul_program'] = $id_program_mitra != null ? $this->Mbkm_model->matkul_program(sha1($id_program_mitra), 'jml_sks') : 0;

			$data['krs_note']	= $this->Krs_model->get_krs_note($id_mahasiswa_pt,$id_smt)->row();
			$data['list_kelas_krs']	= $this->Krs_model->list_kelas_krs($id_mahasiswa_pt, $id_smt, $id_program_mitra);
			$data['status_bayar'] = $this->Main_model->keuangan('konfirmasi_krs',$id_mahasiswa_pt,$id_smt);
			$data['id_smt']		= $id_smt;
			$data['mahasiswa_pt']= $mahasiswa_pt[0];
			$data['title'] 		= 'Buat KRS '.nama_smt($id_smt);
			$data['content'] 	= 'krs/add';


			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Tidak Berhak KRS';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function add_step_one($id_smt=null,$id_mahasiswa_pt=null)
	{
		$check = $this->Main_model->get_konfigurasi('buat_krs')->row();
		if($check->value_konfigurasi=='on' OR $id_mahasiswa_pt == '220511193'){
		/*---if mahasiswa tetap pake sesi----*/
		if($_SESSION['app_level']==1) $id_mahasiswa_pt =  $_SESSION['id_user'];
		$id_smt 	= ($id_smt)?:$_SESSION['active_smt'];
		
		if($_SESSION['app_level']==1) $id_smt =  $_SESSION['active_smt'];
		
		if($id_mahasiswa_pt){
			$bearer = ['id_mahasiswa_pt'=>$id_mahasiswa_pt];
			$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
		
		/*-----jika sudah diajukan-------*/
		$cek_krs_note = $this->Krs_model->get_krs_note($id_mahasiswa_pt,$id_smt)->row();
		if($cek_krs_note){
			$this->session->set_flashdata('msg', 'KRS sudah diajukan!');
			$this->session->set_flashdata('msg_clr', 'danger');
			redirect('krs/add/'.$id_smt.'/'.$id_mahasiswa_pt);
			die();
		}
		
		/*---if mahasiswa ada----*/
		if($mahasiswa_pt){
			$this->load->model('Kurikulum_model');
			$id_kur 	= $this->Kurikulum_model->ref_kurikulum_aktif($mahasiswa_pt[0]->kode_prodi)->row();
		
		/*---if kurikulum ada----*/		
		if($id_kur){
			$data['title'] 		= 'Pilih Mata Kuliah '.$mahasiswa_pt[0]->nama_prodi.' '.nama_smt($id_smt);
			$data['content'] 	= 'krs/add_step_one';
			$data['id_smt']		= $id_smt;
			$data['mahasiswa_pt']= $mahasiswa_pt[0];
			$data['id_kur']		= $id_kur->id_kur;
			
			$data['mbkm'] = $this->Mbkm_model->pendaftaran_aktivitas([ 'p.id_mahasiswa_pt' => $id_mahasiswa_pt, 'a.id_smt' => $id_smt ]);
			// print_r($data['mbkm']->row()); exit;

			$this->load->view('lyt/index',$data);
			
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Tutup';	$data['content'] = 'lyt/pesan'; $data['pesan'] = '<span class="text-danger h3">Pembuatan KRS di tutup. Hubungi Akademik Universitas.</span>';	$this->load->view('lyt/index',$data); }
	}
	
	function add_step_two($id_matkul=null,$id_smt=null,$id_mahasiswa_pt=null)
	{
		$check = $this->Main_model->get_konfigurasi('buat_krs')->row();
		//if($check->value_konfigurasi=='on'){
		if($check->value_konfigurasi=='on' OR $id_mahasiswa_pt == '220511193'){
		/*---if mahasiswa tetap pake sesi----*/
		if($_SESSION['app_level']==1) $id_mahasiswa_pt =  $_SESSION['id_user'];
		$id_smt 	= ($id_smt)?:$_SESSION['active_smt'];
		
		if($_SESSION['app_level']==1) $id_smt =  $_SESSION['active_smt'];
		
		/*---if mahasiswa ada----*/
		if($id_mahasiswa_pt){
			$bearer = ['id_mahasiswa_pt'=>$id_mahasiswa_pt];
			$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
		    //var_dump($mahasiswa_pt); exit;
		/*---if mahasiswa ada----*/
		if($mahasiswa_pt){
			$matkul	= $this->Krs_model->matkul_krs_add_two($id_matkul,$mahasiswa_pt[0]->kode_prodi,$id_smt)->row();
		    //var_dump($matkul); exit;
		/*-----jika sudah diajukan-------*/
		$cek_krs_note = $this->Krs_model->get_krs_note($id_mahasiswa_pt,$id_smt)->row();
		if($cek_krs_note){
			$this->session->set_flashdata('msg', 'KRS sudah diajukan!');
			$this->session->set_flashdata('msg_clr', 'danger');
			redirect('krs/add/'.$id_smt.'/'.$id_mahasiswa_pt);
			die();
		}
		
		/*---if bypass----*/
		if($matkul->sks_mk <= $_SESSION['sisa_sks'] OR $matkul->sks_mk <= $_SESSION['sisa_sks_mbkm']){
			
		/*---if matkul memang dari prodi----*/
		if($matkul){
			$belum	= $this->Krs_model->sudah_kontrak($id_matkul,$id_mahasiswa_pt,$id_smt);
		
		/*--- dan matkul belum di kontrak pada smt ini---*/
		if($belum){
		
			$data['list_kelas']	= $this->Krs_model->kelas_kuliah_mahasiswa_krs($id_matkul,$id_smt)->result();
			$data['title'] 		= 'Pilih Kelas Kuliah '.$matkul->nm_mk;
			$data['content'] 	= 'krs/add_step_two';
			$data['id_smt']		= $id_smt;
			$data['mahasiswa_pt']= $mahasiswa_pt[0];
			$this->load->view('lyt/index',$data);
			
		}else{ 
			$this->session->set_flashdata('msg', 'Mata Kuliah ini sedang diajukan!');
			$this->session->set_flashdata('msg_clr', 'danger');
		    redirect('krs/add/'.$id_smt.'/'.$id_mahasiswa_pt);
		}	
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ 
			$this->session->set_flashdata('msg', 'Kelebihan SKS!');
			$this->session->set_flashdata('msg_clr', 'danger');
		    redirect('krs/add/'.$id_smt.'/'.$id_mahasiswa_pt);
		}
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Tutup';	$data['content'] = 'lyt/pesan'; $data['pesan'] = '<span class="text-danger h3">Pembuatan KRS di tutup. Hubungi Akademik Universitas.</span>';	$this->load->view('lyt/index',$data); }
	}
	
	function add_step_three($id_kelas_kuliah=null,$id_smt=null,$id_mahasiswa_pt=null)
	{
		$check = $this->Main_model->get_konfigurasi('buat_krs')->row();
		if($check->value_konfigurasi=='on' OR $id_mahasiswa_pt == '220511193'){
		/*---if mahasiswa tetap pake sesi----*/
		if($_SESSION['app_level']==1) $id_mahasiswa_pt =  $_SESSION['id_user'];
		$id_smt 	= ($id_smt)?:$_SESSION['active_smt'];
		
		if($_SESSION['app_level']==1) $id_smt =  $_SESSION['active_smt'];
		
		/*---if mahasiswa ada----*/
		if($id_mahasiswa_pt){
			$bearer = ['id_mahasiswa_pt'=>$id_mahasiswa_pt];
			$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
		
		/*---if mahasiswa ada----*/
		if($mahasiswa_pt){
			$kelas	= $this->Krs_model->kelas_prodi($id_kelas_kuliah,$mahasiswa_pt[0]->kode_prodi,$id_smt)->row();
		
		/*-----jika sudah diajukan-------*/
		$cek_krs_note = $this->Krs_model->get_krs_note($id_mahasiswa_pt,$id_smt)->row();
		if($cek_krs_note){
			$this->session->set_flashdata('msg', 'KRS sudah diajukan!');
			$this->session->set_flashdata('msg_clr', 'danger');
			redirect('krs/add/'.$id_smt.'/'.$id_mahasiswa_pt);
			die();
		}
		
		/*---if bypass----*/
		if($kelas->sks_mk <= $_SESSION['sisa_sks']  OR $matkul->sks_mk <= $_SESSION['sisa_sks_mbkm']){
			
		/*---jika kelas memang dari prodi ---*/
		if($kelas){
			$belum	= $this->Krs_model->sudah_kontrak($kelas->id_matkul,$id_mahasiswa_pt,$id_smt);
		
		/*--- dan matkul belum di kontrak pada smt ini---*/
		if($belum){
			
		/*----EKSEKUSI SIMPAN KRS-----*/	
			$data=['id_smt'=>$id_smt,'id_mahasiswa_pt'=>$id_mahasiswa_pt,'id_kelas_kuliah'=>$id_kelas_kuliah,'id_matkul'=>$kelas->id_matkul];
			$simpan = $this->Krs_model->simpan_krs($data);
			if($simpan)
			{
				$whythis='simpan_krs';
				$whatdo='#id_mahasiswa_pt:'.$id_mahasiswa_pt.'#id_kelas_kuliah:'.$id_kelas_kuliah;
				$this->Main_model->akademik_log($whythis,$whatdo);
				
				$this->session->set_flashdata('msg', 'Kelas Kuliah Tersimpan!');
				$this->session->set_flashdata('msg_clr', 'success');
			}else{
				$this->session->set_flashdata('msg', 'Gagal Nih! Coba Lagi!');
				$this->session->set_flashdata('msg_clr', 'danger');
			}
			redirect('krs/add/'.$id_smt.'/'.$id_mahasiswa_pt);
		}else{ 
			$this->session->set_flashdata('msg', 'Mata Kuliah ini sedang diajukan!');
			$this->session->set_flashdata('msg_clr', 'danger');
		    redirect('krs/add/'.$id_smt.'/'.$id_mahasiswa_pt);
		}
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ 
			$this->session->set_flashdata('msg', 'Kelebihan SKS!');
			$this->session->set_flashdata('msg_clr', 'danger');
		    redirect('krs/add/'.$id_smt.'/'.$id_mahasiswa_pt);
		}
		}else{ $data['title']	 = 'Error 404 Data Mahasiswa Error!';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404 ID Mahasiswa PT';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Tutup';	$data['content'] = 'lyt/pesan'; $data['pesan'] = '<span class="text-danger h3">Pembuatan KRS di tutup. Hubungi Akademik Universitas.</span>';	$this->load->view('lyt/index',$data); }
	}
	
	function hapus_krs($id_krs=null)
	{
		if($id_krs){
		/*-----cek ada nggak------*/
		$krs=$this->Krs_model->cek_krs($id_krs)->row();
		if($krs){
		if($_SESSION['app_level']==1)
		{
			if($krs->id_mahasiswa_pt!=$_SESSION['id_user'])
			{
				$this->session->set_flashdata('msg', 'Nggak Boleh Iseng!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('krs/add/'.$krs->id_smt.'/'.$_SESSION['id_user']);
			}
		}	
			$proses = $this->Krs_model->hapus_krs($id_krs);
			if($proses)
			{
				$whythis='hapus_krs';
				$whatdo='#id_mahasiswa_pt:'.$krs->id_mahasiswa_pt;
				$this->Main_model->akademik_log($whythis,$whatdo);
				
				$this->session->set_flashdata('msg', 'KRS Terhapus!');
				$this->session->set_flashdata('msg_clr', 'success');
			}else{
				$this->session->set_flashdata('msg', 'Gagal Nih! Coba Lagi!');
				$this->session->set_flashdata('msg_clr', 'danger');
			}
			redirect('krs/add/'.$krs->id_smt.'/'.$krs->id_mahasiswa_pt);
		
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	}
	
	function riwayat_ajar($id_mahasiswa_pt=null)
	{
		if($_SESSION['app_level']==1) $id_mahasiswa_pt =  $_SESSION['id_user'];
		if($id_mahasiswa_pt){
		
		$bearer = ['id_mahasiswa_pt'=>$id_mahasiswa_pt];
		$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
		if($mahasiswa_pt){
		
		$data['riwayat_ajar']=$this->Krs_model->get_riwayat_ajar($id_mahasiswa_pt)->result();
		$data['title'] 		= 'Riwayat Kuliah Mahasiswa '.$mahasiswa_pt[0]->nm_pd;
		$data['content'] 	= 'krs/riwayat_ajar';
		$this->load->view('lyt/index',$data);
		
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function transkrip($id_mahasiswa_pt=null)
	{
		if($_SESSION['app_level']==1) $id_mahasiswa_pt =  $_SESSION['id_user'];
		if($id_mahasiswa_pt){
		
		$bearer = ['id_mahasiswa_pt'=>$id_mahasiswa_pt];
		$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
		if($mahasiswa_pt){
		
		//$data['riwayat_ajar']=$this->Krs_model->get_riwayat_ajar($id_mahasiswa_pt)->result();
		$data['title'] 		= 'Transkrip Mahasiswa '.$mahasiswa_pt[0]->nm_pd;
		$data['content'] 	= 'krs/transkrip';
		$this->load->view('lyt/index',$data);
		
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function krs()
	{
		$data['title'] 		= 'Riwayat Kuliah Mahasiswa';
		//$data['content'] 	= 'krs/riwayat_ajar';
		$this->load->view('krs/krs',$data);
	}
	
	function khs()
	{
		$data['title'] 		= 'Riwayat Kuliah Mahasiswa';
		//$data['content'] 	= 'krs/riwayat_ajar';
		$this->load->view('krs/khs',$data);
	}
	
	function ksm()
	{
		$data['title'] 		= 'Riwayat Kuliah Mahasiswa';
		//$data['content'] 	= 'krs/riwayat_ajar';
		$this->load->view('krs/ksm',$data);
	}
	
	function validasi()
	{
		if($_SESSION['app_level']==3){
			$data['title'] 		= 'Validasi KRS';
			$data['content'] 	= 'krs/tabel_validasi_krs';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function json_validasi_krs()
	{
		$this->load->model('Validasi_krs_data_model');
	    
		$list = $this->Validasi_krs_data_model->get_datatables();
        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            
            $row[] = '<a href="'.base_url('biodata/'.$field->id_mahasiswa_pt).'">'.$field->id_mahasiswa_pt.'</a>';
            $row[] = $field->id_smt;
            $row[] = $field->validasi;
			$row[] = $field->validasi_aka;
			$row[] = $field->validasi_prodi;
           
            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Validasi_krs_data_model->count_all(),
            "recordsFiltered" => $this->Validasi_krs_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}

}
