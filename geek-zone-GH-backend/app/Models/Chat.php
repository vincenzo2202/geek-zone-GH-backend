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

    public function chatToUserManyToOne()
    {
        return $this->belongsTo(User::class); 
    }

    public function chatToUsersManyToManythroughMessages():BelongsToMany
    {
        return $this->belongsToMany(User::class, 'messages');
    }

    public function chatToUsersManyToManythroughChat_user():BelongsToMany
    {
        return $this->belongsToMany(User::class, 'chat_user');
    }

    public  function chatToChat_UserOneToMany()
    {
        return $this->hasMany(Chat_user::class);
    }

    public  function chatToMessagesOneToMany()
    {
        return $this->hasMany(Message::class);
    }
}
