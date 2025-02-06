<?php

namespace App\Models\Sipema;

use CodeIgniter\Model;

class NilaiModel extends Model
{
    protected $uuidFields       = ['id_nilai'];
    protected $table            = 'sipema_nilai';
    protected $useTimestamps    = false;
    protected $primaryKey       = 'id_nilai';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_nilai', 'id_mata_kuliah', 'id_mhs', 'nilai_uts', 'nilai_uas', 'created_at', 'updated_at'];
    protected $validationRules = [
        'id_nilai' => 'required'
    ];

    function getNilaiMataKuliahMahasiswa()
    {
        $builder = $this->db->table('sipema_nilai');
        $builder->select('sipema_nilai.id_mhs, mahasiswa.nama');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = sipema_nilai.id_mhs');
        $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = sipema_nilai.id_mata_kuliah');
        $builder->groupBy('sipema_nilai.id_mhs');
        $query = $builder->get();
        return $query->getResult();
    }
    
    function getDetailNilaiMataKuliahMahasiswa()
    {
        $builder = $this->db->table('sipema_nilai');
        $builder->select('sipema_nilai.id_mhs, mahasiswa.nama as nama_mahasiswa, mata_kuliah.nama_mata_kuliah, mata_kuliah.sks, sipema_nilai.nilai_uts, sipema_nilai.nilai_uas, sipema_nilai.id_mata_kuliah');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = sipema_nilai.id_mhs');
        $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = sipema_nilai.id_mata_kuliah');
        $query = $builder->get();
        return $query->getResult();
    }

    function hapusDetailNilaiMataKuliahMahasiswa($id_mhs, $id_mata_kuliah)
    {
        $builder = $this->db->table('sipema_nilai');
        $builder->where('id_mhs', $id_mhs);
        $builder->where('id_mata_kuliah', $id_mata_kuliah);
        $builder->delete();
    }

    public function getNilaiById($id_mhs, $id_mata_kuliah)
    {
        $builder = $this->db->table('sipema_nilai');
        $builder->select('sipema_nilai.*, mahasiswa.nama as nama_mahasiswa, mata_kuliah.nama_mata_kuliah');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = sipema_nilai.id_mhs');
        $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = sipema_nilai.id_mata_kuliah');
        $builder->where('sipema_nilai.id_mhs', $id_mhs);
        $builder->where('sipema_nilai.id_mata_kuliah', $id_mata_kuliah);
        $query = $builder->get();
        return $query->getRow();
    }
    
    public function updateNilai($id_mhs, $id_mata_kuliah, $data)
    {
        $builder = $this->db->table('sipema_nilai');
        $builder->where('id_mhs', $id_mhs);
        $builder->where('id_mata_kuliah', $id_mata_kuliah);
        $builder->update($data);
    }

    function getByIdMahasiswa($id_mhs)
    {
        $builder = $this->db->table('sipema_nilai');
        $builder->where('id_mhs', $id_mhs);
        $query = $builder->get();
        return $query->getRow();
    }

    function updateMahasiswa($id_mhs, $data)
    {
        $builder = $this->db->table('sipema_nilai');
        $builder->where('sipema_nilai.id_mhs', $id_mhs);
        $builder->update($data);
    }

    function hapusNilaiMataKuliahMahasiswa($id_mhs)
    {
        $builder = $this->db->table('sipema_nilai');
        $builder->where('id_mhs', $id_mhs);
        $builder->delete();
    }

