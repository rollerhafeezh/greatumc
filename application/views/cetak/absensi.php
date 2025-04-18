<style>
table{
    font-size:80%;
}
.kotak
{
    padding:5px;
    border:1px solid black;
    float: left;
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
        <td align="center"><h3>Detail Kelas</h3></td>
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
    <tr>
        <td align="center"><h3>Detail Pertemuan</h3></td>
    </tr>
</table>
<table border="1" width="100%" cellspacing="0" cellpadding="3">
    <thead>
    <tr>
        <td align="center">Ke#</td>
        <td align="center">Tanggal dan Waktu</td>
        <td align="center">Materi</td>
        <td align="center">Dokumentasi</td>
    </tr>
    </thead>
    <?php
    $count_pertemuan=1;
    $pertemuan = $this->Dhmd_model->get_pertemuan($kelas->id_kelas_kuliah)->result();
    if($pertemuan){
        $count_pertemuan=count($pertemuan);
        foreach($pertemuan as $key=>$value){
            $img_cover = ($value->foto)?:base_url('assets/images/umc.jpg');
            echo'
            <tr>
                <td valign="middle" align="center">'.$count_pertemuan.'</td>
                <td>'.nama_hari($value->hari).' '.tanggal_indo($value->tanggal).'<br>
                '.$value->jam_mulai.' s/d '.$value->jam_selesai.'</td>
                <td>'.strtoupper($value->tipe_kuliah).'<br>
                '.$value->materi.'</td>
                <td align="center"><img src="'. $img_cover.'" width="150px"></td>
            </tr>
            ';
            $count_pertemuan--;
        }
    }
    ?>
</table>
<br>
<table border="0" width="100%" cellspacing="0" cellpadding="3">
    <tr>
        <td align="center"><h3>Detail Absensi</h3></td>
    </tr>
</table>
<table border="1" width="100%" cellspacing="0" cellpadding="3">
    <thead>
    <tr>
        <td align="center">NIM</td>
        <td align="center">Nama</td>
        <td align="center">Detail</td>
    </tr>
    </thead>
    <?php
    $get_nilai = $this->Dhmd_model->get_nilai($kelas->id_kelas_kuliah)->result();
    if($get_nilai){
        foreach($get_nilai as $key=>$value){
            $absen = json_decode($value->kehadiran);
            echo'
            <tr>
                <td align="center">'.$value->id_mahasiswa_pt.'</td>
                <td>'.$value->nm_pd.($value->id_stat_mhs == 'M' ? ' (KAMPUS MERDEKA)' : '').'</td><td>';
                    $pertemuan=1;
					$kehadiran=0;
					$count_pertemuan = ($kelas->count_pertemuan!=0)?:1;
					for($i=0; $i<$kelas->count_pertemuan; $i++)
					{
						if($absen){
							if(!empty($absen[$i])){
								if($absen[$i]==1){
									echo '<span class="kotak" style="float: left; color:green">'.$pertemuan.' <img src="'.base_url('assets/img/ok.png').'" style="width:10px"></span>';
									
								}else if($absen[$i]==2){
									echo '<span class="kotak" style="float: left; color:green">'.$pertemuan.' <img src="'.base_url('assets/img/ok.png').'" style="width:10px"></span>';
									
								}else if($absen[$i]==3){
									echo '<span class="kotak" style="float: left; color:green">'.$pertemuan.' <img src="'.base_url('assets/img/ok.png').'" style="width:10px"></span>';
									
								}else{
									echo '<span class="kotak" style="float: left; color:red">'.$pertemuan.' <img src="'.base_url('assets/img/fail.png').'" style="width:10px"></span>';
								}
							}else{
								echo '<span class="kotak" style="float: left; color:red">'.$pertemuan.' <img src="'.base_url('assets/img/fail.png').'" style="width:10px"></span>';
							} 
						}else{
							echo '<span class="kotak" style="float: left; color:red">'.$pertemuan.' <img src="'.base_url('assets/img/fail.png').'" style="width:10px"></span>';
						}
						$pertemuan++;
					}
             echo'</td></tr>
            ';
            $count_pertemuan--;
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