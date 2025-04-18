<div class="col-md-5">
    <?php if (count($penjadwalan) > 0): ?>
    <section id="boxed-layout-tips" class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Jadwal Seminar / Sidang</h5>
            <table class="w-100">
                <?php $i = 1; $nr_penjadwalan = count($penjadwalan); foreach($penjadwalan as $penjadwalan): ?>
                <tr>
                    <td colspan="3" class="fw-bold"><?= $penjadwalan->deskripsi ?></td>
                </tr>
                <tr>
                    <td class="text-nowrap">Status Kegiatan</td>
                    <td width="1">: </td>
                    <td><?= $penjadwalan->status ? '<span class="text-secondary">Selesai Dilaksanakan</span>' : '<span class="text-primary">Belum Dilaksanakan</span>' ?></td>
                </tr>
                <tr>
                    <td class="text-nowrap">Tempat</td>
                    <td width="1">: </td>
                    <td><?= $penjadwalan->tempat ?></td>
                </tr>
                <tr>
                    <td class="text-nowrap" valign="top">Tgl. Pelaksanaan</td>
                    <td width="1" valign="top">: </td>
                    <td valign="top"><?= format_indo($penjadwalan->tanggal) ?> WIB</td>
                </tr>
                <tr>
                    <td class="text-nowrap" width="130px" valign="top">Ketua Sidang</td>
                    <td width="1" valign="top">: </td>
                    <td valign="top"><?= ucwords(strtolower($penjadwalan->nm_sdm)) ?></td>
                </tr>
                <tr>
                    <td class="text-nowrap" width="130px" valign="top">Dosen Penguji</td>
                    <td width="1" valign="top">: </td>
                    <td valign="top">
                        <ol class="py-0 my-0 ps-3 pe-0">
                        <?php
                        $penguji_ = $this->Aktivitas_model->penguji([ 'p.id_aktivitas' => $penjadwalan->id_aktivitas, 'p.id_kegiatan' => $penjadwalan->id_kegiatan ], 'p.penguji_ke ASC')->result();
                        // print_r($penguji_);
                        foreach ($penguji_ as $penguji_) {
                            echo '<li>'.ucwords(strtolower($penguji_->nm_sdm)).'</li>';
                        }
                        ?>
                        </ol>
                    </td>
                </tr>
                <tr>
                    <td valign="top">Berkas Paparan</td>
                    <td valign="top">: </td>
                    <td valign="top">
                        <?php $berkas_anggota = $this->Aktivitas_model->berkas_anggota([ 'k.id_jenis_aktivitas_mahasiswa' => $aktivitas->id_jenis_aktivitas_mahasiswa, 'kb.id_kat_berkas' => '10', 'bk.id_kegiatan' => $penjadwalan->id_kegiatan ], 'bk.id_kegiatan ASC', $anggota->id_anggota)->result(); ?>
                        <ul class="p-0 m-0 list-unstyled">
                            <?php foreach ($berkas_anggota as $berkas_anggota): ?>
                            <li>
                                <a href="javascript:void(0)" style="<?= $berkas_anggota->berkas ?: 'filter:grayscale(100%)'; ?>" onclick="lihat_berkas(`<?= $berkas_anggota->nama_kategori.' '.$berkas_anggota->deskripsi ?>`, `<?= $berkas_anggota->berkas ?>`, `<?= domain_jitsi($aktivitas->id_jenis_aktivitas_mahasiswa, 'pdfjs', null) ?>`)">
                                    <!-- <img src="<?= base_url('assets/img/pdf.png') ?>" class="ms-1" alt="<?= $berkas_anggota->nama_kategori.' '.$berkas_anggota->deskripsi ?>"> -->
                                    <?= $berkas_anggota->deskripsi ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                         
                    </td>
                </tr>

                <?php if(true): //if (!in_array($jenis_bimbingan, [1, 3]) OR !in_array($penjadwalan->id_kegiatan, [3, 5]) AND $jenis_bimbingan != 3): ?>
                <tr>
                    <td valign="top">Nilai Kegiatan</td>
                    <td valign="top">: </td>
                    <td><a href="javascript:void(0)" onclick="input_nilai(`Atur Nilai <?= $penjadwalan->deskripsi ?>`, `<?= $anggota->id_anggota ?>`, `<?= $penjadwalan->id_penjadwalan ?>`, `<?= $penjadwalan->id_kegiatan ?>`)">Atur Nilai</a></td>
                </tr>
            	<?php endif; ?>
                
                <tr>
                    <td>Berita Acara</td>
                    <td>: </td>
                    <td>
                        <?php $berkas_anggota = $this->Aktivitas_model->berkas_anggota([ 'k.id_jenis_aktivitas_mahasiswa' => $aktivitas->id_jenis_aktivitas_mahasiswa, 'kb.id_kat_berkas' => '4', 'bk.id_kegiatan' => $penjadwalan->id_kegiatan ], 'bk.id_kegiatan ASC', $anggota->id_anggota)->row(); ?>
                        <a  style="<?= $berkas_anggota->berkas != '' ? '' : 'filters:grayscale(100%);' ?>" href="javascript:void(0)" onclick="lihat_berkas(`Berita Acara <?= $berkas_anggota->deskripsi ?>`, `<?= domain_jitsi($aktivitas->id_jenis_aktivitas_mahasiswa, 'pdfjs', null).'/aktivitas/cetak/'.$berkas_anggota->slug_kategori_berkas.'/'.$berkas_anggota->slug_kegiatan.'/'.$penjadwalan->id_penjadwalan.'/'.$anggota->id_mahasiswa_pt.'/'.$aktivitas->id_jenis_aktivitas_mahasiswa ?>`, `<?= domain_jitsi($aktivitas->id_jenis_aktivitas_mahasiswa, 'pdfjs', null) ?>`, <?= $penjadwalan->id_kegiatan == 5 ? $penjadwalan->id_penjadwalan : 'null' ?>)">
                            <!-- <img src="<?= base_url('assets/img/pdf.png') ?>" class="ms-1">  -->
                            Generate Berkas
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Nilai Akhir</td>
                    <td>: </td>
                    <td>
                        <a  style="<?= $berkas_anggota->berkas != '' ? '' : 'filters:grayscale(100%);' ?>" href="javascript:void(0)" onclick="sinkronisasi_nilai(`<?= $anggota->id_anggota ?>`,`<?= $penjadwalan->id_penjadwalan ?>`)">
                            Sinkronisasi Nilai
                        </a>
                    </td>
                </tr>
                <tr style="<?= $i == $nr_penjadwalan ? 'display: none;' : 'height: 20px;' ?>" >
                    <td colspan="3"></td>
                </tr>
                <?php $i++; endforeach; ?>
            </table>
        </div>
    </section>
    <?php endif; ?>

    <section id="boxed-layout-tips" class="card mb-4">
        <div class="card-body">

            <h5 class="card-title">Identitas Mahasiswa</h5>
            <table class="w-100 mb-3">
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
                    <td valign="top">Fakultas</td>
                    <td valign="top">: </td>
                    <td><?= ucwords(strtolower($anggota->nama_fak)) ?></td>
                </tr>
                <tr>
                    <td valign="top">Program Studi</td>
                    <td valign="top">: </td>
                    <td><?= $anggota->nm_jenj_didik ?> - <?= $anggota->nama_prodi ?></td>
                </tr>
                <tr>
                    <td class="text-nowrap" valign="top">Dosen Pembimbing</td>
                    <td width="1" valign="top">: </td>
                    <td valign="top">
                        <ol class="py-0 my-0 ps-3 pe-0">
                        <?php
                        $pembimbing_ = $this->Aktivitas_model->pembimbing([ 'id_aktivitas' => $aktivitas->id_aktivitas ], 'pembimbing_ke ASC')->result();
                        // print_r($pembimbing_);
                        foreach ($pembimbing_ as $pembimbing_) {
                            echo '<li>'.ucwords(strtolower($pembimbing_->nm_sdm)).'</li>';
                        }
                        ?>
                        </ol>
                    </td>
                </tr>
            </table>

            <h5 class="card-title">Identitas Kegiatan</h5>
            <table class="w-100">
                <tr>
                    <td>Status Kegiatan</td>
                    <td>: </td>
                    <td><?= $aktivitas->status == 0 ? '<span class="text-primary">Belum Selesai</span>' : '<span class="text-secondary">Selesai</span>' ?></td>
                </tr>
                <tr>
                    <td class="text-nowrap" width="130px">Jenis Kegiatan</td>
                    <td width="1">: </td>
                    <td><?= $aktivitas->nama_jenis_aktivitas_mahasiswa ?></td>
                </tr> 
                <tr>
                    <td>Tahun Akademik</td>
                    <td>: </td>
                    <td>
                        <?= $aktivitas->nama_semester ?>
                        <!-- <i class="pli-information ms-1 fs-4" data-bs-toggle="tooltip" title="Awal Kontrak: 2020/2021 Genap"></i> -->
                    </td>
                </tr>
                <tr>
                    <td class="text-nowrap">No. Penugasan</td>
                    <td width="1">: </td>
                    <td><?= $aktivitas->sk_tugas ?: '<span class="text-primary">Silahkan hubungi prodi</span>' ?></td>
                </tr>
                <tr>
                    <td class="text-nowrap">Tgl. Penugasan</td>
                    <td width="1">: </td>
                    <td><?= $aktivitas->tanggal_sk_tugas ? tanggal_indo($aktivitas->tanggal_sk_tugas) : '<span class="text-primary">Silahkan hubungi prodi</span>' ?></td>
                </tr>
                <tr>
                    <td class="text-nowrap">SK Pembimbing</td>
                    <td width="1">: </td>
                    <td><a href="<?= $aktivitas->file_sk_tugas ?: 'javascript:void(0)' ?>" download><?= $aktivitas->file_sk_tugas ? 'Unduh Berkas' : '<span class="text-primary">Silahkan hubungi prodi</span>' ?></a></td>
                </tr> 
                <tr>
                    <td valign="top">Lokasi</td>
                    <td valign="top">: </td>
                    <td>
                        <?= strip_tags($aktivitas->lokasi) ?>
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modal_lokasi_penelitian" data-action="2" class="badge bg-info text-white <?= $aktivitas->lokasi ?: 'd-none' ?>"> <i class="psi-hour"></i> Histori</a>
                    </td>
                </tr>
                <tr>
                    <td class="text-nowrap" valign="top">Judul</td>
                    <td valign="top">: </td>
                    <td>
                        <?= strip_tags($aktivitas->judul) ?>
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#<?= $aktivitas->judul ? 'modal_judul': 'modal_ajukan_judul' ?>" data-action="2" class="badge bg-info text-white"> <i class="psi-hour me-1"></i> <?= $aktivitas->judul ? 'Histori': 'Judul Diajukan' ?></a>
                    </td>
                </tr>
                <tr>
                    <td class="text-nowrap" valign="top">Judul (English)</td>
                    <td valign="top">: </td>
                    <td>
                        <?= strip_tags($aktivitas->judul_en) ?>
                    </td>
                </tr>
                <!-- <tr>
                    <td>Jenis Anggota</td>
                    <td>: </td>
                    <td><?= $aktivitas->jenis_anggota == 0 ? 'Personal' : 'Kelompok' ?></td>
                </tr> -->
            </table>

            <?php if (isset($pembimbing)): ?>
            <h5 class="card-title mt-2">Identitas Pembimbing</h5>
            <table class="w-100">
                <?php foreach($pembimbing as $pembimbing): ?>
                <tr>
                    <td colspan="3">Pembimbing Ke-<?= $pembimbing->pembimbing_ke ?></td>
                </tr>
                <tr>
                    <td>NIDN</td>
                    <td>: </td>
                    <td><?= $pembimbing->nidn ?></td>
                </tr>
                <tr>
                    <td class="text-nowrap" width="130px" valign="top">Nama Dosen</td>
                    <td width="1" valign="top">: </td>
                    <td valign="top"><?= ucwords(strtolower($pembimbing->nm_sdm)) ?></td>
                </tr> 
                <tr>
                    <td>No. Handphone</td>
                    <td>: </td>
                    <td><?= $pembimbing->no_hp ? '<a href="tel:+'.$pembimbing->no_hp.'">+'.$pembimbing->no_hp.'</a>' : '-' ?></td>
                </tr>
                <tr style="height: 10px;" class="d-block">
                    <td colspan="3">&nbsp;</td>
                </tr>
                <?php endforeach; ?>
            </table>    
            <?php endif; ?>

            <?php if (isset($penguji)): ?>
            <h5 class="card-title mt-2">Identitas Penguji</h5>
            <table class="w-100">
                <?php foreach($penguji as $penguji): ?>
                <tr>
                    <td colspan="3">Penguji Ke-<?= $penguji->penguji_ke ?></td>
                </tr>
                <tr>
                    <td>NIDN</td>
                    <td>: </td>
                    <td><?= $penguji->nidn ?></td>
                </tr>
                <tr>
                    <td class="text-nowrap" width="130px">Nama Dosen</td>
                    <td width="1">: </td>
                    <td><?= ucwords(strtolower($penguji->nm_sdm)) ?></td>
                </tr> 
                <tr>
                    <td>No. Handphone</td>
                    <td>: </td>
                    <td><?= $penguji->no_hp ? '<a href="tel:+'.$penguji->no_hp.'">+'.$penguji->no_hp.'</a>' : '-' ?></td>
                </tr>
                <tr>
                    <td class="text-nowrap">Kegiatan</td>
                    <td width="1">: </td>
                    <td><?= $penguji->deskripsi ?></td>
                </tr>
                <tr style="height: 10px;" class="d-block">
                    <td colspan="3">&nbsp;</td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php endif; ?>

        </div>
    </section>
