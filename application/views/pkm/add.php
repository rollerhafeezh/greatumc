<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
			<div class="col mb-4">
				<div class="card h-100">
					<div class="card-body">
<!--START
<h5 class="card-title">&nbsp;</h5>-->
<form method="post" class="row g-3" action="<?= base_url('pkm/simpan') ?>" enctype="multipart/form-data">
	<?php if($sesi->judul_sesi){ ?>
	<div class="col-md-12">
	    Tema : <?=$sesi->judul_sesi?>
	</div>
	<?php } 
	
	if($sesi->template_sesi){ ?>
	<div class="col-md-6">
	    Template <?=$sesi->template_sesi?>
	</div>
	<?php } 
	
	if($sesi->petunjuk_sesi){ ?>
	<div class="col-md-6">
	    Pedoman <?=$sesi->petunjuk_sesi?>
	</div>
	<?php } ?>
	<div class="col-md-4">
		<label for="id_smt" class="form-label">Semester Pelaksanaan</label>
		<input type="hidden" name="id_smt" value="<?=$sesi->id_smt?>">
		<input id="id_smt" name="nama_smt" type="text" class="form-control" value="<?=nama_smt($sesi->id_smt)?>" readonly>
	</div>
	<div class="col-md-4">
		<label for="nm_pd" class="form-label">Nama Mahasiswa</label>
		<input type="hidden" name="id_mahasiswa_pt" value="<?=$mahasiswa_pt->id_mahasiswa_pt?>">
		<input id="nm_pd" name="nm_pd" type="text" class="form-control" value="<?=$mahasiswa_pt->nm_pd?>" readonly>
	</div>
	<div class="col-md-4">
		<label for="nama_prodi" class="form-label">Program Studi</label>
		<input type="hidden" name="kode_prodi" value="<?=$mahasiswa_pt->kode_prodi?>">
		<input id="nama_prodi" name="nama_prodi" type="text" class="form-control" value="<?=$mahasiswa_pt->nama_prodi?>" readonly>
	</div>
	<div class="col-md-12">
		<label for="id_jenis_pkm" class="form-label">Bidang</label>
		<select id="id_jenis_pkm" name="id_jenis_pkm" class="form-select" required>
			<option>Pilih</option>
			<?php 
				$ref_jenis 	= $this->Pkm_model->ref_jenis()->result();
				foreach($ref_jenis as $ket=>$value)
				{
					echo'<option value="'.$value->id_jenis_pkm.'" >'.$value->jenis_pkm.'</option>';
				}
			?>
		</select>
	</div>
	<div class="col-md-12">
		<label for="judul" class="form-label">Judul Kegiatan</label>
		<input id="judul" name="judul" type="text" class="form-control" placeholder="Judul Kegiatan" required>
	</div>
	<div class="col-md-12">
		<label for="lokasi" class="form-label">Lokasi Kegiatan</label>
		<input id="lokasi" name="lokasi" type="text" class="form-control" placeholder="Lokasi Kegiatan">
	</div>
	<div class="col-md-12">
		<label for="keterangan" class="form-label">Keterangan</label>
		<textarea class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan Kegiatan" rows="5" style="resize:none"></textarea>
	</div>
	<div class="col-12">
		<button type="submit" class="btn btn-primary btn-lg">Simpan</button>
		<button type="reset" class="btn btn-danger btn-sm">Ulangi</button>
	</div>
</form>
<!--END-->		
					</div>
				</div>
			</div>
		</div>
	</div>
</div>