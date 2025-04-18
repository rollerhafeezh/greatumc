<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tracer_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function simpan_tracer($data)
	{
	    $sql = '
	    INSERT IGNORE INTO '.$_ENV['DB_TRA'].'data_responden (`kode_pt`, `kode_prodi`, `nim`, `nama`, `hp`, `tahun_lulus`, `npwp`, `f8`, `f502`, `f504`, `f1101`, `f5b`, `f5c`, `f5d`, `f18a`, `f18b`, `f18c`, `f18d`, `f1201`, `f14`, `f15`, `f301`, `f302`, `f303`, `f401`, `f402`, `f403`, `f404`, `f405`, `f406`, `f407`, `f408`, `f409`, `f410`, `f411`, `f412`, `f413`, `f414`, `f415`, `f6`, `f7`, `f7a`, `f1001`, `f1601`, `f1602`, `f1603`, `f1604`, `f1605`, `f1606`, `f1607`, `f1608`, `f1609`, `f1610`, `f1611`, `f1612`, `f1613`, `f505`, `f5a1`, `f5a2`, `f1761`, `f1762`, `f1763`, `f1764`, `f1765`, `f1766`, `f1767`, `f1768`, `f1769`, `f1770`, `f1771`, `f1772`, `f1773`, `f1774`, `f21`, `f22`, `f23`, `f24`, `f25`, `f26`, `f27`) VALUE (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
	    
	    return $this->db->query($sql,$data);
	}
}