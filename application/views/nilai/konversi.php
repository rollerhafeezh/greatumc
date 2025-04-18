<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">

			<div class="col mb-4">
				<div class="card">
					<div class="card-body">
					    <h4>Perhatian : Form ini akan menyimpan nilai! Pastikan tidak melakukan lebih dari 1 kali proses</h4>
					    <form method="post" action="<?=base_url('nilai/simpan_konv')?>">
					        <input type="hidden" name="id_mahasiswa_pt" value="<?=$mahasiswa_pt->id_mahasiswa_pt?>">
					        <input type="hidden" name="id_mhs" value="<?=$mahasiswa_pt->id_mhs?>">
<div class="table-responsive">
    <table class="table table-sm">
        <thead>
            <tr>
                <th colspan="4">Nilai Asal</th>
                <th colspan="4">Nilai Konversi</th>
            </tr>
            <tr>
                <th>Kode MK Asal</th>
                <th>Nama MK Asal</th>
                <th>SKS MK Asal</th>
                <th>Nilai MK Asal</th>
                <th>Kode MK Diakui</th>
                <th>Nama MK Diakui</th>
                <th>SKS MK Diakui</th>
                <th>Nilai MK Diakui</th>
            </tr>
        </thead>
        <tbody>
        <?php
            if($mata_kuliah_kurikulum)
            {
                foreach($mata_kuliah_kurikulum as $key=>$value)
                {
                    $matkul_konv = $this->Nilai_model->get_mk($value->id_matkul_konv)->row();
                    $nilai_konv = $this->Nilai_model->get_nilai($value->id_matkul_konv,$mahasiswa_pt->id_mahasiswa_pt)->row();
                    if($matkul_konv)
                    {
                        $kode_mk_konv   = $matkul_konv->kode_mk;
                        $nm_mk_konv     = $matkul_konv->nm_mk;
                        $sks_mk_konv    = $matkul_konv->sks_mk;
                    }else{
                        $kode_mk_konv   = '';
                        $nm_mk_konv     = '';
                        $sks_mk_konv    = '';
                    }
                    
                    if($nilai_konv->nilai_indeks)
                    {
                        switch($nilai_konv->nilai_indeks)
                        {
                            case 4 : $nilai_huruf = 'A'; break;
                            case 3 : $nilai_huruf = 'B'; break;
                            case 2 : $nilai_huruf = 'C'; break;
                            case 1 : $nilai_huruf = 'D'; break;
                            default : $nilai_huruf = 'E'; break;
                        }
                        $nilai_akui = $nilai_konv->nilai_indeks;
                        echo'
                        <input type="hidden" name="kode_mk_asal[]" value="'.$kode_mk_konv.'">
                        <input type="hidden" name="nm_mk_asal[]" value="'.$nm_mk_konv.'">
                        <input type="hidden" name="sks_asal[]" value="'.$sks_mk_konv.'">
                        <input type="hidden" name="sks_diakui[]" value="'.$value->sks_mk.'">
                        <input type="hidden" name="nilai_huruf_asal[]" value="'.$nilai_huruf.'">
                        <input type="hidden" name="nilai_huruf_diakui[]" value="'.$nilai_huruf.'">
                        <input type="hidden" name="nilai_angka_diakui[]" value="'.$nilai_akui.'">
                        <input type="hidden" name="id_matkul[]" value="'.$value->id_matkul.'">
                        ';
                    }else{
                        $nilai_akui = '';
                        $nilai_huruf = '';
                    }
                    
                   echo'
                   <tr>
                        <td>'.$kode_mk_konv.'</td>
                        <td>'.$nm_mk_konv.'</td>
                        <td>'.$sks_mk_konv.'</td>
                        <td>'.$nilai_huruf.'</td>
                        <td>'.$value->kode_mk.'</td>
                        <td>'.$value->nm_mk.'</td>
                        <td>'.$value->sks_mk.'</td>
                        <td>'.$nilai_huruf.'</td>
                    </tr>
                   '; 
                }
            }else{
                echo '<tr><td colspan="8"><em>tidak ada kurikulum Aktif</em></td></tr>';
            }
        ?>
        </tbody>
    </table>
</div>
                    <input class="btn btn-info" onclick="return confirm('are you sure?')" type="submit" value="Simpan">
                    </form>
					 </div>
			    </div>
			</div>
		
		</div>
	</div>
</div>