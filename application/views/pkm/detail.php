<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		    
		    <div class="col-12 mb-2">
		        <div class="card bg-<?=$warna_status_ajuan[$aktivitas->status_aktivitas]?> text-white">
				    <div class="p-3 text-center">
                        <span class="h1">Status <?=$status_ajuan[$aktivitas->status_aktivitas]?></span>
                    </div>
				</div>
		    </div>

			<div class="col-md-8 mb-2">
				<div class="card h-100">
				    <div class="card-body d-flex flex-column">
				        <div class="row">
				            <div class="col-md-4 mb-2">Pengusul</div>
    				        <div class="col-md-8 mb-2">
    				            <?=$mahasiswa_pt->nm_pd?>
    				        </div>
    				        <div class="col-md-4 mb-2">Program Studi</div>
    				        <div class="col-md-8 mb-2">
    				            <?=$mahasiswa_pt->nama_prodi?>
    				        </div>
    				        <div class="col-md-4 mb-2">Bidang</div>
    				        <div class="col-md-8 mb-2">
    				            <?=$aktivitas->jenis_pkm?>
    				        </div>
    				        <div class="col-md-4 mb-2">Judul</div>
    				        <div class="col-md-8 mb-2">
    				            <?php  if($_SESSION['app_level']==1 && $aktivitas->status_aktivitas==0){ ?>
    				            <input type="text" class="form-control" id="judul" value="<?=$aktivitas->judul?>" onchange="update_aktivitas('judul')" placeholder="Judul">
    				            <?php }else{ ?>
    				            <?=$aktivitas->judul?>
    				            <?php } ?>
    				        </div>
    				        <div class="col-md-4 mb-2">Lokasi</div>
    				        <div class="col-md-8 mb-2">
    				            <?php  if($_SESSION['app_level']==1 && $aktivitas->status_aktivitas==0){ ?>
    				            <input type="text" class="form-control" id="lokasi" value="<?=$aktivitas->lokasi?>" onchange="update_aktivitas('lokasi')" placeholder="Lokasi">
    				            <?php }else{ ?>
    				            <?=$aktivitas->lokasi?>
    				            <?php } ?>
    				        </div>
    				        <div class="col-md-4 mb-2">Keterangan</div>
    				        <div class="col-md-8 mb-2">
    				            <?php  if($_SESSION['app_level']==1 && $aktivitas->status_aktivitas==0){ ?>
    				            <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan Kegiatan" rows="5" onblur="update_aktivitas('keterangan')" style="resize:none"><?=$aktivitas->keterangan?></textarea>
    				            <?php }else{ ?>
    				            <?=$aktivitas->keterangan?>
    				            <?php } ?>
    				        </div>
    				        <div class="col-md-4 mb-2">Dokumen
    				        </div>
    				        <div class="col-md-8 mb-2">
    				            
    				            <div class="table-responsive">
    				                <table class="table table-sm">
    				                    <thead>
    				                        <tr>
    				                            <th>Nama Dokumen</th>
    				                            <th>Tautan</th>
    				                            <th>#</th>
    				                        </tr>
    				                    </thead>
    				                    <tbody>
    				                        <?php
    				                            
    				                            $dokumen = $this->Pkm_model->get_dokumen($aktivitas->id_aktivitas)->result();
    				                            if($dokumen)
    				                            {
    				                                foreach($dokumen as $key=>$value){
        				                                echo '
        				                                <tr>
        				                                    <td>'.$value->nama_dokumen.'</td>
        				                                    <td><a href="'.$value->url_dokumen.'" target="_blank" class="text-decoration-none"><i class="psi-paperclip"></i></a></td>
        				                                    <td>';
        				                                    if($_SESSION['app_level']==1 && $aktivitas->status_aktivitas==0){
        				                                    echo '<button class="btn btn-icon btn-danger btn-sm" onclick="hapus_dokumen(`'.$value->id_dokumen.'`)"><i class="psi-trash fs-5"></i></button>';
        				                                    }
        				                                echo'</td>
        				                                </tr>
        				                                ';
        				                            }
    				                            }
        				                    ?>
    				                        <tr>
    				                            <td colspan="3">
    				                                <?php  if($_SESSION['app_level']==1 && $aktivitas->status_aktivitas==0){ ?>
    				                                <div id="form_dokumen" style="display:none">
    				                                    <div class="row">
    				                                        <div class="col-12 mt-1">
    				                                            <input type="text" id="nama_dokumen" name="nama_dokumen" class="form-control" placeholder="Nama Dokumen">
    				                                        </div>
    				                                        <div class="col-12 mt-1">
    				                                            <input type="file" id="dokumen" name="dokumen" class="form-control">
    				                                        </div>
    				                                    </div>
        				                                <div class="mt-2 d-grid gap-2">
                                                            <button class="btn btn-info btn-sm" type="button" onclick="add_dokumen()">Simpan Dokumen</button>
                                                            <button class="btn btn-danger btn-sm" type="button" onclick="add_dokumen_hide()">Ulangi</button>
                                                        </div>
                                                    </div>
    				                                <div  id="btn_dokumen_show">
        				                                <div class="mt-2 d-grid gap-2">
                                                            <button class="btn btn-primary btn-sm" type="button" onclick="add_dokumen_show()">Tambah Dokumen</button>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
    				                    </tbody>
    				                </table>
    				            </div>
    				        </div>
    				    </div>
    				    <div class="row">
    				        <div class="col-md-12 m-2 text-center">VALIDASI</div>
				            <div class="col-md-4 mb-2 text-center">Pengusul
				                <?php  if($_SESSION['app_level']==1 && $aktivitas->status_aktivitas==0){ ?>
            				    <div class="mt-2 d-grid gap-2">
            				        <button class="btn btn-info" type="button" onclick="proses_ajuan('1')">Ajukan</button>
            				    </div>
            				    <?php } 
            				    $check_validasi_mh = $this->Pkm_model->check_validasi('MAHASISWA',$aktivitas->id_aktivitas)->row();
            				    if($check_validasi_mh){ ?>
				                    <br><strong><?=$check_validasi_mh->oleh?></strong><br>
				                    <em><?=$check_validasi_mh->waktu?></em>
				                <?php } ?>
            				</div>
            				<div class="col-md-4 mb-2 text-center">Akademik
				                <?php  if($_SESSION['app_level']==3 && $aktivitas->status_aktivitas==1){ ?>
            				    <div class="mt-2 d-grid gap-2">
            				        <button class="btn btn-info" type="button" onclick="proses_ajuan('2')">Evaluasi</button>
            				    </div>
            				    <?php } ?>
            				     <?php  if($_SESSION['app_level']==3 && $aktivitas->status_aktivitas==2){ ?>
            				    <div class="mt-2 d-grid gap-2">
            				        <button class="btn btn-info" type="button" onclick="proses_ajuan('3')">Konfirmasi</button>
            				    </div>
            				    <?php } ?>
            				    <?php  if($_SESSION['app_level']==3 && ($aktivitas->status_aktivitas<3 && $aktivitas->status_aktivitas>0)){ ?>
            				    <div class="mt-2 d-grid gap-2">
            				        <button class="btn btn-danger" type="button" onclick="proses_ajuan('0')">Kembalikan</button>
            				    </div>
            				    <?php } 
            				    $check_validasi_ak = $this->Pkm_model->check_validasi('AKADEMIK',$aktivitas->id_aktivitas)->row();
            				    if($check_validasi_ak){ ?>
				                    <br><strong><?=$check_validasi_ak->oleh?></strong><br>
				                    <em><?=$check_validasi_ak->waktu?></em>
				                <?php } ?>
            				</div>
            				<div class="col-md-4 mb-2 text-center">Ketua Program Studi
				                <?php  
				                $check_validasi_kp = $this->Pkm_model->check_validasi('KAPRODI',$aktivitas->id_aktivitas)->row();
				                if($_SESSION['app_level']==7 && $aktivitas->status_aktivitas==3 && !$check_validasi_kp){ ?>
				                <div class="mt-2 d-grid gap-2">
            				        <button class="btn btn-info" type="button" onclick="validasi('7')">Validasi</button>
            				    </div>
            				    <?php } 
            				    
				                if($check_validasi_kp){ ?>
				                    <br><strong><?=$check_validasi_kp->oleh?></strong><br>
				                    <em><?=$check_validasi_kp->waktu?></em>
				                <?php } ?>
            				</div>
            				<div class="col-md-12 mb-2 text-center">Wakil Rektor
				                <?php  
				                $check_validasi_wr = $this->Pkm_model->check_validasi('WAKIL REKTOR',$aktivitas->id_aktivitas)->row();
				                if($_SESSION['app_level']==8 && $aktivitas->status_aktivitas==3 && !$check_validasi_wr){ ?>
            				    <div class="mt-2 d-grid gap-2">
            				        <button class="btn btn-info" type="button" onclick="validasi('8')">Validasi</button>
            				    </div>
            				    <?php } 
            				    
				                if($check_validasi_wr){ ?>
				                    <br><strong><?=$check_validasi_wr->oleh?></strong><br>
				                    <em><?=$check_validasi_wr->waktu?></em>
				                <?php } ?>
            				</div>
            			</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-4 mb-2">
			    <div class="card h-100">
				    <div class="card-body d-flex flex-column overflow-scroll scrollable-content" style="height: 400px;">
				    
				    <div class="tab-base">

                        <!-- Nav tabs -->
                        <ul class="nav nav-callout" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#_dm-coTabsBaseHome" type="button" role="tab" aria-controls="home" aria-selected="true">Aktivitas</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#_dm-coTabsBaseProfile" type="button" role="tab" aria-controls="profile" aria-selected="false">Riwayat</button>
                            </li>
                        </ul>

                        <!-- Tabs content -->
                        <div class="tab-content">
                            <div id="_dm-coTabsBaseHome" class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab">
                                <div class="d-flex align-items-center gap-1 pt-3">
                                    <textarea class="form-control" id="isi_percakapan" placeholder="Type a message" rows="1" style="resize:none"></textarea>
                                    <button onclick="add_percakapan()" class="btn btn-icon btn-primary">
                                        <i class="pli-paper-plane fs-5"></i>
                                    </button>
                                </div>
                                <div id="percakapan" class="mt-2"></div>
                            </div>
                            <div id="_dm-coTabsBaseProfile" class="tab-pane fade" role="tabpanel" aria-labelledby="profile-tab">
                                <div id="riwayat"></div>
                            </div>
                        </div>
                    </div>
				    
				    </div>
				</div>
				
		    </div>
		    
		</div>
	</div>
</div>
<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function(event) { 
  load_riwayat()
  load_percakapan()
});

