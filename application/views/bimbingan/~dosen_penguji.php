<div class="content__header content__boxed overlapping">
    <div class="content__wrap">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= base_url('dasbor') ?>">Dasbor</a></li>
                <li class="breadcrumb-item"><a href="#">Bimbingan</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
            </ol>
        </nav>
        <!-- END : Breadcrumb -->

        <h1 class="page-title mb-0 mt-2"><?= $title ?></h1>
        <p class="lead">Kelola data bimbingan bersama <?= $title ?></p>
    </div>
</div>

<div class="content__boxed">
    <div class="content__wrap">
        <div class="card text-center mb-4 col-xl-6 offset-xl-3">
            <div class="card-body">
            	<img src="<?= base_url('assets/img/no user.jpg') ?>" class="img-fluid w-50 mb-2" alt="">
                <h5 class="card-title"><?= $title ?> tidak tersedia!</h5>
                <p class="mb-5">
                	<?= $title ?> hanya muncul apabila sudah di-ploting oleh program studi.
                </p>
            </div>
        </div>

    </div>
</div>

<?php if (false): ?>
<!-- <div class="content__boxed">
	<div class="content__wrap">
		<img src="https://danypambudi.com/wp-content/uploads/2020/04/meeting-screen_jitsi2.png" class="img-fluid rounded" alt="">
	</div>
