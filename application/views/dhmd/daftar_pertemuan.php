<?php
$mulai_pbm = $this->Main_model->get_konfigurasi('mulai_pbm')->row();
$hari_ini 	= date("N");
$tanggal_sekarang	= date('Y-m-d'); 
$jam_sekarang	= date("H:i:s");
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
							<?php if($kelas->tgl_uts){ 
							if($_SESSION['app_level']==1){ ?>
								<a href="<?=base_url('ujian/jawab/uts/'.$kelas->id_kelas_kuliah.'/'.$_SESSION['id_user'])?>" class="text-decoration-none">
								<?=tanggal_indo($kelas->tgl_uts)?><br><?=$kelas->jam_mulai_uts?> sd <?=$kelas->jam_selesai_uts?><br>
								G. <?=$kelas->nama_gedung_uts?> R. <?=$kelas->nama_ruangan_uts?>
								</a>
							<?php }else{ ?>
								<?=tanggal_indo($kelas->tgl_uts)?><br><?=$kelas->jam_mulai_uts?> sd <?=$kelas->jam_selesai_uts?><br>
								G. <?=$kelas->nama_gedung_uts?> R. <?=$kelas->nama_ruangan_uts?>
							<?php } } ?>
							</div>
							<div class="col-md-4 mt-1"><strong>Jadwal UAS</strong></div>
							<div class="col-md-8 mt-1">
							<?php if($kelas->tgl_uas){ 
							if($_SESSION['app_level']==1){ ?>
								<a href="<?=base_url('ujian/jawab/uas/'.$kelas->id_kelas_kuliah.'/'.$_SESSION['id_user'])?>" class="text-decoration-none">
								<?=tanggal_indo($kelas->tgl_uas)?><br><?=$kelas->jam_mulai_uas?> sd <?=$kelas->jam_selesai_uas?><br>
								G. <?=$kelas->nama_gedung_uas?> R. <?=$kelas->nama_ruangan_uas?>
								</a>
							<?php }else{ ?>
									<?=tanggal_indo($kelas->tgl_uas)?><br><?=$kelas->jam_mulai_uas?> sd <?=$kelas->jam_selesai_uas?><br>
								G. <?=$kelas->nama_gedung_uas?> R. <?=$kelas->nama_ruangan_uas?>
							<?php } } ?>
							</div>
						</div>
						
					</div>
						<?php if($_SESSION['app_level']==2){ 
						if($kelas->hari_kuliah == $hari_ini && $mulai_pbm->value_konfigurasi=='on'){
						?>
					<div class="card-footer">
						<div class="d-grid gap-2 mt-2">
							<a class="btn btn-info" href="<?=base_url('dhmd/mulai_kelas/'.$kelas->id_kelas_kuliah.'/kuliah')?>"> Mulai Kelas </a>
						</div>
					</div>
						<?php } } ?>
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
							<?php if($_SESSION['app_level']==1) {?>
							<div class="card-footer">
								<div class="d-grid gap-2 mt-2">
									<a class="btn btn-info" href="<?=base_url('dhmd/profil_mahasiswa/'.$kelas->id_kelas_kuliah.'/'.$_SESSION['id_user'])?>"> Lihat Raport </a>
								</div>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
				
		<div class="row">
			<div class="col mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
						<div class="card-title">
							<div class="h5">Riwayat Pertemuan</div>
						</div>
		
<div class="row">
<!--START CARD PERTEMUAN -->
	<?php
	$pertemuan = $this->Dhmd_model->get_pertemuan($kelas->id_kelas_kuliah)->result();
	if($pertemuan){
	$count_pertemuan=count($pertemuan);
	if($count_pertemuan != $kelas->count_pertemuan) $this->Dhmd_model->update_kelas($kelas->id_kelas_kuliah,'count_pertemuan',$count_pertemuan);
		foreach($pertemuan as $key=>$value){
	$warna_border=($value->tanggal == $tanggal_sekarang)?'primary':'light';
	$img_cover = ($value->foto)?:base_url('assets/images/umc.jpg');
	?>
	<div class="col-md-3 mb-4">
		<div class="card h-100 border-<?=$warna_border?>">
			<img src="<?= $img_cover ?>" class="card-img-top" alt="...">
			<div class="card-body d-flex flex-column">
				<h5 class="card-title">Pertemuan ke #<?=$count_pertemuan?></h5>
			
				<div class="table-responsive">
					<table class="table table-sm">
						<tbody>
							<tr>
								<td><strong>Hari</strong></td>
								<td>:</td>
								<td><?=nama_hari($value->hari)?></td>
							</tr>
							<tr>
								<td><strong>Tanggal</strong></td>
								<td>:</td>
								<td><?=tanggal_indo($value->tanggal)?></td>
							</tr>
							<tr>
								<td><strong>Jenis Pertemuan</strong></td>
								<td>:</td>
								<td><?=strtoupper($value->tipe_kuliah)?></td>
							</tr>
							<tr>
								<td><strong>Jam Mulai</strong></td>
								<td>:</td>
								<td><?=$value->jam_mulai?></td>
							</tr>
							<tr>
								<td><strong>Jam Selesai</strong></td>
								<td>:</td>
								<td><?=$value->jam_selesai?></td>
							</tr>
							<tr>
								<td><strong>Ringkasan</strong></td>
								<td>:</td>
								<td><?=$value->materi?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="card-footer text-center"><a href="<?= base_url('dhmd/detail_pertemuan/'.$value->id_bap_kuliah	) ?>" class="btn btn-primary">Detail Pertemuan</a></div>
		</div>
	</div>
	<?php 
	$count_pertemuan--;
		}
	}else{
		echo '<em>Belum ada Pertemuan</em>';
	}
	?>
<!--END CARD PERTEMUAN -->
</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
