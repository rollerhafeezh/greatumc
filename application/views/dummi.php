<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		
			<div class="col mb-4">
				<div class="card h-100">
					<div class="card-body d-flex flex-column">
						<div class="card-title">
							<h5>Contoh Text</h5>
						</div>
						<p class="text-muted"></p>

						<div class="mt-auto">
							<a class="btn-link" href="#">Contoh Tautan</a>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>
<script>
function simpan_nilai()
{
	Toastify({ text: "Nilai Tersimpan",	style: { background: "<?=$_ENV['CLR_SUC']?>",	} }).showToast();
}
function simpan_komentar()
{
	Toastify({ text: "Gagal Tersimpan",	style: { background: "<?=$_ENV['CLR_PRI']?>",	} }).showToast();
}
function ref_prodi()
{
    var kode_fak = document.getElementById('kode_fak').value;
    let url = "<?=base_url('utama/ref_prodi/')?>"+kode_fak;
    
    fetch(url)
        .then((response) => response.text())
        .then((text) => {
            document.getElementById('kode_prodi').innerHTML = text;
        });
}
function ref_ruangan_kuliah()
{
	var element 	= document.getElementById('id_ruangan');
	var id_gedung 	= document.getElementById('id_gedung').value;
	var hari_kuliah = document.getElementById('hari_kuliah').value;
	var id_smt 		= document.getElementById('id_smt').value;
	var jam_mulai 	= document.getElementById('jam_mulai').value;
	var jam_selesai = document.getElementById('jam_selesai').value;
	
	element.disabled = true;
	fetch('<?=base_url('kelas/ref_ruangan_kuliah/')?>', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
			},
			body: JSON.stringify({
				id_gedung	: id_gedung,
				hari_kuliah	: hari_kuliah,
				id_smt		: id_smt,
				jam_mulai	: jam_mulai,
				jam_selesai	: jam_selesai,
			})
	})
	.then((response) => response.text())
	.then((text) => {
		element.disabled = false;
		element.focus();
		document.getElementById('id_ruangan').innerHTML = text;
	})
	.catch(error => {
		console.log(error)
	})  
}
</script>