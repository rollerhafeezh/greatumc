<?php
$edit_dosen = ($_SESSION['app_level']==2)?'':'disabled';
$bayar_uts = $this->Ujian_model->get_status_cetak($kelas->id_smt,'UTS',$mahasiswa_pt->id_mahasiswa_pt)->row();
$bayar_uas = $this->Ujian_model->get_status_cetak($kelas->id_smt,'UAS',$mahasiswa_pt->id_mahasiswa_pt)->row();
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
<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		
			<div class="col-md-6 mb-3">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
						<h5>Detail Kelas </h5>
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
						</div>
						<h5 class="mt-2">Detail Mahasiswa</h5>
						<div class="row">
							<div class="col-md-4 mt-1"><strong>NIM</strong></div>
							<div class="col-md-8 mt-1"><?=$mahasiswa_pt->id_mahasiswa_pt?></div>
							<div class="col-md-4 mt-1"><strong>Nama Mahasiswa</strong></div>
							<div class="col-md-8 mt-1"><?=$mahasiswa_pt->nm_pd?></div>
							<div class="col-md-4 mt-1"><strong>Email</strong></div>
							<div class="col-md-8 mt-1"><?=$mahasiswa_pt->email?></div>
							<div class="col-md-4 mt-1"><strong>Nomor Handphone</strong></div>
							<div class="col-md-8 mt-1"><?=$mahasiswa_pt->no_hp?></div>
							<div class="col-md-4 mt-1"><strong>Status Bayar UTS</strong></div>
							<div class="col-md-8 mt-1"><?=$check_uts?></div>
							<div class="col-md-4 mt-1"><strong>Status Bayar UAS</strong></div>
							<div class="col-md-8 mt-1"><?=$check_uas?></div>
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
			
			<div class="col-md-4 mb-3">
				<div class="card h-100">
					<div class="card-body">
						<div class="card-title"><h5>Statistik Kehadiran</h5></div>
<div class="table-responsive">
<table class="table">
	<thead>
		<th width="5%">Pertemuan Ke #</th>
		<th>Tanggal</th>
		<th>Status</th>
		<th>Nilai</th>
	</thead>
	</tbody>
<?php
$bap_pertemuan = $this->Dhmd_model->get_pertemuan_mahasiswa($mahasiswa_pt->id_mahasiswa_pt,$kelas->id_kelas_kuliah)->result();
$co=1;
$absen = array();
$total_pertemuan = count($bap_pertemuan);
$total_hadir = 0;
$rata_rata = 0;
$total_bagi=0;
foreach($bap_pertemuan as $key=>$value)
{
	$warna = ($value->status_hadir==1)?'text-info':'text-danger';
	if($value->status_hadir!=0) $total_hadir +=1;
	$absen [] = $value->status_hadir;
	echo'
	<tr class="'.$warna.'">
		<td>'.$co.'</td>
		<td>'.tanggal_indo($value->tanggal).'</td>
		<td>'.status_hadir($value->status_hadir).'</td>
		<td>'.$value->nilai.'</td>
	</tr>
	';
	$rata_rata += $value->nilai;
	if($value->nilai!=0) $total_bagi++;
	$co++;
}
$persen_hadir = ($total_hadir != 0)?(($total_hadir / $total_pertemuan) * 100):0;
$persen_min = $this->Main_model->get_konfigurasi('min_absen')->row()->value_konfigurasi;
$rata_hari = ($rata_rata != 0)?($rata_rata/$total_bagi):0;
?>
	</tbody>
	<tfoot>
		<th colspan="2" align="center">Kehadiran <?=$total_hadir?> / <?=$total_pertemuan?> (<?=number_format($persen_hadir,2,',','.')?> %)</th>
		<th>Rata-rata</th>
		<th><?=$rata_hari?></th>
	</tfoot>
</table>
</div>

<?php
	$this->Dhmd_model->update_nilai_mahasiswa($mahasiswa_pt->id_mahasiswa_pt,$kelas->id_kelas_kuliah,'kehadiran',json_encode($absen));
	$this->Dhmd_model->update_nilai_mahasiswa($mahasiswa_pt->id_mahasiswa_pt,$kelas->id_kelas_kuliah,'nilai_hadir',$persen_hadir);
?>
					</div>
					<div class="card-footer"><small>kehadiran minimal untuk dapat mengikuti ujian adalah : <?=$persen_min?> % </small></div>
				</div>
			</div>
			
			<div class="col-md-4 mb-3">
				<div class="card h-100">
					<div class="card-body">
						<div class="card-title"><h5>Penilaian Aspek Sikap</h5></div>
