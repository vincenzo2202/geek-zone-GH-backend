<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'city',
        'phone_number',
        'photo',
        'role',
        'timestamps',
    ];

    protected $hidden = [
        'password',
        'remember_token', 
    ];


    // Relaciones con feed
    public  function feeds()
    {
        return $this->hasMany(Feed::class);
    }

    public function feedManyToManythroughComments(): BelongsToMany
    {
        return $this->belongsToMany(Feed::class, 'comments', 'user_id', 'feed_id');
    }

    public function feedManyToManythroughLikes(): BelongsToMany
    {
        return $this->belongsToMany(Feed::class, 'likes', 'user_id', 'feed_id');
    }

    public  function likes()
    {
        return $this->hasMany(Like::class);
    }

    public  function comments()
    {
        return $this->hasMany(Comment::class);
    }


    // relaciones con chat
    public  function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function chatManyToManythroughMessages(): BelongsToMany
    {
        return $this->belongsToMany(Chat::class, 'messages', 'user_id', 'chat_id');
    }

    public function chatManyToManythroughChat_user(): BelongsToMany
    {
        return $this->belongsToMany(Chat::class, 'chat_user', 'user_id', 'chat_id');
    }

    public  function chat_users()
    {
        return $this->hasMany(Chat_user::class);
    }

    public  function messages()
    {
        return $this->hasMany(Message::class);
    }
    // Relaciones con Events
    public  function events()
    {
        return $this->hasMany(Event::class);
    }

    public function eventManyToManyThrougheEvent_user(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_user', 'user_id', 'event_id');
    }

    public  function event_users()
    {
        return $this->hasMany(Event_user::class);
    }


    // Relaciones con followers

    public function followers()
    {
        return $this->hasMany(Follower::class, 'follower_id');
    }

    public function followings()
    {
        return $this->hasMany(Follower::class, 'following_id');
    }

    // metodos para jwt
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
