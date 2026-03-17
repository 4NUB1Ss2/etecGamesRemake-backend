<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasApiTokens;

    protected $fillable = [
        'username',
        'email',
        'password',
        'name',
        'role',
        'school_id',
    ];
    protected $hidden = [
        'id',
        'password',
        'created_at',
        'updated_at',


    ];


    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function game()
    {
        return $this->hasMany(Game::class, 'user_id');
    }
}
