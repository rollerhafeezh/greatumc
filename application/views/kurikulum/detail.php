<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
			<div class="col-12 mb-4">
				<div class="card h-100">
					<div class="card-body">
<form method="post" class="row g-3" action="<?= base_url('kurikulum/update_kurikulum/'.$kurikulum->id_kur) ?>" enctype="multipart/form-data">
	<div class="col-md-4 mt-1">
		<label for="kode_fak" class="form-label">Semester Aktif</label>
		<input type="text" class="form-control" value="<?=nama_smt($kurikulum->id_smt)?>" disabled>
	</div>
	<div class="col-md-4 mt-1">
		<label for="kode_fak" class="form-label">Fakultas</label>
		<input type="text" class="form-control" value="<?=$kurikulum->nama_fak?>" disabled>
	</div>
	<div class="col-md-4 mt-1">
		<label for="kode_prodi" class="form-label">Program Studi</label>
		<input type="text" class="form-control" value="<?=$kurikulum->nama_prodi?>" disabled>
	</div>
	<div class="col-md-6 mt-1">
		<label for="nm_kurikulum_sp" class="form-label">Nama Kurikulum</label>
        <input id="nm_kurikulum_sp" name="nm_kurikulum_sp" value="<?=$kurikulum->nm_kurikulum_sp?>" type="text" class="form-control" readonly>
	</div>
	<div class="col-md-6 mt-1">
		<label for="sk_kurikulum" class="form-label">SK Kurikulum</label>
		<a href="<?=$kurikulum->sk_kurikulum?>">Lihat</a>
		<input id="sk_kurikulum" name="sk_kurikulum" accept=".pdf" type="file" class="form-control" style="display:none">
        
	</div>
	<div class="col-md-3 mt-1">
		<label for="jml_sem_normal" class="form-label">&Sigma; Semester Normal</label>
        <input id="jml_sem_normal" name="jml_sem_normal" value="<?=$kurikulum->jml_sem_normal?>" type="number" class="form-control" readonly>
	</div>
	<div class="col-md-3 mt-1">
		<label for="jml_sks_lulus" class="form-label">&Sigma; SKS Lulus</label>
        <input id="jml_sks_lulus" name="jml_sks_lulus" value="<?=$kurikulum->jml_sks_lulus?>" type="number" class="form-control" readonly>
	</div>
	<div class="col-md-3 mt-1">
		<label for="jml_sks_wajib" class="form-label">&Sigma; SKS Wajib</label>
		<input id="jml_sks_wajib" name="jml_sks_wajib" value="<?=$kurikulum->jml_sks_wajib?>" type="number" class="form-control" readonly>
	</div>
	<div class="col-md-3 mt-1">
		<label for="jml_sks_pilihan" class="form-label">&Sigma; SKS Pilihan</label>
		<input id="jml_sks_pilihan" name="jml_sks_pilihan" value="<?=$kurikulum->jml_sks_pilihan?>" type="number" class="form-control" readonly>
	</div>
	<div class="col-12" id="aktifasi">
		<div class="form-check">
			<?php
				$checked=($kurikulum->kur_aktif==1)?'checked':'';
				$status=($kurikulum->kur_aktif==1)?'Aktif':'Tidak Aktif';
			?>
			<input id="kur_aktif" name="kur_aktif" class="form-check-input" <?=$checked?> value="1" type="checkbox" disabled>
			<label for="kur_aktif" class="form-check-label">
				<?=$status?>
			</label>
		</div>
	</div>
	<div class="col-12 text-center">
		<?php if($_SESSION['app_level']==3 or $_SESSION['app_level']==4){ 
		if(!$mata_kuliah_kurikulum)
		{
		?>
		<a href="<?=base_url('kurikulum/hapus_kurikulum/'.$kurikulum->id_kur)?>" onclick="return confirm(`Yakin?`)" id="btn_hapus" class="btn btn-primary">Hapus Kurikulum</a>
		<?php } 
		if($kurikulum->kur_aktif==0){
		?>
		<a href="<?=base_url('kurikulum/aktifasi_kurikulum/'.$kurikulum->id_kur)?>" onclick="return confirm(`Yakin?`)" id="btn_aktif" class="btn btn-info">Aktifkan</a>
		<?php } ?>
		<?php if($check->value_konfigurasi=='on'){ ?>
		<a href="#" onclick="form_edit()" class="btn btn-warning" id="btn_edit">Edit</a> 
		<?php } ?>
		<a href="<?=base_url('kurikulum/konversi_kurikulum/'.$kurikulum->id_kur)?>" id="btn_aktif" class="btn btn-primary">Pengaturan Konversi</a>
		<button type="submit" class="btn btn-info" id="btn_update" style="display:none">Update</button>
		<?php } ?>
	</div>
