<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    const TABLE = 'chats';

    protected $table = self::TABLE;

    protected $fillable = [
        'sender_id',
        'conversation_id',
        'message',
    ];
}
