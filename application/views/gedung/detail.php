<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		
			<div class="col mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
					<div class="card-title m-1">
						<h5>Data Ruangan <span style="cursor:pointer" class="badge bg-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah Ruangan</span></h5>
					</div>
<div class="table-responsive">
<table id="datatabel" class="table table-striped" style="width:100%">
<thead>
    <tr>
        <th>Nama Ruangan</th>
        <th>Tingkat</th>
        <th>Daya Tampung Kuliah</th>
        <th>Daya Tampung Ujian</th>
        <th>Keterangan</th>
        <th>Status</th>
    </tr>
</thead>
<tbody>
	<?php
		if($ruangan)
		{
			foreach($ruangan as $key=>$value){
			$status = ($value->status_ruangan==1)?'Aktif':'Non-Aktif';
			echo'
				<tr>
					<td><input class="form-control" type="text" id="nama_ruangan_'.$value->id_ruangan.'" value="'.$value->nama_ruangan.'" onchange="ganti_nama_ruangan(`'.$value->id_ruangan.'`)"></td>
					<td>'.$value->tingkat_ruangan.'</td>
					<td>'.$value->daya_kuliah.'</td>
					<td>'.$value->daya_ujian.'</td>
					<td>'.$value->ket_ruangan.'</td>
					<td><a href="'.base_url('gedung/ganti_status_ruangan/'.$value->id_gedung.'/'.$value->id_ruangan.'/'.$value->status_ruangan).'">'.$status.'</a></td>
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
        <h5 class="modal-title" id="exampleModalLabel">Tambah Ruangan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" action="<?=base_url('gedung/simpan_ruangan')?>">
		<input type="hidden" name="id_gedung" value="<?=$gedung->id_gedung?>">
		<div class="modal-body">
			<div class="form-floating mb-3">
                <input type="text" id="nama_ruangan" name="nama_ruangan" class="form-control" required>
                <label for="nama_ruangan">Nama Ruangan</label>
            </div>
			
			<div class="form-floating mb-3">
                <input type="number" id="tingkat_ruangan" name="tingkat_ruangan" class="form-control">
                <label for="tingkat_ruangan">Tingkat</label>
            </div>
			
			<div class="form-floating mb-3">
                <input type="number" id="daya_kuliah" name="daya_kuliah" class="form-control">
                <label for="daya_kuliah">Daya Tampung (Kuliah)</label>
            </div>
			
			<div class="form-floating mb-3">
                <input type="number" id="daya_ujian" name="daya_ujian" class="form-control">
                <label for="daya_ujian">Daya Tampung (Ujian)</label>
            </div>
			
			
			<div class="form-floating mb-3">
                <input type="text" id="ket_ruangan" name="ket_ruangan" class="form-control">
                <label for="ket_ruangan">Keterangan</label>
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
function ganti_nama_ruangan(id_ruangan)
{
    var nama_ruangan = document.getElementById('nama_ruangan_'+id_ruangan).value;
    let url = "<?=base_url('gedung/ganti_nama_ruangan/')?>/"+id_ruangan+"/"+nama_ruangan;
    
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