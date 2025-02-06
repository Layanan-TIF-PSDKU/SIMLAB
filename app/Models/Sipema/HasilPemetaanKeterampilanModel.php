<?php

namespace App\Models\Sipema;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use CodeIgniter\Model;

class HasilPemetaanKeterampilanModel extends Model
{
    protected $uuidFields       = ['id_hpk'];
    protected $table            = 'sipema_hasil_pemetaan_k';
    protected $primaryKey       = 'id_hpk';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_hpk', 'id_sub_bidang', 'id_mhs', 'nilai_akhir'];
    protected $validationRules = [
        'id_hpk' => 'required'
    ];

    public function getCekHapusDataIdSubBidang()
    {   
        $query = "DELETE FROM sipema_hasil_pemetaan_k WHERE id_sub_bidang NOT IN ( SELECT DISTINCT id_sub_bidang FROM sipema_pemetaan_mata_k)";
        $this->db->query($query);
    }

    public function getCekHapusDataIdMahasiswa()
    {   
        $query = "DELETE FROM sipema_hasil_pemetaan_k WHERE id_mhs NOT IN ( SELECT DISTINCT id_mhs FROM sipema_nilai)";
        $this->db->query($query);
    }
    
    public function getKalkulasiHasilPemetaan()
    {
        /* Menghitung total SKS yang dimiliki oleh setiap mahasiswa */
        $perhitungan_sks = $this->db->table('mahasiswa m')
                    ->select('m.id_mhs, m.nama, SUM(mk.sks) AS total_sks')
                    ->join('sipema_nilai sn', 'sn.id_mhs = m.id_mhs')
                    ->join('mata_kuliah mk', 'mk.id_mata_kuliah = sn.id_mata_kuliah')
                    ->groupBy('m.id_mhs, m.nama')
                    ->get();

        $jumlah_sks = $perhitungan_sks->getResult();
        /* Memproses setiap data hasil perhitungan SKS */
        foreach ($jumlah_sks as $result) {
            /* Jika total SKS lebih dari 86 */
            if ($result->total_sks >= 86) {
                    $query = "INSERT INTO sipema_hasil_pemetaan_k (id_hpk, id_sub_bidang, id_mhs, nilai_akhir, total_sks)
                    SELECT UUID(), s.id_sub_bidang, s.id_mhs, ROUND(SUM(nilai_akhir),2) as nilai_akhir, 
                    (
                        SELECT SUM(mata_kuliah.sks)
                        FROM sipema_nilai
                        JOIN mata_kuliah ON sipema_nilai.id_mata_kuliah = mata_kuliah.id_mata_kuliah
                            JOIN sipema_pemetaan_mata_k ON sipema_nilai.id_mata_kuliah = sipema_pemetaan_mata_k.id_mata_kuliah
                        WHERE sipema_nilai.id_mhs = s.id_mhs AND sipema_pemetaan_mata_k.id_sub_bidang = s.id_sub_bidang
                    ) as total_sks
                    FROM (
                        SELECT sipema_nilai.id_mhs, sipema_pemetaan_mata_k.id_sub_bidang,
                            ((SUM(sipema_nilai.nilai_uts) / COUNT(DISTINCT sipema_nilai.id_mata_kuliah)) + 
                            (SUM(sipema_nilai.nilai_uas) / COUNT(DISTINCT sipema_nilai.id_mata_kuliah))) / 2 * sipema_bobot.nilai_bobot as nilai_akhir
                        FROM sipema_nilai
                        JOIN sipema_pemetaan_mata_k ON sipema_nilai.id_mata_kuliah = sipema_pemetaan_mata_k.id_mata_kuliah
                        JOIN sipema_bobot ON sipema_pemetaan_mata_k.id_bobot = sipema_bobot.id_bobot
                        JOIN mata_kuliah ON sipema_nilai.id_mata_kuliah = mata_kuliah.id_mata_kuliah 
                        GROUP BY sipema_nilai.id_mhs, sipema_pemetaan_mata_k.id_sub_bidang, sipema_bobot.nilai_bobot
                    ) s
                    GROUP BY s.id_sub_bidang, s.id_mhs
                    ON DUPLICATE KEY UPDATE nilai_akhir = VALUES(nilai_akhir), total_sks = VALUES(total_sks)";
                    /* Menjalankan query */
                    $this->db->query($query);
            }else{
                /* Menghapus hasil pemetaan dari database jika total SKS kurang dari 86 */
                $this->db->table('sipema_hasil_pemetaan_k')
                ->where('id_mhs', $result->id_mhs)
                ->delete();
            }
        }
    }    

