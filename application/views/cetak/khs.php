<?php 
//$status_bayar['hasil']=1;
if($status_bayar['hasil']=='1'){ 
//print_r($mahasiswa_pt);
$biro = $this->Main_model->get_konfigurasi('biro_akademik')->row();
$prodi = $this->Main_model->ref_prodi(null,$mahasiswa_pt->kode_prodi);
//print_r($prodi[0]->nama_kaprodi);
?>
<style>
table{
    font-size:60%;
}
</style>
<header>
<table border="0" width="100%">
	<tr>
		<td width="1" style="text-align: right">
			<img src="<?= $_ENV['LOGO_100']; ?>" width="70">
		</td>
		<td>
			<center>
				<h3 class="p-0 m-0 nama-pt">UNIVERSITAS MUHAMMADIYAH CIREBON</h3>
				<h2 class="p-0 m-0 nama-fakultas"><?=$mahasiswa_pt->nama_fak?> - <?=strtoupper($mahasiswa_pt->nama_prodi)?></h2>

				<p class="alamat-kop">Kampus 1 : Jl. Tuparev No. 70 Cirebon 45153 Telp. +62-231-209608, +62-231-204276, Fax: +62-231-209608</p> 
				<p class="alamat-kop">Kampus 2 dan 3: Jl. Fatahillah - Watubelah - Cirebon Email: <a href="mailto:info@umc.ac.id">info@umc.ac.id</a> Website: <a href="https://umc.ac.id">www.umc.ac.id</a></p>
				<br>
			</center>
		</td>
	</tr>
</table>
<div style="width: 100%;height: 2px;background-color: #000; margin-bottom: 1px; margin-top: 5px"></div>
<div style="width: 100%;height: 1px;background-color: #000; margin-bottom: 5px;"></div>

<table border="0" width="100%">
	<tr>
		<td>
			<center>
				<h4 class="p-0 m-0 nama-pt">KARTU HASIL STUDI</h4>
			</center>
		</td>
	</tr>
</table>
<div style="margin-bottom: 5px;"></div>
<table border="0" width="100%">
	<tr>
		<td width="15%"><strong>NIM</strong></td>
		<td><?=$mahasiswa_pt->id_mahasiswa_pt?></td>
		<td width="10%"><strong>Semester</strong></td>
		<td><?=nama_smt($id_smt)?></td>
	</tr>
	<tr>
		<td width="15%"><strong>Nama Mahasiswa</strong></td>
		<td><?=$mahasiswa_pt->nm_pd?></td>
		<td width="10%"><strong>Homebase</strong></td>
		<td><?=$mahasiswa_pt->nama_fak?> - <?=$mahasiswa_pt->nama_prodi?></td>
	</tr>
</table>
<table border="1" width="100%" cellpadding="5" cellspacing="0">
		
		    <tr>
			<th>Mata Kuliah - Kelas</th>
			<th>SKS</th>
			<th>Nilai</th>
			<th>Bobot</th>
			<th>AM</th>
			</tr>
		
		
		<?php
		$sum_sks=0;
    	$sum_index=0;
    	$sum_bobot=0;
    	$bobot=0;
		if($list_kelas_krs)
		{
			foreach($list_kelas_krs as $key=>$value){
				$sum_sks+=$value['sks_mk'];
				$bobot=$value['sks_mk']*$value['nilai_indeks'];
				$sum_index+=$value['nilai_indeks'];
			    $sum_bobot+=$bobot;
				$warna_validasi='<span class="badge bg-warning">n/a</a>';
				$huruf=($value['isi_persepsi']==1)?$value['nilai_huruf']:'Isi EDOM';
				$indeks=($value['isi_persepsi']==1)?$value['nilai_indeks']:'Isi EDOM';
				$bobots=($value['isi_persepsi']==1)?$bobot:'Isi EDOM';
			echo'
			<tr>
				<td>'.$value['kode_mk'].' '.$value['nm_mk'].' '.$value['nm_kls'].'</td>
				<td align="center">'.$value['sks_mk'].'</td>
				<td align="center">'.$huruf.'</td>
				<td align="center">'.$indeks.'</td>
				<td align="center">'.$bobots.'</td>
			</tr>
			';
			}
			if($sum_sks==0) $sum_sks=1;
        	$ips=($sum_bobot/$sum_sks);
        	//UPDATE IPS
        	$this->Main_model->update_kuliah_mahasiswa($mahasiswa_pt->id_mahasiswa_pt,$id_smt,'ips',$ips);
        	echo'
			
			
			    <tr>
				<th>Jumlah Kredit per Semester</th>
				<th>'.$sum_sks.'</th>
				<th colspan="2"></th>
				<th>'.$sum_bobot.'</th>
				</tr>
			<tr>
				<th>Index Prestasi Semester</th>
				<th colspan="4">'.number_format($ips,2,'.',',').'</th>
				</tr>


			</table><br>
			<table border="0" width="100%" cellspacing="0" cellpadding="5">
            <tr>
                <td align="center">Biro Akademik
                <br><br><br><br><br>
                '.$biro->value_konfigurasi.'
                </td>
                <td align="center">Program Studi
                <br><br><br><br><br>
                '.$prodi[0]->nama_kaprodi.'
                </td>
            </tr>
        </table>';
		}else{
			echo'<tr><td colspan="4">n/a</a></tbody></table>';
		}
}else{ echo '<div class="card p-3 text-danger">'.$status_bayar['message'].'</div>'; } ?>