    function getFilterDataNilaiByIdMahasiswa($id_mhs_filter)
    {
        $builder = $this->db->table('sipema_nilai');
        $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = sipema_nilai.id_mata_kuliah');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = sipema_nilai.id_mhs');
        $builder->where('sipema_nilai.id_mhs', $id_mhs_filter);
        return $builder->get()->getResult();
    }

    function getFilterDataNilaiByIdMataKuliah($id_mata_kuliah_filter)
    {
        $builder = $this->db->table('sipema_nilai');
        $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = sipema_nilai.id_mata_kuliah');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = sipema_nilai.id_mhs');
        $builder->where('sipema_nilai.id_mata_kuliah', $id_mata_kuliah_filter);
        return $builder->get()->getResult();
    }

    function getFilterDataNilaiByNilaiUtsUasFilter($nilai_uts_uas_filter)
    {
        $builder = $this->db->table('sipema_nilai');
        $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = sipema_nilai.id_mata_kuliah');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = sipema_nilai.id_mhs');
        switch ($nilai_uts_uas_filter) {
                case 1:
                    $builder->where('sipema_nilai.nilai_uts >=', 90);
                    $builder->where('sipema_nilai.nilai_uts <=', 100);
                    $builder->where('sipema_nilai.nilai_uas >=', 90);
                    $builder->where('sipema_nilai.nilai_uas <=', 100);
                    break;
                case 2:
                    $builder->where('sipema_nilai.nilai_uts >=', 85);
                    $builder->where('sipema_nilai.nilai_uts <=', 90);
                    $builder->where('sipema_nilai.nilai_uas >=', 85);
                    $builder->where('sipema_nilai.nilai_uas <=', 90);
                    break;
                case 3:
                    $builder->where('sipema_nilai.nilai_uts >=', 80);
                    $builder->where('sipema_nilai.nilai_uts <=', 84.9);
                    $builder->where('sipema_nilai.nilai_uas >=', 80);
                    $builder->where('sipema_nilai.nilai_uas <=', 84.9);
                    break;
                case 4 :
                    $builder->where('sipema_nilai.nilai_uts >=', 75);
                    $builder->where('sipema_nilai.nilai_uts <=', 79.9);
                    $builder->where('sipema_nilai.nilai_uas >=', 75);
                    $builder->where('sipema_nilai.nilai_uas <=', 79.9);
                    break;
                case 5 :
                    $builder->where('sipema_nilai.nilai_uts >=', 70);
                    $builder->where('sipema_nilai.nilai_uts <=', 74.9);
                    $builder->where('sipema_nilai.nilai_uas >=', 70);
                    $builder->where('sipema_nilai.nilai_uas <=', 74.9);
                    break;
                case 6 :
                    $builder->where('sipema_nilai.nilai_uts >=', 65);
                    $builder->where('sipema_nilai.nilai_uts <=', 69.9);
                    $builder->where('sipema_nilai.nilai_uas >=', 65);
                    $builder->where('sipema_nilai.nilai_uas <=', 69.9);
                    break;
                case 7 :
                    $builder->where('sipema_nilai.nilai_uts >=', 60);
                    $builder->where('sipema_nilai.nilai_uts <=', 64.9);
                    $builder->where('sipema_nilai.nilai_uas >=', 60);
                    $builder->where('sipema_nilai.nilai_uas <=', 64.9);
                    break;
                case 8 :
                    $builder->where('sipema_nilai.nilai_uts >=', 55);
                    $builder->where('sipema_nilai.nilai_uts <=', 59.9);
                    $builder->where('sipema_nilai.nilai_uas >=', 55);
                    $builder->where('sipema_nilai.nilai_uas <=', 59.9);
                    break;
                case 9 :
                    $builder->where('sipema_nilai.nilai_uts >=', 50);
                    $builder->where('sipema_nilai.nilai_uts <=', 54.9);
                    $builder->where('sipema_nilai.nilai_uas >=', 50);
                    $builder->where('sipema_nilai.nilai_uas <=', 54.9);
                    break;
                case 10 :
                    $builder->where('sipema_nilai.nilai_uts >=', 0);
                    $builder->where('sipema_nilai.nilai_uts <=', 49.9);
                    $builder->where('sipema_nilai.nilai_uas >=', 0);
                    $builder->where('sipema_nilai.nilai_uas <=', 49.9);
                    break;
            }
        return $builder->get()->getResult();
    }

    function getFilterDataNilaiByIdMahasiswaAndIdMataKuliah($id_mhs_filter, $id_mata_kuliah_filter)
    {
        $builder = $this->db->table('sipema_nilai');
        $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = sipema_nilai.id_mata_kuliah');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = sipema_nilai.id_mhs');
        $builder->where('sipema_nilai.id_mhs', $id_mhs_filter);
        $builder->where('sipema_nilai.id_mata_kuliah', $id_mata_kuliah_filter);
        return $builder->get()->getResult();
    }

    function getFilterDataNilaiByIdMahasiswaAndNilaiUtsUasFilter($id_mhs_filter, $nilai_uts_uas_filter)
    {
        $builder = $this->db->table('sipema_nilai');
        $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = sipema_nilai.id_mata_kuliah');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = sipema_nilai.id_mhs');
        $builder->where('sipema_nilai.id_mhs', $id_mhs_filter);
        switch ($nilai_uts_uas_filter) {
            case 1:
                $builder->where('sipema_nilai.nilai_uts >=', 90);
                $builder->where('sipema_nilai.nilai_uts <=', 100);
                $builder->where('sipema_nilai.nilai_uas >=', 90);
                $builder->where('sipema_nilai.nilai_uas <=', 100);
                break;
            case 2:
                $builder->where('sipema_nilai.nilai_uts >=', 85);
                $builder->where('sipema_nilai.nilai_uts <=', 89.9);
                $builder->where('sipema_nilai.nilai_uas >=', 85);
                $builder->where('sipema_nilai.nilai_uas <=', 89.9);
                break;
            case 3:
                $builder->where('sipema_nilai.nilai_uts >=', 80);
                $builder->where('sipema_nilai.nilai_uts <=', 84.9);
                $builder->where('sipema_nilai.nilai_uas >=', 80);
                $builder->where('sipema_nilai.nilai_uas <=', 84.9);
                break;
            case 4 :
                $builder->where('sipema_nilai.nilai_uts >=', 75);
                $builder->where('sipema_nilai.nilai_uts <=', 79.9);
                $builder->where('sipema_nilai.nilai_uas >=', 75);
                $builder->where('sipema_nilai.nilai_uas <=', 79.9);
                break;
            case 5 :
                $builder->where('sipema_nilai.nilai_uts >=', 70);
                $builder->where('sipema_nilai.nilai_uts <=', 74.9);
                $builder->where('sipema_nilai.nilai_uas >=', 70);
                $builder->where('sipema_nilai.nilai_uas <=', 74.9);
                break;
            case 6 :
                $builder->where('sipema_nilai.nilai_uts >=', 65);
                $builder->where('sipema_nilai.nilai_uts <=', 69.9);
                $builder->where('sipema_nilai.nilai_uas >=', 65);
                $builder->where('sipema_nilai.nilai_uas <=', 69.9);
                break;
            case 7 :
                $builder->where('sipema_nilai.nilai_uts >=', 60);
                $builder->where('sipema_nilai.nilai_uts <=', 64.9);
                $builder->where('sipema_nilai.nilai_uas >=', 60);
                $builder->where('sipema_nilai.nilai_uas <=', 64.9);
                break;
            case 8 :
                $builder->where('sipema_nilai.nilai_uts >=', 55);
                $builder->where('sipema_nilai.nilai_uts <=', 59.9);
                $builder->where('sipema_nilai.nilai_uas >=', 55);
                $builder->where('sipema_nilai.nilai_uas <=', 59.9);
                break;
            case 9 :
                $builder->where('sipema_nilai.nilai_uts >=', 50);
                $builder->where('sipema_nilai.nilai_uts <=', 54.9);
                $builder->where('sipema_nilai.nilai_uas >=', 50);
                $builder->where('sipema_nilai.nilai_uas <=', 54.9);
                break;
            case 10 :
                $builder->where('sipema_nilai.nilai_uts >=', 0);
                $builder->where('sipema_nilai.nilai_uts <=', 49.9);
                $builder->where('sipema_nilai.nilai_uas >=', 0);
                $builder->where('sipema_nilai.nilai_uas <=', 49.9);
                break;
        }
        return $builder->get()->getResult();
    }

    function getFilterDataNilaiByIdMataKuliahAndNilaiUtsUasFilter($id_mata_kuliah_filter, $nilai_uts_uas_filter)
    {
        $builder = $this->db->table('sipema_nilai');
        $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = sipema_nilai.id_mata_kuliah');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = sipema_nilai.id_mhs');
        $builder->where('sipema_nilai.id_mata_kuliah', $id_mata_kuliah_filter);
        switch ($nilai_uts_uas_filter) {
            case 1:
                $builder->where('sipema_nilai.nilai_uts >=', 90);
                $builder->where('sipema_nilai.nilai_uts <=', 100);
                $builder->where('sipema_nilai.nilai_uas >=', 90);
                $builder->where('sipema_nilai.nilai_uas <=', 100);
                break;
            case 2:
                $builder->where('sipema_nilai.nilai_uts >=', 85);
                $builder->where('sipema_nilai.nilai_uts <=', 89.9);
                $builder->where('sipema_nilai.nilai_uas >=', 85);
                $builder->where('sipema_nilai.nilai_uas <=', 89.9);
                break;
            case 3:
                $builder->where('sipema_nilai.nilai_uts >=', 80);
                $builder->where('sipema_nilai.nilai_uts <=', 84.9);
                $builder->where('sipema_nilai.nilai_uas >=', 80);
                $builder->where('sipema_nilai.nilai_uas <=', 84.9);
                break;
            case 4 :
                $builder->where('sipema_nilai.nilai_uts >=', 75);
                $builder->where('sipema_nilai.nilai_uts <=', 79.9);
                $builder->where('sipema_nilai.nilai_uas >=', 75);
                $builder->where('sipema_nilai.nilai_uas <=', 79.9);
                break;
            case 5 :
                $builder->where('sipema_nilai.nilai_uts >=', 70);
                $builder->where('sipema_nilai.nilai_uts <=', 74.9);
                $builder->where('sipema_nilai.nilai_uas >=', 70);
                $builder->where('sipema_nilai.nilai_uas <=', 74.9);
                break;
            case 6 :
                $builder->where('sipema_nilai.nilai_uts >=', 65);
                $builder->where('sipema_nilai.nilai_uts <=', 69.9);
                $builder->where('sipema_nilai.nilai_uas >=', 65);
                $builder->where('sipema_nilai.nilai_uas <=', 69.9);
                break;
            case 7 :
                $builder->where('sipema_nilai.nilai_uts >=', 60);
                $builder->where('sipema_nilai.nilai_uts <=', 64.9);
                $builder->where('sipema_nilai.nilai_uas >=', 60);
                $builder->where('sipema_nilai.nilai_uas <=', 64.9);
                break;
            case 8 :
                $builder->where('sipema_nilai.nilai_uts >=', 55);
                $builder->where('sipema_nilai.nilai_uts <=', 59.9);
                $builder->where('sipema_nilai.nilai_uas >=', 55);
                $builder->where('sipema_nilai.nilai_uas <=', 59.9);
                break;
            case 9 :
                $builder->where('sipema_nilai.nilai_uts >=', 50);
                $builder->where('sipema_nilai.nilai_uts <=', 54.9);
                $builder->where('sipema_nilai.nilai_uas >=', 50);
                $builder->where('sipema_nilai.nilai_uas <=', 54.9);
                break;
            case 10 :
                $builder->where('sipema_nilai.nilai_uts >=', 0);
                $builder->where('sipema_nilai.nilai_uts <=', 49.9);
                $builder->where('sipema_nilai.nilai_uas >=', 0);
                $builder->where('sipema_nilai.nilai_uas <=', 49.9);
                break;
        }
        return $builder->get()->getResult();
    }

    function getFilterDataNilaiByIdMataKuliahAndNilaiUtsUasFilterAndNilaiUtsUasFilter($id_mhs_filter, $id_mata_kuliah_filter, $nilai_uts_uas_filter)
    {
        $builder = $this->db->table('sipema_nilai');
        $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = sipema_nilai.id_mata_kuliah');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = sipema_nilai.id_mhs');
        $builder->where('sipema_nilai.id_mhs', $id_mhs_filter);
        $builder->where('sipema_nilai.id_mata_kuliah', $id_mata_kuliah_filter);
        switch ($nilai_uts_uas_filter) {
            case 1:
                $builder->where('sipema_nilai.nilai_uts >=', 90);
                $builder->where('sipema_nilai.nilai_uts <=', 100);
                $builder->where('sipema_nilai.nilai_uas >=', 90);
                $builder->where('sipema_nilai.nilai_uas <=', 100);
                break;
            case 2:
                $builder->where('sipema_nilai.nilai_uts >=', 85);
                $builder->where('sipema_nilai.nilai_uts <=', 90);
                $builder->where('sipema_nilai.nilai_uas >=', 85);
                $builder->where('sipema_nilai.nilai_uas <=', 90);
                break;
            case 3:
                $builder->where('sipema_nilai.nilai_uts >=', 80);
                $builder->where('sipema_nilai.nilai_uts <=', 84.9);
                $builder->where('sipema_nilai.nilai_uas >=', 80);
                $builder->where('sipema_nilai.nilai_uas <=', 84.9);
                break;
            case 4 :
                $builder->where('sipema_nilai.nilai_uts >=', 75);
                $builder->where('sipema_nilai.nilai_uts <=', 79.9);
                $builder->where('sipema_nilai.nilai_uas >=', 75);
                $builder->where('sipema_nilai.nilai_uas <=', 79.9);
                break;
            case 5 :
                $builder->where('sipema_nilai.nilai_uts >=', 70);
                $builder->where('sipema_nilai.nilai_uts <=', 74.9);
                $builder->where('sipema_nilai.nilai_uas >=', 70);
                $builder->where('sipema_nilai.nilai_uas <=', 74.9);
                break;
            case 6 :
                $builder->where('sipema_nilai.nilai_uts >=', 65);
                $builder->where('sipema_nilai.nilai_uts <=', 69.9);
                $builder->where('sipema_nilai.nilai_uas >=', 65);
                $builder->where('sipema_nilai.nilai_uas <=', 69.9);
                break;
            case 7 :
                $builder->where('sipema_nilai.nilai_uts >=', 60);
                $builder->where('sipema_nilai.nilai_uts <=', 64.9);
                $builder->where('sipema_nilai.nilai_uas >=', 60);
                $builder->where('sipema_nilai.nilai_uas <=', 64.9);
                break;
            case 8 :
                $builder->where('sipema_nilai.nilai_uts >=', 55);
                $builder->where('sipema_nilai.nilai_uts <=', 59.9);
                $builder->where('sipema_nilai.nilai_uas >=', 55);
                $builder->where('sipema_nilai.nilai_uas <=', 59.9);
                break;
            case 9 :
                $builder->where('sipema_nilai.nilai_uts >=', 50);
                $builder->where('sipema_nilai.nilai_uts <=', 54.9);
                $builder->where('sipema_nilai.nilai_uas >=', 50);
                $builder->where('sipema_nilai.nilai_uas <=', 54.9);
                break;
            case 10 :
                $builder->where('sipema_nilai.nilai_uts >=', 0);
                $builder->where('sipema_nilai.nilai_uts <=', 49.9);
                $builder->where('sipema_nilai.nilai_uas >=', 0);
                $builder->where('sipema_nilai.nilai_uas <=', 49.9);
                break;
        }
        return $builder->get()->getResult();
    }
    
}