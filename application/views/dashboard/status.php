<div class="card-body text-center">
    <?php
    $status = $this->Dhmd_model->get_kuliah_mahasiswa()->row();
    if($status){ ?>
    <div class="d-flex align-items-center">
        <div class="flex-shrink-0 p-3">
            <div class="h3 display-3">#<?=$status->smt_mhs?></div>
            <span class="h6">Semester</span>
        </div>
        <div class="flex-grow-1 text-center ms-3">
            <h2 class="text-muted">Status Kuliah Kamu <strong><?=$status->nama_status_mahasiswa?></strong></2>
            <!-- Social media statistics -->
            <div class="mt-4 pt-3 d-flex justify-content-around border-top">
                <div class="text-center">
                    <!--<h4 class="mb-1"><?=$status->ips?></h4>-->
                    <h4 class="mb-1">Soon</h4>
                    <small class="text-muted">IP Semester</small>
                </div>
                <div class="text-center">
                    <h4 class="mb-1"><?=$status->sks_smt?></h4>
                    <small class="text-muted">SKS Semester</small>
                </div>
                <div class="text-center">
                    <!--<h4 class="mb-1"><?=$status->ipk?></h4>-->
                    <h4 class="mb-1">Soon</h4>
                    <small class="text-muted">IPK</small>
                </div>
                <div class="text-center">
                    <!--<h4 class="mb-1"><?=$status->sks_total?></h4>-->
                    <h4 class="mb-1">Soon</h4>
                    <small class="text-muted">SKS Total</small>
                </div>
            </div>
            <!-- END : Social media statistics -->
        </div>
    </div>
    <a href="<?=base_url('cetak/kartu/uts/'.$_SESSION['active_smt'].'/'.$_SESSION['id_user'])?>" class="text-decoration-none btn btn-light" target="_blank"><i class="psi-printer"></i> CETAK KARTU UTS</a>
    <a href="<?=base_url('cetak/kartu/uas/'.$_SESSION['active_smt'].'/'.$_SESSION['id_user'])?>" class="text-decoration-none btn btn-light" target="_blank"><i class="psi-printer"></i> CETAK KARTU UAS</a>
    <?php } ?>
</div>