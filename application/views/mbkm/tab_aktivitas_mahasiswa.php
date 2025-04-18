<div id="aktivitas_mahasiswa" class="tab-pane fade show active" role="tabpanel" aria-labelledby="aktivitas_mahasiswa-tab">
	<div class="alert alert-info"><b>Informasi:</b> Tanggal SK Tugas dan File SK Tugas akan secara otomatis terisi hanya dengan memasukkan No. SK Tugas yang sudah diinputkan sebelumnya.</div>
	<form class="form-aktivitas-mahasiswa was-validated" action="<?= base_url('mbkm/update_aktivitas_mahasiswa') ?>" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="id_aktivitas" value="<?= sha1($aktivitas->id_aktivitas) ?>">
		<div class="form-group row mb-2">
			<label class="col-md-3 col-form-label" for="prodi">Program Studi <span class="text-danger">*</span></label>
			<div class="col-md-5">
				<select id="prodi" name="kode_prodi" class="form-select" required="" <?= $_SESSION['kode_fak'] == '0' ? 'disabled' : 'disabled' ?> >
					<option value="" hidden>Pilih Program Studi</option>
					<?php foreach($prodi as $row): ?>
					<option value="<?= $row->kode_prodi ?>" <?= $row->kode_prodi == $aktivitas->kode_prodi ? 'selected' : '' ?>><?= $row->nama_prodi ?> (<?= $row->nm_jenj_didik ?>)</option>
					<?php endforeach; ?>			
				</select>
			</div>
		</div>
		<div class="form-group row mb-2">
			<label class="col-md-3 col-form-label" for="semester">Semester  <span class="text-danger">*</span></label>
			<div class="col-md-3">
				<select id="semester" name="id_smt" class="form-select" required="" <?= $_SESSION['kode_fak'] == '0' ? 'disabled' : 'disabled' ?>>
					<option value="" hidden>Pilih Semester</option>
					<?php foreach($semester as $row): ?>
					<option value="<?= $row->id_semester ?>" <?= $row->id_semester == $aktivitas->id_smt ? 'selected' : '' ?> ><?= $row->nama_semester ?></option>
					<?php endforeach; ?>				
				</select>
			</div>
		</div>
		<div class="form-group row mb-2">
			<label class="col-md-3 col-form-label" for="jenis_aktivitas">Jenis Aktivitas <span class="text-danger">*</span></label>
			<div class="col-md-3">
				<select id="jenis_aktivitas" name="id_jenis_aktivitas_mahasiswa" class="form-select id_kat_mk" required="" <?= $_SESSION['kode_fak'] == '0' ? 'disabled' : 'disabled' ?>>
					<option value="" hidden>Pilih Jenis Aktivitas</option>
					<?php foreach($jenis_aktivitas_mahasiswa as $row): ?>
						<?php if ($row->id_jenis_aktivitas_mahasiswa >= 13): ?>
							<option value="<?= $row->id_jenis_aktivitas_mahasiswa ?>" <?= $row->id_jenis_aktivitas_mahasiswa == $aktivitas->id_jenis_aktivitas_mahasiswa ? 'selected '.($nama_kegiatan = $row->nama_jenis_aktivitas_mahasiswa) : '' ?>><?= $row->nama_jenis_aktivitas_mahasiswa ?></option>
						<?php endif; ?>
					<?php endforeach; ?>
				</select>
				<small><a href="<?= base_url('mbkm/detail/program_mitra/'.sha1($aktivitas->id_program_mitra)) ?>" target="_blank"><i class="fa fa-search me-1"></i> Lihat Detail Skema</a></small>		
			</div>
		</div>
		<div class="form-group row mb-2">
			<label class="col-md-3 col-form-label" for="judul">Judul Kegiatan<span class="text-danger">*</span></label>
			<div class="col-md-6">
				<textarea class="form-control" rows="5" id="judul" name="judul" placeholder="Judul Kegiatan Masih Kosong" ><?= $aktivitas->judul ?></textarea>
			</div>
		</div>
		<div class="form-group row mb-2">
			<label class="col-md-3 col-form-label" for="lokasi">Lokasi <span class="text-danger">*</span></label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="lokasi" id="lokasi" value="<?= $aktivitas->lokasi ?>" placeholder="Lokasi Masih Kosong" >
				<div class="invalid-feedback">Silahkan konfirmasi kepada mahasiswa untuk memasukan lokasi kegiatan.</div>
			</div>
		</div>
		<div class="form-group row mb-2">
			<label class="col-md-3 col-form-label" for="sk_tugas">No. SK Tugas <span class="text-danger">*</span></label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="sk_tugas" id="sk_tugas" value="<?= $aktivitas->sk_tugas ?>" required="" placeholder="No. SK Tugas Masih Kosong" required="">
				<div class="invalid-feedback">No. SK Penugasan Pembimbing diisi oleh akademik (baca informasi diatas).</div>
			</div>
		</div>
		<div class="form-group row mb-2">
			<label class="col-md-3 col-form-label" for="tanggal_sk_tugas">Tanggal SK Tugas <span class="text-danger">*</span></label>
			<div class="col-md-3">
				<input type="date" class="form-control" name="tanggal_sk_tugas" id="tanggal_sk_tugas" value="<?= $aktivitas->tanggal_sk_tugas ?>">
				<!-- <div class="invalid-feedback">Masukan tanggal surat penugasan pembimbing.</div> -->
			</div>
		</div>
		<div class="form-group row mb-2">
			<label class="col-md-3 col-form-label" for="file_sk_tugas">File SK Tugas <span class="text-danger">*</span></label>
			<div class="col-md-6">
				<input id="file_sk_tugas" name="file_sk_tugas" accept="application/pdf" class="form-control mb-2" type="file">
				<div class="invalid-feedback">Unggah file surat penugasan pembimbing. Maksimal 10 MB.</div>
			 	<?php if ($aktivitas->file_sk_tugas != ''): ?>
			        <input type="hidden" name="file_sk_tugas_temp" value="<?= $aktivitas->file_sk_tugas ?>">
			        <a class="text-decoration-none float-end cursor-pointer" href="javascript:void(0)" onclick="lihat_berkas(`File SK Tugas`, `<?= $aktivitas->file_sk_tugas ?>?time=<?= time() ?>`)"><img src="http://a0.pise.pw/QJGVA" style="margin-top: -4px;"> Lihat Berkas SK Tugas (pdf)</a>
		    	<?php endif; ?>
			</div>
		</div>
		<div class="form-group row mb-2 d-none">
			<label class="col-md-3 col-form-label" for="jenis_anggota">Jenis Anggota <span class="text-danger">*</span></label>
			<div class="col-md-3 mt-2">
				<div class="form-check form-check-inline">
                    <input id="jenis_anggota_personal" class="form-check-input" type="radio" name="jenis_anggota" value="0" <?= ($aktivitas->jenis_anggota == '0') ? 'checked=""' : '' ?> >
                    <label for="jenis_anggota_personal" class="form-check-label">Personal</label>
                </div>
                <div class="form-check form-check-inline">
                    <input id="jenis_anggota_kelompok" class="form-check-input" type="radio" name="jenis_anggota" value="1" <?= ($aktivitas->jenis_anggota == '1') ? 'checked=""' : '' ?>>
                    <label for="jenis_anggota_kelompok" class="form-check-label">Kelompok</label>
                </div>
			</div>
		</div>
		<div class="form-group row mb-2">
			<label class="col-md-3 col-form-label" for="keterangan">Keterangan</label>
			<div class="col-md-6">
				<textarea class="form-control" rows="5" id="keterangan" name="keterangan"><?= $aktivitas->keterangan ?></textarea>
			</div>
		</div>
		<div class="form-group row mt-3">
			<div class="col-md-2 col offset-md-3">
				<button type="reset" class="btn btn-danger w-100"><i class="psi-repeat-3"></i> Reset Perubahan</button>
			</div>
			<div class="col-md-2 col">
				<button class="btn btn-info w-100"><i class="psi-paper-plane"></i> Update Data</button>
			</div>
		</div>
	</form>
</div>