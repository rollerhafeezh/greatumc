<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		
			<div class="col mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
					<div class="card-title m-1">
						<a href="<?=base_url('pkm/buat_bidang')?>" onclick="confirm('Yakin akan membuat Bidang Baru?')" class="btn btn-info">Buat Bidang</a>
					</div>
<div class="table-responsive">
<table id="datatabel" class="table table-striped" style="width:100%">
<thead>
    <tr>
        <th>id bidang</th>
        <th>Nama Bidang</th>
        <th>Aktif</th>
    </tr>
</thead>
<tbody>
	<?php
		if($bidang)
		{
			foreach($bidang as $key=>$value){
			   $aktif = ($value->aktif==1)?'Ya':'Tidak';
			echo'
				<tr>
					<td><a href="'.base_url('pkm/detail_bidang/'.$value->id_jenis_pkm).'">#'.$value->id_jenis_pkm.'</a></td>
					<td>'.$value->jenis_pkm.'</td>
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