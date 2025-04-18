<?php $cek_penjadwalan = $this->Aktivitas_model->penjadwalan('p.id_aktivitas = "'. $aktivitas->id_aktivitas.'" AND "'.date('Y-m-d_H:i:s').'" >= p.tanggal AND p.status = "0" ')->row(); ?>
<?php if($cek_penjadwalan): ?>
<div class="content__boxed">
    <div class="content__wrap pb-0">
        <div class="row">
            <div class="col-md-12">
                <style>
                    #jitsiConferenceFrame0 { border-radius: .4375rem }
                </style>

                <div id="meet"></div>
                <script src='https://meet.jit.si/external_api.js'></script>
                <script>
                    const domain = '<?= domain_jitsi($anggota->id_mahasiswa_pt) ?>';
                    const options = {
                        roomName: '<?= format_nama($cek_penjadwalan->deskripsi) ?>',
                        width: '100%',
                        height: 500,
                        parentNode: document.querySelector('#meet'),
                        configOverwrite: { 
                            startWithAudioMuted: true,
                            startWithVideoMuted: true,
                        },
                        userInfo: {
                            displayName: '<?= format_nama($_SESSION['nama_pengguna']) ?> (DOSEN PEMBIMBING)'
                        }
                    };
                    const api = new JitsiMeetExternalAPI(domain, options);
                    api.executeCommand('subject', '<?= strtoupper($cek_penjadwalan->deskripsi) ?> (<?= format_nama($anggota->nm_pd) ?>)')
                    api.executeCommand('avatarUrl', '<?= $_SESSION['picture'] ?>');
                </script>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<?php $this->load->view('bimbingan/meet') ?>
<?php endif; ?>

<div class="content__boxed">
    <div class="content__wrap">
        <style type="text/css">
            a, a:hover {
                text-decoration: none!important;
            }
        </style>
    	<div class="row">
    		<?php $this->load->view('bimbingan/identitas'); ?>
    		
    		<div class="col-md">
		        <section class="card mb-3">
		            <div class="card-body">
	            		<div class="float-end">
	            			<?php if (isset($_GET['meet'])): ?>
	            				<a href="<?= base_url($this->uri->uri_string()) ?>" class="btn btn-primary btn-xs position-relative">Stop Meet</a>
	            			<?php else: ?>
	            				<a href="<?= base_url($this->uri->uri_string().'?meet') ?>" class="btn btn-info btn-xs position-relative mx-1 <?= $cek_penjadwalan ? 'd-none' : '' ?>">Meet Online</a>
	            			<?php endif; ?>
	            		</div>

		        		<h5 class="card-title mb-1">Catatan Bimbingan / Revisi</h5>

                        <br>
                        <form method="POST" enctype="multipart/form-data" onsubmit="event.preventDefault(); kirim(this)">
                            <input type="hidden" name="jenis_bimbingan" value="<?= $jenis_bimbingan ?>">
                            <input type="hidden" name="id_aktivitas" value="<?= $aktivitas->id_aktivitas ?>">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Tulis sesuatu ..." id="isi" name="isi" style="height: 120px" required=""></textarea>
                                        <label for="isi">Tulis sesuatu ...</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <select id="inputState" class="form-select mt-2" name="id_kegiatan" required="">
                                        <option value="" hidden="">Pilih Jenis Catatan</option>
                                        <option value="0">Bimbingan</option>
                                        <?php foreach ($kegiatan as $kegiatan): ?>
                                        <option value="<?= $kegiatan->id_kegiatan ?>">Revisi <?= $kegiatan->deskripsi ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-8 mt-2">
                                    <input id="fileInput" name="file" class="form-control" type="file">
                                </div>
                                <div class="col-md-4 mt-2">
                                    <button class="btn btn-secondary w-100"><i class="psi-paper-plane"></i> Kirim</button>
                                </div>
                            </div>
                        </form>
                        <br>
                        <div class="alert alert-info py-2"><b>Info:</b> Catatan atau revisi yang bisa dihapus hanya pada label <span class="badge bg-info">Saya</span></div>
		        		<div class="bimbingan mt-3 d-block">
		        			<center class="py-2">
			        			<div class="spinner-border text-dark d-block mb-1" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
	                            Sedang memuat data bimbingan ....
		        			</center>
		        		</div>
		            </div>
		        </section>
    		</div>
    	</div>

    </div>
</div>
<?php $this->load->view('bimbingan/modal') ?>
<?php $this->load->view('bimbingan/script.php') ?>