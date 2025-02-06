<?php

namespace App\Models\Simta;

use CodeIgniter\Model;

class RekomendasiModel extends Model
{
    protected $uuidFields       = ['id_rekomendasi'];
    protected $table            = 'simta_rekomendasi';
    protected $primaryKey       = 'id_rekomendasi';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_rekomendasi', 'id_staf', 'id_pengajuanjudul','nama_rekomendasi', 
                                    'created_at', 'updated_at'];
    protected $validationRules = ['id_rekomendasi' => 'required'
    ];

    public function getDataByIdPengajuanJudul($id_pengajuanjudul)
    {
        return $this->where('id_pengajuanjudul', $id_pengajuanjudul)
                    ->findAll();
    }
}
?>