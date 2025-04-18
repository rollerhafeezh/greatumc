<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">

			<div class="col mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
<div class="row">
	<div class="col-md-12 mb-2">
		<label for="id_smt" class="form-label">Semester</label>
		<select id="id_smt" name="id_smt" class="form-select">
			<option value="0">Semua</option>
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
</div>

<table id="datatabel" class="table table-striped" style="width:100%">
<thead>
    <tr>
        <th>Semester</th>
        <th>NIM</th>
        <th>Nama Mahasiswa</th>
		<th>Homebase</th>
        <th>Validasi</th>
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

<?php $this->load->view('lyt/js_datatable'); ?>
<script type="text/javascript">
$(document).ready(function() {
	var table = $('#datatabel').DataTable( {
		ajax: {
			url 	: "<?=base_url('perwalian/json_krs')?>",
			type 	: 'GET',
			data : function(d){
				d.id_smt=$("#id_smt").val();
			}
		},	
		responsive: true,
		dom: 	"<'row'<'col-sm-12 col-md-4 mb-1'l><'col-sm-12 col-md-4 mb-1'B><'col-sm-12 col-md-4 mb-1'f>>" +
				"<'row'<'col-sm-12 mb-1'tr>>" +
				"<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
		buttons: [
			{
				extend:'pageLength',
				text:'Tampilkan Data',
				className:'btn btn-light',
			},
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
	
	$('#id_smt').change(function(){ //button filter event click
        table.ajax.reload(null,false);  //just reload table
	});
} );
</script>
