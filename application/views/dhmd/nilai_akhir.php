<?php
$konfig_tahun = $this->Main_model->get_konfigurasi('input_nilai_beda_smt')->row();
$konfig_nilai = $this->Main_model->get_konfigurasi('input_nilai')->row();
$konfig_absen = $this->Main_model->get_konfigurasi('ubah_absensi')->row();

if($nilai->id_smt != $_SESSION['active_smt']){
	$edit_tahun = ($konfig_tahun->value_konfigurasi=='on')?'':'disabled';
}else{
	$edit_tahun = '';
}
$edit_nilai = ($konfig_nilai->value_konfigurasi=='on')?'':'disabled';
$edit_absen = ($konfig_absen->value_konfigurasi=='on')?'':'disabled';
$edit_dosen = ($_SESSION['app_level']==2)?'':'disabled';
$bayar_uas = $this->Ujian_model->get_status_cetak($nilai->id_smt,'UAS',$nilai->id_mahasiswa_pt);
if($bayar_uas){
	$bayar_uas = '';
}else{
	$bayar_uas = 'disabled';
}
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
			<td>Kehadiran</td>
			<td><?=$bobot->bobot_hadir?> % </td>
			<td>
				<input type="number" onfocus="this.select()" class="" id="nilai_hadir<?=$nilai->id_nilai?>" value="<?=$nilai->nilai_hadir?>" min="0" max="100" <?=$edit_absen?> <?=$edit_dosen?> <?=$edit_tahun?> <?=$edit_nilai?>>
			</td>
		</tr>
		<tr>
			<td><a href="<?=base_url('ujian/jawab/uts/'.$nilai->id_kelas_kuliah.'/'.$nilai->id_mahasiswa_pt)?>" class="text-decoration-none">UTS</a></td>
			<td><?=$bobot->bobot_uts?> % </td>
			<td>
				<input type="number" onfocus="this.select()" class="" id="nilai_uts<?=$nilai->id_nilai?>" value="<?=$nilai->nilai_uts?>" min="0" max="100" <?=$edit_dosen?> <?=$edit_tahun?> <?=$edit_nilai?>>
			</td>
		</tr>
		<tr>
			<td><a href="<?=base_url('ujian/jawab/uas/'.$nilai->id_kelas_kuliah.'/'.$nilai->id_mahasiswa_pt)?>" class="text-decoration-none">UAS</a></td>
			<td><?=$bobot->bobot_uas?> % </td>
			<td>
				<input type="number" onfocus="this.select()" class="" id="nilai_uas<?=$nilai->id_nilai?>" value="<?=$nilai->nilai_uas?>" min="0" max="100" <?=$edit_dosen?> <?=$edit_tahun?> <?=$edit_nilai?>>
			</td>
		</tr>
		<tr>
			<td>Sikap</td>
			<td><?=$bobot->bobot_sikap?> % </td>
			<td>
				<input type="number" onfocus="this.select()" class="" id="nilai_sikap<?=$nilai->id_nilai?>" value="<?=$nilai->nilai_sikap?>" min="0" max="100" disabled>
			</td>
		</tr>
		<tr>
			<td><?=$bobot->label_a?></td>
			<td><?=$bobot->bobot_a?> % </td>
			<td>
				<input type="number" onfocus="this.select()" class="" id="nilai_a<?=$nilai->id_nilai?>" value="<?=$nilai->nilai_a?>" min="0" max="100" <?=$edit_dosen?> <?=$edit_tahun?> <?=$edit_nilai?>>
			</td>
		</tr>
		<tr>
			<td><?=$bobot->label_b?></td>
			<td><?=$bobot->bobot_b?> % </td>
			<td>
				<input type="number" onfocus="this.select()" class="" id="nilai_b<?=$nilai->id_nilai?>" value="<?=$nilai->nilai_b?>" min="0" max="100" <?=$edit_dosen?> <?=$edit_tahun?> <?=$edit_nilai?>>
			</td>
		</tr>
		<tr>
			<td><?=$bobot->label_c?></td>
			<td><?=$bobot->bobot_c?> % </td>
			<td>
				<input type="number" onfocus="this.select()" class="" id="nilai_c<?=$nilai->id_nilai?>" value="<?=$nilai->nilai_c?>" min="0" max="100" <?=$edit_dosen?> <?=$edit_tahun?> <?=$edit_nilai?>>
			</td>
		</tr>
	</tbody>
	<tfoot>
		<th colspan="2">Nilai Akhir</th>
		<?php if($_SESSION['app_level']==1) { 
		    //if($nilai->isi_persepsi == 0 && $nilai->id_kat_mk==1){ 
            if($nilai->isi_persepsi == 0){ 
        ?>
		        <th><a href="<?=base_url('persepsi/index/'.$nilai->id_kelas_kuliah.'/'.$nilai->id_mahasiswa_pt)?>">Evaluasi dosen oleh mahasiwa (EDOM)</a></th>
		   <?php }else{ ?>
		    <th><span id="nilai_angka_show<?=$nilai->id_nilai?>"><?=$nilai->nilai_angka?></span> <div class="h1" id="nilai_huruf_show<?=$nilai->id_nilai?>"><?=$nilai->nilai_huruf?></div>
		    <br><a href="<?=base_url('persepsi/index/'.$nilai->id_kelas_kuliah.'/'.$nilai->id_mahasiswa_pt)?>">Evaluasi dosen oleh mahasiwa (EDOM)</a></th>
		<?php } }else{ ?>
		    <th><span id="nilai_angka_show<?=$nilai->id_nilai?>"><?=$nilai->nilai_angka?></span> <div class="h1" id="nilai_huruf_show<?=$nilai->id_nilai?>"><?=$nilai->nilai_huruf?></div></th>
		<?php } ?>
	</tfoot>
</table>
</div>
<?php if($_SESSION['app_level']==2) { ?>
	<input type="hidden" id="id_mahasiswa_pt<?=$nilai->id_nilai?>" value="<?=$nilai->id_mahasiswa_pt?>">
	<input type="hidden" id="nilai_angka<?=$nilai->id_nilai?>" value="<?=$nilai->nilai_angka?>">
	<input type="hidden" id="nilai_huruf<?=$nilai->id_nilai?>" value="<?=$nilai->nilai_huruf?>">
	<input type="hidden" id="nilai_indeks<?=$nilai->id_nilai?>" value="<?=$nilai->nilai_indeks?>">
					
	<div class="row">
		<div class="col-6 mt-1">
			<div class="d-grid gap-2">
				<button class="btn btn-warning" id="rekap_nilai<?=$nilai->id_nilai?>" onclick="rekap_nilai('<?=$nilai->id_nilai?>')" <?=$edit_dosen?> <?=$edit_tahun?> <?=$edit_nilai?> <?=$bayar_uas?>><i class="pli-yes"></i> Hitung </button>
			</div>
		</div>
		<div class="col-6 mt-1">
			<div class="d-grid gap-2">
				<button class="btn btn-info" id="simpan_nilai<?=$nilai->id_nilai?>" onclick="simpan_nilai('<?=$nilai->id_nilai?>')" disabled=""><i class="pli-save"></i> Simpan </button>
			</div>
		</div>
	</div>

<?php } ?>