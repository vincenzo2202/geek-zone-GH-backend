<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Event extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [ 
        'title',
        'content',
        'event_date',
        'event_time',
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

    public function event_userToUser(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_user');
    }
}