    function getDataSubBidang($id_bidang, $id_sub_bidang = null, $nilai_akhir_filter = null, $sks_filter = null)
    {
        $builder = $this->db->table('sipema_hasil_pemetaan_k');
        if($id_sub_bidang == null){
            $builder->select('mahasiswa.id_mhs, mahasiswa.nama as nama_mahasiswa, sipema_bidang.nama_bidang, SUM(sipema_hasil_pemetaan_k.total_sks) as total_sks, ROUND(AVG(sipema_hasil_pemetaan_k.nilai_akhir),2) as nilai_akhir');
        }elseif($id_sub_bidang != null){
            $builder->select('mahasiswa.id_mhs, mahasiswa.nama as nama_mahasiswa, sipema_bidang.nama_bidang, sipema_sub_bidang.nama_sub_bidang, SUM(sipema_hasil_pemetaan_k.total_sks) as total_sks, ROUND(AVG(sipema_hasil_pemetaan_k.nilai_akhir),2) as nilai_akhir');
        }
        $builder->join('mahasiswa', 'sipema_hasil_pemetaan_k.id_mhs = mahasiswa.id_mhs');
        $builder->join('sipema_sub_bidang', 'sipema_hasil_pemetaan_k.id_sub_bidang = sipema_sub_bidang.id_sub_bidang');
        $builder->join('sipema_bidang', 'sipema_sub_bidang.id_bidang = sipema_bidang.id_bidang');
        if (!empty($sks_filter)) {
            if($sks_filter == 1){
                $builder->having('total_sks <=', 10);
            } elseif ($sks_filter == 2) {
                $builder->having('total_sks >=', 10);
                $builder->having('total_sks <=', 20);
            } elseif ($sks_filter == 3) {
                $builder->having('total_sks >=', 20);
                $builder->having('total_sks <=', 30);
            } elseif ($sks_filter == 4) {
                $builder->having('total_sks >=', 30);
                $builder->having('total_sks <=', 40);
            } elseif ($sks_filter == 5) {
                $builder->having('total_sks >=', 40);
                $builder->having('total_sks <=', 50);
            } elseif ($sks_filter == 6) {
                $builder->having('total_sks >=', 50);
                $builder->having('total_sks <=', 60);
            } elseif ($sks_filter == 7) {
                $builder->having('total_sks >=', 60);
                $builder->having('total_sks <=', 70);
            } elseif ($sks_filter == 8) {
                $builder->having('total_sks >=', 70);
                $builder->having('total_sks <=', 80);
            } elseif ($sks_filter == 9) {
                $builder->having('total_sks >=', 80);
                $builder->having('total_sks <=', 90);
            } elseif ($sks_filter == 10) {
                $builder->having('total_sks >=', 90);
                $builder->having('total_sks <=', 105);
            } elseif ($sks_filter == 11) {
                $builder->having('total_sks =', 106);
            }
        }
        if($id_sub_bidang == null){
            $builder->where('sipema_sub_bidang.id_bidang', $id_bidang);
        }elseif($id_sub_bidang != null){
            $builder->where('sipema_bidang.id_bidang', $id_bidang);
            $builder->where('sipema_sub_bidang.id_sub_bidang', $id_sub_bidang);
        }
        $builder->groupBy('mahasiswa.id_mhs');
        if (!empty($nilai_akhir_filter)) {
            if ($nilai_akhir_filter == 1) {
                $builder->having('nilai_akhir >=', 90);
            } elseif ($nilai_akhir_filter == 2) {
                $builder->having('nilai_akhir >=', 85);
                $builder->having('nilai_akhir <=', 89.9);
            } elseif ($nilai_akhir_filter == 3) {
                $builder->having('nilai_akhir >=', 80);
                $builder->having('nilai_akhir <=', 84.9);
            } elseif ($nilai_akhir_filter == 4) {
                $builder->having('nilai_akhir >=', 75);
                $builder->having('nilai_akhir <=', 79.9);
            } elseif ($nilai_akhir_filter == 5) {
                $builder->having('nilai_akhir >=', 70);
                $builder->having('nilai_akhir <=', 74.9);
            } elseif ($nilai_akhir_filter == 6) {
                $builder->having('nilai_akhir >=', 65);
                $builder->having('nilai_akhir <=', 69.9);
            } elseif ($nilai_akhir_filter == 7) {
                $builder->having('nilai_akhir >=', 60);
                $builder->having('nilai_akhir <=', 64.9);
            } elseif ($nilai_akhir_filter == 8) {
                $builder->having('nilai_akhir >=', 55);
                $builder->having('nilai_akhir <=', 59.9);
            } elseif ($nilai_akhir_filter == 9) {
                $builder->having('nilai_akhir >=', 50);
                $builder->having('nilai_akhir <=', 54.9);
            } elseif ($nilai_akhir_filter == 10) {
                $builder->having('nilai_akhir >=', 0);
                $builder->having('nilai_akhir <=', 49.9);
            }
        }
        $builder->orderBy('nilai_akhir','DESC');
        return $builder->get()->getResult();
    }

