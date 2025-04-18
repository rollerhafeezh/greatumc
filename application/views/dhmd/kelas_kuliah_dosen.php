<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		<?php 
		$angka_hari = date("N");
		foreach($kelas as $key=>$value){ 
		$hari_kuliah=($value->hari_kuliah==0)?7:$value->hari_kuliah;
		$bg_kelas = $_ENV['KELAS_NORM'];
		$bg_kuliah = 'light';
		if($hari_kuliah==$angka_hari)
		{
			$bg_kelas = $_ENV['KELAS_START'];
			$bg_kuliah = 'info';
		}
		?>
			<div class="col-md-4 mb-4">
				<div class="card h-100">
					<a class="text-decoration-none" href="<?=base_url('dhmd/daftar_pertemuan/'.$value->id_kelas_kuliah)?>"><img src="<?=$bg_kelas?>" class="card-img-top" alt="kelas"></a>
					<div class="card-body d-flex flex-column">
						<h4 class="card-title"><a class="text-decoration-none" href="<?=base_url('dhmd/daftar_pertemuan/'.$value->id_kelas_kuliah)?>"><?= $value->nm_mk ?> <?=$value->nm_kls?></a></h4>
						<span class="badge bg-<?=$bg_kuliah?>"><?=nama_hari($hari_kuliah)?></span>
					</div>
					<div id="carousel<?=$value->id_kelas_kuliah?>" class="carousel slide carousel-dark" data-bs-interval="false" data-bs-ride="carousel">
					  <div class="carousel-inner">
						<div class="carousel-item active px-5">
							<div class="table-responsive">
                                <table class="table table-sm">
									<tbody>
										<tr>
											<td><strong>Prodi</strong></td>
											<td>:</td>
											<td><?=$value->nama_prodi?></td>
										</tr>
										<tr>
											<td><strong>Gedung</strong></td>
											<td>:</td>
											<td><?=$value->nama_gedung?></td>
										</tr>
										<tr>
											<td><strong>Ruangan</strong></td>
											<td>:</td>
											<td><?=$value->nama_ruangan?></td>
										</tr>
										<tr>
											<td><strong>Hari</strong></td>
											<td>:</td>
											<td><?=nama_hari($hari_kuliah)?></td>
										</tr>
										<tr>
											<td><strong>Mulai</strong></td>
											<td>:</td>
											<td><?=$value->jam_mulai?></td>
										</tr>
										<tr>
											<td><strong>Selesai</strong></td>
											<td>:</td>
											<td><?=$value->jam_selesai?></td>
										</tr>
										<tr>
											<td><strong>&Sigma; Peserta</strong></td>
											<td>:</td>
											<td><?=$value->count_peserta?></td>
										</tr>
										<tr>
											<td><strong>&Sigma; Pertemuan</strong></td>
											<td>:</td>
											<td><?=$value->count_pertemuan?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="carousel-item px-4">
							<ul class="list-group list-group-flush">
								<li class="list-group-item"><a class="text-decoration-none" href="https://zoom.us"><img height="48px" src="<?=base_url('assets/images/logo_zoom.jpg')?>"></a></li>
								<li class="list-group-item"><a class="text-decoration-none" href="<?=base_url('dhmd/rps/'.$value->id_matkul)?>">RPS</a></li>
								<li class="list-group-item"><a class="text-decoration-none" href="<?=base_url('dhmd/absensi/'.$value->id_kelas_kuliah)?>">Absensi</a></li>
								<li class="list-group-item"><a class="text-decoration-none" href="<?=base_url('dhmd/daftar_pertemuan/'.$value->id_kelas_kuliah)?>">Daftar Pertemuan</a></li>
								<li class="list-group-item"><a class="text-decoration-none" href="<?=base_url('ujian/soal/'.$value->id_kelas_kuliah)?>">Ujian</a></li>
								<li class="list-group-item"><a class="text-decoration-none" href="<?=base_url('dhmd/nilai/'.$value->id_kelas_kuliah)?>">Nilai</a></li>
							</ul>
						</div>
					</div>
					<button class="carousel-control-next" type="button" data-bs-target="#carousel<?=$value->id_kelas_kuliah?>" data-bs-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Next</span>
					</button>
					</div>
				</div>
			</div>
		<?php } ?>
		</div>
	</div>
</div>

