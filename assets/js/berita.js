var $summernote = $('#isi_berita').summernote({
    placeholder: 'Isi Berita',
    tabsize: 2,
    height: 500,
    toolbar: [
      ['style', ['style']],
      ['font', ['bold', 'underline', 'clear']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['table', ['table']],
      ['insert', ['link', 'picture', 'video']],
      ['view', ['fullscreen', 'codeview', 'help']]
    ],
    
   callbacks: {
        onImageUpload: function (files) {
            sendFile($summernote, files[0]);
        } 
    }
     
});

function sendFile($summernote, file) {
    formData = new FormData();
    formData.append('file', file);
    //console.log(file);
    $.ajax({
        url:'https://greatsys.umc.ac.id/berita/unggah_gambar_v2',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (data) {
            //console.log(data);
            $summernote.summernote('insertImage', data, function ($image) {
                $image.attr('src', data);
            });
            
        }
    });
}