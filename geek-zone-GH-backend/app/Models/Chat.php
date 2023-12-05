<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Chat extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [ 
        'name',
        'user_id',
        'timestamps',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class); 
    }

    public function messageToUser():BelongsToMany
    {
        return $this->belongsToMany(User::class, 'messages');
    }

    public function Chat_UserToUser():BelongsToMany
    {
        return $this->belongsToMany(User::class, 'chat_user');
    }
}
