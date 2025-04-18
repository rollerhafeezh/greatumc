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
					</div>
				</div>
			</div>
		</div>
		
<form method="post" class="row" action="<?= base_url('kelas/proses_ganti_pengampu/'.$id_ajar_dosen) ?>">
			<input type="hidden" name="id_dosen_old" value="<?=$id_ajar_dosen?>">
			<input type="hidden" name="id_smt" id="id_smt" value="<?=$kelas->id_smt?>">
			<input type="hidden" id="hari_kuliah" value="<?=$kelas->hari_kuliah?>">
			<input type="hidden" id="jam_mulai" value="<?=$kelas->jam_mulai?>">
			<input type="hidden" id="jam_selesai" value="<?=$kelas->jam_selesai?>">
			<div class="col mb-4">
				<div class="card h-100">
					<div class="card-body">

						<div class="row g-3">
							<div class="col-md-4 mt-3">
								<label for="team_teach" class="form-label">Team Teaching</label>
								<select id="team_teach" name="team_teach" class="form-select">
									<option value="0">Tidak</option>
									<option value="1">Ya</option>
								</select>
							</div>
							<div class="col-md-8 mt-3">
								<label for="select-repo" class="form-label">Dosen Pengampu</label>
							<select id="select-repo" name="id_dosen" placeholder="Ketik Nama Dosen"></select>
							</div>
							<div class="col-md-12 text-center mt-3">
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
var id_smt = document.getElementById('id_smt').value;
var hari_kuliah = document.getElementById('hari_kuliah').value;
var jam_mulai 	= document.getElementById('jam_mulai').value;
var jam_selesai 	= document.getElementById('jam_selesai').value;
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
				smt: id_smt,
				hari_kuliah: hari_kuliah,
				jam_mulai: jam_mulai,
				team_teach: document.getElementById('team_teach').value,
				jam_selesai: jam_selesai,
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