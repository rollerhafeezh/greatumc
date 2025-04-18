<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		    
		    <div class="col-12 mb-2">
		        <div class="card bg-<?=$warna_status_ajuan[$mahasiswa_mutasi->status_mutasi]?> text-white">
				    <div class="p-3 text-center">
                        <span class="h3">Status <?=$status_ajuan[$mahasiswa_mutasi->status_mutasi]?></span>
                    </div>
				</div>
		    </div>

			<div class="col-md-6 mb-2">
				<div class="card h-100">
				    <h5 class="card-header">Data Lama</h5>
				    <div class="card-body d-flex flex-column">
				        <div class="row">
				            <div class="col-md-4 mb-2">Nama Mahasiswa</div>
    				        <div class="col-md-8 mb-2">
    				            <?=$mahasiswa_mutasi->nm_pd?>
    				        </div>
    				        <div class="col-md-4 mb-2">NIM Lama</div>
    				        <div class="col-md-8 mb-2">
    				            <?=$mahasiswa_mutasi->id_mahasiswa_pt_lama?>
    				        </div>
    				        <div class="col-md-4 mb-2">Jenis Keluar</div>
    				        <div class="col-md-8 mb-2">
    				            Pindahan
    				        </div>
    				        <div class="col-md-4 mb-2">Tanggal Keluar</div>
    				        <div class="col-md-8 mb-2">
    				            <?php  if($_SESSION['app_level']==3 && $mahasiswa_mutasi->status_mutasi==1){ ?>
    				            <input type="date" class="form-control" id="tgl_keluar" value="<?=$mahasiswa_mutasi->tgl_keluar?>" onchange="update_mutasi('tgl_keluar')" placeholder="tgl_keluar">
    				            <?php }else{ ?>
    				            <?=$mahasiswa_mutasi->tgl_keluar?>
    				            <?php } ?>
    				        </div>
    				        <div class="col-md-4 mb-2">Keterangan</div>
    				        <div class="col-md-8 mb-2">
    				            <?php  if($_SESSION['app_level']==3 && $mahasiswa_mutasi->status_mutasi==1){ ?>
    				            <input type="text" class="form-control" id="ket_keluar" value="<?=$mahasiswa_mutasi->ket_keluar?>" onchange="update_mutasi('ket_keluar')" placeholder="ket_keluar">
    				            <?php }else{ ?>
    				            <?=$mahasiswa_mutasi->ket_keluar?>
    				            <?php } ?>
    				        </div>
    				        
    				        <div class="col-md-4 mb-2">Dokumen Pindah</div>
    				        <?php  if($_SESSION['app_level']==3 && $mahasiswa_mutasi->status_mutasi==1){ ?>
    				        <div class="col-md-4 mb-2">
							    <input type="file" accept=".pdf" id="dokumen_pindah" class="form-control" placeholder="SK">
							</div>
							<div class="col-md-4 mb-2">
							    <button id="simpan" class="btn btn-sm btn-block btn-info mt-1" onclick="simpan_dokumen_pindah()"><i class="fas fa-save"></i> Unggah</button>
							</div>    
							    <?php } ?>
				            <div class="col-md-12 mb-2">
				                <?php
                					if($mahasiswa_mutasi->dokumen_pindah){
                						echo '<p><a target="_blank" href="'.$mahasiswa_mutasi->dokumen_pindah.'?'.date('His').'">Lihat Dokumen</a></p>';
                					}else{
                						echo '<p>n/a</p>';
                					}
                				?>
    				        </div>
    				    </div>
    				</div>
				</div>
			</div>
			<div class="col-md-6 mb-2">
				<div class="card h-100">
				    <h5 class="card-header">Data Baru</h5>
				    <div class="card-body d-flex flex-column">
				        <div class="row">
				            <div class="col-md-4 mb-2">Nama Mahasiswa</div>
    				        <div class="col-md-8 mb-2">
    				            <?=$mahasiswa_mutasi->nm_pd?>
    				        </div>
    				        <div class="col-md-4 mb-2">NIM Baru</div>
    				        <div class="col-md-8 mb-2">
    				            <?php  if($_SESSION['app_level']==5 && $mahasiswa_mutasi->status_mutasi==2){ ?>
    				            <input type="number" class="form-control" id="id_mahasiswa_pt_baru" value="<?=$mahasiswa_mutasi->id_mahasiswa_pt_baru?>" onchange="update_mutasi('id_mahasiswa_pt_baru')" placeholder="NIM Baru">
    				            <?php }else{ ?>
    				            <?=$mahasiswa_mutasi->id_mahasiswa_pt_baru?>
    				            <?php } ?>
    				            <i>)* diisi oleh Bag. Keuangan</i>
    				        </div>
    				        <div class="col-md-4 mb-2">Tanggal Masuk</div>
    				        <div class="col-md-8 mb-2">
    				            <?php  if($_SESSION['app_level']==3 && $mahasiswa_mutasi->status_mutasi==1){ ?>
    				            <input type="date" class="form-control" id="tgl_masuk_sp" value="<?=$mahasiswa_mutasi->tgl_masuk_sp?>" onchange="update_mutasi('tgl_masuk_sp')" placeholder="tgl_masuk_sp">
    				            <?php }else{ ?>
    				            <?=$mahasiswa_mutasi->tgl_masuk_sp?>
    				            <?php } ?>
    				        </div>
    				        <div class="col-md-4 mb-2">Tahun Semester Masuk</div>
    				        <div class="col-md-8 mb-2">
    				            <?php  if($_SESSION['app_level']==3 && $mahasiswa_mutasi->status_mutasi==1){ ?>
    				                <select id="mulai_smt" name="mulai_smt" class="form-select"  onchange="update_mutasi('mulai_smt')">
                            			<option value="0">Pilih Tahun</option>
                            			<?php 
                            				$ref_smt 	= $this->Main_model->ref_smt();
                            				foreach($ref_smt as $ket=>$value)
                            				{
                            				    $selected=($value->id_semester==$mahasiswa_mutasi->mulai_smt)?'selected':'';
                            					echo'<option value="'.$value->id_semester.'" '.$selected.'>'.$value->nama_semester.'</option>';
                            				}
                            			?>
                            		</select>
    				            <?php }else{ ?>
    				            <?=$mahasiswa_mutasi->mulai_smt?>
    				            <?php } ?>
    				        </div>
    				        <div class="col-md-4 mb-2">Mulai Semester Masuk</div>
    				        <div class="col-md-8 mb-2">
    				            <?php  if($_SESSION['app_level']==3 && $mahasiswa_mutasi->status_mutasi==1){ ?>
    				                <select id="diterima_smt" name="diterima_smt" class="form-select" onchange="update_mutasi('diterima_smt')">
                            			<option value="0">Pilih Semester</option>
                            			<?php 
                            				for($i=2;$i<=7;$i++)
                            				{
                            				    $selected=($i==$mahasiswa_mutasi->diterima_smt)?'selected':'';
                            				    echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                            				}
                            			?>
                            		</select>
    				            <?php }else{ ?>
    				            <?=$mahasiswa_mutasi->diterima_smt?>
    				            <?php } ?>
    				        </div>
    				        <div class="col-md-4 mb-2">Kelas Mahasiswa</div>
    				        <div class="col-md-8 mb-2">
    				            <?php  if($_SESSION['app_level']==3 && $mahasiswa_mutasi->status_mutasi==1){ 
    				                $kelas_mhs_reg = '';
    				                $kelas_mhs_non = '';
    				                $kelas_mhs_selected = '';
    				                if($mahasiswa_mutasi->kelas_mhs==1){
    				                    $kelas_mhs_reg='selected';
    				                }else if($mahasiswa_mutasi->kelas_mhs==2){
    				                    $kelas_mhs_non='selected';
    				                }else{
    				                    $kelas_mhs_selected ='';
    				                }
    				            ?>
    				                <select id="kelas_mhs" name="kelas_mhs" class="form-select"  onchange="update_mutasi('kelas_mhs')">
                            			<option value="0">Pilih Kelas</option>
                            			<option value="1" <?=$kelas_mhs_reg?>>Reguler</option>
                            			<option value="2" <?=$kelas_mhs_non?>>Non-Reguler</option>
                            		</select>
    				            <?php }else{ ?>
    				            <?php 
    				                if($mahasiswa_mutasi->kelas_mhs==1)
    				                    echo 'Reguler';
    				                else if($mahasiswa_mutasi->kelas_mhs==2)
    				                    echo 'Non-Reg';
    				                else
    				                    echo '-';
    				            ?>
    				            <?php } ?>
    				        </div>
    				        <div class="col-md-4 mb-2">Program Studi</div>
    				        <div class="col-md-8 mb-2">
    				            <?php  if($_SESSION['app_level']==3 && $mahasiswa_mutasi->status_mutasi==1){ ?>
    				                <select id="kode_prodi" name="kode_prodi" class="form-select" onchange="update_mutasi('kode_prodi')">
                            			<option value="0">Pilih Prodi</option>
                            			<?php 
                            				$ref_prodi 	= $this->Main_model->ref_prodi();
                            				foreach($ref_prodi as $ket=>$value)
                            				{
                            				    $selected=($value->kode_prodi==$mahasiswa_mutasi->kode_prodi)?'selected':'';
                            				    if($value->kode_prodi != 0) echo'<option value="'.$value->kode_prodi.'" '.$selected.'>'.$value->nm_jenj_didik.' '.$value->nama_prodi.'</option>';
                            				}
                            			?>
                            		</select>
    				            <?php }else{ ?>
    				                <?=$mahasiswa_mutasi->nm_jenj_didik?> <?=$mahasiswa_mutasi->nama_prodi?>
    				            <?php } ?>
    				        </div>
    				    </div>
    				</div>
				</div>
			</div>
			<div class="col-md-12 mb-2">
				<div class="card h-100">
				    <div class="card-body d-flex flex-column">
				        <?php  if($_SESSION['app_level']==3 && $mahasiswa_mutasi->status_mutasi==1){ ?>
				        <div class="mt-2 d-grid gap-2">
    				        <button class="btn btn-info" type="button" onclick="proses_ajuan('2')">Request NIM</button>
    				    </div>
    				    <?php } ?>
    				    <?php  if($_SESSION['app_level']==5 && $mahasiswa_mutasi->status_mutasi==2){ ?>
				        <div class="mt-2 d-grid gap-2">
    				        <button class="btn btn-info" type="button" onclick="proses_ajuan('3')">Kirim NIM Baru</button>
    				    </div>
    				    <?php } ?>
    				    <?php  if($_SESSION['app_level']==3 && $mahasiswa_mutasi->status_mutasi==3){ ?>
				        <div class="mt-2 d-grid gap-2">
    				        <a href="<?=base_url('mahasiswa/proses_mutasi/'.$mahasiswa_mutasi->id_mutasi)?>" onclick="return confirm('Pastikan semua sudah lengkap!')" class="btn btn-success btn-lg">Proses Mutasi</a>
    				    </div>
    				    <?php } ?>
    				    <?php  if($_SESSION['app_level']==3 && $mahasiswa_mutasi->status_mutasi < 4 ){ ?>
    				    <div class="mt-2 d-grid gap-2">
    				        <button class="btn btn-danger btn-sm" type="button" onclick="proses_ajuan('1')">Kembalikan ke Draft</button>
    				    </div>
    				    <?php } ?>
				    </div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.1.min.js" type="text/javascript"></script>
