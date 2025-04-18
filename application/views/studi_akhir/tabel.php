<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">

			<div class="colmb-4">
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
								        <th>ID</th>
								        <th data-priority="1">NPM</th>
								        <th data-priority="2" class="text-nowrap">Nama Mahasiswa</th>
								        <th  class="text-nowrap">Program Studi</th>
								        <th>Semester</th>
								        <th data-priority="3" >Jenis</th>
								        <th>Judul</th>
								        <th class="text-nowrap">Pembimbing</th>
								        <th>Status</th>
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
				<label for="kode_fak" class="form-label">Fakultas</label>
				<select id="kode_fak" name="kode_fak" class="form-select"  onchange="ref_prodi()">
					<option value="<?=$_SESSION['kode_fak']?>">Semua Data</option>
					<?php 
						$ref_fakultas 	= $this->Main_model->ref_fakultas($_SESSION['kode_fak']);
						foreach($ref_fakultas as $ket=>$value)
						{
							echo'<option value="'.$value->kode_fak.'">'.$value->nama_fak.'</option>';
						}
					?>
				</select>
			</div>
			<div class="col-md-6 mb-2">
				<label for="kode_prodi" class="form-label">Program Studi</label>
				<select id="kode_prodi" name="kode_prodi" class="form-select">
					<option value="<?=$_SESSION['kode_prodi']?>">Semua Data</option>
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
			<div class="col-md-6 mb-2">
				<label for="id_jenis_aktivitas_mahasiswa" class="form-label">Jenis Aktivitas Mahasiswa</label>
				<select id="id_jenis_aktivitas_mahasiswa" name="id_jenis_aktivitas_mahasiswa" class="form-select">
					<option value="0">Semua Data</option>
					<?php 
						$ref_jenis_aktivitas_mahasiswa 	= $this->Main_model->ref_jenis_aktivitas_mahasiswa();
						foreach($ref_jenis_aktivitas_mahasiswa as $ket=>$value)
						{
							if ($value->id_jenis_aktivitas_mahasiswa == 2 || $value->id_jenis_aktivitas_mahasiswa == 6) {
								echo'<option value="'.$value->id_jenis_aktivitas_mahasiswa.'">'.$value->nama_jenis_aktivitas_mahasiswa.'</option>';
							}
						}
					?>
				</select>
			</div>
			<div class="col-md-6 mb-2">
				<label for="status" class="form-label">Status</label>
				<select id="status" name="status" class="form-select">
					<option value="">Semua Data</option>
					<option value="0">Belum Selesai</option>
					<option value="1">Selesai</option>
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

<!-- Modal Rekap Peserta Wisuda -->
<div class="modal fade" id="rekap_peserta_wisuda" tabindex="-1" role="dialog" aria-labelledby="rekap_peserta_wisudaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
		<div class="modal-header">
	        <h5 class="modal-title" id="rekap_peserta_wisudaLabel"><i class="psi-student-male me-2"></i> Rekap Peserta Wisudawan</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
			<form class="form rekap_peserta_wisuda">
				<div class="row">
					<div class="form-group col-md-6 mb-2">
					  <label class="form-label" for="kode_fak_2">Fakultas</label>
					  <select name="kode_fak" id="kode_fak_2" required class="form-control" onchange="ref_prodi('kode_prodi_2')">
						  <option value="<?=$_SESSION['kode_fak']?>" selected>Semua Fakultas</option>
							<?php 
								$ref_fakultas 	= $this->Main_model->ref_fakultas($_SESSION['kode_fak']);
								foreach($ref_fakultas as $ket=>$value)
								{
									echo'<option value="'.$value->kode_fak.'">'.$value->nama_fak.'</option>';
								}
							?>
						</select>
					</div>
					<div class="form-group col-md-6 mb-2">
						<label class="form-label" for="kode_prodi_2">Program Studi</label>
						<select id="kode_prodi_2" name="kode_prodi" class="form-control">
							<option value="<?=$_SESSION['kode_prodi']?>">Semua Program Studi</option>
						</select>
					</div>
					<div class="form-group col-md-6 mb-2" bis_skin_checked="1">
						<label class="form-label" for="mulai">Mulai Tanggal Sidang</label>
						<input type="date" id="mulai" class="form-control" name="mulai" required="">
					</div>
					<div class="form-group col-md-6 mb-2" bis_skin_checked="1">
						<label class="form-label" for="selesai">Selesai Tanggal Sidang</label>
						<input type="date" id="selesai" class="form-control" name="selesai" required="">
					</div>
				</div>
				<button type="submit" class="btn btn-info w-100 mt-2">Lihat Perserta Wisudawan <i class="ms-2 psi-arrow-right-in-circle"></i></button>
			</form>
		</div>
		</div>
	</div>
</div>
<!-- Modal Rekap Peserta Wisuda -->

<?php $this->load->view('lyt/js_datatable'); ?>
<style>
.dataTables_length { display: block; }
</style>
<script type="text/javascript">
var table
rekap_peserta_wisuda = document.querySelector('.rekap_peserta_wisuda')
rekap_peserta_wisuda.addEventListener('submit', event => {
	event.preventDefault()
	var formData = new FormData(rekap_peserta_wisuda)
	var param = new URLSearchParams(formData).toString();

	window.open(`<?= base_url('studi_akhir/wisudawan') ?>?${param}`)
})

function hapus(id) {
	konfirmasi = prompt(`Silahkan masukkan kata 'HAPUS' untuk menghapus data. \n\n* Data akan dihapus secara permanen.\n* Data yang dihapus merupakan tanggung jawab pribadi.`)
	if (konfirmasi == 'HAPUS') {
		fetch('<?= base_url('studi_akhir/hapus/') ?>' + id)
		.then(response => response.text())
		.then(text => {
			table.ajax.reload(null,false);
			Toastify({
				text: "Info: data studi akhir berhasil dihapus.",
			}).showToast();
		})
	}

	return
}

$(document).ready(function() {

	table = $('#datatabel').DataTable( {
		ajax: {
			url 	: "<?=base_url('studi_akhir/json')?>",
			type 	: 'GET',
			data : function(d){
				d.kode_fak =$("#kode_fak").val();
				d.kode_prodi = $("#kode_prodi").val();
				d.id_smt = $("#id_smt").val();
				d.id_jenis_aktivitas_mahasiswa = $("#id_jenis_aktivitas_mahasiswa").val();
				d.status = $("#status").val();
			}
		},
		order: [[2, 'asc']],
		responsive: true,
		columnDefs: [
			// { targets: [1], className: 'text-center'},
			{ targets: [9], orderable: false }
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
            {
                text: '<i class="psi-student-male"></i> Wisudawan',
                className: 'btn btn-info',
                action: function ( e, dt, node, config ) {
                    $('#rekap_peserta_wisuda').modal('show')
                }
            },
			{
				extend:'excelHtml5',
				className:'btn btn-success',
			},
			{
				extend:'pdfHtml5',
				className:'btn btn-danger',
			},
			// {
			// 	extend:'print',
			// 	className:'btn btn-info',
			// },
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
	
	$('#kode_fak, #kode_prodi, #id_smt, #id_jenis_aktivitas_mahasiswa, #status').change(function(){ //button filter event click
        table.ajax.reload(null,false);  //just reload table
	});
	
} );

function ref_prodi(ele = 'kode_prodi')
{
    var kode_fak = document.getElementById('kode_fak').value;
    let url = "<?=base_url('utama/ref_prodi/')?>"+kode_fak;
    
    fetch(url)
        .then((response) => response.text())
        .then((text) => {
            document.getElementById(ele).innerHTML = text;
        });
}
</script>
