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

    public function userManyToOne()
    {
        return $this->belongsTo(User::class); 
    }

    public function eventToUserManyToManyThrougheEvent_user(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_user');
    }

    public  function EventToEvent_userOneToMany()
    {
        return $this->hasMany(Event_user::class);
    }
}
