<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">

			<div class="colmb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
<?php if($_SESSION['app_level']==3) { ?>
<div class="row mb-3">
	<div class="col-md-12 m-2">
		<div class="mb-2 d-grid gap-2">
			<a href="<?= base_url('mahasiswa/mutasi_cari/') ?>" class="btn btn-sm btn-danger" >Mutasi Baru</a>
		</div>	
	</div>
</div>
<?php } ?>
<div class="row">
	<div class="col-md-3 mt-1">
		<label for="mulai_smt" class="form-label">Semester</label>
		<select id="mulai_smt" name="mulai_smt" class="form-select">
			<option value="0">Semua</option>
			<?php 
				$ref_smt 	= $this->Main_model->ref_smt();
				foreach($ref_smt as $ket=>$value)
				{
					echo'<option value="'.$value->id_semester.'">'.$value->nama_semester.'</option>';
				}
			?>
		</select>
	</div>
	<div class="col-md-3 mt-1">
		<label for="kode_fak" class="form-label">Fakultas</label>
		<select id="kode_fak" name="kode_fak" class="form-select"  onchange="ref_prodi()">
			<option value="<?=$_SESSION['kode_fak']?>">Pilih Fakultas</option>
			<?php 
				$ref_fakultas 	= $this->Main_model->ref_fakultas($_SESSION['kode_fak']);
				foreach($ref_fakultas as $ket=>$value)
				{
					echo'<option value="'.$value->kode_fak.'">'.$value->nama_fak.'</option>';
				}
			?>
		</select>
	</div>
	<div class="col-md-3 mt-1">
		<label for="kode_prodi" class="form-label">Program Studi</label>
		<select id="kode_prodi" name="kode_prodi" class="form-select">
			<option value="<?=$_SESSION['kode_prodi']?>">Pilih Program Studi</option>
		</select>
	</div>
	<div class="col-md-3 mt-1">
		<label for="status_mutasi" class="form-label">Status</label>
		<select id="status_mutasi" name="status_mutasi" class="form-select">
			<option value="0">Semua</option>
			<option value="1">Draft</option>
			<option value="2">Req. NIM</option>
			<option value="3">Siap Mutasi</option>
			<option value="4">Selesai</option>
		</select>
	</div>
</div>

<div class="table-responsive mt-2">
<table id="datatabel" class="table table-striped" style="width:100%">
<thead>
    <tr>	
		<th>Semester Masuk</th>
        <th>NIM Lama</th>
        <th>NIM Baru</th>
        <th>Prodi Baru</th>
        <th>Nama Mahasiswa</th>
        <th>Status</th>
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

<?php $this->load->view('lyt/js_datatable'); ?>
<script type="text/javascript">
$(document).ready(function() {
	var table = $('#datatabel').DataTable( {
		search: {
            return: true,
        },
		ajax: {
			url 	: "<?=base_url('mahasiswa/json_mutasi')?>",
			type 	: 'GET',
			data : function(d){
				d.mulai_smt =$("#mulai_smt").val();
				d.kode_fak =$("#kode_fak").val();
				d.kode_prodi = $("#kode_prodi").val();
				d.status_mutasi = $("#status_mutasi").val();
			}
		},	
		order: [[1, 'asc']],
		columnDefs: [
			{ targets: [0], orderable: false },
			{ targets: [0], searchable: false },
		],
		responsive: true,
		dom: 	"<'row'<'col-sm-12 col-md-4 mb-1'l><'col-sm-12 col-md-4 mb-1'B><'col-sm-12 col-md-4 mb-1'f>>" +
				"<'row'<'col-sm-12 mb-1'tr>>" +
				"<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
		lengthMenu: [
			[ 10, 25, 50, -1 ],
			[ '10 rows', '25 rows', '50 rows', 'Show all' ]
		],
		buttons: [
			{
				extend:'excelHtml5',
				className:'btn btn-success',
			},
			{
				extend:'pdfHtml5',
				className:'btn btn-danger',
			},
			{
				extend:'print',
				className:'btn btn-info',
			},
		],
		serverSide: true,
		processing: true,
	} );
	
	$('#status_mutasi').change(function(){ //button filter event click
        table.ajax.reload(null,false);  //just reload table
	});
	
	$('#mulai_smt').change(function(){ //button filter event click
        table.ajax.reload(null,false);  //just reload table
	});
	
	$('#kode_fak').change(function(){ //button filter event click
        table.ajax.reload(null,false);  //just reload table
	});
	
	$('#kode_prodi').change(function(){ //button filter event click
        table.ajax.reload(null,false);  //just reload table
	});
} );

function ref_prodi()
{
    var kode_fak = document.getElementById('kode_fak').value;
    let url = "<?=base_url('utama/ref_prodi/')?>"+kode_fak;
    
    fetch(url)
        .then((response) => response.text())
        .then((text) => {
            document.getElementById('kode_prodi').innerHTML = text;
        });
}
</script>
