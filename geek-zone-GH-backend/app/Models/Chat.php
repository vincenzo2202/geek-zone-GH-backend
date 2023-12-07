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

    public function usersManyToManythroughMessages():BelongsToMany
    {
        return $this->belongsToMany(User::class, 'messages', 'chat_id', 'user_id');
    }

    public function usersManyToManythroughChat_user():BelongsToMany
    {
        return $this->belongsToMany(User::class, 'chat_user', 'chat_id', 'user_id');
    }

    public  function chat_users()
    {
        return $this->hasMany(Chat_user::class);
    }

    public  function messages()
    {
        return $this->hasMany(Message::class);
    }
}
