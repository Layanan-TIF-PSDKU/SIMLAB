<?php

namespace App\Models\Bot;

use CodeIgniter\Model;

class ChatbotLogNotificationModel extends Model
{
    protected $table            = 'bot_notification_log';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id', 'recipient', 'from', 'create_time', 'schedule_time', 'pass_time', 'wa', 'telegram', 'email', 'status_notification'];

    public function findAllWithNama()
{
    $this->select('bot_notification_log.*, IFNULL(staf.nama, mahasiswa.nama) as nama_penerima');
    $this->join('staf', 'staf.id_staf = bot_notification_log.recipient', 'left');
    $this->join('mahasiswa', 'mahasiswa.id_mhs = bot_notification_log.recipient', 'left');
    $this->orderBy('bot_notification_log.schedule_time', 'DESC');
    return $this->findAll();
}

}

class ChatbotLogNotificationKegiatanModel extends Model
{
    protected $table            = 'bot_notification_log_kegiatan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id', 'recipient', 'id_kegiatan', 'from', 'create_time', 'schedule_time', 'pass_time', 'wa', 'telegram', 'email', 'status_notification'];

    public function findAllWithPenanggungJawab()
    {
        $this->select('bot_notification_log_kegiatan.*, staf.nama as pic, bot_kegiatan.nama_kegiatan as kegiatan');
        $this->join('staf', 'staf.id_staf = bot_notification_log_kegiatan.recipient');
        $this->join('bot_kegiatan', 'bot_kegiatan.id_kegiatan = bot_notification_log_kegiatan.id_kegiatan');
        $this->orderBy('bot_notification_log_kegiatan.schedule_time', 'DESC');
        return $this->findAll();
    }
}