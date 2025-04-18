<table class="table table-striped" id="datatabel_logbook">
    <thead>
        <tr>
            <th width="1">No</th>
            <th width="1" class="text-nowrap">Tgl. Kegiatan</th>
            <th>Keterangan Logbook</th>
            <th width="1">Status</th>
            <th width="1">Aksi</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<?php $this->load->view('lyt/js_datatable'); ?>
<script>
    var tabel_logbook

    function edit_logbook(id)
    {
        $('#modal_tambah_logbook').modal('show')
        $('.act').html('Edit')
        fetch('<?= base_url('logbook/detail/logbook/') ?>' + id + '/' + 'edit')
        .then(response => response.json())
        .then(json => {
            if (json.file != null) {
                $('.file').show()
                $('.file').attr('href', json.file)
            }

            if (json.file_gambar != null) {
                $('.file_gambar').show()
                $('.file_gambar').attr('href', json.file_gambar)
            }

            $('#id_logbook').val(json.id_logbook)
            $('#tgl_kegiatan').val(json.tgl_kegiatan)
            tinymce.get("isi").setContent(json.isi);
        })
    }

    function detail_logbook(id)
    {
        $('#modal_detail').modal('show')
        fetch('<?= base_url('logbook/detail/logbook/') ?>' + id)
        .then(response => response.text())
        .then(text => {
            document.querySelector('.detail').innerHTML = text
        })
    }

    function hapus_logbook(id)
    {
        var konfirmasi = confirm('Hapus logbook terpilih ?')
        if (konfirmasi) {
            var formData = new FormData()
            formData.append('id_logbook', id)

            fetch('<?= base_url('logbook/hapus') ?>', { method: 'POST', body: formData })
            .then(response => response.text())
            .then(text => {
                tabel_logbook.ajax.reload(null,false)
            })
        }
    }

    function tambah_logbook()
    {
        $('.act').html('Tambah')
        
        document.querySelector('#form_tambah_logbook').reset()
        tinymce.get("isi").setContent("");
        $('#id_logbook').val('')

        $('.file').hide()
        $('.file_gambar').hide()

        $('#modal_tambah_logbook').modal('show')
    }

    function simpan_logbook(e) {
        if( tinymce.get("isi").getContent() == '' ){
            alert('Maaf, deskripsi kegiatan tidak boleh kosong.')
            return
        }

        if( e.querySelector("#file").files.length == 0 || e.querySelector("#file_gambar").files.length == 0 ){
            var konfirmasi = confirm('Simpan logbook tanpa lampiran dan atau foto kegiatan ?')
            if (!konfirmasi) {
                return
            }
        }

        var formData = new FormData(e)
        formData.append('isi', tinymce.get("isi").getContent())

        fetch('<?= base_url('logbook/simpan') ?>', { method: 'POST', body: formData })
        .then(response => response.text())
        .then(text => {
            e.reset()
            tinymce.get("isi").setContent("");
            $('#modal_tambah_logbook').modal('hide')
            tabel_logbook.ajax.reload(null,false)
        })
    }

    $(document).ready(function() {
        tabel_logbook = $('#datatabel_logbook').DataTable( {
            ajax: {
                url     : "<?= base_url('logbook/json') ?>",
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
                    text: '<i class="fa fa-plus me-1"></i> Tambah Logbook',
                    className: 'btn btn-info btn-sm',
                    action: function ( e, dt, node, config ) {
                        tambah_logbook()
                    }
                },
                <?php else: ?>
                {
                    text: '<i class="psi-repeat-2 me-1"></i> Refresh Tabel',
                    className: 'btn btn-info btn-sm',
                    action: function ( e, dt, node, config ) {
                        tabel_logbook.ajax.reload(null,false)
                    }
                },  
                <?php endif; ?>
            ],
            columnDefs: [
                { targets: [1, 4], className: 'text-nowrap text-center'},
            ],
            order: [[1, 'desc']],
            serverSide: true,
            processing: true,
        } );
    } );
</script>