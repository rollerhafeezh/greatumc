<?php
$hari_ini 	= date("N");
$tgl_ini	= date('Y-m-d'); 
$warna_keterangan='danger';
$kelas_keterangan='Kelas telah selesai dilaksanakan.';
$status_kelas = 'selesai';

if($pertemuan->tanggal == $tgl_ini)
{
	if($pertemuan->jam_selesai)
	{
		
	}else{
		$warna_keterangan='success';
		$kelas_keterangan='Kelas sedang dilaksanakan.';
		$status_kelas = 'berlangsung';
	}
}

if($pertemuan->tipe_kuliah == 'uas' || $pertemuan->tipe_kuliah == 'uts'){
	if($_SESSION['app_level']==1){
		redirect('ujian/jawab/'.$pertemuan->tipe_kuliah.'/'.$pertemuan->id_kelas_kuliah.'/'.$_SESSION['id_user']);
	}else{
		redirect('dhmd/absensi_ujian/'.$pertemuan->tipe_kuliah.'/'.$pertemuan->id_kelas_kuliah);
	}
}

?>
<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		
			<?php if($status_kelas == 'berlangsung') { ?>
			<div class="col-12 mb-3">
				<div class="card h-100">
					<div class="card-body d-flex flex-column text-center">
						<a class="text-decoration-none" href="https://zoom.us"><img height="48px" src="<?=base_url('assets/images/logo_zoom.jpg')?>"></a>
						<div class="m-2 d-grid gap-2" id="meet_loader">
							<!--<button class="btn btn-block btn-lg btn-info" id="start_meet" onclick="load_meet()"><i class="fas fa-video"></i> Mulai <?=$_ENV['MAIN_USER']?> Video Conference</button>
							<button style="display: none" class="btn btn-block btn-lg btn-danger" id="stop_meet" onclick="unload_meet()"><i class="fas fa-video-slash"></i> Stop Video Konferensi</button>
							
							<a class="btn btn-block btn-lg btn-info" href="<?=base_url('dhmd/load_meet/'.$pertemuan->id_bap_kuliah)?>" target="_blank"><i class="fas fa-video"></i> <?=$_ENV['MAIN_USER']?> Video Conference</a>
							-->
						</div>
						<div id="load_meet" class=""></div>
					</div>
				</div>
			</div>
			<?php } ?>
			
			<div class="col-12 mb-4">
				<div class="card h-100">
					<div class="bg-<?=$warna_keterangan?> card-header">
						<h4 class="card-title text-white"><?=$kelas_keterangan?></h4>
					</div>
					<div class="card-body d-flex flex-column">
						
						<div class="row text-dark">
							<div class="col-md-2"><strong>Hari, Tanggal</strong></div>
							<div class="col-md-4 mt-1"><?=nama_hari($pertemuan->hari)?>, <?=tanggal_indo($pertemuan->tanggal)?></div>
							<div class="col-md-2 mt-1"><strong>Gedung, Ruangan</strong></div>
							<div class="col-md-4 mt-1">G. <?=$pertemuan->nama_gedung?> R. <?=$pertemuan->nama_ruangan?></div>
						</div>
						<div class="row text-dark mt-1">
							<div class="col-md-2"><strong>Tipe Perkuliahan</strong></div>
							<div class="col-md-4 mt-1">
							<?php
								if($_SESSION['app_level']==2 && $status_kelas == 'berlangsung')
								{
									?>
<input type="hidden" id="get_tipe" value="<?=($pertemuan->tipe_kuliah)?:'-'?>">
<div class="form-check form-check-inline">
	<input id="radio1" class="form-check-input" type="radio" onchange="update_pertemuan_tipe(`tipe_kuliah`,`kuliah`)" <?=($pertemuan->tipe_kuliah=='kuliah')?'checked=""':''?> name="inlineRadioOptions" value="kuliah">
	<label for="radio1" class="form-check-label">Kuliah</label>
</div>

<div class="form-check form-check-inline">
	<input id="radio2" class="form-check-input" type="radio" onchange="update_pertemuan_tipe(`tipe_kuliah`,`responsi`)" <?=($pertemuan->tipe_kuliah=='responsi')?'checked=""':''?> name="inlineRadioOptions" value="responsi">
	<label for="radio2" class="form-check-label">Responsi</label>
</div>

									<?php
								}else{
									echo strtoupper($pertemuan->tipe_kuliah);
								}
							?>
							</div>
							<div class="col-md-2 mt-1"><strong>Oleh</strong></div>
							<div class="col-md-4 mt-1"><?=$pertemuan->nm_sdm?></div>
						</div>
						<div class="row text-dark mt-1">
							<div class="col-md-2"><strong>Jam Mulai</strong></div>
							<div class="col-md-4 mt-1"><?=$pertemuan->jam_mulai?></div>
							<div class="col-md-2 mt-1"><strong>Jam Selesai</strong></div>
							<div class="col-md-4 mt-1"><?=$pertemuan->jam_selesai?></div>
						</div>
						<div class="row text-dark mt-1">
							<div class="col-md-2"><strong>Ringkasan</strong></div>
							<div class="col-md-4 mt-1">
							<?php
								if($_SESSION['app_level']==2 && $status_kelas == 'berlangsung')
								{
							?>
							<textarea rows="3" class="form-control" onblur="update_pertemuan(`materi`)" id="materi"><?=$pertemuan->materi?></textarea>
							<button class="btn btn-primary mt-2" ><i class="psi-paper-plane"></i></button>		
							<?php
								}else{
									echo $pertemuan->materi;
								}
							?>
							</div>
							<div class="col-md-2 mt-1"><strong>Foto Pertemuan )* maks 2MB</strong></div>
							<div class="col-md-4 mt-1">
							
							<?php
								if($_SESSION['app_level']==2 && $status_kelas == 'berlangsung')
								{
							?>
								<input type="file" accept=".jpg,.jpeg,.png" name="foto_pertemuan" class="form-control" id="foto_pertemuan">
							<?php } ?>
								<input type="hidden" id="get_foto" value="<?=($pertemuan->foto)?:'-'?>">
								<img style="max-height: 250px;" id="foto_pertemuan_preview" src="<?=($pertemuan->foto)?:$_ENV['LOGO_100']?>" class="img-thumbnail mt-3">
							</div>
						</div>
						<?php
							if($_SESSION['app_level']==2 && $status_kelas == 'berlangsung')
							{
						?>
						<div class="mt-2 d-grid gap-2">
							<a id="akhiri_kelas" class="btn btn-primary mt-3" onclick="return confirm('Yakin?')" href="<?=base_url('dhmd/selesai_kelas/'.$pertemuan->id_kelas_kuliah.'/'.$pertemuan->id_bap_kuliah)?>">Selesai</a>
						</div>
						<?php } ?>
						
					</div>
				</div>
			</div>
			
			<div class="col-md-6 mb-4" id="load_peserta"></div>
			<div class="col-md-6 mb-4" id="load_aktifitas"></div>
		</div>
	</div>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<!--<script src="https://meet.jit.si/external_api.js"></script>
