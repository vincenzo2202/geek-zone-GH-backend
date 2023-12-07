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
    public  function feedToUserManyToOne() {
        return $this->belongsTo(User::class);
    }

    public function feedsToUsersManyToManythroughComments(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'comments');
    }

    public function feedsToUsersManyToManythroughLikes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    public  function feedLikesOneToMany()
    {
        return $this->hasMany(Like::class);
    }

    public  function feedCommentsOneToMany()
    {
        return $this->hasMany(Comment::class);
    }


}
