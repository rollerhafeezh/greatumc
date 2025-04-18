<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \PhpOffice\PhpWord\PhpWord;
use \PhpOffice\PhpWord\TemplateProcessor;
use \PhpOffice\PhpWord\IOFactory;
use chillerlan\QRCode\{QRCode, QROptions};
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\Output\QROutputInterface;

class Cetak extends CI_Controller {
	
	function dumb($id_kelas_kuliah=null)
	{
		if($id_kelas_kuliah)
		{
		$this->load->model('Krs_model');
		$kelas = $this->Krs_model->kelas_kuliah_mahasiswa_krs(null,null,$id_kelas_kuliah)->row();
		if($kelas){
		
		
		$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(BASEPATH.'template/cetak_nilai.docx');
		$templateProcessor->setValue('nama_semester', $data[0]);
		$templateProcessor->setValue('nm_mk', $data[0]);
		$templateProcessor->setValue('nama_kelas', $data[0]);
		$templateProcessor->setValue('nama_fak', $data[0]);
		$templateProcessor->setValue('nama_prodi', $data[0]);
		$templateProcessor->setValue('kota', $data[0]);
		$templateProcessor->setValue('tanggal', $data[0]);
		$templateProcessor->cloneRowAndSetValues('no_urut', $nilai);
		$templateProcessor->cloneRowAndSetValues('nidn', $dosen);
		header("Content-Description: File Transfer");
		header('Content-Disposition: attachment; filename="cetak_nilai.docx"');
		header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
		header('Content-Transfer-Encoding: binary');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Expires: 0');
		$templateProcessor->saveAs('php://output');
		
		} 
		    
		}
	}
	
