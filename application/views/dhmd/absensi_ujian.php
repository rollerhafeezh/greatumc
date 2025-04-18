<?php
$hari_ini 	= date("N");
$tgl_ini	= date('Y-m-d'); 
$warna_keterangan='danger';
$kelas_keterangan='Kelas telah selesai dilaksanakan.';
$status_kelas = 'selesai';
$tampilkan = 'disabled';

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
		<div class="row">
			<?php if($status_kelas == 'berlangsung') { ?>
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
							<?php if($kelas->tgl_uas){ ?>
								<?=tanggal_indo($kelas->tgl_uas)?><br><?=$kelas->jam_mulai_uas?> sd <?=$kelas->jam_selesai_uas?><br>
								G. <?=$kelas->nama_gedung_uas?> R. <?=$kelas->nama_ruangan_uas?>
							<?php } ?>
							</div>
							<?php } ?>
							<div class="col-md-4 mt-1"><strong>Jenis Ujian</strong></div>
							<div class="col-md-8 mt-1"><?=strtoupper($pertemuan->tipe_kuliah)?></div>
							<div class="col-md-4 mt-1"><strong>Dokumentasi</strong></div>
							<div class="col-md-8 mt-1">
							<?php
								if($_SESSION['app_level']==2 && $status_kelas == 'berlangsung')
								{
								$tampilkan = '';
							?>
								<input type="file" accept=".jpg,.jpeg,.png" name="foto_pertemuan" class="form-control" id="foto_pertemuan">
							<?php } ?>
								<input type="hidden" id="get_foto" value="<?=($pertemuan->foto)?:''?>">
								<img style="max-height: 250px;" id="foto_pertemuan_preview" src="<?=($pertemuan->foto)?:$_ENV['LOGO_100']?>" class="img-thumbnail mt-3">
							</div>
							<div class="col-md-4"><strong>Keadaan Ujian</strong></div>
							<div class="col-md-8 mt-1">
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
						</div>
						<?php
							if($_SESSION['app_level']==2 && $status_kelas == 'berlangsung')
							{
						?>
						<div class="mt-2 d-grid gap-2">
							<a id="akhiri_kelas" onclick="return confirm('Yakin?')" class="btn btn-primary mt-3" href="<?=base_url('dhmd/selesai_kelas/'.$pertemuan->id_kelas_kuliah.'/'.$pertemuan->id_bap_kuliah)?>">Selesai</a>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		
			<div class="col-md-6 mb-3">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
						<div class="card-title">
							<h4>Detail Peserta</h4>
						</div>
<div class="table-responsive">
	<table class="table table-sm">
		<thead>
			<th>NIM</th>
			<th>Nama</th>
			<th>Hadir</th>
		</thead>
		<tbody>
			<?php
			
			$peserta_uts = $this->Ujian_model->peserta_ujian_absen($kelas->id_kelas_kuliah,strtoupper($jenis_ujian),$pertemuan->id_bap_kuliah)->result();
			if($peserta_uts){
				foreach($peserta_uts as $key=>$value){
				    $get_status_cetak = $this->Ujian_model->get_status_cetak($_SESSION['active_smt'],strtoupper($jenis_ujian),$value->id_mahasiswa_pt)->row();
				    if($get_status_cetak){
				        $boleh = "";
				        $check_kartu = '<span class="text-success"><i class="psi-yes"></i></span>';
				    }else{
				        //$boleh = "";
				        $boleh = "disabled";
				        $check_kartu = '';
				    }
					echo'
					<tr>
						<td>'.$value->id_mahasiswa_pt.' '.$check_kartu.'</td>';
						if($value->status_ujian==0){
							echo '<td>'.$value->nm_pd.'</td>';
						}else{
							echo '<td><a class="text-decoration-none" href="'.base_url('ujian/jawab/'.$jenis_ujian.'/'.$value->id_kelas_kuliah.'/'.$value->id_mahasiswa_pt).'">'.$value->nm_pd.'</a></td>';
						}
						if($value->status_hadir==0){
							echo '<td><input '.$tampilkan.' '.$boleh.' type="checkbox" data-id_mahasiswa_pt="'.$value->id_mahasiswa_pt.'" class="ubah_absen"></td>';
						}else{
							echo '<td><input '.$tampilkan.' type="checkbox" checked="" data-id_mahasiswa_pt="'.$value->id_mahasiswa_pt.'" class="ubah_absen"></td>';
						}
					echo'</tr>';
				}
			}else{ echo '<tr><td colspan="3"><em>belum ada peserta!</em></td></tr>'; } 
			?>
			<!--<tr>
				
				<td><a href="base_url('ujian/periksa_jawaban_ujian')" class="text-decoration-none"> 20226688</a></td>
				<td>Nama Mahasiswa</td>
				<td>99</td>
			</tr>-->
		</tbody>
	</table>
</div>
							
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://meet.jit.si/external_api.js"></script>
<script>
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
<?php

if($_SESSION['app_level']==2 && $status_kelas == 'berlangsung'){
?>
let allCheckBox = document.querySelectorAll('.ubah_absen')

allCheckBox.forEach((checkbox) => { 
  checkbox.addEventListener('change', (event) => {
	var id_mhs = event.target.getAttribute("data-id_mahasiswa_pt")
    if (event.target.checked) {
		update_hadir(id_mhs,1)
    }else{
		update_hadir(id_mhs,0)
	}
  })
})
function update_hadir(id_mahasiswa_pt,status_hadir)
{
	let url = "<?=base_url('dhmd/update_kehadiran/'.$pertemuan->id_bap_kuliah)?>/"+id_mahasiswa_pt+"/"+status_hadir;
	
	fetch(url)
		.then((response) => response.text())
		.then((text) => {
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
	var mate =  document.getElementById('materi').value
	
	if(foto == '' || mate == ''){
		event.preventDefault();
		Toastify({ text: "Lengkapi Dokumentasi, Kondisi Ujian",	style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
	}
  
});

function simpan_foto(e)
{
	var data = new FormData()
	const fileInput = document.getElementById('foto_pertemuan').files[0] ;
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
/*
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
*/
function update_pertemuan(kolom)
{
    var isi = document.getElementById(kolom).value;
    let url = "<?=base_url('dhmd/update_pertemuan_ujian_materi/'.$pertemuan->id_bap_kuliah)?>/"+kolom;
    
    /*fetch(url)
        .then((response) => response.text())
        .then((text) => {
            if(text==1)
				Toastify({ text: "Tersimpan",	style: { background: "<?=$_ENV['CLR_SUC']?>",	} }).showToast();
			else
				Toastify({ text: "Tidak Tersimpan",	style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
			
        });
		*/
	var formData = new FormData()
    formData.append('isi', isi)
    
    fetch(url, { method: 'POST', body: formData })
        .then((response) => response.text())
        .then((text) => {
            if(text==1){
				Toastify({ text: "Tersimpan",	style: { background: "<?=$_ENV['CLR_SUC']?>",	} }).showToast();
				//document.getElementById('get_tipe').value=text;
			}else{
				Toastify({ text: "Tidak Tersimpan",	style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
			}
        });
}
<?php } ?>
</script>