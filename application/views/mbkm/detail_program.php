<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
			<div class="col-lg-8 offset-lg-2 mb-3">
				<div class="tab-base">
					<ul class="nav nav-callout" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#detail_program" type="button" role="tab" aria-controls="detail_program" aria-selected="true">Detail</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#mata_kuliah" type="button" role="tab" aria-controls="mata_kuliah" aria-selected="false">Mata Kuliah</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#dokumen" type="button" role="tab" aria-controls="dokumen" aria-selected="false">Dokumen</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#peserta" type="button" role="tab" aria-controls="peserta" aria-selected="false">Peserta</button>
                        </li>

                        <?php if ($_SESSION['app_level'] == 3): ?>
                    	<li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#validasi" type="button" role="tab" aria-controls="validasi" aria-selected="false">Validasi Program</button>
                        </li>
                        <?php endif; ?>
                    </ul>

                    <div class="tab-content">
                    	<div id="detail_program" class="tab-pane fade active show" role="tabpanel" aria-labelledby="detail_program">
                    		<?php if(isset($_SESSION['msg_inside'])) { ?>
								<div class="alert alert-<?=$_SESSION['msg_inside_clr']?> alert-dismissible fade show" role="alert">
								  <?=$_SESSION['msg_inside']?>
								  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								</div>
							<?php  } ?>

							<?php $disabled = ($_SESSION['app_level'] != 7 ? 'disabled' : ''); ?>
	                        <form class="row" method="POST" action="<?= base_url('mbkm/update/program_mitra/'.sha1($detail->id_program_mitra)) ?>" enctype="multipart/form-data">
                        		
                        		<h5 class="card-title">Data Program Kampus Merdeka</h5>
	                            <div class="col-md-6 mb-3">
	                                <label for="id_program" class="form-label">Skema Program <span class="text-danger">*</span></label>
	                                <select class="form-select" id="id_program" name="id_program" required="" <?= $disabled ?> >
	                                    <option hidden="" value="">Pilih Skema Program</option>
	                                    <?php foreach($this->Mbkm_model->program_mbkm(null, 'nama_jenis_aktivitas_mahasiswa ASC')->result() as $program): ?>
	                                    <option value="<?= $program->id_program ?>" <?= $program->id_program == $detail->id_program ? 'selected' : '' ?> ><?= $program->nama_jenis_aktivitas_mahasiswa ?> <?= $program->nama_program ?></option>
	                                    <?php endforeach; ?>
	                                </select>
	                            </div>
	                            <div class="col-md-6 mb-3">
	                                <label for="jenis_program" class="form-label">Jenis Program <span class="text-danger">*</span></label>
	                                <select class="form-select" id="jenis_program" name="jenis_program" required="" <?= $disabled ?> >
	                                    <option hidden="" value="">Pilih Jenis Program</option>
	                                    <option value="1" <?= $detail->jenis_program == 1 ? 'selected' : '' ?> >Program Mandiri</option>
	                                    <option value="2" <?= $detail->jenis_program == 2 ? 'selected' : '' ?> >Program Kementrian (Pusat)</option>
	                                </select>
	                            </div>
	                            <div class="col-md-6 mb-3">
	                                <label for="id_mitra" class="form-label">Lokasi Kegiatan (Mitra) <span class="text-danger">*</span></label>
	                                <input type="search" class="form-control" required="" id="id_mitra" list="mitra" name="id_mitra" placeholder="Ketikan Nama Mitra atau Merek" onchange="castvote(this); document.querySelector('#hidden_id_mitra').value = document.querySelector(`#mitra > option[value='${this.value}']`).dataset.id_mitra;" value="<?= $this->Mbkm_model->mitra([ 'id_mitra' => $detail->id_mitra ])->row()->nama_merek ?>" <?= $disabled ?>>
	                                <datalist id="mitra">
	                                    <?php foreach($this->Mbkm_model->mitra(null, 'nama_resmi ASC')->result() as $mitra): ?>
	                                    <option value="<?= $mitra->nama_merek ?>" data-id_mitra="<?= $mitra->id_mitra ?>"><?= $mitra->nama_resmi ?></option>
	                                    <?php endforeach; ?>
	                                </datalist>
	                                <input type="hidden" id="hidden_id_mitra" name="id_mitra" value="<?= $detail->id_mitra ?>">
	                            </div>
	                            <div class="col-md-6 mb-3">
	                                <label for="judul_kegiatan" class="form-label">Judul Kegiatan <span class="text-danger">*</span></label>
	                                <input type="text" name="judul_kegiatan" id="judul_kegiatan" class="form-control" placeholder="Contoh: Kampus Mengajar Angkatan 5 Tahun 2023" required="" value="<?= $detail->judul_kegiatan ?>" <?= $disabled ?> >
	                            </div>
	                            <div class="col-md-12 mb-3">
	                                <label for="deskripsi" class="form-label">Deskripsi Kegiatan <span class="text-danger">*</span></label>
	                                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="8" required="" <?= $disabled ?> placeholder="Jelaskan informasi mengenai kegiatan program kampus merdeka." ><?= $detail->deskripsi ?></textarea>
	                            </div>

                           	 	<h5 class="card-title mt-3">Periode Pendaftaran & Pelaksanaan</h5>
	                            <div class="col-md-6 mb-3">
									<label for="id_smt" class="form-label">Semester Pelaksanaan <span class="text-danger">*</span></label>
									<select id="id_smt" name="id_smt" class="form-select" required="" <?= $disabled ?> >
										<option value="" hidden="">Pilih Semester Pelaksanaan</option>
										<?php 
											$ref_smt 	= $this->Main_model->ref_smt();
											foreach($ref_smt as $ket=>$value)
											{
												echo'<option value="'.$value->id_semester.'" '.($value->id_semester == $detail->id_smt ? 'selected' : '').'>'.$value->nama_semester.'</option>';
											}
										?>
									</select>
								</div>
	                            <div class="col-md-3 col-6 mb-3">
	                                <label for="kuota" class="form-label">Kuota (Orang) <span class="text-danger">*</span></label>
	                            	<input type="number" name="kuota" id="kuota" min="0" step="1" required="" class="form-control" value="<?= $detail->kuota ?>" <?= $disabled ?> >
	                            </div>
	                            <div class="col-md-3 col-6 mb-3">
	                                <label for="sks_diakui" class="form-label">SKS Diakui <span class="text-danger">*</span></label>
	                            	<input type="number" name="sks_diakui" id="sks_diakui" min="0" step="1" required="" class="form-control" value="<?= $detail->sks_diakui ?>" <?= $disabled ?> >
	                            </div>
								<div class="col-md-3 col-6 mb-3">
									<label for="tgl_mulai_daftar" class="form-label">Periode Pendaftaran <span class="text-danger">*</span></label>
									<input type="date" name="tgl_mulai_daftar" id="tgl_mulai_daftar" class="form-control" required value="<?= $detail->tgl_mulai_daftar ?>" <?= $disabled ?>>
									<small class="text-muted">Batas Awal Pendaftaran</small>
								</div>
								<div class="col-md-3 col-6 mb-3">
									<label for="tgl_selesai_daftar" class="form-label">&nbsp;</label>
									<input type="date" name="tgl_selesai_daftar" id="tgl_selesai_daftar" class="form-control" required value="<?= $detail->tgl_selesai_daftar ?>" <?= $disabled ?>>
									<small class="text-muted">Batas Akhir Pendaftaran</small>
								</div>
								<div class="col-md-3 col-6 mb-3">
									<label for="tgl_mulai" class="form-label">Periode Pelaksanaan <span class="text-danger">*</span></label>
									<input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control" required value="<?= $detail->tgl_mulai ?>" <?= $disabled ?>>
									<small class="text-muted">Tanggal Mulai Kegiatan</small>
								</div>
								<div class="col-md-3 col-6 mb-3">
									<label for="tgl_selesai" class="form-label">&nbsp;</label>
									<input type="date" name="tgl_selesai" id="tgl_selesai" class="form-control" required value="<?= $detail->tgl_selesai ?>" <?= $disabled ?>>
									<small class="text-muted">Tanggal Selesai Kegiatan</small>
								</div>

                        		<h5 class="card-title">Lainnya</h5>
	                            <div class="col-md-12 mb-3">
	                                <label for="keterangan" class="form-label">Informasi Tambahan (Opsional)</label>
	                                <textarea name="keterangan" id="keterangan" class="form-control" rows="4" <?= $disabled ?> ><?= $detail->keterangan ?></textarea>
	                            </div>

	                            <?php if ($_SESSION['app_level'] == '7'): ?>
	                            <div class="col-6">
	                            	<a href="<?= base_url('mbkm') ?>" class="btn btn-danger w-100"><i class="psi-left-4 me-1"></i> Kembali</a>
	                            </div>
	                            <div class="col-6">
	                            	<button class="btn btn-info w-100"><i class="psi-paper-plane me-1"></i> Simpan Data</button>
	                            </div>
	                        	<?php endif; ?>
	                        </form>
                    	</div>

                    	<div id="mata_kuliah" class="tab-pane fade" role="tabpanel" aria-labelledby="mata_kuliah">
                    		<?php if ($_SESSION['app_level'] == 7): ?>
                    		<form onsubmit="event.preventDefault(); return tambah_matkul_program(this)">
	                    		<div class="row">
	                    			<div class="col-md-10 mb-2">
	                    				<input type="search" class="form-control" id="id_matkul" placeholder="Masukan Kode atau Nama Mata Kuliah" class="form-control" list="mata_kuliah_kurikulum" required="" autocomplete="off" onchange="castvote(this); document.querySelector('#hidden_id_matkul').value = document.querySelector(`#mata_kuliah_kurikulum > option[value='${this.value}']`).dataset.id_matkul;">

	                    				<datalist id="mata_kuliah_kurikulum">
	                    					<?php foreach($mata_kuliah_kurikulum as $mkm): ?>
	                    					<option value="<?= '('.$mkm->kode_mk.') '.$mkm->nm_mk ?>" data-id_matkul="<?= $mkm->id_matkul ?>">Semester <?= $mkm->smt ?></option>
	                    					<?php endforeach; ?>
	                    				</datalist>
                                		<input type="hidden" id="hidden_id_matkul" name="id_matkul">
	                    			</div>
	                    			<div class="col-md-2">
	                    				<button class="btn btn-info w-100">Tambah</button>
	                    			</div>
	                    		</div>
	                    	</form>
	                    	<?php else: ?>
	                    	<div class="alert alert-info mb-1">
	                    		<i class="pli-information me-1"></i> Mata kuliah yang ditawarkan hanya bisa diinput oleh Program Studi.
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
			                                <th class="text-nowrap" width="1">Kode MK</th>
			                                <th class="text-nowrap">Nama Mata Kuliah</th>
			                                <th width="1">SMT</th>
			                                <th width="1">SKS</th>
			                                
			                                <?php if ($_SESSION['app_level'] == 7): ?>
			                                <th width="1">Aksi</th>
			                            	<?php endif; ?>
			                            </tr>
			                        </thead>
									<tbody></tbody>
									<tfoot>
										<tr>
											<th colspan="4" class="text-end">TOTAL SKS :</th>
											<th <?= $_SESSION['app_level'] == 7 ? 'colspan="2"' : '' ?>></th>
										</tr>
									</tfoot>
								</table>
                    		</div>
                    	</div>

                    	<div id="dokumen" class="tab-pane fade" role="tabpanel" aria-labelledby="dokumen">
                    		<?php if ($_SESSION['app_level'] == 7): ?>
                    		<form onsubmit="event.preventDefault(); return tambah_berkas_program_mitra(this)">
	                    		<div class="row">
	                    			<div class="col-md-5 mb-2">
	                    				<select class="form-select" name="id_berkas" required="">
	                    					<option value="" hidden="">Pilih Jenis Berkas</option>
	                    					<?php foreach($this->Mbkm_model->get($_ENV['DB_MBKM'].'berkas', ['berkas_program' => 'Y'])->result() as $berkas): ?>
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
	                    	<div class="alert alert-info">
	                    		<i class="pli-information me-1"></i> Dokumentasi hanya bisa diinput oleh Program Studi.
	                    	</div>
	                    	<?php endif; ?>

	                    	<style type="text/css">
	                    		#datatabel tbody, td, tfoot, th, thead, tr {
	                    			border-style: unset !important;
	                    		}
	                    	</style>
                    		<div class="table-responsive">
	                    		<table id="datatable_program_mitra" class="table table-striped" style="width:100%">
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

                    	<div id="peserta" class="tab-pane fade" role="tabpanel" aria-labelledby="peserta">
                    		<?php if ($_SESSION['app_level'] == 7): ?>
	                    	<div class="alert alert-info">
	                    		<i class="pli-information me-1"></i> Silahkan klik data kolom status untuk mengubah status pendaftaran menjadi diterima atau ditolak.
	                    	</div>
	                    	<?php endif; ?>

	                    	<style type="text/css">
	                    		#datatabel tbody, td, tfoot, th, thead, tr {
	                    			border-style: unset !important;
	                    		}
	                    	</style>
                    		<div class="table-responsive">
	                    		<table id="datatable_peserta" class="table table-striped" style="width:100%">
									<thead>
			                            <tr>
			                                <th width="1">No</th>
			                                <th class="text-nowrap">NIM</th>
			                                <th class="text-nowrap">Nama Lengkap</th>
			                                <th class="text-nowrap">Program Studi</th>
			                                <th class="text-nowrap" width="1">Smt</th>
			                                <th width="1" class="text-nowrap">Status</th>
			                            </tr>
			                        </thead>
									<tbody></tbody>
								</table>
                    		</div>
                    		<!-- <a class="btn btn-secondary mt-3 w-100" onclick="return confirm(`Tetapkan peserta yang diterima untuk melaksanakan kegiatan mbkm ?\n*) Penetapan peserta hanya satu kali dan tidak bisa diulangi!`)">Tetapkan Peserta Kegiatan &raquo;</a> -->
                    	</div>

                        <?php if ($_SESSION['app_level'] == 3): ?>
                        <div id="validasi" class="tab-pane fade" role="tabpanel" aria-labelledby="validasi">
                        	<div class="alert alert-info">
	                    		<i class="pli-information me-1"></i> Program kampus merdeka yang <b>disetujui</b> akan dipublikasikan dan bisa di-kontrak oleh mahasiswa.
	                    	</div>
                    		<form action="<?= base_url('mbkm/aktif/program_mitra/status_program') ?>" method="POST">
                    			<input type="hidden" name="id_program_mitra" value="<?= sha1($detail->id_program_mitra) ?>">
	                    		<div class="row">
	                    			<div class="col-12 mb-3">
	                    				<label for="status" class="form-label">Status Pengajuan Program <span class="text-danger">*</span></label>
	                    				<select class="form-select" name="status" id="status" required="">
	                    					<option value="" hidden="">Pilih Status</option>
	                    					<option value="1" <?= $detail->status == 1 ? 'selected' : ''; ?> >Program Disetujui</option>
	                    					<option value="0" <?= $detail->status == 0 ? 'selected' : ''; ?> >Program Ditolak</option>
	                    				</select>
	                    			</div>
	                    			<div class="col-12 mb-3">
	                    				<label for="keterangan_status" class="form-label">Keterangan (Opsional)</label>
	                    				<textarea name="keterangan_status" id="keterangan_status" class="form-control" placeholder="Tulis keterangan disini ..." rows="5"><?= $detail->keterangan_status ?></textarea>
	                    			</div>
	                    			<div class="col-12">
	                    				<div class="row">
	                    					<div class="col">
	                    						<a href="<?= base_url('mbkm') ?>" class="btn btn-danger w-100"><i class="psi-left-4 me-1"></i> Kembali</a>
	                    					</div>
	                    					<div class="col">
	                    						<button class="btn btn-info w-100"><i class="psi-paper-plane me-1"></i> Simpan Status</button>
	                    					</div>
	                    				</div>
	                    			</div>
	                    		</div>
	                    	</form>
                        <?php endif; ?>

                    </div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('lyt/js_datatable'); ?>
