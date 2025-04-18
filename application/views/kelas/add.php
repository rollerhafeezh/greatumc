<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
<form method="post" action="<?= base_url('kelas/simpan_kelas_kuliah') ?>">
			<div class="col-12 mb-4">
				<div class="card h-100">
					<div class="card-body">

<h5 class="card-title">Inisiasi Kelas</h5>
<div class="row g-3">
	<div class="col-md-3">
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
		<select id="kode_prodi" name="kode_prodi" class="form-select" onchange="ref_kurikulum_aktif()">
			<option>---</option>
		</select>
	</div>
	<div class="col-md-3">
		<label for="id_kur" class="form-label">Kurikulum</label>
		<select id="id_kur" name="id_kur" class="form-select" onchange="ref_matkul_kur_kelas()">
			<option>---</option>
		</select>
	</div>
</div>
	
					</div>
				</div>
			</div>
			
			<div class="col-mb-6 mb-4">
				<div class="card h-100">
					<div class="card-body">

<h5 class="card-title">Detail Kelas</h5>
<div class="row g-3">
	<div class="col-12">
		<label for="id_matkul" class="form-label">Mata Kuliah</label>
		<select id="id_matkul" name="id_matkul" class="form-select">
			<option>---</option>
		</select>
	</div>
	<div class="col-md-6">
		<label for="nm_kls" class="form-label">Nama Kelas</label>
        <input id="nm_kls" name="nm_kls" onfocus="this.select()" value="-" maxlength="5" type="text" class="form-control" required>
	</div>
	<div class="col-md-6">
		<label for="kuota_kelas" class="form-label">Daya Tampung (orang)</label>
        <input id="kuota_kelas" value="30" name="kuota_kelas" type="number" class="form-control" required>
	</div>
</div>
	
					</div>
				</div>
			</div>
			
			<div class="col-mb-6 mb-4">
				<div class="card h-100">
					<div class="card-body">

<h5 class="card-title">Jadwal Kuliah</h5>
<div class="row g-3">
	<div class="col-md-3">
		<label for="team_teach" class="form-label">Team Teaching</label>
		<select id="team_teach" name="team_teach" class="form-select" onchange="sembunyikan_gedung()">
			<option value="0">Tidak</option>
			<option value="1">Ya</option>
		</select>
	</div>
	<div class="col-md-3">
		<label for="hari_kuliah" class="form-label">Hari Kuliah</label>
		<select id="hari_kuliah" name="hari_kuliah" class="form-select" onchange="sembunyikan_gedung()">
			<option>Pilih Hari Kuliah</option>
			<?php
			foreach(nama_hari() as $days=>$values)
			{
				if($days!=0) echo'<option value="'.$days.'">'.$values.'</option>';
			}
			?>
		</select>
	</div>
	<div class="col-md-3">
		<label for="jam_mulai" class="form-label">Jam Mulai</label>
        <input id="jam_mulai" name="jam_mulai" onfocus="this.select()" value="00:00:00" type="text" class="form-control mask_jam" onchange="tampilkan_gedung()">
	</div>
	<div class="col-md-3">
		<label for="jam_selesai" class="form-label">Jam Selesai</label>
        <input id="jam_selesai" name="jam_selesai" onfocus="this.select()" value="00:00:00" type="text" class="form-control mask_jam">
	</div>
	<div class="col-md-6" id="pilih_gedung" style="display:none">
	<label for="id_gedung" class="form-label">Gedung</label>
		<select id="id_gedung" name="id_gedung" class="form-select" onchange="ref_ruangan_kuliah()">
			<option>Pilih Gedung</option>
			<?php
			foreach($id_gedung->result() as $ket=>$value)
			{
				echo'<option value="'.$value->id_gedung.'">'.$value->nama_gedung.'</option>';
			}
			?>
		</select>
	</div>
	<div class="col-md-6"  id="pilih_ruangan" style="display:none">
		<label for="id_ruangan" class="form-label">Ruangan</label>
		<select id="id_ruangan" name="id_ruangan" class="form-select" disabled>
			<option>Pilih Ruangan</option>
		</select>
	</div>
</div>
					
					</div>
				</div>
			</div>
			
			<div class="col-mb-6 mb-4">
				<div class="card h-100">
					<div class="card-body">

