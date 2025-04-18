<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Dhmd extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){redirect(base_url('logout'));}
		if($_SESSION['logged_in']==FALSE){ redirect (base_url('logout'));}
		$this->load->model('Dhmd_model');
		$this->load->model('Ujian_model');
		$this->load->model('Krs_model');
		$this->load->helper('security');
	}
	
	function simpan_rps($id_rps)
	{
		$data=array('id_rps'=>$id_rps,
				'cp_prodi'=>trim($this->input->post('cp_prodi')),
				'cp_mk'=>trim($this->input->post('cp_mk')),
				'deskripsi_singkat'=>trim($this->input->post('deskripsi_singkat')),
				'pokok_bahasan'=>trim($this->input->post('pokok_bahasan')),
				'pustaka_utama'=>trim($this->input->post('pustaka_utama')),
				'pustaka_pendukung'=>trim($this->input->post('pustaka_pendukung')),
				'media_perangkat_lunak'=>trim($this->input->post('media_perangkat_lunak')),
				'media_perangkat_keras'=>trim($this->input->post('media_perangkat_keras')),
		);
		$proses = $this->Dhmd_model->update_rps($data);
		if($proses)
		{
			$this->session->set_flashdata('msg', 'Berhasil!');
			$this->session->set_flashdata('msg_clr', 'success');
			$whythis='buat_rps';
			$whatdo='#id_rps:'.$id_rps;
			$this->Main_model->akademik_log($whythis,$whatdo);
		}else{
			$this->session->set_flashdata('msg', 'Gagal!');
			$this->session->set_flashdata('msg_clr', 'danger');
		}
		redirect('dhmd/rps_detail/'.$id_rps);
	}
	
	function simpan_rps_pertemuan($id_rps_pertemuan,$id_matkul,$id_rps,$minggu_ke)
	{
		$data=array('id_rps_pertemuan'=>$id_rps_pertemuan,
				'sub_cp_mk'=>trim($this->input->post('sub_cp_mk')),
				'indikator'=>trim($this->input->post('indikator')),
				'kriteria_bentuk_penilaian'=>trim($this->input->post('kriteria_bentuk_penilaian')),
				'metode_pembelajaran'=>trim($this->input->post('metode_pembelajaran')),
				'metode_pembelajaran_daring'=>trim($this->input->post('metode_pembelajaran_daring')),
				'materi_pembelajaran'=>trim($this->input->post('materi_pembelajaran')),
				'bobot'=>$this->input->post('bobot'),
			);
		$proses = $this->Dhmd_model->update_rps_pertemuan($data);
		if($proses)
		{
			$this->session->set_flashdata('msg', 'Berhasil!');
			$this->session->set_flashdata('msg_clr', 'success');
			$whythis='rps_pertemuan';
			$whatdo='#id_rps:'.$id_rps.'#id_rps_pertemuan:'.$id_rps_pertemuan;
			$this->Main_model->akademik_log($whythis,$whatdo);
		}else{
			$this->session->set_flashdata('msg', 'Gagal!');
			$this->session->set_flashdata('msg_clr', 'danger');
		}
		redirect('dhmd/buat_rps_pertemuan/'.$id_matkul.'/'.$id_rps.'/'.$minggu_ke);
	}
	
	function buat_rps($id_matkul=null)
	{
		if($_SESSION['app_level']==2){
		if($id_matkul)
		{
			$proses = $this->Dhmd_model->buat_rps($id_matkul);
			if($proses)
			{
				$this->session->set_flashdata('msg', 'Berhasil');
				$this->session->set_flashdata('msg_clr', 'success');
				$this->Dhmd_model->aktif_rps($id_matkul,$proses);
				$whythis='buat_rps';
				$whatdo='#id_matkul:'.$id_matkul.'#id_rps:'.$proses;
				$this->Main_model->akademik_log($whythis,$whatdo);
			}else{
				$this->session->set_flashdata('msg', 'Gagal!');
				$this->session->set_flashdata('msg_clr', 'danger');
			}
			
			redirect('dhmd/rps/'.$id_matkul);
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function rps($id_matkul=null)
	{
		
		if($id_matkul)
		{
		$id_matkul = xss_clean($id_matkul);
		$matkul = $this->Main_model->get_mata_kuliah($id_matkul)->row();
		if($matkul){
		if($_SESSION['app_level']==1)
		{
			$lempar = str_replace('=','',base64_encode($id_matkul));
			redirect(base_url('beranda/rps/'.$lempar));
		}
		$data['matkul'] 	= $matkul;
		$data['title'] 		= 'Daftar Rancangan Pembelajaran Semester '.$matkul->nm_mk.' '.$matkul->nama_prodi;
		$data['content'] 	= 'dhmd/rps';
		$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function rps_detail($id_rps=null)
	{
		if($id_rps)
		{
		$id_rps = xss_clean($id_rps);
		$rps = $this->Main_model->get_rps(null,$id_rps)->row();
		if($rps){
		$this->load->model('Matkul_model');
		$matkul = $this->Matkul_model->get_matkul($rps->id_matkul)->row();
		
		$data['rps'] 		= $rps;
		$data['matkul'] 	= $matkul;
		$data['title'] 		= 'Rancangan Pembelajaran Semester '.$matkul->nm_mk.' '.$matkul->nama_prodi;
		$data['content'] 	= 'dhmd/rps_view';
		$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function buat_rps_pertemuan($id_matkul=null,$id_rps=null,$minggu_ke=null)
	{
		if($_SESSION['app_level']==2){
		if($id_matkul && $id_rps && $minggu_ke)
		{
		$rps = $this->Main_model->get_rps(null,$id_rps)->row();
		if($rps){
			$this->load->model('Matkul_model');
			$rps_pertemuan = $this->Dhmd_model->check_rps_pertemuan($id_matkul,$id_rps,$minggu_ke)->row();
			$matkul = $this->Matkul_model->get_matkul($id_matkul)->row();
			
			$data['rps_pertemuan'] 	= $rps_pertemuan;
			$data['rps'] 		= $rps;
			$data['matkul'] 	= $matkul;
			$data['title'] 		= 'RPS '.$matkul->nm_mk.' '.$matkul->nama_prodi.' Minggu Ke-'.$minggu_ke;
			$data['content'] 	= 'dhmd/rps_pertemuan';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function aktifasi_rps($id_rps=null)
	{
		if($_SESSION['app_level']==2){
		if($id_rps)
		{
			$rps = $this->Main_model->get_rps(null,$id_rps)->row();
			if($rps)
			{
				$this->session->set_flashdata('msg', 'Berhasil');
				$this->session->set_flashdata('msg_clr', 'success');
				
				$this->Dhmd_model->aktif_rps($rps->id_matkul,$id_rps);
				$whythis='buat_rps';
				$whatdo='#id_matkul:'.$rps->id_matkul.'#id_rps:'.$id_rps;
				$this->Main_model->akademik_log($whythis,$whatdo);
			}
			
			redirect('dhmd/rps/'.$rps->id_matkul);
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function index()
	{
		$data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data);
	}
	
	function ujian($jenis=null)
	{
		if($_SESSION['app_level']!=1){
			$data['title'] 		= 'Monitoring Ujian';
			$data['content'] 	= 'dummi';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function kelas_kuliah_dosen()
	{
		if($_SESSION['app_level']==2){
			$data['kelas'] 		= $this->Dhmd_model->kelas_kuliah_dosen($_SESSION['username'],$_SESSION['active_smt'])->result();
			$data['title'] 		= 'Kelas Kuliah Dosen';
			$data['content'] 	= 'dhmd/kelas_kuliah_dosen';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function get_detail_ujian($kode_ujian=null)
	{
		if($_SESSION['app_level']==2){
		if($kode_ujian){
			
			$kode_ujian = base64_decode($kode_ujian);
			$jenis=explode('/',$kode_ujian);
		if(count($jenis)==2){
			$jenis_ujian = $jenis[0];
			$id_kelas_kuliah = $jenis[1];
			$kelas = $this->Krs_model->kelas_kuliah_mahasiswa_krs(null,null,$id_kelas_kuliah)->row();
			if($kelas){
				$data['kelas'] = $kelas;
				$data['jenis_ujian'] = $jenis_ujian;
				$data['id_kelas_kuliah'] = $id_kelas_kuliah;
				$this->load->view('dhmd/ujian_sekarang',$data);
			}else{ echo '<code> Kelas Kuliah tidak terdeteksi! </code>'; }
		}else{ echo '<code> Kode Ujian tidak terdeteksi!! </code>'; }
		}else{ echo '<code> Kode Ujian tidak terdeteksi!! </code>'; }
		}else{ echo '<code> Panik! </code>'; }
	}
	
	function pengawasan_ujian()
	{
		if($_SESSION['app_level']==2){
			$data['title'] 		= 'Scan QR Code Ujian';
			$data['content'] 	= 'ujian/pengawasan';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function update_kehadiran($id_bap_kuliah=null,$id_mahasiswa_pt=null,$status_hadir=null)
	{
		if($_SESSION['app_level']==2){
		if($id_bap_kuliah && $id_mahasiswa_pt){
		$detail_pertemuan = $this->Dhmd_model->get_pertemuan(null,$id_bap_kuliah)->row();
		if($detail_pertemuan)
		{
			$status_hadir=($status_hadir)?:'0';
			$data = ['id_bap_kuliah'=>$id_bap_kuliah,'id_mahasiswa_pt'=>$id_mahasiswa_pt,'id_kelas_kuliah'=>$detail_pertemuan->id_kelas_kuliah,'status'=>$status_hadir];
			$proses = $this->Dhmd_model->update_kehadiran($data);
			if($proses) echo 1; else echo 0;
			
		}else{ echo 0; }
		}else{ echo 0; }
		}else{ echo 0; }
	}
	
	function update_nilai_pertemuan($id_bap_peserta_kuliah=null,$nilai=null)
	{
		if($_SESSION['app_level']==2){
		if($id_bap_peserta_kuliah && $nilai)
		{
			$proses = $this->Dhmd_model->update_nilai_pertemuan($id_bap_peserta_kuliah,$nilai);
			if($proses) echo 1; else echo 0;
			
		}else{ echo 0; }
		}else{ echo 0; }
		
	}
	
	function kelas_kuliah_mahasiswa()
	{
		if($_SESSION['app_level']==1){
			$data['kelas'] 		= $this->Dhmd_model->kelas_kuliah_mahasiswa($_SESSION['id_user'],$_SESSION['active_smt'])->result();
			$data['title'] 		= 'Kelas Kuliah Mahasiswa';
			$data['content'] 	= 'dhmd/kelas_kuliah_mahasiswa';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function selesai_kelas($id_kelas_kuliah=null,$id_bap_kuliah=null)
	{
		if($_SESSION['app_level']==2){
		if($id_kelas_kuliah && $id_bap_kuliah)
		{
		$check_start = $this->Dhmd_model->check_start($id_bap_kuliah,$_SESSION['username'])->row();
		
		if($check_start){
		if($check_start->jam_selesai || $check_start->tanggal != date('Y-m-d') ){
			$this->session->set_flashdata('msg', 'Kelas Telah Selesai!');
			$this->session->set_flashdata('msg_clr', 'danger');
			redirect('dhmd/detail_pertemuan/'.$id_bap_kuliah);
		}else{
			
			$proses = $this->Dhmd_model->update_pertemuan($id_bap_kuliah,'jam_selesai',date("H:i:s"));
			if($proses)
			{
				$whythis='selesai_kelas';
				$whatdo='#id_kelas_kuliah:'.$id_kelas_kuliah.'#id_bap_kuliah:'.$id_bap_kuliah;
				$this->Main_model->akademik_log($whythis,$whatdo);
				
				$this->session->set_flashdata('msg', 'Terima Kasih.');
				$this->session->set_flashdata('msg_clr', 'success');
				redirect('dhmd/detail_pertemuan/'.$id_bap_kuliah);
			}else{
				$this->session->set_flashdata('msg', 'Gagal Menyelesaikan Kelas!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('dhmd/detail_pertemuan/'.$id_bap_kuliah);
			}
		}
		
		}else{ $data['title']	 = 'Error 404b';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404a';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function mulai_kelas($id_kelas_kuliah=null,$jenis=null)
	{
		if($_SESSION['app_level']==2){
		if($id_kelas_kuliah && $jenis)
		{
		
		$kelas = $this->Krs_model->kelas_kuliah_mahasiswa_krs(null,null,$id_kelas_kuliah)->row();
		$ajar_dosen = true;
		if($jenis=='kuliah'){
		$ajar_dosen 	= $this->Main_model->pengampu_kelas_kosong($id_kelas_kuliah,null,$_SESSION['id_user'])->row();
		
		if($kelas && $ajar_dosen){
		$cek_hari = $this->Dhmd_model->check_pertemuan($id_kelas_kuliah,date("Y-m-d"))->row();
		if($cek_hari){
			$this->session->set_flashdata('msg', 'Sudah ada Pertemuan Hari ini!');
			$this->session->set_flashdata('msg_clr', 'danger');
			redirect('dhmd/detail_pertemuan/'.$cek_hari->id_bap_kuliah);
		}else{
			$data = array(
				'id_kelas_kuliah'=>$id_kelas_kuliah,
				'id_ruangan'=>$kelas->id_ruangan,
				'hari'=>date('N'),
				'tanggal'=>date('Y-m-d'),
				'jam_mulai'=>date('H:i:s'),
				'input_by'=>$_SESSION['username'],
			);
			$proses = $this->Dhmd_model->mulai_kuliah($data);
			if($proses)
			{
				$whythis='mulai_kelas';
				$whatdo='#id_kelas_kuliah:'.$id_kelas_kuliah.'#id_bap_kuliah:'.$proses;
				$this->Main_model->akademik_log($whythis,$whatdo);
				
				$this->session->set_flashdata('msg', 'Selamat Mengajar.');
				$this->session->set_flashdata('msg_clr', 'success');
				redirect('dhmd/detail_pertemuan/'.$proses);
			}else{
				$this->session->set_flashdata('msg', 'Gagal Memulai Kelas!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('dhmd/daftar_pertemuan/'.$id_kelas_kuliah);
			}
		}
		}else{ $data['title']	 = 'Error 404c';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else if(($jenis == 'uas' || $jenis == 'uts') && $kelas){
		$cek_hari = $this->Dhmd_model->check_pertemuan($id_kelas_kuliah,date("Y-m-d"))->row();
		if($cek_hari){
			$this->session->set_flashdata('msg', 'Sudah ada Pertemuan Hari ini!');
			$this->session->set_flashdata('msg_clr', 'danger');
			redirect('dhmd/detail_pertemuan/'.$cek_hari->id_bap_kuliah);
		}else{
			$jam_sekarang = date('H:i:s');
			$tanggal_sekarang = date("Y-m-d");
			$jam_mulai_ujian = '00:00:00';
			$jam_selesai_ujian = '00:00:00';
			$tanggal_ujian = '0000-00-00';
			$id_ruangan = 0;
			if($jenis=='uts')
			{
				$id_ruangan = $kelas->id_ruangan_uts;
				$jam_mulai_ujian = $kelas->jam_mulai_uts;
				$jam_selesai_ujian = $kelas->jam_selesai_uts;
				$tanggal_ujian = $kelas->tgl_uts;
			}
			if($jenis=='uas')
			{
				$id_ruangan = $kelas->id_ruangan_uas;
				$jam_mulai_ujian = $kelas->jam_mulai_uas;
				$jam_selesai_ujian = $kelas->jam_selesai_uas;
				$tanggal_ujian = $kelas->tgl_uas;
			}
			if($tanggal_sekarang == $tanggal_ujian && ($jam_sekarang >= $jam_mulai_ujian && $jam_sekarang <= $jam_selesai_ujian)){
				$data = array(
					'tipe_kuliah'=>$jenis,
					'id_kelas_kuliah'=>$id_kelas_kuliah,
					'id_ruangan'=>$id_ruangan,
					'hari'=>date('N'),
					'tanggal'=>date('Y-m-d'),
					'jam_mulai'=>date('H:i:s'),
					'input_by'=>$_SESSION['username'],
				);
				$proses = $this->Dhmd_model->mulai_kuliah($data);
				if($proses)
				{
					$whythis='mulai_ujian';
					$whatdo='#id_kelas_kuliah:'.$id_kelas_kuliah.'#id_bap_kuliah:'.$proses;
					$this->Main_model->akademik_log($whythis,$whatdo);
					
					$this->session->set_flashdata('msg', 'Selamat Mengawas Ujian.');
					$this->session->set_flashdata('msg_clr', 'success');
					redirect('dhmd/absensi_ujian/'.$jenis.'/'.$id_kelas_kuliah);
				}else{
					$this->session->set_flashdata('msg', 'Gagal Memulai Ujian!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('dhmd/pengawasan_ujian/');
				}
			}else{
				$this->session->set_flashdata('msg', 'Gagal Memulai Ujian!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('dhmd/pengawasan_ujian/');
			}
			
		}
		}else{ $data['title']	 = 'Error 404b';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404a';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function arsip_kelas_kuliah_dosen($id_dosen=null)
	{
		if($_SESSION['app_level']!=1){
	        
	    if($_SESSION['app_level']==2) $id_dosen = $_SESSION['username'];
	    
	    if($id_dosen){
	    $bearer = ['nidn'=>$id_dosen];
		$dosen = $this->Main_model->post_api('dosen/dosen',$bearer);
		if($dosen){
		    
		    $data['dosen']      = $dosen[0];
	        $data['title'] 		= 'Arsip Kelas Kuliah '.$dosen[0]->nm_sdm;
			$data['content'] 	= 'dhmd/arsip_kelas_kuliah_dosen';
			$this->load->view('lyt/index',$data);
			
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	    }else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function arsip_kelas_kuliah_mahasiswa()
	{
		if($_SESSION['app_level']==1){
			$data['title'] 		= 'Arsip Kelas Kuliah Mahasiswa';
			$data['content'] 	= 'dhmd/arsip_kelas_kuliah_mahasiswa';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function simpan_aktifitas()
	{
		$id_bap_kuliah = $this->input->post('id_bap_kuliah',true);
		if($_SESSION['app_level']==1){
			$check_bap= $this->Dhmd_model->check_hak_mahasiswa($_SESSION['id_user'],null,$id_bap_kuliah)->row();
			if(!$check_bap)
			{
				echo 0; die();
			}
		}
		$isi_komen = $this->input->post('isi_komen',true);
		$data = [	'id_bap_kuliah'=>$id_bap_kuliah,
					'isi_komen'=>$isi_komen,
					'id_user'=>$_SESSION['id_user'],
					'nama_pengguna'=>$_SESSION['nama_pengguna'],
					'level_name'=>$_SESSION['level_name']
				];
		$proses = $this->Dhmd_model->simpan_bap_aktifitas($data);
		if($proses){
			if(isset($_FILES['addt_file']['name']))
			{
				$nama_dokumen = $id_bap_kuliah.'-'.$_SESSION['id_user'];
				$simpan_file = $this->Main_model->unggah_dokumen($nama_dokumen,'./dokumen/aktifitas_perkuliahan/','*','addt_file');
				if($simpan_file)
				{
					$nama_dokumen=base_url('dokumen/aktifitas_perkuliahan/'.$simpan_file['upload_data']['file_name']);
					$this->Dhmd_model->update_bap_aktifitas($proses,'addt_file',$nama_dokumen);
				}
			}
			echo 1;
		}else{ echo 0; }
	}
	
	function unggah_tugas()
	{
		$id_bap_kuliah = $this->input->post('id_bap_kuliah',true);
		if($_SESSION['app_level']==1){
			$check_bap= $this->Dhmd_model->check_hak_mahasiswa($_SESSION['id_user'],null,$id_bap_kuliah)->row();
			if(!$check_bap)
			{
				echo 0; die();
			}
		}
		
		if(isset($_FILES['dokumen_tugas']['name']))
		{
			$nama_dokumen = md5('tugas-'.$id_bap_kuliah.'-'.$_SESSION['id_user'].'-'.date("YmdHis"));
			$simpan_file = $this->Main_model->unggah_dokumen_re($nama_dokumen,'./dokumen/etc/','*','dokumen_tugas');
			if($simpan_file)
			{
				$nama_dokumen=base_url('dokumen/etc/'.$simpan_file['upload_data']['file_name']);
				$this->Dhmd_model->update_bap_peserta_kuliah($id_bap_kuliah,$_SESSION['id_user'],'dokumen',$nama_dokumen);
				echo 1;
			}else{
				echo 0;
			}
		}else{
			echo 0;
		}
		
		
	}
	
	function hadir($id_kelas_kuliah=null,$id_bap_kuliah=null)
	{
	    $id_kelas_kuliah= xss_clean($id_kelas_kuliah);
	    $id_bap_kuliah = xss_clean($id_bap_kuliah);
		if($_SESSION['app_level']==1){
			$check = $this->Dhmd_model->check_hak_mahasiswa($_SESSION['id_user'],$id_kelas_kuliah,$id_bap_kuliah)->row();
			if($check)
			{
				$check_bap= $this->Dhmd_model->check_bap_mahasiswa($_SESSION['id_user'],$id_bap_kuliah)->row();
				if(!$check_bap){
					if($check->tanggal == date("Y-m-d")){
						$data = array('id_bap_kuliah'=>$id_bap_kuliah,'id_kelas_kuliah'=>$id_kelas_kuliah,'id_mahasiswa_pt'=>$_SESSION['id_user'],'status'=>1);
						$proses = $this->Dhmd_model->hadir($data);
						if($proses)
						{
							$this->session->set_flashdata('msg', 'Selamar Belajar!');
							$this->session->set_flashdata('msg_clr', 'success');
							redirect('dhmd/detail_pertemuan/'.$id_bap_kuliah);
						}
					}else{
						$this->session->set_flashdata('msg', 'Kelas Sudah Selesai!');
						$this->session->set_flashdata('msg_clr', 'danger');
						redirect('dhmd/daftar_pertemuan/'.$id_kelas_kuliah);
					}
				}else{
					$this->session->set_flashdata('msg', 'Sepertinya Kamu sudah Absen!');
					$this->session->set_flashdata('msg_clr', 'danger');
					redirect('dhmd/detail_pertemuan/'.$id_bap_kuliah);
				}
			}else{
				$this->session->set_flashdata('msg', 'Its Not Your Cup of Coffee!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('dashboard/');
			}
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function list_peserta($id_bap_kuliah=null)
	{
		if($id_bap_kuliah){
		$id_bap_kuliah = xss_clean($id_bap_kuliah);
		if($_SESSION['app_level']==1){
			/*JIKA MAHASISWA HANYA DATA DIRI DIA*/
			
			$check = $this->Dhmd_model->check_hak_mahasiswa($_SESSION['id_user'],null,$id_bap_kuliah)->row();
			if($check)
			{
				if(date("Y-m-d")==$check->tanggal && !$check->jam_selesai){
					$check_bap = $this->Dhmd_model->check_bap_mahasiswa($_SESSION['id_user'],$id_bap_kuliah)->row();
					if($check_bap){
						$data['bap']	= $check;
						$this->load->view('dhmd/detail_absen_mahasiswa',$data);
					}else{
						$data['bap']	= $check;
						$this->load->view('dhmd/absen_sekarang',$data);
					}
				}else{
					$data['bap']	= $check;
					$this->load->view('dhmd/detail_absen_mahasiswa',$data);
				}
				/*  */
			}else{
				die();
			}
		}else{
			$data['pertemuan'] 		= $this->Dhmd_model->get_pertemuan(null,$id_bap_kuliah)->row();
			$data['bap_pertemuan']	= $this->Dhmd_model->peserta_pertemuan_bap($id_bap_kuliah);
			$this->load->view('dhmd/peserta_pertemuan_bap',$data);
		}
		}
	}
	
	function absensi_ujian($jenis_ujian=null,$id_kelas_kuliah=null)
	{
		if($_SESSION['app_level']!=1){
		if($jenis_ujian && $id_kelas_kuliah){
		
		$kelas = $this->Krs_model->kelas_kuliah_mahasiswa_krs(null,null,$id_kelas_kuliah)->row();
		$detail_pertemuan = $this->Dhmd_model->get_pertemuan_ujian($id_kelas_kuliah,$jenis_ujian)->row();
		if($detail_pertemuan && $kelas && ($jenis_ujian=='uts' || $jenis_ujian=='uas')){
		//$this->load->model('Ujian_model');
			$data['pertemuan']	= $detail_pertemuan;
			$data['jenis_ujian']= $jenis_ujian;
			$data['kelas'] 		= $kelas;
			$data['title'] 		= 'Absensi '.strtoupper($jenis_ujian).' '.$kelas->nm_mk.' '.$kelas->nm_kls.' '.nama_smt($kelas->id_smt);
			$data['content'] 	= 'dhmd/absensi_ujian';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function list_aktifitas($id_bap_kuliah=null)
	{
		if($id_bap_kuliah){
		    $id_bap_kuliah = xss_clean($id_bap_kuliah);
		if($_SESSION['app_level']==1){
			$check_bap= $this->Dhmd_model->check_hak_mahasiswa($_SESSION['id_user'],null,$id_bap_kuliah)->row();
			if(!$check_bap)
			{
				echo 0; die();
			}
		}
			$data['aktifitas']		= $this->Dhmd_model->get_aktifitas($id_bap_kuliah)->result();
			$data['id_bap_kuliah'] 	= $id_bap_kuliah;
			$this->load->view('dhmd/aktifitas_perkuliahan',$data);
		}
	}
	
	function hapus_aktifitas($id_komen=null)
	{
		if($id_komen){
		    $id_komen = xss_clean($id_komen);
		$komen = $this->Dhmd_model->get_aktifitas(null,$id_komen)->row();
		if($komen){
		if($komen->nama_pengguna == $_SESSION['nama_pengguna'] && $komen->id_user==$_SESSION['id_user'] && $komen->level_name==$_SESSION['level_name']){
		$proses = $this->Dhmd_model->update_bap_aktifitas($id_komen,'is_deleted','1');
		if($proses){
			echo 1;
		}else{ echo 0; }
		}else{ echo 0; }
		}else{ echo 0; }
		}else{ echo 0; }
	}
	
	function profil_mahasiswa($id_kelas_kuliah=null,$id_mahasiswa_pt=null)
	{
		if($id_kelas_kuliah && $id_mahasiswa_pt){
		    $id_kelas_kuliah = xss_clean($id_kelas_kuliah);
		    $id_mahasiswa_pt = xss_clean($id_mahasiswa_pt);
		$id_mahasiswa_pt = ($_SESSION['app_level']==1)?$_SESSION['id_user']:$id_mahasiswa_pt;
		
		if($_SESSION['app_level']==1){ 
			$check = $this->Dhmd_model->check_hak_mahasiswa($id_mahasiswa_pt,$id_kelas_kuliah)->row();
			if(!$check)
			{
				$this->session->set_flashdata('msg', 'Its Not Your Cup of Coffee!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('dashboard/');
			}
		}
		$bearer = ['id_mahasiswa_pt'=>$id_mahasiswa_pt];
		$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
		
		$kelas = $this->Krs_model->kelas_kuliah_mahasiswa_krs(null,null,$id_kelas_kuliah)->row();
		if($kelas && $mahasiswa_pt){
			$data['mahasiswa_pt'] = $mahasiswa_pt[0];
			$data['kelas'] 		= $kelas;
			$data['title'] 		= 'Raport '.$mahasiswa_pt[0]->nm_pd.' '.$kelas->nm_mk.' '.$kelas->nm_kls.' '.nama_smt($kelas->id_smt);
			$data['content'] 	= 'dhmd/profil_mahasiswa';
			$this->load->view('lyt/index',$data);
		
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function nilai_akhir($id_kelas_kuliah=null,$id_mahasiswa_pt=null)
	{
		if($id_kelas_kuliah && $id_mahasiswa_pt){
		$id_kelas_kuliah = xss_clean($id_kelas_kuliah);
		$id_mahasiswa_pt = xss_clean($id_mahasiswa_pt);
		$id_mahasiswa_pt = ($_SESSION['app_level']==1)?$_SESSION['id_user']:$id_mahasiswa_pt;
		$nilai = $this->Dhmd_model->get_nilai($id_kelas_kuliah,$id_mahasiswa_pt)->row();
		$bobot = $this->Dhmd_model->get_persentase($id_kelas_kuliah)->row();
		if($nilai){
			$data['nilai'] = $nilai;
			$data['bobot'] = $bobot;
			$this->load->view('dhmd/nilai_akhir',$data);
		}else{ echo '<em>failed to load resources</em>'; }
		}else{ echo '<em>failed to load resources</em>'; }
	}
	
	function daftar_pertemuan($id_kelas_kuliah=null)
	{
		if($id_kelas_kuliah){
		$id_kelas_kuliah = xss_clean($id_kelas_kuliah);
		if($_SESSION['app_level']==1){ 
			$check = $this->Dhmd_model->check_hak_mahasiswa($_SESSION['id_user'],$id_kelas_kuliah)->row();
			if(!$check)
			{
				$this->session->set_flashdata('msg', 'Its Not Your Cup of Coffee!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('dashboard/');
			}
		}
			$kelas = $this->Krs_model->kelas_kuliah_mahasiswa_krs(null,null,$id_kelas_kuliah)->row();
		if($kelas){
			$data['kelas'] 		= $kelas;
			$data['title'] 		= 'Riwayat Pertemuan '.$kelas->nm_mk.' '.$kelas->nm_kls.' '.nama_smt($kelas->id_smt);
			$data['content'] 	= 'dhmd/daftar_pertemuan';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		//}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function pengaturan_kelas($id_kelas_kuliah=null)
	{
		if($id_kelas_kuliah){
		if($_SESSION['app_level']==2){ 
			$kelas = $this->Krs_model->kelas_kuliah_mahasiswa_krs(null,null,$id_kelas_kuliah)->row();
		if($kelas){
			
			$data['kelas'] 		= $kelas;
			$data['title'] 		= 'Pengaturan Kelas '.$kelas->nm_mk.' '.$kelas->nm_kls.' '.nama_smt($kelas->id_smt);
			$data['content'] 	= 'dhmd/pengaturan_kelas';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	}
	
	function pengaturan_sikap($id_kelas_kuliah=null)
	{
		if($id_kelas_kuliah){
		if($_SESSION['app_level']==2){ 
			$kelas = $this->Krs_model->kelas_kuliah_mahasiswa_krs(null,null,$id_kelas_kuliah)->row();
		if($kelas){
			
			$data['kelas'] 		= $kelas;
			$data['title'] 		= 'Pengaturan Penilaian Sikap '.$kelas->nm_mk.' '.$kelas->nm_kls.' '.nama_smt($kelas->id_smt);
			$data['content'] 	= 'dhmd/pengaturan_sikap';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	}
	
	function absensi($id_kelas_kuliah=null)
	{
		if($_SESSION['app_level']!=1){
		if($id_kelas_kuliah){
		$kelas = $this->Krs_model->kelas_kuliah_mahasiswa_krs(null,null,$id_kelas_kuliah)->row();
		if($kelas){
			$data['kelas'] 		= $kelas;
			$data['title'] 		= 'Rekap Absensi '.$kelas->nm_mk.' '.$kelas->nm_kls;
			$data['content'] 	= 'dhmd/absensi';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function nilai($id_kelas_kuliah=null)
	{
		if($_SESSION['app_level']!=1){
		if($id_kelas_kuliah){
		$kelas = $this->Krs_model->kelas_kuliah_mahasiswa_krs(null,null,$id_kelas_kuliah)->row();
		if($kelas){
			$data['kelas'] 		= $kelas;
			$data['title'] 		= 'Rekap Nilai '.$kelas->nm_mk.' '.$kelas->nm_kls;
			$data['content'] 	= 'dhmd/nilai';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function detail_pertemuan($id_bap_kuliah=null)
	{
		if($id_bap_kuliah){
		$id_bap_kuliah = xss_clean($id_bap_kuliah);
		$detail_pertemuan = $this->Dhmd_model->get_pertemuan(null,$id_bap_kuliah)->row();
		if($detail_pertemuan){
		$urutan_pertemuan = $this->Dhmd_model->urutan_pertemuan($id_bap_kuliah,$detail_pertemuan->id_kelas_kuliah)+1;
			
		$data['title'] 		= 'Detail Pertemuan #'.$urutan_pertemuan.' '.$detail_pertemuan->nm_mk.' '.$detail_pertemuan->nm_kls.' '.nama_smt($detail_pertemuan->id_smt);
		$data['pertemuan'] 	= $detail_pertemuan;
		$data['urutan_pertemuan'] = $urutan_pertemuan;
		$data['content'] 	= 'dhmd/detail_pertemuan';
		$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function update_pertemuan($id_bap_kuliah=null,$field=null,$isi=null)
	{
		if($_SESSION['app_level']==2){
		$value = $this->input->post('isi',true);
		if($id_bap_kuliah && $field && $value){
			$proses = $this->Dhmd_model->update_pertemuan($id_bap_kuliah,$field,$value);
			if($proses) echo 1; else echo 0; 
		}else{
			echo 0;
		}
		}else{
			echo 0;
		}
	}
	
	function update_pertemuan_ujian($id_bap_kuliah=null,$field=null,$value=null)
	{
		if($_SESSION['app_level']==2){
		$value = xss_clean($value);
		if($id_bap_kuliah && $field && $value){
			$proses = $this->Dhmd_model->update_pertemuan($id_bap_kuliah,$field,$value);
			if($proses) echo 1; else echo 0; 
		}else{
			echo 0;
		}
		}else{
			echo 0;
		}
	}
	
	function simpan_persentase()
	{
		if($_SESSION['app_level']==2){
		
		$id_kelas_kuliah = $this->input->post('id_kelas_kuliah');
		foreach($_POST as $key=>$value)
		{
			if($key != 'id_kelas_kuliah') {
				$this->Dhmd_model->update_persentase($id_kelas_kuliah,$key,$value);
			}
		}
			echo 1;
		}else{
			echo 0;
		}
	}
	
	function simpan_sikap()
	{
		if($_SESSION['app_level']==2){
		
		$id_kelas_kuliah = $this->input->post('id_kelas_kuliah');
		foreach($_POST as $key=>$value)
		{
			if($key != 'id_kelas_kuliah') {
				$this->Dhmd_model->update_sikap($id_kelas_kuliah,$key,$value);
			}
		}
			echo 1;
		}else{
			echo 0;
		}
	}
	
	function simpan_nilai()
	{
		if($_SESSION['app_level']==2){
		
		$id_nilai = $this->input->post('id_nilai');
		foreach($_POST as $key=>$value)
		{
			if($key != 'id_nilai' || $key != 'id_mahasiswa_pt') {
				$this->Dhmd_model->update_nilai($id_nilai,$key,$value);
			}
		}
			$whythis='simpan_nilai';
			$whatdo='#id_mahasiswa_pt:'.$this->input->post('id_mahasiswa_pt').'#nilai_huruf:'.$this->input->post('nilai_huruf');
			$this->Main_model->akademik_log($whythis,$whatdo);
			echo 'Mahasiswa : '.$this->input->post('id_mahasiswa_pt').' Nilai : '.$this->input->post('nilai_huruf').' Tersimpan';
		}else{
			echo 0;
		}
	}
	
	function simpan_raport()
	{
		if($_SESSION['app_level']==2){
			$id_mahasiswa_pt = $this->input->post('id_mahasiswa_pt');
			$id_kelas_kuliah = $this->input->post('id_kelas_kuliah');
			$nilai_sikap = $this->input->post('nilai_sikap');
			$this->Dhmd_model->update_nilai_mahasiswa($id_mahasiswa_pt,$id_kelas_kuliah,'nilai_sikap',$nilai_sikap);
			$this->Dhmd_model->update_nilai_sikap($id_mahasiswa_pt,$id_kelas_kuliah,'nilai_a',$this->input->post('nilai_a'));
			$this->Dhmd_model->update_nilai_sikap($id_mahasiswa_pt,$id_kelas_kuliah,'nilai_b',$this->input->post('nilai_b'));
			$this->Dhmd_model->update_nilai_sikap($id_mahasiswa_pt,$id_kelas_kuliah,'nilai_c',$this->input->post('nilai_c'));
			$this->Dhmd_model->update_nilai_sikap($id_mahasiswa_pt,$id_kelas_kuliah,'nilai_d',$this->input->post('nilai_d'));
			$this->Dhmd_model->update_nilai_sikap($id_mahasiswa_pt,$id_kelas_kuliah,'nilai_e',$this->input->post('nilai_e'));
			$this->Dhmd_model->update_nilai_sikap($id_mahasiswa_pt,$id_kelas_kuliah,'nilai_f',$this->input->post('nilai_f'));
			
			echo 'Mahasiswa : '.$id_mahasiswa_pt.' Nilai Sikap : '.$nilai_sikap.' Tersimpan';
		}else{
			echo 0;
		}
	}
	
	function simpan_foto()
	{
		if($_SESSION['app_level']==2){
		$id_bap_kuliah = $this->input->post('id_bap_kuliah');
		$id_kelas_kuliah = $this->input->post('id_kelas_kuliah');
		$uploader = $this->input->post('uploader');
		if($_FILES['foto']['name'])
		{
			$nama_dokumen = $id_kelas_kuliah.'-'.$id_bap_kuliah.'-'.$uploader;
			$simpan_file = $this->Main_model->unggah_dokumen($nama_dokumen,'./dokumen/pertemuan/','jpeg|jpg|png','foto');
			if($simpan_file)
			{
				$nama_dokumen=base_url('dokumen/pertemuan/'.$simpan_file['upload_data']['file_name']);
				$proses = $this->Dhmd_model->update_pertemuan($id_bap_kuliah,'foto',$nama_dokumen);
				if($proses) echo $nama_dokumen.'?'.date("His"); else echo 0; 
			}
		}else{
			echo 0;
		}
		}else{
			echo 0;
		}
	}
	
	function bigbangboom(){
		return false;
	}
	
	function load_meet($nama_room){
		echo'
			<div id="meet"></div>
			<script type="text/javascript">
			const domain = "meet.jit.si";
			const options = {
			    roomName: "'.$_ENV['MAIN_USER'].'-'.$nama_room.'",
			    width: "100%",
			    height: 500,
			    parentNode: document.querySelector("#meet"),';
	    if($_SESSION['app_level']==1){
	        echo"
	        interfaceConfigOverwrite: { 
		    	TOOLBAR_BUTTONS: [
			         'microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen',
        'fodeviceselection',  'profile', 'chat', 'recording',
        'livestreaming', 'etherpad',  'settings', 'raisehand',
        'videoquality', 'filmstrip',  'stats', 'shortcuts',
        'tileview', 'videobackgroundblur', 'download', 
        'e2ee', 'security'
			    ]
		    },
            role: 'participant',
            ";
	    }
		echo'   userInfo: {
			        displayName: "'.$_SESSION['nama_pengguna'].'"
			    }
			};
			const api = new JitsiMeetExternalAPI(domain, options);

			api.on("outgoingMessage", (object) => {
			  console.log(object.message);
			});
			api.emit("outgoingMessage");
			</script>
		';
	}
	
	private function unggah_gambar()
	{
		$pengguna = $_SESSION['id_user'];
		$id_rps = $this->input->post('id_rps');
		
		if(isset($_FILES['file']['name']))
		{
			$nama_dokumen = $pengguna.'-rps-'.$id_rps;
			$simpan_file = $this->Main_model->unggah_dokumen($nama_dokumen,'./dokumen/rps_img/','*','file');
			if($simpan_file)
			{
				$nama_dokumen=base_url('dokumen/rps_img/'.$simpan_file['upload_data']['file_name']);
				$data=array('location' =>$nama_dokumen ,'status'=> 'success');
				
			}else{ 
				$data=array('message' =>'upload failed' ,'status'=> 'error');
			}
		}else{
			$data=array('message' =>'no image' ,'status'=> 'error');
		}
		
		echo json_encode($data, JSON_HEX_APOS | JSON_HEX_QUOT);
	}
	
	private function image_resize($path, $file_name) {
		$this->load->library('image_lib');
		// Thumbnail Image
		$thumb['image_library'] = 'gd2';
		$thumb['source_image'] = $path .'/'. $file_name;
		$thumb['new_image'] = './files/mahasiswa/thumbnail/'. $file_name;
		$thumb['maintain_ratio'] = true;
		$thumb['width'] = 100;
		$thumb['height'] = 100;
		$this->image_lib->initialize($thumb);
		$this->image_lib->resize();
		$this->image_lib->clear();
		// Large Image
		$large['image_library'] = 'gd2';
		$large['source_image'] = $path .'/'. $file_name;
		$large['new_image'] = './files/mahasiswa/large/'. $file_name;
		$large['maintain_ratio'] = true;
		$large['width'] = 600;
		$large['height'] = 1000;
		$this->image_lib->initialize($large);
		$this->image_lib->resize();
		$this->image_lib->clear();
		// Remove Original File
		@unlink($path .'/'. $file_name);
	}
}