function proses_ajuan(status_ajuan)
{
    var x = confirm('Yakin akan diproses? Pastikan semua data sudah Valid!')
    if(x)
    {
        var dataset = new FormData();
        dataset.append('id_aktivitas', '<?=$aktivitas->id_aktivitas?>');
        dataset.append('status_ajuan', status_ajuan);
    	
    	fetch('<?= base_url('pkm/proses_ajuan/') ?>', {
    	    method: 'post',
    		body: dataset
    	}).then( response => {
    		return response.text()
    	}).then( text => {
    		if(text==1){
    		    Toastify({ text: "Berhasil",	style: { background: "green",	} }).showToast();
    		}else{
    			Toastify({ text: "Gagal",	style: { background: "red",	} }).showToast();
    		}
    		setTimeout(location.reload(), 1000);
    	}).catch( err => {
    		console.warn(err)
    	})
    }else{ return false }
}

function validasi(validasi_ajuan)
{
    var x = confirm('Yakin akan diproses? Pastikan semua data sudah Valid!')
    if(x)
    {
        var dataset = new FormData();
        dataset.append('id_aktivitas', '<?=$aktivitas->id_aktivitas?>');
        dataset.append('validasi_ajuan', validasi_ajuan);
    	
    	fetch('<?= base_url('pkm/validasi_ajuan/') ?>', {
    	    method: 'post',
    		body: dataset
    	}).then( response => {
    		return response.text()
    	}).then( text => {
    		if(text==1){
    		    Toastify({ text: "Berhasil",	style: { background: "green",	} }).showToast();
    		}else{
    			Toastify({ text: "Gagal",	style: { background: "red",	} }).showToast();
    		}
    		setTimeout(location.reload(), 1000);
    	}).catch( err => {
    		console.warn(err)
    	})
    }else{ return false }
}

