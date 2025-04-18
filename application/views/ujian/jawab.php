<?php
$jam_sekarang = date('H:i:s');
$tanggal_sekarang = date("Y-m-d");
$jam_mulai_ujian = '00:00:00';
$jam_selesai_ujian = '00:00:00';
$tanggal_ujian = '0000-00-00';

if($jenis_ujian=='uts'){
	$jam_mulai_ujian = $kelas->jam_mulai_uts;
	$jam_selesai_ujian = $kelas->jam_selesai_uts;
	$tanggal_ujian = $kelas->tgl_uts;
}

if($jenis_ujian=='uas'){
	$jam_mulai_ujian = $kelas->jam_mulai_uas;
	$jam_selesai_ujian = $kelas->jam_selesai_uas;
	$tanggal_ujian = $kelas->tgl_uas;
}
?>
<div class="content__boxed">
	<div class="content__wrap">
		<?php if($status_bayar['hasil']=='1'){ ?>
		<div class="row">
		
			<?php if($tanggal_sekarang == $tanggal_ujian && ($jam_sekarang >= $jam_mulai_ujian && $jam_sekarang <= $jam_selesai_ujian)) { ?>
			<div class="col-12 mb-3">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
						<div class="m-1 d-grid gap-2" id="meet_loader">
							<button class="btn btn-block btn-lg btn-info" id="start_meet" onclick="load_meet()"><i class="fas fa-video"></i> Mulai Video Konferensi</button>
							<button style="display: none" class="btn btn-block btn-lg btn-danger" id="stop_meet" onclick="unload_meet()"><i class="fas fa-video-slash"></i> Stop Video Konferensi</button>
						</div>
						<div id="load_meet" class="mt-2"></div>
					</div>
				</div>
			</div>
			<?php } ?>
		
			<div class="col-md-6 mb-3">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
						<div class="card-title">
							<h5>Detail Kelas</h5>
						</div>

						<div class="row">
							<div class="col-md-4 mt-1"><strong>Semester</strong></div>
							<div class="col-md-8 mt-1"><?=nama_smt($kelas->id_smt)?></div>
							<div class="col-md-4 mt-1"><strong>Fakultas/ Prodi</strong></div>
							<div class="col-md-8 mt-1"><?=$kelas->nama_fak?> <?=$kelas->nama_prodi?></div>
							<div class="col-md-4 mt-1"><strong>Kelas</strong></div>
							<div class="col-md-8 mt-1"><?=$kelas->nm_mk?> <?=$kelas->nm_kls?></div>
							<div class="col-md-4 mt-1"><strong>Dosen Pengampu</strong></div>
							<div class="col-md-8 mt-1">
								<?php
									$pengampu=$this->Main_model->pengampu_kelas($kelas->id_kelas_kuliah)->result();
									if($pengampu)
									{
										
										foreach($pengampu as $keys=>$values)
										{
											echo'<strong>'.$values->nidn.'</strong> '.$values->nm_sdm.' ('.$values->sks_subst_tot.' SKS)<br>';
										}
										
									}else{ echo '-'; }
								?>
							</div>
							<?php if($jenis_ujian=='uts'){ ?>
							<div class="col-md-4 mt-1"><strong>Jadwal UTS</strong>
							</div>
							<div class="col-md-8 mt-1">
							<?php if($kelas->tgl_uts){ ?>
								<?=tanggal_indo($kelas->tgl_uts)?><br><?=$kelas->jam_mulai_uts?> sd <?=$kelas->jam_selesai_uts?><br>
								G. <?=$kelas->nama_gedung_uts?> R. <?=$kelas->nama_ruangan_uts?>
							<?php } ?>
							</div>
							<?php }
							if($jenis_ujian=='uas'){ ?>
							<div class="col-md-4 mt-1"><strong>Jadwal UAS</strong>
							</div>
							<div class="col-md-8 mt-1">
							<?php if($kelas->tgl_uas){ 	?>
								<?=tanggal_indo($kelas->tgl_uas)?><br><?=$kelas->jam_mulai_uas?> sd <?=$kelas->jam_selesai_uas?><br>
								G. <?=$kelas->nama_gedung_uas?> R. <?=$kelas->nama_ruangan_uas?>
							<?php } ?>
							</div>
							<?php } ?>
							<div class="col-md-4 mt-1"><strong>Hari Sekarang</strong></div>
							<div class="col-md-8 mt-1"><?=tanggal_indo($tanggal_sekarang)?></div>
							<div class="col-md-4 mt-1"><strong>Jam Sekarang</strong></div>
							<div class="col-md-8 mt-1"><h3><div id="jam_sekarang"><?=$jam_sekarang?></div></h3></div>
						</div>
					</div>
				</div>
			</div>
		
			<div class="col-md-6 mb-3">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
						<div class="card-title">
							<h4>Detail Mahasiswa</h4>
						</div>

		<div class="row">
			<div class="col-md-4 mt-1"><strong>NIM</strong></div>
			<div class="col-md-8 mt-1"><?=$mahasiswa_pt->id_mahasiswa_pt?></div>
			<div class="col-md-4 mt-1"><strong>Nama Mahasiswa</strong></div>
			<div class="col-md-8 mt-1"><h4><?=$mahasiswa_pt->nm_pd?></h4></div>
			<div class="col-md-4 mt-1"><strong>Nomor Handphone</strong></div>
			<div class="col-md-8 mt-1"><?=$mahasiswa_pt->no_hp?></div>
			<div class="col-md-4 mt-1"><strong>Email</strong></div>
			<div class="col-md-8 mt-1"><?=$mahasiswa_pt->email?></div>
		</div>
	
					</div>
				</div>
			</div>
			
			<div class="col-md-6 mb-3" id="#ujian">
				<div class="card">
					<div class="card-body d-flex flex-column">
						<div class="card-title">
							<h4>Soal dan Jawaban Mahasiswa</h4>
						</div>
<?php 
$tampil_soal ='<div>
  <button onclick="tampil_soal()" id="btn-canvas" class="btn btn-sm btn-danger"><i class="psi-eye"></i></button>
  <button id="prev" class="btn btn-sm btn-info">&lt;</button>
  <button id="next" class="btn btn-sm btn-success">&gt;</button>
  &nbsp; &nbsp;
  <span>Hal: <span id="page_num"></span> / <span id="page_count"></span></span>
</div>

<canvas style="display:none" id="the-canvas"></canvas>';
	if($_SESSION['app_level']==1 && $tanggal_sekarang == $tanggal_ujian && ($jam_sekarang >= $jam_mulai_ujian && $jam_sekarang <= $jam_selesai_ujian)){
		$this->Ujian_model->simpan_log($kelas->id_kelas_kuliah,strtoupper($jenis_ujian),$mahasiswa_pt->id_mahasiswa_pt,1);
		echo $tampil_soal;
	}else if($_SESSION['app_level']!=1){
		echo $tampil_soal;
	}else{
		echo '';
	}
	if($_SESSION['app_level']==1 && $tanggal_sekarang == $tanggal_ujian && ($jam_sekarang >= $jam_mulai_ujian && $jam_sekarang <= $jam_selesai_ujian)){
?>
<!-- script src="https://cdn.tiny.cloud/1/euelv3wjksq6s3ph6qk546lit81gvn8cdaosi9ep1ftlkp1v/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script -->
<script src="https://cdn.tiny.cloud/1/e5iaag7fo0dkw0wumh0fi3mon1pgdhxsq5lpz8c12qnewv1s/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
	selector: 'textarea#text_jawaban',
	plugins: 'importcss image media advlist lists wordcount paste table fullscreen',
	menubar: false,
	toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify |  numlist bullist | table | image | removeformat | fullscreen',
	toolbar_mode: 'wrap',
	content_css: [
		'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
		'//www.tiny.cloud/css/codepen.min.css'
	],
	importcss_append: true,
	init_instance_callback: function (editor){
		editor.on('blur', function(e){
			//simpan_jawaban()
		});
	},

	images_upload_handler: function (blobInfo, success, failure) {
		var xhr, formData;
		xhr = new XMLHttpRequest();
		xhr.withCredentials = false;
		xhr.open('POST', '<?=base_url('ujian/unggah_gambar')?>');
		xhr.onload = function() {
		if (xhr.status != 200) {
			failure('HTTP Error: ' + xhr.status);
			return;
		}
		var res = JSON.parse( xhr.responseText );
			if (res.status == 'error') {
			failure( res.message );
			return;
		}
		success( res.location );
		};
		formData = new FormData();
		formData.append('file', blobInfo.blob(), blobInfo.filename());
		formData.append('id_kelas_kuliah', '<?=$kelas->id_kelas_kuliah?>');
		formData.append('jenis_ujian', '<?=strtoupper($jenis_ujian)?>');
		xhr.send(formData);
	},
	height: 400,
	paste_as_text: true,
	relative_urls : false,
	remove_script_host : false,
 });
