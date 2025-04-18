<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Studi_akhir extends CI_Controller {

	protected $app_level;

	function __construct()
	{
		parent::__construct();

		// var_dump(get_class_methods($this)); exit;
		// echo '<pre>' . var_export(get_class_methods($this), true) . '</pre>'; exit;

		if(!isset($_SESSION['logged_in'])){redirect(base_url('logout'));}
		if($_SESSION['logged_in']==FALSE){ redirect (base_url('logout'));}
		
		$this->app_level = [3, 7, 4, 8];
		$this->app_level_dosen = [2];

		$this->load->model('Aktivitas_model');
	}
	
	function index()
	{
		if(in_array($_SESSION['app_level'], $this->app_level)){
			$data['title'] 		= 'Daftar Studi Akhir';
			$data['lead'] 		= 'Kelola data studi akhir mahasiswa.';
			$data['content'] 	= 'studi_akhir/tabel';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function wisudawan()
	{
		$this->load->model('Mahasiswa_model');

		$get = $this->input->get(null, true);

		$data['fakultas'] 	= $this->Main_model->ref_fakultas($get['kode_fak'])[0];
		$data['prodi']		= $this->Main_model->ref_prodi($get['kode_prodi'])[0];
		$data['wisudawan'] 	= $this->Aktivitas_model->wisudawan([ 'kode_prodi' => $get['kode_prodi'], 'kode_fak' => $get['kode_fak'] ])->result();

		$this->load->view('studi_akhir/wisudawan', $data);
	}

	function unduh_berkas_mahasiswa()
	{
		$this->load->model('Mahasiswa_model');

		$folder = 'dokumen/ekspor';
    	if(!file_exists($folder)) {
    		mkdir($folder, 0777, true);
    	}

    	$get 		= $this->input->get(null, true);

    	$fakultas 	= $this->Main_model->ref_fakultas($get['kode_fak'])[0];
		$prodi		= $this->Main_model->ref_prodi($get['kode_prodi'])[0];
		$wisudawan 	= $this->Aktivitas_model->wisudawan([ 'kode_prodi' => $get['kode_prodi'], 'kode_fak' => $get['kode_fak'] ])->result();
    	
    	$error = ""; 

    	if(extension_loaded('zip')) {
    		$zip = new ZipArchive(); // Load zip library  
            $zip_name = "berkas_mahasiswa.zip";  // nama Zip  

            if($zip->open('dokumen/ekspor/'.$zip_name, ZIPARCHIVE::CREATE)!==TRUE) {   //Membuka file zip untuk memuat file
                $error .= "* Maaf Download ZIP gagal"; 
            } 

            foreach ($wisudawan as $row) {
            	$dokumen = [ 
               		'pasfoto' => 'FOTO',
               		'ktp' => 'KTP',
               		// 'kk' => 'KK',
               		'ijazah' => 'IJAZAH',
               	];

               	foreach ($dokumen as $key => $value) {
					$file = $this->Mahasiswa_model->get_dokumen($row->id_mhs, $key);
		    		if(isset($file)) {
		    			$filename = $value.' '.$row->nm_pd.' - '.$row->id_mahasiswa_pt.' ('.$fakultas->inisial_fak.' - '.strtoupper($row->nama_prodi).').jpg';
		    			
		    			copy($file->file_mahasiswa, 'dokumen/ekspor/'.$filename);
	             		$zip->addFile('dokumen/ekspor/'.$filename);
	             	} 
               	}
	    	}

            $zip->close(); 
    	}

  		header("Content-type: application/zip"); 
		header("Content-Disposition: attachment; filename=$zip_name");
		header("Content-length: " . filesize($folder.$zip_name));
		header("Pragma: no-cache"); 
		header("Expires: 0"); 
		readfile($folder.$zip_name);
	}
	
	function edit(int $id_aktivitas)
	{
		$this->load->model('Mahasiswa_model');

		if($id_aktivitas){
			$aktivitas = $this->Aktivitas_model->aktivitas(['a.id_aktivitas' => $id_aktivitas]);
			if($aktivitas->row()){
				$data['jenis_peran'] = [ '1' => 'Ketua', '2' => 'Anggota', '3' => 'Personal' ];

				$data['aktivitas'] 	= $aktivitas->row();
				$data['anggota'] 	= $this->Aktivitas_model->anggota(['a.id_aktivitas' => $id_aktivitas])->result();
				$data['semester'] 	= $this->Main_model->ref_smt();
				$data['prodi'] 		= $this->Main_model->ref_prodi(($_SESSION['kode_fak'] != '0' ? $_SESSION['kode_fak'] : null));
				$data['kegiatan'] 	= $this->Aktivitas_model->kegiatan([ 'id_jenis_aktivitas_mahasiswa' => $data['aktivitas']->id_jenis_aktivitas_mahasiswa ])->result();
				$data['jenis_aktivitas_mahasiswa'] 	= $this->Main_model->ref_jenis_aktivitas_mahasiswa();
				
				if ($data['aktivitas']->id_jenis_aktivitas_mahasiswa == 6) {
					$data['id_kategori_kegiatan'] = [ 110300 ];
				} else{
					$data['id_kategori_kegiatan'] = [ 110400, 110403, 110404, 110407, 110408 ];
				}

				// $data['kategori_kegiatan'] 	= $this->Aktivitas_model->kategori_kegiatan($id_kategori_kegiatan)->result();

				$data['dosen'] 		= $this->Main_model->get_dosen();
				$data['pembimbing'] = $this->Aktivitas_model->pembimbing([ 'id_aktivitas' => $data['aktivitas']->id_aktivitas ], 'p.pembimbing_ke ASC')->result();
				$data['penguji'] 	= $this->Aktivitas_model->penguji([ 'id_aktivitas' => $data['aktivitas']->id_aktivitas ])->result();
				$data['penjadwalan'] 	= $this->Aktivitas_model->penjadwalan([ 'id_aktivitas' => $data['aktivitas']->id_aktivitas ], 'p.id_kegiatan ASC, p.tanggal ASC')->result();
		
				$data['title'] 		= 'Edit Studi Akhir';
				$data['lead']		= 'Periksa kelengkapan data dan berkas studi akhir.';
				$data['content'] 	= 'studi_akhir/edit';
				$this->load->view('lyt/index',$data);
			}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	}

	function update()
	{
		$data = $this->input->post(null, true);
		
		$sk_tugas = $this->Aktivitas_model->aktivitas([ 'sk_tugas' => $data['sk_tugas'] ], 'updated_at DESC')->row();
		if ($sk_tugas) {
			$data['tanggal_sk_tugas'] 	= $sk_tugas->tanggal_sk_tugas;
			$data['file_sk_tugas'] 		= $sk_tugas->file_sk_tugas;

            $this->Aktivitas_model->add_log($_SESSION['username'], $data, null, 'sk_penugasan_pembimbing');
		}

		if (isset($_FILES)) {
			unset($data['file_sk_tugas_temp']);
			if ($_FILES['file_sk_tugas']['name'] != '') {
				unlink('./'.substr($this->input->post('file_sk_tugas_temp', null, true), strlen(base_url())));

				$upload_path = './dokumen/studi_akhir/sk/';
				if( !is_dir($upload_path) ) {
		            mkdir($upload_path, 0777, TRUE);
		        }

				$config['upload_path']          = $upload_path;
			    $config['allowed_types']        = 'pdf';
			    $config['encrypt_name'] 		= TRUE;
			    // $config['file_name'] 		= TRUE;
			    $config['overwrite']			= true;
			    $config['max_size']             = 10240; // 10MB

			    $this->load->library('upload', $config);
			    if ($this->upload->do_upload('file_sk_tugas')) {
			    	$data['file_sk_tugas'] = base_url('dokumen/studi_akhir/sk/'.$this->upload->data('file_name'));

            		$this->Aktivitas_model->add_log($_SESSION['username'], $data, null, 'sk_penugasan_pembimbing');
			    }
			}
		}

		$update = $this->Aktivitas_model->update(array_slice($data, 1), [ 'id_aktivitas' => $data['id_aktivitas'] ]);
		$this->Aktivitas_model->add_log($_SESSION['username'], $data, null, 'update_studi_akhir');
		
		if ($update) {
			$this->session->set_flashdata('msg', 'Data studi akhir berhasil diperbaharui.');
			$this->session->set_flashdata('msg_clr', 'success');
			redirect('studi_akhir/edit/'.$data['id_aktivitas']);
		}
	}
	
	function hapus($id_aktivitas)
	{
		if(in_array($_SESSION['app_level'], $this->app_level)) {
			$where = ['sha1(id_aktivitas)' => $id_aktivitas];
			$hapus = $this->Aktivitas_model->delete('aktivitas', $where);

			if ($hapus) {
				$this->Aktivitas_model->delete('anggota', $where);
				$this->Aktivitas_model->delete('pembimbing', $where);
				$this->Aktivitas_model->delete('penguji', $where);

    			$this->Aktivitas_model->add_log($_SESSION['username'], $where, null, $this->router->method);

			// 	$this->session->set_flashdata('msg', 'Dosen '.$table.' berhasil dihapus.');
			// 	$this->session->set_flashdata('msg_clr', 'success');
			// 	redirect('studi_akhir/edit/'.$id_aktivitas);
			}
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function hapus_berkas_anggota(int $id_berkas_anggota, int $id_aktivitas)
	{
		if(in_array($_SESSION['app_level'], $this->app_level)){
			$hapus = $this->Aktivitas_model->hapus_berkas_anggota([ 'id_berkas_anggota' => $id_berkas_anggota ]);
			if ($hapus) {
				unlink('./'.substr($this->input->get('file'), strlen(base_url())));

    			$this->Aktivitas_model->add_log($_SESSION['username'], ['id_berkas_anggota' => $id_berkas_anggota, 'id_aktivitas' => $id_aktivitas]);

				$this->session->set_flashdata('msg', 'Berkas berhasil dihapus. Silahkan periksa kembali data mahasiswa.');
				$this->session->set_flashdata('msg_clr', 'success');
				redirect('studi_akhir/edit/'.$id_aktivitas);
			}
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function status_kegiatan_anggota(int $id_kegiatan, int $id_anggota, int $status, int $id_aktivitas)
	{
		if(in_array($_SESSION['app_level'], $this->app_level)){
			$data = [
				'id_kegiatan' 	=> $id_kegiatan,
				'id_anggota'	=> $id_anggota,
				'status'		=> $status
			];

			echo $this->Aktivitas_model->status_kegiatan_anggota($data) ? 'success' : 'failed';

			$data['id_aktivitas'] = $id_aktivitas;
    		$this->Aktivitas_model->add_log($_SESSION['username'], $data, null, $this->router->method);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function tambah_dosen($table)
	{
		if(in_array($_SESSION['app_level'], $this->app_level)){
			$data = $this->input->post(null, true);

			$tambah = $this->Aktivitas_model->tambah_dosen($table, $data);
			if ($tambah) {
    			$this->Aktivitas_model->add_log($_SESSION['username'], $data, null, $this->router->method.'_'.$table);

				$this->session->set_flashdata('msg', 'Dosen '.$table.' berhasil ditambahkan.');
				$this->session->set_flashdata('msg_clr', 'success');
				redirect('studi_akhir/edit/'.$data['id_aktivitas']);
			}
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function tambah_penjadwalan()
	{
		if(in_array($_SESSION['app_level'], $this->app_level)){
			$data = $this->input->post(null, true);
			$data['event_id'] = time().$data['id_aktivitas'];

			$tambah = $this->Aktivitas_model->tambah_penjadwalan($data);
			if ($tambah) {
    			$this->Aktivitas_model->add_log($_SESSION['username'], $data, null, $this->router->method);

				$this->session->set_flashdata('msg', 'Penjadwalan kegiatan berhasil ditambahkan.');
				$this->session->set_flashdata('msg_clr', 'success');
				redirect('studi_akhir/edit/'.$data['id_aktivitas']);
			}
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function hapus_dosen($table, $id, $id_aktivitas)
	{
		if(in_array($_SESSION['app_level'], $this->app_level)){
			$data = [ 'id_'.$table => $id, 'id_aktivitas' => $id_aktivitas ];
			$hapus = $this->Aktivitas_model->hapus_dosen($table, $data);

			if ($hapus) {
    			$this->Aktivitas_model->add_log($_SESSION['username'], $data, null, $this->router->method.'_'.$table);

				$this->session->set_flashdata('msg', 'Dosen '.$table.' berhasil dihapus.');
				$this->session->set_flashdata('msg_clr', 'success');
				redirect('studi_akhir/edit/'.$id_aktivitas);
			}
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function hapus_penjadwalan($id_penjadwalan, $id_aktivitas)
	{
		if(in_array($_SESSION['app_level'], $this->app_level)){
			$hapus = $this->Aktivitas_model->hapus_penjadwalan([ 'id_penjadwalan' => $id_penjadwalan, 'id_aktivitas' => $id_aktivitas ]);
			if ($hapus) {
				$data = [ 'id_penjadwalan' => $id_penjadwalan, 'id_aktivitas' => $id_aktivitas ];
    			$this->Aktivitas_model->add_log($_SESSION['username'], $data, null, $this->router->method);

				$this->session->set_flashdata('msg', 'Penjadwalan kegiatan berhasil dihapus.');
				$this->session->set_flashdata('msg_clr', 'success');
				redirect('studi_akhir/edit/'.$id_aktivitas);
			}
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function json()
	{
		$this->load->model('Aktivitas_data_model');
	    
		$list = $this->Aktivitas_data_model->get_datatables();
        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            
            $row[] = $field->id_aktivitas;
            $row[] = $field->id_mahasiswa_pt;
            $row[] = '<a href="'.base_url('studi_akhir/edit/'.$field->id_aktivitas).'" class="text-decoration-none">'.$field->nm_pd.'</a>';
            $row[] = $field->nm_jenj_didik.' - '.$field->nama_prodi;
            $row[] = $field->nama_semester;
            $row[] = $field->nama_jenis_aktivitas_mahasiswa;
            $row[] = $field->judul ?: '-';

            if ($field->id_jenis_aktivitas_mahasiswa == '6') { // Kerja Praktek / PKL
        		$row[] = (ucwords(strtolower($field->nm_sdm))?: '-');
            } else {
            	$pmb = '<ol class="ps-3 m-0">';
            	$pembimbing = $this->Aktivitas_model->pembimbing( ['id_aktivitas' => $field->id_aktivitas], 'pembimbing_ke ASC' );
            	foreach ($pembimbing->result() as $row_pembimbing) {
            		$pmb .= '<li data-bs-toggle="tooltip" title="'.$row_pembimbing->nidn.'">'.ucwords(strtolower($row_pembimbing->nm_sdm)).'</li>';
            	}
            	$pmb .= '</ol>';

            	$row[] = ($pembimbing->num_rows() > 0 ? $pmb : '-');

	        	// $row[] = ($field->id_jenis_aktivitas_mahasiswa == '2' ? '<br><sup>[1]</sup> ' : '' ).
	        	// 		 (ucwords(strtolower($field->nm_sdm))?: '-').
	        	// 		 ($field->id_jenis_aktivitas_mahasiswa == '2' ? ' <br><sup>[2]</sup> '.
	        	// 		 	(ucwords(strtolower($field->nm_sdm_2))?: '') : '');
            }

            $row[] = $field->status ? '<span class="text-secondary">Selesai</span>' : '<span class="text-danger">Belum Selesai</span>';
            $row[] = '<a class="badge bg-danger" title="Hapus" onclick="return hapus(\''.sha1($field->id_aktivitas).'\')" style="cursor: pointer;">Hapus</a>';

            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Aktivitas_data_model->count_all(),
            "recordsFiltered" => $this->Aktivitas_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}

	function dosen_pembimbing()
	{
		if(in_array($_SESSION['app_level'], $this->app_level_dosen)){
			$data['title'] 		= 'Dosen Pembimbing';
			$data['lead'] 		= 'Kelola data studi akhir mahasiswa sebagai dosen pembimbing.';
			$data['content'] 	= 'studi_akhir/dosen_pembimbing';
			$data['jenis_bimbingan'] = 1;
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function dosen_penguji()
	{
		if(in_array($_SESSION['app_level'], $this->app_level_dosen)){
			$data['title'] 		= 'Dosen Penguji';
			$data['lead'] 		= 'Kelola data studi akhir mahasiswa sebagai dosen penguji.';
			$data['content'] 	= 'studi_akhir/dosen_penguji';
			$data['jenis_bimbingan'] = 2;
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function ketua_sidang()
	{
		if(in_array($_SESSION['app_level'], $this->app_level_dosen)){
			$data['title'] 		= 'Ketua Sidang';
			$data['lead'] 		= 'Kelola dan akhiri pelaksanaan seminar & sidang mahasiswa.';
			$data['content'] 	= 'studi_akhir/ketua_sidang';
			$data['jenis_bimbingan'] = 3;
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function json_dosen($jenis_bimbingan=null)
	{
		$_GET['nidn'] = $_SESSION['username'];
		$_GET['jenis_bimbingan'] = $jenis_bimbingan;
		$link = [
			1 => 'dosen_pembimbing',
			2 => 'dosen_penguji',
			3 => 'ketua_sidang'
		];

		$this->load->model('Aktivitas_data_model');

		$list = $this->Aktivitas_data_model->get_datatables();
        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            
            $row[] = $field->id_mahasiswa_pt;
            $row[] = '<a href="'.base_url('bimbingan/'.$link[$jenis_bimbingan].'/'.$field->id_aktivitas).($jenis_bimbingan == 1 ? '' : '/'.$field->id_kegiatan).'" class="text-decoration-none">'.$field->nm_pd.'</a>';
            $row[] = $field->nm_jenj_didik.' - '.$field->nama_prodi;
            $row[] = $field->nama_semester;
            $row[] = $field->nama_jenis_aktivitas_mahasiswa;
            $row[] = $field->judul ?: '-';

            if (in_array($jenis_bimbingan, ['2', '3'])) {
	            $row[] = $field->deskripsi;
	            $row[] = format_indo($field->tanggal).' WIB';
            	$row[] = $field->status_kegiatan ? '<span class="text-secondary">Selesai</span>' : '<span class="text-danger">Belum</span>';
            } else {
            	$row[] = $field->status ? '<span class="text-secondary">Selesai</span>' : '<span class="text-danger">Belum Selesai</span>';
            }
            

            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Aktivitas_data_model->count_all(),
            "recordsFiltered" => $this->Aktivitas_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
}
