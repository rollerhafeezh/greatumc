<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
			<div class="col mb-4">
				<div class="card h-100">
					<div class="card-body">
<!--START
<h5 class="card-title">&nbsp;</h5>-->
<form method="post" class="row g-3" action="<?= base_url('kurikulum/simpan_kurikulum') ?>" enctype="multipart/form-data">
	<div class="col-md-4">
		<label for="id_smt" class="form-label">Semester</label>
		<select id="id_smt" name="id_smt" class="form-select">
			<option>Pilih Semester</option>
			<?php 
				$ref_smt 	= $this->Main_model->ref_smt();
				foreach($ref_smt as $ket=>$value)
				{
					$selected=($value->id_semester==$_SESSION['active_smt'])?'selected':'';
					echo'<option value="'.$value->id_semester.'" '.$selected.'>'.$value->nama_semester.'</option>';
				}
			?>
		</select>
	</div>
	<div class="col-md-4">
		<label for="kode_fak" class="form-label">Fakultas</label>
		<select id="kode_fak" name="kode_fak" class="form-select"  onchange="ref_prodi()">
			<option value="<?=$_SESSION['kode_fak']?>">Pilih Fakultas</option>
			<?php 
				$ref_fakultas 	= $this->Main_model->ref_fakultas($_SESSION['kode_fak']);
				foreach($ref_fakultas as $ket=>$value)
				{
					echo'<option value="'.$value->kode_fak.'">'.$value->nama_fak.'</option>';
				}
			?>
		</select>
	</div>
	<div class="col-md-4">
		<label for="kode_prodi" class="form-label">Program Studi</label>
		<select id="kode_prodi" name="kode_prodi" class="form-select">
			<option>Pilih Program Studi</option>
		</select>
	</div>
	<div class="col-md-6">
		<label for="nm_kurikulum_sp" class="form-label">Nama Kurikulum</label>
        <input id="nm_kurikulum_sp" name="nm_kurikulum_sp" type="text" class="form-control" required>
	</div>
	<div class="col-md-6">
		<label for="sk_kurikulum" class="form-label">SK Kurikulum</label>
        <input id="sk_kurikulum" name="sk_kurikulum" accept=".pdf" type="file" class="form-control">
	</div>
	<div class="col-md-3">
		<label for="jml_sem_normal" class="form-label">&Sigma; Semester Normal</label>
        <input id="jml_sem_normal" name="jml_sem_normal" type="number" class="form-control">
	</div>
	<div class="col-md-3">
		<label for="jml_sks_lulus" class="form-label">&Sigma; SKS Lulus</label>
        <input id="jml_sks_lulus" name="jml_sks_lulus" type="number" class="form-control">
	</div>
	<div class="col-md-3">
		<label for="jml_sks_wajib" class="form-label">&Sigma; SKS Wajib</label>
        <input id="jml_sks_wajib" name="jml_sks_wajib" type="number" class="form-control">
	</div>
	<div class="col-md-3">
		<label for="jml_sks_pilihan" class="form-label">&Sigma; SKS Pilihan</label>
        <input id="jml_sks_pilihan" name="jml_sks_pilihan" type="number" class="form-control">
	</div>
	<div class="col-12">
		<div class="form-check">
			<input id="kur_aktif" name="kur_aktif" class="form-check-input" value="1" type="checkbox">
			<label for="kur_aktif" class="form-check-label">
				Aktifkan Kurikulum
			</label>
		</div>
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
<script>
function ref_prodi()
{
    var kode_fak = document.getElementById('kode_fak').value;
    let url = "<?=base_url('utama/ref_prodi/')?>"+kode_fak;
    
    fetch(url)
        .then((response) => response.text())
        .then((text) => {
            document.getElementById('kode_prodi').innerHTML = text;
        });
}
</script>