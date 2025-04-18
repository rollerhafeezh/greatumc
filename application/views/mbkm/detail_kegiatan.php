<style type="text/css">
	#tabel_detail * {
		border-bottom-style: unset !important;
	}
</style>

<div class="row">
	<div class="col-12">
		<h5>A. Deskripsi kegiatan</h5>
		<?php if ($detail->deskripsi): ?>
		<p align="justify">
			<?= $detail->deskripsi ?>
		</p>
		<?php else: ?>
		<div class="alert alert-info"><i class="pli-information me-1"></i> Tidak ada deskripsi kegiatan.</div>
		<?php endif; ?>

		<h5>B. Mata kuliah yang ditawarkan</h5>
		<?php if ($matkul_program->num_rows() > 0): ?>
		<div class="table-responsive">
    		<table id="tabel_detail" class="table table-striped " style="width:100%">
				<thead>
                    <tr>
                        <th width="1">No</th>
                        <th class="text-nowrap" width="1">Kode MK</th>
                        <th class="text-nowrap">Nama Mata Kuliah</th>
                        <th width="1">SMT</th>
                        <th width="1">SKS</th>
                    </tr>
                </thead>
				<tbody>
				<?php $no = 1; $sks_total = 0; foreach($matkul_program->result() as $mp): ?>
					<tr>
						<td class="text-center"><?= $no++ ?>.</td>
						<td class="text-center"><?= $mp->kode_mk ?></td>
						<td><?= $mp->nm_mk ?></td>
						<td class="text-center"><?= $mp->smt ?></td>
						<td class="text-center"><?= $mp->sks_mk; ?></td>
					</tr>
				<?php $sks_total += $mp->sks_mk; endforeach; ?>
				</tbody>
				<tfoot class="text-dark">
					<tr>
						<th colspan="4" class="text-end">TOTAL SKS :</th>
						<th class="text-center"><?= $sks_total ?></th>
					</tr>
					<tr>
						<th colspan="4" class="text-end">SKS DIAKUI :</th>
						<th class="text-center"><?= $detail->sks_diakui ?></th>
					</tr>
				</tfoot>
			</table>
			<!-- <div class="alert alert-info"><i class="pli-information me-1"></i> SKS diakui : <?= $detail->sks_diakui ?> SKS.</div> -->
		</div>
		<?php else: ?>
		<div class="alert alert-info"><i class="pli-information me-1"></i>Tidak ada mata kuliah yang ditawarkan.</div>
		<?php endif; ?>

		<h5>C. Informasi tambahan</h5>
		<?php if ($detail->keterangan): ?>
		<p align="justify" class="alert alert-info mb-0">
			<?= nl2br(strip_tags($detail->keterangan)) ?>
		</p>
		<?php else: ?>
		<div class="alert alert-info mb-0"><i class="pli-information me-1"></i>Tidak ada informasi tambahan.</div>
		<?php endif; ?>

	</div>
</div>