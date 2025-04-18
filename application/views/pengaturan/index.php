<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		
			<div class="col mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
					
<div class="table-responsive">
<table id="datatabel" class="table table-striped" style="width:100%">
<thead>
    <tr>
        <th>Nama Konfigurasi</th>
        <th>Keterangan</th>
        <th>Value</th>
        <th>#</th>
    </tr>
</thead>
<tbody>
	<?php
		$konfig = $this->Main_model->get_konfigurasi()->result();
		foreach($konfig as $key=>$value){
		echo'
			<tr>
				<td>'.$value->nama_konfigurasi.'</td>
				<td>'.$value->ket_konfigurasi.'</td>
				<td><input type="text" id="'.$value->nama_konfigurasi.'" value="'.$value->value_konfigurasi.'"></td>
				<td><a class="text-decoration-none" href="#" onclick="return simpan(`'.$value->nama_konfigurasi.'`)"><i class="psi-save"></i> Simpan</a></td>
			</tr>
		';
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
<script>
function simpan(nama_konfigurasi)
{
	var x = confirm('yakin?')
	if(x){
		var value_konfigurasi = document.getElementById(nama_konfigurasi).value;
		fetch('<?=base_url('utama/simpan_konfigurasi/')?>', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				},
				body: JSON.stringify({
					nama_konfigurasi	: nama_konfigurasi,
					value_konfigurasi	: value_konfigurasi,
				})
		})
		.then((response) => response.text())
		.then((text) => {
			if(text==0){
				Toastify({ text: "Gagal",	style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
			}else{
				Toastify({ text: "Tersimpan",	style: { background: "<?=$_ENV['CLR_SUC']?>",	} }).showToast();
			}
		})
		.catch(error => {
			console.log(error)
		}) 
		return true;
	}else{
		return false;
	}
}
</script>