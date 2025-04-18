<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
			<div class="col-12 mb-4">
				<div class="card h-100">
					<div class="card-body">
					    <div class="row">
					        <div class="col-md-3 mt-2">Kurikulum Tujuan</div>
					        <div class="col-md-7 mt-2"><?=$kurikulum->nm_kurikulum_sp?></div>
					   </div>
					   <div class="row">
					        <div class="col-md-3 mt-2">Kurikulum Asal</div>
					        <div class="col-md-7 mt-2">
					            <?php if(isset($_SESSION['kurikulum_asal'])){ 
					            $kurikulum_asal=$_SESSION['kurikulum_asal'];
					            $kur_asal = $this->Kurikulum_model->get_kurikulum($_SESSION['kurikulum_asal'])->row();
					            ?>
					            <?=$kur_asal->nm_kurikulum_sp?>
					            <?php }else{ 
					            $kurikulum_asal=0;
					            ?>
					            <select class="form-control" id="kurikulum_asal">
					                <option value="">Pilih Kurikulum Asal</option>
					                <?php
					                    $pilih = $this->Kurikulum_model->get_kur_konversi($kurikulum->id_kur,$kurikulum->kode_prodi)->result();
					                    if($pilih)
					                    {
					                        foreach($pilih as $key=>$value)
					                        {
					                            echo '<option value="'.$value->id_kur.'">'.$value->nm_kurikulum_sp.'</option>';
					                        }
					                    }else{
					                        echo '<option value="">Tidak ada Kurikulum Lain</option>';
					                    }
					                ?>
					            </select>
					            <?php } ?>
					        </div>
					        <?php if(isset($_SESSION['kurikulum_asal'])){ ?>
					            <div class="col-md-2 mt-2"><button onclick="remove_asal()" class="btn btn-primary">Ulang</button></div>
					        <?php }else{ ?>
					            <div class="col-md-2 mt-2"><button onclick="set_asal()" class="btn btn-info">Atur</button></div>
					        <?php } ?>
					   </div>
					</div>
				</div>
			</div>
			
			<div class="col-12 mb-4">
				<div class="card h-100">
					<div class="card-body">
					    
<table class="table table-sm table-bordered table-striped">
	<thead>
		<tr>
			<th colspan="4">Kurikulum Tujuan</th>
			<th>Kurikulum Asal</th>
		</tr>
		<tr>
			<th>Semester</th>
			<th>Kode MK</th>
			<th>Nama MK</th>
			<th>SKS</th>
			<th>Kode MK Nama MK SKS #</th>
		</tr>
	</thead>
	<tbody>
<?php
	foreach ($mata_kuliah_kurikulum as $key => $value) {
		echo'
		<tr>
			<td>'.$value->smt.'</td>
			<td>'.$value->kode_mk.'</td>
			<td>'.$value->nm_mk.'</td>
			<td>'.$value->sks_mk.'</td>';
				if($kurikulum_asal!=0){
				if($value->id_matkul_konv){ 
					echo'<td id="mk_kur'.$value->id_mata_kuliah_kurikulum.'"><strong>'.$value->k_kode_mk.'</strong> '.$value->k_nm_mk.' ('.$value->k_sks_mk.') &nbsp; <button onclick="tampil_form(`'.$value->id_mata_kuliah_kurikulum.'`,`'.$kurikulum->id_kur.'`,`'.$kurikulum_asal.'`)" class="btn btn-sm btn-success btn_proses">UBAH</button> <button onclick="remove_mk_konv(`'.$value->id_mata_kuliah_kurikulum.'`)" class="btn btn-sm btn-danger btn_proses btn-block">HAPUS</button></td>';
				}else{
					echo '<td id="mk_kur'.$value->id_mata_kuliah_kurikulum.'"><button onclick="tampil_form(`'.$value->id_mata_kuliah_kurikulum.'`,`'.$kurikulum->id_kur.'`,`'.$kurikulum_asal.'`)" class="btn btn-sm btn-danger btn_proses btn-block">TAMBAH</button></td>';
				}
				}else{ echo  '<td>Pilih Kurikulum Asal</td>'; }
		echo '</tr>';
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
<script>
function set_asal()
{
    var id_kur ="<?=$kurikulum->id_kur?>"
    var id_kur_asal = document.getElementById('kurikulum_asal').value
    if(id_kur_asal !== "") window.location.assign("<?=base_url('kurikulum/set_asal/')?>"+id_kur+"/"+id_kur_asal);
}
function remove_asal()
{
    var id_kur ="<?=$kurikulum->id_kur?>"
    window.location.assign("<?=base_url('kurikulum/remove_asal/')?>"+id_kur)
}

function batal_form(id_mata_kuliah_kurikulum)
{
  var form_mk = document.querySelector("#mk_kur"+id_mata_kuliah_kurikulum)
  form_mk.innerHTML = 'refresh halaman untuk memunculkan teks'
}

function remove_mk_konv(id_mata_kuliah_kurikulum)
{
	
	var form_mk = document.querySelector("#mk_kur"+id_mata_kuliah_kurikulum)
	fetch('<?= base_url('kurikulum/remove_mk_konv/') ?>', {
		method: 'post',
    	body: new URLSearchParams({ id_mata_kuliah_kurikulum: id_mata_kuliah_kurikulum })
      }).then( response => {
        return response.text()
      }).then( text => {
        form_mk.innerHTML = text
      }).catch( err => {
        console.warn(err)
      })
}

function simpan_mk_konversi(id_mata_kuliah_kurikulum)
{
	var id_matkul_konv = document.querySelector("#mk_konv"+id_mata_kuliah_kurikulum)
	var form_mk = document.querySelector("#mk_kur"+id_mata_kuliah_kurikulum)
	console.log(id_matkul_konv.value)
	
	fetch('<?= base_url('kurikulum/store_mk_konv/') ?>', {
		method: 'post',
    	body: new URLSearchParams({ id_mata_kuliah_kurikulum: id_mata_kuliah_kurikulum, id_matkul_konv : id_matkul_konv.value })
      }).then( response => {
        return response.text()
      }).then( text => {
        form_mk.innerHTML = text
      }).catch( err => {
        console.warn(err)
      })
}

function tampil_form(id_mata_kuliah_kurikulum,id_kur,kurikulum_asal)
{
	var form_mk = document.querySelector("#mk_kur"+id_mata_kuliah_kurikulum)
	fetch('<?= base_url('kurikulum/list_mk_kur/'.$kurikulum->id_kur.'/'.$kurikulum_asal) ?>', {
		method: 'post',
    	body: new URLSearchParams({ id_mata_kuliah_kurikulum: id_mata_kuliah_kurikulum })
      }).then( response => {
        return response.text()
      }).then( text => {
        //$(".btn_proses").hide()
        form_mk.innerHTML = text
      }).catch( err => {
        console.warn(err)
      })
}
</script> 