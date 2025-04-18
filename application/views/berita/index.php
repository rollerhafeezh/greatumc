<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
		    <div class="col-12 mb-3">
				<div class="card h-100">
				    <div class="card-body d-flex flex-column">
				        <?php if($_SESSION['app_level']==3 || $_SESSION['app_level']==4) { ?>
				        <h2><a href="<?=base_url('berita/buat')?>" class="text-decoration-none">Buat Berita</a></h2>
				        <?php } ?>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Judul Berita</th>
                <th>Oleh</th>
                <?php if($_SESSION['app_level']==3 || $_SESSION['app_level']==4) { ?>
                <th>Hapus</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
<?php
$this->load->helper('text');
$daftar=$this->Main_model->get_berita(null,1,25)->result();
if($daftar){
    foreach($daftar as $key=>$value){
        $lempar = str_replace('=','',base64_encode($value->id_berita));
?>
    <tr>
        <td><?=format_indo($value->created_at)?>
        <td><a href="<?=base_url('berita/baca/'.$lempar)?>" class="text-decoration-none"><?=word_limiter($value->judul_berita,15)?></a></td>
        <td><?=$value->pembuat_berita?>
        <?php if($_SESSION['app_level']==3 || $_SESSION['app_level']==4) { ?>
        <td><ahref="<?=base_url('berita/hapus/'.$value->id_berita)?>" onclick="return confirm('Yakin?')" class="text-decoration-none">hapus?</a></td>
        <?php } ?>
    </tr>
<?php 
}
}else{ echo'<tr><td colspan="2"><em class="text-muted">Belum ada berita</em></td></tr>'; }
?>
        <tbody>
    </table>
</div>
			        </div>
                </div>
            </div>
        </div>
    </div>
</div>
