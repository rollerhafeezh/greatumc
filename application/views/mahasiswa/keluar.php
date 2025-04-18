
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
		
<form method="post" action="<?= base_url('mahasiswa/proses_keluar/'.$mahasiswa_pt->id_mahasiswa_pt) ?>" enctype="multipart/form-data">
			<input type="hidden" name="id_mahasiswa_pt" value="<?=$mahasiswa_pt->id_mahasiswa_pt?>">
			<div class="col-12 mb-4">
				<div class="card h-100">
					<div class="card-body">

						<h5 class="card-title">Keluar Akademik
						<a href="<?=base_url('mahasiswa/aktif/'.$mahasiswa_pt->id_mahasiswa_pt)?>" onclick="return confirm(`Yakin?`)">Aktifkan Lagi</a>
						</h5>
						<div class="row g-3">
							
							<div class="col-md-4 mt-2">
								Jenis Keluar
							</div>
							<div class="col-md-8 mt-2">
								<select id="id_jns_keluar" name="id_jns_keluar" class="form-select">
								    <option>Pilih Status Mahasiswa</option>
									<?php 
										$jns_keluar 	= $this->Main_model->ref_jenis_keluar();
										foreach($jns_keluar as $ket=>$value)
										{
											echo'<option value="'.$value->id_jns_keluar.'">'.$value->ket_keluar.'</option>';
										}
									?>
								</select>
							</div>
							<div class="col-md-4 mt-2">
								Tanggal Keluar
							</div>
							<div class="col-md-8 mt-2">
								<input type="date" name="tgl_keluar" class="form-control" value="<?=date("Y-m-d")?>" required>
							</div>
							<div class="col-md-4 mt-2">
								Keterangan
							</div>
							<div class="col-md-8 mt-2">
								<input type="text" name="ket" class="form-control" value="-" required>
							</div>
							<div class="col-md-4 mt-2">
								Surat Permohonan 
								<?php
									if(file_exists('dokumen/etc/keluar-'.$mahasiswa_pt->id_mahasiswa_pt.'.pdf')){
										echo '<a target="_blank" href="'.base_url('dokumen/etc/keluar-'.$mahasiswa_pt->id_mahasiswa_pt.'.pdf?'.date('His')).'">Lihat</a>';
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