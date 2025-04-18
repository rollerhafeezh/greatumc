<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		<div class="col-12 mb-4">
			<div class="card h-100">
				<div class="card-body d-flex flex-column">
					<div class="card-title">
						<h5>Detail Mahasiswa</h5>
					</div>

					<div class="row">
						<div class="col-md-4 mt-1"><strong>NIM</strong></div>
						<div class="col-md-8 mt-1"><?=$mahasiswa_pt->id_mahasiswa_pt?></div>
						<div class="col-md-4 mt-1"><strong>Nama Mahasiswa</strong></div>
						<div class="col-md-8 mt-1"><?=$mahasiswa_pt->nm_pd?></div>
						<div class="col-md-4 mt-1"><strong>Homebase</strong></div>
						<div class="col-md-8 mt-1"><?=$mahasiswa_pt->inisial_fak?> <?=$mahasiswa_pt->nama_prodi?> <?=$mahasiswa_pt->nm_jenj_didik?></div>
						<div class="col-md-4 mt-1"><strong>Dosen Wali</strong></div>
						<div class="col-md-8 mt-1"><?=$mahasiswa_pt->nm_sdm?> </div>
						<div class="col-md-4 mt-1"><strong>Semester diterima/ Tahun Akademik</strong></div>
						<div class="col-md-8 mt-1"><?=$mahasiswa_pt->diterima_smt?> / <?=nama_smt($mahasiswa_pt->mulai_smt)?>
						</div>
					</div>
				</div>
			</div>
		</div>
		
<form method="post" action="<?= base_url('mahasiswa/proses_cuti/'.$id_smt.'/'.$mahasiswa_pt->id_mahasiswa_pt) ?>" enctype="multipart/form-data">
			<input type="hidden" name="id_smt" value="<?=$id_smt?>">
			<input type="hidden" name="id_mahasiswa_pt" value="<?=$mahasiswa_pt->id_mahasiswa_pt?>">
			<div class="col-12 mb-4">
				<div class="card h-100">
					<div class="card-body">

						<h5 class="card-title">Cuti Akademik</h5>
						<div class="row g-3">
							
							<div class="col-md-4 mt-2">
								Tahun Akademik
							</div>
							<div class="col-md-8 mt-2">
								<?=nama_smt($id_smt)?>
							</div>
							<div class="col-md-4 mt-2">
								Surat Permohonan 
								<?php
									if(file_exists('dokumen/etc/cuti-'.$id_smt.'-'.$mahasiswa_pt->id_mahasiswa_pt.'.pdf')){
										echo '<a target="_blank" href="'.base_url('dokumen/etc/cuti-'.$id_smt.'-'.$mahasiswa_pt->id_mahasiswa_pt.'.pdf?'.date('His')).'">Lihat</a>';
									}
								?>
							</div>
							<div class="col-md-8 mt-2">
								<input type="file" name="surat" accept=".pdf">
							</div>
							<div class="col-md-12">
								<button type="submit" class="btn btn-warning">Update</button>
							</div>
						</div>
	
					</div>
				</div>
			</div>
</form>
		</div>
	</div>
</div>