function add_dokumen()
{
    document.getElementById('loading').style.display = 'block';
    var nama_dokumen = document.getElementById('nama_dokumen').value;
	var isi_dokumen = document.getElementById('dokumen').value;
	var dokumen = document.getElementById('dokumen').files[0];
	
	if(nama_dokumen=='')
	{
	    Toastify({ text: "Nama Dokumen harus diisi!",	style: { background: "red",	} }).showToast();
		return false;
	}
	
	if(isi_dokumen=='')
	{
	    Toastify({ text: "Dokumen harus diisi!",	style: { background: "red",	} }).showToast();
		return false;
	}
	
	var dataset = new FormData();
	dataset.append('id_aktivitas', '<?=$aktivitas->id_aktivitas?>');
	dataset.append('nama_dokumen', nama_dokumen);
	dataset.append('dokumen', dokumen);
	
	fetch('<?= base_url('pkm/add_dokumen/') ?>', {
		method: 'post',
		 body: dataset
	}).then( response => {
		return response.text()
	}).then( text => {
	    document.getElementById('loading').style.display = 'none';
		if(text==1){
		    Toastify({ text: "Berhasil",	style: { background: "green",	} }).showToast();
		}else{
			Toastify({ text: "Gagal",	style: { background: "red",	} }).showToast();
		}
		setTimeout(location.reload(), 1000);
	}).catch( err => {
		console.warn(err)
	})
}

