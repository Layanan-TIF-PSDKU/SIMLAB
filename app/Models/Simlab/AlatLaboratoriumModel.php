<?php

namespace App\Models\Simlab;

use CodeIgniter\Model;

class AlatLaboratoriumModel extends Model
{
    protected $table = 'simlab_alat_laboratorium';
    protected $primaryKey = 'id_alat';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $allowedFields = ['id_alat', 'id_kategori', 'id_ruang', 'nama_alat', 'no_inventaris', 'tanggal_masuk', 'jumlah_masuk', 'stok', 'satuan', 'kondisi', 'gambar', 'tanggal_perubahan'];
    protected $validationRules = [
        'id_alat' => 'required',
    ];

    public function getAlatLab()
    {
        $builder = $this->db->table('simlab_alat_laboratorium');
        $builder->select('simlab_alat_laboratorium.*, simlab_kategori.*, simlab_ruang_laboratorium.*');
        $builder->join('simlab_kategori', 'simlab_kategori.id_kategori = simlab_alat_laboratorium.id_kategori');
        $builder->join('simlab_ruang_laboratorium', 'simlab_ruang_laboratorium.id_ruang = simlab_alat_laboratorium.id_ruang');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getAlatLabBaik($kondisi = 'Baik')
    {
        $builder = $this->db->table('simlab_alat_laboratorium');
        $builder->select('simlab_alat_laboratorium.*, simlab_kategori.*, simlab_ruang_laboratorium.*');
        $builder->join('simlab_kategori', 'simlab_kategori.id_kategori = simlab_alat_laboratorium.id_kategori');
        $builder->join('simlab_ruang_laboratorium', 'simlab_ruang_laboratorium.id_ruang = simlab_alat_laboratorium.id_ruang');
        $builder->where('kondisi', $kondisi);
        $builder->orderBy('nama_kategori', 'ASC');
        $builder->orderBy('nama_alat', 'ASC');
        $builder->orderBy('no_inventaris', 'ASC');
        $builder->orderBy('tanggal_masuk', 'ASC');
        $query = $builder->get();
        return $query->getResult();
    }
    public function getAlatLabBaikStok($kondisi = 'Baik')
    {
        $builder = $this->db->table('simlab_alat_laboratorium');
        $builder->select('simlab_alat_laboratorium.*, simlab_kategori.*, simlab_ruang_laboratorium.*');
        $builder->join('simlab_kategori', 'simlab_kategori.id_kategori = simlab_alat_laboratorium.id_kategori');
        $builder->join('simlab_ruang_laboratorium', 'simlab_ruang_laboratorium.id_ruang = simlab_alat_laboratorium.id_ruang');
        $builder->where('kondisi', $kondisi);
        $builder->where('stok >', 0);
        $builder->orderBy('nama_kategori', 'ASC');
        $query = $builder->get();
        return $query->getResult();
    }
    public function getAlatLabRusak($kondisi = 'Rusak')
    {
        $builder = $this->db->table('simlab_alat_laboratorium');
        $builder->select('simlab_alat_laboratorium.*, simlab_kategori.*, simlab_ruang_laboratorium.*');
        $builder->join('simlab_kategori', 'simlab_kategori.id_kategori = simlab_alat_laboratorium.id_kategori');
        $builder->join('simlab_ruang_laboratorium', 'simlab_ruang_laboratorium.id_ruang = simlab_alat_laboratorium.id_ruang');
        $builder->where('kondisi', $kondisi);
        $builder->orderBy('nama_kategori', 'ASC');
        $query = $builder->get();
        return $query->getResult();
    }
    public function getDetailAlat($id)
    {
        $builder = $this->db->table('simlab_alat_laboratorium');
        $builder->select('*');
        $builder->join('simlab_kategori', 'simlab_kategori.id_kategori = simlab_alat_laboratorium.id_kategori');
        $builder->join('simlab_ruang_laboratorium', 'simlab_ruang_laboratorium.id_ruang = simlab_alat_laboratorium.id_ruang');
        $builder->where('simlab_alat_laboratorium.id_alat', $id);
        $query = $builder->get();
        return $query->getRow();
    }

    public function getStokByAlat($id_alat)
    {
        $builder = $this->db->table('simlab_alat_laboratorium');
        $builder->select('simlab_ruang_laboratorium.* ,simlab_alat_laboratorium.*');
        $builder->join('simlab_ruang_laboratorium', 'simlab_ruang_laboratorium.id_ruang = simlab_alat_laboratorium.id_ruang');
        $builder->where('simlab_alat_laboratorium.id_alat', $id_alat);
        $query = $builder->get();
        return $query->getRow();
    }

    public function getFilterAlatMasuk($id_ruang, $tanggal_awal, $tanggal_akhir, $kondisi = 'Baik')
    {

        $builder = $this->db->table('simlab_alat_laboratorium');
        $builder->join('simlab_kategori', 'simlab_kategori.id_kategori = simlab_alat_laboratorium.id_kategori');
        $builder->join('simlab_ruang_laboratorium', 'simlab_ruang_laboratorium.id_ruang = simlab_alat_laboratorium.id_ruang');
        $builder->where('simlab_alat_laboratorium.id_ruang', $id_ruang);
        $builder->where('simlab_alat_laboratorium.tanggal_masuk >=', $tanggal_awal);
        $builder->where('simlab_alat_laboratorium.tanggal_masuk <=', $tanggal_akhir);
        $builder->where('simlab_alat_laboratorium.kondisi', $kondisi);
        $builder->orderBy('nama_kategori', 'ASC');
        $builder->orderBy('nama_alat', 'ASC');
        $builder->orderBy('no_inventaris', 'ASC');
        $query = $builder->get();
        return $query->getResult();
    }
    public function getFilterAlatRusak($id_ruang, $tanggal_awal, $tanggal_akhir, $kondisi = 'Rusak')
    {

        $builder = $this->db->table('simlab_alat_laboratorium');
        $builder->join('simlab_kategori', 'simlab_kategori.id_kategori = simlab_alat_laboratorium.id_kategori');
        $builder->join('simlab_ruang_laboratorium', 'simlab_ruang_laboratorium.id_ruang = simlab_alat_laboratorium.id_ruang');
        $builder->where('simlab_alat_laboratorium.id_ruang', $id_ruang);
        $builder->where('simlab_alat_laboratorium.tanggal_perubahan >=', $tanggal_awal);
        $builder->where('simlab_alat_laboratorium.tanggal_perubahan <=', $tanggal_akhir);
        $builder->where('simlab_alat_laboratorium.kondisi', $kondisi);
        $builder->orderBy('nama_kategori', 'ASC');
        $builder->orderBy('nama_alat', 'ASC');
        $builder->orderBy('no_inventaris', 'ASC');
        $query = $builder->get();
        return $query->getResult();
    }
}