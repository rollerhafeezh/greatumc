<?php
	$nilai = $this->Transkrip_model->konversi($id_kur,$mahasiswa_pt->id_mahasiswa_pt)->result();
	var_dump($nilai); exit;
?>
<table border="1" cellpadding="3" cellspacing="0" width="100%">
<thead>
	<th>KODE MK</th>
	<th>MATA KULIAH</th>
	<th>SKS</th>
	<th>NILAI</th>
	<th>ANGKA</th>
	<th>BOBOT</th>
</thead>
<tbody>
	<?php
	$sum_sks=0;
	$sum_index=0;
	$sum_bobot=0;
	$bobot=0;
	
		foreach($nilai as $key=>$value)
		{
			if($value->nilai_indeks){
				$bobot=$value->sks_mk*$value->nilai_indeks;
				switch ($value->nilai_indeks)
				{
					default : $nilai_huruf='E'; break;
					case 4 : $nilai_huruf='A'; break;
					case 3 : $nilai_huruf='B'; break;
					case 2 : $nilai_huruf='C'; break;
					case 1 : $nilai_huruf='D'; break;
				}
				echo'
				<tr align="center">
					<td>'.$value->kode_mk.'</td>
					<td align="left">'.$value->nm_mk.'</td>
					<td>'.$value->sks_mk.'</td>
					<td>'.$nilai_huruf.'</td>
					<td>'.(int)$value->nilai_indeks.'</td>
					<td>'.$bobot.'</td>
				</tr>
				';
			$sum_sks+=$value->sks_mk;
			$sum_index+=$value->nilai_indeks;
			$sum_bobot+=$bobot;
			}
		}
	?>
<tr align="center">
	<td colspan="2">JUMLAH</td>
	<td><?=$sum_sks?></td>
	<td><?=$sum_index?></td>
	<td>&nbsp;</td>
	<td><?=$sum_bobot?></td>
</tr>
</tbody>
</table>
<?php 
	if($sum_sks==0) $sum_sks=1;
	$ipk=($sum_bobot/$sum_sks);
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
		<td><strong>IPK</strong></td>
		<td><h4><?=number_format($ipk,2,'.',',')?></h4></td>
		<td><strong>Predikat</strong></td>
		<td><h4><?=$result?></h4></td>
	</tr>
</table>
<?php
    //update sks total
    //update ipk
    //upda
    //echo ;
    $this->Main_model->update_kuliah_mahasiswa($mahasiswa_pt->id_mahasiswa_pt,$_SESSION['active_smt'],'sks_total',$sum_sks);
    $this->Main_model->update_kuliah_mahasiswa($mahasiswa_pt->id_mahasiswa_pt,$_SESSION['active_smt'],'ipk',$ipk);
    $this->Main_model->update_ipk($mahasiswa_pt->id_mahasiswa_pt,$ipk);
?>