</script>
<div class="row mt-3">
	<div class="col-md-12">
		<textarea id="text_jawaban" class="form-control" rows="20" placeholder="Tulis Jawaban Kamu Disini"><?=$jawaban->text_jawaban?></textarea>
		<div id="status" style="display:none;"></div>
	</div>
</div>
<div class="row">
	<div class="col-md-12 mt-2">
		<button onclick="simpan_jawaban()" class="btn my-1 btn-block btn-primary"><i class="fas fa-save"></i> SIMPAN JAWABAN</button>
		
	<input type="file" id="file_jawaban" style="display:none" onchange="simpan_file_jawaban()">
	<button class="btn btn-icon bg-transparent" onclick="selectFile()">
		<i class="psi-paperclip fs-5"></i>
	</button>

<p class="mt-2" id="file-upload-filename"><?=($jawaban->file_jawaban)?'<a href="'.$jawaban->file_jawaban.'">Lihat</a>':'file maksimal 15MB'?></p>
		<em>file jawaban tidak dapat dihapus/ hanya dapat ditimpa</em>
	</div>
</div>
<script>
var idwaktu = document.getElementById('jam_sekarang');

function livetime() {
	var d = new Date();
	var s = d.getSeconds();
	var m = d.getMinutes();
	var h = d.getHours();
	m = checkTime(m);
	s = checkTime(s);
	h = checkTime(h);
	var jam_simpan 	= h + ":" + m + ":" + s;
	var jam_selesai = '<?=$jam_selesai_ujian?>';
	idwaktu.textContent = jam_simpan;
	if(jam_selesai < jam_simpan){
		simpan_jawaban();
		location.reload();
	}
}
setInterval(livetime, 1000);


