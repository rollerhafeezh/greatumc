<div class="content__boxed">
	<div class="content__wrap">
		<div class="row justify-content-center">
		
			<div class="col-md-6 mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
						<div class="card-title">
							<h4>Pernyataan Persetujuan Ajuan KRS</h4>
						</div>
						<h5>Dengan menekan tombol ajukan saya : </h5>
						<div class="row">
							<div class="col-md-4 mt-1"><strong>ID Pengguna</strong></div>
							<div class="col-md-8 mt-1"><?=$_SESSION['username']?></div>
							<div class="col-md-4 mt-1"><strong>Nama Pengguna</strong></div>
							<div class="col-md-8 mt-1"><?=$_SESSION['nama_pengguna']?></div>
							<div class="col-md-4 mt-1"><strong>Hak Akses</strong></div>
							<div class="col-md-8 mt-1"><?=$_SESSION['level_name']?></div>
						</div>
						<h5 class="mt-2">Menyetujui untuk mengajukan KRS dengan detail : </h5>
						<div class="row">
							<div class="col-md-4 mt-1"><strong>NIM</strong></div>
							<div class="col-md-8 mt-1"><?=$mahasiswa_pt->id_mahasiswa_pt?></div>
							<div class="col-md-4 mt-1"><strong>Nama Mahasiswa</strong></div>
							<div class="col-md-8 mt-1"><?=$mahasiswa_pt->nm_pd?></div>
							<div class="col-md-4 mt-1"><strong>Jumlah SKS</strong></div>
							<div class="col-md-8 mt-1"><?= ($_SESSION['total_sks'] + $_SESSION['total_sks_mbkm']).' SKS ('.$_SESSION['total_sks'].' SKS Reguler + '.$_SESSION['total_sks_mbkm'].' SKS MBKM)' ?></div>
						</div>
						<em class="m-1">timestamp : <?=date("Y-m-d H:i:s")?></em>
					<div class="mt-4 d-grid gap-2">
						<a href="<?= base_url('krs/ajukan_krs/'.$id_smt.'/'.$mahasiswa_pt->id_mahasiswa_pt) ?>" class="text-decoration-none btn btn-info" ><i class="pli-yes"></i> Ajukan</a>
						<a href="<?= base_url('krs/add/'.$id_smt.'/'.$mahasiswa_pt->id_mahasiswa_pt) ?>" class="text-decoration-none btn btn-danger" ><i class="pli-no"></i> Kembali</a>
					</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>