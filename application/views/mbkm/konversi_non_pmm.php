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
    		<?php $this->load->view('mbkm/identitas_konversi'); ?>
    		
    		<div class="col-12">
		        <div class="card">
                    <div class="card-body">
                        <table class="table table-striped" id="datatabel_konversi">
                            <thead>
                                <tr>
                                    <th width="1">No.</th>
                                    <th class="text-nowrap">Capaian Pembelajaran</th>
                                    <th width="1">SKS</th>
                                    <th class="text-nowrap">Mata Kuliah</th>
                                    <th  width="1">SMT</th>
                                    <th width="1">SKS</th>
                                    <th >Nilai Angka</th>
                                    <th >Nilai Huruf</th>
                                    <th >Nilai Indeks</th>
                                    <th width="1">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
    		</div>
    	</div>

    </div>
</div>

<!-- Modal Konversi Aktivitas -->
<div class="modal fade" id="modal_konversi_aktivitas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_konversi_aktivitas" style="display: none;" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Data Konversi</h5>
        <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <form id="form_tambah_konversi" onsubmit="event.preventDefault(); simpan(this)" class="row">
            <input type="hidden" name="id_aktivitas" value="<?= $aktivitas->id_aktivitas ?>">
            <input type="hidden" name="id_anggota" value="<?= $anggota->id_anggota ?>">
            <input type="hidden" name="id_smt" value="<?= $aktivitas->id_smt ?>">

            <div class="col-md-12 form-group mb-3">
                <label for="cpl" class="form-label fw-bold text-dark">Deskripsi Capaian Pembelajaran <span class="text-danger">*</span></label>
                <textarea name="cpl" class="form-control" required="" id="cpl" placeholder="" rows="3" onkeydown="(event.keyCode == 13 ? event.preventDefault() : '')"></textarea>
                <!-- <input type="text" name="cpl" class="form-control" required="" id="cpl"> -->
            </div>
            <div class="col-md-6 form-group mb-3">
                <label for="jenis_cpl" class="form-label fw-bold text-dark">
                    Jenis Capaian Pembelajaran
                </label>
                <select class="form-select" name="id_jenis_cpl" id="jenis_cpl">
                    <option value="">Pilih Jenis Capaian Pembelajaran</option>
                    <option value="1">Hardskill (Keterampilan Teknis)</option>
                    <option value="2">Softskill (Keterampilan Non-Teknis)</option>
                </select>
                <small>* Opsional</small>
            </div>
            <div class="col-md-6 form-group mb-3">
                <label for="sks_cpl" class="form-label fw-bold text-dark">
                    SKS Capaian Pembelajaran
                </label>
                <input type="number" name="sks_cpl" min="0" max="10" class="form-control" id="sks_cpl">
                <small>* Opsional</small>
            </div>
            <div class="col-md-12 form-group mb-3">
                <label for="id_matkul" class="form-label fw-bold text-dark">Mata Kuliah Diakui <span class="text-danger">*</span></label>
                <input type="search" class="form-control" id="id_matkul" placeholder="Masukan Kode atau Nama Mata Kuliah" list="mata_kuliah_mbkm" required="" autocomplete="off" onchange="castvote(this); document.querySelector('#hidden_id_matkul').value = document.querySelector(`#mata_kuliah_mbkm > option[value='${this.value}']`).dataset.id_matkul;">
                <small class="text-muted">* Mata kuliah diakui diambil dari data krs mahasiswa.</small>
                <datalist id="mata_kuliah_mbkm">
                <?php foreach ($list_kelas_krs->result() as $row): ?>
                    <?php //if ($row->id_program_mitra != ''): ?>
                    <option value="(<?= $row->kode_mk ?>) <?= $row->nm_mk ?>" data-id_matkul="<?= $row->id_matkul ?>_<?= $row->sks_mk ?>"><?= $row->sks_mk ?> SKS <?= $row->id_program_mitra != '' ? 'MBKM' : 'Reguler' ?></option>
                    <?php //endif; ?>
                <?php endforeach; ?>
                </datalist>
                <input type="hidden" id="hidden_id_matkul" name="id_matkul">
            </div>
            <div class="col-md-6 form-group mb-3">
                <label for="nilai_angka" class="form-label fw-bold text-dark">Nilai Angka <span class="text-danger">*</span></label>
                <input type="number" step="0.01" min="0" max="100" name="nilai_angka" class="form-control" id="nilai_angka" required="">
                <small class="text-muted">* Rentang 0 - 100.</small>
            </div>
            <div class="col-md-6 form-group mb-3">
                <label for="nilai_huruf" class="form-label fw-bold text-dark">Nilai Huruf (Nilai Indeks) <span class="text-danger">*</span></label>
                <select class="form-select" id="nilai_huruf" name="nilai_huruf" required="">
                    <option value="" hidden="">Pilih Nilai Huruf</option>
                    <option value="A">A (4,00)</option>
                    <option value="B">B (3,00)</option>
                    <option value="C">C (2,00)</option>
                    <option value="D">D (1,00)</option>
                    <option value="E">E (0,00)</option>
                </select>
            </div>
            <div class="col-md-12">
                <button class="btn btn-info w-100"><i class="psi-paper-plane me-1"></i> Simpan</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal Konversi Aktivitas -->

