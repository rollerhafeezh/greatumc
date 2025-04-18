<?php
$template = ($sesi->template_sesi)?'<a href="'.$sesi->template_sesi.'" target="_blank">Unduh</a>':'';
$petunjuk = ($sesi->petunjuk_sesi)?'<a href="'.$sesi->petunjuk_sesi.'" target="_blank">Unduh</a>':'';
?>
<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		
			<div class="col mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
					<div class="row">
                        <div class="col-md-4 mb-2">Judul</div>
    			        <div class="col-md-8 mb-2">
    			            <input type="text" class="form-control" id="judul_sesi" value="<?=$sesi->judul_sesi?>" onchange="update_sesi('judul_sesi')" placeholder="Judul Sesi">
    			        </div>
    			        <div class="col-md-4 mb-2">Template <?=$template?></div>
    			        <div class="col-md-8 mb-2">
    			            <input type="file" class="form-control" id="template_sesi" value="<?=$sesi->template_sesi?>" onchange="unggah_sesi('template_sesi')" placeholder="Template Sesi">
    			        </div>
    			        <div class="col-md-4 mb-2">Petunjuk Teknis <?=$petunjuk?></div>
    			        <div class="col-md-8 mb-2">
    			            <input type="file" class="form-control" id="petunjuk_sesi" value="<?=$sesi->petunjuk_sesi?>" onchange="unggah_sesi('petunjuk_sesi')" placeholder="Pentunjuk Teknis">
    			        </div>
    			        <div class="col-md-4 mb-2">Tanggal Mulai</div>
    			        <div class="col-md-8 mb-2">
    			            <input type="date" class="form-control" id="tgl_mulai" value="<?=$sesi->tgl_mulai?>" onchange="update_sesi('tgl_mulai')">
    			        </div>
    			        <div class="col-md-4 mb-2">Tanggal Selesai</div>
    			        <div class="col-md-8 mb-2">
    			            <input type="date" class="form-control" id="tgl_selesai" value="<?=$sesi->tgl_selesai?>" onchange="update_sesi('tgl_selesai')">
    			        </div>
    			        <div class="col-md-4 mb-2">Aktif (1: Ya, 0: Tidak)</div>
    			        <div class="col-md-8 mb-2">
    			            <input type="number" min="0" max="1" class="form-control" id="aktif" value="<?=$sesi->aktif?>" onchange="update_sesi('aktif')" placeholder="Judul Sesi">
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
function update_sesi(komponen)
{
	var dataset = new FormData();
	var isi = document.getElementById(komponen).value;
	dataset.append('id_sesi', '<?=$sesi->id_sesi?>');
	dataset.append('isi', isi);
	dataset.append('komponen', komponen);
	
	fetch('<?= base_url('pkm/update_sesi/') ?>', {
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
function unggah_sesi(jenis)
{
    document.getElementById('loading').style.display = 'block';
    var isi_dokumen = document.getElementById(jenis).value;
	var dokumen = document.getElementById(jenis).files[0];
	
	if(isi_dokumen=='')
	{
	    Toastify({ text: "Dokumen harus diisi!",	style: { background: "red",	} }).showToast();
		return false;
	}
	
	var dataset = new FormData();
	dataset.append('id_sesi', '<?=$sesi->id_sesi?>');
	dataset.append('dokumen', dokumen);
	dataset.append('jenis', jenis);
	
	fetch('<?= base_url('pkm/unggah_sesi/') ?>', {
		method: 'post',
		 body: dataset
	}).then( response => {
		return response.text()
	}).then( text => {
	    console.log(text)
	    document.getElementById('loading').style.display = 'none';
		if(text==1){
		    Toastify({ text: "Berhasil",	style: { background: "green",	} }).showToast();
		}else{
			Toastify({ text: "Gagal",	style: { background: "red",	} }).showToast();
		}
		setTimeout(location.reload(), 1000);
	}).catch( err => {
		console.warn(err)
	})
}
</script>