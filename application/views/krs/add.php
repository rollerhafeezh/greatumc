<div class="content__boxed">
	<div class="content__wrap">
		<?php 
		if($status_bayar['hasil']=='1'){ ?>
		<div class="row">
		
			<div class="col-12 mb-3">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
						<div class="card-title">
							<h5>Detail Mahasiswa</h5>
						</div>
<div class="row">
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-4 mt-1"><strong>NIM</strong></div>
			<div class="col-md-8 mt-1"><?=$mahasiswa_pt->id_mahasiswa_pt?></div>
			<div class="col-md-4 mt-1"><strong>Nama Mahasiswa</strong></div>
			<div class="col-md-8 mt-1"><?=$mahasiswa_pt->nm_pd?></div>
			<div class="col-md-4 mt-1"><strong>Homebase</strong></div>
			<div class="col-md-8 mt-1"><?=$mahasiswa_pt->nama_fak?> - <?=$mahasiswa_pt->nama_prodi?></div>
		</div>
	</div>
	<?php 
		$smt_krs = smt_krs($id_smt);
		$cek_ips = $this->Main_model->cek_ips($smt_krs,$mahasiswa_pt->id_mahasiswa_pt)->row();
		$krs_note = $this->Main_model->krs_note($id_smt,$mahasiswa_pt->id_mahasiswa_pt)->row();
		$ips_lalu = ($cek_ips)?$cek_ips->ips:0;
		$hak_sks = batas_sks($ips_lalu);
		$hak_sks_mbkm = ($mbkm->num_rows() > 0 ? $mbkm->row()->sks_diakui : 0);
		$isi_catatan = ($krs_note)?$krs_note->isi_catatan:'';
		$sks_mbkm = 0;
	?>
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-4 mt-1"><strong>Semester</strong></div>
			<div class="col-md-8 mt-1"><?=nama_smt($id_smt)?></div>
			<div class="col-md-4 mt-1"><strong>IPS Semester <?=nama_smt($smt_krs)?></strong></div>
			<div class="col-md-8 mt-1"><?=$ips_lalu?> <a target="_blank" href="<?= base_url('cetak/khs/'.$smt_krs.'/'.$mahasiswa_pt->id_mahasiswa_pt)?>">Cek KHS</a></div>
			<div class="col-md-4 mt-1"><strong>Hak SKS</strong></div>
			<div class="col-md-8 mt-1">
				<?=$hak_sks?> SKS (<?= ($hak_sks - $hak_sks_mbkm) ?> SKS Reguler, <?= $hak_sks_mbkm ?> SKS MBKM)
			</div>
			<div class="col-md-4 mt-1"><strong>Catatan</strong></div>
			<div class="col-md-8 mt-1"><textarea rows="3" class="form-control" disabled><?=$isi_catatan?></textarea></div>
		</div>
	</div>
</div>
					
					</div>
				</div>
			</div>
			
			<div class="col-12 mb-3">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
						<div class="card-title">
							<h5>Daftar Kelas Kuliah Diajukan</h5>
						</div>

						<?php 
						if ($mbkm->num_rows() > 0) { 
							$jml_sks = $matkul_program->row()->jml_sks;
							$sks_mbkm = $jml_sks ? ($jml_sks > $mbkm->row()->sks_diakui ? $mbkm->row()->sks_diakui : $jml_sks) : 0; 
							// print_r($matkul_program->row()->jml_sks);
						?>
							<div class="alert alert-info">
								<i class="pli-information me-1"></i> Pada semester ini kamu tercatat sebagai mahasiswa <b>Merdeka Belajar Kampus Merdeka (MBKM)</b>.
							</div>
						<?php } ?>
<div class="table-responsive">
	<table class="table table-stripped">
		<thead>
			<th>Nama Kelas</th>
			<th>SKS</th>
			<th>Jadwal</th>
			<th>Validasi</th>
			<th>Aksi</th>
		</thead>
		<tbody>
		<?php
		$total_sks=0;
		$total_sks_mbkm = 0;
		if($list_kelas_krs->result())
		{
			foreach($list_kelas_krs->result() as $key=>$value){
				$label_mbkm = '';
			    $hari_kuliah = ($value->hari_kuliah=='0')?7:$value->hari_kuliah;
			    
			    if (isset($value->id_program_mitra)) {
			    	if ($value->id_program_mitra) {
			    		$total_sks_mbkm+=$value->sks_mk;
			    		$label_mbkm = ' <span class="ms-1 badge bg-info">mbkm</span>';
			    	} else {
				    	$total_sks+=$value->sks_mk;
			    	}
			    }else {
			    	$total_sks+=$value->sks_mk;
			    }

				$warna_validasi='<span class="badge bg-warning">n/a</a>';
				$btn_aksi = '<a class="text-decoration-none" href="'.base_url('krs/hapus_krs/'.$value->id_krs).'" onclick="return confirm(`Yakin akan dihapus?`)"><i class="psi-trash text-danger"></i></a>';
				if($value->status_krs==0)
				{
					$warna_validasi='<span class="badge bg-danger">belum</a>';
				}else if($value->status_krs==1)
				{
					$btn_aksi = '';
					$warna_validasi='<span class="badge bg-info">sudah validasi</a>';
				}else if($value->status_krs==2)
				{
					$btn_aksi = '';
					$warna_validasi='<span class="badge bg-success">sudah dikelas</a>';
				}
				if($krs_note) $btn_aksi = '';
				
			echo'
			<tr>
				<td>'.$value->nm_mk.' '.$value->nm_kls.$label_mbkm.'</td>
				<td>'.$value->sks_mk.'</td>
				<td>
					'.nama_hari($hari_kuliah).', 
					'.$value->jam_mulai.' s/d
					'.$value->jam_selesai.'<br>
					G. '.$value->nama_gedung.' R. '.$value->nama_ruangan.'
				</td>
				<td>'.$warna_validasi.'</td>
				<td>'.$btn_aksi.'</td>
			</tr>
			';
			}
			echo'
			</tbody>
			<tfoot>
				<th>TOTAL SKS</th>
				<td colspan="4"><b>'.($total_sks + $total_sks_mbkm).' SKS</b> ('.$total_sks.' SKS Reguler, '.$total_sks_mbkm.' SKS MBKM)</td>
			</tfoot>
		</table>	
			';
		}else{
			echo'<tr><td colspan="4">n/a</a></tbody>
	</table>';
		}
		?>
</div>
<?php 
$check = $this->Main_model->get_konfigurasi('buat_krs')->row();
if($check->value_konfigurasi=='on' ){
if($total_sks != 0 && !$krs_note){ ?>
			<div class="mt-4 d-grid gap-2">
				<a href="<?= base_url('krs/persetujuan_ajukan_krs/'.$id_smt.'/'.$mahasiswa_pt->id_mahasiswa_pt) ?>" class="text-decoration-none btn btn-danger" ><i class="pli-yes"></i> Ajukan</a>
			</div>
<?php } } ?>

					</div>
				</div>
			</div>
			<?php
				$_SESSION['hak_sks']   = $hak_sks;
				
				$_SESSION['total_sks'] = $total_sks; // total sks reguler yang sudah diambil
				$_SESSION['total_sks_mbkm'] = $total_sks_mbkm; // total sks mbkm yg sudah diambil

				$_SESSION['sisa_sks'] = $hak_sks-$total_sks-$sks_mbkm; // sisa sks reguler 
				$_SESSION['sisa_sks_mbkm'] = $sks_mbkm-$total_sks_mbkm; // sisa sks mbkm

				// print_r($_SESSION);
				
				if($total_sks < $hak_sks && !$krs_note){
			?>
			<div class="col-12 mb-4" id="kelas_kuliah_tersedia">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
						<div class="d-grid gap-2">
							<a href="<?= base_url('krs/add_step_one/'.$id_smt.'/'.$mahasiswa_pt->id_mahasiswa_pt) ?>" class="btn btn-info" >Ambil Kelas <i class="pli-arrow-right"></i><i class="pli-arrow-right"></i></a>
						</div>
					</div>
				</div>
			</div>
			<?php } 
				if($krs_note){
			?>
			<div class="col-12 mb-3">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
						<div class="card-title">
							<h5>Validasi KRS</h5>
						</div>
					<div class="row text-center">
						<div class="col-md-6 mt-1">
							<h4>Mahasiswa</h4>
							<?=$krs_note->created_at?>
							<h4><strong><?=$mahasiswa_pt->nm_pd?></strong></h4>
						</div>
						<div class="col-md-6 mt-1">
							<h4>Dosen Wali</h4>
							<?=$krs_note->tgl_validasi?>
							<h4><strong><?=$krs_note->validasi?></strong></h4>
						</div>
						<div class="col-md-4 mt-1">
							<h4>Akademik</h4>
							<?=$krs_note->tgl_validasi_aka?>
							<h4><strong><?=$krs_note->validasi_aka?></strong></h4>
						</div>
						<div class="col-md-4 mt-1">
							<h4>Keuangan</h4>
							<?=$krs_note->tgl_validasi_keu?>
							<h4><strong><?=$krs_note->validasi_keu?></strong></h4>
						</div>
						<div class="col-md-4 mt-1">
							<h4>Program Studi</h4>
							<?=$krs_note->tgl_validasi_prodi?>
							<h4><strong><?=$krs_note->validasi_prodi?></strong></h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php if($check->value_konfigurasi=='on'){ ?>
			<div class="col-12 mt-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
						<div class="mt-4 d-grid gap-2">
						Note: Jika Tarik Ajuan. Akan mengubah data KRS dan data Kelas Kuliah akan terhapus? Harus dari Awal Lagi!
							<a onclick="return confirm('Yakin?')" href="<?= base_url('krs/tarik_ajuan_krs/'.$id_smt.'/'.$mahasiswa_pt->id_mahasiswa_pt) ?>" class="text-decoration-none btn btn-danger" ><i class="pli-yes"></i> Tarik Ajuan</a>
						</div>
					</div>
				</div>
			</div>
		<?php } } ?>
		</div>
		<?php }else{ echo '<div class="card p-3 text-danger">'.$status_bayar['message'].'</div>'; } ?>
	</div>
</div>