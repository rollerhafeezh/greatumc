<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">

			<div class="colmb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
<div class="row">
	<div class="col-md-4 mt-1">
		<label for="id_smt" class="form-label">Semester</label>
		<select id="id_smt" name="id_smt" class="form-select">
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
</div>
<div class="table-responsive mt-3">
<table id="datatabel" class="table table-striped" style="width:100%">
<thead>
    <tr>
        <th>Semester</th>
        <th>Nama Kelas</th>
        <th>Program Studi</th>
        <th>Jadwal</th>
        <th>SKS</th>
        <th>Detail</th>
    </tr>
</thead>
<tbody></tbody>
<tfoot>
    <tr>
        <th>Semester</th>
        <th>Nama Kelas</th>
        <th>Program Studi</th>
        <th>Jadwal</th>
        <th>SKS</th>
        <th>Detail</th>
    </tr>
</tfoot>
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
	
	var table=$('#datatabel').DataTable( {
		search: {
            return: true,
        },
		ajax: {
			url 	: "<?=base_url('dosen/json_arsip_kelas_kuliah')?>",
			type 	: 'GET',
			data : function(d){
				d.id_smt =$("#id_smt").val();
				d.kode_fak =$("#kode_fak").val();
				d.kode_prodi = $("#kode_prodi").val();
				d.id_dosen='<?=$dosen->id_dosen?>';
				
			}
		},
		//order: [[0, 'asc'],[1,'asc']],
		columnDefs: [
			{ targets: [0,1,2,3,4,5], orderable: false },
			{ targets: [0,2,3,4], searchable: false },
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
		"footerCallback": function( tfoot, data, start, end, display ) {
            var api = this.api();
            var intVal = function ( i ) {
				return typeof i === 'string' ?
					i.replace(/[\$,]/g, '')*1 :
					typeof i === 'number' ?
						i : 0;
			};
            $( api.column( 4 ).footer() ).html(
                api.column( 4 ).data().reduce( function ( a, b ) {
                   return intVal(a) + intVal(b);
                }, 0 )
            );
          }
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
