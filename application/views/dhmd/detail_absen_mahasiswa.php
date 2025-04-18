<div class="card mb-3">
	<div class="card-body">

		<div class="text-center position-relative">
			<div class="pt-2 pb-3">
				<img class="img-lg rounded-circle" src="<?=$_SESSION['picture']?>" alt="Profile Picture" loading="lazy">
			</div>
			<div class="h5"><?=$_SESSION['nama_pengguna']?></div>
			<p class="text-muted"><?=$_SESSION['id_user']?></p>
		</div>
		<div class="d-flex justify-content-center gap-2">
			Statistik Pertemuan
		</div>
		<table class="table">
			<thead>
				<th>Pertemuan Ke #</th>
				<th>Tanggal</th>
				<th>Status</th>
				<th>Nilai</th>
			</thead>
			</tbody>
		<?php
		$bap_pertemuan = $this->Dhmd_model->get_pertemuan_mahasiswa($_SESSION['id_user'],$bap->id_kelas_kuliah)->result();
		$co=1;
		$absen = array();
		$total_pertemuan = count($bap_pertemuan);
		$total_hadir = 0;
		foreach($bap_pertemuan as $key=>$value)
		{
			if($value->status_hadir!=0) $total_hadir +=1;
			$absen [] = $value->status_hadir;
			$h4=($bap->tanggal==$value->tanggal)?'h4':'';
			echo'
			<tr class="'.$h4.'">
				<td>'.$co.'</td>
				<td>'.tanggal_indo($value->tanggal).'</td>
				<td>'.status_hadir($value->status_hadir).'</td>
				<td>'.$value->nilai.'</td>
			</tr>
			';
			$co++;
		}
		$persen_hadir = ($total_hadir / $total_pertemuan) * 100;
		$persen_min = $this->Main_model->get_konfigurasi('min_absen')->row()->value_konfigurasi;
		?>
			</tbody>
			<tfoot>
				<th colspan="3" align="center">Kehadiran <?=$total_hadir?> / <?=$total_pertemuan?> (<?=$persen_hadir?> %)</th>
			</tfoot>
		</table>
		<small>kehadiran minimal untuk dapat mengikuti ujian adalah : <?=$persen_min?> % </small>
		<?php
			$this->Dhmd_model->update_nilai_mahasiswa($_SESSION['id_user'],$bap->id_kelas_kuliah,'kehadiran',json_encode($absen));
			$this->Dhmd_model->update_nilai_mahasiswa($_SESSION['id_user'],$bap->id_kelas_kuliah,'nilai_hadir',$persen_hadir);
			$cek_hadir = $this->Dhmd_model->check_bap_mahasiswa($_SESSION['id_user'],$bap->id_bap_kuliah)->row();
			if($cek_hadir){
		?>
		<hr>
		<h4 class="mb-2">Unggah Dokumen Tugas</h4>
		<?php if($cek_hadir->dokumen)
		{
			echo '<p> <a href="'.$cek_hadir->dokumen.'" target="_blank">Lihat Dokumen</a></p>';
		}	
		?>
		<input type="file" name="dokumen_tugas" id="dokumen_tugas" onchange="unggah_tugas()">
		<p><em>Mengunggah ulang dokumen berarti akan menimpa (replace) dokumen terdahulu. Maks 15mb</em></p>
		<?php } ?>
	</div>
</div>