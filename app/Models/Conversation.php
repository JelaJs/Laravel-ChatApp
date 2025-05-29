<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    const TABLE = 'conversation';

    protected $table = self::TABLE;
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'conversation_id',
    ];
}
