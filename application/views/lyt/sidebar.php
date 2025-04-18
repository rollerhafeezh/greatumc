<?php
	//MAHASISWA
	if($_SESSION['app_level']==1)
	{
		$this->Menu_model->lihat('dhmd_mahasiswa');
		$this->Menu_model->lihat('perwalian_mhs');
		$this->Menu_model->lihat('mbkm_mahasiswa');
		$this->Menu_model->studi_akhir_mahasiswa();
		$this->Menu_model->lihat('biodata');

	}
	//MAHASISWA INBOUND
	if($_SESSION['app_level']==10)
	{
		$this->Menu_model->lihat('mahasiswa_inbound');
		$this->Menu_model->lihat('biodata');

	}
	//DOSEN
	if($_SESSION['app_level']==2)
	{
		$this->Menu_model->lihat('dhmd_dosen');
		$this->Menu_model->lihat('perwalian');
		$this->Menu_model->lihat('bimbingan');
		$this->Menu_model->lihat('mbkm_dosen');
		$this->Menu_model->lihat('biodata');
	}
	
	//AKADEMIK
	if($_SESSION['app_level']==3 or $_SESSION['app_level']==4)
	{
		$this->Menu_model->lihat('mahasiswa');
		$this->Menu_model->lihat('kelas_kuliah');
		$this->Menu_model->lihat('studi_akhir');
		$this->Menu_model->lihat('mbkm');
		$this->Menu_model->lihat('dhmd');
		$this->Menu_model->lihat('kurikulum');
		$this->Menu_model->lihat('mata_kuliah');
		$this->Menu_model->lihat('dosen');
	}
	
	if($_SESSION['app_level']==3)
	{
		$this->Menu_model->lihat('pengaturan');
	}
	
	//KEUANGAN
	if($_SESSION['app_level']==5 or $_SESSION['app_level']==6)
	{
		$this->Menu_model->lihat('dosen');
		$this->Menu_model->lihat('mahasiswa');
		$this->Menu_model->lihat('dhmd');
	}
	
	//KAPRODI
	if($_SESSION['app_level']==7 or $_SESSION['app_level']==8 or $_SESSION['app_level']==9)
	{
		$this->Menu_model->lihat('mahasiswa');
		$this->Menu_model->lihat('kelas_kuliah');
		$this->Menu_model->lihat('studi_akhir');
		$this->Menu_model->lihat('mbkm');
		$this->Menu_model->lihat('dhmd');
		$this->Menu_model->lihat('kurikulum');
		$this->Menu_model->lihat('mata_kuliah');
		$this->Menu_model->lihat('dosen');
		if($_SESSION['level_name']=='Wakil Rektor') $this->Menu_model->lihat('tahun');
	}
?>
