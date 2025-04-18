<?php if($status_bayar['hasil']=='1'){ 
    $this->Main_model->cetak_kartu($id_smt,$mahasiswa_pt->id_mahasiswa_pt,$jenis);
//$data['status_bayar'] = $this->Main_model->keuangan($jenis,$id_mahasiswa_pt,$id_smt);
//var_dump($data['status_bayar']);
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
				<h4 class="p-0 m-0 nama-pt">KARTU <?=$jenis?></h4>
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
		<td><?=$mahasiswa_pt->nama_fak?> - <?=strtoupper($mahasiswa_pt->nama_prodi)?></td>
	</tr>
</table>
<br>
<table border="1" width="100%" cellpadding="5" cellspacing="0">
		<thead>
		    <tr>
    			<th>Nama Kelas</th>
    			<th>Jadwal <?=$jenis?></th>
    			<th>Paraf</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$total_sks=0;
		if($list_kelas_krs)
		{
			foreach($list_kelas_krs as $key=>$value){
				$total_sks+=$value['sks_mk'];
			$tgl = ($value['tgl'])?format_indo($value['tgl']):'-';
			echo'
			<tr>
				<td>'.$value['kode_mk'].' '.$value['nm_mk'].' '.$value['nm_kls'].'</td>
				<td>
				    '.$tgl.', 
					'.$value['jam_mulai'].' s/d
					'.$value['jam_selesai'].' - 
					G. '.$value['nama_gedung'].' R. '.$value['nama_ruangan'].'
				</td>
				<td>&nbsp;</td>
			</tr>
			';
			}
			echo'
			</tbody>
		</table>	
			';
		}else{
			echo'<tr><td colspan="4">n/a</a></tbody>
	</table>';
		}

}else{ echo '<div class="card p-3 text-danger">'.$status_bayar['message'].'</div>'; } ?>