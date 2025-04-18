<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transkrip_model extends CI_Model {
    
    function __construct()
	{
		parent::__construct();
	}
    
    function get_kurikulum_prodi($kode_prodi)
    {
        $this->db->where('kode_prodi',$kode_prodi);
        return $this->db->get('kurikulum');
    }
    
    function khs($id_mhs_pt,$id_kur)
	{
		$sql="
		SELECT 
			b.id_matkul,
			b.kode_mk,
			b.nm_mk,
			b.sks_mk,
			c.smt,
			c.a_wajib
		FROM
		mata_kuliah_kurikulum c
		JOIN mata_kuliah b on c.id_matkul=b.id_matkul
		
		WHERE c.id_kur = ?

		ORDER BY b.nm_mk
		";
		return $this->db->query($sql,array($id_kur))->result();
	}
	
	function konversi($id_kur,$id_mahasiswa_pt)
    {
        $sql="
		SELECT 
			old.nm_mk as old_nm_mk,
			old.kode_mk as old_kode_mk,
			old.sks_mk as old_sks_mk,
			baru.id_matkul as new_id_matkul,
			baru.nm_mk as new_nm_mk,
			baru.kode_mk as new_kode_mk,
			baru.sks_mk as new_sks_mk,
			c.smt,
			a.id_matkul, 
			a.id_mahasiswa_pt, 
			MAX(a.nilai_mk) as nilai_indeks
		FROM
		(
			SELECT id_matkul, id_mahasiswa_pt, nilai_indeks as nilai_mk FROM nilai
			UNION ALL
			SELECT id_matkul, id_mahasiswa_pt, nilai_angka_diakui as nilai_mk FROM nilai_transfer
		)a
		
		JOIN mata_kuliah old on a.id_matkul=old.id_matkul
		JOIN mata_kuliah_kurikulum c on a.id_matkul=c.id_matkul_konv
		JOIN mata_kuliah baru on c.id_matkul=baru.id_matkul
		
		WHERE c.id_kur = ?
		AND a.id_mahasiswa_pt = ?
		GROUP BY id_matkul,id_mahasiswa_pt
		ORDER BY c.smt
		";
		return $this->db->query($sql,array($id_kur,$id_mahasiswa_pt));
		
    }
    
    function transkrip($id_kur,$id_mahasiswa_pt)
    {
        $sql = "
        SELECT 
			b.nm_mk,
			b.nm_mk_en,
			b.kode_mk,
			b.sks_mk,
			c.smt,
			a.id_matkul, 
			a.id_mahasiswa_pt, 
			MAX(a.nilai_mk) as nilai_indeks
		FROM
		(
			SELECT id_matkul, id_mahasiswa_pt, nilai_indeks as nilai_mk FROM nilai
			UNION ALL
			SELECT id_matkul, id_mahasiswa_pt, nilai_angka_diakui as nilai_mk FROM nilai_transfer
		) a
		RIGHT JOIN mata_kuliah b on a.id_matkul=b.id_matkul
		JOIN mata_kuliah_kurikulum c on a.id_matkul=c.id_matkul
		
		WHERE a.id_mahasiswa_pt = ?
		AND c.id_kur=?
		GROUP BY id_matkul,id_mahasiswa_pt
		ORDER BY c.smt
        ";
        
        return $this->db->query($sql,array($id_mahasiswa_pt,$id_kur));
    }
	
	function nilai_maks($id_mahasiswa_pt,$id_matkul)
    {
        $sql = "
        SELECT 
			a.id_matkul, 
			a.id_mahasiswa_pt, 
			MAX(a.nilai_mk) as nilai_indeks
		FROM
		(
			SELECT id_matkul, id_mahasiswa_pt, nilai_indeks as nilai_mk FROM nilai
			UNION ALL
			SELECT id_matkul, id_mahasiswa_pt, nilai_angka_diakui as nilai_mk FROM nilai_transfer
		) a
		
		WHERE a.id_mahasiswa_pt = ? and a.id_matkul = ?
		
		GROUP BY id_matkul,id_mahasiswa_pt";
        
        return $this->db->query($sql,array($id_mahasiswa_pt,$id_matkul));
    }
    
    function transkrip_all__($id_mahasiswa_pt)
    {
        $sql = "
        SELECT 
            c.sks_mk,
			c.kode_mk,
			c.nm_mk,
			e.id_nilai,
			e.nilai_huruf,
			e.nilai_indeks,
            e.asal
        FROM
        (
            select 
				id_matkul as id_matkul,
				id_nilai_transfer as id_nilai,
				id_mahasiswa_pt as id_mahasiswa_pt,
				nilai_huruf_diakui AS nilai_huruf,
				nilai_angka_diakui as nilai_indeks, 
				concat('nilai_transfer') as asal 
			from nilai_transfer 
			WHERE id_mahasiswa_pt= ?
        ) e
        JOIN
            mata_kuliah_transfer c 
        ON
            e.id_matkul=c.id_matkul
        ORDER BY
            c.nm_mk
        ";
        
        return $this->db->query($sql,array($id_mahasiswa_pt));
    }
    
    function transkrip_all($id_mahasiswa_pt)
    {
        $sql = "
        SELECT 
            c.sks_mk,
			c.kode_mk,
			c.nm_mk,
			e.id_nilai,
			e.nilai_huruf,
			e.nilai_indeks,
            e.asal
        FROM
        (
            select 
				id_matkul as id_matkul,
				id_nilai as id_nilai,
				id_mahasiswa_pt as id_mahasiswa_pt,
				nilai_huruf AS nilai_huruf,
				nilai_indeks as nilai_indeks, 
				concat('nilai') as asal 
			from nilai 
			WHERE id_mahasiswa_pt= ?
			
            UNION ALL
			
            select 
				id_matkul as id_matkul,
				id_nilai_transfer as id_nilai,
				id_mahasiswa_pt as id_mahasiswa_pt,
				nilai_huruf_diakui AS nilai_huruf,
				nilai_angka_diakui as nilai_indeks, 
				concat('nilai_transfer') as asal 
			from nilai_transfer 
			WHERE id_mahasiswa_pt= ?
        ) e
        LEFT JOIN
            mata_kuliah c 
        ON
            e.id_matkul=c.id_matkul
        ORDER BY
            c.nm_mk
        ";
        return $this->db->query($sql,array($id_mahasiswa_pt,$id_mahasiswa_pt));
    }
    
}