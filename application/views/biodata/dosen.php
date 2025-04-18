<div class="content__boxed">
	<div class="content__wrap">
		
		<div class="row">
			<div class="col mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
					
<div class="card-header toolbar">
	<div class="toolbar-start">
		<h5 class="m-0"></h5>
	</div>
	<div class="toolbar-end">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs card-header-tabs" role="tablist">
			<li class="nav-item" role="presentation">
				<button class="nav-link active" data-bs-toggle="tab" data-bs-target="#_dm-cardTabsHome" type="button" role="tab" aria-controls="home" aria-selected="true">Akademik</button>
			</li>
			<li class="nav-item" role="presentation">
				<button class="nav-link" data-bs-toggle="tab" data-bs-target="#_dm-cardTabsProfile" type="button" role="tab" aria-controls="profile" aria-selected="false">Data Diri</button>
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
    				<a href="<?= base_url('perwalian/tabel_mahasiswa/'.$dosen->id_dosen) ?>" class="btn btn-sm btn-danger" >Mahasiswa Perwalian</a>
    			</div>	
    		</div>
    		<div class="col-md-4">
    			<div class="mb-2 d-grid gap-2">
    				<a href="<?= base_url('dhmd/arsip_kelas_kuliah_dosen/'.$dosen->nidn) ?>" class="btn btn-sm btn-success" >Kelas Kuliah</a>
    			</div>	
    		</div>
    		<!--<div class="col-md-4">
    			<div class="mb-2 d-grid gap-2">
    				<a href="<?= base_url('dhmd/transkrip/'.$mahasiswa_pt->id_mahasiswa_pt) ?>" class="btn btn-sm btn-info" >Transkrip</a>
    			</div>	
    		</div>-->
    	</div>
	</div>
	<div id="_dm-cardTabsProfile" class="tab-pane fade" role="tabpanel" aria-labelledby="profile-tab">
		<em class="text-muted text-danger">disclaimer : berikut ini adalah data yang terekam dalam sistem, jika ditemukan ketidaksesuaian dengan data asli, silahkan konfirmasi kepada pihak akademik</em>
		<div class="row mt-2">
		<?php
			foreach($dosen as $key=>$value)
			{
			    if($key=='email'){
			        if($_SESSION['app_level']==3 ||$_SESSION['app_level']==4){
			        echo'
    					<div class="col-md-4 mt-1"><strong>Email</strong></div>
    					<div class="col-md-8 mt-1">
                            <div class="input-group mb-3">
                                <input type="email" id="email_dosen" name="email" value="'.$value.'" class="form-control">
    					        <button class="btn btn-info" onclick="simpan_email(`'.$dosen->nidn.'`)" type="button" id="button-addon2">Simpan</button>
                            </div>
    					</div>';
			        }else{
			            echo'
    					<div class="col-md-4 mt-1"><strong>Email</strong></div>
    					<div class="col-md-8 mt-1">'.$value.'</div>';
			        }
			    }else if($key=='no_hp'){
			        if($_SESSION['app_level']==3 ||$_SESSION['app_level']==4){
			        echo'
    					<div class="col-md-4 mt-1"><strong>Handphone</strong></div>
    					<div class="col-md-8 mt-1">
                            <div class="input-group mb-3">
                                <input type="text" id="no_hp_dosen" name="no_hp" value="'.$value.'" class="form-control">
    					        <button class="btn btn-info" onclick="simpan_hp(`'.$dosen->nidn.'`)" type="button" id="button-addon2">Simpan</button>
                            </div>
    					</div>';
			        }else{
			            echo'
    					<div class="col-md-4 mt-1"><strong>Handphone</strong></div>
    					<div class="col-md-8 mt-1">'.$value.'</div>';
			        }
			    }else{
    				if($value){
    				    if($key=='nm_sdm'){
    					echo'
        					<div class="col-md-4 mt-1"><strong>Nama Lengkap</strong></div>
        					<div class="col-md-8 mt-1">'.$value.'</div>';
    				    }
    				    if($key=='nidn'){
    					echo'
        					<div class="col-md-4 mt-1"><strong>NIDN</strong></div>
        					<div class="col-md-8 mt-1">'.$value.'</div>';
    				    }
    				    if($key=='jk'){
    					echo'
        					<div class="col-md-4 mt-1"><strong>Jenis Kelamin</strong></div>
        					<div class="col-md-8 mt-1">'.$value.'</div>';
    				    }
    				    if($key=='tmp_lahir'){
    					echo'
        					<div class="col-md-4 mt-1"><strong>Tempat Lahir</strong></div>
        					<div class="col-md-8 mt-1">'.$value.'</div>';
    				    }
    				    if($key=='tgl_lahir'){
    					echo'
        					<div class="col-md-4 mt-1"><strong>Tanggal Lahir</strong></div>
        					<div class="col-md-8 mt-1">'.format_indo($value).'</div>';
    				    }
    				}
			    }
			}
		?>
		</div>
	</div>
	<div id="_dm-cardTabsContact" class="tab-pane fade" role="tabpanel" aria-labelledby="contact-tab">
		<h5 class="card-title">Dokumen</h5>
		<div class="row">
			<div class="col-md-4 mt-1">
				<code>your image here.</code>
			</div>
		</div>
	</div>
</div>
					
					</div>
				</div>
			</div>
		</div>
	
	</div>
</div>
<?php 
if($_SESSION['app_level']==3 || $_SESSION['app_level']==4){ ?>
<script>
function simpan_email(nidn)
{
    email = document.getElementById('email_dosen').value
	var data = new FormData()
	data.append('nidn', nidn);
	data.append('email', email);
	
	fetch('<?=base_url('utama/simpan_email_dosen/')?>', {
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
function simpan_hp(nidn)
{
    no_hp = document.getElementById('no_hp_dosen').value
	var data = new FormData()
	data.append('nidn', nidn);
	data.append('no_hp', no_hp);
	
	fetch('<?=base_url('utama/simpan_no_hp_dosen/')?>', {
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
</script>
<?php } ?>