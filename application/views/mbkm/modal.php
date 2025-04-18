<style type="text/css">
	.tox {
		border-radius: .4375rem;
	}
</style>

<!-- Modal Tambah Laporan -->
<div class="modal fade" id="modal_tambah_laporan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_tambah_laporan" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><span class="act">Tambah</span> Laporan</h5>
        <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
	  <div class="modal-body p-4">
	  	<form id="form_tambah_laporan" onsubmit="event.preventDefault(); simpan_laporan(this)">
			<input type="hidden" name="id_aktivitas" value="<?= $aktivitas->id_aktivitas ?>">
			<input type="hidden" name="id_laporan" id="id_laporan">
			<div class="row">
				<div class="col-md-12 mb-3">
					<div class="form-group">
						<label class="form-label fw-bold text-dark" for="jenis_laporan">Jenis Laporan <span class="text-danger">*</span></label>
						<select name="jenis_laporan" class="form-select" id="jenis_laporan" required="">
							<option value="" hidden>-- Choose --</option>
							<option value="1">Laporan Awal</option>
							<option value="2">Laporan Mingguan</option>
							<option value="3">Laporan Akhir</option>
						</select>		
					</div>
				</div>
				<div class="col-md-12 mb-3">
					<div class="form-group">
						<label class="form-label fw-bold text-dark" for="minggu_ke">Minggu Ke- <span class="text-danger">*</span></label>
						<select name="minggu_ke" class="form-select" id="minggu_ke" required="">
							<option value="" hidden>-- Choose --</option>
							<?php for ($i=1; $i < 21; $i++) { ?>
							<option value="<?= $i ?>"><?= $i ?></option>
							<?php } ?>	
						</select>		
					</div>
				</div>
				<div class="col-md-12 mb-3">
					<div class="form-group">
						<label class="form-label fw-bold text-dark" for="tgl_laporan">Tanggal Laporan <span class="text-danger">*</span></label>
						<input type="date" name="tgl_laporan" id="tgl_laporan" class="form-control" required="" value="<?= date("Y-m-d") ?>">
					</div>
				</div>
				<div class="col-md-12 mb-3">
					<div class="form-group">
						<label class="form-label fw-bold text-dark" for="rencana_kegiatan">Rencana Kegiatan <span class="text-danger">*</span></label>
						<textarea name="rencana_kegiatan" id="rencana_kegiatan" class="form-control"></textarea>
					</div>
				</div>
				<div class="col-md-12 mb-3">
					<div class="form-group">
						<label class="form-label fw-bold text-dark" for="pelaksanaan_kegiatan">Pelaksanaan Kegiatan <span class="text-danger">*</span></label>
						<textarea name="pelaksanaan_kegiatan" id="pelaksanaan_kegiatan" class="form-control"></textarea>
					</div>
				</div>
				<div class="col-md-12 mb-3">
					<div class="form-group">
						<label class="form-label fw-bold text-dark" for="analisis_hasil_kegiatan">Analisis Hasil Kegiatan <span class="text-danger">*</span></label>
						<textarea name="analisis_hasil_kegiatan" id="analisis_hasil_kegiatan" class="form-control"></textarea>
					</div>
				</div>
				<div class="col-md-12 mb-3">
					<div class="form-group">
						<label class="form-label fw-bold text-dark" for="hambatan">Hambatan dan Upaya Mengatasi Hambatan <span class="text-danger">*</span></label>
						<textarea name="hambatan" id="hambatan" class="form-control"></textarea>
					</div>
				</div>
				<div class="col-md-12 mb-3">
					<div class="form-group">
						<label class="form-label fw-bold text-dark" for="rencana_perbaikan">Rencana Perbaikan dan Tindaklanjut <span class="text-danger">*</span></label>
						<textarea name="rencana_perbaikan" id="rencana_perbaikan" class="form-control"></textarea>
					</div>
				</div>

				<div class="col-md-12 mb-3">
					<div class="form-group">
						<label class="form-label fw-bold text-dark" for="file">Lampiran (Opsional)</label>
						<input type="file" class="form-control" name="file" id="file" accept="application/pdf">
						<small class="text-muted">Berkas dalam format pdf.</small>
						<a href="#" style="display: none" class="file float-end" target="_blank"><small><i class="fa fa-download"></i> Download Berkas</small></a>
					</div>
				</div>
				<div class="col-md-12 mb-3">
					<div class="form-group">
						<label class="form-label fw-bold text-dark" for="file_gambar">Lampiran Foto Kegiatan (Opsional)</label>
						<input type="file" class="form-control" name="file_gambar" id="file_gambar" accept="image/*">
						<small class="text-muted">Berkas dalam gambar (.jpg, .jpeg, .png).</small>
						<a href="#" style="display: none" class=" file_gambar float-end" target="_blank"><small><i class="fa fa-download"></i> Download Berkas</small></a>
					</div>
				</div>
				<div class="col-md-12 mb-3">
					<div class="form-group">
						<button type="submit" class="btn btn-info d-block w-100 btn_simpan_laporan"><i class="psi-paper-plane me-1"></i> Simpan Laporan</button>
					</div>
				</div>
			</div>
		</form>	
	  </div>
    </div>
  </div>
