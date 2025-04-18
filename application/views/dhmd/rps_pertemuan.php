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
		<a href="<?=base_url('dhmd/rps_detail/'.$rps->id_rps)?>#rps_pertemuan" class="btn btn-danger">Kembali</a> <a href="<?=base_url('beranda/rps/'.$lempar)?>" class="btn btn-info">Lihat RPS</a>
	</div>
<!--END-->	
</div>
					</div>
				</div>
			</div>
<!-- tiny001 mase -->
<!-- <script src="https://cdn.tiny.cloud/1/b1k2ullr8gqc9niksxycgywh2suxlbrrw72dg8ppjr8oiovx/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script> -->			
			
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
					<div class="card-title">
						<h5>RPS Pertemuan ke <?=$rps_pertemuan->minggu_ke?></h5>
					</div>
<form method="post" action="<?=base_url('dhmd/simpan_rps_pertemuan/'.$rps_pertemuan->id_rps_pertemuan.'/'.$rps->id_matkul.'/'.$rps->id_rps.'/'.$rps_pertemuan->minggu_ke)?>">
<div class="row">
	<div class="col-md-3 mt-3">
		<strong>SUB-CP MK</strong>
	</div>
	<div class="col-md-9 mt-3">
		<textarea name="sub_cp_mk" class="form-control" rows="5"><?=$rps_pertemuan->sub_cp_mk?></textarea>
	</div>
</div>
<div class="row">
	<div class="col-md-3 mt-3">
		<strong>Penilaian</strong>
	</div>
	<div class="col-md-9 mt-3">
		<div class="row">
			<div class="col-12">
				<p><strong>Indikator</strong></p>
				<textarea name="indikator" class="form-control" rows="5"><?=$rps_pertemuan->indikator?></textarea>
			</div>
			<div class="col-12 mt-3">
				<p><strong>Bentuk dan Kriteria</strong></p>
				<textarea name="kriteria_bentuk_penilaian" class="form-control" rows="5"><?=$rps_pertemuan->kriteria_bentuk_penilaian?></textarea>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-3 mt-3">
		<strong>Bentuk Pembelajaran, Metode Pembelajaran, dan Penugasan Mahasiswa</strong>
	</div>
	<div class="col-md-9 mt-3">
		<div class="row">
			<div class="col-12">
				<p><strong>Luring</strong></p>
				<textarea name="metode_pembelajaran" class="form-control" rows="5"><?=$rps_pertemuan->metode_pembelajaran?></textarea>
			</div>
			<div class="col-12 mt-3">
				<p><strong>Daring</strong></p>
				<textarea name="metode_pembelajaran_daring" class="form-control" rows="5"><?=$rps_pertemuan->metode_pembelajaran_daring?></textarea>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-3 mt-3">
		<strong>Materi Pembelajaran [Pustaka]</strong>
	</div>
	<div class="col-md-9 mt-3">
		<textarea name="materi_pembelajaran" class="form-control" rows="5"><?=$rps_pertemuan->materi_pembelajaran?></textarea>
	</div>
</div>
<div class="row">
	<div class="col-md-3 mt-3">
		<strong>Bobot Penilaian	(%)</strong>
	</div>
	<div class="col-md-9 mt-3">
		<input type="number" min="0" max="100" name="bobot" class="form-control" value="<?=$rps_pertemuan->bobot?>">
	</div>
</div>
<div class="row">
	<div class="col mt-3">
		<input type="submit" class="btn btn-info" value="Simpan">
	</div>
</div>
</form>
					</div>
				</div>
			</div>
			
			
			
		</div>
	</div>
</div>