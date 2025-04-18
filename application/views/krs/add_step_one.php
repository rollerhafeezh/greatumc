<?php $arr_mk_mbkm = [] ?>
<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		
			<div class="col mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
						<div class="card-title">
							<h5>Pilih Semester</h5>
						</div>
				
<!--START KELAS-->
<div class="accordion" id="defaultAccordion">
	<?php if ($mbkm->num_rows() > 0): ?>
	<div class="accordion-item mt-2">
		<div class="accordion-header" id="HeadingSMT9">
			<button class="accordion-button bg-info text-white" type="button" data-bs-toggle="collapse" data-bs-target="#CollapseMBKM" aria-expanded="false" aria-controls="CollapseMBKM">
				Mata Kuliah Kampus Merdeka
			</button>
		</div>
		<div id="CollapseMBKM" class="accordion-collapse collapse" aria-labelledby="HeadingMBKM" data-bs-parent="#defaultAccordion" style="">
			<div class="accordion-body border border-info">
				<p class="text-danger">sisa : <?=$_SESSION['sisa_sks_mbkm']?> sks</p>
				<div class="mb-2 d-grid gap-2">
				<?php
					$aktivitas = $mbkm->row();
					$list_mk = $this->Mbkm_model->matkul_program(sha1($aktivitas->id_program_mitra))->result();

					foreach($list_mk as $key=>$value){
						$arr_mk_mbkm[] = $value->id_matkul;
						if($value->sks_mk <= $_SESSION['sisa_sks_mbkm']){
						$wajib=($value->a_wajib==1)?'Wajib':'Pilihan';
				?>
					<a href="<?= base_url('krs/add_step_two/'.$value->id_matkul.'/'.$id_smt.'/'.$mahasiswa_pt->id_mahasiswa_pt) ?>" class="btn text-start btn-sm btn-light" ><?=$value->kode_mk?> <?=$value->nm_mk?> <strong><?=$value->sks_mk?> SKS</strong> <em>(<?=$wajib?>)</em> </a>
					<?php } } ?>	
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<?php 
	$max=8;
	$smt=str_split($id_smt);
	if($smt[4]==1){
		$semester = [1,3,5,7];
	}elseif(($smt[4]==2)){
		$semester = [2,4,6,8];
	}else{
		$semester= [1,2,3,4,5,6,7,8];
	}
	foreach($semester as $i){
	
	?>
	<div class="accordion-item mt-2">
		<div class="accordion-header" id="HeadingSMT<?=$i?>">
			<button class="accordion-button bg-info text-white" type="button" data-bs-toggle="collapse" data-bs-target="#CollapseSMT<?=$i?>" aria-expanded="false" aria-controls="CollapseSMT<?=$i?>">
				Semester <?=$i?>
			</button>
		</div>
		<div id="CollapseSMT<?=$i?>" class="accordion-collapse collapse" aria-labelledby="HeadingSMT<?=$i?>" data-bs-parent="#defaultAccordion" style="">
			<div class="accordion-body border border-info">
				<p class="text-danger">sisa : <?=$_SESSION['sisa_sks']?> sks</p>
				<div class="mb-2 d-grid gap-2">
				<?php 
					$list_mk = $this->Kurikulum_model->ref_maktul_krs($mahasiswa_pt->id_mahasiswa_pt,$id_kur,$i)->result();
					foreach($list_mk as $key=>$value) {
						if($value->sks_mk <= $_SESSION['sisa_sks'] AND !in_array($value->id_matkul, $arr_mk_mbkm)) {
						$wajib=($value->a_wajib==1)?'Wajib':'Pilihan';
						$warna=($value->nilai_huruf)?'info':'light';
						$nilai=($value->nilai_huruf)?:'n/a';
				?>
					<a href="<?= base_url('krs/add_step_two/'.$value->id_matkul.'/'.$id_smt.'/'.$mahasiswa_pt->id_mahasiswa_pt) ?>" class="btn text-start btn-sm  btn-<?=$warna?>" ><?=$value->kode_mk?> <?=$value->nm_mk?> <strong><?=$value->sks_mk?> SKS</strong> <em>(<?=$wajib?>)</em>&nbsp; <strong>Nilai: </strong><?=$nilai?> </a>
					<?php } } ?>	
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
	<div class="accordion-item mt-2">
		<div class="accordion-header" id="HeadingSMT9">
			<button class="accordion-button bg-info text-white" type="button" data-bs-toggle="collapse" data-bs-target="#CollapseSMT9" aria-expanded="false" aria-controls="CollapseSMT9">
				Mata Kuliah Akhir
			</button>
		</div>
		<div id="CollapseSMT9" class="accordion-collapse collapse" aria-labelledby="HeadingSMT9" data-bs-parent="#defaultAccordion" style="">
			<div class="accordion-body border border-info">
				<p class="text-danger">sisa : <?=$_SESSION['sisa_sks']?> sks</p>
				<div class="mb-2 d-grid gap-2">
				<?php 
					$list_mk = $this->Kurikulum_model->ref_maktul_krs($mahasiswa_pt->id_mahasiswa_pt,$id_kur,'0')->result();
					foreach($list_mk as $key=>$value){
						if($value->sks_mk <= $_SESSION['sisa_sks']){
						$wajib=($value->a_wajib==1)?'Wajib':'Pilihan';
						$warna=($value->nilai_huruf)?'info':'light';
						$nilai=($value->nilai_huruf)?:'n/a';
				?>
					<a href="<?= base_url('krs/add_step_two/'.$value->id_matkul.'/'.$id_smt.'/'.$mahasiswa_pt->id_mahasiswa_pt) ?>" class="btn text-start btn-sm  btn-<?=$warna?>" ><?=$value->kode_mk?> <?=$value->nm_mk?> <strong><?=$value->sks_mk?> SKS</strong> <em>(<?=$wajib?>)</em>: <?=$nilai?> </a>
					<?php } } ?>	
				</div>
			</div>
		</div>
	</div>
</div>
<!--END KELAS-->

					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>