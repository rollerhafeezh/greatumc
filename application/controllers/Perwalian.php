<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Perwalian extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){redirect(base_url('logout'));}
		if($_SESSION['logged_in']==FALSE){ redirect (base_url('logout'));}
		
		$this->load->model('Krs_model');
		$this->load->model('Aktivitas_model');
		$this->load->model('Mbkm_model');
	}
	
	function index()
	{
		if($_SESSION['app_level']==2){
			$data['title'] 		= 'Daftar Mahasiswa KRS';
			$data['content'] 	= 'perwalian/tabel';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function simpan_perwalian($id_smt=null,$id_mahasiswa_pt=null)
	{
		if($_SESSION['app_level']==2){
		/*---if mahasiswa tetap pake sesi----*/
		$id_smt 	= ($id_smt)?:$_SESSION['active_smt'];
		
		/*---if id mahasiswa ada----*/
		if($id_mahasiswa_pt){
			$krs = $_POST['id_krs'];
			$total_sks = $_POST['total_sks'];
			foreach($krs as $key){
				$this->Krs_model->update_krs($key,1);
			}
			$this->Krs_model->update_kuliah_mahasiswa_value($id_mahasiswa_pt,$id_smt,'sks_smt',$total_sks);
			$proses = $this->Krs_model->simpan_perwalian($id_mahasiswa_pt,$id_smt);
			if($proses)
			{
				$this->Krs_model->simpan_kelas_kuliah($id_mahasiswa_pt,$id_smt);
				$this->Krs_model->validasi_krs_keuangan($id_mahasiswa_pt,$id_smt);

				$detail_krs = $this->Krs_model->list_kelas_krs($id_mahasiswa_pt, $id_smt)->result();
		        $mahasiswa_pt = $this->Aktivitas_model->mahasiswa_pt([ 'mp.id_mahasiswa_pt' => $id_mahasiswa_pt ])->row();
		        foreach ($detail_krs as $mk) {
		            if ($mk->id_kat_mk == 3 OR $mk->id_kat_mk == 5) { // KERJA PRAKTEK & TUGAS AKHIR
		                $id_jenis_aktivitas_mahasiswa = ($mk->id_kat_mk == 3 ? 6 : 2);
		                    
		                $jml_aktivitas = $this->Aktivitas_model->anggota([ 'a.id_mahasiswa_pt' => $id_mahasiswa_pt, 'as.id_jenis_aktivitas_mahasiswa' => $id_jenis_aktivitas_mahasiswa ])->num_rows();

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
		                         'username' => $mahasiswa_pt->id_mhs,
		                         'id_level' => ($mk->id_kat_mk == 3 ? 16 : 7)
		                     ];

		                     $user_level = $this->Aktivitas_model->tambah_user_level($data_sso);
		                 }
		            }
		        }
				
				$whythis='simpan_perwalian';
				$whatdo='#id_mahasiswa_pt:'.$id_mahasiswa_pt.'#id_smt:'.$id_smt;
				$this->Main_model->akademik_log($whythis,$whatdo);
				
				$this->session->set_flashdata('msg', 'KRS Divalidasi!');
				$this->session->set_flashdata('msg_clr', 'success');
			}else{
				$this->session->set_flashdata('msg', 'Gagal Nih! Coba Lagi!');
				$this->session->set_flashdata('msg_clr', 'danger');
			}
			redirect('perwalian/validasi/'.$id_smt.'/'.$id_mahasiswa_pt);
			
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function isi_catatan($id_smt=null,$id_mahasiswa_pt=null)
	{
		if($_SESSION['app_level']==2){
		/*---if mahasiswa tetap pake sesi----*/
		$id_smt 	= ($id_smt)?:$_SESSION['active_smt'];
		
		/*---if id mahasiswa ada----*/
		if($id_mahasiswa_pt){
			$this->load->helper('security');
			$data=['id_smt'=>$id_smt,'id_mahasiswa_pt'=>$id_mahasiswa_pt,'isi_catatan'=>htmlspecialchars_decode($this->input->post('isi_catatan'),true)];
			$proses = $this->Krs_model->isi_catatan($data);
			if($proses) echo 1; else echo 0;
			
		}else{ echo 0; }
		}else{ echo 0; }
	}
	
	function validasi($id_smt=null,$id_mahasiswa_pt=null)
	{
		if($_SESSION['app_level']!=1){
		/*---if mahasiswa tetap pake sesi----*/
		$id_smt 	= ($id_smt)?:$_SESSION['active_smt'];
		
		/*---if id mahasiswa ada----*/
		if($id_mahasiswa_pt){
			$bearer = ['id_mahasiswa_pt'=>$id_mahasiswa_pt];
			$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
			
		/*---if mahasiswa ada----*/
		if($mahasiswa_pt){
			$data['mbkm'] = $this->Mbkm_model->pendaftaran_aktivitas([ 'p.id_mahasiswa_pt' => $id_mahasiswa_pt, 'a.id_smt' => $id_smt ]);
			$id_program_mitra = $data['mbkm']->num_rows() > 0 ? $data['mbkm']->row()->id_program_mitra : null;

			$data['krs_note']	= $this->Krs_model->get_krs_note($id_mahasiswa_pt,$id_smt)->row();
			$data['list_kelas_krs']	= $this->Krs_model->list_kelas_krs($id_mahasiswa_pt,$id_smt, $id_program_mitra);
			$data['id_smt']		= $id_smt;
			$data['mahasiswa_pt']= $mahasiswa_pt[0];
			$data['title'] 		= 'Validasi KRS '.$mahasiswa_pt[0]->nm_pd.' '.nama_smt($id_smt);
			$data['content'] 	= 'perwalian/validasi';
			$this->load->view('lyt/index',$data);
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function mbkm()
	{
		if($_SESSION['app_level']==2){
			$data['title'] 		= 'Daftar Mahasiswa Perwalian MBKM';
			$data['content'] 	= 'perwalian/tabel_mahasiswa_mbkm';
			$this->load->view('lyt/index', $data);
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function tabel_mahasiswa($id_dosen=null)
	{
		if($_SESSION['app_level']!=1){
		if($_SESSION['app_level']==2) $id_dosen = $_SESSION['id_user'];
	    
	    if($id_dosen){
	    $bearer = ['id_dosen'=>$id_dosen];
		$dosen = $this->Main_model->post_api('dosen/dosen',$bearer);
		if($dosen){
		    
			$data['id_dosen'] 	= $id_dosen;
			$data['title'] 		= 'Daftar Mahasiswa Perwalian '.$dosen[0]->nm_sdm;
			$data['content'] 	= 'perwalian/tabel_mahasiswa';
			$this->load->view('lyt/index',$data);
			
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	    }else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function json_krs()
	{
		$this->load->model('Perwalian_krs_data_model');
	    
		$list = $this->Perwalian_krs_data_model->get_datatables();
		
        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            
            $row[] = nama_smt($field->id_smt) ;
            $row[] = $field->id_mahasiswa_pt ;
            $row[] = '<a href="'.base_url('perwalian/validasi/'.$field->id_smt.'/'.$field->id_mahasiswa_pt).'">'.$field->nm_pd .'</a>';
            $row[] = $field->nama_fak.'-'.$field->nama_prodi ;
            $row[] = ($field->validasi)?'<span class="text-info">Sudah</span>':'<span class="text-danger">Belum</span>' ;
            
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
	
	function json_perwalian()
	{
		$this->load->model('Perwalian_data_model');
	    
		$list = $this->Perwalian_data_model->get_datatables();
        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
			$jenis_keluar = ($field->id_jns_keluar==0)?'Aktif':jenis_keluar($field->id_jns_keluar);
            $no++;
            $row = array();
            
            $row[] = $field->id_mahasiswa_pt ;
            $row[] = '<a href="'.base_url('biodata/mahasiswa/'.$field->id_mahasiswa_pt).'">'.$field->nm_pd .'</a>';
            $row[] = $field->inisial_fak.'-'.$field->nama_prodi ;
            $row[] = nama_smt($field->mulai_smt) ;
            $row[] = $jenis_keluar;
            
            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Perwalian_data_model->count_all(),
            "recordsFiltered" => $this->Perwalian_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
}