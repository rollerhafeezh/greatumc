<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">

			<div class="col-lg-8 col-12 offset-lg-2 mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
						<style type="text/css">
							table.dataTable>tbody>tr.child span.dtr-title {
								display: block !important;
							}
							table.dataTable>tbody>tr.child ul.dtr-details {
								width: 100%;
							}
						</style>
						<div class="table-responsive mt-2">
							<table id="datatabel" class="table table-striped" style="width:100%">
								<thead>
		                            <tr>
		                                <th width="1">No</th>
		                                <th>Skema</th>
		                                <th>Semester</th>
		                                <!-- <th width="1">NIDN</th> -->
		                                <th class="text-nowrap">Nama PIC</th>
		                                <th width="1">Aksi</th>
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

<!-- Modal Filter Pencarian -->
<div class="modal fade" id="modal_filter" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_filter" style="display: none;" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="psi-filter-2 me-2"></i> Filter Pencarian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
	  <div class="modal-body">
	  	<form id="form_filter">
	  	<div class="row">
	  		<div class="col-md-6 mb-2">
				<label for="id_program" class="form-label">Skema</label>
				<select id="id_program" name="id_program" class="form-select">
					<option value="0">Semua Data</option>
					<?php foreach($this->Mbkm_model->program_mbkm(null, 'nama_jenis_aktivitas_mahasiswa ASC')->result() as $program): ?>
                    <option value="<?= $program->id_program ?>" ><?= $program->nama_jenis_aktivitas_mahasiswa ?> <?= $program->nama_program ?></option>
                    <?php endforeach; ?>
				</select>
			</div>
	  		<div class="col-md-6 mb-2">
				<label for="id_smt" class="form-label">Semester</label>
				<select id="id_smt" name="id_smt" class="form-select">
					<option value="0">Semua Data</option>
					<?php 
						$ref_smt 	= $this->Main_model->ref_smt();
						foreach($ref_smt as $ket=>$value)
						{
							echo'<option value="'.$value->id_semester.'">'.$value->nama_semester.'</option>';
						}
					?>
				</select>
			</div>
		</div>
		<div class="row mt-2">
			<div class="col">
				<button type="button" id="reset_filter" class="btn btn-danger w-100"><i class="psi-repeat-3 me-1"></i> Reset Filter</button>
			</div>
			<div class="col">
				<button type="button" class="btn btn-dark w-100" data-bs-dismiss="modal" aria-label="Close"><i class="psi-hand-touch me-1"></i> Terapkan</button>
			</div>
		</div>	
	  </div>
	  </form>
    </div>
  </div>
</div>
<!-- Modal Filter Pencarian -->

<!-- Modal Tambah Koordinator -->
<div class="modal fade" id="modal_tambah_koordinator" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_tambah_koordinator" style="display: none;" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah PIC Kampus Merdeka</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
	  <div class="modal-body">
	  	<form id="form_tambah_koordinator" onsubmit="event.preventDefault(); tambah_koordinator(this)">
	  	<div class="row">
	  		<div class="col-md-12 mb-2">
				<label class="form-label" for="id_program_">Skema Program <span class="text-danger">*</span></label>
				<select id="id_program_" name="id_program" class="form-select" required="">
					<option value="" hidden="">Pilih Skema</option>
					<?php foreach($this->Mbkm_model->program_mbkm(null, 'nama_jenis_aktivitas_mahasiswa ASC')->result() as $program): ?>
                    <option value="<?= $program->id_program ?>" ><?= $program->nama_jenis_aktivitas_mahasiswa ?> <?= $program->nama_program ?></option>
                    <?php endforeach; ?>
				</select>
			</div>
	  		<div class="col-md-12 mb-2 mt-2">
				<label class="form-label" for="id_smt_">Semester Pelaksanaan <span class="text-danger">*</span></label>
				<select id="id_smt_" name="id_smt" class="form-select" required="">
					<option value="" hidden="">Pilih Semester</option>
					<?php 
						$ref_smt 	= $this->Main_model->ref_smt();
						foreach($ref_smt as $ket=>$value)
						{
							echo'<option value="'.$value->id_semester.'">'.$value->nama_semester.'</option>';
						}
					?>
				</select>
			</div>
			<div class="col-md-12 mb-2 mt-2">
				<label class="form-label" for="nidn">Dosen PIC <span class="text-danger">*</span></label>
				<input type="text"	class="form-control" id="nidn" name="nidn" list="pic" required="" placeholder="Masukan NIDN atau Nama Dosen">
				<datalist id="pic">
				<?php 
					$get_dosen_pt 	= $this->Main_model->get_dosen_pt();
					foreach($get_dosen_pt as $dosen_pt)
					{
						echo'<option value="'.$dosen_pt->nidn.'">'.$dosen_pt->nm_sdm.'</option>';
					}
				?>
				</datalist>
			</div>
		</div>
		<div class="row mt-2">
			<div class="col">
				<button class="btn btn-info w-100"><i class="psi-paper-plane me-1"></i> Simpan</button>
			</div>
		</div>	
	  </div>
	  </form>
    </div>
  </div>
