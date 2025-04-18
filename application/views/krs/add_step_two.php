<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		<?php 
		if($list_kelas){
		foreach($list_kelas as $key=>$value){ ?>
			<div class="col-md-3 mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column p-3">
						<h5 class="card-title"><?=$value->nm_mk?> <?=$value->nm_kls?></h5>
						<div class="table-responsive">
							<table class="table table-sm">
								<tbody>
									<tr>
										<td><strong>Semester</strong></td>
										<td>:</td>
										<td><?=nama_smt($id_smt)?></td>
									</tr>
									<tr>
										<td><strong>Prodi</strong></td>
										<td>:</td>
										<td><?=$value->nama_prodi?></td>
									</tr>
									<tr>
										<td><strong>Gedung</strong></td>
										<td>:</td>
										<td><?=$value->nama_gedung?></td>
									</tr>
									<tr>
										<td><strong>Ruangan</strong></td>
										<td>:</td>
										<td><?=$value->nama_ruangan?></td>
									</tr>
									<tr>
										<td><strong>Hari</strong></td>
										<td>:</td>
										<td><?=nama_hari($value->hari_kuliah)?></td>
									</tr>
									<tr>
										<td><strong>Mulai</strong></td>
										<td>:</td>
										<td><?=$value->jam_mulai?></td>
									</tr>
									<tr>
										<td><strong>Selesai</strong></td>
										<td>:</td>
										<td><?=$value->jam_selesai?></td>
									</tr>
									<tr>
										<td><strong>Pengampu</strong></td>
										<td>:</td>
										<td>
										<?php
											$pengampu=$this->Main_model->pengampu_kelas($value->id_kelas_kuliah)->result();
											if($pengampu)
											{
												
												foreach($pengampu as $keys=>$values)
												{
													echo'<p><strong>'.$values->nidn.'</strong> '.$values->nm_sdm.' ('.$values->sks_subst_tot.' SKS)</p>';
												}
												
											}else{ echo 'n/a'; }
										?>
										</td>
									</tr>
									<tr>
										<td><strong>&Sigma; Kuota</strong></td>
										<td>:</td>
										<td><?=$value->count_krs?>/<?=$value->kuota_kelas?> Orang</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="card-footer">
						<div class="mb-2 d-grid gap-2">
						    <?php if($value->count_krs < $value->kuota_kelas) { ?>
							<a href="<?= base_url('krs/add_step_three/'.$value->id_kelas_kuliah.'/'.$id_smt.'/'.$mahasiswa_pt->id_mahasiswa_pt) ?>" class="btn btn-sm  btn-danger" >Ambil Kelas</a>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		<?php } }else{ echo '<div class="h5 text-white"><em>Kelas Kuliah Belum tersedia</em></div>'; } ?>	
		</div>
	</div>
</div>