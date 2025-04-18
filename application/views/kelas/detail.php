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
							<div class="col-md-4 mt-1"><strong>Nama Kelas</strong>
							<?php if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){ ?>
								<a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#modal_nm_kls"><i class="psi-gear"></i></a>
							<?php } ?>
							</div>
							<div class="col-md-8 mt-1"><?=$kelas->nm_mk?> <?=$kelas->nm_kls?></div>
							<div class="col-md-4 mt-1"><strong>Dosen Pengampu</strong></div>
							<div class="col-md-8 mt-1">
								<?php
									$pengampu=$this->Main_model->pengampu_kelas($kelas->id_kelas_kuliah)->result();
									if($pengampu)
									{
										
										foreach($pengampu as $keys=>$values)
										{
											echo'<strong>'.$values->nidn.'</strong> '.$values->nm_sdm.' ('.$values->sks_subst_tot.' SKS) <a href="'.base_url('kelas/ganti_pengampu/'.$values->id_ajar_dosen).'" class="text-decoration-none"><i class="psi-gear"></i></a><br>';
										}
										
									}else{ echo '- <a href="'.base_url('kelas/ganti_pengampu/'.$kelas->id_kelas_kuliah).'" class="text-decoration-none"><i class="psi-gear"></i></a>'; }
								?>
							</div>
							<div class="col-md-4 mt-1"><strong>Peserta/ Kuota</strong>
							<?php if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){ ?>
								<a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#modal_kuota"><i class="psi-gear"></i></a>
							<?php } ?>
							</div>
							<div class="col-md-8 mt-1"><?=$kelas->count_peserta?>/ <?=$kelas->kuota_kelas?> Orang</div>
							<div class="col-md-4 mt-1"><strong>Jadwal Kuliah</strong>
							<?php if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){ ?>
								<a href="<?=base_url('kelas/ganti_jadwal/'.$kelas->id_kelas_kuliah)?>" class="text-decoration-none"><i class="psi-gear"></i></a>
							<?php } ?>
							</div>
							<div class="col-md-8 mt-1">
							<?php if($kelas->hari_kuliah){ ?>
								<?=nama_hari($kelas->hari_kuliah)?>, <?=$kelas->jam_mulai?> sd <?=$kelas->jam_selesai?><br>
								G. <?=$kelas->nama_gedung?> R. <?=$kelas->nama_ruangan?>
							<?php } ?>
							</div>
							<div class="col-md-4 mt-1"><strong>Jadwal UTS</strong>
							<?php if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){ ?>
								<a href="<?=base_url('kelas/ganti_jadwal_ujian/uts/'.$kelas->id_kelas_kuliah)?>" class="text-decoration-none"><i class="psi-gear"></i></a>
							<?php } ?>
							</div>
							<div class="col-md-8 mt-1">
							<?php if($kelas->tgl_uts){ ?>
								<?=tanggal_indo($kelas->tgl_uts)?>, <?=$kelas->jam_mulai_uts?> sd <?=$kelas->jam_selesai_uts?><br>
								G. <?=$kelas->nama_gedung_uts?> R. <?=$kelas->nama_ruangan_uts?>
							<?php } ?>
							</div>
							<div class="col-md-4 mt-1"><strong>Jadwal UAS</strong>
							<?php if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){ ?>
								<a href="<?=base_url('kelas/ganti_jadwal_ujian/uas/'.$kelas->id_kelas_kuliah)?>" class="text-decoration-none"><i class="psi-gear"></i></a>
							<?php } ?>
							</div>
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
							<?php if($_SESSION['app_level']!=1){ ?>
							<div class="col-md-12 mt-1">
								<div class="card bg-primary text-white text-center h-100">
                                    <div class="p-2 text-center">
                                        <div class="display-4"><?=$kelas->skor_persepsi?></div>
                                        <p>Skor EDOM</p>
                                        <small class="lh-1">/100</small>
                                    </div>
                                    <?php if($_SESSION['app_level']==3){ ?>
                                    <div class="d-grid gap-2">
									    <a class="btn btn-info" href="<?=base_url('persepsi/hasil/'.$kelas->id_kelas_kuliah)?>">Hasil EDOM</a>
								    </div>
								    <?php } ?>
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
									<div class="upper">Sikap</div>
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
			<?php
			$krs = $this->Main_model->get_mhs_krs($kelas->id_kelas_kuliah)->result();
			$count_krs = count($krs);
			if($kelas->count_krs != $count_krs) $this->Kelas_model->update_kelas_kuliah($kelas->id_kelas_kuliah,'count_krs',$count_krs);
			?>
			<div class="col-md-6 mb-3">
				<div class="card">
					<div class="card-body d-flex flex-column">
						<div class="card-title">
							<h4>Mahasiswa KRS <?=$count_krs?> Orang</h4>
						</div>
<div class="table-responsive">
	<table class="table table-sm">
		<thead>
			<th>NIM</th>
			<th>Nama</th>
			<th>Status</th>
		</thead>
		<tbody>
			<tr>
			<?php
			$krs = $this->Main_model->get_mhs_krs($kelas->id_kelas_kuliah)->result();
			if($krs)
			{
				foreach($krs as $key=>$values){
				    $status=($values->status_krs==0)?'<span class="text-danger">Belum</span>':'<span class="text-success">Sudah</span>';
					echo'<tr>
						<td>'.$values->id_mahasiswa_pt.'</td>
						<td>'.$values->nm_pd.($values->id_stat_mhs == 'M' ? ' <span class="badge bg-info ms-1">mbkm</span>' : '').'</td>
						<td>'.$status.'</td>
					</tr>';
				}
			}else{
				echo'<tr>
					<td colspan="3"><em>belum ada mahasiswa</em></td>
				</tr>';
			}
			?>	
			</tr>
		</tbody>
	</table>
</div>
					</div>
				</div>
			</div>
			<?php
			$nilai = $this->Main_model->get_mhs_kelas($kelas->id_kelas_kuliah)->result();
			$count_peserta = count($nilai);
			if($kelas->count_peserta != $count_peserta) $this->Kelas_model->update_kelas_kuliah($kelas->id_kelas_kuliah,'count_peserta',$count_peserta);
			?>
			<div class="col-md-6 mb-3">
				<div class="card">
					<div class="card-body d-flex flex-column">
						<div class="card-title">
							<?php if($kelas->id_kat_mk == 5 OR $kelas->id_kat_mk == 3): ?>
							<a onclick="return confirm(`Munculkan menu studi akhir di mahasiswa ?\n\n* Tombol ini hanya digunakan apabila ada mahasiswa yang belum muncul menu studi akhir.`)" href="<?= base_url('kelas/sinkronisasi_studi_akhir/'.$kelas->id_kelas_kuliah) ?>" class="btn btn-xs btn-info float-end"><i class="psi-repeat-2 me-1"></i> Sinkron. Studi Akhir</a>
							<?php endif; ?>

							<h4>Mahasiswa Kelas <?=$count_peserta?> Orang</h4>
						</div>
<div class="table-responsive">
	<table class="table table-sm">
		<thead>
			<th>NIM</th>
			<th>Nama</th>
			<th>Nilai</th>
		</thead>
		<tbody>
		<?php
		
		if($nilai)
		{
			foreach($nilai as $key=>$values){
				echo'<tr>
					<td>'.$values->id_mahasiswa_pt.'</td>
					<td>'.$values->nm_pd.($values->id_stat_mhs == 'M' ? ' <span class="badge bg-info ms-1">mbkm</span>' : '').'</td>
					<td>'.$values->nilai_huruf.'</td>
				</tr>';
			}
		}else{
			echo'<tr>
				<td colspan="3"><em>belum ada mahasiswa</em></td>
			</tr>';
		}
		?>
		</tbody>
	</table>
</div>
					</div>
				</div>
			</div>
			<?php if(($_SESSION['app_level']==3 || $_SESSION['app_level']==4) && $count_krs ==0 && $count_peserta == 0){ ?>
			<div class="col-12 mb-3">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
						<div class="d-grid gap-2">
							<a class="btn btn-danger" onclick="return confirm(`Yakin?`)" href="<?=base_url('kelas/hapus/'.$kelas->id_kelas_kuliah)?>">Hapus Kelas Kuliah</a>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_kuota" tabindex="-1" aria-labelledby="modal_kuota" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ubah Kuota</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" action="<?=base_url('kelas/ganti_kuota/'.$kelas->id_kelas_kuliah)?>">
		
		<div class="modal-body">
			
			<div class="form-floating mb-3">
                <input type="number" id="kuota_kelas" name="kuota_kelas" value="<?=$kelas->kuota_kelas?>" onfocus="this.select()" class="form-control">
                <label for="ket_gedung">Kuota Kelas</label>
            </div>
		</div>
		
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary" type="submit">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal -->

<!-- Modal -->
<div class="modal fade" id="modal_nm_kls" tabindex="-1" aria-labelledby="modal_nm_kls" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ubah Nama Kelas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" action="<?=base_url('kelas/ganti_nm_kls/'.$kelas->id_kelas_kuliah)?>">
		
		<div class="modal-body">
			
			<div class="form-floating mb-3">
			    <input id="nm_kls" name="nm_kls" onfocus="this.select()" value="<?=$kelas->nm_kls?>" maxlength="5" type="text" class="form-control" required>
                <label for="ket_gedung">Nama Kelas</label>
            </div>
		</div>
		
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary" type="submit">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal -->