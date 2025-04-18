<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		
			<div class="col mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
					<div class="row">
                        <div class="col-md-4 mb-2">Nama Bidang</div>
    			        <div class="col-md-8 mb-2">
    			            <input type="text" class="form-control" id="jenis_pkm" value="<?=$bidang->jenis_pkm?>" onchange="update_bidang('jenis_pkm')" placeholder="Nama Bidang">
    			        </div>
    			        <div class="col-md-4 mb-2">Aktif (1: Ya, 0: Tidak)</div>
    			        <div class="col-md-8 mb-2">
    			            <input type="number" min="0" max="1" class="form-control" id="aktif" value="<?=$bidang->aktif?>" onchange="update_bidang('aktif')">
    			        </div>
    			    </div>
    			    <button class="btn btn-primary mt-3">Update</button>
    			    </div>
				</div>
			</div>
		
		</div>
	</div>
</div>
<script type="text/javascript">
function update_bidang(komponen)
{
	var dataset = new FormData();
	var isi = document.getElementById(komponen).value;
	dataset.append('id_jenis_pkm', '<?=$bidang->id_jenis_pkm?>');
	dataset.append('isi', isi);
	dataset.append('komponen', komponen);
	
	fetch('<?= base_url('pkm/update_bidang/') ?>', {
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