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
		<td colspan="4" align="center"><h4>TRANSKRIP NILAI</h4></td>
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
<?php
$tot_sks=0;
$tot_bobot=0;
	for($i=1;$i<=8;$i++)
	{
		echo'<h4 style="margin-top: 5px;">Semester : '.$i.'</h4>';
	?>
<table border="1" cellpadding="3" cellspacing="0" width="100%">
<thead>
	<tr>
		<th colspan="4" width="72%">MATA KULIAH</th>
		<th colspan="4" width="28%">NILAI</th>
	</tr>
	<tr>
		<th width="10%">KODE MK</th>
		<th>NAMA MATA KULIAH</th>
		<th width="7%">WAJIB</th>
		<th width="7%">SKS</th>
		<th width="7%">HURUF</th>
		<th width="7%">INDEKS</th>
		<th width="7%">SKS</th>
		<th width="7%">BOBOT <br><em><small>(indeks x sks)</small></em></th>
	</tr>
</thead>
<tbody>
	<?php
	$sum_sks=0;
	$sum_index=0;
	$sum_bobot=0;
	$bobot=0;
		foreach($kurikulum as $key=>$value)
		{
			if($value->smt==$i){
				$wajib=($value->a_wajib==1)?'Wajib':'Pil';
				$nilai_huruf='-';
				$nilai_indeks='-';
				$bobot='-';
				$sks='-';
				if(isset($_SESSION['nilai_temp'][$value->id_matkul]))
				{
					$nilai_indeks=(int)$_SESSION['nilai_temp'][$value->id_matkul];
					switch ($_SESSION['nilai_temp'][$value->id_matkul])
					{
						default : $nilai_huruf='E'; break;
						case 4 : $nilai_huruf='A'; break;
						case 3 : $nilai_huruf='B'; break;
						case 2 : $nilai_huruf='C'; break;
						case 1 : $nilai_huruf='D'; break;
					}
				$bobot=$value->sks_mk*$nilai_indeks;
				$sks=$value->sks_mk;
				$sum_sks+=$value->sks_mk;
				$sum_index+=$nilai_indeks;
				$sum_bobot+=$bobot;
				}
				echo'<tr align="center">
						<td align="center">'.$value->kode_mk.'</td>
						<td align="left">'.$value->nm_mk.'</td>
						<td align="center">'.$wajib.'</td>
						<td align="center">'.$value->sks_mk.'</td>
						<td align="center">'.$nilai_huruf.'</td>
						<td align="center">'.$nilai_indeks.'</td>
						<td align="center">'.$sks.'</td>
						<td align="center">'.$bobot.'</td>
					</tr>';
			}
		}
	?>
</tbody>
<tfoot>
<tr>
	<td colspan="6" align="center">JUMLAH</td>
	<td align="center"><?=$sum_sks?></td>
	<td align="center"><?=$sum_bobot?></td>
</tr>
<tr align="center">
	<td colspan="6" align="center">IP Semester (&Sigma; BOBOT / &Sigma; SKS)</td>
	<td colspan="2" align="center"><?=number_format(($sum_bobot/(($sum_sks)?:1)),2,',','.')?></td>
</tr>
</tfoot>
</table>

<?php
	$tot_sks+=$sum_sks;
	$tot_bobot+=$sum_bobot;
	}
?>
<h4 style="margin-top: 5px;">Mata Kuliah Akhir</h4>
<table border="1" cellpadding="3" cellspacing="0" width="100%">
<thead>
	<tr>
		<th colspan="4">MATA KULIAH</th>
		<th colspan="4">NILAI</th>
	</tr>
	<tr>
		<th>KODE MK</th>
		<th>NAMA MATA KULIAH</th>
		<th>WAJIB</th>
		<th>SKS</th>
		<th>HURUF</th>
		<th>INDEKS</th>
		<th>SKS</th>
		<th>BOBOT <br><em><small>(indeks x sks)</small></em></th>
	</tr>
</thead>
<tbody>
	<?php
	$sum_sks=0;
	$sum_index=0;
	$sum_bobot=0;
	$bobot=0;
		foreach($kurikulum as $key=>$value)
		{
			if($value->smt==0){
				$wajib=($value->a_wajib==1)?'Wajib':'Pil';
				$nilai_huruf='-';
				$nilai_indeks='';
				$bobot='';
				$sks='';
				if(isset($_SESSION['nilai_temp'][$value->id_matkul]))
				{
					$nilai_indeks=$_SESSION['nilai_temp'][$value->id_matkul];
					switch ($_SESSION['nilai_temp'][$value->id_matkul])
					{
						default : $nilai_huruf='E'; break;
						case 4 : $nilai_huruf='A'; break;
						case 3 : $nilai_huruf='B'; break;
						case 2 : $nilai_huruf='C'; break;
						case 1 : $nilai_huruf='D'; break;
					}
				$sks=$value->sks_mk;
				$bobot=$value->sks_mk*$nilai_indeks;
				$sum_sks+=$value->sks_mk;
				$sum_index+=$nilai_indeks;
				$sum_bobot+=$bobot;
				}
				echo'<tr align="center">
						<td align="center">'.$value->kode_mk.'</td>
						<td align="left">'.$value->nm_mk.'</td>
						<td align="center">'.$wajib.'</td>
						<td align="center">'.$value->sks_mk.'</td>
						<td align="center">'.$nilai_huruf.'</td>
						<td align="center">'.$nilai_indeks.'</td>
						<td align="center">'.$sks.'</td>
						<td align="center">'.$bobot.'</td>
					</tr>';
			}
		}
	?>
</tbody>
<tfoot>
<tr>
	<td colspan="6" align="center">JUMLAH</td>
	<td align="center"><?=$sum_sks?></td>
	<td align="center"><?=$sum_bobot?></td>
</tr>
<tr align="center">
	<td colspan="6" align="center">IP Semester (&Sigma; BOBOT / &Sigma; SKS)</td>
	<td colspan="2" align="center"><?=number_format(($sum_bobot/(($sum_sks)?:1)),2,',','.')?></td>
</tr>
</tfoot>
</table>
<?php
$tot_sks+=$sum_sks;
$tot_bobot+=$sum_bobot;
	if($tot_sks==0) $tot_sks=1;
	$ipk=($tot_bobot/$tot_sks);
	if($ipk>3.5){
		$result='Dengan Pujian';
	}else if($ipk>2.75){
		$result='Sangat Memuaskan';
	}else if($ipk>2){
		$result='Memuaskan';
	}else{
		$result='-';
	}
?>
<hr>
<table width="100%" style="page-break-inside: avoid;">
	<tr align="center">
		<td><strong>IPK</strong></td>
		<td><h4><?=number_format($ipk,2,'.',',')?></h4></td>
		<td><strong>Predikat</strong></td>
		<td><h4><?=$result?></h4></td>
	</tr>
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