<?php $this->load->view('lyt/js_datatable'); ?>
<script>
    var tabel_konversi

    function validasi(id_konversi_aktivitas) {
        var konfirmasi = confirm('Validasi nilai yang dipilih ?\n\n* Nilai yang sudah divalidasi akan dikunci dan tidak bisa dikelola lagi.')
        if (konfirmasi) {
            fetch('<?= base_url('konversi/validasi/konversi_aktivitas/') ?>' + id_konversi_aktivitas)
            .then(response => response.text())
            .then(text => {
                tabel_konversi.ajax.reload(null,false)
                Toastify({
                    text: text,
                }).showToast();
            })
        }
    }

    function hapus(id_konversi_aktivitas) {
        var konfirmasi = confirm('Hapus data yang dipilih ?')
        if (konfirmasi) {
            fetch('<?= base_url('konversi/hapus/konversi_aktivitas/') ?>' + id_konversi_aktivitas)
            .then(response => response.text())
            .then(text => {
                tabel_konversi.ajax.reload(null,false)
                Toastify({
                    text: text,
                }).showToast();
            })
        }
    }

    function tambah() {
        // $('#modal_konversi_aktivitas').modal('show')
        var modal = new bootstrap.Modal(document.getElementById('modal_konversi_aktivitas'))
        modal.show()
    }

    function simpan(e) {
        var formData = new FormData(e)
        fetch('<?= base_url('konversi/simpan/konversi_aktivitas/') ?>', { method: 'POST', body: formData })
        .then(response => response.text())
        .then(text => {
            e.reset()
            tabel_konversi.ajax.reload(null,false)
            Toastify({
                text: text,
            }).showToast();
        })
    }

    $(document).ready(function() {
        tabel_konversi = $('#datatabel_konversi').DataTable( {
            ajax: {
                url     : "<?= base_url('konversi/json_konversi_aktivitas') ?>",
                type    : 'GET',
                data : function(d) {
                    d.id_aktivitas = '<?= sha1($anggota->id_aktivitas) ?>';
                    d.id_anggota = '<?= sha1($anggota->id_anggota) ?>';
                    d.id_smt = '<?= $aktivitas->id_smt ?>';
                }
            },
            responsive: true,
            autoWidth: false,
            dom:    "<'row'<'col-sm-12 col-md-4 mb-1'l><'col-sm-12 col-md-4 mb-1'B><'col-sm-12 col-md-4 mb-1'f>>" +
                    "<'row'<'col-sm-12 mb-1'tr>>" +
                    "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
            buttons: [
                <?php if ($_SESSION['app_level'] == 7 OR $_SESSION['app_level'] == 2): ?>
                {
                    text: '<i class="fa fa-plus me-1"></i> Tambah Data',
                    className: 'btn btn-info btn-sm',
                    action: function ( e, dt, node, config ) {
                        tambah()
                    }
                },
                <?php endif; ?>
            ],
            columnDefs: [
                { targets: [0, 2, 5, 6, 7, 8, 9], className: 'text-center', orderable: false},
            ],
            order: [[4, 'asc']],
            serverSide: true,
            processing: true,
        } );
    } );

    function castvote(e) {
        var datalist = document.querySelector(`#${e.getAttribute('list')}`).children

        var flag = false
        for(let i = 0; i < datalist.length; i++){
            flag = datalist[i].value === e.value || flag
        }

        if (!flag)
          e.value = ""
    }
</script>