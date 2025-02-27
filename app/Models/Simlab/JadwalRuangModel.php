<?php

namespace App\Models\Simlab;

use CodeIgniter\Model;

class JadwalRuangModel extends Model
{
    protected $table = 'simlab_jadwal_ruang';
    protected $primaryKey = 'id_jadwal';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $allowedFields = ['id_jadwal', 'id_mata_kuliah', 'id_ruang', 'kelas', 'hari', 'tahun_ajaran', 'semester', 'waktu_mulai', 'waktu_selesai'];
    protected $validationRules = [
        'id_jadwal' => 'required',
    ];

    public function getJadwalRuang($id_ruang)
    {
        $builder = $this->db->table('simlab_jadwal_ruang');
        $builder->select('simlab_jadwal_ruang.id_jadwal, simlab_jadwal_ruang.id_ruang, simlab_jadwal_ruang.waktu_mulai, simlab_jadwal_ruang.waktu_selesai, simlab_jadwal_ruang.kelas, simlab_jadwal_ruang.hari, simlab_jadwal_ruang.tahun_ajaran,simlab_jadwal_ruang.semester,,simlab_ruang_laboratorium.*, mata_kuliah.nama_mata_kuliah');
        $builder->join('simlab_ruang_laboratorium', 'simlab_ruang_laboratorium.id_ruang = simlab_jadwal_ruang.id_ruang');
        $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = simlab_jadwal_ruang.id_mata_kuliah');
        $builder->where('simlab_jadwal_ruang.id_ruang', $id_ruang);
        $builder->orderBy('tahun_ajaran', 'ASC');
        $builder->orderBy('semester', 'ASC');
        $builder->orderBy('kelas', 'ASC');
        $builder->orderBy("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')");
        $builder->orderBy('waktu_mulai', 'ASC');
        $query = $builder->get();
        return $query->getResult();
    }
    public function getJadwalByRuang($id_ruang, $id_jadwal)
    {
        $builder = $this->db->table('simlab_jadwal_ruang');
        $builder->select('simlab_jadwal_ruang.*, mata_kuliah.nama_mata_kuliah, simlab_ruang_laboratorium.nama_ruang');
        $builder->join('simlab_ruang_laboratorium', 'simlab_ruang_laboratorium.id_ruang = simlab_jadwal_ruang.id_ruang');
        $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = simlab_jadwal_ruang.id_mata_kuliah');
        $builder->where('simlab_jadwal_ruang.id_ruang', $id_ruang);
        $builder->where('simlab_jadwal_ruang.id_jadwal', $id_jadwal);
        $query = $builder->get();
        return $query->getRow();
    }
    public function updateJadwal($id_ruang, $id_jadwal, $data)
    {
        $builder = $this->db->table('simlab_jadwal_ruang');
        $builder->where('id_ruang', $id_ruang);
        $builder->where('id_jadwal', $id_jadwal);
        $builder->update($data);
    }
    public function deleteJadwal($id_ruang, $id_jadwal)
    {
        $builder = $this->db->table('simlab_jadwal_ruang');
        $builder->where('id_ruang', $id_ruang);
        $builder->where('id_jadwal', $id_jadwal);
        $builder->delete();
    }

    public function cekKetersediaanRuangByJadwalPraktikum($id_ruang, $hari, $waktu_mulai, $waktu_selesai)
    {
        $builder = $this->db->table('simlab_jadwal_ruang');
        $builder->where('id_ruang', $id_ruang);
        $builder->where('hari', $hari);
        // $builder->where('tahun_ajaran', $tahun_ajaran);
        $builder->where('waktu_mulai <', $waktu_selesai);
        $builder->where('waktu_selesai >', $waktu_mulai);
        return $builder->countAllResults();
    }

    public function getJadwal()
    {
        $builder = $this->db->table('simlab_jadwal_ruang');
        $builder->select('simlab_jadwal_ruang.id_jadwal, simlab_jadwal_ruang.id_ruang, simlab_jadwal_ruang.waktu_mulai, simlab_jadwal_ruang.waktu_selesai, simlab_jadwal_ruang.kelas, simlab_jadwal_ruang.hari, simlab_jadwal_ruang.tahun_ajaran,simlab_jadwal_ruang.semester,,simlab_ruang_laboratorium.*, mata_kuliah.nama_mata_kuliah');
        $builder->join('simlab_ruang_laboratorium', 'simlab_ruang_laboratorium.id_ruang = simlab_jadwal_ruang.id_ruang');
        $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = simlab_jadwal_ruang.id_mata_kuliah');
        $builder->orderBy('tahun_ajaran', 'ASC');
        $builder->orderBy('semester', 'ASC');
        $builder->orderBy('kelas', 'ASC');
        $builder->orderBy("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')");
        $builder->orderBy('waktu_mulai', 'ASC');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getFilterRuangPraktikum($id_ruang, $tahun_ajaran, $semester)
    {
        $builder = $this->db->table('simlab_jadwal_ruang');
        $builder->select('simlab_jadwal_ruang.id_jadwal, simlab_jadwal_ruang.id_ruang, simlab_jadwal_ruang.waktu_mulai, simlab_jadwal_ruang.waktu_selesai, simlab_jadwal_ruang.kelas, simlab_jadwal_ruang.hari, simlab_jadwal_ruang.tahun_ajaran,simlab_jadwal_ruang.semester,,simlab_ruang_laboratorium.*, mata_kuliah.nama_mata_kuliah');
        $builder->join('simlab_ruang_laboratorium', 'simlab_ruang_laboratorium.id_ruang = simlab_jadwal_ruang.id_ruang');
        $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = simlab_jadwal_ruang.id_mata_kuliah');
        $builder->where('simlab_jadwal_ruang.id_ruang', $id_ruang);
        $builder->where('simlab_jadwal_ruang.tahun_ajaran', $tahun_ajaran);
        $builder->where('simlab_jadwal_ruang.semester', $semester);
        $builder->orderBy('tahun_ajaran', 'ASC');
        $builder->orderBy('semester', 'ASC');
        $builder->orderBy('kelas', 'ASC');
        $builder->orderBy("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')");
        $builder->orderBy('waktu_mulai', 'ASC');
        $query = $builder->get();
        return $query->getResult();
    }
}
