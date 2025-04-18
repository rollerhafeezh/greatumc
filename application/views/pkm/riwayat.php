<div class="table-responsive">
<table class="table table-striped" style="width:100%">
<thead>
    <tr>
        <th>Waktu</th>
        <th>Aktor</th>
        <th>Aksi</th>
    </tr>
</thead>
<tbody>
    <?php
    if($riwayat->result())
    {
        foreach($riwayat->result() as $key=>$value)
        {
            echo '<tr>
                <td>'.$value->created_at.'</td>
                <td>'.$value->siapa.'</td>
                <td>'.$value->ngapain.'</td>
            </tr>';
        }
    }else{
        
    }
    ?>
</tbody>
</table>
</div>