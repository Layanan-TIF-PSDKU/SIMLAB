<?php

namespace App\Controllers\Bot;

use App\Controllers\BaseController;
use CodeIgniter\Config\Services;
use App\Models\Bot\ChatbotUserMahasiswaModel;
use App\Models\Bot\ChatbotUserStaffModel;
use App\Models\Bot\ChatbotLogNotificationModel;
use App\Models\Bot\ChatbotLogNotificationKegiatanModel;

class ChatbotLogNotificationController extends BaseController
{
    public function __construct()
    {
        $this->Log = new ChatbotLogNotificationModel();
        $this->LogKegiatan = new ChatbotLogNotificationKegiatanModel();
        $this->validation = \Config\Services::validation();
    }

    public function log()
    {
        $data = [
            'log' => $this->Log->findAllWithNama(),
            'title' => 'Log Notification Chatbot',
        ];
        return view('bot/notification_log/log', $data);
    }

    public function log_kegiatan()
    {
        $data = [
            'log' => $this->LogKegiatan->findAllWithPenanggungJawab(),
            'title' => 'Log Notification Kegiatan Chatbot',
        ];
        return view('bot/notification_log/kegiatan', $data);
    }
}