<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
			<div class="col-md-8 offset-md-2 mb-3">
				<div class="card">
					<div class="card-body">
                        <form class="row" method="POST" action="<?= base_url('mbkm/simpan/mitra') ?>" enctype="multipart/form-data">
                            <div class="col-md-6 mb-3">
                                <label for="nama_resmi" class="form-label">Nama Resmi <span class="text-danger">*</span></label>
                                <input type="text" name="nama_resmi" id="nama_resmi" required="" class="form-control" placeholder="Contoh: PT Dicoding Akademi Indonesia">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nama_merek" class="form-label">Nama Merek <span class="text-danger">*</span></label>
                                <input type="text" name="nama_merek" id="nama_merek" required="" class="form-control" placeholder="Contoh: Dicoding Academy">
                                <small class="text-muted">Nama merek akan ditampilkan kepada mahasiswa.</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tautan" class="form-label">Website Resmi <span class="text-danger">*</span></label>
                                <input type="text" name="tautan" id="tautan" required="" class="form-control" placeholder="https://www.dicoding.com/">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="id_jenis_instansi" class="form-label">Jenis Instansi <span class="text-danger">*</span></label>
                                <select name="id_jenis_instansi" id="id_jenis_instansi" class="form-control" required>
                                    <option value="" hidden>Pilih Jenis Instansi</option>
                                    <?php foreach($this->Mbkm_model->get($_ENV['DB_REF'].'jenis_instansi')->result() as $jenis_instansi): ?>
                                    <option value="<?= $jenis_instansi->id_jenis_instansi ?>"><?= $jenis_instansi->nama_jenis_instansi ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi Mitra <span class="text-danger">*</span></label>
                                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="8" placeholder="Tuliskan deskripsi mitra" required=""></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea name="alamat" id="alamat" class="form-control" rows="4" placeholder="Tuliskan alamat lengkap mitra" required=""></textarea>
                            </div>
                            <div class="col-md-6 col-6 mb-3">
                                <label for="telepon" class="form-label">Telepon <span class="text-danger">*</span></label>
                                <input type="tel" name="telepon" id="telepon" required="" class="form-control" placeholder="(021) 11223344">
                            </div>
                            <div class="col-md-6 col-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" required="" class="form-control" placeholder="mitra@gmail.com">
                            </div>

							<div class="col-md-6 col-6 mb-3">
								<label for="tgl_mulai" class="form-label">Periode Kerja Sama <span class="text-danger">*</span></label>
								<input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control" required>
								<small class="text-muted">Tanggal Dimulai Kerjasama</small>
							</div>
							<div class="col-md-6 col-6 mb-3">
								<label for="tgl_selesai" class="form-label">&nbsp;</label>
								<input type="date" name="tgl_selesai" id="tgl_selesai" class="form-control" required>
								<small class="text-muted">Tanggal Berakhir Kerjasama</small>
							</div>

                            <div class="col-6">
                            	<a href="<?= base_url('mitra') ?>" class="btn btn-danger w-100"><i class="psi-left-4 me-1"></i> Kembali</a>
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