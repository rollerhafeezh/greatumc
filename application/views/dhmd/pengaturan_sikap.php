<?php
$sikap = $this->Dhmd_model->get_sikap($kelas->id_kelas_kuliah)->row();
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
						<div class="card-title"><h4 class="mt-2">Penilaian Aspek Sikap (dalam %)</h4></div>
						<div class="row">
							<div class="col-md-6 mt-1"><strong>Disipin</strong></div>
							<div class="col-md-6 mt-1"><input class="form-control" onfocus="this.select()" onchange="hitung_total()" type="number" id="bobot_disiplin" value="<?=$sikap->bobot_disiplin?>" max="100" min="0"></div>
							<div class="col-md-6 mt-1"><strong>Tanggung Jawab</strong></div>
							<div class="col-md-6 mt-1"><input class="form-control" onfocus="this.select()" onchange="hitung_total()" type="number" id="bobot_jawab" value="<?=$sikap->bobot_jawab?>" max="100" min="0"></div>
							<div class="col-md-6 mt-1"><strong>Kreatif</strong></div>
							<div class="col-md-6 mt-1"><input class="form-control" onfocus="this.select()" onchange="hitung_total()" type="number" id="bobot_kreatif" value="<?=$sikap->bobot_kreatif?>" max="100" min="0"></div>
							<div class="col-md-6 mt-1"><input class="form-control" onfocus="this.select()" type="text" id="label_a" value="<?=$sikap->label_a?>"></div>
							<div class="col-md-6 mt-1"><input class="form-control" onfocus="this.select()" onchange="hitung_total()" type="number" id="bobot_a" value="<?=$sikap->bobot_a?>" max="100" min="0"></div>
							<div class="col-md-6 mt-1"><input class="form-control" onfocus="this.select()" type="text" id="label_b" value="<?=$sikap->label_b?>"></div>
							<div class="col-md-6 mt-1"><input class="form-control" onfocus="this.select()" onchange="hitung_total()" type="number" id="bobot_b" value="<?=$sikap->bobot_b?>" max="100" min="0"></div>
							<div class="col-md-6 mt-1"><input class="form-control" onfocus="this.select()" type="text" id="label_c" value="<?=$sikap->label_c?>"></div>
							<div class="col-md-6 mt-1"><input class="form-control" onfocus="this.select()" onchange="hitung_total()" type="number" id="bobot_c" value="<?=$sikap->bobot_c?>" max="100" min="0"></div>
							<div class="col-md-6 mt-1"><input class="form-control" onfocus="this.select()" type="text" id="label_d" value="<?=$sikap->label_d?>"></div>
							<div class="col-md-6 mt-1"><input class="form-control" onfocus="this.select()" onchange="hitung_total()" type="number" id="bobot_d" value="<?=$sikap->bobot_d?>" max="100" min="0"></div>
							<div class="col-md-6 mt-1"><strong>Total</strong></div>
							<div class="col-md-6 mt-1"><div id="total_bobot" class="h3"><?=($sikap->bobot_disiplin+$sikap->bobot_jawab+$sikap->bobot_kreatif+$sikap->bobot_a+$sikap->bobot_b+$sikap->bobot_c+$sikap->bobot_d)?></div></div>
						</div>
					</div>
					<div class="card-footer text-center">
						<div class="d-grid gap-2">
							<button class="btn btn-info" id="btn_persentase" onclick="simpan_persentase()">Simpan Persentase</button>
						</div>
						<small><em>Peraturan Menteri Pendidikan dan Kebudayaan Nomor 3 Tahun 2020 tentang Standar Nasional Pendidikan Tinggi</em></small>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
function hitung_total()
{
	var bobot_jawab = document.getElementById('bobot_jawab').value
	var bobot_disiplin = document.getElementById('bobot_disiplin').value
	var bobot_kreatif = document.getElementById('bobot_kreatif').value
	var bobot_a = document.getElementById('bobot_a').value
	var bobot_b = document.getElementById('bobot_b').value
	var bobot_c = document.getElementById('bobot_c').value
	var bobot_d = document.getElementById('bobot_d').value
	var total_bobot = document.getElementById('total_bobot')
	
	var total     = parseInt(bobot_jawab) + parseInt(bobot_disiplin) + parseInt(bobot_kreatif) + parseInt(bobot_a) + parseInt(bobot_b) + parseInt(bobot_c) + parseInt(bobot_d);
	
	total_bobot.innerHTML = total
	if(total == 100){
		document.getElementById("btn_persentase").removeAttribute("disabled");
	}else{
		document.getElementById("btn_persentase").setAttribute('disabled', '');
	}
}

function simpan_persentase()
{
	var data = new FormData()
	const bobot_jawab = document.getElementById('bobot_jawab').value
	const bobot_disiplin = document.getElementById('bobot_disiplin').value
	const bobot_kreatif = document.getElementById('bobot_kreatif').value
	const bobot_a = document.getElementById('bobot_a').value
	const bobot_b = document.getElementById('bobot_b').value
	const bobot_c = document.getElementById('bobot_c').value
	const bobot_d = document.getElementById('bobot_d').value
	const label_a = document.getElementById('label_a').value
	const label_b = document.getElementById('label_b').value
	const label_d = document.getElementById('label_d').value
	const label_c = document.getElementById('label_c').value
	
	data.append('id_kelas_kuliah', '<?=$kelas->id_kelas_kuliah?>');
	data.append('bobot_disiplin', bobot_disiplin);
	data.append('bobot_jawab', bobot_jawab);
	data.append('bobot_kreatif', bobot_kreatif);
	data.append('bobot_a', bobot_a);
	data.append('bobot_b', bobot_b);
	data.append('bobot_c', bobot_c);
	data.append('bobot_d', bobot_d);
	data.append('label_a', label_a);
	data.append('label_b', label_b);
	data.append('label_c', label_c);
	data.append('label_d', label_d);
	
	simpan_data(data)
}

function simpan_data(data)
{
	fetch('<?=base_url('dhmd/simpan_sikap/')?>', {
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
