<?php

namespace App\Models\Mbkm;

use CodeIgniter\Model;

class MbkmFixModel extends Model
{
    protected $uuidFields = ['id_mbkm_fix'];
    protected $table = 'mbkm_fix';
    protected $primaryKey = 'id_mbkm_fix';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $allowedFields = ['id_mbkm_fix', 'id_mhs', 'id_staf', 'id_mitra', 'status_mahasiswa', 'nama_instansi', 'jenis_mbkm', 'bukti', 'lap_akhir'];
    protected $validationRules = [
        'id_mbkm_fix' => 'required',
    ];

    public function getMbkmFixByAdmin()
    {
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, mitra.*, staf.*, staf.nama as nm_staf, mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('staf', 'staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra', 'mitra.id_mitra = mbkm_fix.id_mitra');
        // $builder->join('mbkm_total_uts', 'mbkm_total_uts.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $query = $builder->get();
        return $query->getResult();
    }

    // sebelum join mitra
    // tampilan sesuai id mhs yg blm ada mitra

    // 'mbkmFix4' => $this->mbkmFix->getMbkmFixByMhs2(),

    public function getMbkmFixByMhsMonitoring() // user by mahasiswa untuk monitoring

    {
        $user_id = user()->id;
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('staf', 'staf.id_staf = mbkm_fix.id_staf');
        $builder->join('users', 'users.id = mahasiswa.id_user');
        $builder->join('mitra', 'mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('mbkm_monitoring', 'mbkm_monitoring.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->where(['mahasiswa.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();
    }

    // 'mbkmFix2' => $this->mbkmFix->getMbkmFixByMhs(),
    public function getMbkmFixByMhs()
    {
        $user_id = user()->id;
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, staf.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('staf', 'staf.id_staf = mbkm_fix.id_staf');
        $builder->join('users', 'users.id = mahasiswa.id_user');
        // $builder->join('mitra', 'mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->where(['mahasiswa.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();
    }

    // sesudah join sama mitra
    // tampilan sesuai id mhs yg udh ada mitra
    // 'mbkmFix4' => $this->mbkmFix->getMbkmFixByMhs2(),
    public function getMbkmFixByMhs2()
    {
        $user_id = user()->id;
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, staf.*, mitra.id_mitra, mitra.nama_instansi, staf.nama as nm_staf,mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('staf', 'staf.id_staf = mbkm_fix.id_staf');
        $builder->join('users', 'users.id = mahasiswa.id_user');
        $builder->join('mitra', 'mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->where(['mahasiswa.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();
    }

    // tampil data MBKM fix sesuai role dosen
    public function getMbkmFixByDosenPenilaian()
    {
        $user_id = user()->id;
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        // $builder->join('mbkm_monitoring', 'mbkm_monitoring.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->join('staf', 'staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra', 'mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('users', 'users.id = staf.id_user');
        $builder->where(['staf.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();
    }
    public function getMbkmFixByDosen()
    {

        $user_id = user()->id;
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, staf.*, mitra.*, mbkm_monitoring.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('mbkm_monitoring', 'mbkm_monitoring.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->join('staf', 'staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra', 'mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('users', 'users.id = staf.id_user');
        $builder->where(['staf.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();
    }

    // tampil data MBKM fix sesuai role dosen tanpa mitra
    public function getMbkmFixByDosen2()
    {

        $user_id = user()->id;
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, staf.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('staf', 'staf.id_staf = mbkm_fix.id_staf');
        // $builder->join('mitra','mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('users', 'users.id = staf.id_user');
        $builder->where(['staf.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();
    }

    // tampil data mbkm fix sesuai role dosen untuk monitoring
    public function getMbkmFixByDosenMonitoring()
    {
        $user_id = user()->id;
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, staf.*, mitra.*, mbkm_monitoring.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('mbkm_monitoring', 'mbkm_monitoring.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->join('staf', 'staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra', 'mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('users', 'users.id = staf.id_user');
        $builder->where(['staf.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();
    }

    // tampil data mbkm fix sesuai role mitra
    public function getMbkmFixByMitra()
    {
        $user_id = user()->id;
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, staf.*, mitra.*,mbkm_total_uts.*,mbkm_total_uas.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('mbkm_total_uts', 'mbkm_total_uts.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->join('mbkm_total_uas', 'mbkm_total_uas.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->join('staf', 'staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra', 'mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('users', 'users.id = mitra.id_user');
        $builder->where(['mitra.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();
    }

    // Monitoring
    public function getMonitoringProdiByDosen()
    {
        $user_id = user()->id;
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, staf.*, mitra.*, mbkm_monitoring.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('mbkm_monitoring', 'mbkm_monitoring.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->join('staf', 'staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra', 'mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('users', 'users.id = staf.id_user');
        $builder->where('mbkm_fix.jenis_mbkm', 'msib');
        $builder->where(['staf.id_user' => $user_id]);
        $query = $builder->get()->getResult();
    }
    
    // Monitoring By Mhs
    public function getMonByMhs()
    {
        $user_id = user()->id;
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, staf.*,mbkm_monitoring.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('staf', 'staf.id_staf = mbkm_fix.id_staf');
        $builder->join('users', 'users.id = mahasiswa.id_user');
        $builder->join('mitra', 'mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('mbkm_monitoring', 'mbkm_monitoring.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->where(['mahasiswa.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();
    }

    // Controller Monitoring 
    
    // MONITORING - MSIB
    public function getMbkmFixMonMsibAdm()
    {   
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, mitra.*, staf.*,   staf.nama as nm_staf, mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('staf', 'staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra', 'mitra.id_mitra = mbkm_fix.id_mitra');
        // $builder->join('mbkm_monitoring', 'mbkm_monitoring.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->where('mbkm_fix.jenis_mbkm', 'msib');
        $query = $builder->get();
        return $query->getResult();
    }
    
    public function getMbkmFixMonMsibDsn()
    {   $user_id = user()->id;
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, mitra.*, staf.*,  staf.nama as nm_staf, mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('staf', 'staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra', 'mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('users', 'users.id = staf.id_user');
        // $builder->join('mbkm_monitoring', 'mbkm_monitoring.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->where('mbkm_fix.jenis_mbkm', 'msib');
        $builder->where(['staf.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();
    }
    
    public function getDetailMonMsibAdm($id_mbkm_fix)
    {   
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, mitra.*, staf.*, mbkm_monitoring.*,  staf.nama as nm_staf, mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('staf', 'staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra', 'mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('mbkm_monitoring', 'mbkm_monitoring.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->where('mbkm_fix.jenis_mbkm', 'msib');
        $builder->where('mbkm_fix.id_mbkm_fix', $id_mbkm_fix);
        $query = $builder->get();
        return $query->getResult();
    }
    
    public function getDetailMonMsibDsn($id_mbkm_fix)
    {   
        $user_id = user()->id;
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, mitra.*, staf.*, mbkm_monitoring.*,  staf.nama as nm_staf, mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('staf', 'staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra', 'mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('mbkm_monitoring', 'mbkm_monitoring.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->join('users', 'users.id = staf.id_user');
        $builder->where('mbkm_fix.jenis_mbkm', 'msib');
        $builder->where('mbkm_fix.id_mbkm_fix', $id_mbkm_fix);
        $builder->where(['staf.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();
    }
    // MONITORING - PRODI
    public function getMbkmFixMonProdiAdm()
    {   
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, mitra.*, staf.*,   staf.nama as nm_staf, mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('staf', 'staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra', 'mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->where('mbkm_fix.jenis_mbkm', 'prodi');
        $query = $builder->get();
        return $query->getResult();
    }
    
    public function getMbkmFixMonProdiDsn()
    {   $user_id = user()->id;
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, mitra.*, staf.*,  staf.nama as nm_staf, mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('staf', 'staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra', 'mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('users', 'users.id = staf.id_user');
        $builder->where('mbkm_fix.jenis_mbkm', 'prodi');
        $builder->where(['staf.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();
    }
    
    public function getDetailMonProdiAdm($id_mbkm_fix)
    {   
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, mitra.*, staf.*, mbkm_monitoring.*,  staf.nama as nm_staf, mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('staf', 'staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra', 'mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('mbkm_monitoring', 'mbkm_monitoring.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->where('mbkm_fix.jenis_mbkm', 'prodi');
        $builder->where('mbkm_fix.id_mbkm_fix', $id_mbkm_fix);
        $query = $builder->get();
        return $query->getResult();
    }
    
    public function getDetailMonProdiDsn($id_mbkm_fix)
    {   
        $user_id = user()->id;
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, mitra.*, staf.*, mbkm_monitoring.*,  staf.nama as nm_staf, mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('staf', 'staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra', 'mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('mbkm_monitoring', 'mbkm_monitoring.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->join('users', 'users.id = staf.id_user');
        $builder->where('mbkm_fix.jenis_mbkm', 'prodi');
        $builder->where('mbkm_fix.id_mbkm_fix', $id_mbkm_fix);
        $builder->where(['staf.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();
    }
    // MONITORING - HIBAH
    public function getMbkmFixMonHibahAdm()
    {   
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, mitra.*, staf.*,   staf.nama as nm_staf, mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('staf', 'staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra', 'mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->where('mbkm_fix.jenis_mbkm', 'hibah');
        $query = $builder->get();
        return $query->getResult();
    }
    
    public function getMbkmFixMonHibahDsn()
    {   $user_id = user()->id;
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, mitra.*, staf.*,  staf.nama as nm_staf, mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('staf', 'staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra', 'mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('users', 'users.id = staf.id_user');
        $builder->where('mbkm_fix.jenis_mbkm', 'hibah');
        $builder->where(['staf.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();
    }
    
    public function getDetailMonHibahAdm($id_mbkm_fix)
    {   
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, mitra.*, staf.*, mbkm_monitoring.*,  staf.nama as nm_staf, mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('staf', 'staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra', 'mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('mbkm_monitoring', 'mbkm_monitoring.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->where('mbkm_fix.jenis_mbkm', 'hibah');
        $builder->where('mbkm_fix.id_mbkm_fix', $id_mbkm_fix);
        $query = $builder->get();
        return $query->getResult();
    }
    
    public function getDetailMonHibahDsn($id_mbkm_fix)
    {   
        $user_id = user()->id;
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, mitra.*, staf.*, mbkm_monitoring.*,  staf.nama as nm_staf, mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('staf', 'staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra', 'mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('mbkm_monitoring', 'mbkm_monitoring.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->join('users', 'users.id = staf.id_user');
        $builder->where('mbkm_fix.jenis_mbkm', 'hibah');
        $builder->where('mbkm_fix.id_mbkm_fix', $id_mbkm_fix);
        $builder->where(['staf.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();
    }

    function getFilterAdm($th_masuk)
    {
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf, mitra.nama_instansi as nm_mitra, mahasiswa.nama as nm_mhs');
        $builder->join('staf','staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra','mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->where('mahasiswa.th_masuk', $th_masuk);
        return $builder->get()->getResult();
    }
    function getFilterDsn($th_masuk)
    {
        $user_id = user()->id;
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf, mitra.nama_instansi as nm_mitra, mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa','mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('staf','staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra','mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('users','users.id = staf.id_user');
        $builder->where(['staf.id_user' => $user_id]);
        $builder->where('mahasiswa.th_masuk', $th_masuk);
        return $builder->get()->getResult();
    }
    public function getDetail($id_mbkm_fix){
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf, mitra.nama_instansi as nm_mitra, mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa','mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('staf','staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra','mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->where('id_mbkm_fix', $id_mbkm_fix);
        $query = $builder->get();
        return $query->getRow(); 
    }

    // Filter Monitoring
    public function getFilterMonMsibDsn($th_masuk)
    {
        $user_id = user()->id;
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf, mitra.nama_instansi as nm_mitra, mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa','mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('staf','staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra','mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('users','users.id = staf.id_user');
        $builder->where('mbkm_fix.jenis_mbkm', 'msib');
        $builder->where(['staf.id_user' => $user_id]);
        $builder->where('mahasiswa.th_masuk', $th_masuk);
        return $builder->get()->getResult();
    }
    
    public function getFilterMonMsibAdm($th_masuk)
    {
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf, mitra.nama_instansi as nm_mitra, mahasiswa.nama as nm_mhs');
        $builder->join('staf','staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra','mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->where('mbkm_fix.jenis_mbkm', 'msib');
        $builder->where('mahasiswa.th_masuk', $th_masuk);
        return $builder->get()->getResult();
    }
    public function getFilterMonProdiDsn($th_masuk)
    {
        $user_id = user()->id;
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf, mitra.nama_instansi as nm_mitra, mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa','mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('staf','staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra','mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('users','users.id = staf.id_user');
        $builder->where('mbkm_fix.jenis_mbkm', 'prodi');
        $builder->where(['staf.id_user' => $user_id]);
        $builder->where('mahasiswa.th_masuk', $th_masuk);
        return $builder->get()->getResult();
    }
    
    public function getFilterMonProdiAdm($th_masuk)
    {
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf, mitra.nama_instansi as nm_mitra, mahasiswa.nama as nm_mhs');
        $builder->join('staf','staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra','mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->where('mbkm_fix.jenis_mbkm', 'prodi');
        $builder->where('mahasiswa.th_masuk', $th_masuk);
        return $builder->get()->getResult();
    }
    public function getFilterMonHibahDsn($th_masuk)
    {
        $user_id = user()->id;
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf, mitra.nama_instansi as nm_mitra, mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa','mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('staf','staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra','mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('users','users.id = staf.id_user');
        $builder->where('mbkm_fix.jenis_mbkm', 'hibah');
        $builder->where(['staf.id_user' => $user_id]);
        $builder->where('mahasiswa.th_masuk', $th_masuk);
        return $builder->get()->getResult();
    }
    
    public function getFilterMonHibahAdm($th_masuk)
    {
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf, mitra.nama_instansi as nm_mitra, mahasiswa.nama as nm_mhs');
        $builder->join('staf','staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra','mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->where('mbkm_fix.jenis_mbkm', 'hibah');
        $builder->where('mahasiswa.th_masuk', $th_masuk);
        return $builder->get()->getResult();
    }
    
    public function getFilterNilaiUtsAdm($th_masuk)
    {
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*,  mbkm_total_uts.*, staf.*, mitra.*, staf.nama as nm_staf, mitra.nama_instansi as nm_mitra, mahasiswa.nama as nm_mhs');
        $builder->join('mbkm_total_uts','mbkm_total_uts.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->join('staf','staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra','mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->where('mbkm_fix.jenis_mbkm', 'msib');
        $builder->where('mahasiswa.th_masuk', $th_masuk);
        return $builder->get()->getResult();
    }
    
    // tampil data MBKM fix sesuai role dosen
    public function getMbkmFixByDosenPenilaianUas()
    {
        $user_id = user()->id;
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, staf.*, mitra.*, mbkm_total_uts.*, mbkm_total_uas.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('mbkm_total_uts', 'mbkm_total_uts.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->join('mbkm_total_uas', 'mbkm_total_uas.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->join('staf', 'staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra', 'mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('users', 'users.id = staf.id_user');
        $builder->where(['staf.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();
    }
    public function getMbkmFixByDosenPenilaianUts()
    {
        // $builder = $this->db->table('mbkm_fix');
        // $builder->select('mbkm_fix.*, mahasiswa.*, staf.*, mitra.*, mbkm_total_uts.*, mbkm_total_uas.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs');
        // $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        // $builder->join('mbkm_total_uts', 'mbkm_total_uts.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        // $builder->join('mbkm_total_uas', 'mbkm_total_uas.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        // $builder->join('staf', 'staf.id_staf = mbkm_fix.id_staf');
        // $builder->join('mitra', 'mitra.id_mitra = mbkm_fix.id_mitra');
        // $query = $builder->get();
        // return $query->getResult();
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mbkm_total_uts.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs');
        $builder->join('mbkm_total_uts','mbkm_total_uts.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->join('mahasiswa','mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('staf','staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra','mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('users','users.id = mahasiswa.id_user');
        $query = $builder->get();
        return $query->getResult(); 
    }
    public function getAllPenilaian()
    {   
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mbkm_total_uas.*, mbkm_total_uts.*, mbkm_nilai_konversi.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs');
        $builder->join('mbkm_total_uas','mbkm_total_uas.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->join('mbkm_total_uts','mbkm_total_uts.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->join('mbkm_nilai_konversi','mbkm_nilai_konversi.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->join('mahasiswa','mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('staf','staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra','mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('users','users.id = mahasiswa.id_user');
        $query = $builder->get();
        return $query->getResult(); 
    }
    public function getAllPenilaianByDosen()
    {   $user_id = user()->id;
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mbkm_total_uas.*, mbkm_total_uts.*, mbkm_nilai_konversi.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs');
        $builder->join('mbkm_total_uas','mbkm_total_uas.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->join('mbkm_total_uts','mbkm_total_uts.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->join('mbkm_nilai_konversi','mbkm_nilai_konversi.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->join('mahasiswa','mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('staf','staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra','mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('users', 'users.id = staf.id_user');
        $builder->where(['staf.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult(); 
    }
    public function getMbkmById($id_mbkm_fix){
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_fix.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs, staf.alamat as a_staf, mitra.alamat as a_mitra,  mitra.nama_instansi as nm_mitra'); 
        $builder->join('mahasiswa','mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('staf','staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra','mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('users','users.id = mahasiswa.id_user');
        $builder->where('id_mbkm_fix', $id_mbkm_fix);
        $query = $builder->get();
        return $query->getRow(); 
    }

    function getAllNilaiFilterAdm($th_masuk)
    {
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_total_uas.*, mbkm_total_uts.*, mbkm_fix.*, mahasiswa.*, mbkm_nilai_konversi.*, staf.*, mitra.*, mitra.nama_instansi as nm_mitra, staf.nama as nm_staf, mahasiswa.nama as nm_mhs');
        $builder->join('mbkm_total_uas','mbkm_total_uas.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->join('mbkm_nilai_konversi','mbkm_nilai_konversi.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->join('mbkm_total_uts','mbkm_total_uts.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->join('staf','staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra','mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->where('mahasiswa.th_masuk', $th_masuk);
        return $builder->get()->getResult();
    }
    function getAllNilaiFilterDsn($th_masuk)
    {   $user_id = user()->id;
        $builder = $this->db->table('mbkm_fix');
        $builder->select('mbkm_total_uas.*, mbkm_total_uts.*, mbkm_fix.*, mahasiswa.*, mbkm_nilai_konversi.*, staf.*, mitra.*, mitra.nama_instansi as nm_mitra, staf.nama as nm_staf, mahasiswa.nama as nm_mhs');
        $builder->join('mbkm_total_uas','mbkm_total_uas.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->join('mbkm_nilai_konversi','mbkm_nilai_konversi.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->join('mbkm_total_uts','mbkm_total_uts.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->join('staf','staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra','mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('users', 'users.id = staf.id_user');
        $builder->where(['staf.id_user' => $user_id]);
        $builder->where('mahasiswa.th_masuk', $th_masuk);
        return $builder->get()->getResult();
    }
}