<style>
table{
    font-size:90%;
}
</style>
<header>
<table border="0" width="100%">
	<tr>
		<td width="1" style="text-align: right">
			<img src="<?= $_ENV['LOGO_100']; ?>" width="70">
		</td>
		<td>
			<center>
				<h3 class="p-0 m-0 nama-pt">UNIVERSITAS MUHAMMADIYAH CIREBON</h3>
				<h2 class="p-0 m-0 nama-fakultas"><?=$kelas->nama_fak?> - <?=strtoupper($kelas->nama_prodi)?></h2>

				<p class="alamat-kop">Kampus 1 : Jl. Tuparev No. 70 Cirebon 45153 Telp. +62-231-209608, +62-231-204276, Fax: +62-231-209608</p> 
				<p class="alamat-kop">Kampus 2 dan 3: Jl. Fatahillah - Watubelah - Cirebon Email: <a href="mailto:info@umc.ac.id">info@umc.ac.id</a> Website: <a href="https://umc.ac.id">www.umc.ac.id</a></p>
				<br>
			</center>
		</td>
	</tr>
</table>
<div style="width: 100%;height: 2px;background-color: #000; margin-bottom: 1px; margin-top: 5px"></div>
<div style="width: 100%;height: 1px;background-color: #000; margin-bottom: 5px;"></div>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center"><h3>REKAPITULASI NILAI</h3></td>
    </tr>
    <tr>
        <td width="80%" valign="top">
            <table border="0" width="100%">
                <tr>
                    <td valign="top">Semester</td>
                    <td><?=nama_smt($kelas->id_smt)?></td>
                </tr>
                <tr>
                    <td valign="top">Fakultas/ Prodi</td>
                    <td><?=$kelas->nama_fak?> - <?=strtoupper($kelas->nama_prodi)?></td>
                </tr>
                <tr>
                    <td valign="top">Kelas</td>
                    <td><?=$kelas->nm_mk?> <?=$kelas->nm_kls?></td>
                </tr>
                <tr>
                    <td>Peserta</td>
                    <td><?=$kelas->count_peserta?> Orang</td>
                </tr>
                <tr>
                    <td valign="top">Pengampu</td>
                    <td>
                        <?php
                            $pengampu=$this->Main_model->pengampu_kelas($kelas->id_kelas_kuliah)->result();
    						if($pengampu)
    						{
    							
    							foreach($pengampu as $keys=>$values)
    							{
    								echo'<strong>'.$values->nidn.'</strong> '.$values->nm_sdm.' ('.$values->sks_subst_tot.' SKS)<br>';
    							}
    							
    						}else{ echo '-'; }
                        ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br>
<table border="1" width="100%" cellspacing="0" cellpadding="3">
    <thead>
    <tr>
        <td align="center">No</td>
        <td align="center">NIM</td>
        <td align="center">Nama</td>
        <td align="center">Kehadiran (<?=$kelas->bobot_hadir?>%)</td>
        <td align="center">UTS (<?=$kelas->bobot_uts?>%)</td>
        <td align="center">UAS (<?=$kelas->bobot_uas?>%)</td>
        <td align="center">Sikap (<?=$kelas->bobot_sikap?>%)</td>
        <td align="center"><?=$kelas->label_a?> (<?=$kelas->bobot_a?>%)</td>
        <td align="center"><?=$kelas->label_b?> (<?=$kelas->bobot_b?>)%</td>
        <td align="center"><?=$kelas->label_c?> (<?=$kelas->bobot_c?>)%</td>
        <td align="center">Nilai Akhir</td>
        <td align="center">Nilai Mutu</td>
    </tr>
    </thead>
    <?php
    $nilai = $this->Dhmd_model->get_nilai($kelas->id_kelas_kuliah)->result();;
    //$nilai = $this->Main_model->get_mhs_kelas($kelas->id_kelas_kuliah)->result();
    //echo '<pre>';
    //var_dump($nilai);
    if($nilai)
    {
        $co=1;
        foreach($nilai as $key=>$value)
        {
            echo'
            <tr>
                <td align="center">'.$co.'</td>
                <td align="center">'.$value->id_mahasiswa_pt.'</td>
                <td>'.$value->nm_pd.($value->id_stat_mhs == 'M' ? ' (KAMPUS MERDEKA)' : '').'</td>
                <td align="center">'.$value->nilai_hadir.'</td>
                <td align="center">'.$value->nilai_uts.'</td>
                <td align="center">'.$value->nilai_uas.'</td>
                <td align="center">'.$value->nilai_sikap.'</td>
                <td align="center">'.$value->nilai_a.'</td>
                <td align="center">'.$value->nilai_b.'</td>
                <td align="center">'.$value->nilai_c.'</td>
                <td align="center">'.$value->nilai_angka.'</td>
                <td align="center">'.$value->nilai_huruf.'</td>
            </tr>
            ';
        
        $co++;
        }
    }
    ?>
</table>
<br>
Berkas ini telah divalidasi per tanggal ...........<br>
*) Dicetak menggunakan <strong>Kertas A4</strong>
<hr>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center">Cirebon, <?=format_indo(date("Y-m-d H:i:s"))?><br><strong>Pengampu</strong></td>
    </tr>    
</table>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
        <?php
        if($pengampu)
		{
			
			foreach($pengampu as $keys=>$values)
			{
				echo'<td align="center"><br><br><br><br><strong>'.$values->nm_sdm.'</strong><br>'.$values->nidn.'</td>';
			}
			
		}
        ?>
    </tr>    
</table>