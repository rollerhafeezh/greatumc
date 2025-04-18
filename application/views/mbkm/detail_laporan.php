<style type="text/css">
	.form-group label {
		font-weight: bold;
	}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="form-group mb-3">
			<label class="form-label text-dark" >Status</label>
			<?php $status = ['Revisi', 'Disetujui']; ?>
			
			<?php if ($_SESSION['app_level'] == 2): ?>
			<select name="status" id="status" required="" class="form-select" data-id="<?= sha1($detail->id_laporan) ?>" onchange="ubah_status(this, `laporan`)">
				<option value="" hidden="">Diproses (Menunggu Persetujuan)</option>
			<?php
				for ($i=0; $i < count($status); $i++) { 
					echo '<option value="'.$i.'" '.( ($i == $detail->status && $detail->status != '') ? 'selected' : '').'>'.$status[$i].'</option>';
				}
			?>
			</select>

			<?php else: ?>
			<p><?= $detail->status != '' ? $status[$detail->status] : 'Diproses (Menunggu Persetujuan)' ?></p>
			<?php endif; ?>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label class="form-label text-dark" >Tgl. Laporan</label>
			<p><?= tanggal_indo($detail->tgl_laporan) ?></p>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label class="form-label text-dark" >Rencana Kegiatan</label>
			<?= $detail->rencana_kegiatan ?>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label class="form-label text-dark" >Pelaksanaan Kegiatan</label>
			<?= $detail->pelaksanaan_kegiatan ?>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label class="form-label text-dark" >Analisis Hasil Kegiatan</label>
			<?= $detail->analisis_hasil_kegiatan ?>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label class="form-label text-dark" >Hambatan dan Upaya Mengatasi Hambatan</label>
			<?= $detail->hambatan ?>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label class="form-label text-dark" >Rencana Perbaikan dan Tindaklanjut</label>
			<?= $detail->rencana_perbaikan ?>
		</div>
	</div>
	<div class="col-md-12 mb-3 <?= $detail->file == '' ? 'd-none' : '' ?>">
		<div class="form-group">
			<label class="form-label text-dark" >Lampiran (.pdf)</label>
			<a class="d-block" href="<?= $detail->file ?>" download><i class="fa fa-download"></i> Unduh Lampiran</a>
		</div>
	</div>
	<div class="col-md-12 mb-3 <?= $detail->file_gambar == '' ? 'd-none' : '' ?>">
		<div class="form-group">
			<label class="form-label text-dark" >Lampiran Foto Kegiatan</label>
			<a class="d-block" href="<?= $detail->file_gambar ?>" download><i class="fa fa-download"></i> Unduh Lampiran</a>
		</div>
	</div>
</div>

<div class="tanggapan row" style="display: <?= ($detail->status != 0 OR $detail->status == '') ? 'none' : ''; ?>;">
	<div class="col-md-12 mb-3">
		<label for="tanggapan" class="fw-bold text-dark form-label mb-3">Tanggapan Revisi</label>
		<?php if ($_SESSION['app_level'] == 2): ?>
		<form onsubmit="event.preventDefault(); simpan_tanggapan(this, `<?= sha1($detail->id_laporan) ?>`, `laporan`)" class="mb-3">
			<input type="hidden" name="id_parent" value="<?= $detail->id_laporan ?>">
			<textarea name="isi" id="tanggapan" class="form-control" rows="3"></textarea>
			<button class="btn btn-info d-block w-100 mt-2"><i class="psi-paper-plane me-1"></i> Kirim Tanggapan</button>
		</form>
		<?php endif; ?>	
 		
		<div class="accordion" id="colorsAccordion">
	        <div class="accordion-item border-0">
	            <div class="accordion-header" id="colorsAccHeadingOne">
	                <button class="accordion-button bg-light shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#laporan" aria-expanded="true" aria-controls="laporan">
	                    <i class="psi-hour me-1"></i> Riwayat Tanggapan
	                </button>
	            </div>
	            <div id="laporan" class="accordion-collapse bg-light collapse show" aria-labelledby="colorsAccHeadingOne" data-bs-parent="#colorsAccordion" style="">
	                <div class="accordion-body ps-0">
				      	<div class="pb-5">
					      	<div class="timeline">
					      		<?php if(count($tanggapan) < 1): ?>
					      			<span class="text-center w-100">
						      			<i class="psi-speech-bubble-dialog me-1"></i> <i>Tanggapan revisi masih kosong.</i>
					      			</span>
					      		<?php endif; ?>

					      		<?php foreach($tanggapan as $row): ?>
					      		<div class="tl-entry">
					                <div class="tl-time">
					                    <div class="tl-date"><?= date("d/m/Y", strtotime(explode(' ', $row->created_at)[0])) ?></div>
					                    <div class="tl-time"><?= substr(explode(' ', $row->created_at)[1], 0, 5) ?> WIB</div>
					                </div>
					                <div class="tl-point"></div>
					                <div class="tl-content card ">
					                    <div class="card-body">
					                    	<?php if ($_SESSION['app_level'] == 2): ?>
					                    	<a class="badge badge-super bg-danger text-decoration-none text-white" href="javascript:void(0)" onclick="hapus_tanggapan(`<?= sha1($row->id_tanggapan) ?>`, `<?= sha1($row->id_parent) ?>`, `laporan`)">
                                                <i class="fa fa-remove"></i>
                                            </a>
                                        	<?php endif; ?>

				  							<?= $row->isi ?>
					                    </div>
					                </div>
					            </div>
	  							<?php endforeach; ?>
					        </div>
					    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
</div>