<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		
			<div class="col-12 mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
<div class="table-responsive">
<table class="table">
	<thead>
		<th>Nama Kurikulum</th>
		<th>Fakultas</th>
		<th>Prodi</th>
	</thead>
	<tbody>
		<?php
			if($kurikulum)
			{
				foreach($kurikulum as $key=>$value)
				{
					$lempar = str_replace('=','',base64_encode($value->id_kur));
					echo'
					<tr>
						<td><a href="'.base_url('beranda/kurikulum_detail/'.$lempar).'" class="text-decoration-none">'.strtoupper($value->nm_kurikulum_sp).'</a></td>
						<td>'.strtoupper($value->nama_fak).'</td>
						<td>'.strtoupper($value->nama_prodi).'</td>
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