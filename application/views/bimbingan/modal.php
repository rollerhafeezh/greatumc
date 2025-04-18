<style type="text/css">
	.timeline .tl-time:not(:empty) {
	    min-width: 5.5rem!important;
	}
</style>
<!-- Modal Lihat Berkas -->
<div class="modal" id="lihatBerkas" tabindex="-1" aria-labelledby="lihatBerkasLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header bg-primary p-0 py-1">
        <span class="modal-title ms-2 my-1  text-white" style="width: 85%; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">
          <img src="http://a0.pise.pw/QJGVA" style="margin-top: -4px;" class="me-1"> 
          <span id="lihatBerkasLabel">Lihat Berkas</span>
        </span>
        <?php if ($this->router->fetch_class() == 'bimbingan' && $this->router->fetch_method() == 'ketua_sidang' && $this->uri->segment(4) == '5'): ?>
        <a class="btn btn-xs btn-light float-end text-nowrap me-2" id="sinkronisasi_nilai" href="#" onclick="return confirm(`Apakah anda yakin ingin melakukan sinkronisasi nilai ?\nnilai yang sudah masuk transkrip tidak bisa ditarik kembali.`)">Sinkronisasi Nilai</a>
        <?php endif; ?>
        <button type="button" class="border border-dark bg-white p-1 btn-close me-2 text-danger" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0 overflow-hidden" >
      	<iframe  id="lihatBerkasFile" src="#" type="application/pdf" class="w-100 h-100"></iframe>
      </div>
    </div>
  </div>
</div>
<!-- Modal Lihat Berkas -->

<!-- Modal Lokasi -->
<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modal_lokasi_penelitian" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_lokasi_penelitianLabel">Lokasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      	<!-- LOG -->
      	<div class="accordion" id="colorsAccordion">
            <div class="accordion-item border-0">
                <div class="accordion-header" id="colorsAccHeadingOne">
                    <button class="accordion-button bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#log_lokasi" aria-expanded="true" aria-controls="log_lokasi">
                        Riwayat Perubahan
                    </button>
                </div>
                <div id="log_lokasi" class="accordion-collapse bg-light collapse show" aria-labelledby="colorsAccHeadingOne" data-bs-parent="#colorsAccordion" style="">
                    <div class="accordion-body ps-0">
				      	<div class="pb-5">
					      	<div class="timeline">
						      	<?php
						      		$lokasi = $this->Aktivitas_model->aktivitas_log([ 'whois' => $anggota->id_mahasiswa_pt, 'whatdo' => 'simpan_lokasi' ], 'created_at DESC')->result();
						      		echo count($lokasi) < 1 ? '<center class="pt-4 d-block w-100">Belum ada riwayat perubahan.</center>' : '';
						      		$i = 0;
						      		foreach ($lokasi as $lokasi) { $data = json_decode($lokasi->data); ++$i;
						      	?>
					      		<div class="tl-entry <?= ($i == 1 ? 'active' : '') ?>">
					                <div class="tl-time">
					                    <div class="tl-date"><?= date("d/m/Y", strtotime(explode(' ', $lokasi->created_at)[0])) ?></div>
					                    <div class="tl-time"><?= substr(explode(' ', $lokasi->created_at)[1], 0, 5) ?> WIB</div>
					                </div>
					                <div class="tl-point"></div>
					                <div class="tl-content card <?= ($i == 1 ? 'bg-secondary text-white' : '') ?>">
					                    <div class="card-body">
					                        <?= $data->lokasi ?>
					                    </div>
					                </div>
					            </div>
						      	<?php
						      		}
						      	?>
					        </div>
					    </div>
                    </div>
                </div>
            </div>
        </div>
      	<!-- LOG -->
      </div>
    </div>
  </div>
</div>
<!-- Modal Lokasi -->

<!-- Modal Ajukan Judul -->
<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modal_ajukan_judul" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_ajukan_judulLabel">Ajukan Judul Penelitian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php $aktivitas_judul = $this->Aktivitas_model->get($_ENV['DB_AKT'].'aktivitas_judul', ['id_aktivitas' => $aktivitas->id_aktivitas], 'created_at DESC', 3); ?>

        <?php if ($aktivitas_judul->num_rows() > 0): ?>
        <div class="alert alert-info">
          Silahkan periksa judul dan permasalahan yang diajukan oleh mahasiswa dan pilih 1 judul untuk di acc.
        </div>
        <form method="POST" action="<?= base_url('bimbingan/acc_judul') ?>">
          <input type="hidden" name="id_aktivitas" value="<?= $aktivitas->id_aktivitas ?>">
          <?php $i = 1; foreach($aktivitas_judul->result() as $aj): ?>
          <div class="form-check mb-3">
              <input id="acc_judul_<?= $aj->ke ?>" class="form-check-input" type="radio" value="<?= $aj->judul ?>" name="judul" <?= $i == 1 ? 'required' : '' ?>>
              <label for="acc_judul_<?= $aj->ke ?>" class="form-check-label">
                  ACC Judul <?= $aj->ke ?>
              </label>
          </div>
          <div class="form-group mb-3">
            <label for="judul" class="fw-bold">Judul Penelitian <?= $aj->ke ?></label>
            <p align="justify"><?= $aj->judul ?></p>
          </div>
          <div class="form-group">
            <label for="permasalahan" class="fw-bold">Permasalahan <?= $aj->ke ?></label>
            <p align="justify"><?= $aj->permasalahan ?></p>
          </div>
          <hr>
          <?php $i++; endforeach; ?>
          <div class="row">
            <div class="col">
              <button type="submit" class="btn btn-primary d-block w-100" onclick="return confirm('Acc Judul ?')"><i class="psi-paper-plane me-1"></i>Acc Judul</button>
            </div>
          </div>
        </form>
        <?php else: ?>
          <div class="alert alert-info mb-0 text-center"><i class="pli-information me-1"></i>Belum ada judul yang diajukan oleh mahasiswa.</div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<!-- Modal Ajukan Judul -->

