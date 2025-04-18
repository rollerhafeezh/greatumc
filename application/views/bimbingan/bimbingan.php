<?php if ( !in_array($_SESSION['app_level'], $app_level_dosen) ): ?>
    <p class="text-center text-danger mt-5">
        <img src="<?= base_url('assets/images/system_error.png') ?>" class="d-block mx-auto">
        Data bimbingan / revisi tidak akan tersimpan karena sesi login kamu sudah berubah, silahkan reload halaman ini.
    </p>
<?php exit; endif; ?>

<?php if (count($bimbingan) < 1): ?>
	<p class="text-center mt-5">
        <i class="psi-speech-bubble-dialog d-block fs-1 mb-2"></i>
        Data bimbingan masih kosong.
    </p>

<?php else: $i = 1; $rows = count($bimbingan); ?>
	<?php foreach ($bimbingan as $bimbingan): ?>
	<div class="media mt-3 pb-3 d-block" style="<?= ($i != $rows) ? 'border-bottom: 1px dashed rgba(0, 0, 0, 0.1);' : 'padding-bottom: 5px !important;'; ?>">
        <div class="media-body position-relative">
        	<small class="position-absolute timeago" style="right: 0; top: 2px" data-bs-toggle="tooltip" title="<?= tanggal_indo(explode(' ', $bimbingan->created_at)[0]).' '.explode(' ', $bimbingan->created_at)[1] ?>" data-bs-original-title="AW" datetime="<?= $bimbingan->created_at ?>" ><?= tanggal_indo($bimbingan->created_at) ?></small>
            <p class="text-bold-600 mb-0" style="width: 80%">
	                <a class="fw-bold"
	                    <?php if($bimbingan->id_user == $_SESSION['username']): ?>
	                    onclick="hapus_bimbingan(this)" 
	                    data-id_bimbingan="<?= $bimbingan->id_bimbingan ?>"
	                    data-file="<?= $bimbingan->file ?>"
	                    <?php endif; ?>
	                    href="javascript:void(0)"
	                >
    	                <?= $bimbingan->nama_user ?>
        	        </a>

                    (<?= $bimbingan->level_name ?>) 
                    <span class="badge bg-secondary">
                    	<i class="psi-quill-3 me-1"></i> 
                    	<?= $bimbingan->nama_kegiatan != '' ? 'Revisi '.$bimbingan->deskripsi : 'Bimbingan' ?>
                    </span>
                    <span class="badge bg-info <?= $_SESSION['username'] == $bimbingan->id_user ? 'd-inline-block' : 'd-none' ?>">Saya</span>
            </p>
            <p class="m-0 mt-1"><?= strip_tags(urldecode($bimbingan->isi), '<br>') ?></p>

            <?php if ($bimbingan->file != ''): ?>
            <a href="<?= $bimbingan->file ?>" class="d-inline-block text-center mt-1 " target="_blank" download data-toggle="tooltip" title="<?= $bimbingan->file ?>">
                <i class="psi-paperclip me-1" style="margin-top: -4px;"></i>
                Unduh Lampiran Berkas (<?= substr(get_headers($bimbingan->file, 1)[0], 9, 3) < 400 ? round(get_headers($bimbingan->file, 1)['Content-Length']/ 1024, 2) : '~' ?> KB)
            </a>
            <?php endif; ?>
            
            <?php
            $i++;
            $sub_bimbingan  = $this->Aktivitas_model->bimbingan([ 'id_parent' => $bimbingan->id_bimbingan ], 'b.created_at asc')->result();

			if (count($sub_bimbingan) < 1): ?>
        	<!-- KIRIM CATATAN -->
            <div class="media mt-2">
                <div class="media-body position-relative">
                    <fieldset class="form-group position-relative has-icon-left mb-0">
                        <div class="kirim_bimbingan position-relative">
                            <i class="psi-speech-bubble-dialog position-absolute fs-5" style="left: 17px; top: 12px;"></i>
                            <input required="" onkeypress="kirim(this, event)" type="text" class="form-control ps-5" placeholder="Tulis sesuatu ..." data-id_parent="<?= $bimbingan->id_bimbingan ?>" data-id_aktivitas="<?= $bimbingan->id_aktivitas ?>" data-jenis_bimbingan="<?= $bimbingan->jenis_bimbingan ?>" data-id_kegiatan="<?= $bimbingan->id_kegiatan ?>">
                        </div>
                        <small class="form-help">Tekan <b>Enter</b> untuk mengirim.</small>
                        <label class="form-help float-end text-info text-right">
                            <small data-bs-toggle="tooltip" data-original-title="Maksimal 5 MB">
                                <input type="file" name="file" class="d-none" onclick="is_open = true" onblur="is_open = false" onchange="lampirkan_berkas(this)">
                                <i class="psi-paperclip me-1"></i>
                                <span>Lampirkan Berkas (Maks. <?= ($_ENV['MAX_UPLOADED_SIZE'] / 1000) ?> MB)</span>
                            </small>
                        </label>
                        <div class="form-control-position" bis_skin_checked="1">
                            <i class="ft-message-square"></i>
                        </div>
                    </fieldset>
                </div>
            </div>
            <!-- KIRIM CATATAN -->

            <!-- LIST SUB BIMBINGAN -->
            <?php else: ?>
            <?php foreach ($sub_bimbingan as $sub_bimbingan): ?>
            <div class="media mt-2 ms-4" >
                <div class="media-left pr-2" ></div>
                <div class="media-body position-relative" >
                    <small class="position-absolute timeago" style="right: 0; top: 0"  data-toggle="tooltip" title="<?= tanggal_indo(explode(' ', $sub_bimbingan->created_at)[0]).' '.explode(' ', $sub_bimbingan->created_at)[1] ?>" datetime="<?= $sub_bimbingan->created_at ?>" ><?= $sub_bimbingan->created_at ?></small>
                    <p class="text-bold-600 mb-0" style="width: 80%;">
                        <a 	class="fw-bold"
                            <?php if($sub_bimbingan->id_user == $_SESSION['username']): ?>
                            onclick="hapus_bimbingan(this)" 
                            data-id_bimbingan="<?= $sub_bimbingan->id_bimbingan ?>"
                            data-file="<?= $sub_bimbingan->file ?>"
                            <?php endif; ?>
                            href="javascript:void(0)"
                        >
                        	<?= $sub_bimbingan->nama_user ?>
                    	</a>
                        (<?= $sub_bimbingan->level_name ?>) 
                        <span class="badge bg-info <?= $_SESSION['username'] == $sub_bimbingan->id_user ? 'd-inline-block' : 'd-none' ?>">Saya</span>
                    </p>
                    <p class="m-0"><?= strip_tags(urldecode($sub_bimbingan->isi), '<br>') ?></p>

                    <?php if ($sub_bimbingan->file != ''): ?>
                    <a href="<?= $sub_bimbingan->file ?>" class="d-inline-block text-center mt-1 " target="_blank" download data-toggle="tooltip" title="<?= $sub_bimbingan->file ?>">
                        <i class="psi-paperclip me-1" style="margin-top: -4px;"></i>
                        Unduh Lampiran Berkas (<?= substr(get_headers($sub_bimbingan->file, 1)[0], 9, 3) < 400 ? round(get_headers($sub_bimbingan->file, 1)['Content-Length']/ 1024, 2) : '~' ?> KB)
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>

            <!-- KIRIM CATATAN -->
            <div class="media mt-2 ms-4">
                <div class="media-body position-relative">
                    <fieldset class="form-group position-relative has-icon-left mb-0">
                        <div class="kirim_bimbingan position-relative">
                            <i class="psi-speech-bubble-dialog position-absolute fs-5" style="left: 17px; top: 12px;"></i>
                            <input required="" onkeypress="kirim(this, event)" type="text" class="form-control ps-5" placeholder="Tulis sesuatu ..." data-id_parent="<?= $bimbingan->id_bimbingan ?>" data-id_aktivitas="<?= $bimbingan->id_aktivitas ?>" data-jenis_bimbingan="<?= $bimbingan->jenis_bimbingan ?>" data-id_kegiatan="<?= $bimbingan->id_kegiatan ?>">
                        </div>
                        <small class="form-help">Tekan <b>Enter</b> untuk mengirim.</small>
                        <label class="form-help float-end text-info text-right">
                            <small data-toggle="tooltip" title="" data-original-title="Maksimal 5 MB">
                                <input type="file" name="file" class="d-none" onclick="is_open = true" onblur="is_open = false" onchange="lampirkan_berkas(this)">
                                <i class="psi-paperclip me-1"></i>
                                <span>Lampirkan Berkas (Maks. <?= ($_ENV['MAX_UPLOADED_SIZE'] / 1000) ?> MB)</span>
                            </small>
                        </label>
                        <div class="form-control-position" bis_skin_checked="1">
                            <i class="ft-message-square"></i>
                        </div>
                    </fieldset>
                </div>
            </div>
            <!-- KIRIM CATATAN -->

        	<?php endif; ?>
        </div>
    </div>
	<?php endforeach; ?>
<?php endif; ?>