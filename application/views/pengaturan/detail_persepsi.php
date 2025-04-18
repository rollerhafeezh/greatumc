<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		
			<div class="col-md-12 mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
                        <div class="row">
                            <div class="col-md-4">Nama Instrumen</div>
                            <div class="col-md-8"><?=$persepsi->nama_instrumen?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">Tahun Implementasi</div>
                            <div class="col-md-8"><?=$persepsi->tahun_instrumen?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">Aktif</div>
                            <div class="col-md-8"><?=$persepsi->aktif?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">Waktu</div>
                            <div class="col-md-8"><?=$persepsi->created_at?> <?=$persepsi->updated_at?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
<div class="table-responsive"> 
<table id="datatabel" class="table table-striped" style="width:100%">
<thead>
    <tr>
        <th>Variabel</th>
        <th>Pertanyaan</th>
        <th>Skala Min</th>
        <th>Skala Maks</th>
        <th>Aktif</th>
        <th>#</th>
    </tr>
</thead>
<tbody>
	<?php
	    $pertanyaan=$this->Persepsi_model->get_pertanyaan($persepsi->id_instrumen)->result();
		if($pertanyaan)
		{
			foreach($pertanyaan as $key=>$value){
			echo'
				<tr>
					<td><input onblur="update_detail_persepsi(`variabel`,`'.$value->id_pertanyaan.'`)" class="form-control" type="text" id="variabel-'.$value->id_pertanyaan.'" value="'.$value->variabel.'"></td>
					<td><textarea onblur="update_detail_persepsi(`text_pertanyaan`,`'.$value->id_pertanyaan.'`)" class="form-control" id="text_pertanyaan-'.$value->id_pertanyaan.'" rows="5">'.$value->text_pertanyaan.'</textarea></td>
					<td><input onblur="update_detail_persepsi(`skala_min`,`'.$value->id_pertanyaan.'`)" class="form-control" type="text" id="skala_min-'.$value->id_pertanyaan.'" value="'.$value->skala_min.'"></td>
					<td><input onblur="update_detail_persepsi(`skala_maks`,`'.$value->id_pertanyaan.'`)" class="form-control" type="text" id="skala_maks-'.$value->id_pertanyaan.'" value="'.$value->skala_maks.'"></td>
					<td><input onblur="update_detail_persepsi(`aktif`,`'.$value->id_pertanyaan.'`)" class="form-control" type="number" min="0" max="1" id="aktif-'.$value->id_pertanyaan.'" value="'.$value->aktif.'"></td>
					<td><button class="btn btn-icon btn-outline-success"><i class="psi-save"></i></button></td>
				</tr>
			';
			}
		}else{
			echo'<tr><td colspan="5">belum ada data</td></tr>';
		}
	?>
	    <tr><td colspan="5"><strong>Tambah Pertanyaan Baru</strong></td></tr>
	    <tr>
	       <td><input type="text" class="form-control" id="variabel_baru" placeholder="Variabel"></td>
	       <td><textarea type="text" class="form-control" id="text_pertanyaan_baru" placeholder="Pertanyaan"></textarea></td>
	       <td><input type="text" class="form-control" id="skala_min_baru" placeholder="Skala Minimal"></td>
	       <td><input type="text" class="form-control" id="skala_maks_baru" placeholder="Skala Maksimal"></td>
	       <td>Aktif</td>
	       <td><button class="btn btn-outline-success" onclick="tambah_pertanyaan('<?=$persepsi->id_instrumen?>')"><i class="psi-save"></i> Tambah</button></td>
        </tr>
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
function update_detail_persepsi(kolom,id_pertanyaan)
{
	var data = new FormData()
	const isi = document.getElementById(kolom+"-"+id_pertanyaan).value;
	
	data.append('isi', isi);
	data.append('kolom', kolom);
	data.append('id_pertanyaan', id_pertanyaan);
	
	fetch('<?=base_url('persepsi/update_detail_persepsi/')?>', {
		method: 'POST',
		body: data
	})
	.then((response) => response.text())
	.then((text) => {
		if(text==1){
			Toastify({ text: "Tersimpan",	style: { background: "<?=$_ENV['CLR_SUC']?>",	} }).showToast();
		}else{
			Toastify({ text: "Gatot!",	style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
		}
	})
	.catch(error => {
		console.log(error)
	})  
}

function tambah_pertanyaan(id_instrumen)
{
	var data = new FormData()
	const variabel = document.getElementById('variabel_baru').value;
	const text_pertanyaan = document.getElementById('text_pertanyaan_baru').value;
	const skala_min = document.getElementById('skala_min_baru').value;
	const skala_maks = document.getElementById('skala_maks_baru').value;
	
	data.append('variabel', variabel);
	data.append('text_pertanyaan', text_pertanyaan);
	data.append('skala_min', skala_min);
	data.append('skala_maks', skala_maks);
	data.append('id_instrumen', id_instrumen);
	
	fetch('<?=base_url('persepsi/tambah_pertanyaan/')?>', {
		method: 'POST',
		body: data
	})
	.then((response) => response.text())
	.then((text) => {
		if(text==1){
			Toastify({ text: "Tersimpan",	style: { background: "<?=$_ENV['CLR_SUC']?>",	} }).showToast();
		}else{
			Toastify({ text: "Gatot!",	style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
		}
		location.reload();
	})
	.catch(error => {
		console.log(error)
	})  
}
</script>