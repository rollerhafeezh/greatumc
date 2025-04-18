<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		    <div class="col-12 mb-3">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
					<form method="post" action="<?=base_url('berita/simpan/')?>">
					    <input type="text" class="form-control form-control-lg my-3" name="judul_berita" autofocus placeholder="Judul Berita">
					    <textarea id="isi_berita" name="isi_berita" class="form-control mt-3" rows="20" placeholder="Isi Berita"></textarea>
					    <div class="mt-3">Waktu Selesai Berita :</div>
					    <input type="date" class="form-control my-3" name="expired_at" value="<?echo date('Y-m-d', strtotime(date("Y-m-d").'+ 14 Days')); ?>">
					    <div class="mt-3">Penulis Berita :</div>
					    <input type="text" class="form-control my-3" value="<?=$_SESSION['nama_pengguna'].' ('.$_SESSION['level_name'].')'?>" name="pembuat_berita">
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