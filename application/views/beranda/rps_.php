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
	<div class="col-md-2">
		<label for="sks_tm" class="form-label"><strong>SKS Tatap Muka</strong></label>
		<?=$matkul->sks_tm?>
	</div>
	<div class="col-md-2">
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
	<div class="col-md-2">
		<label for="sks_mk" class="form-label"><strong>&Sigma; SKS</strong></label>
        <?=$matkul->sks_mk?>
	</div>
	<div class="col-12 text-center">
	</div>
<!--END-->	
</div>
					</div>
				</div>
			</div>

			<div class="col-12 mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">

<div class="row">
	<div class="col-md-3 mt-1">
		<strong>Capaian Pembelajaran (CP)</strong>
	</div>
	<div class="col-md-9 mt-1">
		<div class="row">
			<div class="col-12">
				<p><strong>CP Program Studi :</strong></p>
				<?=$rps->cp_prodi?>
				
			</div>
			<div class="col-12 mt-1">
				<p><strong>CP Mata kuliah : </strong></p>
				<?=$rps->cp_mk?>
				
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-3 mt-1">
		<strong>Deskripsi Singkat</strong>
	</div>
	<div class="col-md-9 mt-1">
		<?=$rps->deskripsi_singkat?>
		
	</div>
</div>
<div class="row">
	<div class="col-md-3 mt-1">
		<strong>Pokok Bahasan / Bahan Kajian</strong>
	</div>
	<div class="col-md-9 mt-1">
		<?=$rps->pokok_bahasan?>
		
	</div>
</div>
<div class="row">
	<div class="col-md-3 mt-1">
		<strong>Pustaka</strong>
	</div>
	<div class="col-md-9 mt-1">
		<div class="row">
			<div class="col-12">
				<p><strong>Utama :</strong></p>
				<?=$rps->pustaka_utama?>
				
			</div>
			<div class="col-12 mt-1">
				<p><strong>Pendukung :</strong></p>
				<?=$rps->pustaka_pendukung?>
				
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-3 mt-1">
		<strong>Media Pembelajaran</strong>
	</div>
	<div class="col-md-9 mt-1">
		<div class="row">
			<div class="col-12">
				<p><strong>Perangkat Keras :</strong></p>
				<?=$rps->media_perangkat_keras?>
				
			</div>
			<div class="col-12 mt-1">
				<p><strong>Perangkat Lunak :</strong></p>
				<?=$rps->media_perangkat_lunak?>
				
			</div>
		</div>
	</div>
</div>

					</div>
				</div>
			</div>
			
			<div class="col-12 mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
						<div class="card-title">
							<h5>RPS Pertemuan</h5>
						</div>
<div class="table-responsive">
	<table class="table table-bordered">
	<thead>
		<tr>
			<th rowspan="2" width="1" class="text-center text-wrap">Minggu Ke-</th>
			<th rowspan="2" class="text-center text-wrap">SUB-CP MK</th>
			<th colspan="2" class="text-center text-wrap">Penilaian</th>
			<th colspan="2" class="text-center text-wrap">Bentuk Pembelajaran,<br>Metode Pembelajaran, dan<br>Penugasan Mahasiswa</th>
			<th rowspan="2" class="text-center text-wrap">Materi Pembelajaran [Pustaka]</th>
			<th rowspan="2" class="text-center text-wrap">Bobot Penilaian</th>
		</tr>
		<tr>
			<th class="text-center text-wrap">Indikator</th>
			<th class="text-center text-wrap">Bentuk dan Kriteria</th>
			<th class="text-center text-wrap">Luring</th>
			<th class="text-center text-wrap">Daring</th>
		</tr>
	</thead>
	<?php
	for($i=1;$i<=16;$i++)
	{
		$rps_pertemuan = $this->Main_model->get_rps_pertemuan($rps->id_matkul,$rps->id_rps,null,$i)->row();
		if($rps_pertemuan)
		{
			echo '<tr> 
					<td>'.$i.'</td>
					<td>'.$rps_pertemuan->sub_cp_mk.'</td>
					<td>'.$rps_pertemuan->indikator.'</td>
					<td>'.$rps_pertemuan->kriteria_bentuk_penilaian.'</td>
					<td>'.$rps_pertemuan->metode_pembelajaran.'</td>
					<td>'.$rps_pertemuan->metode_pembelajaran_daring.'</td>
					<td>'.$rps_pertemuan->materi_pembelajaran.'</td>
					<td>'.$rps_pertemuan->bobot.'</td>
			</tr>';
		}else{
			echo '<tr><td colspan="9"><em>tidak tersedia</em></td></tr>';
		}
	}
	?>
	</table>
</div>					
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>