</div>
<!-- Modal Tambah Laporan -->

<!-- Modal Detail Laporan -->
<div class="modal fade text-left" id="modal_detail_laporan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="myModalLabel1"><i class="fas fa-info-circle me-1"></i> Detail Laporan</h5>
        		<button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body p-4 detail_laporan">
				<img src="https://i.pinimg.com/originals/62/c3/79/62c379ae3baad2a6f3810a8ad1a19d47.gif" width="50%" class="d-block" style="margin: 0 auto" alt="Loading ...">
			</div>
		</div>
	</div>
</div>
<!-- Modal Detail Laporan -->

<!-- Modal Tambah Logbook -->
<div class="modal fade" id="modal_tambah_logbook" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_tambah_logbook" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><span class="act">Tambah</span> Logbook</h5>
        <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
	  <div class="modal-body p-4">
	  	<form id="form_tambah_logbook" onsubmit="event.preventDefault(); simpan_logbook(this)" class="row">
	  		<input type="hidden" name="id_aktivitas" value="<?= $aktivitas->id_aktivitas ?>">
	  		<input type="hidden" name="id_logbook" id="id_logbook">
		  	<div class="col-md-12 form-group mb-3">
				<label for="tgl_kegiatan" class="form-label fw-bold text-dark">Tanggal Kegiatan <span class="text-danger">*</span></label>
				<input type="date" name="tgl_kegiatan" id="tgl_kegiatan" value="<?= date('Y-m-d') ?>" class="form-control" required="">
			</div>
			<div class="col-md-12 form-group mb-3">
				<label for="isi" class="form-label fw-bold text-dark">Deskripsi Kegiatan <span class="text-danger">*</span></label>
				<textarea id="isi" class="form-control"></textarea>
				<small class="text-muted">Deskripsi kegiatan (<i>logbook</i>) minimal 25 karakter</small>
			</div>
			<div class="col-md-12 form-group mb-3">
				<label for="file" class="form-label fw-bold text-dark">
					Lampiran (Opsional)
				</label>
				<input type="file" class="form-control" name="file" id="file" accept="application/pdf">
				<small class="text-muted">Berkas dalam format pdf.</small>
				<a href="#" style="display: none" class="file float-end" download><small><i class="fa fa-download me-1"></i> Unduh Berkas</small></a>
			</div>
			<div class="col-md-12 form-group mb-3">
				<label for="file_gambar" class="form-label fw-bold text-dark">
					Lampiran Foto Kegiatan (Opsional)
				</label>
				<input type="file" class="form-control" name="file_gambar" id="file_gambar" accept="image/*">
				<small class="text-muted">
					Berkas dalam format gambar (.jpeg, .jpg, .png).
					<a href="#" style="display: none" class="float-end file_gambar" download><small><i class="fa fa-download"></i> Unduh Berkas</small></a>
				</small>
			</div>
			<div class="col-md-12">
				<button class="btn btn-info w-100"><i class="psi-paper-plane me-1"></i> Simpan Logbook</button>
			</div>
	  	</form>
	  </div>
    </div>
  </div>
</div>
<!-- Modal Tambah Logbook -->


<!-- Modal Detail Logbook -->
<div class="modal fade text-left" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="myModalLabel1"><i class="fas fa-info-circle me-1"></i> Detail Logbook</h5>
        		<button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body p-4 detail">
				<img src="https://i.pinimg.com/originals/62/c3/79/62c379ae3baad2a6f3810a8ad1a19d47.gif" width="50%" class="d-block" style="margin: 0 auto" alt="Loading ...">
			</div>
		</div>
	</div>
</div>
<!-- Modal Detail Logbook -->