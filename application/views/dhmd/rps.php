<?php
$lempar = str_replace('=','',base64_encode($matkul->id_matkul));

$rps = $this->Main_model->get_rps($matkul->id_matkul)->result();
?>
<div class="content__boxed">
	<div class="content__wrap">
<div class="row g-sm-1 mb-3">
		<?php
		$co=1;
		foreach($rps as $key=>$value){
			$warna = ($value->status==1)?'info':'light';
			$status = ($value->status==1)?'Aktif':'Tidak Aktif';
		?>
	<div class="col-sm-6 col-xl-3">
		<!--Tile-->
		<div class="card bg-<?=$warna?> text-white mb-1 mb-xl-1">
			<div class="p-3 text-center">
				<span class="display-5">v<?=$co?></span>
				<h3><?=$status?></h3>
				<h5><a class="text-white text-decoration-none btn btn-danger" href="<?=base_url('dhmd/rps_detail/'.$value->id_rps)?>">Detail</a></h5>
			</div>
		</div>
		<!--END : Tile-->
	</div>
		<?php 
		$co++;
		} ?>
</div>

<div class="row">
	<div class="col-12 mb-4">
		<div class="card h-100">
			<div class="card-body d-flex flex-column">
				<a href="<?=base_url('dhmd/buat_rps/'.$matkul->id_matkul)?>" onclick="return confirm('Yakin?')" class="btn btn-info"> Buat Versi Baru<a>
			</div>
		</div>
	</div>
</div>
	
		
	</div>
</div>