<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';

    protected $fillable = [
        'message',
        'chat_id',
        'user_id',
    ];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

     
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
