<div class="col mb-3">
	<div class="card h-100">
		<div class="card-body d-flex flex-column">
			<div class="card-title">
				<h5>Jadwal <?=strtoupper($jenis_ujian)?></h5>
			</div>

			<div class="row">
				<div class="col-md-4 mt-1"><strong>Semester</strong></div>
				<div class="col-md-8 mt-1"><?=nama_smt($kelas->id_smt)?></div>
				<div class="col-md-4 mt-1"><strong>Fakultas/ Prodi</strong></div>
				<div class="col-md-8 mt-1"><?=$kelas->nama_fak?> <?=$kelas->nama_prodi?></div>
				<div class="col-md-4 mt-1"><strong>Kelas</strong></div>
				<div class="col-md-8 mt-1"><?=$kelas->nm_mk?> <?=$kelas->nm_kls?></div>
				<div class="col-md-4 mt-1"><strong>Dosen Pengampu</strong></div>
				<div class="col-md-8 mt-1">
					<?php
						$jam_sekarang = date('H:i:s');
						$tanggal_sekarang = date("Y-m-d");
						$jam_mulai_ujian = '00:00:00';
						$jam_selesai_ujian = '00:00:00';
						$tanggal_ujian = '0000-00-00';
						$pengampu=$this->Main_model->pengampu_kelas($kelas->id_kelas_kuliah)->result();
						if($pengampu)
						{
							
							foreach($pengampu as $keys=>$values)
							{
								echo'<strong>'.$values->nidn.'</strong> '.$values->nm_sdm.' ('.$values->sks_subst_tot.' SKS)<br>';
							}
							
						}else{ echo '-'; }
					?>
				</div>
				<?php if($jenis_ujian=='uts'){ ?>
				<div class="col-md-4 mt-1"><strong>Jadwal UTS</strong>
				</div>
				<div class="col-md-8 mt-1">
				<?php if($kelas->tgl_uts){ 
				$jam_mulai_ujian = $kelas->jam_mulai_uts;
				$jam_selesai_ujian = $kelas->jam_selesai_uts;
				$tanggal_ujian = $kelas->tgl_uts;
				?>
					<?=tanggal_indo($kelas->tgl_uts)?><br><?=$kelas->jam_mulai_uts?> sd <?=$kelas->jam_selesai_uts?><br>
					G. <?=$kelas->nama_gedung_uts?> R. <?=$kelas->nama_ruangan_uts?>
				<?php } ?>
				</div>
				<?php }
				if($jenis_ujian=='uas'){ ?>
				<div class="col-md-4 mt-1"><strong>Jadwal UAS</strong>
				</div>
				<div class="col-md-8 mt-1">
				<?php if($kelas->tgl_uas){ 
				$jam_mulai_ujian = $kelas->jam_mulai_uas;
				$jam_selesai_ujian = $kelas->jam_selesai_uas;
				$tanggal_ujian = $kelas->tgl_uas;
				?>
					<?=tanggal_indo($kelas->tgl_uas)?><br><?=$kelas->jam_mulai_uas?> sd <?=$kelas->jam_selesai_uas?><br>
					G. <?=$kelas->nama_gedung_uas?> R. <?=$kelas->nama_ruangan_uas?>
				<?php } ?>
				</div>
				<?php } ?>
				<div class="col-md-4 mt-1"><strong>Hari Sekarang</strong></div>
				<div class="col-md-8 mt-1"><?=tanggal_indo($tanggal_sekarang)?></div>
				<div class="col-md-4 mt-1"><strong>Jam Sekarang</strong></div>
				<div class="col-md-8 mt-1"><h3><div id="jam_sekarang"><?=$jam_sekarang?></div></h3></div>
			</div>
			<?php
			//if($tanggal_sekarang == $tanggal_ujian && ($jam_sekarang >= $jam_mulai_ujian && $jam_sekarang <= $jam_selesai_ujian)){
			if($tanggal_sekarang == $tanggal_ujian){
				echo '<a class="btn btn-primary" href="'.base_url('dhmd/mulai_kelas/'.$kelas->id_kelas_kuliah.'/'.$jenis_ujian).'">Mulai '.strtoupper($jenis_ujian).'</a>';
			}else{
				echo '<div class="text-danger text-center h3">Bukan waktunya ujian!</div>';
			}
			?>
		</div>
	</div>
</div>