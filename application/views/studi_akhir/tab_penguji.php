<style type="text/css">
	a { text-decoration: none!important }
</style>
<div id="penguji" class="tab-pane fade" role="tabpanel" aria-labelledby="penguji-tab">
	<form class="mb-3" method="POST" action="<?= base_url('studi_akhir/tambah_dosen/penguji') ?>">
		<input type="hidden" name="id_aktivitas" value="<?= $aktivitas->id_aktivitas ?>">
		<div class="row">
			<div class="col-md-3 mb-1">
				<input type="text" name="nidn" class="form-control nidn" placeholder="Masukkan Nama Dosen" required="" autocomplete="off" list="datalist_dosen" id="nidn" onchange="castvote()">
			</div>
			<div class="col-md-3 mb-1">
				<select name="id_kegiatan" class="form-select" required="">
					<option value="" hidden>Pilih Kegiatan</option>
					<?php foreach($kegiatan as $kegiatan): ?>
					<option value="<?= $kegiatan->id_kegiatan ?>" <?= (($aktivitas->kode_fak != 3 AND $kegiatan->id_kegiatan == 4) ? 'hidden' : '') ?> ><?= $kegiatan->deskripsi ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="col-md-3 mb-1">
				<select name="id_kategori_kegiatan" class="form-select" required="">
					<option value="" hidden>Pilih Kategori Kegiatan</option>
					<?php $kategori_kegiatan = $this->Aktivitas_model->kategori_kegiatan(null, 'penguji')->result(); ?>
					<?php foreach($kategori_kegiatan as $kategori_kegiatan): ?>
					<option value="<?= $kategori_kegiatan->id_kategori_kegiatan ?>"><?= $kategori_kegiatan->nama_kategori_kegiatan ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="col-md-2 mb-1">
				<input type="number" class="form-control" required="" name="penguji_ke" min="1" placeholder="Penguji Ke">
			</div>
			<div class="col-md-1 mb-1">
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
					<td>Kegiatan</td>
					<td>Kategori Kegiatan</td>
					<td>Penguji Ke</td>
					<td width="1">Aksi</td>
				</tr>
			</thead>
			<tbody>
			<?php if (count($penguji) > 0): ?>
				<?php foreach ($penguji as $penguji): ?>
				<tr>
					<td><?= $penguji->id_penguji ?></td>
					<td><?= $penguji->nidn ?></td>
					<td><?= $penguji->nm_sdm ?></td>
					<td><?= $penguji->deskripsi ?></td>
					<td><?= $penguji->nama_kategori_kegiatan ?></td>
					<td class="text-center"><?= $penguji->penguji_ke ?></td>
					<td>
						<a onclick="return confirm('Hapus Dosen Penguji a.n <?= $penguji->nm_sdm ?> ?')" href="<?= base_url('studi_akhir/hapus_dosen/penguji/'.$penguji->id_penguji.'/'.$penguji->id_aktivitas) ?>" class="badge bg-danger text-white">hapus</a>
					</td>
				</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="7" class="text-center"><i class="psi-student-male-female d-block fs-1 my-2"></i> Dosen Penguji Belum Diatur.</td>
				</tr>
			<?php endif; ?>	
			</tbody>
		</table>
	</div>
</div>
