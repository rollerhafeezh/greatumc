<style type="text/css">
	a { text-decoration: none!important }
</style>
<div id="pembimbing" class="tab-pane fade" role="tabpanel" aria-labelledby="pembimbing-tab">
	<form class="mb-3" method="POST" action="<?= base_url('mbkm/tambah_dosen/pembimbing') ?>">
		<input type="hidden" name="id_aktivitas" value="<?= $aktivitas->id_aktivitas ?>">
		<div class="row">
			<div class="col-md-3 mb-1">
				<input type="text" name="nidn" class="form-control nidn" placeholder="Masukkan Nama Dosen" required="" autocomplete="off" list="datalist_dosen" id="nidn" onchange="castvote()">
			</div>
			<div class="col-md-5 mb-1">
				<select name="id_kategori_kegiatan" class="form-select" required="">
					<option value="" hidden>Pilih Kategori Kegiatan</option>
					<?php $kategori_kegiatan = $this->Aktivitas_model->kategori_kegiatan(110300)->result(); ?>
					<?php foreach($kategori_kegiatan as $kategori_kegiatan): ?>
					<option value="<?= $kategori_kegiatan->id_kategori_kegiatan ?>"><?= $kategori_kegiatan->nama_kategori_kegiatan ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="col-md-2 mb-1">
				<input type="number" class="form-control" required="" name="pembimbing_ke" min="1" placeholder="Pembimbing Ke">
			</div>
			<div class="col-md-2 mb-1">
				<button type="submit" class="btn btn-info d-block w-100"><i class="ft-plus"></i> TAMBAH</button>
			</div>
		</div>
	</form>

	<div class="table-responsive">
		<table class="table table-bordered table-striped my-0">
			<thead class="text-nowrap">
				<tr class="bg-info text-white">
					<td class="text-white" width="1">ID</td>
					<td>NIDN</td>
					<td>Nama Dosen</td>
					<td>Kategori Kegiatan</td>
					<td>Pembimbing Ke</td>
					<td width="1">Aksi</td>
				</tr>
			</thead>
			<tbody>
			<?php if (count($pembimbing) > 0): ?>
				<?php foreach ($pembimbing as $pembimbing): ?>
				<tr>
					<td><?= $pembimbing->id_pembimbing ?></td>
					<td><?= $pembimbing->nidn ?></td>
					<td><?= $pembimbing->nm_sdm ?></td>
					<td><?= $pembimbing->nama_kategori_kegiatan ?></td>
					<td class="text-center"><?= $pembimbing->pembimbing_ke ?></td>
					<td align="center">
						<?php if(in_array($_SESSION['app_level'], [3, 7])): ?>
						<a onclick="return confirm('Hapus Dosen Pembimbing a.n <?= $pembimbing->nm_sdm ?> ?')" href="<?= base_url('mbkm/hapus_dosen/pembimbing/'.sha1($pembimbing->id_pembimbing).'/'.sha1($pembimbing->id_aktivitas)) ?>" class="badge bg-danger text-white">hapus</a>
						<?php else: ?>
						-
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="6" class="text-center"><i class="psi-student-male-female d-block fs-1 my-2"></i> Dosen Pembimbing Belum Diatur.</td>
				</tr>
			<?php endif; ?>	
			</tbody>
		</table>
	</div>
</div>