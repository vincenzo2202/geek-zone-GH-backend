<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
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


}
