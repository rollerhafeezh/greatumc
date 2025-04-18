<div class="content__boxed">
	<div class="content__wrap">
        <form class="row" method="POST" action="<?= base_url('mbkm/simpan/berita') ?>" enctype="multipart/form-data">
			<div class="col-md-4">
            	<div class="form-group mb-3">
                    <label for="cover" class="form-label">
            			<img src="<?= base_url('assets/images/cover.png') ?>" class="img-fluid rounded" id="pratinjau_cover" alt="">
        			</label>
                    <input type="file" name="cover" class="form-control" accept="image/*" id="cover" onchange="(document.querySelector('#pratinjau_cover').src = this.files[0] ? window.URL.createObjectURL(this.files[0]) : '<?= base_url('assets/images/cover.png') ?>') ">
                </div>
			</div>
			<div class="col-md-8 mb-3">
				<div class="card">
					<div class="card-body">
						<div class="row">
                            <div class="col-md-12">
                            	<div class="form-group mb-3">
	                                <label for="judul" class="form-label">Judul Berita <span class="text-danger">*</span></label>
	                                <input type="text" name="judul" id="judul" required="" class="form-control" placeholder="Masukan Judul Berita Disini">
                            	</div>
                            	<style type="text/css">
									.tox {
										border-radius: .4375rem;
									}
								</style>
	                            <div class="form-group mb-3">
	                                <label for="isi" class="form-label">Isi Berita <span class="text-danger">*</span></label>
	                                <textarea name="isi" id="isi" class="form-control" rows="8"></textarea>
	                            </div>
	                            <div class="form-group mb-3">
	                                <label for="tags" class="form-label">Tags Berita <span class="text-danger">*</span></label>
	                            	<p>Tekan <span class="badge bg-info">Enter</span> untuk menambahkan tag berita.</p>
	                                <select class="form-select" id="tags" name="tags[]" multiple data-allow-new="true" data-allow-clear="true"></select>
	                            </div>

	                            <div class="row">
		                            <div class="col-6 form-group mb-3">
		                                <label for="published_at" class="form-label">Tanggal Terbit <span class="text-danger">*</span></label>
		                                <input type="date" name="published_at" id="published_at" required="" value="<?= date('Y-m-d') ?>" class="form-control">
		                            </div>
		                            <div class="col-6 form-group mb-3">
		                                <label for="penulis" class="form-label">Penulis Berita <span class="text-danger">*</span></label>
		                                <input type="text" name="penulis" id="penulis" required="" value="<?=$_SESSION['nama_pengguna'].' ('.$_SESSION['level_name'].')'?>" class="form-control">
		                            </div>
	                            </div>
                            </div>
                            
                            <div class="col-6">
                            	<a href="<?= base_url('berita') ?>" class="btn btn-danger w-100"><i class="psi-left-4 me-1"></i> Kembali</a>
                            </div>
                            <div class="col-6">
                            	<button class="btn btn-info w-100"><i class="psi-paper-plane me-1"></i> Simpan Data</button>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</form>
	</div>
</div>

<script src="https://cdn.tiny.cloud/1/euelv3wjksq6s3ph6qk546lit81gvn8cdaosi9ep1ftlkp1v/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
	// Wait for the document to fully load.
	window.addEventListener( "DOMContentLoaded", async () => {


	    // Import and initialize the Bootstrap 5 Tags.
	    try {
	        const { default: Tags } = await import( "https://cdn.jsdelivr.net/gh/lekoala/bootstrap5-tags@master/tags.min.js" );
	        Tags.init();
	    } catch (error) {
	        console.error( "Couln't import Bootstrap 5 Tags Plugins" );
	    }


	    // Initialize the Tagin plugin
	    for ( const el of document.querySelectorAll( ".tagin" ) ) {
	        tagin(el)
	    }
	})

	tinymce.init({
		selector: 'textarea#isi',
		plugins: 'importcss image media advlist lists wordcount paste table fullscreen',
		menubar: false,
		toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify |  numlist bullist | table | image | removeformat | fullscreen',
		toolbar_mode: 'wrap',
		content_css: [
			'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
			'//www.tiny.cloud/css/codepen.min.css'
		],
		importcss_append: true,
		/*init_instance_callback: function (editor){
			editor.on('blur', function(e){
				//simpan_jawaban()
			});
		},
	    */
		images_upload_handler: function (blobInfo, success, failure) {
			var xhr, formData;
			xhr = new XMLHttpRequest();
			xhr.withCredentials = false;
			xhr.open('POST', '<?=base_url('berita/unggah_gambar')?>');
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
		height: 400,
		paste_as_text: true,
		relative_urls : false,
		remove_script_host : false,
	 });

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