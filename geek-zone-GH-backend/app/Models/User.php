<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
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
    public  function UsersToFeedOneToMany()
    {
        return $this->hasMany(Feed::class);
    }

    public function UsersToFeedManyToManythroughComments(): BelongsToMany
    {
        return $this->belongsToMany(Feed::class, 'comments');
    }

    public function UsersToFeedManyToManythroughLikes(): BelongsToMany
    {
        return $this->belongsToMany(Feed::class, 'likes');
    }

    public  function usersLikesOneToMany()
    {
        return $this->hasMany(Like::class);
    }

    public  function usersCommentsOneToMany()
    {
        return $this->hasMany(Comment::class);
    }


    // relaciones con chat
    public  function UsersToChatOneToMany()
    {
        return $this->hasMany(Chat::class);
    }

    public function UsersToChatManyToManythroughMessages(): BelongsToMany
    {
        return $this->belongsToMany(Chat::class, 'messages');
    }

    public function UsersToChatManyToManythroughChat_user(): BelongsToMany
    {
        return $this->belongsToMany(Chat::class, 'chat_user');
    }

    public  function usersToChat_UserOneToMany()
    {
        return $this->hasMany(Chat_user::class);
    }

    public  function usersToMessagesOneToMany()
    {
        return $this->hasMany(Message::class);
    }
    // Relaciones con Events
    public  function eventsOneToMany()
    {
        return $this->hasMany(Event::class);
    }

    public function usersToEventManyToManyThrougheEvent_user(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_user');
    }

    public  function usersToEvent_userOneToMany()
    {
        return $this->hasMany(Event_user::class);
    }


    // Relaciones con followers
    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'following_id', 'follower_id');
    }

    public function follower()
    {
        return $this->belongsToMany(User::class,  'followers', 'follower_id', 'following_id');
    }
}
