<?php

namespace App\Models\Mbkm;

use CodeIgniter\Model;

class BerkasModel extends Model
{
    protected $uuidFields       = ['id_berkas'];
    protected $table            = 'mbkm_berkas';
    protected $primaryKey       = 'id_berkas';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_berkas', 'nama_berkas', 'file_berkas', 'jenis', 'created_at', 'update_at'];
    protected $validationRules = [
        'id_berkas' => 'required'
    ];
    
    function getBerkasPendaftaran()
    {
        $builder = $this->db->table('mbkm_berkas');
        $builder->where('jenis', 'pendaftaran');
        $query = $builder->get();
        return $query->getResult();
    }
    function getBerkasInformasi()
    {
        $builder = $this->db->table('mbkm_berkas');
        $builder->where('jenis', 'informasi');
        $query = $builder->get();
        return $query->getResult();
    }
    
}