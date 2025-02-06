<?php

namespace App\Models\Simlab;

use CodeIgniter\Model;

class PerawatanAlatLabModel extends Model
{
    protected $table      = 'simlab_perawatan_alat';
    protected $primaryKey = 'id_perawatan_alat';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields = ['id_perawatan_alat','id_alat', 'jenis','level', 'tanggal'];
    protected $validationRules = [
        'id_perawatan_alat' => 'required'
    ];

    function getPerawatanAlat()
    {
        $builder = $this->db->table('simlab_perawatan_alat');
        $builder->select('*, simlab_ruang_laboratorium.nama_ruang'); 
        $builder->join('simlab_alat_laboratorium', 'simlab_perawatan_alat.id_alat = simlab_alat_laboratorium.id_alat');
        $builder->join('simlab_kategori', 'simlab_alat_laboratorium.id_kategori = simlab_kategori.id_kategori');
        $builder->join('simlab_ruang_laboratorium', 'simlab_alat_laboratorium.id_ruang = simlab_ruang_laboratorium.id_ruang');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getFilterPerawatanAlat($id_ruang, $tanggal_awal, $tanggal_akhir)
    {

        $builder = $this->db->table('simlab_perawatan_alat');
        $builder->select('*, simlab_ruang_laboratorium.nama_ruang, simlab_kategori.nama_kategori');
        $builder->join('simlab_alat_laboratorium', 'simlab_alat_laboratorium.id_alat = simlab_perawatan_alat.id_alat');
        $builder->join('simlab_kategori', 'simlab_alat_laboratorium.id_kategori = simlab_kategori.id_kategori');
        $builder->join('simlab_ruang_laboratorium', 'simlab_alat_laboratorium.id_ruang = simlab_ruang_laboratorium.id_ruang');
        $builder->where('simlab_alat_laboratorium.id_ruang', $id_ruang);
        $builder->where('simlab_perawatan_alat.tanggal >=', $tanggal_awal);
        $builder->where('simlab_perawatan_alat.tanggal <=', $tanggal_akhir);
        $builder->orderBy('nama_kategori', 'ASC');
        $builder->orderBy('nama_alat', 'ASC');
        $builder->orderBy('no_inventaris', 'ASC');
        $query = $builder->get();
        return $query->getResult();
    }
}

?>