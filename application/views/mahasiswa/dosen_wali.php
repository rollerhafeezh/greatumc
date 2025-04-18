<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		<div class="col-12 mb-4">
			<div class="card h-100">
				<div class="card-body d-flex flex-column">
					<div class="card-title">
						<h5>Detail Mahasiswa</h5>
					</div>

					<div class="row">
						<div class="col-md-4 mt-1"><strong>NIM</strong></div>
						<div class="col-md-8 mt-1"><?=$mahasiswa_pt->id_mahasiswa_pt?></div>
						<div class="col-md-4 mt-1"><strong>Nama Mahasiswa</strong></div>
						<div class="col-md-8 mt-1"><?=$mahasiswa_pt->nm_pd?></div>
						<div class="col-md-4 mt-1"><strong>Homebase</strong></div>
						<div class="col-md-8 mt-1"><?=$mahasiswa_pt->inisial_fak?> <?=$mahasiswa_pt->nama_prodi?> <?=$mahasiswa_pt->nm_jenj_didik?></div>
						<div class="col-md-4 mt-1"><strong>Dosen Wali</strong></div>
						<div class="col-md-8 mt-1"><?=$mahasiswa_pt->nm_sdm?> </div>
						<div class="col-md-4 mt-1"><strong>Semester diterima/ Tahun Akademik</strong></div>
						<div class="col-md-8 mt-1"><?=$mahasiswa_pt->diterima_smt?> / <?=nama_smt($mahasiswa_pt->mulai_smt)?>
						</div>
					</div>
				</div>
			</div>
		</div>
		
<form method="post" action="<?= base_url('mahasiswa/proses_dosen_wali/'.$mahasiswa_pt->id_mahasiswa_pt) ?>">
			<input type="hidden" name="id_dosen_old" value="<?=$mahasiswa_pt->id_dosen?>">
			<input type="hidden" name="id_mahasiswa_pt" value="<?=$mahasiswa_pt->id_mahasiswa_pt?>">
			<div class="col-12 mb-4">
				<div class="card h-100">
					<div class="card-body">

						<h5 class="card-title">Dosen Wali</h5>
						<div class="row g-3">
							
							<div class="col-md-12">
							<select id="select-repo" name="id_dosen" placeholder="Ketik Nama Dosen"></select>
							</div>
							<div class="col-md-12 text-center">
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
			url: '<?=base_url('utama/get_dosen')?>',
			type: 'GET',
			data: {
				nm_sdm: query,
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