<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Mbkm extends CI_Controller {

	protected $app_level;

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){redirect(base_url('logout'));}
		if($_SESSION['logged_in']==FALSE){ redirect (base_url('logout'));}
		// print_r($_SESSION); exit;
		$this->app_level = [3, 7, 4, 8];
		$this->app_level_dosen = [2];

		$this->load->model('Aktivitas_model');
		$this->load->model('Mbkm_model');
	}
	
	function index()
	{
		if(in_array($_SESSION['app_level'], $this->app_level)){
			$data['title'] 		= 'Program Kampus Merdeka';
			$data['lead'] 		= 'Kelola data program kampus merdeka.';
			$data['content'] 	= 'mbkm/tabel_program';
			$this->load->view('lyt/index',$data);
		} elseif ($_SESSION['app_level'] == '1') { // Mahasiswa
			$data['title'] 		= 'Program Saya - Kampus Merdeka';
			$data['lead'] 		= 'Kelola program kampus merdeka yang kamu ikuti.';
			$data['content'] 	= 'mbkm/tabel_program_mhs';
			$this->load->view('lyt/index',$data);
		} else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function cari_program()
	{
		if ($_SESSION['app_level'] == '1') { // Mahasiswa
			$data['title'] 		= 'Cari Program - Kampus Merdeka';
			$data['lead'] 		= 'Daftar program kampus merdeka yang ditawarkan.';
			$data['content'] 	= 'mbkm/tabel_cari_program';
			$this->load->view('lyt/index',$data);
		} else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function aktivitas($id_aktivitas, $id_mahasiswa_pt = null)
	{
		if ($id_mahasiswa_pt == null) {
			$id_mahasiswa_pt = $_SESSION['id_user'];
		}

		// if(in_array($_SESSION['app_level'], $this->app_level)){
		// if ($_SESSION['app_level'] == '1') { // Mahasiswa
			$data['title'] 		= 'Aktivitas Kampus Merdeka';
			$data['lead'] 		= 'Kelola aktivitas kampus merdeka yang kamu ikuti.';
			$data['content'] 	= 'mbkm/aktivitas';

        	$data['anggota']    = $this->Aktivitas_model->anggota([ 'a.id_mahasiswa_pt' => $id_mahasiswa_pt, 'sha1(as.id_aktivitas)' => $id_aktivitas ], null, $_ENV['DB_MBKM'])->row();
	        $data['aktivitas']  = $this->Aktivitas_model->aktivitas([ 'a.id_aktivitas' => $data['anggota']->id_aktivitas ], null, null, $_ENV['DB_MBKM'])->row();
	        $data['pembimbing'] = $this->Aktivitas_model->pembimbing([ 'id_aktivitas' => $data['anggota']->id_aktivitas ], null, $_ENV['DB_MBKM']);
	        $data['koordinator'] = $this->Mbkm_model->koordinator_program([ 'id_program' => $data['aktivitas']->id_program, 'id_smt' => $data['aktivitas']->id_smt ]);

			$this->load->view('lyt/index',$data);
		// } else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function mahasiswa()
	{
		if(in_array($_SESSION['app_level'], $this->app_level)){
			$data['title'] 		= 'Mahasiswa Kampus Merdeka';
			$data['lead'] 		= 'Kelola aktivitas mahasiswa yang mengikuti program kampus merdeka.';
			$data['content'] 	= 'mbkm/tabel_mahasiswa';
			$this->load->view('lyt/index',$data);

		// } elseif ($_SESSION['app_level'] == '1') { // Mahasiswa
		// 	$data['title'] 		= 'Program Kampus Merdeka';
		// 	$data['lead'] 		= 'Daftar program kampus merdeka yang ditawarkan.';
		// 	$data['content'] 	= 'mbkm/tabel_program_mhs';
		// 	$this->load->view('lyt/index',$data);

		} else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function mitra()
	{
		if(in_array($_SESSION['app_level'], $this->app_level)){
			$data['title'] 		= 'Mitra Kampus Merdeka';
			$data['lead'] 		= 'Kelola data mitra kampus merdeka.';
			$data['content'] 	= 'mbkm/tabel_mitra';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function pic()
	{
		if(in_array($_SESSION['app_level'], $this->app_level)){
			$data['title'] 		= 'PIC Program Kampus Merdeka';
			$data['lead'] 		= 'Kelola data pic program kampus merdeka.';
			$data['content'] 	= 'mbkm/tabel_pic';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function berita()
	{
		if(in_array($_SESSION['app_level'], $this->app_level)){
			$data['title'] 		= 'Berita Kampus Merdeka';
			$data['lead'] 		= 'Kelola data berita kampus merdeka.';
			$data['content'] 	= 'mbkm/tabel_berita';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function tambah_program()
	{
		if(in_array($_SESSION['app_level'], $this->app_level)){
			$data['title'] 		= 'Tambah Program Kampus Merdeka';
			$data['lead'] 		= 'Silahkan lengkapi formulir dibawah.';
			$data['content'] 	= 'mbkm/tambah_program';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function tambah_mitra()
	{
		if(in_array($_SESSION['app_level'], $this->app_level)){
			$data['title'] 		= 'Tambah Mitra Kampus Merdeka';
			$data['lead'] 		= 'Silahkan lengkapi formulir dibawah.';
			$data['content'] 	= 'mbkm/tambah_mitra';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function tambah_berita()
	{
		if(in_array($_SESSION['app_level'], $this->app_level)){
			$data['title'] 		= 'Tambah Berita Kampus Merdeka';
			$data['lead'] 		= 'Silahkan lengkapi form isian dibawah.';
			$data['content'] 	= 'mbkm/tambah_berita';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function simpan($table = 'program_mitra')
	{
		$data = $this->input->post(null, true);
		if ($table != 'berita') {
			$data['kode_prodi'] = $_SESSION['kode_prodi'];
			
			$simpan = $this->Mbkm_model->insert($_ENV['DB_MBKM'].$table, $data, true);
			if ($simpan) {
				$this->session->set_flashdata('msg_inside', '<i class="pli-yes me-1"></i> Data berhasil disimpan. Silahkan lengkapi data sehingga bisa diverifikasi.');
				$this->session->set_flashdata('msg_inside_clr', 'success');

				redirect('mbkm/detail/'.$table.'/'.sha1($simpan));
			} else {
				$this->session->set_flashdata('msg', 'Data gagal disimpan. Silahkan ulangi lagi.');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('mbkm');
			}
		
		} else {
			$data['slug'] = url_title($data['judul'], 'dash', TRUE);

			if ($_FILES['cover']['name'] != '') {
				$upload_path = './dokumen/berita/';
		        if( !is_dir($upload_path) ) {
		            mkdir($upload_path, 0777, TRUE);
		        }
		        
		        $new_name = 'cover-'.$data['slug'].' '.time();
				$config['file_name'] 			= $new_name;
		        $config['upload_path']          = $upload_path;
		        $config['allowed_types']        = 'gif|jpg|png|jpeg';
		        $config['max_size']             = $_ENV['MAX_UPLOADED_SIZE'];

		        $this->load->library('upload', $config);

		        if ( ! $this->upload->do_upload('cover')) {
		            print_r($this->upload->display_errors());
		        } else {
		            $data['cover'] = base_url($upload_path.$this->upload->data('file_name'));
		        }
			}

			$tags = '';
			foreach ($data['tags'] as $key => $value) {
				$tags .= $value.',';
			}
			unset($data['tags']);

			$data['tags'] = rtrim($tags, ',');
			$data['id_penulis'] = $_SESSION['username'];
			$simpan = $this->Mbkm_model->insert($_ENV['DB_MBKM'].$table, $data, true);
			
			if ($simpan) {
				$this->session->set_flashdata('msg_inside', '<i class="pli-yes me-1"></i> Berita berhasil disimpan. Silahkan periksa tabel.');
				$this->session->set_flashdata('msg_inside_clr', 'success');
			} else {
				$this->session->set_flashdata('msg', 'Berita gagal disimpan. Silahkan ulangi lagi.');
				$this->session->set_flashdata('msg_clr', 'danger');
			}

			redirect('mbkm/berita');
		}
	}

	function unggah_gambar($dest = 'berita')
	{
		if(isset($_FILES['file']['name']))
		{
			$nama_dokumen = $_SESSION['username'];
			$simpan_file = $this->Main_model->unggah_dokumen($nama_dokumen,'./dokumen/berita/','*','file');
			if($simpan_file)
			{
				$nama_dokumen=base_url('dokumen/'.$dest.'/'.$simpan_file['upload_data']['file_name']);
				$data=array('location' =>$nama_dokumen ,'status'=> 'success');
				
			}else{ 
				$data=array('message' =>'upload failed' ,'status'=> 'error');
			}
		}else{
			$data=array('message' =>'no image' ,'status'=> 'error');
		}
		
		echo json_encode($data, JSON_HEX_APOS | JSON_HEX_QUOT);
	}

	function tambah_koordinator_program()
	{
		$data = $this->input->post(null, true);
		// print_r($data); exit;

		$simpan = $this->Mbkm_model->insert($_ENV['DB_MBKM'].'koordinator_program', $data);
		echo $simpan ? '1' : '0';
	}

	function detail($table, $id)
	{
		if(in_array($_SESSION['app_level'], $this->app_level)){
			if ($table == 'program_mitra') {
				$data['mata_kuliah_kurikulum'] = $this->Mbkm_model->get_mata_kuliah_kurikulum(['k.kode_prodi' => $_SESSION['kode_prodi'], 'k.kur_aktif' => '1'])->result();
				$data['detail']		= $this->Mbkm_model->get($_ENV['DB_MBKM'].$table, [ 'sha1(id_program_mitra)' => $id ])->row();
				$data['title'] 		= $data['detail']->judul_kegiatan.' ('.$data['detail']->id_smt.')';
				// $data['title'] 		= 'Detail Program Kampus Merdeka';
				$data['lead'] 		= 'Periksa kelengkapan data program kampus merdeka.';
				$data['content'] 	= 'mbkm/detail_program';
			} else {
				$data['detail']		= $this->Mbkm_model->get($_ENV['DB_MBKM'].$table, [ 'sha1(id_mitra)' => $id ])->row();
				$data['title'] 		= 'Detail Mitra Kampus Merdeka';
				$data['lead'] 		= 'Periksa kelengkapan data mitra kampus merdeka.';
				$data['content'] 	= 'mbkm/detail_mitra';
			}

			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function update($table, $id)
	{
		$data = $this->input->post(null, true);
		$data['kode_prodi'] = $_SESSION['kode_prodi'];

		$update = $this->Mbkm_model->update($_ENV['DB_MBKM'].$table, [ 'sha1(id_'.$table.')' => $id ], $data);

		if ($table == 'program_mitra') {
			$program_mitra = $this->Mbkm_model->program_mitra([ 'sha1(id_'.$table.')' => $id ])->row();

			$data_aktivitas = [
				'id_jenis_aktivitas_mahasiswa' => $program_mitra->id_jenis_aktivitas_mahasiswa,
				'id_smt' => $program_mitra->id_smt,
				'judul' => $program_mitra->judul_kegiatan,
				'keterangan' => $program_mitra->deskripsi,
				'lokasi' => $program_mitra->nama_merek
			];

			$update = $this->Mbkm_model->update($_ENV['DB_MBKM'].'aktivitas', [ 'sha1(id_'.$table.')' => $id ], $data_aktivitas);
		}

		if ($update) {
			$this->session->set_flashdata('msg_inside', '<i class="pli-yes me-1"></i> Detail program kampus merdeka berhasil di-update.');
			$this->session->set_flashdata('msg_inside_clr', 'success');
		} else {
			$this->session->set_flashdata('msg_inside', '<i class="pli-close me-1"></i> Detail program kampus merdeka gagal di-update.');
			$this->session->set_flashdata('msg_inside_clr', 'danger');
		}
		
		redirect('mbkm/detail/'.$table.'/'.$id);
	}

	function tambah_matkul_program($id_program_mitra)
	{
		$data['id_matkul'] = $this->input->post('id_matkul', true);
		$data['id_program_mitra'] = $id_program_mitra;

		$simpan = $this->Mbkm_model->insert($_ENV['DB_MBKM'].'matkul_program_mitra', $data);
		if ($simpan) { echo '1'; } else { echo '0'; }
	}

	function tambah_berkas_mitra($id_mitra)
	{
		$data['id_berkas'] = $this->input->post('id_berkas', true);
		$data['id_mitra'] = $id_mitra;

		$upload_path = './dokumen/mitra/';
        if( !is_dir($upload_path) ) {
            mkdir($upload_path, 0777, TRUE);
        }
        
        $new_name = $this->input->post('slug', true).' '.format_nama($this->input->post('nama_merek', true)).' '.time();
		$config['file_name'] 			= $new_name;
        $config['upload_path']          = $upload_path;
        $config['allowed_types']        = 'gif|jpg|png|jpeg|pdf|doc|docx';
        $config['max_size']             = $_ENV['MAX_UPLOADED_SIZE'];

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('berkas')) {
            print_r($this->upload->display_errors());
        } else {
            $data['berkas'] = base_url($upload_path.$this->upload->data('file_name'));

			$simpan = $this->Mbkm_model->insert($_ENV['DB_MBKM'].'berkas_mitra', $data);
			if ($simpan) { 
				echo '1';
			} else { 
				echo '0'; 
			}
        }
	}

	function tambah_berkas_program_mitra($id_program_mitra)
	{
		$data['id_berkas'] = $this->input->post('id_berkas', true);
		$data['id_program_mitra'] = $id_program_mitra;

		$upload_path = './dokumen/program_mitra/';
        if( !is_dir($upload_path) ) {
            mkdir($upload_path, 0777, TRUE);
        }
        
        $new_name = $this->input->post('slug', true).' '.$id_program_mitra.' '.time();
		$config['file_name'] 			= $new_name;
        $config['upload_path']          = $upload_path;
        $config['allowed_types']        = 'gif|jpg|png|jpeg|pdf|doc|docx';
        $config['max_size']             = $_ENV['MAX_UPLOADED_SIZE'];

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('berkas')) {
            print_r($this->upload->display_errors());
        } else {
            $data['berkas'] = base_url($upload_path.$this->upload->data('file_name'));

			$simpan = $this->Mbkm_model->insert($_ENV['DB_MBKM'].'berkas_program_mitra', $data);
			if ($simpan) { 
				echo '1';
			} else { 
				echo '0'; 
			}
        }
	}

	function hapus_matkul_program()
	{
		if(in_array($_SESSION['app_level'], $this->app_level)){
			$param = [ 'sha1(id_matkul)' => $this->input->post('idm', true), 'sha1(id_program_mitra)' => $this->input->post('ipm', true) ];
			$hapus = $this->Mbkm_model->delete($_ENV['DB_MBKM'].'matkul_program_mitra', $param);

			if ($hapus) {
    			$this->Mbkm_model->add_log($_SESSION['username'], $param);
    			echo '1';
			} else {
				echo '0';
			}
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function hapus($table)
	{
		if(in_array($_SESSION['app_level'], $this->app_level)){
			$post = $this->input->post();
			$param = [ 'sha1('.array_keys($post)[0].')' => $this->input->post(array_keys($post)[0], true) ];
			$hapus = $this->Mbkm_model->delete($_ENV['DB_MBKM'].$table, $param);

			if ($hapus) {
    			$this->Mbkm_model->add_log($_SESSION['username'], $param);
			}
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function aktif($table, $status = '')
	{
		if(in_array($_SESSION['app_level'], $this->app_level)){
			$post = $this->input->post();
			$where = [ 'sha1('.array_keys($post)[0].')' => $this->input->post(array_keys($post)[0], true) ];

			if ($status == '') {
				$data = [ 'aktif' => ($this->input->post('aktif', true) == 1 ? '0' : '1') ];
			} else {
				$data = [ 
					'status' => $this->input->post('status', true),
					'keterangan_status' => $this->input->post('keterangan_status', true),
					'tgl_status' => date('Y-m-d H:i:s')
				];

			}
			
			if ($status == '') {
				$aktif = $this->Mbkm_model->update($_ENV['DB_MBKM'].$table, $where, $data);
    			$this->Mbkm_model->add_log($_SESSION['username'], array_merge($where, $data));
			} else {
				$update = $this->Mbkm_model->update($_ENV['DB_MBKM'].$table, $where, $data);
				
				if ($update) {
    				$this->Mbkm_model->add_log($_SESSION['username'], array_merge($where, $data), null, 'status_program');
					$this->session->set_flashdata('msg_inside', '<i class="pli-yes me-1"></i> Status pengajuan program berhasil diperbaharui.');
					$this->session->set_flashdata('msg_inside_clr', 'success');
				} else {
					$this->session->set_flashdata('msg', 'Status pengajuan program gagal diperbaharui');
					$this->session->set_flashdata('msg_clr', 'danger');
				}
				
       			redirect($_SERVER['HTTP_REFERER']);
			}

		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function status_peserta()
	{
		$post = $this->input->post(null, true);

		if ($post['status'] == 1) {
			$jml_peserta = $this->Mbkm_model->get($_ENV['DB_MBKM'].'pendaftaran', [ 'sha1(id_program_mitra)' => $post['id_program_mitra'], 'status' => '1' ])->num_rows();

			if ( $jml_peserta < $post['kuota']) {
				// $program_mitra = $this->Mbkm_model->get($_ENV['DB_MBKM'].'program_mitra', [ 'sha1(id_program_mitra)' => $post['id_program_mitra'] ])->row();

				$program_mitra = $this->Mbkm_model->program_mitra([ 'sha1(id_program_mitra)' => $post['id_program_mitra'] ])->row();
				$pendaftaran = $this->Mbkm_model->get($_ENV['DB_MBKM'].'pendaftaran', [ 'sha1(id_pendaftaran)' => $post['id_pendaftaran'] ])->row();

				$aktivitas = $this->Aktivitas_model->anggota([ 'a.id_mahasiswa_pt' => $pendaftaran->id_mahasiswa_pt, 'as.id_program_mitra' => $pendaftaran->id_program_mitra ], null, $_ENV['DB_MBKM']);

                if ($aktivitas->num_rows() < 1) {
                    $data_aktivitas = [
                        'jenis_anggota' => '0',
                        'id_jenis_aktivitas_mahasiswa' => $program_mitra->id_jenis_aktivitas_mahasiswa,
                        'id_program_mitra' => $program_mitra->id_program_mitra,
                        'kode_prodi' => $program_mitra->kode_prodi,
                        'id_smt' => $program_mitra->id_smt,
                        'judul' => $program_mitra->judul_kegiatan,
                        'lokasi' => $program_mitra->nama_merek,
                        'keterangan' => $program_mitra->deskripsi,
                    ]; $id_aktivitas = $this->Aktivitas_model->tambah_aktivitas($data_aktivitas, $_ENV['DB_MBKM']);

                    $data_anggota = [
                        'id_aktivitas' => $id_aktivitas,
                        'id_mahasiswa_pt' => $pendaftaran->id_mahasiswa_pt,
                        'jenis_peran' => '3',
                    ]; $anggota = $this->Aktivitas_model->tambah_anggota($data_anggota, $_ENV['DB_MBKM']);

					$update = $this->Mbkm_model->update($_ENV['DB_MBKM'].'pendaftaran', [ 'sha1(id_pendaftaran)' => $post['id_pendaftaran'] ], [ 'status' => $post['status'], 'id_aktivitas' => $id_aktivitas ]);
                } else {
                	$update = $this->Mbkm_model->update($_ENV['DB_MBKM'].'pendaftaran', [ 'sha1(id_pendaftaran)' => $post['id_pendaftaran'] ], [ 'status' => $post['status'], 'id_aktivitas' => $aktivitas->row()->id_aktivitas ]);
                }

			} else {
				echo 'Maaf, tidak bisa menerima lagi peserta karena kuota sudah limit.'; exit;
			}

		} else {
			$update = $this->Mbkm_model->update($_ENV['DB_MBKM'].'pendaftaran', [ 'sha1(id_pendaftaran)' => $post['id_pendaftaran'] ], [ 'status' => $post['status']]);
		}

		echo $update ? 'Info: Status peserta berhasil diubah.' : 'Error: Status peserta gagal diubah';
		
		$jml_peserta = $this->Mbkm_model->get($_ENV['DB_MBKM'].'pendaftaran', [ 'sha1(id_program_mitra)' => $post['id_program_mitra'], 'status' => '1' ])->num_rows();
		$update_jml_peserta = $this->Mbkm_model->update($_ENV['DB_MBKM'].'program_mitra', [ 'sha1(id_program_mitra)' => $post['id_program_mitra'] ], [ 'peserta' => $jml_peserta ]);
	}

	function pendaftaran($id_program_mitra)
	{
        $program_mitra = $this->Mbkm_model->get($_ENV['DB_MBKM'].'program_mitra', [ 'sha1(id_program_mitra)' => $id_program_mitra ])->row();
		if ((date('Y-m-d') >= $program_mitra->tgl_mulai_daftar) && (date('Y-m-d') <= $program_mitra->tgl_selesai_daftar)){
			$data = [
				'id_mahasiswa_pt' => $_SESSION['id_user'],
				'smt_mhs' => $_SESSION['smt_mhs'],
				'id_program_mitra' => $program_mitra->id_program_mitra
			];

			$insert_ignore = $this->Mbkm_model->insert_ignore($_ENV['DB_MBKM'].'pendaftaran', $data);
			if ($insert_ignore) {
				$this->session->set_flashdata('msg', '<i class="pli-information me-1"></i> Pendaftaran berhasil dilakukan, silahkan tunggu program studi melakukan seleksi dan cek status pendaftaran kamu secara berkala.');
				$this->session->set_flashdata('msg_clr', 'success');
			}

		} else {
			$this->session->set_flashdata('msg', '<i class="pli-information me-1"></i> Maaf, tidak bisa melakukan pendaftaran karena sekarang tidak dalam periode pendaftaran.');
			$this->session->set_flashdata('msg_clr', 'info');
		}
		
		redirect('mbkm');
	}

	function batalkan_pendaftaran($id_pendaftaran)
	{
		$delete = $this->Mbkm_model->delete($_ENV['DB_MBKM'].'pendaftaran', [ 'sha1(id_pendaftaran)' => $id_pendaftaran, 'id_mahasiswa_pt' => $_SESSION['id_user'], 'status' => null ]);

		if ($delete) {
			$this->session->set_flashdata('msg', '<i class="pli-information me-1"></i> Pendaftaran berhasil dibatalkan. Silahkan cari program kampus merdeka yang sesuai dengan kamu.');
			$this->session->set_flashdata('msg_clr', 'success');
		} else {
        	$this->session->set_flashdata('msg', '<i class="pli-information me-1"></i> Maaf, pendaftaran tidak bisa dibatalkan karena kamu sudah memperoleh status pendaftaran.');
			$this->session->set_flashdata('msg_clr', 'danger');
        }
		
		redirect($_SERVER['HTTP_REFERER']);
	}

	function detail_kegiatan()
    {
        $id = $this->input->post('id_program_mitra', true);
        $data['detail'] = $this->Mbkm_model->get($_ENV['DB_MBKM'].'program_mitra', [ 'sha1(id_program_mitra)' => $id ])->row();
        $data['matkul_program'] = $this->Mbkm_model->matkul_program($id);

        $this->load->view('mbkm/detail_kegiatan', $data);
    }

	function json()
    {
        $this->load->model('Mbkm_data_model');
        $list = $this->Mbkm_data_model->get_datatables();

        $status = ['Ditolak', 'Disetujui'];
        $status_bg = ['bg-danger', 'bg-secondary'];
        
        $status_pendaftaran = ['Tidak Lulus', 'Lulus Seleksi'];

        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            
            $row[] = $no.'.';
            $row[] = $field->nama_jenis_aktivitas_mahasiswa.' '.$field->nama_program.' ('.($field->jenis_program == 1 ? 'Mandiri' : 'Kementrian').')';
            $row[] = $field->nama_prodi;
            $row[] = '<a class="m-0 p-0 fw-bold text-dark text-decoration-none" href="'.($_SESSION['app_level'] == 1 ? $field->tautan : base_url('mbkm/detail/mitra/'.sha1($field->id_mitra))).'">'.$field->nama_merek.'</a><br>'.$field->alamat;

            $tahun = date('Y', strtotime($field->tgl_mulai)) == date('Y', strtotime($field->tgl_selesai)) ? 1 : null;
            $row[] = '<b class="m-0 p-0 d-block text-dark">'.$field->nama_semester.'</b>'.date('j M Y', strtotime($field->tgl_mulai)).' s.d '.date('j M Y', strtotime($field->tgl_selesai));;

            
            if ($_SESSION['app_level'] != 1) { // Akademik dan Kaprodi
	            $row[] = '<a href="javascript:void(0)" class="badge '.$status_bg[$field->aktif].'" onclick="aktif(`'.sha1($field->id_program_mitra).'`, '.$field->aktif.')">'.($field->aktif == 1 ? 'Ya' : 'Tidak').'</a>';

	            $row[] = $field->status == '' ? '<span class="badge bg-info" title="Sedang diproses oleh koordinator program.">Diproses</span>' : '<span class="badge '.$status_bg[$field->status].'" data-bs-toggle="tooltip" title="'.($field->tgl_status ? tanggal_indo($field->tgl_status) : '-').'">'.$status[$field->status].'</span>';
	            
	            $peserta = function ($id, $status) {
	            	return $this->Mbkm_model->get($_ENV['DB_MBKM'].'pendaftaran', ['id_program_mitra' => $id, 'status' => $status])->num_rows();
	            };

	            $row[] = '<span class="badge '.($field->peserta >= $field->kuota ? 'bg-danger' : 'bg-secondary').'">'.$peserta($field->id_program_mitra, '1').' / '.$field->kuota.'</span><br>'.
	            		 '<span class="badge bg-info"><i class="fa fa-user-check me-1"></i> '.$peserta($field->id_program_mitra, null).'</span>'.
	            		 '<span class="badge bg-danger"><i class="fa fa-user-alt-slash me-1"></i> '.$peserta($field->id_program_mitra, '0').'</span>';

	            // $row[] = '-';
	            $row[] = '<a class="badge bg-info me-1" href="'.base_url('mbkm/detail/program_mitra/'.sha1($field->id_program_mitra)).'">Detail</a>'.
	            		($_SESSION['app_level'] == 7 ? '<a class="badge bg-danger" href="javascript:void(0)" onclick="return hapus(`'.sha1($field->id_program_mitra).'`)">Hapus</a>' : '');
            	
            	} else { // Mahasiswa
            		$row[] = ($field->id_pendaftaran) 
            					? '<span class="badge '.
            						($field->status_pendaftaran  != ''
            							? $status_bg[$field->status_pendaftaran] 
            							: 'bg-info').'">'.
            						($field->status_pendaftaran != ''
            							? $status_pendaftaran[$field->status_pendaftaran] 
            							: 'Tahap Seleksi').'</span>' 
            					: date('j M Y', strtotime($field->tgl_mulai_daftar)).' s.d '.date('j M Y', strtotime($field->tgl_selesai_daftar));

	            	$row[] = '<span class="badge '.($field->peserta >= $field->kuota ? 'bg-danger' : 'bg-secondary').'">'.$field->peserta.' / '.$field->kuota.'</span>';

            		$row[] = '<a class="badge bg-info me-1" onclick="detail_kegiatan(`'.sha1($field->id_program_mitra).'`)" href="javascript:void(0)">Detail</a>'.
	            		((date('Y-m-d') >= $field->tgl_mulai_daftar) && (date('Y-m-d') <= $field->tgl_selesai_daftar && !$field->id_pendaftaran) 
	            			? '<a class="badge bg-secondary" href="'.base_url('mbkm/pendaftaran/'.sha1($field->id_program_mitra)).'" onclick="return confirm(`Apakah kamu yakin ingin melakukan pendaftaran kampus merdeka pada program terpilih ?`)">Daftar</a>' 
	            			: ( in_array($field->status_pendaftaran, ['0', '1']) 
	            				? ($field->status_pendaftaran == '0' 
	            					? '' 
	            					: '<a class="badge bg-info" href="'.base_url('mbkm/aktivitas/'.sha1($field->id_aktivitas)).'">Aktivitas</a>') 
	            				: (($field->status_pendaftaran == '' AND $field->id_pendaftaran) 
	            					? '<a class="badge bg-danger" href="'.base_url('mbkm/batalkan_pendaftaran/'.sha1($field->id_pendaftaran)).'" onclick="return confirm(`Apakah kamu yakin ingin membatalkan pendaftaran kampus merdeka pada program terpilih ?`)">Batalkan</a>' 
	            					: '<span class="badge bg-danger">Ditutup</span>') ) );
            	}

            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Mbkm_data_model->count_all(),
            "recordsFiltered" => $this->Mbkm_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
    }

    function json_matkul_program()
    {
        $this->load->model('Matkul_program_data_model');
        $list = $this->Matkul_program_data_model->get_datatables();

        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            
            $row[] = $no.'.';
            $row[] = $field->kode_mk;
            $row[] = $field->nm_mk;
            $row[] = $field->smt;
            $row[] = $field->sks_mk;
            
            if ($_SESSION['app_level'] == 7) {
           		$row[] = '<a class="text-decoration-none text-danger" href="javascript:void(0)" onclick="return hapus_matkul_program(`'.sha1($field->id_matkul).'`,`'.sha1($field->id_program_mitra).'`)">Hapus</a>';
            }

            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Matkul_program_data_model->count_all(),
            "recordsFiltered" => $this->Matkul_program_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
    }

    function json_mitra()
    {
        $this->load->model('Mitra_data_model');
        $list = $this->Mitra_data_model->get_datatables();

        $status_bg = ['bg-danger', 'bg-secondary'];
        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            
            $row[] = $no.'.';
            $row[] = '<b class="m-0 p-0 d-block text-dark">'.$field->nama_merek.'</b>'.$field->nama_resmi;
            $row[] = $field->alamat;
            $row[] = $field->telepon.'<br>'.$field->email;
            
            $row[] = '<a href="javascript:void(0)" class="badge '.$status_bg[$field->aktif].'" '.($_SESSION['app_level'] == 7 ? 'onclick="aktif(`'.sha1($field->id_mitra).'`, '.$field->aktif.')"' : '').'>'.($field->aktif == 1 ? 'Ya' : 'Tidak').'</a>';
            
            $row[] = '<a class="badge bg-info me-1" href="'.base_url('mbkm/detail/mitra/'.sha1($field->id_mitra)).'">Detail</a>'.
            		($_SESSION['app_level'] == 7 ? '<a class="badge bg-danger" href="javascript:void(0)" onclick="return hapus(`'.sha1($field->id_mitra).'`)">Hapus</a>' : '');

            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Mitra_data_model->count_all(),
            "recordsFiltered" => $this->Mitra_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
    }

    function json_berita()
    {
        $this->load->model('Berita_data_model');
        $list = $this->Berita_data_model->get_datatables();

        $status_bg = ['bg-danger', 'bg-secondary'];
        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            
            $row[] = $no.'.';
            $row[] = '<a class="text-decoration-none" href="'.$_ENV['MBKM_URL'].'/berita/detail/'.$field->slug.'" target="_blank">'.$field->judul.'</a>';

            $tags = explode(',', $field->tags);
            $tag = '';

            foreach ($tags as $key => $value) {
            	$tag .= '<a href="'.$_ENV['MBKM_URL'].'/berita/tags/'.$value.'" target="_blank" class="badge bg-info ">'.$value.'</a> ';
            }

            $row[] = $tag;
            $row[] = tanggal_indo($field->created_at);
            
            $row[] = '<a href="javascript:void(0)" class="badge '.$status_bg[$field->aktif].'" '.($_SESSION['app_level'] == 3 ? 'onclick="aktif(`'.sha1($field->id_berita).'`, '.$field->aktif.')"' : '').'>'.($field->aktif == 1 ? 'Ya' : 'Tidak').'</a>';
            
            $row[] = ($_SESSION['app_level'] == 7 ? '<a class="badge bg-danger" href="javascript:void(0)" onclick="return hapus(`'.sha1($field->id_berita).'`)">Hapus</a>' : 'n/a');

            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Berita_data_model->count_all(),
            "recordsFiltered" => $this->Berita_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
    }

    function json_berkas_program_mitra()
    {
        $this->load->model('Berkas_program_mitra_data_model');
        $list = $this->Berkas_program_mitra_data_model->get_datatables();

        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            
            $row[] = $no.'.';
            $row[] = $field->nama_berkas;
            $row[] = tanggal_indo($field->created_at);
            $row[] = '<a class="text-decoration-none" href="'.$field->berkas.'" download>Unduh</a>';
            
            if ($_SESSION['app_level'] == 7) {
           		$row[] = '<a class="text-decoration-none text-danger" href="javascript:void(0)" onclick="hapus_berkas_program_mitra(`'.sha1($field->id_berkas_program_mitra).'`)">Hapus</a>';
            }

            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Berkas_program_mitra_data_model->count_all(),
            "recordsFiltered" => $this->Berkas_program_mitra_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
    }

    function json_peserta()
    {
        $this->load->model('Peserta_mbkm_data_model');
        $list = $this->Peserta_mbkm_data_model->get_datatables();

        $status = ['Ditolak', 'Disetujui'];
        $status_bg = ['bg-danger', 'bg-secondary'];

        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            
            $row[] = $no.'.';
            $row[] = $field->id_mahasiswa_pt;
            $row[] = '<a href="'.base_url('biodata/mahasiswa/'.$field->id_mahasiswa_pt).'" target="_blank" class="text-decoration-none">'.$field->nm_pd.'</a>';
            $row[] = $field->inisial_fak.' - '.$field->nama_prodi.' ('.$field->nm_jenj_didik.')';
            $row[] = $field->smt_mhs;
            
            if ($_SESSION['app_level'] == 7) {
            	$row[] = ($field->status == '' ? '<a class="badge bg-info" href="javascript:void(0)" onclick="status(`'.sha1($field->id_pendaftaran).'`)">Diproses</a>' : '<a href="javascript:void(0)" class="badge '.$status_bg[$field->status].'" onclick="status(`'.sha1($field->id_pendaftaran).'`)">'.($field->status == 1 ? 'Diterima' : 'Ditolak').'</a>');
            } else {
            	$row[] = ($field->status == '' ? '<span class="badge bg-info">Diproses</span>' : '<span class="badge '.$status_bg[$field->status].'">'.($field->status == 1 ? 'Diterima' : 'Ditolak').'</span>');
            }

            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Peserta_mbkm_data_model->count_all(),
            "recordsFiltered" => $this->Peserta_mbkm_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
    }

    function json_berkas_mitra()
    {
        $this->load->model('Berkas_mitra_data_model');
        $list = $this->Berkas_mitra_data_model->get_datatables();

        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            
            $row[] = $no.'.';
            $row[] = $field->nama_berkas;
            $row[] = tanggal_indo($field->created_at);
            $row[] = '<a class="text-decoration-none" href="'.$field->berkas.'" download>Unduh</a>';
            
            if ($_SESSION['app_level'] == 7) {
           		$row[] = '<a class="text-decoration-none text-danger" href="javascript:void(0)" onclick="hapus_berkas_mitra(`'.sha1($field->id_berkas_mitra).'`)">Hapus</a>';
            }

            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Berkas_mitra_data_model->count_all(),
            "recordsFiltered" => $this->Berkas_mitra_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
    }

    function json_koordinator_program()
    {
        $this->load->model('Koordinator_program_data_model');
        $list = $this->Koordinator_program_data_model->get_datatables();

        $status_bg = ['bg-danger', 'bg-secondary'];
        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            
            $row[] = $no.'.';
            $row[] = 'Program '.$field->nama_jenis_aktivitas_mahasiswa.' '.$field->nama_program;
            $row[] = $field->nama_semester;
            // $row[] = $field->nidn;
            $row[] = '<a href="'.base_url('biodata/dosen/'.$field->nidn).'" class="text-decoration-none">'.$field->nm_sdm.'</a>';
            
			if(in_array($_SESSION['app_level'], [3])) {
	            $row[] = '<a class="badge bg-danger" href="javascript:void(0)" onclick="return hapus(`'.sha1($field->id_koordinator_program).'`)">Hapus</a>';
	        } else {
	        	$row[] = '-';
	        }

            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Koordinator_program_data_model->count_all(),
            "recordsFiltered" => $this->Koordinator_program_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
    }

	function aktivitas_mhs($act = null, $id_aktivitas = null)
	{
		$this->load->model('Mahasiswa_model');

		if(in_array($_SESSION['app_level'], $this->app_level)){
			if ($act == null && $id_aktivitas == null) {
				$data['title'] 		= 'Peserta Kampus Merdeka';
				$data['lead'] 		= 'Kelola data peserta yang mengikuti program kampus merdeka.';
				$data['content'] 	= 'mbkm/tabel_aktivitas_mahasiswa';
			} else if ($act == 'detail' && $id_aktivitas != null) {
				$data['title'] 		= 'Detail Peserta Kampus Merdeka';
				$data['lead'] 		= 'Kelola aktivitas mahasiswa kampus merdeka.';
				$data['content'] 	= 'mbkm/detail';

				$aktivitas = $this->Aktivitas_model->aktivitas(['sha1(a.id_aktivitas)' => $id_aktivitas], null, null, $_ENV['DB_MBKM']);
				
				$data['aktivitas'] 	= $aktivitas->row();
				$data['anggota'] 	= $this->Aktivitas_model->anggota(['sha1(a.id_aktivitas)' => $id_aktivitas], null, $_ENV['DB_MBKM'])->result();
				$data['semester'] 	= $this->Main_model->ref_smt();
				$data['prodi'] 		= $this->Main_model->ref_prodi(($_SESSION['kode_fak'] != '0' ? $_SESSION['kode_fak'] : null));
				$data['jenis_aktivitas_mahasiswa'] 	= $this->Main_model->ref_jenis_aktivitas_mahasiswa();
				$data['dosen'] 		= $this->Main_model->get_dosen();
				$data['pembimbing'] = $this->Aktivitas_model->pembimbing([ 'sha1(id_aktivitas)' => $id_aktivitas ], 'p.pembimbing_ke ASC', $_ENV['DB_MBKM'])->result();
			}

			$this->load->view('lyt/index',$data);
		} else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function tambah_dosen($table)
	{
		if(in_array($_SESSION['app_level'], $this->app_level)){
			$data = $this->input->post(null, true);

			$tambah = $this->Aktivitas_model->tambah_dosen($table, $data, $_ENV['DB_MBKM']);
			if ($tambah) {
    			// $this->Aktivitas_model->add_log($_SESSION['username'], $data, null, $this->router->method.'_'.$table);

				$this->session->set_flashdata('msg', 'Dosen '.$table.' berhasil ditambahkan.');
				$this->session->set_flashdata('msg_clr', 'success');
				redirect('mbkm/aktivitas_mhs/detail/'.sha1($data['id_aktivitas']));
			}
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function hapus_dosen($table, $id, $id_aktivitas)
	{
		if(in_array($_SESSION['app_level'], $this->app_level)){
			$data = [ 'sha1(id_'.$table.')' => $id, 'sha1(id_aktivitas)' => $id_aktivitas ];
			$hapus = $this->Aktivitas_model->hapus_dosen($table, $data, $_ENV['DB_MBKM']);

			if ($hapus) {
    			// $this->Aktivitas_model->add_log($_SESSION['username'], $data, null, $this->router->method.'_'.$table);

				$this->session->set_flashdata('msg', 'Dosen '.$table.' berhasil dihapus.');
				$this->session->set_flashdata('msg_clr', 'success');
				redirect('mbkm/aktivitas_mhs/detail/'.$id_aktivitas);
			}
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function update_aktivitas_mahasiswa()
	{
		$data = $this->input->post(null, true);
		
		$sk_tugas = $this->Aktivitas_model->aktivitas([ 'sk_tugas' => $data['sk_tugas'] ], 'updated_at DESC', null, $_ENV['DB_MBKM'])->row();
		if ($sk_tugas) {
			$data['tanggal_sk_tugas'] 	= $sk_tugas->tanggal_sk_tugas;
			$data['file_sk_tugas'] 		= $sk_tugas->file_sk_tugas;

            // $this->Aktivitas_model->add_log($_SESSION['username'], $data, null, 'sk_penugasan_pembimbing');
		}

		if (isset($_FILES)) {
			unset($data['file_sk_tugas_temp']);
			if ($_FILES['file_sk_tugas']['name'] != '') {
				unlink('./'.substr($this->input->post('file_sk_tugas_temp', null, true), strlen(base_url())));

				$upload_path = './dokumen/mbkm/sk/';
				if( !is_dir($upload_path) ) {
		            mkdir($upload_path, 0777, TRUE);
		        }

				$config['upload_path']          = $upload_path;
			    $config['allowed_types']        = 'pdf';
			    $config['encrypt_name'] 		= TRUE;
			    // $config['file_name'] 		= TRUE;
			    $config['overwrite']			= true;
			    $config['max_size']             = 15240; // 10MB

			    $this->load->library('upload', $config);
			    if ($this->upload->do_upload('file_sk_tugas')) {
			    	$data['file_sk_tugas'] = base_url('dokumen/mbkm/sk/'.$this->upload->data('file_name'));

            		// $this->Aktivitas_model->add_log($_SESSION['username'], $data, null, 'sk_penugasan_pembimbing');
			    }
			}
		}

		$update = $this->Aktivitas_model->update(array_slice($data, 1), [ 'sha1(id_aktivitas)' => $data['id_aktivitas'] ], null, $_ENV['DB_MBKM']);
		// $this->Aktivitas_model->add_log($_SESSION['username'], $data, null, 'update_mbkm');
		
		if ($update) {
			$this->session->set_flashdata('msg', 'Data aktivitas mahasiswa berhasil diperbaharui.');
			$this->session->set_flashdata('msg_clr', 'success');
			redirect('mbkm/aktivitas_mhs/detail/'.$data['id_aktivitas']);
		}
	}

    function json_aktivitas_mahasiswa()
	{
		$this->load->model('Aktivitas_mbkm_data_model');
	    
		$list = $this->Aktivitas_mbkm_data_model->get_datatables();
        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            
            $row[] = $field->id_mahasiswa_pt;
            $row[] = '<a href="'.base_url( ($_SESSION['app_level'] == 2 ? 'mbkm/aktivitas/'.sha1($field->id_aktivitas).'/'.$field->id_mahasiswa_pt : 'mbkm/aktivitas_mhs/detail/'.sha1($field->id_aktivitas)) ).'" class="text-decoration-none">'.$field->nm_pd.'</a>';
            $row[] = $field->nm_jenj_didik.' - '.$field->nama_prodi;
            $row[] = $field->nama_semester;

            $row[] = $_SESSION['app_level'] == 2  // Dosen
            			? $field->nama_jenis_aktivitas_mahasiswa.' '.$field->nama_program.' ('.($field->jenis_program == 1 ? 'Mandiri' : 'Kementrian').')' 
            			: '<a class="text-decoration-none" target="_blank" href="'.base_url('mbkm/detail/program_mitra/'.sha1($field->id_program_mitra)).'">'.$field->nama_jenis_aktivitas_mahasiswa.' '.$field->nama_program.' ('.($field->jenis_program == 1 ? 'Mandiri' : 'Kementrian').')</a>';
            $row[] = $_SESSION['app_level'] == 2 // Dosen
            			? $field->lokasi 
            			: '<a class="text-decoration-none" href="'.base_url('mbkm/detail/mitra/'.sha1($field->id_mitra)).'">'.$field->lokasi.'</a>';

            $row[] = ucwords(strtolower($field->nm_sdm))?: '-';

            $nilai_cpl = '<a target="_blank" class="badge bg-danger" id="kosong" href="'.base_url('mbkm/konversi/'.sha1($field->id_aktivitas).'/'.$field->id_mahasiswa_pt).'">Kosong</a>';
            if ($field->nilai_cpl) {
            	$nilai_cpl = json_decode($field->nilai_cpl, true);
            	
            	$n_nilai = count($nilai_cpl);
            	$n_nilai_validated = 0; 
            	for ($i=0; $i < $n_nilai; $i++) {
            		if ($nilai_cpl[$i]['tgl_validasi'] != 'belum') {
            			$n_nilai_validated++;
            		}
            	}

            	$p_nilai = round($n_nilai_validated / $n_nilai * 100).'%';
            	if ($p_nilai == 100) {
            		$nilai_cpl = '<a  target="_blank" class="badge bg-secondary" id="lengkap" href="'.base_url('mbkm/konversi/'.sha1($field->id_aktivitas).'/'.$field->id_mahasiswa_pt).'">Lengkap</a>';
            	} else {
            		$nilai_cpl = '<a  target="_blank" class="badge bg-info" id="diproses" href="'.base_url('mbkm/konversi/'.sha1($field->id_aktivitas).'/'.$field->id_mahasiswa_pt).'">Diproses</a>';
            	}
            }
            // foreach ($field->nilai_cpl as $row_nilai_cpl) {
            // 	echo $row_nilai_cpl;
            // }

            $row[] = $nilai_cpl;

            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Aktivitas_mbkm_data_model->count_all(),
            "recordsFiltered" => $this->Aktivitas_mbkm_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}

	function pembimbing()
	{
		if ($_SESSION['app_level'] == '2') { // Mahasiswa
			$data['title'] 		= 'Pembimbing Kampus Merdeka';
			$data['lead'] 		= 'Kelola aktivitas mahasiswa kampus merdeka sebagai dosen pembimbing lapangan.';
			$data['content'] 	= 'mbkm/tabel_pembimbing';
			$this->load->view('lyt/index',$data);
		} else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function koordinator()
	{
		if ($_SESSION['app_level'] == '2') { // Mahasiswa
			$data['title'] 		= 'Koordinator Program Kampus Merdeka';
			$data['lead'] 		= 'Lihat progres aktivitas mahasiswa kampus merdeka.';
			$data['content'] 	= 'mbkm/tabel_koordinator';
			$this->load->view('lyt/index',$data);
		} else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function konversi($id_aktivitas, $id_mahasiswa_pt = null)
	{
		$this->load->model('Krs_model');

		if ($id_mahasiswa_pt == null) {
			$id_mahasiswa_pt = $_SESSION['id_user'];
		}

		if(in_array($_SESSION['app_level'], $this->app_level) OR $_SESSION['app_level'] == 2){
        	$data['anggota']    = $this->Aktivitas_model->anggota([ 'a.id_mahasiswa_pt' => $id_mahasiswa_pt, 'sha1(as.id_aktivitas)' => $id_aktivitas ], null, $_ENV['DB_MBKM'])->row();
	        $data['aktivitas']  = $this->Aktivitas_model->aktivitas([ 'a.id_aktivitas' => $data['anggota']->id_aktivitas ], null, null, $_ENV['DB_MBKM'])->row();
	        $data['pembimbing'] = $this->Aktivitas_model->pembimbing([ 'id_aktivitas' => $data['anggota']->id_aktivitas ], null, $_ENV['DB_MBKM']);
	        $data['koordinator'] = $this->Mbkm_model->koordinator_program([ 'id_program' => $data['aktivitas']->id_program, 'id_smt' => $data['aktivitas']->id_smt ]);

	        $data['list_kelas_krs']	= $this->Krs_model->list_kelas_krs($id_mahasiswa_pt, $data['aktivitas']->id_smt, $data['aktivitas']->id_program_mitra);
	        // print_r($data['list_kelas_krs']->result()); exit;

			$data['title'] 		= 'Konversi Kampus Merdeka';
			$data['lead'] 		= 'Atur konversi kegiatan mahasiswa kampus merdeka.';
			$data['content'] 	= $data['aktivitas']->id_jenis_aktivitas_mahasiswa == 21 ? 'mbkm/konversi_pmm' : 'mbkm/konversi_non_pmm';

			$this->load->view('lyt/index',$data);
		} else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
}
