<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    const TABLE = 'conversation';

    protected $table = self::TABLE;
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'conversation_id',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(Chat::class, 'conversation_id', 'conversation_id');
    }
}
