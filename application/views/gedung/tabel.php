<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		
			<div class="col mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
					<div class="card-title m-1">
						<h5><span style="cursor:pointer" class="badge bg-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah Gedung</span></h5>
					</div>
<div class="table-responsive">
<table id="datatabel" class="table table-striped" style="width:100%">
<thead>
    <tr>
        <th>Nama Gedung</th>
        <th>Detail Ruangan</th>
        <th>Lokasi Gedung</th>
        <th>Keterangan</th>
        <th>Status</th>
    </tr>
</thead>
<tbody>
	<?php
		if($gedung)
		{
			foreach($gedung as $key=>$value){
			$status = ($value->status_gedung==1)?'Aktif':'Non-Aktif';
			echo'
				<tr>
					<td><input class="form-control" type="text" id="nama_gedung_'.$value->id_gedung.'" value="'.$value->nama_gedung.'" onchange="ganti_nama_gedung(`'.$value->id_gedung.'`)"></td>
					<td><a href="'.base_url('gedung/detail/'.$value->id_gedung).'">Lihat</a></td>
					<td>'.$value->lokasi_gedung.'</td>
					<td>'.$value->ket_gedung.'</td>
					<td><a href="'.base_url('gedung/ganti_status_gedung/'.$value->id_gedung.'/'.$value->status_gedung).'">'.$status.'</a></td>
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
        <h5 class="modal-title" id="exampleModalLabel">Tambah Gedung</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" action="<?=base_url('gedung/simpan_gedung')?>">
		
		<div class="modal-body">
			<div class="form-floating mb-3">
                <input type="text" id="nama_gedung" name="nama_gedung" class="form-control" required>
                <label for="nama_gedung">Nama Gedung</label>
            </div>
			
			<div class="form-floating mb-3">
                <input type="text" id="lokasi_gedung" name="lokasi_gedung" class="form-control">
                <label for="lokasi_gedung">Lokasi Gedung</label>
            </div>
			
			<div class="form-floating mb-3">
                <input type="text" id="ket_gedung" name="ket_gedung" class="form-control">
                <label for="ket_gedung">Keterangan</label>
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
function ganti_nama_gedung(id_gedung)
{
    var nama_gedung = document.getElementById('nama_gedung_'+id_gedung).value;
    let url = "<?=base_url('gedung/ganti_nama_gedung/')?>/"+id_gedung+"/"+nama_gedung;
    
    fetch(url)
        .then((response) => response.text())
        .then((text) => {
            if(text==1)
				Toastify({ text: "Tersimpan",	style: { background: "<?=$_ENV['CLR_SUC']?>",	} }).showToast();
			else
				Toastify({ text: "Tidak Tersimpan",	style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
			
        });
}

</script>