<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">

			<div class="colmb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
					<h4>Filter : </h4>
<div class="row">
	<div class="col-md-4 mt-1">
		<label for="id_smt" class="form-label">Semester</label>
		<select id="id_smt" name="id_smt" class="form-select">
			<option value="0">Semua Semester</option>
			<?php 
				$ref_smt 	= $this->Main_model->ref_smt();
				foreach($ref_smt as $ket=>$value)
				{
					$selected=($value->id_semester==$_SESSION['active_smt'])?'selected':'';
					echo'<option value="'.$value->id_semester.'" '.$selected.'>'.$value->nama_semester.'</option>';
				}
			?>
		</select>
	</div>
	<div class="col-md-4 mt-1">
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
	<div class="col-md-4 mt-1">
		<label for="kode_prodi" class="form-label">Program Studi</label>
		<select id="kode_prodi" name="kode_prodi" class="form-select">
			<option value="<?=$_SESSION['kode_prodi']?>">Pilih Program Studi</option>
		</select>
	</div>
	<div class="col-md-2 mt-1">
		<label for="jadwal_kuliah" class="form-label">Jadwal Kuliah </label>
		<select id="jadwal_kuliah" name="jadwal_kuliah" class="form-select" onchange="sulap(`jadwal_kuliah`)">
			<option value="0">Sembunyikan</option>
			<option value="1">Tampilkan</option>
		</select>
	</div>
	<div class="col-md-2 mt-1">
		<label for="jadwal_uts" class="form-label">Jadwal UTS</label>
		<select id="jadwal_uts" name="jadwal_uts" class="form-select" onchange="sulap(`jadwal_uts`)">
			<option value="0">Sembunyikan</option>
			<option value="1">Tampilkan</option>
		</select>
	</div>
	<div class="col-md-2 mt-1">
		<label for="jadwal_uas" class="form-label">Jadwal UAS</label>
		<select id="jadwal_uas" name="jadwal_uas" class="form-select" onchange="sulap(`jadwal_uas`)">
			<option value="0">Sembunyikan</option>
			<option value="1">Tampilkan</option>
		</select>
	</div>
	<div class="col-md-2 mt-1">
		<label for="pengampu" class="form-label">Pengampu</label>
		<select id="pengampu" name="pengampu" class="form-select" onchange="sulap(`pengampu`)">
			<option value="0">Sembunyikan</option>
			<option value="1">Tampilkan</option>
		</select>
	</div>
	<div class="col-md-2 mt-1">
		<label for="persepsi" class="form-label">Skor Persepsi</label>
		<select id="persepsi" name="persepsi" class="form-select" onchange="sulap(`persepsi`)">
			<option value="0">Sembunyikan</option>
			<option value="1">Tampilkan</option>
		</select>
	</div>
</div>
<div class="table-responsive mt-2">
<table id="datatabel" class="table table-striped" style="width:100%">
<thead>
    <tr>
        <th>Semester</th>
        <th>Nama Kelas</th>
        <th>Kode Prodi</th>
        <th>Kuota</th>
        <th>Pertemuan</th>
        <th>Jadwal</th>
        <th>UTS</th>
        <th>UAS</th>
        <th>Pengampu</th>
        <th>Skor</th>
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
			url 	: "<?=base_url('kelas/json')?>",
			type 	: 'GET',
			data : function(d){
				d.kode_fak =$("#kode_fak").val();
				d.kode_prodi = $("#kode_prodi").val();
				d.id_smt=$("#id_smt").val();
			}
		},
		order: [[1, 'asc']],
		columnDefs: [
			{ targets: [0,2,5,6,7,8], orderable: false },
			{ targets: [0,1,3,4,5,6,7,8,9], searchable: false },
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
	
	$('#id_smt').change(function(){ //button filter event click
        table.ajax.reload(null,false);  //just reload table
	});
	
	$('#kode_fak').change(function(){ //button filter event click
        table.ajax.reload(null,false);  //just reload table
	});
	
	$('#kode_prodi').change(function(){ //button filter event click
        table.ajax.reload(null,false);  //just reload table
	});
} );

function sulap(elemen)
{
	var jenis = document.getElementById(elemen).value
	let nodeList = document.getElementsByClassName(elemen);
	if(jenis==1)
	{
		for (let i = 0; i < nodeList.length; i++) {
			nodeList[i].style.display='block';
		}
	}else{
		for (let i = 0; i < nodeList.length; i++) {
			nodeList[i].style.display='none';
		}
	}
}

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

function load_pengampu(id_kelas_kuliah)
{
    let url = "<?=base_url('utama/ref_pengampu/')?>"+id_kelas_kuliah;
    
    fetch(url)
        .then((response) => response.text())
        .then((text) => {
            document.getElementById('pengampu_'+id_kelas_kuliah).innerHTML = text;
        });
}
</script>
