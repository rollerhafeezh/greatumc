<div class="content__boxed">
    <div class="content__wrap">
        <style type="text/css">
            a, a:hover {
                text-decoration: none!important;
            }

            .popover-body ol {
                padding: 0 0 0 15px !important;
                margin: 0px !important;
            }

            .popover-body ol li {
                margin-bottom: 5px !important;
            }
        </style>
    	<div class="row">
    		<?php $this->load->view('mbkm/identitas'); ?>
    		
    		<div class="col-md">
		        <div class="card">
                    <div class="card-header toolbar">
                        <div class="toolbar-start">
                            <h5 class="m-0"><i class="psi-notepad me-1" style="margin-top: -3px;"></i> Aktivitas Kampus Merdeka</h5>
                        </div>
                        <div class="toolbar-end">

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#logbook" type="button" role="tab" aria-controls="logbook" aria-selected="false">Logbook  <!-- <i class="pli-information ms-1 text-info" data-bs-toggle="popover"data-bs-original-title="Tips Mengisi Logbook" data-bs-html="true" data-bs-content="
                                    <ol style='padding: 0px; margin: 0px;'>
                                        <li>Laporkan semua kegiatan harian kamu;</li>
                                        <li>Usahakan lebih dari 25 kata;</li>
                                        <li>Tambahkan informasi kelemahan dan kelebihan agenda kegiatan;</li>
                                        <li>Lampirkan berkas pendukung, seperti lampiran/foto kegiatan;</li>
                                        <li>Usahakan isi tepat waktu;</li>
                                        <li>Jangan lupa salin logbook pada dokumen lain seperti word.</li>
                                    </ol>
                                    "></i> --></button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#laporan" type="button" role="tab" aria-controls="laporan" aria-selected="true">Laporan</button>
                                </li>
                            </ul>

                        </div>
                    </div>
                    <div class="card-body tab-content">
                        <div id="logbook" class="tab-pane fade active show" role="tabpanel" aria-labelledby="logbook-tab">
                            <?php $this->load->view('mbkm/logbook') ?>
                        </div>
                        <div id="laporan" class="tab-pane fade" role="tabpanel" aria-labelledby="laporan-tab">
                            <?php $this->load->view('mbkm/laporan') ?>
                        </div>
                    </div>
                </div>
    		</div>
    	</div>

    </div>
</div>

<?php $this->load->view('mbkm/modal'); ?>

<?php if($_SESSION['app_level'] == 2): ?>
<script>
    function ubah_status(e, target) {
        fetch(`/${target}/ubah_status/` + e.dataset.id + '/' + e.value)
        .then(response => response.text())
        .then(text => {
            target == 'logbook' ? tabel_logbook.ajax.reload(null,false) : tabel_laporan.ajax.reload(null,false)
            
            Toastify({
                text: text,
            }).showToast();
        })

        if (e.value == 0) {
            $('.tanggapan').show()
        } else {
            $('.tanggapan').hide()
        }
    }

    function simpan_tanggapan(e, id, target) {
        var formData = new FormData(e)

        fetch(`/${target}/simpan_tanggapan/`, { method: 'POST', body: formData })
        .then(response => response.text())
        .then(text => {
            target == 'logbook' ? tabel_logbook.ajax.reload(null,false) : tabel_laporan.ajax.reload(null,false)
            target == 'logbook' ? detail_logbook(id) : detail_laporan(id)
            
            Toastify({
                text: text,
            }).showToast();
        })
    }

    function hapus_tanggapan(id_tanggapan, id, target) {
        var konfirmasi = confirm('Hapus tanggapan yang dipilih ?')
        if (konfirmasi) {
            var formData = new FormData()
            formData.append('id_tanggapan', id_tanggapan)
            
            fetch(`/${target}/hapus_tanggapan/`, { method: 'POST', body: formData })
            .then(response => response.text())
            .then(text => {
                target == 'logbook' ? tabel_logbook.ajax.reload(null,false) : tabel_laporan.ajax.reload(null,false)
                target == 'logbook' ? detail_logbook(id) : detail_laporan(id)
                
                Toastify({
                    text: text,
                }).showToast();
            })
        }
    }
</script>
<?php endif; ?>