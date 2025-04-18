<div class="content__boxed">
    <div class="content__wrap">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <h5 class="card-header" style="min-height: 0px">Data Mahasiswa</h5>
                    <div class="card-body">
                        <!-- Block styled form -->
                        <form class="row g-3" method="POST" action="<?= base_url('biodata/update') ?>">
                            <div class="col-md-6">
                                <label for="id_mahasiswa_pt" class="form-label">Nomor Induk Mahasiswa</label>
                                <input id="id_mahasiswa_pt" type="text" class="form-control" disabled value="<?= $mahasiswa_pt->id_mahasiswa_pt ?>">
                            </div>

                            <div class="col-md-6">
                                <label for="nm_pd" class="form-label">Nama Lengkap</label>
                                <input id="nm_pd" type="text" class="form-control" disabled value="<?= $mahasiswa_pt->nm_pd ?>">
                            </div>

                            <div class="col-md-6">
                                <label for="nm_ibu_kandung" class="form-label">Nama Ibu Kandung</label>
                                <input id="nm_ibu_kandung" type="text" class="form-control" disabled value="<?= $mahasiswa_pt->nm_ibu_kandung ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="jk" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select id="jk" class="form-select" required="" disabled>
                                    <option hidden="">Pilih Jenis Kelamin</option>
                                    <option value="L" <?= $mahasiswa_pt->jk == 'L' ? 'selected' : '' ?> >Laki-laki</option>
                                    <option value="P" <?= $mahasiswa_pt->jk == 'P' ? 'selected' : '' ?> >Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-3 col-6">
                                <label for="tmp_lahir" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                <input id="tmp_lahir" name="tmp_lahir" type="text" class="form-control" required="" value="<?= $mahasiswa_pt->tmp_lahir ?>">
                            </div>
                            <div class="col-md-3 col-6">
                                <label for="tgl_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input id="tgl_lahir" name="tgl_lahir" type="date" class="form-control" required="" value="<?= $mahasiswa_pt->tgl_lahir ?>" >
                            </div>
                            <div class="col-md-6">
                                <label for="id_agama" class="form-label">Agama <span class="text-danger">*</span></label>
                                <select id="id_agama" class="form-select" required="" disabled>
                                    <option value="" hidden="">Pilih Agama</option>
                                    <?php foreach($agama as $agama): ?>
                                    <option value="<?= $agama->id_agama ?>" <?= $agama->id_agama == $mahasiswa_pt->id_agama ? 'selected' : '' ?> ><?= $agama->agama ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                                <input id="nik" name="nik" type="text" pattern="[0-9]+" minlength="16" maxlength="16" class="form-control" required="" value="<?= $mahasiswa_pt->nik ?>" >
                            </div>
                            <div class="col-md-6">
                                <label for="nisn" class="form-label">NISN <span class="text-danger">*</span></label>
                                <input id="nisn" name="nisn" type="text" pattern="[0-9]+" minlength="8" maxlength="8" class="form-control" required="" value="<?= $mahasiswa_pt->nisn ?>" >
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input id="email" name="email" type="email" class="form-control" required=""  value="<?= $mahasiswa_pt->email ?>" >
                            </div>
                            <div class="col-md-6">
                                <label for="no_hp" class="form-label">No. Handphone <span class="text-danger">*</span></label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        +62
                                    </span>
                                    <input type="tel" class="form-control" name="no_hp" id="no_hp" required=""  value="<?= $mahasiswa_pt->no_hp ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="jalan" class="form-label">Blok / Jalan <span class="text-danger">*</span></label>
                                <input id="jalan" name="jalan" type="text" class="form-control" required=""  value="<?= $mahasiswa_pt->jalan ?>">
                            </div>
                            <div class="col-md-3 col-6">
                                <label for="rt" class="form-label">RT <span class="text-danger">*</span></label>
                                <input id="rt" name="rt" type="number" class="form-control" required="" value="<?= $mahasiswa_pt->rt ?>">
                            </div>
                            <div class="col-md-3 col-6">
                                <label for="rw" class="form-label">RW <span class="text-danger">*</span></label>
                                <input id="rw" name="rw" type="number" class="form-control" required="" value="<?= $mahasiswa_pt->rw ?>">
                            </div>

                            <div class="col-md-6">
                                <label for="kelurahan" class="form-label">Kelurahan <span class="text-danger">*</span></label>
                                <input id="kelurahan" name="kelurahan" type="text" class="form-control" required="" value="<?= $mahasiswa_pt->kelurahan ?>">
                            </div>
                            <div class="col-md-3">
                                <label for="kecamatan" class="form-label">Kecamatan <span class="text-danger">*</span></label>
                                <input id="kecamatan" name="id_wil" list="data_kecamatan" type="text" class="form-control" required="" value="<?= $mahasiswa_pt->id_wil ?>" onchange="castvote()">

                                <datalist id="data_kecamatan">
                                    <?php foreach ($kecamatan as $kecamatan): ?>
                                    <option value="<?= $kecamatan->id_wil ?>"><?= $kecamatan->nm_wil ?>, <?= $kecamatan->nama_kabupaten ?></option>
                                    <?php endforeach; ?>
                                </datalist>
                            </div>
                            <div class="col-md-3">
                                <label for="kode_pos" class="form-label">Kode Pos <span class="text-danger">*</span></label>
                                <input id="kode_pos" name="kode_pos" type="text" class="form-control" required="" value="<?= $mahasiswa_pt->kode_pos ?>">
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary w-100 mt-3">Simpan</button>
                            </div>
                        </form>
                        <!-- END : Block styled form -->
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
	function castvote(index) {
	    document.querySelectorAll('#kecamatan').forEach( el => {
	        var datalist = el;
	        var browserChildren = document.querySelector('#data_kecamatan').children

	        var flag = false
	        for(let i = 0; i < browserChildren.length; i++){
	            flag = browserChildren[i].value === datalist.value || flag
	        }

	        if (!flag)
	          datalist.value = ""
	    })
	  }
</script>