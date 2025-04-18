<?php
	$jumlah = count($bap_pertemuan);
?>
<div class="card h-100">
	<div class="card-body d-flex flex-column">
		<div class="card-title">
			<h5>Jumlah Peserta : <?=$jumlah?> Orang <i class="psi-repeat-7 text-info" onclick="get_peserta()" style="cursor:pointer"></i></h5>
		</div>
		<div class="table-responsive">
			<table class="table table-sm">
				<thead>
					<th>NIM</th>
					<th>Nama</th>
					<th>Status</th>
					<th>Nilai</th>
				</thead>
				<tbody>
				<?php
				if($bap_pertemuan)
				{
					$status_hadir =  array("A","H","S","I");
					foreach($bap_pertemuan as $key=>$value)
					{
						$dokumen = ($value->dokumen)?'<a href="'.$value->dokumen.'" target="_blank" class="text-decoration-none">'.$value->id_mahasiswa_pt.'</a>':$value->id_mahasiswa_pt;
						$nm_pd = ($value->dokumen)?'<a href="'.$value->dokumen.'" target="_blank" class="text-decoration-none">'.$value->nm_pd.'</a>':$value->nm_pd;
						$jam_hadir = ($value->created_at)?'<br><small>'.format_indo($value->created_at).'</small>':'';
						echo'
						<tr>
							<td>'.$dokumen.'</td>
							<td>'.$nm_pd.($value->id_stat_mhs == 'M' ? ' <span class="badge bg-info ms-1">mbkm</span>' : '').''.$jam_hadir.'</td>';
							if($_SESSION['app_level']==2 && date("Y-m-d")==$pertemuan->tanggal && !$pertemuan->jam_selesai){
								echo '<td><select id="hadir_'.$value->id_mahasiswa_pt.'" onchange="update_hadir(`'.$value->id_mahasiswa_pt.'`)">';
								foreach($status_hadir as $keys=>$values)
								{
									if($value->status_hadir == $keys)	echo '<option selected value="'.$keys.'">'.$values.'</option>';
									else	echo '<option value="'.$keys.'">'.$values.'</option>';
								}
								echo'</select></td>';
							}else{
								echo '<td>'.status_hadir($value->status_hadir).'</td>';
							}
							if($_SESSION['app_level']==2){
								if($value->status_hadir != 0){
									echo '<td><input onfocus="this.select()" id="nilai_'.$value->id_bap_peserta_kuliah.'" type="number" min="0" max="100" value="'.$value->nilai.'" onchange="update_nilai_pertemuan(`'.$value->id_bap_peserta_kuliah.'`)"></td>';
								}else{
									echo '<td>'.$value->nilai.'</td>';
								}
							}else{
								echo '<td>'.$value->nilai.'</td>';
							}
						echo'</tr>
						';
					}
				}
				?>
				</tbody>
			</table>
		</div>
	</div>
</div>