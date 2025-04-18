<div class="card mb-3">
	<div class="card-body">

		<div class="text-center position-relative">
			<div class="pt-2 pb-3">
				<img class="img-lg rounded-circle" src="<?=$_SESSION['picture']?>" alt="Profile Picture" loading="lazy">
			</div>
			<div class="h5"><?=$_SESSION['nama_pengguna']?></div>
			<p class="text-muted"><?=$_SESSION['id_user']?></p>
		</div>
		<div class="d-flex justify-content-center gap-2">
			<a class="btn btn-light" href="<?=base_url('dhmd/hadir/'.$bap->id_kelas_kuliah.'/'.$bap->id_bap_kuliah)?>" >Absen Dulu</a>
		</div>
		
	</div>
</div>