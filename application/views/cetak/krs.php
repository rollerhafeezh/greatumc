<?php if($status_bayar['hasil']=='1'){ ?>
<style>
table{
    font-size:60%;
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
				<h2 class="p-0 m-0 nama-fakultas"><?=$mahasiswa_pt->nama_fak?> - <?=strtoupper($mahasiswa_pt->nama_prodi)?></h2>

				<p class="alamat-kop">Kampus 1 : Jl. Tuparev No. 70 Cirebon 45153 Telp. +62-231-209608, +62-231-204276, Fax: +62-231-209608</p> 
				<p class="alamat-kop">Kampus 2 dan 3: Jl. Fatahillah - Watubelah - Cirebon Email: <a href="mailto:info@umc.ac.id">info@umc.ac.id</a> Website: <a href="https://umc.ac.id">www.umc.ac.id</a></p>
				<br>
			</center>
		</td>
	</tr>
</table>
<div style="width: 100%;height: 2px;background-color: #000; margin-bottom: 1px; margin-top: 5px"></div>
<div style="width: 100%;height: 1px;background-color: #000; margin-bottom: 5px;"></div>
</header>
<table border="0" width="100%">
	<tr>
		<td>
			<center>
				<h4 class="p-0 m-0 nama-pt">KARTU RENCANA STUDI</h4>
			</center>
		</td>
	</tr>
</table>
<div style="margin-bottom: 5px;"></div>
<table border="0" width="100%">
	<tr>
		<td width="15%"><strong>NIM</strong></td>
		<td><?=$mahasiswa_pt->id_mahasiswa_pt?></td>
		<td width="10%"><strong>Semester</strong></td>
		<td><?=nama_smt($id_smt)?></td>
	</tr>
	<tr>
		<td width="15%"><strong>Nama Mahasiswa</strong></td>
		<td><?=$mahasiswa_pt->nm_pd?></td>
		<td width="10%"><strong>Homebase</strong></td>
		<td><?=$mahasiswa_pt->nama_fak?> - <?=$mahasiswa_pt->nama_prodi?></td>
	</tr>
</table>
<br>
<table border="1" width="100%" cellpadding="5" cellspacing="0">
		<thead>
		    <tr>
		        <th>Mata Kuliah - Kelas</th>
			    <th>SKS</th>
			    <th>Jadwal</th>
			    <th>Validasi</th>    
		    </tr>
		</thead>
		<tbody>
		<?php
		$total_sks=0;
		if($list_kelas_krs->result())
		{
			foreach($list_kelas_krs->result() as $key=>$value){
				$total_sks+=$value->sks_mk;
				$warna_validasi='<span class="badge bg-warning">n/a</a>';
				if($value->status_krs==0)
				{
					$warna_validasi='<span class="badge bg-danger">belum</a>';
				}else if($value->status_krs==1)
				{
					$btn_aksi = '';
					$warna_validasi='<span class="badge bg-info">sudah validasi</a>';
				}else if($value->status_krs==2)
				{
					$btn_aksi = '';
					$warna_validasi='<span class="badge bg-success">sudah dikelas</a>';
				}
				if($krs_note) $btn_aksi = '';
				
			echo'
			<tr>
				<td>'.$value->kode_mk.' '.$value->nm_mk.' '.$value->nm_kls.'</td>
				<td align="center">'.$value->sks_mk.'</td>
				<td>
					'.nama_hari($value->hari_kuliah).',  
					'.$value->jam_mulai.' s/d
					'.$value->jam_selesai.'<br>
					G. '.$value->nama_gedung.' R. '.$value->nama_ruangan.'
				</td>
				<td>'.$warna_validasi.'</td>
			</tr>
			';
			}
			echo'
			</tbody>
			<tfoot>
			<tr>
                <th>TOTAL SKS</th>
				<th>'.$total_sks.'</th>
				<th colspan="2">&nbsp;</th>
			</tr>
			</tfoot>
		</table>	
			';
		}else{
			echo'<tr><td colspan="4">n/a</a></tbody>
	</table>';
		}
		?>
<br>
<?php if($krs_note) { ?>
<table border="0" width="100%">
	<tr align="center">
		<td colspan="2"><h1>Validasi</h1></td>
	</tr>
	<tr align="center">
		<td width="50%"><strong>Mahasiswa</strong></td>
		<td width="50%"><strong>Dosen Wali</strong></td>
		
	</tr>
	<tr align="center">
		<td><?=$krs_note->created_at?><br><strong><?=$mahasiswa_pt->nm_pd?></strong></td>
		<td><?=$krs_note->tgl_validasi?><br><strong><?=$krs_note->validasi?></strong></td>
	</tr>
</table>
<?php } }else{ echo '<div class="card p-3 text-danger">'.$status_bayar['message'].'</div>'; } ?>