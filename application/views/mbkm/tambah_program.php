<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
			<div class="col-md-8 offset-md-2 mb-3">
				<div class="card">
					<div class="card-body">
                        <h5 class="card-title">Data Program Kampus Merdeka</h5>
                        <form class="row" method="POST" action="<?= base_url('mbkm/simpan') ?>" enctype="multipart/form-data">
                            <div class="col-md-6 mb-3">
                                <label for="id_program" class="form-label">Skema Program <span class="text-danger">*</span></label>
                                <select class="form-select" id="id_program" name="id_program" required="">
                                    <option hidden="" value="">Pilih Skema Program</option>
                                    <?php foreach($this->Mbkm_model->program_mbkm(null, 'nama_jenis_aktivitas_mahasiswa ASC')->result() as $program): ?>
                                    <option value="<?= $program->id_program ?>"><?= $program->nama_jenis_aktivitas_mahasiswa ?> <?= $program->nama_program ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="jenis_program" class="form-label">Jenis Program <span class="text-danger">*</span></label>
                                <select class="form-select" id="jenis_program" name="jenis_program" required="">
                                    <option hidden="" value="">Pilih Jenis Program</option>
                                    <option value="1">Program Mandiri</option>
                                    <option value="2">Program Kementrian (Pusat)</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="id_mitra" class="form-label">Lokasi Kegiatan (Mitra) <span class="text-danger">*</span></label>
                                <input type="search" class="form-control" required="" id="id_mitra" list="mitra" name="id_mitra" placeholder="Ketikan Nama Mitra atau Merek" onchange="castvote(this); document.querySelector('#hidden_id_mitra').value = document.querySelector(`#mitra > option[value='${this.value}']`).dataset.id_mitra; ">
                                <!-- <select class="form-select" id="id_mitra" name="id_mitra" required=""> -->
                                    <!-- <option hidden="" value="">Pilih Lokasi Kegiatan (Mitra)</option> -->
                                <datalist id="mitra">
                                    <?php foreach($this->Mbkm_model->mitra(null, 'nama_resmi ASC')->result() as $mitra): ?>
                                    <option value="<?= $mitra->nama_merek ?>" data-id_mitra="<?= $mitra->id_mitra ?>"><?= $mitra->nama_resmi ?></option>
                                    <?php endforeach; ?>
                                </datalist>
                                <input type="hidden" id="hidden_id_mitra" name="id_mitra">
                                <!-- </select> -->
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="judul_kegiatan" class="form-label">Judul Kegiatan <span class="text-danger">*</span></label>
                                <input type="text" name="judul_kegiatan" id="judul_kegiatan" class="form-control" placeholder="Contoh: Kampus Mengajar Angkatan 5 Tahun 2023" required="">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi Kegiatan <span class="text-danger">*</span></label>
                                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="8" placeholder="Jelaskan informasi mengenai kegiatan program kampus merdeka." required=""></textarea>
                            </div>

                            <h5 class="card-title mt-3">Periode Pendaftaran & Pelaksanaan</h5>
                            <div class="col-md-6 mb-3">
								<label for="id_smt" class="form-label">Semester Pelaksanaan <span class="text-danger">*</span></label>
								<select id="id_smt" name="id_smt" class="form-select" required="">
									<option value="" hidden="">Pilih Semester Pelaksanaan</option>
									<?php 
										$ref_smt 	= $this->Main_model->ref_smt();
										foreach($ref_smt as $ket=>$value)
										{
											echo'<option value="'.$value->id_semester.'">'.$value->nama_semester.'</option>';
										}
									?>
								</select>
							</div>
                            <div class="col-md-3 col-6 mb-3">
                                <label for="kuota" class="form-label">Kuota (Orang) <span class="text-danger">*</span></label>
                            	<input type="number" name="kuota" id="kuota" min="0" step="1" required="" class="form-control">
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <label for="sks_diakui" class="form-label">SKS Diakui <span class="text-danger">*</span></label>
                            	<input type="number" name="sks_diakui" id="sks_diakui" min="0" step="1" required="" class="form-control">
                            </div>
							<div class="col-md-3 col-6 mb-3">
								<label for="tgl_mulai_daftar" class="form-label">Periode Pendaftaran <span class="text-danger">*</span></label>
								<input type="date" name="tgl_mulai_daftar" id="tgl_mulai_daftar" class="form-control" required>
								<small class="text-muted">Batas Awal Pendaftaran</small>
							</div>
							<div class="col-md-3 col-6 mb-3">
								<label for="tgl_selesai_daftar" class="form-label">&nbsp;</label>
								<input type="date" name="tgl_selesai_daftar" id="tgl_selesai_daftar" class="form-control" required>
								<small class="text-muted">Batas Akhir Pendaftaran</small>
							</div>
							<div class="col-md-3 col-6 mb-3">
								<label for="tgl_mulai" class="form-label">Periode Pelaksanaan <span class="text-danger">*</span></label>
								<input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control" required>
								<small class="text-muted">Tanggal Mulai Kegiatan</small>
							</div>
							<div class="col-md-3 col-6 mb-3">
								<label for="tgl_selesai" class="form-label">&nbsp;</label>
								<input type="date" name="tgl_selesai" id="tgl_selesai" class="form-control" required>
								<small class="text-muted">Tanggal Selesai Kegiatan</small>
							</div>

                            <h5 class="card-title mt-3">Lainnya</h5>
                            <div class="col-md-12 mb-3">
                                <label for="keterangan" class="form-label">Informasi Tambahan (Opsional)</label>
                                <textarea name="keterangan" id="keterangan" class="form-control" rows="4" placeholder=""></textarea>
                            </div>
                            <div class="col-6">
                            	<a href="<?= base_url('mbkm') ?>" class="btn btn-danger w-100"><i class="psi-left-4 me-1"></i> Kembali</a>
                            </div>
                            <div class="col-6">
                            	<button class="btn btn-info w-100"><i class="psi-paper-plane me-1"></i> Simpan Data</button>
                            </div>
                        </form>
                    </div>
				</div>
			</div>
			<!-- <div class="col-md-5">
				<div class="card">
					<div class="card-body">
                        <h5 class="card-title">Persyaratan Khusus</h5>

                    </div>
                </div>
            </div> -->
		</div>
	</div>
</div>

<script>
	function castvote(e) {
	    var datalist = document.querySelector(`#${e.getAttribute('list')}`).children

        var flag = false
        for(let i = 0; i < datalist.length; i++){
            flag = datalist[i].value === e.value || flag
        }

        if (!flag)
          e.value = ""
  	}
</script>