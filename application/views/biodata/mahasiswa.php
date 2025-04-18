<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">

			<div class="col mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
						
<div class="card-header toolbar">
	<div class="toolbar-start">
		<h5 class="m-0"><?=$mahasiswa_pt->id_mahasiswa_pt?></h5>
	</div>
	<div class="toolbar-end">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs card-header-tabs" role="tablist">
			<li class="nav-item" role="presentation">
				<button class="nav-link active" data-bs-toggle="tab" data-bs-target="#_dm-cardTabsHome" type="button" role="tab" aria-controls="home" aria-selected="true">Akademik</button>
			</li>
			<li class="nav-item" role="presentation">
				<button class="nav-link" data-bs-toggle="tab" data-bs-target="#_dm-cardTabsProfile" type="button" role="tab" aria-controls="profile" aria-selected="false">
					Data Diri
					<a href="<?= base_url('biodata/edit') ?>" class="badge bg-info ms-2 text-white text-decoration-none">Edit Data</a>
				</button>
			</li>
			<li class="nav-item" role="presentation">
				<button class="nav-link" data-bs-toggle="tab" data-bs-target="#_dm-cardTabsContact" type="button" role="tab" aria-controls="contact" aria-selected="false">Dokumen</button>
			</li>
		</ul>
	</div>
