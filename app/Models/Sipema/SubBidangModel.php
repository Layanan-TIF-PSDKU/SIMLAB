<?php

namespace App\Models\Sipema;

use CodeIgniter\Model;

class SubBidangModel extends Model
{
    protected $uuidFields       = ['id_sub_bidang'];
    protected $table            = 'sipema_sub_bidang';
    protected $useTimestamps    = false;
    protected $primaryKey       = 'id_sub_bidang';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_sub_bidang', 'nama_sub_bidang', 'id_bidang', 'id_staf', 'created_at', 'updated_at'];
    protected $validationRules = [
        'id_sub_bidang' => 'required'
    ];

    function getIdSubBidang($id_sub_bidang)
    {
        $builder = $this->db->table('sipema_sub_bidang');
        $builder->join('sipema_sub_bidang_dosen', 'sipema_sub_bidang.id_sub_bidang = sipema_sub_bidang_dosen.id_sub_bidang');
        $builder->join('staf', 'sipema_sub_bidang_dosen.id_staf = staf.id_staf');
        $builder->where('sipema_sub_bidang.id_sub_bidang', $id_sub_bidang);
        $builder->where('staf.jenis', 'dosen');
        $query = $builder->get();
        return $query->getResultArray();
    }

    function getSubBidang($id_sub_bidang)
    {
        $builder = $this->db->table('sipema_sub_bidang');
        $builder->join('sipema_bidang', 'sipema_sub_bidang.id_bidang = sipema_bidang.id_bidang');
        $builder->where('sipema_sub_bidang.id_sub_bidang', $id_sub_bidang);
        $query = $builder->get();
        return $query->getRow();
    }
    
    function getDetailSubBidang()
    {
        $builder = $this->db->table('sipema_sub_bidang AS s');
        $builder->select('s.id_sub_bidang, IFNULL(sub_count.jumlah_staf, 0) AS jumlah_staf, st.nama AS nama_dosen, s.nama_sub_bidang, b.nama_bidang');
        $builder->join('sipema_sub_bidang_dosen AS sd', 's.id_sub_bidang = sd.id_sub_bidang');
        $builder->join('staf AS st', 'sd.id_staf = st.id_staf');
        $builder->join('sipema_bidang AS b', 'b.id_bidang = s.id_bidang');
        $builder->join('(SELECT id_sub_bidang, COUNT(id_staf) AS jumlah_staf FROM sipema_sub_bidang_dosen GROUP BY id_sub_bidang) AS sub_count', 's.id_sub_bidang = sub_count.id_sub_bidang', 'left');
        $query = $builder->get();
        return $query->getResult();
    }

    function getCountJumlahDosen()
    {
        $builder = $this->db->table('sipema_sub_bidang_dosen');
        $builder->select('id_sub_bidang, COUNT(id_staf) AS jumlah_staf');
        $builder->groupBy('id_sub_bidang');
        $query = $builder->get();
        return $query->getResult(); 
    }
    
    function getRekomendasiByDosen($id_sub_bidang, $id_user)
    {
        $builder = $this->db->table('sipema_sub_bidang_dosen');
        $builder->select('sipema_sub_bidang_dosen.id_sub_bidang_dosen, sipema_sub_bidang_dosen.id_sub_bidang, sipema_sub_bidang_dosen.id_staf, staf.nama as nama_dosen, staf.nip, staf.no_telp, staf.alamat, staf.jenis, staf.status, users.username');
        $builder->join('sipema_sub_bidang', 'sipema_sub_bidang_dosen.id_sub_bidang = sipema_sub_bidang.id_sub_bidang');
        $builder->join('staf', 'sipema_sub_bidang_dosen.id_staf = staf.id_staf');
        $builder->join('users', 'staf.id_user = users.id');
        $builder->where('sipema_sub_bidang_dosen.id_sub_bidang', $id_sub_bidang);
        if(in_groups('admin')){    
        }else{
           $builder->where('users.id', $id_user);
        }
        $query = $builder->get();
        return $query->getRowArray();
    }
}