function simpan_jawaban()
{
	var text_jawaban = tinyMCE.get('text_jawaban').getContent();
	var data = new FormData()
	
	data.append('id_kelas_kuliah', '<?=$kelas->id_kelas_kuliah?>');
	data.append('jenis_ujian', '<?=strtoupper($jenis_ujian)?>');
	data.append('text_jawaban', text_jawaban);
	
	fetch('<?=base_url('ujian/simpan_jawaban/')?>', {
		method: 'POST',
		body: data
	})
	.then((response) => response.text())
	.then((text) => {
		if(text==0){
			Toastify({ text: "Tidak Tersimpan",	style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
		}else{
			Toastify({ text: "Tersimpan",	style: { background: "<?=$_ENV['CLR_SUC']?>",	} }).showToast();
		}
	})
	.catch(error => {
		console.log(error)
	})  
}

function hapus_addt_file()
{
	document.getElementById( 'file-upload-filename' ).style.display = 'none';
	document.getElementById('file_jawaban').value = "";
}

function showFileName() {
	var btn = '<span style="cursor:pointer" class="text-danger" onclick="hapus_addt_file()"><i class="psi-cross"></i></span>';
	var infoArea = document.getElementById( 'file-upload-filename' );
	var fileName = document.getElementById('file_jawaban').files[0];
	if(fileName.size > 15728640)
		infoArea.innerHTML = '<span class="text-danger">Maksimal 15 MB</span>';
	else
		infoArea.innerHTML = 'Dokumen : ' + fileName.name +' '+ btn;
}
function selectFile() {
	document.getElementById("file_jawaban").click();
}

function simpan_file_jawaban()
{
	var data = new FormData()
	const fileInput = document.getElementById('file_jawaban').files[0] ;
	var infoArea = document.getElementById( 'file-upload-filename' );
	data.append('id_kelas_kuliah', '<?=$kelas->id_kelas_kuliah?>');
	data.append('jenis_ujian', '<?=strtoupper($jenis_ujian)?>');56
	data.append('file_jawaban', fileInput);
	
	document.getElementById('loading').style.display = 'block';
	fetch('<?=base_url('ujian/simpan_file_jawaban/')?>', {
		method: 'POST',
		body: data
	})
	.then((response) => response.text())
	.then((texts) => {
		document.getElementById('loading').style.display = 'none';
		if(texts==0){
			Toastify({ text: "Tidak Tersimpan",	style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
		}else{
			infoArea.innerHTML = 'Dokumen : ' + texts;
			Toastify({ text: "Tersimpan",	style: { background: "<?=$_ENV['CLR_SUC']?>",	} }).showToast();
		}
	})
	.catch(error => {
		console.log(error)
	})  
}


function checkTime(i) {
  if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
  return i;
}
</script>
<?php 
	}else{ ?>
		<hr>
		<?=($jawaban->text_jawaban)?:''?>
		<?=($jawaban->file_jawaban)?'<a href="'.$jawaban->file_jawaban.'" target="_blank">Lihat Dokumen</a>':''?>
	<?php
	}
	
	$nilai_ujian = $this->Ujian_model->get_nilai_ujian($kelas->id_kelas_kuliah,strtoupper($jenis_ujian),$mahasiswa_pt->id_mahasiswa_pt)->row();
if($_SESSION['app_level']==1){ ?>
<a href="<?=base_url('cetak/jawaban/'.$jenis_ujian.'/'.$kelas->id_kelas_kuliah.'/'.$mahasiswa_pt->id_mahasiswa_pt)?>" target="_blank" class="text-decoration-none mt-3"><i class="psi-file-download"></i> Unduh Template Jawaban</a>
<?php } 
?>


					</div>
				</div>
			</div>
			
			<div class="col-md-6 mb-3">
				<div class="card">
					<div class="card-body d-flex flex-column">
						<div class="card-title">
							<h4>Komentar dan Nilai</h4>
						</div>
<?php if($_SESSION['app_level']==2){ ?>
<div class="d-flex align-items-center gap-1 pt-3">
	<textarea class="form-control" onfocus="this.select()" id="komentar_dosen" placeholder="Berikanlah Komentar" rows="3" style="resize:none"><?=$jawaban->komentar_dosen?></textarea>
	<button onclick="simpan_komentar()" class="btn btn-icon btn-primary">
		<i class="psi-paper-plane fs-5"></i>
	</button>
</div>
<div class="d-flex align-items-center gap-1 pt-3">
<input type="number" min="0" onfocus="this.select()" max="100" id="nilai" name="nilai" value="<?=($nilai_ujian->nilai_ujian)?:'0'?>" required="" class="form-control mt-1">
<button onclick="update_nilai(`<?=($nilai_ujian->id_nilai)?>`)" class="btn btn-primary btn-sm btn-icon"><i class="psi-save  fs-5"></i></button>
</div>	
<?php }else{ ?>
<p><?=($jawaban->komentar_dosen)?:''?></p>
<h2>Nilai : <?=($nilai_ujian->nilai_ujian)?:'0'?></h2>
<?php } ?>
<h4 class="mt-3" style="cursor:pointer" onclick="tampil_log()">Log Ujian</h4>
<div class="table-responsive" id="log_ujian" style="display:none">
	<table class="table table-sm">
		<thead>
			<th>Waktu</th>
			<th>Proses</th>
		</thead>
		<tbody>
			<?php
			$jenis_log = array(1=>'Buka Ujian','Simpan Jawaban','Unggah Dokumen','Simpan Nilai','Komentar','Unggah Gambar');
			$lihat_log = $this->Ujian_model->get_log($kelas->id_kelas_kuliah,strtoupper($jenis_ujian),$mahasiswa_pt->id_mahasiswa_pt)->result();
			foreach($lihat_log as $key_logs=>$value_log){
				echo'<tr>
						<td>'.$value_log->update_time.'</td>
						<td>'.$jenis_log[$value_log->jenis_log].'</td>
					</tr>
					';
			}
			?>
		</tbody>
	</table>
</div>			
					</div>
				</div>
			</div>
			
		</div>
		<?php }else{ echo '<div class="card p-3 text-danger">'.$status_bayar['message'].'</div>'; } ?>
	</div>
</div>
<script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://meet.jit.si/external_api.js"></script>
<script>
function load_meet()
{
	$('#load_meet').load("<?= base_url('dhmd/load_meet/'.(isset($pertemuan->id_bap_kuliah)?$pertemuan->id_bap_kuliah:1)) ?>");
	$('#start_meet').hide();
	$('#stop_meet').show();
}
function unload_meet()
{
	$('#load_meet').load("<?= base_url('dhmd/bigbangboom/') ?>");
	//$('#start_meet').show();
	$('#meet_loader').hide();
}

function tampil_soal()
{
	document.getElementById('the-canvas').style.display = 'block';
	document.getElementById('btn-canvas').style.display = 'none';
}

function tampil_log()
{
	document.getElementById('log_ujian').style.display = 'block';
}

<?php if($_SESSION['app_level']==2){ ?>

function update_nilai(id_nilai)
{
	var nilai = document.getElementById('nilai').value
	var data = new FormData()
	
	data.append('jenis_ujian', '<?=strtoupper($jenis_ujian)?>');
	data.append('nilai', nilai);
	data.append('id_nilai', id_nilai);
	data.append('id_mahasiswa_pt', '<?=$mahasiswa_pt->id_mahasiswa_pt?>');
	data.append('id_kelas_kuliah', '<?=$kelas->id_kelas_kuliah?>');
	
	fetch('<?=base_url('ujian/update_nilai/')?>', {
		method: 'POST',
		body: data
	})
	.then((response) => response.text())
	.then((text) => {
		if(text==0){
			Toastify({ text: "Tidak Tersimpan",	style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
		}else{
			Toastify({ text: "Tersimpan",	style: { background: "<?=$_ENV['CLR_SUC']?>",	} }).showToast();
		}
	})
	.catch(error => {
		console.log(error)
	})
}

function simpan_komentar()
{
	var komentar_dosen = document.getElementById('komentar_dosen').value
	var data = new FormData()
	
	data.append('id_mahasiswa_pt', '<?=$mahasiswa_pt->id_mahasiswa_pt?>');
	data.append('id_kelas_kuliah', '<?=$kelas->id_kelas_kuliah?>');
	data.append('jenis_ujian', '<?=strtoupper($jenis_ujian)?>');
	data.append('komentar_dosen', komentar_dosen);
	
	fetch('<?=base_url('ujian/simpan_komentar/')?>', {
		method: 'POST',
		body: data
	})
	.then((response) => response.text())
	.then((text) => {
		if(text==0){
			Toastify({ text: "Tidak Tersimpan",	style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
		}else{
			Toastify({ text: "Tersimpan",	style: { background: "<?=$_ENV['CLR_SUC']?>",	} }).showToast();
		}
	})
	.catch(error => {
		console.log(error)
	})  
}

<?php 
}
$soal = $this->Ujian_model->get_soal_ujian($kelas->id_kelas_kuliah,strtoupper($jenis_ujian),'1')->row();
$soal_ujian = ($soal)?$soal->dokumen_soal:base_url('dokumen/ujian/na.pdf');
$tampil_script ='
var url = "'.$soal_ujian.'";
var pdfjsLib = window["pdfjs-dist/build/pdf"];

pdfjsLib.GlobalWorkerOptions.workerSrc = "//mozilla.github.io/pdf.js/build/pdf.worker.js";

var pdfDoc = null,
    pageNum = 1,
    pageRendering = false,
    pageNumPending = null,
    scale = 1.5,
    canvas = document.getElementById("the-canvas"),
    ctx = canvas.getContext("2d");

function renderPage(num) {
  pageRendering = true;

  pdfDoc.getPage(num).then(function(page) {
    var viewport = page.getViewport({scale: scale});
    canvas.height = viewport.height;
    canvas.width = viewport.width;


    var renderContext = {
      canvasContext: ctx,
      viewport: viewport
    };
    var renderTask = page.render(renderContext);


    renderTask.promise.then(function() {
      pageRendering = false;
      if (pageNumPending !== null) {

        renderPage(pageNumPending);
        pageNumPending = null;
      }
    });
  });
 document.getElementById("page_num").textContent = num;
}

function queueRenderPage(num) {
  if (pageRendering) {
    pageNumPending = num;
  } else {
    renderPage(num);
  }
}

function onPrevPage() {
  if (pageNum <= 1) {
    return;
  }
  pageNum--;
  queueRenderPage(pageNum);
}
document.getElementById("prev").addEventListener("click", onPrevPage);

function onNextPage() {
  if (pageNum >= pdfDoc.numPages) {
    return;
  }
  pageNum++;
  queueRenderPage(pageNum);
}
document.getElementById("next").addEventListener("click", onNextPage);

pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
  pdfDoc = pdfDoc_;
  document.getElementById("page_count").textContent = pdfDoc.numPages;
  renderPage(pageNum);
});

';
	if($_SESSION['app_level']==1 && $tanggal_sekarang == $tanggal_ujian && ($jam_sekarang >= $jam_mulai_ujian && $jam_sekarang <= $jam_selesai_ujian)){
		echo $tampil_script;
	}else if($_SESSION['app_level']!=1){
		echo $tampil_script;
	}else{
		echo '';
	}
?>

</script>