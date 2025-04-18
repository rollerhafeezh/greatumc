<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		
		<div class="col-12 mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
<div class="row">
	<div class="col-md-3">
		<?=$matkul->nama_fak?>
	</div>
	<div class="col-md-3">
		<label for="kode_prodi" class="form-label"><strong>Program Studi</strong></label>
		<?=$matkul->nama_prodi?>
	</div>
	<div class="col-md-3">
		<label for="jns_mk" class="form-label"><strong>Jenis Mata Kuliah</strong></label>
		<?=$matkul->nama_jenis_mk?>
	</div>
	<div class="col-md-3">
		<label for="kode_mk" class="form-label"><strong>Kode Mata Kuliah</strong></label>
		<?=$matkul->kode_mk?>
    </div>
	<div class="col-6">
		<label for="nm_mk" class="form-label"><strong>Nama Mata Kuliah</strong></label>
		<?=$matkul->nm_mk?>
    </div>
	<div class="col-6">
		<label for="nm_mk_en" class="form-label"><strong>Nama Mata Kuliah <i>(en)</i></strong></label>
		<?=$matkul->nm_mk_en?>
	</div>
	<div class="col-md-3">
		<label for="sks_tm" class="form-label"><strong>SKS Tatap Muka</strong></label>
		<?=$matkul->sks_tm?>
	</div>
	<div class="col-md-3">
		<label for="sks_prak" class="form-label"><strong>SKS Praktek</strong></label>
		<?=$matkul->sks_prak?>
	</div>
	<div class="col-md-3">
		<label for="sks_prak_lap" class="form-label"><strong>SKS Praktek Lapangan</strong></label>
		<?=$matkul->sks_prak_lap?>
	</div>
	<div class="col-md-3">
		<label for="sks_sim" class="form-label"><strong>SKS Simulasi</strong></label>
		<?=$matkul->sks_sim?>
	</div>
	<div class="col-md-3">
		<label for="sks_mk" class="form-label"><strong>&Sigma; SKS</strong></label>
        <?=$matkul->sks_mk?>
	</div>
	<div class="col-12 text-center">
		<?php 
		$lempar = str_replace('=','',base64_encode($rps->id_matkul));
		if(($_SESSION['app_level']==2 or $_SESSION['app_level']==9) && $rps->status==0){ ?>
		<a href="<?=base_url('dhmd/aktifasi_rps/'.$rps->id_rps)?>" onclick="return confirm(`Yakin?`)" id="btn_hapus" class="btn btn-primary">Aktifasi RPS</a>
		<?php } ?>
		<a href="<?=base_url('beranda/rps/'.$lempar)?>" class="btn btn-info">Lihat RPS</a>
	</div>
<!--END-->	
</div>
					</div>
				</div>
			</div>
<!-- tiny001 mase -->
<!-- < script src="https://cdn.tiny.cloud/1/b1k2ullr8gqc9niksxycgywh2suxlbrrw72dg8ppjr8oiovx/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script> -->			
			
<!-- tiny002 mase -->
<script src="https://cdn.tiny.cloud/1/f9kj6z3hff8d4x8nz4zs511ndeb460esldltidjxxageihpx/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
	selector: 'textarea',
	plugins: 'importcss image media advlist lists wordcount paste table fullscreen save',
	menubar: false,
	toolbar: 'save | undo redo | bold italic underline | alignleft aligncenter alignright alignjustify |  numlist bullist | table | image | removeformat | fullscreen',
	toolbar_mode: 'wrap',
	content_css: [
		'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
		'//www.tiny.cloud/css/codepen.min.css'
	],
	importcss_append: true,
	
	setup: function (editor) {
      editor.on('blur', function (e) {
        console.log(e)
      });
    },
	images_upload_handler: function (blobInfo, success, failure) {
		var xhr, formData;
		xhr = new XMLHttpRequest();
		xhr.withCredentials = false;
		xhr.open('POST', '<?=base_url('dhmd/unggah_gambar')?>');
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
		formData.append('id_rps', '<?=$rps->id_rps?>');
		xhr.send(formData);
	},
	height: 200,
	paste_as_text: true,
	relative_urls : false,
	remove_script_host : false,
 });
 
</script>	
			<div class="col-12 mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
