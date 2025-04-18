<style>
.kecil{
    font-size:80%;
}
</style>
<header>
<table border="0" width="100%" class="kecil">
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
<table border="0" width="100%" cellspacing="0" cellpadding="5">
    <tr>
        <td align="center"><h3>DAFTAR HADIR <?=strtoupper($jenis)?></h3></td>
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
                <tr>
                    <td valign="top">Jadwal <?=strtoupper($jenis)?></td>
                    <td>
                        <?php
                            if($jenis=='uts')
                            {
                                if($kelas->tgl_uts)
                                {
                                    ?>
                    <?=tanggal_indo($kelas->tgl_uts)?><br><?=$kelas->jam_mulai_uts?> sd <?=$kelas->jam_selesai_uts?><br>
					G. <?=$kelas->nama_gedung_uts?> R. <?=$kelas->nama_ruangan_uts?>
                                    <?php
                                }
                            }
                            if($jenis=='uas')
                            {
                                if($kelas->tgl_uas)
                                {
                                    ?>
                    <?=tanggal_indo($kelas->tgl_uas)?><br><?=$kelas->jam_mulai_uas?> sd <?=$kelas->jam_selesai_uas?><br>
					G. <?=$kelas->nama_gedung_uas?> R. <?=$kelas->nama_ruangan_uas?>
                                    <?php
                                }
                            }
                        ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br>
<table border="1" width="100%" cellspacing="0" cellpadding="5">
    <thead>
    <tr>
        <td align="center">No</td>
        <td align="center">NIM</td>
        <td align="center">Nama</td>
        <td align="center">Paraf</td>
    </tr>
    </thead>
    <?php
    $nilai = $this->Main_model->get_mhs_kelas($kelas->id_kelas_kuliah)->result();
    //$nilai = $this->Ujian_model->peserta_ujian_absen($kelas->id_kelas_kuliah,strtoupper($jenis),$pertemuan->id_bap_kuliah)->result();
    if($nilai)
    {
        $co=1;
        foreach($nilai as $key=>$value)
        {
            echo'
            <tr>
                <td align="center">'.$co.'</td>
                <td align="center">'.$value->id_mahasiswa_pt.'</td>
                <td>'.$value->nm_pd.'</td>
                <td align="center">&nbsp;</td>
            </tr>
            ';
        
        $co++;
        }
    }
    ?>
</table>
<br>
<table border="0" width="100%" cellspacing="0" cellpadding="5">
    <tr>
        <td align="center">Pengawas
        <br><br><br><br>
        .............................
        </td>
        <td align="center">Penguji
        <br><br><br><br>
        .............................
        </td>
    </tr>
</table>