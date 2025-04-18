<div class="d-flex flex-column flex-fill">

    <div class="bg-gray-300 d-flex flex-column-reverse flex-fill min-h-0 overflow-auto scrollable-content p-4 rounded-3">
        <div class="justify-content-end">
            <?php
            if($percakapan->result())
            {
                foreach($percakapan->result() as $key=>$value)
                {
                    if($value->nama_user == $_SESSION['nama_pengguna']){
                        echo '
                        <div class="d-flex justify-content-end mb-2" onclick="hapus_percakapan(`'.$value->id_bimbingan.'`)" style="cursor:pointer">
                            <div class="bubble bubble-primary">
                                <p class="mb-1">'.$value->isi.'</p>
                                <small class="text-muted">'.$value->created_at.'</small>
                            </div>
                        </div>';
                    }else{
                        echo '
                        <div class="d-flex mb-2">
                            <div class="bubble">
                                <p class="mb-1"><strong>'.$value->nama_user.'</strong></p>
                                <p class="mb-1">'.$value->isi.'</p>
                                <small class="text-muted">'.$value->created_at.'</small>
                            </div>
                        </div>';
                    }
                }
            }else{
                
            }
            ?>
        </div>
    </div>

</div>