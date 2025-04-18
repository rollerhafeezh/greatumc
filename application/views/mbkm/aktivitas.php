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
<script src="https://cdn.tiny.cloud/1/euelv3wjksq6s3ph6qk546lit81gvn8cdaosi9ep1ftlkp1v/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

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

<script>
    tinymce.init({
        selector: 'textarea',
        plugins: 'importcss image media advlist lists wordcount paste table fullscreen',
        menubar: false,
        toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify |  numlist bullist | table | image | removeformat | fullscreen',
        toolbar_mode: 'wrap',
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tiny.cloud/css/codepen.min.css'
        ],
        importcss_append: true,
        images_upload_handler: function (blobInfo, success, failure) {
            var xhr, formData;
            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '<?=base_url('mbkm/unggah_gambar')?>');
            xhr.onload = function() {
            if (xhr.status != 200) {
                failure('HTTP Error: ' + xhr.status);
                return;
            }
            var res = JSON.parse( xhr.responseText );
                if (res.status == 'error') {
                failure( res.message );
                return;
            }
            success( res.location );
            };
            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            xhr.send(formData);
        },
        height: 300,
        paste_as_text: true,
        relative_urls : false,
        remove_script_host : false,
     });
</script>