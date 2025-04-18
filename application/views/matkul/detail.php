<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		
			<div class="col mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
<form method="post" class="row g-3" action="<?= base_url('matkul/update_matkul/'.$matkul->id_matkul) ?>">
	<div class="col-md-3">
		<label for="kode_fak" class="form-label">Fakultas</label>
		<input type="text" class="form-control" value="<?=$matkul->nama_fak?>" disabled>
	</div>
	<div class="col-md-3">
		<label for="kode_prodi" class="form-label">Program Studi</label>
		<input type="text" class="form-control" value="<?=$matkul->nama_prodi?>" disabled>
	</div>
	<div class="col-md-3">
		<label for="jns_mk" class="form-label">Jenis Mata Kuliah</label>
		<select id="jns_mk" name="jns_mk" class="form-select" disabled>
			<option value="<?=$matkul->inisial_jenis_mk?>"><?=$matkul->nama_jenis_mk?></option>
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
		<select id="id_kat_mk" name="id_kat_mk" class="form-select" disabled>
			<option value="<?=$matkul->id_kat_mk?>"><?=$matkul->inisial_kat_mk?></option>
			<?php 
				foreach($ref_kategori_mk as $ket=>$value)
				{
					echo'<option value="'.$value->id_kat_mk.'">'.$value->inisial_kat_mk.'</option>';
				}
			?>
		</select>
	</div>
	<div class="col-md-2">
		<label for="kode_mk" class="form-label">Kode Mata Kuliah</label>
		<input id="kode_mk" name="kode_mk" type="text" class="form-control" value="<?=$matkul->kode_mk?>" readonly>
    </div>
	<div class="col-5">
		<label for="nm_mk" class="form-label">Nama Mata Kuliah</label>
		<input id="nm_mk" name="nm_mk" type="text" class="form-control" value="<?=$matkul->nm_mk?>" readonly>
    </div>
	<div class="col-5">
		<label for="nm_mk_en" class="form-label">Nama Mata Kuliah <i>(en)</i></label>
		<input id="nm_mk_en" name="nm_mk_en" type="text" class="form-control" value="<?=$matkul->nm_mk_en?>" readonly>
	</div>
	<div class="col-md-2">
		<label for="sks_tm" class="form-label">SKS Tatap Muka</label>
		<input id="sks_tm" name="sks_tm" type="number" class="form-control" value="<?=$matkul->sks_tm?>" onchange="update_sks_mk()" readonly>
	</div>
	<div class="col-md-2">
		<label for="sks_prak" class="form-label">SKS Praktek</label>
		<input id="sks_prak" name="sks_prak" type="number" class="form-control" value="<?=$matkul->sks_prak?>" onchange="update_sks_mk()" readonly>
	</div>
	<div class="col-md-2">
		<label for="sks_prak_lap" class="form-label">SKS Praktek Lapangan</label>
		<input id="sks_prak_lap" name="sks_prak_lap" type="number" class="form-control" value="<?=$matkul->sks_prak_lap?>" onchange="update_sks_mk()" readonly>
	</div>
	<div class="col-md-2">
		<label for="sks_sim" class="form-label">SKS Simulasi</label>
		<input id="sks_sim" name="sks_sim" type="number" class="form-control" value="<?=$matkul->sks_sim?>" onchange="update_sks_mk()" readonly>
	</div>
	<div class="col-md-4">
		<label for="sks_mk" class="form-label">&Sigma; SKS</label>
        <input id="sks_mk" name="sks_mk" type="number" class="form-control" value="<?=$matkul->sks_mk?>" readonly>
	</div>
	<div class="col-12 text-center">
		<?php if($_SESSION['app_level']==3 or $_SESSION['app_level']==4){ ?>
		<a href="<?=base_url('matkul/hapus_matkul/'.$matkul->id_matkul)?>" onclick="return confirm(`Yakin?`)" id="btn_hapus" class="btn btn-primary">Hapus Mata Kuliah</a>
		<a href="#" onclick="form_edit()" class="btn btn-warning" id="btn_edit">Edit</a> 
		<button type="submit" class="btn btn-info" id="btn_update" style="display:none">Update</button>
		<?php } ?>
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
function form_edit()
{
	document.getElementById("btn_update").style.display = "block";
	document.getElementById("btn_edit").style.display = "none";
	document.getElementById("kode_mk").removeAttribute("readonly");
	document.getElementById("nm_mk").removeAttribute("readonly");
	document.getElementById("nm_mk_en").removeAttribute("readonly");
	document.getElementById("sks_prak").removeAttribute("readonly");
	document.getElementById("sks_prak_lap").removeAttribute("readonly");
	document.getElementById("sks_sim").removeAttribute("readonly");
	document.getElementById("sks_tm").removeAttribute("readonly");
	document.getElementById("jns_mk").removeAttribute("disabled");
	document.getElementById("id_kat_mk").removeAttribute("disabled");
}
</script>