<?php
	$get_sikap 		 = $this->Dhmd_model->get_sikap($kelas->id_kelas_kuliah)->row();
	$get_nilai_sikap = $this->Dhmd_model->get_nilai_sikap($kelas->id_kelas_kuliah,$mahasiswa_pt->id_mahasiswa_pt)->row();
	$nilai_sikap_akhir = 
		($get_nilai_sikap->nilai_a * ($get_sikap->bobot_disiplin / 100)) +
		($get_nilai_sikap->nilai_b * ($get_sikap->bobot_jawab / 100)) +
		($get_nilai_sikap->nilai_c * ($get_sikap->bobot_kreatif / 100)) +
		($get_nilai_sikap->nilai_d * ($get_sikap->bobot_a / 100)) +
		($get_nilai_sikap->nilai_e * ($get_sikap->bobot_b / 100)) +
		($get_nilai_sikap->nilai_f * ($get_sikap->bobot_c / 100));
		($get_nilai_sikap->nilai_g * ($get_sikap->bobot_d / 100));
	$nilai_sikap_akhir = number_format($nilai_sikap_akhir,2,'.',',');
?>
<div class="table-responsive">
<table class="table">
	<thead>
		<th>Aspek Sikap</th>
		<th>Bobot</th>
		<th>Nilai</th>
	</thead>
	</tbody>
		<tr>
			<td>Disipin</td>
			<td><?=$get_sikap->bobot_disiplin?> %</td>
			<td>
				<input type="number" onfocus="this.select()" class="" id="nilai_sikap_a<?=$get_nilai_sikap->id_nilai_sikap?>" value="<?=$get_nilai_sikap->nilai_a?>" min="0" max="100" <?=$edit_dosen?>>
			</td>
		</tr>
		<tr>
			<td>Tanggung Jawab</td>
			<td><?=$get_sikap->bobot_jawab?> %</td>
			<td>
				<input type="number" onfocus="this.select()" class="" id="nilai_sikap_b<?=$get_nilai_sikap->id_nilai_sikap?>" value="<?=$get_nilai_sikap->nilai_b?>" min="0" max="100" <?=$edit_dosen?>>
			</td>
		</tr>
		<tr>
			<td>Kreatif</td>
			<td><?=$get_sikap->bobot_kreatif?> %</td>
			<td>
				<input type="number" onfocus="this.select()" class="" id="nilai_sikap_c<?=$get_nilai_sikap->id_nilai_sikap?>" value="<?=$get_nilai_sikap->nilai_c?>" min="0" max="100" <?=$edit_dosen?>>
			</td>
		</tr>
		<tr>
			<td><?=$get_sikap->label_a?></td>
			<td><?=$get_sikap->bobot_a?> %</td>
			<td>
				<input type="number" onfocus="this.select()" class="" id="nilai_sikap_d<?=$get_nilai_sikap->id_nilai_sikap?>" value="<?=$get_nilai_sikap->nilai_d?>" min="0" max="100" <?=$edit_dosen?>>
			</td>
		</tr>
		<tr>
			<td><?=$get_sikap->label_b?></td>
			<td><?=$get_sikap->bobot_b?> %</td>
			<td>
				<input type="number" onfocus="this.select()" class="" id="nilai_sikap_e<?=$get_nilai_sikap->id_nilai_sikap?>" value="<?=$get_nilai_sikap->nilai_e?>" min="0" max="100" <?=$edit_dosen?>>
			</td>
		</tr>
		<tr>
			<td><?=$get_sikap->label_c?></td>
			<td><?=$get_sikap->bobot_c?> %</td>
			<td>
				<input type="number" onfocus="this.select()" class="" id="nilai_sikap_f<?=$get_nilai_sikap->id_nilai_sikap?>" value="<?=$get_nilai_sikap->nilai_f?>" min="0" max="100" <?=$edit_dosen?>>
				<input type="hidden" value="<?=$nilai_sikap_akhir?>" id="nilai_sikap_akhir">
			</td>
		</tr>
		<tr>
			<td><?=$get_sikap->label_d?></td>
			<td><?=$get_sikap->bobot_d?> %</td>
			<td>
				<input type="number" onfocus="this.select()" class="" id="nilai_sikap_g<?=$get_nilai_sikap->id_nilai_sikap?>" value="<?=$get_nilai_sikap->nilai_g?>" min="0" max="100" <?=$edit_dosen?>>
			</td>
		</tr>
	</tbody>
	<tfoot>
		<th colspan="2">Nilai Sikap</th>
		<th><div id="nilai_sikap_akhir_show"><?=$nilai_sikap_akhir?></div></th>
	</tfoot>
</table>
</div>
<?php if($_SESSION['app_level']==2) { ?>

	<div class="row">
		<div class="col-6 mt-1">
			<div class="d-grid gap-2">
				<button class="btn btn-warning" onclick="hitung_nilai_sikap_akhir('<?=$get_nilai_sikap->id_nilai_sikap?>')" <?=$bayar_uas?>><i class="pli-yes"></i> Hitung</button>
			</div>
		</div>
		<div class="col-6 mt-1">
			<div class="d-grid gap-2">
				<button disabled class="btn btn-info" onclick="simpan_nilai_sikap_akhir('<?=$get_nilai_sikap->id_nilai_sikap?>')" id="simpan_nilai_sikap_akhir"><i class="pli-save"></i> Simpan</button>
			</div>
		</div>
	</div>

<?php } ?>
</div>

				</div>
			</div>
			
			<div class="col-md-4 mb-3">
				<div class="card h-100">
					<div class="card-body">
						<div class="card-title"><h5>Nilai Akhir</h5></div>