<style>
.dataTables_length { display: block; }
#datatabel_wrapper .row:first-child { display: none !important; }
</style>
<script>
	var table_mk, table_program_mitra, table_peserta

	function status(id_pendaftaran) {
		var status = prompt('Silahkan masukan kode status:\n1: Diterima\n0: Ditolak\natau, kosongkan untuk status default (diproses).\n\n*) Status pendaftaran yang sudah diubah tidak bisa diatur kembali.')
		if (status == 1 || status == 0) {
			var formData = new FormData()
			formData.append('id_program_mitra', '<?= sha1($detail->id_program_mitra) ?>')
			formData.append('kuota', <?= $detail->kuota ?>)
			formData.append('id_pendaftaran', id_pendaftaran)
			formData.append('status', status)

			fetch('<?= base_url('mbkm/status_peserta') ?>', { method: 'POST', body: formData })
			.then(response => response.text())
			.then(text => {
				table_peserta.ajax.reload(null,false);
				Toastify({
					text: text,
				}).showToast();
			})
		} else {
			alert('Maaf, status harus bernilai 0 (Ditolak) atau 1 (Diterima).')
		}
	}

	function tambah_berkas_program_mitra(e) {
		var formData = new FormData(e)
		formData.append('slug', e[0].options[e[0].selectedIndex].dataset.slug)

		fetch('<?= base_url('mbkm/tambah_berkas_program_mitra/'.$detail->id_program_mitra) ?>', { method: 'POST', body: formData })
		.then(response => response.text())
		.then(text => {
			table_program_mitra.ajax.reload(null,false);
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

	function hapus_berkas_program_mitra(id_berkas_program_mitra) {
		var konfirmasi = confirm('Hapus Dokumen Yang Dipilih ?')
		if (konfirmasi) {
			var formData = new FormData()
			formData.append('id_berkas_program_mitra', id_berkas_program_mitra)

			fetch('<?= base_url('mbkm/hapus/berkas_program_mitra') ?>', { method: 'POST', body: formData })
			.then(response => response.text())
			.then(text => {
				table_program_mitra.ajax.reload(null,false);
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

	function tambah_matkul_program(e) {
		var formData = new FormData(e)
		fetch('<?= base_url('mbkm/tambah_matkul_program/'.$detail->id_program_mitra) ?>', { method: 'POST', body: formData })
		.then(response => response.text())
		.then(text => {
			table_mk.ajax.reload(null,false);
			if (text == 1) {
				Toastify({
					text: "Info: Mata kuliah berhasil ditambahkan.",
				}).showToast();
			} else {
				Toastify({
					text: "Error: Mata kuliah gagal ditambahkan atau mata kuliah sudah ada pada tabel.",
				}).showToast();
			}

			e.reset()
		})
	}

	function hapus_matkul_program(idm, ipm) {
	var konfirmasi = confirm('Hapus Mata Kuliah Yang Dipilih ?')
	if (konfirmasi) {
		var formData = new FormData()
		formData.append('idm', idm)
		formData.append('ipm', ipm)

		fetch('<?= base_url('mbkm/hapus_matkul_program') ?>', { method: 'POST', body: formData })
		.then(response => response.text())
		.then(text => {
			table_mk.ajax.reload(null,false);
			if (text == 1) {
				Toastify({
					text: "Info: Mata kuliah berhasil dihapus.",
				}).showToast();
			} else {
				Toastify({
					text: "Error: Mata kuliah gagal dihapus.",
				}).showToast();
			}
		})
	}

	return
}
	
	$(document).ready(function() {
		table_mk = $('#datatabel').DataTable( {
			ajax: {
				url 	: "<?= base_url('mbkm/json_matkul_program') ?>",
				type 	: 'GET',
				data : function(d) {
					d.ipm = '<?= sha1($detail->id_program_mitra) ?>';
				}
			},
			// responsive: true,
			"autoWidth": false,
			dom: 	"<'row'<'col-sm-12 col-md-4 mb-1'l><'col-sm-12 col-md-4 mb-1'B><'col-sm-12 col-md-4 mb-1'f>>" +
					"<'row'<'col-sm-12 mb-1'tr>>" +
					"<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
			buttons: [],
			serverSide: true,
			processing: true,
			lengthChange: false, searching: false, paging: false, info: false,
			footerCallback: function (row, data, start, end, display) {
	            var api = this.api();
	 
	            // Remove the formatting to get integer data for summation
	            var intVal = function (i) {
	                return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
	            };
	 
	            // Total over all pages
	            total = api
	                .column(4)
	                .data()
	                .reduce(function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0);
	 
	            // Update footer
	            $(api.column(4).footer()).html(total + ' / ' + <?= $detail->sks_diakui ?> + ' SKS' );
	        },
		} );

		table_program_mitra = $('#datatable_program_mitra').DataTable( {
			ajax: {
				url 	: "<?= base_url('mbkm/json_berkas_program_mitra') ?>",
				type 	: 'GET',
				data : function(d) {
					d.id_program_mitra = '<?= sha1($detail->id_program_mitra) ?>';
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

		table_peserta = $('#datatable_peserta').DataTable( {
			ajax: {
				url 	: "<?= base_url('mbkm/json_peserta') ?>",
				type 	: 'GET',
				data : function(d) {
					d.id_program_mitra = '<?= sha1($detail->id_program_mitra) ?>';
				}
			},
			responsive: true,
			"autoWidth": false,
			dom: 	"<'row'<'col-sm-12 col-md-4 mb-1'l><'col-sm-12 col-md-4 mb-1'B><'col-sm-12 col-md-4 mb-1'f>>" +
					"<'row'<'col-sm-12 mb-1'tr>>" +
					"<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
			order: [[ 5, 'desc' ], [ 4, 'asc' ], [ 2, 'asc' ]],
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