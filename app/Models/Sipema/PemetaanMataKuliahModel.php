<?php

namespace App\Models\Sipema;

use CodeIgniter\Model;

class PemetaanMataKuliahModel extends Model
{
    protected $uuidFields       = ['id_pmk'];
    protected $table            = 'sipema_pemetaan_mata_k';
    protected $useTimestamps    = false;
    protected $primaryKey       = 'id_pmk';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_pmk', 'id_sub_bidang', 'id_mata_kuliah', 'id_bobot', 'created_at', 'updated_at'];
    protected $validationRules = [
        'id_pmk' => 'required'
    ];

    function getDetailPemetaanMataKuliahSubBidangModul($id_sub_bidang)
    {
        $builder = $this->db->table('sipema_pemetaan_mata_k');
        $builder->select('sipema_sub_bidang.id_sub_bidang,sipema_sub_bidang.nama_sub_bidang, mata_kuliah.nama_mata_kuliah, sipema_bobot.jenis_bobot, sipema_bobot.nilai_bobot, mata_kuliah.id_mata_kuliah');
        $builder->join('sipema_sub_bidang', 'sipema_sub_bidang.id_sub_bidang = sipema_pemetaan_mata_k.id_sub_bidang');
        $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = sipema_pemetaan_mata_k.id_mata_kuliah');
        $builder->join('sipema_bobot', 'sipema_bobot.id_bobot = sipema_pemetaan_mata_k.id_bobot');
        $builder->where('sipema_pemetaan_mata_k.id_sub_bidang', $id_sub_bidang);
        $query = $builder->get();
        return $query->getResult();
    }

    function getDetailPemetaanMataKuliah()
    {
        $builder = $this->db->table('sipema_pemetaan_mata_k');
        $builder->select('sipema_sub_bidang.id_sub_bidang, sipema_sub_bidang.nama_sub_bidang, mata_kuliah.nama_mata_kuliah, sipema_bobot.jenis_bobot, sipema_bobot.nilai_bobot, mata_kuliah.id_mata_kuliah');
        $builder->join('sipema_sub_bidang', 'sipema_sub_bidang.id_sub_bidang = sipema_pemetaan_mata_k.id_sub_bidang');
        $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = sipema_pemetaan_mata_k.id_mata_kuliah');
        $builder->join('sipema_bobot', 'sipema_bobot.id_bobot = sipema_pemetaan_mata_k.id_bobot');
        $query = $builder->get();
        return $query->getResult();
    }

    function getSubBidangPemetaanById($id_sub_bidang)
    {
        $builder = $this->db->table('sipema_pemetaan_mata_k');
        $builder->where('id_sub_bidang', $id_sub_bidang);
        $query = $builder->get();
        return $query->getRow();
    }

    function updateDetailPemetaanMataKuliah($id_sub_bidang, $id_mata_kuliah)
    {
        $builder = $this->db->table('sipema_pemetaan_mata_k');
        $builder->select('sipema_pemetaan_mata_k.*, sipema_sub_bidang.nama_sub_bidang');
        $builder->join('sipema_sub_bidang', 'sipema_sub_bidang.id_sub_bidang = sipema_pemetaan_mata_k.id_sub_bidang');
        $builder->where('sipema_pemetaan_mata_k.id_sub_bidang', $id_sub_bidang);
        $builder->where('sipema_pemetaan_mata_k.id_mata_kuliah', $id_mata_kuliah);
        $query = $builder->get();

        return $query->getRow();
    }

    public function getDataFilterPemetaan($id_bidang_filter_pemetaan, $id_sub_bidang_filter_pemetaan = null, $jenis_bobot_filter_pemetaan = null)
    {
        $builder = $this->db->table('sipema_pemetaan_mata_k');
        $builder->select('sipema_pemetaan_mata_k.*, sipema_sub_bidang.nama_sub_bidang, mata_kuliah.kode_mata_kuliah, mata_kuliah.nama_mata_kuliah, mata_kuliah.semester, mata_kuliah.sks, mata_kuliah.jenis, sipema_bobot.jenis_bobot, sipema_bobot.nilai_bobot');
        $builder->join('sipema_sub_bidang', 'sipema_sub_bidang.id_sub_bidang = sipema_pemetaan_mata_k.id_sub_bidang');
        $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = sipema_pemetaan_mata_k.id_mata_kuliah');
        $builder->join('sipema_bobot', 'sipema_bobot.id_bobot = sipema_pemetaan_mata_k.id_bobot');

        if (!empty($id_bidang_filter_pemetaan)) {
            $builder->where('sipema_sub_bidang.id_bidang', $id_bidang_filter_pemetaan);
        }

        if (!empty($id_sub_bidang_filter_pemetaan)) {
            $builder->where('sipema_pemetaan_mata_k.id_sub_bidang', $id_sub_bidang_filter_pemetaan);
        }

        if (!empty($jenis_bobot_filter_pemetaan)) {
            $builder->where('sipema_bobot.jenis_bobot', $jenis_bobot_filter_pemetaan);
        }

        $query = $builder->get();

        return $query->getResultArray();
    }

    public function getDataFilterPemetaanBidangJenisBobot($id_bidang_filter_pemetaan, $jenis_bobot_filter_pemetaan)
    {
        $builder = $this->db->table('sipema_pemetaan_mata_k');
        $builder->select('sipema_pemetaan_mata_k.*, sipema_sub_bidang.nama_sub_bidang, mata_kuliah.kode_mata_kuliah, mata_kuliah.nama_mata_kuliah, mata_kuliah.semester, mata_kuliah.sks, mata_kuliah.jenis, sipema_bobot.jenis_bobot, sipema_bobot.nilai_bobot');
        $builder->join('sipema_sub_bidang', 'sipema_sub_bidang.id_sub_bidang = sipema_pemetaan_mata_k.id_sub_bidang');
        $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = sipema_pemetaan_mata_k.id_mata_kuliah');
        $builder->join('sipema_bobot', 'sipema_bobot.id_bobot = sipema_pemetaan_mata_k.id_bobot');
        $builder->where('sipema_sub_bidang.id_bidang', $id_bidang_filter_pemetaan);
        $builder->where('sipema_bobot.jenis_bobot', $jenis_bobot_filter_pemetaan);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getDataFilterPemetaanJenisBobot($jenis_bobot_filter_pemetaan)
    {
        $builder = $this->db->table('sipema_pemetaan_mata_k');
        $builder->select('sipema_pemetaan_mata_k.*, sipema_sub_bidang.nama_sub_bidang, mata_kuliah.kode_mata_kuliah, mata_kuliah.nama_mata_kuliah, mata_kuliah.semester, mata_kuliah.sks, mata_kuliah.jenis, sipema_bobot.jenis_bobot, sipema_bobot.nilai_bobot');
        $builder->join('sipema_sub_bidang', 'sipema_sub_bidang.id_sub_bidang = sipema_pemetaan_mata_k.id_sub_bidang');
        $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = sipema_pemetaan_mata_k.id_mata_kuliah');
        $builder->join('sipema_bobot', 'sipema_bobot.id_bobot = sipema_pemetaan_mata_k.id_bobot');
        $builder->where('sipema_bobot.jenis_bobot', $jenis_bobot_filter_pemetaan);
        $query = $builder->get();
        return $query->getResultArray();
    }  
}