<!-- Modal Judul -->
<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modal_judul" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_judulLabel">Judul</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      	<!-- LOG -->
      	<div class="accordion" id="colorsAccordion">
            <div class="accordion-item border-0">
                <div class="accordion-header" id="colorsAccHeadingOne">
                    <button class="accordion-button bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#log_judul" aria-expanded="true" aria-controls="log_judul">
                        Riwayat Perubahan
                    </button>
                </div>
                <div id="log_judul" class="accordion-collapse bg-light collapse show" aria-labelledby="colorsAccHeadingOne" data-bs-parent="#colorsAccordion" style="">
                    <div class="accordion-body ps-0">
				      	<div class="pb-5">
					      	<div class="timeline">
						      	<?php
						      		$judul = $this->Aktivitas_model->aktivitas_log([ 'whois' => $anggota->id_mahasiswa_pt, 'whatdo' => 'simpan_judul' ], 'created_at DESC')->result();
						      		echo count($judul) < 1 ? '<center class="pt-4 d-block w-100">Belum ada riwayat perubahan.</center>' : '';
						      		$i = 0;
						      		foreach ($judul as $judul) { $data = json_decode($judul->data); ++$i;
						      	?>
					      		<div class="tl-entry <?= ($i == 1 ? 'active' : '') ?>">
					                <div class="tl-time">
					                    <div class="tl-date"><?= date("d/m/Y", strtotime(explode(' ', $judul->created_at)[0])) ?></div>
					                    <div class="tl-time"><?= substr(explode(' ', $judul->created_at)[1], 0, 5) ?> WIB</div>
					                </div>
					                <div class="tl-point"></div>
					                <div class="tl-content card <?= ($i == 1 ? 'bg-secondary text-white' : '') ?>">
					                    <div class="card-body">
					                    	<b>"<?= $data->judul ?>"</b>
					                        <br><br>
					                        <i>"<?= $data->judul_en ?>"</i>
					                        <br><br>
					                    	Permasalahan : <br>
					                    	<?= $data->keterangan ?>
					                    </div>
					                </div>
					            </div>
						      	<?php
						      		}
						      	?>
					        </div>
					    </div>
                    </div>
                </div>
            </div>
        </div>
      	<!-- LOG -->
      </div>
    </div>
  </div>
</div>
<!-- Modal Judul -->

<!-- Modal Atur Nilai -->
<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modal_input_nilai" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_input_nilaiLabel">Formulir Penilaian Mahasiswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modal_input_nilaiBody">
        <center class="py-2">
          <div class="spinner-border text-dark d-block mb-1" role="status">
              <span class="visually-hidden">Loading...</span>
          </div>
          Sedang memuat data nilai ....
        </center>
      </div>
    </div>
  </div>
</div>
<!-- Modal Atur Nilai -->

<!-- Modal Sinkronisasi Nilai -->
<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modal_sinkronisasi_nilai" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_input_nilaiLabel">Sinkronisasi Nilai Kegiatan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modal_sinkronisasi_nilaiBody">
        <center class="py-2">
          <div class="spinner-border text-dark d-block mb-1" role="status">
              <span class="visually-hidden">Loading...</span>
          </div>
          Sedang memuat data nilai ....
        </center>
      </div>
    </div>
  </div>
</div>
<!-- Modal Sinkronisasi Nilai -->

<script>
	function lihat_berkas(filename, pdf, pdfviewer='<?= base_url() ?>', id_penjadwalan=null) {
	    if (pdf != '') {
        
        <?php if ($this->router->fetch_class() == 'bimbingan' && $this->router->fetch_method() == 'ketua_sidang' && $this->uri->segment(4) == '5'): ?>
        if (id_penjadwalan) {
          document.getElementById('sinkronisasi_nilai').href = '<?= base_url('bimbingan/sinkronisasi_nilai/') ?>' + id_penjadwalan
          document.getElementById('sinkronisasi_nilai').style.display = 'block'
        } else {
          document.getElementById('sinkronisasi_nilai').style.display = 'none'
        }
        <?php endif; ?>

  			document.getElementById('lihatBerkasLabel').innerHTML = filename
  			document.getElementById('lihatBerkasFile').src = pdfviewer + '/assets/plugins/pdfjs/web/viewer.html?file=' + pdf
  			var myModal = new bootstrap.Modal(document.getElementById('lihatBerkas'))
  			 myModal.show()
	    }
  	}
</script>