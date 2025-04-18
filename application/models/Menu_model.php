<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('encryption');
	}

	function get_user_studi_akhir()
	{
	    $this->db->join($_ENV['DB_SSO'].'app_level b','a.id_level=b.id_level','left');
	    $this->db->join($_ENV['DB_SSO'].'app_ref c','b.id_app=c.id_app','left');
	    $this->db->join($_ENV['DB_AKT'].'anggota aa','aa.id_mahasiswa_pt = '.$_SESSION['id_user']);
	    
	    // $this->db->where('a.status_user_level',1);
	    $this->db->where('a.username',$_SESSION['username']);
	    $this->db->where_in('c.id_app', [6, 7]);
	    
	    $this->db->order_by('c.nama_app','ASC');
	    $this->db->order_by('b.level_name','ASC');

	    $this->db->group_by('c.id_app');

	    return $this->db->get($_ENV['DB_SSO'].'user_level a')->result();
	}

	// function create_auth($salt_key, $id_level)
	function create_auth($salt_key, $id_level, $id_user)
	{
	    $waktu = date("Y-m-d H:i:s");
	    $add2  = date('Y-m-d H:i:s',strtotime('+2 minutes',strtotime($waktu)));
	    $plain_text=$_SESSION['username'].'#'.$id_level.'#'.$id_user.'#'.$add2;
	    // $plain_text=$_SESSION['username'].'#'.$id_level.'#'.$add2;
		$this->encryption->initialize(array(	
												'cipher' => 'aes-256',
												'mode' => 'ctr',
												'key' => $salt_key
												));
		
		$kirim=$this->encryption->encrypt($plain_text);
		return str_replace('=', '', base64_encode($kirim));
	}

	function studi_akhir_mahasiswa()
	{
		$data = $this->get_user_studi_akhir();
		foreach ($data as $row) {
			$auth = $this->create_auth($row->salt_app, $row->id_level, $_SESSION['id_user']);

			echo'
	        <li class="nav-item">
	            <a href="'.$row->url_app.'/auth/logon/'.$auth.'" target="_blank" class="nav-link mininav-toggle">
				<i class="psi-atom fs-5 me-2"></i>
	        	    <span class="nav-label mininav-content ms-1">'.$row->nama_app.'</span>
	            </a>
	        </li>
	        ';
		}
	}
    
    function dosen()
    {
        $data=['has-sub'=>FALSE,
				'menu_color'=>'',
				'menu_link'=>'dosen/index',
				'menu_text'=>'Dosen',
				'menu_icon'=>'psi-business-man-woman'
			];
		return $data;
    }
    
    function tahun()
    {
        $data=['has-sub'=>FALSE,
				'menu_color'=>'',
				'menu_link'=>'pengaturan/tahun',
				'menu_text'=>'Tahun Akademik',
				'menu_icon'=>'psi-calendar'
			];
		return $data;
    }
    
    function mahasiswa()
    {
        $data=['has-sub'=>TRUE,
				'menu_color'=>'bg-success',
				'menu_text'=>'Mahasiswa',
				'menu_icon'=>'psi-student-male-female',
				'menu_link'=>'mahasiswa',
				//#1..n
				'menu_child'=>[   ['menu_link'=>'mahasiswa/index',
								    'menu_text'=>'Daftar Mahasiswa'],
								    ['menu_link'=>'mahasiswa/kuliah_mahasiswa',
									'menu_text'=>'Aktifitas Mahasiswa'],
								    ['menu_link'=>'mahasiswa/validasi',
									'menu_text'=>'Validasi KRS'],
									['menu_link'=>'mahasiswa/kartu_ujian',
									'menu_text'=>'Kartu Ujian'],
									['menu_link'=>'mahasiswa/mutasi',
									'menu_text'=>'Mutasi'],
							]
            
            ];
        return $data;
    }
	
	function kurikulum()
	{
		$data=['has-sub'=>TRUE,
				'menu_color'=>'bg-success',
				'menu_text'=>'Kurikulum',
				'menu_icon'=>'psi-books-2',
				'menu_link'=>'kurikulum',
				//#1..n
				'menu_child'=>[   ['menu_link'=>'kurikulum/index',
								    'menu_text'=>'Daftar Kurikulum'],
								    ['menu_link'=>'kurikulum/add',
									'menu_text'=>'Buat Kurikulum'],
							]
            
            ];
        return $data;
	}
	
	function mata_kuliah()
	{
		$data=['has-sub'=>TRUE,
				'menu_color'=>'bg-success',
				'menu_text'=>'Mata Kuliah',
				'menu_icon'=>'psi-notepad-2',
				'menu_link'=>'matkul',
				//#1..n
				'menu_child'=>[   ['menu_link'=>'matkul/index',
								    'menu_text'=>'Daftar Mata Kuliah'],
								    ['menu_link'=>'matkul/add',
									'menu_text'=>'Buat Mata Kuliah'],
							]
            
            ];
        return $data;
	}
	
	function kelas_kuliah()
	{
		$data=['has-sub'=>TRUE,
				'menu_color'=>'bg-success',
				'menu_text'=>'Kelas Kuliah',
				'menu_icon'=>'psi-blackboard',
				'menu_link'=>'kelas',
				//#1..n
				'menu_child'=>[   ['menu_link'=>'kelas/index',
								    'menu_text'=>'Daftar Kelas Kuliah'],
								    ['menu_link'=>'kelas/add',
									'menu_text'=>'Buat Kelas Kuliah'],
							]
            
            ];
        return $data;
	}
	
	                            	
	function pengaturan()
	{
		$data=['has-sub'=>TRUE,
				'menu_color'=>'bg-success',
				'menu_text'=>'Pengaturan',
				'menu_icon'=>'psi-gear',
				'menu_link'=>'pengaturan',
				//#1..n
			    'menu_child'=>[     ['menu_link'=>'berita/',
									'menu_text'=>'Berita'],
									['menu_link'=>'pengaturan/fakultas',
									'menu_text'=>'Atur Fakultas'],
									['menu_link'=>'gedung/index',
									'menu_text'=>'Atur Gedung dan Ruangan'],
									['menu_link'=>'pengaturan/index',
									'menu_text'=>'Atur Konstanta'],
									['menu_link'=>'pengaturan/log_akademik',
									'menu_text'=>'Log Akademik'],
									['menu_link'=>'pengaturan/persepsi',
									'menu_text'=>'Evaluasi Kelas'],
							]
            
            ];
        return $data;
	}
	
	function dhmd()
	{
		$data=['has-sub'=>TRUE,
				'menu_color'=>'bg-success',
				'menu_text'=>'Monitoring PBM',
				'menu_icon'=>'psi-spell-check',
				'menu_link'=>'monitoring',
				//#1..n
				'menu_child'=>[   ['menu_link'=>'monitoring/index',
								    'menu_text'=>'Perkuliahan'],
								    ['menu_link'=>'monitoring/ujian',
									'menu_text'=>'Ujian'],
									['menu_link'=>'monitoring/rekap',
									'menu_text'=>'Rekapitulasi SKS'],
									/*['menu_link'=>'monitoring/rekap_2',
									'menu_text'=>'Rekapitulasi Pertemuan'],*/
							]
            
            ];
        return $data;
	}
	
	function dhmd_dosen()
	{
		$data=['has-sub'=>TRUE,
				'menu_color'=>'bg-success',
				'menu_text'=>'PBM',
				'menu_icon'=>'psi-spell-check',
				'menu_link'=>'dhmd',
				//#1..n
				'menu_child'=>[   ['menu_link'=>'dhmd/kelas_kuliah_dosen',
								    'menu_text'=>'Kelas Kuliah'],
								    ['menu_link'=>'dhmd/arsip_kelas_kuliah_dosen',
									'menu_text'=>'Arsip Kelas Kuliah'],
									['menu_link'=>'dhmd/pengawasan_ujian',
									'menu_text'=>'Pengawasan Ujian'],
									['menu_link'=>'dosen/riwayat_pengawasan',
									'menu_text'=>'Arsip Pengawasan Ujian'],
							]
            
            ];
        return $data;
	}
	
	function dhmd_mahasiswa()
	{
		$data=['has-sub'=>TRUE,
				'menu_color'=>'bg-success',
				'menu_text'=>'PBM',
				'menu_icon'=>'psi-spell-check',
				'menu_link'=>'dhmd',
				//#1..n
				'menu_child'=>[   ['menu_link'=>'dhmd/kelas_kuliah_mahasiswa',
								    'menu_text'=>'Kelas Kuliah'],
								    ['menu_link'=>'dhmd/arsip_kelas_kuliah_mahasiswa',
									'menu_text'=>'Arsip Kelas Kuliah'],
							]
            
            ];
        return $data;
	}
	
	function perwalian_mhs()
	{
		$data=['has-sub'=>TRUE,
				'menu_color'=>'bg-success',
				'menu_text'=>'Akademik',
				'menu_icon'=>'psi-handshake',
				'menu_link'=>'krs',
				//#1..n
				'menu_child'=>[   ['menu_link'=>'krs/add',
								    'menu_text'=>'Buat KRS'],
								    ['menu_link'=>'krs/riwayat_ajar',
									'menu_text'=>'Riwayat Ajar'],
									['menu_link'=>'krs/transkrip',
									'menu_text'=>'Transkrip Nilai'],
							]
            
            ];
        return $data;
	}
	
	function pkm()
	{
		$data=['has-sub'=>TRUE,
				'menu_color'=>'bg-success',
				'menu_text'=>'PKM',
				'menu_icon'=>'psi-handshake',
				'menu_link'=>'pkm',
				//#1..n
				'menu_child'=>[   ['menu_link'=>'pkm/',
								    'menu_text'=>'Pengumuman'],
								    ['menu_link'=>'pkm/add',
									'menu_text'=>'Buat Ajuan'],
									['menu_link'=>'pkm/tabel',
									'menu_text'=>'Arsip PKM'],
							]
            
            ];
        return $data;
	}
	
	function perwalian()
	{
		$data=['has-sub'=>TRUE,
				'menu_color'=>'bg-success',
				'menu_text'=>'Perwalian',
				'menu_icon'=>'psi-handshake',
				'menu_link'=>'perwalian',
				//#1..n
				'menu_child'=>[   ['menu_link'=>'perwalian/index',
								    'menu_text'=>'Perwalian'],
								 //    ['menu_link'=>'perwalian/mbkm',
									// 'menu_text'=>'Perwalian MBKM'],
									['menu_link'=>'perwalian/tabel_mahasiswa',
									'menu_text'=>'Daftar Mahasiswa'],
							]
            
            ];
        return $data;
	}

	function studi_akhir()
	{
		$data=['has-sub'=>FALSE,
				'menu_color'=>'bg-success',
				'menu_text'=>'Studi Akhir',
				'menu_icon'=>'psi-student-male',
				'menu_link'=>'studi_akhir',
				//#1..n
				// 'menu_child'=>[   ['menu_link'=>'studi_akhir/index',
				// 				    'menu_text'=>'Daftar Studi Akhir'],
				// 				    ['menu_link'=>'studi_akhir/tambah',
				// 					'menu_text'=>'Buat Data Baru'],
				// 			]
            
            ];
        return $data;
	}

	function mbkm()
	{
		$data=['has-sub'=>TRUE,
				'menu_color'=>'bg-success',
				'menu_text'=>'Kampus Merdeka',
				'menu_icon'=>'psi-atom',
				'menu_link'=>'mbkm',
				'menu_child'=>[   ['menu_link'=>'mbkm/index',
								    'menu_text'=>'Program MBKM'],
								    ['menu_link'=>'mbkm/aktivitas_mhs',
									'menu_text'=>'Aktivitas Mahasiswa'],
								    ['menu_link'=>'mbkm/mitra',
									'menu_text'=>'Mitra'],
									['menu_link'=>'mbkm/pic',
									'menu_text'=>'Koordinator (PIC)'],
									['menu_link'=>'mbkm/berita',
									'menu_text'=>'Berita MBKM'],
							]
            
            ];
        return $data;
	}

	function mbkm_mahasiswa()
	{
		$data=['has-sub'=>true,
				'menu_color'=>'bg-success',
				'menu_text'=>'Kampus Merdeka',
				'menu_icon'=>'psi-atom',
				'menu_link'=>'mbkm',
				'menu_child'=>[   ['menu_link'=>'mbkm',
								    'menu_text'=>'Program Saya'],
								    ['menu_link'=>'mbkm/cari_program',
								    'menu_text'=>'Cari Program'],
							]
            
            ];
        return $data;
	}

	function mbkm_dosen()
	{
		$data=['has-sub'=>true,
				'menu_color'=>'bg-success',
				'menu_text'=>'Kampus Merdeka',
				'menu_icon'=>'psi-atom',
				'menu_link'=>'mbkm',
				'menu_child'=>[   ['menu_link'=>'mbkm/pembimbing',
								    'menu_text'=>'Pembimbing'],
								    ['menu_link'=>'mbkm/koordinator',
								    'menu_text'=>'Koordinator'],
							]
            
            ];
        return $data;
	}

	function bimbingan()
	{
		$data=['has-sub'=>TRUE,
				'menu_color'=>'bg-success',
				'menu_text'=>'Studi Akhir',
				'menu_icon'=>'psi-student-male',
				'menu_link'=>'studi_akhir',
				'menu_child'=>[ 
								['menu_link'	=> 'studi_akhir/dosen_pembimbing', 'menu_text'=>'Dosen Pembimbing'],
							  	[ 'menu_link'	=> 'studi_akhir/dosen_penguji', 'menu_text'=>'Dosen Penguji'],
							  	[ 'menu_link'	=> 'studi_akhir/ketua_sidang', 'menu_text'=>'Ketua Sidang'],
							]
            ];
        return $data;
	}
	
	function biodata()
	{
		$data=['has-sub'=>FALSE,
				'menu_color'=>'',
				'menu_link'=>'biodata/index',
				'menu_text'=>'Biodata',
				'menu_icon'=>'psi-id-card'
			];
		return $data;
	}

	function mahasiswa_inbound()
	{
		$data=['has-sub'=>FALSE,
				'menu_color'=>'',
				'menu_link'=>'inbound/kuliah',
				'menu_text'=>'Perkuliahan',
				'menu_icon'=>'psi-notepad'
			];
		return $data;
	}
    
    function lihat($menu)
    {
        $data = $this->$menu();
        if($data['has-sub']){
            echo'
                <li class="nav-item has-sub">
                    <a href="#" class="mininav-toggle nav-link collapsed '.(strpos($this->uri->uri_string(), $data['menu_link']) !== false ? 'active' : '').'">
						<i class="'.$data['menu_icon'].' fs-5 me-2"></i>
                	    <span class="nav-label ms-1">'.$data['menu_text'].'</span>
                    </a>
                
                    <ul class="mininav-content nav collapse">';
                	    foreach($data['menu_child'] as $value){
                	    echo'<li class="nav-item">
                		    <a href="'.base_url($value['menu_link']).'" class="nav-link">'.$value['menu_text'].'</a>
                	    </li>';
                	    }
            echo '</ul>
                </li>';
        }else{
            echo'
            <li class="nav-item">
                <a href="'.base_url($data['menu_link']).'" class="nav-link mininav-toggle '.(strpos($this->uri->uri_string(), $data['menu_link']) !== false ? 'active' : '').'">
				<i class="'.$data['menu_icon'].' fs-5 me-2"></i>
            	    <span class="nav-label mininav-content ms-1">'.$data['menu_text'].'</span>
                </a>
            </li>
            ';
        }
    }

}