</div> -->
<div class="content__boxed">
    <div class="content__wrap">

    	<div class="row">
    		<?php $this->load->view('skripsi/identitas'); ?>
    		
    		<div class="col-md">
		        <section class="card mb-3">
		            <div class="card-body">
		            	<div>
		            		<div class="float-end">
		            			<button type="button" class="btn btn-primary btn-xs position-relative">Bimbingan Online</button>
		            		</div>
			        		<h5 class="card-title">Bimbingan</h5>
			        		<!-- <p class="text-center mt-5">
			        			<i class="psi-speech-bubble-dialog d-block fs-1 mb-2"></i>
			        			Data bimbingan masih kosong.
			        		</p> -->

			        		<?php if(true): ?>
			        			<div class="media mb-4 pb-4 mt-4" style="line-height: 1.5; border-bottom: 1px solid rgba(0, 0, 0, 0.1);">
						        <div class="media-body position-relative">
						        	<small class="position-absolute timeago" style="right: 0; top: 0" data-bs-toggle="tooltip" title="01 September 2022">1 jam yang lalu</small>
						            <p class="text-bold-600 mb-0">
						                <a>
						                    <span class="text-info">
						                        Nurhidayat
						                    </span> 
						                    (Dosen)
						                     <span class="badge bg-secondary">Revisi Seminar Usulan Penelitian</span>
						                </a>
						            </p>

						            <p class="m-0">Perbaiki proposal penelitian</p>

						            <!-- KIRIM CATATAN -->
						            <div class="media mt-2">
						                <div class="media-body position-relative">
								            <fieldset class="form-group position-relative has-icon-left mb-0">
							                    <input required="" onkeypress="kirim(this, event)" type="text" class="form-control font-small-3" placeholder="Tulis sesuatu ..." data-id_parent="374" data-id_aktivitas="1163">
							                    <small class="form-help font-small-2">Tekan <b>Enter</b> untuk mengirim.</small>
							                    <label class="form-help font-small-2 float-end text-info text-right">
								                    <input type="file" name="file" class="d-none" onchange="lampirkan_dokumen(this)">
								                    <small data-toggle="tooltip" title="" data-original-title="Maksimal 5 MB">
								                    	<i class="psi-paperclip me-1"></i>
								                		Lampirkan Berkas
								                	</small>
								                </label>
							                    <div class="form-control-position" bis_skin_checked="1">
							                        <i class="ft-message-square"></i>
							                    </div>
							                </fieldset>
										</div>
						            </div>
						            <!-- KIRIM CATATAN -->
								</div>
						    </div>
			        		<div class="media mb-4 pb-4 mt-4" style="line-height: 1.5; border-bottom: 1px solid rgba(0, 0, 0, 0.1);">
						        <div class="media-body position-relative">
						        	<small class="position-absolute timeago" style="right: 0; top: 0" data-bs-toggle="tooltip" title="01 September 2022">1 jam yang lalu</small>
						            <p class="text-bold-600 mb-0">
						                <a>
						                    <span class="text-info">
						                        Nurhidayat
						                    </span> 
						                    (Dosen)
						                     <span class="badge bg-secondary">Bimbingan</span>
						                </a>
						            </p>

						            <p class="m-0">Revisi Bab 3 terkait aturan pengadaan!</p>
						            
						            <!-- SUB BIMBINGAN -->
                	           		<div class="media mt-2">
						                <div class="media-body position-relative ps-4">
						        			<small class="position-absolute timeago" style="right: 0; top: 0" data-bs-toggle="tooltip" title="01 September 2022">1 jam yang lalu</small>
						                    <p class="text-bold-600 mb-0">
						                        <a onclick="hapus(this)" data-id_bimbingan="377" data-file="https://skripsi.unma.ac.id/berkas/bimbingan/Ujian_Susulan.pdf">
						                            <span class="text-info">
						                                Hafidz Sanjaya
						                            </span> 
						                            (Mahasiswa) 
						                            <span class="badge bg-info d-inline-block">Saya</span>
						                        </a>
						                    </p>
						                    <p class="m-0">Berikut disampaikan dokumen bab 3, mohon koreksinya pak</p>

						                                        <a href="https://skripsi.unma.ac.id/berkas/bimbingan/Ujian_Susulan.pdf" class="d-block  text-center w-100 p-3 text-decoration-none" style="border: 1px dashed silver; margin-top: 5px;" data-toggle="tooltip" title="" target="_blank" data-original-title="https://skripsi.unma.ac.id/berkas/bimbingan/Ujian_Susulan.pdf">
						                    	<i class="ft-download"></i> Unduh Berkas
						                    </a>
										</div>
						            </div>

						        	<div class="media mt-2">
						                <div class="media-left pe-4"></div>
						                <div class="media-body position-relative">
						        			<small class="position-absolute timeago" style="right: 0; top: 0" data-toggle="tooltip" title="" datetime="2021-01-12 14:23:10" timeago-id="526" data-original-title="12 Januari 2021 14:23:10">1 jam yang lalu</small>
						                    <p class="text-bold-600 mb-0">
						                        <a>
						                            <span class="text-info">
						                                Nurhidayat
						                            </span> 
						                            (Dosen) 
						                            <span class="badge bg-info d-none">Saya</span>
						                        </a>
						                    </p>
						                    <p class="m-0">Baik, saya akan baca dulu</p>

										</div>
						            </div>
						            <!-- SUB BIMBINGAN -->

						            <!-- KIRIM CATATAN -->
						            <div class="media mt-2">
						                <div class="media-body position-relative ps-4">
								            <fieldset class="form-group position-relative has-icon-left mb-0">
							                    <input required="" onkeypress="kirim(this, event)" type="text" class="form-control font-small-3" placeholder="Tulis sesuatu ..." data-id_parent="374" data-id_aktivitas="1163">
							                    <small class="form-help font-small-2">Tekan <b>Enter</b> untuk mengirim.</small>
							                    <label class="form-help font-small-2 float-end text-info text-right">
								                    <input type="file" name="file" class="d-none" onchange="lampirkan_dokumen(this)">
								                    <small data-toggle="tooltip" title="" data-original-title="Maksimal 5 MB">
								                    	<i class="psi-paperclip me-1"></i>
								                		Lampirkan Berkas
								                	</small>
								                </label>
							                    <div class="form-control-position" bis_skin_checked="1">
							                        <i class="ft-message-square"></i>
							                    </div>
							                </fieldset>
										</div>
						            </div>
						            <!-- KIRIM CATATAN -->
								</div>
						    </div>

						    <div class="media mb-4 mt-4" style="line-height: 1.5;">
						        <div class="media-body position-relative">
						        	<small class="position-absolute timeago" style="right: 0; top: 0" data-bs-toggle="tooltip" title="01 September 2022">1 jam yang lalu</small>
						            <p class="text-bold-600 mb-0">
						                <a>
						                    <span class="text-info">
						                        Nurhidayat
						                    </span> 
						                    (Dosen)
						                     <span class="badge bg-secondary">Bimbingan</span>
						                </a>
						            </p>

						            <p class="m-0">Revisi Bab 3 terkait aturan pengadaan!</p>
						            
						            <!-- SUB BIMBINGAN -->
                	           		<div class="media mt-2">
						                <div class="media-body position-relative ps-4">
						        			<small class="position-absolute timeago" style="right: 0; top: 0" data-bs-toggle="tooltip" title="01 September 2022">1 jam yang lalu</small>
						                    <p class="text-bold-600 mb-0">
						                        <a onclick="hapus(this)" data-id_bimbingan="377" data-file="https://skripsi.unma.ac.id/berkas/bimbingan/Ujian_Susulan.pdf">
						                            <span class="text-info">
						                                Hafidz Sanjaya
						                            </span> 
						                            (Mahasiswa) 
						                            <span class="badge bg-info d-inline-block">Saya</span>
						                        </a>
						                    </p>
						                    <p class="m-0">Berikut disampaikan dokumen bab 3, mohon koreksinya pak</p>

						                                        <a href="https://skripsi.unma.ac.id/berkas/bimbingan/Ujian_Susulan.pdf" class="d-block  text-center w-100 p-3 text-decoration-none" style="border: 1px dashed silver; margin-top: 5px;" data-toggle="tooltip" title="" target="_blank" data-original-title="https://skripsi.unma.ac.id/berkas/bimbingan/Ujian_Susulan.pdf">
						                    	<i class="ft-download"></i> Unduh Berkas
						                    </a>
										</div>
						            </div>

						        	<div class="media mt-2">
						                <div class="media-body position-relative ps-4">
						        			<small class="position-absolute timeago" style="right: 0; top: 0" data-toggle="tooltip" title="" datetime="2021-01-12 14:23:10" timeago-id="526" data-original-title="12 Januari 2021 14:23:10">1 jam yang lalu</small>
						                    <p class="text-bold-600 mb-0">
						                        <a>
						                            <span class="text-info">
						                                Nurhidayat
						                            </span> 
						                            (Dosen) 
						                            <span class="badge bg-info d-none">Saya</span>
						                        </a>
						                    </p>
						                    <p class="m-0">Baik, saya akan baca dulu</p>

										</div>
						            </div>
						            <!-- SUB BIMBINGAN -->

						            <!-- KIRIM CATATAN -->
						            <div class="media mt-2">
						                <div class="media-body position-relative ps-4">
								            <fieldset class="form-group position-relative has-icon-left mb-0">
							                    <input required="" onkeypress="kirim(this, event)" type="text" class="form-control font-small-3" placeholder="Tulis sesuatu ..." data-id_parent="374" data-id_aktivitas="1163">
							                    <small class="form-help font-small-2">Tekan <b>Enter</b> untuk mengirim.</small>
							                    <label class="form-help font-small-2 float-end text-info text-right">
								                    <input type="file" name="file" class="d-none" onchange="lampirkan_dokumen(this)">
								                    <small data-toggle="tooltip" title="" data-original-title="Maksimal 5 MB">
								                    	<i class="psi-paperclip me-1"></i>
								                		Lampirkan Berkas
								                	</small>
								                </label>
							                    <div class="form-control-position" bis_skin_checked="1">
							                        <i class="ft-message-square"></i>
							                    </div>
							                </fieldset>
										</div>
						            </div>
						            <!-- KIRIM CATATAN -->

								</div>
						    </div>
							<?php endif; ?>

		            	</div>
		            </div>
		        </section>
    		</div>
    	</div>

    </div>
</div>
<?php endif; ?>