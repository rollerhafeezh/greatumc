<div class="card h-100">
					<div class="card-body d-flex flex-column">
						<div class="card-title">
							<h5>Aktifitas Perkuliahan <i class="psi-repeat-7 text-info" onclick="get_aktifitas()" style="cursor:pointer"></i></h5>
						</div>

<div class="d-flex align-items-center gap-1 pt-3">
	<input type="file" id="addt_file" style="display:none" onchange="showFileName(this.target)">
	<textarea class="form-control" id="isi_komen" onkeyup="count_char()" placeholder="<?=$_SESSION['nama_pengguna']?> (<?=$_SESSION['level_name']?>), minimal 5 karakter" rows="2" style="resize:none"></textarea>
	<button class="btn btn-icon bg-transparent" onclick="selectFile()">
		<i class="psi-paperclip fs-5"></i>
	</button>
	<button id="kirim_aktifitas" class="btn btn-icon btn-primary" onclick="kirim_aktifitas()" disabled>
		<i class="psi-paper-plane fs-5"></i>
	</button>
</div>
<div class="mt-2" id="file-upload-filename">file maksimal 15MB</div>
<div class="p-2">
	<div class="timeline">
	<?php
		if($aktifitas){
			foreach($aktifitas as $key=>$value){
				$dokumen=($value->addt_file)?'<br><a href="'.$value->addt_file.'" class="text-decoration-none"><i class="psi-paperclip fs-5"></i> dokumen</a>':'';
				$hapus = ($value->nama_pengguna == $_SESSION['nama_pengguna'] && $value->id_user==$_SESSION['id_user'] && $value->level_name==$_SESSION['level_name'])?'onclick="return hapus_aktifitas(`'.$value->id_komen.'`)"':'';
				echo'<div class="tl-entry">
					<div class="tl-point"></div>
					<div class="tl-content card">
						<div class="card-body">
							<h5 class="card-title" style="cursor:pointer" '.$hapus.'>'.$value->nama_pengguna.' ('.$value->level_name.') <small class="text-muted">'.format_indo($value->created_at).'</small></h5>
							'.$value->isi_komen.'
							'.$dokumen.'
							</div>
					</div>
				</div>';
			}
		}else{
			echo'<div class="tl-entry">
        			<div class="tl-point"></div>
					<div class="tl-content card">
						<div class="card-body">
							<h5 class="card-title text-muted">belum ada aktifitas</h5>
						</div>
					</div>
				</div>';
		}
	?>
	</div>
</div>
				</div>
			</div>
<script>
	
</script>