<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function(event) { 
  
});
function simpan_dokumen_pindah(event)
{
	var dokumen_pindah 	= $('#dokumen_pindah')[ 0 ].files[ 0 ];
	
	var dataset = new FormData();
	dataset.append('id_mutasi', '<?=$mahasiswa_mutasi->id_mutasi?>');
	dataset.append('dokumen_pindah', dokumen_pindah);
	$.ajax({
		url: '<?=base_url('mahasiswa/simpan_dokumen_pindah')?>', 
		type: 'POST',
		data: dataset,
		contentType: false,
		processData: false,
		success : function( data ) {
		    //console.log(data)
			if(data==1){
			    Toastify({ text: "Berhasil", style: { background: "<?=$_ENV['CLR_SUC']?>",	} }).showToast();
			}else{
				Toastify({ text: "Gagal", style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
			}
			setTimeout(function () { window.location.reload();}, 1000);
		}
	})
}

function proses_ajuan(status_ajuan)
{
    var x = confirm('Yakin akan diproses? Pastikan semua data sudah Valid!')
    if(x)
    {
        var dataset = new FormData();
        dataset.append('id_mutasi', '<?=$mahasiswa_mutasi->id_mutasi?>');
        dataset.append('isi', status_ajuan);
	    dataset.append('komponen', 'status_mutasi');
    	
    	fetch('<?= base_url('mahasiswa/update_mutasi/') ?>', {
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
/*
function validasi(validasi_ajuan)
{
    var x = confirm('Yakin akan diproses? Pastikan semua data sudah Valid!')
    if(x)
    {
        var dataset = new FormData();
        dataset.append('id_mutasi', '<?=$mahasiswa_mutasi->id_mutasi?>');
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
	dataset.append('id_mutasi', '<?=$mahasiswa_mutasi->id_mutasi?>');
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
*/
function update_mutasi(komponen)
{
	var dataset = new FormData();
	var isi = document.getElementById(komponen).value;
	dataset.append('id_mutasi', '<?=$mahasiswa_mutasi->id_mutasi?>');
	dataset.append('isi', isi);
	dataset.append('komponen', komponen);
	
	fetch('<?= base_url('mahasiswa/update_mutasi/') ?>', {
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
	}).catch( err => {
		console.warn(err)
	})
}
/*
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
*/
</script>