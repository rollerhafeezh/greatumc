<?php

// configuration
$url = base_url('pkm/pengumuman/');
$file =APPPATH.'.pengumuman';
// read the textfile
$text = file_get_contents($file);

?>
<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
			<div class="col mb-2">
			    <div class="card">
			        <div class="card-body">
                        <div class="clearfix">
                            <?php echo $text; ?>
                        </div>
                    </div>
			    </div>
			</div>
	    </div>
	</div>
</div>
