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
        <th>Kode Fakultas</th>
        <th>Nama</th>
        <th>Inisial</th>
    </tr>
</thead>
<tbody>
	<?php
		if($fakultas)
		{
			foreach($fakultas as $key=>$value){
			echo'
				<tr>
					<td>'.$value->kode_fak.'</td>
					<td><a href="'.base_url('pengaturan/detail_fakultas/'.$value->kode_fak).'">'.$value->nama_fak.'</a></td>
					<td>'.$value->inisial_fak.'</td>
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