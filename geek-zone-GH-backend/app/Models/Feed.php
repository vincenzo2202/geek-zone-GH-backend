<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Feed extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'title',
        'content',
        'photo',
        'user_id',
        'timestamps',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relaciones con user
    public  function user() {
        return $this->belongsTo(User::class);
    }

    public function usersManyToManythroughComments(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'comments','feed_id', 'user_id');
    }

    public function usersManyToManythroughLikes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'likes','feed_id', 'user_id');
    }

    public  function likes()
    {
        return $this->hasMany(Like::class);
    }

    public  function comments()
    {
        return $this->hasMany(Comment::class);
    }


}
