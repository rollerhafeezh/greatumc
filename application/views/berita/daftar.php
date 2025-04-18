<?php
$this->load->helper('text');
$daftar=$this->Main_model->get_berita(null,1,10)->result();
if($daftar){
    foreach($daftar as $key=>$value){
        $lempar = str_replace('=','',base64_encode($value->id_berita));
?>
<div class="d-flex mb-4">
    <div class="flex-shrink-0">
        <img class="img-sm rounded-circle" src="<?=$_ENV['LOGO_100']?>" alt="Profile Picture" loading="lazy">
    </div>
    <div class="flex-grow-1 ms-3">
        <div class="mb-1">
            <a href="<?=base_url('berita/baca/'.$lempar)?>" class="h6 btn-link"><?=$value->judul_berita?></a>
        </div>
        <small class="d-block text-muted mb-2"><i class="pli-user fs-5"></i> <?=$value->pembuat_berita?> | <i class="pli-clock fs-5"></i> <?=format_indo($value->created_at)?></small>
        <?=word_limiter($value->isi_berita,20)?>
    </div>
</div>
<?php 
}
}else{ echo'<em class="text-muted">Belum ada berita</em>'; }
?>