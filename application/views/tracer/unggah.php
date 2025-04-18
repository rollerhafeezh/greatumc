<div class="content__boxed">
	<div class="content__wrap">
		<div class="row">
			<div class="col mb-4">
				<div class="card h-100">
					<div class="card-body">
<form method="post" class="row g-3" action="" enctype="multipart/form-data">
    <input type="file" accept=".xlsx" name="data_responden">
    <input type="submit" value="simpan">
</form>
<?php
class FirstRowFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter
{
    public function readCell($column, $row, $worksheetName = '') {
        
        return $row > 1;
    }
}    
    if (isset($_FILES['data_responden'])) {
        $tgl_sekarang = date('YmdHis');
        $nama_file_baru = 'data' . $tgl_sekarang . '.xlsx';
        
        if (is_file('tmp/' . $nama_file_baru)) unlink('tmp/' . $nama_file_baru);
        $ext = pathinfo($_FILES['data_responden']['name'], PATHINFO_EXTENSION); 
        $tmp_file = $_FILES['data_responden']['tmp_name'];
        
        if ($ext == "xlsx") {
           
            move_uploaded_file($tmp_file, 'tmp/' . $nama_file_baru);
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $filterRow = new FirstRowFilter();
            //$reader->setReadFilter($filterRow);
            
            $spreadsheet = $reader->load('tmp/' . $nama_file_baru);
            $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
$buang = array('\'','+');
            foreach ($sheet as $row) {
$data['kode_pt']=($row['A'])?:NULL;
$data['kode_prodi']=($row['B'])?:NULL;
$data['nim']=($row['C'])?:NULL;
$data['nama']=($row['D'])?:NULL;
$data['hp']=($row['E'])?str_replace($buang,'',$row['E']):NULL;
$data['tahun']=($row['F'])?:NULL;
$data['npwp']=($row['G'])?:NULL;
$data['f8']=($row['H'])?:NULL;
$data['f502']=($row['I'])?:NULL;
$data['f504']=($row['J'])?:NULL;
$data['f1101']=($row['K'])?:NULL;
$data['f5b']=($row['L'])?:NULL;
$data['f5c']=($row['M'])?:NULL;
$data['f5d']=($row['N'])?:NULL;
$data['f18a']=($row['O'])?:NULL;
$data['f18b']=($row['P'])?:NULL;
$data['f18c']=($row['Q'])?:NULL;
$data['f18d']=($row['R'])?:NULL;
$data['f1201']=($row['S'])?:NULL;
$data['f14']=($row['T'])?:NULL;
$data['f15']=($row['U'])?:NULL;
$data['f301']=($row['V'])?:NULL;
$data['f302']=($row['W'])?:NULL;
$data['f303']=($row['X'])?:NULL;
$data['f401']=($row['Y'])?:NULL;
$data['f402']=($row['Z'])?:NULL;
$data['f403']=($row['AA'])?:NULL;
$data['f404']=($row['AB'])?:NULL;
$data['f405']=($row['AC'])?:NULL;
$data['f406']=($row['AD'])?:NULL;
$data['f407']=($row['AE'])?:NULL;
$data['f408']=($row['AF'])?:NULL;
$data['f409']=($row['AG'])?:NULL;
$data['f410']=($row['AH'])?:NULL;
$data['f411']=($row['AI'])?:NULL;
$data['f412']=($row['AJ'])?:NULL;
$data['f413']=($row['AK'])?:NULL;
$data['f414']=($row['AL'])?:NULL;
$data['f415']=($row['AM'])?:NULL;
$data['f6']=($row['AN'])?:NULL;
$data['f7']=($row['AO'])?:NULL;
$data['f7a']=($row['AP'])?:NULL;
$data['f1001']=($row['AQ'])?:NULL;
$data['f1601']=($row['AR'])?:NULL;
$data['f1602']=($row['AS'])?:NULL;
$data['f1603']=($row['AT'])?:NULL;
$data['f1604']=($row['AU'])?:NULL;
$data['f1605']=($row['AV'])?:NULL;
$data['f1606']=($row['AW'])?:NULL;
$data['f1607']=($row['AX'])?:NULL;
$data['f1608']=($row['AY'])?:NULL;
$data['f1609']=($row['AZ'])?:NULL;
$data['f1610']=($row['BA'])?:NULL;
$data['f1611']=($row['BB'])?:NULL;
$data['f1612']=($row['BC'])?:NULL;
$data['f1613']=($row['BD'])?:NULL;
$data['f505']=($row['BE'])?:NULL;
$data['f5a1']=($row['BF'])?:NULL;
$data['f5a2']=($row['BG'])?:NULL;
$data['f1761']=($row['BH'])?:NULL;
$data['f1762']=($row['BI'])?:NULL;
$data['f1763']=($row['BJ'])?:NULL;
$data['f1764']=($row['BK'])?:NULL;
$data['f1765']=($row['BL'])?:NULL;
$data['f1766']=($row['BM'])?:NULL;
$data['f1767']=($row['BN'])?:NULL;
$data['f1768']=($row['BO'])?:NULL;
$data['f1769']=($row['BP'])?:NULL;
$data['f1770']=($row['BQ'])?:NULL;
$data['f1771']=($row['BR'])?:NULL;
$data['f1772']=($row['BS'])?:NULL;
$data['f1773']=($row['BT'])?:NULL;
$data['f1774']=($row['BU'])?:NULL;
$data['f21']=($row['BV'])?:NULL;
$data['f22']=($row['BW'])?:NULL;
$data['f23']=($row['BX'])?:NULL;
$data['f24']=($row['BY'])?:NULL;
$data['f25']=($row['BZ'])?:NULL;
$data['f26']=($row['CA'])?:NULL;
$data['f27']=($row['CB'])?:NULL;
            
            $proses = $this->Tracer_model->simpan_tracer($data);
            if($proses)
            {
                echo 'Tersimpan<br>';
            }else{
                echo 'Gagal<br>';
            }
            }
            
        } else { 
            echo "<div style='color: red;margin-bottom: 10px;'> Hanya File Excel (.xlsx) yang diperbolehkan </div>";
        }
    
    unlink('tmp/' . $nama_file_baru);
    }
    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>