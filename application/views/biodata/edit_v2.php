<div class="content__boxed">
    <div class="content__wrap">
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="<?= $mahasiswa_pt->foto ?>" class="rounded img-fluid mb-2" alt="Profile Picture">
                            <!-- <h5 class="text-lg text-overflow mb-0"><?= $mahasiswa_pt->nm_pd ?></h5> -->
                        </div>
                    </div>
                </div>

                <div class="card mb-2">
                        <h5 class="card-header" style="min-height: 0px"><i class="pli-university me-1" style="margin-top: -3px;"></i> Data Perguruan Tinggi</h5>
                        <div class="card-body">
                            <!-- Block styled form -->
                            <div class="row g-2">
                                <div class="col-4">NPSN</div>
                                <div class="col-8 text-dark"><?= $mahasiswa_pt->npsn ?></div>
                                <div class="col-4">Nama PT</div>
                                <div class="col-8 text-dark"><?= $mahasiswa_pt->nm_lemb ?></div>
                                <div class="col-4">Prodi</div>
                                <div class="col-8 text-dark"><?= $mahasiswa_pt->nama_prodi ?></div>
                            </div>
                        </div>
                    </div>

            </div>
            <div class="col-md-8">
                <form method="POST" action="<?= base_url('biodata/update_v2') ?>">
                    <div class="card">
                        <h5 class="card-header" style="min-height: 0px"><i class="pli-male-2 me-1" style="margin-top: -3px;"></i> Data Diri</h5>
                        <div class="card-body">
                            <!-- Block styled form -->
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="id_mahasiswa_pt" class="form-label text-dark">Nomor Induk Mahasiswa</label>
                                    <input id="id_mahasiswa_pt" type="text" class="form-control" disabled value="<?= $mahasiswa_pt->id_mahasiswa_pt ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="nm_pd" class="form-label text-dark">Nama Lengkap</label>
                                    <input id="nm_pd" type="text" class="form-control" disabled value="<?= $mahasiswa_pt->nm_pd ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="jk" class="form-label text-dark">Jenis Kelamin</label>
                                    <select id="jk" class="form-select" required="" disabled>
                                        <option hidden="">Pilih Jenis Kelamin</option>
                                        <option value="L" <?= $mahasiswa_pt->jk == 'L' ? 'selected' : '' ?> >Laki-laki</option>
                                        <option value="P" <?= $mahasiswa_pt->jk == 'P' ? 'selected' : '' ?> >Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-4 col-6">
                                    <label for="tmp_lahir" class="form-label text-dark">Tempat Lahir</label>
                                    <input id="tmp_lahir" disabled type="text" class="form-control" required="" value="<?= $mahasiswa_pt->tmp_lahir ?>">
                                </div>
                                <div class="col-md-4 col-6">
                                    <label for="tgl_lahir" class="form-label text-dark">Tanggal Lahir</label>
                                    <input id="tgl_lahir" disabled type="date" class="form-control" required="" value="<?= $mahasiswa_pt->tgl_lahir ?>" >
                                </div>
                                <div class="col-md-6">
                                    <label for="nik" class="form-label text-dark">Nomor Induk Kependudukan (NIK)</label>
                                    <input id="nik" disabled type="text" pattern="[0-9]+" minlength="16" maxlength="16" class="form-control" required="" value="<?= $mahasiswa_pt->nik ?>" >
                                </div>
                                <div class="col-md-6">
                                    <label for="id_agama" class="form-label text-dark">Agama <span class="text-danger">*</span></label>
                                    <select id="id_agama" class="form-select" required="" name="id_agama">
                                        <option value="" hidden="">Pilih Agama</option>
                                        <?php foreach($agama as $agama): ?>
                                            <option value="<?= $agama->id_agama ?>" <?= $agama->id_agama == $mahasiswa_pt->id_agama ? 'selected' : '' ?> ><?= $agama->agama ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-2">
                        <h5 class="card-header" style="min-height: 0px"><i class="pli-phone-2 me-1" style="margin-top: -3px;"></i> Kontak</h5>
                        <div class="card-body">
                            <!-- Block styled form -->
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input id="email" disabled type="email" class="form-control" required=""  value="<?= $mahasiswa_pt->email ?>" >
                                </div>
                                <div class="col-md-6">
                                    <label for="no_hp" class="form-label">No. Handphone <span class="text-danger">*</span></label>
                                    <div class="input-group mb-3">
                                        <!-- <span class="input-group-text">
                                            +62
                                        </span> -->
                                        <input type="tel" class="form-control" name="no_hp" id="no_hp" required=""  value="<?= $mahasiswa_pt->no_hp ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-2">
                        <h5 class="card-header" style="min-height: 0px"><i class="pli-map-marker-2 me-1" style="margin-top: -3px;"></i> Alamat</h5>
                        <div class="card-body">
                            <!-- Block styled form -->
                            <div class="row g-3">
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
                            </div>
                            <!-- END : Block styled form -->
                        </div>
                    </div>
                </form>
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