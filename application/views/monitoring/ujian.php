<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">

			<div class="colmb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
					<h4>Filter : </h4>
<div class="row">
	<div class="col-md-6 mt-1">
		<label for="tanggal" class="form-label">Tanggal</label>
		<input type="date" value="<?=date("Y-m-d")?>" class="form-control" id="tanggal">
	</div>
	<div class="col-md-6 mt-1">
		<label for="jenis" class="form-label">Jenis Ujian</label>
		<select id="jenis" name="jenis" class="form-select">
			<option value="uts">UTS</option>
			<option value="uas">UAS</option>
		</select>
	</div>
	<div class="col-md-6 mt-1">
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
	<div class="col-md-6 mt-1">
		<label for="kode_prodi" class="form-label">Program Studi</label>
		<select id="kode_prodi" name="kode_prodi" class="form-select">
			<option value="<?=$_SESSION['kode_prodi']?>">Pilih Program Studi</option>
		</select>
	</div>
	<div class="col-md-6" id="pilih_gedung">
	    <label for="id_gedung" class="form-label">Gedung</label>
		<select id="id_gedung" name="id_gedung" class="form-select" onchange="ref_gedung()">
			<option value="0">Pilih Gedung</option>
			<?php
			$id_gedung = $this->Gedung_model->get_gedung(null,1);
			foreach($id_gedung->result() as $ket=>$value)
			{
				echo'<option value="'.$value->id_gedung.'">'.$value->nama_gedung.'</option>';
			}
			?>
		</select>
	</div>
	<div class="col-md-6"  id="pilih_ruangan">
		<label for="id_ruangan" class="form-label">Ruangan</label>
		<select id="id_ruangan" name="id_ruangan" class="form-select">
			<option value="0">Pilih Ruangan</option>
		</select>
	</div>
	
</div>
<div class="table-responsive mt-2">
<table id="datatabel" class="table table-striped" style="width:100%">
<thead>
    <tr>
        <th>Nama Kelas</th>
        <th>Fakultas/ Prodi</th>
        <th>Jadwal</th>
        <th>Status</th>
        <th>Cetak</th>
        <th>Pengampu</th>
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
		ajax: {
			url 	: "<?=base_url('monitoring/json_ujian')?>",
			type 	: 'GET',
			data : function(d){
				d.kode_fak =$("#kode_fak").val();
				d.kode_prodi = $("#kode_prodi").val();
				d.tanggal=$("#tanggal").val();
				d.jenis=$("#jenis").val();
				d.id_gedung=$("#id_gedung").val();
				d.id_ruangan=$("#id_ruangan").val();
			}
		},
		order: [[2, 'asc']],
		columnDefs: [
			{ targets: [0,1], orderable: false },
			{ targets: [2,3], searchable: false },
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
		search: {
            return: true,
        },
	} );
	
	$('#tanggal').change(function(){ //button filter event click
        table.ajax.reload(null,false);  //just reload table
	});
	
	$('#kode_fak').change(function(){ //button filter event click
        table.ajax.reload(null,false);  //just reload table
	});
	
	$('#kode_prodi').change(function(){ //button filter event click
        table.ajax.reload(null,false);  //just reload table
	});
	
	$('#jenis').change(function(){ //button filter event click
        table.ajax.reload(null,false);  //just reload table
	});
	
	$('#id_gedung').change(function(){ //button filter event click
        table.ajax.reload(null,false);  //just reload table
	});
	
	$('#id_ruangan').change(function(){ //button filter event click
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
function ref_gedung()
{
    var id_gedung = document.getElementById('id_gedung').value;
    let url = "<?=base_url('utama/ref_gedung/')?>"+id_gedung;
    
    fetch(url)
        .then((response) => response.text())
        .then((text) => {
            document.getElementById('id_ruangan').innerHTML = text;
        });
}
</script>
