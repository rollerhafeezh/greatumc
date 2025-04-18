<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">

			<div class="colmb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
<div class="row">
	<div class="col-md-12 mt-1">
		<label for="id_smt" class="form-label">Semester Aktif</label>
		<select id="id_smt" name="id_smt" class="form-select">
			<option value="0">Semua Semester</option>
			<?php 
				$ref_smt 	= $this->Main_model->ref_smt();
				foreach($ref_smt as $ket=>$value)
				{
					$selected=($value->id_semester==$_SESSION['active_smt'])?'selected':'';
					echo'<option value="'.$value->id_semester.'" '.$selected.'>'.$value->nama_semester.'</option>';
				}
			?>
		</select>
	</div>
	
	<div class="col-md-12 mt-2">
	    <button class="btn btn-primary" onclick="return simpan()">Ubah</button>
	</div>
</div>
                    </div>
                </div>
            </div>
        
        </div>
    </div>
</div>
<script>
function simpan()
{
	var x = confirm('Yakin akan diubah?')
	if(x){
		var id_smt = document.getElementById("id_smt").value;
		window.open("<?=base_url('pengaturan/ubah_tahun/')?>"+id_smt)
		return true;
	}else{
		return false;
	}
}
</script>