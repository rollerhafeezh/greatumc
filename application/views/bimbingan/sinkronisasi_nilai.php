<form action="<?= base_url('bimbingan/simpan_sinkronisasi_nilai') ?>" method="POST">
	<!-- <div class="alert alert-info text-center">
		<i class="psi-information me-1"></i> Belum ada dosen yang input nilai.
	</div> -->
	<table class="w-100" cellpadding="3" cellspacing="0">
		<tr>
			<td class="text-nowrap">NIM</td>
			<td valign="top">:</td>
			<td valign="top"><?= $anggota->id_mahasiswa_pt ?></td>
		</tr>
		<tr>
			<td width="1" class="text-nowrap">Nama Lengkap</td>
			<td width="1" valign="top">:</td>
			<td valign="top"><?= $anggota->nm_pd ?></td>
		</tr>
		<tr>
			<td>Program Studi</td>
			<td valign="top">:</td>
			<td valign="top"><?= $anggota->nama_prodi ?> (<?= $anggota->nm_jenj_didik ?>)</td>
		</tr>
		<tr>
			<td class="text-nowrap">Nama Kegiatan</td>
			<td valign="top">:</td>
			<td valign="top"><?= $penjadwalan->deskripsi ?></td>
		</tr>
		<tr>
			<td><br>Detail Penilaian</td>
			<td><br>:</td>
			<td></td>
		</tr>
	</table>

	<table class="table table-bordered table-striped" cellpadding="3" cellspacing="0">
		<tr bgcolor="#F2F2F2" align="center">
			<th width="1">No</th>
			<th>Dosen</th>
			<th>Jabatan</th>
			<th width="70">Score</th>
		</tr>
		<?php 
			$i = 1; 
			$total_score = 0;
			$table = ['pembimbing', 'penguji', 'ketua sidang'];
		?>

		<?php if ($nilai_akhir->num_rows() > 0): ?>
		<?php foreach ($nilai_akhir->result() as $row): ?>
		<tr valign="middle">
			<td align="center"><?= $i ?>.</td>
			<td>
				<?= $this->Aktivitas_model->get($_ENV['DB_GREAT'].'dosen', ['nidn' => $row->nidn])->row()->nm_sdm ?><br>
				NIDN. <?= $row->nidn ?>
			</td>
			
			<?php if ($row->jenis_nilai < 3): ?>
			<?php $target = $table[$row->jenis_nilai-1]; $column = $target.'_ke'; ?>
			<td align="center"><?= ucwords($target) ?> <?= no_romawi($this->Aktivitas_model->get($_ENV['DB_AKT'].$target, ['nidn' => $row->nidn, 'id_aktivitas' => $penjadwalan->id_aktivitas])->row()->$column) ?></td>
			<?php else: ?>
			<td align="center"><?= ucwords($table[$row->jenis_nilai-1]) ?></td>
			<?php endif; ?>
			
			<td align="center"><?= $row->nilai_angka ?></td>

			<?php $total_score += $row->nilai_angka; ?>
		</tr>
		<?php $i++; endforeach; ?>
		<tr class="fw-bold text-center">
			<td colspan="3">Total Score</td>
			<td><?= $total_score != 0 ? number_format($total_score, 2) : '0' ?></td>
		</tr>
		<tr class="text-center">
			<td colspan="3"><b>Nilai Akhir</b> (Total Score / <?= $nilai_akhir->num_rows() ?>)</td>
			<td class="fw-bold">
				<?php $nilai_akhir = $total_score / $nilai_akhir->num_rows(); ?>
				<?php if ($nilai_akhir != 0): ?>
					<?= $nilai_akhir = number_format($nilai_akhir, 2) ?> (<?= $nilai_huruf = $this->Aktivitas_model->nilai_huruf($nilai_akhir, $penjadwalan->id_kegiatan)->nilai_huruf ?>)
				<?php endif; ?>
			</td>
		</tr>

		<?php else: ?>
		<tr>
			<td colspan="4" align="center">Belum ada yang input nilai.</td>
		</tr>
		<?php endif; ?>
	</table>

	<div class="form-group">
		<input type="hidden" name="id_mahasiswa_pt" value="<?= $anggota->id_mahasiswa_pt ?>">
		<input type="hidden" name="id_aktivitas" value="<?= $penjadwalan->id_aktivitas ?>">
		<input type="hidden" name="nilai_angka" value="<?= $nilai_akhir ?>">
		<input type="hidden" name="nilai_huruf" value="<?= $nilai_huruf ?>">
		<!-- <label id="id_nilai" class="form-label">Sinkronisasi ke Kelas Kuliah <span class="text-danger">*</span></label> -->
		<select class="form-select" id="id_nilai" name="id_nilai" required="">
			<option value="" hidden="">Pilih Kelas Kuliah</option>
			<?php foreach ($kelas_kuliah->result() as $row): ?>
			<option value="<?= $row->id_nilai ?>"><?= $row->id_smt ?> - <?= $row->nm_mk ?> (<?= $row->nm_kls ?>)</option>
			<?php endforeach; ?>
		</select>
	</div>

	<button class="btn btn-info w-100 mt-4" onclick="return confirm('Sinkronisasikan nilai ke kelas kuliah terpilih ?')">
		<i class="psi-paper-plane me-1"></i> Sinkronisasi Nilai
	</button>
</form>