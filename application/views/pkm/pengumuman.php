<?php

// configuration
$url = base_url('pkm/pengumuman/');
$file =APPPATH.'.pengumuman';

// check if form has been submitted
if (isset($_POST['isi_berita']))
{
    // save the text contents
    file_put_contents($file, $_POST['isi_berita']);

    // redirect to form again
    header(sprintf('Location: %s', $url));
    printf('<a href="%s">Moved</a>.', htmlspecialchars($url));
    exit();
}

// read the textfile
$text = file_get_contents($file);

?>
<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		    <div class="col-12 mb-3">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
					<form method="post" action="">
					    <textarea id="isi_berita" name="isi_berita" class="form-control mt-3" rows="20" placeholder="Pengumuman"><?php echo htmlspecialchars($text) ?></textarea>
					    <div class="mt-3 d-grid gap-2">
                            <input type="submit" value="SIMPAN" class="btn btn-info">
					    </div>
				    </form>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.tiny.cloud/1/euelv3wjksq6s3ph6qk546lit81gvn8cdaosi9ep1ftlkp1v/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
	selector: 'textarea#isi_berita',
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
</script>