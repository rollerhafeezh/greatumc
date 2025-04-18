<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		
			<div class="col-md-6 mb-4">
				<div class="card">
					<div class="card-body d-flex flex-column text-center">
						<video id="preview"></video>
						<div class="mt-2" id="pilih_kamera"></div>
						<div class="mt-2" id="pesan_pilih_kamera"></div>
					</div>
				</div>
			</div>
			<div class="col-md-6 mb-4">
				<div class="card">
					<div class="card-body d-flex flex-column">
						<input pattern="[A-Za-z0-9]" type="text" autofocus id="kode_ujian" onchange="aktif_mulai()" class="form-control" placeholder="Scan QRcode atau Masukkan Kode Ujian">
						<div class="m-2 d-grid gap-2">
							<button id="tombol_mulai" onclick="detail_ujian()" class="btn btn-primary" disabled>Dapatkan Detail Ujian</button>
						</div>
						<div id="detail_ujian"></div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>
<script src="https://cdn.jsdelivr.net/gh/schmich/instascan-builds@master/instascan.min.js"></script>
<script type="text/javascript">
	function detail_ujian()
	{
		var kode_ujian = document.getElementById("kode_ujian").value
		fetch('<?= base_url('dhmd/get_detail_ujian/') ?>'+kode_ujian, {
			method: 'post',
		}).then( response => {
			return response.text()
		}).then( text => {
			document.querySelector('#detail_ujian').innerHTML=text
		}).catch( err => {
			console.warn(err)
		})
	}
	
	function aktif_mulai()
	{
		document.getElementById("tombol_mulai").removeAttribute("disabled");
	}
	
	let scanner = new Instascan.Scanner({ video: document.getElementById('preview'), mirror: false});
      scanner.addListener('scan', function (content) {
        document.getElementById("kode_ujian").value = content;
		document.getElementById("tombol_mulai").removeAttribute("disabled");
      });
      
	let nama_kamera = "";
	Instascan.Camera.getCameras().then(function (cameras) {
		var selectedCamera = cameras[0]
		if(cameras.length > 0){
			cameras.forEach((element, index) => { 
				nama_kamera +=  '<button class="btn btn-success m-1" onclick="return changeCamera('+index+')">'+element.name.toUpperCase()+'</button>';
				
				if (element.name.indexOf('back') != -1 || element.name.indexOf('Belakang') != -1) {
					selectedCamera = element;
					return false;
				}
			})
			
			scanner.start(selectedCamera);
		}else{
			document.getElementById("pesan_pilih_kamera").innerHTML = "Kamera tidak ditemukan. Pastikan perangkat anda memiliki kamera."
		}
		document.getElementById("pilih_kamera").innerHTML = nama_kamera;
	}).catch(function (e) {
		console.error(e);
	});
	
	
	
	function changeCamera(e) {
		Instascan.Camera.getCameras().then(function (cameras) {
			console.log(e)
			scanner.start(cameras[e]);
		}).catch(function (e) {
			document.getElementById("pesan_pilih_kamera").innerHTML = "Untuk memilih kamera ini, silahkan Refresh halaman."
		});
	}
</script>