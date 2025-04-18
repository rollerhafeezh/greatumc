<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Nilai extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){redirect(base_url('logout')); }
		if($_SESSION['logged_in']==FALSE){ redirect (base_url('logout')); }
		if($_SESSION['app_level']!=3){ redirect (base_url('dashboard')); }
		$this->load->helper('security');
		$this->load->model(['Nilai_model','Kurikulum_model']);
	}
	
	function index()
	{
		echo'wdyt';
	}
	
	function konversi($id_mahasiswa_pt=null)
	{
	    if($id_mahasiswa_pt){
			$bearer = ['id_mahasiswa_pt'=>$id_mahasiswa_pt];
			$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
			
		/*---if mahasiswa ada----*/
		if($mahasiswa_pt){
		    $id_kur = $this->Nilai_model->get_kur_aktif($mahasiswa_pt[0]->kode_prodi)->row()->id_kur;
		    $data['mata_kuliah_kurikulum'] 	= $this->Kurikulum_model->get_mata_kuliah_kurikulum($id_kur)->result();
    	    $data['title'] 		= 'Nilai Konversi Kurikulum';
    	    $data['mahasiswa_pt'] 		= $mahasiswa_pt[0];
    		$data['content'] 	= 'nilai/konversi';
    		$this->load->view('lyt/index',$data);
    		
		}else{ $data['title']	 = 'Data tidak Ditemukan';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function manual($id_mahasiswa_pt=null)
	{
	    if($id_mahasiswa_pt){
			$bearer = ['id_mahasiswa_pt'=>$id_mahasiswa_pt];
			$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
			
		/*---if mahasiswa ada----*/
		if($mahasiswa_pt){
		    $id_kur = $this->Nilai_model->get_kur_aktif($mahasiswa_pt[0]->kode_prodi)->row()->id_kur;
		    $data['mata_kuliah_kurikulum'] 	= $this->Kurikulum_model->get_mata_kuliah_kurikulum($id_kur)->result();
    	    $data['title'] 		= 'Nilai Manual/ Konversi';
    	    $data['mahasiswa_pt'] 		= $mahasiswa_pt[0];
    		$data['content'] 	= 'nilai/manual';
    		$this->load->view('lyt/index',$data);
    		
		}else{ $data['title']	 = 'Data tidak Ditemukan';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function simpan_manual()
	{
	 $jml_data = count($this->input->post('ceknilai'));

        foreach($this->input->post('ceknilai') as $id_matkul)
        {
            $nilai_angka = 0;
            if($_POST['nilai_huruf_asal-'.$id_matkul]=='A') $nilai_angka = 4;
            if($_POST['nilai_huruf_asal-'.$id_matkul]=='B') $nilai_angka = 3;
            if($_POST['nilai_huruf_asal-'.$id_matkul]=='C') $nilai_angka = 2;
            if($_POST['nilai_huruf_asal-'.$id_matkul]=='D') $nilai_angka = 1;
            $data=[
            'id_mhs' => $this->input->post('id_mhs'),
            'id_mahasiswa_pt' => $this->input->post('id_mahasiswa_pt'),
            'id_matkul' => $id_matkul,
            'kode_mk_asal' => $_POST['kode_mk_konv-'.$id_matkul],
            'nm_mk_asal' => $_POST['nm_mk_konv-'.$id_matkul],
            'sks_asal' => $_POST['sks_mk_konv-'.$id_matkul],
            'sks_diakui' => $_POST['sks_diakui-'.$id_matkul],
            'nilai_huruf_asal' => $_POST['nilai_huruf_asal-'.$id_matkul],
            'nilai_huruf_diakui' => $_POST['nilai_huruf_asal-'.$id_matkul],
            'nilai_angka_diakui' => $nilai_angka,
            ];
            $simpan = $this->Nilai_model->simpan_nilai_konversi($data);
            if($simpan)
            {
                $whythis='simpan_nilai_konversi';
                $whatdo='#id_mahasiswa_pt:'.$this->input->post('id_mahasiswa_pt').'#id_matkul'.$_POST['id_matkul'][$i].'#nilai'.$_POST['nilai_huruf_diakui'][$i];
                $this->Main_model->akademik_log($whythis,$whatdo);
            }
        }
        redirect (base_url('transkrip/index/'.$this->input->post('id_mahasiswa_pt')));
	}
	
	function simpan_konv()
	{
        $jml_data = count($this->input->post('id_matkul'));

        for($i=0;$i<$jml_data;$i++)
        {
            $data=[
                'id_mhs' => $this->input->post('id_mhs'),
                'id_mahasiswa_pt' => $this->input->post('id_mahasiswa_pt'),
                'id_matkul' => $_POST['id_matkul'][$i],
                'kode_mk_asal' => $_POST['kode_mk_asal'][$i],
                'nm_mk_asal' => $_POST['nm_mk_asal'][$i],
                'sks_asal' => $_POST['sks_asal'][$i],
                'sks_diakui' => $_POST['sks_diakui'][$i],
                'nilai_huruf_asal' => $_POST['nilai_huruf_asal'][$i],
                'nilai_huruf_diakui' => $_POST['nilai_huruf_diakui'][$i],
                'nilai_angka_diakui' => $_POST['nilai_angka_diakui'][$i],
                ];
            $simpan = $this->Nilai_model->simpan_nilai_konversi($data);
            if($simpan)
            {
                $whythis='simpan_nilai_konversi';
                $whatdo='#id_mahasiswa_pt:'.$this->input->post('id_mahasiswa_pt').'#id_matkul'.$_POST['id_matkul'][$i].'#nilai'.$_POST['nilai_huruf_diakui'][$i];
                $this->Main_model->akademik_log($whythis,$whatdo);
            }
        }
        redirect (base_url('transkrip/index/'.$this->input->post('id_mahasiswa_pt')));
	}
	
	function nilai_maks($id_mahasiswa_pt,$id_matkul)
	{
		$nilai = $this->Nilai_model->get_nilai($id_matkul,$id_mahasiswa_pt)->row();
		if($nilai->nilai_indeks=='4.00') echo 'A';
		else if($nilai->nilai_indeks=='3.00') echo 'B';
		else if($nilai->nilai_indeks=='2.00') echo 'C';
		else if($nilai->nilai_indeks=='1.00') echo 'D';
		else if($nilai->nilai_indeks=='0.00') echo 'E';
		else echo '';
		
	}

	
}