    function getDataBidangNilaiAkhirSks($id_bidang, $nilai_akhir_filter, $sks_filter)
    {
        $builder = $this->db->table('sipema_hasil_pemetaan_k');
        $builder->select('mahasiswa.id_mhs, mahasiswa.nama as nama_mahasiswa, sipema_bidang.nama_bidang, SUM(sipema_hasil_pemetaan_k.total_sks) as total_sks, ROUND(AVG(sipema_hasil_pemetaan_k.nilai_akhir),2) as nilai_akhir');
        $builder->join('mahasiswa', 'sipema_hasil_pemetaan_k.id_mhs = mahasiswa.id_mhs');
        $builder->join('sipema_sub_bidang', 'sipema_hasil_pemetaan_k.id_sub_bidang = sipema_sub_bidang.id_sub_bidang');
        $builder->join('sipema_bidang', 'sipema_sub_bidang.id_bidang = sipema_bidang.id_bidang');
        if (!empty($sks_filter)) {
            if($sks_filter == 1){
                $builder->having('total_sks <=', 10);
            } elseif ($sks_filter == 2) {
                $builder->having('total_sks >=', 10);
                $builder->having('total_sks <=', 20);
            } elseif ($sks_filter == 3) {
                $builder->having('total_sks >=', 20);
                $builder->having('total_sks <=', 30);
            } elseif ($sks_filter == 4) {
                $builder->having('total_sks >=', 30);
                $builder->having('total_sks <=', 40);
            } elseif ($sks_filter == 5) {
                $builder->having('total_sks >=', 40);
                $builder->having('total_sks <=', 50);
            } elseif ($sks_filter == 6) {
                $builder->having('total_sks >=', 50);
                $builder->having('total_sks <=', 60);
            } elseif ($sks_filter == 7) {
                $builder->having('total_sks >=', 60);
                $builder->having('total_sks <=', 70);
            } elseif ($sks_filter == 8) {
                $builder->having('total_sks >=', 70);
                $builder->having('total_sks <=', 80);
            } elseif ($sks_filter == 9) {
                $builder->having('total_sks >=', 80);
                $builder->having('total_sks <=', 90);
            } elseif ($sks_filter == 10) {
                $builder->having('total_sks >=', 90);
                $builder->having('total_sks <=', 105);
            } elseif ($sks_filter == 11) {
                $builder->having('total_sks =', 106);
            }
        }
        $builder->where('sipema_sub_bidang.id_bidang', $id_bidang);
        $builder->groupBy('mahasiswa.id_mhs');
        if (!empty($nilai_akhir_filter)) {
            if ($nilai_akhir_filter == 1) {
                $builder->having('nilai_akhir >=', 90);
            } elseif ($nilai_akhir_filter == 2) {
                $builder->having('nilai_akhir >=', 85);
                $builder->having('nilai_akhir <=', 89.9);
            } elseif ($nilai_akhir_filter == 3) {
                $builder->having('nilai_akhir >=', 80);
                $builder->having('nilai_akhir <=', 84.9);
            } elseif ($nilai_akhir_filter == 4) {
                $builder->having('nilai_akhir >=', 75);
                $builder->having('nilai_akhir <=', 79.9);
            } elseif ($nilai_akhir_filter == 5) {
                $builder->having('nilai_akhir >=', 70);
                $builder->having('nilai_akhir <=', 74.9);
            } elseif ($nilai_akhir_filter == 6) {
                $builder->having('nilai_akhir >=', 65);
                $builder->having('nilai_akhir <=', 69.9);
            } elseif ($nilai_akhir_filter == 7) {
                $builder->having('nilai_akhir >=', 60);
                $builder->having('nilai_akhir <=', 64.9);
            } elseif ($nilai_akhir_filter == 8) {
                $builder->having('nilai_akhir >=', 55);
                $builder->having('nilai_akhir <=', 59.9);
            } elseif ($nilai_akhir_filter == 9) {
                $builder->having('nilai_akhir >=', 50);
                $builder->having('nilai_akhir <=', 54.9);
            } elseif ($nilai_akhir_filter == 10) {
                $builder->having('nilai_akhir >=', 0);
                $builder->having('nilai_akhir <=', 49.9);
            }
        }
        $builder->orderBy('nilai_akhir','DESC');
        return $builder->get()->getResult();
    }

