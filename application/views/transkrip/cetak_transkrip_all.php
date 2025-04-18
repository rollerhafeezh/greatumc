<!DOCTYPE html>
<html>
<head>
<title>...</title>
<style media="print">
@media print {
   	table{
		font-family: sans-serif;
		font-size: 70%;
	}
}
</style>
</head>
<body>
<table width="100%">
	<tr align="center">
		<td width="25%"><img src="https://www.sso.umc.ac.id/assets/images/logo_100.png"></td>
		<td>
			<h3><?=$mahasiswa_pt->nama_fak?></h3>
			<h2>UNIVERSITAS MUHAMMADIYAH CIREBON</h2>
			<h4><?=$mahasiswa_pt->nama_prodi?></h4>
Kampus 1 : Jl. Tuparev No. 70 Cirebon 45153<br>
Kampus 2 dan 3: Jl. Fatahillah - Watubelah - Cirebon<br>
Telp. +62-231-209608, +62-231-204276, Fax: +62-231-209608<br>
Email: info@umc.ac.id Website: www.umc.ac.id

		</td>
	</tr>
</table>
<hr>
<table width="100%">
	<tr>
		<td colspan="4" align="center"><h4>RIWAYAT NILAI</h4></td>
	</tr>
	<tr valign="center">
		<td width="20%">NAMA<br><em>Name</em></td>
		<td><?=$mahasiswa_pt->nm_pd?></td>
		<td width="20%">NO. SERI<br><em>Serial Num.</em></td>
		<td>......</td>
	</tr>
	<tr valign="center">
		<td width="20%">TTL<br><em>Date of Birth</em></td>
		<td><?=$mahasiswa_pt->tmp_lahir?>, <?=format_indo($mahasiswa_pt->tgl_lahir)?></td>
		<td width="20%">NIM<br><em>Student Number</em></td>
		<td><?=$mahasiswa_pt->id_mahasiswa_pt?></td>
	</tr>
	<tr valign="center">
		<td width="20%">FAKULTAS<br><em>Faculty</em></td>
		<td><?=$mahasiswa_pt->nama_fak?></td>
		<td width="20%">TAHUN MASUK<br><em>Entry Year</em></td>
		<td><?=nama_smt($mahasiswa_pt->mulai_smt)?></td>
	</tr>
	<tr valign="center">
		<td width="20%">PRODI<br><em>Study Program</em></td>
		<td><?=$mahasiswa_pt->nama_prodi?></td>
		<td width="20%">Tahun Lulus<br><em>Passing Year</em></td>
		<td>......</td>
	</tr>
</table>
<table border="1" cellpadding="3" cellspacing="0" width="100%"><thead>
	<tr>
	<th>KODE MK</th>
	<th>MATA KULIAH</th>
	<th>NILAI</th>
	<th>ASAL</th>
	</tr>
</thead>
<tbody>
	<?php
	    $nilai = $this->Transkrip_model->transkrip_all($mahasiswa_pt->id_mahasiswa_pt)->result();
	    if($nilai){
		foreach($nilai as $key=>$value)
		{
			echo'
			<tr>
				<td>'.$value->kode_mk.'</td>
				<td>'.$value->nm_mk.'</td>
				<td>'.$value->nilai_huruf.'</td>
				<td>'.$value->asal.'</td>
			</tr>
			';
		} }
	?>
</tbody>
</table>
<hr>
<table width="100%" style="page-break-inside: avoid;">
	<tr>
		<td colspan="4" align="center"><strong>Dikeluarkan di Cirebon: <?=format_indo(date("Y-m-d"))?></strong></td>
	</tr>
	<tr>
		<td colspan="4" align="center"><em>Issued in Cirebon on <?=date("F, d Y")?></em></td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<p>Mengetahui,</p>
			<p>Ketua Program Studi <?=$mahasiswa_pt->nama_prodi?></p>
			<p>&nbsp;</p>
			<p>&nbsp;</p>
			<p><u><strong>....................</strong></u></p>
		</td>
		<td colspan="2" align="center">
			<p>Dosen Wali</p>
			<p>&nbsp;</p>
			<p>&nbsp;</p>
			<p>&nbsp;</p>
			<p><u><strong><?=$mahasiswa_pt->nm_sdm?></strong></u></p>
		</td>
	</tr>
</table>
</body>
</html>