</div>
<div class="card-body tab-content">
	<div id="_dm-cardTabsHome" class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab">
		<div class="row">
			<div class="col-md-4">
				<div class="mb-2 d-grid gap-2">
					<a href="<?= base_url('krs/riwayat_ajar/'.$mahasiswa_pt->id_mahasiswa_pt) ?>" class="btn btn-sm btn-danger" >Riwayat Ajar</a>
				</div>	
			</div>
			<div class="col-md-4">
				<div class="mb-2 d-grid gap-2">
					<a href="<?= base_url('krs/add/'.$_SESSION['active_smt'].'/'.$mahasiswa_pt->id_mahasiswa_pt) ?>" class="btn btn-sm btn-success" >KRS</a>
				</div>	
			</div>
			<div class="col-md-4">
				<div class="mb-2 d-grid gap-2">
					<a href="<?= base_url('krs/transkrip/'.$mahasiswa_pt->id_mahasiswa_pt) ?>" class="btn btn-sm btn-info" >Transkrip</a>
				</div>	
			</div>
		</div>
		<div class="row">
			<div class="col-md-4 mt-1"><strong>NIM</strong></div>
			<div class="col-md-8 mt-1"><?=$mahasiswa_pt->id_mahasiswa_pt?></div>
			<div class="col-md-4 mt-1"><strong>Nama Mahasiswa</strong></div>
			<div class="col-md-8 mt-1"><?=$mahasiswa_pt->nm_pd?></div>
			<div class="col-md-4 mt-1"><strong>Homebase</strong></div>
			<div class="col-md-8 mt-1"><?=$mahasiswa_pt->inisial_fak?> <?=$mahasiswa_pt->nama_prodi?> <?=$mahasiswa_pt->nm_jenj_didik?></div>
			<div class="col-md-4 mt-1"><strong>Dosen Wali</strong></div>
			<div class="col-md-8 mt-1"><?=$mahasiswa_pt->nm_sdm?> 
			<?php if($_SESSION['app_level']==4 || $_SESSION['app_level']==3){ ?>
			<a class="text-decoration-none" href="<?= base_url('mahasiswa/dosen_wali/'.$mahasiswa_pt->id_mahasiswa_pt) ?>"> <i class="psi-edit"></i> </a>
			<?php } ?>
			</div>
			<div class="col-md-4 mt-1"><strong>Semester diterima/ Tahun Akademik</strong></div>
			<div class="col-md-8 mt-1">
			    <?php if($mahasiswa_pt->diterima_smt && $mahasiswa_pt->mulai_smt){ ?>
			    <?=$mahasiswa_pt->diterima_smt?> / <?=nama_smt($mahasiswa_pt->mulai_smt)?>
			    <?php }else{
			        echo '<strong>Hubungi Akademik!</strong>';
			    } ?>
			</div>
			<div class="col-md-4 mt-1"><strong>Status</strong></div>
			<?php
			$keluar = ($mahasiswa_pt->id_jns_keluar)?jenis_keluar($mahasiswa_pt->id_jns_keluar):'Aktif';
			?>
			<div class="col-md-8 mt-1"><?=$keluar?></div>
			<div class="col-md-4 mt-1"><strong>Kelas</strong></div>
			<?php
			$kelas = ($mahasiswa_pt->kelas_mhs == 1)?'Reguler':'Non Reguler';
			?>			
			<div class="col-md-8 mt-1"><?=$kelas?></div>
		</div>
		<div class="row mt-3">
		<?php if($_SESSION['app_level']==3) { ?>
			<div class="col-md-4">
				<div class="mb-2 d-grid gap-2">
					<a href="<?= base_url('mahasiswa/keluar/'.$mahasiswa_pt->id_mahasiswa_pt) ?>" class="btn btn-sm btn-danger" >Keluar</a>
				</div>	
			</div>
			<div class="col-md-4">
				<div class="mb-2 d-grid gap-2">
					<a href="<?= base_url('nilai/konversi/'.$mahasiswa_pt->id_mahasiswa_pt) ?>" class="btn btn-sm btn-success" >Konversi Kurikulum</a>
				</div>	
			</div>
			<div class="col-md-4">
				<div class="mb-2 d-grid gap-2">
					<a href="<?= base_url('nilai/manual/'.$mahasiswa_pt->id_mahasiswa_pt) ?>" class="btn btn-sm btn-info" >Nilai Konversi</a>
				</div>	
			</div>
		<?php } ?>
		</div>
	</div>
	<div id="_dm-cardTabsProfile" class="tab-pane fade" role="tabpanel" aria-labelledby="profile-tab">
	    <em class="text-muted">disclaimer : berikut ini adalah data yang terekam dalam sistem, jika ditemukan ketidaksesuaian dengan data asli, silahkan konfirmasi kepada pihak akademik</em>
		<div class="row mt-2">
		<?php
			foreach($mahasiswa_pt as $key=>$value)
			{
			    if($key=='id_mhs')
			    {
			        if($value){
    					echo'
    					<div class="col-md-4 mt-1"><strong>'.str_replace('_',' ',$key).'</strong></div>
    					<div class="col-md-8 mt-1">'.$value.'</div>';
    				}
			    }else if($key=='nm_pd')
			    {
			        if($value){
    					echo'
    					<div class="col-md-4 mt-1"><strong>'.str_replace('_',' ',$key).'</strong></div>
    					<div class="col-md-8 mt-1">'.$value.'</div>';
    				}
			    }else if($key=='id_mahasiswa_pt')
			    {
			        if($value){
    					echo'
    					<div class="col-md-4 mt-1"><strong>'.str_replace('_',' ',$key).'</strong></div>
    					<div class="col-md-8 mt-1">'.$value.'</div>';
    				}
			    }else if($key=='nm_sdm')
			    {
			        if($value){
    					echo'
    					<div class="col-md-4 mt-1"><strong>'.str_replace('_',' ',$key).'</strong></div>
    					<div class="col-md-8 mt-1">'.$value.'</div>';
    				}
			    }else if($key=='nidn')
			    {
			        if($value){
    					echo'
    					<div class="col-md-4 mt-1"><strong>'.str_replace('_',' ',$key).'</strong></div>
    					<div class="col-md-8 mt-1">'.$value.'</div>';
    				}
			    }else if($key=='nama_fak')
			    {
			        if($value){
    					echo'
    					<div class="col-md-4 mt-1"><strong>'.str_replace('_',' ',$key).'</strong></div>
    					<div class="col-md-8 mt-1">'.$value.'</div>';
    				}
			    }else if($key=='nama_prodi')
			    {
			        if($value){
    					echo'
    					<div class="col-md-4 mt-1"><strong>'.str_replace('_',' ',$key).'</strong></div>
    					<div class="col-md-8 mt-1">'.$value.'</div>';
    				}
			    }else if($key=='email'){
			        if($_SESSION['app_level']==3 ||$_SESSION['app_level']==4){
			        echo'
    					<div class="col-md-4 mt-1"><strong>'.str_replace('_',' ',$key).'</strong></div>
    					<div class="col-md-8 mt-1">
                            <div class="input-group mb-3">
                                <input type="email" id="email_mhs" name="email" value="'.$value.'" class="form-control">
    					        <button class="btn btn-info" onclick="simpan_email(`'.$mahasiswa_pt->id_mhs.'`)" type="button" id="button-addon2">Simpan</button>
                            </div>
    					</div>';
			        }else{
			            echo'
    					<div class="col-md-4 mt-1"><strong>'.str_replace('_',' ',$key).'</strong></div>
    					<div class="col-md-8 mt-1">'.$value.'</div>';
			        }
			    }else if($key=='no_hp'){
			        if($_SESSION['app_level']==3 ||$_SESSION['app_level']==4){
			        echo'
    					<div class="col-md-4 mt-1"><strong>'.str_replace('_',' ',$key).'</strong></div>
    					<div class="col-md-8 mt-1">
                            <div class="input-group mb-3">
                                <input type="text" id="no_hp_mhs" name="no_hp" value="'.$value.'" class="form-control">
    					        <button class="btn btn-info" onclick="simpan_hp(`'.$mahasiswa_pt->id_mhs.'`)" type="button" id="button-addon2">Simpan</button>
                            </div>
    					</div>';
			        }else{
			            echo'
    					<div class="col-md-4 mt-1"><strong>'.str_replace('_',' ',$key).'</strong></div>
    					<div class="col-md-8 mt-1">'.$value.'</div>';
			        }
			    }else{
    				
			    }
			}
		?>
		</div>
	</div>
	<div id="_dm-cardTabsContact" class="tab-pane fade" role="tabpanel" aria-labelledby="contact-tab">
		<div class="row">
            <div class="col-md-4 mt-2">
               <div class="card h-100">
                   <div class="card-header">Pas Foto</div>
                   <div class="card-body">
                        <?php
                        $dokumen = $this->Mahasiswa_model->get_dokumen($mahasiswa_pt->id_mhs,'pasfoto');
                        if($dokumen)
                        {
                            $pasfoto = $dokumen->file_mahasiswa;
                        }else{
                            $pasfoto = $_ENV['LOGO_100'];
                        }
                       ?>
                       <img style="max-width: 250px;" id="pasfoto_preview" src="<?=$pasfoto?>" class="mt-3">
                   </div>
                   <div class="card-footer"><input type="file" accept=".jpg,.jpeg,.png" id="pasfoto" name="pasfoto" onchange="unggah_dokumen('pasfoto')"></div>
                </div>
             </div>
             <div class="col-md-4 mt-2">
               <div class="card h-100">
                   <div class="card-header">KTP</div>
                   <div class="card-body">
                        <?php
                        
                        $dokumen = $this->Mahasiswa_model->get_dokumen($mahasiswa_pt->id_mhs,'ktp');
                        if($dokumen)
                        {
                            $ktp = $dokumen->file_mahasiswa;
                        }else{
                            $ktp = $_ENV['LOGO_100'];
                        }
    
                       ?>
                       <img style="max-width: 250px;" id="ktp_preview" src="<?=$ktp?>" class="mt-3">
                   </div>
                   <div class="card-footer"><input type="file" accept=".jpg,.jpeg,.png" id="ktp" name="ktp" onchange="unggah_dokumen('ktp')"></div>
                </div>
             </div>
             <div class="col-md-4 mt-2">
               <div class="card h-100">
                   <div class="card-header">Kartu Keluarga</div>
                   <div class="card-body">
                        <?php
                       
                        $dokumen = $this->Mahasiswa_model->get_dokumen($mahasiswa_pt->id_mhs,'kk');
                        if($dokumen)
                        {
                            $kk = $dokumen->file_mahasiswa;
                        }else{
                            $kk = $_ENV['LOGO_100'];
                        }
    
                       ?>
                       <img style="max-width: 250px;" id="kk_preview" src="<?=$kk?>" class="mt-3">
                   </div>
                   <div class="card-footer"><input type="file" accept=".jpg,.jpeg,.png" id="kk" name="kk" onchange="unggah_dokumen('kk')"></div>
                </div>
             </div>
             <div class="col-md-4 mt-2">
               <div class="card h-100">
                   <div class="card-header">Ijazah Terkahir</div>
                   <div class="card-body">
                        <?php
                       
                        $dokumen = $this->Mahasiswa_model->get_dokumen($mahasiswa_pt->id_mhs,'ijazah');
                        if($dokumen)
                        {
                            $ijazah = $dokumen->file_mahasiswa;
                        }else{
                             $ijazah = $_ENV['LOGO_100'];
                        }
    
                       ?>
                       <img style="max-width: 250px;" id="ijazah_preview" src="<?=$ijazah?>" class="mt-3">
                   </div>
                   <div class="card-footer"><input type="file" accept=".jpg,.jpeg,.png" id="ijazah" name="ijazah" onchange="unggah_dokumen('ijazah')"></div>
                </div>
             </div>
             <div class="col-md-4 mt-2">
               <div class="card h-100">
                   <div class="card-header">Akta Kenal Lahir</div>
                   <div class="card-body">
                        <?php
                        
                        $dokumen = $this->Mahasiswa_model->get_dokumen($mahasiswa_pt->id_mhs,'akta');
                        if($dokumen)
                        {
                            $akta = $dokumen->file_mahasiswa;
                        }else{
                            $akta = $_ENV['LOGO_100'];
                        }
    
                       ?>
                       <img style="max-width: 250px;" id="akta_preview" src="<?=$akta?>" class="mt-3">
                   </div>
                   <div class="card-footer"><input type="file" accept=".jpg,.jpeg,.png" id="akta" name="akta" onchange="unggah_dokumen('akta')"></div>
                </div>
             </div>
			 <div class="col-md-4 mt-2">
               <div class="card h-100">
                   <div class="card-header">NPWP</div>
                   <div class="card-body">
                        <?php
                        
                        $dokumen = $this->Mahasiswa_model->get_dokumen($mahasiswa_pt->id_mhs,'npwp');
                        if($dokumen)
                        {
                            $npwp = $dokumen->file_mahasiswa;
                        }else{
                            $npwp = $_ENV['LOGO_100'];
                        }
    
                       ?>
                       <img style="max-width: 250px;" id="npwp_preview" src="<?=$npwp?>" class="mt-3">
                   </div>
                   <div class="card-footer"><input type="file" accept=".jpg,.jpeg,.png" id="npwp" name="npwp" onchange="unggah_dokumen('npwp')"></div>
                </div>
             </div>
         </div>
         <hr>
         <h4>File PMB</h4>
         <div class="row">
         <?php
            $dok_pmb = $this->Mahasiswa_model->get_dokumen_pmb($mahasiswa_pt->id_mhs);
            if($dok_pmb)
            {				
                foreach($dok_pmb as $key=>$value)
                {
					$path_parts = pathinfo($value->file_calon_mhs);
                    ?>
                    <div class="col-md-4 mt-2">
                       <div class="card h-100">
                           <div class="card-header"><?=strtoupper($value->jenis)?></div>
                           <div class="card-body">
							   <?php if($path_parts['extension']=='pdf') { ?>
								<embed width="100%" height="400" src="<?=$value->link_file?><?=$value->file_calon_mhs?>" class="mt-3"/>
							   <?php } else { ?>
								<img style="max-width: 250px;" src="<?=$value->link_file?><?=$value->file_calon_mhs?>" class="mt-3">
							   <?php } ?>							   
                           </div>
                        </div>
                     </div>
                    <?php
                }
            }
         ?>
         </div>
	</div>
