<?php $nilai_akhir = 0; ?>
<form action="<?= base_url('bimbingan/simpan_nilai') ?>" method="POST">
	<input type="hidden" name="id_penjadwalan" value="<?= $id_penjadwalan; ?>">
	<input type="hidden" name="id_anggota" value="<?= $id_anggota; ?>">
	<input type="hidden" name="jenis_nilai" value="<?= $jenis_nilai; ?>">

	<!-- FORM PENILAIAN SIDANG USULAN PENELITIAN & SIDANG SKRIPSI -->
	<?php if ($id_kegiatan == 3 OR $id_kegiatan == 5): ?>

	<?php $kriteria_nilai = $this->Aktivitas_model->nilai([ 'id_anggota' => $id_anggota, 'id_penjadwalan' => $id_penjadwalan, 'jenis_nilai' => $jenis_nilai, 'nidn' => $_SESSION['username'], 'id_kegiatan' => $id_kegiatan ], null, ['kn.id_parent' => 0])->result(); ?>
	<div class="alert alert-info">
		<b>Catatan Penilaian:</b>
		<ul class="py-0 ps-3 m-0">
			<li>Masing-masing skor diberi skor 1-4 (nilai pecahan dimungkinkan);</li>
			<li>Presentasi dalam bahasa inggris diberikan nilai tambahan 3 (kurang memuaskan), 6 (cukup memuaskan), 10 (sangat memuaskan) untuk nilai total;</li>
			<li>Berikan skor 0 untuk menghapus nilai tertentu.</li>
		</ul>
	</div>
	<div class="table-responsive">
		<?php foreach($kriteria_nilai as $kriteria_nilai): ?>
		<table class="table table-bordered table-striped" width="100%">
			<tr class="text-center">
				<th>No.</th>
				<th>Kriteria dan Indikator Penilaian</th>
				<th>Bobot</th>
				<th>Skor</th>
				<th>Nilai <br> (Bobot x Skor)</th>
			</tr>
			<tr valign="middle">
				<th class="text-center" colspan="5"><?= $kriteria_nilai->nama_komponen ?> (<?= $kriteria_nilai->bobot ?>)</th>
			</tr>

    		<?php 
				$nilai = $this->Aktivitas_model->nilai([ 'id_anggota' => $id_anggota, 'id_penjadwalan' => $id_penjadwalan, 'jenis_nilai' => $jenis_nilai, 'nidn' => $_SESSION['username'], 'id_kegiatan' => $id_kegiatan, '' ], null, ['kn.id_parent' => $kriteria_nilai->id_komponen_nilai])->result();
				$no = 1;
				$bobot_skor = 0; 
				$total_nilai = 0;
			?>
			<?php foreach($nilai as $nilai): ?>
			<tr valign="middle">
				<td class="text-center" width="1"><?= $no ?>.</td>
				<td><?= $nilai->nama_komponen ?></td>
				<td class="text-center" width="115px"><?= $nilai->bobot ?></td>
				<td width="115px">
					<input type="number" class="form-control" min="0" max="4" oninput="update_nilai(this, <?= $nilai->id_parent ?>, <?= $nilai->id_komponen_nilai ?>)" step=".01" data-bobot="<?= $nilai->bobot ?>" data-id_kegiatan="<?= $id_kegiatan ?>" name="nilai[<?= $nilai->id_komponen_nilai ?>]" value="<?= $nilai->nilai ?>" required>
				</td>
				<td class="text-center" width="115px" id="nilai_<?= $nilai->id_parent ?>_<?= $nilai->id_komponen_nilai ?>">
					<?php $bobot_skor += ($nilai->bobot * $nilai->nilai); ?>
					<?php $total_nilai += $bobot_skor; ?>

					<?= $bobot_skor != 0 ? format_nilai($bobot_skor) : '' ?>
				</td>
			</tr>
			<?php $no++;  $bobot_skor = 0; endforeach; ?>

			<tr>
				<th class="text-center" colspan="4">Total Nilai</th>
				<th class="text-center" id="total_nilai_<?= $nilai->id_parent ?>">
					<?= $total_nilai != 0 ? format_nilai($total_nilai) : '' ?>
				</th>
			</tr>
		</table>
		<?php $nilai_akhir += $total_nilai ?>
		<?php endforeach; ?>

		<table class="table table-bordered table-striped">
			<tr valign="middle">
				<td class="text-center"><b>Nilai Tambahan</b> (Presentasi dalam bahasa inggris)</td>
				<th class="text-center" width="115px">
					<?php 
						$nilai_tambahan = $this->Aktivitas_model->nilai_tambahan(['id_komponen_nilai' => '0', 'id_anggota' => $id_anggota, 'id_penjadwalan' => $id_penjadwalan, 'jenis_nilai' => $jenis_nilai, 'nidn' => $_SESSION['username']])->row(); 
						$nilai_akhir += ($nilai_tambahan ? $nilai_tambahan->nilai : 0);
					?>
					<input type="number" class="form-control" min="0" max="10" step=".01" oninput="update_nilai_tambahan(this)" id="total_nilai_tambahan" 
					data-id_kegiatan="<?= $id_kegiatan ?>" name="nilai[0]" value="<?= $nilai_tambahan ? $nilai_tambahan->nilai : '' ?>">
				</th>
			</tr>
		</table>
		
		<table class="table table-bordered table-striped">
			<tr valign="middle">
				<td class="text-center"><b>Nilai Akhir</b> (Σ Total Nilai / 100)</td>
				<th class="text-center" width="115px">
					<div id="nilai_akhir">
					<?php if ($nilai_akhir != 0): ?>
						<?= $nilai_akhir = format_nilai(round($nilai_akhir/100, 2)) ?>
						(<?= $nilai_huruf = $this->Aktivitas_model->nilai_huruf($nilai_akhir, $id_kegiatan)->nilai_huruf ?>)

					<!-- <input type="hidden" name="id_aktivitas" value="<?= $id_aktivitas ?>">
					<input type="hidden" name="id_kegiatan" value="<?= $id_kegiatan ?>">
					<input type="hidden" name="nilai_angka" id="nilai_angka_hidden" value="<?= $nilai_akhir ?>"> -->
					<?php endif; ?>
					</div>
				</th>
			</tr>
		</table>
		<button class="btn btn-info w-100 mt-1">Simpan Nilai <i class="ms-1 psi-arrow-right-in-circle"></i></button>
	</div>

	<?php endif; ?>
	<!-- FORM PENILAIAN SIDANG USULAN PENELITIAN -->

	<!-- FORM PENILAIAN SIDANG PENDADARAN -->
	<?php if ($id_kegiatan == 2 OR $id_kegiatan == 4): ?>
	<?php $nilai = $this->Aktivitas_model->nilai([ 'id_anggota' => $id_anggota, 'id_penjadwalan' => $id_penjadwalan, 'jenis_nilai' => $jenis_nilai, 'nidn' => $_SESSION['username'], 'id_kegiatan' => $id_kegiatan ])->result(); ?>
    <div class="alert alert-info">
		<!-- <i class="pli-information me-1"></i> -->
		<b>Catatan Penilaian:</b>
		<ul class="py-0 ps-3 m-0">
			<li>Masukkan nilai pada rentang 0 s.d 100;</li>
			<li>Nilai 0 tidak diaggap dan akan menghapus nilai pada komponen tersebut;</li>
		</ul>
	</div>
	<div class="table-responsive">
		<table class="table table-bordered table-striped">
			<tr valign="middle" class="text-center">
				<th>No</th>
				<th>Unsur Penilaian</th>
				<th>Nilai</th>
			</tr>
			<?php $no = 1; $total_nilai = 0; ?>
			<?php foreach ($nilai as $nilai): ?>
			<tr valign="middle">
				<td class="text-center"><?= $no ?></td>
				<td><?= $nilai->nama_komponen ?></td>
				<td width="115px">
					<input type="number" class="form-control text-center" min="0" max="100" oninput="update_nilai(this)" step=".01" data-bobot="<?= $nilai->bobot ?>" data-id_kegiatan="<?= $id_kegiatan ?>" name="nilai[<?= $nilai->id_komponen_nilai ?>]" value="<?= $nilai->nilai ?>" required>
				</td>
			</tr>
			<?php $total_nilai += $nilai->nilai; $no++; ?>
			<?php endforeach; ?>
			<tr>
				<th colspan="2" class="text-end">Total</th>
				<th  class="text-center" id="total_nilai">
					<?= $total_nilai != 0 ? number_format($total_nilai, 2) : '' ?>
				</th>
			</tr>
			<tr>
				<th colspan="2" class="text-end">Rata-rata</th>
				<th  class="text-center" id="rata_rata_nilai">
					<?php if ($total_nilai != 0): ?>
						<?= $nilai_akhir = number_format(($total_nilai / ($no-1)), 2) ?>
						(<?= $nilai_huruf = $this->Aktivitas_model->nilai_huruf($nilai_akhir, $id_kegiatan)->nilai_huruf ?>)
					<?php endif; ?>
				</th>
			</tr>
		</table>
		<button class="btn btn-info w-100 mt-1">Simpan Nilai <i class="ms-1 psi-arrow-right-in-circle"></i></button>
	</div>
	<?php endif; ?>
	<!-- FORM PENILAIAN SIDANG PENDADARAN -->


	<!-- FORM PENILAIAN SEMINAR PKL / PPL -->
	<?php if ($id_kegiatan == 99): ?> 
    <?php $nilai = $this->Aktivitas_model->nilai([ 'id_anggota' => $id_anggota, 'id_penjadwalan' => $id_penjadwalan, 'jenis_nilai' => $jenis_nilai, 'nidn' => $_SESSION['username'], 'id_kegiatan' => $id_kegiatan ])->result(); ?>
    <div class="alert alert-info d-none">
		<!-- <i class="pli-information me-1"></i> -->
		<b>Informasi:</b>
		<ul class="py-0 ps-3 m-0">
			<li>Masukkan rentang nilai 0 s.d 100;</li>
			<li>Nilai 0 tidak diaggap dan akan menghapus nilai pada komponen tersebut;</li>
		</ul>
	</div>
	<div class="row">
		<?php foreach($nilai as $nilai): ?>
		<div class="col-md-4 mb-2 <?= (($nilai->id_komponen_nilai == 1 || $nilai->id_komponen_nilai == 4) && $jenis_nilai >= 2) ? 'd-none' : '' ?>">
	        <label for="<?= $nilai->id_komponen_nilai; ?>" class="form-label">Nilai <?= $nilai->nama_komponen; ?> <span class="text-danger">*</span></label>
	        <input id="<?= $nilai->id_komponen_nilai; ?>" name="nilai[<?= $nilai->id_komponen_nilai; ?>]" type="number" min="0" max="100" class="form-control" value="<?= $nilai->nilai; ?>" <?= !(($nilai->id_komponen_nilai == 1 || $nilai->id_komponen_nilai == 4) && $jenis_nilai >= 2) ? 'required' : '' ?>>
	    </div>
		<?php endforeach; ?>
		<div class="col-12"></div>
		<div class="col-12">
			<?php if ($nilai): ?>
			<button class="btn btn-info w-100 mt-2">Simpan Nilai <i class="ms-1 psi-arrow-right-in-circle"></i></button>
			<?php else: ?>
			<button class="btn btn-danger disabled w-100 mt-2"><i class="pli-exclamation me-1"></i> Komponen nilai belum diatur pada database.</button>
			<?php endif; ?>
		</div>
	</div>
	<?php endif; ?>
	<!-- FORM PENILAIAN SEMINAR PKL / PPL -->

	<input type="hidden" name="id_aktivitas" value="<?= $id_aktivitas ?>">
	<input type="hidden" name="id_kegiatan" value="<?= $id_kegiatan ?>">
	<input type="hidden" name="nilai_angka" id="nilai_angka_hidden" value="<?= $nilai_akhir ?>">
</form>