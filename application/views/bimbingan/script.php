<script>
	var is_open = false
	var source = new EventSource('/bimbingan/sse')
	var offline

	source.onmessage = function(event) {
		if (!(document.activeElement.tagName === "INPUT")) {
			if (areAllInputsEmpty() && is_open == false) {
				bimbingan()
			}
		}
	}

	window.addEventListener('focus', function (e) {
		if (is_open) {
			is_open = false
		}
	})

	function areAllInputsEmpty() {
	    var inputs = document.querySelectorAll('.bimbingan input');
	    for (const input of inputs){
	        if (input.value !== '') {
	    		input.focus()
	        	return false;
	        }
	    }
	    
	    return true;
	}

	function bimbingan()
	{
		fetch('/bimbingan/bimbingan/<?= $aktivitas->id_aktivitas.'/'.$jenis_bimbingan ?>')
		.then(response => response.text())
		.then(text => {
			document.querySelector('.bimbingan').innerHTML = text
		})
		.then( () => {
			timeago.render(document.querySelectorAll(".timeago"), "id_ID")
		})
	}

	var upload;
	function lampirkan_berkas(e) {
		e.parentElement.parentElement.parentElement.children[0].children[1].focus()
		e.parentElement.children[2].innerHTML = `<span class="overflow-hidden" style="width: 200px; text-overflow: ellipsis;">${e.files[0].name}</span> - <a onclick="reset(this, event)" class="text-danger">hapus</a>`
		upload = e
	}

	function reset(e, event) {
		event.preventDefault()
		var inputFile = e.parentElement.parentElement.children[0]
		var label = e.parentElement

		inputFile.value = ''
		label.innerHTML = 'Lampirkan Berkas (Maks. 5 MB)'
		is_open = false
	}

	function kirim(e, event=null) {
		if (event) {
			if (e.value != '' && event.keyCode == '13') {
				e.setAttribute('disabled', 'true')
				var formData = new FormData()
				formData.append('isi', e.value)
				formData.append('id_parent', e.dataset.id_parent)
				formData.append('id_aktivitas', e.dataset.id_aktivitas)
				formData.append('jenis_bimbingan', e.dataset.jenis_bimbingan)
				formData.append('id_kegiatan', e.dataset.id_kegiatan)
				
				if (upload)
					formData.append('file', upload.files[0])

				fetch('/bimbingan/kirim', {
					method: 'POST',
					body: formData
				})
				.then(response => response.text())
				.then(text => {
					if (text) {
						alert(text)
					}
					
					upload = null
					is_open = false
					bimbingan()
				})
			}
		} else {
			var formData = new FormData(e)
			fetch('/bimbingan/kirim', {
				method: 'POST',
				body: formData
			})
			.then(response => response.text())
			.then(text => {
				if (text) {
					alert(text)
					bimbingan()
					return
				}

				e.reset()
				bimbingan()
			})
			.catch((error) => {
			  	console.log(error)
			});

			return 
		}
	}

	function hapus_bimbingan(e) {
		var konfirmasi = confirm('Hapus Bimbingan Dipilih ?')
		if (konfirmasi) {
			var inputs = document.querySelectorAll('.bimbingan input');
		    for (const input of inputs) {
		    	input.setAttribute('disabled', 'true')
		    }

			fetch('/bimbingan/hapus', {
				method: 'POST',
				body: new URLSearchParams({ 
					id_bimbingan: e.dataset.id_bimbingan, 
					file: e.dataset.file
				})
			})
			.then(response => response.text())
			.then(text => {
				bimbingan()
				is_open = false
			})
		}
	}

</script>