<h5 class="card-title">Dosen Pengampu</h5>
<div class="row g-3">
	
	<div class="col-12">
	<select id="select-repo" name="id_dosen[]" placeholder="Ketik Nama Dosen" multiple></select>
	</div>
	<div class="col-12 text-center">
		<button type="submit" class="btn btn-primary btn-lg">Simpan</button>
		<button type="reset" class="btn btn-danger btn-sm">Ulangi</button>
	</div>
</div>
	
					</div>
				</div>
			</div>
</form>
		</div>
	</div>
</div>
<link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.6/css/selectize.bootstrap5.min.css" rel="stylesheet"> 
<script src="https://code.jquery.com/jquery-3.6.1.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.6/js/standalone/selectize.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" type="text/javascript"></script>

<script>
$(document).ready(function(){
	$('.mask_jam').mask('00:00:00');
});

function sembunyikan_gedung()
{
	document.getElementById('pilih_gedung').style.display='none';
	document.getElementById('pilih_ruangan').style.display='none';
}

function tampilkan_gedung()
{
	document.getElementById('pilih_gedung').style.display='block';
	document.getElementById('pilih_gedung').focus();
	document.getElementById('pilih_ruangan').style.display='block';
}

function ref_ruangan_kuliah()
{
	var element 	= document.getElementById('id_ruangan');
	var team_teach 	= document.getElementById('team_teach').value;
	var id_gedung 	= document.getElementById('id_gedung').value;
	var hari_kuliah = document.getElementById('hari_kuliah').value;
	var id_smt 		= document.getElementById('id_smt').value;
	var jam_mulai 	= document.getElementById('jam_mulai').value;
	var jam_selesai = document.getElementById('jam_selesai').value;
	
	element.disabled = true;
	fetch('<?=base_url('utama/ref_ruangan_kuliah/')?>', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
			},
			body: JSON.stringify({
				team_teach	: team_teach,
				id_gedung	: id_gedung,
				hari_kuliah	: hari_kuliah,
				id_smt		: id_smt,
				jam_mulai	: jam_mulai,
				jam_selesai	: jam_selesai,
			})
	})
	.then((response) => response.text())
	.then((text) => {
		element.disabled = false;
		element.focus();
		document.getElementById('id_ruangan').innerHTML = text;
	})
	.catch(error => {
		console.log(error)
	})  
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

function ref_kurikulum_aktif()
{
    var kode_prodi = document.getElementById('kode_prodi').value;
    let url = "<?=base_url('utama/ref_kurikulum_aktif/')?>"+kode_prodi;
    
    fetch(url)
        .then((response) => response.text())
        .then((text) => {
            document.getElementById('id_kur').innerHTML = text;
        });
}

function ref_matkul_kur_kelas()
{
    var id_kur = document.getElementById('id_kur').value;
    var id_smt = document.getElementById('id_smt').value;
    let url = "<?=base_url('utama/ref_matkul_kur_kelas/')?>"+id_kur+"/"+id_smt;
    
    fetch(url)
        .then((response) => response.text())
        .then((text) => {
            document.getElementById('id_matkul').innerHTML = text;
        });
}

$('#select-repo').selectize({
	valueField: 'id_dosen',
	labelField: 'nm_sdm',
	searchField: 'nm_sdm',
	options: [],
	create: false,
	render: {
		option: function(item, escape) {
			return '<option value="'+item.id_dosen+'">'+ item.nidn +' '+ item.nm_sdm +'</option>';
		} 
	},
	load: function(query, callback) {
		if (!query.length) return callback();
		$.ajax({
			url: '<?=base_url('utama/get_dosen_pt')?>',
			type: 'GET',
			data: {
				nm_sdm: query,
				smt: document.getElementById('id_smt').value,
				hari_kuliah: document.getElementById('hari_kuliah').value,
				jam_mulai: document.getElementById('jam_mulai').value,
				team_teach: document.getElementById('team_teach').value,
				jam_selesai: document.getElementById('jam_selesai').value,
			},
			error: function() {
				callback();
			},
			success: function(res) {
				callback(JSON.parse(res));
			}
		});
	}
});

</script>