<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">

			<div class="colmb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
<div class="row">
	<div class="col-md-3 mt-1">
		<label for="mulai_smt" class="form-label">Tahun Masuk</label>
		<select id="mulai_smt" name="mulai_smt" class="form-select">
			<option value="0">Semua</option>
			<?php 
				$ref_smt 	= $this->Main_model->ref_smt();
				foreach($ref_smt as $ket=>$value)
				{
					echo'<option value="'.$value->id_semester.'" >'.$value->nama_semester.'</option>';
				}
			?>
		</select>
	</div>
	<div class="col-md-3 mt-1">
		<label for="id_smt" class="form-label">Semester</label>
		<select id="id_smt" name="id_smt" class="form-select">
			<option value="0">Pilih Semester</option>
			<?php 
				foreach($ref_smt as $ket=>$value)
				{
					$selected=($value->id_semester==$_SESSION['active_smt'])?'selected':'';
					echo'<option value="'.$value->id_semester.'" '.$selected.'>'.$value->nama_semester.'</option>';
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
		<label for="validasi" class="form-label">Dosen Wali</label>
		<select id="validasi" name="validasi" class="form-select">
			<option value="0">Semua</option>
			<option value="1">Sudah</option>
			<option value="2">Belum</option>
		</select>
	</div>
	<div class="col-md-3 mt-1">
		<label for="validasi_aka" class="form-label">Akademik</label>
		<select id="validasi_aka" name="validasi_aka" class="form-select">
			<option value="0">Semua</option>
			<option value="1">Sudah</option>
			<option value="2">Belum</option>
		</select>
	</div>
	<div class="col-md-3 mt-1">
		<label for="validasi_keu" class="form-label">Keuangan</label>
		<select id="validasi_keu" name="validasi_keu" class="form-select">
			<option value="0">Semua</option>
			<option value="1">Sudah</option>
			<option value="2">Belum</option>
		</select>
	</div>
	<div class="col-md-3 mt-1">
		<label for="validasi_prodi" class="form-label">Prodi</label>
		<select id="validasi_prodi" name="validasi_prodi" class="form-select">
			<option value="0">Semua</option>
			<option value="1">Sudah</option>
			<option value="2">Belum</option>
		</select>
	</div>
	
</div>

<div class="table-responsive mt-2">
<table id="datatabel" class="table table-striped" style="width:100%">
<thead>
    <tr>
        <th rowspan="2">Semester</th>
        <th rowspan="2">NIM</th>
        <th rowspan="2">Nama Mahasiswa</th>
		<th rowspan="2">Dosen Wali</th>
		<th colspan="4">Validasi</th>
		<th rowspan="2">SKS</th>
	</tr>	
	<tr>	
		<th>Dosen Wali</th>
        <th>Akademik</th>
        <th>Keuangan</th>
        <th>Prodi</th>
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
			url 	: "<?=base_url('mahasiswa/json_validasi')?>",
			type 	: 'GET',
			data : function(d){
				d.mulai_smt =$("#mulai_smt").val();
				d.id_smt =$("#id_smt").val();
				d.kode_fak =$("#kode_fak").val();
				d.kode_prodi = $("#kode_prodi").val();
				d.validasi = $("#validasi").val();
				d.validasi_aka = $("#validasi_aka").val();
				d.validasi_keu = $("#validasi_keu").val();
				d.validasi_prodi = $("#validasi_prodi").val();
			}
		},	
		order: [[1, 'asc']],
		columnDefs: [
			{ targets: [0], orderable: false },
			{ targets: [0,4,5,6,7,8], searchable: false },
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
	
	
	$('#mulai_smt').change(function(){ //button filter event click
        table.ajax.reload(null,false);  //just reload table
	});
	
	$('#id_smt').change(function(){ //button filter event click
        table.ajax.reload(null,false);  //just reload table
	});
	
	$('#kode_fak').change(function(){ //button filter event click
        table.ajax.reload(null,false);  //just reload table
	});
	
	$('#kode_prodi').change(function(){ //button filter event click
        table.ajax.reload(null,false);  //just reload table
	});
	
	$('#validasi').change(function(){ //button filter event click
        table.ajax.reload(null,false);  //just reload table
	});
	
	$('#validasi_aka').change(function(){ //button filter event click
        table.ajax.reload(null,false);  //just reload table
	});
	
	$('#validasi_keu').change(function(){ //button filter event click
        table.ajax.reload(null,false);  //just reload table
	});
	
	$('#validasi_prodi').change(function(){ //button filter event click
        table.ajax.reload(null,false);  //just reload table
	});
} );

function validasi(id_smt,id_mahasiswa_pt,id_mhs=null)
{
	fetch('<?=base_url('mahasiswa/validasi_krs/')?>', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
			},
			body: JSON.stringify({
				id_mahasiswa_pt	: id_mahasiswa_pt,
				id_smt		: id_smt,
				id_mhs : id_mhs
			})
	})
	.then((response) => response.text())
	.then((text) => {
		if(text==0){
			Toastify({ text: "Gagal",	style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
		}else{
			Toastify({ text: "Tersimpan",	style: { background: "<?=$_ENV['CLR_SUC']?>",	} }).showToast();
			document.getElementById(id_mahasiswa_pt).innerHTML = text;
			document.getElementById(id_mahasiswa_pt).classList.remove('bg-danger');
			document.getElementById(id_mahasiswa_pt).classList.add('bg-info');
		}
	})
	.catch(error => {
		console.log(error)
	}) 
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
</script>
