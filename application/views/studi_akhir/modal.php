<!-- Modal Lihat Berkas -->
<div class="modal" id="lihatBerkas" tabindex="-1" aria-labelledby="lihatBerkasLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header bg-primary p-0 py-1">
        <span class="modal-title ms-2 my-1  text-white" style="width: 85%; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">
          <img src="<?= base_url('assets/img/pdf.png') ?>" style="margin-top: -4px;" class="me-1"> 
          <span id="lihatBerkasLabel">Lihat Berkas</span>
        </span>
        <button type="button" class="border border-dark bg-white p-1 btn-close me-2 text-danger" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0 overflow-hidden" >
      	<iframe  id="lihatBerkasFile" src="#" type="application/pdf" class="w-100 h-100"></iframe>
      </div>
    </div>
  </div>
</div>
<!-- Modal Lihat Berkas -->

<script>
  function lihat_berkas(filename, pdf, viewer='<?= base_url() ?>') {
    if (pdf != '') {
      document.getElementById('lihatBerkasLabel').innerHTML = filename
      document.getElementById('lihatBerkasFile').src = viewer + '/assets/plugins/pdfjs/web/viewer.html?file=' + pdf
      console.log(viewer + '/assets/plugins/pdfjs/web/viewer.html?file=' + pdf)
      var myModal = new bootstrap.Modal(document.getElementById('lihatBerkas'))
      myModal.show()
    }
  }
</script>