<?php

namespace App\Models\Bot;

use CodeIgniter\Model;

class ChatbotResponseModel extends Model
{
    protected $uuidFields       = ['id'];
    protected $table            = 'bot_telegram_messages';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['message', 'attachment','create_at', 'created_by'];

    public function initialize()
    {
        parent::initialize();
        $this->db->query("SET NAMES 'utf8mb4'");
    }
}

class BotTagTelegramMessageModel extends Model
{
    protected $table = 'bot_tag_telegram_messages';
    protected $primaryKey = 'id_tag';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields = ['id_tag','tag', 'id_messages'];

    public function saveTag($tagName, $idMessages)
    {
        $data = [
            'tag' => $tagName,
            'id_messages' => $idMessages
        ];

        return $this->insert($data);
    }

    public function tambahTag( $idMessages,$tagName)
    {
        $data = [
            'id_messages' => $idMessages,
            'tag' => $tagName,
        ];

        return $this->save($data);
    }

    public function deleteTagsByMessageId($messageId)
    {
        return $this->where('id_messages', $messageId)->delete();
    }

}

class BotTelegramMessageModel extends Model
{
    protected $table = 'bot_telegram_messages';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id','message', 'create_at'];

    public function tags()
    {
        return $this->hasMany(BotTagTelegramMessageModel::class, 'id_messages', 'id');
    }
}