    function getDataBidangNilaiAkhir($id_bidang, $nilai_akhir_filter)
    {
        $builder = $this->db->table('sipema_hasil_pemetaan_k');
        $builder->select('mahasiswa.id_mhs, mahasiswa.nama as nama_mahasiswa, sipema_bidang.nama_bidang, SUM(sipema_hasil_pemetaan_k.total_sks) as total_sks, ROUND(AVG(sipema_hasil_pemetaan_k.nilai_akhir),2) as nilai_akhir');
        $builder->join('mahasiswa', 'sipema_hasil_pemetaan_k.id_mhs = mahasiswa.id_mhs');
        $builder->join('sipema_sub_bidang', 'sipema_hasil_pemetaan_k.id_sub_bidang = sipema_sub_bidang.id_sub_bidang');
        $builder->join('sipema_bidang', 'sipema_sub_bidang.id_bidang = sipema_bidang.id_bidang');
        $builder->where('sipema_sub_bidang.id_bidang', $id_bidang);
        $builder->groupBy('mahasiswa.id_mhs');
        if (!empty($nilai_akhir_filter)) {
            if ($nilai_akhir_filter == 1) {
                $builder->having('nilai_akhir >=', 90);
            } elseif ($nilai_akhir_filter == 2) {
                $builder->having('nilai_akhir >=', 85);
                $builder->having('nilai_akhir <=', 89.9);
            } elseif ($nilai_akhir_filter == 3) {
                $builder->having('nilai_akhir >=', 80);
                $builder->having('nilai_akhir <=', 84.9);
            } elseif ($nilai_akhir_filter == 4) {
                $builder->having('nilai_akhir >=', 75);
                $builder->having('nilai_akhir <=', 79.9);
            } elseif ($nilai_akhir_filter == 5) {
                $builder->having('nilai_akhir >=', 70);
                $builder->having('nilai_akhir <=', 74.9);
            } elseif ($nilai_akhir_filter == 6) {
                $builder->having('nilai_akhir >=', 65);
                $builder->having('nilai_akhir <=', 69.9);
            } elseif ($nilai_akhir_filter == 7) {
                $builder->having('nilai_akhir >=', 60);
                $builder->having('nilai_akhir <=', 64.9);
            } elseif ($nilai_akhir_filter == 8) {
                $builder->having('nilai_akhir >=', 55);
                $builder->having('nilai_akhir <=', 59.9);
            } elseif ($nilai_akhir_filter == 9) {
                $builder->having('nilai_akhir >=', 50);
                $builder->having('nilai_akhir <=', 54.9);
            } elseif ($nilai_akhir_filter == 10) {
                $builder->having('nilai_akhir >=', 0);
                $builder->having('nilai_akhir <=', 49.9);
            }
        }
        $builder->orderBy('nilai_akhir','DESC');
        return $builder->get()->getResult();
    }

