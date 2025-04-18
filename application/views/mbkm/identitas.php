<div class="col-md-4">
    <section id="boxed-layout-tips" class="card mb-2">
        <div class="card-body">
            <h5 class="card-title"><i class="psi-male-2 me-1" style="margin-top: -3px;"></i> Identitas Mahasiswa</h5>
            <table class="w-100">
                <tr>
                    <td class="text-nowrap" width="130px">NIM</td>
                    <td width="1">: </td>
                    <td data-toggle="tooltip" title="<?= $anggota->id_mhs ?>"><?= $anggota->id_mahasiswa_pt ?></td>
                </tr>
                <tr>
                    <td valign="top">Nama Lengkap</td>
                    <td valign="top">: </td>
                    <td><?= ucwords(strtolower($anggota->nm_pd)) ?></td>
                </tr>
                <tr>
                    <td valign="top">No. Handphone</td>
                    <td valign="top">: </td>
                    <td><?= $anggota->no_hp ? '<a href="tel:+62'.$anggota->no_hp.'">+62'.$anggota->no_hp.'</a>' : '-' ?></td>
                </tr>
                <tr>
                    <td valign="top">Email</td>
                    <td valign="top">: </td>
                    <td><?= '<a href="mailto:'.$anggota->email.'">'.$anggota->email.'</a>' ?: '-' ?></td>
                </tr>
                <tr>
                    <td valign="top">Fakultas</td>
                    <td valign="top">: </td>
                    <td><?= ucwords(strtolower($anggota->nama_fak)) ?></td>
                </tr>
                <tr>
                    <td valign="top">Program Studi</td>
                    <td valign="top">: </td>
                    <td><?= $anggota->nm_jenj_didik ?> - <?= $anggota->nama_prodi ?></td>
                </tr>
            </table>
        </div>
    </section>

    <section id="boxed-layout-tips" class="card mb-2">
        <div class="card-body">
            <h5 class="card-title"><i class="psi-information me-1" style="margin-top: -3px;"></i> Identitas Kegiatan</h5>
            <table class="w-100">
                <tr>
                    <td class="text-nowrap" valign="top">Judul Kegiatan</td>
                    <td valign="top">: </td>
                    <td>
                        <?= strip_tags($aktivitas->judul) ?>
                    </td>
                </tr>
                <tr>
                    <td class="text-nowrap" width="130px" valign="top">Skema Program</td>
                    <td width="1" valign="top">: </td>
                    <td><?= $aktivitas->nama_jenis_aktivitas_mahasiswa ?> <?= $aktivitas->nama_program ?> (<?= ($aktivitas->jenis_program == 1 ? 'Mandiri' : 'Kementrian') ?>)</td>
                </tr> 
                <tr>
                    <td class="text-nowrap" valign="top">Program Studi</td>
                    <td width="1" valign="top">: </td>
                    <td><?= $aktivitas->nama_prodi ?></td>
                </tr> 
                <tr>
                    <td>Tahun Akademik</td>
                    <td>: </td>
                    <td>
                        <?= $aktivitas->nama_semester ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top">Tgl. Pelaksanaan</td>
                    <td valign="top">: </td>
                    <td>
                        <?= tanggal_indo($aktivitas->tgl_mulai) ?> s.d <?= tanggal_indo($aktivitas->tgl_selesai) ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top">Lokasi Kegiatan</td>
                    <td valign="top">: </td>
                    <td>
                        <a href="<?= $aktivitas->tautan ?>" target="_blank"><?= strip_tags($aktivitas->lokasi) ?></a>
                    </td>
                </tr>
                <tr>
                    <td valign="top">Alamat</td>
                    <td valign="top">: </td>
                    <td>
                        <?= strip_tags($aktivitas->alamat) ?>
                    </td>
                </tr>

                <?php if ($koordinator->num_rows() > 0): ?>
                <tr>
                    <td valign="top">Koordinator</td>
                    <td valign="top">: </td>
                    <td>
                        <?= ucwords(strtolower($koordinator->row()->nm_sdm)) ?> (<?= $koordinator->row()->nidn ?>)
                    </td>
                </tr>
                <?php endif; ?>

                <?php if ($pembimbing->num_rows() > 0): ?>
                <tr>
                    <td valign="top">Pembimbing</td>
                    <td valign="top">: </td>
                    <td>
                        <?= ucwords(strtolower($pembimbing->row()->nm_sdm)) ?> (<?= $pembimbing->row()->nidn ?>)
                    </td>
                </tr>
                <?php endif; ?>
            </table>

        </div>
    </section>

    <section id="boxed-layout-tips" class="card mb-2">
        <div class="card-body">
            <h5 class="card-title"><i class="psi-notepad me-1" style="margin-top: -3px;"></i> Penilaian Mahasiswa</h5>
            <a href="<?= base_url('mbkm/konversi/'.sha1($anggota->id_aktivitas).'/'.$anggota->id_mahasiswa_pt) ?>" class="btn btn-info w-100 mt-2">Konversi Nilai</a>
        </div>
    </section>

    <?php if (false): ?>
    <section id="boxed-layout-tips" class="card mb-2">
        <div class="card-body">
            <h5 class="card-title"><i class="psi-business-man me-1" style="margin-top: -3px;"></i> Dosen Pembimbing Lapangan (DPL)</h5>
            <table class="w-100">
                <?php foreach($pembimbing->result() as $pembimbing): ?>
                <tr>
                    <td class="text-nowrap" width="130px" valign="top">NIDN</td>
                    <td width="1" valign="top">: </td>
                    <td><?= $pembimbing->nidn ?></td>
                </tr> 
                <tr>
                    <td class="text-nowrap" valign="top">Nama Dosen</td>
                    <td valign="top">: </td>
                    <td>
                        <?= $pembimbing->nm_sdm ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top">No. Handphone</td>
                    <td valign="top">: </td>
                    <td><?= $pembimbing->no_hp ? '<a href="tel:+62'.$pembimbing->no_hp.'">+62'.$pembimbing->no_hp.'</a>' : '-' ?></td>
                </tr>
                <?php endforeach; ?>
            </table>

        </div>
    </section>
    <?php endif; ?>
</div>