<form method="post" action="<?=base_url('dhmd/simpan_rps/'.$rps->id_rps)?>">
<div class="row">
	<div class="col-md-3 mt-1">
		<strong>Capaian Pembelajaran (CP)</strong>
	</div>
	<div class="col-md-9 mt-1">
		<div class="row">
			<div class="col-12">
				<p><strong>CP Program Studi :</strong></p>
				<?php if($_SESSION['app_level']==2) { ?>
				<textarea name="cp_prodi" class="form-control" rows="5"><?=$rps->cp_prodi?></textarea>
				<?php }else{ ?>
				<?=$rps->cp_prodi?>
				<?php } ?>
			</div>
			<div class="col-12 mt-1">
				<p><strong>CP Mata kuliah : </strong></p>
				<?php if($_SESSION['app_level']==2) { ?>
				<textarea name="cp_mk" class="form-control" rows="5"><?=$rps->cp_mk?></textarea>
				<?php }else{ ?>
				<?=$rps->cp_mk?>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-3 mt-1">
		<strong>Deskripsi Singkat</strong>
	</div>
	<div class="col-md-9 mt-1">
		<?php if($_SESSION['app_level']==2) { ?>
		<textarea name="deskripsi_singkat" class="form-control" rows="5"><?=$rps->deskripsi_singkat?></textarea>
		<?php }else{ ?>
		<?=$rps->deskripsi_singkat?>
		<?php } ?>
	</div>
</div>
<div class="row">
	<div class="col-md-3 mt-1">
		<strong>Pokok Bahasan / Bahan Kajian</strong>
	</div>
	<div class="col-md-9 mt-1">
		<?php if($_SESSION['app_level']==2) { ?>
		<textarea name="pokok_bahasan" class="form-control" rows="5"><?=$rps->pokok_bahasan?></textarea>
		<?php }else{ ?>
		<?=$rps->pokok_bahasan?>
		<?php } ?>
	</div>
</div>
<div class="row">
	<div class="col-md-3 mt-1">
		<strong>Pustaka</strong>
	</div>
	<div class="col-md-9 mt-1">
		<div class="row">
			<div class="col-12">
				<p><strong>Utama :</strong></p>
				<?php if($_SESSION['app_level']==2) { ?>
				<textarea name="pustaka_utama" class="form-control" rows="5"><?=$rps->pustaka_utama?></textarea>
				<?php }else{ ?>
				<?=$rps->pustaka_utama?>
				<?php } ?>
			</div>
			<div class="col-12 mt-1">
				<p><strong>Pendukung :</strong></p>
				<?php if($_SESSION['app_level']==2) { ?>
				<textarea name="pustaka_pendukung" class="form-control" rows="5"><?=$rps->pustaka_pendukung?></textarea>
				<?php }else{ ?>
				<?=$rps->pustaka_pendukung?>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-3 mt-1">
		<strong>Media Pembelajaran</strong>
	</div>
	<div class="col-md-9 mt-1">
		<div class="row">
			<div class="col-12">
				<p><strong>Perangkat Keras :</strong></p>
				<?php if($_SESSION['app_level']==2) { ?>
				<textarea name="media_perangkat_keras" class="form-control" rows="5"><?=$rps->media_perangkat_keras?></textarea>
				<?php }else{ ?>
				<?=$rps->media_perangkat_keras?>
				<?php } ?>
			</div>
			<div class="col-12 mt-1">
				<p><strong>Perangkat Lunak :</strong></p>
				<?php if($_SESSION['app_level']==2) { ?>
				<textarea name="media_perangkat_lunak" class="form-control" rows="5"><?=$rps->media_perangkat_lunak?></textarea>
				<?php }else{ ?>
				<?=$rps->media_perangkat_lunak?>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
</form>
					</div>
				</div>
			</div>
			
			<div class="col-12 mb-4" id="rps_pertemuan">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
						<div class="card-title">
							<h5>RPS Pertemuan</h5>
						</div>
<div class="table-responsive">
	<table class="table table-bordered">
	<thead>
		<tr>
			<th rowspan="2" width="1" class="text-center text-wrap">Minggu Ke-</th>
			<th rowspan="2" class="text-center text-wrap">SUB-CP MK</th>
			<th colspan="2" class="text-center text-wrap">Penilaian</th>
			<th colspan="2" class="text-center text-wrap">Bentuk Pembelajaran,<br>Metode Pembelajaran, dan<br>Penugasan Mahasiswa</th>
			<th rowspan="2" class="text-center text-wrap">Materi Pembelajaran [Pustaka]</th>
			<th rowspan="2" class="text-center text-wrap">Bobot Penilaian</th>
			<th rowspan="2" class="text-center text-wrap">Aksi</th>
		</tr>
		<tr>
			<th class="text-center text-wrap">Indikator</th>
			<th class="text-center text-wrap">Bentuk dan Kriteria</th>
			<th class="text-center text-wrap">Luring</th>
			<th class="text-center text-wrap">Daring</th>
		</tr>
	</thead>
	
	<?php
	for($i=1;$i<=16;$i++)
	{
		$rps_pertemuan = $this->Main_model->get_rps_pertemuan($rps->id_matkul,$rps->id_rps,null,$i)->row();
		if($rps_pertemuan)
		{
			echo '<tr> 
					<td>'.$i.'</td>
					<td>'.$rps_pertemuan->sub_cp_mk.'</td>
					<td>'.$rps_pertemuan->indikator.'</td>
					<td>'.$rps_pertemuan->kriteria_bentuk_penilaian.'</td>
					<td>'.$rps_pertemuan->metode_pembelajaran.'</td>
					<td>'.$rps_pertemuan->metode_pembelajaran_daring.'</td>
					<td>'.$rps_pertemuan->materi_pembelajaran.'</td>
					<td>'.$rps_pertemuan->bobot.'</td>
			';
			if($_SESSION['app_level']==2){
				echo'<td><a href="'.base_url('dhmd/buat_rps_pertemuan/'.$rps->id_matkul.'/'.$rps->id_rps.'/'.$i).'" class="text-decoration-none">Edit</td>';
			}else{
				echo '<td>&nbsp;</td>';
			}
			echo'</tr>';
		}else{
			if($_SESSION['app_level']==2){
				echo '<tr><td colspan="9"><a href="'.base_url('dhmd/buat_rps_pertemuan/'.$rps->id_matkul.'/'.$rps->id_rps.'/'.$i).'" class="text-decoration-none"> Tambah Minggu ke #'.$i.'</td></tr>';
			}else{
				echo '<tr><td colspan="9"><em>tidak tersedia</em></td></tr>';
			}
		}
	}
	?>
	</table>
</div>					
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>