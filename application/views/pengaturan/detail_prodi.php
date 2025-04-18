<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		    
		    <div class="col-md-6 mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
					<div class="card-title m-1">
						Program Studi
					</div>
<div class="row mt-2">
<?php
	foreach($prodi as $key=>$value)
	{
		if($key=='nama_kaprodi'){
			echo'
			<div class="col-md-4 mt-1"><strong>'.str_replace('_',' ',$key).'</strong></div>
			<div class="col-md-8 mt-1"><input type="text" class="form-control" id="'.$key.'" value="'.$value.'" onchange="update_prodi(`'.$key.'`)" placeholder="'.$key.'"></div>';
		}else if($key=='nidn_kaprodi'){
			echo'
			<div class="col-md-4 mt-1"><strong>'.str_replace('_',' ',$key).'</strong></div>
			<div class="col-md-8 mt-1"><input type="text" class="form-control" id="'.$key.'" value="'.$value.'" onchange="update_prodi(`'.$key.'`)" placeholder="'.$key.'"></div>';
		}else{
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
		
			
		</div>
	</div>
</div>
<script type="text/javascript">
function update_prodi(komponen)
{
	var dataset = new FormData();
	var isi = document.getElementById(komponen).value;
	dataset.append('kode_prodi', '<?=$prodi->kode_prodi?>');
	dataset.append('isi', isi);
	dataset.append('komponen', komponen);
	
	fetch('<?= base_url('pengaturan/update_prodi/') ?>', {
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