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
<table width="100%">
	<tr align="center">
		<td><strong>IPK (&Sigma; TOTAL BOBOT / &Sigma; TOTAL SKS)</strong></td>
		<td><h4>(<?=$tot_bobot?> / <?=$tot_sks?>) <?=number_format($ipk,2,'.',',')?></h4></td>
		<td><strong>Predikat</strong></td>
		<td><h4><?=$result?></h4></td>
	</tr>
</table>