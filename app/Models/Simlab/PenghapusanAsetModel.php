<?php

namespace App\Models\Simlab;

use CodeIgniter\Model;

class PenghapusanAsetModel extends Model
{
    protected $table      = 'simlab_penghapusan_aset';
    protected $primaryKey = 'id_penghapusan_aset';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields = ['id_penghapusan_aset','id_alat', 'tanggal_penghapusan','jumlah_penghapusan'];
    protected $validationRules = [
        'id_penghapusan_aset' => 'required'
    ];

    function getPenghapusanAset()
    {
        $builder = $this->db->table('simlab_penghapusan_aset');
        $builder->select('*, simlab_ruang_laboratorium.nama_ruang'); 
        $builder->join('simlab_alat_laboratorium', 'simlab_alat_laboratorium.id_alat = simlab_penghapusan_aset.id_alat');
        $builder->join('simlab_kategori', 'simlab_alat_laboratorium.id_kategori = simlab_kategori.id_kategori');
        $builder->join('simlab_ruang_laboratorium', 'simlab_alat_laboratorium.id_ruang = simlab_ruang_laboratorium.id_ruang');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getFilterPenghapusanAset($id_ruang, $tanggal_awal, $tanggal_akhir)
    {

        $builder = $this->db->table('simlab_penghapusan_aset');
        $builder->select('*, simlab_ruang_laboratorium.nama_ruang, simlab_kategori.nama_kategori');
        $builder->join('simlab_alat_laboratorium', 'simlab_alat_laboratorium.id_alat = simlab_penghapusan_aset.id_alat');
        $builder->join('simlab_kategori', 'simlab_alat_laboratorium.id_kategori = simlab_kategori.id_kategori');
        $builder->join('simlab_ruang_laboratorium', 'simlab_alat_laboratorium.id_ruang = simlab_ruang_laboratorium.id_ruang');
        $builder->where('simlab_alat_laboratorium.id_ruang', $id_ruang);
        $builder->where('simlab_penghapusan_aset.tanggal_penghapusan >=', $tanggal_awal);
        $builder->where('simlab_penghapusan_aset.tanggal_penghapusan <=', $tanggal_akhir);
        $builder->orderBy('nama_kategori', 'ASC');
        $builder->orderBy('nama_alat', 'ASC');
        $builder->orderBy('no_inventaris', 'ASC');
        $query = $builder->get();
        return $query->getResult();
    }
}

?>