<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		
			<div class="col mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
					<div class="card-title m-1">
						
					</div>
<div class="table-responsive">
<table id="datatabel" class="table table-striped" style="width:100%">
<thead>
    <tr>
        <th>Tahun Aktif</th>
        <th>Nama Instrumen</th>
        <th>Status</th>
    </tr>
</thead>
<tbody>
	<?php
	    $persepsi=$this->Persepsi_model->get()->result();
		if($persepsi)
		{
			foreach($persepsi as $key=>$value){
			echo'
				<tr>
					<td>'.$value->tahun_instrumen.'</td>
					<td><a href="'.base_url('pengaturan/detail_persepsi/'.$value->id_instrumen).'">'.$value->nama_instrumen.'</a></td>
					<td>'.$value->aktif.'</td>
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