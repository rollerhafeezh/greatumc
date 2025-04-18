<?php
$konfig_tahun = $this->Main_model->get_konfigurasi('input_nilai_beda_smt')->row();
$konfig_nilai = $this->Main_model->get_konfigurasi('input_nilai')->row();
$konfig_absen = $this->Main_model->get_konfigurasi('ubah_absensi')->row();

if($kelas->id_smt != $_SESSION['active_smt']){
	$edit_tahun = ($konfig_tahun->value_konfigurasi=='on')?'':'disabled';
}else{
	$edit_tahun = '';
}
$edit_nilai = ($konfig_nilai->value_konfigurasi=='on')?'':'disabled';
$edit_absen = ($konfig_absen->value_konfigurasi=='on')?'':'disabled';
$edit_dosen = ($_SESSION['app_level']==2)?'':'disabled';

?>

<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		
			<div class="col-md-6 mb-3">
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
										
									}else{ echo '-'; }
								?>
							</div>
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
								<?=tanggal_indo($kelas->tgl_uts)?><br><?=$kelas->jam_mulai_uts?> sd <?=$kelas->jam_selesai_uts?><br>
								G. <?=$kelas->nama_gedung_uts?> R. <?=$kelas->nama_ruangan_uts?>
							<?php } ?>
							</div>
							<div class="col-md-4 mt-1"><strong>Jadwal UAS</strong></div>
							<div class="col-md-8 mt-1">
							<?php if($kelas->tgl_uas){ ?>
								<?=tanggal_indo($kelas->tgl_uas)?><br><?=$kelas->jam_mulai_uas?> sd <?=$kelas->jam_selesai_uas?><br>
								G. <?=$kelas->nama_gedung_uas?> R. <?=$kelas->nama_ruangan_uas?>
							<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 mb-3">
				<div class="card mt-2">
					<div class="card-body d-flex flex-column">
						<div class="row">
							<div class="col-md-4 mt-1">
								<div class="d-grid gap-2">
									<div class="btn btn-light" >&Sigma; <?=$kelas->count_pertemuan?> Pertemuan </div>
								</div>
							</div>
							<div class="col-md-4 mt-1">
								<div class="d-grid gap-2">
									<a class="btn btn-info" href="<?=base_url('dhmd/daftar_pertemuan/'.$kelas->id_kelas_kuliah)?>">Riwayat Pertemuan</a>
								</div>
							</div>
							<div class="col-md-4 mt-1">
								<div class="d-grid gap-2">
									<a class="btn btn-info" href="<?=base_url('dhmd/rps/'.$kelas->id_matkul)?>">RPS</a>
								</div>
							</div>
							<?php if($_SESSION['app_level']!=1){ ?>
							<div class="col-md-4 mt-1">
								<div class="d-grid gap-2">
									<a class="btn btn-info" href="<?=base_url('dhmd/absensi/'.$kelas->id_kelas_kuliah)?>">Rekap Absensi</a>
								</div>
							</div>
							<div class="col-md-4 mt-1">
								<div class="d-grid gap-2">
									<a class="btn btn-info" href="<?=base_url('ujian/soal/'.$kelas->id_kelas_kuliah)?>">Ujian</a>
								</div>
							</div>
							<div class="col-md-4 mt-1">
								<div class="d-grid gap-2">
									<a class="btn btn-info" href="<?=base_url('dhmd/nilai/'.$kelas->id_kelas_kuliah)?>">Nilai</a>
								</div>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 mt-2">
						<div class="card h-100">
							<div class="card-body d-flex flex-column">
								<div class="card-title">
								<?php if($_SESSION['app_level']==2){ ?>
								<h5 class=""><a href="<?=base_url('dhmd/pengaturan_kelas/'.$kelas->id_kelas_kuliah)?>" class="text-decoration-none">Atur Persentase Nilai</a></h5>
								<?php }else{ ?>
								<h5 class="">Persentase Nilai</h5>
								<?php } ?>
								</div>
								<div class="card-text row">
									<div class="col-md-6">
									<div class="upper">Kehadiran</div>
									</div>
									<div class="col-md-6">
									<h5><b><span class="count persentase"><?=$kelas->bobot_hadir?></span>%</b></h5>
									</div>
									<div class="col-md-6">
									<div class="upper">UTS</div>
									</div>
									<div class="col-md-6">
									<h5><b><span class="count persentase"><?=$kelas->bobot_uts?></span>%</b></h5>
									</div>
									<div class="col-md-6">
									<div class="upper">UAS</div>
									</div>
									<div class="col-md-6">
									<h5><b><span class="count persentase"><?=$kelas->bobot_uas?></span>%</b></h5>
									</div>
									<div class="col-md-6">
									<div class="upper">
									<?php if($_SESSION['app_level']==2){ ?>
									<a href="<?=base_url('dhmd/pengaturan_sikap/'.$kelas->id_kelas_kuliah)?>" class="text-decoration-none">Atur Sikap</a>
									<?php }else{ ?>
									Sikap
									<?php } ?>
									</div>
									</div>
									<div class="col-md-6">
									<h5><b><span class="count persentase"><?=$kelas->bobot_sikap?></span>%</b></h5>
									</div>
									<div class="col-md-6">
									<div class="upper"><?=$kelas->label_a?></div>
									</div>
									<div class="col-md-6">
									<h5><b><span class="count persentase"><?=$kelas->bobot_a?></span>%</b></h5>
									</div>
									<div class="col-md-6">
									<div class="upper"><?=$kelas->label_b?></div>
									</div>
									<div class="col-md-6">
									<h5><b><span class="count persentase"><?=$kelas->bobot_b?></span>%</b></h5>
									</div>
									<div class="col-md-6">
									<div class="upper"><?=$kelas->label_c?></div>
									</div>
									<div class="col-md-6">
									<h5><b><span class="count persentase"><?=$kelas->bobot_c?></span>%</b></h5>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6 mt-2">
						<div class="card h-100">
							<div class="card-body d-flex flex-column">
								<div class="card-title">
									<?php if($_SESSION['app_level']==2){ ?>
									<h5 class=""><a href="<?=base_url('dhmd/pengaturan_kelas/'.$kelas->id_kelas_kuliah)?>" class="text-decoration-none">Atur Penilaian Acuan</a></h5>
									<?php }else{ ?>
									<h5 class="">Penilaian Acuan</h5>
									<?php } ?>
								</div>
								<div class="card-text row">
									<div class="col-md-6 col-6">
										<div class="upper">A</div>
									</div>
									<div class="col-md-6 col-6">
										<h5><b><span class="count persentase"><?=$kelas->A?> > </span></b></h5>
									</div>
									<div class="col-md-6 col-6">
										<div class="upper">B</div>
									</div>
									<div class="col-md-6 col-6">
										<h5><b><span class="count persentase"><?=$kelas->B?> > </span></b></h5>
									</div>
									<div class="col-md-6 col-6">
										<div class="upper">C</div>
									</div>
									<div class="col-md-6 col-6">
										<h5><b><span class="count persentase"><?=$kelas->C?> > </span></b></h5>
									</div>
									<div class="col-md-6 col-6">
										<div class="upper">D</div>
									</div>
									<div class="col-md-6 col-6">
										<h5><b><span class="count persentase"><?=$kelas->D?> > </span></b></h5>
									</div>
									<div class="col-md-6 col-6">
										<div class="upper">E</div>
									</div>
									<div class="col-md-6 col-6">
										<h5><b><span class="count persentase"><?=$kelas->E?> > </span></b></h5>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		
		<div class="row">
			<div class="col-12 mb-3">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
						<div class="card-title">
							<h4>Detail Absensi Mahasiswa | <a class="text-decoration-none" target="_blank" href="<?= base_url('cetak/absen/'.$kelas->id_kelas_kuliah) ?>"><i class="psi-printer"></i> Cetak</a></h4>
						</div>
<div class="table-responsive">
	<table class="table table-sm">
		<thead>
			<th>NIM</th>
			<th>Nama</th>
			<th width="auto">
				Pertemuan
				<br>
				<span class="badge bg-success">Hadir</span> <span class="badge bg-danger">Alfa</span> <span class="badge bg-warning">Sakit</span> <span class="badge bg-info">Izin</span> 
            </th>
			<th>Kehadiran</th>
		</thead>
		<tbody>
		<?php 
		$get_nilai = $this->Dhmd_model->get_nilai($kelas->id_kelas_kuliah)->result();
		if($get_nilai){
			foreach($get_nilai as $key=>$value){
			$absen = json_decode($value->kehadiran);
		?>
			<tr>
				<td><?=$value->id_mahasiswa_pt?></td>
				<td><?=$value->nm_pd.($value->id_stat_mhs == 'M' ? ' <span class="badge bg-info ms-1">mbkm</span>' : '')?></td>
				<td>
				<?php
					$pertemuan=1;
					$kehadiran=0;
					$count_pertemuan = ($kelas->count_pertemuan!=0)?$kelas->count_pertemuan:1;
					for($i=0; $i<$kelas->count_pertemuan; $i++)
					{
						if($absen){
							if(!empty($absen[$i])){
								if($absen[$i]==1){
									echo '<div class="badge bg-success"><i class="pli-yes d-none d-print-block"></i>'.$pertemuan.'</div>';
									$kehadiran++;
								}else if($absen[$i]==2){
									echo '<div class="badge bg-warning"><i class="pli-yes d-none d-print-block"></i>'.$pertemuan.'</div>';
									$kehadiran++;
								}else if($absen[$i]==3){
									echo '<div class="badge bg-info"><i class="pli-yes d-none d-print-block"></i>'.$pertemuan.'</div>';
									$kehadiran++;
								}else{
									echo '<div class="badge bg-danger"><i class="pli-close d-none d-print-block"></i>'.$pertemuan.'</div>';
								}
							}else{
								echo '<div class="badge bg-danger"><i class="pli-close d-none d-print-block"></i>'.$pertemuan.'</div>';
							} 
						}else{
							echo '<div class="badge bg-danger"><i class="pli-close d-none d-print-block"></i>'.$pertemuan.'</div>';
						}
						$pertemuan++;
					}
				?>
				</td>
				<td> <?=$kehadiran?> Pertemuan (<?php echo  number_format((($kehadiran/$count_pertemuan)*100),2,'.',','); ?>) %</td>
				
			</tr>
		<?php
			} } ?>
		</tbody>
	</table>
</div>
					</div>
				</div>
			</div>
		</div>	
		</div>
	</div>
</div>
