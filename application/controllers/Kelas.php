<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){redirect(base_url('logout'));}
		if($_SESSION['logged_in']==FALSE){ redirect (base_url('logout'));}

		$this->load->model('Kelas_model');
	}
	
	function index()
	{
		if($_SESSION['app_level']!=1){
			$data['title'] 		= 'Daftar Kelas Kuliah';
			$data['content'] 	= 'kelas/tabel';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function detail($id_kelas_kuliah=null)
	{
		if($_SESSION['app_level']!=1){
		if($id_kelas_kuliah){
		$this->load->model('Krs_model');
		$kelas = $this->Krs_model->kelas_kuliah_mahasiswa_krs(null,null,$id_kelas_kuliah)->row();
		if($kelas){
			$data['kelas'] 		= $kelas;
			$data['title'] 		= 'Detail Kelas '.$kelas->nm_mk.' '.$kelas->nm_kls;
			$data['content'] 	= 'kelas/detail';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function sinkronisasi_studi_akhir($id_kelas_kuliah) {
        $this->load->model('Krs_model');
        $this->load->model('Aktivitas_model');

        $mahasiswa_studi_akhir = $this->Main_model->get_mhs_kelas($id_kelas_kuliah)->result();
        
        foreach ($mahasiswa_studi_akhir as $msa) {
	        $detail_krs = $this->Krs_model->list_kelas_krs($msa->id_mahasiswa_pt, $msa->id_smt)->result();
	        $mahasiswa_pt = $this->Aktivitas_model->mahasiswa_pt([ 'mp.id_mahasiswa_pt' => $msa->id_mahasiswa_pt ])->row();

	        foreach ($detail_krs as $mk) {
	            if ($mk->id_kat_mk == 3 OR $mk->id_kat_mk == 5) { // KERJA PRAKTEK & TUGAS AKHIR
	                $id_jenis_aktivitas_mahasiswa = ($mk->id_kat_mk == 3 ? 6 : 2);
	                    
	                $jml_aktivitas = $this->Aktivitas_model->anggota([ 'a.id_mahasiswa_pt' => $msa->id_mahasiswa_pt, 'as.id_jenis_aktivitas_mahasiswa' => $id_jenis_aktivitas_mahasiswa ])->num_rows();

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
	                         'id_mahasiswa_pt' => $msa->id_mahasiswa_pt,
	                         'jenis_peran' => '3',
	                         'status' => '0'
	                     ];
	                     $anggota = $this->Aktivitas_model->tambah_anggota($data_anggota);

	                     $data_sso = [
	                         'username' => $mahasiswa_pt->id_mhs,
	                         'id_level' => ($mk->id_kat_mk == 3 ? 16 : 7)
	                     ];

	                     $user_level = $this->Aktivitas_model->tambah_user_level($data_sso);
	                 }
	            }
	        }
        }

    	$this->session->set_flashdata('msg', 'sinkronisasi berhasil. Menu studi akhir sudah dimunculkan di mahasiswa.');
		$this->session->set_flashdata('msg_clr', 'info');
		redirect('kelas/detail/'.$id_kelas_kuliah);
    }
	
	function ganti_pengampu_kosong($id_kelas_kuliah=null)
	{
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		if($id_kelas_kuliah){
			$ajar_dosen = $this->Main_model->pengampu_kelas_kosong($id_kelas_kuliah)->row();
		if($ajar_dosen){
			$this->load->model('Krs_model');
			$kelas = $this->Krs_model->kelas_kuliah_simple(null,null,$id_kelas_kuliah)->row();
		
		if($kelas){
			$data['ajar_dosen'] 	= $ajar_dosen;
			$data['id_ajar_dosen'] 	= $ajar_dosen->id_kelas_kuliah;
			$data['id_kelas_kuliah'] 	= $id_kelas_kuliah;
			$data['kelas'] 		= $kelas;
			$data['title'] 		= 'Ubah Pengampu '.$kelas->nm_mk.' '.$kelas->nm_kls;
			$data['content'] 	= 'kelas/ganti_pengampu';
			$this->load->view('lyt/index',$data);
			
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }	
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function ganti_pengampu($id_ajar_dosen=null)
	{
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		if($id_ajar_dosen){
			$ajar_dosen = $this->Main_model->pengampu_kelas_kosong(null,$id_ajar_dosen)->row();
		
		if($ajar_dosen){
			$this->load->model('Krs_model');
			$kelas = $this->Krs_model->kelas_kuliah_simple(null,null,$ajar_dosen->id_kelas_kuliah)->row();
		
		if($kelas){
			$data['ajar_dosen'] 	= $ajar_dosen;
			$data['id_ajar_dosen'] 	= $id_ajar_dosen;
			$data['kelas'] 		= $kelas;
			$data['title'] 		= 'Ubah Pengampu '.$kelas->nm_mk.' '.$kelas->nm_kls;
			$data['content'] 	= 'kelas/ganti_pengampu';
			$this->load->view('lyt/index',$data);
			
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function ganti_jadwal($id_kelas_kuliah=null)
	{
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		if($id_kelas_kuliah){
			
			$this->load->model('Krs_model');
			$kelas = $this->Krs_model->kelas_kuliah_simple(null,null,$id_kelas_kuliah)->row();
		
		if($kelas){
			$this->load->model('Gedung_model');
			$data['id_gedung'] 	= $this->Gedung_model->get_gedung(null,1);
			$data['id_kelas_kuliah']= $id_kelas_kuliah;
			$data['kelas'] 		= $kelas;
			$data['title'] 		= 'Ubah Jadwal '.$kelas->nm_mk.' '.$kelas->nm_kls;
			$data['content'] 	= 'kelas/ganti_jadwal';
			$this->load->view('lyt/index',$data);
			
		
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function hapus($id_kelas_kuliah=null)
	{
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		$cek_kelas	= $this->Kelas_model->check_count($id_kelas_kuliah,'nilai');
		$cek_krs 	= $this->Kelas_model->check_count($id_kelas_kuliah,'krs');
		if($id_kelas_kuliah){
		$cek_kelas	= $this->Kelas_model->check_count($id_kelas_kuliah,'nilai');
		$cek_krs 	= $this->Kelas_model->check_count($id_kelas_kuliah,'krs');
		if($cek_kelas == 0 && $cek_krs == 0)
		{
			$proses = $this->Kelas_model->hapus_kelas($id_kelas_kuliah);
			if($proses)
			{
				$whythis='hapus_kelas';
				$whatdo='#id_kelas_kuliah:'.$id_kelas_kuliah;
				$this->Main_model->akademik_log($whythis,$whatdo);
				
				$this->session->set_flashdata('msg', 'Data Terhapus!');
				$this->session->set_flashdata('msg_clr', 'success');
				redirect('kelas/');
			}else{
				$this->session->set_flashdata('msg', 'Gagal Dihapus!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('kelas/detail/'.$id_kelas_kuliah);
			}
		}else{
			$this->session->set_flashdata('msg', 'Gagal Dihapus! Masih ada Mahasiswa KRS/ Nilai');
			$this->session->set_flashdata('msg_clr', 'danger');
			redirect('kelas/detail/'.$id_kelas_kuliah);
		}
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function ganti_jadwal_ujian($jenis=null,$id_kelas_kuliah=null)
	{
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		if($id_kelas_kuliah && $jenis){
		
		if(strtoupper($jenis) == 'UAS' || strtoupper($jenis) =='UTS'){
			$this->load->model('Krs_model');
			$kelas = $this->Krs_model->kelas_kuliah_simple(null,null,$id_kelas_kuliah)->row();
		
		if($kelas){
			$this->load->model('Gedung_model');
			$data['id_gedung'] 	= $this->Gedung_model->get_gedung(null,1);
			$data['id_kelas_kuliah']= $id_kelas_kuliah;
			$data['kelas'] 		= $kelas;
			$data['jenis'] 		= strtolower($jenis);
			$data['title'] 		= 'Ubah Jadwal '.strtoupper($jenis).' '.$kelas->nm_mk.' '.$kelas->nm_kls;
			$data['content'] 	= 'kelas/ganti_jadwal_ujian';
			$this->load->view('lyt/index',$data);
			
		
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function proses_ganti_jadwal($id_kelas_kuliah=null)
	{
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		if($id_kelas_kuliah){
			$this->load->model('Krs_model');
			$kelas = $this->Krs_model->kelas_kuliah_simple(null,null,$id_kelas_kuliah)->row();
		    $team_teach	= ($this->input->post('team_teach')==1)?'Ya':'Tdk';
		if($kelas){
			if($this->input->post('id_ruangan')==0){
				$id_ruangan	=0;
				$hari_kuliah=7;
				$jam_mulai	='00:00:00';
				$jam_selesai='00:00:00';
			}else{
				$id_ruangan		=$this->input->post('id_ruangan');
				$hari_kuliah	=$this->input->post('hari_kuliah');
				$jam_mulai		=$this->input->post('jam_mulai');
				$jam_selesai	=$this->input->post('jam_selesai');
			}
			
			$kelas=array(
				'id_kelas_kuliah'=>$id_kelas_kuliah,
				'id_ruangan'	=>$id_ruangan,
				'hari_kuliah'	=>$hari_kuliah,
				'jam_mulai'		=>$jam_mulai,
				'jam_selesai'	=>$jam_selesai,
			);
			
			$proses = $this->Kelas_model->proses_ganti_jadwal($kelas);
			if($proses)
			{
				$whythis='ganti_jadwal';
				$whatdo='#id_kelas_kuliah:'.$id_kelas_kuliah.'#team_teach'.$team_teach;
				$this->Main_model->akademik_log($whythis,$whatdo);
				
				$this->session->set_flashdata('msg', 'Data Tersimpan!');
				$this->session->set_flashdata('msg_clr', 'success');
				redirect('kelas/detail/'.$id_kelas_kuliah);
			}else{
				$this->session->set_flashdata('msg', 'Gagal Tersimpan!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('kelas/detail/'.$id_kelas_kuliah);
			}
			
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function proses_ganti_jadwal_ujian($jenis=null,$id_kelas_kuliah=null)
	{
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		if($id_kelas_kuliah && $jenis){
		
		if(strtoupper($jenis) == 'UAS' || strtoupper($jenis) =='UTS'){
			$this->load->model('Krs_model');
			$kelas = $this->Krs_model->kelas_kuliah_simple(null,null,$id_kelas_kuliah)->row();
		
		if($kelas){
			if($this->input->post('id_ruangan')==0){
				$id_ruangan	=0;
				$tgl_ujian=null;
				$jam_mulai	='00:00:00';
				$jam_selesai='00:00:00';
			}else{
				$id_ruangan		=$this->input->post('id_ruangan');
				$tgl_ujian		=$this->input->post('tgl');
				$jam_mulai		=$this->input->post('jam_mulai');
				$jam_selesai	=$this->input->post('jam_selesai');
			}
			
			if($jenis=='uts')
			{
				$data=array(
					'id_kelas_kuliah'	=>$id_kelas_kuliah,
					'id_ruangan_uts'	=>$id_ruangan,
					'tgl_uts'=>$tgl_ujian,
					'jam_mulai_uts'	=>$jam_mulai,
					'jam_selesai_uts'=>$jam_selesai,
				);
			}
			
			if($jenis=='uas')
			{
				$data=array(
					'id_kelas_kuliah'=>$id_kelas_kuliah,
					'id_ruangan_uas'=>$id_ruangan,
					'tgl_uas'=>$tgl_ujian,
					'jam_mulai_uas'	=>$jam_mulai,
					'jam_selesai_uas'=>$jam_selesai,
				);
			}
			
			$proses = $this->Kelas_model->proses_ganti_jadwal_ujian($jenis,$data);
			if($proses)
			{
				$whythis='ganti_jadwal_ujian';
				$whatdo='#id_kelas_kuliah:'.$id_kelas_kuliah;
				$this->Main_model->akademik_log($whythis,$whatdo);
				
				$this->session->set_flashdata('msg', 'Data Tersimpan!');
				$this->session->set_flashdata('msg_clr', 'success');
				redirect('kelas/detail/'.$id_kelas_kuliah);
			}else{
				$this->session->set_flashdata('msg', 'Gagal Tersimpan!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('kelas/detail/'.$id_kelas_kuliah);
			}
			
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function proses_ganti_pengampu($id_ajar_dosen=null)
	{
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		if($id_ajar_dosen){
			$ajar_dosen = $this->Main_model->pengampu_kelas_kosong(null,$id_ajar_dosen)->row();
		
		if($ajar_dosen){
			$team_teach	= ($this->input->post('team_teach')==1)?'Ya':'Tdk';
			$id_smt=$this->input->post('id_smt');
			$id_dosen=$this->input->post('id_dosen');
			$id_dosen_old=$this->input->post('id_dosen_old');
			/*----check maks sks---*/
			if($_SESSION['kode_fak'] != 7){
			    $id_dosen = ($this->Main_model->check_maks_sks_dosen($id_dosen,$id_smt,$ajar_dosen->sks_subst_tot))?$id_dosen:'0';
			}
			$proses = $this->Kelas_model->proses_ganti_pengampu($id_ajar_dosen,$id_dosen);
			if($proses)
			{
				$whythis='ganti_pengampu';
				$whatdo='#id_ajar_dosen:'.$id_ajar_dosen.'#id_kelas_kuliah:'.$ajar_dosen->id_kelas_kuliah.'#id_dosen:'.$id_dosen.'#id_dosen_old:'.$id_dosen_old.'#team_teach'.$team_teach;
				$this->Main_model->akademik_log($whythis,$whatdo);
				
				$this->session->set_flashdata('msg', 'Data Tersimpan!');
				$this->session->set_flashdata('msg_clr', 'success');
				redirect('kelas/detail/'.$ajar_dosen->id_kelas_kuliah);
			}else{
				$this->session->set_flashdata('msg', 'Gagal Tersimpan!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('kelas/detail/'.$ajar_dosen->id_kelas_kuliah);
			}
			
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function ganti_kuota($id_kelas_kuliah=null)
	{
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		if($id_kelas_kuliah){
			$this->load->model('Krs_model');
			$kelas = $this->Krs_model->kelas_kuliah_simple(null,null,$id_kelas_kuliah)->row();
		
		if($kelas){
			
			$kuota_kelas = $this->input->post('kuota_kelas');
			
			$proses = $this->Kelas_model->ganti_kuota($id_kelas_kuliah,$kuota_kelas);
			if($proses)
			{
				$whythis='ganti_kuota';
				$whatdo='#id_kelas_kuliah:'.$id_kelas_kuliah;
				$this->Main_model->akademik_log($whythis,$whatdo);
				
				$this->session->set_flashdata('msg', 'Data Tersimpan!');
				$this->session->set_flashdata('msg_clr', 'success');
				redirect('kelas/detail/'.$id_kelas_kuliah);
			}else{
				$this->session->set_flashdata('msg', 'Gagal Tersimpan!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('kelas/detail/'.$id_kelas_kuliah);
			}
			
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function ganti_nm_kls($id_kelas_kuliah=null)
	{
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		if($id_kelas_kuliah){
			$this->load->model('Krs_model');
			$kelas = $this->Krs_model->kelas_kuliah_simple(null,null,$id_kelas_kuliah)->row();
		
		if($kelas){
			
			$nm_kls = $this->input->post('nm_kls');
			
			$proses = $this->Kelas_model->ganti_nm_kls($id_kelas_kuliah,$nm_kls);
			if($proses)
			{
				$whythis='ganti_nm_kls';
				$whatdo='#id_kelas_kuliah:'.$id_kelas_kuliah;
				$this->Main_model->akademik_log($whythis,$whatdo);
				
				$this->session->set_flashdata('msg', 'Data Tersimpan!');
				$this->session->set_flashdata('msg_clr', 'success');
				redirect('kelas/detail/'.$id_kelas_kuliah);
			}else{
				$this->session->set_flashdata('msg', 'Gagal Tersimpan!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('kelas/detail/'.$id_kelas_kuliah);
			}
			
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function add()
	{
		$check = $this->Main_model->get_konfigurasi('buat_kelas')->row();
		if($check->value_konfigurasi=='on'){
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
			$this->load->model('Gedung_model');
			$data['id_gedung'] 	= $this->Gedung_model->get_gedung(null,1);
			$data['title'] 		= 'Buat Kelas Kuliah';
			$data['content'] 	= 'kelas/add';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Tutup';	$data['content'] = 'lyt/pesan'; $data['pesan'] = '<span class="text-danger h3">Pembuatan Kelas Kuliah di tutup. Hubungi Akademik Universitas.</span>';	$this->load->view('lyt/index',$data); }
		
	}
	
	function simpan_kelas_kuliah()
	{
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
			
		$kode_prodi	= $this->input->post('kode_prodi');
		$id_matkul	= $this->input->post('id_matkul');
		$team_teach	= ($this->input->post('team_teach')==1)?'Ya':'Tdk';
		$sks		= $this->Main_model->get_mata_kuliah($id_matkul)->row();
		$id_smt		= $this->input->post('id_smt');
		if($this->input->post('id_ruangan')==0){
			$id_ruangan	=0;
			$hari_kuliah=7;
			$jam_mulai	='00:00:00';
			$jam_selesai='00:00:00';
		}else{
			$id_ruangan		=$this->input->post('id_ruangan');
			$hari_kuliah	=$this->input->post('hari_kuliah');
			$jam_mulai		=$this->input->post('jam_mulai');
			$jam_selesai	=$this->input->post('jam_selesai');
		}	
		
		$kelas=array(
			'id_smt'		=>$id_smt,
			'nm_kls'		=>strtoupper(htmlentities($this->input->post('nm_kls'))),
			'kuota_kelas'	=>$this->input->post('kuota_kelas'),
			'id_ruangan'	=>$id_ruangan,
			'hari_kuliah'	=>$hari_kuliah,
			'jam_mulai'		=>$jam_mulai,
			'jam_selesai'	=>$jam_selesai,
			'sks_mk'		=>$sks->sks_mk,
			'sks_tm'		=>$sks->sks_tm,
			'sks_prak'		=>$sks->sks_prak,
			'sks_prak_lap'	=>$sks->sks_prak_lap,
			'sks_sim'		=>$sks->sks_sim,
			'id_matkul'		=>$id_matkul,
			'kode_prodi'	=>$kode_prodi
		);
		
		
		$result=$this->Kelas_model->simpan_kelas_kuliah($kelas);
		if($result){
			
		//jika diinputkan dosen pengampu
		if($_POST['id_dosen']){
			$id_dosen=$_POST['id_dosen'];
			//untuk membagi sks jika dosen lebih dari 1
			$bagi=count($id_dosen);
			
			$sks_subst_tot=$sks->sks_mk/$bagi;
			$sks_tm_subst=$sks->sks_tm/$bagi;
			$sks_prak_subst=$sks->sks_prak/$bagi;
			$sks_prak_lap_subst=$sks->sks_prak_lap/$bagi;
			$sks_sim_subst=$sks->sks_sim/$bagi;
			
			foreach($id_dosen as $r){
			    $id_dosen_simpan = $r;
			    if($_SESSION['kode_fak'] != 7){
				    /*----check maks sks---*/
				    $id_dosen_simpan = ($this->Main_model->check_maks_sks_dosen($r,$id_smt,$sks_subst_tot))?$r:'0';
			    }
				$dosen=array(
					'id_dosen'=>$id_dosen_simpan,
					'id_kelas_kuliah'=>$result,
					'sks_subst_tot'=>$sks_subst_tot,
					'sks_tm_subst'=>$sks_tm_subst,
					'sks_prak_subst'=>$sks_prak_subst,
					'sks_prak_lap_subst'=>$sks_prak_lap_subst,
					'sks_sim_subst'=>$sks_sim_subst,
					'id_smt'=>$id_smt,
				);
				$this->Kelas_model->simpan_ajar_dosen($dosen);
			}
		}else{
			$sks_subst_tot=$sks->sks_mk;
			$sks_tm_subst=$sks->sks_tm;
			$sks_prak_subst=$sks->sks_prak;
			$sks_prak_lap_subst=$sks->sks_prak_lap;
			$sks_sim_subst=$sks->sks_sim;
			$dosen=array(
					'id_smt'=>$id_smt,
					'id_dosen'=>'0',
					'id_kelas_kuliah'=>$result,
					'sks_subst_tot'=>$sks_subst_tot,
					'sks_tm_subst'=>$sks_tm_subst,
					'sks_prak_subst'=>$sks_prak_subst,
					'sks_prak_lap_subst'=>$sks_prak_lap_subst,
					'sks_sim_subst'=>$sks_sim_subst
				);
				
				$this->Kelas_model->simpan_ajar_dosen($dosen);
		}
			$whythis='simpan_kelas_kuliah';
		    $whatdo='#id_kelas_kuliah:'.$result.'#team_teach'.$team_teach;
		    $this->Main_model->akademik_log($whythis,$whatdo);
		    
			$this->session->set_flashdata('msg', 'Berhasil!');
			$this->session->set_flashdata('msg_clr', 'success');
		    redirect('kelas/detail/'.$result);
		}else{
			$this->session->set_flashdata('msg', 'Gagal!');
			$this->session->set_flashdata('msg_clr', 'danger');
		    redirect('kelas/add');
		}
		
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function json()
	{
		$this->load->model('Kelas_data_model');
	    $list = $this->Kelas_data_model->get_datatables();
        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
            $uts = '';
			$uas = '';
			$kuliah = '';
			if($field->hari_kuliah) $kuliah  = '<div class="jadwal_kuliah" style="display:none">'.nama_hari($field->hari_kuliah).', '.$field->jam_mulai .' s/d '.$field->jam_selesai.'<br>G. '.$field->nama_gedung .' R.'.$field->nama_ruangan.'</div>';
			if($field->tgl_uts) $uts  = '<div class="jadwal_uts" style="display:none"><a href="'.base_url('cetak/sampul/uts/'.$field->id_kelas_kuliah).'" class="text-decoration-none" target="_blank">'.tanggal_indo($field->tgl_uts).', '.$field->jam_mulai_uts.' s.d '.$field->jam_selesai_uts.'<br>G. '.$field->nama_gedung_uts.' R. '.$field->nama_ruangan_uts.'</a></div>';
			if($field->tgl_uas) $uas  = '<div class="jadwal_uas" style="display:none"><a href="'.base_url('cetak/sampul/uas/'.$field->id_kelas_kuliah).'" class="text-decoration-none" target="_blank">'.tanggal_indo($field->tgl_uas).', '.$field->jam_mulai_uas.' s.d '.$field->jam_selesai_uas.'<br>G. '.$field->nama_gedung_uas.' R. '.$field->nama_ruangan_uas.'</a></div>';
			
			$no++;
            $row = array();
            
            $row[] = nama_smt($field->id_smt);
            $row[] = '<a href="'.base_url('kelas/detail/'.$field->id_kelas_kuliah).'">'.$field->nm_mk.' '.$field->nm_kls.'</a>';
            $row[] = $field->inisial_fak.' '.$field->nama_prodi;
            $row[] = $field->count_peserta.'/ '.$field->kuota_kelas;
            $row[] = $field->count_pertemuan.'/ 16';
            $row[] = $kuliah;
            $row[] = $uts;
            $row[] = $uas;
			$row[] = '<div class="pengampu" style="display:none">'.$this->ref_pengampu($field->id_kelas_kuliah).'</div>';
			$row[] = '<div class="persepsi" style="display:none">'.$field->skor_persepsi.'</div>';
			
            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Kelas_data_model->count_all(),
            "recordsFiltered" => $this->Kelas_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	function ref_ruangan_ujian()
	{
		$_POST = json_decode($this->input->raw_input_stream, true);
		
		$id_gedung	=$this->input->post('id_gedung');
		$id_smt		=$this->input->post('id_smt');
		$tgl_ujian 	=$this->input->post('tgl');
		$jenis 		=$this->input->post('jenis');
		$jam_mulai	=(strlen($this->input->post('jam_mulai'))!=5)?$this->input->post('jam_mulai').':00':$this->input->post('jam_mulai');
		$jam_selesai=(strlen($this->input->post('jam_selesai'))!=5)?$this->input->post('jam_selesai').':00':$this->input->post('jam_selesai');
		
		if($jenis=='uts')
		{
			$data=array(
				'id_smt'=>$id_smt,
				'id_gedung'	=>$id_gedung,
				'tgl_uts'=>$tgl_ujian,
				'jam_mulai_uts'	=>$jam_mulai,
				'jam_selesai_uts'=>$jam_selesai,
			);
		}
		
		if($jenis=='uas')
		{
			$data=array(
				'id_smt'=>$id_smt,
				'id_gedung'	=>$id_gedung,
				'tgl_uas'=>$tgl_ujian,
				'jam_mulai_uas'	=>$jam_mulai,
				'jam_selesai_uas'=>$jam_selesai,
			);
		}
		
		
		$result=$this->Kelas_model->ref_ruangan_ujian($jenis,$data)->result();
		
		if($result){
			$option="<option>Pilih Ruangan</option>";
			foreach ($result as $key=>$value ){
				$option.= '<option value='.$value->id_ruangan.'>'.$value->nama_ruangan.'</option>';
			}
		}else{
			$option="<option>Ruangan Penuh!</option>";
		}
		echo $option;
	}

	function ref_pengampu($id_kelas_kuliah)
	{
		$option='';
		$pengampu=$this->Main_model->pengampu_kelas($id_kelas_kuliah)->result();
		if($pengampu)
		{
			foreach($pengampu as $keys=>$values)
			{
				$option.='<strong>'.$values->nidn.'</strong> '.$values->nm_sdm.' ('.$values->sks_subst_tot.' SKS)<br>';
			}
		}
		return $option;
	}
}