</div>

<script>
	function sinkronisasi_nilai(id_anggota, id_penjadwalan) {
        var myModal = new bootstrap.Modal(document.getElementById('modal_sinkronisasi_nilai'))
        myModal.show()

        var formData = new FormData()
        formData.append('id_anggota', id_anggota)
        formData.append('id_penjadwalan', id_penjadwalan)

        fetch('<?= base_url('bimbingan/sinkronisasi_nilai/') ?>', { 
            method: 'POST', 
            body: formData
        })
        .then(response => response.text())
        .then(text => {
            document.querySelector('#modal_sinkronisasi_nilaiBody').innerHTML = text
        })
    }

    function input_nilai(label, id_anggota, id_penjadwalan, id_kegiatan) {
        var myModal = new bootstrap.Modal(document.getElementById('modal_input_nilai'))
        myModal.show()

        var formData = new FormData()
        formData.append('id_anggota', id_anggota)
        formData.append('id_penjadwalan', id_penjadwalan)
        formData.append('id_kegiatan', id_kegiatan)
        formData.append('id_aktivitas', <?= $aktivitas->id_aktivitas ?>)

        fetch('<?= base_url('bimbingan/nilai/'.$jenis_bimbingan) ?>', { 
            method: 'POST', 
            body: formData
        })
        .then(response => response.text())
        .then(text => {
            document.querySelector('#modal_input_nilaiLabel').innerHTML = label
            document.querySelector('#modal_input_nilaiBody').innerHTML = text
        })
    }

    function update_nilai(e, id_parent = null, id_komponen_nilai = null) {
        if (e.dataset.id_kegiatan == 3 || e.dataset.id_kegiatan == 5) {
            if (e.value > 4) e.value = 4
            
            document.querySelector('#nilai_'+id_parent+'_'+id_komponen_nilai).innerHTML = (e.value * e.dataset.bobot).toFixed(2);

            var bobot_skor = 0  
            document.querySelectorAll('*[id^="nilai_'+id_parent+'"]').forEach(i => {
                bobot_skor += Number(i.innerHTML)
                // bobot_skor += Number(parseFloat(i.innerHTML != '' ? parseFloat(i.innerHTML) : 0).toFixed(2))
            })

            document.querySelector('*[id^="total_nilai_'+id_parent+'"]').innerHTML = Number(bobot_skor).toFixed(2)
            // document.querySelector('*[id^="total_nilai_'+id_parent+'"]').innerHTML = Number(parseFloat(bobot_skor).toFixed(2))
            generate_nilai_akhir(e.dataset.id_kegiatan)
        }

        if (e.dataset.id_kegiatan == 4 || e.dataset.id_kegiatan == 2) {
            if (e.value > 100) e.value = 100
            
            var total_nilai = 0
        	var pembagi = 0
            document.querySelectorAll('input[name^="nilai["]').forEach(i => {
                total_nilai += Number(parseFloat(i.value != '' ? parseFloat(i.value) : 0).toFixed(2))
                pembagi++
            })
            document.querySelector('*[id^="total_nilai"]').innerHTML = Number(parseFloat(total_nilai).toFixed(2))
            
            var nilai_akhir = Number(parseFloat(total_nilai / pembagi).toFixed(2))
            document.querySelector('*[id^="rata_rata_nilai"]').innerHTML = nilai_akhir + ` (<a href="javascript:void(0)" data-nilai_akhir='${nilai_akhir}' data-id_kegiatan='${e.dataset.id_kegiatan}' onclick="pengaturan_nilai(this)">?</a>)`
            document.querySelector('#nilai_angka_hidden').value = nilai_akhir
        }
    }

    function update_nilai_tambahan(e) {
        if (e.value > 10) e.value = 10
        generate_nilai_akhir(e.dataset.id_kegiatan)
    }

    function generate_nilai_akhir(id_kegiatan) {
        var total_nilai = 0  
        document.querySelectorAll('*[id^="total_nilai"]').forEach(i => {
            if (i.nodeName == 'TH') {
                total_nilai += Number(i.innerHTML)
                // total_nilai += Number(parseFloat(i.innerHTML != '' ? parseFloat(i.innerHTML) : 0).toFixed(2))
            } else { // nodeName = INPUT
                total_nilai += Number(i.value)
                // total_nilai += Number(parseFloat(i.value != '' ? parseFloat(i.value) : 0).toFixed(2))
            }
        })

        var nilai_akhir = (Number(parseFloat(total_nilai).toFixed(2)) / 100).toFixed(2)
        document.querySelector('*[id^="nilai_akhir"]').innerHTML = nilai_akhir + ` (<a href="javascript:void(0)" data-nilai_akhir='${nilai_akhir}' data-id_kegiatan='${id_kegiatan}' onclick="pengaturan_nilai(this)">?</a>)`
        document.querySelector('#nilai_angka_hidden').value = nilai_akhir
    }

    function pengaturan_nilai(e) {
        var formData = new FormData()
        formData.append('nilai_angka', e.dataset.nilai_akhir)

        fetch('<?= base_url('bimbingan/nilai_huruf/') ?>' + e.dataset.id_kegiatan, {
            method: 'POST',
            body: formData
        }).then(response => response.text())
        .then(text => {
            e.innerHTML = text
        })
    }
</script>