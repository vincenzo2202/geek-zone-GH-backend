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

    public  function feed()
    {
        return $this->hasMany(Feed::class);
    }

    public function commentsToFeed(): BelongsToMany
    {
        return $this->belongsToMany(Feed::class, 'comments');
    }

    public function likesToFeed(): BelongsToMany
    {
        return $this->belongsToMany(Feed::class, 'likes');
    }
 
}
