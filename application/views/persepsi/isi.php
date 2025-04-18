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
							<div class="col-md-4 mt-1"><strong>ID Responden</strong></div>
							<div class="col-md-8 mt-1"><h2><?=$detail->id_responden?><h2></div>
							<div class="col-md-12 mt-1">
							    <h4>PENTING:</h4>
							    <p>Survey ini bersifat anonim, sehingga kamu bebas mengutarakan/ mengisi survey ini sesuai dengan yang kamu rasakan ketika menempuh kelas kuliah</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		<div class="row justify-content-center">
			<div class="col-md-6 mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
						    <div class="h5">Instrumen Persepsi</div>
						    <?php
                            $respon = $this->Persepsi_model->get_respon($detail->id_responden)->result();
                            $respon_text = $this->Persepsi_model->get_respon_text($detail->id_responden)->row();
                            if ($respon) {
                                echo '<h4>Kamu sudah memberikan Respon untuk Kelas Kuliah ini. Dengan Detail :</h4>';
                                $i = 1;
                            
                                foreach ($respon as $key => $value) {
                                    echo 'Pertanyaan #' . $i . '. ' . $value->nilai . '<br>';
                                    $i++;
                                }
                                if ($respon_text) {
                                    echo '<p>Kritik dan Saran : ' . $respon_text->pesan_moral . '</p>';
                                }
                                echo '<a href="' . base_url('persepsi/ulangi/' . $detail->id_responden) . '" class="btn btn-danger" onclick="return confirm(`Yakin akan Mengulangi Isian Persepsi?`)"><i class="psi-trash"></i> Ulangi Lagi!</a>';
                            } else {
                            ?>
							<form method="POST" action="<?= base_url('persepsi/simpan/'.$detail->id_responden) ?>">
							<?php 
							$pertanyaan = $this->Persepsi_model->get_pertanyaan($detail->id_instrumen,null,1)->result();
							if($pertanyaan){
							foreach ($pertanyaan as $value) { 
            					$skala_min = '';
            					$skala_maks = '';
            					if($value->skala_min)
            					{
            						$skala_min=$value->skala_min;
            					}
            					
            					if($value->skala_maks)
            					{
            						$skala_maks=$value->skala_maks;
            					}
            				?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <small><em><?= $value->variabel; ?></em></small>
                                    </div>
                                    <div class="col-md-12 mb-1">
                                        <strong><?= $value->text_pertanyaan; ?></strong>
                                    </div>
                                    <div class="col-3 text-bold-700 text-right">
                                       <em><?= $skala_min; ?></em>
                                    </div>
                                    <div class="col-6 text-center">
                                        <?php for ($i = 1; $i <= $value->jml_skala; $i++) { ?>
                                            <input type="radio" name="<?= $value->id_pertanyaan; ?>" value="<?= $i; ?>" <?= ($i == 1) ? 'required' : '' ?>>
                                        <?php } ?>
                                    </div>
                                    <div class="col-3 text-bold-700">
                                        <em><?php echo $skala_maks; ?></em>
                                    </div>
                                </div>
                                <hr>
                            <?php } } ?>
                        <div class="row my-1">
                            <div class="col-md-12 h2">
                                <textarea rows="5" name="pesan_moral" class="form-control" placeholder="Kritik dan Saran Membangun" required></textarea>
                            </div>
                        </div>
                        <button class="btn btn-lg btn-info" type="submit">Selesai</button>
                    </form>
                <div class="my-2">
                    <!--<em>Sumber ; BUKU PEDOMAN SERTIFIKASI PENDIDIK UNTUK DOSEN (SERDOS) TERINTEGRASI BUKU 2 PENILAIAN PORTOFOLIO. DIREKTORAT JENDERAL SUMBER DAYA ILMU PENGETAHUAN, TEKNOLOGI DAN PENDIDIKAN TINGGI KEMENTERIANRISET, TEKNOLOGI DAN PENDIDIKAN TINGGI. (2019) Hal. 20-21</em>-->
                </div>
                <?php } ?>
					</div>	
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<script>
        /*
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
        */
    </script>
