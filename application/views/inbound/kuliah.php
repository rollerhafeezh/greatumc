<div class="content__boxed">
	<style type="text/css">
		table.w-100 tr td {
			vertical-align: top;
		}
	</style>
	<div class="content__wrap">
		<div class="row">
			<div class="col-md-4">
				<section id="boxed-layout-tips" class="card mb-3">
					<div class="card-body">
						<h5 class="card-title"><i class="pli-male-2 me-1" style="margin-top: -3px;"></i> Data Mahasiswa</h5>
						<table class="w-100">
							<tr>
								<td class="text-nowrap" width="40%">Nama Mhs.</td>
								<td width="1">: </td>
								<td><?= $mahasiswa_pt->nm_pd ?></td>
							</tr>
							<tr>
								<td class="text-nowrap">NIM</td>
								<td width="1">: </td>
								<td><?= $mahasiswa_pt->id_mahasiswa_pt ?></td>
							</tr>
							<tr>
								<td class="text-nowrap">No. Handphone</td>
								<td width="1">: </td>
								<td><?= $mahasiswa_pt->no_hp ?></td>
							</tr>
							<tr>
								<td class="text-nowrap">Email</td>
								<td width="1">: </td>
								<td><?= $mahasiswa_pt->email ?></td>
							</tr>
						</table>
					</div>
				</section>

				<section id="boxed-layout-tips" class="card mb-3">
					<div class="card-body">
						<h5 class="card-title"><i class="pli-university me-1" style="margin-top: -3px;"></i> Perguruan Tinggi Asal</h5>
						<table class="w-100">
							<tr>
								<td class="text-nowrap" width="40%">Nama PT</td>
								<td width="1">: </td>
								<td><?= $mahasiswa_pt->nm_lemb ?></td>
							</tr>
							<tr>
								<td class="text-nowrap">Nama Prodi</td>
								<td width="1">: </td>
								<td><?= $mahasiswa_pt->nama_prodi ?></td>
							</tr>
						</table>
					</div>
				</section>
			</div>

			<div class="col-md">
				<section id="boxed-layout-tips" class="card mb-3" method="post">
					<div class="card-body">
						<h5 class="card-title"><i class="pli-notepad me-1" style="margin-top: -3px;"></i> Kartu Rencana Studi</h5>

						<form  id="form_lihat_kelas" class="mt-4">
							<div class="row">
								<div class="col-md-4 mb-2">
									<div class="form-group">
										<select class="form-select" required id="kode_prodi" name="kode_prodi">
											<option value="">Pilih Program Studi</option>
											<option value="1">Informatika</option>
										</select>
									</div>
								</div>
								<div class="col-md-5 mb-2">
									<div class="form-group">
										<select class="form-select" required id="id_matkul" name="id_matkul">
											<option value="">Pilih Mata Kuliah</option>
											<option value="1">Kur 2025</option>
										</select>
									</div>
								</div>
								<div class="col-md-3 mb-2">
									<button type="submit" class="btn d-block btn-md btn-info w-100"><i class="pli-magnifi-glass me-1" style="margin-top: -3px;"></i> Lihat Kelas</button>
								</div>
							</div>
						</form>

						<table class="table table-striped mt-3">
							<thead>
								<tr>
									<th>Nama Kelas</th>
									<th>SKS</th>
									<th>Jadwal</th>
									<th>Ruang</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td colspan="5" class="text-center">
										<img src="<?= base_url('assets/images/no data.png') ?>" width="30%"><br>
										Oops, kartu rencana studi masih kosong. <br>
										Silahkan lihat dan ambil kelas terlebih dahulu.
									</td>
								</tr>
								<!-- <tr>
									<td><a href="#" class="text-decoration-none">Kalkulus dan Geometri</a></td>
									<td>4</td>
									<td>Senin, 08:45 s.d 11:45</td>
									<td>R. 301</td>
									<td>n/a</td>
								</tr>
								<tr>
									<td><a href="#" class="text-decoration-none">Logika Matematika & Digital</a></td>
									<td>3</td>
									<td>Senin, 13:00 s.d 14:45</td>
									<td>R. 301</td>
									<td>n/a</td>
								</tr> -->
							</tbody>
							<tfoot class="text-dark">
								<tr>
									<th></th>
									<th colspan="2">0 SKS</th>
								</tr>
							</tfoot>	
						</table>
					</div>
				</section>
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