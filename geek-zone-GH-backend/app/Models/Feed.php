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

    public  function user() {
        return $this->belongsTo(User::class);
    }

    public function commentsToUser(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'comments');
    }

    public function likesToUser(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'likes');
    }


}
