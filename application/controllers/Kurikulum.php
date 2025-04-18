<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Kurikulum extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){redirect(base_url('logout'));}
		if($_SESSION['logged_in']==FALSE){ redirect (base_url('logout'));}
		
		$this->load->model('Kurikulum_model');
	}
	
	function remove_mk_konv()
	{
        if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		
		$id_mata_kuliah_kurikulum=$this->input->post('id_mata_kuliah_kurikulum');
		$save = $this->Kurikulum_model->remove_mk_konv($id_mata_kuliah_kurikulum);
		if($save){
		    
			$whythis='remove_mk_konv';
			$action='#id_mata_kuliah_kurikulum:'.$this->input->post('id_mata_kuliah_kurikulum');
			$this->Main_model->akademik_log($whythis,$action);
			
			echo 'refresh halaman untuk memunculkan opsi';
		}else{
			echo 'error';
		}
        }else{ echo 'error'; }
	}
	
	function store_mk_konv()
	{
        if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		
		$id_mata_kuliah_kurikulum=$this->input->post('id_mata_kuliah_kurikulum');
		$id_matkul_konv=$this->input->post('id_matkul_konv');
		$save = $this->Kurikulum_model->store_mk_konv($id_mata_kuliah_kurikulum,$id_matkul_konv);
		if($save){
		    $hasil = $save->row();
			$whythis='store_or_upd_mk_konv';
			$action='#id_mata_kuliah_kurikulum:'.$this->input->post('id_mata_kuliah_kurikulum').'#id_matkul_konv:'.$this->input->post('id_matkul_konv');
			$this->Main_model->akademik_log($whythis,$action);
			
			echo '<strong>'.$hasil->kode_mk.'</strong> '.$hasil->nm_mk.' ('.$hasil->sks_mk.')';
		}else{
			echo 'error';
		}
        }else{ echo 'error'; }
	}
	
	function list_mk_kur($id_kur,$kurikulum_asal)
	{
		$list_mk_kur = $this->Kurikulum_model->list_mk_konversi($id_kur,$kurikulum_asal)->result();
		$data['list_mk_kur']	= $list_mk_kur;
		$data['id_mata_kuliah_kurikulum']	= $this->input->post('id_mata_kuliah_kurikulum');
		$data['id_kur']	= $id_kur;
		$data['kurikulum_asal']	= $kurikulum_asal;
		$this->load->view('kurikulum/list_mk_kur',$data);
	}
	
	function set_asal($id_kur,$id_kur_asal)
	{
		$_SESSION['kurikulum_asal']=$id_kur_asal;
		redirect(base_url('kurikulum/konversi_kurikulum/'.$id_kur));
	}

	function remove_asal($id_kur)
	{
		unset($_SESSION['kurikulum_asal']);
		redirect(base_url('kurikulum/konversi_kurikulum/'.$id_kur));
	}
	
	function index()
	{
		if($_SESSION['app_level']!=1){
			$data['title'] 		= 'Daftar Kurikulum';
			$data['content'] 	= 'kurikulum/tabel';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function konversi_kurikulum($id_kur=null)
	{
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		if($id_kur){
		$kurikulum = $this->Kurikulum_model->get_kurikulum($id_kur)->row();
		if($kurikulum){
			$data['mata_kuliah_kurikulum'] 	= $this->Kurikulum_model->get_mata_kuliah_kurikulum_konversi($id_kur)->result();
			$data['kurikulum'] 	= $kurikulum;
			$data['title'] 		= 'Konversi '.$kurikulum->nm_kurikulum_sp;
			$data['content'] 	= 'kurikulum/konversi';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function add()
	{
		$check = $this->Main_model->get_konfigurasi('buat_kurikulum')->row();
		if($check->value_konfigurasi=='on'){
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
			$data['title'] 		= 'Buat Kurikulum';
			$data['content'] 	= 'kurikulum/add';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Tutup';	$data['content'] = 'lyt/pesan'; $data['pesan'] = '<span class="text-danger h3">Pembuatan Kurikulum di tutup. Hubungi Akademik Universitas.</span>';	$this->load->view('lyt/index',$data); }
	}
	
	function detail($id_kur=null)
	{
		if($_SESSION['app_level']!=1){
		if($id_kur){
		$kurikulum = $this->Kurikulum_model->get_kurikulum($id_kur)->row();
		if($kurikulum){
		    $check = $this->Main_model->get_konfigurasi('ubah_kurikulum')->row();
			$data['mata_kuliah_kurikulum'] 	= $this->Kurikulum_model->get_mata_kuliah_kurikulum($id_kur)->result();
			$data['kurikulum'] 	= $kurikulum;
			$data['check'] 	    = $check;
			$data['title'] 		= 'Detail Kurikulum '.$kurikulum->nm_kurikulum_sp;
			$data['content'] 	= 'kurikulum/detail';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function simpan_mata_kuliah_kurikulum()
	{
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		$get_matkul = $this->Main_model->get_mata_kuliah($this->input->post('id_matkul'))->row();
		if($get_matkul){
			$data=[
				'id_kur'=>$this->input->post('id_kur'),
				'smt'=>$this->input->post('smt'),
				'a_wajib'=>$this->input->post('a_wajib'),
				'id_matkul'=>$get_matkul->id_matkul,
				'sks_mk'=>$get_matkul->sks_mk,
				'sks_tm'=>$get_matkul->sks_tm,
				'sks_prak'=>$get_matkul->sks_prak,
				'sks_prak_lap'=>$get_matkul->sks_prak_lap,
				'sks_sim'=>$get_matkul->sks_sim,
			];
			$id_kur = $this->Kurikulum_model->simpan_mata_kuliah_kurikulum($data);
			if($id_kur)
			{
				$whythis='simpan_mata_kuliah_kurikulum';
				$whatdo='#id_kur:'.$id_kur.'#id_matkul:'.$get_matkul->id_matkul.'#smt:'.$this->input->post('smt');
				$this->Main_model->akademik_log($whythis,$whatdo);
				
				$this->session->set_flashdata('msg', 'Data Tersimpan!');
				$this->session->set_flashdata('msg_clr', 'success');
				redirect('kurikulum/detail/'.$this->input->post('id_kur'));
			}else{
				$this->session->set_flashdata('msg', 'Gagal Tersimpan!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('kurikulum/detail/'.$this->input->post('id_kur'));
			}
		}else{
			$this->session->set_flashdata('msg', 'Mata Kuliah tidak ditemukan!');
			$this->session->set_flashdata('msg_clr', 'danger');
			redirect('kurikulum/detail/'.$this->input->post('id_kur'));
		}
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function hapus_mata_kuliah_kurikulum($id_kur=null,$id_mata_kuliah_kurikulum=null)
	{
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		if($id_kur && $id_mata_kuliah_kurikulum){
			
			$proses = $this->Kurikulum_model->hapus_mata_kuliah_kurikulum($id_mata_kuliah_kurikulum);
			if($proses)
			{
				$whythis='hapus_mata_kuliah_kurikulum';
				$whatdo='#id_kur:'.$id_kur.'#id_mata_kuliah_kurikulum:'.$id_mata_kuliah_kurikulum;
				$this->Main_model->akademik_log($whythis,$whatdo);
				
				$this->session->set_flashdata('msg', 'Data Terhapus!');
				$this->session->set_flashdata('msg_clr', 'success');
				redirect('kurikulum/detail/'.$id_kur);
			}else{
				$this->session->set_flashdata('msg', 'Gagal Terhapus!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('kurikulum/detail/'.$id_kur);
			}
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function simpan_kurikulum()
	{
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
			$data=[
				'id_smt'=>$this->input->post('id_smt'),
				'nm_kurikulum_sp'=>$this->input->post('nm_kurikulum_sp'),
				'kode_prodi'=>$this->input->post('kode_prodi'),
				'jml_sem_normal'=>($this->input->post('jml_sem_normal'))?:NULL,
				'jml_sks_lulus'=>($this->input->post('jml_sks_lulus'))?:NULL,
				'jml_sks_wajib'=>($this->input->post('jml_sks_wajib'))?:NULL,
				'jml_sks_pilihan'=>($this->input->post('jml_sks_pilihan'))?:NULL
			];
			$id_kur = $this->Kurikulum_model->simpan_kurikulum($data);
			if($id_kur)
			{
				if($this->input->post('kur_aktif'))
				{
					$this->Kurikulum_model->aktif_kurikulum($id_kur);
				}
				
				if($_FILES['sk_kurikulum']['name'])
				{
					$nama_dokumen = $id_kur.'-'.$this->input->post('nm_kurikulum_sp');
					$simpan_file = $this->Main_model->unggah_dokumen($nama_dokumen,'./dokumen/kurikulum/','pdf','sk_kurikulum');
					if($simpan_file)
					{
						$nama_dokumen=base_url('dokumen/kurikulum/'.$simpan_file['upload_data']['file_name']);
						$this->Kurikulum_model->update_sk($id_kur,$nama_dokumen);
					}
				}
				
				$whythis='simpan_kurikulum';
				$whatdo='#id_kur:'.$id_kur.'#nm_kurikulum_sp:'.$this->input->post('nm_kurikulum_sp');
				$this->Main_model->akademik_log($whythis,$whatdo);
				
				$this->session->set_flashdata('msg', 'Data Tersimpan!');
				$this->session->set_flashdata('msg_clr', 'success');
				redirect('kurikulum/detail/'.$id_kur);
			}else{
				$this->session->set_flashdata('msg', 'Gagal Tersimpan!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('kurikulum/add');
			}
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function hapus_kurikulum($id_kur=null)
	{
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		if($id_kur){
		$mk_kur = $this->Kurikulum_model->get_mata_kuliah_kurikulum($id_kur)->row();
		if(!$mk_kur){
			$proses = $this->Kurikulum_model->hapus_kurikulum($id_kur);
			if($proses)
			{
				$whythis='hapus_kurikulum';
				$whatdo='#id_kur:'.$id_kur;
				$this->Main_model->akademik_log($whythis,$whatdo);
				
				$this->session->set_flashdata('msg', 'Data Terhapus!');
				$this->session->set_flashdata('msg_clr', 'success');
				redirect('kurikulum/');
			}else{
				$this->session->set_flashdata('msg', 'Gagal Terhapus!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('kurikulum/detail/'.$id_kur);
			}
			
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function ubah_mk_kur()
	{
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		
		    $smt = $this->input->post('smt');
		    $id_mata_kuliah_kurikulum = $this->input->post('id_mata_kuliah_kurikulum');
			$proses = $this->Kurikulum_model->ubah_mk_kur($id_mata_kuliah_kurikulum,$smt);
			if($proses)
			{
				$whythis='ubah_smt_mk_kur';
				$whatdo='#smt:'.$smt.'#id_mata_kuliah_kurikulum'.$id_mata_kuliah_kurikulum;
				$this->Main_model->akademik_log($whythis,$whatdo);
				
				echo 1;
			}else{
				echo 0;
			}
			
		}else{ echo 0; }
	}
	
	function aktifasi_kurikulum($id_kur=null)
	{
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		if($id_kur){
		
			$proses = $this->Kurikulum_model->aktif_kurikulum($id_kur);
			if($proses)
			{
				$whythis='aktifasi_kurikulum';
				$whatdo='#id_kur:'.$id_kur;
				$this->Main_model->akademik_log($whythis,$whatdo);
				
				$this->session->set_flashdata('msg', 'Aktif!');
				$this->session->set_flashdata('msg_clr', 'success');
				redirect('kurikulum/detail/'.$id_kur);
			}else{
				$this->session->set_flashdata('msg', 'Gagal!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('kurikulum/detail/'.$id_kur);
			}
			
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function update_kurikulum($id_kur=null)
	{
		if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){
		if($id_kur){
			$data=[
				
				'id_kur'=>$id_kur,
				'nm_kurikulum_sp'=>$this->input->post('nm_kurikulum_sp'),
				'jml_sem_normal'=>($this->input->post('jml_sem_normal'))?:NULL,
				'jml_sks_lulus'=>($this->input->post('jml_sks_lulus'))?:NULL,
				'jml_sks_wajib'=>($this->input->post('jml_sks_wajib'))?:NULL,
				'jml_sks_pilihan'=>($this->input->post('jml_sks_pilihan'))?:NULL
			];
			$proses = $this->Kurikulum_model->update_kurikulum($data);
			if($proses)
			{
				if($_FILES['sk_kurikulum']['name'])
				{
					$nama_dokumen = $id_kur.'-'.$this->input->post('nm_kurikulum_sp');
					$simpan_file = $this->Main_model->unggah_dokumen($nama_dokumen,'./dokumen/kurikulum/','pdf','sk_kurikulum');
					if($simpan_file)
					{
						$nama_dokumen=base_url('dokumen/kurikulum/'.$simpan_file['upload_data']['file_name']);
						$this->Kurikulum_model->update_sk($id_kur,$nama_dokumen);
					}
				}
				
				$whythis='update_kurikulum';
				$whatdo='#id_kur:'.$id_kur.'#nm_kurikulum_sp:'.$this->input->post('nm_kurikulum_sp');
				$this->Main_model->akademik_log($whythis,$whatdo);
				
				$this->session->set_flashdata('msg', 'Data Tersimpan!');
				$this->session->set_flashdata('msg_clr', 'success');
				redirect('kurikulum/detail/'.$id_kur);
			}else{
				$this->session->set_flashdata('msg', 'Gagal Tersimpan!');
				$this->session->set_flashdata('msg_clr', 'danger');
				redirect('kurikulum/detail/'.$id_kur);
			}
			
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

	function json()
	{
		$this->load->model('Kurikulum_data_model');
	    
		$list = $this->Kurikulum_data_model->get_datatables();
        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            
            $row[] = nama_smt($field->id_smt);
            $row[] = '<a href="'.base_url('kurikulum/detail/'.$field->id_kur).'">'.$field->nm_kurikulum_sp.'</a>';
            $row[] = $field->inisial_fak.' '.$field->nama_prodi;
            $row[] = ($field->kur_aktif==1)?'Aktif':'Non-Tidak';

            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Kurikulum_data_model->count_all(),
            "recordsFiltered" => $this->Kurikulum_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	function get_mata_kuliah_kurikulum($id_kur,$kode_prodi)
	{
	    $result=$this->Kurikulum_model->get_add_mata_kuliah_kurikulum($id_kur,$kode_prodi)->result();
		if($result){
		$option="<option>Pilih Mata Kuliah</option>";
		foreach ($result as $key=>$value ){
			$option.= '<option value="'.$value->id_matkul.'">'.$value->kode_mk.' '.$value->nm_mk.'</option>';
		}
		}else{
			$option="<option>Tidak ada Mata Kuliah Tersedia</option>";
		}
		echo $option;
	}

}
