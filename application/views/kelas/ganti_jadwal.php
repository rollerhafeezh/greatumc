<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
			
			<div class="col-12 mb-4">
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
							<div class="col-md-4 mt-1"><strong>Jadwal Kuliah</strong></div>
							<div class="col-md-8 mt-1">
							<?php if($kelas->hari_kuliah){ ?>
								<?=nama_hari($kelas->hari_kuliah)?>, <?=$kelas->jam_mulai?> sd <?=$kelas->jam_selesai?><br>
								G. <?=$kelas->nama_gedung?> R. <?=$kelas->nama_ruangan?>
							<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-12 mb-4">
				<div class="card h-100">
					<div class="card-body">
					<h5 class="card-title">Jadwal Kuliah</h5>
					<form method="post" action="<?= base_url('kelas/proses_ganti_jadwal/'.$id_kelas_kuliah) ?>">
						<input type="hidden" id="id_smt" value="<?=$kelas->id_smt?>" name="id_smt">
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
									<option value="0">Pilih Hari Kuliah</option>
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
								<input id="jam_mulai" name="jam_mulai" onfocus="this.select()" onblur="tampilkan_gedung()" value="00:00:00" type="text" class="form-control mask_jam">
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
							</span>
							<div class="col-12 text-center">
								<button type="submit" class="btn btn-primary btn-lg">Simpan</button>
								<button type="reset" class="btn btn-danger btn-sm">Ulangi</button>
							</div>
						</div>
					</form>
					</div>
				</div>
			</div>
		
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
	document.getElementById('pilih_ruangan').style.display='block';
	document.getElementById('pilih_gedung').focus()
}

function ref_ruangan_kuliah()
{
	var element 	= document.getElementById('id_ruangan');
	var id_gedung 	= document.getElementById('id_gedung').value;
	var hari_kuliah = document.getElementById('hari_kuliah').value;
	var id_smt 		= document.getElementById('id_smt').value;
	var jam_mulai 	= document.getElementById('jam_mulai').value;
	var jam_selesai = document.getElementById('jam_selesai').value;
	var team_teach = document.getElementById('team_teach').value;
	
	element.disabled = true;
	fetch('<?=base_url('utama/ref_ruangan_kuliah/')?>', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
			},
			body: JSON.stringify({
				id_gedung	: id_gedung,
				hari_kuliah	: hari_kuliah,
				id_smt		: id_smt,
				jam_mulai	: jam_mulai,
				jam_selesai	: jam_selesai,
				team_teach	: team_teach,
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


</script>