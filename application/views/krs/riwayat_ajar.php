
<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
			<div class="colmb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
<table id="datatabel" class="table table-striped table-responsive" style="width:100%">
<thead>
    <tr>
        <th>Tahun Akademik</th>
        <th>Status</th>
        <th>UTS</th>
        <th>UAS</th>
        <th>KRS</th>
        <th>KSM</th>
        <th>KHS</th>
    </tr>
</thead>
<tbody>
	<?php
	if($riwayat_ajar)
		//var_dump($riwayat_ajar); exit;
		foreach($riwayat_ajar as $key => $value){
	?>
	<tr>
		<td><?=nama_smt($value->id_smt)?></td>
		<td><?=$value->nama_status_mahasiswa?> 
		<?php
			if(file_exists('dokumen/etc/cuti-'.$value->id_smt.'-'.$value->id_mahasiswa_pt.'.pdf')){
				echo '<a target="_blank" href="'.base_url('dokumen/etc/cuti-'.$value->id_smt.'-'.$value->id_mahasiswa_pt.'.pdf?'.date('His')).'">Lihat Surat</a>';
			}
		?>
		</td>
		<?php if($value->id_stat_mhs=='A' || $value->id_stat_mhs == 'M') { ?>
		<td><a target="_blank" href="<?= base_url('cetak/kartu/uts/'.$value->id_smt.'/'.$value->id_mahasiswa_pt)?>" class="text-decoration-none"><i class="psi-printer"></i></a></td>
		<td><a target="_blank" href="<?= base_url('cetak/kartu/uas/'.$value->id_smt.'/'.$value->id_mahasiswa_pt)?>" class="text-decoration-none"><i class="psi-printer"></i></a></td>
		<td><a target="_blank" href="<?= base_url('cetak/krs/'.$value->id_smt.'/'.$value->id_mahasiswa_pt)?>" class="text-decoration-none"><i class="psi-printer"></i></a></td>
		<td><a target="_blank" href="<?= base_url('cetak/ksm/'.$value->id_smt.'/'.$value->id_mahasiswa_pt)?>" class="text-decoration-none"><i class="psi-printer"></i></a></td>
		<td><a target="_blank" href="<?= base_url('cetak/khs/'.$value->id_smt.'/'.$value->id_mahasiswa_pt)?>" class="text-decoration-none"><i class="psi-printer"></i></a></td>
		<?php } ?>
	</tr>
		<?php } ?>
</tbody>
</table>
<p>Keterangan Status:</p>
<ul>
    <li>Non-Aktif <em class="text-danger">status non aktif karena belum mengajukan KRS</em></li>
    <li>Aktif</li>
    <li>Cuti</li>
    <li>Kampus Merdeka</li>
</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>