<script src='https://8x8.vc/vpaas-magic-cookie-2d8d209fdb634a74bb7795d595d92c3a/external_api.js' async></script>-->
<script type="text/javascript">
	function count_char()
	{
		var isi_komen = document.getElementById('isi_komen').value
		if(isi_komen.length > 5){
			document.getElementById("kirim_aktifitas").removeAttribute("disabled");
		}else{
			
			document.getElementById("kirim_aktifitas").setAttribute('disabled', '');
		}
	}

	function hapus_addt_file()
	{
		document.getElementById( 'file-upload-filename' ).style.display = 'none';
		document.getElementById('addt_file').value = "";
	}
	
	function showFileName() {
		var btn = '<span style="cursor:pointer" class="text-danger" onclick="hapus_addt_file()"><i class="psi-cross"></i></span>';
		var infoArea = document.getElementById( 'file-upload-filename' );
		var fileName = document.getElementById('addt_file').files[0];
		if(fileName.size > 15728640)
			infoArea.innerHTML = '<span class="text-danger">Maksimal 15 MB</span>';
		else
			infoArea.innerHTML = 'Dokumen : ' + fileName.name +' '+ btn;
	}
	function selectFile() {
		document.getElementById("addt_file").click();
	}
	
	function get_peserta()
	{
		fetch('<?= base_url('dhmd/list_peserta/'.$pertemuan->id_bap_kuliah) ?>', {
			method: 'post',
		}).then( response => {
			return response.text()
		}).then( text => {
			document.querySelector('#load_peserta').innerHTML=text
		}).catch( err => {
			console.warn(err)
		})
	}
	
	function get_aktifitas()
	{
		fetch('<?= base_url('dhmd/list_aktifitas/'.$pertemuan->id_bap_kuliah) ?>', {
			method: 'post',
		}).then( response => {
			return response.text()
		}).then( text => {
			document.querySelector('#load_aktifitas').innerHTML=text
		}).catch( err => {
			console.warn(err)
		})
	}
	
	window.addEventListener('load', event => {
		get_peserta()
		get_aktifitas()
	});
	
	function load_meet()
	{
		$('#load_meet').load("<?= base_url('dhmd/load_meet/'.$pertemuan->id_bap_kuliah) ?>");
		$('#start_meet').hide();
		$('#stop_meet').show();
	}
	function unload_meet()
	{
		$('#load_meet').load("<?= base_url('dhmd/bigbangboom/') ?>");
		//$('#start_meet').show();
		$('#meet_loader').hide();
	}
	function hapus_aktifitas(id_komen)
	{
		var x = confirm('Yakin?')
		if(x){
			let url = "<?=base_url('dhmd/hapus_aktifitas/')?>/"+id_komen;
			
			fetch(url)
				.then((response) => response.text())
				.then((text) => {
					if(text==1){
						get_aktifitas()
						Toastify({ text: "Berhasil",	style: { background: "<?=$_ENV['CLR_SUC']?>",	} }).showToast();
					}else{
						Toastify({ text: "Gagal!",	style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
					}
				});
		}
	}
	
	function kirim_aktifitas()
	{
		var data = new FormData()
		const addt_file = document.getElementById('addt_file').files[0] ;
		const isi_komen = document.getElementById('isi_komen').value ;
		
		data.append('id_bap_kuliah', '<?=$pertemuan->id_bap_kuliah?>');
		data.append('addt_file', addt_file);
		data.append('isi_komen', isi_komen);
		
		fetch('<?=base_url('dhmd/simpan_aktifitas/')?>', {
			method: 'POST',
			body: data
		})
		.then((response) => response.text())
		.then((text) => {
			//console.log(text)
			hapus_addt_file()
			get_aktifitas()
			if(text==1){
				Toastify({ text: "Tersimpan",	style: { background: "<?=$_ENV['CLR_SUC']?>",	} }).showToast();
			}else{
				Toastify({ text: "Gatot!",	style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
			}
		})
		.catch(error => {
			console.log(error)
		})  
	}
	
	function unggah_tugas()
	{
		var data = new FormData()
		const dokumen_tugas = document.getElementById('dokumen_tugas').files[0] ;
		if(dokumen_tugas.size > 15728640) return false;
		
		data.append('id_bap_kuliah', '<?=$pertemuan->id_bap_kuliah?>');
		data.append('dokumen_tugas', dokumen_tugas);
		
		fetch('<?=base_url('dhmd/unggah_tugas/')?>', {
			method: 'POST',
			body: data
		})
		.then((response) => response.text())
		.then((text) => {
			get_peserta()
			if(text==1){
				Toastify({ text: "Tersimpan",	style: { background: "<?=$_ENV['CLR_SUC']?>",	} }).showToast();
			}else{
				Toastify({ text: "Gatot!",	style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
			}
		})
		.catch(error => {
			console.log(error)
		})  
	}
</script>
<?php 
if($_SESSION['app_level']==2){ ?>
<script>
function update_nilai_pertemuan (id_bap_peserta_kuliah){
	var nilai = document.getElementById('nilai_'+id_bap_peserta_kuliah).value
	let url = "<?=base_url('dhmd/update_nilai_pertemuan/')?>/"+id_bap_peserta_kuliah+"/"+nilai;
	
	fetch(url)
		.then((response) => response.text())
		.then((text) => {
			get_peserta()
			if(text==1){
				Toastify({ text: "Berhasil",	style: { background: "<?=$_ENV['CLR_SUC']?>",	} }).showToast();
			}else{
				Toastify({ text: "Gagal!",	style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
			}
		});
}
</script>
<?php
}
	
if($_SESSION['app_level']==2 && $status_kelas == 'berlangsung'){
?>
<script>
function update_hadir(id_mahasiswa_pt)
{
	var status_hadir = document.getElementById('hadir_'+id_mahasiswa_pt).value
	let url = "<?=base_url('dhmd/update_kehadiran/'.$pertemuan->id_bap_kuliah)?>/"+id_mahasiswa_pt+"/"+status_hadir;
	
	fetch(url)
		.then((response) => response.text())
		.then((text) => {
			get_peserta()
			if(text==1){
				
				Toastify({ text: "Berhasil",	style: { background: "<?=$_ENV['CLR_SUC']?>",	} }).showToast();
			}else{
				Toastify({ text: "Gagal!",	style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
			}
		});
	
}

document.getElementById('foto_pertemuan').addEventListener('change', (e) => {  simpan_foto(e.target) });

document.getElementById("akhiri_kelas").addEventListener("click", function(event){
  
	var foto =  document.getElementById('get_foto').value
	var tipe =  document.getElementById('get_tipe').value
	var mate =  document.getElementById('materi').value
	
	if(foto == '-' || tipe == '-' || mate == ''){
		event.preventDefault();
		Toastify({ text: "Lengkapi Dokumentasi, Materi dan Tipe Perkuliahan",	style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
	}
  
});

function simpan_foto(e)
{
	var data = new FormData()
	const fileInput = document.getElementById('foto_pertemuan').files[0] ;
	if(fileInput.size > 2728640) return false;
	data.append('uploader', '<?=$_SESSION['username']?>');
	data.append('id_kelas_kuliah', '<?=$pertemuan->id_kelas_kuliah?>');
	data.append('id_bap_kuliah', '<?=$pertemuan->id_bap_kuliah?>');
	data.append('foto', fileInput);
	
	document.getElementById('loading').style.display = 'block';
	fetch('<?=base_url('dhmd/simpan_foto/')?>', {
		method: 'POST',
		body: data
	})
	.then((response) => response.text())
	.then((text) => {
		document.getElementById('foto_pertemuan').value = "";
		document.getElementById('loading').style.display = 'none';
		if(text==0){
			Toastify({ text: "Tidak Tersimpan",	style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
		}else{
			Toastify({ text: "Tersimpan",	style: { background: "<?=$_ENV['CLR_SUC']?>",	} }).showToast();
			document.getElementById('foto_pertemuan_preview').setAttribute('src', text);
			document.getElementById('get_foto').value=text;
		}
	})
	.catch(error => {
		console.log(error)
	})  
}

function update_pertemuan_tipe(kolom,isi)
{
    let url = "<?=base_url('dhmd/update_pertemuan/'.$pertemuan->id_bap_kuliah)?>/"+kolom;
    
    var formData = new FormData()
    formData.append('isi', isi)
    
    fetch(url, { method: 'POST', body: formData })
        .then((response) => response.text())
        .then((text) => {
            if(text==1){
				Toastify({ text: "Tersimpan",	style: { background: "<?=$_ENV['CLR_SUC']?>",	} }).showToast();
				document.getElementById('get_tipe').value=text;
			}else{
				Toastify({ text: "Tidak Tersimpan",	style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
			}
        });
}

function update_pertemuan(kolom)
{
    var isi = document.getElementById(kolom).value;
    let url = "<?=base_url('dhmd/update_pertemuan/'.$pertemuan->id_bap_kuliah)?>/"+kolom;
    
    var formData = new FormData()
    formData.append('isi', isi)
    
    fetch(url, { method: 'POST', body: formData })
        .then((response) => response.text())
        .then((text) => {
            if(text==1)
				Toastify({ text: "Tersimpan",	style: { background: "<?=$_ENV['CLR_SUC']?>",	} }).showToast();
			else
				Toastify({ text: "Tidak Tersimpan",	style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
			
        });
}

</script>
<?php } ?>