</div>
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
function unggah_dokumen(jenis_dokumen)
	{
		var data = new FormData()
		const dokumen = document.getElementById(jenis_dokumen).files[0] ;
		if(dokumen.size > 15728640) return false;
		
		data.append('id_mhs', '<?=$mahasiswa_pt->id_mhs?>');
		data.append('dokumen', dokumen);
		data.append('jenis_dokumen', jenis_dokumen);
		
		fetch('<?=base_url('mahasiswa/unggah_dokumen/')?>', {
			method: 'POST',
			body: data
		})
		.then((response) => response.text())
		.then((text) => {
			
			if(text==0){
				Toastify({ text: "Gatot!",	style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
			}else{
			    document.getElementById(jenis_dokumen+'_preview').setAttribute('src', text);
				Toastify({ text: "Tersimpan",	style: { background: "<?=$_ENV['CLR_SUC']?>",	} }).showToast();
			}
		})
		.catch(error => {
			console.log(error)
		})  
	}
	
<?php if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){ ?>

function simpan_email(id_mhs)
{
    email = document.getElementById('email_mhs').value
	var data = new FormData()
	data.append('id_mhs', id_mhs);
	data.append('email', email);
	
	fetch('<?=base_url('utama/simpan_email_mhs/')?>', {
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
function simpan_hp(id_mhs)
{
    no_hp = document.getElementById('no_hp_mhs').value
	var data = new FormData()
	data.append('id_mhs', id_mhs);
	data.append('no_hp', no_hp);
	
	fetch('<?=base_url('utama/simpan_no_hp_mhs/')?>', {
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

<?php } ?>
</script>
    
