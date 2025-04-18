<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		
			<div class="col-12 mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
<div class="table-responsive">
<table class="table">
	<thead>
		<th>Semester</th>
		<th>Kode MK</th>
		<th>Nama Mata Kuliah</th>
		<th>SKS</th>
	</thead>
	<tbody>
		<?php
			if($mk)
			{
				foreach($mk as $key=>$value)
				{
					$lempar = str_replace('=','',base64_encode($value->id_matkul));
					echo'
					<tr>
						<td>'.$value->smt.'</td>
						<td>'.strtoupper($value->kode_mk).'</td>
						<td><a href="'.base_url('beranda/rps/'.$lempar).'" class="text-decoration-none">'.strtoupper($value->nm_mk).'</a></td>
						<td>'.$value->sks_mk.'</td>
					</tr>
					';
				}
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