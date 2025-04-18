<!-- <div class="table-responsive"> -->
<table class="table table-striped" id="datatabel_laporan">
    <thead>
        <tr>
            <th width="1">No</th>
            <th>Jenis Laporan</th>
            <th width="1" class="text-nowrap">Tgl. Laporan</th>
            <th width="1" class="text-nowrap">Minggu Ke</th>
            <th width="1">Status</th>
            <th width="1">Aksi</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
<!-- </div> -->

<?php $this->load->view('lyt/js_datatable'); ?>
<script>
    var tabel_laporan

    function edit_laporan(id)
    {
        $('#modal_tambah_laporan').modal('show')
        $('.act').html('Edit')
        fetch('<?= base_url('laporan/detail/laporan/') ?>' + id + '/' + 'edit')
        .then(response => response.json())
        .then(json => {
            console.log(json)
            if (json.file != null) {
                $('.file').show()
                $('.file').attr('href', json.file)
            }

            if (json.file_gambar != null) {
                $('.file_gambar').show()
                $('.file_gambar').attr('href', json.file_gambar)
            }

            $('#jenis_laporan').val(json.jenis_laporan)
            $('#minggu_ke').val(json.minggu_ke)
            $('#id_laporan').val(json.id_laporan)
            $('#tgl_laporan').val(json.tgl_laporan)

            tinymce.get("rencana_kegiatan").setContent(json.rencana_kegiatan)
            tinymce.get("pelaksanaan_kegiatan").setContent(json.pelaksanaan_kegiatan)
            tinymce.get("analisis_hasil_kegiatan").setContent(json.analisis_hasil_kegiatan)
            tinymce.get("hambatan").setContent(json.hambatan)
            tinymce.get("rencana_perbaikan").setContent(json.rencana_perbaikan)
        })
    }

    function detail_laporan(id)
    {
        $('#modal_detail_laporan').modal('show')
        fetch('<?= base_url('laporan/detail/laporan/') ?>' + id)
        .then(response => response.text())
        .then(text => {
            document.querySelector('.detail_laporan').innerHTML = text
        })
    }

    function hapus_laporan(id)
    {
        var konfirmasi = confirm('Hapus laporan terpilih ?')
        if (konfirmasi) {
            var formData = new FormData()
            formData.append('id_laporan', id)

            fetch('<?= base_url('laporan/hapus') ?>', { method: 'POST', body: formData })
            .then(response => response.text())
            .then(text => {
                tabel_laporan.ajax.reload(null,false)
            })
        }
    }

    function tambah_laporan()
    {
        $('.act').html('Tambah')
        
        document.querySelector('#form_tambah_laporan').reset()
        tinymce.get("rencana_kegiatan").setContent('')
        tinymce.get("pelaksanaan_kegiatan").setContent('')
        tinymce.get("analisis_hasil_kegiatan").setContent('')
        tinymce.get("hambatan").setContent('')
        tinymce.get("rencana_perbaikan").setContent('')
        $('#id_laporan').val('')

        $('.file').hide()
        $('.file_gambar').hide()

        $('#modal_tambah_laporan').modal('show')
    }

    function simpan_laporan(e) {
        if( e.querySelector("#file").files.length == 0 || e.querySelector("#file_gambar").files.length == 0 ){
            var konfirmasi = confirm('Simpan laporan tanpa lampiran dan atau foto kegiatan ?')
            if (!konfirmasi) {
                return
            }
        }

        var formData = new FormData(e)

        formData.append('rencana_kegiatan', tinymce.get("rencana_kegiatan").getContent())
        formData.append('pelaksanaan_kegiatan', tinymce.get("pelaksanaan_kegiatan").getContent())
        formData.append('analisis_hasil_kegiatan', tinymce.get("analisis_hasil_kegiatan").getContent())
        formData.append('hambatan', tinymce.get("hambatan").getContent())
        formData.append('rencana_perbaikan', tinymce.get("rencana_perbaikan").getContent())

        fetch('<?= base_url('laporan/simpan') ?>', { method: 'POST', body: formData })
        .then(response => response.text())
        .then(text => {
            tinymce.get("rencana_kegiatan").setContent('')
            tinymce.get("pelaksanaan_kegiatan").setContent('')
            tinymce.get("analisis_hasil_kegiatan").setContent('')
            tinymce.get("hambatan").setContent('')
            tinymce.get("rencana_perbaikan").setContent('')
            
            e.reset()
            $('#modal_tambah_laporan').modal('hide')
            tabel_laporan.ajax.reload(null,false)
        })
    }

    $(document).ready(function() {
        tabel_laporan = $('#datatabel_laporan').DataTable( {
            ajax: {
                url     : "<?= base_url('laporan/json') ?>",
                type    : 'GET',
                data : function(d) {
                    d.id_aktivitas = '<?= sha1($aktivitas->id_aktivitas) ?>';
                }
            },
            responsive: true,
            autoWidth: false,
            dom:    "<'row'<'col-sm-12 col-md-4 mb-1'l><'col-sm-12 col-md-4 mb-1'B><'col-sm-12 col-md-4 mb-1'f>>" +
                    "<'row'<'col-sm-12 mb-1'tr>>" +
                    "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
            buttons: [
                <?php if ($_SESSION['app_level'] == 1): ?>
                {
                    text: '<i class="fa fa-plus me-1"></i> Tambah Laporan',
                    className: 'btn btn-info btn-sm',
                    action: function ( e, dt, node, config ) {
                        tambah_laporan()
                    }
                },
                <?php else: ?>
                {
                    text: '<i class="psi-repeat-2 me-1"></i> Refresh Tabel',
                    className: 'btn btn-info btn-sm',
                    action: function ( e, dt, node, config ) {
                        tabel_laporan.ajax.reload(null,false)
                    }
                },  
                <?php endif; ?>
            ],
            columnDefs: [
                { targets: [2], className: 'text-nowrap'},
                { targets: [3, 5], className: 'text-nowrap text-center'},
            ],
            order: [[3, 'desc']],
            serverSide: true,
            processing: true,
        } );

    } );
</script>