<?php

namespace App\Models\TimelineReminder;

use CodeIgniter\Model;

class KegiatanModel extends Model
{
    protected $uuidFields       = ['id_kegiatan'];
    protected $table            = 'bot_kegiatan';
    protected $primaryKey       = 'id_kegiatan';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_kegiatan','nama_kegiatan','deskripsi_kegiatan','pic', 'waktu_kegiatan'];
    protected $validationRules = [
        'id_kegiatan' => 'required'
    ];
 
    public function getPIC()
    {
        return $this->belongsTo('App\Models\StafModel', 'pic', 'id_staf');
    }

    public function findAllWithPenanggungJawabID($id_kegiatan)
    {
        $this->select('bot_kegiatan.*, staf.nama as penanggung_jawab_nama');
        $this->join('staf', 'staf.id_staf = bot_kegiatan.pic');
        return $this->find($id_kegiatan);
    }

    public function findAllWithPenanggungJawab()
    {
        $this->select('bot_kegiatan.*, staf.nama as penanggung_jawab_nama');
        $this->join('staf', 'staf.id_staf = bot_kegiatan.pic');
        return $this->findAll();
    }

    public function docs(){
        return $this->hasMany(DokumenModel::class, 'id_kegiatan', 'id_kegiatan');
    }
}

class DokumenModel extends Model
{
    protected $uuidFields       = ['id_dokumen'];
    protected $table            = 'bot_dokumen_kegiatan';
    protected $primaryKey       = 'id_dokumen';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['nama_dokumen','link','id_kegiatan'];

    public function deleteDocumentsByKegiatanId($kegiatanId)
    {
        $documents = $this->where('id_kegiatan', $kegiatanId)->findAll();
    
        foreach ($documents as $document) {
            if (is_file('timelinereminder_assets/dokumen_kegiatan/' . $document->link)) {
                unlink('timelinereminder_assets/dokumen_kegiatan/' . $document->link);
            }
        }
    
        return $this->where('id_kegiatan', $kegiatanId)->delete();
    }

}

class NotificationModel extends Model
{
    protected $table            = 'bot_notification_log_kegiatan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id','recipient', 'id_kegiatan', 'pesan', 'subject_email', 'pesan_email', 'create_time', 'schedule_time', 'pass_time', 'wa', 'telegram', 'email', 'status_notification'];

    public function findNotification($id_kegiatan){
        $current_time = time() * 1000;
        return $this->where('id_kegiatan', $id_kegiatan)
        ->where('pass_time', '-')
        ->where('schedule_time >=', $current_time)
        ->findAll();
    }
    public function findNotificationActive($id_kegiatan){
        $current_time = time() * 1000;
        return $this->where('id_kegiatan', $id_kegiatan)
        ->where('pass_time', '-')
        ->where('schedule_time >=', $current_time)
        ->where('status_notification', true)
        ->countAllResults() > 0;
    } 
    public function findNotificationByID($id){
        return $this->where('id', $id)->find();
    }

    public function findNotificationForMute($id_kegiatan){
        return $this->where('id_kegiatan', $id_kegiatan)
        ->where('pass_time', '-')
        ->where('status_notification', true)
        ->findAll();
    }

    public function MuteNotification($id_kegiatan){
        $notification = $this->findNotificationForMute($id_kegiatan);
        foreach ($notification as $notif){
            $data = [
                'status_notification' => false
            ];
            $this->update($notif->id, $data);
        }
    }
}

class StafModel extends Model
{
    protected $uuidFields       = ['id_staf'];
    protected $table            = 'staf';
    protected $primaryKey       = 'id_staf';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_staf','id_user','nama','nip', 'no_telp', 'alamat', 'jenis'];
    protected $validationRules = [
        'id_staf' => 'required'
    ];

    public function kegiatan()
    {
        return $this->hasMany('App\Models\KegiatanModel', 'penanggung_jawab', 'id_staf');
    }
}