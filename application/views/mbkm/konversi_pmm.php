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
                        <table class="table table-striped table-bordered" id="datatabel_konversi">
                            <thead>
                                <tr>
                                    <th colspan="5" class="text-center">Nilai Asal</th>
                                    <th colspan="5" class="text-center">Hasil Konversi</th>
                                    <th rowspan="2" class="text-center" width="1">Aksi</th>
                                </tr>
                                <tr class="text-center">
                                    <th class="text-center text-nowrap">PT Asal</th>
                                    <th class="text-center" width="1" >Kode MK</th>
                                    <th class="text-center text-nowrap">Nama MK</th>
                                    <th class="text-center" width="1">SKS MK</th>
                                    <th class="text-center" width="1">Nilai Huruf</th>

                                    <th class="text-center" width="1">Kode MK</th>
                                    <th class="text-center text-nowrap">Nama MK</th>
                                    <th class="text-center" width="1">SKS MK</th>
                                    <th class="text-center" width="1">Nilai Huruf</th>
                                    <th class="text-center" width="1">Nilai Indeks</th>
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
<div class="modal fade" id="modal_nilai_transfer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_nilai_transfer" style="display: none;" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Data Konversi</h5>
        <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <form id="form_tambah_konversi" onsubmit="event.preventDefault(); simpan(this)" class="row" autocomplete="off">
            <input type="hidden" name="id_aktivitas" value="<?= $aktivitas->id_aktivitas ?>">
            <input type="hidden" name="id_mahasiswa_pt" value="<?= $anggota->id_mahasiswa_pt ?>">
            <input type="hidden" name="id_mhs" value="<?= $anggota->id_mhs ?>">

            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label class="form-label fw-bold text-dark" for="nm_lemb">Asal Perguruan Tinggi</label>
                    <input type="search" autocomplete="off" name="nm_lemb" id="nm_lemb" class="form-control" required="" placeholder="Nama Perguruan Tinggi" list="satuan_pendidikan" onchange="castvote(this); document.querySelector('#id_sp').value = document.querySelector(`#satuan_pendidikan > option[value='${this.value}']`).dataset.id_sp;">
                    <small class="text-muted">* Opsional</small>
                    <datalist id="satuan_pendidikan">
                    <?php
                    	$satuan_pendidikan = $this->Mbkm_model->get($_ENV['DB_REF'].'satuan_pendidikan', [ 'id_sp !=' => '', 'nm_lemb !=' => '' ], 'nm_lemb asc');
                    	foreach ($satuan_pendidikan->result() as $satuan_pendidikan) {		
                    		echo '<option value="'.$satuan_pendidikan->nm_lemb.'" data-id_sp="'.$satuan_pendidikan->id_sp.'">'.$satuan_pendidikan->nm_singkat.'</option>';
                    	}
                    ?>
                    </datalist>	
                    <input type="hidden" name="id_sp" id="id_sp">
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label class="form-label fw-bold text-dark" for="kode_mk_asal">Kode MK Asal <span class="text-danger">*</span></label>
                    <input type="text" name="kode_mk_asal" id="kode_mk_asal" class="form-control" required="" placeholder="Kode Mata Kuliah Asal">
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label class="form-label fw-bold text-dark" for="nm_mk_asal">Nama MK Asal <span class="text-danger">*</span></label>
                    <input type="text" name="nm_mk_asal" id="nm_mk_asal" class="form-control" required="" placeholder="Nama Mata Kuliah Asal">
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label class="form-label fw-bold text-dark" for="sks_asal">SKS Asal <span class="text-danger">*</span></label>
                    <input type="number" maxlength="1" name="sks_asal" id="sks_asal" class="form-control" required="" placeholder="Bobot SKS Asal">
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label class="form-label fw-bold text-dark" for="nilai_huruf_asal">Nilai Huruf Asal <span class="text-danger">*</span></label>
                    <input type="text" maxlength="2" name="nilai_huruf_asal" id="nilai_huruf_asal" class="form-control" placeholder="Nilai Huruf Asal" required="">
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label class="form-label fw-bold text-dark" for="id_matkul">Mata Kuliah Diakui <span class="text-danger">*</span></label>
                    <input type="search" class="form-control" id="id_matkul" placeholder="Masukan Kode atau Nama Mata Kuliah" list="list_kelas_krs" required="" autocomplete="off" onchange="castvote(this); document.querySelector('#hidden_id_matkul').value = document.querySelector(`#list_kelas_krs > option[value='${this.value}']`).dataset.id_matkul;">
                    <small><i class="pli-information me-1"></i> Berdasarkan KRS Mahasiswa Tahun Akademik <?= $aktivitas->nama_semester ?>.</small>
	                <datalist id="list_kelas_krs">
	                <?php foreach ($list_kelas_krs->result() as $row): ?>
	                    <?php //if ($row->id_program_mitra != ''): ?>
	                    <option value="(<?= $row->kode_mk ?>) <?= $row->nm_mk ?>" data-id_matkul="<?= $row->id_matkul ?>_<?= $row->sks_mk ?>"><?= $row->sks_mk ?> SKS <?= $row->id_program_mitra != '' ? 'MBKM' : 'Reguler' ?></option>
	                    <?php //endif; ?>
	                <?php endforeach; ?>
	                </datalist>
	                <input type="hidden" id="hidden_id_matkul" name="id_matkul">
                </div>
            </div>
            <!-- <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label class="form-label fw-bold text-dark" for="nilai_angka_diakui">Nilai Angka Diakui <span class="text-danger">*</span></label>
                    <select class="form-select" id="nilai_angka_diakui" name="nilai_angka_diakui" required="">
	                    <option value="" hidden="">Pilih Nilai Huruf</option>
	                    <option value="4">4</option>
	                    <option value="3">3</option>
	                    <option value="2">2</option>
	                    <option value="1">1</option>
	                    <option value="0">0</option>
	                </select>
                </div>
            </div> -->
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label class="form-label fw-bold text-dark" for="nilai_huruf_diakui">Nilai Huruf (Nilai Indeks) Diakui <span class="text-danger">*</span></label>
                    <select class="form-select" id="nilai_huruf_diakui" name="nilai_huruf_diakui" required="">
                    <option value="" hidden="">Pilih Nilai Huruf</option>
                    <option value="A">A (4,00)</option>
                    <option value="B">B (3,00)</option>
                    <option value="C">C (2,00)</option>
                    <option value="D">D (1,00)</option>
                    <option value="E">E (0,00)</option>
                </select>
                </div>
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

    function validasi(id_nilai_transfer) {
        var konfirmasi = confirm('Validasi nilai yang dipilih ?\n\n* Nilai yang sudah divalidasi akan dikunci dan tidak bisa dikelola lagi.')
        if (konfirmasi) {
            fetch('<?= base_url('konversi/validasi/nilai_transfer/') ?>' + id_nilai_transfer + '/<?= $aktivitas->id_smt ?>')
            .then(response => response.text())
            .then(text => {
                tabel_konversi.ajax.reload(null,false)
                Toastify({
                    text: text,
                }).showToast();
            })
        }
    }

    function hapus(id_nilai_transfer) {
        var konfirmasi = confirm('Hapus data yang dipilih ?')
        if (konfirmasi) {
            fetch('<?= base_url('konversi/hapus/nilai_transfer/') ?>' + id_nilai_transfer)
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
        // $('#modal_nilai_transfer').modal('show')
        var modal = new bootstrap.Modal(document.getElementById('modal_nilai_transfer'))
        modal.show()
    }

    function simpan(e) {
        var formData = new FormData(e)
        fetch('<?= base_url('konversi/simpan/nilai_transfer/') ?>', { method: 'POST', body: formData })
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
                url     : "<?= base_url('konversi/json_nilai_transfer') ?>",
                type    : 'GET',
                data : function(d) {
                    d.id_aktivitas = '<?= sha1($anggota->id_aktivitas) ?>';
                    d.id_mahasiswa_pt = '<?= $anggota->id_mahasiswa_pt ?>';
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
                { targets: [1,2,3,4,5,6,7,8,9,10], className: 'text-center', orderable: false},
            ],
            // order: [[4, 'asc']],
            ordering: false,
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