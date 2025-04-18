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
						<div class="card-title h5">
							Detail Nilai Mahasiswa | <a class="text-decoration-none" target="_blank" href="<?= base_url('cetak/nilai/'.$kelas->id_kelas_kuliah) ?>"><i class="psi-printer"></i> Cetak Nilai</a><?php if($_SESSION['app_level']==2) { ?> | <a class="text-decoration-none" href="<?= base_url('dhmd/pengaturan_sikap/'.$kelas->id_kelas_kuliah) ?>"><i class="psi-gear"></i> Pengaturan Penilaian Aspek Sikap</a> <?php } ?>
						</div>
<div class="table-responsive">
	<table class="table table-sm">
		<thead>
			<th>NIM</th>
			<th>Nama</th>
			<th>Kehadiran</th>
			<th>UTS</th>
			<th>UAS</th>
			<th>Sikap</th>
			<th><?=$kelas->label_a?></th>
			<th><?=$kelas->label_b?></th>
			<th><?=$kelas->label_c?></th>
			<th>Nilai AKhir</th>
			<th>Nilai Mutu</th>
			<th>Aksi</th>
		</thead>
		<tbody>
			<?php 
			$get_nilai = $this->Dhmd_model->get_nilai($kelas->id_kelas_kuliah)->result();
			if($get_nilai){
				foreach($get_nilai as $key=>$value){
				$bayar_uts = $this->Ujian_model->get_status_cetak($kelas->id_smt,'UTS',$value->id_mahasiswa_pt)->row();
				$bayar_uas = $this->Ujian_model->get_status_cetak($kelas->id_smt,'UAS',$value->id_mahasiswa_pt)->row();
				if($bayar_uts){
					$check_uts = '<span class="text-success"><i class="psi-yes"></i> UTS</span>';
				}else{
					$check_uts = '<span class="text-danger"><i class="psi-close"></i> UTS</span>';
				}
				if($bayar_uas){
					$bayar_uas = '';
					$check_uas = '<span class="text-success"><i class="psi-yes"></i> UAS</span>';
				}else{
					$bayar_uas = 'disabled';
					$check_uas = '<span class="text-danger"><i class="psi-close"></i> UAS</span>';
				}
			?>
			<tr>
				<td><?=$value->id_mahasiswa_pt?></td>
				<td><a href="<?=base_url('dhmd/profil_mahasiswa/'.$kelas->id_kelas_kuliah.'/'.$value->id_mahasiswa_pt)?>" class="text-decoration-none"><?=$value->nm_pd.($value->id_stat_mhs == 'M' ? ' <span class="badge bg-info ms-1">mbkm</span>' : '')?> <?=$check_uts?> <?=$check_uas?></a></td>
				<td><input type="number" onfocus="this.select()" class="" id="nilai_hadir<?=$value->id_nilai?>" value="<?=$value->nilai_hadir?>" min="0" max="100" <?=$edit_absen?> <?=$edit_dosen?> <?=$edit_tahun?> <?=$edit_nilai?>></td>
				<td><input type="number" onfocus="this.select()" class="" id="nilai_uts<?=$value->id_nilai?>" value="<?=$value->nilai_uts?>" min="0" max="100" <?=$edit_dosen?> <?=$edit_tahun?> <?=$edit_nilai?>></td>
				<td><input type="number" onfocus="this.select()" class="" id="nilai_uas<?=$value->id_nilai?>" value="<?=$value->nilai_uas?>" min="0" max="100" <?=$edit_dosen?> <?=$edit_tahun?> <?=$edit_nilai?>></td>
				<td><input type="number" onfocus="this.select()" class="" id="nilai_sikap<?=$value->id_nilai?>" value="<?=$value->nilai_sikap?>" min="0" max="100" disabled></td>
				<td><input type="number" onfocus="this.select()" class="" id="nilai_a<?=$value->id_nilai?>" value="<?=$value->nilai_a?>" min="0" max="100" <?=$edit_dosen?> <?=$edit_tahun?> <?=$edit_nilai?>></td>
				<td><input type="number" onfocus="this.select()" class="" id="nilai_b<?=$value->id_nilai?>" value="<?=$value->nilai_b?>" min="0" max="100" <?=$edit_dosen?> <?=$edit_tahun?> <?=$edit_nilai?>></td>
				<td><input type="number" onfocus="this.select()" class="" id="nilai_c<?=$value->id_nilai?>" value="<?=$value->nilai_c?>" min="0" max="100" <?=$edit_dosen?> <?=$edit_tahun?> <?=$edit_nilai?>></td>
				<td>
					<input type="hidden" id="id_mahasiswa_pt<?=$value->id_nilai?>" value="<?=$value->id_mahasiswa_pt?>">
					<input type="hidden" id="nilai_angka<?=$value->id_nilai?>" value="<?=$value->nilai_angka?>">
					<input type="hidden" id="nilai_huruf<?=$value->id_nilai?>" value="<?=$value->nilai_huruf?>">
					<input type="hidden" id="nilai_indeks<?=$value->id_nilai?>" value="<?=$value->nilai_indeks?>">
					<div id="nilai_angka_show<?=$value->id_nilai?>"><?=$value->nilai_angka?></div>
				</td>
				<td><div id="nilai_huruf_show<?=$value->id_nilai?>"><?=$value->nilai_huruf?></div></td>
				<td>
				<?php if($_SESSION['app_level']==2){ ?>
					<div class="btn-group" role="group">
						<button class="btn btn-warning" id="rekap_nilai<?=$value->id_nilai?>" onclick="rekap_nilai('<?=$value->id_nilai?>')" <?=$edit_dosen?> <?=$edit_tahun?> <?=$edit_nilai?> <?=$bayar_uas?>><i class="pli-yes"></i></button>
						<button class="btn btn-info" id="simpan_nilai<?=$value->id_nilai?>" onclick="simpan_nilai('<?=$value->id_nilai?>')" disabled=""><i class="pli-save"></i></button>
					</div>
				<?php } ?>
				</td>
				</td>
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
<?php if($_SESSION['app_level']==2){ ?>
<script>
function rekap_nilai(id_nilai)
{
	
	document.getElementById("simpan_nilai"+id_nilai).removeAttribute("disabled");
	
	var nilai_hadir = parseFloat(document.getElementById("nilai_hadir"+id_nilai).value) * parseFloat(<?=($kelas->bobot_hadir/100)?>);
	var nilai_uts = parseFloat(document.getElementById("nilai_uts"+id_nilai).value) * parseFloat(<?=($kelas->bobot_uts/100)?>);
	var nilai_uas = parseFloat(document.getElementById("nilai_uas"+id_nilai).value) * parseFloat(<?=($kelas->bobot_uas/100)?>);
	var nilai_sikap = parseFloat(document.getElementById("nilai_sikap"+id_nilai).value) * parseFloat(<?=($kelas->bobot_sikap/100)?>);
	var nilai_a = parseFloat(document.getElementById("nilai_a"+id_nilai).value) * parseFloat(<?=($kelas->bobot_a/100)?>);
	var nilai_b = parseFloat(document.getElementById("nilai_b"+id_nilai).value) * parseFloat(<?=($kelas->bobot_b/100)?>);
	var nilai_c = parseFloat(document.getElementById("nilai_c"+id_nilai).value) * parseFloat(<?=($kelas->bobot_c/100)?>);
	
	var nilai_akhir = nilai_hadir + nilai_uts + nilai_uas + nilai_sikap + nilai_a + nilai_b + nilai_c;
	var nilai_huruf;
	var nilai_indeks;
	
	if(nilai_akhir >= <?=$kelas->A?> && nilai_akhir <= 100){
		nilai_indeks = 4;
		nilai_huruf = 'A';
	}else if(nilai_akhir >= <?=$kelas->B?> && nilai_akhir <= <?=$kelas->A?>){
		nilai_indeks = 3;
		nilai_huruf = 'B';
	}else if(nilai_akhir >= <?=$kelas->C?> && nilai_akhir <= <?=$kelas->B?>){
		nilai_indeks = 2;
		nilai_huruf = 'C';
	}else if(nilai_akhir >= <?=$kelas->D?> && nilai_akhir <= <?=$kelas->C?>){
		nilai_indeks = 1;
		nilai_huruf = 'D';
	}else{
		nilai_indeks = 0;
		nilai_huruf = 'E';
	}
	
	document.getElementById("nilai_angka"+id_nilai).value = nilai_akhir.toFixed(2)
	document.getElementById("nilai_angka_show"+id_nilai).innerHTML = nilai_akhir.toFixed(2)
	document.getElementById("nilai_huruf"+id_nilai).value = nilai_huruf
	document.getElementById("nilai_huruf_show"+id_nilai).innerHTML = nilai_huruf
	document.getElementById("nilai_indeks"+id_nilai).value = nilai_indeks
}
function simpan_nilai(id_nilai)
{
	
	document.getElementById("simpan_nilai"+id_nilai).setAttribute("disabled","");
	
	var id_nilai = id_nilai;
	var id_mahasiswa_pt = document.getElementById("id_mahasiswa_pt"+id_nilai).value
	var nilai_hadir = document.getElementById("nilai_hadir"+id_nilai).value
	var nilai_uts = document.getElementById("nilai_uts"+id_nilai).value
	var nilai_uas = document.getElementById("nilai_uas"+id_nilai).value
	var nilai_sikap = document.getElementById("nilai_sikap"+id_nilai).value
	var nilai_a = document.getElementById("nilai_a"+id_nilai).value
	var nilai_b = document.getElementById("nilai_b"+id_nilai).value
	var nilai_c = document.getElementById("nilai_c"+id_nilai).value
	var nilai_angka = document.getElementById("nilai_angka"+id_nilai).value
	var nilai_huruf = document.getElementById("nilai_huruf"+id_nilai).value
	var nilai_indeks = document.getElementById("nilai_indeks"+id_nilai).value
	
	var data = new FormData()
	
	data.append('id_mahasiswa_pt', id_mahasiswa_pt);
	data.append('id_nilai', id_nilai);
	data.append('nilai_hadir', nilai_hadir);
	data.append('nilai_uts', nilai_uts);
	data.append('nilai_uas', nilai_uas);
	data.append('nilai_sikap', nilai_sikap);
	data.append('nilai_a', nilai_a);
	data.append('nilai_b', nilai_b);
	data.append('nilai_c', nilai_c);
	data.append('nilai_angka', nilai_angka);
	data.append('nilai_huruf', nilai_huruf);
	data.append('nilai_indeks', nilai_indeks);
	
	fetch('<?=base_url('dhmd/simpan_nilai/')?>', {
		method: 'POST',
		body: data
	})
	.then((response) => response.text())
	.then((texts) => {
		if(texts==0){
			Toastify({ text: "Gagal!",	style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
		}else{
			Toastify({ text: texts,	style: { background: "<?=$_ENV['CLR_SUC']?>",	} }).showToast();
		}
	})
	.catch(error => {
		console.log(error)
	})  
}
</script>
<?php } ?>