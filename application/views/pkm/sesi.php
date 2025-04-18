<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		
			<div class="col mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
					<div class="card-title m-1">
						<a href="<?=base_url('pkm/buat_sesi')?>" onclick="confirm('Yakin akan membuat sesi Baru?')" class="btn btn-info">Buat Sesi</a>
					</div>
<div class="table-responsive">
<table id="datatabel" class="table table-striped" style="width:100%">
<thead>
    <tr>
        <th>id sesi</th>
        <th>Tema/ Judul</th>
        <th>Template</th>
        <th>Juknis</th>
        <th>Tanggal</th>
        <th>Aktif</th>
    </tr>
</thead>
<tbody>
	<?php
		if($sesi)
		{
			foreach($sesi as $key=>$value){
			    $template = ($value->template_sesi)?'<a href="'.$value->template_sesi.'" target="_blank">Unduh</a>':'na';
			    $petunjuk = ($value->petunjuk_sesi)?'<a href="'.$value->petunjuk_sesi.'" target="_blank">Unduh</a>':'na';
			    $aktif = ($value->aktif==1)?'Ya':'Tidak';
			echo'
				<tr>
					<td><a href="'.base_url('pkm/detail_sesi/'.$value->id_sesi).'">#'.$value->id_sesi.'</a></td>
					<td>'.$value->judul_sesi.'</td>
					<td>'.$template.'</td>
					<td>'.$petunjuk.'</td>
					<td>'.$value->tgl_mulai.' s/d '.$value->tgl_selesai.'</td>
					<td>'.$aktif.'</td>
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