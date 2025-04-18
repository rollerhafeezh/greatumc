<style type="text/css">
	a { text-decoration: none!important }
</style>
<div id="peserta" class="tab-pane fade" role="tabpanel" aria-labelledby="peserta-tab">
	<div class="table-responsive">
	   <table class="table table-bordered table-striped my-0">
	      <thead class="text-nowrap">
	         <tr class="bg-info text-white">
	            <td class="text-white" width="1">ID</td>
	            <td width="">NPM</td>
	            <td>Nama Mahasiswa</td>
	            <td>Jenis Anggota</td>
	            <td>Aktivitas</td>
	            <td width="180px">Konversi Nilai</td>
	         </tr>
	      </thead>
	      <tbody>
	      	<?php $no = 1; foreach($anggota as $anggota): ?>
	      	<tr>
	      		<td class="text-center"><?= $anggota->id_anggota ?></td>
	      		<td><?= $anggota->id_mahasiswa_pt ?></td>
	      		<td>
	      			<a href="<?= base_url('biodata/mahasiswa/'.$anggota->id_mahasiswa_pt) ?>" target="_blank"><?= $anggota->nm_pd ?></a>
	      		</td>
	      		<td class="text-nowrap">
	      			Personal
	               	<?php
	               	$dokumen = [ 
	               		'pasfoto' => 'Foto Almamater',
	               		'ktp' => 'Kartu Tanda Penduduk',
	               		'kk' => 'Kartu Keluarga',
	               		'ijazah' => 'Ijazah Terakhir',
	               		'akta' => 'Akta Kenal Lahir'
	               	];
	               	?>
	               	<ul class="p-0 m-0 list-unstyled">
	               		<?php 
	               		foreach($dokumen as $key => $value): 
	               		$file = $this->Mahasiswa_model->get_dokumen($anggota->id_mhs, $key);
                        $file = $file ? $file->file_mahasiswa : '';
               			?>
	      				<li class="d-none">
	      					<a data-group="berkas_mahasiswa" data-thumbnail="<?= $file ?>" href="<?= $file ? $file.'" class="html5lightbox"': 'javascript:void(0)' ?>" <?= !$file ? 'style="filter: grayscale(100%);"' : '' ?> data-description="<a href='<?= $file ?>' download='<?= strtoupper($value).' '.$anggota->nm_pd ?>'>Unduh Berkas</a>">
	      						<img src="<?= base_url('assets/img/file.png') ?>"> 
	      						<?= $value ?>
	      					</a>
	      				</li>
	               		<?php endforeach; ?>
	      			</ul>
	      		</td>
	      		<td class="text-nowrap">
	      			<ul class="p-0 m-0 list-unstyled">
	      			    <li>
	      			    	<a href="<?= base_url('krs/add/'.$_SESSION['active_smt'].'/'.$anggota->id_mahasiswa_pt) ?>" target="_blank" class="d-block">
		  						<i class="fa fa-copy me-1"></i> KRS Mahasiswa
		  					</a>
	      			    </li>
	      			    <li>
		  					<a href="<?= base_url('mbkm/aktivitas/'.sha1($aktivitas->id_aktivitas).'/'.$anggota->id_mahasiswa_pt) ?>" target="_blank">
		  						<i class="fa fa-history me-1"></i> Aktivitas Mahasiswa
		  					</a>
	      			    </li>
	      			</ul>
	      			
	      		</td>
	      		<td class="text-nowrap">
	      			<a href="<?= base_url('mbkm/konversi/'.sha1($aktivitas->id_aktivitas).'/'.$anggota->id_mahasiswa_pt) ?>" target="_blank">
  						<i class="fa fa-edit me-1"></i> Detail
  					</a>
	      		</td>
	      	</tr>
	      	<?php endforeach; ?>
	      </tbody>
	   </table>
	</div>
</div>
<!-- <script type="text/javascript" src="<?= base_url('assets/plugins') ?>/html5lightbox/jquery.js"></script> -->
<script type="text/javascript" src="<?= base_url('assets/plugins') ?>/html5lightbox/html5lightbox.js"></script>
<script>
	function status_kegiatan_anggota(status, id_kegiatan, id_anggota, id_aktivitas) {
		fetch('<?= base_url('studi_akhir/status_kegiatan_anggota/') ?>' + id_kegiatan + '/' + id_anggota + '/' + status + '/' + id_aktivitas)
		.then(response => response.text())
		.then(text => {
			console.log(text)
		})
	}
</script>