	function soal_ujian($id_kelas_kuliah=null,$jenis=null)
	{
		if($_SESSION['app_level']!=1){
	    if($id_kelas_kuliah && $jenis){
	    if($jenis == 'uts' || $jenis=='uas'){
        $this->load->model('Krs_model');
		$id_kelas_kuliah = xss_clean($id_kelas_kuliah);
		$kelas = $this->Krs_model->kelas_kuliah_mahasiswa_krs(null,null,$id_kelas_kuliah)->row();
		if($kelas){
		    $data['kelas'] 	= $kelas;
			$data['jenis'] 	= $jenis;
			//$this->load->view('cetak/sampul',$data);
			$nama_ujian = ($jenis=='uts')?'UJIAN TENGAH SEMESTER':'UJIAN AKHIR SEMESTER';
			$dosen = [];
			$pengampu=$this->Main_model->pengampu_kelas($kelas->id_kelas_kuliah)->result();
			if($pengampu)
			{
				foreach($pengampu as $keys=>$values)
				{
					$row=[];
					$row['nidn'] = $values->nidn;
					$row['nm_sdm'] = $values->nm_sdm;
					$dosen[]=$row;
				}
			}
			$tgl_ujian='';
			$jam_mulai='';
			$jam_selesai='';
			$nama_gedung='';
			$nama_ruangan='';
			if($jenis=='uts')
			{
			    if($kelas->tgl_uts)
			    {
			        	$tgl_ujian=tanggal_indo($kelas->tgl_uts);
            			$jam_mulai=$kelas->jam_mulai_uts;
            			$jam_selesai=$kelas->jam_selesai_uts;
            			$nama_gedung=$kelas->nama_gedung_uts;
            			$nama_ruangan=$kelas->nama_ruangan_uts;
			    }
			}
			if($jenis=='uas')
			{
			    if($kelas->tgl_uas)
			    {
			        	$tgl_ujian=tanggal_indo($kelas->tgl_uas);
            			$jam_mulai=$kelas->jam_mulai_uas;
            			$jam_selesai=$kelas->jam_selesai_uas;
            			$nama_gedung=$kelas->nama_gedung_uas;
            			$nama_ruangan=$kelas->nama_ruangan_uas;
			    }
			}
			$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(APPPATH.'views/template_soal.docx');
    		$templateProcessor->setValue('nama_ujian', $nama_ujian);
    		$templateProcessor->setValue('nama_smt', nama_smt($kelas->id_smt));
    		$templateProcessor->setValue('nm_mk', $kelas->nm_mk);
    		$templateProcessor->setValue('nm_kls', $kelas->nm_kls);
    		$templateProcessor->setValue('nama_fak', $kelas->nama_fak);
    		$templateProcessor->setValue('nama_prodi', $kelas->nama_prodi);
    		$templateProcessor->setValue('tgl_ujian', $tgl_ujian);
    		$templateProcessor->setValue('jam_mulai', $jam_mulai);
    		$templateProcessor->setValue('jam_selesai', $jam_selesai);
    		$templateProcessor->setValue('nama_gedung', $nama_gedung);
    		$templateProcessor->setValue('nama_ruangan', $nama_ruangan);
    		$templateProcessor->cloneRowAndSetValues('nidn', $dosen);
    		header("Content-Description: File Transfer");
    		header('Content-Disposition: attachment; filename="soal-'.$jenis.'-'.$id_kelas_kuliah.'.docx"');
    		header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    		header('Content-Transfer-Encoding: binary');
    		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    		header('Expires: 0');
    		$templateProcessor->saveAs('php://output');
			
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	    }else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	    }else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function jawaban($jenis=null,$id_kelas_kuliah=null,$id_mahasiswa_pt=null)
	{
		$id_mahasiswa_pt = xss_clean($id_mahasiswa_pt);
		$jenis = xss_clean($jenis);
		$id_kelas_kuliah = xss_clean($id_kelas_kuliah);
		if($_SESSION['app_level']==1) $id_mahasiswa_pt =  $_SESSION['id_user'];
	    if($id_kelas_kuliah && $jenis && $id_mahasiswa_pt){
	    if($jenis == 'uts' || $jenis=='uas'){
        $this->load->model('Krs_model');
		$id_kelas_kuliah = xss_clean($id_kelas_kuliah);
		$kelas = $this->Krs_model->kelas_kuliah_mahasiswa_krs(null,null,$id_kelas_kuliah)->row();
		if($kelas){
		    if($_SESSION['app_level']==1){ 
		        $this->load->model('Dhmd_model');
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
		    if($mahasiswa_pt){
		        
			$nama_ujian = ($jenis=='uts')?'UJIAN TENGAH SEMESTER':'UJIAN AKHIR SEMESTER';
			$dosen = [];
			$pengampu=$this->Main_model->pengampu_kelas($kelas->id_kelas_kuliah)->result();
			if($pengampu)
			{
				foreach($pengampu as $keys=>$values)
				{
					$row=[];
					$row['nidn'] = $values->nidn;
					$row['nm_sdm'] = $values->nm_sdm;
					$dosen[]=$row;
				}
			}
			$tgl_ujian='';
			$jam_mulai='';
			$jam_selesai='';
			$nama_gedung='';
			$nama_ruangan='';
			if($jenis=='uts')
			{
			    if($kelas->tgl_uts)
			    {
			        	$tgl_ujian=tanggal_indo($kelas->tgl_uts);
            			$jam_mulai=$kelas->jam_mulai_uts;
            			$jam_selesai=$kelas->jam_selesai_uts;
            			$nama_gedung=$kelas->nama_gedung_uts;
            			$nama_ruangan=$kelas->nama_ruangan_uts;
			    }
			}
			if($jenis=='uas')
			{
			    if($kelas->tgl_uas)
			    {
			        	$tgl_ujian=tanggal_indo($kelas->tgl_uas);
            			$jam_mulai=$kelas->jam_mulai_uas;
            			$jam_selesai=$kelas->jam_selesai_uas;
            			$nama_gedung=$kelas->nama_gedung_uas;
            			$nama_ruangan=$kelas->nama_ruangan_uas;
			    }
			}
			$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(APPPATH.'views/template_jawaban.docx');
    		$templateProcessor->setValue('nama_ujian', $nama_ujian);
    		$templateProcessor->setValue('nama_smt', nama_smt($kelas->id_smt));
    		$templateProcessor->setValue('id_mahasiswa_pt', $mahasiswa_pt[0]->id_mahasiswa_pt);
    		$templateProcessor->setValue('nm_pd', $mahasiswa_pt[0]->nm_pd);
    		$templateProcessor->setValue('email', $mahasiswa_pt[0]->email);
    		$templateProcessor->setValue('no_hp', $mahasiswa_pt[0]->no_hp);
    		$templateProcessor->setValue('nm_mk', $kelas->nm_mk);
    		$templateProcessor->setValue('nm_kls', $kelas->nm_kls);
    		$templateProcessor->setValue('nama_fak', $kelas->nama_fak);
    		$templateProcessor->setValue('nama_prodi', $kelas->nama_prodi);
    		$templateProcessor->setValue('tgl_ujian', $tgl_ujian);
    		$templateProcessor->setValue('jam_mulai', $jam_mulai);
    		$templateProcessor->setValue('jam_selesai', $jam_selesai);
    		$templateProcessor->setValue('nama_gedung', $nama_gedung);
    		$templateProcessor->setValue('nama_ruangan', $nama_ruangan);
    		$templateProcessor->cloneRowAndSetValues('nidn', $dosen);
    		header("Content-Description: File Transfer");
    		header('Content-Disposition: attachment; filename="jawaban-'.$jenis.'-'.$id_kelas_kuliah.'.docx"');
    		header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    		header('Content-Transfer-Encoding: binary');
    		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    		header('Expires: 0');
    		$templateProcessor->saveAs('php://output');
			
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	    }else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	    
	}
	
	function sampul($jenis=null,$id_kelas_kuliah=null)
	{
	    if($_SESSION['app_level']!=1){
	    if($id_kelas_kuliah && $jenis){
	    if($jenis == 'uts' || $jenis=='uas'){
        $this->load->model('Krs_model');
		$id_kelas_kuliah = xss_clean($id_kelas_kuliah);
		$kelas = $this->Krs_model->kelas_kuliah_mahasiswa_krs(null,null,$id_kelas_kuliah)->row();
		if($kelas){
		    $kode = $jenis.'/'.$id_kelas_kuliah;
		    $kode = str_replace('=','',base64_encode($kode));
		    $data['qrcode'] = (new QRCode)->render($kode);
			$data['kode'] 	= $kode;
			$data['kelas'] 	= $kelas;
			$data['jenis'] 	= $jenis;
			//$this->load->view('cetak/sampul',$data);
			
			$mpdf = new \Mpdf\Mpdf([ 'mode'=>'utf-8', 'format'=>'A5-L' ]);
			$cetak = $this->load->view('cetak/sampul', $data, true);
			
			$mpdf->SetHTMLHeader('
				<table width="100%" style="font-size:9pt;">
					<tr>
						<td width="50%" align="right">Sampul '.strtoupper($jenis).' | '.$kelas->nm_mk.' '.$kelas->nm_kls.' '.nama_smt($kelas->id_smt).'</i></td>
					</tr>
				</table>
			');

			$mpdf->SetHTMLFooter('
				<table width="100%" style="font-size:9pt;">
					<tr>
						<td width="50%" align="right"><i>Berkas ini dicetak otomatis oleh sistem pada tanggal {DATE d/m/Y h:i:s}</i></td>
					</tr>
				</table>
			');
			$mpdf->writeHTML($cetak);
			$mpdf->output($jenis.'-'.$id_kelas_kuliah.'.pdf', 'I');
			
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	    }else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	    }else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function ba($jenis=null,$id_kelas_kuliah=null)
	{
	    if($_SESSION['app_level']!=1){
	    if($id_kelas_kuliah && $jenis){
	    if($jenis == 'uts' || $jenis=='uas'){
        $this->load->model('Krs_model');
		$id_kelas_kuliah = xss_clean($id_kelas_kuliah);
		$kelas = $this->Krs_model->kelas_kuliah_mahasiswa_krs(null,null,$id_kelas_kuliah)->row();
		if($kelas){
		    $kode = $jenis.'/'.$id_kelas_kuliah;
		    $kode = str_replace('=','',base64_encode($kode));
		    $data['qrcode'] = (new QRCode)->render($kode);
			$data['kode'] 	= $kode;
			$data['kelas'] 	= $kelas;
			$data['jenis'] 	= $jenis;
			//$this->load->view('cetak/sampul',$data);
			
			$mpdf = new \Mpdf\Mpdf([ 'mode'=>'utf-8', 'format'=>'A4' ]);
			$cetak = $this->load->view('cetak/ba', $data, true);
			
			$mpdf->SetHTMLHeader('
				<table width="100%" style="font-size:9pt;">
					<tr>
						<td width="50%" align="right">Berita Acara '.strtoupper($jenis).' | '.$kelas->nm_mk.' '.$kelas->nm_kls.' '.nama_smt($kelas->id_smt).'</i></td>
					</tr>
				</table>
			');

			$mpdf->SetHTMLFooter('
				<table width="100%" style="font-size:9pt;">
					<tr>
						<td width="50%" align="right"><i>Berkas ini dicetak otomatis oleh sistem pada tanggal {DATE d/m/Y h:i:s}</i></td>
					</tr>
				</table>
			');
			$mpdf->writeHTML($cetak);
			$mpdf->output($jenis.'-'.$id_kelas_kuliah.'.pdf', 'I');
			
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	    }else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	    }else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function dafhad($jenis=null,$id_kelas_kuliah=null)
	{
	    if($_SESSION['app_level']!=1){
	    if($id_kelas_kuliah && $jenis){
	    if($jenis == 'uts' || $jenis=='uas'){
        $this->load->model(['Krs_model','Ujian_model']);
		$id_kelas_kuliah = xss_clean($id_kelas_kuliah);
		$kelas = $this->Krs_model->kelas_kuliah_mahasiswa_krs(null,null,$id_kelas_kuliah)->row();
		if($kelas){
		    $kode = $jenis.'/'.$id_kelas_kuliah;
		    $kode = str_replace('=','',base64_encode($kode));
		    $data['qrcode'] = (new QRCode)->render($kode);
			$data['kode'] 	= $kode;
			$data['kelas'] 	= $kelas;
			$data['jenis'] 	= $jenis;
			//$this->load->view('cetak/sampul',$data);
			
			$mpdf = new \Mpdf\Mpdf([ 'mode'=>'utf-8', 'format'=>'A4' ]);
			$cetak = $this->load->view('cetak/dafhad', $data, true);
			
			$mpdf->SetHTMLHeader('
				<table width="100%" style="font-size:9pt;">
					<tr>
						<td width="50%" align="right">Daftar Hadir '.strtoupper($jenis).' | '.$kelas->nm_mk.' '.$kelas->nm_kls.' '.nama_smt($kelas->id_smt).'</i></td>
					</tr>
				</table>
			');

			$mpdf->SetHTMLFooter('
				<table width="100%" style="font-size:9pt;">
					<tr>
						<td width="50%" align="right"><i>Berkas ini dicetak otomatis oleh sistem pada tanggal {DATE d/m/Y h:i:s}</i></td>
					</tr>
				</table>
			');
			$mpdf->writeHTML($cetak);
			$mpdf->output($jenis.'-'.$id_kelas_kuliah.'.pdf', 'I');
			
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	    }else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	    }else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function ujian($jenis=null,$id_kelas_kuliah=null)
	{
	    if($_SESSION['app_level']!=1){
	    if($id_kelas_kuliah && $jenis){
	    if($jenis == 'uts' || $jenis=='uas'){
        $this->load->model('Krs_model');
		$id_kelas_kuliah = xss_clean($id_kelas_kuliah);
		$kelas = $this->Krs_model->kelas_kuliah_mahasiswa_krs(null,null,$id_kelas_kuliah)->row();
		if($kelas){
		    $kode = $jenis.'/'.$id_kelas_kuliah;
		    $kode = str_replace('=','',base64_encode($kode));
		    $data['qrcode'] = (new QRCode)->render($kode);
			$data['kode'] 	= $kode;
			$data['kelas'] 	= $kelas;
			$data['jenis'] 	= $jenis;
			//$this->load->view('cetak/ujian',$data);
			
			$mpdf = new \Mpdf\Mpdf([ 'mode'=>'utf-8', 'format'=>'A4' ]);
			$cetak = $this->load->view('cetak/ujian', $data, true);
			
			$mpdf->SetHTMLHeader('
				<table width="100%" style="font-size:9pt;">
					<tr>
						<td width="50%" align="right">Nilai '.strtoupper($jenis).' | '.$kelas->nm_mk.' '.$kelas->nm_kls.' '.nama_smt($kelas->id_smt).'</i></td>
					</tr>
				</table>
			');

			$mpdf->SetHTMLFooter('
				<table width="100%" style="font-size:9pt;">
					<tr>
						<td width="50%" align="right"><i>Berkas ini dicetak otomatis oleh sistem pada tanggal {DATE d/m/Y h:i:s}</i></td>
					</tr>
				</table>
			');
			$mpdf->writeHTML($cetak);
			$mpdf->output($jenis.'-'.$id_kelas_kuliah.'.pdf', 'I');
			
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	    }else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	    }else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
    function nilai($id_kelas_kuliah=null)
	{
	    if($_SESSION['app_level']!=1){
	    if($id_kelas_kuliah){
	    
        $this->load->model(['Krs_model','Dhmd_model']);
		$id_kelas_kuliah = xss_clean($id_kelas_kuliah);
		$kelas = $this->Krs_model->kelas_kuliah_mahasiswa_krs(null,null,$id_kelas_kuliah)->row();
		if($kelas){
		    
		    $data['kelas'] 	= $kelas;
			
			//$this->load->view('cetak/nilai',$data);
			
			$mpdf = new \Mpdf\Mpdf([ 'mode'=>'utf-8', 'format'=>'A4-L' ]);
			$cetak = $this->load->view('cetak/nilai', $data, true);
			
			$mpdf->SetHTMLHeader('
				<table width="100%" style="font-size:9pt;">
					<tr>
						<td width="50%" align="right">Nilai | '.$kelas->nm_mk.' '.$kelas->nm_kls.' '.nama_smt($kelas->id_smt).'</i></td>
					</tr>
				</table>
			');

			$mpdf->SetHTMLFooter('
				<table width="100%" style="font-size:9pt;">
					<tr>
						<td width="50%" align="right"><i>Berkas ini dicetak otomatis oleh sistem pada tanggal {DATE d/m/Y h:i:s}</i></td>
					</tr>
				</table>
			');
			$mpdf->writeHTML($cetak);
			$mpdf->output('nilai-'.$id_kelas_kuliah.'.pdf', 'I');
			
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	    }else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	    }else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function absen($id_kelas_kuliah=null)
	{
	    if($_SESSION['app_level']!=1){
	    if($id_kelas_kuliah){
	    
        $this->load->model(['Krs_model','Dhmd_model']);
		$id_kelas_kuliah = xss_clean($id_kelas_kuliah);
		$kelas = $this->Krs_model->kelas_kuliah_mahasiswa_krs(null,null,$id_kelas_kuliah)->row();
		if($kelas){
		    
		    $data['kelas'] 	= $kelas;
			
			$this->load->view('cetak/absensi',$data);
			
			/*$mpdf = new \Mpdf\Mpdf([ 'mode'=>'utf-8', 'format'=>'A4-L' ]);
			$cetak = $this->load->view('cetak/absensi', $data, true);
			
			$mpdf->SetHTMLHeader('
				<table width="100%" style="font-size:9pt;">
					<tr>
						<td width="50%" align="right">Pertemuan dan Absensi | '.$kelas->nm_mk.' '.$kelas->nm_kls.' '.nama_smt($kelas->id_smt).' Hal-{PAGENO}</i></td>
					</tr>
				</table>
			');

			$mpdf->SetHTMLFooter('
				<table width="100%" style="font-size:9pt;">
					<tr>
						<td width="50%" align="right"><i>Berkas ini dicetak otomatis oleh sistem pada tanggal {DATE d/m/Y h:i:s}</i></td>
					</tr>
				</table>
			');
			$mpdf->writeHTML($cetak);
			$mpdf->output('absensi-'.$id_kelas_kuliah.'.pdf', 'I');*/
			
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	    }else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	    }else{ $data['title']	 = 'Error 401';	$data['content'] = 'e401';	$this->load->view('lyt/index',$data); }
	}
	
	function kartu($jenis=null,$id_smt=null,$id_mahasiswa_pt=null)
	{
		if($_SESSION['app_level']==1) $id_mahasiswa_pt =  $_SESSION['id_user'];
		$id_smt 	= ($id_smt)?:$_SESSION['active_smt'];
		
		$id_mahasiswa_pt = xss_clean($id_mahasiswa_pt);
		$jenis = xss_clean($jenis);
		$id_smt = xss_clean($id_smt);
		
		/*---if id mahasiswa ada----*/
		if($id_mahasiswa_pt && $id_smt && $jenis){
		if($jenis == 'uts' || $jenis=='uas'){
			$bearer = ['id_mahasiswa_pt'=>$id_mahasiswa_pt];
			$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
			
		/*---if mahasiswa ada----*/
		if($mahasiswa_pt){
			$this->load->model('Krs_model');
			$data['jenis']      = strtoupper($jenis);
			//$data['krs_note']	= $this->Krs_model->get_krs_note($id_mahasiswa_pt,$id_smt)->row();
			$data['list_kelas_krs']	= $this->Krs_model->list_kelas_ujian($id_mahasiswa_pt,$id_smt,$jenis)->result_array();
			$data['status_bayar'] = $this->Main_model->keuangan($jenis,$id_mahasiswa_pt,$id_smt);
			$data['id_smt']		= $id_smt;
			$data['mahasiswa_pt']= $mahasiswa_pt[0];
			//$this->load->view('cetak/kartu', $data);
			$mpdf = new \Mpdf\Mpdf([ 'mode'=>'utf-8', 'format'=>'A5-L' ]);
			$cetak = $this->load->view('cetak/kartu', $data, true);
			
			$mpdf->SetHTMLFooter('
				<table width="100%" style="font-size:9pt;">
					<tr>
						<td width="50%" align="right"><i>Berkas ini dicetak otomatis oleh sistem pada tanggal {DATE d/m/Y h:i:s}</i></td>
					</tr>
				</table>
			');
			$mpdf->writeHTML(utf8_encode($cetak));
			$mpdf->output($jenis.'-'.$id_smt.'-'.$id_mahasiswa_pt.'.pdf', 'I');
			
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	}
	
	function krs($id_smt=null,$id_mahasiswa_pt=null)
	{
		if($_SESSION['app_level']==1) $id_mahasiswa_pt =  $_SESSION['id_user'];
		$id_smt 	= ($id_smt)?:$_SESSION['active_smt'];
		
		/*---if id mahasiswa ada----*/
		if($id_mahasiswa_pt && $id_smt){
			$bearer = ['id_mahasiswa_pt'=>$id_mahasiswa_pt];
			$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
			
		/*---if mahasiswa ada----*/
		if($mahasiswa_pt){
			$this->load->model('Krs_model');
			$list_kelas_krs = $this->Krs_model->list_kelas_krs($id_mahasiswa_pt,$id_smt);
			//var_dump($list_kelas_krs->result()); exit();
		    $sks = 0;
		    if($list_kelas_krs->result())
			{
			    foreach($list_kelas_krs->result() as $key=>$value)
			    {
			        $sks +=$value->sks_mk;
			    }
			}
			$this->Krs_model->update_kuliah_mahasiswa_value($id_mahasiswa_pt,$id_smt,'sks_smt',$sks);
			$data['krs_note']	= $this->Krs_model->get_krs_note($id_mahasiswa_pt,$id_smt)->row();
			$data['list_kelas_krs']	= $list_kelas_krs;
			$data['status_bayar'] = $this->Main_model->keuangan('konfirmasi_krs',$id_mahasiswa_pt,$id_smt);
			$data['id_smt']		= $id_smt;
			$data['mahasiswa_pt']= $mahasiswa_pt[0];
			//$this->load->view('cetak/krs', $data);
			$mpdf = new \Mpdf\Mpdf([ 'mode'=>'utf-8', 'format'=>'A5-L' ]);
			$cetak = $this->load->view('cetak/krs', $data, true);
			
			$mpdf->SetHTMLHeader('
				<table width="100%" style="font-size:9pt;">
					<tr>
						<td width="50%" align="right">Kartu Rencana Studi | '.$id_mahasiswa_pt.' | '.nama_smt($id_smt).' Hal-<i>{PAGENO}</i></td>
					</tr>
				</table>
			');

			$mpdf->SetHTMLFooter('
				<table width="100%" style="font-size:9pt;">
					<tr>
						<td width="50%" align="right"><i>Berkas ini dicetak otomatis oleh sistem pada tanggal {DATE d/m/Y h:i:s}</i></td>
					</tr>
				</table>
			');
			$mpdf->writeHTML($cetak);
			$mpdf->output('KRS-'.$id_smt.'-'.$id_mahasiswa_pt.'.pdf', 'I');
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	}
	
	function ksm($id_smt=null,$id_mahasiswa_pt=null)
	{
		if($_SESSION['app_level']==1) $id_mahasiswa_pt =  $_SESSION['id_user'];
		$id_smt 	= ($id_smt)?:$_SESSION['active_smt'];
		
		/*---if id mahasiswa ada----*/
		if($id_mahasiswa_pt && $id_smt){
			$bearer = ['id_mahasiswa_pt'=>$id_mahasiswa_pt];
			$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
			
		/*---if mahasiswa ada----*/
		if($mahasiswa_pt){
			$this->load->model('Krs_model');
			$data['krs_note']	= $this->Krs_model->get_krs_note($id_mahasiswa_pt,$id_smt)->row();
			$data['list_kelas_krs']	= $this->Krs_model->list_kelas_krs($id_mahasiswa_pt,$id_smt)->result_array();
			$data['status_bayar'] = $this->Main_model->keuangan('konfirmasi_krs',$id_mahasiswa_pt,$id_smt);
			$data['id_smt']		= $id_smt;
			$data['mahasiswa_pt']= $mahasiswa_pt[0];
			//$this->load->view('cetak/ksm', $data);
			$mpdf = new \Mpdf\Mpdf([ 'mode'=>'utf-8', 'format'=>'A5-L' ]);
			$cetak = $this->load->view('cetak/ksm', $data, true);
		    $mpdf->SetHTMLHeader('
				<table width="100%" style="font-size:9pt;">
					<tr>
						<td width="50%" align="right">Kartu Studi Mahasiswa | '.$id_mahasiswa_pt.' | '.nama_smt($id_smt).' Hal-<i>{PAGENO}</i></td>
					</tr>
				</table>
			');
    
			$mpdf->SetHTMLFooter('
				<table width="100%" style="font-size:9pt;">
					<tr>
						<td width="50%" align="right"><i>Berkas ini dicetak otomatis oleh sistem pada tanggal {DATE d/m/Y h:i:s}</i></td>
					</tr>
				</table>
			');
			$mpdf->use_kwt = true;
			$mpdf->writeHTML($cetak);
			$mpdf->output('KSM-'.$id_smt.'-'.$id_mahasiswa_pt.'.pdf', 'I');
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	}
	
	function khs($id_smt=null,$id_mahasiswa_pt=null)
	{
		if($_SESSION['app_level']==1) $id_mahasiswa_pt =  $_SESSION['id_user'];
		$id_smt 	= ($id_smt)?:$_SESSION['active_smt'];
		
		/*---if id mahasiswa ada----*/
		if($id_mahasiswa_pt && $id_smt){
			$bearer = ['id_mahasiswa_pt'=>$id_mahasiswa_pt];
			$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
			
		/*---if mahasiswa ada----*/
		if($mahasiswa_pt){
			$this->load->model('Krs_model');
			$data['krs_note']	= $this->Krs_model->get_krs_note($id_mahasiswa_pt,$id_smt)->row();
			$data['list_kelas_krs']	= $this->Krs_model->list_kelas_kuliah($id_mahasiswa_pt,$id_smt)->result_array();
			$data['status_bayar'] = $this->Main_model->keuangan('uas',$id_mahasiswa_pt,$id_smt);
			$data['id_smt']		= $id_smt;
			$data['mahasiswa_pt']= $mahasiswa_pt[0];
			//$this->load->view('cetak/khs', $data);
			$mpdf = new \Mpdf\Mpdf([ 'mode'=>'utf-8', 'format'=>'A5-L' ]);
			$cetak = $this->load->view('cetak/khs', $data, true);
			$mpdf->SetHTMLHeader('
				<table width="100%" style="font-size:8pt;">
					<tr>
						<td width="50%" align="right">Kartu Hasil Studi | '.$id_mahasiswa_pt.' | '.nama_smt($id_smt).' Hal-<i>{PAGENO}</i></td>
					</tr>
				</table>
			');

			$mpdf->SetHTMLFooter('
				<table width="100%" style="font-size:6pt;">
					<tr>
						<td width="50%" align="right"><i>Berkas ini dicetak otomatis oleh sistem pada tanggal {DATE d/m/Y h:i:s}</i></td>
					</tr>
				</table>
			');
			$mpdf->writeHTML($cetak);
			$mpdf->output('KHS-'.$id_smt.'-'.$id_mahasiswa_pt.'.pdf', 'I');
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	}
	
	/* percobaan outputnya apa*/
	function innalillahi_wa_innailaihi_ro_jiun($jenis=null,$id_smt=null,$id_mahasiswa_pt=null)
	{
		$id_mahasiswa_pt = xss_clean($id_mahasiswa_pt);
		$jenis = xss_clean($jenis);
		$id_smt = xss_clean($id_smt);
		
		/*---if id mahasiswa ada----*/
		if($id_mahasiswa_pt && $id_smt && $jenis)
		{
			if($jenis == 'uts' || $jenis=='uas'){
				$bearer = ['id_mahasiswa_pt'=>$id_mahasiswa_pt];
				$mahasiswa_pt = $this->Main_model->post_api('mahasiswa/mahasiswa_pt',$bearer);
				
					/*---if mahasiswa ada----*/
					if($mahasiswa_pt)
					{
						$this->load->model('Krs_model');
						$data['jenis']      = strtoupper($jenis);
						//$data['krs_note']	= $this->Krs_model->get_krs_note($id_mahasiswa_pt,$id_smt)->row();
						$data['list_kelas_krs']	= $this->Krs_model->list_kelas_ujian($id_mahasiswa_pt,$id_smt,$jenis)->result_array();
						$data['status_bayar'] = $this->Main_model->keuangan($jenis,$id_mahasiswa_pt,$id_smt);
						//$data['status_bayar'] = $this->Main_model->keuangan('konfirmasi_krs',$id_mahasiswa_pt,$id_smt);
						$data['id_smt']		= $id_smt;
						$data['mahasiswa_pt']= $mahasiswa_pt[0];
						
						var_dump( $data['status_bayar']);
						echo '<br/>';
						//var_dump( $mahasiswa_pt);
					}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
			}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
		}else{ $data['title']	 = 'Error 404';	$data['content'] = 'e404';	$this->load->view('lyt/index',$data); }
	}
	
}