<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		    <div class="col-12 mb-3">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
					<form method="post" action="<?=base_url('berita/simpan/')?>">
					    <input type="text" class="form-control form-control-lg my-3" name="judul_berita" autofocus placeholder="Judul Berita">
					    <textarea id="isi_berita" name="isi_berita" class="form-control mt-3" rows="20" placeholder="Isi Berita"></textarea>
					    <div class="mt-3">Waktu Selesai Berita :</div>
					    <input type="date" class="form-control my-3" name="expired_at" value="<?= date('Y-m-d', strtotime(date("Y-m-d").'+ 14 Days')); ?>">
					    <div class="mt-3">Penulis Berita :</div>
					    <input type="text" class="form-control my-3" value="<?=$_SESSION['nama_pengguna'].' ('.$_SESSION['level_name'].')'?>" name="pembuat_berita">
					    <div class="mt-3 d-grid gap-2">
                            <input type="submit" value="SIMPAN" class="btn btn-info">
					    </div>
				    </form>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>