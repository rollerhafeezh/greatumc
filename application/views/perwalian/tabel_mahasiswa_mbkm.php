<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">

			<div class="colmb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">

<table id="datatabel" class="table table-striped" style="width:100%">
<thead>
    <tr>
        <th>NIM</th>
        <th>Nama Mahasiswa</th>
        <th>Homebase</th>
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
<?php $this->load->view('lyt/js_datatable'); ?>
<script type="text/javascript">
$(document).ready(function() {
	$('#datatabel_').DataTable( {
		ajax: {
			url 	: "<?=base_url('perwalian/json_krs_mbkm')?>",
			type 	: 'GET',
		},	
		responsive: true,
		dom: 	"<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
				"<'row'<'col-sm-12'tr>>" +
				"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
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
} );
</script>
