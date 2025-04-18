<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

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

		if ($data['id_laporan'] == '') {
			$insert = $this->Mbkm_model->insert($_ENV['DB_MBKM'].'laporan', $data);
		} else {
			$id_laporan = $data['id_laporan'];
			unset($data['id_laporan']);

			$update = $this->Mbkm_model->update($_ENV['DB_MBKM'].'laporan', [ 'sha1(id_laporan)' => $id_laporan ], $data);
		}
	}

	function hapus()
	{
		$data = [ 'sha1(id_laporan)' => $this->input->post('id_laporan'), 'id_user' => $_SESSION['id_user'] ];
		$laporan = $this->Mbkm_model->get($_ENV['DB_MBKM'].'laporan', $data)->row();
			
		if ($laporan->file) unlink('./dokumen/mbkm/'.$laporan->file); 

		$delete  = $this->Mbkm_model->delete($_ENV['DB_MBKM'].'laporan', $data);
		echo $delete ? 'Sukses: laporan berhasil dihapus.' : 'Error: laporan gagal dihapus;';
	}

	public function detail($table, $id, $act = null)
	{
		if ($_SESSION['app_level'] == 1) {
			$where = [ 'sha1(id_'.$table.')' => $id, 'id_user' => $_SESSION['id_user'] ];
		} else {
			$where = [ 'sha1(id_'.$table.')' => $id ];
		}

		$data['detail'] = $this->Mbkm_model->get($_ENV['DB_MBKM'].'laporan', $where)->row();
		$data['tanggapan'] = $this->Mbkm_model->get($_ENV['DB_MBKM'].'tanggapan', [ 'sha1(id_parent)' => $id, 'jenis_tanggapan' => 2 ], 'created_at DESC')->result();
		
		if ($act == 'edit') {
			$data['detail']->id_laporan = sha1($data['detail']->id_laporan);
			echo json_encode($data['detail']); exit;
		}

		$this->load->view('mbkm/detail_laporan', $data);
	}

	function json()
    {
        $this->load->model('Laporan_data_model');
        $list = $this->Laporan_data_model->get_datatables();

        $status = ['Revisi', 'Disetujui'];
        $status_bg = ['bg-warning', 'bg-secondary'];
        $jenis_laporan = ['Awal', 'Mingguan', 'Akhir'];

        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            
            $row[] = $no.'.';
            $row[] = 'Laporan '.$jenis_laporan[$field->jenis_laporan-1];
            $row[] = tanggal_indo($field->tgl_laporan);
            $row[] = $field->minggu_ke;
            $row[] = $field->status == '' ? '<span class="badge bg-info">Diproses</span>' : '<span class="badge '.$status_bg[$field->status].'">'.$status[$field->status].'</span>';
            
            if ($_SESSION['app_level'] == 1) {
           		$row[] = $field->status == 1 
           					? '<a href="javascript:void(0)" onclick="detail_laporan(`'.sha1($field->id_laporan).'`)" class="btn btn-info btn-xs"><i class="fas fa-search"></i></a>' 
           					: '<a href="javascript:void(0)" onclick="edit_laporan(`'.sha1($field->id_laporan).'`)" class="btn btn-secondary btn-xs text-white"><i class="fas fa-edit"></i></a>
								<a href="javascript:void(0)" onclick="hapus_laporan(`'.sha1($field->id_laporan).'`)" class="btn btn-danger btn-xs"><i class="fas fa-times"></i></a>
								<a href="javascript:void(0)" onclick="detail_laporan(`'.sha1($field->id_laporan).'`)" class="btn btn-info btn-xs"><i class="fas fa-search"></i></a>';
            } else {
            	$row[] = '<a href="javascript:void(0)" onclick="detail_laporan(`'.sha1($field->id_laporan).'`)" class="btn btn-info btn-xs"><i class="fas fa-search"></i></a>';
            }

            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Laporan_data_model->count_all(),
            "recordsFiltered" => $this->Laporan_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
    }

    function ubah_status($id, $status)
	{
		$update  = $this->Mbkm_model->update($_ENV['DB_MBKM'].'laporan', ['sha1(id_laporan)' => $id], ['status' => $status]);
		echo $update ? 'Sukses: status laporan berhasil diubah.' : 'Error: status laporan gagal diubah';
	}

	function simpan_tanggapan()
	{
		$data = $this->input->post(null, true);

		$data['jenis_tanggapan'] = 2;
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

/* End of file laporan.php */
/* Location: ./application/controllers/laporan.php */