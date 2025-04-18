<?php error_reporting(0); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Rekap Peserta Wisudawan <?= !$prodi->kode_prodi ? '' : 'Program Studi '.$prodi->nama_prodi ?> <?= ucwords(strtolower($fakultas->nama_fak)) ?></title>
	<style type="text/css">
		* {
			font-family: tahoma;
			font-size: 12px;
		}

		.side-border2 tr td {
		    border-right: 1px solid #a9c6c9;
		    border-bottom: 1px solid #a9c6c9;
		}

		a { text-decoration: none }
	</style>
	<script type="text/javascript" src="<?= base_url('assets/plugins') ?>/html5lightbox/jquery.js"></script>
	<script type="text/javascript" src="<?= base_url('assets/plugins') ?>/html5lightbox/html5lightbox.js"></script>
</head>
<body>
	<div style="text-align: center;">
		<b>
			DAFTAR NAMA LULUSAN UNTUK PEMASANGAN NINA DAN PENCETAKAN IJAZAH <br>
            PERIODE LULUS <?= strtoupper(tanggal_indo($this->input->get('mulai'))) ?> s.d <?= strtoupper(tanggal_indo($this->input->get('selesai'))) ?> <br>
            <? if($this->input->get('kode_prodi')): ?>
			PROGRAM STUDI <?= strtoupper($prodi->nama_prodi) ?> <br>
            <?php endif; ?>

			<?= $fakultas->nama_fak ?> <br>
			<!-- TA. <?= $_SESSION['thn_akademik'] ?> <br> -->
		</b>
	</div>

		<p></p>
		<p></p>
		<p></p>

		<a style="float: left; text-decoration: none;" href="<?= base_url('aktivitas_mahasiswa/ekspor_peserta_wisuda?kode_fak='.$this->input->get('kode_fak').'&kode_prodi='.$this->input->get('kode_prodi').'&mulai='.$this->input->get('mulai').'&selesai='.$this->input->get('selesai')) ?>">
			<img src="https://icons.iconarchive.com/icons/dakirby309/simply-styled/24/Microsoft-Excel-2013-icon.png" width="15" align="left" /> &nbsp; Ekspor Data
		</a>

		<a target="_blank" style="float: left; text-decoration: none;margin-left: 15px;" href="<?= base_url('studi_akhir/unduh_berkas_mahasiswa?kode_fak='.$this->input->get('kode_fak').'&kode_prodi='.$this->input->get('kode_prodi').'&mulai='.$this->input->get('mulai').'&selesai='.$this->input->get('selesai')) ?>">
			<img src="https://icons.iconarchive.com/icons/alienvalley/osx-dock-replacement/24/photos-icon.png" width="15" align="left" /> &nbsp; Unduh Berkas Mahasiswa
		</a>
		<p></p><br>
        <table style="width: 100%; border-top: 1px solid #a9c6c9; border-left: 1px solid #a9c6c9; margin-top: 5px;" border="0" cellpadding="5" cellspacing="0" class="side-border2">
            <tr style="background: #c3dde0;">
                <td class="pad" align="center">NO</td>
                <td class="pad" align="center">NIM</td>
                <td class="pad" align="center">NAMA LENGKAP</td>
                <td class="pad" align="center">NIK</td>
                <td class="pad" align="center">TEMPAT LAHIR</td>
                <td class="pad" align="center">TANGGAL LAHIR</td>
                <td class="pad" align="center">IPK</td>
                <td class="pad" align="center">YUDISIUM</td>
                <td class="pad" align="center">TAHUN MASUK</td>
                <td class="pad" align="center">STATUS AWAL</td>
                <td class="pad" align="center">SKS YANG DITEMPUH</td>
                <td class="pad" align="center">TANGGAL LULUS</td>
                <td class="pad" align="center">JUDUL SKRIPSI / TUGAS AKHIR</td>
                <td class="pad" align="center">ALAMAT</td>
                <td class="pad" align="center">NO. HP</td>
                <td class="pad" align="center">EMAIL</td>
                <td class="pad" align="center">FOTO</td>
                <td class="pad" align="center">IJAZAH</td>
                <td class="pad" align="center">KTP</td>
            </tr>
            <?php $no = 1; foreach ($wisudawan as $row) { $color = ($no % 2 == 1) ? "#FFFFFF": "#D4E3E5"; ?>
            <tr bgcolor="<?= $color ?>">
            	<td align="center"><?= $no++ ?></td>
            	<td align="center"><?= $row->id_mahasiswa_pt ?></td>
            	<td><?= $row->nm_pd ?></td>
            	<td><?= $row->nik ?></td>
            	<td align="center"><?= $row->tmp_lahir ?></td>
            	<td align="center"><?= tanggal_indo($row->tgl_lahir) ?></td>
    			<td><a target="_blank" href="<?= base_url('nilai/transkrip/'.$row->id_kur.'/'.$row->id_mahasiswa_pt) ?>" class="lihat_transkrip" id="transkrip"><?= str_replace('.', ',', $row->ipk) ?></a></td>
            	<td>
            		<?php
            		if ($row->ipk >= 2 AND $row->ipk <= 2.75) {
            			echo 'Lulus';
            		} elseif ($row->ipk >= 2.76 AND $row->ipk <= 3) {
            			echo 'Memuaskan';
            		} elseif ($row->ipk >= 3.01 AND $row->ipk <= 3.50) {
            			echo 'Sangat Memuaskan';
            		} elseif ($row->ipk >= 3.51 AND $row->ipk <= 4) {
            			echo 'Dengan Pujian';
            		}
            		?>
            	</td>
            	<td align="center"><?= substr($row->mulai_smt, 0, 4) ?></td>
            	<td align="center"><?= $row->nama_jalur_masuk ?></td>
            	<td align="center"><?= $row->sks_diakui ?></td>
            	<td align="center"><a target="_blank" style="text-decoration: none"><?= tanggal_indo($row->tanggal) ?></a></td>
            	<td><?= strtoupper($row->judul) ?></td>
            	<td style="text-transform: uppercase;"><?= $row->jalan.' '.$row->blok.' '.($row->rt ? 'RT '.$row->rt : '').' '.($row->rw ? 'RW '.$row->rw : '').' '.$row->nm_wil ?></td>
            	<td align="center"><?= $row->no_hp ?></td>
                <td align="center"><?= $row->email ?></td>

                <td align="center">
                	<?php
                        $dokumen = $this->Mahasiswa_model->get_dokumen($row->id_mhs, 'pasfoto');
                        $dokumen = $dokumen ? $dokumen->file_mahasiswa : '';
                    ?>
                	<a class="html5lightbox" data-group="pasfoto" data-thumbnail="<?= $dokumen ?>" href="<?= $dokumen ?>" data-description="<a href='<?= $dokumen ?>' download='<?= 'FOTO '.$row->nm_pd ?>'>Unduh Berkas</a>">
            			<img src="<?= $dokumen ?>" width="50" alt="">
            		</a>
                </td>
                <td align="center">
                	<?php
                        $dokumen = $this->Mahasiswa_model->get_dokumen($row->id_mhs, 'ijazah');
                        $dokumen = $dokumen ? $dokumen->file_mahasiswa : '';
                    ?>
                	<a class="html5lightbox" data-group="ijazah" data-thumbnail="<?= $dokumen ?>" href="<?= $dokumen ?>" data-description="<a href='<?= $dokumen ?>' download='<?= 'IJAZAH '.$row->nm_pd ?>'>Unduh Berkas</a>">
            			<img src="<?= $dokumen ?>" width="50" alt="">
            		</a>
                </td>
                <td align="center">
                	<?php
                        $dokumen = $this->Mahasiswa_model->get_dokumen($row->id_mhs, 'ktp');
                        $dokumen = $dokumen ? $dokumen->file_mahasiswa : '';
                    ?>
                	<a class="html5lightbox" data-group="ktp" data-thumbnail="<?= $dokumen ?>" href="<?= $dokumen ?>" data-description="<a href='<?= $dokumen ?>' download='<?= 'KTP '.$row->nm_pd ?>'>Unduh Berkas</a>">
            			<img src="<?= $dokumen ?>" width="50" alt="">
            		</a>
                </td>
            </tr>
            <?php
             } ?>
        </table>
</body>
</html>