    function getDataBidangSks($id_bidang, $sks_filter)
    {
        $builder = $this->db->table('sipema_hasil_pemetaan_k');
        $builder->select('mahasiswa.id_mhs, mahasiswa.nama as nama_mahasiswa, sipema_bidang.nama_bidang, SUM(sipema_hasil_pemetaan_k.total_sks) as total_sks, ROUND(AVG(sipema_hasil_pemetaan_k.nilai_akhir),2) as nilai_akhir');
        $builder->join('mahasiswa', 'sipema_hasil_pemetaan_k.id_mhs = mahasiswa.id_mhs');
        $builder->join('sipema_sub_bidang', 'sipema_hasil_pemetaan_k.id_sub_bidang = sipema_sub_bidang.id_sub_bidang');
        $builder->join('sipema_bidang', 'sipema_sub_bidang.id_bidang = sipema_bidang.id_bidang');
        if (!empty($sks_filter)) {
            if($sks_filter == 1){
                $builder->having('total_sks <=', 10);
            } elseif ($sks_filter == 2) {
                $builder->having('total_sks >=', 10);
                $builder->having('total_sks <=', 20);
            } elseif ($sks_filter == 3) {
                $builder->having('total_sks >=', 20);
                $builder->having('total_sks <=', 30);
            } elseif ($sks_filter == 4) {
                $builder->having('total_sks >=', 30);
                $builder->having('total_sks <=', 40);
            } elseif ($sks_filter == 5) {
                $builder->having('total_sks >=', 40);
                $builder->having('total_sks <=', 50);
            } elseif ($sks_filter == 6) {
                $builder->having('total_sks >=', 50);
                $builder->having('total_sks <=', 60);
            } elseif ($sks_filter == 7) {
                $builder->having('total_sks >=', 60);
                $builder->having('total_sks <=', 70);
            } elseif ($sks_filter == 8) {
                $builder->having('total_sks >=', 70);
                $builder->having('total_sks <=', 80);
            } elseif ($sks_filter == 9) {
                $builder->having('total_sks >=', 80);
                $builder->having('total_sks <=', 90);
            } elseif ($sks_filter == 10) {
                $builder->having('total_sks >=', 90);
                $builder->having('total_sks <=', 105);
            } elseif ($sks_filter == 11) {
                $builder->having('total_sks =', 106);
            }
        }
        $builder->where('sipema_sub_bidang.id_bidang', $id_bidang);
        $builder->groupBy('mahasiswa.id_mhs');
        $builder->orderBy('nilai_akhir','DESC');
        return $builder->get()->getResult();
    }

    function getDataBidangSubBidangSks($id_bidang, $id_sub_bidang, $sks_filter)
    {
        $builder = $this->db->table('sipema_hasil_pemetaan_k');
        $builder->select('mahasiswa.id_mhs, mahasiswa.nama as nama_mahasiswa, sipema_bidang.nama_bidang, sipema_sub_bidang.nama_sub_bidang, SUM(sipema_hasil_pemetaan_k.total_sks) as total_sks, ROUND(AVG(sipema_hasil_pemetaan_k.nilai_akhir),2) as nilai_akhir');
        $builder->join('mahasiswa', 'sipema_hasil_pemetaan_k.id_mhs = mahasiswa.id_mhs');
        $builder->join('sipema_sub_bidang', 'sipema_hasil_pemetaan_k.id_sub_bidang = sipema_sub_bidang.id_sub_bidang');
        $builder->join('sipema_bidang', 'sipema_sub_bidang.id_bidang = sipema_bidang.id_bidang');
        if (!empty($sks_filter)) {
            if($sks_filter == 1){
                $builder->having('total_sks <=', 10);
            } elseif ($sks_filter == 2) {
                $builder->having('total_sks >=', 10);
                $builder->having('total_sks <=', 20);
            } elseif ($sks_filter == 3) {
                $builder->having('total_sks >=', 20);
                $builder->having('total_sks <=', 30);
            } elseif ($sks_filter == 4) {
                $builder->having('total_sks >=', 30);
                $builder->having('total_sks <=', 40);
            } elseif ($sks_filter == 5) {
                $builder->having('total_sks >=', 40);
                $builder->having('total_sks <=', 50);
            } elseif ($sks_filter == 6) {
                $builder->having('total_sks >=', 50);
                $builder->having('total_sks <=', 60);
            } elseif ($sks_filter == 7) {
                $builder->having('total_sks >=', 60);
                $builder->having('total_sks <=', 70);
            } elseif ($sks_filter == 8) {
                $builder->having('total_sks >=', 70);
                $builder->having('total_sks <=', 80);
            } elseif ($sks_filter == 9) {
                $builder->having('total_sks >=', 80);
                $builder->having('total_sks <=', 90);
            } elseif ($sks_filter == 10) {
                $builder->having('total_sks >=', 90);
                $builder->having('total_sks <=', 105);
            } elseif ($sks_filter == 11) {
                $builder->having('total_sks =', 106);
            }
        }
        $builder->where('sipema_bidang.id_bidang', $id_bidang);
        $builder->where('sipema_sub_bidang.id_sub_bidang', $id_sub_bidang);
        $builder->groupBy('mahasiswa.id_mhs');
        $builder->orderBy('nilai_akhir','DESC');
        return $builder->get()->getResult();
    }

