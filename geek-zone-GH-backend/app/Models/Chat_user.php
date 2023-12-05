<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat_user extends Model
{
    use HasFactory;

    protected $table = 'chat_user';

    protected $fillable = [
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