</form>
<!--END-->		
					</div>
				</div>
			</div>
			
			<div class="col-12 mb-4">
				<div class="card h-100">
					
					<div class="card-body d-flex flex-column">
					<div class="card-title m-1">
						<h5>Mata Kuliah Kurikulum <?php if($check->value_konfigurasi=='on'){ ?> <span style="cursor:pointer" class="badge bg-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah MK Kurikulum</span> <?php } ?></h5>
					</div>
<div class="table-responsive">
<table id="datatabel" class="table table-striped" style="width:100%">
<thead>
    <tr>
        <th>Semester</th>
        <th>ID_MATKUL</th>
        <th>Kode MK</th>
        <th>Nama MK</th>
        <th>SKS</th>
        <th>Wajib</th>
        <th>Jenis MK</th>
        <th width="1">Kategori</th>
        <th width="1">PMM</th>
        <th>Aksi</th>
    </tr>
</thead>
<tbody>
	<?php
		if($mata_kuliah_kurikulum)
		{
		    //var_dump($mata_kuliah_kurikulum); exit;
			foreach($mata_kuliah_kurikulum as $key=>$value){
				$btn='';
			if($check->value_konfigurasi=='on'){
    			if($_SESSION['app_level']==3 or $_SESSION['app_level']==4){ 
    				$btn = '<a class="text-decoration-none" href="'.base_url('kurikulum/hapus_mata_kuliah_kurikulum/'.$kurikulum->id_kur.'/'.$value->id_mata_kuliah_kurikulum).'" onclick="return confirm(`Yakin akan dihapus?`)"><i class="psi-trash text-danger"></i></a>';
    			}
			}
			$a_wajib = ($value->a_wajib==1)?'Wajib':'Pilihan';
			echo'
				<tr>';
				
    			    if($_SESSION['app_level']==3 or $_SESSION['app_level']==4){
        			    if($check->value_konfigurasi=='on'){
    					echo '<td>
    					    <select onchange="ubah_mk_kur(`'.$value->id_mata_kuliah_kurikulum.'`)" id="id_mk_'.$value->id_mata_kuliah_kurikulum.'">
    					        ';
    					        for($i=0;$i<=8;$i++){
    					            $pilih=($value->smt==$i)?'selected':'';
    					            echo '<option value="'.$i.'" '.$pilih.'>'.$i.'</option>';
    					        }
    					echo'</select>
    					</td>';
        			    }else{
        			        echo '<td>'.$value->smt.'</td>';
        			    }
    			    }else{
    			        echo '<td>'.$value->smt.'</td>';
    			    }
					echo'<td>'.$value->id_matkul.'</td>
					<td>'.$value->kode_mk.'</td>
					<td>'.$value->nm_mk.'</td>
					<td>'.$value->sks_mk.'</td>
					<td>'.$a_wajib.'</td>
					<td>'.$value->nama_jenis_mk.'</td>
					<td>'.$value->id_kat_mk.'</td>
					<td><a class="text-decoration-none" href="javascript:void(0)" onclick="pmm(`'.$value->id_matkul.'`, `'.$value->pmm.'`)">'.($value->pmm ? 'Y' : 'N').'</td>
					<td>'.$btn.'</td>
				</tr>
			';
			}
		}else{
			echo'<tr><td colspan="5">belum ada data</td></tr>';
		}
	?>
</tbody>
</table>
</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Level</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" action="<?=base_url('kurikulum/simpan_mata_kuliah_kurikulum')?>">
		<input type="hidden" name="id_kur" value="<?=$kurikulum->id_kur?>">
      <div class="modal-body">
			<div class="form-floating mb-3">
                <a href="#" class="btn btn-primary text-decoration-none" onclick="get_mk()"> Ambil data Mata Kuliah</a>
            </div>
			<div class="form-floating mb-3">
                <select class="form-select" name="id_matkul" id="id_matkul" aria-label="Level" required>
                  <option>-</option>
                </select>
                <label for="floatingInput">Mata Kuliah</label>
            </div>
			<div class="form-floating mb-3">
                <select name="smt" id="smt" class="form-control" required>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="0">0</option>
				</select>
                <label for="floatingInput">Semester</label>
            </div>
			<div class="form-floating mb-3">
                <select name="a_wajib" id="a_wajib" class="form-control" required>
				<option value="1">Wajib</option>
				<option value="2">Pilihan</option>
				</select>
                <label for="floatingInput">Wajib</label>
            </div>
		</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary" type="submit">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal -->
<script>
function pmm(id_matkul, pmm) {
	var konfirmasi = confirm('Apakah anda yakin?')

	if (konfirmasi) {
		var data = new FormData()

		data.append('id_matkul', id_matkul);
		data.append('pmm', pmm);
		
		fetch('<?=base_url('kurikulum/ubah_pmm_matkul/')?>', {
			method: 'POST',
			body: data
		})
		.then((response) => response.text())
		.then((text) => {
			if(text==0){
				Toastify({ text: "Gatot!",	style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
			}else{
				Toastify({ text: "Tersimpan. Silahkan refresh halaman.",	style: { background: "<?=$_ENV['CLR_SUC']?>",	} }).showToast();
			}
		})
		.catch(error => {
			console.log(error)
		})   
	}
}

function ubah_mk_kur(id_mata_kuliah_kurikulum)
{
    smt = document.getElementById('id_mk_'+id_mata_kuliah_kurikulum).value
	var data = new FormData()
	data.append('id_mata_kuliah_kurikulum', id_mata_kuliah_kurikulum);
	data.append('smt', smt);
	
	fetch('<?=base_url('kurikulum/ubah_mk_kur/')?>', {
		method: 'POST',
		body: data
	})
	.then((response) => response.text())
	.then((text) => {
		if(text==0){
			Toastify({ text: "Gatot!",	style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
		}else{
			Toastify({ text: "Tersimpan",	style: { background: "<?=$_ENV['CLR_SUC']?>",	} }).showToast();
		}
	})
	.catch(error => {
		console.log(error)
	})   
}

function get_mk()
{
    let url = "<?=base_url('kurikulum/get_mata_kuliah_kurikulum/'.$kurikulum->id_kur.'/'.$kurikulum->kode_prodi)?>";
    
    fetch(url)
        .then((response) => response.text())
        .then((text) => {
            document.getElementById('id_matkul').innerHTML = text;
        });
}

function form_edit()
{
	document.getElementById("sk_kurikulum").style.display = "block";
	document.getElementById("btn_update").style.display = "block";
	document.getElementById("btn_aktif").style.display = "none";
	document.getElementById("btn_edit").style.display = "none";
	//document.getElementById("btn_hapus").style.display = "none";
	document.getElementById("jml_sem_normal").removeAttribute("readonly");
	document.getElementById("jml_sks_lulus").removeAttribute("readonly");
	document.getElementById("jml_sks_wajib").removeAttribute("readonly");
	document.getElementById("jml_sks_pilihan").removeAttribute("readonly");
	document.getElementById("nm_kurikulum_sp").removeAttribute("readonly");
}
</script>