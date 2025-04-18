<div class="row">
	<div class="col-md-8">
		<select id="mk_konv<?=$id_mata_kuliah_kurikulum?>" class="form-control">
			<option>Pilih MK</option>
			<?php
				foreach ($list_mk_kur as $key => $value) {
					echo '<option value="'.$value->id_matkul.'">'.$value->nm_mk.' '.$value->kode_mk.' ('.$value->sks_mk.')</option>';
				}
			?>	
		</select>
	</div>
	<div class="col-md-2">
		<button class="btn btn-success" onclick="simpan_mk_konversi('<?=$id_mata_kuliah_kurikulum?>')">SIMPAN</button>
	</div>
	<div class="col-md-2">
		<button class="btn btn-warning" onclick="batal_form('<?=$id_mata_kuliah_kurikulum?>')">TUTUP</button>
	</div>
</div>