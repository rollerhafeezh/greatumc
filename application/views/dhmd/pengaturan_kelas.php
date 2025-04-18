<?php 
$konfig_pap = $this->Main_model->get_konfigurasi('ubah_pap')->row();
$edit_pap = ($konfig_pap->value_konfigurasi=='on')?'':'disabled';
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
										
									}else{ echo '- '; }
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
								<a href="<?=base_url('kelas/ganti_jadwal/'.$kelas->id_kelas_kuliah)?>" class="text-decoration-none"><i class="psi-rename"></i></a>
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
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
						<div class="card-title">
							
<div class="row">
	<div class="col-md-4 mt-1">
		<div class="d-grid gap-2">
			<div class="btn btn-light" >&Sigma; <?=$kelas->count_pertemuan?> Pertemuan </div>
		</div>
	</div>
	<div class="col-md-4 mt-1">
		<div class="d-grid gap-2">
			<a class="btn btn-info" href="<?=base_url('dhmd/daftar_pertemuan/'.$kelas->id_kelas_kuliah)?>" >Riwayat Pertemuan</a>
		</div>
	</div>
	<div class="col-md-4 mt-1">
		<div class="d-grid gap-2">
			<a class="btn btn-info" href="<?=base_url('dhmd/rps/'.$kelas->id_matkul)?>" >RPS</a>
		</div>
	</div>
	<div class="col-md-4 mt-1">
		<div class="d-grid gap-2">
			<a class="btn btn-info" href="<?=base_url('dhmd/absensi/'.$kelas->id_kelas_kuliah)?>" >Rekap Absensi</a>
		</div>
	</div>
	<div class="col-md-4 mt-1">
		<div class="d-grid gap-2">
			<a class="btn btn-info" href="<?=base_url('ujian/soal/'.$kelas->id_kelas_kuliah)?>" >Ujian</a>
		</div>
	</div>
	<div class="col-md-4 mt-1">
		<div class="d-grid gap-2">
			<a class="btn btn-info" href="<?=base_url('dhmd/nilai/'.$kelas->id_kelas_kuliah)?>" >Nilai</a>
		</div>
	</div>
</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-6 mb-3">
				<div class="card">
					<div class="card-body d-flex flex-column">
						<div class="card-title"><h4 class="mt-2">Persentase Nilai (dalam %)</h4></div>
						<div class="row">
							<div class="col-md-6 mt-1"><strong>Kehadiran</strong></div>
							<div class="col-md-6 mt-1"><input class="form-control" onfocus="this.select()" onchange="hitung_total()" type="number" id="bobot_hadir" value="<?=$kelas->bobot_hadir?>" max="100" min="0"></div>
							<div class="col-md-6 mt-1"><strong>UTS</strong></div>
							<div class="col-md-6 mt-1"><input class="form-control" onfocus="this.select()" onchange="hitung_total()" type="number" id="bobot_uts" value="<?=$kelas->bobot_uts?>" max="100" min="0"></div>
							<div class="col-md-6 mt-1"><strong>UAS</strong></div>
							<div class="col-md-6 mt-1"><input class="form-control" onfocus="this.select()" onchange="hitung_total()" type="number" id="bobot_uas" value="<?=$kelas->bobot_uas?>" max="100" min="0"></div>
							<div class="col-md-6 mt-1"><strong>Sikap</strong></div>
							<div class="col-md-6 mt-1"><input class="form-control" onfocus="this.select()" onchange="hitung_total()" type="number" id="bobot_sikap" value="<?=$kelas->bobot_sikap?>" max="100" min="0"></div>
							<div class="col-md-6 mt-1"><input class="form-control" onfocus="this.select()" type="text" id="label_a" value="<?=$kelas->label_a?>"></div>
							<div class="col-md-6 mt-1"><input class="form-control" onfocus="this.select()" onchange="hitung_total()" type="number" id="bobot_a" value="<?=$kelas->bobot_a?>" max="100" min="0"></div>
							<div class="col-md-6 mt-1"><input class="form-control" onfocus="this.select()" type="text" id="label_b" value="<?=$kelas->label_b?>"></div>
							<div class="col-md-6 mt-1"><input class="form-control" onfocus="this.select()" onchange="hitung_total()" type="number" id="bobot_b" value="<?=$kelas->bobot_b?>" max="100" min="0"></div>
							<div class="col-md-6 mt-1"><input class="form-control" onfocus="this.select()" type="text" id="label_c" value="<?=$kelas->label_c?>"></div>
							<div class="col-md-6 mt-1"><input class="form-control" onfocus="this.select()" onchange="hitung_total()" type="number" id="bobot_c" value="<?=$kelas->bobot_c?>" max="100" min="0"></div>
							<div class="col-md-6 mt-1"><strong>Total</strong></div>
							<div class="col-md-6 mt-1"><div id="total_bobot" class="h3"><?=($kelas->bobot_hadir+$kelas->bobot_uts+$kelas->bobot_uas+$kelas->bobot_a+$kelas->bobot_b+$kelas->bobot_c+$kelas->bobot_sikap)?></div></div>
						</div>
					</div>
					<div class="card-footer text-center">
						<div class="d-grid gap-2">
							<button class="btn btn-info" id="btn_persentase" onclick="simpan_persentase()">Simpan Persentase</button>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-6 mb-3">
				<div class="card">
					<div class="card-body d-flex flex-column">
						<div class="card-title"><h4 class="mt-2">Penilaian Acuan</h4></div>
						<div class="row">
							<div class="col-md-4 mt-1"><strong>A</strong></div>
							<div class="col-md-4 mt-1"><input <?=$edit_pap?> onfocus="this.select()" class="form-control" type="number" onchange="update_min('a')" id="nilai_a" value="<?=$kelas->A?>"></div>
							<div class="col-md-4 mt-1">100</div>
							<div class="col-md-4 mt-1"><strong>B</strong></div>
							<div class="col-md-4 mt-1"><input <?=$edit_pap?> onfocus="this.select()" class="form-control" type="number" onchange="update_min('b')" id="nilai_b" value="<?=$kelas->B?>"></div>
							<div class="col-md-4 mt-1"><input disabled type="number" class="form-control" id="min_a"  value="<?=($kelas->A-1)?>"></div>
							<div class="col-md-4 mt-1"><strong>C</strong></div>
							<div class="col-md-4 mt-1"><input <?=$edit_pap?> onfocus="this.select()" class="form-control" type="number" onchange="update_min('c')" id="nilai_c" value="<?=$kelas->C?>"></div>
							<div class="col-md-4 mt-1"><input disabled type="number" class="form-control" id="min_b" value="<?=($kelas->B-1)?>"></div>
							<div class="col-md-4 mt-1"><strong>D</strong></div>
							<div class="col-md-4 mt-1"><input <?=$edit_pap?> onfocus="this.select()" class="form-control" type="number" onchange="update_min('d')" id="nilai_d" value="<?=$kelas->D?>"></div>
							<div class="col-md-4 mt-1"><input disabled type="number" class="form-control" id="min_c" value="<?=($kelas->C-1)?>"></div>
							<div class="col-md-4 mt-1"><strong>E</strong></div>
							<div class="col-md-4 mt-1">0</div>
							<div class="col-md-4 mt-1"><input disabled type="number" class="form-control" id="min_d" value="<?=($kelas->D-1)?>"></div>
						</div>
					</div>
					<div class="card-footer text-center">
						<div class="d-grid gap-2">
							<button class="btn btn-info" id="btn_persentase" onclick="simpan_pap()" <?=$edit_pap?>>Simpan PAP</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
