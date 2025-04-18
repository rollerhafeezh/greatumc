<style type="text/css">
	a { text-decoration: none!important }
</style>
<div id="peserta" class="tab-pane fade" role="tabpanel" aria-labelledby="peserta-tab">
	<div class="alert alert-info"><b>Informasi:</b> Apabila Berkas Kegiatan yang di-upload mahasiswa sudah lengkap mohon untuk memperbaharui Status Berkas.</div>
	<div class="table-responsive">
	   <table class="table table-bordered table-striped my-0">
	      <thead class="text-nowrap">
	         <tr class="bg-info text-white">
	            <td class="text-white" width="1">ID</td>
	            <td width="">NPM</td>
	            <td>Nama Mahasiswa</td>
	            <td width="">Berkas Mahasiswa</td>
	            <td>Berkas Kegiatan</td>
	            <td width="180px">Status Berkas</td>
	            <!-- <td width="1">Aksi</td> -->
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
	               	<!-- <b class="mb-1 d-block">Berkas</b> -->
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
	      				<li>
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
	      			<?php
	      			$i = 1;
	      			$kegiatan = $this->Aktivitas_model->kegiatan(['id_jenis_aktivitas_mahasiswa' => $aktivitas->id_jenis_aktivitas_mahasiswa])->result();
	      			foreach ($kegiatan as $kegiatan) {
						if ($kegiatan->id_kegiatan != 4 OR $anggota->kode_fak == 3) {

		      				echo '<b class="mb-1 d-block '.($i > 1 ? 'mt-2' : '').'">'.$kegiatan->deskripsi.'</b>';
		      				$i++;

		      				$berkas_kegiatan = $this->Aktivitas_model->berkas_kegiatan(['id_kegiatan' => $kegiatan->id_kegiatan, 'tipe_berkas' => 'upload'], 'urutan ASC', $anggota->id_anggota)->result();
		      				foreach ($berkas_kegiatan as $berkas_kegiatan) { 
		      				?>
		      				<li>
		      					<span data-bs-toggle="tooltip" title="<?= $berkas_kegiatan->created_at != '' ? tanggal_indo(explode(' ', $berkas_kegiatan->created_at)[0]).' '.explode(' ', $berkas_kegiatan->created_at)[1] : 'Berkas masih kosong.' ?>" >
			                        
			                        <a <?= $berkas_kegiatan->berkas == '' ? 'style="filter: grayscale(100%);"' : '' ?> href="javascript:void(0)" onclick="lihat_berkas(`<?= $berkas_kegiatan->nama_kategori ?>`, `<?= $berkas_kegiatan->berkas != '' ? $berkas_kegiatan->berkas.'?time='.time().'' : '' ?>`, `<?= $_ENV['PDFVIEWER_SKRIPSI'] ?>`)">
			                            <img src="<?= base_url('assets/img/pdf.png') ?>"> <?= $berkas_kegiatan->nama_kategori ?>
			                        </a> 

		      					</span>

		                        <?php if ($berkas_kegiatan->id_berkas_anggota != ''): ?>
		                        - <a onclick="return confirm('Hapus Berkas <?= $berkas_kegiatan->nama_kategori ?> ?')" href="<?= base_url('studi_akhir/hapus_berkas_anggota/'.$berkas_kegiatan->id_berkas_anggota.'/'.$aktivitas->id_aktivitas.'?file='.$berkas_kegiatan->berkas) ?>" class="badge bg-danger text-white">hapus</a>
		                        <?php endif; ?>
		      						
	                      	</li>
		      				<?php
		      				}
		      			}
	      			}
	      			?>
	      			</ul>
	      		</td>
	      		<td class="text-nowrap">
	      			<?php
	      			$kegiatan_anggota = $this->Aktivitas_model->kegiatan_anggota(['id_jenis_aktivitas_mahasiswa' => $aktivitas->id_jenis_aktivitas_mahasiswa], $anggota->id_anggota)->result();
	      			foreach ($kegiatan_anggota as $kegiatan_anggota) {
						if ($kegiatan_anggota->id_kegiatan != 4 OR $anggota->kode_fak == 3) {

		      				echo '<select class="form-select" onchange="status_kegiatan_anggota(this.value,`'.$kegiatan_anggota->id_kegiatan.'`,`'.$anggota->id_anggota.'`, `'.$aktivitas->id_aktivitas.'`)"  data-bs-toggle="tooltip" title="'.($kegiatan_anggota->id_anggota ? tanggal_indo(explode(' ', $kegiatan_anggota->created_at)[0]).' '.explode(' ', $kegiatan_anggota->created_at)[1] : 'Belum diperbaharui.').'">
		      					<option value="0" '.($kegiatan_anggota->status != 1 ? 'selected' : '').'>Belum Lengkap</option>
		      					<option value="1" '.($kegiatan_anggota->status == 1 ? 'selected' : '').'>Lengkap</option>
		      				</select>';

		      				$berkas_kegiatan = $this->Aktivitas_model->berkas_kegiatan(['id_kegiatan' => $kegiatan_anggota->id_kegiatan, 'tipe_berkas' => 'upload'], 'urutan ASC')->result();
		      				foreach ($berkas_kegiatan as $berkas_kegiatan) { echo '<br>'; }
		      			}
	      			}
	      			?>
	      		</td>
	      		<!-- <td>
	               <a href="javascript:void(0)" onclick="hapusAnggota()" class="badge bg-primary text-white fw-normal" data-bs-toggle="tooltip" title="Hapus"><i class="psi-trash"></i></a>
	      		</td> -->
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