<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		
			<div class="col-md-6 mb-3">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
						<div class="row">
							<div class="col-md-4 mt-1"><strong>Semester</strong></div>
							<div class="col-md-8 mt-1"><?=nama_smt($kelas->id_smt)?></div>
							<div class="col-md-4 mt-1"><strong>Fakultas/ Prodi</strong></div>
							<div class="col-md-8 mt-1"><?=$kelas->nama_fak?> <?=$kelas->nama_prodi?></div>
							<div class="col-md-4 mt-1"><strong>Kelas</strong></div>
							<div class="col-md-8 mt-1"><?=$kelas->nm_mk?> <?=$kelas->nm_kls?></div>
							<div class="col-md-4 mt-1"><strong>Dosen Pengampu</strong></div>
							<div class="col-md-8 mt-1">
								<?php
									$pengampu=$this->Main_model->pengampu_kelas($kelas->id_kelas_kuliah)->result();
									if($pengampu)
									{
										
										foreach($pengampu as $keys=>$values)
										{
											echo'<strong>'.$values->nidn.'</strong> '.$values->nm_sdm.' ('.$values->sks_subst_tot.' SKS)<br>';
										}
										
									}else{ echo 'n/a'; }
								?>
							</div>
							<div class="col-md-4 mt-1"><strong>Peserta/ Kuota</strong></div>
							<div class="col-md-8 mt-1"><?=$kelas->count_peserta?>/ <?=$kelas->kuota_kelas?> Orang</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-6 mb-3">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
						<div class="row">
							<div class="col-md-4 mt-1"><strong>Jadwal Kuliah</strong></div>
							<div class="col-md-8 mt-1">
							<?php if($kelas->hari_kuliah){ ?>
								<?=nama_hari($kelas->hari_kuliah)?>, <?=$kelas->jam_mulai?> sd <?=$kelas->jam_selesai?><br>
								G. <?=$kelas->nama_gedung?> R. <?=$kelas->nama_ruangan?>
							<?php } ?>
							</div>
							<div class="col-md-4 mt-1"><strong>Jadwal UTS</strong></div>
							<div class="col-md-8 mt-1">
							<?php if($kelas->tgl_uts){ ?>
								<?=tanggal_indo($kelas->tgl_uts)?>, <?=$kelas->jam_mulai_uts?> sd <?=$kelas->jam_selesai_uts?><br>
								G. <?=$kelas->nama_gedung_uts?> R. <?=$kelas->nama_ruangan_uts?>
							<?php } ?>
							</div>
							<div class="col-md-4 mt-1"><strong>Jadwal UAS</strong></div>
							<div class="col-md-8 mt-1">
							<?php if($kelas->tgl_uas){ ?>
								<?=tanggal_indo($kelas->tgl_uas)?>, <?=$kelas->jam_mulai_uas?> sd <?=$kelas->jam_selesai_uas?><br>
								G. <?=$kelas->nama_gedung_uas?> R. <?=$kelas->nama_ruangan_uas?>
							<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-6 mb-3" id="#ujian">
				<div class="card">
					<div class="card-body d-flex flex-column">
						<div class="card-title">
							<h4>Ujian Tengah Semester</h4>
						</div>
<h5 class="mt-2"><a class="text-decoration-none" href="<?=base_url('cetak/ujian/uts/'.$kelas->id_kelas_kuliah)?>" target="_blank">Nilai UTS <i class="psi-printer"></i></a></h5>
<div class="table-responsive">
	<table class="table table-sm">
		<thead>
			<th>NIM</th>
			<th>Nama</th>
			<th>Nilai</th>
		</thead>
		<tbody>
			<?php
			$peserta_uts = $this->Ujian_model->peserta_ujian($kelas->id_kelas_kuliah,'UTS')->result();
			if($peserta_uts){
				foreach($peserta_uts as $key=>$value){
					echo'
					<tr>
						<td>'.$value->id_mahasiswa_pt.'</td>';
						if($value->status_ujian==0){
							echo '<td>'.$value->nm_pd.($value->id_stat_mhs == 'M' ? ' <span class="badge bg-info ms-1">mbkm</span>' : '').'</td>';
						}else{
							echo '<td><a class="text-decoration-none" href="'.base_url('ujian/jawab/uts/'.$value->id_kelas_kuliah.'/'.$value->id_mahasiswa_pt).'">'.$value->nm_pd.($value->id_stat_mhs == 'M' ? ' <span class="badge bg-info ms-1">mbkm</span>' : '').'</a></td>';
						}
						echo'<td>'.$value->nilai_ujian.'</td>
					</tr>
					';
				}
			}else{ echo '<tr><td colspan="3"><em>belum ada peserta!</em></td></tr>'; } 
			?>
		</tbody>
	</table>
</div>
<hr>
<h5 class="mt-2">Riwayat Soal <a href="<?=base_url('cetak/soal_ujian/'.$kelas->id_kelas_kuliah.'/uts')?>" target="_blank" class="text-decoration-none mt-3"> Unduh Template Soal UTS</a></h5>
<div class="table-responsive">
	<table class="table table-sm">
		<thead>
			<th>Soal</th>
			<th>Waktu Unggah</th>
			<th>Aktif</th>
		</thead>
		<tbody>
			<?php
			$soal_uts = $this->Ujian_model->get_soal_ujian($kelas->id_kelas_kuliah,'UTS')->result();
			if($soal_uts){
				foreach($soal_uts as $key=>$value){
				$aktif=($value->status_soal==1)?'Aktif':'Tidak';
					echo'
					<tr>
						<td><a class="text-decoration-none" href="'.$value->dokumen_soal.'" target="_blank">Lihat</a></td>
						<td>'.format_indo($value->update_time).'</td>
						<td>'.$aktif.'</td>
					</tr>
					';
				}
			}else{ echo '<tr><td colspan="3"><em>belum ada soal!</em></td></tr>'; } 
			?>
		</tbody>
	</table>
</div>
<?php if($_SESSION['app_level']==2){ ?>
<hr>
<h5 style="cursor:pointer" onclick="tampilkan('dokumen_soal_uts')">Unggah Soal UTS</h5>
<input id="dokumen_soal_uts" style="display:none" name="dokumen_soal_uts" accept=".pdf" type="file" onchange="simpan_soal('uts')" class="form-control mt-3">
<?php } ?>
					</div>
				</div>
			</div>
			
			<div class="col-md-6 mb-3">
				<div class="card">
					<div class="card-body d-flex flex-column">
						<div class="card-title">
							<h4>Ujian Akhir Semester</h4>
						</div>
<h5 class="mt-2"><a class="text-decoration-none" href="<?=base_url('cetak/ujian/uas/'.$kelas->id_kelas_kuliah)?>" target="_blank">Nilai UAS <i class="psi-printer"></i></a></h5>
<div class="table-responsive">
	<table class="table table-sm">
		<thead>
			<th>NIM</th>
			<th>Nama</th>
			<th>Nilai</th>
		</thead>
		<tbody>
			<?php
			$peserta_uas = $this->Ujian_model->peserta_ujian($kelas->id_kelas_kuliah,'UAS')->result();
			if($peserta_uas){
				foreach($peserta_uas as $key=>$value){
					echo'
					<tr>
						<td>'.$value->id_mahasiswa_pt.'</td>';
						if($value->status_ujian==0){
							echo '<td>'.$value->nm_pd.($value->id_stat_mhs == 'M' ? ' <span class="badge bg-info ms-1">mbkm</span>' : '').'</td>';
						}else{
							echo '<td><a class="text-decoration-none" href="'.base_url('ujian/jawab/uas/'.$value->id_kelas_kuliah.'/'.$value->id_mahasiswa_pt).'">'.$value->nm_pd.($value->id_stat_mhs == 'M' ? ' <span class="badge bg-info ms-1">mbkm</span>' : '').'</a></td>';
						}
						echo'<td>'.$value->nilai_ujian.'</td>
					</tr>
					';
				}
			}else{ echo '<tr><td colspan="3"><em>belum ada peserta!</em></td></tr>'; } 
			?>
		</tbody>
	</table>
</div>
<hr>
<h5 class="mt-2">Riwayat Soal <a href="<?=base_url('cetak/soal_ujian/'.$kelas->id_kelas_kuliah.'/uas')?>" target="_blank" class="text-decoration-none mt-3"> Unduh Template Soal UAS</a></h5>
<div class="table-responsive">
	<table class="table table-sm">
		<thead>
			<th>Soal</th>
			<th>Waktu Unggah</th>
			<th>Aktif</th>
		</thead>
		<tbody>
			<?php
			$soal_uas = $this->Ujian_model->get_soal_ujian($kelas->id_kelas_kuliah,'UAS')->result();
			if($soal_uas){
				foreach($soal_uas as $key=>$value){
				$aktif=($value->status_soal==1)?'Aktif':'Tidak';
					echo'
					<tr>
						<td><a class="text-decoration-none" href="'.$value->dokumen_soal.'" target="_blank">Lihat</a></td>
						<td>'.format_indo($value->update_time).'</td>
						<td>'.$aktif.'</td>
					</tr>
					';
				}
			}else{ echo '<tr><td colspan="3"><em>belum ada soal!</em></td></tr>'; } 
			?>
		</tbody>
	</table>
</div>
<?php if($_SESSION['app_level']==2){ ?>
<hr>
<h5 style="cursor:pointer" onclick="tampilkan('dokumen_soal_uas')">Unggah Soal UAS</h5>
<input id="dokumen_soal_uas" style="display:none" name="dokumen_soal_uas" accept=".pdf" type="file" onchange="simpan_soal('uas')" class="form-control mt-3">
<?php } ?>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>
<script>
function tampilkan(elemen)
{
	document.getElementById(elemen).style.display = 'block';
}
function simpan_soal(jenis_ujian)
	{
		document.getElementById('loading').style.display = 'block';
		var data = new FormData()
		const dokumen_soal = document.getElementById('dokumen_soal_'+jenis_ujian).files[0] ;
		
		data.append('id_kelas_kuliah', '<?=$kelas->id_kelas_kuliah?>');
		data.append('dokumen_soal', dokumen_soal);
		data.append('jenis_ujian', jenis_ujian);
		
		fetch('<?=base_url('ujian/simpan_soal/')?>', {
			method: 'POST',
			body: data
		})
		.then((response) => response.text())
		.then((texts) => {
			if(texts==1){
				Toastify({ text: "Tersimpan",	style: { background: "<?=$_ENV['CLR_SUC']?>",	} }).showToast();
				setTimeout("window.location.reload()",1000);
			}else{
				Toastify({ text: texts,	style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
			}
		})
		.catch(error => {
			console.log(error)
		})  
		document.getElementById('loading').style.display = 'none';
	}
</script>