</div>
<!-- Modal Tambah Koordinator -->

<?php $this->load->view('lyt/js_datatable'); ?>
<style>
.dataTables_length { display: block; }
</style>
<script type="text/javascript">
	var table

	function tambah_koordinator(e) {
		var formData = new FormData(e)

		fetch('<?= base_url('mbkm/tambah_koordinator_program') ?>', { method: 'POST', body: formData })
		.then(response => response.text())
		.then(text => {
			table.ajax.reload(null,false);
			if (text == '1') {
				e.reset()
				Toastify({
					text: "Sukses: PIC kampus merdeka berhasil disimpan.",
				}).showToast();
			} else {
				Toastify({
					text: "Error: PIC kampus merdeka gagal disimpan atau sudah ada.",
				}).showToast();
			}
		})
	}

	function hapus(id) {
		var konfirmasi = confirm('Hapus PIC Yang Dipilih ?')
		if (konfirmasi) {
			var formData = new FormData()
			formData.append('id_koordinator_program', id)

			fetch('<?= base_url('mbkm/hapus/koordinator_program') ?>', { method: 'POST', body: formData })
			.then(response => response.text())
			.then(text => {
				table.ajax.reload(null,false);
				Toastify({
					text: "PIC kampus merdeka berhasil dihapus.",
				}).showToast();
			})
		}

		return
	}

	function aktif(id, aktif) {
		var konfirmasi = confirm('Ganti Status Aktif PIC ?')
		if (konfirmasi) {
			var formData = new FormData()
			formData.append('id_koordinator_program', id)
			formData.append('aktif', aktif)

			fetch('<?= base_url('mbkm/aktif/koordinator_program') ?>', { method: 'POST', body: formData })
			.then(response => response.text())
			.then(text => {
				table.ajax.reload(null,false);
				Toastify({
					text: "Info: Status aktif berhasil diganti.",
				}).showToast();
			})
		}

		return
	}

	$(document).ready(function() {
		table = $('#datatabel').DataTable( {
			ajax: {
				url 	: "<?= base_url('mbkm/json_koordinator_program') ?>",
				type 	: 'GET',
				data : function(d) {
					d.id_program = $("#id_program").val();
					d.id_smt = $("#id_smt").val();
				}
			},
			responsive: true,
			columnDefs: [
				// { targets: [1], className: 'text-center'},
				{ targets: [1], className: 'text-nowrap' }
			],
			dom: 	"<'row'<'col-sm-12 col-md-4 mb-1'l><'col-sm-12 col-md-4 mb-1'B><'col-sm-12 col-md-4 mb-1'f>>" +
					"<'row'<'col-sm-12 mb-1'tr>>" +
					"<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
			lengthMenu: [
				[ 10, 25, 50, -1 ],
				[ '10 rows', '25 rows', '50 rows', 'Show all' ]
			],
			buttons: [
				{
	                text: '<i class="psi-filter-2"></i> Filter',
	                className: 'btn btn-light',
	                action: function ( e, dt, node, config ) {
	                    $('#modal_filter').modal('show')
	                }
	            },
				<?php if ($_SESSION['app_level'] == 3): ?>
				{
	                text: 'Tambah',
	                className: 'btn btn-info',
	                action: function ( e, dt, node, config ) {
	                    $('#modal_tambah_koordinator').modal('show')
	                }
	            },
	        	<?php endif; ?>
			],
			serverSide: true,
			processing: true,
			search: {
	            return: true,
	        },
		} );

		$('#reset_filter').click(function(){ //button filter event click
			$('#form_filter').trigger('reset')
	        table.ajax.reload(null,false);  //just reload table
		});
		
		$('#id_smt, #id_program').change(function(){ //button filter event click
	        table.ajax.reload(null,false);  //just reload table
		});
		
	} );
</script>
