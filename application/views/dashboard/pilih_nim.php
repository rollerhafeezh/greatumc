<div class="content__boxed">
	<div class="content__wrap">
		<div class="row justify-content-center">
		    <?php
		        foreach($mahasiswa_pt->result() as $key=>$value){ 
		    ?>
		    <div class="col-md-4 mb-4">
		        <div class="card h-100">
					<div class="card-body d-flex flex-column">
						<div class="card-title">
							<!-- Profile picture and short information -->
                            <div class="text-center position-relative">
                                <div class="pt-2 pb-3">
                                    <img class="img-lg rounded-circle" src="<?=$_SESSION['picture']?>" alt="Profile Picture" loading="lazy">
                                </div>
                                <div class="h3"><?=$value->id_mahasiswa_pt?></div>
                                <p class="h4"><?=$value->nama_fak?></p>
                                <p class="h5"><?=strtoupper($value->nama_prodi)?></p>
                            </div>
                            
                            <!-- END : Profile picture and short information -->
						</div>
					</div>
					<div class="card-footer">
					    <div class="d-flex justify-content-center gap-2">
                            <a href="<?=base_url('dashboard/logon_dd/'.$value->id_mahasiswa_pt)?>" class="btn btn-info text-decoration-none">Pilih</a>
                        </div>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>