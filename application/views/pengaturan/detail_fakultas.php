<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		    
		    <div class="col-md-6 mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
					<div class="card-title m-1">
						
					</div>
<div class="row mt-2">
<?php
    foreach($fakultas as $key=>$value)
	{
		if($key=='nama_fak'){
			echo'
			<div class="col-md-4 mt-1"><strong>'.str_replace('_',' ',$key).'</strong></div>
			<div class="col-md-8 mt-1"><input type="text" class="form-control" id="'.$key.'" value="'.$value.'" onchange="update_fakultas(`'.$key.'`)" placeholder="'.$key.'"></div>';
		}else if($key=='nama_fak_en'){
			echo'
			<div class="col-md-4 mt-1"><strong>'.str_replace('_',' ',$key).'</strong></div>
			<div class="col-md-8 mt-1"><input type="text" class="form-control" id="'.$key.'" value="'.$value.'" onchange="update_fakultas(`'.$key.'`)" placeholder="'.$key.'"></div>';
		}else if($key=='dekan'){
			echo'
			<div class="col-md-4 mt-1"><strong>'.str_replace('_',' ',$key).'</strong></div>
			<div class="col-md-8 mt-1"><input type="text" class="form-control" id="'.$key.'" value="'.$value.'" onchange="update_fakultas(`'.$key.'`)" placeholder="'.$key.'"></div>';
		}else {
		    echo'
			<div class="col-md-4 mt-1"><strong>'.str_replace('_',' ',$key).'</strong></div>
			<div class="col-md-8 mt-1">'.$value.'</div>';
		}
	}
?>
</div>
					</div>
				</div>
			</div>
		
			<div class="col-md-6 mb-4">
				<div class="card">
					<div class="card-body d-flex flex-column">
					<div class="card-title m-1">
						Program Studi
					</div>
<div class="table-responsive">
<table id="datatabel" class="table table-striped" style="width:100%">
<thead>
    <tr>
        <th>Kode Prodi</th>
        <th>Nama</th>
        <th>Inisial</th>
    </tr>
</thead>
<tbody>
	<?php
		if($prodi)
		{
			foreach($prodi as $key=>$value){
			echo'
				<tr>
					<td>'.$value->kode_prodi.'</td>
					<td><a href="'.base_url('pengaturan/detail_prodi/'.$value->kode_prodi).'">'.$value->nama_prodi.'</a></td>
					<td>'.$value->inisial_prodi.'</td>
				</tr>
			';
			}
		}else{
			echo'<tr><td colspan="5">belum ada data</td></tr>';
		}
	?>
</tbody>
</table>
</div>
					</div>
				</div>
			</div>
				
			
		</div>
	</div>
</div>
<script type="text/javascript">
function update_fakultas(komponen)
{
	var dataset = new FormData();
	var isi = document.getElementById(komponen).value;
	dataset.append('kode_fak', '<?=$fakultas->kode_fak?>');
	dataset.append('isi', isi);
	dataset.append('komponen', komponen);
	
	fetch('<?= base_url('pengaturan/update_fakultas/') ?>', {
		method: 'post',
		 body: dataset
	}).then( response => {
		return response.text()
	}).then( text => {
		if(text==1){
		    Toastify({ text: "Berhasil",	style: { background: "green",	} }).showToast();
		}else{
			Toastify({ text: "Gagal",	style: { background: "red",	} }).showToast();
		}
		//setTimeout(location.reload(), 1000);
	}).catch( err => {
		console.warn(err)
	})
}
</script>