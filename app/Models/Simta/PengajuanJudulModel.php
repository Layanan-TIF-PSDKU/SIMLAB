<?php

namespace App\Models\Simta;

use CodeIgniter\Model;

class PengajuanJudulModel extends Model
{
    protected $uuidFields       = ['id_pengajuanjudul'];
    protected $table            = 'simta_pengajuanjudul';
    protected $primaryKey       = 'id_pengajuanjudul';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_pengajuanjudul', 'id_mhs',  'id_staf', 'nama_judul1','deskripsi_sistem1', 
                                   'nama_judul2','deskripsi_sistem2',  'nama_judul3','deskripsi_sistem3', 'status_pj', 'catatan', 
                                   'created_at', 'updated_at'];
    protected $validationRules = ['id_pengajuanjudul' => 'required'
    ];

    protected $mahasiswa = 'mahasiswa';
    protected $staf = 'staf';
    
    function getPengajuanJudulByUser()
    {   
        $user_id = user()->id;
        $builder = $this->db->table('simta_pengajuanjudul');
        $builder->select('simta_pengajuanjudul.*, mahasiswa.*,mahasiswa.nama as nm_mhs'); 
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = simta_pengajuanjudul.id_mhs');
        $builder->join('users', 'users.id = mahasiswa.id_user');
        $builder->where(['mahasiswa.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();
    }

    function getPengajuanJudulByUser1()
    {   
        $user_id = user()->id;
        $builder = $this->db->table('simta_pengajuanjudul');
        $builder->select('simta_pengajuanjudul.*, mahasiswa.*, staf.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs'); 
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = simta_pengajuanjudul.id_mhs');
        $builder->join('staf', 'staf.id_staf = simta_pengajuanjudul.id_staf');
        $builder->join('users', 'users.id = staf.id_user');
        $builder->where(['staf.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();
    }

    function getPengajuanJudulDetail()
    {   
        $user_id = user()->id;
        $builder = $this->db->table('simta_pengajuanjudul');
        $builder->select('simta_pengajuanjudul.*, mahasiswa.*, staf.*, simta_rekomendasi.* simta_rekomendasi.nama_rekomendasi as nm_rekomendasi,
                          staf.nama as nm_staf,mahasiswa.nama as nm_mhs'); 
        $builder->join('simta_rekomendasi', 'simta_rekomendasi.id_pengajuanjudul = simta_pengajuanjudul.id_rekomendasi');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = simta_pengajuanjudul.id_mhs');
        $builder->join('staf', 'staf.id_staf = simta_pengajuanjudul.id_staf');
        $builder->join('users', 'users.id = mahasiswa.id_user');
        $builder->where(['mahasiswa.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();
    }

    public function getUsers()
    {
        $builder = $this->db->table('simta_pengajuanjudul');
        $builder->join('simta_rekomendasi', 'simta_rekomendasi.id_rekomendasi');
    }

    public function getDataByIdPengajuanJudul($id_pengajuanjudul)
    {
        $builder = $this->db->table('simta_rekomendasi');
        $builder->where('id_pengajuanjudul', $id_pengajuanjudul);
        $builder->findAll();
    }
    public function getRekomendasiDosen()
    {
        //return $this->select('simta_pengajuanjudul.*, simta_rekomendasi.nama_rekomendasi AS nama_rekomendasi, staf.nama AS nama_staf')
            //->join('simta_rekomendasi', 'simta_rekomendasi.id_rekomendasi = simta_pengajuanjudul.rekomendasi_id', 'left')
           // ->join('staf', 'staf.id_staf = simta_pengajuanjudul.id_staf', 'left')
           // ->findAll();
        // $builder = $this->db->table('simta_pengajuanjudul');
        // return $this->select('simta_pengajuanjudul.id_pengajuanjudul, simta_pengajuanjudul.id_mhs, simta_pengajuanjudul.id_staf, 
        // simta_pengajuanjudul.nama_judul1, simta_pengajuanjudul.deskripsi_sistem1, simta_pengajuanjudul.nama_judul2, 
        // simta_pengajuanjudul.deskripsi_sistem2, simta_pengajuanjudul.nama_judul3, simta_pengajuanjudul.deskripsi_sistem3, 
        // gs.id_rekomendasi, g.nama_rekomendasi AS nama_rekomendasi, s.id_staf, s.nama AS staf_nama, s.jenis AS staf_jenis')
        //     ->join('simta_rekomendasi gs', 'simta_pengajuanjudul.id_pengajuanjudul = gs.id_pengajuanjudul')
        //     ->join('simta_rekomendasi g', 'g.id_rekomendasi = gs.id_rekomendasi')
        //     ->join('staf s', 's.id_user = simta_pengajuanjudul.id_staf', 'left') 
        //     ->findAll();
        $builder = $this->db->table('simta_pengajuanjudul');
        $builder->select('mahasiswa.id_mhs AS id_mhs, mahasiswa.nama AS `nama_mahasiswa`,
            s.nama AS `nama_staf`,
            r.nama_rekomendasi AS `nama_rekomendasi`,
            mahasiswa.nim AS `nim`,
            mahasiswa.kelas AS `kelas`,
            simta_pengajuanjudul.nama_judul1 AS `nama_judul1`,
            simta_pengajuanjudul.deskripsi_sistem1 AS `deskripsi_sistem1`,
            simta_pengajuanjudul.nama_judul2 AS `nama_judul2`,
            simta_pengajuanjudul.deskripsi_sistem2 AS `deskripsi_sistem2`,
            simta_pengajuanjudul.nama_judul3 AS `nama_judul3`,
            simta_pengajuanjudul.deskripsi_sistem3 AS `deskripsi_sistem3`');
        $builder->join('mahasiswa mahasiswa', 'simta_pengajuanjudul.id_mhs = mahasiswa.id_mhs');
        $builder->join('simta_rekomendasi r', 'simta_pengajuanjudul.id_pengajuanjudul = r.id_pengajuanjudul');
        $builder->join('staf s', 'r.id_staf = s.id_staf');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getData()
    {
        $builder = $this->db->table($this->simta_pengajuanjudul);
        $builder->select('*');
        $builder->join($this->mahasiswa, 'simta_pengajuanjudul.id_mhs = mahasiswa.id_mhs', 'left');
        $builder->join($this->staf, 'simta_pengajuanjudul.id_staf = staf.id_staf', 'left');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function countPengajuanJudul() {
        // Assuming you have the method getPengajuanJudulByUser1 in the model
        $pengajuanJudul = $this->getPengajuanJudulByUser1();

        // Return the count of pengajuan judul
        return count($pengajuanJudul);
    }
    
}