function update_min(nilai)
{
	var nilai_aktif	= document.getElementById('nilai_'+nilai).value
	var min_nilai 	= document.getElementById('min_'+nilai)
	min_nilai.value = parseInt(nilai_aktif) - 1
}

function hitung_total()
{
	var bobot_hadir = document.getElementById('bobot_hadir').value
	var bobot_uts = document.getElementById('bobot_uts').value
	var bobot_uas = document.getElementById('bobot_uas').value
	var bobot_sikap = document.getElementById('bobot_sikap').value
	var bobot_a = document.getElementById('bobot_a').value
	var bobot_b = document.getElementById('bobot_b').value
	var bobot_c = document.getElementById('bobot_c').value
	var total_bobot = document.getElementById('total_bobot')
	
	var total     = parseInt(bobot_hadir) + parseInt(bobot_uts) + parseInt(bobot_uas) + parseInt(bobot_sikap) + parseInt(bobot_a) + parseInt(bobot_b) + parseInt(bobot_c);
	
	total_bobot.innerHTML = total
	if(total == 100){
		document.getElementById("btn_persentase").removeAttribute("disabled");
	}else{
		document.getElementById("btn_persentase").setAttribute('disabled', '');
	}
}

function simpan_pap()
{
	var data = new FormData()
	
	const a = document.getElementById('nilai_a').value
	const b = document.getElementById('nilai_b').value
	const c = document.getElementById('nilai_c').value
	const d = document.getElementById('nilai_d').value
	
	data.append('id_kelas_kuliah', '<?=$kelas->id_kelas_kuliah?>');
	data.append('A', a);
	data.append('B', b);
	data.append('C', c);
	data.append('D', d);
	
	simpan_data(data)
}

function simpan_persentase()
{
	var data = new FormData()
	const bobot_hadir = document.getElementById('bobot_hadir').value
	const bobot_uts = document.getElementById('bobot_uts').value
	const bobot_uas = document.getElementById('bobot_uas').value
	const bobot_sikap = document.getElementById('bobot_sikap').value
	const bobot_a = document.getElementById('bobot_a').value
	const bobot_b = document.getElementById('bobot_b').value
	const bobot_c = document.getElementById('bobot_c').value
	const label_a = document.getElementById('label_a').value
	const label_b = document.getElementById('label_b').value
	const label_c = document.getElementById('label_c').value
	
	data.append('id_kelas_kuliah', '<?=$kelas->id_kelas_kuliah?>');
	data.append('bobot_hadir', bobot_hadir);
	data.append('bobot_uts', bobot_uts);
	data.append('bobot_uas', bobot_uas);
	data.append('bobot_sikap', bobot_sikap);
	data.append('bobot_a', bobot_a);
	data.append('bobot_b', bobot_b);
	data.append('bobot_c', bobot_c);
	data.append('label_a', label_a);
	data.append('label_b', label_b);
	data.append('label_c', label_c);
	
	simpan_data(data)
}

function simpan_data(data)
{
	fetch('<?=base_url('dhmd/simpan_persentase/')?>', {
		method: 'POST',
		body: data
	})
	.then((response) => response.text())
	.then((text) => {
		if(text==0){
			Toastify({ text: "Gatot!",	style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
		}else{
			Toastify({ text: "Tersimpan",	style: { background: "<?=$_ENV['CLR_SUC']?>",	} }).showToast();
		}
	})
	.catch(error => {
		console.log(error)
	})  
}
</script>
