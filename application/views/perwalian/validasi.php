<div class="content__boxed">
	<div class="content__wrap">
		<?php if ($mbkm->num_rows() > 0): ?>
		<div class="alert alert-info mt-2">
			<i class="pli-information me-1"></i> Pada semester ini mahasiswa tersebut tercatat sebagai mahasiswa <b>Merdeka Belajar Kampus Merdeka (MBKM)</b>.<!--  silahkan ambil mata kuliah kampus merdeka sebanyak <?= $sks_mbkm = $mbkm->row()->sks_diakui ?> SKS. -->
		</div>
		<?php endif; ?>
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
			<div class="col-md-4 mt-1"><strong>Lihat KRS</strong></div>
			<div class="col-md-8 mt-1"><a href="<?= base_url('krs/add/'.$id_smt.'/'.$mahasiswa_pt->id_mahasiswa_pt)?>">Cek KRS</a></div>
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
		$edit_catatan = ($_SESSION['app_level']!=2)?'disabled':'';
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
			<div class="col-md-8 mt-1"><textarea rows="3" class="form-control" onblur="simpan_catatan()" id="isi_catatan" <?=$edit_catatan?>><?=$isi_catatan?></textarea>
			<button class="btn btn-primary mt-2 <?=$edit_catatan?>" ><i class="psi-paper-plane"></i></button>
			</div>
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
<form method="post" action="<?=base_url('perwalian/simpan_perwalian/'.$id_smt.'/'.$mahasiswa_pt->id_mahasiswa_pt)?>">
<div class="table-responsive">
	<table class="table table-stripped">
		<thead>
			<th>Nama Kelas</th>
			<th>SKS</th>
			<th>Jadwal</th>
			<th>Validasi</th>
		</thead>
		<tbody>
		<?php
		$total_sks=0;
		$total_sks_mbkm = 0;
		if($list_kelas_krs->result())
		{
			foreach($list_kelas_krs->result() as $key=>$value){
				$label_mbkm = '';
				
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

				$validasi = '<input type="checkbox" '.$edit_catatan.' class="form-check-input mt-0 krsmhs" name="id_krs[]" value="'.$value->id_krs.'" onchange="tampil_btn()">';
				if($value->status_krs==1)
				{
					$validasi='<span class="badge bg-info">sudah validasi</a>';
				}
				if($value->status_krs==2)
				{
					$validasi='<span class="badge bg-success">sudah dikelas</a>';
				}
			echo'
			<tr>
				<td>'.$value->nm_mk.' '.$value->nm_kls.$label_mbkm.'</td>
				<td>'.$value->sks_mk.'</td>
				<td>
					'.nama_hari($value->hari_kuliah).' <br>
					'.$value->jam_mulai.' s/d
					'.$value->jam_selesai.'
				</td>
				<td>'.$validasi.'</td>
			</tr>
			';
			}
			echo'
			</tbody>
			<tfoot>
				<th>TOTAL SKS</th>
				<td colspan="2"><b>'.($total_sks + $total_sks_mbkm).' SKS</b> ('.$total_sks.' SKS Reguler, '.$total_sks_mbkm.' SKS MBKM)</td>
				<th><input type="checkbox" '.$edit_catatan.' class="form-check-input mt-0" onClick="check_all(this)"></th>
			</tfoot>
		</table>	
			';
		}else{
			echo'<tr><td colspan="4">n/a</a></tbody>
	</table>';
		}
		?>
</div>
<div class="mt-4 d-grid gap-2">
	<input type="hidden" value="<?=$total_sks?>" name="total_sks">
	<button <?=$edit_catatan?> class="btn btn-info" type="submit" style="display:none" id="btn_ajuan"><i class="pli-yes"></i> Validasi</button>
</div>
</form>
					</div>
				</div>
			</div>
			
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
	</div>
</div>
<script>
function tampil_btn()
{
	document.getElementById("btn_ajuan").style.display = "block";
}

function check_all(source)
{
    checkboxes = document.querySelectorAll('.krsmhs');
    checkboxes.forEach(e => {
        e.checked = source.checked
    })
    
    if (source.checked) {
        document.getElementById("btn_ajuan").style.display = "block";
    } else {
        document.getElementById("btn_ajuan").style.display = "none";
    }
    
    // for(var checkbox in checkboxes)
        // checkbox.checked = source.checked;
}

function simpan_catatan()
{
    var isi_catatan = document.getElementById('isi_catatan').value;
	var data = new FormData()
	data.append('isi_catatan', isi_catatan);
    
	let url = "<?=base_url('perwalian/isi_catatan/'.$id_smt.'/'.$mahasiswa_pt->id_mahasiswa_pt.'/')?>"
    
	fetch(url, {
		method: 'POST',
		body: data
	})
        .then((response) => response.text())
        .then((text) => {
            if(text==1)
				Toastify({ text: "Catatan Tersimpan",	style: { background: "<?=$_ENV['CLR_SUC']?>",	} }).showToast();
			else
				Toastify({ text: "Catatan Tidak Tersimpan",	style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
			
        });
}
</script>