<div id="load_nilai_akhir"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
window.addEventListener('load', event => {
	get_nilai_akhir()
});

function get_nilai_akhir()
{
	fetch('<?= base_url('dhmd/nilai_akhir/'.$kelas->id_kelas_kuliah.'/'.$mahasiswa_pt->id_mahasiswa_pt) ?>', {
		method: 'post',
	}).then( response => {
		return response.text()
	}).then( text => {
		document.querySelector('#load_nilai_akhir').innerHTML=text
	}).catch( err => {
		console.warn(err)
	})
}
<?php if($_SESSION['app_level']==2) { ?>
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

function hitung_nilai_sikap_akhir(id_nilai_sikap)
{
	var nilai_a = parseFloat(document.getElementById('nilai_sikap_a'+id_nilai_sikap).value) * parseFloat(0.<?=$get_sikap->bobot_disiplin?>);
	var nilai_b = parseFloat(document.getElementById('nilai_sikap_b'+id_nilai_sikap).value) * parseFloat(0.<?=$get_sikap->bobot_jawab?>);
	var nilai_c = parseFloat(document.getElementById('nilai_sikap_c'+id_nilai_sikap).value) * parseFloat(0.<?=$get_sikap->bobot_kreatif?>);
	var nilai_d = parseFloat(document.getElementById('nilai_sikap_d'+id_nilai_sikap).value) * parseFloat(0.<?=$get_sikap->bobot_a?>);
	var nilai_e = parseFloat(document.getElementById('nilai_sikap_e'+id_nilai_sikap).value) * parseFloat(0.<?=$get_sikap->bobot_b?>);
	var nilai_f = parseFloat(document.getElementById('nilai_sikap_f'+id_nilai_sikap).value) * parseFloat(0.<?=$get_sikap->bobot_c?>);
	var nilai_g = parseFloat(document.getElementById('nilai_sikap_g'+id_nilai_sikap).value) * parseFloat(0.<?=$get_sikap->bobot_d?>);
	
	var nilai_sikap_akhir_show = document.getElementById('nilai_sikap_akhir_show')
	var nilai_sikap_akhir = document.getElementById('nilai_sikap_akhir')
	
	var total     = parseFloat(nilai_a) + parseFloat(nilai_b) + parseFloat(nilai_c) + parseFloat(nilai_d) + parseFloat(nilai_e) + parseFloat(nilai_f) + parseFloat(nilai_g);
	
	nilai_sikap_akhir_show.innerHTML = total.toFixed(2)
	nilai_sikap_akhir.value = total.toFixed(2)
	
	document.getElementById("simpan_nilai_sikap_akhir").removeAttribute("disabled");
	
}

function simpan_nilai_sikap_akhir(id_nilai_sikap)
{
	var nilai_a = document.getElementById('nilai_sikap_a'+id_nilai_sikap).value
	var nilai_b = document.getElementById('nilai_sikap_b'+id_nilai_sikap).value
	var nilai_c = document.getElementById('nilai_sikap_c'+id_nilai_sikap).value
	var nilai_d = document.getElementById('nilai_sikap_d'+id_nilai_sikap).value
	var nilai_e = document.getElementById('nilai_sikap_e'+id_nilai_sikap).value
	var nilai_f = document.getElementById('nilai_sikap_f'+id_nilai_sikap).value
	var nilai_g = document.getElementById('nilai_sikap_g'+id_nilai_sikap).value
	var nilai_sikap = document.getElementById('nilai_sikap_akhir').value
	
	var data = new FormData()
	
	data.append('nilai_a', nilai_a);
	data.append('nilai_b', nilai_b);
	data.append('nilai_c', nilai_c);
	data.append('nilai_d', nilai_d);
	data.append('nilai_e', nilai_e);
	data.append('nilai_f', nilai_f);
	data.append('nilai_g', nilai_g);
	data.append('nilai_sikap', nilai_sikap);
	data.append('id_mahasiswa_pt', '<?=$mahasiswa_pt->id_mahasiswa_pt?>');
	data.append('id_kelas_kuliah', '<?=$kelas->id_kelas_kuliah?>');
	
	fetch('<?=base_url('dhmd/simpan_raport/')?>', {
		method: 'POST',
		body: data
	})
	.then((response) => response.text())
	.then((texts) => {
		get_nilai_akhir()
		if(texts==0){
			Toastify({ text: "Gagal!",	style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
		}else{
			Toastify({ text: texts,	style: { background: "<?=$_ENV['CLR_SUC']?>",	} }).showToast();
		}
	})
	.catch(error => {
		console.log(error)
	})  
	
	document.getElementById("simpan_nilai_sikap_akhir").setAttribute("disabled","");
}


<?php } ?>
</script>
