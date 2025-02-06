<?php
namespace App\Models\Simta;

use CodeIgniter\Model;

class BerkasTAModel extends Model
{
    protected $uuidFields       = ['id_berkas'];
    protected $table            = 'simta_berkas';
    protected $primaryKey       = 'id_berkas';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_berkas', 'nama_berkas',  'kategori', 'keterangan', 'file_berkas'];
    protected $validationRules = ['id_berkas' => 'required'
    ];
}
