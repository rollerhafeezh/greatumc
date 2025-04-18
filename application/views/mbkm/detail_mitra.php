<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
			<div class="col-lg-8 offset-lg-2 mb-3">
				<div class="tab-base">
					<ul class="nav nav-callout" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#detail_mitra" type="button" role="tab" aria-controls="detail_mitra" aria-selected="true">Data Mitra</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#dokumen" type="button" role="tab" aria-controls="dokumen" aria-selected="false">Dokumen Pendukung</button>
                        </li>
                    </ul>

                    <div class="tab-content">
                    	<div id="detail_mitra" class="tab-pane fade active show" role="tabpanel" aria-labelledby="detail_mitra">
                    		<?php if(isset($_SESSION['msg_inside'])) { ?>
								<div class="alert alert-<?=$_SESSION['msg_inside_clr']?> alert-dismissible fade show" role="alert">
								  <?=$_SESSION['msg_inside']?>
								  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								</div>
							<?php  } ?>

							<?php $disabled = ($_SESSION['app_level'] != 7 ? 'disabled' : ''); ?>
	                        <form class="row" method="POST" action="<?= base_url('mbkm/update/mitra/'.sha1($detail->id_mitra)) ?>" enctype="multipart/form-data">
	                            <div class="col-md-6 mb-3">
	                                <label for="nama_resmi" class="form-label">Nama Resmi <span class="text-danger">*</span></label>
	                                <input type="text" name="nama_resmi" id="nama_resmi" required="" class="form-control" placeholder="Contoh: PT Dicoding Akademi Indonesia" value="<?= $detail->nama_resmi ?>">
	                            </div>
	                            <div class="col-md-6 mb-3">
	                                <label for="nama_merek" class="form-label">Nama Merek <span class="text-danger">*</span></label>
	                                <input type="text" name="nama_merek" id="nama_merek" required="" class="form-control" placeholder="Contoh: Dicoding Academy"  value="<?= $detail->nama_merek ?>">
	                                <small class="text-muted">Nama merek akan ditampilkan kepada mahasiswa.</small>
	                            </div>
	                            <div class="col-md-6 mb-3">
	                                <label for="tautan" class="form-label">Website Resmi <span class="text-danger">*</span></label>
	                                <input type="text" name="tautan" id="tautan" required="" class="form-control" placeholder="https://www.dicoding.com/" value="<?= $detail->tautan ?>">
	                            </div>
	                            <div class="col-md-6 mb-3">
	                                <label for="id_jenis_instansi" class="form-label">Jenis Instansi <span class="text-danger">*</span></label>
	                                <select name="id_jenis_instansi" id="id_jenis_instansi" class="form-select" required>
	                                    <option value="" hidden>Pilih Jenis Instansi</option>
	                                    <?php foreach($this->Mbkm_model->get($_ENV['DB_REF'].'jenis_instansi')->result() as $jenis_instansi): ?>
	                                    <option value="<?= $jenis_instansi->id_jenis_instansi ?>" <?= $jenis_instansi->id_jenis_instansi == $detail->id_jenis_instansi ? 'selected' : '' ?>><?= $jenis_instansi->nama_jenis_instansi ?></option>
	                                    <?php endforeach; ?>
	                                </select>
	                            </div>
	                            <div class="col-md-12 mb-3">
	                                <label for="deskripsi" class="form-label">Deskripsi Mitra <span class="text-danger">*</span></label>
	                                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="8" placeholder="Tuliskan deskripsi mitra" required=""><?= $detail->deskripsi ?></textarea>
	                            </div>
	                            <div class="col-md-12 mb-3">
	                                <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
	                                <textarea name="alamat" id="alamat" class="form-control" rows="4" placeholder="Tuliskan alamat lengkap mitra" required=""><?= $detail->alamat ?></textarea>
	                            </div>
	                            <div class="col-md-6 col-6 mb-3">
	                                <label for="telepon" class="form-label">Telepon <span class="text-danger">*</span></label>
	                                <input type="tel" name="telepon" id="telepon" required="" class="form-control" placeholder="(021) 11223344" value="<?= $detail->telepon ?>">
	                            </div>
	                            <div class="col-md-6 col-6 mb-3">
	                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
	                                <input type="email" name="email" id="email" required="" class="form-control" placeholder="mitra@gmail.com" value="<?= $detail->email ?>">
	                            </div>

								<div class="col-md-6 col-6 mb-3">
									<label for="tgl_mulai" class="form-label">Periode Kerja Sama <span class="text-danger">*</span></label>
									<input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control" required value="<?= $detail->tgl_mulai ?>" > 
									<small class="text-muted">Tanggal Dimulai Kerjasama</small>
								</div>
								<div class="col-md-6 col-6 mb-3">
									<label for="tgl_selesai" class="form-label">&nbsp;</label>
									<input type="date" name="tgl_selesai" id="tgl_selesai" class="form-control" required value="<?= $detail->tgl_selesai ?>" >
									<small class="text-muted">Tanggal Berakhir Kerjasama</small>
								</div>

	                            <h5 class="mt-3"><i class="psi-phone-2 me-1"></i> Narahubung Mitra</h5>
	                            <div class="col-md-6 mb-3">
	                                <label for="nama_narahubung" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
	                                <input type="text" name="nama_narahubung" id="nama_narahubung" required="" placeholder="Nama Lengkap Narahubung" class="form-control" value="<?= $detail->nama_narahubung ?>">
	                            </div>
	                            <div class="col-md-3 col-6 mb-3">
	                                <label for="telepon_narahubung" class="form-label">No. Handphone <span class="text-danger">*</span></label>
	                                <input type="tel" name="telepon_narahubung" id="telepon_narahubung" required="" class="form-control" placeholder="No. Handphone Narahubung" value="<?= $detail->telepon_narahubung ?>">
	                            </div>
	                            <div class="col-md-3 col-6 mb-3">
	                                <label for="email_narahubung" class="form-label">Email <span class="text-danger">*</span></label>
	                                <input type="email" name="email_narahubung" id="email_narahubung" required="" class="form-control" placeholder="email_narahubung@gmail.com" value="<?= $detail->email_narahubung ?>">
	                            </div>
	                            <?php if ($_SESSION['app_level'] == '7'): ?>
	                            <div class="col-6 mt-2">
	                            	<a href="<?= base_url('mitra') ?>" class="btn btn-danger w-100"><i class="psi-left-4 me-1"></i> Kembali</a>
	                            </div>
	                            <div class="col-6 mt-2">
	                            	<button class="btn btn-info w-100"><i class="psi-paper-plane me-1"></i> Simpan Data</button>
	                            </div>
	                        	<?php endif; ?>
	                        </form>
                    	</div>

                    	<div id="dokumen" class="tab-pane fade" role="tabpanel" aria-labelledby="dokumen">
                    		<?php if ($_SESSION['app_level'] == 7): ?>
                    		<form onsubmit="event.preventDefault(); return tambah_berkas_mitra(this)">
	                    		<div class="row">
	                    			<div class="col-md-5 mb-2">
	                    				<select class="form-select" name="id_berkas" required="">
	                    					<option value="" hidden="">Pilih Jenis Berkas</option>
	                    					<?php foreach($this->Mbkm_model->get($_ENV['DB_MBKM'].'berkas', ['berkas_mitra' => 'Y'])->result() as $berkas): ?>
		                                    <option value="<?= $berkas->id_berkas ?>" data-slug="<?= $berkas->slug ?>"><?= $berkas->nama_berkas ?></option>
		                                    <?php endforeach; ?>
	                    				</select>
	                    			</div>
	                    			<div class="col-md-5 mb-2">
	                    				<input type="file" id="berkas" name="berkas" class="form-control" required="">
	                    				<small class="text-muted">Maks. 15 MB; Berkas Gambar atau Dokumen.</small>
	                    			</div>
	                    			<div class="col-md-2">
	                    				<button class="btn btn-info w-100">Unggah</button>
	                    			</div>
	                    		</div>
	                    	</form>
	                    	<?php else: ?>
	                    	<div class="alert alert-info mb-0">
	                    		<b>Informasi: </b>Dokumentasi hanya bisa diinput oleh Program Studi.
	                    	</div>
	                    	<?php endif; ?>

	                    	<style type="text/css">
	                    		#datatabel tbody, td, tfoot, th, thead, tr {
	                    			border-style: unset !important;
	                    		}
	                    	</style>
                    		<div class="table-responsive">
	                    		<table id="datatabel" class="table table-striped" style="width:100%">
									<thead>
			                            <tr>
			                                <th width="1">No</th>
			                                <th class="text-nowrap">Jenis Berkas</th>
			                                <th class="text-nowrap">Tgl. Upload</th>
			                                <th width="1">Berkas</th>
			                                
			                                <?php if ($_SESSION['app_level'] == 7): ?>
			                                <th width="1">Aksi</th>
			                            	<?php endif; ?>
			                            </tr>
			                        </thead>
									<tbody></tbody>
								</table>
                    		</div>
                    	</div>
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('lyt/js_datatable'); ?>
<style>
.dataTables_length { display: block; }
</style>
<script>
	var table

	function tambah_berkas_mitra(e) {
		var formData = new FormData(e)
		formData.append('slug', e[0].options[e[0].selectedIndex].dataset.slug)
		formData.append('nama_merek', '<?= strtolower($detail->nama_merek) ?>')

		fetch('<?= base_url('mbkm/tambah_berkas_mitra/'.$detail->id_mitra) ?>', { method: 'POST', body: formData })
		.then(response => response.text())
		.then(text => {
			table.ajax.reload(null,false);
			if (text == 1) {
				Toastify({
					text: "Info: Dokumen berhasil ditambahkan.",
				}).showToast();
			} else {
				Toastify({
					text: "Error: Dokumen gagal ditambahkan atau Dokumen sudah ada pada tabel.",
				}).showToast();
			}

			e.reset()
		})
	}

	function hapus_berkas_mitra(id_berkas_mitra) {
	var konfirmasi = confirm('Hapus Dokumen Yang Dipilih ?')
	if (konfirmasi) {
		var formData = new FormData()
		formData.append('id_berkas_mitra', id_berkas_mitra)

		fetch('<?= base_url('mbkm/hapus/berkas_mitra') ?>', { method: 'POST', body: formData })
		.then(response => response.text())
		.then(text => {
			table.ajax.reload(null,false);
			if (text == 1) {
				Toastify({
					text: "Info: Dokumen berhasil dihapus.",
				}).showToast();
			} else {
				Toastify({
					text: "Error: Dokumen gagal dihapus.",
				}).showToast();
			}
		})
	}

		return
	}
	
	$(document).ready(function() {
		table = $('#datatabel').DataTable( {
			ajax: {
				url 	: "<?= base_url('mbkm/json_berkas_mitra') ?>",
				type 	: 'GET',
				data : function(d) {
					d.id_mitra = '<?= sha1($detail->id_mitra) ?>';
				}
			},
			responsive: true,
			"autoWidth": false,
			dom: 	"<'row'<'col-sm-12 col-md-4 mb-1'l><'col-sm-12 col-md-4 mb-1'B><'col-sm-12 col-md-4 mb-1'f>>" +
					"<'row'<'col-sm-12 mb-1'tr>>" +
					"<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
			buttons: [],
			serverSide: true,
			processing: true,
		} );
	} );

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