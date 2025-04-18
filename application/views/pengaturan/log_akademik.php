<?php 
//$konfig     = $this->Main_model->get_log_akademik()->result();
$ngapain    = $this->Main_model->ngapain()->result();
?>
<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		
			<div class="col mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
<div class="row">
	<div class="col-md-3 mt-1">
		<label for="whois" class="form-label">Siapa</label>
		<input type="text" placeholder="Siapa" id="whois" name="whois" class="form-control">
	</div>
	<div class="col-md-3 mt-1">
		<label for="whythis" class="form-label">Ngapain</label>
		<select class="form-select" id="whythis" name="whythis">
            <option value="0">semua</option>
            <?php
                if($ngapain)
                {
                    foreach($ngapain as $key=>$value)
                    {
                        echo'<option value="'.$value->whythis.'">'.$value->whythis.'</option>';
                    }
                }
            ?>
           </select>
	</div>
	<div class="col-md-3 mt-1">
		<label for="wherefrom" class="form-label">IP Address</label>
		<input type="text" placeholder="Dari Mana" id="wherefrom" name="wherefrom" class="form-control">
	</div>
	<div class="col-md-3 mt-1">
		<label for="whenat" class="form-label">Kapan</label>
		<input type="text" placeholder="Kapan" name="whenat" id="whenat" class="form-control">
		<input type="hidden" id="awal" value="<?=date('Y-m-d')?>">
		<input type="hidden" id="akhir" value="<?=date('Y-m-d')?>">
	</div>
</div>

<div class="table-responsive mt-3">
<table id="datatabel" class="table table-striped" style="width:100%">
<thead>
    <tr>
        <th>Kapan</th>
        <th>Siapa</th>
        <th>Ngapain</th>
        <th>Apa Aja</th>
        <th>Dari Mana</th>
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
<script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	
	var table=$('#datatabel').DataTable( {
		search: {
            return: true,
        },
		ajax: {
			url 	: "<?=base_url('pengaturan/json_log')?>",
			type 	: 'GET',
			data : function(d){
				d.whythis =$("#whythis").val();
				d.whois =$("#whois").val();
				d.wherefrom =$("#wherefrom").val();
				d.awal =$("#awal").val();
				d.akhir =$("#akhir").val();
			}
		},
		order: [[0, 'desc']],
		columnDefs: [
			{ targets: [1,2,3,4], orderable: false },
			{ targets: [3], searchable: false },
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
	
	$('#whenat').change(function(){ 
	    console.log($('#whenat').val())
	    //table.ajax.reload(null,false);
	});
	
	$('#whythis').change(function(){ 
	    table.ajax.reload(null,false);
	});
	
	$("#whois").on("keydown", function(event) {
        if(event.which == 13)
        table.ajax.reload(null,false);
    });
    
    $("#wherefrom").on("keydown", function(event) {
        if(event.which == 13)
        table.ajax.reload(null,false);
    });
    
    new Litepicker({
    element: document.getElementById( "whenat" ),
    singleMode: false,
    startDate: '<?=date("Y-m-d")?>',
    endDate: '<?=date("Y-m-d")?>',
    numberOfMonths: 2,
    numberOfColumns: 2,
    tooltipText: {
        one: "day",
        other: "days"
    },
    tooltipNumber: (totalDays) => {
        return totalDays - 1;
    },
    setup: (picker) => {
      picker.on('selected', (date1, date2) => {
            var awal = dateFormat(date1)
            var akhir = dateFormat(date2)
            $('#awal').val(awal)
            $('#akhir').val(akhir)
            table.ajax.reload(null,false);
      });
    },
    })

function dateFormat(date) {
    const day = date.getDate();
    const month = date.getMonth() + 1;
    const year = date.getFullYear();

    return `${year}-${month}-${day}`;
}
	
} );

</script>