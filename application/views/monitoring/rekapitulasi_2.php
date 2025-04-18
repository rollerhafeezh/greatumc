<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		
			<div class="col mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
<div class="row">
	<div class="col-md-4 mt-2">
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
	<div class="col-md-4 mt-2">
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
	<div class="col-md-4 mt-2">
		<label for="kode_prodi" class="form-label">Program Studi</label>
		<select id="kode_prodi" name="kode_prodi" class="form-select">
			<option value="<?=$_SESSION['kode_prodi']?>">Pilih Program Studi</option>
		</select>
	</div>
	<div class="col-md-5 mt-2">
		<label for="jenis_pertemuan" class="form-label">Jenis Pertemuan</label>
		<select id="jenis_pertemuan" name="jenis_pertemuan" class="form-select">
			<option value='1'>Kuliah</option>
			<option value='2'>UAS</option>
			<option value='3'>UTS</option>
		</select>
	</div>
	<div class="col-md-5 mt-2">
		<label for="whenat" class="form-label">Kapan</label>
		<input type="text" placeholder="Kapan" name="whenat" id="whenat" class="form-control">
		<input type="hidden" id="awal" value="<?=date('Y-m-d')?>">
		<input type="hidden" id="akhir" value="<?=date('Y-m-d')?>">
	</div>
	<div class="col-md-2 mt-2">
		<label for="selesai" class="form-label">Selesai</label>
		<select id="selesai" name="jenis_pertemuan" class="form-select">
			<option value='1'>Ya</option>
			<option value='2'>Tidak</option>
		</select>
	</div>
	<div class="col-12 mt-2">
		<div class="mb-2 d-grid gap-2">
			<button class="btn btn-sm btn-success" id="atur_ulang">Rekap</button>
		</div>
	</div>
</div>

<div class="table-responsive mt-4">
<table id="datatabel" class="table table-striped" style="width:100%">
<thead>
    <tr>
        <th>No</th>
        <th>Nama Dosen</th>
        <th>Fakultas-Prodi</th>
        <th>Kelas Kuliah</th>
        <th>Tanggal Pertemuan</th>
        <th>Mulai</th>
        <th>Selesai</th>
        <th>Durasi<br>(menit)</th>
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
			url 	: "<?=base_url('monitoring/json_rekap_2')?>",
			type 	: 'GET',
			data : function(d){
				d.selesai =$("#selesai").val();
				d.id_smt =$("#id_smt").val();
				d.kode_fak =$("#kode_fak").val();
				d.kode_prodi =$("#kode_prodi").val();
				d.jenis_pertemuan =$("#jenis_pertemuan").val();
				d.awal =$("#awal").val();
				d.akhir =$("#akhir").val();
			}
		},
	    columnDefs: [
		/*	{ targets: [1,2,3,4], orderable: false },
			{ targets: [3], searchable: false },*/
		],
		responsive: true,
		dom: 	"<'row'<'col-sm-12 col-md-4 mb-1'i><'col-sm-12 col-md-4 mb-1'B><'col-sm-12 col-md-4 mb-1'f>>" +
				"<'row'<'col-sm-12 mb-1'tr>>" +
				"<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
		/*lengthMenu: [
			[ 10, 25, 50, -1 ],
			[ '10 rows', '25 rows', '50 rows', 'Show all' ]
		],*/
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
		paging: false,
		ordering: false,
		searching: false,
	} );
	
	/*$('#whenat').change(function(){ 
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
    });*/
    
    $("#atur_ulang").on("click", function(event) {
        table.ajax.reload(null,false);
    });
    
    new Litepicker({
    element: document.getElementById( "whenat" ),
    singleMode: false,
    startDate: '<?=date('Y-m-d')?>',
    endDate: '<?=date('Y-m-d')?>',
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
            //table.ajax.reload(null,false);
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