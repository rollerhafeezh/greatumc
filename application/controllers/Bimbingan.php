<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bimbingan extends CI_Controller {
    
    protected $app_level;
    protected $exceptions;

	function __construct()
	{
		parent::__construct();
		
        if(!isset($_SESSION['logged_in'])){redirect(base_url('logout'));}
		if($_SESSION['logged_in']==FALSE){ redirect (base_url('logout'));}
        
        $this->app_level_dosen = [ 2, 3 ];
        $this->exceptions = [ 'sse', 'bimbingan' ];

        if( !in_array($_SESSION['app_level'], $this->app_level_dosen) && !in_array($this->router->fetch_method(), $this->exceptions) ) {
            redirect('logout','refresh');
        }

        $this->load->model('Aktivitas_model');
    }

    function acc_judul()
    {
        $data = $this->input->post(null, true);

        $update = $this->Aktivitas_model->update([ 'judul' => $data['judul'] ], ['id_aktivitas' => $data['id_aktivitas']]);
        if ($update) {
            $this->Aktivitas_model->add_log($_SESSION['username'], $data, null, 'acc_judul');

            $this->session->set_flashdata('msg', 'Judul berhasil di acc.');
            $this->session->set_flashdata('msg_clr', 'success');
        }

        redirect(base_url('bimbingan/dosen_pembimbing/'.$data['id_aktivitas']));
    }

    function tutup_seminar_sidang(int $id_penjadwalan, int $id_aktivitas)
    {
        $tutup_seminar_sidang = $this->Aktivitas_model->tutup_seminar_sidang(['status' => '1', 'selesai' => date('H:i:s') ], ['id_penjadwalan' => $id_penjadwalan]);

        if ($tutup_seminar_sidang) {
            $data = [
                'id_penjadwalan' => $id_penjadwalan,
                'id_aktivitas' => $id_aktivitas
            ];
            $this->Aktivitas_model->add_log($_SESSION['username'], $data, null, 'akhiri_seminar_sidang');
            
            $this->session->set_flashdata('msg', 'Seminar atau sidang skripsi berhasil ditutup. Silahkan generate berkas berita acara untuk melihat hasil kegiatan.');
            $this->session->set_flashdata('msg_clr', 'success');
        }

        redirect($_SERVER['HTTP_REFERER']);
    }

    function akt() {
    // function akt($id_mahasiswa_pt, $id_smt) {
        $this->load->model('Krs_model');

        $mahasiswa_studi_akhir = $this->Aktivitas_model->mahasiswa_studi_akhir(id_kat_mk)->result();
        print_r($mahasiswa_studi_akhir); exit;
        
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
    }

    function dosen_pembimbing(int $id_aktivitas)
    {
        $data['title'] = 'Dosen Pembimbing';
        $data['lead'] = 'Kelola data bimbingan bersama mahasiswa.';
    	$data['content'] = 'bimbingan/dosen_pembimbing';

        $data['jenis_bimbingan'] = 1;
        $data['aktivitas']  = $this->Aktivitas_model->aktivitas([ 'a.id_aktivitas' => $id_aktivitas, 'p.nidn' => $_SESSION['username'] ], null, $data['jenis_bimbingan'])->row();

        if ($data['aktivitas']) {
            $data['kegiatan'] = $this->Aktivitas_model->kegiatan([ 'id_jenis_aktivitas_mahasiswa' => $data['aktivitas']->id_jenis_aktivitas_mahasiswa ])->result();
            $data['anggota']    = $this->Aktivitas_model->anggota([ 'a.id_aktivitas' => $data['aktivitas']->id_aktivitas ])->row();
            $data['penjadwalan'] = $this->Aktivitas_model->penjadwalan([ 'id_aktivitas' => $data['anggota']->id_aktivitas ], 'p.id_kegiatan ASC, p.tanggal ASC')->result();

            $this->load->view('lyt/index',$data);
        } else {
            $data['title']  = 'Error 404'; $data['content'] = 'e404';  $this->load->view('lyt/index',$data);
        }
    }

    function dosen_penguji(int $id_aktivitas, int $id_kegiatan)
    {
        $data['title'] = 'Dosen Penguji';
        $data['lead'] = 'Kelola catatan revisi bersama mahasiswa.';
        $data['content'] = 'bimbingan/dosen_penguji';

        $data['jenis_bimbingan'] = 2;
        $data['aktivitas']  = $this->Aktivitas_model->aktivitas([ 'a.id_aktivitas' => $id_aktivitas, 'p.nidn' => $_SESSION['username'] ], null, $data['jenis_bimbingan'])->row();

        if ($data['aktivitas']) {
            $data['kegiatan'] = $this->Aktivitas_model->penguji([ 'id_aktivitas' => $data['aktivitas']->id_aktivitas, 'p.nidn' => $_SESSION['username'], 'p.id_kegiatan' => $id_kegiatan ])->result();
            $data['anggota']    = $this->Aktivitas_model->anggota([ 'a.id_aktivitas' => $data['aktivitas']->id_aktivitas ])->row();
            $data['penjadwalan'] = $this->Aktivitas_model->penjadwalan([ 'id_aktivitas' => $data['anggota']->id_aktivitas, 'p.id_kegiatan' => $id_kegiatan ], 'p.id_kegiatan ASC, p.tanggal ASC')->result();

            $this->load->view('lyt/index',$data);
        } else {
            $data['title']  = 'Error 404'; $data['content'] = 'e404';  $this->load->view('lyt/index',$data);
        }
    }

    function ketua_sidang(int $id_aktivitas, int $id_kegiatan)
    {
        $data['title'] = 'Ketua Sidang';
        $data['lead'] = 'Kelola pelaksanaan seminar dan sidang sebagai moderator.';
        $data['content'] = 'bimbingan/ketua_sidang';

        $data['jenis_bimbingan'] = 3;
        $data['aktivitas']  = $this->Aktivitas_model->aktivitas([ 'a.id_aktivitas' => $id_aktivitas, 'p.nidn' => $_SESSION['username'] ], null, $data['jenis_bimbingan'])->row();

        if ($data['aktivitas']) {
            $data['kegiatan'] = $this->Aktivitas_model->penguji([ 'id_aktivitas' => $data['aktivitas']->id_aktivitas, 'p.nidn' => $_SESSION['username'], 'p.id_kegiatan' => $id_kegiatan ])->result();
            $data['anggota']    = $this->Aktivitas_model->anggota([ 'a.id_aktivitas' => $data['aktivitas']->id_aktivitas ])->row();
            $data['penjadwalan'] = $this->Aktivitas_model->penjadwalan([ 'id_aktivitas' => $data['anggota']->id_aktivitas, 'p.id_kegiatan' => $id_kegiatan ], 'p.id_kegiatan ASC, p.tanggal ASC')->result();

            $this->load->view('lyt/index',$data);
        } else {
            $data['title']  = 'Error 404'; $data['content'] = 'e404';  $this->load->view('lyt/index',$data);
        }
    }

    function cetak(int $jenis_bimbingan) 
    {
        $data['anggota']    = $this->Aktivitas_model->anggota([ 'a.id_mahasiswa_pt' => $_SESSION['id_user'], 'as.id_jenis_aktivitas_mahasiswa' => $_SESSION['id_jenis_aktivitas_mahasiswa'] ])->row();
        $data['aktivitas']  = $this->Aktivitas_model->aktivitas([ 'a.id_aktivitas' => $data['anggota']->id_aktivitas, 'a.id_jenis_aktivitas_mahasiswa' => $_SESSION['id_jenis_aktivitas_mahasiswa'] ])->row();
        $data['pembimbing'] = $this->Aktivitas_model->pembimbing([ 'id_aktivitas' => $data['anggota']->id_aktivitas ])->result();

        $data['mahasiswa']  = $this->Aktivitas_model->mahasiswa([ 'm.id_mhs' => $data['anggota']->id_mhs ])->row();
        $data['bimbingan']  = $this->Aktivitas_model->bimbingan([ 'b.id_aktivitas' => $data['anggota']->id_aktivitas, 'b.jenis_bimbingan' => $jenis_bimbingan, 'b.level_name' => 'Dosen' ], 'b.created_at desc')->result();

        $arr_jenis_bimbingan = ['-', 'Dosen Pembimbing', 'Dosen Penguji', 'Ketua Sidang'];
        $data['title'] = 'Laporan Kemajuan '.$arr_jenis_bimbingan[$jenis_bimbingan].' - '.ucwords(strtolower($data['anggota']->nm_pd));

        $mpdf = new \Mpdf\Mpdf([ 'mode'=>'utf-8', 'format'=>'FOLIO' ]);
        $html = $this->load->view('cetak/laporan_kemajuan', $data, true);
        $stylesheet = file_get_contents(base_url('assets/css/cetak.css'));
        $mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->writeHTML(utf8_encode($html));

        $mpdf->output($data['title'].'.pdf', 'I');
    }

    function bimbingan(int $id_aktivitas, int $jenis_bimbingan)
    {
    	$data['app_level_dosen'] = $this->app_level_dosen;

        $data['aktivitas']  = $this->Aktivitas_model->aktivitas([ 'a.id_aktivitas' => $id_aktivitas, 'p.nidn' => $_SESSION['username'] ], null, $jenis_bimbingan)->row();
        if ($data['aktivitas']) {
            $data['bimbingan']  = $this->Aktivitas_model->bimbingan([ 'b.id_aktivitas' => $data['aktivitas']->id_aktivitas, 'b.id_parent' => '0', 'b.jenis_bimbingan' => $jenis_bimbingan, 'b.level_name' => 'Dosen' ], 'b.created_at desc')->result();
            $data['jenis_bimbingan'] = $jenis_bimbingan;

            $this->load->view('bimbingan/bimbingan', $data);
        }
    }

    function sse()
    {
        header("Content-Type: text/event-stream");
        header("Cache-Control: no-cache");
        header("Connection: keep-alive");

        $time = date('r');
        echo "data: The server time is: {$time}\n\n";
        ob_end_flush();
        flush();
    }

    function kirim()
    {
        $data = $this->input->post(null, true);
        $data['id_user'] = $_SESSION['username'];
        $data['nama_user'] = ucwords(strtolower($_SESSION['nama_pengguna']));
        $data['level_name'] = ucwords(strtolower($_SESSION['level_name']));
        $data['isi'] = nl2br($data['isi']);

        if($_FILES)  {
            if ($_FILES['file']['name'] != '') {
                
                $upload_path = './dokumen/bimbingan/';
                if( !is_dir($upload_path) ) {
                    mkdir($upload_path, 0777, TRUE);
                }

                $config['upload_path']          = $upload_path;
                $config['allowed_types']        = 'pdf|doc|docx|ppt|pptx|jpg|jpeg|png|xls|xlsx|csv';
                $config['overwrite']            = true;
                $config['max_size']             = $_ENV['MAX_UPLOADED_SIZE'];

                $this->load->library('upload', $config);
                if ($this->upload->do_upload('file')) {
                    $data['file'] = base_url('dokumen/bimbingan/'.$this->upload->data('file_name'));
                } else {
                    echo strip_tags($this->upload->display_errors()).' (max. uploaded size: '.($_ENV['MAX_UPLOADED_SIZE']/1000).' MB, allowed filetypes: '.$config['allowed_types'].')';
                    exit;
                }
            }
        }

        $bimbingan = $this->Aktivitas_model->simpan_bimbingan($data);
    }

    function hapus()
    {
        if ($this->input->post('file') != '') {
            $file = explode('/', $this->input->post('file', true));
            unlink('./dokumen/bimbingan/'.$file[5]);
        }

        $bimbingan = $this->Aktivitas_model->hapus_bimbingan([ 'id_bimbingan' => $this->input->post('id_bimbingan', true), 'id_user' => $_SESSION['username'] ]);
    }

    function nilai_huruf($id_kegiatan)
    {
        $data = $this->input->post(null, true);
        $nilai = $this->Aktivitas_model->nilai_huruf($data['nilai_angka'], $id_kegiatan);
        echo $nilai->nilai_huruf;
    }

    function simpan_sinkronisasi_nilai()
    {
        $this->load->model('Dhmd_model');

        if($_SESSION['app_level']==2){

        $data = $this->input->post();
        unset($data['id_aktivitas']);
        unset($data['id_mahasiswa_pt']);

        // $id_nilai = $this->input->post('id_nilai');
        $nilai = ['A' => 4, 'B' => 3, 'C' => 2, 'D' => 1, 'E' => 0, 'TL' => 0];
        $data['nilai_indeks'] = $nilai[$data['nilai_huruf']];

        foreach($data as $key=>$value)
        {
            if($key != 'id_nilai' OR $key != 'id_mahasiswa_pt') {
                $this->Dhmd_model->update_nilai($data['id_nilai'],$key,$value);
            }
        }
            $whythis='simpan_nilai';
            $whatdo='#id_mahasiswa_pt:'.$this->input->post('id_mahasiswa_pt').'#nilai_huruf:'.$this->input->post('nilai_huruf');
            $this->Main_model->akademik_log($whythis,$whatdo);
           
            $this->Aktivitas_model->add_log($_SESSION['username'], $this->input->post(), null, 'sinkronisasi_nilai');

            $this->session->set_flashdata('msg', '<i class="pli-yes me-1"></i> Sinkronisasi nilai berhasil, silahkan periksa KHS atau Transkrip Nilai Mahasiswa.');
            $this->session->set_flashdata('msg_clr', 'success');
        }else{
            $this->session->set_flashdata('msg', 'Sinkronisasi nilai gagal dilakukan, silahkan coba lagi nanti.');
            $this->session->set_flashdata('msg_clr', 'warning');
        }

        redirect($_SERVER['HTTP_REFERER']);
    }

    function sinkronisasi_nilai()
    {
        $this->load->model('Krs_model');

        $data = $this->input->post(null, true);

        $data['anggota'] = $this->Aktivitas_model->anggota([ 'id_anggota' => $data['id_anggota'] ])->row();
        $data['penjadwalan'] = $this->Aktivitas_model->penjadwalan([ 'p.id_penjadwalan' => $data['id_penjadwalan'] ], null, 'id_kat_mk')->row();
        $data['nilai_akhir'] = $this->Aktivitas_model->nilai_akhir([ 'id_penjadwalan' => $data['id_penjadwalan'] ]);
        $data['kelas_kuliah'] = $this->Krs_model->list_kelas_kuliah($data['anggota']->id_mahasiswa_pt, null, $data['penjadwalan']->id_kat_mk);
        // print_r($data); exit;

        $this->load->view('bimbingan/sinkronisasi_nilai', $data);
    }

    function nilai(int $jenis_nilai)
    {
        $data = $this->input->post(null, true);
        $data['jenis_nilai'] = $jenis_nilai;

        $this->load->view('bimbingan/nilai', $data);
    }

    function simpan_nilai()
    {
        $data = $this->input->post(null, true);

        foreach ($data['nilai'] as $key => $value) {
            $param = [
                'id_komponen_nilai' => $key,
                'id_penjadwalan'    => $data['id_penjadwalan'], 
                'id_anggota'        => $data['id_anggota'], 
                'jenis_nilai'       => $data['jenis_nilai'], 
                'nidn'              => $_SESSION['username']
            ];

            if ($value > 0) {
                $param['nilai'] = $value;
                $this->Aktivitas_model->simpan_nilai($param);
            } else {
                $this->Aktivitas_model->hapus_nilai($param);
            }
        }


        $nilai_akhir = [
                'id_penjadwalan'    => $data['id_penjadwalan'], 
                'id_anggota'        => $data['id_anggota'], 
                'jenis_nilai'       => $data['jenis_nilai'], 
                // 'ke'                => $data['ke'], 
                'nidn'              => $_SESSION['username'],
        ];

        if ($data['nilai_angka'] > 0) {
            $nilai_akhir['nilai_angka'] = $data['nilai_angka'];
            $nilai_akhir['nilai_huruf'] = $this->Aktivitas_model->nilai_huruf($data['nilai_angka'], $data['id_kegiatan'])->nilai_huruf ;

            $this->Aktivitas_model->simpan_nilai($nilai_akhir, 'nilai_akhir');
        } else {
            $this->Aktivitas_model->hapus_nilai($nilai_akhir, 'nilai_akhir');
        }

        $this->session->set_flashdata('msg', 'Nilai kegiatan berhasil diinput. Silahkan periksa form atur nilai atau berita acara untuk memastikan.');
        $this->session->set_flashdata('msg_clr', 'success');
        redirect($_SERVER['HTTP_REFERER']);
    }

}