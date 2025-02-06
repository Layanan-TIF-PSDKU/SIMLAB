<?php

namespace App\Models\Bot;

use CodeIgniter\Model;


class ChatbotUserMahasiswaModel extends Model
{
    protected $uuidFields       = ['id_mahasiswa'];
    protected $table            = 'bot_user_mahasiswa';
    protected $primaryKey       = 'id_user_bot';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_user_bot','id_mahasiswa','email', 'no_wa','username_telegram','status_notification','id_telegram'];

    public function checkUserMahasiswaExists($email)
    {
        return $this->where('email', $email)->countAllResults() > 0;
    }

    public function checkUserBotMahasiswaExists($id)
    {
        return $this->where('id_mahasiswa', $id)->countAllResults() > 0;
    }

    public function GetUserMahasiswa($email)
    {
        return $this->where('email', $email)->findAll();
    }

    public function findNamaMahasiswa($email)
    {
        $this->select('bot_user_mahasiswa.*, mahasiswa.nama as nama');
        $this->join('mahasiswa', 'mahasiswa.id_mhs = bot_user_mahasiswa.id_mahasiswa');
        return $this->where('bot_user_mahasiswa.email', $email)->findAll();
    }

    public function findUserMahasiswaByID($id_user_bot)
    {
        $this->select('bot_user_mahasiswa.*, mahasiswa.nama as nama');
        $this->join('mahasiswa', 'mahasiswa.id_mhs = bot_user_mahasiswa.id_mahasiswa');
        return $this->where('bot_user_mahasiswa.id_user_bot', $id_user_bot)->find();
    }

    public function findAllUserMahasiswa()
    {
        $this->select('bot_user_mahasiswa.*, mahasiswa.nama as nama');
        $this->join('mahasiswa', 'mahasiswa.id_mhs = bot_user_mahasiswa.id_mahasiswa');
        return $this->findAll();
    }

    public function findUserAngkatanKelas($angkatan, $kelas){
        return $this->select()
            ->join('mahasiswa', 'mahasiswa.id_mhs = bot_user_mahasiswa.id_mahasiswa')
            ->where('mahasiswa.th_masuk', $angkatan)
            ->where('mahasiswa.kelas', $kelas)
            ->findAll();
    }

    public function findUserAngkatan($angkatan){
        return $this->select()
            ->join('mahasiswa', 'mahasiswa.id_mhs = bot_user_mahasiswa.id_mahasiswa')
            ->where('mahasiswa.th_masuk', $angkatan)
            ->findAll();
    }
}

class ChatbotUserStaffModel extends Model
{
    protected $uuidFields       = ['id_staff'];
    protected $table            = 'bot_user_staff';
    protected $primaryKey       = 'id_user_bot';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_user_bot','id_staff','email', 'no_wa','username_telegram','status_notification','id_telegram'];

    public function checkUserStaffExists($email)
    {
    return $this->where('email', $email)->countAllResults() > 0;
    }

    public function checkUserBotStaffExists($id)
    {
        return $this->where('id_staff', $id)->countAllResults() > 0;
    }

    public function updateStatus($id, $data)
    {
        return $this->update($id, $data);
    }

    public function GetUserStaf($email)
    {
    return $this->where('email', $email)->findAll();
    }

    public function findNamaStaf($email)
    {
        $this->select('bot_user_staff.*, staf.nama as nama');
        $this->join('staf', 'staf.id_staf = bot_user_staff.id_staff');
        return $this->where('bot_user_staff.email', $email)->findAll();
    }

    public function findUserStafByID($id_user_bot)
    {
        $this->select('bot_user_staff.*, staf.nama as nama');
        $this->join('staf', 'staf.id_staf = bot_user_staff.id_staff');
        return $this->where('bot_user_staff.id_user_bot', $id_user_bot)->find();
    }

    public function findAllUserStaf()
    {
        $this->select('bot_user_staff.*, staf.nama as nama');
        $this->join('staf', 'staf.id_staf = bot_user_staff.id_staff');
        return $this->findAll();
    }

    public function checkUserBotStaffLaboranfExists($recipient)
    {
        return $this->where('id_staff', $recipient)->countAllResults() > 0;
    }
    
}

class ChatbotRegisterModel extends Model
{
    protected $table            = 'bot_registrasi';
    protected $primaryKey       = 'id_registrasi';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_registrasi','nama_lengkap','email', 'no_wa','pesan_aktivasi','create_at','regis_status'];

    public function checkRegisStatus($email)
    {
    return $this->where('email', $email)->where('regis_status', false)->countAllResults() > 0;
    }

    public function GetPesanAktivasi($email)
    {
    return $this->select('pesan_aktivasi')
    ->where('email', $email)
    ->where('regis_status', false)
    ->find();
    }
}

class MahasiswaModel extends Model
{
    protected $uuidFields       = ['id_mhs'];
    protected $table            = 'mahasiswa';
    protected $primaryKey       = 'id_mhs';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_mhs', 'id_user', 'nama', 'email', 'nim', 'prodi', 'no_telp', 'th_masuk', 'th_lulus', 'kelas', 'status'];
    protected $validationRules = [
        'id_mhs' => 'required'
    ];
    public function GetIdMhs()
    {
    $id_user = user()->id;
    return $this->select('id_mhs')->where('id_user', $id_user)->find();
    }
}
