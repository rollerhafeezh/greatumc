<style type="text/css">
	a { text-decoration: none!important }
</style>
<div id="penjadwalan" class="tab-pane fade" role="tabpanel" aria-labelledby="penjadwalan-tab">
	<form class="mb-3" method="POST" action="<?= base_url('studi_akhir/tambah_penjadwalan') ?>">
		<input type="hidden" name="id_aktivitas" value="<?= $aktivitas->id_aktivitas ?>">
		<div class="row">
			<div class="col-md-3 mb-1">
				<select name="id_kegiatan" class="form-select" required="">
					<option value="" hidden>Pilih Kegiatan</option>
					<?php foreach($kegiatan as $kegiatan): ?>
					<option value="<?= $kegiatan->id_kegiatan ?>"  <?= (($aktivitas->kode_fak != 3 AND $kegiatan->id_kegiatan == 4) ? 'hidden' : '') ?> ><?= $kegiatan->deskripsi ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="col-md-2 mb-1">
				<input type="text" name="nidn" class="form-control nidn" placeholder="Ketua Sidang" required="" autocomplete="off" list="datalist_dosen" id="nidn" onchange="castvote()">
			</div>
			<div class="col-md-2 mb-1">
				<input type="text" name="tempat" class="form-control" placeholder="Tempat" required="" id="tempat">
			</div>
			<div class="col-md-3 mb-1">
				<input type="datetime-local" name="tanggal" class="form-control" required="" id="tanggal">
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
					<td>Kegiatan</td>
					<td>Ketua Sidang</td>
					<td>Tempat</td>
					<td>Tanggal Pelaksanaan</td>
					<td>Status</td>
					<!-- <td>Selesai</td> -->
					<td>Berkas</td>
					<td width="1">Aksi</td>
				</tr>
			</thead>
			<tbody>
			<?php if (count($penjadwalan) > 0): ?>
				<?php foreach ($penjadwalan as $penjadwalan): ?>
				<tr>
					<td><?= $penjadwalan->id_penjadwalan ?></td>
					<td><?= $penjadwalan->deskripsi ?></td>
					<td><?= $penjadwalan->nidn ?> - <?= $penjadwalan->nm_sdm ?></td>
					<td><?= $penjadwalan->tempat ?></td>
					<td><?= $penjadwalan->event_id == '' ? format_indo($penjadwalan->tanggal) : '<a href="https://meet.jit.si/'.$penjadwalan->event_id.'" target="_blank">'.format_indo($penjadwalan->tanggal).' WIB</a>' ?></td>
					<td><?= $penjadwalan->status ? '<span class="text-secondary">Sudah Dilaksanakan</span>' : '<span class="text-danger">Belum Dilaksanakan</span>' ?></td>
					<!-- <td><?= $penjadwalan->selesai ?></td> -->
					<td>
						<?php $berkas_anggota = $this->Aktivitas_model->berkas_anggota([ 'k.id_jenis_aktivitas_mahasiswa' => $aktivitas->id_jenis_aktivitas_mahasiswa, 'kb.id_kat_berkas' => '4', 'bk.id_kegiatan' => $penjadwalan->id_kegiatan ])->row(); ?>

                        <a  href="javascript:void(0)" onclick="lihat_berkas(`Berita Acara <?= $berkas_anggota->deskripsi ?>`, `<?= domain_jitsi($aktivitas->id_jenis_aktivitas_mahasiswa, 'pdfjs', null).'/aktivitas/cetak/'.$berkas_anggota->slug_kategori_berkas.'/'.$berkas_anggota->slug_kegiatan.'/'.$penjadwalan->id_penjadwalan.'/'.$anggota[0]->id_mahasiswa_pt.'/'.$aktivitas->id_jenis_aktivitas_mahasiswa ?>`, `<?= domain_jitsi($aktivitas->id_jenis_aktivitas_mahasiswa, 'pdfjs', null) ?>`, <?= $penjadwalan->id_kegiatan == 5 ? $penjadwalan->id_penjadwalan : 'null' ?>)" class="text-nowrap">
                            <img src="<?= base_url('assets/img/pdf.png') ?>"> Berita Acara
                        </a>
					</td>
					<td>
						<a onclick="return confirm('Hapus Jadwal <?= $penjadwalan->deskripsi ?> ?')" href="<?= base_url('studi_akhir/hapus_penjadwalan/'.$penjadwalan->id_penjadwalan.'/'.$penjadwalan->id_aktivitas) ?>" class="badge bg-danger text-white">hapus</a>
					</td>
				</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="9" class="text-center"><i class="psi-calendar-4 d-block fs-1 my-2"></i> Penjadwalan Belum Diatur.</td>
				</tr>
			<?php endif; ?>	
			</tbody>
		</table>
	</div>
</div>
