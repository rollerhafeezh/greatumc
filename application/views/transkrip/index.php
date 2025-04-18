<div class="content__boxed">
	<div class="content__wrap">
		<div class="row justify-content-center">
		
			<div class="col-md-6 mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
						<div class="row">
							<div class="col-md-4 mt-2"><strong>Kurikulum</strong></div>
							<div class="col-md-8 mt-2">
							    <select class="form-control p-1 my-1" id="id_kur">

							    <?php
							        $kur=$this->Transkrip_model->get_kurikulum_prodi($mahasiswa_pt->kode_prodi)->result();
							        if($kur){
							            foreach($kur as $key=>$value)
							            {
							                echo '<option value="'.$value->id_kur.'">'.$value->nm_kurikulum_sp.'</option>';    
							            }
							        }else{
							            echo '<option>tidak ada kurikulum</option>';
							        }
							    ?>
							    </select>
							</div>
							<div class="col-md-4 mt-2"><strong>Jenis Transkrip</strong></div>
							<div class="col-md-8 mt-2">
							    <select name="tipe" class="form-control p-1 my-1" id="tipe">
                                	<option value="transkrip">Transkrip</option>
                                	<option value="khs">Transkrip Per Semester</option>
                                	<!--<option value="konversi">Konversi Nilai</option>-->
                                	<option value="transkrip_all">Riwayat Nilai</option>
                                </select>
							</div>
						</div>
					<div class="mt-4 d-grid gap-2">
						<button onclick="lihat()" class="text-decoration-none btn btn-success" ><i class="pli-eye"></i> Lihat</button>
						<button onclick="cetak()" class="text-decoration-none btn btn-info" ><i class="psi-printer"></i> Cetak</button>
					</div>
					</div>
				</div>
			</div>
			
		</div>
		<div class="row justify-content-center">
		
			<div class="col-md-12 mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
						<div id="tampil"></div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>
<script type="text/javascript">
function lihat() {
    var tipe = document.getElementById('tipe').value ;
    var id_kur = document.getElementById('id_kur').value ;
	
	if(tipe != '' && id_kur != ''){
	    fetch("<?= base_url() ?>transkrip/"+tipe+"/"+id_kur+"/<?=$mahasiswa_pt->id_mahasiswa_pt?>", {
		}).then( response => {
			return response.text()
		}).then( text => {
			document.querySelector('#tampil').innerHTML=text
		}).catch( err => {
			console.warn(err)
		})
	
	}else{
		Toastify({ text: "pilih salah satu!",	style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
		return false;
	}
}

function cetak() {
    var tipe = document.getElementById('tipe').value ;
    var id_kur = document.getElementById('id_kur').value ;
	
	if(tipe != '' && id_kur != ''){
	    window.open("<?= base_url() ?>transkrip/cetak_"+tipe+"/"+id_kur+"/<?=$mahasiswa_pt->id_mahasiswa_pt?>");
	}else{
		Toastify({ text: "pilih salah satu!",	style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
		return false;
	}
}

</script>