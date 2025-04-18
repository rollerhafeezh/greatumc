<div class="content__boxed">
	<div class="content__wrap">
		<div class="row justify-content-center">
		
			<div class="col-md-6 mb-3">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
						<div class="card-title">
							<h5>Detail Kelas</h5>
						</div>
						<div class="row">
							<div class="col-md-4 mt-1"><strong>Semester</strong></div>
							<div class="col-md-8 mt-1"><?=nama_smt($kelas->id_smt)?></div>
							<div class="col-md-4 mt-1"><strong>Fakultas/ Prodi</strong></div>
							<div class="col-md-8 mt-1"><?=$kelas->nama_fak?> <?=$kelas->nama_prodi?></div>
							<div class="col-md-4 mt-1"><strong>Kelas</strong></div>
							<div class="col-md-8 mt-1"><?=$kelas->nm_mk?> <?=$kelas->nm_kls?></div>
							<div class="col-md-4 mt-1"><strong>Dosen Pengampu</strong></div>
							<div class="col-md-8 mt-1">
								<?php
									$pengampu=$this->Main_model->pengampu_kelas($kelas->id_kelas_kuliah)->result();
									if($pengampu)
									{
										
										foreach($pengampu as $keys=>$values)
										{
											echo'<strong>'.$values->nidn.'</strong> '.$values->nm_sdm.' ('.$values->sks_subst_tot.' SKS)<br>';
										}
										
									}else{ echo '-'; }
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-6 mb-3">
				<div class="card bg-danger text-white text-center h-100">
                    <div class="p-2 text-center">
                        <i class="psi-speech-bubble-3 text-white text-opacity-50 display-3 my-4"></i>
                        <div class="display-4"><?=$kelas->skor_persepsi?></div>
                        <p>Skor Persepsi</p>
                        <small class="lh-1">/100</small>
                    </div>
                </div>
			</div>
			<div class="col-md-12 mb-3">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
						<div class="card-title">
							<h5>Persepsi Teks</h5>
						</div>
        				<div class="timeline">
        				    <?php 
        				    $respon_text = $this->Persepsi_model->get_respon_text(null,$kelas->id_kelas_kuliah)->result();
        				    if($respon_text){
        				        foreach($respon_text as $key=>$value)
        				        { ?>
        				    <div class="tl-entry">
                                <div class="tl-point"></div>
                                <div class="tl-content card">
                                    <div class="card-body">
                                    <?=$value->pesan_moral?>
                                    </div>
                                </div>
                            </div>    
        				    <?php }
        				    }else{
        				    ?>
                            <div class="tl-entry">
                                <div class="tl-point"></div>
                                <div class="tl-content card">
                                    <div class="card-body">
                                        .......
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
				    </div>
				</div>
			</div>
			<div class="col-md-12 mb-3">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
						<div class="card-title">
							<h5>Rekapitulasi</h5>
						</div>
        				<?php
                        $jml_pertanyaan = count($distinct_pertanyaan);
                        //var_dump($responden);
                        if (!empty($responden)) {
                        ?>
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered" width="100%">
                
                                <thead>
                                    <tr>
                                        <th rowspan="2">ID Responden</th>
                                        <th colspan="<?= $jml_pertanyaan ?>" class="text-center">No Urut Pertanyaan</th>
                                        <th rowspan="2">Rata-rata</th>
                                    </tr>
                                    <tr>
                                        <?php
                
                                        for ($i = 0; $i < $jml_pertanyaan; $i++) { ?>
                                            <th><?php echo 'Q' . '(' . $distinct_pertanyaan[$i]->id_pertanyaan . ')'; ?></th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($responden as $key) {
                                    ?>
                                        <tr>
                                            <td><?= $key->id_responden; ?></td>
                                            <?php
                                            $co = 1;
                                            $jml_nilai = 0;
                                            for ($i = 0; $i < $jml_pertanyaan; $i++) { ?>
                                                <td><?php
                                                    $nilai = $this->Persepsi_model->get_survey($kelas->id_kelas_kuliah, $distinct_pertanyaan[$i]->id_pertanyaan, $key->id_responden);
                                                    $nilai = ($nilai) ? $nilai[0]->nilai : 0;
                                                    $jml_nilai += $nilai;
                                                    echo $nilai; ?></td>
                                            <?php $co++;
                                            } ?>
                                            <td class="text-center"><?php echo number_format($jml_nilai / $jml_pertanyaan, 2, ',', '.'); ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                
                            </table>
                        </div>
                        <?php } else {
                            echo '<h5>Tidak ada data</h5>';
                        } ?>
				    </div>
				</div>
			</div>
	    </div>
    </div>
</div>
<script>
        window.addEventListener("load", () => {
            var orientation = (screen.orientation || {}).type || screen.mozOrientation || screen.msOrientation;

            if (orientation === "landscape-primary") {
                console.log("That looks good.");
            } else if (orientation === "landscape-secondary") {
                console.log("Mmmh... the screen is upside down!");
            } else if (orientation === "portrait-secondary" || orientation === "portrait-primary") {
                alert('Gunakan Handphone secara Mendatar (landscape mode) untuk dapat mengakses Halaman ini. Kemudian Refresh Halaman.')
            } else if (orientation === undefined) {
                alert('Mohon maaf Browser ini tidak menampilkan Survey. Silahkan Gunakan Browser Lain.')
            }
        });
    </script>
