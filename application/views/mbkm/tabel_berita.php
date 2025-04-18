<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">

			<div class="col-lg-12 mb-4">
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
		                                <th class="text-nowrap">Judul Berita</th>
		                                <th class="text-nowrap">Tags</th>
		                                <th class="text-nowrap">Tgl. Dibuat</th>
		                                <th width="1">Aktif</th>
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
				<label for="aktif" class="form-label">Aktif</label>
				<select id="aktif" name="aktif" class="form-select">
					<option value="">Semua Data</option>
					<option value="0">Tidak</option>
					<option value="1">Ya</option>
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

<?php $this->load->view('lyt/js_datatable'); ?>
<style>
.dataTables_length { display: block; }
</style>
<script type="text/javascript">
	var table

	function hapus(id) {
		var konfirmasi = confirm('Hapus Berita Yang Dipilih ?')
		if (konfirmasi) {
			var formData = new FormData()
			formData.append('id_berita', id)

			fetch('<?= base_url('mbkm/hapus/berita') ?>', { method: 'POST', body: formData })
			.then(response => response.text())
			.then(text => {
				table.ajax.reload(null,false);
				Toastify({
					text: "Info: Berita kampus merdeka berhasil dihapus.",
				}).showToast();
			})
		}
		return
	}

	function aktif(id, aktif) {
		var konfirmasi = confirm('Ganti Status Aktif Berita ?')
		if (konfirmasi) {
			var formData = new FormData()
			formData.append('id_berita', id)
			formData.append('aktif', aktif)

			fetch('<?= base_url('mbkm/aktif/berita') ?>', { method: 'POST', body: formData })
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
				url 	: "<?= base_url('mbkm/json_berita') ?>",
				type 	: 'GET',
				data : function(d) {
					d.aktif = $("#aktif").val();
				}
			},
			responsive: true,
			columnDefs: [
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
	            },			{
					extend:'excelHtml5',
					className:'btn btn-success',
				},
				{
	                text: 'Tambah',
	                className: 'btn btn-info',
	                action: function ( e, dt, node, config ) {
	                    window.location.href = '<?= base_url ('mbkm/tambah_berita') ?>'
	                }
	            },
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
		
		$('#aktif').change(function(){ //button filter event click
	        table.ajax.reload(null,false);  //just reload table
		});
		
	} );
</script>
