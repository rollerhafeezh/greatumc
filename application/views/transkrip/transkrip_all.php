<table border="1" cellpadding="3" cellspacing="0" width="100%"><thead>
	<th>KODE MK</th>
	<th>MATA KULIAH</th>
	<th>NILAI</th>
	<th>ASAL</th>
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