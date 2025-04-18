<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">

			<div class="col mb-4">
				<div class="card">
					<div class="card-body">
					    <h4>Perhatian : Form ini akan menyimpan nilai! Pastikan tidak melakukan lebih dari 1 kali proses</h4>
					    <form method="post" action="<?=base_url('nilai/simpan_manual')?>">
					        <input type="hidden" name="id_mahasiswa_pt" value="<?=$mahasiswa_pt->id_mahasiswa_pt?>">
					        <input type="hidden" name="id_mhs" value="<?=$mahasiswa_pt->id_mhs?>">
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <td rowspan="2">#</td>
                <th colspan="4">Nilai Asal</th>
                <th colspan="5">Nilai Konversi</th>
            </tr>
            <tr>
                <th>Kode MK Asal</th>
                <th>Nama MK Asal</th>
                <th>SKS MK Asal</th>
                <th>Nilai MK Asal</th>
                <th>Kode MK Diakui</th>
                <th>Nama MK Diakui</th>
                <th>SKS MK Diakui</th>
                <th>Nilai MK Diakui</th>
				<th>Sudah ada?</th>
            </tr>
        </thead>
        <tbody>
        <?php
            if($mata_kuliah_kurikulum)
            {
                foreach($mata_kuliah_kurikulum as $key=>$value)
                {
                        $kode_mk_konv   = '';
                        $nm_mk_konv     = '';
                        $sks_mk_konv    = '';
                        $nilai_akui = '';
                        $nilai_huruf = '';
                   echo'
                   <tr>
                        <td>
                            <input type="checkbox" name="ceknilai[]" value="'.$value->id_matkul.'" class="ceknilai" id="ceknilai-'.$value->id_matkul.'" data-id_matkul="'.$value->id_matkul.'">
                        </td>
                        <td><input style="display:none" type="text" id="kode_mk_konv-'.$value->id_matkul.'" name="kode_mk_konv-'.$value->id_matkul.'" class="form-control" placeholder="Kode MK Asal"></td>
                        <td><input style="display:none" type="text" id="nm_mk_konv-'.$value->id_matkul.'" name="nm_mk_konv-'.$value->id_matkul.'" class="form-control" placeholder="Nama MK Asal"></td>
                        <td><input style="display:none" type="number" id="sks_mk_konv-'.$value->id_matkul.'" name="sks_mk_konv-'.$value->id_matkul.'" class="form-control" placeholder="SKS MK Asal"></td>
                        <td><select style="display:none" id="nilai_huruf_asal-'.$value->id_matkul.'" name="nilai_huruf_asal-'.$value->id_matkul.'" data-id_matkul="'.$value->id_matkul.'" class="nilai_huruf_asal form-control"><option>pilih</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option></select></td>
                        <td>'.$value->kode_mk.'</td>
                        <td>'.$value->nm_mk.'</td>
                        <td>'.$value->sks_mk.' <input type="hidden" name="sks_diakui-'.$value->id_matkul.'" value="'.$value->sks_mk.'"></td>
                        <td><div id="nilai_huruf_diakui-'.$value->id_matkul.'"></div></td>
						<td><div class="get_nilai" id="h_mk'.$value->id_matkul.'" data-id_matkul="'.$value->id_matkul.'" ></div></td>
                    </tr>
                   '; 
                }
            }else{
                echo '<tr><td colspan="8"><em>tidak ada kurikulum Aktif</em></td></tr>';
            }
        ?>
        </tbody>
    </table>
</div>
                    <input class="btn btn-info" onclick="return confirm('are you sure?')" type="submit" value="Simpan">
                    </form>
					 </div>
			    </div>
			</div>
		
		</div>
	</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.1.min.js" type="text/javascript"></script>
<script>
	$(".ceknilai").change(function(event)
	{
		var id_matkul = $(this).data("id_matkul")
		if($("#ceknilai-"+id_matkul).prop("checked") == true){
			$("#kode_mk_konv-"+id_matkul).show()
			$("#nm_mk_konv-"+id_matkul).show()
			$("#sks_mk_konv-"+id_matkul).show()
			$("#nilai_huruf_asal-"+id_matkul).show()
		}
		else if($("#ceknilai-"+id_matkul).prop("checked") == false){
			$("#kode_mk_konv-"+id_matkul).hide()
			$("#nm_mk_konv-"+id_matkul).hide()
			$("#sks_mk_konv-"+id_matkul).hide()
			$("#nilai_huruf_asal-"+id_matkul).hide()
			$("#nilai_huruf_diakui-"+id_matkul).html('')
		}
	})
	$(".nilai_huruf_asal").change(function(event)
	{
		var id_matkul   = $(this).data("id_matkul")
		var nilai       = $(this).val()
		$("#nilai_huruf_diakui-"+id_matkul).html(nilai)
	})
	
	
	var nilai = document.querySelectorAll('.get_nilai');
	var id_mahasiswa_pt = '<?=$mahasiswa_pt->id_mahasiswa_pt?>';
	nilai.forEach( (row, index) => {
		fetch('<?= base_url('nilai/nilai_maks') ?>/'+id_mahasiswa_pt+'/'+row.dataset.id_matkul, {
		}).then( response => {
			return response.text()
		}).then( text => {
			document.querySelector("#h_mk"+row.dataset.id_matkul).textContent = text
		}).catch( err => {
			console.warn(err)
		})
})
</script>