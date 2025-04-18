<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">

			<div class="col mb-4">
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
		                                <th data-priority="1" class="text-nowrap">Skema Program</th>
		                                <th data-priority="2">Prodi</th>
		                                <th>Lokasi Kegiatan</th>
		                                <th width="1">Jadwal Kegiatan</th>
		                                <th width="1">Pendaftaran</th>
		                                <th width="1" data-priority="3">Kuota</th>
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
				<label for="id_program" class="form-label">Jenis Skema</label>
				<select id="id_program" name="id_program" class="form-select">
					<option value="0">Semua Data</option>
					<?php foreach($this->Mbkm_model->program_mbkm(null, 'nama_jenis_aktivitas_mahasiswa ASC')->result() as $program): ?>
                    <option value="<?= $program->id_program ?>" ><?= $program->nama_jenis_aktivitas_mahasiswa ?> <?= $program->nama_program ?></option>
                    <?php endforeach; ?>
				</select>
			</div>
			<div class="col-md-6 mb-2">
				<label for="jenis_program" class="form-label">Jenis Program</label>
				<select id="jenis_program" name="jenis_program" class="form-select">
					<option value="">Semua Data</option>
					<option value="1">Program Mandiri</option>
					<option value="2">Program Kementrian (Pusat)</option>
				</select>
			</div>
			<div class="col-md-6 mb-2">
				<label for="pendaftaran" class="form-label">Status Pendaftaran</label>
				<select id="pendaftaran" name="pendaftaran" class="form-select">
					<option value="">Semua Data</option>
					<option value="1">Pendaftaran Dibuka</option>
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

<!-- Modal Informasi Kegiatan -->
<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="detail_kegiatan" >
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="detail_kegiatanLabel">Detail Kegiatan</h5>
            <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        	<div class="detail_kegiatan"></div>
            <div class="loading">
                <div class="py-2 text-center">

                    <!-- Loader - Ball grid pulse -->
                    <div class="loader">
                        <div class="loader-inner line-scale">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                    <!-- END : Loader - Ball grid pulse -->

                </div>
                <p class="text-center">
                    Sedang memuat data, silahkan tunggu ...
                </p>
            </div>
        </div>
    </div>
  </div>
</div>
<!-- Modal Informasi Kegiatan -->

<?php $this->load->view('lyt/js_datatable'); ?>
<style>
.dataTables_length { display: block; }
</style>
<script type="text/javascript">
var table

function detail_kegiatan(id) {
	var detail_kegiatan = document.querySelector('.detail_kegiatan')
	var loading = document.querySelector('.loading')

    var modal_detail_kegiatan = new bootstrap.Modal(document.getElementById('detail_kegiatan'))
    modal_detail_kegiatan.show()
    
	loading.style.display = 'block'
	detail_kegiatan.style.display = 'none'

    var formData = new FormData()
    formData.append('id_program_mitra', id)

    fetch('<?= base_url('mbkm/detail_kegiatan') ?>', { method: 'POST', body: formData })
    .then(response => response.text())
    .then(text => {
    	loading.style.display = 'none'
        detail_kegiatan.innerHTML = text
		detail_kegiatan.style.display = 'block'
    })
}

$(document).ready(function() {
	table = $('#datatabel').DataTable( {
		ajax: {
			url 	: "<?= base_url('mbkm/json') ?>",
			type 	: 'GET',
			data : function(d) {
				d.kode_fak =$("#kode_fak").val();
				d.kode_prodi = $("#kode_prodi").val();
				d.id_smt = $("#id_smt").val();
				d.id_jenis_aktivitas_mahasiswa = 0;
				d.id_program = $("#id_program").val();
				d.jenis_program = $("#jenis_program").val();
				d.pendaftaran = $("#pendaftaran").val();
			}
		},
		responsive: true,
		columnDefs: [
			{ targets: [4], className: 'text-nowrap'},
			// { targets: [3], orderable: false }
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
                text: '<i class="psi-filter-2"></i> Filter Pencarian',
                className: 'btn btn-light',
                action: function ( e, dt, node, config ) {
                    $('#modal_filter').modal('show')
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
	
	$('#kode_fak, #kode_prodi, #id_smt, #id_program, #pendaftaran, #jenis_program').change(function(){ //button filter event click
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