function load_riwayat()
{
    let url = "<?=base_url('pkm/riwayat/'.$aktivitas->id_aktivitas)?>";
    
    fetch(url)
        .then((response) => response.text())
        .then((text) => {
            document.getElementById('riwayat').innerHTML = text;
        });
}

function hapus_percakapan(id_bimbingan)
{
    var x = confirm('Yakin akan dihapus?')
    if(x)
    {
        var dataset = new FormData();
        dataset.append('id_bimbingan', id_bimbingan);
    	
    	fetch('<?= base_url('pkm/hapus_percakapan/') ?>', {
    	    method: 'post',
    		body: dataset
    	}).then( response => {
    		return response.text()
    	}).then( text => {
    	    console.log(text)
    		if(text==1){
    		    Toastify({ text: "Berhasil",	style: { background: "green",	} }).showToast();
    		}else{
    			Toastify({ text: "Gagal",	style: { background: "red",	} }).showToast();
    		}
    	load_percakapan()
    	}).catch( err => {
    		console.warn(err)
    	})
    }else{ return false }
}


function add_percakapan()
{
    var isi_percakapan = document.getElementById('isi_percakapan').value;
	
	if(isi_percakapan=='')
	{
	    Toastify({ text: "Isi Percakapan harus diisi!",	style: { background: "red",	} }).showToast();
		return false;
	}
	
    var dataset = new FormData();
	dataset.append('id_aktivitas', '<?=$aktivitas->id_aktivitas?>');
	dataset.append('isi', isi_percakapan);
	
	fetch('<?= base_url('pkm/add_percakapan/') ?>', {
		method: 'post',
		 body: dataset
	}).then( response => {
		return response.text()
	}).then( text => {
	document.getElementById('isi_percakapan').value = ''
		if(text==1){
		    Toastify({ text: "Berhasil",	style: { background: "green",	} }).showToast();
		}else{
			Toastify({ text: "Gagal",	style: { background: "red",	} }).showToast();
		}
	
	load_percakapan()
	}).catch( err => {
		console.warn(err)
	})
}

function load_percakapan()
{
    let url = "<?=base_url('pkm/percakapan/'.$aktivitas->id_aktivitas)?>";
    
    fetch(url)
        .then((response) => response.text())
        .then((text) => {
            document.getElementById('percakapan').innerHTML = text;
        });
}

function update_aktivitas(komponen)
{
	var dataset = new FormData();
	var isi = document.getElementById(komponen).value;
	dataset.append('id_aktivitas', '<?=$aktivitas->id_aktivitas?>');
	dataset.append('isi', isi);
	dataset.append('komponen', komponen);
	
	fetch('<?= base_url('pkm/update_aktivitas/') ?>', {
		method: 'post',
		 body: dataset
	}).then( response => {
		return response.text()
	}).then( text => {
		if(text==1){
		    Toastify({ text: "Berhasil",	style: { background: "green",	} }).showToast();
		}else{
			Toastify({ text: "Gagal",	style: { background: "red",	} }).showToast();
		}
		load_riwayat()
	}).catch( err => {
		console.warn(err)
	})
}

function add_dokumen_hide()
{
    document.getElementById('form_dokumen').style.display='none';
    document.getElementById('btn_dokumen_show').style.display='block';
}

function add_dokumen_show()
{
    document.getElementById('form_dokumen').style.display='block';
    document.getElementById('btn_dokumen_show').style.display='none';
}
</script>