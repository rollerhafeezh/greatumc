<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
			<div class="col mb-4">
				<div class="card h-100">
					<div class="card-body">
<!--START
<h5 class="card-title">&nbsp;</h5>-->
<form method="post" class="row g-3" action="<?= base_url('matkul/simpan_matkul') ?>">
	<div class="col-md-3">
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
	<div class="col-md-3">
		<label for="kode_prodi" class="form-label">Program Studi</label>
		<select id="kode_prodi" name="kode_prodi" class="form-select">
			<option>Pilih Program Studi</option>
		</select>
	</div>
	<div class="col-md-3">
		<label for="jns_mk" class="form-label">Jenis Mata Kuliah</label>
		<select id="jns_mk" name="jns_mk" class="form-select">
			<option>Pilih Jenis Mata Kuliah</option>
			<?php 
				foreach($ref_jenis_mk as $ket=>$value)
				{
					echo'<option value="'.$value->inisial_jenis_mk.'" '.$selected.'>'.$value->nama_jenis_mk.'</option>';
				}
			?>
		</select>
	</div>
	<div class="col-md-3">
		<label for="id_kat_mk" class="form-label">Kategori Mata Kuliah</label>
		<select id="id_kat_mk" name="id_kat_mk" class="form-select">
			<option value="" hidden="">Pilih Kategori Mata Kuliah</option>
			<?php 
				foreach($ref_kategori_mk as $ket=>$value)
				{
					echo'<option value="'.$value->id_kat_mk.'" '.$selected.'>'.$value->ket_kat_mk.'</option>';
				}
			?>
		</select>
	</div>
	<div class="col-md-2">
		<label for="kode_mk" class="form-label">Kode Mata Kuliah</label>
        <input id="kode_mk" name="kode_mk" type="text" class="form-control" required>
	</div>
	<div class="col-5">
		<label for="nm_mk" class="form-label">Nama Mata Kuliah</label>
        <input id="nm_mk" name="nm_mk" type="text" class="form-control" required>
	</div>
	<div class="col-5">
		<label for="nm_mk_en" class="form-label">Nama Mata Kuliah <i>(en)</i></label>
        <input id="nm_mk_en" name="nm_mk_en" type="text" value="-" class="form-control" required>
	</div>
	<div class="col-md-2">
		<label for="sks_tm" class="form-label">SKS Tatap Muka</label>
        <input id="sks_tm" value="0" name="sks_tm" type="number" class="form-control" onchange="update_sks_mk()">
	</div>
	<div class="col-md-2">
		<label for="sks_prak" class="form-label">SKS Praktek</label>
        <input id="sks_prak" value="0" name="sks_prak" type="number" class="form-control" onchange="update_sks_mk()">
	</div>
	<div class="col-md-2">
		<label for="sks_prak_lap" class="form-label">SKS Praktek Lapangan</label>
        <input id="sks_prak_lap" value="0" name="sks_prak_lap" type="number" class="form-control" onchange="update_sks_mk()">
	</div>
	<div class="col-md-2">
		<label for="sks_sim" class="form-label">SKS Simulasi</label>
        <input id="sks_sim" value="0" name="sks_sim" type="number" class="form-control" onchange="update_sks_mk()">
	</div>
	<div class="col-md-4">
		<label for="sks_mk" class="form-label">&Sigma; SKS</label>
        <input id="sks_mk" value="0" name="sks_mk" type="number" class="form-control" required readonly>
	</div>
	<div class="col-12 text-center">
		<button type="submit" class="btn btn-primary">Simpan</button>
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
function update_sks_mk()
{
	var sks_tm = document.getElementById('sks_tm').value;
	var sks_prak = document.getElementById('sks_prak').value;
	var sks_sim = document.getElementById('sks_sim').value;
	var sks_prak_lap = document.getElementById('sks_prak_lap').value;
	var sks_mk = document.getElementById('sks_mk');
	var mk;
	mk = Number(sks_tm) + Number(sks_prak) + Number(sks_sim) + Number(sks_prak_lap);
	sks_mk.value = mk;
}

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