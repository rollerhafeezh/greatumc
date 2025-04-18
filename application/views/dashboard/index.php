<?php 
$dat = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
$date=$dat->format('H');
if($date < 10) 
  $greeting="صَبَاحُ الْخَيْر"; 
else if($date < 14) 
  $greeting="نَهَارُكَ سَعِيْد";
else if($date<18)
  $greeting="مَسَاءُ الْخَيْرِ"; 
else 
  $greeting="لَيْلَتُكَ سَعِيْدَة"; 

?>
<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
			<div class="col-md-6 mb-2">
			    <div class="card">
                    <h5 class="card-header">Hai, <?=$_SESSION['nama_pengguna']?></h5>
                    <div class="card-body overflow-scroll scrollable-content" style="height: 300px;">
                        <div class="clearfix">
                        	<?php if ($_SESSION['id_level'] == '96'): ?>
                        	<pre>
	                        	<?php
	                        		print_r($_SESSION);
	                        	?>
                        	</pre>
                        	<?php endif; ?>

                            <?php
                            if($_SESSION['app_level']==1) { 
                                echo'<p>Jadwal Kuliah Hari ini: </p>';
    			                $angka_hari = date("N");
    			                $kelas = $this->Dhmd_model->kelas_kuliah_mahasiswa($_SESSION['id_user'],$_SESSION['active_smt'])->result();
    			                if($kelas)
        						{
        							foreach($kelas as $key=>$value){ 
        								if($value->hari_kuliah==$angka_hari)
        								{
        									echo '<h4 class="mt-2"><a href="'.base_url('dhmd/daftar_pertemuan/'.$value->id_kelas_kuliah).'" class="text-decoration-none">'.$value->nm_mk.' '.$value->nm_kls.'</a></h4>';
        									echo 'G.'.$value->nama_gedung.' R.'.$value->nama_ruangan.'<br>';
        									echo $value->jam_mulai.' s/d '.$value->jam_selesai;
        								}
    							    }
    						    }else{ echo '<em class="text-muted">tidak ada</em>'; }
                            }
                            
                            if($_SESSION['app_level']==2) { 
                                echo'<p>Jadwal Kuliah Hari ini: </p>';
    			                $angka_hari = date("N");
    			                $kelas = $this->Dhmd_model->kelas_kuliah_dosen($_SESSION['username'],$_SESSION['active_smt'])->result();
    			                if($kelas)
        						{
        							foreach($kelas as $key=>$value){ 
        								if($value->hari_kuliah==$angka_hari)
        								{
        									echo '<h4 class="mt-2"><a href="'.base_url('dhmd/daftar_pertemuan/'.$value->id_kelas_kuliah).'" class="text-decoration-none">'.$value->nm_mk.' '.$value->nm_kls.'</a></h4>';
        									echo 'G.'.$value->nama_gedung.' R.'.$value->nama_ruangan.'<br>';
        									echo $value->jam_mulai.' s/d '.$value->jam_selesai;
        								}
    							    }
    						    }else{ echo '<em class="text-muted">tidak ada</em>'; }
                            }
                            ?>
                        </div>
                    </div>
                </div>
			</div>
			<div class="col-md-6 mb-2">
			    <div class="card">
                    <h5 class="card-header"><a href="<?=base_url('berita')?>" class="text-decoration-none">Berita Terbaru : </a></h5>
                    <div class="card-body overflow-scroll scrollable-content" style="height: 300px;">
                        <div class="clearfix">
                            <?php $this->load->view('berita/daftar'); ?>
                        </div>
                    </div>
                </div>
			</div>
			<?php if($_SESSION['app_level']==1) { ?>
			<div class="col-md-6 mb-2">
			    <div class="card">
                    <h5 class="card-header">Status Kamu Semester ini :</h5>
                    <?php $this->load->view('dashboard/status'); ?>
                </div>
			</div>
			<?php } ?>
		</div>
		<?php if($_SESSION['app_level']==3) { ?>
		<div class="row">
			<div class="col-md-12 mb-2">
			    <div class="card">
                    <h5 class="card-header">Ringkasan Umum :</h5>
                    <?php $this->load->view('dashboard/grafik'); ?>
                </div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>