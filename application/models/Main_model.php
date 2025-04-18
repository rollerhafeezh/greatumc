<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function update_fakultas($kode_fak,$isi,$komponen)
    {
        $this->db->where('kode_fak',$kode_fak);
		$this->db->set($komponen,$isi);
		return $this->db->update($_ENV['DB_REF'].'fakultas');
    }
    
    function update_prodi($kode_prodi,$isi,$komponen)
    {
        $this->db->where('kode_prodi',$kode_prodi);
		$this->db->set($komponen,$isi);
		return $this->db->update($_ENV['DB_REF'].'prodi');
    }
	
	function ubah_tahun($id_smt)
	{
	    $this->db->set('a_periode_aktif','0');
		$this->db->update($_ENV['DB_REF'].'semester');
		
		$this->db->where('id_semester',$id_smt);
		$this->db->set('a_periode_aktif','1');
		return $this->db->update($_ENV['DB_REF'].'semester');
	}
	
	function proses_cuti($id_smt,$id_mahasiswa_pt)
	{
		$this->db->where('id_smt',$id_smt);
		$this->db->where('id_mahasiswa_pt',$id_mahasiswa_pt);
		$this->db->set('id_stat_mhs','C');
		return $this->db->update('kuliah_mahasiswa');
	}

	function update_biodata($data, $where)
	{
		$this->db->where($where);
		return $this->db->update($_ENV['DB_GREAT'].'mahasiswa', $data);
	}

	function ref_kecamatan()
	{
		return json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/kecamatan'));
	}

	function ref_agama()
	{
		return json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/agama'));
	}
	
	function proses_keluar($id_jns_keluar,$id_mahasiswa_pt,$tgl_keluar,$ket)
	{
		$this->db->where('id_mahasiswa_pt',$id_mahasiswa_pt);
		$this->db->set('id_jns_keluar',$id_jns_keluar);
		$this->db->set('tgl_keluar',$tgl_keluar);
		$this->db->set('ket',$ket);
		$this->db->set('npm_aktif','0');
		return $this->db->update('mahasiswa_pt');
	}
	
	function proses_aktif($id_mahasiswa_pt)
	{
		$this->db->where('id_mahasiswa_pt',$id_mahasiswa_pt);
		$this->db->set('id_jns_keluar','0');
		$this->db->set('tgl_keluar',null);
		$this->db->set('ket',null);
		$this->db->set('npm_aktif','1');
		return $this->db->update('mahasiswa_pt');
	}
	
	function cetak_kartu($id_smt,$id_mahasiswa_pt,$jenis)
	{
	    $sql = 'insert ignore into cetak_kartu (id_mahasiswa_pt,jenis_kartu,id_smt) value(?,?,?)';
	    return $this->db->query($sql,array($id_mahasiswa_pt,$jenis,$id_smt));
	}
	
	function cek_milik($id_mhs,$id_mahasiswa_pt)
	{
	    $this->db->where('id_mhs',$id_mhs);
	    $this->db->where('id_mahasiswa_pt',$id_mahasiswa_pt);
	    return $this->db->get('mahasiswa_pt');
	}
	
	function get_count_nim($id_mhs)
	{
	    $this->db->where('a.id_mhs',$id_mhs);
	    $this->db->join($_ENV['DB_REF'].'prodi b','a.kode_prodi=b.kode_prodi');
		$this->db->join($_ENV['DB_REF'].'fakultas c','c.kode_fak=b.kode_fak');
	    return $this->db->get('mahasiswa_pt a');
	}
	
	function get_berita($id_berita=null,$status=null,$limit)
	{
	    if($id_berita){
	        $this->db->where('id_berita',$id_berita);
	    }
	    if($status){
	        $this->db->where('status',$status);
	    }
	    $this->db->limit($limit);
	    $this->db->order_by('id_berita','desc');
	    $this->db->where('expired_at >', date("Y-m-d H:i:s"));
	    return $this->db->get('berita');
	}
	
	function hapus_berita($id_berita)
	{
	    $this->db->where('id_berita',$id_berita);
	    $this->db->set('status',0);
	    return $this->db->update('berita');
	}
	
	function simpan_berita($data)
	{
	    $this->db->insert('berita',$data);
	    return $this->db->insert_id();
	}
	
	function get_id_kelas_aktif($data)
	{
		$query = '  SELECT id_kelas_kuliah 
		            FROM '.$_ENV['DB_GREAT'].'kelas_kuliah 
		            WHERE ((? BETWEEN `jam_mulai` AND `jam_selesai` OR ? = `jam_mulai`) 
		            OR (? BETWEEN `jam_mulai` AND `jam_selesai` OR ? = `jam_selesai`) )
		            AND hari_kuliah = ? and id_smt = ?';
		$id_kelas_kuliah = $this->db->query($query, array($data['jam_mulai'],$data['jam_mulai'],$data['jam_selesai'],$data['jam_selesai'],$data['hari_kuliah'],$data['id_smt']));
		
		$id_kelas_kuliahs = array();
		if( $id_kelas_kuliah->num_rows() > 0 )
		{
			foreach( $id_kelas_kuliah->result() as $row )
			{
				$id_kelas_kuliahs[] = $row->id_kelas_kuliah;
			}
			
			$this->db->select('id_dosen');
			$this->db->where_in('id_kelas_kuliah', $id_kelas_kuliahs);
			$sql = $this->db->get('ajar_dosen');
			//var_dump($sql->result());
			$id_dosens=array();
			if( $sql->num_rows() > 0 )
			{
				foreach( $sql->result() as $row )
				{
					$id_dosens[] = $row->id_dosen;
				}
				return $id_dosens;
			}else{
				return false;
			}
		} else{
		    return false;
		}
	}
	
	function get_dosen_pt()
    {
        $nm_sdm= $this->input->get('nm_sdm');
        $team_teach= $this->input->get('team_teach');
        $id_smt= $this->input->get('smt');
        $hari_kuliah= $this->input->get('hari_kuliah');
        $jam_mulai= $this->input->get('jam_mulai');
        $jam_selesai= $this->input->get('jam_selesai');
		$get_id_dosen = array('hari_kuliah'=>$hari_kuliah,'id_smt'=>$id_smt,'jam_mulai'=>$jam_mulai,'jam_selesai'=>$jam_selesai);
		
		/*SKIP HARDCODED*/
		if($team_teach=='0'){
		$id_dosen = $this->get_id_kelas_aktif($get_id_dosen);
		
			if($id_dosen)
			{
				$this->db->where_not_in('a.id_dosen',$id_dosen);
			}
		}

        if($nm_sdm)
        {
            $this->db->like('a.nm_sdm',$nm_sdm);
        }

        if($id_smt)
        {
            $this->db->where('c.id_semester',$id_smt);
        }

        $this->db->select('a.nm_sdm,a.nidn,a.id_dosen');
        $this->db->join($_ENV['DB_GREAT'].'dosen_pt b','a.id_dosen=b.id_dosen');
        $this->db->join($_ENV['DB_REF'].'semester c','c.id_tahun_ajaran=b.id_tahun_ajaran');
        return $this->db->get($_ENV['DB_GREAT'].'dosen a')->result();
    }
    
	/*---CREATE AKUN MHS + LEVEL----*/
    function simpan_email_mhs($id_mhs,$email)
    {
        $this->update_email_sso_mhs($id_mhs,$email);
        
        $this->db->where('id_mhs',$id_mhs);
        $this->db->set('email',$email);
        return $this->db->update('mahasiswa');
    }
    
    function simpan_email_dosen($nidn,$email)
    {
        $this->update_email_sso_dosen($nidn,$email);
        
        $this->db->where('nidn',$nidn);
        $this->db->set('email',$email);
        return $this->db->update('dosen');
    }
    
    function simpan_no_hp_mhs($id_mhs,$no_hp)
    {
        $this->db->where('id_mhs',$id_mhs);
        $this->db->set('no_hp',$no_hp);
        return $this->db->update('mahasiswa');
    }
    
    function simpan_no_hp_dosen($nidn,$no_hp)
    {
        $this->db->where('nidn',$nidn);
        $this->db->set('no_hp',$no_hp);
        return $this->db->update('dosen');
    }
    
    function update_email_sso_mhs($id_mhs,$email)
    {
        $this->db->where('username',$id_mhs);
        $usermain = $this->db->get($_ENV['DB_SSO'].'user_main')->row();
        if($usermain)
        {
            $this->db->where('username',$id_mhs);
            $this->db->set('email',$email);
            $this->db->update($_ENV['DB_SSO'].'user_main');
        }else{
            $nm_pd = $this->db->select('nm_pd')->where('id_mhs',$id_mhs)->get('mahasiswa')->row()->nm_pd;
            $this->db->set('email',$email);
            $this->db->set('nama_pengguna',$nm_pd);
            $this->db->set('username',$id_mhs);
            $this->db->insert($_ENV['DB_SSO'].'user_main');
            
            $this->db->set('id_level','1');
            $this->db->set('username',$id_mhs);
            $this->db->insert($_ENV['DB_SSO'].'user_level');
        }
    }
    
    function update_email_sso_dosen($nidn,$email)
    {
        $this->db->where('username',$nidn);
        $usermain = $this->db->get($_ENV['DB_SSO'].'user_main')->row();
        if($usermain)
        {
            $this->db->where('username',$nidn);
            $this->db->set('email',$email);
            $this->db->update($_ENV['DB_SSO'].'user_main');
        }else{
            $nm_pd = $this->db->select('nm_sdm')->where('nidn',$nidn)->get('dosen')->row()->nm_sdm;
            $this->db->set('email',$email);
            $this->db->set('nama_pengguna',$nm_pd);
            $this->db->set('username',$nidn);
            $this->db->insert($_ENV['DB_SSO'].'user_main');
            
            $this->db->set('id_level','2');
            $this->db->set('username',$nidn);
            $this->db->insert($_ENV['DB_SSO'].'user_level');
        }
    }
	
	function ref_ruangan_kuliah($data)
	{
		$query = '  SELECT id_ruangan 
		            FROM '.$_ENV['DB_GREAT'].'kelas_kuliah 
		            WHERE ((? BETWEEN `jam_mulai` AND `jam_selesai` OR ? = `jam_mulai`) 
		            OR (? BETWEEN `jam_mulai` AND `jam_selesai` OR ? = `jam_selesai`) )
		            AND hari_kuliah = ? and id_smt = ?';
		$id_ruangan = $this->db->query($query, array($data['jam_mulai'],$data['jam_mulai'],$data['jam_selesai'],$data['jam_selesai'],$data['hari_kuliah'],$data['id_smt']));
		
		$id_ruangans = array();
		if( $id_ruangan->num_rows() > 0 )
		{
			foreach( $id_ruangan->result() as $row )
			{
				$id_ruangans[] = $row->id_ruangan;
			}
			
			/*SKIP HARDCODED*/
			if($data['team_teach']==1){
				if($data['id_gedung']!=1)
				{
					$this->db->where_in('id_ruangan', $id_ruangans);
				}
			}else{
				if($data['id_gedung']!=1){
					$this->db->where_not_in('id_ruangan', $id_ruangans);
				}
			}
		} 
		
		$this->db->where('id_gedung',$data['id_gedung']);
		$this->db->where('status_ruangan', '1');
		$this->db->order_by('nama_ruangan','asc');
		return $this->db->get($_ENV['DB_REF'].'ruangan');
	}
	
	function get_kurikulum($id_kur=null,$kur_aktif=null)
	{
		if($id_kur)
		{
			$this->db->where('a.id_kur',$id_kur);
		}
		if($kur_aktif)
		{
			$this->db->where('a.kur_aktif',$kur_aktif);
		}
		$this->db->join($_ENV['DB_REF'].'prodi b','a.kode_prodi=b.kode_prodi');
		$this->db->join($_ENV['DB_REF'].'fakultas c','c.kode_fak=b.kode_fak');
		$this->db->order_by('nm_kurikulum_sp','asc');
		return $this->db->get($_ENV['DB_GREAT'].'kurikulum a');
	}
	
	function get_rps($id_matkul=null,$id_rps=null,$status=null)
	{
		if($status)
		{
			$this->db->where('status',$status);
		}
		if($id_rps)
		{
			$this->db->where('id_rps',$id_rps);
		}
		if($id_matkul)
		{
			$this->db->where('id_matkul',$id_matkul);
		}
		
		return $this->db->get('rps');
	}
	
	function get_rps_pertemuan($id_matkul=null,$id_rps=null,$id_rps_pertemuan=null,$minggu_ke=null)
	{
		if($id_rps)
		{
			$this->db->where('id_rps',$id_rps);
		}
		if($id_rps_pertemuan)
		{
			$this->db->where('id_rps_pertemuan',$id_rps_pertemuan);
		}
		if($id_matkul)
		{
			$this->db->where('id_matkul',$id_matkul);
		}
		if($minggu_ke)
		{
			$this->db->where('minggu_ke',$minggu_ke);
		}
		$this->db->order_by('minggu_ke','asc');
		return $this->db->get('rps_pertemuan');
	}
	
	function get_dosen()
    {
        $nm_sdm= $this->input->get('nm_sdm');
        $id_dosen= $this->input->get('id_dosen');
		
		if($id_dosen)
		{
			$this->db->where_not_in('a.id_dosen',$id_dosen);
		}

        if($nm_sdm)
        {
            $this->db->like('a.nm_sdm',$nm_sdm);
        }

        $this->db->select('a.nm_sdm,a.nidn,a.id_dosen');
        return $this->db->get($_ENV['DB_GREAT'].'dosen a')->result();
    }
	
	function count_sks_dosen($id_dosen,$id_smt)
	{
		return $this->db->select('sum(sks_subst_tot) as total_sks')->where('id_dosen',$id_dosen)->where('id_smt',$id_smt)->get('ajar_dosen')->row()->total_sks;
	}
	
	function conf_maks_sks_dosen()
	{
		return $this->db->select('value_konfigurasi')->where('nama_konfigurasi','maks_sks_dosen')->get('konfigurasi')->row()->value_konfigurasi;
	}
	
	function check_maks_sks_dosen($id_dosen,$id_smt,$sks_baru)
	{
		$maks_sks = $this->conf_maks_sks_dosen();
		$sks = $this->db->select('sum(sks_subst_tot) as total_sks')->where('id_dosen',$id_dosen)->where('id_smt',$id_smt)->get('ajar_dosen')->row()->total_sks;
		$total_sks = $sks_baru + $sks;
		if($total_sks > $maks_sks) return false; else return true;
	}
	
	function ngapain()
	{
	    $this->db->select('whythis');
	    $this->db->distinct('whythis');
	    $this->db->order_by('whythis','asc');
	    return $this->db->get('akademik_log');
	}
	
	function get_log_akademik()
	{
		$this->db->order_by('whenat','desc');
		$this->db->limit(1000);
		return $this->db->get('akademik_log');
	}
	
	function simpan_konfigurasi($nama_konfigurasi,$value_konfigurasi)
	{
		$this->db->where('nama_konfigurasi',$nama_konfigurasi);
		$this->db->set('value_konfigurasi',$value_konfigurasi);
		return $this->db->update('konfigurasi');
	}
	
	function get_konfigurasi($nama_konfigurasi=null)
	{
		if($nama_konfigurasi)
		{
			$this->db->where('nama_konfigurasi',$nama_konfigurasi);
		}
		return $this->db->get('konfigurasi');
	}
	
	function get_nama_mahasiswa($id_mhs)
	{
	    $this->db->select('nm_pd');
	    $this->db->where('id_mhs',$id_mhs);
	    return $this->db->get('mahasiswa')->row();
	}
	
	function check_kuliah_mahasiswa($id_mahasiswa_pt,$id_smt)
	{
		$smt = $this->get_mulai_smt($id_mahasiswa_pt);
		/*-----------CHECK KULIAH MAHASISWA---------------*/
		if($smt->mulai_smt <= $id_smt)
		{
			$check = $this->db->where('id_mahasiswa_pt',$id_mahasiswa_pt)->where('id_smt',$id_smt)->get('kuliah_mahasiswa')->row();
			if(!$check)
			{
			    $smt_mhs = $this->smt_mhs($smt->mulai_smt,$smt->diterima_smt,$id_smt);
			    if($smt_mhs < 15) {
    				$data=['id_mahasiswa_pt'=>$id_mahasiswa_pt,'id_smt'=>$id_smt,'smt_mhs'=>$smt_mhs];
    				$this->db->insert('kuliah_mahasiswa',$data);
			    }
			}
		}
		
		/*-----------CHECK DAN GENERATE IPK & IPS SEMESTER -------------*/
		$this->update_sks_smt($id_mahasiswa_pt,$id_smt);
		//$this->update_sks_total($id_mahasiswa_pt,$id_smt); /*HANYA BERLAKU UNTUK MABA YANG MASUK SESUAI GREAT*/
		
		return $this->db->where('id_mahasiswa_pt',$id_mahasiswa_pt)->where('id_smt',$id_smt)->get('kuliah_mahasiswa')->row();
	}
	
	function update_ips()
	{
	    
	}
	
	function update_ipk($id_mahasiswa_pt,$ipk)
	{
	    $this->db->where('id_mahasiswa_pt',$id_mahasiswa_pt);
	    $this->db->set('ipk',$ipk);
	    return $this->db->update('mahasiswa_pt'); 
	}
	
	function update_sks_smt($id_mahasiswa_pt,$id_smt)
	{
	    $this->db->select('sum(b.sks_mk) as sks');
	    $this->db->join('mata_kuliah b','a.id_matkul=b.id_matkul');
	    $this->db->where('a.id_smt',$id_smt);
	    $this->db->where('a.id_mahasiswa_pt',$id_mahasiswa_pt);
	    $sql = $this->db->get('nilai a')->row();
	    $sks = ($sql->sks)?:0;
	    $this->update_kuliah_mahasiswa($id_mahasiswa_pt,$id_smt,'sks_smt',$sks);
    }
	
	/*function update_sks_total($id_mahasiswa_pt,$id_smt)
	{
	    $this->db->select('sum(b.sks_mk) as sks');
	    $this->db->join('mata_kuliah b','a.id_matkul=b.id_matkul');
	    $this->db->where('a.id_smt <=',$id_smt);
	    $this->db->where('a.id_mahasiswa_pt',$id_mahasiswa_pt);
	    $sql = $this->db->get('nilai a')->row();
	    $sks = ($sql->sks)?:0;
        $this->update_kuliah_mahasiswa($id_mahasiswa_pt,$id_smt,'sks_total',$sks);
	}*/
	
	function update_kuliah_mahasiswa($id_mahasiswa_pt,$id_smt,$field,$value)
	{
	    $this->db->where('id_smt',$id_smt);
	    $this->db->where('id_mahasiswa_pt',$id_mahasiswa_pt);
	    $this->db->set($field,$value);
	    return $this->db->update('kuliah_mahasiswa');
	}
	
	function check_smt_mahasiswa($id_mahasiswa_pt,$id_smt)
	{
		$smt = $this->get_mulai_smt($id_mahasiswa_pt);
		
		if($smt){
    		if($smt->diterima_smt != 0){
        		if($smt->mulai_smt <= $id_smt)
        		{
        			 $smt = $this->smt_mhs($smt->mulai_smt,$smt->diterima_smt,$id_smt);
        			 if($smt < 15) {
        			     return true;
        			 }else{
        			     return false;
        			 }
        		}else{
        		    return false; 
        		}
    		}else{
    		    return false;
    		}
		}else{
		    return false;
		}
	}
	
	function get_mhs_kelas($id_kelas_kuliah=null)
	{
		if($id_kelas_kuliah)
		{
			$this->db->where('a.id_kelas_kuliah',$id_kelas_kuliah);
		}
		$this->db->select('a.id_nilai,a.id_kelas_kuliah,a.id_krs,a.id_smt,c.nm_pd,b.id_mahasiswa_pt,a.nilai_huruf,a.nilai_uts,a.nilai_uas, km.id_stat_mhs, a.nilai_angka');
		$this->db->join($_ENV['DB_GREAT'].'mahasiswa_pt b','a.id_mahasiswa_pt=b.id_mahasiswa_pt');
		$this->db->join($_ENV['DB_GREAT'].'mahasiswa c','c.id_mhs=b.id_mhs');
		$this->db->join($_ENV['DB_GREAT'].'kuliah_mahasiswa km','km.id_mahasiswa_pt = a.id_mahasiswa_pt AND km.id_smt = a.id_smt');
		//$this->db->join($_ENV['DB_REF'].'prodi p','b.kode_prodi=p.kode_prodi');
		//$this->db->join($_ENV['DB_REF'].'fakultas f','f.kode_fak=p.kode_fak');
		$this->db->order_by('a.id_mahasiswa_pt','asc');
		//$this->db->order_by('c.nm_pd','asc');
		return $this->db->get($_ENV['DB_GREAT'].'nilai a');
	}
	
	function get_mhs_krs($id_kelas_kuliah=null)
	{
		if($id_kelas_kuliah)
		{
			$this->db->where('a.id_kelas_kuliah',$id_kelas_kuliah);
		}
		$this->db->select('a.id_krs,a.id_kelas_kuliah,a.id_krs,c.nm_pd,b.id_mahasiswa_pt,a.status_krs, km.id_stat_mhs');
		$this->db->join($_ENV['DB_GREAT'].'mahasiswa_pt b','a.id_mahasiswa_pt=b.id_mahasiswa_pt');
		$this->db->join($_ENV['DB_GREAT'].'mahasiswa c','c.id_mhs=b.id_mhs');
		$this->db->join($_ENV['DB_GREAT'].'kuliah_mahasiswa km','km.id_mahasiswa_pt = a.id_mahasiswa_pt AND km.id_smt = a.id_smt');
		//$this->db->join($_ENV['DB_REF'].'prodi p','b.kode_prodi=p.kode_prodi');
		//$this->db->join($_ENV['DB_REF'].'fakultas f','f.kode_fak=p.kode_fak');
		$this->db->order_by('a.id_mahasiswa_pt','asc');
		$this->db->order_by('c.nm_pd','asc');
		return $this->db->get($_ENV['DB_GREAT'].'krs a');
	}
	
	function get_mulai_smt($id_mahasiswa_pt)
	{
		return $this->db->select('mulai_smt,diterima_smt')->where('id_mahasiswa_pt',$id_mahasiswa_pt)->get('mahasiswa_pt')->row();
	}
	
	function pengampu_kelas_kosong($id_kelas_kuliah=null,$id_ajar_dosen=null,$id_dosen=null)
	{
		if($id_kelas_kuliah)
		{
			$this->db->where('a.id_kelas_kuliah',$id_kelas_kuliah);
		}
		if($id_dosen)
		{
			$this->db->where('a.id_dosen',$id_dosen);
		}
		if($id_ajar_dosen)
		{
			$this->db->where('a.id_ajar_dosen',$id_ajar_dosen);
		}
		return $this->db->get($_ENV['DB_GREAT'].'ajar_dosen a');
	}
	
	function pengampu_kelas($id_kelas_kuliah=null,$id_ajar_dosen=null)
	{
		if($id_ajar_dosen)
		{
			$this->db->where('a.id_ajar_dosen',$id_ajar_dosen);
		}
		if($id_kelas_kuliah)
		{
			$this->db->where('a.id_kelas_kuliah',$id_kelas_kuliah);
		}
		$this->db->select('b.nm_sdm,b.nidn,a.id_dosen,a.sks_subst_tot,a.id_ajar_dosen,a.id_kelas_kuliah');
		$this->db->join($_ENV['DB_GREAT'].'dosen b','a.id_dosen=b.id_dosen');
		return $this->db->get($_ENV['DB_GREAT'].'ajar_dosen a');
	}
	
	function cek_ips($id_smt,$id_mahasiswa_pt)
	{
		$this->db->select('ips');
		$this->db->where('id_smt',$id_smt);
		$this->db->where('id_mahasiswa_pt',$id_mahasiswa_pt);
		return $this->db->get($_ENV['DB_GREAT'].'kuliah_mahasiswa');
	}
	
	function krs_note($id_smt,$id_mahasiswa_pt)
	{
		$this->db->where('id_smt',$id_smt);
		$this->db->where('id_mahasiswa_pt',$id_mahasiswa_pt);
		return $this->db->get($_ENV['DB_GREAT'].'krs_note');
	}
	
	function get_mata_kuliah($id_matkul=null)
	{
		if($id_matkul)
		{
			$this->db->where('a.id_matkul',$id_matkul);
		}
		$this->db->join($_ENV['DB_REF'].'prodi b','a.kode_prodi=b.kode_prodi');
		$this->db->join($_ENV['DB_REF'].'fakultas c','c.kode_fak=b.kode_fak');
		return $this->db->get($_ENV['DB_GREAT'].'mata_kuliah a');
	}
	
	function ref_ruangan($id_gedung=null)
	{
		if($id_gedung)
		{
			$this->db->where('id_gedung',$id_gedung);
		}
		return $this->db->get($_ENV['DB_REF'].'ruangan');
	}
	
	function unggah_dokumen($nama_dokumen,$nama_folder,$tipe=null,$dokumen)
	{
		/*upload lib and process */
		$config['file_name'] 	= $nama_dokumen.'-'.date('YmdHis');
		$config['upload_path'] 	= $nama_folder;
		if($tipe) $config['allowed_types'] = $tipe;
		$config['file_ext_tolower'] = TRUE;
		$config['remove_spaces'] = TRUE;
		$config['overwrite'] = TRUE;
		
		$this->load->library('upload',$config);
		
		if ( !$this->upload->do_upload($dokumen))
		{
			$hasil = array('error' => $this->upload->display_errors());
		}else{
			$hasil = array('upload_data' => $this->upload->data());
		}
		return $hasil;
	}
	
	function unggah_dokumen_re($nama_dokumen,$nama_folder,$tipe=null,$dokumen)
	{
		/*upload lib and process */
		$config['file_name'] 	= $nama_dokumen;
		$config['upload_path'] 	= $nama_folder;
		if($tipe) $config['allowed_types'] = $tipe;
		$config['file_ext_tolower'] = TRUE;
		$config['remove_spaces'] = TRUE;
		$config['overwrite'] = TRUE;
		
		$this->load->library('upload',$config);
		
		if ( !$this->upload->do_upload($dokumen))
		{
			$hasil = array('error' => $this->upload->display_errors());
		}else{
			$hasil = array('upload_data' => $this->upload->data());
		}
		return $hasil;
	}
	
	function ref_jenis_mk()
	{
		return json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/jenis_mk'));
	}

	function ref_kategori_mk()
	{
		return json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/kategori_mk'));
	}

	function ref_kategori_kegiatan()
	{
		return json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/kategori_kegiatan'));
	}

	function ref_kegiatan()
	{
		return json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/kegiatan'));
	}
	
	function ref_tahun_ajaran()
	{
		return json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/tahun_ajaran'));
	}
	
	function ref_status_mahasiswa()
	{
		return json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/status_mahasiswa'));
	}
	
	function ref_jenis_keluar()
	{
		return json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/jenis_keluar'));
	}
	
	function ref_smt()
	{
		return json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/smt'));
	}

	function ref_jenis_aktivitas_mahasiswa()
	{
		return json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/jenis_aktivitas_mahasiswa'));
	}
	
	function ref_fakultas($kode_fak=null)
	{
		$query='';
		if($kode_fak || $kode_fak !=0)
		{
			$query.='?kode_fak='.$kode_fak;
		}
		return json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/fakultas'.$query));
	}
	
	function ref_prodi($kode_fak=null,$kode_prodi=null)
	{
		$query='';
		if($kode_fak && $kode_prodi)
		{
			$query.='?kode_fak='.$kode_fak.'&kode_prodi='.$kode_prodi;
		}else if($kode_fak)
		{
			$query.='?kode_fak='.$kode_fak;
		}else if($kode_prodi)
		{
			$query.='?kode_prodi='.$kode_prodi;
		}
		//return $query;
		return json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/prodi'.$query));
	}
	
	public function akademik_log($whythis,$whatdo)
	{
		$data=array(
			'whois'		=> $_SESSION['username'],
			'whythis'	=> $whythis,
			'whatdo'	=> $whatdo,
			'wherefrom'	=> $this->getUserIpAddr()
		);				
		return $this->db->insert('akademik_log',$data);
	}
	
	function keuangan($tipe,$nim,$id_smt)
	{
	    $url = 'https://rest-simaku-umc.gsidatacenter.online:8112/simaku';
	    $this->curl->http_header('TYPE',$tipe);
	    $this->curl->http_header('NIM',$nim);
	    $this->curl->http_header('IDSEMESTER',$id_smt);
	    $this->curl->http_header('CLIENTID','6227');
	    $this->curl->http_header('CREDENTIALKEY','7yhe8ujkkejeiuj6593');
		//return json_decode($this->curl->simple_get($url));
		$hasil = json_decode($this->curl->simple_get($url));
		if($hasil){
		    if($hasil->status=='ok')
    		{
    		    return $this->parseData($hasil->data,'6227','7yhe8ujkkejeiuj6593');
    		}else{
    		    return ['hasil'=>0,'message'=>'Terjadi Kesalahan. Silahkan Coba lagi dalam 1 Menit.'];
    		}
		}else{
		    return ['hasil'=>0,'message'=>'Terjadi Kesalahan. Silahkan Coba lagi dalam 1 Menit.'];
		}
	}
	
	function tagihan_total($nim,$id_smt)
	{
	    $url = 'https://rest-simaku-umc.gsidatacenter.online:8112/simaku';
	    $this->curl->http_header('TYPE','tagihan_total');
	    //$this->curl->http_header('TYPE','tagihan_rinci');
	    $this->curl->http_header('NIM',$nim);
	    $this->curl->http_header('IDSEMESTER',$id_smt);
	    $this->curl->http_header('CLIENTID','6227');
	    $this->curl->http_header('CREDENTIALKEY','7yhe8ujkkejeiuj6593');
		$hasil = json_decode($this->curl->simple_get($url));
		if($hasil){
		    //return $hasil;
		    //exit;
		    if($hasil->status=='ok')
    		{
    		    $tagihan = $this->parseData($hasil->data,'6227','7yhe8ujkkejeiuj6593');
    		    $tag = $tagihan['data']['tagihan'];
    		    $this->update_kuliah_mahasiswa($nim,$id_smt,'biaya_kuliah',$tag);
    		}
		}
	}
	
	function parseData($hased_string, $cid, $secret) {
		$parsed_string = $this->doubleDecrypt($hased_string, $cid, $secret);
		list($timestamp, $data) = array_pad(explode('.', $parsed_string, 2), 2, null);
	    //if (self::tsDiff(strrev($timestamp)) === true) {
			return json_decode($data, true);
		//}
		//return null;
	}
	
	private function doubleDecrypt($string, $cid, $secret) {
		$result = base64_decode(strtr(str_pad($string, ceil(strlen($string) / 4) * 4, '=', STR_PAD_RIGHT), '-_', '+/'));
		// var_dump($result);
		$result = $this->decrypt($result, $cid);
		// var_dump($result);
		$result = $this->decrypt($result, $secret);
		// var_dump($result);
		return $result;
	}

	private function decrypt($string, $key) {
		$result = '';
		$strls = strlen($string);
		$strlk = strlen($key);
		for($i = 0; $i < $strls; $i++) {
			$char = substr($string, $i, 1);
			$keychar = substr($key, ($i % $strlk) - 1, 1);
			$char = chr(((ord($char) - ord($keychar)) + 256) % 128);
			$result .= $char;
		}
		return $result;
	}
	
	function post_api($url,$data)
	{
		$this->curl->http_header('token',$_SESSION['api_token']);
		$this->curl->http_header('bearer','SIMAK');
		return json_decode($this->curl->simple_post($_ENV['API_LINK'].$url,$data));
	}
	
	function getUserIpAddr()
	{			
		if(!empty($_SERVER['HTTP_CLIENT_IP'])){	        
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){	        
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{	     
			$ip = $_SERVER['REMOTE_ADDR'];
		}	
		return $ip;	
	}
	
	private function smt_mhs($mulai_smt,$diterima_smt,$smt_count)
	{
		
			/*semester berjalan genap / gajil/ pendek*/
			$smt=str_split($smt_count);
			if($smt[4]==3){
				$smt_mhs=0;
			}else{
				$diff_smt=$smt_count-$mulai_smt;
				switch($diff_smt){
					case 0 		: $smt_mhs=$diterima_smt+0; 	break;
					case 1 		: $smt_mhs=$diterima_smt+1; 	break;
					case 9 		: $smt_mhs=$diterima_smt+1; 	break;
					case 10 	: $smt_mhs=$diterima_smt+2; 	break;
					case 11 	: $smt_mhs=$diterima_smt+3; 	break;
					case 19 	: $smt_mhs=$diterima_smt+3; 	break;
					case 20 	: $smt_mhs=$diterima_smt+4; 	break;
					case 21 	: $smt_mhs=$diterima_smt+5; 	break;
					case 29 	: $smt_mhs=$diterima_smt+5; 	break;
					case 30 	: $smt_mhs=$diterima_smt+6; 	break;
					case 31 	: $smt_mhs=$diterima_smt+7; 	break;
					case 39 	: $smt_mhs=$diterima_smt+7; 	break;
					case 40 	: $smt_mhs=$diterima_smt+8; 	break;
					case 41 	: $smt_mhs=$diterima_smt+9; 	break;
					case 49 	: $smt_mhs=$diterima_smt+9; 	break;
					case 50 	: $smt_mhs=$diterima_smt+10; 	break;
					case 51 	: $smt_mhs=$diterima_smt+11; 	break;
					case 59 	: $smt_mhs=$diterima_smt+11; 	break;
					case 60 	: $smt_mhs=$diterima_smt+12; 	break;
					case 61 	: $smt_mhs=$diterima_smt+13; 	break;
					case 69 	: $smt_mhs=$diterima_smt+13; 	break;
					case 70 	: $smt_mhs=$diterima_smt+14; 	break;
					case 71 	: $smt_mhs=$diterima_smt+15; 	break;
					case 79 	: $smt_mhs=$diterima_smt+15; 	break;
					case 80 	: $smt_mhs=$diterima_smt+16; 	break;
					case 81 	: $smt_mhs=$diterima_smt+17; 	break;
					case 89 	: $smt_mhs=$diterima_smt+17; 	break;
					case 90 	: $smt_mhs=$diterima_smt+18; 	break;
					default		: $smt_mhs=0; break;
				}
			}
		return $smt_mhs;
	}
}