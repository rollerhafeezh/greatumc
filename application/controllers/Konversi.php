<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konversi extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		if(!isset($_SESSION['logged_in'])){redirect(base_url('logout'));}
		if($_SESSION['logged_in']==FALSE){ redirect (base_url('logout'));}
		
		$this->app_level = [3, 7, 4, 2];
		$this->app_level_dosen = [2];

		$this->load->model('Aktivitas_model');
		$this->load->model('Mbkm_model');
	}

	function simpan($table)
	{
        $db = ($table == 'konversi_aktivitas' ? $_ENV['DB_MBKM'] : $_ENV['DB_GREAT']);

		$data = $this->input->post(null, true);
		$arr_nilai = [
			'4' => 'A',
			'3' => 'B',
			'2' => 'C',
			'1' => 'D',
			'0' => 'E',
		];

        if ($table == 'konversi_aktivitas') {
            $data['sks_mata_kuliah'] = explode('_', $data['id_matkul'])[1];
            $data['id_matkul'] = explode('_', $data['id_matkul'])[0];
    		$data['nilai_indeks'] = array_search($data['nilai_huruf'], $arr_nilai);
        } else {            
            $data['sks_diakui'] = explode('_', $data['id_matkul'])[1];
            $data['id_matkul'] = explode('_', $data['id_matkul'])[0];
            $data['nilai_angka_diakui'] = array_search($data['nilai_huruf_diakui'], $arr_nilai);
        }
        
		$insert = $this->Mbkm_model->insert_ignore($db.$table, $data);
		echo $insert ? 'Sukses: data berhasil simpan.' : 'Error: data gagal disimpan atau data sudah ada, silahkan periksa tabel konversi.';
	}

	function hapus($table, $id)
	{
        $db = ($table == 'konversi_aktivitas' ? $_ENV['DB_MBKM'] : $_ENV['DB_GREAT']);

		if(in_array($_SESSION['app_level'], $this->app_level)){
			$param = [ 'sha1(id_'.$table.')' => $id ];
			$hapus = $this->Mbkm_model->delete($db.$table, $param);
			echo $hapus ? 'Sukses: data berhasil dihapus.' : 'Error: data gagal dihapus.';

		}else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}

    function validasi($table, $id, $id_smt = null)
    {
        $db = ($table == 'konversi_aktivitas' ? $_ENV['DB_MBKM'] : $_ENV['DB_GREAT']);

        if($_SESSION['app_level'] == 3){
            $param = [ 'sha1(id_'.$table.')' => $id ];

            if ($table == 'konversi_aktivitas') {
            	$data = $this->Mbkm_model->get_join($db.$table, $param, null, [ 'join' => $_ENV['DB_MBKM'].'anggota', 'on' => 'anggota.id_anggota = konversi_aktivitas.id_anggota' ])->row();
                $where = [
                    'id_smt' => $data->id_smt,
                    'id_matkul' => $data->id_matkul,
                    'id_mahasiswa_pt' => $data->id_mahasiswa_pt,
                ]; 
                $set = [ 'nilai_huruf' => $data->nilai_huruf, 'nilai_indeks' => $data->nilai_indeks, 'nilai_angka' => $data->nilai_angka ];
                // $update = $this->Mbkm_model->update($_ENV['DB_GREAT'].'nilai', $where, [ 'nilai_huruf' => $data->nilai_huruf, 'nilai_indeks' => $data->nilai_indeks ]);

            } else { // nilai_transfer
            	$data = $this->Mbkm_model->get($db.$table, $param)->row();
                $where = [
                    'id_smt' => $id_smt,
                    'id_matkul' => $data->id_matkul,
                    'id_mahasiswa_pt' => $data->id_mahasiswa_pt,
                ]; 
                $set = [ 'nilai_huruf' => $data->nilai_huruf_diakui, 'nilai_indeks' => $data->nilai_angka_diakui ];
                // $update = $this->Mbkm_model->update($_ENV['DB_GREAT'].'nilai', $where, [ 'nilai_huruf' => $data->nilai_huruf_diakui, 'nilai_indeks' => $data->nilai_angka_diakui ]);
            }

            $update = $this->Mbkm_model->update($_ENV['DB_GREAT'].'nilai', $where, $set);
            $this->Mbkm_model->update($db.$table, $param, [ 'tgl_validasi' => date('Y-m-d') ]);
            // print_r($data);
            echo $update ? 'Sukses: Nilai berhasil divalidasi.' : 'Error: Nilai gagal divalidasi, silahkan hubungi pengelola website.';

        }else{ $data['title']    = 'Error 401'; $data['content'] = 'e401';  $this->load->view('lyt/index',$data); }
    }

	function json_konversi_aktivitas()
    {
        $this->load->model('Konversi_aktivitas_data_model');
        $list = $this->Konversi_aktivitas_data_model->get_datatables();

        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            
            $row[] = $no.'.';
            $row[] = $field->cpl.'<br><small>'.$field->nama_jenis_cpl.'</small>';
            $row[] = $field->sks_cpl;
            $row[] = $field->kode_mk.' - '.$field->nm_mk;
            $row[] = $field->smt;
            $row[] = $field->sks_mk;
            $row[] = $field->nilai_angka;
            $row[] = $field->nilai_huruf;
            $row[] = $field->nilai_indeks;
            
          //   if ($_SESSION['app_level'] == 7 OR $_SESSION['app_level'] == 2) {
        		// $row[] = '<a href="javascript:void(0)" onclick="hapus(`'.sha1($field->id_konversi_aktivitas).'`)" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i></a>';
          //   }

            if ($field->tgl_validasi == null) {
                if ($_SESSION['app_level'] == 7) { // KAPRODI
                    $row[] = '<a href="javascript:void(0)" onclick="hapus(`'.sha1($field->id_konversi_aktivitas).'`)" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i></a>';
                } elseif ($_SESSION['app_level'] == 3) { // AKADEMIK
                    $row[] = '<a href="javascript:void(0)" onclick="validasi(`'.sha1($field->id_konversi_aktivitas).'`)" class="btn btn-info btn-xs" title="Validasi Nilai"><i class="fa fa-check"></i></a>';
                } else {
                    $row[] = 'n/a';
                }
            } else {
                $row[] = '<span class="btn btn-secondary btn-xs" data-bs-toggle="tooltip" title="Validated: '.tanggal_indo($field->tgl_validasi).'"><i class="fa fa-check"></i></span>';
            }

            $data[] = $row;

            $nilai_cpl[] = [
                'id_konversi_aktivitas' => $field->id_konversi_aktivitas,
                'tgl_validasi' =>  ($field->tgl_validasi ?: 'belum')
            ];
        }

        if ( $this->Konversi_aktivitas_data_model->count_all() > 0) {
            $belum = $nilai_cpl ? (array_search('belum', array_column($nilai_cpl, 'tgl_validasi')) !== false ? '0' : '1') : null;
            $nilai_cpl = json_encode($nilai_cpl);
        } else {
            $nilai_cpl = null;
            $belum = null;
        }

        $this->Aktivitas_model->update(['nilai_cpl' => $nilai_cpl], ['sha1(id_aktivitas)' => $_GET['id_aktivitas']], null, $_ENV['DB_MBKM']);
        $this->Aktivitas_model->update(['status_nilai_cpl' => $belum], ['sha1(id_aktivitas)' => $_GET['id_aktivitas']], null, $_ENV['DB_MBKM']);
        
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Konversi_aktivitas_data_model->count_all(),
            "recordsFiltered" => $this->Konversi_aktivitas_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
    }

    function json_nilai_transfer()
    {
        $this->load->model('Nilai_transfer_data_model');
        $list = $this->Nilai_transfer_data_model->get_datatables();

        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            
            $row[] = $field->nm_lemb;
            $row[] = $field->kode_mk_asal;
            $row[] = $field->nm_mk_asal;
            $row[] = $field->sks_asal;
            $row[] = $field->nilai_huruf_asal;

            $row[] = $field->kode_mk;
            $row[] = $field->nm_mk;
            $row[] = $field->sks_mk;
            $row[] = $field->nilai_huruf_diakui;
            $row[] = $field->nilai_angka_diakui;
            
            // if ($_SESSION['app_level'] == 7 OR $_SESSION['app_level'] == 2 OR $_SESSION['app_level'] == 3) {
            if ($field->tgl_validasi == null) {
                if ($_SESSION['app_level'] == 7) { // KAPRODI
                    $row[] = '<a href="javascript:void(0)" onclick="hapus(`'.sha1($field->id_nilai_transfer).'`)" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i></a>';
                } elseif ($_SESSION['app_level'] == 3) { // AKADEMIK
                    $row[] = '<a href="javascript:void(0)" onclick="validasi(`'.sha1($field->id_nilai_transfer).'`)" class="btn btn-info btn-xs" title="Validasi Nilai"><i class="fa fa-check"></i></a>';
                } else {
                    $row[] = 'n/a';
                }
            } else {
                if ($_SESSION['app_level'] == 3) { // AKADEMIK
                   $row[] = '<span class="btn btn-secondary btn-xs" data-bs-toggle="tooltip" title="Validated: '.tanggal_indo($field->tgl_validasi).'" onclick="validasi(`'.sha1($field->id_nilai_transfer).'`)" ><i class="fa fa-check"></i></span>';
                } else {
                   $row[] = '<span class="btn btn-secondary btn-xs" data-bs-toggle="tooltip" title="Validated: '.tanggal_indo($field->tgl_validasi).'"><i class="fa fa-check"></i></span>';
                }
            }
            // }

            $data[] = $row;

            $nilai_cpl[] = [
                'id_nilai_transfer' => $field->id_nilai_transfer,
                'tgl_validasi' =>  ($field->tgl_validasi ?: 'belum')
            ];
        }

        if ( $this->Nilai_transfer_data_model->count_all() > 0) {
            $belum = $nilai_cpl ? (array_search('belum', array_column($nilai_cpl, 'tgl_validasi')) !== false ? '0' : '1') : null;
            $nilai_cpl = json_encode($nilai_cpl);
        } else {
            $nilai_cpl = null;
            $belum = null;
        }

        $this->Aktivitas_model->update(['nilai_cpl' => $nilai_cpl], ['sha1(id_aktivitas)' => $_GET['id_aktivitas']], null, $_ENV['DB_MBKM']);
        $this->Aktivitas_model->update(['status_nilai_cpl' => $belum], ['sha1(id_aktivitas)' => $_GET['id_aktivitas']], null, $_ENV['DB_MBKM']);

        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Nilai_transfer_data_model->count_all(),
            "recordsFiltered" => $this->Nilai_transfer_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
    }

}

/* End of file Konversi.php */
/* Location: ./application/controllers/Konversi.php */