    public function getChartData($id_mhs)
    {
        $builder = $this->db->table('sipema_hasil_pemetaan_k');
        $builder->select('nama_bidang, nama_sub_bidang, nilai_akhir');
        $builder->join('sipema_sub_bidang', 'sipema_hasil_pemetaan_k.id_sub_bidang = sipema_sub_bidang.id_sub_bidang');
        $builder->join('sipema_bidang', 'sipema_sub_bidang.id_bidang = sipema_bidang.id_bidang');
        $builder->where('id_mhs', $id_mhs);
        $query = $builder->get();
        return $query->getResult();
    }

    public function getAllChartData()
    {
        $query = $this->db->query('SELECT b.nama_bidang, sb.nama_sub_bidang, ROUND(AVG(hpk.nilai_akhir), 2) as nilai_akhir FROM sipema_hasil_pemetaan_k hpk
                                  INNER JOIN sipema_sub_bidang sb ON hpk.id_sub_bidang = sb.id_sub_bidang
                                  INNER JOIN sipema_bidang b ON sb.id_bidang = b.id_bidang
                                  GROUP BY b.nama_bidang, sb.nama_sub_bidang');
        return $query->getResult();
    }

    public function getChartDataByUsersLogin($id)
    {
        $builder = $this->db->table('sipema_hasil_pemetaan_k');
        $builder->select('nama_bidang, nama_sub_bidang, nilai_akhir, mahasiswa.nama as nama_mahasiswa');
        $builder->join('sipema_sub_bidang', 'sipema_hasil_pemetaan_k.id_sub_bidang = sipema_sub_bidang.id_sub_bidang');
        $builder->join('sipema_bidang', 'sipema_sub_bidang.id_bidang = sipema_bidang.id_bidang');
        $builder->join('mahasiswa', 'sipema_hasil_pemetaan_k.id_mhs = mahasiswa.id_mhs');
        $builder->join('users', 'mahasiswa.id_user = users.id');
        $builder->where('users.id', $id);
        $builder->orderBy('sipema_hasil_pemetaan_k.nilai_akhir', 'DESC');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getChartDataMahasiswaBySubBidang()
    {
        $builder = $this->db->table('sipema_hasil_pemetaan_k');
        $builder->select('nama_bidang, nama_sub_bidang, nilai_akhir, mahasiswa.nama as nama_mahasiswa');
        $builder->join('sipema_sub_bidang', 'sipema_hasil_pemetaan_k.id_sub_bidang = sipema_sub_bidang.id_sub_bidang');
        $builder->join('sipema_bidang', 'sipema_sub_bidang.id_bidang = sipema_bidang.id_bidang');
        $builder->join('mahasiswa', 'sipema_hasil_pemetaan_k.id_mhs = mahasiswa.id_mhs');
        $builder->join('users', 'mahasiswa.id_user = users.id');
        $builder->orderBy('mahasiswa.nama', 'DESC');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getSubBidangByBidang($id_bidang) {
        $builder = $this->db->table('sipema_sub_bidang');
        $builder->where('id_bidang', $id_bidang);
        $query = $builder->get();
        return $query->getResult();
    }
}