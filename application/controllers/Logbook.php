<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logbook extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		if(!isset($_SESSION['logged_in'])){redirect(base_url('logout'));}
		if($_SESSION['logged_in']==FALSE){ redirect (base_url('logout'));}
		
		$this->app_level = [3, 7, 4];
		$this->app_level_dosen = [2];

		$this->load->model('Aktivitas_model');
		$this->load->model('Mbkm_model');
	}

	function simpan()
	{
		date_default_timezone_set('Asia/Jakarta');

		$data = $this->input->post(null, true);
		$data['id_user'] = $_SESSION['id_user'];
		$data['nama_user'] = ucwords(strtolower($_SESSION['nama_pengguna']));
		$data['level_name'] = ucwords(strtolower($_SESSION['level_name']));

		if($_FILES)  {
			$upload_path = './dokumen/mbkm/';
	        if( !is_dir($upload_path) ) {
	            mkdir($upload_path, 0777, TRUE);
	        }

			$config['upload_path']          = $upload_path;
		    $config['allowed_types']        = 'pdf|jpg|png|gif';
		    $config['overwrite']			= true;
		    $config['max_size']             = $_ENV['MAX_UPLOADED_SIZE']; // 1MB

		    $this->load->library('upload', $config);

		    if ($this->upload->do_upload('file')) {
		    	$data['file'] = base_url($upload_path.$this->upload->data('file_name'));
		    } else {
		    	echo $this->upload->display_errors();
		    }

		    if ($this->upload->do_upload('file_gambar')) {
		    	$data['file_gambar'] = base_url($upload_path.$this->upload->data('file_name'));
		    } else {
		    	echo $this->upload->display_errors();
		    }
		}

		if ($data['id_logbook'] == '') {
			$insert = $this->Mbkm_model->insert($_ENV['DB_MBKM'].'logbook', $data);
		} else {
			$id_logbook = $data['id_logbook'];
			unset($data['id_logbook']);

			$update = $this->Mbkm_model->update($_ENV['DB_MBKM'].'logbook', [ 'sha1(id_logbook)' => $id_logbook ], $data);
		}
	}

	function hapus()
	{
		$data = [ 'sha1(id_logbook)' => $this->input->post('id_logbook'), 'id_user' => $_SESSION['id_user'] ];
		$logbook = $this->Mbkm_model->get($_ENV['DB_MBKM'].'logbook', $data)->row();
			
		if ($logbook->file) unlink('./dokumen/mbkm/'.$logbook->file); 

		$delete  = $this->Mbkm_model->delete($_ENV['DB_MBKM'].'logbook', $data);
		echo $delete ? 'Sukses: logbook berhasil dihapus.' : 'Error: logbook gagal dihapus;';
	}

	function detail($table, $id, $act = null)
	{
		if ($_SESSION['app_level'] == 1) {
			$where = [ 'sha1(id_'.$table.')' => $id, 'id_user' => $_SESSION['id_user'] ];
		} else {
			$where = [ 'sha1(id_'.$table.')' => $id ];
		}

		$data['detail'] = $this->Mbkm_model->get($_ENV['DB_MBKM'].'logbook', $where)->row();
		$data['tanggapan'] = $this->Mbkm_model->get($_ENV['DB_MBKM'].'tanggapan', [ 'sha1(id_parent)' => $id, 'jenis_tanggapan' => 1 ], 'created_at DESC')->result();
		
		if ($act == 'edit') {
			$data['detail']->id_logbook = sha1($data['detail']->id_logbook);
			echo json_encode($data['detail']); exit;
		}

		$this->load->view('mbkm/detail_logbook', $data);
	}

	function json()
    {
        $this->load->model('Logbook_data_model');
        $list = $this->Logbook_data_model->get_datatables();

        $status = ['Revisi', 'Disetujui'];
        $status_bg = ['bg-warning', 'bg-secondary'];

        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            
            $row[] = $no.'.';
            $row[] = tanggal_indo($field->tgl_kegiatan);
            $row[] = str_word_count($field->isi) >= 25 ? substr($field->isi, 0, 250).'...' : $field->isi;
            $row[] = $field->status == '' ? '<span class="badge bg-info">Diproses</span>' : '<span class="badge '.$status_bg[$field->status].'">'.$status[$field->status].'</span>';
            
            if ($_SESSION['app_level'] == 1) {
           		$row[] = $field->status == 1 
           					? '<a href="javascript:void(0)" onclick="detail_logbook(`'.sha1($field->id_logbook).'`)" class="btn btn-info btn-xs"><i class="fas fa-search"></i></a>' 
           					: '<a href="javascript:void(0)" onclick="edit_logbook(`'.sha1($field->id_logbook).'`)" class="btn btn-secondary btn-xs text-white"><i class="fas fa-edit"></i></a>
								<a href="javascript:void(0)" onclick="hapus_logbook(`'.sha1($field->id_logbook).'`)" class="btn btn-danger btn-xs"><i class="fas fa-times"></i></a>
								<a href="javascript:void(0)" onclick="detail_logbook(`'.sha1($field->id_logbook).'`)" class="btn btn-info btn-xs"><i class="fas fa-search"></i></a>';
            } else {
            	$row[] = '<a href="javascript:void(0)" onclick="detail_logbook(`'.sha1($field->id_logbook).'`)" class="btn btn-info btn-xs"><i class="fas fa-search"></i></a>';
            }

            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Logbook_data_model->count_all(),
            "recordsFiltered" => $this->Logbook_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
    }

	function ubah_status($id, $status)
	{
		$update  = $this->Mbkm_model->update($_ENV['DB_MBKM'].'logbook', ['sha1(id_logbook)' => $id], ['status' => $status]);
		echo $update ? 'Sukses: status logbook berhasil diubah.' : 'Error: status logbook gagal diubah';
	}
	
	function simpan_tanggapan()
	{
		$data = $this->input->post(null, true);

		$data['jenis_tanggapan'] = 1;
		$data['id_user'] = $_SESSION['username'];
		$data['nama_user'] = $_SESSION['nama_pengguna'];
		$data['level_name'] = $_SESSION['level_name'];

		$insert = $this->Mbkm_model->insert($_ENV['DB_MBKM'].'tanggapan', $data);
		echo $insert ? 'Sukses: tanggapan revisi berhasil disimpan.' : 'Error: tanggapan revisi gagal disimpan.';
	}

	function hapus_tanggapan()
	{
		$data = [ 'sha1(id_tanggapan)' => $this->input->post('id_tanggapan'), 'id_user' => $_SESSION['username'] ];
		$delete  = $this->Mbkm_model->delete($_ENV['DB_MBKM'].'tanggapan', $data);
		echo $delete ? 'Sukses: tanggapan revisi berhasil dihapus.' : 'Error: tanggapan revisi gagal dihapus;';
	}

}

/* End of file Logbook.php */
/* Location: ./application/controllers/Logbook.php */